<?php

//日间、夜间模式切换提示
if (panda_pz('day_night_notice')) {
    function day_night_notice() {?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/layui/2.6.8/layui.min.js"></script>
    <?php }
    function day_night_notice_js() {?>
        <script>$(".toggle-theme").click(function() {var toggleThemeText = "当前为日间模式";if (!$("body").hasClass('dark-theme')) {toggleThemeText ="当前为夜间模式";}layer.msg(toggleThemeText, {time: 2000,anim: 1});});</script>
    <?php }
    add_action('wp_head', 'day_night_notice');
    add_action('wp_footer', 'day_night_notice_js');
}

// 私密评论
if (panda_pz('private_comment')) {
    // 私密评论显示逻辑
    function zib_private_message_hook($comment_content, $comment) {
        $comment_ID = $comment->comment_ID;
        $is_private = get_comment_meta($comment_ID, '_private', true);
        $email = $comment->comment_author_email;
        $current_user = wp_get_current_user();
        
        // HTML for private comment notification
        $html = '<div class="hidden-box" reply-show="true" reload-hash="#hidden-box-comment"><a class="hidden-text"><i class="fa fa-exclamation-circle mr10"></i>此评论为私密评论，仅双方可见.</a></div>';

        if ($is_private) {
            // 安全判断：优先使用 user_id 比对
            $is_comment_author = false;
            $is_post_author = false;
            $is_admin = current_user_can('manage_options');

            if ($current_user && $current_user->ID) {
                $is_comment_author = ($current_user->ID == $comment->user_id);
                $is_post_author = ($current_user->ID == get_post_field('post_author', $comment->comment_post_ID));
            }

            // 仅允许：管理员 / 评论作者 / 文章作者 查看私密评论内容
            if ($is_admin || $is_comment_author || $is_post_author) {
                return '<div class="hidden-box show" id="hidden-box-comment"><div class="hidden-text">私密评论内容</div>' . $comment_content . '</div>';
            }

            return $html;
        }

        return $comment_content;
    }
    add_filter('get_comment_text', 'zib_private_message_hook', 10, 2);

    // 添加私密按钮到评论操作列表
    function zib_comments_action_add_private($lists, $comment) {
        $current_user = wp_get_current_user();
        $user_id = get_current_user_id();

        // 仅允许管理员或评论作者看到“设为私密”选项
        if (is_user_logged_in() && (is_super_admin($user_id) || $current_user->ID == $comment->user_id)) {

            $comment_ID = $comment->comment_ID;
            $is_private = get_comment_meta($comment_ID, '_private', true);
            $private_text = empty($is_private) ? '设为私密' : '取消私密';
            $action = empty($is_private) ? 'set_private' : 'del_private';
            $private_but = '<a class="comment-private-link wp-ajax-submit" form-action="' . esc_attr($action) . '" form-data="' . esc_attr(json_encode(['id' => $comment_ID])) . '" href="javascript:;"><i class="fa fa-user-secret mr10" aria-hidden="true"></i>' . $private_text . '</a>';

            $lists = '<li>' . $private_but . '</li>' . $lists;
        }

        return $lists;
    }
    add_filter('comments_action_lists', 'zib_comments_action_add_private', 99, 2);

    // 处理更新评论私密状态的 AJAX 请求
    function zib_private_comment_action() {
        $response = ['reload' => true];

        if (!isset($_POST['action']) || !$_POST['action']) {
            zib_send_json_error(['msg' => '无效的操作类型'] + $response);
        }

        if (!isset($_POST['id']) || !$_POST['id']) {
            zib_send_json_error(['msg' => '无效的评论ID'] + $response);
        }

        $comment_id = intval($_POST['id']);
        $action = sanitize_text_field($_POST['action']);
        $comment = get_comment($comment_id);
        $post_author_id = get_post_field('post_author', $comment->comment_post_ID);

        $current_user = wp_get_current_user();

        // 用 user_id 判断评论作者
        if (!$comment_id || !$current_user || !($current_user->ID == $comment->user_id || current_user_can('manage_options'))) {
            zib_send_json_error(['msg' => '权限不足或无效的评论ID'] + $response);
        }

        if ($action === 'set_private') {
            update_comment_meta($comment_id, '_private', 'true');
            zib_send_json_success(['msg' => '评论已设为私密'] + $response);
        } elseif ($action === 'del_private') {
            delete_comment_meta($comment_id, '_private');
            zib_send_json_success(['msg' => '评论已公开'] + $response);
        } else {
            zib_send_json_error(['msg' => '无效的操作类型'] + $response);
        }
    }
    add_action('wp_ajax_set_private', 'zib_private_comment_action');
    add_action('wp_ajax_del_private', 'zib_private_comment_action');
}

