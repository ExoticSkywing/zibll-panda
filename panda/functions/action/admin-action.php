<?php

//屏蔽使用未定义变量的提示和警告
if (panda_pz('error_reporting', false)) {
    ini_set("error_reporting","E_ALL & ~E_NOTICE");//屏蔽未定义变量提示错误
}

//禁用translations_api
if (panda_pz('ban_translations_api', false)) {
    add_filter('translations_api', '__return_true');
}

//禁用翻译更新检查
if(panda_pz('ban_update_translations', false)){
    add_filter('pre_site_transient_update_core', '__return_null');
    add_filter('pre_site_transient_update_plugins', '__return_null');
    add_filter('pre_site_transient_update_themes', '__return_null');
}

//禁用current_screen
if (panda_pz('ban_current_screen', false)) {
    remove_action('current_screen', 'wp_get_current_screen');
}

//禁用wp_check_php_version
if (panda_pz('ban_wp_check_php_version', false)) {
    remove_action('admin_init', 'wp_check_php_version');
}

//禁用wp_check_browser_version
if (panda_pz('ban_wp_check_browser_version', false)) {
    remove_action('admin_init', 'wp_check_browser_version');
}

//移除版本号
if (panda_pz('remove_version', false)) {
    // 头部
    remove_action('wp_head', 'wp_generator');
    //rss
    add_filter('the_generator', '__return_empty_string');
}

//移除加载文件版本号
if (panda_pz('remove_file_version', false)) {
    function removeFileVersion($src)
    {
        if (strpos($src, 'ver=')) {
            $src = remove_query_arg('ver', $src);
        }
        return $src;
    }
    add_filter('style_loader_src', 'removeFileVersion', PHP_INT_MAX);
    add_filter('script_loader_src', 'removeFileVersion', PHP_INT_MAX);
}

//移除文章头部feed
if (panda_pz('remove_post_feed', false)) {
    remove_action('wp_head', 'feed_links', 2);
    remove_action('wp_head', 'feed_links_extra', 3);
}

//移除RSD
if (panda_pz('remove_rsd', false)) {
    remove_action('wp_head', 'rsd_link');
}

//移除wlwmanifest
if (panda_pz('remove_wlwmanifest', false)) {
    remove_action('wp_head', 'wlwmanifest_link');
}

//移除短链接
if (panda_pz('remove_shortlink', false)) {
    remove_action('wp_head', 'wp_shortlink_wp_head', 10);
}

//功能禁用
if (panda_pz('close_rest_api', false)) {
    //屏蔽 REST API
    add_filter('rest_enabled', '__return_false');
    add_filter('rest_jsonp_enabled', '__return_false');
}
if (panda_pz('close_pingback', false)) {
    add_filter('xmlrpc_methods', function ($methods) {
        $methods['pingback.ping'] = '__return_false';
        $methods['pingback.extensions.getPingbacks'] = '__return_false';
        return $methods;
    });
    //禁用 pingbacks, enclosures, trackbacks
    remove_action('do_pings', 'do_all_pings');
    //去掉 _encloseme 和 do_ping 操作。
    remove_action('publish_post', '_publish_post_hook');
}
if (panda_pz('close_xml_rpc', false)) {
    //关闭XML-RPC接口
    add_filter('xmlrpc_enabled', '__return_false');
    add_filter('xmlrpc_methods', '__return_empty_array');
}
if (panda_pz('close_emoji', false)) {
    //禁止emoji
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('embed_head', 'print_emoji_detection_script');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
}
// 关闭保存修订版本
if (panda_pz('close_revision', false)) {
    if (!defined('WP_POST_REVISIONS')) { // 仅当未定义时才定义
        define('WP_POST_REVISIONS', false);
    }
    add_filter('wp_revisions_to_keep', '__return_false'); // 禁用修订版本
}

// 关闭文章自动保存
if (panda_pz('close_auto_save_post', false)) {
    if (!defined('AUTOSAVE_INTERVAL')) { // 仅当未定义时才定义
        define('AUTOSAVE_INTERVAL', false);
    }

    // 禁用自动保存脚本
    add_action('admin_print_scripts', function () {
        wp_deregister_script('autosave'); // 移除自动保存相关的 JavaScript 脚本
    });

    // 禁用后端自动保存
    add_filter('autosave_interval', '__return_false'); // 禁用自动保存的间隔时间
}

if (panda_pz('close_image_height_limit', false)) {//关闭图像高度限制
    add_filter('big_image_size_threshold', '__return_false');
}
if (panda_pz('close_image_creat_size', false)) {//禁止生成多种图像尺寸
    add_filter('intermediate_image_sizes_advanced', function () {
        return [];
    });
    add_filter('big_image_size_threshold', '__return_false');
}
if (panda_pz('close_image_srcset', false)) {//禁止图片设置多种尺寸
    add_filter('wp_calculate_image_srcset', '__return_false');
}
if (panda_pz('close_image_attributes', false)) {//禁止插入图片添加属性
    add_filter('post_thumbnail_html', function ($html) {
        $html = preg_replace('/width="(\d*)"\s+height="(\d*)"\s+class=\"[^\"]*\"/', "", $html);
        $html = preg_replace('/  /', "", $html);

        return $html;
    }, 10);
    add_filter('image_send_to_editor', function ($html) {
        $html = preg_replace('/width="(\d*)"\s+height="(\d*)"\s+class=\"[^\"]*\"/', "", $html);
        $html = preg_replace('/  /', "", $html);
        return $html;
    }, 10);
}
if (panda_pz('close_transcoding', false)) {//关闭字符转码
    add_filter('run_wptexturize', '__return_false');
}
if (panda_pz('close_auto_embeds', false)) {//禁止Auto Embeds
    remove_filter('the_content', array($GLOBALS['wp_embed'], 'autoembed'), 8);
}
if (panda_pz('close_post_embeds', false)) {//禁止文章Embeds
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    remove_action('wp_head', 'wp_oembed_add_host_js');
}

