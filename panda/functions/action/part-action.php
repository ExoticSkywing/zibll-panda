<?php

/* LOGO扫光 */
if (panda_pz('logo_scan')) {
    function logo_scan() { 
        echo '<style>.navbar-brand{position:relative;overflow:hidden;margin: 0px 0 0 0px;}.navbar-brand:before{content:""; position: absolute; left: -665px; top: -460px; width: 200px; height: 15px; background-color: rgba(255,255,255,.5); -webkit-transform: rotate(-45deg); -moz-transform: rotate(-45deg); -ms-transform: rotate(-45deg); -o-transform: rotate(-45deg); transform: rotate(-45deg); -webkit-animation: searchLights 6s ease-in 0s infinite; -o-animation: searchLights 6s ease-in 0s infinite; animation: searchLights 6s ease-in 0s infinite;}@-moz-keyframes searchLights{50%{left: -100px; top: 0;} 65%{left: 120px; top: 100px;}}@keyframes searchLights{40%{left: -100px; top: 0;} 60%{left: 120px; top: 100px;} 80%{left: -100px; top: 0px;}}</style>';
    } add_action('wp_head', 'logo_scan');
}

/* logo透明过渡美化样式 */
if (panda_pz('logo_transition')) {
    function logo_transition() { 
        echo '<style>.navbar-brand {position: relative;}.navbar-logo img {position: relative;display: inline-block;animation: logoShine 2s infinite ease-in-out;}@keyframes logoShine {0% {transform: translateX(0);opacity: 1;}40% {transform: translateX(15px);opacity: 0.3;}60% {transform: translateX(15px);opacity: 0.3;}100% {transform: translateX(0);opacity: 1;}}</style>';
    } add_action('wp_head', 'logo_transition');
}

//hue-rotate 色相动画
if (panda_pz('logo1')) {
    function logo1(){?>
        <style>.navbar-logo{animation: hue 4s infinite;}@keyframes hue {from {filter: hue-rotate(0deg);}to {filter: hue-rotate(-360deg);}}</style>
    <?php }add_action('wp_head', 'logo1');
}

//invert 反色
if (panda_pz('logo3')) {
    function logo3(){?>
        <style>.navbar-logo{filter:drop-shadow(0 0 10px dodgerblue);}</style>
    <?php }add_action('wp_head', 'logo3');
}
        
//drop-shadow 阴影
if (panda_pz('logo2')) {
    function logo2(){?>
        <style>.navbar-logo{filter:invert(1);}</style>
    <?php }add_action('wp_head', 'logo2');
}

// 禁用搜索功能
if (panda_pz('nosearch')) {
    function nosearch() {?>
        <script>$(document).ready(function(){$("li.relative").css("display","none")})</script>
<?php }add_action('wp_head', 'nosearch');
}

/* 显示FPS */
if (panda_pz('top_fps')) {
    function top_fps() {?>
        <script>
// FPS帧
$('body').before('');
var showFPS = (function(){
var requestAnimationFrame =
window.requestAnimationFrame ||
window.webkitRequestAnimationFrame ||
window.mozRequestAnimationFrame ||
window.oRequestAnimationFrame ||
window.msRequestAnimationFrame ||
function(callback) {
window.setTimeout(callback, 1000/60);
};
var e,pe,pid,fps,last,offset,step,appendFps;

fps = 0;
last = Date.now();
step = function(){
offset = Date.now() - last;
fps += 1;
if( offset >= 1000 ){
last += offset;
appendFps(fps);
fps = 0;
}
requestAnimationFrame( step );
};
appendFps = function(fps){
console.log(fps+'FPS');
$('#fps').html(fps+'FPS');
};
step();
})();
        </script>
<style>
    #fps {
        position: fixed;
        top: 0;
        left: 0;
        z-index: 99999;
        <?php echo panda_pz('top_fps_style');?>
    }
</style>
<div id="fps"></div>
    <?php } add_action('wp_head', 'top_fps');
}

/* 导航文字加粗 */
if (panda_pz('nav_bold')) {
    function nav_bold() {
        echo '<style>ul.nav {font-weight: bold;}</style>';
    } add_action('wp_head', 'nav_bold');
}

/* 顶部添加彩色进度条 */
if (panda_pz('top_progress_bar')) {
    function top_progress_bar(){?>
        <?php 
        $mobile_cols = panda_pz('panda_footer_stats_mobile_cols', 2);
        if (!is_numeric($mobile_cols)) { $mobile_cols = 2; }
        $mobile_cols = max(1, min(6, intval($mobile_cols)));
        $mobile_basis = 100 / $mobile_cols;

        $desktop_cols = panda_pz('panda_footer_stats_desktop_cols', 5);
        if (!is_numeric($desktop_cols)) { $desktop_cols = 5; }
        $desktop_cols = max(1, min(8, intval($desktop_cols)));
        $desktop_basis = 100 / $desktop_cols;
        ?>
        <style>
        #percentageCounter {
            position:fixed;
            left:0;
            top:0;
            height:3px;
            z-index:99999;
            background-image: linear-gradient(to right, #339933, #FF6666);
            border-radius:5px;
        }
        </style>
        <div id="percentageCounter"></div>
        <script>
        $(document).ready(function() {
            // 进度条加载显示
            $(window).scroll(function() {
                var a = $(window).scrollTop(),
                    c = $(document).height(),
                    b = $(window).height();
                var scrollPercent = a / (c - b) * 100;
                scrollPercent = scrollPercent.toFixed(1);
                $("#percentageCounter").css({
                    width: scrollPercent + "%"
                });
            }).trigger("scroll");
        });
        </script>
        <?php
    }
    add_action('wp_head', 'top_progress_bar');
}

//登录小萝莉
if (panda_pz('login_girl_img')) {
    function login_girl_img(){?>
        <style>
        .sign::before {
            content: '';
            position: absolute;
            top: -144px;
            left: 80px;
            width: 191px;
            height: 187px;
            background: url(<?php echo panda_pz('static_panda');?>/assets/img/loginll.png) no-repeat center / 100%;
        }
        .sign-img {
            padding-right: 50%;
        }
        </style>
    <?php } add_action('wp_head', 'login_girl_img');
}

