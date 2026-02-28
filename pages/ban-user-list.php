<?php
/**
 * Template name: Panda子主题-用户封禁2
 * Description: Ban user list page
 */

//开始输出
$post_id                     = get_queried_object_id();
$page_id                     = $post_id;
$header_style                = zib_get_page_header_style();
$content_style               = zib_get_page_content_style($post_id);
$container_class = 'container';
$container_class .= $content_style ? ' page-content-' . $content_style : '';

//小工具容器
$widgets_register_container = array();
if (get_post_meta($post_id, 'widgets_register', true)) {
    $widgets_register_container = (array) get_post_meta($post_id, 'widgets_register_container', true);
}

get_header();
//顶部全宽度小工具
if ($widgets_register_container && in_array('top_fluid', $widgets_register_container)) {
    echo '<div class="container fluid-widget">';
    dynamic_sidebar('page_top_fluid_' . $post_id);
    echo '</div>';
}
?>
<main class="container <?php echo $container_class; ?>">
    <div class="content-wrap">
        <div class="content-layout">
        <?php  if($header_style != 1){echo zib_get_page_header($post_id);}?>
            <div class="theme-box radius8">
            <?php  if($header_style == 1){ echo zib_get_page_header($post_id);}?>
                <?php
                // 获取所有被封禁的用户
                $banned_users = get_users(array(
                    'meta_key' => 'banned',
                    'meta_value' => array(1, 2),
                    'meta_compare' => 'IN'
                ));
                
                if ($banned_users) {
                    $current_user_id = get_current_user_id();
                    
                    foreach ($banned_users as $user) {
                        $user_id = $user->ID;
                        $ban_info = zib_get_user_ban_info($user_id);
                        $is_current_user = ($current_user_id == $user_id);
                        
                        // 获取用户头像
                        $avatar = zib_get_data_avatar($user_id);
                        
                        echo '<div class="plate-card zib-widget" style="width: calc(20% - 16px);margin: 8px;">';
                        echo '<div class="plate-thumb">';
                        echo $avatar;
                        echo '</div>';
                        echo '<div class="title text-ellipsis mt10">' . $user->display_name . '</div>';
                        
                        // 封禁状态信息
                        $ban_type = $ban_info['type'] ?? 0;
                        $ban_status = ($ban_type == 2) ? '账号已封禁(禁止登录)' : '小黑屋禁封中';
                        $ban_time = !empty($ban_info['banned_time']) ? $ban_info['banned_time'] : '永久';
                        $reason = $ban_info['reason'] ?? '';
                        $time = $ban_info['time'];
                        
                        echo '<div class="mt3 px12 muted-2-color text-ellipsis count" data-toggle="tooltip" title="">';
                        echo $ban_status . '<br>';
                        echo '原因：' . $reason . '<br>';
                        echo '期限：' . $ban_time . '<br>';
                        echo '开始时间：' . $time;
                        echo '</div>';
                        
                        // 如果是当前用户查看自己的封禁状态
                        if ($is_current_user) {
                            $no_appeal = !empty($ban_info['no_appeal']);
                            
                            if ($no_appeal) {
                                echo '<div class="btn-follow but jb-pink but-plate btn-block mt20 disabled">';
                                echo '禁止申诉';
                                echo '</div>';
                            } else {
                                echo zib_get_user_ban_appeal_link($user_id, 'btn-follow but jb-pink but-plate btn-block mt20', '申诉解封');
                            }
                        } else {
                            // 管理员显示解封按钮
                            if (zib_current_user_can('set_user_ban') && !is_super_admin($user_id) && get_current_user_id() != $user_id) {
                                echo zib_get_edit_user_ban_link($user_id, 'btn-follow but jb-pink but-plate btn-block mt20', '解封此用户');
                            }
                        }

                        echo '</div>';
                    }
                } else {
                    // 没有封禁用户时显示空白内容
                    echo zib_get_null('暂无被封禁用户', 60, 'null.svg', '', 280, 0);
                }
                ?>
            </div>
            
            <?php
            comments_template('/template/comments.php', true);
            if ($widgets_register_container && in_array('bottom_content', $widgets_register_container)) {
                dynamic_sidebar('page_bottom_content_' . $post_id);
            } ?>
        </div>
    </div>
    <?php get_sidebar(); ?>
</main>
<?php
if ($widgets_register_container && in_array('bottom_fluid', $widgets_register_container)) {
    echo '<div class="container fluid-widget">';
    dynamic_sidebar('page_bottom_fluid_' . $post_id);
    echo '</div>';
}
get_footer();
?>