<?php
/**
 * 创建合作商Logo轮播小工具
 */

Panda_CFSwidget::create('partner_logo_widget', array(
        'title'       => '合作商Logo轮播展示',
        'zib_title'   => false,
        'zib_affix'   => false,
        'zib_show'    => false,
        'description' => '3行交叉方向轮播的合作商logo展示，第一行和第三行向右滚动，第二行向左滚动',
        'fields'      => array(
            // 标题和副标题
            array(
                'id'      => 'main_title',
                'title'   => '主标题',
                'default' => '汇集安防停车行业众多品牌及共创者技术资料',
                'type'    => 'text',
                'desc'    => '轮播区域的主标题',
            ),
            array(
                'id'      => 'subtitle',
                'title'   => '副标题',
                'default' => '停车技术员感谢每一位企业及个人合作伙伴的支持与信任',
                'type'    => 'text',
                'desc'    => '轮播区域的副标题',
            ),
            array(
                'id'      => 'show_header',
                'title'   => '显示标题区域',
                'type'    => 'switcher',
                'default' => true,
                'desc'    => '是否显示主标题和副标题',
            ),

            // 第一行配置
            array(
                'type'    => 'subheading',
                'content' => '第一行Logo配置（向右滚动）',
            ),
            array(
                'id'          => 'row1_logos',
                'type'        => 'group',
                'title'       => '第一行Logo列表',
                'button_title' => '添加Logo',
                'fields'      => array(
                    array(
                        'id'    => 'image',
                        'type'  => 'media',
                        'title' => 'Logo图片',
                        'library' => 'image',
                    ),
                    array(
                        'id'    => 'link',
                        'type'  => 'text',
                        'title' => '跳转链接',
                        'desc'  => '点击logo后跳转的URL地址',
                    ),
                    array(
                        'id'    => 'title',
                        'type'  => 'text',
                        'title' => '标题',
                        'desc'  => '鼠标悬停时显示的标题',
                    ),
                ),
            ),

            // 第二行配置
            array(
                'type'    => 'subheading',
                'content' => '第二行Logo配置（向左滚动）',
            ),
            array(
                'id'          => 'row2_logos',
                'type'        => 'group',
                'title'       => '第二行Logo列表',
                'button_title' => '添加Logo',
                'fields'      => array(
                    array(
                        'id'    => 'image',
                        'type'  => 'media',
                        'title' => 'Logo图片',
                        'library' => 'image',
                    ),
                    array(
                        'id'    => 'link',
                        'type'  => 'text',
                        'title' => '跳转链接',
                        'desc'  => '点击logo后跳转的URL地址',
                    ),
                    array(
                        'id'    => 'title',
                        'type'  => 'text',
                        'title' => '标题',
                        'desc'  => '鼠标悬停时显示的标题',
                    ),
                ),
            ),

            // 第三行配置
            array(
                'type'    => 'subheading',
                'content' => '第三行Logo配置（向右滚动）',
            ),
            array(
                'id'          => 'row3_logos',
                'type'        => 'group',
                'title'       => '第三行Logo列表',
                'button_title' => '添加Logo',
                'fields'      => array(
                    array(
                        'id'    => 'image',
                        'type'  => 'media',
                        'title' => 'Logo图片',
                        'library' => 'image',
                    ),
                    array(
                        'id'    => 'link',
                        'type'  => 'text',
                        'title' => '跳转链接',
                        'desc'  => '点击logo后跳转的URL地址',
                    ),
                    array(
                        'id'    => 'title',
                        'type'  => 'text',
                        'title' => '标题',
                        'desc'  => '鼠标悬停时显示的标题',
                    ),
                ),
            ),

            // 样式配置
            array(
                'type'    => 'subheading',
                'content' => '样式配置',
            ),
            array(
                'id'      => 'card_style',
                'title'   => '卡片样式',
                'type'    => 'select',
                'options' => array(
                    'default' => '默认白色卡片',
                    'theme'   => '主题色卡片',
                    'muted'   => '灰色卡片',
                    'transparent' => '透明背景',
                ),
                'default' => 'default',
            ),
            array(
                'id'      => 'logo_width',
                'title'   => 'Logo宽度（桌面端）',
                'default' => '280',
                'type'    => 'number',
                'unit'    => 'px',
                'desc'    => '桌面端logo卡片宽度',
            ),
            array(
                'id'      => 'logo_height',
                'title'   => 'Logo高度（桌面端）',
                'default' => '180',
                'type'    => 'number',
                'unit'    => 'px',
                'desc'    => '桌面端logo卡片高度',
            ),
            array(
                'id'      => 'animation_speed',
                'title'   => '动画速度',
                'default' => '30',
                'type'    => 'number',
                'unit'    => '秒',
                'desc'    => '轮播动画完成一次循环的时间',
            ),
            array(
                'id'      => 'gap_size',
                'title'   => 'Logo间距',
                'type'    => 'select',
                'options' => array(
                    'sm' => '小间距',
                    'md' => '中等间距',
                    'lg' => '大间距',
                ),
                'default' => 'md',
            ),
        ),
    ));


