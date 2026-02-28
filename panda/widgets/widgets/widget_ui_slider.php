<?php
Panda_CFSwidget::create('panda_widget_ui_slider', array(
    'title'       => '幻灯片(新布局)',
    'zib_affix'   => true,
    'zib_show'    => true,
    'description' => '新布局的幻灯片组件',
    'fields'      => array(
        array(
            'id'     => 'slides1',
            'type'   => 'group',
            'min'    => '1',
            'accordion_title_number'   => true,
            'accordion_title_auto'     => false,
            'accordion_title_prefix'   => '幻灯片',
            'button_title'             => '添加幻灯片',
            'title'    => '第1个幻灯片内容',
            'subtitle' => '添加幻灯片',
            'desc'     => '注意：当添加的幻灯片内容只有一个的时候，则不会以幻灯片的形式展示。',
            'default'   => array(
                array(
                    'background' =>'http://127.0.0.1/wp-content/uploads/2024/06/O1CN01HQds5n1QbIh9ZD5r9_2210123621994.jpg',
                    'link'  => array('url' => 'https://example.com/1', 'target' => '_blank'),
                    'text_align'  => 'left-bottom',
                    'text_size_m'  => 20,
                    'text_size_pc'  => 30,
                ),
            ),
            'fields' => CFS_Module::add_slider(),
        ),
        array(
            'id'     => 'slides2',
            'type'   => 'group',
            'min'    => '1',
            'accordion_title_number'   => true,
            'accordion_title_auto'     => false,
            'accordion_title_prefix'   => '幻灯片',
            'button_title'             => '添加幻灯片',
            'title'    => '第2个幻灯片内容',
            'subtitle' => '添加幻灯片',
            'desc'     => '注意：当添加的幻灯片内容只有一个的时候，则不会以幻灯片的形式展示。',
            'default'   => array(
                array(
                    'background' =>'http://127.0.0.1/wp-content/uploads/2024/06/O1CN01HQds5n1QbIh9ZD5r9_2210123621994.jpg',
                    'link'  => array('url' => 'https://example.com/1', 'target' => '_blank'),
                    'text_align'  => 'left-bottom',
                    'text_size_m'  => 20,
                    'text_size_pc'  => 30,
                ),
            ),
            'fields' => CFS_Module::add_slider(),
        ),
        array(
            'id'     => 'slides3',
            'type'   => 'group',
            'min'    => '1',
            'accordion_title_number'   => true,
            'accordion_title_auto'     => false,
            'accordion_title_prefix'   => '幻灯片',
            'button_title'             => '添加幻灯片',
            'title'    => '第3个幻灯片内容',
            'subtitle' => '添加幻灯片',
            'desc'     => '注意：当添加的幻灯片内容只有一个的时候，则不会以幻灯片的形式展示。',
            'default'   => array(
                array(
                    'background' => 'http://127.0.0.1/wp-content/uploads/2024/06/O1CN01HQds5n1QbIh9ZD5r9_2210123621994.jpg',
                    'link'  => array('url' => 'https://example.com/1', 'target' => '_blank'),
                    'text_align'  => 'left-bottom',
                    'text_size_m'  => 20,
                    'text_size_pc'  => 30,
                ),
            ),
            'fields' => CFS_Module::add_slider(),
        ),
        array(
            'id'     => 'slides4',
            'type'   => 'group',
            'min'    => '1',
            'accordion_title_number'   => true,
            'accordion_title_auto'     => false,
            'accordion_title_prefix'   => '幻灯片',
            'button_title'             => '添加幻灯片',
            'title'    => '第4个幻灯片内容',
            'subtitle' => '添加幻灯片',
            'desc'     => '注意：当添加的幻灯片内容只有一个的时候，则不会以幻灯片的形式展示。',
            'default'   => array(
                array(
                    'background' => 'http://127.0.0.1/wp-content/uploads/2024/06/O1CN01HQds5n1QbIh9ZD5r9_2210123621994.jpg',
                    'link'  => array('url' => 'https://example.com/1', 'target' => '_blank'),
                    'text_align'  => 'left-bottom',
                    'text_size_m'  => 20,
                    'text_size_pc'  => 30,
                ),
            ),
            'fields' => CFS_Module::add_slider(),
        ),
        array(
            'id'     => 'slides5',
            'type'   => 'group',
            'min'    => '1',
            'accordion_title_number'   => true,
            'accordion_title_auto'     => false,
            'accordion_title_prefix'   => '幻灯片',
            'button_title'             => '添加幻灯片',
            'title'    => '第5个幻灯片内容',
            'subtitle' => '添加幻灯片',
            'desc'     => '注意：当添加的幻灯片内容只有一个的时候，则不会以幻灯片的形式展示。',
            'default'   => array(
                array(
                    'background' => 'http://127.0.0.1/wp-content/uploads/2024/06/O1CN01HQds5n1QbIh9ZD5r9_2210123621994.jpg',
                    'link'  => array('url' => 'https://example.com/1', 'target' => '_blank'),
                    'text_align'  => 'left-bottom',
                    'text_size_m'  => 20,
                    'text_size_pc'  => 30,
                ),
            ),
            'fields' => CFS_Module::add_slider(),
        ),
        array(
            'id'            => 'option',
            'type'          => 'accordion',
            'title'         => '幻灯片设置',
            'default'   => array(
                'direction'   => 'horizontal',
                'button'      => true,
                'pagination'  => true,
                'effect'      => 'slide',
                'auto_height' => false,
                'pc_height'   => 400,
                'm_height'    => 240,
                'spacebetween' => 15,
                'speed'       => 0,
                'interval'    => 4,
            ),
            'accordions'    => array(
                array(
                    'title'     => '幻灯片设置',
                    'icon'      => 'fa fa-fw fa-angle-right',
                    'fields'    =>array(
                            array(
                                'title'   => '循环切换',
                                'class'   => 'compact',
                                'id'      => 'loop',
                                'default' => true,
                                'type'    => 'switcher',
                            ),
                            array(
                                'title'   => '显示翻页按钮',
                                'class'   => 'compact',
                                'id'      => 'button',
                                'default' => false,
                                'type'    => 'switcher',
                            ),
                            array(
                                'title'   => '显示指示器',
                                'type'    => 'switcher',
                                'id'      => 'pagination',
                                'class'   => 'compact',
                                'default' => false,
                                'type'    => 'switcher',
                            ),
                            array(
                                'id'      => 'effect',
                                'default' => 'slide',
                                'class'   => 'compact',
                                'title'   => '切换动画',
                                'type'    => "select",
                                'options' => array(
                                    'slide'     => __('滑动', 'zib_language'),
                                    'fade'      => __('淡出淡入', 'zib_language'),
                                    'cube'      => __('3D方块', 'zib_language'),
                                    'coverflow' => __('3D滑入', 'zib_language'),
                                    'flip'      => __('3D翻转', 'zib_language'),
                                ),
                            ),
                            array(
                                'id'      => 'pc_height_style',
                                'class'   => 'compact',
                                'title'   => '电脑端高度',
                                'default' => 610,
                                'max'     => 800,
                                'min'     => 120,
                                'step'    => 20,
                                'unit'    => 'PX',
                                'type'    => 'spinner',
                            ),
                            array(
                                'id'      => 'm_height_style',
                                'title'   => '移动端高度',
                                'class'   => 'compact',
                                'default' => 200,
                                'max'     => 500,
                                'min'     => 100,
                                'step'    => 20,
                                'unit'    => 'PX',
                                'type'    => 'spinner',
                            ),
                            array(
                                'id'       => 'speed',
                                'title'    => '切换速度',
                                'subtitle' => '切换过程的时间(越小越快)',
                                'desc'     => '设置为“0”，则为自动模式：根据幻灯片大小自动设置最佳速度',
                                'class'    => 'compact',
                                'default'  => 0,
                                'max'      => 3000,
                                'min'      => 0,
                                'step'     => 100,
                                'unit'     => '毫秒',
                                'type'     => 'slider',
                            ),
                            array(
                                'title'   => '自动播放',
                                'type'    => 'switcher',
                                'id'      => 'autoplay',
                                'class'   => 'compact',
                                'default' => true,
                                'type'    => 'switcher',
                            ),
                            array(
                                'dependency' => array('autoplay', '!=', ''),
                                'id'         => 'interval',
                                'title'      => '停顿时间',
                                'subtitle'   => '自动切换的时间间隔(越小越快)',
                                'class'      => 'compact',
                                'default'    => 4,
                                'max'        => 20,
                                'min'        => 0,
                                'step'       => 1,
                                'unit'       => '秒',
                                'type'       => 'slider',
                            ),
                    ),
                )
            )
        ),
    )
));

