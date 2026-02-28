<?php
// Panda 主题小工具：zibll 首页横幅（滚动推荐卡片）

// 注册小工具配置
Panda_CFSwidget::create('zibll_home_banner', array(
    'title'       => '滚动推荐卡片',
    'zib_title'   => false,
    'zib_affix'   => false,
    'zib_show'    => true,
    'description' => '首页横幅区域，包含标题、标签、分类和轮播图',
    'fields'      => array(
        array(
            'id'      => 'banner_title1',
            'title'   => '横幅大标题1',
            'type'    => 'text',
            'default' => '分享绿色',
        ),
        array(
            'id'      => 'banner_title2',
            'title'   => '横幅大标题2',
            'type'    => 'text',
            'default' => '与精品应用',
        ),
        array(
            'id'      => 'banner_domain',
            'title'   => '域名显示',
            'type'    => 'text',
            'default' => '902d.com',
        ),
        array(
            'id'      => 'random_link',
            'title'   => '随便逛逛链接',
            'type'    => 'text',
            'default' => 'https://www.902d.com/',
        ),
        array(
            'id'      => 'random_text',
            'title'   => '随便逛逛文案',
            'type'    => 'text',
            'default' => '随便逛逛',
        ),
        array(
            'id'      => 'release_link',
            'title'   => '发布需求链接',
            'type'    => 'text',
            'default' => 'https://www.902d.com/',
        ),
        array(
            'id'      => 'release_text',
            'title'   => '发布需求文案',
            'type'    => 'text',
            'default' => '发布需求',
        ),
        array(
            'id'      => 'show_tags',
            'title'   => '显示标签图标',
            'type'    => 'switcher',
            'default' => '1',
        ),
        // 简化：提供最多3张轮播图配置
        array('id' => 'slide1_img', 'title' => '轮播1图片URL', 'type' => 'text', 'default' => ''),
        array('id' => 'slide1_link', 'title' => '轮播1链接', 'type' => 'text', 'default' => '#'),
        array('id' => 'slide1_nofollow', 'title' => '轮播1nofollow', 'type' => 'switcher', 'default' => '1'),
        array('id' => 'slide2_img', 'title' => '轮播2图片URL', 'type' => 'text', 'default' => ''),
        array('id' => 'slide2_link', 'title' => '轮播2链接', 'type' => 'text', 'default' => '#'),
        array('id' => 'slide2_nofollow', 'title' => '轮播2nofollow', 'type' => 'switcher', 'default' => '1'),
        array('id' => 'slide3_img', 'title' => '轮播3图片URL', 'type' => 'text', 'default' => ''),
        array('id' => 'slide3_link', 'title' => '轮播3链接', 'type' => 'text', 'default' => '#'),
        array('id' => 'slide3_nofollow', 'title' => '轮播3nofollow', 'type' => 'switcher', 'default' => '1'),
    )
));

