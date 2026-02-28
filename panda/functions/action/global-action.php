<?php

function vue_style(){?>
    <script src="<?php echo panda_pz('static_panda');?>/assets/js/vue/vue.min.js"></script>
    <script src="<?php echo panda_pz('static_panda');?>/assets/js/vue/index.js"></script>
    <link rel="stylesheet" href="<?php echo panda_pz('static_panda');?>/assets/css/vue/index.css">
<?php }add_action('wp_footer', 'vue_style');

//小标题美化  
if (panda_pz('h2_optimize')) {
    function h2_optimize() {
        $bg_url = panda_pz('h2_optimize_image');
        ?>
        <style>
              body.home .box-body.notop {
  background:var(--main-bg-color);
  padding:5px;
  padding-left:1.2em;
  border-radius:10px;
  margin-bottom:10px;
}
body.home .title-theme {
  position:relative;
  padding-left:1.3em;
  font-size:20px;
  margin:5px;
}
body.home .title-theme::before {
  content:'';
  top:-20px;
  width:50px;
  height:50px;
  left:-28px;
  background:url('<?php echo esc_url($bg_url); ?>');
  box-shadow:0 0 black;
  background-size:cover;
}
body.home .title-theme small {
  font-size:60%;
  margin-left:20px;
}
body.home .title-theme .ml10::before {
  position:absolute;
  content:'';
  width:1px;
  background:var(--theme-color);
  top:30%;
  left:115px;
  bottom:16%;
}
        </style>
    <?php }
    add_action('wp_footer', 'h2_optimize');
}

//icon美化   
if (panda_pz('icon_optimize')) {
    $static_panda_url = panda_pz('static_panda');
    wp_enqueue_script('danmu-js', $static_panda_url . '/assets/js/svg-icon.js', array('jquery'), panda_version(), true);
}

// 友链访问数统计（全局注册 AJAX，确保前后端均可用）
add_action('wp_ajax_update_link_visit_count', 'update_link_visit_count_callback');
add_action('wp_ajax_nopriv_update_link_visit_count', 'update_link_visit_count_callback');
function update_link_visit_count_callback() {
    // 基本校验
    if (!isset($_POST['link_id']) || !is_numeric($_POST['link_id'])) {
        wp_send_json_error(array('status' => 'invalid')); return;
    }

    $link_id = (int)$_POST['link_id'];

    // 获取链接 URL：优先自定义 meta，否则回退到书签表
    $bookmark = get_bookmark($link_id);
    $link_url_meta = get_post_meta($link_id, 'link_url', true);
    $link_url = $link_url_meta ? $link_url_meta : ($bookmark && !is_wp_error($bookmark) ? $bookmark->link_url : '');

    // 计数逻辑：沿用之前的 post_meta 方案，避免破坏现有数据
    $current_visits = get_post_meta($link_id, 'link_visit_count', true);
    $new_visits = empty($current_visits) ? 1 : (int)$current_visits + 1;
    update_post_meta($link_id, 'link_visit_count', $new_visits);

    // 返回 go 路由，保持与父主题一致的外链跳转风格
    $go_link_url = '';
    if ($link_url) {
        $go_link_url = function_exists('zib_get_gourl') ? zib_get_gourl($link_url) : add_query_arg('golink', base64_encode($link_url), home_url('/'));
    }

    wp_send_json_success(array('go_link_url' => $go_link_url, 'link_url' => $link_url, 'visits' => $new_visits));
}

//全局灰色主题    
if (panda_pz('gray_theme')) {
    function gray_theme() {?>
        <style>html{-webkit-filter: grayscale(100%);filter: grayscale(100%);}</style>
    <?php }
    add_action('wp_footer', 'gray_theme');
}

//首页灰色主题
if (panda_pz('gray_index')) {
    function gray_index() {?>
        <style>html body.home{-webkit-filter: grayscale(100%);filter: grayscale(100%);}</style>
    <?php } add_action('wp_footer', 'gray_index');
}