function panda_widget_ui_slider($args, $instance)
{
    $show_class = Zib_CFSwidget::show_class($instance);
    if (empty($instance['option']) || !$show_class) return;
    $instance_style = $instance['option'];
    ?>
    <style>
    .slider-container{height:50%;width:100%;position:relative;display:flex;flex-direction:row;}
    .slider-container .mb20{margin-bottom:0px;}
    .slider-container .item-1 .new-swiper .swiper-slide img:not(.img-icon):not(.smilie-icon):not(.avatar-badge):not(.avatar){width:100%;height:<?php echo $instance_style['pc_height_style']; ?>px;}
    .slider-container .right-side .new-swiper .swiper-slide img:not(.img-icon):not(.smilie-icon):not(.avatar-badge):not(.avatar){width:100%;height:<?php echo ($instance_style['pc_height_style']-10)/2;?>px;}
    .item-1{width:50%;padding:5px;}
    .right-side{display:flex;width:50%;}
    .group-2-3,.group-4-5{display:flex;flex-direction:column;width:calc(50% - 5px);}
    .item-2,.item-3,.item-4,.item-5{width:100%;height:50%;padding:5px;}
    @media (max-width:767px){
    .slider-container .item-1 .new-swiper .swiper-slide img:not(.img-icon):not(.smilie-icon):not(.avatar-badge):not(.avatar){width:100%;height:<?php echo $instance_style['m_height_style']; ?>px;}
    .slider-container .right-side .new-swiper .swiper-slide img:not(.img-icon):not(.smilie-icon):not(.avatar-badge):not(.avatar){width:100%;height:<?php echo ($instance_style['m_height_style'])/2;?>px;}
    .slider-container{flex-direction:column;}
    .item-1{width:100%;height:50%;}
    .right-side{display:flex;flex-direction:row;width:100%;}
    .group-2-3,.group-4-5{display:flex;flex-direction:column;width:calc(50% - 0px);}
    .item-2,.item-3,.item-4,.item-5{width:100%;height:50%;padding:5px;}
    .slider-container .item-1 .new-swiper {height:50%;}
    }</style>
    <?php
    echo '<div class="slider-container">';
    for ($i = 1; $i <= 5; $i++) {
        $slide_key = 'slides' . $i;
        if (empty($instance[$slide_key]) || !is_array($instance[$slide_key]) || empty($instance[$slide_key][0])) continue;
        $header_slider = $instance[$slide_key];
        $header_slider_option = $instance['option'];
        if (!is_array($header_slider_option)) continue;
        $header_slider_option['slides'] = $header_slider;
        if ($i == 1) {
            echo '<div class="item-' . $i . '">';
            Zib_CFSwidget::echo_before($instance);
            zib_new_slider($header_slider_option);
            Zib_CFSwidget::echo_after($instance);
            echo '</div>';
        }
        if ($i > 1) {
            if($i == 2){
                echo '<div class="right-side">';
            }
            if($i < 4){
                if($i == 2){
                    echo '<div class="group-2-3">';
                }
                echo '<div class="item-' . $i . '">';
                Zib_CFSwidget::echo_before($instance);
                zib_new_slider($header_slider_option);
                Zib_CFSwidget::echo_after($instance);
                echo '</div>';
                if($i == 3){
                    echo '</div>';
                }
            }else{
                if($i == 4){
                    echo '<div class="group-4-5">';
                }
                echo '<div class="item-' . $i . '">';
                Zib_CFSwidget::echo_before($instance);
                zib_new_slider($header_slider_option);
                Zib_CFSwidget::echo_after($instance);
                echo '</div>';
                if($i == 5){
                    echo '</div>';
                }
            }
            if($i == 5){
                echo '</div>';
            }
        }
    }
    echo '</div>';
}
?>