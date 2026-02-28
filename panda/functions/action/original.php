<?php
/*
 * @Author: 苏晨
 * @Url: https://www.scbkw.com
 * @Date: 2024-12-20 13:49:26
 * @LastEditTime: 2024-12-31 10:05:27
 * @Email: 528609062@qq.com
 * @Project: 
 * @Description: 
 */
// 评论区评论正则拦截
if (panda_pz('comment_filter_regex')) {
    function refused_english_comments($incoming_comment) {
        // 获取评论内容
        $comment_content = $incoming_comment['comment_content'];
        // 去除评论内容中的 [g=xxx]，其中 xxx 为任意字符串
        $comment_content = preg_replace('/\[g=[^\]]*\]/', '', $comment_content);
        // 检查评论内容是否为空 
        if (empty($comment_content) && in_array(1, panda_pz('comment_filter_regex_num'))) {
            wp_die('{"error":1,"ys":"danger","msg":"评论不能是纯表情内容"}');
        }
        // 检查评论内容是否完全由数字组成
        if (preg_match('/^[0-9]+$/u', $comment_content) && in_array(2, panda_pz('comment_filter_regex_num'))) {
            wp_die('{"error":1,"ys":"danger","msg":"您的评论不能完全由数字组成"}');
        }
        // 检查评论内容是否完全由字母组成
        if (preg_match('/^[a-zA-Z]+$/u', $comment_content) && in_array(3, panda_pz('comment_filter_regex_num'))) {
            wp_die('{"error":1,"ys":"danger","msg":"您的评论不能完全由英文字母组成"}');
        }
        // 检查评论内容是否不包含汉字、数字或英文字母
        if (!preg_match('/[一-龥0-9a-zA-Z]/u', $comment_content) && in_array(4, panda_pz('comment_filter_regex_num'))) {
            wp_die('{"error":1,"ys":"danger","msg":"您的评论必须包含汉字、数字或英文字母"}');
        }
        // 检查评论内容是否包含连续出现3次及以上的相同字符
        if (preg_match('/(.)\\1{2}/u', $comment_content) && in_array(5, panda_pz('comment_filter_regex_num'))) {
            wp_die('{"error":1,"ys":"danger","msg":"您的评论不能包含连续出现3次及以上的相同字符"}');
        }
        // 检查评论内容是否包含日文字符
        if (preg_match('/[ぁ-ん]+|[ァ-ヴ]+/u', $comment_content) && in_array(6, panda_pz('comment_filter_regex_num'))) {
            wp_die('{"error":1,"ys":"danger","msg":"您的评论不能包含日文"}');
        }
        // 如果没有问题，返回评论内容
        return $incoming_comment;
    }
    add_filter('preprocess_comment', 'refused_english_comments');
}

//自定义go.php模板
function panda_gophp_template()
{
    $golink = get_query_var('golink');
    if ($golink) {
        global $wp_query;
        $wp_query->is_home = false;
        $wp_query->is_page = true; //将该模板改为页面属性，而非首页
        $template          = get_theme_file_path('/go.php');
        @session_start();
        $_SESSION['GOLINK'] = $golink;
        load_template($template);
        exit;
    }
}
remove_action('template_redirect', 'zib_gophp_template', 5);
add_action('template_redirect', 'panda_gophp_template', 5);