// 小工具渲染函数（名称需与create第一个参数一致）
function zibll_home_banner($args, $instance)
{
    $show_class = Panda_CFSwidget::show_class($instance);
    if (!$show_class) {
        return;
    }

    Panda_CFSwidget::echo_before($instance, '');

    // 引入样式
    if (function_exists('wp_enqueue_style')) {
        wp_enqueue_style('panda-home-banner', get_template_directory_uri() . '/assets/css/home_banner.css', array(), '1.0.0');
    }

    // 字段获取
    $title1       = isset($instance['banner_title1']) ? $instance['banner_title1'] : '分享绿色';
    $title2       = isset($instance['banner_title2']) ? $instance['banner_title2'] : '与精品应用';
    $domain       = isset($instance['banner_domain']) ? $instance['banner_domain'] : '902d.com';
    $random_link  = isset($instance['random_link']) ? $instance['random_link'] : 'https://www.902d.com/';
    $random_text  = isset($instance['random_text']) ? $instance['random_text'] : '随便逛逛';
    $release_link = isset($instance['release_link']) ? $instance['release_link'] : 'https://www.902d.com/';
    $release_text = isset($instance['release_text']) ? $instance['release_text'] : '发布需求';
    $show_tags    = isset($instance['show_tags']) ? $instance['show_tags'] : '1';

    // 轮播图整理（最多3张）
    $slides = array();
    for ($i = 1; $i <= 3; $i++) {
        $img = isset($instance['slide' . $i . '_img']) ? trim($instance['slide' . $i . '_img']) : '';
        if ($img) {
            $slides[] = array(
                'link'     => isset($instance['slide' . $i . '_link']) ? $instance['slide' . $i . '_link'] : '#',
                'img'      => $img,
                'nofollow' => isset($instance['slide' . $i . '_nofollow']) && $instance['slide' . $i . '_nofollow'] === '1',
            );
        }
    }

    // 控制是否显示标签组
    if ($show_tags !== '1') {
        echo '<style>.tags-group-all{display:none}</style>';
    }

    // 输出HTML（参考原插件渲染，简化分类按钮与标签内容）
    ?>
    <div id="home_top">
        <div class="recent-top-post-group" id="recent-top-post-group">
            <div class="recent-post-top" id="recent-post-top" style="display:flex;">
                <div id="bannerGroup">
                    <div id="banners">
                        <div class="banners-title">
                            <div class="banners-title-big"><?php echo esc_html($title1); ?></div>
                            <div class="banners-title-big"><?php echo esc_html($title2); ?></div>
                            <div class="banners-title-small"><?php echo esc_html($domain); ?></div>
                        </div>

                        <div class="tags-group-all">
                            <div class="tags-group-wrapper">
                                <!-- 可在此处添加标签图标; 为保持简洁此处留空 -->
                            </div>
                        </div>

                        <a id="banner-hover" href="<?php echo esc_url($random_link); ?>" rel="external nofollow">
                            <i class="heofont icon-right"></i>
                            <span class="bannerText"><?php echo esc_html($random_text); ?></span>
                        </a>
                    </div>
                </div>

                <div class="topGroup">
                    <div class="todayCard" id="todayCard" style="z-index: 1;" data-autoplay-delay="4000">
                        <div class="todayCard-info">
                            <div class="todayCard-tips"><?php echo esc_html($domain); ?></div>
                            <div class="todayCard-title"></div>
                        </div>
                        <div class="todayCard-cover-slides" style="position: relative; overflow: hidden;">
                            <div class="todayCard-slides-wrapper" style="transform: translateX(0%);">
                                <?php foreach ($slides as $slide) : ?>
                                    <a href="<?php echo esc_url($slide['link']); ?>" target="_blank"
                                       class="todayCard-slide-item"
                                       style="background-image: url('<?php echo esc_url($slide['img']); ?>');"
                                       <?php echo $slide['nofollow'] ? 'rel="external nofollow"' : ''; ?>>
                                        <span class="slide-link-area"></span>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                            <div class="todayCard-indicators">
                                <?php foreach ($slides as $index => $slide) : ?>
                                    <span class="indicator-dot <?php echo $index === 0 ? 'active' : ''; ?>" data-idx="<?php echo $index; ?>"></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="banner-button-group">
                            <a class="banner-button" href="<?php echo esc_url($release_link); ?>" rel="external nofollow">
                                <span class="banner-button-text"><?php echo esc_html($release_text); ?></span>
                            </a>
                        </div>
                        <span class="todayCard-arrow todayCard-arrow-left">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="15 18 9 12 15 6"></polyline>
                            </svg>
                        </span>
                        <span class="todayCard-arrow todayCard-arrow-right">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </span>
                        <style>
                            .todayCard-slides-wrapper a{z-index:999}
                            .todayCard-slide-item .slide-link-area{pointer-events:none}
                            .todayCard-slide-item .slide-link-area{display:block;width:100%;height:100%;pointer-events:none}
                            .todayCard-cover-slides{position:relative;width:100%;height:100%;overflow:hidden;z-index:1}
                            .todayCard-slides-wrapper{display:flex;transition:transform .8s cubic-bezier(.4,0,.2,1);will-change:transform}
                            .todayCard-slide-item{flex:0 0 100%;background-size:cover;background-position:center;display:block;position:relative}
                            .todayCard-slide-item .slide-link-area{display:block;width:100%;height:100%}
                            .todayCard-indicators{position:absolute;left:0;right:0;bottom:10px;text-align:center;z-index:10;pointer-events:none}
                            .todayCard-indicators .indicator-dot{display:inline-block;margin:0 3px;background:rgba(255,255,255,.7);transition:background .3s,border-radius .3s,width .3s,height .3s;cursor:pointer;pointer-events:auto;vertical-align:middle;width:7px;height:7px;border-radius:50%}
                            .todayCard-indicators .indicator-dot.active{width:16px;height:6px;border-radius:3px;background:#fff}
                        </style>

                        <script>
                            (function(){
                                var card = document.getElementById('todayCard');
                                if(!card) return;

                                var wrapper = card.querySelector('.todayCard-slides-wrapper');
                                var slides = wrapper ? wrapper.querySelectorAll('.todayCard-slide-item') : [];
                                var indicatorsBox = card.querySelector('.todayCard-indicators');
                                if(!slides.length) return;

                                var idx = 0;
                                function show(i){
                                    if(!slides.length) return;
                                    idx = (i + slides.length) % slides.length;
                                    var translateX = -idx * 100;
                                    wrapper.style.transform = 'translateX(' + translateX + '%)';
                                    var dots = indicatorsBox ? indicatorsBox.querySelectorAll('.indicator-dot') : [];
                                    if(dots.length){
                                        for(var d=0; d<dots.length; d++){
                                            dots[d].classList.remove('active');
                                        }
                                        dots[idx].classList.add('active');
                                    }
                                }
                                show(0);
                                function next(){ show(idx + 1); }
                                function prev(){ show(idx - 1); }

                                var left = card.querySelector('.todayCard-arrow-left');
                                var right = card.querySelector('.todayCard-arrow-right');
                                if(left) left.onclick = function(){ prev(); resetAutoPlay(); };
                                if(right) right.onclick = function(){ next(); resetAutoPlay(); };

                                var dots = indicatorsBox ? indicatorsBox.querySelectorAll('.indicator-dot') : [];
                                if(dots.length){
                                    for(var i=0;i<dots.length;i++){
                                        (function(i){
                                            dots[i].onclick = function(e){ e.stopPropagation(); show(i); resetAutoPlay(); };
                                        })(i);
                                    }
                                }

                                wrapper.addEventListener('wheel', function(e){
                                    e.preventDefault();
                                    if(e.deltaY > 0){ next(); } else if(e.deltaY < 0){ prev(); }
                                    resetAutoPlay();
                                }, {passive: false});

                                var autoplayDelay = parseInt(card.getAttribute('data-autoplay-delay')) || 5000;
                                var autoplayTimer = null;
                                function startAutoPlay(){ stopAutoPlay(); autoplayTimer = setInterval(function(){ next(); }, autoplayDelay); }
                                function stopAutoPlay(){ if(autoplayTimer) clearInterval(autoplayTimer); autoplayTimer = null; }
                                function resetAutoPlay(){ startAutoPlay(); }
                                card.addEventListener('mouseenter', stopAutoPlay);
                                card.addEventListener('mouseleave', startAutoPlay);
                                startAutoPlay();
                            })();
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php

    Panda_CFSwidget::echo_after($instance);
}

?>