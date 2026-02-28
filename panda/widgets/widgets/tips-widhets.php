<?php
// 使用Panda_CFSwidget类创建一个名为'widget_ui_tips'的小工具
Panda_CFSwidget::create('widget_ui_tips', array(
    'title'       => 'tips-滚动播报',  // 小工具的标题
    'zib_title'   => true,  // 是否显示模块标题菜单
    'zib_affix'   => true,  // 是否显示侧栏随动菜单
    'description' => '显示滚动播报，建议侧边栏显示。',  // 小工具的描述
    'fields'      => array(  // 配置小工具的字段
        array(
            'title'       => '不显示背景盒子',
            'id'          => 'hide_box',
            'type'        => 'checkbox',
            'default'     => '',
        )
    )
));

// 定义显示小工具的函数
function widget_ui_tips($args, $instance)
{
    // 可用于是否显示判断
    $show_class = Panda_CFSwidget::show_class($instance);//值为1或者0

    // 获取小工具字段值
    $hide_box = isset($instance['hide_box']) ? $instance['hide_box'] : false;
    
    // 构建HTML输出
    $class = $hide_box ? '' : ' zib-widget';
    
    $html = '<div class="user_lists' . esc_attr($class) . '">';
    
    $html .= '<section id="custom_html-2" class="widget_text widget widget_custom_html mar16-b">';
    $html .= '<meta charset="utf-8">';
    $html .= '<div class="textwidget custom-html-widget">';
    $html .= '<aside id="php_text-8" class="widget php_text wow fadeInUp" data-wow-delay="0.3s">';
    $html .= '<div class="textwidget widget-text">';
    $html .= '<style type="text/css">#container-box-1{color:#526372;text-transform:uppercase;width:100%;font-size:16px;line-height:50px;text-align:center}#flip-box-1{overflow:hidden;height:50px}#flip-box-1 div{height:50px}#flip-box-1>div>div{color:#fff;display:inline-block;text-align:center;height:50px;width:100%}#flip-box-1 div:first-child{animation:show 8s linear infinite}.flip-box-1-1{background-color:#FF7E40}.flip-box-1-2{background-color:#C166FF}.flip-box-1-3{background-color:#737373}.flip-box-1-4{background-color:#4ec7f3}.flip-box-1-5{background-color:#42c58a}.flip-box-1-6{background-color:#F1617D}@keyframes show{0%{margin-top:-300px}5%{margin-top:-250px}16.666%{margin-top:-250px}21.666%{margin-top:-200px}33.332%{margin-top:-200px}38.332%{margin-top:-150px}49.998%{margin-top:-150px}54.998%{margin-top:-100px}66.664%{margin-top:-100px}71.664%{margin-top:-50px}83.33%{margin-top:-50px}88.33%{margin-top:0px}99.996%{margin-top:0px}100%{margin-top:300px}}</style>';
    $html .= '<div id="container-box-1">';
    $html .= '<div class="container-box-1-1">坚持每天来逛逛，会让你</div>';
    $html .= '<div id="flip-box-1">';
    $html .= '<div><div class="flip-box-1-1">生活也美好了！</div></div>';
    $html .= '<div><div class="flip-box-1-2">心情也舒畅了！</div></div>';
    $html .= '<div><div class="flip-box-1-3">走路也有劲了！</div></div>';
    $html .= '<div><div class="flip-box-1-4">腿也不痛了！</div></div>';
    $html .= '<div><div class="flip-box-1-5">腰也不酸了！</div></div>';
    $html .= '<div><div class="flip-box-1-6">工作也轻松了！</div></div>';
    $html .= '</div>';
    $html .= '<div class="container-box-1-2">你好我也好，不要忘记哦!</div>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '<div class="clear"></div>';
    $html .= '</aside>';
    $html .= '</div>';
    $html .= '</section>';
    $html .= '</div>';

    // 在小工具内容之前调用Panda_CFSwidget的echo_before函数
    Panda_CFSwidget::echo_before($instance, '');

    // 输出小工具内容
    echo $html;

    // 在小工具内容之后调用Panda_CFSwidget的echo_after函数
    Panda_CFSwidget::echo_after($instance);
}
?>