//下拉菜单半透明
if (panda_pz('top_menu_opacity')) {
    function top_menu_opacity() {?>
        <style>.navbar-top .sub-menu,.theme-popover{background:linear-gradient(135deg,#ffffffb0 35%,#ffffffb0 100%);box-shadow:0px 0px 8px rgba(255,112,173,0.35);backdrop-filter:saturate(5) blur(20px)}</style>
    <?php } add_action('wp_head', 'top_menu_opacity');  
}

//右上角开通会员炫彩色
if (panda_pz('vip_buy_color_style')) {
    function vip_buy_color_style() {?>
        <style>.payvip-icon{color: #ffffff;--this-color: #ffffff;background:linear-gradient(135deg,#ff7faf91 10%,#43b2ff 100%);}.vip-theme1{background:linear-gradient(135deg,#ff7faf91 10%,#43b2ff 100%);}.vip-theme2{background:linear-gradient(43deg,#ff6ac3 0%,#465dff 46%,#72e699 100%);color:#e4e2fb;}</style>
    <?php }add_action('wp_head', 'vip_buy_color_style');
}

// 彩色导航菜单
if(panda_pz('nav_color_style')){
    function nav_color_style(){
        ?>
        <style>
            @media (max-width: 767px){
                .mobile-menus .sub-menu li {
                    background: var(--main-border-color);
                    border-radius: 5px;
                }
            }
            .navbar-top .nav>li>a,.navbar-top .sub-menu li>a,.mobile-menus li a,.mobile-menus .sub-menu li>a{background:linear-gradient(90deg,rgba(131,58,180,1) 0%,rgba(253,29,29,1) 33.3%,rgba(252,176,69,1) 66.6%,rgba(131,58,180,1) 100%);-webkit-background-clip:text;color:transparent !important;background-size:300% 100%;animation:text 4s infinite linear;}
            @media (max-width:768px){span.ua-info{display:none}
            .comment-author .user-title{width:40% !important}
            }
            .comment-author .user-title{font-size:13px;background:linear-gradient(90deg,rgba(131,58,180,1) 0%,rgba(253,29,29,1) 33.3%,rgba(252,176,69,1) 66.6%,rgba(131,58,180,1) 100%);-webkit-background-clip:text;color:transparent !important;background-size:300% 100%;animation:text 4s infinite linear}
            @keyframes text{0%{background-position:0 0}
            100%{background-position:-150% 0}
            }
            .b2-qr-code-fill{background:linear-gradient(90deg,rgba(131,58,180,1) 0%,rgba(253,29,29,1) 33.3%,rgba(252,176,69,1) 66.6%,rgba(131,58,180,1) 100%);-webkit-background-clip:text;color:transparent !important;background-size:300% 100%;animation:text 4s infinite linear}
        </style>
        <?php
    }
    add_action('wp_footer', 'nav_color_style');
}

/*页脚样式*/
function get_panda_zib_time()
{
    $panda_footer_time = panda_pz('panda_footers_time');
    $panda_time = strtotime($panda_footer_time);
    $time = ceil((time() - $panda_time) / 86400) - 1;
    return $time;
}
function footer_style(){
    if (panda_pz('diy_footer_style') == 'mr') {
        if (panda_pz('footer_wave_style') && !is_page('user-sign')) {
            echo '<style>.footer-tabbar-placeholder{display: none;}@media (max-width: 768px){.footer-tabbar-placeholder1 {background: var(--footer-bg);height: calc(49px + constant(safe-area-inset-bottom));height: calc(49px + env(safe-area-inset-bottom))}}</style><div class="wiiuii_layout"><svg class="editorial" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28" preserveAspectRatio="none"><defs><path id="gentle-wave" d="M-160 44c30 0  58-18 88-18s 58 18 88 18  58-18 88-18  58 18 88 18 v44h-352z" /></defs><g class="parallax"><use xlink:href="#gentle-wave" x="50" y="0" fill="#4579e2"/><use xlink:href="#gentle-wave" x="50" y="3" fill="#3461c1"/><use xlink:href="#gentle-wave" x="50" y="6" fill="#2d55aa"/></g></svg></div><style>.parallax > use{animation: move-forever 12s linear infinite;}.parallax > use:nth-child(1){animation-delay: -2s;}.parallax > use:nth-child(2){animation-delay: -2s; animation-duration: 5s;}.parallax > use:nth-child(3){animation-delay: -4s; animation-duration: 3s;}@keyframes move-forever{0%{transform: translate(-90px, 0%);} 100%{transform: translate(85px, 0%);}}.wiiuii_layout{width: 100%;height: 40px;position: relative;overflow: hidden;z-index: 1;background: var(--footer-bg);}.editorial{display: block; width: 100%; height: 40px; margin: 0;}</style>
            <div class="footer-tabbar-placeholder1"></div>';
            
        }
    } else if (panda_pz('diy_footer_style') == 'black' && !is_page('user-sign')) {
        
    ?>
        <style>.footer {display: none;}.footer-tabbar-placeholder{display: none;}@media (max-width: 768px){.footer-tabbar-placeholder1 {background: var(--footer-bg);height: calc(49px + constant(safe-area-inset-bottom));height: calc(49px + env(safe-area-inset-bottom))}}</style>        
        <link rel="stylesheet" href="<?php echo panda_pz('static_panda');?>/assets/css/<?php echo panda_pz('footer_color_style')?'footer_style.css':'footer.css';?>" type="text/css">
        <?php if (panda_pz('panda_footers_tj')) {?>
            <div id="panda_stat">
                <?php
            function tjtjtj(){
    global $wpdb;

    // 预计算各类统计数据
    $users = (int) $wpdb->get_var("SELECT COUNT(ID) FROM $wpdb->users");

    $count_posts = wp_count_posts();
    $published_posts = isset($count_posts->publish) ? (int) $count_posts->publish : 0;

    // 帖子总数（论坛）
    $count_topics_obj = wp_count_posts('forum_post');
    $published_topics = isset($count_topics_obj->publish) ? (int) $count_topics_obj->publish : 0;

    // 总浏览数（所有类型的views）
    $total_views = 0;
    $views_rows = $wpdb->get_results("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='views'");
    if ($views_rows) {
        foreach ($views_rows as $v) {
            $mv = isset($v->meta_value) ? (int) $v->meta_value : 0;
            if ($mv > 0) {
                $total_views += $mv;
            }
        }
    }

    // 今日发布文章数
    $today = getdate();
    $posts_today_query = new WP_Query(array(
        'year'      => $today['year'],
        'monthnum'  => $today['mon'],
        'day'       => $today['mday'],
        'post_type' => 'post',
        'post_status' => 'publish',
        'fields'    => 'ids',
        'no_found_rows' => true,
    ));
    $posts_today = (int) $posts_today_query->found_posts;

    // 今日发布帖子数（论坛）
    $topics_today_query = new WP_Query(array(
        'year'      => $today['year'],
        'monthnum'  => $today['mon'],
        'day'       => $today['mday'],
        'post_type' => 'forum_post',
        'post_status' => 'publish',
        'fields'    => 'ids',
        'no_found_rows' => true,
    ));
    $topics_today = (int) $topics_today_query->found_posts;

    // 评论数量（已批准）
    $comments_count_obj = wp_count_comments();
    $comments_total = isset($comments_count_obj->approved) ? (int) $comments_count_obj->approved : 0;

    // 稳定运行时间（天）
    $wdyx_time = floor((time() - strtotime(panda_pz('panda_footers_time'))) / 86400);

    // 使用字段集“网站信息统计设置”的拖拽排序字段作为选择与顺序
    $default_items = array('users_total','posts_total','topics_total','views_total','today_posts','today_topics','comments_total','uptime_days');
    $stats_group = panda_pz('panda_footer_stats_group');
    $order = (is_array($stats_group) && isset($stats_group['panda_footer_stats_order']) && is_array($stats_group['panda_footer_stats_order'])) ? $stats_group['panda_footer_stats_order'] : array();
    $items = !empty($order) ? $order : $default_items;

    // 映射数据与默认标签、图标（可在后台自定义覆盖）
    $map = array(
        'users_total'    => array('icon' => 'fa fa-users',         'label' => '会员总数',        'value' => $users),
        'posts_total'    => array('icon' => 'fa fa-file-text-o',   'label' => '文章总数',        'value' => $published_posts),
        'topics_total'   => array('icon' => 'fa fa-comments',      'label' => '帖子总数',        'value' => $published_topics),
        'views_total'    => array('icon' => 'fa fa-eye',           'label' => '浏览总数',        'value' => $total_views),
        'today_posts'    => array('icon' => 'fa fa-calendar-o',    'label' => '今日发布文章数',  'value' => $posts_today),
        'today_topics'   => array('icon' => 'fa fa-calendar',      'label' => '今日发布帖子数',  'value' => $topics_today),
        'comments_total' => array('icon' => 'fa fa-commenting',    'label' => '评论数量',        'value' => $comments_total),
        'uptime_days'    => array('icon' => 'fa fa-rocket',        'label' => '稳定运行',        'value' => $wdyx_time . '天'),
    );

    // 输出HTML
    echo '<div id="caired"><div class="cai"><ul>';
    // 读取字段集以获取每个统计项的图标与文字设置
    $stats_group_conf = panda_pz('panda_footer_stats_group');
    $conf_map = array();
    if (is_array($stats_group_conf) && isset($stats_group_conf['panda_footer_stats_item_configs']) && is_array($stats_group_conf['panda_footer_stats_item_configs'])) {
        foreach ($stats_group_conf['panda_footer_stats_item_configs'] as $it) {
            if (is_array($it) && isset($it['key']) && $it['key'] !== '') {
                $conf_map[$it['key']] = $it;
            }
        }
    }
    foreach ($items as $key) {
        if (isset($map[$key])) {
            $m = $map[$key];
            $conf = isset($conf_map[$key]) ? $conf_map[$key] : array();
            if (empty($conf)) {
                // 兼容旧版字段结构
                $conf_id = 'panda_footer_stats_item_' . $key;
                $conf = (is_array($stats_group_conf) && isset($stats_group_conf[$conf_id]) && is_array($stats_group_conf[$conf_id])) ? $stats_group_conf[$conf_id] : array();
            }

            $icon_class = isset($conf['icon']) && $conf['icon'] !== '' ? $conf['icon'] : $m['icon'];
            $label_text = isset($conf['label']) && $conf['label'] !== '' ? $conf['label'] : $m['label'];
            $show_icon  = isset($conf['show_icon']) ? (bool)$conf['show_icon'] : true;
            $show_label = isset($conf['show_label']) ? (bool)$conf['show_label'] : true;

            echo '<li>';
            if ($show_icon) {
                if (strpos($icon_class, '<') !== false) {
                    echo $icon_class; // 允许自定义HTML图标
                } else {
                    echo '<i class="' . esc_attr($icon_class) . '"></i>';
                }
            }
            echo '<span>' . esc_html($m['value']) . '</span>';
            if ($show_label) {
                echo '<p>' . esc_html($label_text) . '</p>';
            }
            echo '</li>';
        }
    }
    echo '</ul></div></div>';
    }
    /*底部统计结束*/
        ?>
        <?php 
        // 读取每行显示个数（优先顶层选项，兼容旧版字段集）
        $mobile_cols = panda_pz('panda_footer_stats_mobile_cols');
        if (!is_numeric($mobile_cols)) {
            $stats_group_cols = panda_pz('panda_footer_stats_group');
            $mobile_cols = (is_array($stats_group_cols) && isset($stats_group_cols['panda_footer_stats_mobile_cols'])) ? $stats_group_cols['panda_footer_stats_mobile_cols'] : 2;
        }
        $mobile_cols = max(1, min(6, intval($mobile_cols)));
        $mobile_basis = 100 / $mobile_cols;

        $desktop_cols = panda_pz('panda_footer_stats_desktop_cols');
        if (!is_numeric($desktop_cols)) {
            if (!isset($stats_group_cols)) {
                $stats_group_cols = panda_pz('panda_footer_stats_group');
            }
            $desktop_cols = (is_array($stats_group_cols) && isset($stats_group_cols['panda_footer_stats_desktop_cols'])) ? $stats_group_cols['panda_footer_stats_desktop_cols'] : 5;
        }
        $desktop_cols = max(1, min(8, intval($desktop_cols)));
        $desktop_basis = 100 / $desktop_cols;
        ?>
        <style>
#caired{
height: 100%;
width: 100%;
margin: 0;
padding: 0;
font-family: "montserrat";
background-image: -webkit-linear-gradient(45deg,#2c3e50,#27ae60,#2980b9,#e74c3c,#8e44ad);
background-size: 400%;
animation: bganimation 15s infinite;
}
@keyframes bganimation {
0%{
background-position: 0% 50%;
}
50%{
background-position: 100% 50%;
}
100%{
background-position: 0% 50%;
}
}
#caired{border-radius: 10px;}
#caired .cai ul{display: flex; flex-wrap: wrap; gap: 12px; height: auto; align-items: center; justify-content: space-between;}
#caired .cai ul li{flex: 1 1 calc(<?php echo round($desktop_basis, 4); ?>% - 12px); min-width: 140px; color: #fff; text-align: center;}
#caired .cai ul li p{font-size: 18px; font-weight: bold;}
#caired .cai ul li span{font-size: 34px; font-family: Arial;}
@media screen and (max-width: 992px){#caired .cai ul li{flex: 1 1 calc(33.33% - 12px);} #caired .cai ul li span{font-size: 28px;} #caired .cai ul li p{font-size: 16px;}}
@media screen and (max-width: 768px){#caired .cai ul{height:auto;} #caired .cai ul li{min-width: 0 !important; flex: 0 0 calc(<?php echo round($mobile_basis, 4); ?>% - 12px);} #caired .cai ul li span{font-size: 22px; font-family: Arial;} #caired .cai ul li p{font-size: 14px;} #caired .cai ul li i{font-size: 20px;}}
#caired .cai{font-weight:700;padding:20px 0 20px 0;}
/* 图标样式 */
#caired .cai ul li i {
    display: block;
    margin-bottom: 5px;
    font-size: 24px; /* 根据需要调整大小 */
}
</style> 
        <?php echo tjtjtj();?>
        <?php if (panda_pz('panda_footers_wave')) {
        if (panda_pz('footer_color_style')){?>  
            <div class="wave-box">
    <style>
        /* 颜色：前波浪使用 var(--main-bg-color)，后波浪使用 var(--muted-2-color) */
        /* 将波浪固定在统计区底部，并让下边与其底边重合 */
        #panda_stat{ position: relative; overflow: visible; }
        .wave-box { position: absolute; left: 0; right: 0; bottom: 0; height: 60px; z-index: 3; pointer-events: none; }
        .marquee-box { position: absolute; left: 0; top: 0; width: 100%; overflow: hidden; }
        /* 单条无缝滚动：用双份相同波形拼接，动画整体移动 */
        .wave-strip { width: 200%; display: flex; }
        .wave-strip .wave-svg { height: 60px; width: 50%; display: block; }
        .wave-strip { animation: panda-wave-scroll 16s linear infinite; will-change: transform; }
        /* 分层速度、透明度与相位偏移（增强分离度） */
        #wave-list-box1 .wave-strip { animation-duration: 16s; opacity: 0.55; animation-delay: -0s; }
        #wave-list-box2 .wave-strip { animation-duration: 20s; opacity: 0.45; animation-delay: -3s; }
        #wave-list-box3 .wave-strip { animation-duration: 26s; opacity: 0.35; animation-delay: -6s; }
        #wave-list-box7 .wave-strip { animation-duration: 32s; opacity: 0.28; animation-delay: -9s; }
        #wave-list-box4 .wave-strip { animation-duration: 14s; opacity: 0.72; animation-delay: -0s; }
        #wave-list-box5 .wave-strip { animation-duration: 22s; opacity: 0.50; animation-delay: -2s; }
        #wave-list-box6 .wave-strip { animation-duration: 30s; opacity: 0.38; animation-delay: -4s; }
        #wave-list-box8 .wave-strip { animation-duration: 36s; opacity: 0.30; animation-delay: -6s; }
        /* 垂直位移：拉开与第一层的距离，使下层可见 */
        #wave-list-box1 { transform: translateY(6px); }
        #wave-list-box2 { transform: translateY(12px); }
        #wave-list-box3 { transform: translateY(18px); }
        #wave-list-box7 { transform: translateY(24px); }
        #wave-list-box5 { transform: translateY(30px); }
        #wave-list-box6 { transform: translateY(36px); }
        /* 夜间模式下整体透明度微调 */
        body.dark-theme #wave-list-box4 .wave-strip { opacity: 0.85; transition: opacity .25s ease; }
        /* 前/后波浪颜色（提高应用优先级） */
        .theme-wave1 { color: var(--main-bg-color); }
        body.dark-theme .theme-wave1 { color: #000; }
        .theme-wave2 { color: var(--main-bg-color); }
        .wave-svg path { fill: currentColor !important; transition: fill .25s ease; }
        /* 避免混合模式影响颜色 */
        .wave-svg { mix-blend-mode: normal; }
        .wave-list-box ul, .wave-list-box ul li { display: block; }
        @keyframes panda-wave-scroll { from { transform: translateX(0); } to { transform: translateX(-50%); } }
    </style>
    <div class="marquee-box marquee-up" id="marquee-box">
        <div class="marquee">
            <div class="wave-list-box" id="wave-list-box1">
                <ul>
                    <li>
                        <div class="wave-strip">
                            <svg class="theme-wave2 wave-svg" viewBox="0 0 1200 60" preserveAspectRatio="none" aria-label="波浪">
                                <path d="M0 44 C 60 64, 120 24, 180 44 C 240 64, 300 24, 360 44 C 420 64, 480 24, 540 44 C 600 64, 660 24, 720 44 C 780 64, 840 24, 900 44 C 960 64, 1020 24, 1080 44 C 1140 64, 1200 24, 1200 44 L 1200 60 L 0 60 Z"></path>
                            </svg>
                            <svg class="theme-wave2 wave-svg" viewBox="0 0 1200 60" preserveAspectRatio="none" aria-label="波浪">
                                <path d="M0 44 C 60 64, 120 24, 180 44 C 240 64, 300 24, 360 44 C 420 64, 480 24, 540 44 C 600 64, 660 24, 720 44 C 780 64, 840 24, 900 44 C 960 64, 1020 24, 1080 44 C 1140 64, 1200 24, 1200 44 L 1200 60 L 0 60 Z"></path>
                            </svg>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="wave-list-box" id="wave-list-box2">
                <ul>
                    <li>
                        <div class="wave-strip">
                            <svg class="theme-wave2 wave-svg" viewBox="0 0 1200 60" preserveAspectRatio="none" aria-label="波浪">
                                <path d="M0 40 C 60 60, 120 20, 180 40 C 240 60, 300 20, 360 40 C 420 60, 480 20, 540 40 C 600 60, 660 20, 720 40 C 780 60, 840 20, 900 40 C 960 60, 1020 20, 1080 40 C 1140 60, 1200 20, 1200 40 L 1200 60 L 0 60 Z"></path>
                            </svg>
                            <svg class="theme-wave2 wave-svg" viewBox="0 0 1200 60" preserveAspectRatio="none" aria-label="波浪">
                                <path d="M0 40 C 60 60, 120 20, 180 40 C 240 60, 300 20, 360 40 C 420 60, 480 20, 540 40 C 600 60, 660 20, 720 40 C 780 60, 840 20, 900 40 C 960 60, 1020 20, 1080 40 C 1140 60, 1200 20, 1200 40 L 1200 60 L 0 60 Z"></path>
                            </svg>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="wave-list-box" id="wave-list-box3">
                <ul>
                    <li>
                        <div class="wave-strip">
                            <svg class="theme-wave2 wave-svg" viewBox="0 0 1200 60" preserveAspectRatio="none" aria-label="波浪">
                                <path d="M0 36 C 60 56, 120 16, 180 36 C 240 56, 300 16, 360 36 C 420 56, 480 16, 540 36 C 600 56, 660 16, 720 36 C 780 56, 840 16, 900 36 C 960 56, 1020 16, 1080 36 C 1140 56, 1200 16, 1200 36 L 1200 60 L 0 60 Z"></path>
                            </svg>
                            <svg class="theme-wave2 wave-svg" viewBox="0 0 1200 60" preserveAspectRatio="none" aria-label="波浪">
                                <path d="M0 36 C 60 56, 120 16, 180 36 C 240 56, 300 16, 360 36 C 420 56, 480 16, 540 36 C 600 56, 660 16, 720 36 C 780 56, 840 16, 900 36 C 960 56, 1020 16, 1080 36 C 1140 56, 1200 16, 1200 36 L 1200 60 L 0 60 Z"></path>
                            </svg>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="wave-list-box" id="wave-list-box7">
                <ul>
                    <li>
                        <div class="wave-strip">
                            <svg class="theme-wave2 wave-svg" viewBox="0 0 1200 60" preserveAspectRatio="none" aria-label="波浪">
                                <path d="M0 32 C 60 52, 120 12, 180 32 C 240 52, 300 12, 360 32 C 420 52, 480 12, 540 32 C 600 52, 660 12, 720 32 C 780 52, 840 12, 900 32 C 960 52, 1020 12, 1080 32 C 1140 52, 1200 12, 1200 32 L 1200 60 L 0 60 Z"></path>
                            </svg>
                            <svg class="theme-wave2 wave-svg" viewBox="0 0 1200 60" preserveAspectRatio="none" aria-label="波浪">
                                <path d="M0 32 C 60 52, 120 12, 180 32 C 240 52, 300 12, 360 32 C 420 52, 480 12, 540 32 C 600 52, 660 12, 720 32 C 780 52, 840 12, 900 32 C 960 52, 1020 12, 1080 32 C 1140 52, 1200 12, 1200 32 L 1200 60 L 0 60 Z"></path>
                            </svg>
                        </div>
                    </li>
                </ul>
            </div>
            <!-- 额外后层：增加波浪数量并拉开与第一层的距离 -->
            <div class="wave-list-box" id="wave-list-box5">
                <ul>
                    <li>
                        <div class="wave-strip">
                            <svg class="theme-wave2 wave-svg" viewBox="0 0 1200 60" preserveAspectRatio="none" aria-label="波浪">
                                <path d="M0 28 C 60 48, 120 8, 180 28 C 240 48, 300 8, 360 28 C 420 48, 480 8, 540 28 C 600 48, 660 8, 720 28 C 780 48, 840 8, 900 28 C 960 48, 1020 8, 1080 28 C 1140 48, 1200 8, 1200 28 L 1200 60 L 0 60 Z"></path>
                            </svg>
                            <svg class="theme-wave2 wave-svg" viewBox="0 0 1200 60" preserveAspectRatio="none" aria-label="波浪">
                                <path d="M0 28 C 60 48, 120 8, 180 28 C 240 48, 300 8, 360 28 C 420 48, 480 8, 540 28 C 600 48, 660 8, 720 28 C 780 48, 840 8, 900 28 C 960 48, 1020 8, 1080 28 C 1140 48, 1200 8, 1200 28 L 1200 60 L 0 60 Z"></path>
                            </svg>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="wave-list-box" id="wave-list-box6">
                <ul>
                    <li>
                        <div class="wave-strip">
                            <svg class="theme-wave2 wave-svg" viewBox="0 0 1200 60" preserveAspectRatio="none" aria-label="波浪">
                                <path d="M0 24 C 60 40, 120 8, 180 24 C 240 40, 300 8, 360 24 C 420 40, 480 8, 540 24 C 600 40, 660 8, 720 24 C 780 40, 840 8, 900 24 C 960 40, 1020 8, 1080 24 C 1140 40, 1200 8, 1200 24 L 1200 60 L 0 60 Z"></path>
                            </svg>
                            <svg class="theme-wave2 wave-svg" viewBox="0 0 1200 60" preserveAspectRatio="none" aria-label="波浪">
                                <path d="M0 24 C 60 40, 120 8, 180 24 C 240 40, 300 8, 360 24 C 420 40, 480 8, 540 24 C 600 40, 660 8, 720 24 C 780 40, 840 8, 900 24 C 960 40, 1020 8, 1080 24 C 1140 40, 1200 8, 1200 24 L 1200 60 L 0 60 Z"></path>
                            </svg>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="marquee-box" id="marquee-box3">
        <div class="marquee">
            <div class="wave-list-box" id="wave-list-box4">
                <ul>
                    <li>
                        <div class="wave-strip">
                            <svg class="theme-wave1 wave-svg" viewBox="0 0 1200 60" preserveAspectRatio="none" aria-label="波浪">
                                <path d="M0 35 C 80 55, 160 15, 240 35 C 320 55, 400 15, 480 35 C 560 55, 640 15, 720 35 C 800 55, 880 15, 960 35 C 1040 55, 1120 15, 1200 35 L 1200 60 L 0 60 Z"></path>
                            </svg>
                            <svg class="theme-wave1 wave-svg" viewBox="0 0 1200 60" preserveAspectRatio="none" aria-label="波浪">
                                <path d="M0 35 C 80 55, 160 15, 240 35 C 320 55, 400 15, 480 35 C 560 55, 640 15, 720 35 C 800 55, 880 15, 960 35 C 1040 55, 1120 15, 1200 35 L 1200 60 L 0 60 Z"></path>
                            </svg>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
        <!-- SVG+CSS 悬浮过渡，固定在统计区底部 -->
        <?php } else {?>
        <div class="wave-box night">
            <style>
                #panda_stat{ position: relative; overflow: visible; }
                .wave-box { position: absolute; left: 0; right: 0; bottom: 0; height: 60px; z-index: 3; pointer-events: none; }
                /* 夜间变色：为非彩色样式提供深色渐变与滤镜 */
                .wave-box.night:after {
                    content: '';
                    position: absolute;
                    left: 0; right: 0; bottom: 0;
                    height: 60px;
                    background-size: 300% 100%;
                    opacity: .35;
                    animation: nightGradient 18s linear infinite;
                    pointer-events: none;
                }
                .marquee-box { position: absolute; left: 0; top: 0; width: 100%; overflow: hidden; }
                /* 夜间波浪颜色（可按需调整为更暗或更亮） */
                .night-wave1 { color: #0f172a; }
                .night-wave2 { color: #1e293b; }
                /* SVG波浪统一过渡与尺寸 */
                .wave-strip { width: 200%; display: flex; animation: panda-wave-scroll 16s linear infinite; will-change: transform; }
                .wave-strip .wave-svg { height: 60px; width: 50%; display: block; }
                .wave-svg path { fill: currentColor !important; transition: fill .25s ease; }
                @keyframes nightGradient { 0% { background-position: 0% 0; } 100% { background-position: 200% 0; } }
                @keyframes panda-wave-scroll { from { transform: translateX(0); } to { transform: translateX(-50%); } }
            </style>
            <div class="marquee-box marquee-up" id="marquee-box">
                <div class="marquee">
                    <div class="wave-list-box" id="wave-list-box1">
                        <ul>
                            <li>
                                <div class="wave-strip">
                                    <svg class="night-wave2 wave-svg" viewBox="0 0 1200 60" preserveAspectRatio="none" aria-label="波浪">
                                        <path d="M0 44 C 60 64, 120 24, 180 44 C 240 64, 300 24, 360 44 C 420 64, 480 24, 540 44 C 600 64, 660 24, 720 44 C 780 64, 840 24, 900 44 C 960 64, 1020 24, 1080 44 C 1140 64, 1200 24, 1200 44 L 1200 60 L 0 60 Z"></path>
                                    </svg>
                                    <svg class="night-wave2 wave-svg" viewBox="0 0 1200 60" preserveAspectRatio="none" aria-label="波浪">
                                        <path d="M0 44 C 60 64, 120 24, 180 44 C 240 64, 300 24, 360 44 C 420 64, 480 24, 540 44 C 600 64, 660 24, 720 44 C 780 64, 840 24, 900 44 C 960 64, 1020 24, 1080 44 C 1140 64, 1200 24, 1200 44 L 1200 60 L 0 60 Z"></path>
                                    </svg>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="wave-list-box" id="wave-list-box2">
                        <ul>
                            <li>
                                <div class="wave-strip">
                                    <svg class="night-wave2 wave-svg" viewBox="0 0 1200 60" preserveAspectRatio="none" aria-label="波浪">
                                        <path d="M0 40 C 60 60, 120 20, 180 40 C 240 60, 300 20, 360 40 C 420 60, 480 20, 540 40 C 600 60, 660 20, 720 40 C 780 60, 840 20, 900 40 C 960 60, 1020 20, 1080 40 C 1140 60, 1200 20, 1200 40 L 1200 60 L 0 60 Z"></path>
                                    </svg>
                                    <svg class="night-wave2 wave-svg" viewBox="0 0 1200 60" preserveAspectRatio="none" aria-label="波浪">
                                        <path d="M0 40 C 60 60, 120 20, 180 40 C 240 60, 300 20, 360 40 C 420 60, 480 20, 540 40 C 600 60, 660 20, 720 40 C 780 60, 840 20, 900 40 C 960 60, 1020 20, 1080 40 C 1140 60, 1200 20, 1200 40 L 1200 60 L 0 60 Z"></path>
                                    </svg>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="marquee-box" id="marquee-box3">
                <div class="marquee">
                    <div class="wave-list-box" id="wave-list-box4">
                        <ul>
                            <li>
                                <div class="wave-strip">
                                    <svg class="night-wave1 wave-svg" viewBox="0 0 1200 60" preserveAspectRatio="none" aria-label="波浪">
                                        <path d="M0 35 C 80 55, 160 15, 240 35 C 320 55, 400 15, 480 35 C 560 55, 640 15, 720 35 C 800 55, 880 15, 960 35 C 1040 55, 1120 15, 1200 35 L 1200 60 L 0 60 Z"></path>
                                    </svg>
                                    <svg class="night-wave1 wave-svg" viewBox="0 0 1200 60" preserveAspectRatio="none" aria-label="波浪">
                                        <path d="M0 35 C 80 55, 160 15, 240 35 C 320 55, 400 15, 480 35 C 560 55, 640 15, 720 35 C 800 55, 880 15, 960 35 C 1040 55, 1120 15, 1200 35 L 1200 60 L 0 60 Z"></path>
                                    </svg>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="wave-list-box" id="wave-list-box5">
                        <ul>
                            <li>
                                <div class="wave-strip">
                                    <svg class="night-wave1 wave-svg" viewBox="0 0 1200 60" preserveAspectRatio="none" aria-label="波浪">
                                        <path d="M0 32 C 60 52, 120 12, 180 32 C 240 52, 300 12, 360 32 C 420 52, 480 12, 540 32 C 600 52, 660 12, 720 32 C 780 52, 840 12, 900 32 C 960 52, 1020 12, 1080 32 C 1140 52, 1200 12, 1200 32 L 1200 60 L 0 60 Z"></path>
                                    </svg>
                                    <svg class="night-wave1 wave-svg" viewBox="0 0 1200 60" preserveAspectRatio="none" aria-label="波浪">
                                        <path d="M0 32 C 60 52, 120 12, 180 32 C 240 52, 300 12, 360 32 C 420 52, 480 12, 540 32 C 600 52, 660 12, 720 32 C 780 52, 840 12, 900 32 C 960 52, 1020 12, 1080 32 C 1140 52, 1200 12, 1200 32 L 1200 60 L 0 60 Z"></path>
                                    </svg>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="<?php echo panda_pz('static_panda');?>/assets/js/wave.js"></script>
        <?php } } ?>
            </div>
        <?php } ?>
            <div id="colophon" class="footer1">
                <div id="Onecad_footer_ys2" class="footer-navi">
                    <div id="panda_title" class="wrapper">
                        <div class="about widget Onecad_fl">
                            <div class="title">
                                <div class="panda_beat_heart">
                                    <div class="panda_beat_left"></div>
                                    <div class="panda_beat_right"></div>
                                </div>
                                <h2><?php echo panda_pz('panda_footers_title'); ?></h2>
                            </div>
                            <p style="color: #949498;"><?php echo panda_pz('diy_footer_description'); ?></p>
                            <p style="color: #949498;"><?php printf(' 页面耗时 %.3f 秒 | 数据库查询 %d 次 | 内存 %.2f MB ', timer_stop(0, 3), get_num_queries(), memory_get_peak_usage() / 1024 / 1024); ?>| <?php
                                //首先你要有读写文件的权限，首次访问肯不显示，正常情况刷新即可
                                $online_log = "wp-content/themes/panda/assets/others/maplers.dat"; //保存人数的文件到根目录,
                                $timeout = 30;//30秒内没动作者,认为掉线
                                $entries = file($online_log);
                                $temp = array();
                                if (!file_exists($online_log)) {
                                    // 文件不存在，可以创建文件或给出提示
                                    echo "文件不存在，请检查路径或权限。";
                                    return;
                                }
                                $entries = file($online_log);
                                if ($entries === false) {
                                    // 文件读取失败，可能由于权限问题或其他原因
                                    echo "文件读取失败，请检查文件路径和权限。";
                                    return;
                                }
                                // 确保 $entries 是数组后，再进行后续操作
                                for ($i=0;$i<count($entries);$i++){
                                $entry = explode(",",trim($entries[$i]));
                                if(($entry[0] != getenv('REMOTE_ADDR')) && ($entry[1] > time())) {
                                array_push($temp,$entry[0].",".$entry[1]."\n"); //取出其他浏览者的信息,并去掉超时者,保存进$temp
                                }}
                                array_push($temp,getenv('REMOTE_ADDR').",".(time() + ($timeout))."\n"); //更新浏览者的时间
                                $maplers = count($temp); //计算在线人数
                                $entries = implode("",$temp);
                                //写入文件
                                $fp = fopen($online_log,"w");
                                flock($fp,LOCK_EX); //flock() 不能在NFS以及其他的一些网络文件系统中正常工作
                                fputs($fp,$entries);
                                flock($fp,LOCK_UN);
                                fclose($fp);
                                echo "在线人数：".$maplers."人";
                                ?></p>
                        </div>
                        <div class="navis Onecad_fl hide_sm" style="font-weight: bold;">
                            <?php
                            // 关于我们
                            $about_title = panda_pz('black_footer_about_title');
                            $about_items = panda_pz('black_footer_about_items');
                            echo '<div class="navi">';
                            echo '<h2 class="title">' . esc_html($about_title ? $about_title : '关于我们') . '</h2>';
                            if (is_array($about_items) && !empty($about_items)) {
                                echo '<ul>';
                                foreach ($about_items as $item) {
                                    $label = isset($item['label']) ? $item['label'] : '';
                                    $url   = isset($item['url']) ? $item['url'] : '#';
                                    echo '<li><a href="' . esc_url($url) . '" target="_blank">' . esc_html($label) . '</a></li>';
                                }
                                echo '</ul>';
                            }
                            echo '</div>';

                            // 特色功能
                            $feature_title = panda_pz('black_footer_feature_title');
                            $feature_items = panda_pz('black_footer_feature_items');
                            echo '<div class="navi">';
                            echo '<h2 class="title">' . esc_html($feature_title ? $feature_title : '特色功能') . '</h2>';
                            if (is_array($feature_items) && !empty($feature_items)) {
                                echo '<ul>';
                                foreach ($feature_items as $item) {
                                    $label = isset($item['label']) ? $item['label'] : '';
                                    $url   = isset($item['url']) ? $item['url'] : '#';
                                    echo '<li><a href="' . esc_url($url) . '" target="_blank">' . esc_html($label) . '</a></li>';
                                }
                                echo '</ul>';
                            }
                            echo '</div>';

                            // 用户服务
                            $user_title = panda_pz('black_footer_user_title');
                            $user_items = panda_pz('black_footer_user_items');
                            echo '<div class="navi">';
                            echo '<h2 class="title">' . esc_html($user_title ? $user_title : '用户服务') . '</h2>';
                            if (is_array($user_items) && !empty($user_items)) {
                                echo '<ul>';
                                foreach ($user_items as $item) {
                                    $label = isset($item['label']) ? $item['label'] : '';
                                    $url   = isset($item['url']) ? $item['url'] : '#';
                                    echo '<li><a href="' . esc_url($url) . '" target="_blank">' . esc_html($label) . '</a></li>';
                                }
                                echo '</ul>';
                            }
                            echo '</div>';
                            ?>
                        </div>
                        <div class="ewms widget fr hide_sm">
                            <ul class="clearfix">
                                <?php
                                $qr_items = panda_pz('black_footer_qr_items');
                                if (is_array($qr_items) && !empty($qr_items)) {
                                    foreach ($qr_items as $item) {
                                        $label = isset($item['label']) ? $item['label'] : '';
                                        $img   = isset($item['img']) ? $item['img'] : '';
                                        $url   = isset($item['url']) ? $item['url'] : '';
                                        if ($url) {
                                            echo '<li><a rel="nofollow" href="' . esc_url($url) . '" target="_blank"><div><div class="Onecad_footer_ico"><img class="thumb" src="' . esc_url($img) . '"></div><h4>' . esc_html($label) . '</h4></div></a></li>';
                                        } else {
                                            echo '<li><div><div class="Onecad_footer_ico"><img class="thumb" src="' . esc_url($img) . '"></div><h4>' . esc_html($label) . '</h4></div></li>';
                                        }
                                    }
                                }
                                ?>
                            </ul>
                            <div class="like">
                                <strong><?php $count_posts = wp_count_posts(); echo $published_posts = $count_posts->publish; ?></strong>
                                <h3 class="footer_description">精品文章等您来关注</h3>
                            </div>
                        </div>
                    </div>
                    <div class="footer-colors"></div>
                    <?php if(panda_pz('panda_footers_friend')){?>
                        <div id="panda_bg_box">
                            <div id="panda_links">
                                <ul>友情链接：<?php wp_list_bookmarks('title_li=&categorize=0&category=0&before=<span>&after=&nbsp</span>&show_images=0&show_description=0&orderby=url'); ?><a href="<?php echo panda_pz('panda_footers_url'); ?>" style="color: #0078ff; float: right;">申请友链</a></ul>
                            </div>
                        </div>
                    <?php } ?>
                    <center>
                        <div class="foot-copyright">
                            <div class="wrapper">
                                <p class="foot-copyright-fl fla footer_description" style="color: #949498;"><?php echo panda_pz('panda_footers_copyright'); ?></p>
                            </div>
                        </div>
                    </center>
                </div>
            </div>
            <div class="footer-tabbar-placeholder1"></div>
    <?php
    } else if (panda_pz('diy_footer_style') == 'wh' && !is_page('user-sign')) {
        ?>
       <div class="footer2-fav">
    <div class="wrapper footer2-fav-top">
        <div class="Onecad_fl site-info">
            <h2><?php echo esc_html(panda_pz('wh_footer_site_title')); ?></h2>
            <div class="site-p"><p><?php echo esc_html(panda_pz('wh_footer_site_desc')); ?></p></div>
        </div>
        <?php if (panda_pz('wh_footer_enable_fav')): ?>
        <div class="fr site-fav">
            <a class="btn btn-fav btn-orange" id="favoriteBtn">
    <i class="tubiao wei-shoucang1"></i>
    收藏本站
</a>
<div id="customPopup" class="popup-overlay">
    <div class="popup-container">
        <div class="popup-header">
            <h3>收藏本站</h3>
            <button class="popup-close" id="closePopup">&times;</button>
        </div>
        <div class="popup-content">
            <p id="popupMessage">请使用快捷键添加收藏：<br>Windows: Ctrl+D<br>Mac: Command+D</p>
            <div class="popup-buttons">
                <button class="popup-btn" id="confirmBtn">知道了</button>
            </div>
        </div>
    </div>
</div>
        </div>
        <?php endif; ?>
        <div class="site-girl">
            <div class="girl Onecad_fl">
                <i
                    class="thumb"
                    style="background-image: url(<?php echo esc_url(panda_pz('wh_footer_girl_image')); ?>)"
                ></i>
            </div>
            <div class="girl-info hide_md">
                <?php echo wp_kses_post(panda_pz('wh_footer_girl_text')); ?>
            </div>
        </div>
    </div>
</div>

<footer2
    id="onecad_new_footer2"
    class="onecad_new_footer2 bg_img"
    style="background-image: url(<?php echo esc_url(panda_pz('wh_footer_bg_image')); ?>)"
>
    <div
        id="hmbk-footer2-new"
        class="footer2"
    >
        <div style="background-image: url(<?php echo esc_url(panda_pz('wh_footer_bg_image')); ?>)">
            <div class="hmbk-footer2">
                <div class="wrapper">
                    <div class="hmbk-footer2-widget-in">
                        <section
                            id="text-3"
                            class="widget widget_text mg-b zibtf-radius"
                        >
                            <?php $about_title = panda_pz('wh_footer_about_title'); ?>
                            <h2 class="widget-title footer2-h"><?php echo esc_html($about_title ? $about_title : '关于我们'); ?></h2>
                            <div class="textwidget"><p><?php echo esc_html(panda_pz('wh_footer_about_text')); ?></p></div>
                        </section>
                        <section
                            id="nav_menu-2"
                            class="widget widget_nav_menu mg-b zibtf-radius"
                        >
                            <?php $about_title = panda_pz('wh_footer_about_title'); ?>
                            <h2 class="widget-title footer2-h"><?php echo esc_html($about_title ? $about_title : '关于我们'); ?></h2>
                            <div class="menu-footer2-container">
                                <?php
                                $about_items = panda_pz('wh_footer_about_items');
                                if (is_array($about_items) && !empty($about_items)) {
                                    echo '<ul class="menu">';
                                    foreach ($about_items as $item) {
                                        $label = isset($item['label']) ? $item['label'] : '';
                                        $url   = isset($item['url']) ? $item['url'] : '#';
                                        echo '<li><a href="' . esc_url($url) . '" target="_blank">' . esc_html($label) . '</a></li>';
                                    }
                                    echo '</ul>';
                                } else {
                                    // 兼容旧数据
                                    echo wp_kses_post(panda_pz('wh_footer_about_list'));
                                }
                                ?>
                            </div>
                        </section>
                        <section
                            id="nav_menu-3"
                            class="widget widget_nav_menu mg-b zibtf-radius"
                        >
                            <?php $feature_title = panda_pz('wh_footer_feature_title'); ?>
                            <h2 class="widget-title footer2-h"><?php echo esc_html($feature_title ? $feature_title : '特色功能'); ?></h2>
                            <div class="menu-footer2-container">
                                <?php
                                $feature_items = panda_pz('wh_footer_feature_items');
                                if (is_array($feature_items) && !empty($feature_items)) {
                                    echo '<ul class="menu">';
                                    foreach ($feature_items as $item) {
                                        $label = isset($item['label']) ? $item['label'] : '';
                                        $url   = isset($item['url']) ? $item['url'] : '#';
                                        echo '<li><a href="' . esc_url($url) . '" target="_blank">' . esc_html($label) . '</a></li>';
                                    }
                                    echo '</ul>';
                                } else {
                                    echo wp_kses_post(panda_pz('wh_footer_feature_list'));
                                }
                                ?>
                            </div>
                        </section>
                        <section
                            id="nav_menu-4"
                            class="widget widget_nav_menu mg-b zibtf-radius"
                        >
                            <?php $user_title = panda_pz('wh_footer_user_title'); ?>
                            <h2 class="widget-title footer2-h"><?php echo esc_html($user_title ? $user_title : '用户服务'); ?></h2>
                            <div class="menu-footer2-container">
                                <?php
                                $user_items = panda_pz('wh_footer_user_items');
                                if (is_array($user_items) && !empty($user_items)) {
                                    echo '<ul class="menu">';
                                    foreach ($user_items as $item) {
                                        $label = isset($item['label']) ? $item['label'] : '';
                                        $url   = isset($item['url']) ? $item['url'] : '#';
                                        echo '<li><a href="' . esc_url($url) . '" target="_blank">' . esc_html($label) . '</a></li>';
                                    }
                                    echo '</ul>';
                                } else {
                                    echo wp_kses_post(panda_pz('wh_footer_user_list'));
                                }
                                ?>
                            </div>
                        </section>
                        <section
                            id="custom_html-3"
                            class="widget_text widget widget_custom_html mg-b zibtf-radius"
                        >
                            <?php $qr_title = panda_pz('wh_footer_qr_title'); ?>
                            <h2 class="widget-title footer2-h"><?php echo esc_html($qr_title ? $qr_title : '关注交流'); ?></h2>
                            <div class="textwidget custom-html-widget">
                                <div class="row qr-container">
                                    <?php
                                    $qr_items = panda_pz('wh_footer_qr_items');
                                    if (is_array($qr_items) && !empty($qr_items)) {
                                        foreach ($qr_items as $qi) {
                                            $label = isset($qi['label']) ? $qi['label'] : '';
                                            $img   = isset($qi['img']) ? $qi['img'] : '';
                                            ?>
                                            <div class="qr-item">
                                                <div class="qr-wrapper">
                                                    <img width="90" height="90" alt="<?php echo esc_attr($label); ?>" src="<?php echo esc_url($img); ?>" class="qr-img" />
                                                </div>
                                                <p class="qr-tips"><?php echo esc_html($label); ?></p>
                                            </div>
                                            <?php
                                        }
                                    } else {
                                        // 兼容旧的三个二维码设置
                                        ?>
                                        <div class="qr-item">
                                            <div class="qr-wrapper">
                                                <img width="90" height="90" alt="<?php echo esc_attr(panda_pz('wh_footer_qr1_label')); ?>" src="<?php echo esc_url(panda_pz('wh_footer_qr1_img')); ?>" class="qr-img" />
                                            </div>
                                            <p class="qr-tips"><?php echo esc_html(panda_pz('wh_footer_qr1_label')); ?></p>
                                        </div>
                                        <div class="qr-item">
                                            <div class="qr-wrapper">
                                                <img width="90" height="90" alt="<?php echo esc_attr(panda_pz('wh_footer_qr2_label')); ?>" src="<?php echo esc_url(panda_pz('wh_footer_qr2_img')); ?>" class="qr-img" />
                                            </div>
                                            <p class="qr-tips"><?php echo esc_html(panda_pz('wh_footer_qr2_label')); ?></p>
                                        </div>
                                        <div class="qr-item">
                                            <div class="qr-wrapper">
                                                <img width="90" height="90" alt="<?php echo esc_attr(panda_pz('wh_footer_qr3_label')); ?>" src="<?php echo esc_url(panda_pz('wh_footer_qr3_img')); ?>" class="qr-img" />
                                            </div>
                                            <p class="qr-tips"><?php echo esc_html(panda_pz('wh_footer_qr3_label')); ?></p>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
            <div class="hmbk-footer2-nav">
                <div class="wrapper">
                    <?php if (panda_pz('wh_footer_show_links')): ?>
                    <div class="footer2-links">
                        <div class="link-content">
                            <span class="link-heading">友情链接：</span>
                            <div class="link-items">
                                <?php wp_list_bookmarks('title_li=&categorize=0&category=0&before=<span>&after=</span>&show_images=0&show_description=0&orderby=url');?>
                            </div>
                        </div>
                        <a href="<?php echo esc_url(panda_pz('wh_footer_links_apply_url')); ?>" target="_blank" class="apply-link">友链申请+</a>
                    </div>
                    <?php endif; ?>
                    <div class="footer2-bottom">
                        <div class="footer2-bottom-container">
                            <div class="foot-left">
                                <?php
                                // 版权文案支持占位符：{year}、{site_title}、{site_domain}、{site_url}
                                $copyright_tpl = panda_pz('wh_footer_copyright_text');
                                if (empty($copyright_tpl)) {
                                    $copyright_tpl = '版权所有Copyright © {year} {site_title} 保留资源解释权';
                                }
                                // 从全站配置读取站点信息
                                $site_title  = esc_html(get_bloginfo('name'));
                                $site_url    = esc_url(home_url('/'));
                                $site_domain = esc_html(parse_url($site_url, PHP_URL_HOST));
                                $replaced    = strtr($copyright_tpl, array(
                                    '{year}'       => date('Y'),
                                    '{site_title}' => $site_title,
                                    '{site_domain}'=> $site_domain,
                                    '{site_url}'   => $site_url,
                                ));
                                echo '<div class="foot-copyright">' . wp_kses_post($replaced) . '</div>';
                                ?>
                            </div>
                            <div class="footer2-bottom-right">
                                <a rel="nofollow" target="__blank" href="https://beian.miit.gov.cn" class="icp-info"><?php echo esc_html(panda_pz('wh_footer_icp')); ?></a>
                                <span>数据库查询：<?php echo get_num_queries(); ?>次 页面加载耗时<?php timer_stop(3); ?> 秒</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer2>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const favoriteBtn = document.getElementById('favoriteBtn');
    if (!favoriteBtn) return; // 未启用收藏按钮时，直接退出
    const customPopup = document.getElementById('customPopup');
    const closePopup = document.getElementById('closePopup');
    const confirmBtn = document.getElementById('confirmBtn');
    const popupMessage = document.getElementById('popupMessage');
    
    // 检测浏览器类型
    const isEdge = /Edg\/\d+/.test(navigator.userAgent);
    const isChrome = /Chrome\/\d+/.test(navigator.userAgent) && !isEdge;
    const isFirefox = /Firefox\/\d+/.test(navigator.userAgent);
    const isSafari = /Safari\/\d+/.test(navigator.userAgent) && !isChrome && !isEdge;
    const isIE = /Trident\/|MSIE/.test(navigator.userAgent);
    
    // 根据浏览器显示相应的快捷键提示
    if (isEdge) {
        favoriteBtn.innerHTML += ' (Ctrl+D)';
    } else if (isSafari) {
        favoriteBtn.innerHTML += ' (⌘+D)';
    } else {
        favoriteBtn.innerHTML += ' (Ctrl+D)';
    }
    
    // 显示弹窗函数
    function showPopup(message) {
        popupMessage.innerHTML = message;
        customPopup.classList.add('active');
        // 阻止页面滚动
        document.body.style.overflow = 'hidden';
    }
    
    // 隐藏弹窗函数
    function hidePopup() {
        customPopup.classList.remove('active');
        // 恢复页面滚动
        document.body.style.overflow = '';
    }
    
    favoriteBtn.addEventListener('click', function(e) {
        e.preventDefault();
        const siteTitle = document.title || '<?php echo esc_js(panda_pz('wh_footer_site_title')); ?>';
        const siteUrl = window.location.href;
        let message = '';
        
        try {
            // 尝试调用浏览器收藏API
            if (isIE && window.external && typeof window.external.AddFavorite === 'function') {
                window.external.AddFavorite(siteUrl, siteTitle);
                return;
            } else if (isFirefox && window.sidebar && typeof window.sidebar.addPanel === 'function') {
                window.sidebar.addPanel(siteTitle, siteUrl, '');
                return;
            }
        } catch (err) {
            console.log('自动收藏失败:', err);
        }
        
        // 对于不支持自动收藏的浏览器，显示对应提示
        if (isEdge) {
            message = 'Edge浏览器支持通过快捷键收藏：<br><br>请按 <strong>Ctrl+D</strong> 键将本站添加到收藏夹';
        } else if (isChrome) {
            message = 'Chrome浏览器支持通过快捷键收藏：<br><br>请按 <strong>Ctrl+D</strong> 键将本站添加到收藏夹';
        } else if (isSafari) {
            message = 'Safari浏览器支持通过快捷键收藏：<br><br>请按 <strong>Command+D</strong> 键将本站添加到收藏夹';
        } else if (isFirefox) {
            message = 'Firefox浏览器支持通过快捷键收藏：<br><br>请按 <strong>Ctrl+D</strong> 键将本站添加到收藏夹';
        } else {
            message = '请使用快捷键添加收藏：<br><br>Windows: <strong>Ctrl+D</strong><br>Mac: <strong>Command+D</strong>';
        }
        
        showPopup(message);
    });
    
    // 关闭弹窗事件
    closePopup.addEventListener('click', hidePopup);
    confirmBtn.addEventListener('click', hidePopup);
    
    // 点击遮罩层关闭弹窗
    customPopup.addEventListener('click', function(e) {
        if (e.target === customPopup) {
            hidePopup();
        }
    });
    
    // 按ESC键关闭弹窗
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && customPopup.classList.contains('active')) {
            hidePopup();
        }
    });
});
</script>
<style>
/* 按钮核心样式与动画效果 */
.btn-fav {
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
    z-index: 1;
    /* 确保按钮内容在波纹之上 */
}

/* 鼠标悬停放大效果 */
.btn-fav:hover {
    transform: scale(1.08);
    box-shadow: 0 6px 15px rgba(59, 130, 246, 0.4);
}

/* 波纹效果容器 */
.btn-fav::before,
.btn-fav::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    background-color: rgba(59, 130, 246, 0.3);
    border-radius: 50%;
    transform: translate(-50%, -50%);
    opacity: 0;
    z-index: -1;
    animation: ripple 3s infinite;
}

/* 第二个波纹，延迟动画开始时间以形成连续效果 */
.btn-fav::after {
    animation-delay: 1s;
}

/* 波纹动画 */
@keyframes ripple {
    0% {
        width: 0;
        height: 0;
        opacity: 0.8;
    }
    100% {
        width: 300px;
        height: 300px;
        opacity: 0;
    }
}

/* 点击反馈效果 */
.btn-fav.clicked {
    transform: scale(0.95);
    background-color: #e05200;
}

.btn-fav:active::before,
.btn-fav:active::after {
    animation: none; /* 点击时暂停波纹动画 */
}

/* 自定义弹窗样式 */
.popup-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease, visibility 0.3s ease;
}

.popup-overlay.active {
    opacity: 1;
    visibility: visible;
}

.popup-container {
    /* 渐变蓝半透明背景 */
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.9), rgba(37, 99, 235, 0.95));
    border-radius: 16px; /* 圆角设计 */
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
    width: 90%;
    max-width: 400px;
    overflow: hidden;
    transform: translateY(20px);
    transition: transform 0.3s ease;
}

.popup-overlay.active .popup-container {
    transform: translateY(0);
}

.popup-header {
    padding: 18px 24px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.popup-header h3 {
    margin: 0;
    color: #fff;
    font-size: 18px;
    font-weight: 600;
}

.popup-close {
    background: none;
    border: none;
    color: rgba(255, 255, 255, 0.8);
    font-size: 24px;
    cursor: pointer;
    transition: color 0.2s ease;
    padding: 0 8px;
}

.popup-close:hover {
    color: #fff;
}

.popup-content {
    padding: 24px;
    color: #fff;
    text-align: center;
}

.popup-content p {
    margin: 0 0 20px;
    line-height: 1.6;
    font-size: 15px;
}

.popup-content strong {
    background-color: rgba(255, 255, 255, 0.2);
    padding: 2px 8px;
    border-radius: 4px;
    margin: 0 2px;
}

.popup-buttons {
    margin-top: 15px;
}

.popup-btn {
    background-color: rgba(255, 255, 255, 0.2);
    border: none;
    color: #fff;
    padding: 10px 24px;
    border-radius: 30px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.2s ease;
}

.popup-btn:hover {
    background-color: rgba(255, 255, 255, 0.3);
    transform: translateY(-2px);
}

/* 响应式调整 */
@media (max-width: 480px) {
    .popup-container {
        border-radius: 12px;
    }
    
    .popup-header, .popup-content {
        padding: 15px 20px;
    }
    
    .popup-content p {
        font-size: 14px;
    }
}
    .footer2 {
        background: #333 !important;
    }
    /* 顶部收藏区背景 */
    .footer2-fav {
        position: relative;
        overflow: hidden;
        width: 100%;
        background-image: linear-gradient(to top, #9ae8ff, transparent);
        padding: 0 15px;
        box-sizing: border-box;
    }
    @media (min-width: 768px) {
        .footer2-fav {
            display: flex;
            overflow: visible;
            width: auto;
            padding: 0;
        }
    }
    .footer2-fav .footer2-fav-top {
        display: flex;
        align-items: center;
        overflow: visible;
        padding-top: 36px;
        padding-bottom: 36px;
        justify-content: space-between;
        width: 100%;
        box-sizing: border-box;
    }
    @media (max-width: 767px) {
        .footer2-fav {
            padding-bottom: 0;
        }
        .footer2-fav .girl-info,
        .footer2-fav .site-fav,
        .footer2-fav .site-p {
            display: none !important;
        }
        .footer2-fav .site-info {
            width: 50%;
            padding-right: 10px;
            box-sizing: border-box;
        }
        .footer2-fav .site-girl {
            position: static;
            width: 50%;
            display: flex;
            align-items: flex-start;
            justify-content: flex-end;
            padding-top: 10px;
            margin-left: auto;
        }
        .footer2-fav .site-girl .girl {
            position: static;
            width: 100%;
            max-width: 140px;
            height: auto;
        }
        .footer2-fav .footer2-fav-top {
            flex-wrap: wrap;
            padding-bottom: 20px;
        }
    }
    .footer2-fav .site-info {
        width: 60%;
    }
    @media (min-width: 768px) {
        .footer2-fav .site-info {
            width: auto;
        }
    }
    .footer2-fav .site-info h2 {
        margin-bottom: 10px;
        text-transform: uppercase;
        font-size: 20px;
        line-height: 1.4;
    }
    @media (min-width: 768px) {
        .footer2-fav .site-info h2 {
            font-size: 26px;
        }
    }
    .footer2-fav .site-info h2 a {
        color: #000;
        text-decoration: none;
    }
    .footer2-fav .site-info .site-p {
        margin-bottom: 10px;
        max-width: 500px;
    }
    .footer2-fav .site-info .site-p p:first-child:after {
        content: ',';
    }
    @media (min-width: 768px) {
        .footer2-fav .site-info .site-p {
            margin-bottom: 0;
        }
        .footer2-fav .site-info .site-p p:first-child:after {
            content: '';
        }
    }
    .footer2-fav .site-info p {
        margin-bottom: 10px;
        color: #797979;
        font-size: 12px;
        line-height: 1.8;
        white-space: normal;
        word-wrap: break-word;
    }
    @media (min-width: 768px) {
        .footer2-fav .site-info p {
            display: block;
            margin-bottom: 0;
            font-size: 14px;
        }
    }
    .footer2-fav .site-fav {
        padding-top: 5px;
    }
    @media (min-width: 768px) {
        .footer2-fav .site-fav {
            padding-top: 24px;
        }
    }
    .footer2-fav .site-fav .btn-orange {
        padding: 0 1.2em;
        border-radius: 8px;
        background-color: var(--focus-color);
        color: #fff;
        font-size: 14px;
        line-height: 2.5;
        text-decoration: none;
        display: inline-block;
    }
    @media (min-width: 768px) {
        .footer2-fav .site-fav .btn-orange {
            padding: 0 2em;
            font-size: var(--hmbk--margin);
            line-height: 3.5;
        }
    }
    .footer2-fav .site-girl {
        position: absolute;
        bottom: 0;
        left: 50%;
    }
    .footer2-fav .site-girl .girl {
        position: absolute;
        bottom: 0;
        left: 50px;
        width: 180px; /* 图片容器宽度 - PC端 */
        transition: all 0.3s;
    }
    @media (min-width: 768px) {
        .footer2-fav .site-girl .girl {
            left: -50px;
        }
    }
    .footer2-fav .site-girl .girl:after {
        position: absolute;
        top: 40%;
        left: 100%;
        display: block;
        visibility: hidden;
        color: #a7a7a7;
        content: 'Hi~';
        font-size: 20px;
        opacity: 0;
        transition: all 0.3s;
    }
    
    /* 核心：确保图片完全显示的样式 */
    .thumb {
        position: relative;
        display: block;
        overflow: hidden;
        width: 100%;
        height: 0;
        background-color: transparent;
        background-position: center;
        background-size: contain; /* 改为contain确保图片完全显示 */
        background-repeat: no-repeat;
        transition: all 0.2s;
    }
    
    /* 关键：根据图片实际比例设置padding-top，确保完整显示 */
    /* 假设图片比例为3:4（宽3，高4），则padding-top = 4/3 * 100% ≈ 133.333% */
    .footer2-fav .site-girl .thumb {
        padding-top: 133.333%; /* 调整为图片实际比例 */
    }
    
    /* 核心样式调整 */
.footer2-fav .site-girl .thumb {
    padding-top: 120%; /* 根据实际图片比例调整 */
    aspect-ratio: 1/1; /* 示例比例，可替换为实际值 */
    background-size: contain;
    background-position: center center;
}

/* 移动端单独优化 */
@media (max-width: 767px) {
    .footer2-fav .site-girl .girl {
        max-width: 120px;
    }
}
    /* 移动端图片设置 */
    @media (max-width: 767px) {
        .footer2-fav .thumb {
            padding-top: 133.333%; /* 保持相同比例 */
            max-height: none; /* 移除最大高度限制 */
        }
    }
    
    .footer2-fav .site-girl .girl-info {
        margin-bottom: 55px;
        margin-left: 150px;
    }
    .footer2-fav .site-girl h4 {
        color: #797979;
        font-weight: 400;
        font-size: 14px;
        line-height: 1.8;
    }
    .footer2-fav .site-girl a {
        color: #797979;
        text-decoration: none;
    }
    .footer2-fav .site-girl a:hover {
        color: #ff5c00;
    }
    @media (min-width: 768px) {
        .footer2-fav:hover .site-girl .girl {
            left: -80px;
        }
        .footer2-fav:hover .site-girl .girl:after {
            visibility: visible;
            opacity: 1;
        }
    }
    .wrapper {
        max-width: 100%;
        margin: 0 auto;
    }
    .Onecad_fl {
        float: left;
    }
    .fr {
        float: right;
    }
    .hide_md {
        display: none;
    }
    @media (min-width: 768px) {
        .hide_md {
            display: block;
        }
    }
    #onecad_new_footer2 {
        clear: both;
    }
    #hmbk-footer2-new .hmbk-footer2 > .wrapper {
        border-bottom: 1px solid #9e9e9e3b;
    }
    .footer2 {
        padding: 0 !important;
    }
    #hmbk-footer2-new .hmbk-footer2 .widget-title {
        position: relative;
        border-bottom: 0;
        font-size: 18px;
        margin-bottom: 14px;
        color: #fff;
        text-align: left;
        margin-top: 25px;
        margin-left: 5px;
    }

    #hmbk-footer2-new .hmbk-footer2 .widget-title:before {
        position: absolute;
        bottom: -5px;
        left: 0;
        width: 40px;
        height: 2px;
        background-color: #3B82F6 !important;
        content: '';
        transition: width 0.3s ease;
    }
    .dark-theme .footer2-fav .site-info p {
    color: #fff;
    }
    .dark-theme .footer2-fav .site-girl h4 {
    color: #fff;

}