//侧边栏评论小工具简约美化
if (panda_pz('sidebar_comment_style')) {
    function comment_side_style() {?>
        <style>
	   .comment-mini-lists>div.posts-mini{border: 1px dashed #999999;border-radius: 10px;margin-top: 10px;}
	    </style>
    <?php } add_action('wp_head', 'comment_side_style');
}

//侧边栏评论小工具
if (panda_pz('comment_side_bg_style')) {
    function comment_side_bg_style_css(){?>
        <style>.posts-mini{background-size:cover;margin-bottom:5px;padding:15px;}span.flex0.icon-spot.muted-3-color{color:var(--theme-color);opacity:0.5;}.text-ellipsis-5{max-height:3em;-webkit-line-clamp:5;max-width:12em;}</style>
        <?php }
        function comment_side_bg_style_js(){?>
        <script>
        var postsMiniElements = document.querySelectorAll('.posts-mini');  
        postsMiniElements.forEach(function(element) {  
            var randomBase64 = btoa(Math.random().toString(36).substr(2, 9));  
            var url = '<?php echo panda_pz('static_panda');?>/assets/img/uid/?kid=' + randomBase64;  
            element.style.backgroundImage = 'url(' + url + ')';  
        });
        </script>
    <?php }
    add_action('wp_head', 'comment_side_bg_style_css');
    add_action('wp_footer', 'comment_side_bg_style_js');
}

//侧边栏评论小工具炫酷效果
if (panda_pz('comment_side_effect_style')) {
    function comment_side_effect_style() {?>
        <style>
        .comment-mini-lists .posts-mini {
            border-bottom: 1px dotted #f9d7e2;
            box-shadow: rgb(42 42 223 / 20%) 0px 7px 29px 0px;
            background-image: URL('<?php echo panda_pz('static_panda');?>/assets/img/comment/commentkuang.webp');
            background-size: 100% 100%;
        }
        </style>
    <?php } add_action('wp_head', 'comment_side_effect_style');
}
//评论框背景
if (panda_pz('comment_bg_img') != 'default') {
    function comment_bg_img() {
        switch (panda_pz('comment_bg_img')) {
            case '1':
                $background_image = ''.panda_pz('static_panda').'/assets/img/comment/1.png';
                break;
            case '2':
                $background_image = ''.panda_pz('static_panda').'/assets/img/comment/2.png';
                break;
            case '3':
                $background_image = ''.panda_pz('static_panda').'/assets/img/comment/3.png';
                break;
            case '4':
                $background_image = ''.panda_pz('static_panda').'/assets/img/comment/4.png';
                break;
            case '5':
                $background_image = ''.panda_pz('static_panda').'/assets/img/comment/5.jpg';
                break;
            case '6':
                $background_image = ''.panda_pz('static_panda').'/assets/img/comment/6.gif';
                break;
            case '7':
                $background_image = ''.panda_pz('static_panda').'/assets/img/comment/7.png';
                break;
            case '8':
                $background_image = ''.panda_pz('static_panda').'/assets/img/comment/8.gif';
                break;
            case '9':
                $background_image = ''.panda_pz('static_panda').'/assets/img/comment/9.gif';
                break;
            case 'custom':
                $background_image = panda_pz('comment_bg_img_s');
                break;
            default:
                $background_image = ''; 
        }
        ?>
        <style>
            textarea#comment {
                background-color: transparent;
                background: linear-gradient(rgba(0, 0, 0, 0.05), rgba(0, 0, 0, 0.05)), url(
                    <?php echo $background_image; ?>
                ) right 30px bottom 0px no-repeat;
                background-size: auto 75px;
                -moz-transition: ease-in-out 0.45s;
                -webkit-transition: ease-in-out 0.45s;
                -o-transition: ease-in-out 0.45s;
                -ms-transition: ease-in-out 0.45s;
                transition: ease-in-out 0.45s;
            }
            textarea#comment:focus {
                background-position-y: 789px;
                -moz-transition: ease-in-out 0.45s;
                -webkit-transition: ease-in-out 0.45s;
                -o-transition: ease-in-out 0.45s;
                -ms-transition: ease-in-out 0.45s;
                transition: ease-in-out 0.45s;
            }
        </style>
        <?php
    }
    add_action('wp_head', 'comment_bg_img');
}

