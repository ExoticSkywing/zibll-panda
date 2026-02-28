<?php
/**
 * 其他函数
 *
 * @package Panda
 */
//微语
add_action('init', 'my_custom_init'); function my_custom_init() { $labels = array( 'name' => '微语', 'singular_name' => '微语', 'add_new' => '发表微语', 'add_new_item' => '发表微语', 'edit_item' => '编辑微语', 'new_item' => '新微语', 'view_item' => '查看微语', 'search_items' => '搜索微语', 'not_found' => '暂无微语', 'not_found_in_trash' => '没有已遗弃的微语', 'parent_item_colon' => '', 'menu_name' => '微语' ); $args = array( 'labels' => $labels, 'public' => true, 'publicly_queryable' => true, 'show_ui' => true, 'show_in_menu' => true, 'query_var' => true, 'rewrite' => true, 'capability_type' => 'post', 'has_archive' => true, 'hierarchical' => false, 'menu_position' => null, 'supports' => array('title','editor','author') ); register_post_type('shuoshuo',$args); }

/*说说点赞功能*/
add_action('wp_ajax_nopriv_bigfa_like', 'bigfa_like');
add_action('wp_ajax_bigfa_like', 'bigfa_like');
function bigfa_like(){
    global $wpdb,$post;
    $id = $_POST["um_id"];
    $action = $_POST["um_action"];
    if ( $action == 'ding'){
    $bigfa_raters = get_post_meta($id,'bigfa_ding',true);
    $expire = time() + 99999999;
    $domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false; // make cookies work with localhost
    setcookie('bigfa_ding_'.$id,$id,$expire,'/',$domain,false);
    if (!$bigfa_raters || !is_numeric($bigfa_raters)) {
        update_post_meta($id, 'bigfa_ding', 1);
    } 
    else {
            update_post_meta($id, 'bigfa_ding', ($bigfa_raters + 1));
        }
    echo get_post_meta($id,'bigfa_ding',true);
    } 
    die;
}

/* 统计总访问量 */
function nd_get_all_view(){
    global $wpdb;
    $count=0;
    $views= $wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE meta_key='views'");
    foreach($views as $key=>$value){
      $meta_value=$value->meta_value;
      if($meta_value!=' '){
        $count+=(int)$meta_value;
      }
    }return $count;
  }
/* 统计本周文章数量 */
function get_posts_count_from_last_168h($post_type ='post') {
    global $wpdb;
    $numposts = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT COUNT(ID) ".
            "FROM {$wpdb->posts} ".
            "WHERE ".
                "post_status='publish' ".
                "AND post_type= %s ".
                "AND post_date> %s",
            $post_type, date('Y-m-d H:i:s', strtotime('-168 hours'))
        )
    );
    return $numposts;
}

//实现侧边栏文本工具运行PHP代码
add_filter('widget_text', 'php_text', 99);
function php_text($text) {
    if (strpos($text, '<' . '?') !== false) {
    ob_start();
    eval('?' . '>' . $text);
    $text = ob_get_contents();
    ob_end_clean();
    }
    return $text;
}

//  文章字数和阅读时间
function count_words_read_time () {
    global $post;
    $text_num = mb_strlen(preg_replace('/s/','',html_entity_decode(strip_tags($post->post_content))),'UTF-8');
    $output = '共计' . $text_num . '字&nbsp;&nbsp;';
    return $output;
  }

