<?php
// 使用Panda_CFSwidget类创建一个名为'widget_ui_time_progress'的小工具
Panda_CFSwidget::create('widget_ui_time_progress', array(
    'title'       => 'time-时间胶囊',  // 小工具的标题
    'zib_title'   => true,  // 是否显示模块标题菜单
    'zib_affix'   => true,  // 是否显示侧栏随动菜单
    'description' => '显示时间胶囊，建议侧边栏显示。',  // 小工具的描述
));

// 定义显示小工具的函数
function widget_ui_time_progress($args, $instance)
{
    // 可用于是否显示判断
    $show_class = Panda_CFSwidget::show_class($instance);//值为1或者0
    
    // 加载样式和脚本
    $static_panda_url = panda_pz('static_panda');
    wp_enqueue_style('panda-time-progress-style', $static_panda_url . '/assets/css/widgets/time-widgets.css', array(), '1.0.0');
    wp_enqueue_script('panda-time-progress-script', $static_panda_url . '/assets/js/widgets/time-widgets.js', array('jquery'), '1.0.0', true);

    
    $html = '<div class="panda-time-progress blue">';
    $html .= '<div class="progress-warp">';
    $html .= '<div class="progress-progress" id="progress-bar"></div>';
    $html .= '<div class="progress-text" id="progress-text">%</div>';
    $html .= '</div>';
    $html .= '<div class="progress-note">';
    $html .= '<div class="progress-time-title" id="progress-time-title">月</div>';
    $html .= '<div class="progress-time-sub-title" id="progress-time-sub-title">天</div>';
    $html .= '</div>';
    $html .= '</div>';

    // 在小工具内容之前调用Panda_CFSwidget的echo_before函数
    Panda_CFSwidget::echo_before($instance, '');

    // 输出小工具内容
    echo $html;

    // 在小工具内容之后调用Panda_CFSwidget的echo_after函数
    Panda_CFSwidget::echo_after($instance);
}
?>