.dark-theme .footer2-fav .site-girl .girl:after {
   color: #fff;
}
    #hmbk-footer2-new .hmbk-footer2 section:hover .widget-title:before {
        width: 80px;
    }
    #hmbk-footer2-new .hmbk-footer2 .textwidget {
        padding: 10px 0;
        line-height: 26px;
    }
    /* 将“关于我们”介绍文本颜色设置为白色 */
    #hmbk-footer2-new .hmbk-footer2 #text-3 .textwidget p {
        color: #fff;
    }
    #hmbk-footer2-new .hmbk-footer2 section:first-child {
        width: 30%;
    }
    #hmbk-footer2-new .hmbk-footer2 #nav_menu-1 li {
        display: inline-block;
        width: 45%;
    }
    #hmbk-footer2-new .hmbk-footer2 #nav_menu-2,
    #hmbk-footer2-new .hmbk-footer2 #nav_menu-3,
    #hmbk-footer2-new .hmbk-footer2 #nav_menu-4 {
        width: 18%;
    }
    #hmbk-footer2-new .hmbk-footer2 .widget ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    #hmbk-footer2-new .hmbk-footer2 .widget ul li {
        position: relative;
        padding: 7px 0 8px 15px;
    }
    #hmbk-footer2-new .hmbk-footer2 .widget ul li:before {
        position: absolute;
        top: 9px;
        left: 1px;
        color: #3B82F6 !important;
        content: '•';
        font-size: 16px;
        line-height: 1;
    }
    #hmbk-footer2-new .hmbk-footer2 .hmbk-footer2-widget-in {
        display: flex;
        justify-content: space-between;
    }
    #hmbk-footer2-new .hmbk-footer2 .widget {
        padding: 0 15px;
    }
    #hmbk-footer2-new .hmbk-footer2 section {
        margin: 0;
        margin-bottom: 0;
    }
    #hmbk-footer2-new .hmbk-footer2 .hmbk-footer2-widget-in {
        margin: 0 -10px;
    }
    #hmbk-footer2-new .hmbk-footer2 section:last-child .qr-container {
        display: flex;
        width: 100%;
        justify-content: space-around;
        padding-top: 5px;
    }
    .qr-item {
        text-align: center;
        padding: 0 5px;
    }
    .qr-wrapper {
        width: 90px;
        height: 90px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        padding: 5px;
    }
    .qr-img {
        width: 100% !important;
        height: 100% !important;
        object-fit: contain;
        border-radius: 8px;
        transition: transform 0.3s ease;
    }
    .qr-img:hover {
        transform: scale(1.05);
    }
    #hmbk-footer2-new .hmbk-footer2 section:last-child .qr-tips {
        margin-top: 8px;
        max-width: 90px;
        text-align: center;
        font-size: 13px;
        line-height: 1.2em;
        margin-bottom: 0;
        color: #fff;
    }
    #hmbk-footer2-new a {
        text-decoration: none;
        transition: all 0.3s ease;
        color: #fff;
    }
    #hmbk-footer2-new a:hover {
        color: #3B82F6 !important;
        margin-left: 3px;
    }
    #hmbk-footer2-new .footer2-bottom {
        height: auto;
        line-height: 24px;
        color: #fff;
        font-size: 12px;
        padding: 15px 20px;
        background-color: #000;
        width: 100%;
        margin: 0;
        position: relative;
        left: 0;
        right: 0;
        box-sizing: border-box;
        clear: both;
    }
    .footer2-links {
        padding: 8px 16px;
        margin: 10px auto;
        max-width: var(--mian-max-width);
        background: linear-gradient(135deg, rgba(154, 232, 255, 0.3) 0, rgba(154, 232, 255, 0.1) 100%);
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }
    .link-content {
        display: flex;
        align-items: center;
        width: 100%;
        gap: 10px;
        box-sizing: border-box;
    }
    .link-heading {
        color: #fff;
        font-weight: 600;
        font-size: 14px;
        margin-right: 12px;
        white-space: nowrap;
        padding: 5px 0;
    }
    .link-items {
        display: flex;
        flex-wrap: wrap;
        row-gap: 6px;
        column-gap: 15px;
        margin: 0;
        padding: 0;
        justify-content: flex-start;
    }
    .apply-link,
    .link-items a {
        color: #f0f0f0 !important;
        font-size: 13px;
        transition: all 0.3s ease;
        text-decoration: none !important;
        white-space: nowrap;
    }
    .apply-link:hover,
    .link-items a:hover {
        color: #3B82F6 !important;
    }
    .apply-link {
        margin-left: auto;
        font-weight: 500;
        white-space: nowrap;
        background-color: rgba(59, 130, 246, 0.2);
        padding: 4px 10px;
        border-radius: 4px;
    }
    #hmbk-footer2-new .hmbk-footer2-nav .wrapper {
        padding: 0;
        max-width: none;
    }
    .footer2-bottom-container {
        max-width: var(--mian-max-width);
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 10px;
    }
    .foot-left {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    .foot-menu {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    .foot-menu a {
        color: #ccc;
        font-size: 12px;
    }
    #hmbk-footer2-new .footer2-bottom a:hover {
        color: #fff !important;
    }
    @media screen and (max-width: 768px) {
        #hmbk-footer2-new .hmbk-footer2 .hmbk-footer2-widget-in,
        .footer2-links {
            display: none !important;
        }
        #hmbk-footer2-new .hmbk-footer2 > .wrapper {
            border-bottom: none;
        }
        .hmbk-footer2-nav {
            box-sizing: border-box;
            width: 100%;
            overflow: hidden;
        }
        #hmbk-footer2-new .footer2-bottom {
            padding: 15px 20px;
        }
        .footer2-bottom-container {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        .foot-left { align-items: center; }
        .foot-menu { justify-content: center; }
        .footer2-bottom-right {
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 8px;
            justify-content: center;
            width: 100%;
        }
        .foot-copyright {
            font-size: 10px;
            line-height: 1.8em;
            word-break: break-all;
            white-space: normal;
            width: 100%;
        }
        .footer2-bottom-right {
            font-size: 10px;
            line-height: 1.8em;
        }
    }
    @media screen and (min-width: 769px) {
        #hmbk-footer2-new .hmbk-footer2 section:first-child {
            width: 25%;
        }
        #hmbk-footer2-new .hmbk-footer2 #nav_menu-2,
        #hmbk-footer2-new .hmbk-footer2 #nav_menu-3,
        #hmbk-footer2-new .hmbk-footer2 #nav_menu-4 {
            width: 15%;
        }
        .link-items {
            gap: 5px;
            margin-top: 1px;
        }
        .link-items a {
            font-size: 12px;
        }
        .footer2-bottom-container {
            flex-wrap: nowrap;
            gap: 0;
        }
        .foot-copyright {
            text-align: left;
            width: auto;
        }
        .footer2-bottom-right {
            text-align: right;
            display: flex;
            gap: 15px;
            align-items: center;
        }
    }
    .wrapper {
        margin: 0 auto;
        max-width: var(--mian-max-width);
        padding: 0 20px;
    }
    .entry-content > ol li::marker,
    .entry-content > ul li::marker {
        color: #999;
        font-family: DIN-Medium;
    }
    .widget ul li {
        font-size: 13px;
        padding: 12px 16px;
        box-sizing: border-box;
    }
    .widget ul li + li {
        margin-top: -8px;
    }
    .widget > h2 {
        font-size: 16px;
        font-weight: 600;
        line-height: 1;
    }
    .footer2 {
        font-size: 13px;
    }

    /* CSS变量定义 */
    :root {
        --focus-color: #ff5c00;
        --hmbk--margin: 14px;
        --footer2-bg: #fff;
        --mian-max-width: 1200px;
    }
    .footer{display: none;}
    
