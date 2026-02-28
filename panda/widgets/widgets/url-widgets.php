<?php
// 使用Panda_CFSwidget类创建一个名为'widget_ui_url'的小工具
Panda_CFSwidget::create('widget_ui_url', array(
    'title'       => 'url-引流小广告',  // 小工具的标题
    'zib_title'   => true,  // 是否显示模块标题菜单
    'zib_affix'   => true,  // 是否显示侧栏随动菜单
    'description' => '显示引流小广告，建议侧边栏显示。',  // 小工具的描述
    'fields'      => array(  // 配置小工具的字段
        array(
            'title'       => '标题',  // 字段标题
            'id'          => 'url_title',  // 字段ID，用于在前端引用
            'type'        => 'text',  // 字段类型，文本框
            'default'     => 'Panda的小工具',  // 字段的默认值
            'description' => '请输入广告标题'  // 字段描述，说明用途
        ),
        array(
            'title'       => '副标题',  // 字段标题
            'id'          => 'url_mini_title',  // 字段ID，用于在前端引用
            'type'        => 'text',  // 字段类型，文本框
            'default'     => 'Panda推荐，安全有保障',  // 字段的默认值
            'description' => '请输入广告副标题'  // 字段描述，说明用途
        ),
        array(
            'title'       => '链接地址',  // 字段标题
            'id'          => 'to_url',  // 字段ID，用于在前端引用
            'type'        => 'text',  // 字段类型，文本框
            'default'     => 'https://www.scbkw.com',  // 字段的默认值
            'description' => '请输入广告跳转链接'  // 字段描述，说明用途
        ),
        array(
            'title'       => '不显示背景盒子',
            'id'          => 'hide_box',
            'type'        => 'checkbox',
            'default'     => true,
        )
    )
));

// 定义显示小工具的函数
function widget_ui_url($args, $instance)
{
    // 可用于是否显示判断
    $show_class = Panda_CFSwidget::show_class($instance);//值为1或者0

    // 获取小工具字段值
    $title = $instance['url_title'];
    $mini_title = $instance['url_mini_title'];
    $to_url = $instance['to_url'];
    $hide_box = isset($instance['hide_box']) ? $instance['hide_box'] : false;
    
    // 构建HTML输出
    $class = $hide_box ? '' : ' zib-widget';
    
    $html = '<div class="' . esc_attr($class) . '" style="margin:0 0 20px 0;">';
    $html .= '<a class="ads" href="' . esc_url($to_url) . '" target="_blank" style="border-radius:5px;">';
    $html .= '<h4>' . esc_html($title) . '</h4>';
    $html .= '<h5>' . esc_html($mini_title) . '</h5>';
    $html .= '<span class="ads-btn ads-btn-outline">立即进入</span></a>';
    $html .= '<style>
        .ads{display:block; padding:40px 15px; text-align:center; color:#fff!important; background:#ff5719; background-image:-webkit-linear-gradient(135deg,#bbafe7,#5368d9); background-image:linear-gradient(135deg,#bbafe7,#5368d9)}
        .ads h4{margin:0; font-size:22px; font-weight:bold}
        .ads h5{margin:10px 0 0; font-size:14px; font-weight:bold}
        .ads .ads-btn{margin-top:20px; font-weight:bold}
        .ads .ads-btn:hover{color:#ff5719}
        .ads-btn{display:inline-block; font-weight:normal; margin-top:10px; color:#666; text-align:center; vertical-align:top; user-select:none; border:none; padding:0 36px; line-height:38px; font-size:14px; border-radius:10px; outline:0; -webkit-transition:all 0.3s ease-in-out; -moz-transition:all 0.3s ease-in-out; transition:all 0.3s ease-in-out}
        .ads-btn:hover,.btn:focus,.btn.focus{outline:0; text-decoration:none}
        .ads-btn:active,.btn.active{outline:0; box-shadow:inset 0 3px 5px rgba(0,0,0,0.125)}
        .ads-btn-outline{line-height:36px; color:#fff; background-color:transparent; border:1px solid#fff}
        .ads-btn-outline:hover,.btn-outline:focus,.btn-outline.focus{color:#343a3c; background-color:#fff}
    </style>';
    $html .= '</div>';

    // 在小工具内容之前调用Panda_CFSwidget的echo_before函数
    Panda_CFSwidget::echo_before($instance, '');

    // 输出小工具内容
    echo $html;

    // 在小工具内容之后调用Panda_CFSwidget的echo_after函数
    Panda_CFSwidget::echo_after($instance);
}
?>