/**
 * 小工具内容输出函数
 */
function partner_logo_widget($args, $instance)
{
    // 显示控制判断
    $show_class = Panda_CFSwidget::show_class($instance);
    if (!$show_class) {
        return;
    }

    // 获取参数
    $main_title = $instance['main_title'] ?? '汇集安防停车行业众多品牌及共创者技术资料';
    $subtitle = $instance['subtitle'] ?? '停车技术员感谢每一位企业及个人合作伙伴的支持与信任';
    $show_header = $instance['show_header'] ?? true;
    $row1_logos = $instance['row1_logos'] ?? array();
    $row2_logos = $instance['row2_logos'] ?? array();
    $row3_logos = $instance['row3_logos'] ?? array();
    $card_style = $instance['card_style'] ?? 'default';
    $logo_width = $instance['logo_width'] ?? '280';
    $logo_height = $instance['logo_height'] ?? '180';
    $animation_speed = $instance['animation_speed'] ?? '30';
    $gap_size = $instance['gap_size'] ?? 'md';

    // 间距映射
    $gap_map = array(
        'sm' => '1rem',
        'md' => '1.5rem',
        'lg' => '2rem',
    );
    $gap = $gap_map[$gap_size] ?? '1.5rem';
    $gap_desktop = $gap_size === 'sm' ? '2rem' : ($gap_size === 'lg' ? '3rem' : '2.5rem');

    // 生成唯一ID
    $widget_id = 'plc-' . uniqid();

    Panda_CFSwidget::echo_before($instance);

    ?>
    <div class="partner-logo-carousel-widget" id="<?php echo esc_attr($widget_id); ?>">
        <!-- 头部标题 -->
        <?php if ($show_header && ($main_title || $subtitle)): ?>
        <header class="plc-header text-center">
            <?php if ($main_title): ?>
            <h3 class="plc-title em12"><?php echo esc_html($main_title); ?></h3>
            <?php endif; ?>
            <?php if ($subtitle): ?>
            <p class="plc-subtitle muted-2-color em09"><?php echo esc_html($subtitle); ?></p>
            <?php endif; ?>
        </header>
        <?php endif; ?>

        <!-- Logo轮播区域 -->
        <main class="plc-main">
            <?php
            // 渲染第一行（向右）
            echo render_logo_row($row1_logos, 'right', $widget_id . '-row1', $card_style);
            // 渲染第二行（向左）
            echo render_logo_row($row2_logos, 'left', $widget_id . '-row2', $card_style);
            // 渲染第三行（向右）
            echo render_logo_row($row3_logos, 'right', $widget_id . '-row3', $card_style);
            ?>
        </main>
    </div>

    <style>
        #<?php echo esc_attr($widget_id); ?> {
            width: 100%;
            overflow: hidden;
        }

        #<?php echo esc_attr($widget_id); ?> .plc-header {
            padding: 1rem 0;
            margin-bottom: 1rem;
        }

        @media (min-width: 768px) {
            #<?php echo esc_attr($widget_id); ?> .plc-header {
                padding: 1.5rem 0;
                margin-bottom: 1.5rem;
            }
        }

        #<?php echo esc_attr($widget_id); ?> .plc-title {
            font-weight: bold;
            color: var(--key-color);
            margin-bottom: 0.5rem;
            line-height: 1.4;
        }

        #<?php echo esc_attr($widget_id); ?> .plc-subtitle {
            color: var(--muted-2-color);
            margin: 0;
            line-height: 1.6;
        }

        #<?php echo esc_attr($widget_id); ?> .plc-main {
            width: 100%;
            padding: 0.5rem 0;
        }

        @media (min-width: 768px) {
            #<?php echo esc_attr($widget_id); ?> .plc-main {
                padding: 1rem 0;
            }
        }

        #<?php echo esc_attr($widget_id); ?> .plc-row {
            overflow: hidden;
            margin-bottom: 1rem;
            position: relative;
        }

        @media (min-width: 768px) {
            #<?php echo esc_attr($widget_id); ?> .plc-row {
                margin-bottom: 1.5rem;
            }
        }

        #<?php echo esc_attr($widget_id); ?> .plc-track {
            display: flex;
            gap: <?php echo esc_attr($gap); ?>;
        }

        @media (min-width: 768px) {
            #<?php echo esc_attr($widget_id); ?> .plc-track {
                gap: <?php echo esc_attr($gap_desktop); ?>;
            }
        }

        #<?php echo esc_attr($widget_id); ?> .plc-card {
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: var(--main-radius);
            transition: box-shadow 0.3s, transform 0.3s, opacity 0.3s;
            padding: 1rem;
            width: 140px;
            height: 90px;
            position: relative;
            overflow: hidden;
        }

        @media (min-width: 768px) {
            #<?php echo esc_attr($widget_id); ?> .plc-card {
                padding: 1.5rem;
                width: <?php echo esc_attr($logo_width); ?>px;
                height: <?php echo esc_attr($logo_height); ?>px;
            }
        }

        /* 卡片样式变体 */
        #<?php echo esc_attr($widget_id); ?> .plc-card.card-default {
            background: var(--main-bg-color);
            box-shadow: 0 1px 3px var(--main-shadow);
        }

        #<?php echo esc_attr($widget_id); ?> .plc-card.card-theme {
            background: var(--theme-color);
            box-shadow: 0 1px 3px rgba(240, 68, 148, 0.2);
        }

        #<?php echo esc_attr($widget_id); ?> .plc-card.card-muted {
            background: var(--muted-bg-color);
            box-shadow: 0 1px 3px var(--main-shadow);
        }

        #<?php echo esc_attr($widget_id); ?> .plc-card.card-transparent {
            background: transparent;
            box-shadow: none;
        }

        #<?php echo esc_attr($widget_id); ?> .plc-card:hover {
            box-shadow: 0 4px 12px var(--main-shadow);
            transform: translateY(-3px);
        }

        #<?php echo esc_attr($widget_id); ?> .plc-card.card-transparent:hover {
            box-shadow: 0 2px 8px var(--main-shadow);
            background: var(--main-bg-color);
        }

        #<?php echo esc_attr($widget_id); ?> .plc-card img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            transition: transform 0.3s;
        }

        #<?php echo esc_attr($widget_id); ?> .plc-card:hover img {
            transform: scale(1.05);
        }

        /* 动画 */
        @keyframes plc-scroll-left-<?php echo esc_attr($widget_id); ?> {
            0% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(-50%);
            }
        }

        @keyframes plc-scroll-right-<?php echo esc_attr($widget_id); ?> {
            0% {
                transform: translateX(-50%);
            }
            100% {
                transform: translateX(0);
            }
        }

        #<?php echo esc_attr($widget_id); ?> .plc-animate-left {
            animation: plc-scroll-left-<?php echo esc_attr($widget_id); ?> <?php echo esc_attr($animation_speed); ?>s linear infinite;
        }

        #<?php echo esc_attr($widget_id); ?> .plc-animate-right {
            animation: plc-scroll-right-<?php echo esc_attr($widget_id); ?> <?php echo esc_attr($animation_speed); ?>s linear infinite;
        }

        /* 移动端加快动画速度 */
        @media (max-width: 768px) {
            #<?php echo esc_attr($widget_id); ?> .plc-animate-left {
                animation: plc-scroll-left-<?php echo esc_attr($widget_id); ?> <?php echo esc_attr($animation_speed * 0.66); ?>s linear infinite;
            }

            #<?php echo esc_attr($widget_id); ?> .plc-animate-right {
                animation: plc-scroll-right-<?php echo esc_attr($widget_id); ?> <?php echo esc_attr($animation_speed * 0.66); ?>s linear infinite;
            }
        }

        /* 鼠标悬停时暂停动画 */
        #<?php echo esc_attr($widget_id); ?> .plc-track:hover {
            animation-play-state: paused;
        }

        /* 暗黑模式适配 */
        .dark-theme #<?php echo esc_attr($widget_id); ?> .plc-card.card-default {
            background: var(--main-bg-color);
        }

        .dark-theme #<?php echo esc_attr($widget_id); ?> .plc-card.card-muted {
            background: var(--muted-bg-color);
        }
    </style>
    <?php

    Panda_CFSwidget::echo_after($instance);
}