</style>
        <?php
    } else if (panda_pz('diy_footer_style') == 'simple' && !is_page('user-sign')) {
        echo '这是simple样式';
    } else if (panda_pz('diy_footer_style') == 'custom' && !is_page('user-sign')) {?>
        <style>.footer{display: none;}.footer-tabbar-placeholder{display: none;}@media (max-width: 768px){.footer-tabbar-placeholder1 {background: var(--footer-bg);height: calc(49px + constant(safe-area-inset-bottom));height: calc(49px + env(safe-area-inset-bottom))}}</style>
        <link rel="stylesheet" href="<?php echo panda_pz('static_panda');?>/assets/css/footer2.css' ?>" type="text/css">
            <footer class="footer2">
                <?php if (function_exists('dynamic_sidebar')) {
                    dynamic_sidebar('all_footer');
                } ?>
            <?php echo panda_pz('foot_custom'); ?>
            </div>
            </footer>
            <div class="footer-tabbar-placeholder1"></div>
    <?php }
} add_action('wp_footer', 'footer_style');
//二维码1
if (panda_pz('erweima1')) {
    function erweima1(){?>
    <style>.footer-miniimg{filter:hue-rotate(80deg);}</style>
    <?php }
    add_action('wp_footer', 'erweima1');
}
    
