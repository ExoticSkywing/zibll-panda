<?php

if (panda_pz('comment_auto_reply')) {
    function auto_reply_on_comment($comment_id, $comment_approved) {
        if ($comment_approved == 1) {
            $comment = get_comment($comment_id);
            if ($comment->comment_parent == 0) {
                $admin_user = panda_pz('comment_auto_reply_comment_user_id');
                $comment_content = $comment->comment_content;
                $comment_content = '你好，帮我回复一下用户的评论，评论内容为：' . $comment_content . ',请不要回复其他多余的内容';
                $ai_select = panda_pz('ai_select');
                switch ($ai_select) {
                    case 0:
                        $comment_content = ai_deepseek($comment_content);
                        break;
                    case 1:
                        $comment_content = ai_chatgpt($comment_content);
                        break;
                    case 2:
                        $comment_content = (new Sample())->processRequest($comment_content);
                        break;
                    case 3:
                        $comment_content = get_response_from_api($comment_content);
                        break;
                }
                $reply_comment = array(
                    'comment_post_ID' => $comment->comment_post_ID,
                    'comment_author' => $admin_user->display_name,
                    'comment_author_email' => $admin_user->user_email,
                    'comment_author_url' => $admin_user->user_url,
                    'comment_content' => $comment_content,
                    'comment_type' => '',
                    'comment_parent' => $comment_id,
                    'user_id' => $admin_user,
                );
                wp_insert_comment($reply_comment);
            }
        }
    }
    add_action('wp_insert_comment', 'auto_reply_on_comment', 10, 2);
}
