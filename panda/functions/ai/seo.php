<?php

// 生成一个自定义元框，用于显示和保存AI生成的SEO内容
add_action('zib_require_end', function () {
    if (!class_exists('CSF')) {
        return;
    }
    CSF::createMetabox('ai_seo', array(
        'title'     => '一键生成SEO',
        'post_type' => array('post', 'page', 'plate', 'forum_post'),
        'context'   => 'advanced',
        'data_type' => 'unserialize',
    ));

    CSF::createSection('ai_seo', array(
        'fields' => array(
            array(
                'type'    => 'submessage',
                'class'   => 'compact',
                'content' => '
                    <ajaxform class="ajax-form" ajax-url="' . admin_url("admin-ajax.php") . '">
                        <div><a href="javascript:;" class="but jb-yellow ajax-submit-seo mt6"><i class="fa fa-paper-plane-o"></i>一键生成SEO</a></div>
                    </ajaxform>
                    <div id="test-response"></div>
                    <script type="text/javascript">
                        jQuery(document).ready(function($){
                            $(".ajax-submit-seo").on("click", function() {
                                var $btn = $(this); // 获取按钮元素
                                var post_id = $("#post_ID").val(); // 假设你已经有了文章ID字段，或者你可以根据页面结构调整这个值

                                var data = {
                                    action: "ai_seo_get", // WordPress AJAX action
                                    post_id: post_id,     // 传递文章ID
                                };

                                // 禁用按钮，防止重复点击
                                $btn.prop("disabled", true).text("操作进行中...");
                                // 显示初始的“操作进行中”提示
                                $("#test-response").html("<p>正在生成SEO，请稍等...</p>");

                                // 发送 AJAX 请求
                                $.post(ajaxurl, data, function(response) {
                                    if (response.success) {
                                        $("#test-response").html("<p>" + response.data.message + "</p>");
                                        
                                        // 从返回的 message 中提取 SEO 内容并填充文本框
                                        $("input[name=\'title\']").val(response.data.message.seo_title);
                                        $("input[name=\'keywords\']").val(response.data.message.seo_keywords);
                                        $("textarea[name=\'description\']").val(response.data.message.seo_description);
                                    } else {
                                        $("#test-response").html("<p>" + response.data.message + "</p>");
                                    }
                                }).fail(function() {
                                    $("#test-response").html("<p>发生了错误，请稍后再试。</p>");
                                }).always(function() {
                                    // 恢复按钮状态
                                    $btn.prop("disabled", false).text("一键生成SEO");
                                });
                            });
                        });
                    </script>
                ',
            ),
        ),
    ));
});


// 处理AI生成SEO内容并返回
function ai_seo_get() {
    if ((panda_pz('chatgpt_api_key') && panda_pz('chatgpt_api_url')) || (panda_pz('wyy_api_key') && panda_pz('wyy_app_secret'))) {
        $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
        $ai_select = panda_pz('ai_select');
        if ($post_id > 0) {
            $post = get_post($post_id);
            if ($post) {
                $zibll_options = get_option('zibll_options');
                $connector = isset($zibll_options['connector']) ? $zibll_options['connector'] : '-';
                $title = $post->post_title;
                $post_title = $title . $connector . get_bloginfo('name');
                $content = strip_tags($post->post_content);
                
                // 更严格的提示语
                $question = "你是一个专业的SEO优化专家。请根据以下文章内容生成SEO元素：
                
                文章标题: {$title}
                文章内容: " . mb_substr($content, 0, 1000, 'UTF-8') . "
                
                要求:
                1. 生成一段50-150字符的描述(不要包含关键词列表)
                2. 生成5-10个最相关的关键词(英文逗号分隔)
                
                请严格按以下格式返回，不要有任何前缀或多余字符:
                
                [描述开始]
                这里放置50-150字符的描述内容
                [描述结束]
                
                [关键词开始]
                关键词1,关键词2,关键词3
                [关键词结束]";

                // 调用AI接口
                $seo_result = '';
                switch ($ai_select) {
                    case 0: $seo_result = ai_deepseek($question);break;
                    case 1: $seo_result = ai_chatgpt($question); break;
                    case 2: $seo_result = (new Sample())->processRequest($question); break;
                    case 3: $seo_result = get_response_from_api($question); break;
                }

                // 初始化默认值
                $seo_description = mb_substr($content, 0, 150, 'UTF-8');
                $seo_keywords = $title;
                
                // 解析前再次清理可能的多余字符
                $seo_result = preg_replace('/^[\n\s]+/', '', $seo_result);
                $seo_result = preg_replace('/[\n\s]+$/', '', $seo_result);
                
                // 解析描述
                if (preg_match('/\[描述开始\](.*?)\[描述结束\]/s', $seo_result, $desc_match)) {
                    $seo_description = trim($desc_match[1]);
                    // 清理描述中的多余内容和前后空格
                    $seo_description = preg_replace('/关键词:.*$/i', '', $seo_description);
                    $seo_description = preg_replace('/\s+/', ' ', $seo_description);
                    
                    // 精确控制描述长度(50-150字符)
                    $desc_length = mb_strlen($seo_description, 'UTF-8');
                    if ($desc_length < 50) {
                        $seo_description .= ' ' . mb_substr($content, 0, 50 - $desc_length, 'UTF-8');
                    } elseif ($desc_length > 150) {
                        $seo_description = mb_substr($seo_description, 0, 147, 'UTF-8') . '...';
                    }
                }
                
                // 解析关键词
                if (preg_match('/\[关键词开始\](.*?)\[关键词结束\]/s', $seo_result, $kw_match)) {
                    $seo_keywords = trim($kw_match[1]);
                    // 规范化关键词格式
                    $seo_keywords = preg_replace('/[，、；;]/u', ',', $seo_keywords);
                    $seo_keywords = preg_replace('/\s+/', '', $seo_keywords);
                    $seo_keywords = preg_replace('/,+/', ',', $seo_keywords);
                    $seo_keywords = trim($seo_keywords, ',');
                    
                    // 去重并限制数量
                    $keywords_array = array_unique(explode(',', $seo_keywords));
                    $keywords_array = array_slice($keywords_array, 0, 10);
                    $seo_keywords = implode(',', $keywords_array);
                }

                return wp_send_json_success(array(
                    'message' => array(
                        'seo_title' => esc_html($post_title),
                        'seo_description' => esc_html($seo_description),
                        'seo_keywords' => esc_html($seo_keywords)
                    )
                ));
            }
            return wp_send_json_error(array('message' => "未能获取到指定的帖子。"));
        }
        return wp_send_json_error(array('message' => "无效的文章ID。"));
    }
    return wp_send_json_error(array('message' => "AI配置错误或未启用。"));
}

add_action('wp_ajax_ai_seo_get', 'ai_seo_get');