//二维码2
if (panda_pz('erweima2')) {
    function erweima2(){?>
    <style>.footer-miniimg{filter:invert(1);}</style>
    <?php }
    add_action('wp_footer', 'erweima2');
}
    //二维码3
if (panda_pz('erweima3')) {
    function erweima13(){?>
    <style>.footer-miniimg{filter:drop-shadow(0 0 10px dodgerblue);}</style>
    <?php }
    add_action('wp_footer', 'erweima13');
}

//二维码4
if (panda_pz('erweima4')) {
    function erweima4(){?>
    <style>.footer-miniimg p {position: relative;}.footer-miniimg p:hover {filter: contrast(1.1);}.footer-miniimg p:active {filter: contrast(0.9);}.footer-miniimg p::before,.footer-miniimg p::after {content: "";border: 2px solid;border-image: linear-gradient(45deg, gold, deeppink) 1;position: absolute;top: -5px;left: -5px;right: -5px;bottom: -5px;animation: clippath 3s infinite;}.footer-miniimg p::before {animation: clippath 3s infinite -1.5s linear;}@keyframes clippath {0%,100% {clip-path: inset(0 0 96% 0);filter: hue-rotate(0deg);}25% {clip-path: inset(0 96% 0 0);}50% {clip-path: inset(96% 0 0 0);filter: hue-rotate(360deg);}75% {clip-path: inset(0 0 0 96%);}}</style>
    <?php }
    add_action('wp_footer', 'erweima4');
}