//评论区背景
function comment_bg_style(){
    if (panda_pz('comment_bg_style') == 'red') {?>
    <style>body{--acg-color:#fff8fa;}.dark-theme{--acg-color:#323335;}#postcomments .children {background: rgb(116 116 116 / 0%);}.comment .list-inline>.comt-main {border-color: #ff8bb5;background-color: var(--acg-color);background-image: url(<?php echo panda_pz('static_panda');?>/assets/img/bg/shading_red.png);}.comment .list-inline>li {vertical-align: top;overflow: hidden;border-radius: 5px;margin: 0 15px 15px;border: 1px solid;position: relative;display: flow-root;padding: 10px;}</style>
    <?php }if (panda_pz('comment_bg_style') == 'blue') {?>
        <style>body{--acg-color:#f8fdff;}.dark-theme{--acg-color:#323335;}#postcomments .children {background: rgb(116 116 116 / 0%);}.comment .list-inline>.comt-main {border-color: #71baff80;background-color: var(--acg-color);background-image: url(<?php echo panda_pz('static_panda');?>/assets/img/bg/shading_blue.png);}.comment .list-inline>li {vertical-align: top;overflow: hidden;border-radius: 5px;margin: 0 15px 15px;border: 1px solid;position: relative;display: flow-root;padding: 10px;}</style>
    <?php }if (panda_pz('comment_bg_style') == 'red_and_blue') {?>
        <style>body{--acg-color:#fff8fa;--acg-color2:#f8fdff;}.dark-theme{--acg-color:#323335;--acg-color2:#323335;}#postcomments .commentlist .comment{border-top:1px solid rgb(50 50 50 / 0%);border-radius:15px;margin:0 15px 15px;border:1px solid;display:flow-root;background-image:url(<?php echo panda_pz('static_panda');?>/assets/img/bg/shading_blue.png);border-color:#71baff80;background-color:var(--acg-color2);}#postcomments .commentlist .comment+.comment{border-top:1px solid rgb(50 50 50 / 0%);padding:0 0 15px 0;border-radius:15px;margin:0 15px 15px;border:1px solid;display:flow-root;padding:10px;}#postcomments .commentlist .comment+.comment:nth-child(odd){background-image:url(<?php echo panda_pz('static_panda');?>/assets/img/bg/shading_red.png);border-color:#ff8bb5;background-color:var(--acg-color);}#postcomments .commentlist .comment+.comment:nth-child(even){background-image:url(<?php echo panda_pz('static_panda');?>/assets/img/bg/shading_blue.png);border-color:#71baff80;background-color:var(--acg-color2);}#postcomments .children{background:rgb(116 116 116 / 0%);margin-bottom:6px;border-radius:15px;display:flow-root;}#postcomments .children:nth-child(even){background-image:url(<?php echo panda_pz('static_panda');?>/assets/img/bg/shading_blue.png);border-color:#71baff80;}#postcomments .children:nth-child(odd){background-image:url(<?php echo panda_pz('static_panda');?>/assets/img/bg/shading_red.png);border-color:#ff8bb5;background-color:var(--acg-color);}</style>
    <?php }if (panda_pz('comment_bg_style') == 'diy') {?>
<style>
#postcomments .children {
background: rgb(116 116 116 / 0%);
}
.comment .list-inline>.comt-main {
border-color: #ff8bb5;
background-color: var(--acg-color);
background-image: url(<?php echo panda_pz('comment_bg_diy')?>);
}
.comment .list-inline>li {
vertical-align: top;
overflow: hidden;
border-radius: 5px;
margin: 0 15px 15px;
border: 1px solid;
position: relative;
display: flow-root;
padding: 10px;
}
    </style>
    <?php }
}add_action('wp_head', 'comment_bg_style');

// 评论区ID
if (panda_pz('comment_uid')) {
    function comment_uid_css() {
        ?>
        <style>
            .bili-dyn-item__ornament {
                position: sticky;
                right: 48px;
                top: 18px;
                margin-top: -13px;
                float: right;
            }
            .bili-dyn-ornament__type--3 {
                height: 44px;
                width: 146px;
            }
            .bili-dyn-ornament img {
                height: 100%;
                width: 100%;
                user-select: none;
                pointer-events: none;
            }
            .bili-dyn-ornament__type--3 span {
                font-family: num !important;
                font-size: 12px;
                position: absolute;
                right: 54px;
                top: 15px;
                transform: scale(.88);
                transform-origin: right;
            }
        </style>
        <?php
    }
    function generateRandomString($length = 10) {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }
    function comment_uid($info, $comment, $depth) {
        $user_ip = $comment->comment_author_IP;
        if ($user_ip) {
            $randomString = generateRandomString();
            $img_list = array('' . panda_pz('static_panda') . '/assets/img/uid/?kid=' . base64_encode($randomString));
            $color_list = array("rgb(138, 154, 247)", "rgb(187, 103, 138)", "rgb(166, 236, 149)", "rgb(172, 170, 94)", "rgb(240, 88, 88)", "rgb(182, 117, 243)", "rgb(219, 96, 157)", "rgb(245, 107, 72)", "rgb(196, 167, 104)", "rgb(221, 42, 42)", "rgb(240, 158, 226)", "rgb(243, 200, 98)", "rgb(248, 155, 200)", "rgb(114, 153, 238)", "rgb(214, 207, 107)", "rgb(192, 127, 235)", "rgb(197, 184, 30)", "rgb(245, 155, 210)", "rgb(231, 197, 152)", "rgb(98, 98, 119)", "rgb(221, 200, 173)", "rgb(110, 175, 187)", "rgb(137, 141, 190)", "rgb(166, 152, 238)", "rgb(104, 192, 207)", "rgb(216, 124, 152)");
            $img_res = array_rand($img_list);
            $color_res = array_rand($color_list);

            $user_id = $comment->user_id;
            $user_id = str_pad($user_id, panda_pz('comment_uid_s'), "0", STR_PAD_LEFT);
            $uid_type = 'ID:' . $user_id;
            $uid_type_desc = 'ID';

            $pad_length = 5;
            $uid = $uid_type;
            $bill_html = '<div class="bili-dyn-item__ornament" data-clipboard-tag="' . $uid_type_desc . '" data-clipboard-text="' . $uid . '"><div class="bili-dyn-ornament"><div class="bili-dyn-ornament__type--3"><img src="' . $img_list[$img_res] . '" alt="' . $uid_type_desc . '"><span style="color:' . $color_list[$color_res] . '">' . $uid . '</span></div></div></div>';
            $info .= $bill_html;
        }
        return $info;
    }
    add_action('wp_head', 'comment_uid_css');
    add_filter('comment_footer_info', 'comment_uid', 10, 3);
}

/*评论区自动输入随机内容*/
if (panda_pz('comment_random_text')) {
    function comment_random_text_js(){?>
        <script>$.getJSON("<?php echo panda_pz('static_panda');?>/assets/others/yiyan/talk_words.php?code=yiyan",function(data){$("#comment").text(data.text);});$(function(){$("#comment").click(function() {$(this).select();})})</script>
        <?php }
    add_action('wp_footer', 'comment_random_text_js');
}

//夸夸
if (panda_pz('pandamsg_comment_box')) {
    function pandamsg_comment_box() {
        ?>
    <link rel="stylesheet" type="text/css" href="<?php echo panda_pz('static_panda'); ?>/assets/css/kuakua.css">
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var submitButton = document.getElementById('submit');
        if (submitButton) {
            // 创建夸夸按钮 (a标签)
            var praiseButton = document.createElement('a');
            praiseButton.className = 'but btn-input-expand input-image mr6';
            praiseButton.id = 'kuakua'; // 固定id属性
            praiseButton.href = "javascript:;";
            praiseButton.innerHTML = '<svg class="icon hide-sm" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" role="img"><image href="<?php echo panda_pz('static_panda'); ?>/assets/img/kuakua.png" width="14px" height="14px" /></svg><span>夸夸</span>';
            
            // 创建新的div标签
            var newDiv = document.createElement('div');
            newDiv.className = 'kuakua-div';  // 设定class属性
            newDiv.style.width = '100%';
            newDiv.style.height = '100%';
            newDiv.style.background = '#000';
            newDiv.style.zIndex = '1031';
            newDiv.style.position = 'fixed';
            newDiv.style.top = '0';
            newDiv.style.left = '0';
            newDiv.style.opacity = '.6';
            newDiv.style.display = 'none';

            // 将a标签插入到submit按钮前
            submitButton.parentNode.insertBefore(praiseButton, submitButton);

            // 在a标签后插入div
            praiseButton.parentNode.insertBefore(newDiv, praiseButton.nextSibling);

            // 在新的div后面插入夸夸功能的内容
            var kuakuaBox = document.createElement('div');
            kuakuaBox.className = 'kuakua-first-box';
            kuakuaBox.style.display = 'none';
            kuakuaBox.innerHTML = `
                <div class="kuakua-ei">
                    <span class="kuakua-close" title="关闭">
                        <div>
                            <svg fill-rule="evenodd" clip-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="1.414" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" id="close" class="sc-eCImPb iRFNEp">
                                <g fill="none" fill-rule="evenodd" stroke="currentColor">
                                    <path d="M7.99 7.99L1 1l6.99 6.99L1 14.98l6.99-6.99zm0 0L15 15 7.99 7.99 14.98 1 7.99 7.99z" stroke="currentColor"></path>
                                </g>
                            </svg>
                        </div>
                    </span>
                    <div>
                        <div class="kuakua-column">
                            <section class="kuakua-headerIcon">
                                <svg class="icon kuakua-icon" aria-hidden="true">
                                    <image href="<?php echo panda_pz('static_panda'); ?>/assets/img/kuakua.png" width="65px" height="60px" />
                                </svg>
                            </section>
                            <span size="16" color="black4" class="kuakua-headerTitle">夸夸</span>
                        </div>
                    </div>
                    <div style="position: relative; display: block;">
                        <div>
                            <section class="kuakua-modal-body">
                                <section class="kuakua-contentBox">
                                    <span size="18" color="black4" class="kuakua-comment">还有吗！没看够！</span>
                                    <button type="button" class="kuakua-cancelBtn">换一换</button>
                                </section>
                                <button type="button" class="kuakua-confirmBtn">夸夸TA</button>
                            </section>
                        </div>
                    </div>
                </div>
            `;
            // 插入到新创建的div后面
            newDiv.parentNode.insertBefore(kuakuaBox, newDiv.nextSibling);
            // 点击按钮控制显示/隐藏
            praiseButton.addEventListener('click', function(e) {
                newDiv.style.display = newDiv.style.display === 'none' ? 'block' : 'none';
                kuakuaBox.style.display = kuakuaBox.style.display === 'none' ? 'block' : 'none';
                fetchPraise(); // 获取并展示初始夸夸内容
                e.stopPropagation();
            });
            // 关闭按钮逻辑
            var closeButton = kuakuaBox.querySelector('.kuakua-close');
            closeButton.addEventListener('click', function() {
                kuakuaBox.style.display = 'none';
                newDiv.style.display = 'none';
                document.getElementById('comment').value = ""; // 清空评论框内容
            });
            // 获取夸夸文本的函数
            function fetchPraise() {
                $.getJSON("<?php echo panda_pz('static_panda'); ?>/assets/others/yiyan/talk_words.php?code=kuakua", function(data) {
                    $(".kuakua-comment").html(data.text);
                    $("#comment").val(data.text); // 将夸夸文本插入评论框
                });
            }
            // 换一换按钮逻辑
            $(".kuakua-cancelBtn").click(function() {
                fetchPraise(); // 获取并展示新夸夸内容
            });

            // 夸夸确认按钮逻辑
            $(".kuakua-confirmBtn").click(function() {
                $("#submit").trigger("click"); // 提交评论
                kuakuaBox.style.display = 'none';
                newDiv.style.display = 'none';
            });
        }
    });
    </script>
    <?php
    }add_action('wp_footer', 'pandamsg_comment_box');
      
}