if (panda_pz('restore_widget_gutenberg', false)) {//禁止小工具区块编辑器
    add_filter('gutenberg_use_widgets_block_editor', '__return_false');
    add_filter('use_widgets_block_editor', '__return_false');
}
if (panda_pz('close_core_update', false)) {//关闭WordPress核心更新
    // 彻底关闭自动更新
    add_filter('automatic_updater_disabled', '__return_true');
    // 关闭更新检查定时作业
    remove_action('init', 'wp_schedule_update_checks');
    //  移除已有的版本检查定时作业
    wp_clear_scheduled_hook('wp_version_check');
    // 移除已有的自动更新定时作业
    wp_clear_scheduled_hook('wp_maybe_auto_update');
    // 移除后台内核更新检查
    remove_action('admin_init', '_maybe_update_core');
    add_filter('pre_site_transient_update_core', function ($a) {
        return null;
    });
}
if (panda_pz('close_theme_update', false)) {//关闭主题自动更新
    wp_clear_scheduled_hook('wp_update_themes');
    add_filter('auto_update_theme', '__return_false');
    remove_action('load-themes.php', 'wp_update_themes');
    remove_action('load-update.php', 'wp_update_themes');
    remove_action('load-update-core.php', 'wp_update_themes');
    remove_action('admin_init', '_maybe_update_themes');
    add_filter('pre_set_site_transient_update_themes', function ($a) {
        return null;
    });
}
if (panda_pz('close_plugin_update', false)) {//关闭插件自动更新
    wp_clear_scheduled_hook('wp_update_plugins');
    add_filter('auto_update_plugin', '__return_false');
    add_filter('pre_site_transient_update_plugins', function ($a) {
        return null;
    });
    remove_action('load-plugins.php', 'wp_update_plugins');
    remove_action('load-update.php', 'wp_update_plugins');
    remove_action('load-update-core.php', 'wp_update_plugins');
    remove_action('admin_init', '_maybe_update_plugins');
}
if (panda_pz('close_mail_update_user_info_note', false)) {//关闭用户信息邮件通知
    add_filter('send_password_change_email', '__return_false');
    add_filter('email_change_email', '__return_false');
    if (!function_exists('wp_password_change_notification')) {
        function wp_password_change_notification($user)
        {
            return null;
        }
    }
}
if (panda_pz('close_mail_register_note', false)) {//关闭注册邮件通知
    add_filter('wp_new_user_notification_email_admin', '__return_false');
    add_filter('wp_new_user_notification_email', '__return_false');
}
if (panda_pz('close_email_check', false)) {//屏蔽定期邮箱验证
    add_filter('admin_email_check_interval', '__return_false');
}



//关闭后台登录页面logo
if (panda_pz('remove_login_logo', false)) {
    add_action('login_footer', function () {
        ?>
        <script>
            window.addEventListener('load', function () {
                // 所有资源加载完成后的处理逻辑
                jQuery('#login>h1:first-child').remove();
            });
        </script>
        <?php
    });
}

//关闭前台顶部管理工具条
if (panda_pz('close_admin_bar', false)) {
    add_filter('show_admin_bar', '__return_false');
}

//关闭登录页面语言选择
if (panda_pz('close_login_translate', false)) {
    add_filter('login_display_language_dropdown', '__return_false');
}

//关闭仪表盘左上角WordPress的icon
if (panda_pz('remove_dashboard_icon', false)) {
    add_action('wp_before_admin_bar_render', function () {
        global $wp_admin_bar;

        $wp_admin_bar->remove_menu('wp-logo');
    }, 0);
}

//关闭仪表盘左上角WordPress的icon
if (panda_pz('remove_dashboard_content', false)) {
    function wml_remove_dashboard_content() {
        global $wp_meta_boxes;
        // 以下这一行代码将删除 "快速发布" 模块
        unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
        // 以下这一行代码将删除 "引入链接" 模块
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
        // 以下这一行代码将删除 "插件" 模块
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
        // 以下这一行代码将删除 "近期评论" 模块
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
        // 以下这一行代码将删除 "近期草稿" 模块
        unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
        // 以下这一行代码将删除 "WordPress 开发日志" 模块
        unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
        // 以下这一行代码将删除 "其它 WordPress 新闻" 模块
        unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
        // 以下这一行代码将删除 "概况" 模块
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
        // 以下这一行代码将删除 "概况" 模块
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_site_health']);
        // 以下这一行代码将删除 "动态" 模块
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
        // 以下这一行代码将删除 "Redis" 模块
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_rediscache']);
        // 以下这一行代码将删除 "WPJAM" 模块
        unset($wp_meta_boxes['dashboard']['normal']['core']['column4-sortables']);
    } 
    add_action('wp_dashboard_setup', 'wml_remove_dashboard_content' );
}

//移除后台选项按钮
if (panda_pz('remove_houtai_xuanxiang', false)) {
    add_action('in_admin_header', function(){
        add_filter('screen_options_show_screen', '__return_false');
        add_filter('hidden_columns', '__return_empty_array');
    });
}

