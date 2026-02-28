<?php
// 使用Panda_CFSwidget类创建一个名为'widget_ui_marquee'的小工具
Panda_CFSwidget::create('widget_ui_marquee', array(
    'title'       => 'marquee-跑马灯公告',  // 小工具的标题
    'zib_title'   => true,  // 是否显示模块标题菜单
    'description' => '显示跑马灯公告，建议首页全宽度使用。',  // 小工具的描述
    'fields'      => array(  // 配置小工具的字段
        array(
            'title'       => '公告内容',  // 字段标题
            'id'          => 'text',  // 字段ID，用于在前端引用
            'type'        => 'text',  // 字段类型，文本框
            'default'     => '',  // 字段的默认值
            'description' => '请输入要显示的公告内容'  // 字段描述，说明用途
        ),
        array(
            'title'       => '不显示背景盒子',
            'id'          => 'hide_box',
            'type'        => 'checkbox',
            'default'     => '',
        )
    )
));

// 定义显示小工具的函数
function widget_ui_marquee($args, $instance)
{
    // 可用于是否显示判断
    $show_class = Panda_CFSwidget::show_class($instance);//值为1或者0

    // 获取小工具字段值
    $text = $instance['text'];
    $hide_box = isset($instance['hide_box']) ? $instance['hide_box'] : false;
    
    // 构建小工具的HTML输出
    $class = $hide_box ? '' : ' zib-widget';
    
    $html = '<div class="user_lists' . $class . '">';
    $html .= '<style>
                #nr{font-size:20px; margin: 0; background: -webkit-linear-gradient(left, #ffffff, #ff0000 6.25%, #ff7d00 12.5%, #ffff00 18.75%, #00ff00 25%, #00ffff 31.25%, #0000ff 37.5%, #ff00ff 43.75%, #ffff00 50%, #ff0000 56.25%, #ff7d00 62.5%, #ffff00 68.75%, #00ff00 75%, #00ffff 81.25%, #0000ff 87.5%, #ff00ff 93.75%, #ffff00 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-size: 200% 100%; animation: masked-animation 2s infinite linear;} @keyframes masked-animation{0%{background-position: 0 0;} 100%{background-position: -100%, 0;} }
              </style>
              <div style="background-color:#333;border-radius:25px;box-shadow:0px 0px 5px #f200ff;padding:5px;margin-bottom:0px;margin:10px;">
                  <marquee>
                  <b id="nr">'.esc_html($text).'</b> </marquee>
              </div>';
    $html .= '</div>';

    // 在小工具内容之前调用Panda_CFSwidget的echo_before函数
    Panda_CFSwidget::echo_before($instance, '');

    // 输出小工具内容
    echo $html;

    // 在小工具内容之后调用Panda_CFSwidget的echo_after函数
    Panda_CFSwidget::echo_after($instance);
}
?>