function zib_msg_set_notice_style(){
    $user_id = get_current_user_id();
    if (!$user_id) {
        return;
    }

    $msg_set = (array) zib_get_user_meta($user_id, 'message_shield', true);

    $but_args   = array();
    $but_args[] = array(
        'checked' => in_array('posts', $msg_set),
        'neme'    => 'posts',
        'title'   => '文章评论',
        'label'   => '接收文章、评论、收藏等相关消息',
    );
    $but_args[] = array(
        'checked' => in_array('like', $msg_set),
        'neme'    => 'like',
        'title'   => '点赞喜欢',
        'label'   => '接收点赞、关注等相关消息',
    );
    $but_args[] = array(
        'checked' => in_array('system', $msg_set),
        'neme'    => 'system',
        'title'   => '系统消息',
        'label'   => '接收订单、活动、等系统消息',
    );
    if (panda_pz('add_pandamsg_post_box')) {
    $but_args[] = array(
        'checked' => in_array('article', $msg_set),
        'neme'    => 'article',
        'title'   => '文章发布、更新',
        'label'   => '接收文章发布、更新相关消息',
    );
    }
    if (panda_pz('pandamsg_post_comment')) {
    $but_args[] = array(
        'checked' => in_array('article_update', $msg_set),
        'neme'    => 'article_update',
        'title'   => '文章更新',
        'label'   => '接收评论过的文章更新相关消息',
    );
    }
    if (panda_pz('pandamsg_user')) {
    $but_args[] = array(
        'checked' => in_array('ueser_login', $msg_set),
        'neme'    => 'ueser_login',
        'title'   => '用户登录',
        'label'   => '接收用户登录相关消息',
    );
    }
    if (panda_pz('pandamsg_user_update')) {
    $but_args[] = array(
        'checked' => in_array('ueser_update', $msg_set),
        'neme'    => 'ueser_update',
        'title'   => '用户信息更新',
        'label'   => '接收用户信息更新相关消息',
    );
    }
    if (panda_pz('pandamsg_user_reg')) {
    $but_args[] = array(
        'checked' => in_array('ueser_reg', $msg_set),
        'neme'    => 'ueser_reg',
        'title'   => '推广用户注册',
        'label'   => '接收推广用户注册相关消息',
    );
    }
    if (panda_pz('pandamsg_vip')) {
    $but_args[] = array(
        'checked' => in_array('vip', $msg_set),
        'neme'    => 'vip',
        'title'   => '会员到期',
        'label'   => '接收会员到期相关消息',        
    );
    }
    $set = '';
    foreach ($but_args as $but) {
        $checked = $but['checked'] ? '' : ' checked="checked"';

        $set .= '<div class="border-bottom box-body"><label class="flex jsb ac">';
        $set .= '<input class="hide"' . $checked . ' name="' . $but['neme'] . '" type="checkbox">';

        $set .= '<div class="flex1 mr20">';
        $set .= '<div class="em12 mb6">' . $but['title'] . '</div>';
        $set .= '<div class="muted-2-color" style="font-weight: normal;">' . $but['label'] . '</div>';
        $set .= '</div>';

        $set .= '<div class="form-switch flex0">';

        $set .= '</div>';
        $set .= '</label></div>';
    }

    $set .= '<div class="mt20 mr20 text-right">';
    $set .= '<input type="hidden" name="user_id" value="' . $user_id . '">';
    $set .= '<input type="hidden" name="action" value="message_shield">';
    $set .= wp_nonce_field('user_msg_set', '_wpnonce', false, false); //安全验证
    $set .= '<button type="button" zibajax="submit" class="but jb-blue padding-lg mt10" name="submit"><i class="fa fa-check mr10"></i>确认提交</button>';
    $set .= '</div>';

    $con = '';
    $con = '<form>' . $set . '</form>';

    $html = '<div class="zib-widget"><div class="box-body notop nopw-sm">' . $con . '</div></div>';
    return zib_get_ajax_ajaxpager_one_centent($html);
}
add_filter('main_user_tab_content_msg', 'zib_msg_set_notice_style');