//蒲公英
if (panda_pz('plbj5')) {
    function plbj5(){?>
        <link rel="stylesheet" href="<?php echo panda_pz('static_panda');?>/assets/css/pugongying.css">
        <div class="dandelion"><span class="smalldan"></span><span class="bigdan"></span></div>  
        <?php }
        add_action('wp_footer', 'plbj5');
    }
    
    //底部导航栏
    if (panda_pz('plbj4')) {
    function plbj4(){?>
        <script src="<?php echo panda_pz('static_panda');?>/assets/js/dibunav.js"></script>
        <link rel="stylesheet" href="<?php echo panda_pz('static_panda');?>/assets/css/dibunav.css">
        <div class="footwaveline">
            <i style="background-image: url(<?php echo panda_pz('static_panda');?>/assets/img/footer/dibu.png);display: inline-block;width: 200px;height: 100px;position: fixed;bottom: 0;z-index: 110;background-size: 100%;pointer-events: none;"></i>
            <div class="footwavewave" style="background: url(<?php echo panda_pz('static_panda');?>/assets/img/footer/dibu1.png) 0 0 repeat-x;height: 3px;width: 100%;position: fixed;background-size: 10px 3px;z-index: 98;bottom: 30px;"></div>
            <div id="shi" style="position: fixed;bottom: 0;margin-left: 200px;z-index: 99;">
                <h4 class="my-face" style="font-size:13px;margin:0 5px 2px 5px;color:#797979;margin-bottom: 10px;"><?php echo panda_pz('bottomnav0');?></h4>
            </div>
            <div style="width: 100%;height: 30px;position: fixed;bottom: 0;z-index: 97;box-shadow: 0 -2px 10px rgb(0 0 0 / 10%);background:#fff;">
                <nav class="joe_header__below-logon" style="float: right;margin-right: 50px;margin-top: -7px;">  
                        <span class="dz" style="display: inline-block;">
                            <a href="<?php echo panda_pz('bottomhre1');?>" data-toggle="tooltip" data-original-title="<?php echo panda_pz('bottomnav1');?>">
                            <svg class="icon" aria-hidden="true">
                                <use xlink:href="#icon-pinglun"></use>
                            </svg><?php echo panda_pz('bottomnav1');?></a>
                    </span>
                    <span class="dz" style="display: inline-block;">
                       <a href="<?php echo panda_pz('bottomhre2');?>" data-toggle="tooltip" data-original-title="<?php echo panda_pz('bottomnav2');?>">
                            <svg class="icon" aria-hidden="true">
                                <use xlink:href="#icon-pinglun"></use>
                            </svg><?php echo panda_pz('bottomnav2');?></a>
                    </span>
                        <span class="dz" style="display: inline-block;">
                    <a href="<?php echo panda_pz('bottomhre3');?>" data-toggle="tooltip" data-original-title="<?php echo panda_pz('bottomnav3');?>">
                            <svg class="icon" aria-hidden="true">
                                <use xlink:href="#icon-pinglun"></use>
                            </svg><?php echo panda_pz('bottomnav3');?></a>
                    </span>
                        <span class="dz" style="display: inline-block;">
                    <a href="<?php echo panda_pz('bottomhre4');?>" data-toggle="tooltip" data-original-title="<?php echo panda_pz('bottomnav4');?>">
                            <svg class="icon" aria-hidden="true">
                                <use xlink:href="#icon-pinglun"></use>
                            </svg><?php echo panda_pz('bottomnav4');?></a>
                    </span>
                    <span style="line-height: 45px;" class="sc">
                        <a href="<?php echo panda_pz('bottomhre5');?>" data-toggle="tooltip" data-original-title="<?php echo panda_pz('bottomnav5');?>">
                            <svg class="icon" aria-hidden="true">
                                <use xlink:href="#icon-pinglun"></use>
                            </svg><?php echo panda_pz('bottomnav5');?></a>
                    </span>
                </nav></div></div><script>$('footer').before('<span id="bottomtime"></span>');
        function NewDate(str) {
        str = str.split('-');
        var date = new Date();
        date.setUTCFullYear(str[0], str[1] - 1, str[2]);
        date.setUTCHours(0, 0, 0, 0);
        return date;}
        function momxc() {
        var birthDay =NewDate("<?php echo panda_pz('timeauthor1') ?>");
        var today=new Date();
        var timeold=today.getTime()-birthDay.getTime();
        var sectimeold=timeold/1000
        var secondsold=Math.floor(sectimeold);
        var msPerDay=24*60*60*1000; var e_daysold=timeold/msPerDay;
        var daysold=Math.floor(e_daysold);
        var e_hrsold=(daysold-e_daysold)*-24;
        var hrsold=Math.floor(e_hrsold);
        var e_minsold=(hrsold-e_hrsold)*-60;
        var minsold=Math.floor((hrsold-e_hrsold)*-60); var seconds=Math.floor((minsold-e_minsold)*-60).toString();
        seconds=seconds>9?seconds:"0"+seconds;//秒数补全
        minsold=minsold>9?minsold:"0"+minsold;//分数补全
        hrsold=hrsold>9?hrsold:"0"+hrsold;//时数补全
        <?php if(panda_pz('timeauthor1') != ''){?>
        document.getElementById("bottomtime").innerHTML = "本站已安全运行"+daysold+"天 "+hrsold+"时 "+minsold+"分 "+seconds+"秒";
        <?php }?>
        setTimeout(momxc, 1000);}momxc();
        $(document).ready(function(){if(window.screen.width < window.screen.height){
        $("#bottomtime").hide();}else{$("#bottomtime").show();}})</script>
        <style>#bottomtime{z-index:99999;animation:change 10s infinite;font-size:11px; color:cornflowerblue;display:block;bottom:7px;left:34%;width:250px;position:fixed;}@keyframes change{0%{color:#5cb85c;}25%{color:#556bd8;}50%{color:#e40707;}75%{color:#66e616;}100% {color:#67bd31;}}</style>
    <?php }add_action('wp_footer', 'plbj4');
}