//移除后台帮助按钮
if (panda_pz('remove_houtai_bangzhu', false)) {
    add_action('in_admin_header', function(){
        global $current_screen;
        $current_screen->remove_help_tabs();
    });
}

//移除后台右下角版本号
if (panda_pz('remove_houtai_banbenhao', false)) {
    function change_footer_admin () {return '';}
    add_filter('admin_footer_text', 'change_footer_admin', 9999);
    function change_footer_version() {return '';}
    add_filter( 'update_footer', 'change_footer_version', 9999);
}

//移除感谢您使用wordpress创作
if (panda_pz('remove_houtai_ganxiesy', false)) {
    function my_admin_footer_text(){
        return "";
        }
        function my_update_footer()
        {
        return "";
        }
    add_filter( 'admin_footer_text', 'my_admin_footer_text', 99999999 );
    add_filter( 'update_footer', 'my_update_footer', 99999999 );
}



// 禁止Wordpress自动生成略缩图
if (panda_pz('suoluetu',false)) {
    function suoluetu( $sizes ){
        unset( $sizes[ 'thumbnail' ]);
        unset( $sizes[ 'medium' ]);
        unset( $sizes[ 'medium_large' ] );
        unset( $sizes[ 'large' ]);
        unset( $sizes[ 'full' ] );
        unset( $sizes['1536x1536'] );
        unset( $sizes['2048x2048'] );
        return $sizes;
    }add_filter( 'intermediate_image_sizes_advanced', 'suoluetu' );
}

/* 清空仪表盘上面所有区块 */
if (panda_pz('qingkong_yibiaopan_neirong',true)) {  
    function example_remove_dashboard_widgets() {
       global $wp_meta_boxes;
       // 以下这一行代码将删除 "快速发布" 模块
       unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
       // 以下这一行代码将删除 "引入链接" 模块
       unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
       // 以下这一行代码将删除 "插件" 模块
       unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
       // 以下这一行代码将删除 "近期评论" 模块
       unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
       // 以下这一行代码将删除 "近期草稿" 模块
       unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
       // 以下这一行代码将删除 "WordPress 开发日志" 模块
       unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
       // 以下这一行代码将删除 "其它 WordPress 新闻" 模块
       unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
       // 以下这一行代码将删除 "概况" 模块
       unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
       // 以下这一行代码将删除 "概况" 模块
       unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_site_health']);
       // 以下这一行代码将删除 "动态" 模块
       unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
       // 以下这一行代码将删除 "Redis" 模块
       unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_rediscache']);
       // 以下这一行代码将删除 "WPJAM" 模块
       unset($wp_meta_boxes['dashboard']['normal']['core']['column4-sortables']);
} add_action('wp_dashboard_setup', 'example_remove_dashboard_widgets' );}

/* 移除后台界面右上角的选项 */
if (panda_pz('yichu_houtai_xuanxiang',false)) {
    add_action('in_admin_header', function(){
    add_filter('screen_options_show_screen', '__return_false');
    add_filter('hidden_columns', '__return_empty_array');
});}

/* 移除后台界面右上角的帮助 */
if (panda_pz('yichu_houtai_bangzhu',false)) {
    add_action('in_admin_header', function(){
    global $current_screen;
    $current_screen->remove_help_tabs();
});}


/* 移除后台界面右下角的版本号 */
if (panda_pz('yichu_houtai_banbenhao',false)) {
    function change_footer_admin () {return '';}
    add_filter('admin_footer_text', 'change_footer_admin', 9999);
    function change_footer_version() {return '';}
    add_filter( 'update_footer', 'change_footer_version', 9999);
}

/* 移除后台无用的菜单 */
if (panda_pz('yichu_houtai_caidan_yibiaopan',false)) {
    add_action( 'admin_menu', function(){
    remove_menu_page( 'index.php' ); //仪表盘
});}
if (panda_pz('yichu_houtai_caidan_duomeiti',false)) {
    add_action( 'admin_menu', function(){
    remove_menu_page( 'upload.php' ); //多媒体
});}
if (panda_pz('yichu_houtai_caidan_yemian',false)) {
    add_action( 'admin_menu', function(){
    remove_menu_page( 'edit.php?post_type=page' ); //页面
});}
if (panda_pz('yichu_houtai_caidan_pinglun',false)) {
    add_action( 'admin_menu', function(){
    remove_menu_page( 'edit-comments.php' ); //评论
});}
if (panda_pz('yichu_houtai_caidan_lianjie',false)) {
    add_action( 'admin_menu', function(){
    remove_menu_page( 'link-manager.php' ); //链接
});}
if (panda_pz('yichu_houtai_caidan_chajian',false)) {
    add_action( 'admin_menu', function(){
    remove_menu_page( 'plugins.php' ); //插件
});}
if (panda_pz('yichu_houtai_caidan_waiguan',false)) {
    add_action( 'admin_menu', function(){
    remove_menu_page( 'themes.php' ); //外观
});}
if (panda_pz('yichu_houtai_caidan_yonghu',false)) {
    add_action( 'admin_menu', function(){
    remove_menu_page( 'users.php' ); //用户
});}
if (panda_pz('yichu_houtai_caidan_gongju',false)) {
    add_action( 'admin_menu', function(){
    remove_menu_page( 'tools.php' ); //工具
});}
if (panda_pz('yichu_houtai_caidan_shezhi',false)) {
    add_action( 'admin_menu', function(){
    remove_menu_page( 'options-general.php' ); //设置
});}
if (panda_pz('yichu_zib_pay',false)) {
    add_action( 'admin_menu', function(){
    remove_menu_page( 'zibpay_page' ); //子比商城
});}