//文章更新邮件通知
function add_pandamsg_post_box (){if (panda_pz('add_pandamsg_post_box')) {
    add_meta_box('pandamsg_post_box', '邮件通知', 'pandamsg_post_box','post','normal','high');
}}add_action('add_meta_boxes','add_pandamsg_post_box');

function pandamsg_post_box(){if (panda_pz('add_pandamsg_post_box')) {
    echo '<span style="margin:15px 20px 15px 0; display:inline-block;"><label><input type="checkbox" checked name="pandamsg_post" value="1" title="勾选此项，将邮件通知博客所有注册用户"/> 给用户发送邮件通知</label></span></br>发布、更新文章会给用户发送邮件';
}}
  
function pandamsg_newPostNotify($post_ID) {if (panda_pz('add_pandamsg_post_box')) {
    if(!isset($_POST['pandamsg_post']))return;
    if(wp_is_post_revision($post_ID))return;
    global $wpdb;
    $blogurl   = get_bloginfo('url');
    $get_post_info = get_post($post_ID);
    if ( $get_post_info->post_status == 'publish' && $_POST['original_post_status'] != 'publish' ) {
        $wp_user_email = $wpdb->get_results("SELECT DISTINCT * FROM $wpdb->users");
        foreach ( $wp_user_email as $email ) {
          $user_id = $email->ID;
          if (!zib_msg_is_allow_receive($user_id, 'article')) return;
          $fsemail = $email->user_email;
          $subject = ''.get_bloginfo('name').'更新啦！';
          $message = '尊敬的 '.$email->display_name.' :<br>您关注的'.get_bloginfo('name').'更新了一篇新文章：<h2>'.get_the_title($post_ID).'</h2><p style="padding: 10px 15px; border-radius: 8px; background: rgba(141, 141, 141, 0.05); line-height: 1.7;">'.zib_get_excerpt().'</p><br><br>您可以点击下方按钮查看更新内容<br><a target="_blank" style="margin-top: 20px;padding:5px 20px" class="but jb-blue"  href="'.get_permalink($post_ID).'" rel="noopener">立即查看</a><br><br>如有打扰在<a href="'.$blogurl.'/user" rel="noopener" target="_blank">消息通知</a>中关闭掉文章发布、更新选项即可';
          wp_mail($fsemail, $subject, $message);
       }
    }
}}add_action('publish_post', 'pandamsg_newPostNotify');
  