/* 滚动条 */
switch (panda_pz('sidebar_scrollbar_style')) {
    case '1':
        function scroll_bar(){?>
            <style>::-webkit-scrollbar-thumb{background-color:<?php echo panda_pz('scrollbar_color',false);?>;height:50px;  outline-offset:-2px;  outline:2px solid #fff;  -webkit-border-radius:4px;  border: 2px solid #fff;  }  ::-webkit-scrollbar{  width:8px;  height:8px;  }  ::-webkit-scrollbar-track-piece{  background-color:#fff;  -webkit-border-radius:0;  }</style>
        <?php }
        add_action( 'wp_footer', 'scroll_bar' );
        break;
    case'2':
        function scroll_bar(){?>
            <style>::-webkit-scrollbar {width : 6px;height: 1px;}::-webkit-scrollbar-thumb {border-radius:10px;background-color: <?php echo panda_pz('scrollbar_gradient_color_1');?>;background-image: linear-gradient(0deg, <?php echo panda_pz('scrollbar_gradient_color_1');?> 0%, <?php echo panda_pz('scrollbar_gradient_color_2');?> 80%, <?php echo panda_pz('scrollbar_gradient_color_3',false);?> 100%);}::-webkit-scrollbar-track {box-shadow   : inset 0 0 10px rgb(0 0 0 / 10%);background   : #ededed;}</style>
        <?php }
        add_action( 'wp_footer', 'scroll_bar' );
        break;
    case'3':
        function scroll_bar(){?>
    <style>::-webkit-scrollbar {width: <?php echo panda_pz('scrollbar_colorful_width',false);?>px;  height: 1px;}::-webkit-scrollbar-thumb {background-color: #12b7f5;background-image: -webkit-linear-gradient(45deg, rgba(255, 93, 143, 1) 25%, transparent 25%, transparent 50%, rgba(255, 93, 143, 1) 50%, rgba(255, 93, 143, 1) 75%, transparent 75%, transparent);}::-webkit-scrollbar-track {-webkit-box-shadow: inset 0 0 5px rgba(0,0,0,0.2);background: #f6f6f6;}</style>
        <?php }
        add_action( 'wp_footer', 'scroll_bar' );
}

/* 网页动态标题 */
if (panda_pz('dynamic_title')) {
    function dynamic_title() {?>
        <script>var OriginTitile=document.title,titleTime;document.addEventListener("visibilitychange",function(){if(document.hidden){document.title="<?php echo panda_pz('dynamic_title_leave'); ?>";clearTimeout(titleTime)}else{document.title="<?php echo panda_pz('dynamic_title_back'); ?>";titleTime=setTimeout(function(){document.title=OriginTitile},2000)}});</script>
    <?php } add_action('wp_footer', 'dynamic_title');
}

/* 全局字体 */
if (panda_pz('font_family') != 'default') {
    function font_family() {
        echo '<style> @font-face{font-family:"xxx";src:url("';
        switch (panda_pz('font_family')) {
            case 'style1':
                echo ''.panda_pz('static_panda').'/assets/font/DingTalk-JinBuTi.woff2';
                break;
            case 'style2':
                echo ''.panda_pz('static_panda').'/assets/font/AlimamaShuHeiTi-Bold.woff2';
                break;               
            case 'style3':
                echo ''.panda_pz('static_panda').'/assets/font/AlimamaFangYuanTiVF-Thin.woff2';
                break;
            case 'style4':
                echo ''.panda_pz('static_panda').'/assets/font/AlimamaDongFangDaKai-Regular.woff2';
                break;
            case 'style5':
                echo ''.panda_pz('static_panda').'/assets/font/AlimamaDaoLiTi.woff2';
                break;
            case 'style6':
                echo ''.panda_pz('static_panda').'/assets/font/Alibaba_PuHuiTi_2.0_35_Thin_35_Thin.ttf';
                break;
            case 'custom':
                echo panda_pz('font_family_post');
                break;
            default:
                break;
        }
        echo '");font-weight: normal;font-style: normal;}*{font-family:"xxx"}</style>';
    } add_action('wp_footer', 'font_family');
}

/* 粒子打字效果 */
if (panda_pz('particle_effect')) {
    function particle_effect() {
        echo '<script src="'.panda_pz('static_panda').'/assets/js/particle_effect.js"></script>';
    } add_action('wp_footer', 'particle_effect');
}

/* 樱花飘落效果 */
if (panda_pz('falling_flower_style')) {
    function falling_flower_style() {
        echo '<script src="'.panda_pz('static_panda').'/assets/js/sakura.js"></script>';
    } add_action('wp_footer', 'falling_flower_style');
}

/*雪花飘落效果*/
if (panda_pz('falling_snow_style')) {
    function falling_snow_style(){?>
        <script type="text/javascript">
            (function($){
            $.fn.snow = function(options){
            var $flake = $('<div id="snowbox" />').css({'position': 'absolute','z-index':'9999', 'top': '-50px'}).html('❄'),
            documentHeight     = $(document).height(),
            documentWidth  = $(document).width(),
            defaults = {
                minSize   : 10,
                maxSize   : 20,
                newOn     : 1000,
                flakeColor : "#AFDAEF" 
            },
            options = $.extend({}, defaults, options);
            var interval= setInterval( function(){
            var startPositionLeft = Math.random() * documentWidth;
            var startPositionTop = Math.random() * documentHeight;
            startOpacity = 0.5 + Math.random(),
            sizeFlake = options.minSize + Math.random() * options.maxSize,
            endPositionTop = documentHeight - 200,
            endPositionLeft = startPositionLeft - 500 + Math.random() * 500,
            durationFall = documentHeight * 10 + Math.random() * 5000;
            $flake.clone().appendTo('body').css({
                left: startPositionLeft,
                top: startPositionTop,
                opacity: startOpacity,
                'font-size': sizeFlake,
                color: options.flakeColor
            }).animate({
                top: endPositionTop,
                left: endPositionLeft,
                opacity: 0.2
            }, durationFall, 'linear', function(){
                $(this).remove();
            });
            }, options.newOn);
                };
                })(jQuery);
            $(function(){
                $.fn.snow({
                minSize: <?php echo panda_pz('falling_snow_min_size')?>, /* 定义雪花最小尺寸 */
                maxSize: <?php echo panda_pz('falling_snow_max_size')?>,/* 定义雪花最大尺寸 */
                newOn: <?php echo panda_pz('falling_snow_new_on')?>,   /* 定义密集程度，数字越小越密集 */
                });
            });
        </script>
    <?php } add_action('wp_footer', 'falling_snow_style');
}

/* 新的雪花飘落*/
if (panda_pz('falling_snow_new_style')) {
    function falling_snow_new_style(){?>
        <style>
  .snowflake {
    position: fixed;
    top: -10px;
    background-color: white;
    border-radius: 50%;
    opacity: 0.7;
    z-index: 1000;
  }
</style>

<script>
  function createSnowflake() {
    const snowflake = document.createElement('div');
    snowflake.classList.add('snowflake');
    snowflake.style.left = Math.random() * window.innerWidth + 'px';
    snowflake.style.animationName = 'fall';
    snowflake.style.animationDuration = Math.random() * 3 + 2 + 's'; // 随机下落时间
    snowflake.style.animationTimingFunction = 'linear';
    snowflake.style.animationIterationCount = 'infinite';
    snowflake.style.animationDelay = Math.random() * 5 + 's'; // 随机延迟时间
    snowflake.style.borderRadius = '50%';
    snowflake.style.opacity = Math.random();
    snowflake.style.transform = 'scale(' + Math.random() + ')';
    snowflake.style.width = Math.random() * 10 + 'px';
    snowflake.style.height = snowflake.style.width;

    document.body.appendChild(snowflake);

    snowflake.addEventListener('animationend', function() {
      snowflake.remove();
    });
  }

  function initSnow() {
    for (let i = 0; i < '<?php echo panda_pz('falling_snow_new_num') ?>'; i++) {
      createSnowflake();
    }
  }

  const style = document.createElement('style');
  style.innerHTML = `
    @keyframes fall {
      0% { top: -10px; }
      100% { top: 100%; }
    }
  `;
  document.head.appendChild(style);
  initSnow();
</script>
    <?php } add_action('wp_footer', 'falling_snow_new_style');
}

/* 可爱的返回顶部悬挂猫 */
if (panda_pz('back_to_top_cat')) {
    function back_to_top_cat() {
        echo '<script src="'.panda_pz('static_panda').'/assets/js/cat.js"></script>
        <script type="text/javascript" src="'.panda_pz('static_panda').'/assets/js/szgotop.js"></script>
        <link rel="stylesheet" type="text/css" href="'.panda_pz('static_panda').'/assets/css/szgotop.css" /><div class="back-to-top cd-top faa-float animated cd-is-visible" style="top: -600px;"></div>';
    } add_action('wp_footer', 'back_to_top_cat');
}

/* 复制小弹窗*/
if (panda_pz('copy_notice_style')&&!panda_pz('disable_copy_style')) {
    function copy_notice_style() {?>
        <script>
          document.addEventListener("copy", function(e) {
    const selection = window.getSelection ? window.getSelection() : document.selection.createRange().text;
    const target = e.target;

    if (selection.toString() !== '') {
        new Vue({
            data: function() {
                this.$notify({
                    title: "<?php echo panda_pz('copy_notice_title'); ?>",
                    message: "<?php echo panda_pz('copy_notice_message'); ?>",
                    position: 'bottom-right',
                    offset: 50,
                    showClose: true,
                    type: "success"
                });
                return { visible: false };
            }
        });
    } else if (selection.toString() === '') {
        new Vue({
            data: function() {
                this.$notify({
                    title: "<?php echo panda_pz('copy_notice_d_title'); ?>",
                    message: "<?php echo panda_pz('copy_notice_d_message'); ?>",
                    position: 'bottom-right',
                    offset: 50,
                    showClose: true,
                    type: "error"
                });
                return { visible: false };
            }
        });
    }
});
        </script>
    <?php } add_action('wp_head', 'copy_notice_style');
}

//复制后保存原文地址
if (panda_pz('copy_save_url')&&!is_super_admin()){
    function copy_save_url() {?>
        <script src="<?php echo panda_pz('static_panda');?>/assets/js/copysite.js"></script><script>$(document).on("copy", function(e) {var selected = window.getSelection();var selectedText = selected.toString().replace(/\n/g, "<br>");var copyFooter ="<br>-----------------------------<br>" +"" +"【网站名称】：<?php bloginfo('name'); ?><br> 【文章地址】：" +document.location.href ;if (document.location.pathname === "/") {var copyFooter ="<br>-----------------------------------------<br>"  +document.location.href ;}var msgContent ='<span style="font-weight: 700;margin: 0 !important;">【<?php bloginfo('name'); ?>】<br>复制成功，若要转载请务必保留原文链接</span>' + copyFooter;layer.msg(msgContent, {time: 2000,shift: 2,shade: 0.3,skin: "wiiuii-layer-mode"});var copyHolder = $("<div>", {id: "temp",html: selectedText + copyFooter,style: {position: "absolute",left: "-99999px"}});$("body").append(copyHolder);selected.selectAllChildren(copyHolder[0]);window.setTimeout(function() {copyHolder.remove();}, 0);});</script>
    <?php }
    add_action('wp_footer', 'copy_save_url');
}

//原神启动
if (panda_pz('genshin_start_img')) {
    function yuanshen() {?>
        <style>
            body:after {
            content: " ";
            position: fixed;
            inset: 0;
            background-color: white;
            z-index: 999;
            background-image: url(<?php echo panda_pz('static_panda');?>/assets/img/yuanshen.svg);
            background-repeat: no-repeat;
            background-position: center;
            background-size: 30%;
            animation: fadeOut 3s;
            animation-fill-mode: forwards;
            -webkit-transition: fadeOut 3s;
            transition: fadeOut 3s;
            pointer-events: none;
        }
        @keyframes fadeOut {
          50% {
            opacity: 1;
          }
         
          100% {
            opacity: 0;
          }
        }
        </style>
    <?php } add_action('wp_footer', 'yuanshen');
}

//默认颜色修改
if(panda_pz('default_color_style')){
    function default_color_style() {?>
        <style>
            <?php echo panda_pz('default_color');?>
        </style>
    <?php }add_action('wp_footer', 'default_color_style');    
}

//会员购买样式
if(panda_pz('vip_buy_style')){
    if (panda_pz('vip_buy_style') == '1') {
        function vip_buy_1() {?>
            <style>.payvip-modal{background-image:url(<?php echo panda_pz('static_panda');?>/assets/img/vip/vip_bg_left.png),url(<?php echo panda_pz('static_panda');?>/assets/img/vip/vip_bg_right.png);background-position:0 100%,100% 100%;background-repeat:no-repeat,no-repeat;background-size:20%;}</style>
        <?php }add_action('wp_footer', 'vip_buy_1');
    } elseif (panda_pz('vip_buy_style') == '2') {
        function vip_buy_2() {?>
            <style>.payvip-modal{background-color:#FFF2E5;background-image:url(<?php echo panda_pz('static_panda');?>/assets/img/vip/svip_bg.png);background-size:100% auto;background-repeat:no-repeat;}</style>
        <?php }add_action('wp_footer', 'vip_buy_2');
    }

}
if (panda_pz('vip_buy_img')) {
    function vip_buy_img() {?>
        <style>.payvip-modal{background-image:url(<?php echo panda_pz('static_panda');?>/assets/img/vip/vip_bg_left.png),url(<?php echo panda_pz('static_panda');?>/assets/img/vip/vip_bg_right.png);background-position:0 100%,100% 100%;background-repeat:no-repeat,no-repeat;background-size:20%;}</style>
    <?php }add_action('wp_footer', 'vip_buy_img');
}
    
//粉色拟态化
if (panda_pz('pink_style')) {
        function pink_style() {?>
            <style>.navbar-top .navbar-right .sub-menu{box-shadow:inset 0 1px 4px 0 <?php echo panda_pz('pink_color');?>;}.card{box-shadow:inset 0 1px 4px 0 <?php echo panda_pz('pink_color'); ?>;}.zib-widget{box-shadow:inset 0 1px 4px 0 <?php echo panda_pz('pink_color'); ?>;}.plate-lists .plate-item{box-shadow:inset 0 1px 4px 0 <?php echo panda_pz('pink_color'); ?>;}.forum-posts{box-shadow:inset 0 1px 4px 0 <?php echo panda_pz('pink_color'); ?>;}.article{box-shadow:inset 0 1px 4px 0 <?php echo panda_pz('pink_color'); ?>;}.radius8{box-shadow:inset 0 1px 4px 0 <?php echo panda_pz('pink_color'); ?>;}.posts-item{box-shadow:inset 0 1px 4px 0 <?php echo panda_pz('pink_color'); ?>;}</style>
    <?php }add_action('wp_footer', 'pink_style');
}

// go跳转页面
// go.php文件

//鼠标选中文字颜色样式
if (panda_pz('hover_color_style')){
    function hover_color_style() {?>
        <style>::selection {background: transparent;color: <?php echo panda_pz('hover_color');?>}</style>
    <?php }add_action('wp_footer', 'hover_color_style');
}

//右下角提示成功美化
if(panda_pz('msg_style')=='1'){
    function right_bottom_style(){?>
    <style>
        .notyf.success {
background: linear-gradient(90deg,rgb(249 15 15 / 70%),rgba(61,189,249,.8));
border-radius: 18px 0 0 18px;
}.enlighter-default .enlighter{max-height:400px;overflow-y:auto !important;}.posts-item .item-heading>a {font-weight: bold;color: unset;}@media (max-width:640px) {
.meta-right .meta-like{
display: unset !important;
}
}
</style>
<?php }add_action('wp_footer', 'right_bottom_style');
}
if(panda_pz('msg_style')=='2'){
    $static_panda_url = panda_pz('static_panda');
    wp_enqueue_style('msg.css', $static_panda_url.'/assets/css/msg.css');
    wp_enqueue_script('msg.js', $static_panda_url.'/assets/js/msg.js', array('jquery'));
}
if(panda_pz('msg_style')=='3'){
    function msg_style3(){?>
        <style>
            .notyf {
                border-radius: var(--main-radius) 0 0 var(--main-radius);
                position: relative;
                overflow: hidden;
                backdrop-filter: blur(8px);
                box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
                transition: all 0.3s ease
            }

            .notyf:hover {
                transform: translateY(-2px);
                box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2)
            }

            @keyframes ripple {
                0% {
                    background-position: 0% 50%;
                    box-shadow: 0 0 25px rgba(255, 255, 255, 0.4)
                }

                50% {
                    background-position: 100% 50%;
                    box-shadow: 0 0 40px rgba(255, 255, 255, 0.5)
                }

                100% {
                    background-position: 0% 50%;
                    box-shadow: 0 0 25px rgba(255, 255, 255, 0.4)
                }
            }

            @keyframes shine {
                0% {
                    transform: translateX(-100%) translateY(-100%) rotate(25deg);
                    opacity: 0
                }

                25% {
                    opacity: 0.5
                }

                75% {
                    opacity: 0.5
                }

                100% {
                    transform: translateX(100%) translateY(100%) rotate(25deg);
                    opacity: 0
                }
            }

            .notyf:after {
                content: '';
                position: absolute;
                top: -50%;
                left: -50%;
                width: 200%;
                height: 200%;
                background: linear-gradient(75deg, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.2) 25%, rgba(255, 255, 255, 0.4) 50%, rgba(255, 255, 255, 0.2) 75%, rgba(255, 255, 255, 0) 100%);
                animation: shine 1.2s ease-in-out infinite
            }

            .notyf.success {
                background: linear-gradient(135deg, rgba(24, 190, 157, 0.95), rgba(46, 204, 170, 1), rgba(24, 190, 157, 0.95)) !important;
                background-size: 300% 300% !important;
                animation: ripple 1.2s ease-in-out infinite !important;
                border: 1px solid rgba(255, 255, 255, 0.3)
            }

            .notyf.info {
                background: linear-gradient(135deg, rgba(45, 152, 218, 0.95), rgba(86, 173, 225, 1), rgba(45, 152, 218, 0.95)) !important;
                background-size: 300% 300% !important;
                animation: ripple 1.2s ease-in-out infinite !important;
                border: 1px solid rgba(255, 255, 255, 0.3)
            }

            .notyf.load {
                background: linear-gradient(135deg, rgba(255, 145, 0, 0.95), rgba(255, 179, 0, 1), rgba(255, 145, 0, 0.95)) !important;
                background-size: 300% 300% !important;
                animation: ripple 1.2s ease-in-out infinite !important;
                border: 1px solid rgba(255, 255, 255, 0.3)
            }

            .notyf.warning {
                background: linear-gradient(135deg, rgba(246, 185, 59, 0.95), rgba(255, 177, 66, 1), rgba(246, 185, 59, 0.95)) !important;
                background-size: 300% 300% !important;
                animation: ripple 1.2s ease-in-out infinite !important;
                border: 1px solid rgba(255, 255, 255, 0.3)
            }

            .notyf.danger {
                background: linear-gradient(135deg, rgba(234, 84, 85, 0.95), rgba(255, 107, 107, 1), rgba(234, 84, 85, 0.95)) !important;
                background-size: 300% 300% !important;
                animation: ripple 1.2s ease-in-out infinite !important;
                border: 1px solid rgba(255, 255, 255, 0.3)
            }
        </style>
    <?php }add_action('wp_footer', 'msg_style3');
}
// 冬日奇境
if (panda_pz('theme_snowy', false)){
    // 引入静态文件
    function panda_snow_scripts() {
        // 获取资源的正确路径
        $static_panda_url = panda_pz('static_panda');
        // 加载JS和CSS文件
        wp_enqueue_script('snowfall-js', $static_panda_url . '/assets/others/snowy/snowfall.jquery.min.js', array('jquery'), null, true);
        wp_enqueue_script('snowy-script', $static_panda_url . '/assets/others/snowy/script.js', array('jquery'), null, true);
        wp_enqueue_style('snowy-style', $static_panda_url . '/assets/others/snowy/style.css');
    }
    add_action('wp_enqueue_scripts', 'panda_snow_scripts');
    
    if (panda_pz('theme_snowy_music', false)){
        // 插入所需HTML
        function panda_snow_html() {
            echo '
        <i style="display: inline-block; height: auto; position: fixed; bottom: 0; z-index: 110; margin-bottom: 20px; left: 50%; transform: translateX(-50%); transition: all 0.5s ease;">
            <div class="player">
                <div id="info" class="info">
                    <span class="artist">圣诞节 - 铃儿响叮当</span>
                    <span class="name">纯音乐</span>
                    <div class="progress-bar">
                        <span class="current-time">0:00</span>
                        <span class="duration">0:00</span>
                        <div class="bar"></div>
                    </div>
                </div>
                <div id="control-panel" class="control-panel">
                    <div class="album-art"></div>
                    <div class="controls">
                        <div class="prev"></div>
                        <div id="play" class="play"></div>
                        <div class="next"></div>
                    </div>
                </div>
            </div>
        </i>';
        }
        if (!wp_is_mobile()) {
            add_action('wp_footer', 'panda_snow_html');
        }
    }
    // 移除子比主题的go跳转调用函数
    remove_action('template_redirect', 'zib_gophp_template', 5);

    // 使用插件go跳转函数
    function panda_snow_gophp_template() {
        $golink = get_query_var('golink');
        //error_log("golink: " . print_r($golink, true)); // 添加调试信息
        if ($golink) {
            global $wp_query;
            $wp_query->is_home = false;
            $wp_query->is_page = true;
            $template = get_theme_file_path('/assets/others/snowy/snow_go.php');
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['GOLINK'] = $golink;
            load_template($template);
            exit;
        }
    }
    add_action('template_redirect', 'panda_snow_gophp_template', 5);
}


// 右键菜单
if (panda_pz('rbutton_is', false)) {
    function panda_zib_rbutton()
    {
        ?>
        <style type="text/css">
            a {text-decoration: none;}div.usercm {background-repeat: no-repeat;background-position: center center;background-size: cover;background-color: #fff;font-size: 13px!important;width: 130px;-moz-box-shadow: 1px 1px 3px rgba (0,0,0,.3);box-shadow: 0px 0px 15px <?php echo panda_pz('rbutton_yy_c');?>;position: absolute;display: none;z-index: 10000;opacity: 0.9;border-radius: 8px;}div.usercm ul {list-style-type: none;list-style-position: outside;margin: 0px;padding: 0px;display: block }div.usercm ul li {margin: 0px;padding: 0px;line-height: 35px;}div.usercm ul li a {color: <?php echo panda_pz('rbutton_zt_c');?>;padding: 0 15px;display: block }div.usercm ul li a:hover {color: #fff;background: <?php echo panda_pz('rbutton_xt_c');?> }div.usercm ul li a i {margin-right: 10px;width: 10px;}a.disabled {color: #c8c8c8!important;cursor: not-allowed }a.disabled:hover {background-color: rgba(255,11,11,0)!important }div.usercm {background: #fff !important;}
        </style>
        <div class="usercm" style="left: 199px; top: 5px; display: none;">
            <ul>
            <?php $type = panda_pz('rbutton_gn'); //功能
            if (in_array("copy", $type)) { ?>
                <li>
                    <a href="javascript:void(0);" rel="external nofollow" rel="external nofollow" onclick="getSelect();">
                        <i class="fa fa-file fa-fw"></i>
                        <span>复制</span>
                    </a>
                </li>
                <?php }
                if (in_array("refresh", $type)) { ?>
                <li>
                    <a href="javascript:window.location.reload();" rel="external nofollow">
                        <i class="fa fa-refresh fa-fw"></i>
                        <span>刷新</span>
                    </a>
                </li>
                <?php }
                if (in_array("index", $type)) { ?>
                <li>
                    <a href="/" rel="external nofollow">
                        <i class="fa fa-home fa-fw"></i>
                        <span>首页</span>
                    </a>
                </li>
                <?php }
                if (in_array("forward", $type)) { ?>
                <li>
                    <a href="javascript:history.go(1);" rel="external nofollow">
                        <i class="fa fa-arrow-right fa-fw"></i>
                        <span>前进</span>
                    </a>
                </li>
                <?php }
                if (in_array("retreat", $type)) { ?>
                <li>
                    <a href="javascript:history.go(-1);" rel="external nofollow">
                        <i class="fa fa-arrow-left fa-fw"></i>
                        <span>后退</span>
                    </a>
                </li>
                <?php }
                if (in_array("search", $type)) { ?>
                <li>
                    <a href="javascript:void(0);" onclick="baiduSearch();">
                        <i class="fa fa-search fa-fw"></i>
                        <span>搜索</span>
                    </a>
                </li>
                <?php }?>
                <li style="border-bottom:1px solid gray"></li>
                <?php 
                $list=panda_pz('rbutton_an');
                if(!empty($list)){
                    foreach($list as $val) {
                        echo '<li><a target="'.$val['link']['target'].'" href="'.$val['link']['url'].'"><i class="'.$val['icon'].'"></i><span>'.$val['name'].'</span></a></li>';
                    }
                }
                ?>
            </ul>
        </div>
        <script type="text/javascript">
            (function(a) {
                a.extend({
                    mouseMoveShow: function(b) {
                        var d = 0
                          , c = 0
                          , h = 0
                          , k = 0
                          , e = 0
                          , f = 0;
                        a(window).mousemove(function(g) {
                            d = a(window).width();
                            c = a(window).height();
                            h = g.clientX;
                            k = g.clientY;
                            e = g.pageX;
                            f = g.pageY;
                            h + a(b).width() >= d && (e = e - a(b).width() - 5);
                            k + a(b).height() >= c && (f = f - a(b).height() - 5);
                            a("html").on({
                                contextmenu: function(c) {
                                    3 == c.which && a(b).css({
                                        left: e,
                                        top: f
                                    }).show()
                                },
                                click: function() {
                                    a(b).hide()
                                }
                            })
                        })
                    },
                    disabledContextMenu: function() {
                        window.oncontextmenu = function() {
                            return !1
                        }
                    }
                })
            }
            )(jQuery);
            function getSelect() {
                "" == (window.getSelection ? window.getSelection() : document.selection.createRange().text) ? layer.msg("请选择需要搜索的内容！") : document.execCommand("Copy")
            }
            function baiduSearch() {
                var a = window.getSelection ? window.getSelection() : document.selection.createRange().text;
                "" == a ? layer.msg("请选择需要搜索的内容！") : window.open("<?php echo site_url();?>/?s=" + a)
            }

            $(function() {
                for (var a = navigator.userAgent, b = "Android;iPhone;SymbianOS;Windows Phone;iPad;iPod".split(";"), d = !0, c = 0; c < b.length; c++)
                    if (0 < a.indexOf(b[c])) {
                        d = !1;
                        break
                    }
                d && ($.mouseMoveShow(".usercm"),
                $.disabledContextMenu())
            });
        </script>
    <?php }
    add_action('wp_footer', 'panda_zib_rbutton');
}


if(panda_pz('tag_id_html', false)){
   // 修改标签链接结构
    function modify_tag_link($link, $term, $taxonomy) {
        if ($taxonomy === 'post_tag') {
            return home_url('/tag/' . $term->term_id . '/');
        }
        return $link;
    }
    add_filter('term_link', 'modify_tag_link', 10, 3);

    // 添加重写规则
    function add_tag_rewrite_rules() {
        add_rewrite_rule(
            'tag/([0-9]+)/?$',
            'index.php?tag_id=$matches[1]',
            'top'
        );
        add_rewrite_rule(
            'tag/([0-9]+)/page/([0-9]+)/?$',
            'index.php?tag_id=$matches[1]&paged=$matches[2]',
            'top'
        );
    }
    add_action('init', 'add_tag_rewrite_rules');

    // 查询变量添加 tag_id 和 paged
    function add_tag_query_vars($vars) {
        $vars[] = 'tag_id';
        $vars[] = 'paged';
        return $vars;
    }
    add_filter('query_vars', 'add_tag_query_vars');

    // 根据 tag_id 修改查询
    function modify_tag_query($query) {
        if (!is_admin() && $query->is_main_query()) {
            $tag_id = get_query_var('tag_id');
            if ($tag_id) {
                $term = get_term($tag_id, 'post_tag');
                if ($term && !is_wp_error($term)) {
                    $query->set('tag', $term->slug);
                    if (get_query_var('paged')) {
                        $query->set('paged', get_query_var('paged'));
                    }
                }
            }
        }
    }
    add_action('pre_get_posts', 'modify_tag_query');
}    


// 灵动岛
if(panda_pz('lingdongdao')){
    function lingdongdao_html() {
        ?>
            <div class="dynamic-island inactive" id="dynamicIsland" style="opacity: 0;">
                <img src="<?php echo panda_pz('static_panda');?>/assets/img/lingdongdao.png" alt="通知图标" width="30" height="30">
                <div class="island-content">
                    <div class="bars" style="line-height: 50px; margin: 0;">
                        <p style="line-height: 50px; margin: 0; font-size: 12px; padding-right: 10px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;"> 欢迎访问<?php echo get_bloginfo('name'); ?></p>
                        <div class="bar"></div>
                        <div class="bar"></div>
                        <div class="bar"></div>
                        <div class="bar"></div>
                        <div class="bar"></div>
                        <div class="bar"></div>
                        <div class="bar"></div>
                    </div>
                </div>
            </div>
        <?php
    }add_action('wp_footer', 'lingdongdao_html');
    function lingdongdao_others() {
        ?>
        <style>
            .dynamic-island:hover img {width:30px;    height:30px;;}
            .bars {display:flex;align-items:center;  justify-content:flex-end;  gap:3px;}
            .bar {width:2px;height:13px;background-color:green;animation:bounce 1s infinite ease-in-out;animation-direction:alternate;}
            .bar:nth-child(1) {animation-duration:1s;}
            .bar:nth-child(2) {animation-duration:0.9s;}
            .bar:nth-child(3) {animation-duration:0.8s;}
            .bar:nth-child(4) {animation-duration:0.7s;}
            .bar:nth-child(5) {animation-duration:0.6s;}
            .bar:nth-child(6) {animation-duration:0.9s;}
            .bar:nth-child(7) {animation-duration:0.7s;}
            .dynamic-island {position:fixed;top:80px;left:50%;transform:translateX(-50%) scale(0);    transform-origin:center;width:auto;max-width:80%;height:40px;background-color:#000;border-radius:25px;    color:white;display:flex;align-items:center;justify-content:space-between;    transition:transform 0.4s ease-in-out,height 0.6s ease-in-out,border-radius 0.6s ease-in-out,box-shadow 0.5s ease-in-out,opacity 0.5s ease-in-out;overflow:visible;    z-index:1000;padding-left:35px;    padding-right:20px;    opacity:0;box-shadow:0 0px 10px rgba(0,0,0,0.45);;}
            .dynamic-island.active {transform:translateX(-50%) scale(1);    opacity:1;}
            .dynamic-island.inactive {transform:translateX(-50%) scale(0);    opacity:0;}
            .island-content {opacity:0;transition:opacity 0.9s ease-in-out,filter 0.8s ease-in-out;    font-weight:bold;    flex-grow:1;    text-align:right;    width:100%;}
            .dynamic-island.active .island-content {opacity:1;}
            .dynamic-island img {position:absolute;left:10px;    width:20px;    height:20px;    object-fit:cover;    transition:height 0.8s ease-in-out,width 0.8s ease-in-out,filter 0.8s ease-in-out;}
            .dynamic-island:hover {height:60px;border-radius:50px;}
            @keyframes bounce {0% {transform:scaleY(0.3);background-color:green;}
            50% {transform:scaleY(1);background-color:orange;}
            100% {transform:scaleY(0.3);background-color:green;}
            ;}
        </style>
        <script type="text/javascript">
            window.onload = function() {
            triggerIsland();
            let title;
            const currentUrl = window.location.pathname;
            if (currentUrl.includes('/message/')) {
                document.querySelector('.bars p').innerText = "正在访问消息页面";
            } else if (currentUrl.includes('/user/')) {
                document.querySelector('.bars p').innerText = "欢迎来到用户中心";
            } else if (document.body.classList.contains('home') || document.body.classList.contains('front-page')) {
                document.querySelector('.bars p').innerText = "欢迎来到<?php echo get_bloginfo('name'); ?>";
            } else if (document.body.classList.contains('single')) {
                title = "<?php echo addslashes(html_entity_decode(get_the_title())); ?>";
                document.querySelector('.bars p').innerText = "正在访问：" + title;
            } else if (document.body.classList.contains('category')) {
                const category = "<?php echo addslashes(html_entity_decode(get_queried_object()->name)); ?>";
                document.querySelector('.bars p').innerText = "正在访问：" + category + " 分类";
            } else if (document.body.classList.contains('page')) {
                title = "<?php echo addslashes(html_entity_decode(get_the_title())); ?>";
                document.querySelector('.bars p').innerText = "正在访问：" + title;
            } else {
                document.querySelector('.bars p').innerText = "欢迎来到<?php echo get_bloginfo('name'); ?>";
            }
            }
            ;
            function triggerIsland() {
            const island = document.getElementById('dynamicIsland');
            if (island) {
                island.style.opacity = 1;
                island.classList.add('active')
                                island.classList.remove('inactive');
                setTimeout(() => {
                closeIsland();
                }
                , 4000);
            }
            }
            function closeIsland() {
            const island = document.getElementById('dynamicIsland')
                        if (island) {
                island.classList.remove('active');
                island.classList.add('inactive');
                setTimeout(() => {
                island.style.opacity = 0;
                }
                , 600);
            }
            }
        </script>
            <?php
    }
    add_action('wp_footer', 'lingdongdao_others');
}

// 置顶样式
if(panda_pz('top_style')){
    function top_style(){
        ?>
            <style>
                @-webkit-keyframes burn{0%{-webkit-clip-path:polygon(51% 94%,44% 93%,40% 92%,35% 89%,31% 83%,32% 77%,34% 71%,38% 62%,38% 55%,38% 47%,42% 52%,45% 56%,45% 53%,45% 47%,45% 42%,46% 40%,49% 35%,50% 44%,51% 49%,54% 54%,56% 59%,58% 62%,59% 56%,60% 52%,63% 57%,63% 62%,61% 68%,63% 72%,65% 77%,67% 81%,66% 86%,63% 90%,60% 92%);clip-path:polygon(51% 94%,44% 93%,40% 92%,35% 89%,31% 83%,32% 77%,34% 71%,38% 62%,38% 55%,38% 47%,42% 52%,45% 56%,45% 53%,45% 47%,45% 42%,46% 40%,49% 35%,50% 44%,51% 49%,54% 54%,56% 59%,58% 62%,59% 56%,60% 52%,63% 57%,63% 62%,61% 68%,63% 72%,65% 77%,67% 81%,66% 86%,63% 90%,60% 92%);}
                25%{-webkit-clip-path:polygon(49% 97%,41% 97%,35% 92%,33% 86%,34% 80%,30% 74%,34% 77%,38% 81%,38% 78%,36% 72%,35% 67%,37% 61%,37% 54%,39% 61%,39% 67%,43% 63%,43% 58%,45% 44%,44% 58%,48% 66%,51% 67%,51% 59%,54% 67%,56% 72%,57% 79%,59% 77%,60% 71%,61% 77%,61% 83%,60% 89%,61% 94%,57% 97%,52% 98%);clip-path:polygon(49% 97%,41% 97%,35% 92%,33% 86%,34% 80%,30% 74%,34% 77%,38% 81%,38% 78%,36% 72%,35% 67%,37% 61%,37% 54%,39% 61%,39% 67%,43% 63%,43% 58%,45% 44%,44% 58%,48% 66%,51% 67%,51% 59%,54% 67%,56% 72%,57% 79%,59% 77%,60% 71%,61% 77%,61% 83%,60% 89%,61% 94%,57% 97%,52% 98%);}
                50%{-webkit-clip-path:polygon(46% 97%,39% 96%,35% 89%,36% 84%,34% 77%,30% 73%,30% 65%,30% 70%,35% 75%,38% 68%,37% 61%,40% 53%,41% 42%,42% 56%,44% 65%,50% 67%,51% 57%,53% 68%,52% 74%,51% 81%,55% 78%,57% 72%,58% 79%,57% 85%,55% 88%,60% 87%,63% 82%,63% 89%,59% 94%,55% 98%,51% 92%,50% 99%,45% 96%);clip-path:polygon(46% 97%,39% 96%,35% 89%,36% 84%,34% 77%,30% 73%,30% 65%,30% 70%,35% 75%,38% 68%,37% 61%,40% 53%,41% 42%,42% 56%,44% 65%,50% 67%,51% 57%,53% 68%,52% 74%,51% 81%,55% 78%,57% 72%,58% 79%,57% 85%,55% 88%,60% 87%,63% 82%,63% 89%,59% 94%,55% 98%,51% 92%,50% 99%,45% 96%);}
                75%{-webkit-clip-path:polygon(45% 97%,38% 97%,33% 93%,31% 87%,31% 81%,29% 76%,25% 69%,29% 61%,30% 69%,35% 71%,35% 62%,34% 54%,38% 45%,38% 54%,43% 62%,47% 57%,48% 49%,44% 38%,50% 46%,53% 60%,54% 71%,53% 79%,59% 76%,60% 66%,64% 73%,63% 79%,59% 85%,64% 90%,68% 84%,68% 92%,60% 97%,53% 98%,48% 99%);clip-path:polygon(45% 97%,38% 97%,33% 93%,31% 87%,31% 81%,29% 76%,25% 69%,29% 61%,30% 69%,35% 71%,35% 62%,34% 54%,38% 45%,38% 54%,43% 62%,47% 57%,48% 49%,44% 38%,50% 46%,53% 60%,54% 71%,53% 79%,59% 76%,60% 66%,64% 73%,63% 79%,59% 85%,64% 90%,68% 84%,68% 92%,60% 97%,53% 98%,48% 99%);}
                100%{-webkit-clip-path:polygon(48% 97%,42% 97%,37% 93%,31% 92%,28% 88%,26% 81%,29% 84%,34% 84%,33% 79%,30% 74%,31% 67%,34% 57%,34% 65%,39% 71%,43% 65%,43% 55%,40% 45%,48% 59%,49% 69%,51% 76%,55% 71%,54% 65%,54% 58%,58% 64%,61% 72%,57% 82%,61% 87%,64% 78%,66% 85%,64% 93%,57% 96%,54% 93%,48% 97%);clip-path:polygon(48% 97%,42% 97%,37% 93%,31% 92%,28% 88%,26% 81%,29% 84%,34% 84%,33% 79%,30% 74%,31% 67%,34% 57%,34% 65%,39% 71%,43% 65%,43% 55%,40% 45%,48% 59%,49% 69%,51% 76%,55% 71%,54% 65%,54% 58%,58% 64%,61% 72%,57% 82%,61% 87%,64% 78%,66% 85%,64% 93%,57% 96%,54% 93%,48% 97%);}
                }
                @keyframes burn{0%{-webkit-clip-path:polygon(51% 94%,44% 93%,40% 92%,35% 89%,31% 83%,32% 77%,34% 71%,38% 62%,38% 55%,38% 47%,42% 52%,45% 56%,45% 53%,45% 47%,45% 42%,46% 40%,49% 35%,50% 44%,51% 49%,54% 54%,56% 59%,58% 62%,59% 56%,60% 52%,63% 57%,63% 62%,61% 68%,63% 72%,65% 77%,67% 81%,66% 86%,63% 90%,60% 92%);clip-path:polygon(51% 94%,44% 93%,40% 92%,35% 89%,31% 83%,32% 77%,34% 71%,38% 62%,38% 55%,38% 47%,42% 52%,45% 56%,45% 53%,45% 47%,45% 42%,46% 40%,49% 35%,50% 44%,51% 49%,54% 54%,56% 59%,58% 62%,59% 56%,60% 52%,63% 57%,63% 62%,61% 68%,63% 72%,65% 77%,67% 81%,66% 86%,63% 90%,60% 92%);}
                25%{-webkit-clip-path:polygon(49% 97%,41% 97%,35% 92%,33% 86%,34% 80%,30% 74%,34% 77%,38% 81%,38% 78%,36% 72%,35% 67%,37% 61%,37% 54%,39% 61%,39% 67%,43% 63%,43% 58%,45% 44%,44% 58%,48% 66%,51% 67%,51% 59%,54% 67%,56% 72%,57% 79%,59% 77%,60% 71%,61% 77%,61% 83%,60% 89%,61% 94%,57% 97%,52% 98%);clip-path:polygon(49% 97%,41% 97%,35% 92%,33% 86%,34% 80%,30% 74%,34% 77%,38% 81%,38% 78%,36% 72%,35% 67%,37% 61%,37% 54%,39% 61%,39% 67%,43% 63%,43% 58%,45% 44%,44% 58%,48% 66%,51% 67%,51% 59%,54% 67%,56% 72%,57% 79%,59% 77%,60% 71%,61% 77%,61% 83%,60% 89%,61% 94%,57% 97%,52% 98%);}
                50%{-webkit-clip-path:polygon(46% 97%,39% 96%,35% 89%,36% 84%,34% 77%,30% 73%,30% 65%,30% 70%,35% 75%,38% 68%,37% 61%,40% 53%,41% 42%,42% 56%,44% 65%,50% 67%,51% 57%,53% 68%,52% 74%,51% 81%,55% 78%,57% 72%,58% 79%,57% 85%,55% 88%,60% 87%,63% 82%,63% 89%,59% 94%,55% 98%,51% 92%,50% 99%,45% 96%);clip-path:polygon(46% 97%,39% 96%,35% 89%,36% 84%,34% 77%,30% 73%,30% 65%,30% 70%,35% 75%,38% 68%,37% 61%,40% 53%,41% 42%,42% 56%,44% 65%,50% 67%,51% 57%,53% 68%,52% 74%,51% 81%,55% 78%,57% 72%,58% 79%,57% 85%,55% 88%,60% 87%,63% 82%,63% 89%,59% 94%,55% 98%,51% 92%,50% 99%,45% 96%);}
                75%{-webkit-clip-path:polygon(45% 97%,38% 97%,33% 93%,31% 87%,31% 81%,29% 76%,25% 69%,29% 61%,30% 69%,35% 71%,35% 62%,34% 54%,38% 45%,38% 54%,43% 62%,47% 57%,48% 49%,44% 38%,50% 46%,53% 60%,54% 71%,53% 79%,59% 76%,60% 66%,64% 73%,63% 79%,59% 85%,64% 90%,68% 84%,68% 92%,60% 97%,53% 98%,48% 99%);clip-path:polygon(45% 97%,38% 97%,33% 93%,31% 87%,31% 81%,29% 76%,25% 69%,29% 61%,30% 69%,35% 71%,35% 62%,34% 54%,38% 45%,38% 54%,43% 62%,47% 57%,48% 49%,44% 38%,50% 46%,53% 60%,54% 71%,53% 79%,59% 76%,60% 66%,64% 73%,63% 79%,59% 85%,64% 90%,68% 84%,68% 92%,60% 97%,53% 98%,48% 99%);}
                100%{-webkit-clip-path:polygon(48% 97%,42% 97%,37% 93%,31% 92%,28% 88%,26% 81%,29% 84%,34% 84%,33% 79%,30% 74%,31% 67%,34% 57%,34% 65%,39% 71%,43% 65%,43% 55%,40% 45%,48% 59%,49% 69%,51% 76%,55% 71%,54% 65%,54% 58%,58% 64%,61% 72%,57% 82%,61% 87%,64% 78%,66% 85%,64% 93%,57% 96%,54% 93%,48% 97%);clip-path:polygon(48% 97%,42% 97%,37% 93%,31% 92%,28% 88%,26% 81%,29% 84%,34% 84%,33% 79%,30% 74%,31% 67%,34% 57%,34% 65%,39% 71%,43% 65%,43% 55%,40% 45%,48% 59%,49% 69%,51% 76%,55% 71%,54% 65%,54% 58%,58% 64%,61% 72%,57% 82%,61% 87%,64% 78%,66% 85%,64% 93%,57% 96%,54% 93%,48% 97%);}
                }
                @-webkit-keyframes burn_alt{0%{-webkit-clip-path:polygon(48% 97%,43% 97%,38% 97%,34% 94%,33% 91%,32% 87%,29% 83%,26% 80%,21% 75%,20% 71%,20% 66%,20% 59%,20% 65%,24% 68%,28% 67%,28% 62%,25% 60%,21% 52%,21% 43%,24% 32%,23% 39%,24% 46%,28% 48%,33% 44%,33% 39%,31% 32%,28% 23%,30% 14%,31% 22%,35% 28%,39% 28%,41% 25%,40% 21%,39% 13%,41% 6%,42% 15%,45% 23%,49% 25%,52% 22%,51% 13%,54% 21%,56% 29%,53% 35%,50% 41%,53% 46%,58% 46%,60% 39%,60% 34%,64% 39%,65% 45%,63% 51%,61% 56%,64% 61%,68% 59%,71% 55%,73% 48%,73% 40%,76% 48%,77% 56%,76% 62%,74% 66%,69% 71%,71% 74%,75% 74%,79% 71%,81% 65%,82% 72%,81% 77%,77% 82%,73% 86%,73% 89%,78% 89%,82% 85%,81% 91%,78% 95%,72% 97%,65% 98%,59% 98%,53% 99%,47% 97%);clip-path:polygon(48% 97%,43% 97%,38% 97%,34% 94%,33% 91%,32% 87%,29% 83%,26% 80%,21% 75%,20% 71%,20% 66%,20% 59%,20% 65%,24% 68%,28% 67%,28% 62%,25% 60%,21% 52%,21% 43%,24% 32%,23% 39%,24% 46%,28% 48%,33% 44%,33% 39%,31% 32%,28% 23%,30% 14%,31% 22%,35% 28%,39% 28%,41% 25%,40% 21%,39% 13%,41% 6%,42% 15%,45% 23%,49% 25%,52% 22%,51% 13%,54% 21%,56% 29%,53% 35%,50% 41%,53% 46%,58% 46%,60% 39%,60% 34%,64% 39%,65% 45%,63% 51%,61% 56%,64% 61%,68% 59%,71% 55%,73% 48%,73% 40%,76% 48%,77% 56%,76% 62%,74% 66%,69% 71%,71% 74%,75% 74%,79% 71%,81% 65%,82% 72%,81% 77%,77% 82%,73% 86%,73% 89%,78% 89%,82% 85%,81% 91%,78% 95%,72% 97%,65% 98%,59% 98%,53% 99%,47% 97%);}
                25%{-webkit-clip-path:polygon(44% 99%,41% 99%,35% 98%,29% 97%,24% 93%,21% 86%,20% 80%,16% 74%,16% 64%,16% 71%,21% 75%,25% 72%,25% 65%,22% 59%,19% 53%,19% 44%,21% 52%,25% 59%,29% 57%,29% 51%,26% 44%,26% 38%,30% 32%,31% 26%,30% 18%,34% 25%,33% 35%,33% 44%,34% 50%,39% 53%,44% 52%,45% 49%,44% 44%,42% 38%,44% 33%,48% 26%,45% 35%,47% 41%,50% 44%,51% 52%,49% 60%,48% 65%,53% 69%,58% 65%,57% 59%,58% 51%,62% 41%,66% 40%,64% 47%,61% 58%,63% 66%,66% 68%,70% 67%,72% 62%,73% 57%,71% 48%,75% 53%,79% 57%,79% 64%,76% 70%,72% 75%,70% 78%,74% 80%,78% 79%,82% 76%,84% 71%,85% 66%,84% 62%,88% 67%,89% 72%,89% 79%,87% 83%,84% 89%,81% 93%,76% 97%,69% 98%,60% 99%,54% 99%,48% 100%,45% 97%);clip-path:polygon(44% 99%,41% 99%,35% 98%,29% 97%,24% 93%,21% 86%,20% 80%,16% 74%,16% 64%,16% 71%,21% 75%,25% 72%,25% 65%,22% 59%,19% 53%,19% 44%,21% 52%,25% 59%,29% 57%,29% 51%,26% 44%,26% 38%,30% 32%,31% 26%,30% 18%,34% 25%,33% 35%,33% 44%,34% 50%,39% 53%,44% 52%,45% 49%,44% 44%,42% 38%,44% 33%,48% 26%,45% 35%,47% 41%,50% 44%,51% 52%,49% 60%,48% 65%,53% 69%,58% 65%,57% 59%,58% 51%,62% 41%,66% 40%,64% 47%,61% 58%,63% 66%,66% 68%,70% 67%,72% 62%,73% 57%,71% 48%,75% 53%,79% 57%,79% 64%,76% 70%,72% 75%,70% 78%,74% 80%,78% 79%,82% 76%,84% 71%,85% 66%,84% 62%,88% 67%,89% 72%,89% 79%,87% 83%,84% 89%,81% 93%,76% 97%,69% 98%,60% 99%,54% 99%,48% 100%,45% 97%);}
                50%{-webkit-clip-path:polygon(45% 99%,40% 98%,34% 98%,31% 96%,28% 93%,26% 89%,27% 84%,26% 81%,23% 77%,20% 73%,18% 70%,19% 65%,19% 60%,20% 53%,20% 43%,24% 41%,28% 32%,28% 40%,28% 48%,29% 53%,33% 52%,35% 49%,36% 42%,36% 35%,36% 27%,39% 19%,42% 12%,40% 23%,39% 29%,41% 37%,43% 41%,44% 47%,45% 52%,47% 55%,50% 57%,52% 54%,53% 48%,52% 42%,51% 33%,50% 26%,54% 36%,55% 39%,57% 46%,57% 52%,55% 58%,55% 61%,58% 65%,62% 64%,64% 60%,65% 54%,64% 49%,65% 43%,68% 38%,67% 44%,69% 51%,72% 53%,72% 59%,70% 65%,68% 69%,68% 74%,71% 75%,74% 73%,76% 69%,78% 63%,82% 58%,81% 63%,81% 69%,81% 75%,76% 80%,75% 85%,79% 87%,82% 84%,83% 91%,79% 94%,75% 96%,71% 97%,64% 98%,58% 99%,53% 98%,46% 100%);clip-path:polygon(45% 99%,40% 98%,34% 98%,31% 96%,28% 93%,26% 89%,27% 84%,26% 81%,23% 77%,20% 73%,18% 70%,19% 65%,19% 60%,20% 53%,20% 43%,24% 41%,28% 32%,28% 40%,28% 48%,29% 53%,33% 52%,35% 49%,36% 42%,36% 35%,36% 27%,39% 19%,42% 12%,40% 23%,39% 29%,41% 37%,43% 41%,44% 47%,45% 52%,47% 55%,50% 57%,52% 54%,53% 48%,52% 42%,51% 33%,50% 26%,54% 36%,55% 39%,57% 46%,57% 52%,55% 58%,55% 61%,58% 65%,62% 64%,64% 60%,65% 54%,64% 49%,65% 43%,68% 38%,67% 44%,69% 51%,72% 53%,72% 59%,70% 65%,68% 69%,68% 74%,71% 75%,74% 73%,76% 69%,78% 63%,82% 58%,81% 63%,81% 69%,81% 75%,76% 80%,75% 85%,79% 87%,82% 84%,83% 91%,79% 94%,75% 96%,71% 97%,64% 98%,58% 99%,53% 98%,46% 100%);}
                75%{-webkit-clip-path:polygon(45% 99%,41% 99%,35% 98%,30% 98%,25% 94%,22% 89%,21% 84%,23% 77%,23% 70%,19% 63%,23% 66%,27% 71%,28% 76%,32% 78%,35% 72%,32% 67%,28% 64%,24% 58%,24% 49%,27% 42%,30% 34%,31% 24%,29% 13%,33% 18%,38% 25%,38% 36%,37% 44%,41% 48%,45% 48%,48% 45%,48% 39%,46% 33%,48% 27%,52% 20%,50% 29%,51% 38%,53% 44%,54% 52%,56% 57%,61% 57%,64% 55%,65% 48%,63% 39%,63% 32%,66% 37%,69% 44%,70% 52%,68% 59%,66% 64%,67% 69%,73% 72%,76% 71%,77% 66%,76% 58%,76% 51%,80% 57%,82% 62%,82% 68%,80% 73%,77% 78%,74% 82%,75% 87%,78% 87%,81% 84%,84% 79%,86% 74%,88% 78%,87% 83%,84% 89%,82% 92%,78% 97%,74% 97%,69% 97%,66% 98%,61% 98%,57% 97%,53% 99%,49% 96%,47% 99%,48% 99%);clip-path:polygon(45% 99%,41% 99%,35% 98%,30% 98%,25% 94%,22% 89%,21% 84%,23% 77%,23% 70%,19% 63%,23% 66%,27% 71%,28% 76%,32% 78%,35% 72%,32% 67%,28% 64%,24% 58%,24% 49%,27% 42%,30% 34%,31% 24%,29% 13%,33% 18%,38% 25%,38% 36%,37% 44%,41% 48%,45% 48%,48% 45%,48% 39%,46% 33%,48% 27%,52% 20%,50% 29%,51% 38%,53% 44%,54% 52%,56% 57%,61% 57%,64% 55%,65% 48%,63% 39%,63% 32%,66% 37%,69% 44%,70% 52%,68% 59%,66% 64%,67% 69%,73% 72%,76% 71%,77% 66%,76% 58%,76% 51%,80% 57%,82% 62%,82% 68%,80% 73%,77% 78%,74% 82%,75% 87%,78% 87%,81% 84%,84% 79%,86% 74%,88% 78%,87% 83%,84% 89%,82% 92%,78% 97%,74% 97%,69% 97%,66% 98%,61% 98%,57% 97%,53% 99%,49% 96%,47% 99%,48% 99%);}
                100%{-webkit-clip-path:polygon(47% 99%,42% 99%,37% 98%,32% 96%,28% 92%,26% 89%,26% 83%,26% 80%,26% 72%,23% 67%,16% 63%,14% 52%,16% 46%,16% 53%,20% 60%,26% 58%,27% 51%,25% 46%,20% 41%,19% 36%,19% 30%,21% 26%,24% 20%,23% 13%,22% 7%,26% 11%,28% 17%,28% 24%,26% 30%,30% 34%,34% 34%,39% 32%,40% 27%,38% 21%,43% 28%,43% 36%,41% 41%,46% 44%,51% 41%,53% 35%,53% 26%,57% 26%,59% 33%,60% 39%,57% 46%,55% 53%,58% 57%,64% 56%,66% 52%,69% 41%,70% 48%,69% 56%,66% 63%,64% 67%,65% 71%,70% 71%,74% 68%,76% 62%,77% 54%,79% 60%,81% 66%,80% 71%,76% 75%,72% 78%,71% 82%,75% 84%,80% 83%,84% 78%,86% 83%,83% 89%,78% 92%,74% 92%,73% 96%,69% 97%,65% 96%,62% 98%,57% 99%,54% 97%,51% 99%,46% 99%);clip-path:polygon(47% 99%,42% 99%,37% 98%,32% 96%,28% 92%,26% 89%,26% 83%,26% 80%,26% 72%,23% 67%,16% 63%,14% 52%,16% 46%,16% 53%,20% 60%,26% 58%,27% 51%,25% 46%,20% 41%,19% 36%,19% 30%,21% 26%,24% 20%,23% 13%,22% 7%,26% 11%,28% 17%,28% 24%,26% 30%,30% 34%,34% 34%,39% 32%,40% 27%,38% 21%,43% 28%,43% 36%,41% 41%,46% 44%,51% 41%,53% 35%,53% 26%,57% 26%,59% 33%,60% 39%,57% 46%,55% 53%,58% 57%,64% 56%,66% 52%,69% 41%,70% 48%,69% 56%,66% 63%,64% 67%,65% 71%,70% 71%,74% 68%,76% 62%,77% 54%,79% 60%,81% 66%,80% 71%,76% 75%,72% 78%,71% 82%,75% 84%,80% 83%,84% 78%,86% 83%,83% 89%,78% 92%,74% 92%,73% 96%,69% 97%,65% 96%,62% 98%,57% 99%,54% 97%,51% 99%,46% 99%);}
                }
                @keyframes burn_alt{0%{-webkit-clip-path:polygon(48% 97%,43% 97%,38% 97%,34% 94%,33% 91%,32% 87%,29% 83%,26% 80%,21% 75%,20% 71%,20% 66%,20% 59%,20% 65%,24% 68%,28% 67%,28% 62%,25% 60%,21% 52%,21% 43%,24% 32%,23% 39%,24% 46%,28% 48%,33% 44%,33% 39%,31% 32%,28% 23%,30% 14%,31% 22%,35% 28%,39% 28%,41% 25%,40% 21%,39% 13%,41% 6%,42% 15%,45% 23%,49% 25%,52% 22%,51% 13%,54% 21%,56% 29%,53% 35%,50% 41%,53% 46%,58% 46%,60% 39%,60% 34%,64% 39%,65% 45%,63% 51%,61% 56%,64% 61%,68% 59%,71% 55%,73% 48%,73% 40%,76% 48%,77% 56%,76% 62%,74% 66%,69% 71%,71% 74%,75% 74%,79% 71%,81% 65%,82% 72%,81% 77%,77% 82%,73% 86%,73% 89%,78% 89%,82% 85%,81% 91%,78% 95%,72% 97%,65% 98%,59% 98%,53% 99%,47% 97%);clip-path:polygon(48% 97%,43% 97%,38% 97%,34% 94%,33% 91%,32% 87%,29% 83%,26% 80%,21% 75%,20% 71%,20% 66%,20% 59%,20% 65%,24% 68%,28% 67%,28% 62%,25% 60%,21% 52%,21% 43%,24% 32%,23% 39%,24% 46%,28% 48%,33% 44%,33% 39%,31% 32%,28% 23%,30% 14%,31% 22%,35% 28%,39% 28%,41% 25%,40% 21%,39% 13%,41% 6%,42% 15%,45% 23%,49% 25%,52% 22%,51% 13%,54% 21%,56% 29%,53% 35%,50% 41%,53% 46%,58% 46%,60% 39%,60% 34%,64% 39%,65% 45%,63% 51%,61% 56%,64% 61%,68% 59%,71% 55%,73% 48%,73% 40%,76% 48%,77% 56%,76% 62%,74% 66%,69% 71%,71% 74%,75% 74%,79% 71%,81% 65%,82% 72%,81% 77%,77% 82%,73% 86%,73% 89%,78% 89%,82% 85%,81% 91%,78% 95%,72% 97%,65% 98%,59% 98%,53% 99%,47% 97%);}
                25%{-webkit-clip-path:polygon(44% 99%,41% 99%,35% 98%,29% 97%,24% 93%,21% 86%,20% 80%,16% 74%,16% 64%,16% 71%,21% 75%,25% 72%,25% 65%,22% 59%,19% 53%,19% 44%,21% 52%,25% 59%,29% 57%,29% 51%,26% 44%,26% 38%,30% 32%,31% 26%,30% 18%,34% 25%,33% 35%,33% 44%,34% 50%,39% 53%,44% 52%,45% 49%,44% 44%,42% 38%,44% 33%,48% 26%,45% 35%,47% 41%,50% 44%,51% 52%,49% 60%,48% 65%,53% 69%,58% 65%,57% 59%,58% 51%,62% 41%,66% 40%,64% 47%,61% 58%,63% 66%,66% 68%,70% 67%,72% 62%,73% 57%,71% 48%,75% 53%,79% 57%,79% 64%,76% 70%,72% 75%,70% 78%,74% 80%,78% 79%,82% 76%,84% 71%,85% 66%,84% 62%,88% 67%,89% 72%,89% 79%,87% 83%,84% 89%,81% 93%,76% 97%,69% 98%,60% 99%,54% 99%,48% 100%,45% 97%);clip-path:polygon(44% 99%,41% 99%,35% 98%,29% 97%,24% 93%,21% 86%,20% 80%,16% 74%,16% 64%,16% 71%,21% 75%,25% 72%,25% 65%,22% 59%,19% 53%,19% 44%,21% 52%,25% 59%,29% 57%,29% 51%,26% 44%,26% 38%,30% 32%,31% 26%,30% 18%,34% 25%,33% 35%,33% 44%,34% 50%,39% 53%,44% 52%,45% 49%,44% 44%,42% 38%,44% 33%,48% 26%,45% 35%,47% 41%,50% 44%,51% 52%,49% 60%,48% 65%,53% 69%,58% 65%,57% 59%,58% 51%,62% 41%,66% 40%,64% 47%,61% 58%,63% 66%,66% 68%,70% 67%,72% 62%,73% 57%,71% 48%,75% 53%,79% 57%,79% 64%,76% 70%,72% 75%,70% 78%,74% 80%,78% 79%,82% 76%,84% 71%,85% 66%,84% 62%,88% 67%,89% 72%,89% 79%,87% 83%,84% 89%,81% 93%,76% 97%,69% 98%,60% 99%,54% 99%,48% 100%,45% 97%);}
                50%{-webkit-clip-path:polygon(45% 99%,40% 98%,34% 98%,31% 96%,28% 93%,26% 89%,27% 84%,26% 81%,23% 77%,20% 73%,18% 70%,19% 65%,19% 60%,20% 53%,20% 43%,24% 41%,28% 32%,28% 40%,28% 48%,29% 53%,33% 52%,35% 49%,36% 42%,36% 35%,36% 27%,39% 19%,42% 12%,40% 23%,39% 29%,41% 37%,43% 41%,44% 47%,45% 52%,47% 55%,50% 57%,52% 54%,53% 48%,52% 42%,51% 33%,50% 26%,54% 36%,55% 39%,57% 46%,57% 52%,55% 58%,55% 61%,58% 65%,62% 64%,64% 60%,65% 54%,64% 49%,65% 43%,68% 38%,67% 44%,69% 51%,72% 53%,72% 59%,70% 65%,68% 69%,68% 74%,71% 75%,74% 73%,76% 69%,78% 63%,82% 58%,81% 63%,81% 69%,81% 75%,76% 80%,75% 85%,79% 87%,82% 84%,83% 91%,79% 94%,75% 96%,71% 97%,64% 98%,58% 99%,53% 98%,46% 100%);clip-path:polygon(45% 99%,40% 98%,34% 98%,31% 96%,28% 93%,26% 89%,27% 84%,26% 81%,23% 77%,20% 73%,18% 70%,19% 65%,19% 60%,20% 53%,20% 43%,24% 41%,28% 32%,28% 40%,28% 48%,29% 53%,33% 52%,35% 49%,36% 42%,36% 35%,36% 27%,39% 19%,42% 12%,40% 23%,39% 29%,41% 37%,43% 41%,44% 47%,45% 52%,47% 55%,50% 57%,52% 54%,53% 48%,52% 42%,51% 33%,50% 26%,54% 36%,55% 39%,57% 46%,57% 52%,55% 58%,55% 61%,58% 65%,62% 64%,64% 60%,65% 54%,64% 49%,65% 43%,68% 38%,67% 44%,69% 51%,72% 53%,72% 59%,70% 65%,68% 69%,68% 74%,71% 75%,74% 73%,76% 69%,78% 63%,82% 58%,81% 63%,81% 69%,81% 75%,76% 80%,75% 85%,79% 87%,82% 84%,83% 91%,79% 94%,75% 96%,71% 97%,64% 98%,58% 99%,53% 98%,46% 100%);}
                75%{-webkit-clip-path:polygon(45% 99%,41% 99%,35% 98%,30% 98%,25% 94%,22% 89%,21% 84%,23% 77%,23% 70%,19% 63%,23% 66%,27% 71%,28% 76%,32% 78%,35% 72%,32% 67%,28% 64%,24% 58%,24% 49%,27% 42%,30% 34%,31% 24%,29% 13%,33% 18%,38% 25%,38% 36%,37% 44%,41% 48%,45% 48%,48% 45%,48% 39%,46% 33%,48% 27%,52% 20%,50% 29%,51% 38%,53% 44%,54% 52%,56% 57%,61% 57%,64% 55%,65% 48%,63% 39%,63% 32%,66% 37%,69% 44%,70% 52%,68% 59%,66% 64%,67% 69%,73% 72%,76% 71%,77% 66%,76% 58%,76% 51%,80% 57%,82% 62%,82% 68%,80% 73%,77% 78%,74% 82%,75% 87%,78% 87%,81% 84%,84% 79%,86% 74%,88% 78%,87% 83%,84% 89%,82% 92%,78% 97%,74% 97%,69% 97%,66% 98%,61% 98%,57% 97%,53% 99%,49% 96%,47% 99%,48% 99%);clip-path:polygon(45% 99%,41% 99%,35% 98%,30% 98%,25% 94%,22% 89%,21% 84%,23% 77%,23% 70%,19% 63%,23% 66%,27% 71%,28% 76%,32% 78%,35% 72%,32% 67%,28% 64%,24% 58%,24% 49%,27% 42%,30% 34%,31% 24%,29% 13%,33% 18%,38% 25%,38% 36%,37% 44%,41% 48%,45% 48%,48% 45%,48% 39%,46% 33%,48% 27%,52% 20%,50% 29%,51% 38%,53% 44%,54% 52%,56% 57%,61% 57%,64% 55%,65% 48%,63% 39%,63% 32%,66% 37%,69% 44%,70% 52%,68% 59%,66% 64%,67% 69%,73% 72%,76% 71%,77% 66%,76% 58%,76% 51%,80% 57%,82% 62%,82% 68%,80% 73%,77% 78%,74% 82%,75% 87%,78% 87%,81% 84%,84% 79%,86% 74%,88% 78%,87% 83%,84% 89%,82% 92%,78% 97%,74% 97%,69% 97%,66% 98%,61% 98%,57% 97%,53% 99%,49% 96%,47% 99%,48% 99%);}
                100%{-webkit-clip-path:polygon(47% 99%,42% 99%,37% 98%,32% 96%,28% 92%,26% 89%,26% 83%,26% 80%,26% 72%,23% 67%,16% 63%,14% 52%,16% 46%,16% 53%,20% 60%,26% 58%,27% 51%,25% 46%,20% 41%,19% 36%,19% 30%,21% 26%,24% 20%,23% 13%,22% 7%,26% 11%,28% 17%,28% 24%,26% 30%,30% 34%,34% 34%,39% 32%,40% 27%,38% 21%,43% 28%,43% 36%,41% 41%,46% 44%,51% 41%,53% 35%,53% 26%,57% 26%,59% 33%,60% 39%,57% 46%,55% 53%,58% 57%,64% 56%,66% 52%,69% 41%,70% 48%,69% 56%,66% 63%,64% 67%,65% 71%,70% 71%,74% 68%,76% 62%,77% 54%,79% 60%,81% 66%,80% 71%,76% 75%,72% 78%,71% 82%,75% 84%,80% 83%,84% 78%,86% 83%,83% 89%,78% 92%,74% 92%,73% 96%,69% 97%,65% 96%,62% 98%,57% 99%,54% 97%,51% 99%,46% 99%);clip-path:polygon(47% 99%,42% 99%,37% 98%,32% 96%,28% 92%,26% 89%,26% 83%,26% 80%,26% 72%,23% 67%,16% 63%,14% 52%,16% 46%,16% 53%,20% 60%,26% 58%,27% 51%,25% 46%,20% 41%,19% 36%,19% 30%,21% 26%,24% 20%,23% 13%,22% 7%,26% 11%,28% 17%,28% 24%,26% 30%,30% 34%,34% 34%,39% 32%,40% 27%,38% 21%,43% 28%,43% 36%,41% 41%,46% 44%,51% 41%,53% 35%,53% 26%,57% 26%,59% 33%,60% 39%,57% 46%,55% 53%,58% 57%,64% 56%,66% 52%,69% 41%,70% 48%,69% 56%,66% 63%,64% 67%,65% 71%,70% 71%,74% 68%,76% 62%,77% 54%,79% 60%,81% 66%,80% 71%,76% 75%,72% 78%,71% 82%,75% 84%,80% 83%,84% 78%,86% 83%,83% 89%,78% 92%,74% 92%,73% 96%,69% 97%,65% 96%,62% 98%,57% 99%,54% 97%,51% 99%,46% 99%);}
                }
                .posts-item.card.ajax-item .img-badge.left.jb-red,.posts-item.card.ajax-item .item-thumbnail .img-badge.left.jb-red,.posts-item.list.ajax-item.flex .post-graphic .img-badge.left.jb-red{font-size:14px;padding:0 5px;background:linear-gradient(to right,#FF5722,#ff9800,#FFC107)!important;border-radius:9px 5px 5px 9px;color:#fff;padding-right:10px;}
                .posts-item.card.ajax-item .img-badge.left.jb-red:before,.posts-item.card.ajax-item .item-thumbnail .img-badge.left.jb-red:before,.posts-item.list.ajax-item.flex .post-graphic .img-badge.left.jb-red:before{-webkit-animation:burn 0.9s linear alternate infinite;animation:burn .9s linear alternate infinite;right:-43px;top:-26px;z-index:2;background:linear-gradient(0deg,#ffb305 10%,#FF9800 20%,#E91E63 50%,#e91e1e 99%);opacity:0.7;position:absolute;content:"";transform:rotate(90deg);height:70px;width:35px;}
                .posts-item.card.ajax-item .img-badge.left.jb-red:after,.posts-item.card.ajax-item .item-thumbnail .img-badge.left.jb-red:after,.posts-item.list.ajax-item.flex .post-graphic .img-badge.left.jb-red:after{z-index:1;opacity:1;-webkit-animation:burn_alt .7s linear alternate infinite;animation:burn_alt .7s linear alternate infinite;right:-45px;top:-32px;background:linear-gradient(0deg,#ffb305 10%,#ffbd04 20%,#ed6434 50%,#fa4708 59%);position:absolute;content:"";transform:rotate(90deg);height:80px;width:30px;}
            </style>
        <?php
    }add_action('wp_footer','top_style');
}


// 前台管理员快速切换账号(ctrl+q切换)
if(panda_pz('quick_switch')){
    
/**
 * 搜索弹窗
 */
function zib_manage_login_modal() {
    if (!current_user_can('manage_options')) { // 检查是否为管理员
        exit();
    }
    $user_id = get_current_user_id();
    if (!$user_id) {
        return;
    }
    $html = '';
    $action    = 'manage_login_user_search';
    $emby = zib_get_null('', 40, 'null-search.svg', '', 0, 150);

    //ajax搜索组件
    $search = '<div class="auto-search" ajax-url="' . zib_get_admin_ajax_url($action) . '">';
    $search .= '<div class="form-right-icon">';
    $search .= '<input type="text" name="s" class="form-control search-input" style="max-width:100%" tabindex="1" value="" placeholder="请输入关键词以搜索用户" autocomplete="off">';
    $search .= '<div class="search-icon abs-right">' . zib_get_svg('search') . '</div>';
    $search .= '</div>';
    $search .= '<div class="mt20 mb10 muted-3-color separator search-remind em09">请输入关键词以搜索用户</div>';
    $search .= '<div class="search-container mini-scrollbar scroll-y max-vh5">' . $emby . '</div>';
    $search .= '</div>';

    echo $search;
    exit();
}
add_action('wp_ajax_manage_login_modal', 'zib_manage_login_modal');

//搜索用户
function zib_manage_login_user_search()
{

    $type = !empty($_REQUEST['type']) ? $_REQUEST['type'] : 'points';
    $s    = !empty($_POST['s']) ? strip_tags(trim($_POST['s'])) : '';

    $lists       = '';
    $exclude     = array(); //排除自己
    $ice_perpage = 30; //最多30个
    $users_args  = array(
        'search'         => '*' . $s . '*',
        'exclude'        => $exclude,
        'search_columns' => array('user_email', 'user_nicename', 'display_name', 'user_login'),
        'count_total'    => false,
        'number'         => $ice_perpage,
        'fields'         => ['ID'],
        'meta_query'     => array(
            'relation' => 'OR', //排除禁封用户
            array(
                'key'     => 'banned',
                'value'   => array(1, 2),
                'compare' => 'NOT IN',
            ),
            array(
                'key'     => 'banned',
                'compare' => 'NOT EXISTS',
            ),
        ),
    );
    $user_search = new WP_User_Query($users_args);
    $users       = $user_search->get_results();

    if ($users) {
        foreach ($users as $user) {
            $lists .= zib_manage_login_user_card($user->ID);
        }
    }

    if ($lists) {
        zib_send_json_success(array('data' => $lists, 'remind' => '请选择用户进行操作'));
    } else {
        zib_send_json_success(array('data' => zib_get_null('', 40, 'null-user.svg', '', 0, 150), 'remind' => '未找到相关用户'));
    }
    exit;
}
add_action('wp_ajax_manage_login_user_search', 'zib_manage_login_user_search');

/**
 * @description: 获取用户的卡片
 * @param {*} $recipient
 * @return {*}
 */
function zib_manage_login_user_card($author_id, $is_con = false, $is_btn = true)
{
    $user = get_userdata($author_id);
    if (!isset($user->display_name)) {
        return;
    }

    $display_name = zib_get_user_name($author_id);
    $avatar       = zib_get_avatar_box($author_id);
    $btn          = $is_btn ? '<div class="muted-color">登录该账号<i style="margin:0 0 0 6px;" class="fa fa-angle-right em12"></i></div>' : '';
    $info         = $user->user_email ? zib_get_hide_email($user->user_email) : $user->user_login;

    $html = !$is_con ? '<div data-for="recipient" class="user-info flex ac padding-h6 border-bottom pointer">' : '';
    $html .= $avatar;
    $html .= '<div class="flex1 ml10 flex ac jsb">';
    $html .= '<div class="flex1">' . $display_name . '<div class="mt3 em09 muted-2-color">' . $info . '</div></div>';
    $html .= $btn ? '<div class="flex0 em09 ml10 recipient-user-btn">' . $btn . '</div>' : '';
    $html .= '</div>';
    $html .= !$is_con ? '</div>' : '';
    return '<span class="wp-ajax-submit" form-action="manage_login_ajax" href="javascript:;" form-data="' . esc_attr(json_encode(['user_id' => $author_id])) . '">' . $html . '</span>';
}

// 登录被选中的账号
function zib_manage_login_ajax()
{

    if (!current_user_can('manage_options')) { // 检查是否为管理员
        zib_send_json_error(['msg' => '权限不足','reload' => true]);
    }

    $user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;

    if ($user_id > 0) {
        wp_set_current_user($user_id);
        wp_set_auth_cookie($user_id);
        zib_send_json_success(['msg' => '登陆成功','reload' => true]);
    }
}
add_action('wp_ajax_manage_login_ajax', 'zib_manage_login_ajax');


function zib_manage_login_jQuery(){
    ?>
    <script>
    jQuery(document).ready(function($) {
    // 监听全局的键盘按下事件
    $(document).keydown(function(event) {
        // 检查是否按下了CTRL和Q键
        if (event.ctrlKey && event.key === "q") {
            event.preventDefault(); // 防止浏览器默认行为
            
            // 触发模态框显示逻辑
            openManageLoginModal();
        }
    });

    // 也可以通过点击按钮来打开模态框
    $('#open-modal-btn').click(openManageLoginModal);

    function openManageLoginModal() {
        var modalId = 'manage-login-modal';
        var modalContentId = 'manage-login-modal-content';

        // 检查模态框是否已经存在
        if ($('#' + modalId).length === 0) {
            // 创建新的模态框结构
            var modalHtml = `
                <div class="modal fade" id="${modalId}" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div id="${modalContentId}" class="modal-body">
                                <!-- 内容将通过AJAX加载 -->
                                <p class="placeholder t1"></p>
                                <h4 style="height:120px;" class="placeholder k1"></h4>
                                <p class="placeholder k2"></p>
                                <i class="placeholder s1"></i>
                                <i class="placeholder s1 ml10"></i>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            $('body').append(modalHtml);
        }

        // 加载远程内容
        $.ajax({
            url: window._win.ajax_url, // 使用已定义的ajax_url
            method: 'POST',
            data: {
                action: 'manage_login_modal', // PHP钩子中的action名称
                // 如果有其他数据需要传递给服务器端，可以在这里添加
            },
            success: function(response) {
                // 将响应内容插入到模态框容器中
                $('#' + modalContentId).html(response);
                // 显示模态框
                $('#' + modalId).modal('show');
            },
            error: function(error) {
                console.error('Error loading modal content:', error);
            }
        });
    }
});
</script>
<?

}
 if (current_user_can('manage_options')) { // 检查是否为管理员
    add_action('wp_footer','zib_manage_login_jQuery');
}
}

// 新用户注册自动用指定id发送私信
if(panda_pz('new_user_send_message')){
function auto_send_private($new_user_id) {
    // 检查是否是新用户，并确保用户ID为1存在
    $send_user_id = panda_pz('new_user_send_message_id');  // 假设用户1存在
    // 获取私信内容
    $msg_content = panda_pz('new_user_send_message_content');
    // 定义私信参数
    $msg_args = array(
        'send_user'    => $send_user_id,
        'receive_user' => $new_user_id,  // 新用户ID
        'content'      => $msg_content,
        'parent'       => '',
        'status'       => '',
        'meta'         => '',
        'other'        => '',
    );
    // 发送私信
    $msg = Zib_Private::add($msg_args);
}
add_action('user_register', 'auto_send_private');
}


// 跳转链接添加_blank
if(panda_pz('link_blank')){
    function link_blank(){
        ?>
        <script>
            window.onload = function() {
                var links = document.getElementsByTagName('a');
                for (var i = 0; i < links.length; i++) {
                    if (links[i].href.includes('?golink=')) {
                        links[i].setAttribute('target', '_blank');
                    }
                }
            };
        </script>
        <?php
    }
    add_action('wp_footer','link_blank');
}

// 前台文章编辑器离开页面提示保存
if(panda_pz('editor_save')){
    function zib_editor_save(){
        ?>
        <script type="text/javascript">
        let whiteList = ['/newposts','/posts-edit/']
        let flag = whiteList.includes(window.location.pathname)  ? true : false
        let formListenerAdded = false;
        function listeningForm() {
            var hasChanges = false;
            var oldXHR = window.XMLHttpRequest;
            setTimeout(function() {
            var iframe = document.getElementById('post_content_ifr');
            if (iframe) {
                var iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
                var observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        hasChanges = true
                    
                    });
                });
                var config = { attributes: true, childList: true, characterData: true, subtree: true };
                observer.observe(iframeDoc.documentElement, config);        
                }
            }, 1000);
            Array.from(document.querySelectorAll('input, textarea, select')).forEach(function(element) {
                element.addEventListener('input', function() {
                    hasChanges = true;
            
                });
            });
            if (typeof tinyMCE !== 'undefined') {
                tinyMCE.editors.forEach(function(editor) {
                    editor.on('change', function() {
                        hasChanges = true;
                    });
                });
            }
            function newXHR() {
                var realXHR = new oldXHR();
                realXHR.addEventListener('readystatechange', function() {
                    if (realXHR.readyState === 4) {
                        if (realXHR.responseURL =='../wp-admin/admin-ajax.php') {
                            hasChanges= false
                        
                        }
                    }
                }, false);
                return realXHR;
            }
            window.XMLHttpRequest = newXHR;
            window.addEventListener('beforeunload', function(event) {
                if (hasChanges) {
                    var message = '您有未保存的更改。如果离开此页面，您可能会丢失这些更改。';
                    event.returnValue = message;
                    return message
                }
                
            });
        }
        document.addEventListener('DOMContentLoaded', function() {
            if (!formListenerAdded && flag) {
                listeningForm();
                formListenerAdded = true;
            }
        });
        </script>
        <?php
    }
    add_action('wp_footer', 'zib_editor_save');
}

// 小工具标题样式美化
if(panda_pz('widget_title_style')){
    function widget_title_style(){
        ?>
        <style>
        .title-theme::before{background:#ff1856;background-color:initial;background-image:url(<?php echo panda_pz('widget_title_img');?>);background-size:cover;border-radius:5px;bottom:10%;box-shadow:#000 0 0;content:"";height:70px;left:-28px;position:absolute;top:-30px;width:80px;}
        .box-body.notop{background:#fff;background-repeat:repeat;border-radius:8px;box-shadow:0 0 10px rgba(116,116,116,.08);margin-bottom:10px;padding:5px 5px 5px 1.2em;}
        .title-theme{font-size:20px;margin:5px;padding-left:1.3em;position:relative;}
        .title-theme .ml10::before{background:#ff1856;background-repeat:repeat;bottom:16%;content:"";left:115px;position:absolute;top:30%;width:1px;}
        </style>
        <?php
    }add_action('wp_footer','widget_title_style');
}

// 弹窗modal背景
if (panda_pz('modal_bg')){
    function modal_bg(){
        ?>
        <style>
            /*modal弹窗背景样式*/
            #zibpay_modal, .modal-open .modal {
                background: url(<?php echo panda_pz('static_panda');?>/assets/img/modal_bg.png);
                backdrop-filter: blur(10px) !important;
            }
        </style>
        <?php
    }add_action('wp_footer','modal_bg');
}

/*自定义全局背景 */
if (panda_pz('diy_bg_img')) {
    function diy_bg_img() {
        if (panda_pz('diy_bg_sun')) {?>
            <style>
            body {
                        background-image: url(<?php echo panda_pz('diy_bg_img_sun')?>);
                        background-position-x: center;
                        background-position-y: center;
                        background-repeat: no-repeat;
                        background-attachment: fixed;
                        background-size: cover;
                    }
            </style>
        <?php }if (panda_pz('diy_bg_moon')) {?>
            <style>
           .dark-theme{
                background-image: url(<?php echo panda_pz('diy_bg_img_moon')?>);
                background-position-x: center;
                background-position-y: center;
                background-repeat: no-repeat;
                background-attachment: fixed;
                background-size: cover;
            }
            </style>
        <?php }
    }add_action('wp_footer', 'diy_bg_img');
}

/*动态背景*/
function dynamic_bg_style() {
    switch (panda_pz('dynamic_bg_style')) {
        case 'bg1':
            ?>
            <div id="bubble"><canvas width="1494" height="815" style="display: block; position: fixed; top: 0px; left: 0px; z-index: -2;"></canvas></div>
            <script src="<?php echo panda_pz('static_panda');?>/assets/js/bg/control.js"></script>
            <?php
            break;
        case 'bg2':
            ?>
            <link rel="stylesheet" href="<?php echo panda_pz('static_panda');?>/assets/css/bg/yuansufuhao.css" />
            <script>
            $('head').before('<div class="container1"><div class="inner-container1"><div class="shape"></div></div><div class="inner-container1"><div class="shape"></div></div></div>');
            </script>
            <script src="<?php echo panda_pz('static_panda');?>/assets/js/bg/yuansufuhao.min.js"></script>
            <script>
            $(document).ready(function(){
                var html = '';
                for(var i=1; i<=50; i++){
                    html += '<div class="shape-container--'+i+' shape-animation"><div class="random-shape"></div></div>';
                }
                document.querySelector('.shape').innerHTML += html;
            });
            </script>
            <?php
            break;
        case 'bg3':
            ?>
            <div class="mouse-cursor cursor-outer"></div><div class="mouse-cursor cursor-inner"></div>
            <script src="<?php echo panda_pz('static_panda');?>/assets/js/bg/shubiao.js"></script>
            <style>
            .mouse-cursor {
                position: fixed;
                left: 0;
                top: 0;
                pointer-events: none;
                border-radius: 50%;
                -webkit-transform: translateZ(0);
                transform: translateZ(0);
                visibility: hidden;
            }
            .cursor-inner {
                margin-left: -3px;
                margin-top: -3px;
                width: 6px;
                height: 6px;
                z-index: 10000001;
                background: transparent;
                -webkit-transition: width .3s ease-in-out, height .3s ease-in-out, margin .3s ease-in-out, opacity .3s ease-in-out;
                transition: width .3s ease-in-out, height .3s ease-in-out, margin .3s ease-in-out, opacity .3s ease-in-out;
            }
            .cursor-inner.cursor-hover {
                margin-left: -18px;
                margin-top: -18px;
                width: 36px;
                height: 36px;
                background: transparent;
                opacity: .3;
            }
            .cursor-outer {
                margin-left: -15px;
                margin-top: -15px;
                width: 30px;
                height: 30px;
                border: 2px solid transparent;
                -webkit-box-sizing: border-box;
                box-sizing: border-box;
                z-index: 10000000;
                opacity: .5;
                -webkit-transition: all .08s ease-out;
                transition: all .08s ease-out;
            }
            .cursor-outer.cursor-hover {
                opacity: 0;
            }
            .main-wrapper[data-magic-cursor=hide].mouse-cursor {
                display: none;
                opacity: 0;
                visibility: hidden;
                position: absolute;
                z-index: -1111;
            }
            </style>
            <script src="<?php echo panda_pz('static_panda');?>/assets/js/bg/lizi.js"></script>
            <?php
            break;
        case 'bg4':
            ?>
            <style>
            body {
                background-image: url("<?php echo panda_pz('static_panda');?>/assets/img/bg/jianyue.svg");
                background-position-x: center;
                background-position-y: center;
                background-repeat: no-repeat;
                background-attachment: fixed;
                background-size: cover;
            }
            </style>
            <?php
            break;
        default:
            // 如果没有匹配的样式，可以在这里处理默认情况
            // 例如，可以输出一个默认背景或者什么都不做
            break;
    }
}
add_action('wp_head', 'dynamic_bg_style');

/*手机背景*/
function phone_bg_img() {
    switch (panda_pz('phone_bg_img')) {
        case 'bg1':
            ?>
            <style>
                @media screen and (max-width: 1000px){
                body {
                    background-image: url(<?php echo panda_pz('static_panda');?>/assets/img/bg/mp.jpg);
                    background-position-x: center;
                    background-position-y: center;
                    background-repeat: no-repeat;
                    background-attachment: fixed;
                    background-size: cover;
                }}
            </style>
            <?php
            break;
        case 'bg2':
            ?>
            <style>
                @media screen and (max-width: 1000px){
                body {
                    background-image: url(<?php echo panda_pz('static_panda');?>/assets/img/bg/ce.jpg);
                    background-position-x: center;
                    background-position-y: center;
                    background-repeat: no-repeat;
                    background-attachment: fixed;
                    background-size: cover;
                }}
            </style>
            <?php
            break;
        case 'bg3':
            ?>
            <style>
                @media screen and (max-width: 1000px){
                body {
                    background-image: url(<?php echo panda_pz('static_panda');?>/assets/img/bg/mp1.png);
                    background-position-x: center;
                    background-position-y: center;
                    background-repeat: no-repeat;
                    background-attachment: fixed;
                    background-size: cover;
                }}
            </style>
            <?php
            break;
        case 'bg4':
            ?>
            <style>
                @media screen and (max-width: 1000px){
                body {
                    background-image: url(<?php echo panda_pz('static_panda');?>/assets/img/bg/pcd.png);
                    background-position-x: center;
                    background-position-y: center;
                    background-repeat: no-repeat;
                    background-attachment: fixed;
                    background-size: cover;
                }}
            </style>
            <?php
            break;
        case 'diy':
            if (panda_pz('diy_phone_bg_img_sun') != '' && panda_pz('diy_phone_bg_sun')) {
                ?>
                <style>
                    @media screen and (max-width: 1000px){
                    body {
                        background-image: url بالإضBT('diy_phone_bg_img_sun');
                        background-position-x: center;
                        background-position-y: center;
                        background-repeat: no-repeat;
                        background-attachment: fixed;
                        background-size: cover;
                    }}
                </style>
                <?php
            }
            if (panda_pz('diy_phone_bg_img_moon') != '' && panda_pz('diy_phone_bg_moon')) {
                ?>
                <style>
                    @media screen and (max-width: 1000px){
                    .dark-theme{
                        background-image: url بالإضBT('diy_phone_bg_img_moon');
                        background-position-x: center;
                        background-position-y: center;
                        background-repeat: no-repeat;
                        background-attachment: fixed;
                        background-size: cover;
                    }}
                </style>
                <?php
            }
            break;
        default:
            // 如果没有匹配的样式，可以在这里处理默认情况
            // 例如，可以输出一个默认背景或者什么都不做
            break;
    }
}
add_action('wp_head', 'phone_bg_img');

/*手机侧边背景 */
function phone_bg_img_side() {
    switch (panda_pz('phone_bg_img_side')) {
        case 'bg1':
            ?>
            <style>
                @media (max-width: 767px) {
                    .mobile-navbar.show, .mobile-navbar.left {
                        background-size: cover;
                        background-repeat: no-repeat;
                        background-position: center center;
                        cursor: pointer;
                        background-image: linear-gradient(rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.3)), url("<?php echo panda_pz('static_panda');?>/assets/img/bg/mp.jpg");
                    }
                    .mobile-nav-widget .box-body {
                        background: var(--muted-border-color) !important;
                    }
                }
            </style>
            <?php
            break;
        case 'bg2':
            ?>
            <style>
                @media (max-width: 767px) {
                    .mobile-navbar.show, .mobile-navbar.left {
                        background-size: cover;
                        background-repeat: no-repeat;
                        background-position: center center;
                        cursor: pointer;
                        background-image: linear-gradient(rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.3)), url("<?php echo panda_pz('static_panda');?>/assets/img/bg/ce.jpg");
                    }
                    .mobile-nav-widget .box-body {
                        background: var(--muted-border-color) !important;
                    }
                }
            </style>
            <?php
            break;
        case 'bg3':
            ?>
            <style>
                @media (max-width: 767px) {
                    .mobile-navbar.show, .mobile-navbar.left {
                        background-size: cover;
                        background-repeat: no-repeat;
                        background-position: center center;
                        cursor: pointer;
                        background-image: linear-gradient(rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.3)), url("<?php echo panda_pz('static_panda');?>/assets/img/bg/mp1.png");
                    }
                    .mobile-nav-widget .box-body {
                        background: var(--muted-border-color) !important;
                    }
                }
            </style>
            <?php
            break;
        case 'diy':
            ?>
            <style>
                @media (max-width: 767px) {
                    .mobile-navbar.show, .mobile-navbar.left {
                        background-size: cover;
                        background-repeat: no-repeat;
                        background-position: center center;
                        cursor: pointer;
                        background-image: linear-gradient(rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.3)), url("<?php echo panda_pz('diy_phone_bg_img_side') ?>");
                    }
                    .mobile-nav-widget .box-body {
                        background: var(--muted-border-color) !important;
                    }
                }
            </style>
            <?php
            break;
        default:
            // 如果没有匹配的样式，可以在这里处理默认情况
            // 例如，可以输出一个默认背景或者什么都不做
            break;
    }
}
add_action('wp_head', 'phone_bg_img_side');

/*电脑背景 */
function pc_bg_img() {
    switch (panda_pz('pc_bg_img')) {
        case 'bg1':
            ?>
            <style>
            @media screen and (min-width: 801px) {
                body {
                    background-image: url("<?php echo panda_pz('static_panda');?>/assets/img/bg/pc.jpg");
                    background-position-x: center;
                    background-position-y: center;
                    background-repeat: no-repeat;
                    background-attachment: fixed;
                    background-size: cover;
                }
            }
            </style>
            <?php
            break;
        case 'bg2':
            ?>
            <style>
            @media screen and (min-width: 801px) {
                body {
                    background-image: url("<?php echo panda_pz('static_panda');?>/assets/img/bg/pc2.jpg");
                    background-position-x: center;
                    background-position-y: center;
                    background-repeat: no-repeat;
                    background-attachment: fixed;
                    background-size: cover;
                }
            }
            </style>
            <?php
            break;
        case 'bg3':
            ?>
            <style>
            @media screen and (min-width: 801px) {
                body {
                    background-image: url("<?php echo panda_pz('static_panda');?>/assets/img/bg/pc1.png");
                    background-position-x: center;
                    background-position-y: center;
                    background-repeat: no-repeat;
                    background-attachment: fixed;
                    background-size: cover;
                }
            }
            </style>
            <?php
            break;
        case 'bg4':
            ?>
            <style>
            @media screen and (min-width: 801px) {
                body {
                    background-image: url("<?php echo panda_pz('static_panda');?>/assets/img/bg/pcd.png");
                    background-position-x: center;
                    background-position-y: center;
                    background-repeat: no-repeat;
                    background-attachment: fixed;
                    background-size: cover;
                }
            }
            </style>
            <?php
            break;
        case 'diy':
            if (panda_pz('diy_pc_bg_img_sun') != '' && panda_pz('diy_pc_bg_sun')) {
                ?>
                <style>
                @media screen and (min-width: 801px) {
                    body {
                        background-image: url بالإضBT('diy_pc_bg_img_sun');
                        background-position-x: center;
                        background-position-y: center;
                        background-repeat: no-repeat;
                        background-attachment: fixed;
                        background-size: cover;
                    }
                }
                </style>
                <?php
            }
            if (panda_pz('diy_pc_bg_img_moon') != '' && panda_pz('diy_pc_bg_moon')) {
                ?>
                <style>
                @media screen and (min-width: 801px) {
                    .dark-theme {
                        background-image: url<function_call>اضBT('diy_pc_bg_img_moon');
                        background-position-x: center;
                        background-position-y: center;
                        background-repeat: no-repeat;
                        background-attachment: fixed;
                        background-size: cover;
                    }
                }
                </style>
                <?php
            }
            break;
        default:
            break;
    }
}
add_action('wp_head', 'pc_bg_img');

//导航栏背景
function navbar_bg() {
    switch (panda_pz('nav_bg_img_post')) {
        case 'bg1':
            ?>
            <style>
            @media screen and (min-width: 1000px) {
                .header-layout-1 {
                    position: relative;
                    background-image: url("<?php echo panda_pz('static_panda');?>/assets/img/bg/zhifeiji.gif");
                    background-position: center right;
                    background-size: 100% 100%;
                }
            }
            </style>
            <?php
            break;
        case 'bg2':
            ?>
            <style>
            @media screen and (min-width: 1000px) {
                .header-layout-1 {
                    position: relative;
                    background-image: url("<?php echo panda_pz('static_panda');?>/assets/img/bg/zsf.png");
                    background-position: center right;
                    background-size: 100% 100%;
                }
            }
            </style>
            <?php
            break;
        case 'bg3':
            ?>
            <style>
            @media screen and (min-width: 1000px) {
                .header-layout-1 {
                    position: relative;
                    background-image: url("<?php echo panda_pz('static_panda');?>/assets/img/bg/gfth.png");
                    background-position: center right;
                    background-size: 100% 100%;
                }
            }
            </style>
            <?php
            break;
        case 'bg4':
            ?>
            <style>
            @media screen and (min-width: 1000px) {
                .header-layout-1 {
                    position: relative;
                    background-image: url("<?php echo panda_pz('static_panda');?>/assets/img/bg/wlsh.png");
                    background-position: center right;
                    background-size: 100% 100%;
                }
            }
            </style>
            <?php
            break;
        case 'bg5':
            ?>
            <style>
            @media screen and (min-width: 1000px) {
                .header-layout-1 {
                    position: relative;
                    background-image: url("<?php echo panda_pz('static_panda');?>/assets/img/bg/dmss.gif");
                    background-position: center right;
                    background-size: 100% 100%;
                }
            }
            </style>
            <?php
            break;
        case 'bg6':
            ?>
            <style>
            @media screen and (min-width: 1000px) {
                .header-layout-1 {
                    position: relative;
                    background-image: url("<?php echo panda_pz('static_panda');?>/assets/img/bg/aixin.gif");
                    background-position: center right;
                    background-size: 100% 100%;
                }
            }
            </style>
            <?php
            break;
        case 'bg7':
            ?>
            <style>
            @media screen and (min-width: 1000px) {
                .header-layout-1 {
                    position: relative;
                    background-image: url("<?php echo panda_pz('static_panda');?>/assets/img/bg/haitan.gif");
                    background-position: center right;
                    background-size: 100% 100%;
                }
            }
            </style>
            <?php
            break;
        case 'diy':
            ?>
            <style>
            @media screen and (min-width: 1000px) {
                .header-layout-1 {
                    position: relative;
                    background-image: url بالإضBT('nav_bg_img');
                    background-position: center right;
                    background-size: 100% 100%;
                }
            }
            </style>
            <?php
            break;
        default:
            break;
    }
}
add_action('wp_head', 'navbar_bg');

// 搜索框背景
switch (panda_pz('search_bg_style')) {
    case 'blue':
        function search_bg_style_blue() {
            ?>
            <style>.navbar-search.show {background-image: url(<?php echo panda_pz('static_panda');?>/assets/img/bg/shading_blue.png);}</style>
            <?php
        }
        add_action('wp_head', 'search_bg_style_blue');
        break;
    case 'red':
        function search_bg_style_red() {
            ?>
            <style>.navbar-search.show {background-image: url(<?php echo panda_pz('static_panda');?>/assets/img/bg/shading_red.png);}</style>
            <?php
        }
        add_action('wp_head', 'search_bg_style_red');
        break;
    default:
        break;
}

//网页背景粒子特效
if(panda_pz('bg_particle')){
    function bg_particle(){
        echo '<script>
        !function(){"use strict";function e(e){return e&&e.__esModule&&Object.prototype.hasOwnProperty.call(e,"default")?e.default:e}function t(e,t){return e(t={exports:{}},t.exports),t.exports}var n=t(function(e,t){Object.defineProperty(t,"__esModule",{value:!0});var n=1;t.default=function(){return""+n++},e.exports=t.default});e(n);var o=t(function(e,t){Object.defineProperty(t,"__esModule",{value:!0}),t.default=function(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:30,n=null;return function(){for(var o=this,i=arguments.length,r=Array(i),a=0;a<i;a++)r[a]=arguments[a];clearTimeout(n),n=setTimeout(function(){e.apply(o,r)},t)}},e.exports=t.default});e(o);var i=t(function(e,t){Object.defineProperty(t,"__esModule",{value:!0});t.SizeSensorId="size-sensor-id",t.SensorStyle="display:block;position:absolute;top:0;left:0;height:100%;width:100%;overflow:hidden;pointer-events:none;z-index:-1;opacity:0",t.SensorClassName="size-sensor-object"});e(i);i.SizeSensorId,i.SensorStyle,i.SensorClassName;var r=t(function(e,t){Object.defineProperty(t,"__esModule",{value:!0}),t.createSensor=void 0;var n,r=(n=o)&&n.__esModule?n:{default:n};t.createSensor=function(e){var t=void 0,n=[],o=(0,r.default)(function(){n.forEach(function(t){t(e)})}),a=function(){t&&t.parentNode&&(t.contentDocument.defaultView.removeEventListener("resize",o),t.parentNode.removeChild(t),t=void 0,n=[])};return{element:e,bind:function(r){t||(t=function(){"static"===getComputedStyle(e).position&&(e.style.position="relative");var t=document.createElement("object");return t.onload=function(){t.contentDocument.defaultView.addEventListener("resize",o),o()},t.setAttribute("style",i.SensorStyle),t.setAttribute("class",i.SensorClassName),t.type="text/html",e.appendChild(t),t.data="about:blank",t}()),-1===n.indexOf(r)&&n.push(r)},destroy:a,unbind:function(e){var o=n.indexOf(e);-1!==o&&n.splice(o,1),0===n.length&&t&&a()}}}});e(r);r.createSensor;var a=t(function(e,t){Object.defineProperty(t,"__esModule",{value:!0}),t.createSensor=void 0;var n,i=(n=o)&&n.__esModule?n:{default:n};t.createSensor=function(e){var t=void 0,n=[],o=(0,i.default)(function(){n.forEach(function(t){t(e)})}),r=function(){t.disconnect(),n=[],t=void 0};return{element:e,bind:function(i){t||(t=function(){var t=new ResizeObserver(o);return t.observe(e),o(),t}()),-1===n.indexOf(i)&&n.push(i)},destroy:r,unbind:function(e){var o=n.indexOf(e);-1!==o&&n.splice(o,1),0===n.length&&t&&r()}}}});e(a);a.createSensor;var s=t(function(e,t){Object.defineProperty(t,"__esModule",{value:!0}),t.createSensor=void 0;t.createSensor="undefined"!=typeof ResizeObserver?a.createSensor:r.createSensor});e(s);s.createSensor;var u=t(function(e,t){Object.defineProperty(t,"__esModule",{value:!0}),t.removeSensor=t.getSensor=void 0;var o,r=(o=n)&&o.__esModule?o:{default:o};var a={};t.getSensor=function(e){var t=e.getAttribute(i.SizeSensorId);if(t&&a[t])return a[t];var n=(0,r.default)();e.setAttribute(i.SizeSensorId,n);var o=(0,s.createSensor)(e);return a[n]=o,o},t.removeSensor=function(e){var t=e.element.getAttribute(i.SizeSensorId);e.element.removeAttribute(i.SizeSensorId),e.destroy(),t&&a[t]&&delete a[t]}});e(u);u.removeSensor,u.getSensor;var c=t(function(e,t){Object.defineProperty(t,"__esModule",{value:!0}),t.clear=t.bind=void 0;t.bind=function(e,t){var n=(0,u.getSensor)(e);return n.bind(t),function(){n.unbind(t)}},t.clear=function(e){var t=(0,u.getSensor)(e);(0,u.removeSensor)(t)}});e(c);var l=c.clear,d=c.bind,v=window.requestAnimationFrame||window.webkitRequestAnimationFrame||window.mozRequestAnimationFrame||window.msRequestAnimationFrame||window.oRequestAnimationFrame||function(e){return window.setTimeout(e,1e3/60)},f=window.cancelAnimationFrame||window.webkitCancelAnimationFrame||window.mozCancelAnimationFrame||window.msCancelAnimationFrame||window.oCancelAnimationFrame||window.clearTimeout,m=function(e){return new Array(e).fill(0).map(function(e,t){return t})},h=Object.assign||function(e){for(var t=1;t<arguments.length;t++){var n=arguments[t];for(var o in n)Object.prototype.hasOwnProperty.call(n,o)&&(e[o]=n[o])}return e},p=function(){function e(e,t){for(var n=0;n<t.length;n++){var o=t[n];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(e,o.key,o)}}return function(t,n,o){return n&&e(t.prototype,n),o&&e(t,o),t}}();var y=function(){function e(t,n){var o=this;!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),this.randomPoints=function(){return m(o.c.count).map(function(){return{x:Math.random()*o.canvas.width,y:Math.random()*o.canvas.height,xa:2*Math.random()-1,ya:2*Math.random()-1,max:6e3}})},this.el=t,this.c=h({zIndex:-1,opacity:.5,color:"0,0,0",pointColor:"0,0,0",count:99},n),this.canvas=this.newCanvas(),this.context=this.canvas.getContext("2d"),this.points=this.randomPoints(),this.current={x:null,y:null,max:2e4},this.all=this.points.concat([this.current]),this.bindEvent(),this.requestFrame(this.drawCanvas)}return p(e,[{key:"bindEvent",value:function(){var e=this;d(this.el,function(){e.canvas.width=e.el.clientWidth,e.canvas.height=e.el.clientHeight}),this.onmousemove=window.onmousemove,window.onmousemove=function(t){e.current.x=t.clientX-e.el.offsetLeft+document.scrollingElement.scrollLeft,e.current.y=t.clientY-e.el.offsetTop+document.scrollingElement.scrollTop,e.onmousemove&&e.onmousemove(t)},this.onmouseout=window.onmouseout,window.onmouseout=function(){e.current.x=null,e.current.y=null,e.onmouseout&&e.onmouseout()}}},{key:"newCanvas",value:function(){"static"===getComputedStyle(this.el).position&&(this.el.style.position="relative");var e,t=document.createElement("canvas");return t.style.cssText="display:block;position:absolute;top:0;left:0;height:100%;width:100%;overflow:hidden;pointer-events:none;z-index:"+(e=this.c).zIndex+";opacity:"+e.opacity,t.width=this.el.clientWidth,t.height=this.el.clientHeight,this.el.appendChild(t),t}},{key:"requestFrame",value:function(e){var t=this;this.tid=v(function(){return e.call(t)})}},{key:"drawCanvas",value:function(){var e=this,t=this.context,n=this.canvas.width,o=this.canvas.height,i=this.current,r=this.points,a=this.all;t.clearRect(0,0,n,o);var s=void 0,u=void 0,c=void 0,l=void 0,d=void 0,v=void 0;r.forEach(function(r,f){for(r.x+=r.xa,r.y+=r.ya,r.xa*=r.x>n||r.x<0?-1:1,r.ya*=r.y>o||r.y<0?-1:1,t.fillStyle="rgba("+e.c.pointColor+")",t.fillRect(r.x-.5,r.y-.5,1,1),u=f+1;u<a.length;u++)null!==(s=a[u]).x&&null!==s.y&&(l=r.x-s.x,d=r.y-s.y,(v=l*l+d*d)<s.max&&(s===i&&v>=s.max/2&&(r.x-=.03*l,r.y-=.03*d),c=(s.max-v)/s.max,t.beginPath(),t.lineWidth=c/2,t.strokeStyle="rgba("+e.c.color+","+(c+.2)+")",t.moveTo(r.x,r.y),t.lineTo(s.x,s.y),t.stroke()))}),this.requestFrame(this.drawCanvas)}},{key:"destroy",value:function(){l(this.el),window.onmousemove=this.onmousemove,window.onmouseout=this.onmouseout,f(this.tid),this.canvas.parentNode.removeChild(this.canvas)}}]),e}();y.version="2.0.4";var w,b;new y(document.body,(w=document.getElementsByTagName("script"),{zIndex:(b=w[w.length-1]).getAttribute("zIndex"),opacity:b.getAttribute("opacity"),color:b.getAttribute("color"),pointColor:b.getAttribute("pointColor"),count:Number(b.getAttribute("count"))||99}))}();
        </script>';
    }add_action('wp_footer', 'bg_particle');
}


/* 全局鼠标样式 */
function mousestyle() {
    switch (panda_pz('mousestyle')) {
        case 'style1':
            ?>
            <style>
                body {
                    cursor: url('<?php echo panda_pz('static_panda');?>/assets/img/mouse/shubiao1.png'), default;
                }
                a:hover {
                    cursor: url('<?php echo panda_pz('static_panda');?>/assets/img/mouse/shubiao2.png'), pointer;
                }
            </style>
            <?php
            break;
        case 'style2':
            ?>
            <style>
                body {
                    cursor: url('<?php echo panda_pz('static_panda');?>/assets/img/mouse/arr1.png'), default;
                }
                a:hover {
                    cursor: url('<?php echo panda_pz('static_panda');?>/assets/img/mouse/arr2.png'), pointer;
                }
            </style>
            <?php
            break;
        case 'style3':
            ?>
            <style>
                body {
                    cursor: url('<?php echo panda_pz('static_panda');?>/assets/img/mouse/arr3.png'), default;
                }
                a:hover {
                    cursor: url('<?php echo panda_pz('static_panda');?>/assets/img/mouse/arr4.png'), pointer;
                }
            </style>
            <?php
            break;
        case 'style4':
            ?>
            <style>
                body {
                    cursor: url('<?php echo panda_pz('static_panda');?>/assets/img/mouse/arr5.png'), default;
                }
                a:hover {
                    cursor: url('<?php echo panda_pz('static_panda');?>/assets/img/mouse/arr6.png'), pointer;
                }
            </style>
            <?php
            break;
        case 'style5':
            ?>
            <style>
                body {
                    cursor: url('<?php echo panda_pz('static_panda');?>/assets/img/mouse/arr7.png'), default;
                }
                a:hover {
                    cursor: url('<?php echo panda_pz('static_panda');?>/assets/img/mouse/arr8.png'), pointer;
                }
            </style>
            <?php
            break;
        case 'style6':
            ?>
            <style>
                body {
                    cursor: url('<?php echo panda_pz('static_panda');?>/assets/img/mouse/arr9.png'), default;
                }
                a:hover {
                    cursor: url('<?php echo panda_pz('static_panda');?>/assets/img/mouse/arr10.png'), pointer;
                }
            </style>
            <?php
            break;
        case 'style7':
            ?>
            <style>
                body {
                    cursor: url('<?php echo panda_pz('static_panda');?>/assets/img/mouse/arr11.png'), default;
                }
                a:hover {
                    cursor: url('<?php echo panda_pz('static_panda');?>/assets/img/mouse/arr12.png'), pointer;
                }
            </style>
            <?php
            break;
        case 'diy':
            $mousestyle_sz = panda_pz('mousestyle_sz');
            ?>
            <style>
                body {
                    cursor: url('<?php echo $mousestyle_sz['head']; ?>'), default;
                }
                a:hover {
                    cursor: url('<?php echo $mousestyle_sz['hand']; ?>'), pointer;
                }
            </style>
            <?php
            break;
        default:
            // 如果没有匹配的样式，可以在这里处理默认情况
            // 例如，可以输出一个默认背景或者什么都不做
            break;
    }
}
add_action('wp_footer', 'mousestyle');

/* 鼠标点击彩色效果 */
if (panda_pz('click_style') != 'default') {
    function click_style() {
        switch (panda_pz('click_style')) {
            case '1':
                ?>
                <script src="<?php echo panda_pz('static_panda');?>/assets/js/cursor/cursor1.js"></script>
                <?php
                break;
            case '2':
                ?>
                <script src="<?php echo panda_pz('static_panda');?>/assets/js/cursor/cursor2.js"></script>
                <?php
                break;
            case '3':
                ?>
                <script src="<?php echo panda_pz('static_panda');?>/assets/js/cursor/cursor3.js"></script>
                <?php
                break;
            case '4':
                ?>
                <script src="<?php echo panda_pz('static_panda');?>/assets/js/cursor/cursor4.js"></script>
                <?php
                break;
            case '5':
                ?>
                <script src="<?php echo panda_pz('static_panda');?>/assets/js/cursor/cursor5.js"></script>
                <?php
                break;
            case '6':
                ?>
                <canvas class="fireworks" style="position:fixed;left:0;top:0;z-index:99999999;pointer-events:none;"></canvas>
                <script src="<?php echo panda_pz('static_panda');?>/assets/js/cursor/cursor6.js"></script>
                <?php
                break;
            case '7':
                ?>
                <script type="text/javascript">
                    var a_idx = 0;
                    jQuery(document).ready(function($) {
                        $("body").click(function(e) {
                            var a = new Array我们必须确保代码的正确性和安全性，以避免潜在的错误和漏洞。在实际应用中，我们还需要考虑代码的可读性和维护性，以确保代码的长期可持续性。
                            var a_idx = (a_idx + 1) % a.length;
                            var x = e.pageX,
                                y = e.pageY;
                            var $i = $("<span/>").text(a[a_idx]);
                            a_idx = (a_idx + 1) % a.length;
                            var x = e.pageX,
                                y = e.pageY;
                            $i.css({
                                "z-index": 999999999999999999999999999999999999999999999999999999999999999999999,
                                "top": y - 20,
                                "left": x,
                                "position": "absolute",
                                "font-weight": "bold",
                                "color": "#ff6651"
                            });
                            $("body").append($i);
                            $i.animate({
                                "top": y - 180,
                                "opacity": 0
                            }, 1500, function() {
                                $i.remove();
                            });
                        });
                    });
                </script>
                <?php
                break;
            default:
                // 如果没有匹配的样式，可以在这里处理默认情况
                // 例如，可以输出一个默认背景或者什么都不做
                break;
        }
    }
    add_action('wp_footer', 'click_style');
}

/* 鼠标移动特效 */
if (panda_pz('follow_effect_style') != 'default') {
    function follow_effect_style() {
        switch (panda_pz('follow_effect_style')) {
            case '1':
                ?>
                <script src="<?php echo panda_pz('static_panda');?>/assets/js/cursor/cursor7.js"></script>
                <?php
                break;
            case '2':
                ?>
                <script src="<?php echo panda_pz('static_panda');?>/assets/js/cursor/cursor8.js"></script>
                <?php
                break;
            case '3':
                ?>
                <script src="<?php echo panda_pz('static_panda');?>/assets/js/cursor/cursor9.js"></script>
                <?php
                break;
            case '4':
                ?>
                <script src="<?php echo panda_pz('static_panda');?>/assets/js/cursor/cursor10.js"></script>
                <?php
                break;
            case '5':
                ?>
                <script src="<?php echo panda_pz('static_panda');?>/assets/js/cursor/cursor11.js"></script>
                <?php
                break;
            case '6':
                ?>
                <script src="<?php echo panda_pz('static_panda');?>/assets/js/cursor/cursor12.js"></script>
                <?php
                break;
            default:
                // 如果没有匹配的样式，可以在这里处理默认情况
                // 例如，可以输出一个默认背景或者什么都不做
                break;
        }
    }
    add_action('wp_footer', 'follow_effect_style');
}


// 鼠标跟随
function follow_light_style() {
    switch (panda_pz('follow_light_style')) {
        case 'blue':
            ?>
            <div class="mouse-cursor cursor-outer"></div><div class="mouse-cursor cursor-inner"></div>
            <script src="<?php echo panda_pz('static_panda');?>/assets/js/bg/shubiao.js"></script>
            <style>
                .mouse-cursor {
                    position: fixed;
                    left: 0;
                    top: 0;
                    pointer-events: none;
                    border-radius: 50%;
                    -webkit-transform: translateZ(0);
                    transform: translateZ(0);
                    visibility: hidden;
                }
                .cursor-inner {
                    margin-left: -3px;
                    margin-top: -3px;
                    width: 6px;
                    height: 6px;
                    z-index: 10000001;
                    background: #123eed;
                    -webkit-transition: width .3s ease-in-out, height .3s ease-in-out, margin .3s ease-in-out, opacity .3s ease-in-out;
                    transition: width .3s ease-in-out, height .3s ease-in-out, margin .3s ease-in-out, opacity .3s ease-in-out;
                }
                .cursor-inner.cursor-hover {
                    margin-left: -18px;
                    margin-top: -18px;
                    width: 36px;
                    height: 36px;
                    background: #123eed !important;
                    opacity: .3;
                }
                .cursor-outer {
                    margin-left: -15px;
                    margin-top: -15px;
                    width: 30px;
                    height: 30px;
                    border: 2px solid #123eed !important;
                    -webkit-box-sizing: border-box;
                    box-sizing: border-box;
                    z-index: 10000000;
                    opacity: .5;
                    -webkit-transition: all .08s ease-out;
                    transition: all .08s ease-out;
                }
                .cursor-outer.cursor-hover {
                    opacity: 0;
                }
                .main-wrapper[data-magic-cursor=hide] .mouse-cursor {
                    display: none;
                    opacity: 0;
                    visibility: hidden;
                    position: absolute;
                    z-index: -1111;
                }
            </style>
            <?php
            break;
        case 'green':
            ?>
            <div class="mouse-cursor cursor-outer"></div><div class="mouse-cursor cursor-inner"></div>
            <script src="<?php echo panda_pz('static_panda');?>/assets/js/bg/shubiao.js"></script>
            <style>
                .mouse-cursor {
                    position: fixed;
                    left: 0;
                    top: 0;
                    pointer-events: none;
                    border-radius: 50%;
                    -webkit-transform: translateZ(0);
                    transform: translateZ(0);
                    visibility: hidden;
                }
                .cursor-inner {
                    margin-left: -3px;
                    margin-top: -3px;
                    width: 6px;
                    height: 6px;
                    z-index: 10000001;
                    background: green;
                    -webkit-transition: width .3s ease-in-out, height .3s ease-in-out, margin .3s ease-in-out, opacity .3s ease-in-out;
                    transition: width .3s ease-in-out, height .3s ease-in-out, margin .3s ease-in-out, opacity .3s ease-in-out;
                }
                .cursor-inner.cursor-hover {
                    margin-left: -18px;
                    margin-top: -18px;
                    width: 36px;
                    height: 36px;
                    background: green !important;
                    opacity: .3;
                }
                .cursor-outer {
                    margin-left: -15px;
                    margin-top: -15px;
                    width: 30px;
                    height: 30px;
                    border: 2px solid green !important;
                    -webkit-box-sizing: border-box;
                    box-sizing: border-box;
                    z-index: 10000000;
                    opacity: .5;
                    -webkit-transition: all .08s ease-out;
                    transition: all .08s ease-out;
                }
                .cursor-outer.cursor-hover {
                    opacity: 0;
                }
                .main-wrapper[data-magic-cursor=hide].mouse-cursor {
                    display: none;
                    opacity: 0;
                    visibility: hidden;
                    position: absolute;
                    z-index: -1111;
                }
            </style>
            <?php
            break;
        case 'pink':
            ?>
            <div class="mouse-cursor cursor-outer"></div><div class="mouse-cursor cursor-inner"></div>
            <script src="<?php echo panda_pz('static_panda');?>/assets/js/bg/shubiao.js"></script>
            <style>
                .mouse-cursor {
                    position: fixed;
                    left: 0;
                    top: 0;
                    pointer-events: none;
                    border-radius: 50%;
                    -webkit-transform: translateZ(0);
                    transform: translateZ(0);
                    visibility: hidden;
                }
                .cursor-inner {
                    margin-left: -3px;
                    margin-top: -3px;
                    width: 6px;
                    height: 6px;
                    z-index: 10000001;
                    background: hotpink;
                    -webkit-transition: width .3s ease-in-out, height .3s ease-in-out, margin .3s ease-in-out, opacity .3s ease-in-out;
                    transition: width .3s ease-in-out, height .3s ease-in-out, margin .3s ease-in-out, opacity .3s ease-in-out;
                }
                .cursor-inner.cursor-hover {
                    margin-left: -18px;
                    margin-top: -18px;
                    width: 36px;
                    height: 36px;
                    background: hotpink !important;
                    opacity: .3;
                }
                .cursor-outer {
                    margin-left: -15px;
                    margin-top: -15px;
                    width: 30px;
                    height: 30px;
                    border: 2px solid hotpink !important;
                    -webkit-box-sizing: border-box;
                    box-sizing: border-box;
                    z-index: 10000000;
                    opacity: .5;
                    -webkit-transition: all .08s ease-out;
                    transition: all .08s ease-out;
                }
                .cursor-outer.cursor-hover {
                    opacity: 0;
                }
                .main-wrapper[data-magic-cursor=hide].mouse-cursor {
                    display: none;
                    opacity: 0;
                    visibility: hidden;
                    position: absolute;
                    z-index: -1111;
                }
            </style>
            <?php
            break;
        default:
            // 如果没有匹配的样式，可以在这里处理默认情况
            // 例如，可以输出一个默认背景或者什么都不做
            break;
    }
}
add_action('wp_head', 'follow_light_style');

//  禁用复制
if (panda_pz('disable_copy_style')) {
    function disable_copy_style(){?>
        <script>document.oncopy = function () {new Vue({data: function () {this.$notify({title: "<?php echo panda_pz('disable_copy_style_title')?>",message: "<?php echo panda_pz('disable_copy_style_message')?>",position: 'bottom-right',offset: 50,showClose: false,type: "error"});return {visible: false}}})
        return false;}</script>
    <?php }add_action('wp_footer', 'disable_copy_style');
}

// 禁用鼠标右键
if (panda_pz('disable_right_click_style')) {
    function disable_right_click_style(){?>
        <script>document.oncontextmenu = function () {new Vue({data: function () {this.$notify({title: "<?php echo panda_pz('disable_right_click_style_title')?>",message: "<?php echo panda_pz('disable_right_click_style_message')?>",position: 'bottom-right',offset: 50,showClose: false,type: "warning"});return { visible: false }}})
                return false;}</script>
    <?php }add_action('wp_footer', 'disable_right_click_style');
}

function disable_hotkey() {?>
    <script>
        document.onkeydown = function (event) {
            <?php if (panda_pz('disable_hotkey_ctrl_s')) {?>
                if (event.ctrlKey && event.keyCode == 83) {event.preventDefault();new Vue({data: function () {this.$notify({title: "<?php echo panda_pz('disable_hotkey_ctrl_s_title')?>",message: "<?php echo panda_pz('disable_hotkey_ctrl_s_message')?>",position: 'bottom-right',offset: 50,showClose: true,type: "error"});return {visible: false}}})
                return false;}
            <?php } if (panda_pz('disable_hotkey_ctrl_u')) {?>
                if (event.ctrlKey && event.keyCode == 85) {event.preventDefault();new Vue({data: function () {this.$notify({title: "<?php echo panda_pz('disable_hotkey_ctrl_u_title')?>",message: "<?php echo panda_pz('disable_hotkey_ctrl_u_message')?>",position: 'bottom-right',offset: 50,showClose: true,type: "error"});return {visible: false}}})
                return false;}
            <?php } if (panda_pz('disable_hotkey_ctrl_f')) {?>
                if (event.ctrlKey && event.keyCode == 70) { event.preventDefault();new Vue({data: function () {this.$notify({title: "<?php echo panda_pz('disable_hotkey_ctrl_f_title')?>",message: "<?php echo panda_pz('disable_hotkey_ctrl_f_message')?>",position: 'bottom-right',offset: 50,showClose: true,type: "error"});return {visible: false}}})
                return false;}
            <?php } if (panda_pz('disable_hotkey_ctrl_p')) {?>
                if (event.ctrlKey && event.keyCode == 80) { event.preventDefault();new Vue({data: function () {this.$notify({title: "<?php echo panda_pz('disable_hotkey_ctrl_p_title')?>",message: "<?php echo panda_pz('disable_hotkey_ctrl_p_message')?>",position: 'bottom-right',offset: 50,showClose: true,type: "error"});return {visible: false}}})
                return false;}
            <?php } if (panda_pz('disable_hotkey_ctrl_shift_i')) {?>
                if (event.ctrlKey && event.shiftKey && event.keyCode == 73) { event.preventDefault();new Vue({data: function () {this.$notify({title: "<?php echo panda_pz('disable_hotkey_ctrl_shift_i_title')?>",message: "<?php echo panda_pz('disable_hotkey_ctrl_shift_i_message')?>",position: 'bottom-right',offset: 50,showClose: false,type: "error"});return {visible: false}}})
                return false;}
            <?php } if (panda_pz('disable_hotkey_f12')) {?>
                if (event.keyCode == 123) {event.preventDefault();new Vue({data: function () {this.$notify({title: "<?php echo panda_pz('disable_hotkey_f12_title')?>",message: "<?php echo panda_pz('disable_hotkey_f12_message')?>",position: 'bottom-right',offset: 50,showClose: false,type: "error"});return {visible: false}}}) 
                return false;}
            <?php } ?>
        };
    </script>
<?php } add_action('wp_head', 'disable_hotkey');

/*开启f12跳转模式*/
if (panda_pz('f12_jump_style')) {
    function f12_jump_style(){?>
        <script type="module">import devtools from '<?php echo panda_pz('static_panda');?>/assets/others/banf12/js/moukey.js';if (devtools.isOpen) {window.location.href = "<?php echo panda_pz('static_panda');?>/assets/others/banf12"};window.addEventListener('devtoolschange', event => {if (event.detail.isOpen) {window.location.href = "<?php echo panda_pz('static_panda');?>/assets/others/banf12"};});</script>
    <?php } add_action('wp_head', 'f12_jump_style');
}

/*禁用鼠标选中*/
if (panda_pz('disable_mouse_select_style')) {
    function disable_mouse_select_style(){?>
        <script>document.onselectstart = function () {new Vue({data: function () {this.$notify({title: "<?php echo panda_pz('disable_mouse_select_style_title')?>",message: "<?php echo panda_pz('disable_mouse_select_style_message')?>",position: 'bottom-right',offset: 50,showClose: false,type: "error"});return {visible: false}}})
                return false;}</script>
    <?php } add_action('wp_head', 'disable_mouse_select_style');
}

/* 禁止鼠标拖动 */
if (panda_pz('disable_drag_style')) {
    function disable_drag_style(){?>
        <script>document.ondragstart = function () {new Vue({data: function () {this.$notify({title: "<?php echo panda_pz('disable_drag_style_title')?>",message: "<?php echo panda_pz('disable_drag_style_message')?>",position: 'bottom-right',offset: 50,showClose: false,type: "error"});return {visible: false}}})
                return false;}</script>
<?php } add_action('wp_head', 'disable_drag_style');
}

// 覆盖父主题的头部输出，优先输出站点图标，同时保留父主题的其他头部内容
if (!function_exists('panda_head_favicon')) {
    function panda_head_favicon() {
        if (is_admin()) {
            return;
        }
        $icon = '';
        if (function_exists('has_site_icon') && has_site_icon() && function_exists('get_site_icon_url')) {
            $icon = get_site_icon_url(32);
        }
        if (!$icon && function_exists('_pz') && _pz('favicon')) {
            $icon = _pz('favicon');
        }
        if (!$icon) {
            $icon = home_url('/') . 'favicon.ico';
        }
        if ($icon) {
            echo "<link rel='shortcut icon' href='" . esc_url($icon) . "'>";
            echo "<link rel='icon' href='" . esc_url($icon) . "'>";
        }
        // 同时输出 WordPress 的站点图标标签（若已设置），提升兼容性
        if (function_exists('has_site_icon') && has_site_icon() && function_exists('wp_site_icon')) {
            wp_site_icon();
        }
    }
}

if (!function_exists('panda_head')) {
    function panda_head() {
        panda_head_favicon();
        if (function_exists('zib_head_css')) { zib_head_css(); }
        if (function_exists('zib_head_code')) { zib_head_code(); }
        if (function_exists('zib_head_other')) { zib_head_other(); }
    }
    // 移除父主题默认的头部输出，避免无效 favicon 覆盖
    remove_action('wp_head', 'zib_head');
    add_action('wp_head', 'panda_head', 10);
}