// 角标css样式
function badge_style() {?>
<style>
    .tag-license {position: absolute;top: 11px;right: -17px;-webkit-transform: rotate(45deg);z-index: 1;width: 75px;height: 18px;color: #fff;line-height: 18px;text-align: center;font-size: 12px;/*font-style: normal;*/}
                a.item-left-category {position: absolute;
                left: 7px;
                top: 10px;
                padding: 5px 6px;
                font-size: 1rem;
                line-height: 1;
                color: #fff;
                -webkit-backdrop-filter: blur(10px);
                backdrop-filter: blur(10px);
                border-radius: 6px;
                z-index: 1;
                }
                
a.item-category {position: absolute;left:10px;top: 10px;padding: 5px 6px;font-size: 1rem;line-height: 1;color: #fff;-webkit-backdrop-filter: blur(10px);backdrop-filter: blur(10px);border-radius: 6px;z-index: 1;}                
span.bottom-l {overflow: hidden;text-overflow: ellipsis;white-space: nowrap;}
.n-collect-item-bottom {position: absolute;bottom: -1px;left: 0;width: 100%;height: 25px;border-radius: 0 0 4px 4px;-webkit-backdrop-filter: saturate(180%) blur(20px);font-size: 13px;color: #fff;text-shadow: 0 2px 2px rgba(0,0,0,.16);display: -webkit-box;display: -ms-flexbox;display: flex;-webkit-box-align: center;-ms-flex-align: center;align-items: center;-webkit-box-pack: justify;-ms-flex-pack: justify;justify-content: center;padding: 0 18px;z-index: 1;}
.posts-item.card .item-thumbnail{background:#c4cffa26;width:100%;padding-bottom:var(--posts-card-scale);}
a.item-category-app{position:absolute;height:24px;line-height:24px;width:100%;text-align:center;bottom:0;left:0;background:radial-gradient(circle,#3783ff,#3783ffbf);color:var(--this-color);font-size:12px;border-radius:0 0 10px 10px;}
a.item-category-app-b{position:absolute;height:24px;line-height:24px;width:100%;text-align:center;bottom:0;left:0;background:radial-gradient(circle,#ff5631,#ff5631ba);color:var(--this-color);font-size:12px;border-radius:0 0 10px 10px;}
a.item-category-app-c{position:absolute;height:24px;line-height:24px;width:100%;text-align:center;bottom:0;left:0;background:radial-gradient(circle,#464242,#464242ad);color:var(--this-color);font-size:12px;border-radius:0 0 10px 10px;}
.jiaobiao2{position:absolute;top:10px;right:-50px;z-index:1;width:140px;height:20px;background:var(--this-bg);color:var(--this-color);line-height:20px;transform:rotate(45deg);text-align:center;font-size:12px;left:auto;border-radius:0 50px 50px 0;}
.bg-color-purple {background-image: url(<?php echo panda_pz('static_panda');?>/assets/img/badge/bg.jpg);}
.bg-color-red {background-image: url(<?php echo panda_pz('static_panda');?>/assets/img/badge/bg2.webp);}
.bg-color-green {background-image: url(<?php echo panda_pz('static_panda');?>/assets/img/badge/bg3.png);}
.bg-color-yellow {background-image: url(<?php echo panda_pz('static_panda');?>/assets/img/badge/bg4.png);}
.bg-color-black {background-image: url(<?php echo panda_pz('static_panda');?>/assets/img/badge/bg5.webp);}
</style>
<?php }
add_action('wp_head', 'badge_style');

// 标题前缀：在父主题加载完成后注册，确保 CSF 已可用
add_action('zib_require_end', function () {
    if (!class_exists('CSF')) {
        return;
    }
    CSF::createMetabox('Panda_titles', array(
        'title'     => '标题前缀',
        'post_type' => 'post',
        'context'   => 'advanced',
        'data_type' => 'unserialize',
        'priority'  => 'high',
    ));

    CSF::createSection('Panda_titles', array(
        'fields' => array(
            array(
                'id'       => 'titles_moshi',
                'type'     => 'radio',
                'title'    => '模式选择',
                'desc'     => '选择图片或自定义文字',
                'inline'   => true,
                'options'  => array(
                    'img'   => '图片',
                    'text'  => '文字',
                ),
                'default' => 'img',  // 默认选择图片模式
            ),
            array(
                'id'      => 'text',
                'type'    => 'text',
                'title'   => '文字模式',
                'desc'    => '建议两个字',
                'dependency' => array('titles_moshi', '==', 'text'),  // 依赖关系：当模式选择为文字时显示
            ),
            array(
                'id'      => 'text_bg_color',
                'type'    => 'palette',
                'title'   => '背景颜色',
                'desc'    => '部分颜色带有文字颜色，其余默认白色',
                'class'   => 'compact skin-color',
                'default' => "jb-vip2",
                'options' => CFS_Module::zib_palette(array(), array('jb')),
                'dependency' => array('titles_moshi', '==', 'text'),  // 依赖关系：当模式选择为文字时显示
            ),
            array(
                'id'      => 'img',
                'type'    => 'palette',
                'title'   => '选择一个图片',
                'desc'    => '固定使用以下几款SVG图标',
                'class'   => 'compact skin-color',
                'default' => "jb-vip2",
                'options' => Panda_Module::Panda_imgtitle(),
                'dependency' => array('titles_moshi', '==', 'img'),  // 依赖关系：当模式选择为图片时显示
            ),
        ),
    ));
});

class Panda_Module
{
    public static function Panda_imgtitle($palette = array())
    {
            $palette = array_merge($palette, array(
                'shice'      => array('url('.panda_pz('static_panda').'/assets/img/title/shice.svg);width: 50px;'),
                'dujia'    => array('url('.panda_pz('static_panda').'/assets/img/title/10002.svg);width: 50px;'),
                'shoufa'    => array('url('.panda_pz('static_panda').'/assets/img/title/10001.svg);width: 50px;'),
            ));
        return $palette;
    }

}

function apply_Panda_prefixes_to_title($title, $id = null) {
    // 只有在前端，并且非单个页面，才对标题进行更改
    if (!is_404() &&! is_admin() && !is_single() && $id) {
        // 先获取meta box中的设置项
        $prefixes_setting = get_post_meta($id, 'titles_moshi', true);

        if($prefixes_setting == 'img') {
            $selected_img = get_post_meta($id, 'img', true);
            $img_url ='';
            switch ($selected_img) {
                case 'shice':
                    $img_url = ''.panda_pz('static_panda').'/assets/img/title/shice.svg';
                    break;
                case 'shoufa':
                    $img_url = ''.panda_pz('static_panda').'/assets/img/title/10001.svg';
                    break;
                case 'dujia':
                    $img_url = ''.panda_pz('static_panda').'/assets/img/title/10002.svg';
                    break;
            }
            
            if(!empty($img_url)) {
                $title = "<img src='$img_url' alt='$img_url' style=' height: 20px; pointer-events: none;margin-right: 3px;'/>" . $title;
            }
        } else {
            // 对保存的文字前缀进行处理
            $prefix_text = get_post_meta($id, 'text', true);
            $prefix_bg_color = get_post_meta($id, 'text_bg_color', true);
            if (!empty($prefix_text)) {
                $title = "<span class='Panda_prefix ". esc_attr($prefix_bg_color) ."'>" . esc_html($prefix_text) . "</span> " . $title;
            }
        }
    }
    return $title;
}
add_filter('the_title', 'apply_Panda_prefixes_to_title', 10, 2);

function Panda_prefix_css() {?>
<style>
    .Panda_prefix{
    position: relative;
    overflow: hidden;
    display: inline-flex;
    align-items: center;
    border-radius: 5px;
    padding: 5px 4px;
    /* margin-right: 3px; */
    height: 19px;
    font-size: 12px;
    /* top: -3px; */
    /* clip-path: polygon(7% 0, 99% 0, 93% 100%, 0 100%); */
}
.Panda_prefix:after, .Panda_prefix:after {
    position: absolute;
    content: " ";
    display: block;
    left: -100%;
    top: -5px;
    width: 15px;
    height: 145%;
    background-image: linear-gradient(90deg, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.5), rgba(255, 255, 255, 0));
    animation: sweepTitle 3s ease-in-out infinite;
    transform: rotate(28deg);
}
@keyframes sweepTitle {
    0% {
        left: -100%
    }

    100% {
        left: 100%
    }
}
</style>
<?php }
add_action('wp_head', 'Panda_prefix_css');


// 文章版权
function add_Panda_copyright_meta_box() { 
    add_meta_box(  
        'Panda_copyright',  
        '版权开关',  
        'Panda_copyright_html',  
        'post',  
        'normal',  
        'high'  
    );  
}
add_action('admin_menu', 'add_Panda_copyright_meta_box');  
  
function Panda_copyright_html($post) { 
    $checked = get_post_meta($post->ID, '_Panda_copyright_checked', true) ? 'checked="checked"' : '';  
    echo '<label><input type="checkbox" name="Panda_copyright_checked" value="1" ' . $checked . ' /> 关闭该文章底部版权</label>'; 
}
function save_Panda_copyright_meta($post_id) { 
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return; // 防止在自动保存时执行  
    if (!isset($_POST['Panda_copyright_checked'])) return; // 如果复选框没有被提交，则返回  
  
    $checked = isset($_POST['Panda_copyright_checked']) && $_POST['Panda_copyright_checked'] == 1 ? true : false;  
    update_post_meta($post_id, '_Panda_copyright_checked', $checked);  
}
add_action('save_post', 'save_Panda_copyright_meta');  
  
function load_custom_css() {  
    global $post;  
    if (!is_singular('post')) return; // 确保只在文章页面加载  
  
    $checked = get_post_meta($post->ID, '_Panda_copyright_checked', true);  
    if (!$checked) return; // 如果复选框没有被勾选，则返回  
  
    echo '<style type="text/css">';  
    echo '.em09.muted-3-color{display:none;}';  
    echo '</style>';  
}  
add_action('wp_footer', 'load_custom_css');

// 文章热度和角标：延迟注册，确保 CSF 已加载
add_action('zib_require_end', function () {
    if (!class_exists('CSF')) {
        return;
    }
    CSF::createMetabox('mrhe_jingxuan', array(
        'title'     => '热度',
        'post_type' => array('post', 'page', 'plate', 'forum_post'),
        'context'   => 'advanced',
        'data_type' => 'unserialize',
    ));
    CSF::createSection('mrhe_jingxuan', array(
        'fields' => array(
            array(
                'title'   => __('是否显示热度'),
                'id'      => 'jx',
                'type'    => 'switcher',
                'default' => false,
            ),
            array(
                'dependency' => array('jx', '==', true),
                'title'      => __('实现文字'),
                'id'         => 'jx_sort',
                'type'       => 'text',
                'default'    => '精选',
                'desc'       => '文章显示在热度板块的标题',
            ),
        ),
    ));
});

add_action('zib_require_end', function () {
    if (!class_exists('CSF')) {
        return;
    }
    CSF::createMetabox('vxras', array(
        'title'     => '附加功能',
        'post_type' => array('post'),
        'context'   => 'advanced',
        'data_type' => 'unserialize',
    ));
    
    CSF::createSection('vxras', array(
        'fields' => array(
            array(
                'title'   => __('角标'),
                'id'      => 'mh_text',
                'type'    => 'switcher',
                'label'   => '标识',
                'desc'   => '填哪个显示哪个，不想要的留空就行',
                'default' => false,
            ),
            array(
				'class'    => 'compact',
                'dependency'  => array( 'mh_text', '==', true),
                'title'   => __('左上角标'),
                'id'      => 'right_text',
                'type'    => 'text',
                'desc'    => __('输入自定义文字'),
                'default' => false,
            ),
            array(
				'class'    => 'compact',
                'dependency'  => array( 'mh_text', '==', true),
                'title'    => ' ',
                'subtitle' => '背景颜色',
                'id'       => "right_color",
                'class'    => 'compact skin-color',
                'default'  => "c-yellow",
                'type'     => "palette",
                'options'  => CFS_Module::zib_palette(
                array(
                    'transparent' => array('rgba(114, 114, 114, 0.1)'),
                    )
                ),
            ),
            array(
				'class'    => 'compact',
                'dependency'  => array( 'mh_text', '==', true),
                'title'   => __('右上角标'),
                'id'      => 'left_text',
                'type'    => 'text',
                'desc'    => __('输入自定义文字'),
                'default' => false,
            ),
            array(
				'class'    => 'compact',
                'dependency'  => array( 'mh_text', '==', true),
                'title'    => ' ',
                'subtitle' => '背景颜色',
                'id'       => "left_color",
                'class'    => 'compact skin-color',
                'default'  => "c-yellow",
                'type'     => "palette",
                'options'  => CFS_Module::zib_palette(
                array(
                    'transparent' => array('rgba(114, 114, 114, 0.1)'),
                    )
                ),
            ),
            array(
				'class'    => 'compact',
                'dependency'  => array( 'mh_text', '==', true),
                'title'   => __('封面底部'),
                'id'      => 'bottom_text',
                'type'    => 'text',
                'desc'    => __('输入自定义文字'),
                'default' => false,
            ),
            array(
				'class'    => 'compact',
                'dependency'  => array( 'mh_text', '==', true),
                'title'    => ' ',
                'subtitle' => '背景颜色',
                'id'       => "bottom_color",
                'class'    => 'compact skin-color',
                'default'  => "c-yellow",
                'type'     => "palette",
                'options'  => CFS_Module::zib_palette(
                array(
                    'transparent' => array('rgba(114, 114, 114, 0.1)'),
                    )
                ),
            ),
        ),
    ));
});


function zib_nav_links_ajax_hand() {
    $url = isset($_GET['link_url']) ? sanitize_text_field($_GET['link_url']) : '';

    if (empty($url)) {
        wp_send_json_error(['msg' => '网址不能为空']);
    }

    try {
        $api_response = zib_nav_links_curls('https://api.ahfi.cn/api/websiteinfo?url=' . urlencode($url));
        $response_data = json_decode($api_response, true);

        if ($response_data && isset($response_data['code']) && $response_data['code'] === 200) {
            wp_send_json_success([
                'title' => $response_data['data']['title'],
                'description' => $response_data['data']['description'],
                'msg' => $response_data['message']
            ]);
        } else {
            wp_send_json_error(['msg' => $response_data['message']]);
        }
    } catch (Exception $e) {
        wp_send_json_error(['msg' => '请求API时发生错误: ' . $e->getMessage()]);
    }
}

add_action('wp_ajax_zib_nav_links_ajax_hand', 'zib_nav_links_ajax_hand');
add_action('wp_ajax_nopriv_zib_nav_links_ajax_hand', 'zib_nav_links_ajax_hand');

function zib_nav_links_curls($url) {
    $ch = curl_init();
    $timeout = 30;
    $ua = 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36';

    $options = [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_CONNECTTIMEOUT => $timeout,
        CURLOPT_FOLLOWLOCATION => 1,
        CURLOPT_USERAGENT => $ua,
        CURLOPT_SSL_VERIFYPEER => FALSE,
        CURLOPT_SSL_VERIFYHOST => FALSE
    ];

    curl_setopt_array($ch, $options);

    $content = curl_exec($ch);
    if ($content === false) {
        curl_close($ch);
        throw new Exception("cURL Error: " . curl_error($ch));
    }

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode !== 200) {
        throw new Exception("HTTP Error: " . $httpCode);
    }

    return trim(mb_convert_encoding($content, 'UTF-8', mb_detect_encoding($content)));
}

function zib_nav_javascript() {
?>
<script>
$(function() {
    const buttonHtml = '<style>#link_description{width:87%;}</style><span class="abs-right" style="top: 68%;right:5px;"><button type="button" class="but jb-pink zbtool-submit" style="overflow: hidden; position: relative;line-height: 1.7;">一键获取</button></span>';
    const inputTag = $('input[name="link_description"]');
    if (inputTag.length === 0) return;
    inputTag.after(buttonHtml);

    function toggleButtonState(disabled) {
        $('.zbtool-submit').prop('disabled', disabled);
    }

    $('.zbtool-submit').on('click', function() {
        const url = $("input[name='link_url']").val();

        if (!url) {
            notyf("请输入网址", "danger", 0, "zib_nav_golink");
            return;
        }

        toggleButtonState(true);  
        notyf("加载中，请稍等...", "load", 2000, "zib_nav_golink");

        jQuery.ajax({
            type: "GET",
            dataType: "json",
            url: "<?php echo esc_url(admin_url('admin-ajax.php')) ?>",
            data: {
                action: "zib_nav_links_ajax_hand",
                link_url: url
            },
            success: function(response) {
                toggleButtonState(false); 
                if (response.success) {
                    $("#link_name").val(response.data.title);
                    $("#link_description").val(response.data.description);
                    notyf(response.data.msg, "", 0, "zib_nav_golink");
                } else {
                    notyf(response.data.msg, "danger", 0, "zib_nav_golink");
                }
            },
            error: function(errorThrown) {
                toggleButtonState(false);  
                console.error("Ajax请求失败:", errorThrown);
                notyf("请求失败，请重试", "danger", 0, "zib_nav_golink");
            }
        });
    });
});
</script>
<?php
}
add_action('wp_footer', 'zib_nav_javascript');




// 文章版权
function add_Ai_description_meta_box() { 
    add_meta_box(  
        'Ai_description',  
        'AI摘要开关',  
        'Ai_description_html',  
        'post',  
        'normal',  
        'high'  
    );  
}
add_action('admin_menu', 'add_Ai_description_meta_box');  
  
function Ai_description_html($post) { 
    $checked = get_post_meta($post->ID, '_Ai_description_checked', true) ? 'checked="checked"' : '';  
    echo '<label><input type="checkbox" name="Ai_description_checked" value="1" ' . $checked . ' /> 关闭该文章AI摘要</label>'; 
}
function save_Ai_description_meta($post_id) { 
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return; // 防止在自动保存时执行  
    if (!isset($_POST['Ai_description_checked'])) return; // 如果复选框没有被提交，则返回  
  
    $checked = isset($_POST['Ai_description_checked']) && $_POST['Ai_description_checked'] == 1 ? true : false;  
    update_post_meta($post_id, '_Ai_description_checked', $checked);  
}
add_action('save_post', 'save_Ai_description_meta');  
  
function ai_load_custom_css() {  
    global $post;  
    if (!is_singular('post')) return; // 确保只在文章页面加载  
  
    $checked = get_post_meta($post->ID, '_Ai_description_checked', true);  
    if (!$checked) return; // 如果复选框没有被勾选，则返回  
  
    echo '<style type="text/css">';  
    echo '.post-PandaAI{display:none;}';  
    echo '</style>';  
}  
add_action('wp_footer', 'ai_load_custom_css');

function zib_single_style(){
    ?>
    <style>
        .panel-heading .fa{transition:transform 0.3s ease;transform:rotate(-45deg);padding:5px;color:#556af1;}.panel-heading:not(.collapsed) .fa{transform:rotate(0deg);}.question-container{border-radius:6px;border:solid 1px var(--main-border-color);overflow:hidden;border-bottom:solid 0px rgba(50,50,50,0);}.question{cursor:pointer;position:relative;margin-bottom:10px;padding:2.5rem 4rem;margin-bottom:0;border-bottom:solid 1px var(--main-border-color);}.question i{position:absolute;right:0;top:50%;transform:translateY(-50%);}.question.active i.fa.fa-plus{display:none;}.question.active i.fa.fa-minus{display:inline-block;}.answer.active{display:unset;background-color:var(--focus-color);flex:1 1 auto;min-height:1px;color:#fff !important;padding:2.5rem 4.5rem;display:block;}@keyframes bounce{0%{transform:scaleY(0.3);background-color:green;}50%{transform:scaleY(1);background-color:orange;}100%{transform:scaleY(0.3);background-color:green;};}.tab2_content.active{display:block;}.tab2_content.active{display:block;}#accordionhelp-content{margin-bottom:20px;}.tab-container{width:80%;margin:auto;}.tabs{display:flex;cursor:pointer;padding:20px 0;}.tab{padding:10px 15px;transition:background-color 0.3s;border-radius:10px;background:var(--muted-bg-color);margin:0px 5px;font-size:14px;}.tab.active{color:#fff;background-color:#556af1;transform:scale(1.05);box-shadow:0 6px 12px rgba(0,0,0,0.3);transition:all 0.3s ease;}.tab-content{position:relative;overflow:hidden;}.tab2_content{display:none;}.button{display:inline-block;padding:10px 20px;font-size:16px;font-weight:bold;text-align:center;text-decoration:none;cursor:pointer;border:none;border-radius:5px;background-color:#556af1;color:#fff;box-shadow:0 4px 8px rgba(0,0,0,0.2);transition:all 0.3s ease;}.button:hover{background-color:#3e53c4;box-shadow:0 6px 12px rgba(0,0,0,0.3);}
    </style>
    <?php
}add_action('wp_footer', 'zib_single_style');