function notify_commenters_on_update($post_ID, $post_after, $post_before) {
    if (panda_pz('pandamsg_post_comment')) {
        // 检查文章是否确实被更新（不是新建立的）
        if ($post_after->post_date == $post_after->post_modified) return;

        // 获取评论过的用户的电子邮件
        $args = array(
            'post_id' => $post_ID,
            'status' => 'approve'
        );
        $comments = get_comments($args);
        $notified_users = array(); // 存储已经发送过通知邮件的用户的电子邮件

        // 获取已发送过通知的邮箱列表
        $notified_emails = get_option('notified_post_update_emails', array());

        foreach ($comments as $comment) {
            if (!empty($comment->comment_author_email) && filter_var($comment->comment_author_email, FILTER_VALIDATE_EMAIL)) {
                $email = $comment->comment_author_email;

                // 检查该邮箱是否已收到过通知
                if (!in_array($email, $notified_emails)) {
                    array_push($notified_users, $email);
                    $notified_emails[] = $email;  // 将邮箱添加到已通知邮箱列表
                }
            }
        }

        // 如果有用户需要通知，发送邮件
        if (!empty($notified_users)) {
            // 邮件主题和内容
            $subject = '我们更新了您评论过的文章!';
            $message = '您好，' . "\r\n\r\n";
            $message .= '一篇您之前评论过的文章《' . $post_after->post_title . '》已经有了更新。' . "\r\n";
            $message .= '您可以点击以下链接查看文章的最新内容：' . "\r\n";
            $message .= get_permalink($post_ID) . "\r\n\r\n";
            $message .= '谢谢您的参与，期待您再次光临！' . "\r\n";
            $message .= get_bloginfo('name') . "\r\n";
            $message .= '<br><br>如有打扰在<a href="'.$blogurl.'/user" rel="noopener" target="_blank">消息通知</a>中关闭掉文章更新选项即可';

            // 发送邮件给每个需要通知的用户
            foreach ($notified_users as $email) {
                if (!zib_msg_is_allow_receive($user_id, 'article_update')) return;
                wp_mail($email, $subject, $message);
            }

            // 将已通知的邮箱保存到选项中
            update_option('notified_post_update_emails', $notified_emails);
        }
    }
}

add_action('post_updated', 'notify_commenters_on_update', 10, 3);




// 用户登录提醒
if (panda_pz('pandamsg_user')) {
    function notify_all_user_login($user_login, $user) {
        // 尊重用户“登录提醒”开关
        if (!zib_msg_is_allow_receive($user->ID, 'ueser_login')) {
            return;
        }
        date_default_timezone_set('PRC');
        $user_email = $user->user_email;
        $subject = '您的账户登录提醒 - ' . get_option("blogname");
        $message = '<p>您好！您的账户(' . $user_login . ')已成功登录：</p>' .
                "<p>登录时间：" . date("Y-m-d H:i:s") . "</p>" .
                "<p>登录IP：" . $_SERVER['REMOTE_ADDR'] . "</p>" .
                "<p>设备信息：" . $_SERVER['HTTP_USER_AGENT'] . "</p>";
        $domain = preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));
        $headers = array(
            'Content-Type: text/html; charset=' . get_option('blog_charset'),
            'From: 系统通知 <no-reply@' . $domain . '>'
        );
        wp_mail($user_email, $subject, $message, $headers);
    }
    add_action('wp_login', 'notify_all_user_login', 10, 2);
}

//用户资料变更提醒
  
function user_profile_update_email_notification( $user_id, $old_user_data ) {if (panda_pz('pandamsg_user_update')) {
    $user = get_userdata( $user_id );
    // 用户电子邮件地址
    $to = $user->user_email;
    // 邮件标题
    $subject = '您的账户资料已更新';
    // 设置邮件消息内容
    $message = "尊敬的 " . $user->display_name . ",\n\n" . 
                 "您的账户资料已经在 " . get_bloginfo( 'name' ) . " 上成功更新。\n\n" . 
                 "如果您没有请求此变更，请尽快联系我们。\n\n" . 
                 "此致\n\n" . get_bloginfo( 'name' ) . " 团队";
    // 邮件头部信息
    $headers = array('Content-Type: text/plain; charset=UTF-8');
    // 发送邮件
    if (!zib_msg_is_allow_receive($user_id, 'ueser_update')) return;
    wp_mail( $to, $subject, $message, $headers );
}}add_action( 'profile_update', 'user_profile_update_email_notification', 10, 2 );
  