/* 去除后台上边引导条 */
if (panda_pz('admin_nav_none',false)) {
    function admin_nav_none() {
        echo '<style>#wpadminbar{display: none;}#wpcontent, #wpfooter{margin-top: -30px;}</style>';
    } add_action('admin_head','admin_nav_none');
}

/* 安全模式 */
if (panda_pz('anquanmoshi',false)) {
    /* 禁止主题插件编辑 */
    define('DISALLOW_FILE_EDIT', true);
    /* 禁止后台主题插件上传安装 */
    define('DISALLOW_FILE_MODS',true);
}

/* 移除Wordpress后台感谢使用wordpress创作 */
if (panda_pz('gx_cz',false)) {
    function my_admin_footer_text(){
        return "";
        }
        function my_update_footer()
        {
        return "";
        }
    add_filter( 'admin_footer_text', 'my_admin_footer_text', 99999999 );
    add_filter( 'update_footer', 'my_update_footer', 99999999 );
}

// 后台&美化
if(panda_pz('admins_switch')){
    switch (panda_pz('admins_select')){
        case '1':
            // 引入样式文件
            function admin_style() {
                $styles = '';
                $color = '';
                if (panda_pz('theme_skin')) {
                    $color = panda_pz('theme_skin');
                }

                if (panda_pz('theme_skin_custom')) {
                    $color = substr(panda_pz('theme_skin_custom'), 1);
                }

                $shadow   = '';
                $opacity1 = '';
                if ($color) {
                    $shadow   = hex_to_rgba('#' . $color, '.4');
                    $opacity1 = hex_to_rgba('#' . $color, '.1');
                }

                $var = '';
                $var .= $color ? '--theme-color:#' . $color . ' !important;' : '';
                $var .= $shadow ? '--focus-shadow-color:' . $shadow . ' !important;' : '';
                $var .= $opacity1 ? '--focus-color-opacity1:' . $opacity1 . ' !important;' : '';

                $mian_r = panda_pz('theme_main_radius', 8);
                if (8 != $mian_r) {
                    $var .= '--main-radius:' . $mian_r . 'px !important;';
                }
                $styles .= 'body{' . $var . '}';
                
                if (panda_pz('dark_theme_skin_custom')) {
                    $color = substr(panda_pz('dark_theme_skin_custom'), 1);

                    $shadow   = '';
                    $opacity1 = '';
                    if ($color) {
                        $shadow   = hex_to_rgba('#' . $color, '.4');
                        $opacity1 = hex_to_rgba('#' . $color, '.1');
                    }

                    $dark_var = '';
                    $dark_var .= $color ? '--theme-color:#' . $color . ';' : '';
                    $dark_var .= $shadow ? '--focus-shadow-color:' . $shadow . ';' : '';
                    $dark_var .= $opacity1 ? '--focus-color-opacity1:' . $opacity1 . ';' : '';

                    $styles .= 'body.dark-theme{' . $dark_var . '}';
                }

                //全局背景图片
                $theme_img_bg = panda_pz('theme_img_bg');
                if (!empty($theme_img_bg['background-image'])) {
                    $styles .= 'body{
                        background-image: url("' . $theme_img_bg['background-image'] . '") !important;
                        ' . ($theme_img_bg['background-position'] ? 'background-position: ' . $theme_img_bg['background-position'] . ' !important;' : '') . '
                        ' . ($theme_img_bg['background-repeat'] ? 'background-repeat: ' . $theme_img_bg['background-repeat'] . ' !important;' : '') . '
                        ' . ($theme_img_bg['background-attachment'] ? 'background-attachment: ' . $theme_img_bg['background-attachment'] . ' !important;' : '') . '
                        ' . ($theme_img_bg['background-size'] ? 'background-size: ' . $theme_img_bg['background-size'] . ' !important;' : '') . '
                        ' . ($theme_img_bg['background-origin'] ? 'background-origin: ' . $theme_img_bg['background-origin'] . ' !important;' : '') . '
                    }';
                }

                $theme_img_bg = panda_pz('dark_theme_img_bg');
                if (!empty($theme_img_bg['background-image'])) {
                    $styles .= '.dark-theme{
                        background-image: url("' . $theme_img_bg['background-image'] . '");
                        ' . ($theme_img_bg['background-position'] ? 'background-position: ' . $theme_img_bg['background-position'] . ';' : '') . '
                        ' . ($theme_img_bg['background-repeat'] ? 'background-repeat: ' . $theme_img_bg['background-repeat'] . ';' : '') . '
                        ' . ($theme_img_bg['background-attachment'] ? 'background-attachment: ' . $theme_img_bg['background-attachment'] . ';' : '') . '
                        ' . ($theme_img_bg['background-size'] ? 'background-size: ' . $theme_img_bg['background-size'] . ';' : '') . '
                        ' . ($theme_img_bg['background-origin'] ? 'background-origin: ' . $theme_img_bg['background-origin'] . ';' : '') . '
                    }';
                }

                if ($styles) {
                    echo '<style>' . $styles . '</style>';
                    echo zib_admin_qj_dh_css();
                    echo zib_admin_qj_dh_nr();
                }
                $static_panda_url = panda_pz('static_panda');
                wp_enqueue_style('zib_admin_style', $static_panda_url . '/assets/others/admin/style_1/admin_style.css', array(), panda_version());
                wp_enqueue_script('zib_admin_scripts', $static_panda_url . '/assets/others/admin/style_1/script.js', array('jquery'), panda_version());
            }
            add_action('admin_enqueue_scripts', 'admin_style');

            // 引入前台样式文件
            function zib_admin_style() {
                $static_panda_url = panda_pz('static_panda');
                wp_enqueue_style('zib_admin_style', $static_panda_url . '/assets/others/admin/style_1/zib_admin_style.css', array(), panda_version());
            }
            add_action('wp_enqueue_scripts', 'zib_admin_style');
            break;
        case '2':
            require_once 'style_2/admin-theme.php';
            break;
        case '3':
            require_once 'style_3/admin-theme.php';
            break;
        case '4':
            require_once 'style_4/admin-theme.php';
            break;
    }
}