/**
 * 渲染单行logo
 */
function render_logo_row($logos, $direction, $row_id, $card_style = 'default')
{
    if (empty($logos)) {
        return '';
    }

    // 复制logo数组以实现无缝循环
    $duplicated_logos = array_merge($logos, $logos);

    $animation_class = $direction === 'right' ? 'plc-animate-right' : 'plc-animate-left';
    $card_class = 'card-' . $card_style;

    ob_start();
    ?>
    <div class="plc-row">
        <div class="plc-track <?php echo esc_attr($animation_class); ?>" id="<?php echo esc_attr($row_id); ?>">
            <?php foreach ($duplicated_logos as $index => $logo): ?>
                <?php
                $image_url = !empty($logo['image']['url']) ? $logo['image']['url'] : '';
                $link = !empty($logo['link']) ? $logo['link'] : '';
                $title = !empty($logo['title']) ? $logo['title'] : '';
                
                if (!$image_url) {
                    continue;
                }
                ?>
                <?php if ($link): ?>
                <a href="<?php echo esc_url($link); ?>" class="plc-card <?php echo esc_attr($card_class); ?>" title="<?php echo esc_attr($title); ?>" target="_blank" rel="noopener noreferrer">
                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($title); ?>">
                </a>
                <?php else: ?>
                <div class="plc-card <?php echo esc_attr($card_class); ?>" title="<?php echo esc_attr($title); ?>">
                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($title); ?>">
                </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