function notify_referrer_on_new_registration($new_user_id) {if (panda_pz('pandamsg_user_reg')) {
    // 获取新注册用户的数据
    $new_user_data = get_userdata($new_user_id);
    // 假设我们在用户注册时，通过某种方式保存了推荐人的ID
    // 例如，可能保存在用户的meta数据中
    $referrer_id = get_user_meta($new_user_id, 'referrer_id', true);      
    if (!empty($referrer_id)) {
        // 获取推荐人的数据
        $referrer_data = get_userdata($referrer_id);
        if ($referrer_data) {
            // 设置邮件标题和内容
            $blog_name = get_bloginfo('name');
            $subject = '您推广的好友已成功注册';
            $message = "亲爱的 {$referrer_data->display_name},\n\n";
            $message .= "您推广的好友 {$new_user_data->display_name} 已经成功在 {$blog_name} 网站上注册。\n\n";
            $message .= "访问下面的链接查看您的推广成果：\n";
            $message .= site_url('/referrer-area'); // 替换为您的推荐区域URL
            // 设置邮件头部信息
            $headers = array('Content-Type: text/plain; charset=UTF-8');
            // 发送邮件
            if (!zib_msg_is_allow_receive($user_id, 'ueser_reg')) return;
            wp_mail($referrer_data->user_email, $subject, $message, $headers);
            // 这里，您也可以执行其他相关逻辑，例如更新推荐人的统计数据、奖励积分等
        }
    }
}}add_action('user_register', 'notify_referrer_on_new_registration', 10, 1);


// 会员到期提醒
function pandamsg_notify_user_vip_expiration($user_id) {if (panda_pz('pandamsg_vip')) {
    // 获取用户会员到期时间
    $vip_exp_date = get_user_meta($user_id, 'vip_exp_date', true);
    // 检查是否是永久会员
    if ('Permanent' == $vip_exp_date) return;
    // 获取当前日期和到期日期的差值（以天为单位）
    $current_date = new DateTime();
    $expiration_date = new DateTime($vip_exp_date);
    $interval = $current_date->diff($expiration_date)->format('%r%a');
    // 根据剩余天数决定消息内容
    $message_content = '';
    $notify_days = pandamsg('vip_notification_days');  // 在此数组中定义提醒的天数
    $notify = false; // 是否发送通知的标志
    if (in_array($interval, $notify_days)) {
        $day_word = $interval == 1 ? '明天' : $interval . '天后';
        $message_content = "<p>您的会员服务将在<b style='color:red;font-size: 2em;'>{$day_word}</b>到期。</p><p>为了确保您能够不间断享受我们的专属服务和权益，我们诚邀您及时续订。</p><p><a href='" . get_bloginfo('url') . "' class='vip-pay' style='color: #0077ff;background: #5ca8ff52;padding: 3px;border-radius: 4px;'>点击此处立即续订</a>,继续畅享精彩内容与特权！感谢您的支持，如果您有任何疑问或需要帮助，请随时联系我们。</p>";
        $notify = true;
    } else if ($interval <= 0) {
        // 如果会员已到期
        $message_content = '<p>您的会员身份已到期，我们希望您能继续享受到我们提供的专属优惠和服务。</p><p>现在续订，不仅可以立即恢复您的会员资格，还能享受到专门为您准备的续订优惠！</p><p><a href="' . get_bloginfo('url') . '" class="vip-pay" style="color: #0077ff;background: #5ca8ff52;padding: 3px;border-radius: 4px;">点击此处→[续订链接]</a>，秒回VIP体验，精彩不停歇。</p><p>期待再次为您服务！</p><p>为您送上最好的祝愿</p>';
        $notify = true;
    }
    if ($notify) {
        // 通知逻辑
        $title = '会员到期提醒';
        $message = '亲爱的会员用户：' . '<br>' . $message_content;
        
        $msg_arge = array(
            'send_user' => 'admin',
            'receive_user' => $user_id,
            'type' => 'system',
            'title' => $title,
            'content' => $message,
            'meta' => '',
            'other' => '',
        );
        // 创建新消息（假设您已经有了pandamsg类和相应的添加消息的方法）
        if (method_exists('pandamsg', 'add')) {
            pandamsg::add($msg_arge);
        }
        // 如果需要也可以发送邮件
        $user_data = get_userdata($user_id);
        $email = !empty($user_data->user_email) ? $user_data->user_email : '';
        // 判断邮箱格式是否正确，且不包含无效标记
        if (is_email($email) && !stristr($email, '@no')) {
            $blog_name = get_bloginfo('name');
            $title     = '[' . $blog_name . '] ' . $title;
            /**发送邮件 */
            if (!zib_msg_is_allow_receive($user_id, 'vip')) return;
            @wp_mail($email, $title, $message);
        }
    }
}}add_action('wp', 'pandamsg_daily_vip_expiration_check');