//左侧显示文章热榜
if (panda_pz('article_hot_list', false)) {
    //热榜
function activity_rankings($time_range) {
    $args = array(
        'posts_per_page' => 10, // 文章数量
        'meta_key' => 'views', // 基于浏览量（需自定义实现）
        'orderby' => 'meta_value_num', // 按数字排序
        'order' => 'DESC', // 降序
    );
    $query = new WP_Query($args);

    if ($query->have_posts()) {
        echo '<div class="rank-box">';

        while ($query->have_posts()) {
            $query->the_post();
            // 链接
            echo '<a class="class-item js-rank" href="' . get_permalink() . '" target="_blank">';
            // 图像
            echo zib_post_thumbnail('','class-pic');
            // 文章信息
            echo '<div class="class-info">';
            // 标题
            echo '<div class="name">' . get_the_title() . '</div>';
            // 浏览量（自定义获取方法）
            echo '<span class="badg b-theme badg-sm">' . get_post_view_count('', '热度值') . '</span>';
            echo '</div>';
            echo '</a>';
        }

        echo '</div>';
    } else {
        // 没有找到文章
        echo '<p>没有找到相关文章。</p>';
    }
    wp_reset_postdata(); // 重置文章数据
}
function urlsssss() 
{
    $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';
    $domain = $_SERVER['HTTP_HOST'];
    $url = $protocol . $domain;
    
    echo $url;
}

function panda_sidebar_ranking(){?>
    <style>
        /*左悬浮排行榜*/
    .fix-left {
      position:fixed;
      top:<?php echo panda_pz('article_hot_list_height'); ?>px;
      left:10px;
      z-index:10;
    }
    .fix-item {
      width:50px;
      height:68px;
      background-color:#fff;
      box-shadow:0 5px 10px 0 rgba(0,0,0,.1);
      margin-bottom:20px;
      border-radius:15px;
      transition:all .2s;
    }
    .item-title {
      text-align:center;
      overflow:hidden;
      cursor:pointer;
      position:relative;
      color:#333;
    }
    img[data-v-3b17862b] {
      width:30px;
      display:block;
      margin:8px auto 0;
    }
    span[data-v-3b17862b] {
      font-size:12px;
    }
    i[data-v-3b17862b] {
      display:none;
      position:absolute;
      width:30px;
      height:30px;
      line-height:30px;
      text-align:center;
      right:0;
      top:0;
      color:#fff;
    }
    .rank-box[data-v-3b17862b] {
      display:none;
      padding:10px 10px 0 10px;
      height:350px;
      overflow-y:auto;
      background-color:#fff;
      box-shadow:0 5px 10px 0 rgba(0,0,0,.1);
      border-bottom-right-radius:15px;
      border-bottom-left-radius:15px;
    }
    .rank-box .panda_new_post_label {
        display: none;
    }
    ul[data-v-3b17862b] {
      list-style:none;
    }
    li[data-v-3b17862b] {
      border-bottom:1px solid #f3e9e961;
      padding:8px 0;
    }
    .img[data-v-3b17862b] {
      float:left;
      width:100%;
      height:100%;
      overflow:hidden;
      margin-right:8px;
    }
    .img img[data-v-3b17862b] {
      width:100%;
      height:100%;
    }
    ul li .title[data-v-3b17862b] {
      overflow:hidden;
      height:32px;
      font-size:12px;
      line-height:16px;
      color:#333;
    }
    .fix-left .fix-item.active[data-v-3b17862b] {
      width:280px;
    }
    .fix-left .fix-item.active .item-title[data-v-3b17862b] {
      height:60px;
      line-height:60px;
      background-color:#333;
      color:#fff;
      border-top-left-radius:15px;
      border-top-right-radius:15px;
    }
    .fix-left .fix-item.active .item-title img[data-v-3b17862b] {
      display:inline-block;
      margin:0 15px 0 0;
    }
    .fix-left .fix-item.active .item-title span[data-v-3b17862b] {
      font-size:14px;
    }
    .fix-left .fix-item.active .item-title i[data-v-3b17862b],.fix-left .fix-item.active .rank-box[data-v-3b17862b] {
      display:block
    }
    .enlighter-default .enlighter {
      max-height:400px;
      overflow-y:auto !important;
    }
    .posts-item .item-heading>a {
      font-weight:bold;
      color:unset;
    }
    @media (max-width:640px) {
      .meta-right .meta-view {
      display:unset !important;
    }
    }
    a.class-item.js-rank {
        display: block;
        width: 100%;
        height: 80px;
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }
    .class-info {
        width: 190px;
        font-size: 12px;
    }
    .name {
        line-height: 20px;
        font-weight: 400;
        margin-bottom: 2px;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        overflow: hidden;
        -webkit-box-orient: vertical;
        font-size: 15px;
    }
    img.class-pic {
        width: 125px;
        border-radius: 8px;
        margin-right: 10px;
        height: 80px;
    }
    a.class-item.js-rank {
        display: block;
        width: 100%;
        height: 80px;
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }
    </style>
    <div data-v-3b17862b="" class="fix-left"><div id="panda_cb_ht" data-v-3b17862b="" class="fix-item">
            <div data-v-3b17862b="" class="item-title">
                <img data-v-3b17862b="" src="<?php echo panda_pz('article_hot_lists_img');?>" >
                <span data-v-3b17862b="">
                    后退
                </span>
            </div>
        </div><div id="panda_cb_bd" data-v-3b17862b="" class="fix-item">
            <div data-v-3b17862b="" class="item-title">
                <img data-v-3b17862b="" src="<?php echo panda_pz('article_hot_list_img');?>" >
                <span id="macgf_bd_wz" data-v-3b17862b="">
                    榜单
                </span>
            </div>
            <div data-v-3b17862b="" class="rank-box">
                <ul data-v-3b17862b="">
                    <?php activity_rankings('1 month ago');; ?>
                </ul>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        // 获取元素
    var element = document.getElementById("panda_cb_bd");
    
    // 添加点击事件监听器
    element.addEventListener("click", function() {
        // 切换 class
        if (element.classList.contains("active")) {
            element.classList.remove("active");
        } else {
            element.classList.add("active");
        }
    });
    document.getElementById("panda_cb_ht").addEventListener("click", function() {
        // 跳转到指定网址
        window.location.href = "<?php echo urlsssss();?>";
    });
    document.addEventListener("DOMContentLoaded", function() {
        var divElement = document.getElementById("panda_cb_ht");
        // 获取当前页面的完整URL
        var currentPageUrl = window.location.href;
        // 指定的首页URL
        var homepageUrl = "<?php echo urlsssss();?>/";
        // 检查当前页面是否为首页
        if (currentPageUrl !== homepageUrl) {
            // 如果是首页，则显示 div 元素
            divElement.style.display = "block";
        } else {
            // 如果不是首页，则隐藏 div 元素
            divElement.style.display = "none";
        }
    });
    </script>
    <?php }
    add_action('wp_footer', 'panda_sidebar_ranking');
}

