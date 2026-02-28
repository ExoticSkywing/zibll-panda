<?php
// 使用 Panda_CFSwidget 类创建一个名为 'widget_links' 的小工具
Panda_CFSwidget::create('widget_links', array(
    'title'       => 'links-旗下网站',  // 小工具标题
    'zib_title'   => true,  // 是否显示模块标题菜单
    'zib_affix'   => true,  // 是否显示侧栏随动菜单
    'description' => '显示旗下网站，建议侧边栏显示',  // 描述
    'fields'      => array(
        array(
            'title'       => '第一个文字',
            'id'          => 'link_1_text',
            'type'        => 'text',
            'default'     => '',
            'description' => '第一个链接文字'
        ),
        array(
            'title'       => '第一个按钮',
            'id'          => 'link_1_btn',
            'type'        => 'text',
            'default'     => '',
            'description' => '第一个按钮文字'
        ),
        array(
            'title'       => '第一个链接',
            'id'          => 'link_1_url',
            'type'        => 'text',
            'default'     => '',
            'description' => '第一个链接地址'
        ),

        array(
            'title'       => '第二个文字',
            'id'          => 'link_2_text',
            'type'        => 'text',
            'default'     => '',
            'description' => '第二个链接文字'
        ),
        array(
            'title'       => '第二个按钮',
            'id'          => 'link_2_btn',
            'type'        => 'text',
            'default'     => '',
            'description' => '第二个按钮文字'
        ),
        array(
            'title'       => '第二个链接',
            'id'          => 'link_2_url',
            'type'        => 'text',
            'default'     => '',
            'description' => '第二个链接地址'
        ),

        array(
            'title'       => '第三个文字',
            'id'          => 'link_3_text',
            'type'        => 'text',
            'default'     => '',
            'description' => '第三个链接文字'
        ),
        array(
            'title'       => '第三个按钮',
            'id'          => 'link_3_btn',
            'type'        => 'text',
            'default'     => '',
            'description' => '第三个按钮文字'
        ),
        array(
            'title'       => '第三个链接',
            'id'          => 'link_3_url',
            'type'        => 'text',
            'default'     => '',
            'description' => '第三个链接地址'
        ),

        array(
            'title'       => '第四个文字',
            'id'          => 'link_4_text',
            'type'        => 'text',
            'default'     => '',
            'description' => '第四个链接文字'
        ),
        array(
            'title'       => '第四个按钮',
            'id'          => 'link_4_btn',
            'type'        => 'text',
            'default'     => '',
            'description' => '第四个按钮文字'
        ),
        array(
            'title'       => '第四个链接',
            'id'          => 'link_4_url',
            'type'        => 'text',
            'default'     => '',
            'description' => '第四个链接地址'
        ),

        array(
            'title'       => '第五个文字',
            'id'          => 'link_5_text',
            'type'        => 'text',
            'default'     => '',
            'description' => '第五个链接文字'
        ),
        array(
            'title'       => '第五个按钮',
            'id'          => 'link_5_btn',
            'type'        => 'text',
            'default'     => '',
            'description' => '第五个按钮文字'
        ),
        array(
            'title'       => '第五个链接',
            'id'          => 'link_5_url',
            'type'        => 'text',
            'default'     => '',
            'description' => '第五个链接地址'
        ),

        array(
            'title'       => '隐藏背景盒子',
            'id'          => 'hide_box',
            'type'        => 'checkbox',
            'default'     => '',
            'description' => '勾选后不显示背景盒子'
        ),
    )
));

// 定义小工具显示函数
function widget_links($args, $instance)
{
    // 获取显示规则class
    $show_class = Panda_CFSwidget::show_class($instance);

    $hide_box   = !empty($instance['hide_box']);
    $box_class  = $hide_box ? '' : ' zib-widget';

    // 输出前置HTML
    Panda_CFSwidget::echo_before($instance, $box_class);

    echo '<div class="user_lists">';
    echo '<style type="text/css">
        .zhan-widget-link{position:relative;margin-bottom:-10px !important;display:block;font-size:13px;background:#fff;color:#525252;line-height:40px;margin-left:-10px;padding:0 14px;border:1px solid #DDD;border-radius:2px;width:auto}
        span.zhan-widget-link.zhan-link-z1 {margin-top: -10px;}
        .zhan-widget-link-count i{margin-right:9px;font-size:17px;vertical-align:middle}
        .zhan-widget-link-title{position:absolute;top:-1px;right:-14px !important;bottom:-1px;width:100px;text-align:center;background:rgba(255,255,255,.08);transition:width .3s;border-radius:0 3px 3px 0}
        .zhan-widget-link:hover .zhan-widget-link-title{width:116px}
        .zhan-widget-link a{position:absolute;top:0;left:0;right:0;bottom:0}
        .zhan-link-z1{border-color:rgba(236,61,81,.39)}.zhan-link-z1 .zhan-widget-link-title{background-color:#ec3d51;color:#fff}
        .zhan-link-z2{border-color:rgba(18,170,232,.39)}.zhan-link-z2 .zhan-widget-link-title{background-color:#12aae8;color:#fff}
        .zhan-link-z3{border-color:rgba(221,7,208,.39)}.zhan-link-z3 .zhan-widget-link-title{background-color:#dd07d0;color:#fff}
        .zhan-link-z4{border-color:rgba(249,82,16,.39)}.zhan-link-z4 .zhan-widget-link-title{background-color:#f95210;color:#fff}
        .zhan-link-z5{border-color:rgba(25,152,114,.39)}.zhan-link-z5 .zhan-widget-link-title{background-color:#199872;color:#fff}
    </style>';

    for ($i = 1; $i <= 5; $i++) {
        if (!empty($instance["link_{$i}_text"]) && !empty($instance["link_{$i}_btn"]) && !empty($instance["link_{$i}_url"])) {
            echo '<span class="zhan-widget-link zhan-link-z'.$i.'">';
            echo '<span class="zhan-widget-link-count">'.esc_html($instance["link_{$i}_text"]).'</span>';
            echo '<a href="'.esc_url($instance["link_{$i}_url"]).'" target="_blank" rel="noopener">';
            echo '<span class="zhan-widget-link-title">'.esc_html($instance["link_{$i}_btn"]).'</span>';
            echo '</a></span><br />';
        }
    }

    echo '</div>';

    // 输出后置HTML
    Panda_CFSwidget::echo_after($instance);
}