function pandamsg_daily_vip_expiration_check() {if (panda_pz('pandamsg_vip')) {
    if (!wp_next_scheduled('pandamsg_daily_check_vip_status')) {
        wp_schedule_event(time(), '1min', 'pandamsg_daily_check_vip_status');
    }
}}add_action('pandamsg_daily_check_vip_status', 'pandamsg_execute_daily_vip_check');

function pandamsg_execute_daily_vip_check() {if (panda_pz('pandamsg_vip')) {
    // 获取所有用户
    $users = get_users();
    foreach ($users as $user) {
        // 对每个用户执行会员状态检查
        pandamsg_notify_user_vip_expiration($user->ID);
    }
}}

// 后台登陆通知
function pandamsg_admin_login_notification() {if (panda_pz('pandamsg_admin')) {
    // 检查是否已设置了特定的登录Cookie，如果设置了，则不再发送邮件
    if (isset($_COOKIE['admin_logged_in']) && $_COOKIE['admin_logged_in'] == get_current_user_id()) {
        return;
    }
    $current_user = wp_get_current_user();
    // 检查当前登录用户是否有访问后台权限
    if (current_user_can('edit_posts')) {
        // 获取管理员的电子邮件地址
        $admin_email = get_option('admin_email');
        // 设置邮件主题和内容
        $subject = "通知: 用户 {$current_user->user_login} 登录了WordPress后台";
        $message = "用户 {$current_user->user_login} 在 " . date('Y-m-d H:i:s') . " 登录了WordPress后台。\n\n用户邮箱: {$current_user->user_email}\n登录IP: " . $_SERVER['REMOTE_ADDR'];
        // 发送邮件给管理员
        wp_mail($admin_email, $subject, $message);

        // 发送成功后，设置一个Cookie，标记该用户一天之内已发送过登录提醒
        $cookie_expiry = DAY_IN_SECONDS; // WordPress预定义的一天的秒数常量
        
        // Cookie值设置为当前登录的用户ID，以便每个用户有自己的Cookie记录
        setcookie('admin_logged_in', get_current_user_id(), time() + $cookie_expiry, COOKIEPATH, COOKIE_DOMAIN, is_ssl(), true);
    }
}}add_action('admin_init', 'pandamsg_admin_login_notification');


add_action('wp_ajax_diy_email_to_all_users', 'send_email_to_all_users_callback');
function send_email_to_all_users_callback() {
    // 权限检查
    if (!is_super_admin()) {
        echo (json_encode(array('error' => 1, 'ys' => 'danger', 'msg' => '操作权限不足')));
        exit();
    }

    $email_title = panda_pz('pandamsg_diy_title');
    $email_content = panda_pz('pandamsg_diy_desc');

    // 获取所有用户的电子邮件
    $users = get_users(array('fields' => array('user_email')));

    // 发送电子邮件
    foreach ($users as $user) {
        wp_mail($user->user_email, $email_title, $email_content);
    }

    wp_send_json_success('邮件发送成功');
}

// —— 子主题接管：保存“消息通知”设置，支持更多细分类型 ——
add_action('init', function(){
    // 移除父主题默认处理器
    remove_action('wp_ajax_message_shield', 'zib_ajax_user_message_shield');
    // 注册子主题的处理器
    add_action('wp_ajax_message_shield', 'panda_ajax_user_message_shield');
});

function panda_ajax_user_message_shield(){
    if (!_pz('message_user_set', true)) {
        echo(json_encode(array('error' => 1, 'ys' => 'danger', 'msg' => '暂未提供此功能')));
        exit;
    }

    $user_id = get_current_user_id();
    if (!$user_id) {
        echo(json_encode(array('error' => 1, 'ys' => 'danger', 'msg' => '登录失效，请刷新页面')));
        exit;
    }
    // 安全验证
    if (!wp_verify_nonce($_REQUEST['_wpnonce'], 'user_msg_set')) {
        echo(json_encode(array('error' => 1, 'ys' => 'danger', 'msg' => '安全验证失败，请刷新后再试')));
        exit();
    }

    $shield      = array();
    // 扩展支持的屏蔽类型（与子主题UI保持一致）
    $shield_type = array(
        'posts',
        'like',
        'system',
        'article',
        'article_update',
        'ueser_login',
        'ueser_update',
        'ueser_reg',
        'vip',
    );

    foreach ($shield_type as $type) {
        if (empty($_REQUEST[$type])) {
            $shield[] = $type;
        }
    }
    zib_update_user_meta($user_id, 'message_shield', $shield);

    echo(json_encode(array('msg' => '设置已保存', 'shield' => $shield)));
    exit;
}

// —— 通过过滤器扩展分类映射，让具体类型能被屏蔽 ——
add_filter('message_cats', function($cat_type){
    // 将具体类型作为“分类键”加入映射，以便屏蔽列表直接命中
    $cat_type['article']        = array('article');
    $cat_type['article_update'] = array('article_update');
    $cat_type['ueser_login']    = array('ueser_login');
    $cat_type['ueser_update']   = array('ueser_update');
    $cat_type['ueser_reg']      = array('ueser_reg');
    $cat_type['vip']            = array('vip');
    return $cat_type;
}, 10, 1);