// 随便看看
if (panda_pz('suibiankankan')) {
    function random_postlite() {global $wpdb;$query = "SELECT ID FROM $wpdb->posts WHERE post_type = 'post' AND post_password = '' AND post_status = 'publish' ORDER BY RAND() LIMIT 1";$random_id = $wpdb->get_var( $query );wp_redirect( get_permalink( $random_id ) );exit;}    
    function suibiankankan() {?>
    <style>.suibianknakan{position: fixed;z-index: 999999;left: 0;top: <?php echo panda_pz('suibiankankan_height');?>px;margin-top: -36px;width: 28px;height: 70px;transition: all .3s;font-size: 12px;background: var(--main-bg-color);border-radius: 0 7px 7px 0; padding: 8px 7px;line-height: 14px;}@media screen and (max-width: 768px){.suibianknakan{display:none;}}</style>
    <a href="/?random" target="_blank" class="suibianknakan" style="font-weight:700;">随便看看</a>
    <?php }
    if( isset( $_GET['random'] ) ){
        add_action( 'template_redirect', 'random_postlite' );
    }
    add_action('wp_footer','suibiankankan');
}

//调皮小萝莉
if (panda_pz('cute_girl_img')) {
    function cute_girl_img() {?>
        <style>#tiaopill{position:fixed;bottom:40px;right:-5px;width:57px;height:70px;background-image:url(<?php echo panda_pz('static_panda');?>/assets/img/cute_girl_img.png);background-position:center;background-size:cover;background-repeat:no-repeat;transition:background .3s;z-index:99999999999999}#tiaopill:hover{background-position:60px 50%;}</style>
        <div id="tiaopill" onmouseout="duoMaomao()" style="bottom: 60vh;"></div>
        <script>var randomNum =function(minNum,maxNum) {switch (arguments.length) {case 1:return parseInt(Math.random() *minNum + 1,10);break;case 2:return parseInt(Math.random() *(maxNum - minNum + 1) + minNum,10);break;default:return 0;break;};};var duoMaomao =function() {var tiaopill =$('#tiaopill');tiaopill.css('bottom',randomNum(1,90) + 'vh');};</script>
    <?php }     add_action('wp_head', 'cute_girl_img');
}

//猫耳朵
if (panda_pz('moecat')) {
    function moecat() {?>
        <style>.dropdown-menu{margin-bottom:10px;border:none;box-sizing:border-box;padding:25px 12px 14px;border-radius:8px;background:url(<?php echo panda_pz('static_panda');?>/assets/img/bg-cat-main-code.png) no-repeat 50%;-webkit-background-size:100% 100%;-moz-background-size:100% 100%;background-size:100% 100%}.float-btn.qrcode-btn .hover-show-con{width:150px;top:-60px;padding:30px 5px 12px;text-align:center}.dropdown-menu{box-shadow:0 0 10px 8px rgb(116 116 116 / 0%);}.sidebar {height: auto;padding: 50px 0px 0px;background: url(/wp-content/plugins/ACG/img/bg-cat-main.png) center top / 100% no-repeat;transform: translate3d(0px, 0px, 0px);}</style>
    <?php } add_action('wp_head','moecat');
}

//渐变圆形悬浮按钮
if (panda_pz('xfan')) {
    function xfan() {?>
        <style>.float-right .float-btn {width: 40px;line-height: 40px;display: block;font-size: 1.4em;--this-color: #fff;--this-bg: var(--float-btn-bg);background: linear-gradient(90deg, #fdfffc73 0%, <?php echo panda_pz('xfan_color')?> 100%);position: relative;color: var(--this-color)!important;}.float-right.round .float-btn {margin-top: 5px;border-radius: 20px;}</style>
    <?php }
    add_action('wp_head', 'xfan');
    }
    
    //初一小盏风格化悬浮按钮
    if (panda_pz('vxrasxfan')) {
    function vxrasxfan() {?>
        <style>/*悬浮按钮*/
        .float-right.round .float-btn {
            position: relative;
            display: block;
            height: 56px;
            width: 56px;
            padding: 20px 4px;
            -webkit-border-radius: 50%;
            -moz-border-radius: 50%;
            border-radius: 50%;
            margin-bottom: 8px;
            font-size: 14px;
            line-height: 20px;
            text-align: center;
            color: #FFD1D8;
            background-color: #ffffff;
            -webkit-box-shadow: 0 0 6px 0 #FFD1D8;
            -moz-box-shadow: 0 0 6px 0 #FFD1D8;
            box-shadow: 0 0 6px 0 #FFD1D8;
            cursor: pointer;
            display: flex;
            justify-content: center; 
            align-items: center; 
        }
        .fa-toggle-theme::after, .fa-toggle-theme::before {
            font-size: 20px;
        }
        .float-right.round:hover .float-btn:hover {
            -moz-box-shadow: 0 0 6px 0 #FFB5C3;
            box-shadow: 0 0 6px 0 #fc6976;
                background-color: #FFB5C3;
        }
        .float-btn .hover-show-con {
            right: 40px;
            margin-right: 25px;
        }
        </style>
    <?php } add_action('wp_head', 'vxrasxfan');
}

if (panda_pz('card_extend')){
    add_filter('user_center_page_sidebar', 'zib_cardcode_user_info_tab_cardcode');
}

function panda_sidebar($con)
{

    $title = panda_pz('panda_manage_title');
    foreach (panda_pz('panda_manage_center') as $group_item) 
    {
        $buttons[] = array(
            'image' => $group_item['panda_manage_image'],
            'icon' => !empty($group_item['panda_manage_icon']) ? $group_item['panda_manage_icon'] : '',
            'name' => $group_item['panda_manage_name'],
            'url' => !empty($group_item['panda_manage_url']) ? $group_item['panda_manage_url'] : '',
            'type' => $group_item['panda_manage_lx'], 
        );
    }
    $buttons = apply_filters('manage_user_center_page_sidebar_button_2_args', $buttons);
    $buttons_html = '';
    foreach ($buttons as $but) 
    {  
        $buttons_html .= '<style>.panda-item {color: var(--theme-color);width: calc(25% - 10px);margin: 5px;min-width: 50px;max-width: 100px;cursor: pointer;}.icon{width: 1em;height: 1em;vertical-align: -0.15em;fill: currentColor;overflow: hidden;}</style>';      
        $buttons_html .= '<a class="panda-item" ';  
        if ($but['type'] == 'url') {
            $buttons_html .= 'target="_blank" href="'.$but['url'].'"';
        } elseif ($but['type'] == 'ajax') {
            $buttons_html .= 'data-class="modal-mini full-sm" href="javascript:;" data-remote="' . add_query_arg(['action' => ''.$but['url'].''], admin_url('admin-ajax.php')) . '"  data-toggle="RefreshModal"';
        }  
        if ($but['image']) { 
            $buttons_html .= '><div class="em16"><img class="icon em12" src="'.$but['image'].'"></div><div class="px12 muted-color mt3">' . $but['name'] . '</div></a>'; 
        } elseif ($but['icon']) {
            $buttons_html .= '><div class="em16"><icon>' . zib_get_cfs_icon($but['icon']) . '</icon></div><div class="px12 muted-color mt3">' . $but['name'] . '</div></a>'; 
        }
    }
    $con .= $buttons_html ? '<div class="zib-widget padding-6"><div class="padding-6 ml3">'.$title.'</div><div class="flex ac hh text-center icon-but-box user-icon-but-box">' . $buttons_html . '</div></div>' : '';
    return $con;
}
    
if (panda_pz('panda_manage_sidebar')) 
{
    add_filter('user_center_page_sidebar', 'panda_sidebar');
}
    
function zib_widget_padding_color(){
    ?>
    <style>
        .zib-widget padding-6 {
            color:red;
        }
    </style>
    <?php
}add_action('wp_head', 'zib_widget_padding_color');