//全局loading动画
function zib_admin_qj_dh_nr()
{
    //蜘蛛爬虫则不显示

    if (zib_is_crawler()) {
        return;
    }

    $dh_nr = '';

    if (panda_pz('qj_dh_xs') == 'no2') {
        $dh_nr = '<div class="qjdh_no2"></div>';
    } elseif (panda_pz('qj_dh_xs') == 'no3') {
        $dh_nr = '<div class="qjdh_no3"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>';
    } elseif (panda_pz('qj_dh_xs') == 'no4') {
        $dh_nr = '<div class="qjdh_no4"></div>';
    } elseif (panda_pz('qj_dh_xs') == 'no5') {
        $dh_nr = '<div class="qjdh_no5"><div></div><div></div><div></div></div>';
    } elseif (panda_pz('qj_dh_xs') == 'no6') {
        $dh_nr = '<div class="qjdh_no6"><div></div><div></div><div></div></div>';
    } elseif (panda_pz('qj_dh_xs') == 'no7') {
        $dh_nr = '<div class="qjdh_no7"></div>';
    } elseif (panda_pz('qj_dh_xs') == 'no8') {
        $dh_nr = '<div class="qjdh_no8"><div></div><div></div><div></div><div></div></div>';
    } elseif (panda_pz('qj_dh_xs') == 'no9') {
        $dh_nr = '<div class="qjdh_no9"><div></div><div></div><div></div><div></div><div></div></div>';
    } elseif (panda_pz('qj_dh_xs') == 'no10') {
        $dh_nr = '<div class="qjdh_no10"><div></div><div></div><div></div></div>';
    }

    if (panda_pz('qj_loading')) {
        return '<div class="qjl qj_loading" style="position: fixed;background:var(--main-bg-color);width: 100%;margin-top:-150px;height:300%;z-index: 99999999"><div style="position:fixed;top:0;left:0;bottom:0;right:0;display:flex;align-items:center;justify-content:center">' . $dh_nr . '</div></div>';
    }
};
function zib_admin_qj_dh_css()
{
    //蜘蛛爬虫则不显示
    if (zib_is_crawler()) {
        return;
    }

    if (panda_pz('qj_dh_xs') == 'no2') {
        $dh_css = '.qjdh_no2{width:50px;height:50px;border:5px solid transparent;border-radius:50%;border-top-color:#2aab69;border-bottom-color:#2aab69;animation:huan-rotate 1s cubic-bezier(0.7, 0.1, 0.31, 0.9) infinite}@keyframes huan-rotate{0%{transform:rotate(0)}to{transform:rotate(360deg)}}';
    } elseif (panda_pz('qj_dh_xs') == 'no3') {
        $dh_css = '.qjdh_no3{position:relative;top:-10px;left:-4px;transform:scale(1)}.qjdh_no3>div:nth-child(1){top:20px;left:0;-webkit-animation:line-spin-fade-loader 1.2s -.84s infinite ease-in-out;animation:line-spin-fade-loader 1.2s -.84s infinite ease-in-out}.qjdh_no3>div:nth-child(2){top:13.64px;left:13.64px;-webkit-transform:rotate(-45deg);transform:rotate(-45deg);-webkit-animation:line-spin-fade-loader 1.2s -.72s infinite ease-in-out;animation:line-spin-fade-loader 1.2s -.72s infinite ease-in-out}.qjdh_no3>div:nth-child(3){top:0;left:20px;-webkit-transform:rotate(90deg);transform:rotate(90deg);-webkit-animation:line-spin-fade-loader 1.2s -.6s infinite ease-in-out;animation:line-spin-fade-loader 1.2s -.6s infinite ease-in-out}.qjdh_no3>div:nth-child(4){top:-13.64px;left:13.64px;-webkit-transform:rotate(45deg);transform:rotate(45deg);-webkit-animation:line-spin-fade-loader 1.2s -.48s infinite ease-in-out;animation:line-spin-fade-loader 1.2s -.48s infinite ease-in-out}.qjdh_no3>div:nth-child(5){top:-20px;left:0;-webkit-animation:line-spin-fade-loader 1.2s -.36s infinite ease-in-out;animation:line-spin-fade-loader 1.2s -.36s infinite ease-in-out}.qjdh_no3>div:nth-child(6){top:-13.64px;left:-13.64px;-webkit-transform:rotate(-45deg);transform:rotate(-45deg);-webkit-animation:line-spin-fade-loader 1.2s -.24s infinite ease-in-out;animation:line-spin-fade-loader 1.2s -.24s infinite ease-in-out}.qjdh_no3>div:nth-child(7){top:0;left:-20px;-webkit-transform:rotate(90deg);transform:rotate(90deg);-webkit-animation:line-spin-fade-loader 1.2s -.12s infinite ease-in-out;animation:line-spin-fade-loader 1.2s -.12s infinite ease-in-out}.qjdh_no3>div:nth-child(8){top:13.64px;left:-13.64px;-webkit-transform:rotate(45deg);transform:rotate(45deg);-webkit-animation:line-spin-fade-loader 1.2s 0s infinite ease-in-out;animation:line-spin-fade-loader 1.2s 0s infinite ease-in-out}.qjdh_no3>div{position:absolute;margin:2px;width:4px;width:5px;height:35px;height:15px;border-radius:2px;background-color:#1487ff;-webkit-animation-fill-mode:both;animation-fill-mode:both}@-webkit-keyframes line-spin-fade-loader{50%{opacity:.3}to{opacity:1}}@keyframes line-spin-fade-loader{50%{opacity:.3}to{opacity:1}}';
    } elseif (panda_pz('qj_dh_xs') == 'no4') {
        $dh_css = '.qjdh_no4{width:50px;height:50px;background-color:#1b96b9;-webkit-animation:rotateplane 1s infinite ease-in-out;animation:rotateplane 1s infinite ease-in-out}@-webkit-keyframes rotateplane{0%{-webkit-transform:perspective(120px)}50%{-webkit-transform:perspective(120px) rotateY(180deg)}to{-webkit-transform:perspective(120px) rotateY(180deg) rotateX(180deg)}}@keyframes rotateplane{0%{transform:perspective(120px) rotateX(0deg) rotateY(0deg);-webkit-transform:perspective(120px) rotateX(0deg) rotateY(0deg)}50%{transform:perspective(120px) rotateX(-180.1deg) rotateY(0deg);-webkit-transform:perspective(120px) rotateX(-180.1deg) rotateY(0deg)}to{transform:perspective(120px) rotateX(-180deg) rotateY(-179.9deg);-webkit-transform:perspective(120px) rotateX(-180deg) rotateY(-179.9deg)}}';
    } elseif (panda_pz('qj_dh_xs') == 'no5') {
        $dh_css = '.qjdh_no5{transform:scale(1)}.qjdh_no5>div:nth-child(1){-webkit-animation:ball-pulse-sync .6s -.14s infinite ease-in-out;animation:ball-pulse-sync .6s -.14s infinite ease-in-out}.qjdh_no5>div:nth-child(2){-webkit-animation:ball-pulse-sync .6s -70ms infinite ease-in-out;animation:ball-pulse-sync .6s -70ms infinite ease-in-out}.qjdh_no5>div:nth-child(3){-webkit-animation:ball-pulse-sync .6s 0s infinite ease-in-out;animation:ball-pulse-sync .6s 0s infinite ease-in-out}.qjdh_no5>div{background-color:#ec6a21;width:15px;height:15px;border-radius:100%;margin:4px;-webkit-animation-fill-mode:both;animation-fill-mode:both;display:inline-block}@keyframes ball-pulse-sync{33%{-webkit-transform:translateY(10px);transform:translateY(10px)}66%{-webkit-transform:translateY(-10px);transform:translateY(-10px)}to{-webkit-transform:translateY(0);transform:translateY(0)}}';
    } elseif (panda_pz('qj_dh_xs') == 'no6') {
        $dh_css = '.qjdh_no6{transform:scale(1) translateY(-30px)}.qjdh_no6>div:nth-child(2){-webkit-animation-delay:-.4s;animation-delay:-.4s}.qjdh_no6>div:nth-child(3){-webkit-animation-delay:-.2s;animation-delay:-.2s}.qjdh_no6>div{position:absolute;top:0;left:-30px;margin:2px;margin:0;width:15px;width:60px;height:15px;height:60px;border-radius:100%;background-color:#ff3cb2;opacity:0;-webkit-animation-fill-mode:both;animation-fill-mode:both;-webkit-animation:ball-scale-multiple 1s 0s linear infinite;animation:ball-scale-multiple 1s 0s linear infinite}@-webkit-keyframes ball-scale-multiple{0%{opacity:0;-webkit-transform:scale(0);transform:scale(0)}5%{opacity:1}to{-webkit-transform:scale(1);transform:scale(1)}}@keyframes ball-scale-multiple{0%,to{opacity:0}0%{-webkit-transform:scale(0);transform:scale(0)}5%{opacity:1}to{opacity:0;-webkit-transform:scale(1);transform:scale(1)}}';
    } elseif (panda_pz('qj_dh_xs') == 'no7') {
        $dh_css = '.qjdh_no7{position:absolute;top:0;right:0;bottom:0;left:0;margin:auto;width:50px;height:50px}.qjdh_no7:before{top:59px;height:5px;border-radius:50%;background:#000;opacity:.1;animation:box-loading-shadow .5s linear infinite}.qjdh_no7:after,.qjdh_no7:before{position:absolute;left:0;width:50px;content:""}.qjdh_no7:after{top:0;height:50px;border-radius:3px;background:#15c574;animation:box-loading-animate .5s linear infinite}@keyframes box-loading-animate{17%{border-bottom-right-radius:3px}25%{transform:translateY(9px) rotate(22.5deg)}50%{border-bottom-right-radius:40px;transform:translateY(18px) scale(1,.9) rotate(45deg)}75%{transform:translateY(9px) rotate(67.5deg)}to{transform:translateY(0) rotate(90deg)}}@keyframes box-loading-shadow{0%,to{transform:scale(1,1)}50%{transform:scale(1.2,1)}}';
    } elseif (panda_pz('qj_dh_xs') == 'no8') {
        $dh_css = '.qjdh_no8{height:50px;width:50px;-webkit-transform:rotate(45deg);transform:rotate(45deg);-webkit-animation:l_xx 1.5s infinite;animation:l_xx 1.5s infinite}.qjdh_no8>div{width:25px;height:25px;background-color:#f54a71;float:left}.qjdh_no8>div:nth-child(1){-webkit-animation:o_one 1.5s infinite;animation:o_one 1.5s infinite}.qjdh_no8>div:nth-child(2){-webkit-animation:o_two 1.5s infinite;animation:o_two 1.5s infinite}.qjdh_no8>div:nth-child(3){-webkit-animation:o_three 1.5s infinite;animation:o_three 1.5s infinite}.qjdh_no8>div:nth-child(4){-webkit-animation:o_four 1.5s infinite;animation:o_four 1.5s infinite}@-webkit-keyframes l_xx{to{-webkit-transform:rotate(-45deg)}}@-webkit-keyframes o_one{30%{-webkit-transform:translate(0,-50px) rotate(-180deg)}to{-webkit-transform:translate(0,0) rotate(-180deg)}}@keyframes o_one{30%{transform:translate(0,-50px) rotate(-180deg);-webkit-transform:translate(0,-50px) rotate(-180deg)}to{transform:translate(0,0) rotate(-180deg);-webkit-transform:translate(0,0) rotate(-180deg)}}@-webkit-keyframes o_two{30%{-webkit-transform:translate(50px,0) rotate(-180deg)}to{-webkit-transform:translate(0,0) rotate(-180deg)}}@keyframes o_two{30%{transform:translate(50px,0) rotate(-180deg);-webkit-transform:translate(50px,0) rotate(-180deg)}to{transform:translate(0,0) rotate(-180deg);-webkit-transform:translate(0,0) rotate(-180deg)}}@-webkit-keyframes o_three{30%{-webkit-transform:translate(-50px,0) rotate(-180deg)}to{-webkit-transform:translate(0,0) rotate(-180deg)}}@keyframes o_three{30%{transform:translate(-50px,0) rotate(-180deg);-webkit-transform:translate(-50px,0) rotate(-180deg)}to{transform:translate(0,0) rotate(-180deg);-webkit-transform:rtranslate(0,0) rotate(-180deg)}}@-webkit-keyframes o_four{30%{-webkit-transform:translate(0,50px) rotate(-180deg)}to{-webkit-transform:translate(0,0) rotate(-180deg)}}@keyframes o_four{30%{transform:translate(0,50px) rotate(-180deg);-webkit-transform:translate(0,50px) rotate(-180deg)}to{transform:translate(0,0) rotate(-180deg);-webkit-transform:translate(0,0) rotate(-180deg)}}';
    } elseif (panda_pz('qj_dh_xs') == 'no9') {
        $dh_css = '.qjdh_no9{transform:scale(1)}.qjdh_no9>div{display:inline-block;margin:5px;width:4px;height:35px;border-radius:2px;background-color:#11d4c5;-webkit-animation-fill-mode:both;animation-fill-mode:both;-webkit-animation:line-scale-pulse-out .9s -.6s infinite cubic-bezier(.85,.25,.37,.85);animation:line-scale-pulse-out .9s -.6s infinite cubic-bezier(.85,.25,.37,.85)}.qjdh_no9>div:nth-child(2),.qjdh_no9>div:nth-child(4){-webkit-animation-delay:-.4s!important;animation-delay:-.4s!important}.qjdh_no9>div:nth-child(1),.qjdh_no9>div:nth-child(5){-webkit-animation-delay:-.2s!important;animation-delay:-.2s!important}@-webkit-keyframes line-scale-pulse-out{0%{-webkit-transform:scaley(1);transform:scaley(1)}50%{-webkit-transform:scaley(.4);transform:scaley(.4)}}@keyframes line-scale-pulse-out{0%,to{-webkit-transform:scaley(1);transform:scaley(1)}50%{-webkit-transform:scaley(.4);transform:scaley(.4)}to{-webkit-transform:scaley(1);transform:scaley(1)}}';
    } elseif (panda_pz('qj_dh_xs') == 'no10') {
        $dh_css = '.qjdh_no10{position:relative;transform:translate(-29.99px,-37.51px)}.qjdh_no10>div:nth-child(1){animation-name:ql-1}.qjdh_no10>div:nth-child(1),.qjdh_no10>div:nth-child(2){animation-delay:0;animation-duration:2s;animation-timing-function:ease-in-out;animation-iteration-count:infinite}.qjdh_no10>div:nth-child(2){animation-name:ql-2}.qjdh_no10>div:nth-child(3){animation-name:ql-3;animation-delay:0;animation-duration:2s;animation-timing-function:ease-in-out;animation-iteration-count:infinite}.qjdh_no10>div{position: absolute;width:18px;height:18px;border-radius:100%;background:#ff00a3}.qjdh_no10>div:nth-of-type(1){top:50px}.qjdh_no10>div:nth-of-type(2){left:25px}.qjdh_no10>div:nth-of-type(3){top:50px;left:50px}@keyframes ql-1{33%{transform:translate(25px,-50px)}66%{transform:translate(50px,0)}to{transform:translate(0,0)}}@keyframes ql-2{33%{transform:translate(25px,50px)}66%{transform:translate(-25px,50px)}to{transform:translate(0,0)}}@keyframes ql-3{33%{transform:translate(-50px,0)}66%{transform:translate(-25px,-50px)}to{transform:translate(0,0)}}';
    }

    if (panda_pz('qj_loading') && panda_pz('qj_dh_xs') && panda_pz('qj_dh_xs') != 'no1') {
        return '<style type="text/css" id="qj_dh_css">' . $dh_css . '</style>';
    }

    return;
};

//日夜间切换
function add_theme_toggle_button_to_admin_bar() {
    // 创建日夜间切换按钮的 HTML
    $toggle_button_html = '<a href="javascript:;" id="theme-toggle-btn" class="ab-item" aria-label="切换主题"><span class="ab-icon"><svg t="1728700650459" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="1658" width="30" height="30"><path d="M507.1872 520.96m-450.816 0a450.816 450.816 0 1 0 901.632 0 450.816 450.816 0 1 0-901.632 0Z" fill="#E9ECFF" p-id="1659"></path><path d="M503.9104 200.0896c-2.304 0-4.608 0-6.912 0.0512-11.4688 0.256-15.6672 15.4624-5.7344 21.248 66.3552 38.7072 109.568 112.7936 103.7312 196.4032-7.2192 103.6288-91.2384 187.4944-194.8672 194.4576-83.968 5.6832-158.208-38.0416-196.6592-104.96-5.7344-9.984-20.9408-5.7856-21.248 5.6832-0.1024 2.9696-0.1024 5.9392-0.1024 8.9088 0 182.784 152.3712 329.984 336.9984 321.4848 164.864-7.5776 298.7008-141.4144 306.2784-306.2784 8.448-184.576-138.7008-336.9984-321.4848-336.9984z" fill="#6C6CEA" p-id="1660"></path><path d="M361.5744 476.16m-50.2272 0a50.2272 50.2272 0 1 0 100.4544 0 50.2272 50.2272 0 1 0-100.4544 0Z" fill="#8D92F8" p-id="1661"></path><path d="M503.9104 200.0896c-2.304 0-4.608 0-6.912 0.0512-11.4688 0.256-15.6672 15.4624-5.7344 21.248 66.3552 38.7072 109.568 112.7424 103.7312 196.4032-7.2192 103.6288-91.2384 187.4944-194.8672 194.4576-83.968 5.6832-158.208-38.0416-196.6592-104.96-5.7344-9.984-20.9408-5.7856-21.248 5.6832-0.1024 2.9696-0.1024 5.9392-0.1024 8.9088 0 107.4176 52.6848 202.5472 133.5808 260.9664a366.65344 366.65344 0 0 0 108.1856 16.2304c202.9568 0 367.5136-164.5568 367.5136-367.5136 0-22.4256-2.0992-44.3392-5.9392-65.6384-54.9888-98.816-160.4096-165.8368-281.5488-165.8368z" fill="#757BF2" p-id="1662"></path><path d="M496.9984 200.192c-11.4688 0.256-15.6672 15.4624-5.7344 21.248 66.3552 38.7072 109.568 112.7424 103.7312 196.4032-7.2192 103.6288-91.2384 187.4944-194.8672 194.4576-83.968 5.6832-158.208-38.0416-196.6592-104.96-5.7344-9.984-20.9408-5.7856-21.248 5.6832-0.1024 2.9696-0.1024 5.9392-0.1024 8.9088 0 50.176 11.5712 97.6896 32.0512 140.032a366.80192 366.80192 0 0 0 111.616 17.3056c202.9568 0 367.5136-164.5568 367.5136-367.5136 0-17.92-1.3312-35.5328-3.84-52.7872-52.4288-37.0688-116.4288-58.8288-185.4976-58.8288-2.3552-0.0512-4.6592 0-6.9632 0.0512z" fill="#8486F8" p-id="1663"></path><path d="M203.4688 507.3408c-5.7344-9.984-20.9408-5.7856-21.248 5.6832-0.1024 2.9696-0.1024 5.9392-0.1024 8.9088 0 10.5472 0.5632 20.992 1.536 31.2832 16.2304 2.2016 32.8192 3.4304 49.664 3.4304 3.1232 0 6.1952-0.1536 9.2672-0.256-15.36-14.2848-28.6208-30.7712-39.1168-49.0496zM503.9104 200.0896c-2.304 0-4.608 0-6.912 0.0512-11.4688 0.256-15.6672 15.4624-5.7344 21.248a210.49344 210.49344 0 0 1 86.272 96.4608 367.1552 367.1552 0 0 0 22.272-103.168 322.62144 322.62144 0 0 0-95.8976-14.592z" fill="#8D92F8" p-id="1664"></path></svg></span></a>';

    // 将日夜间切换按钮添加到顶部工具栏
    global $wp_admin_bar;
    $wp_admin_bar->add_menu(
        array(
            'id' => 'theme_toggle_button',
            'title' => $toggle_button_html,
            'href' => '#',
            'parent' => null,
            'meta' => array(
                'class' => 'ab-item',
                'aria-label' => '切换主题',
            ),
        )
    );
}
if(panda_pz('admins_switch') && panda_pz('admins_select') == '1'){
    add_action('admin_bar_menu', 'add_theme_toggle_button_to_admin_bar', 10, 3);
}