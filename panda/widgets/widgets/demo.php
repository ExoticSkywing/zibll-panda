<?php
// 使用Panda_CFSwidget类创建一个名为'widget_demo'的小工具
Panda_CFSwidget::create('widget_demo', array(
    'title'       => 'demo-小工具demo',  // 小工具的标题
    'zib_title'   => true,  // 是否显示模块标题菜单
    'zib_affix'   => true,  // 是否显示侧栏随动菜单
    'zib_show'    => true,  // 是否展示小工具显示规则菜单
    'description' => '显示特定分类目录下的文章，可设置两行布局',  // 小工具的描述
    'fields'      => array(  // 配置小工具的字段
       array(
            'title'       => '内容',  // 字段标题
            'id'          => 'content',  // 字段ID，用于在前端引用
            'type'        => 'text',  // 字段类型，文本框
            'default'     => '这是一个demo小工具',  // 字段的默认值
            'description' => '这是描述'  // 字段描述，说明用途
        ),
    )
));

// 定义显示小工具的函数
function widget_demo($args, $instance)
{
    // 可用于是否显示判断
    $show_class = Panda_CFSwidget::show_class($instance);//值为1或者0

    // 获取小工具字段中'content'的值
    $content = $instance['content'];

    // 构建小工具的HTML输出，包含标题和内容
    $html = '<div class="widget widget-demo">';
    $html.= '<div class="widget-title">'. $instance['title']. '</div>';  // 显示小工具标题
    $html.= '<div class="jb-pink">'. $content. '</div>';  // 显示内容字段（带样式）
    $html.= '</div>'; 

    // 在小工具内容之前调用Panda_CFSwidget的echo_before函数
    Panda_CFSwidget::echo_before($instance, '');

    // 直接输出content字段的值
    echo '直接输出content</br>';
    echo $content;  // 输出内容字段的值
    echo '</br>content包裹在html中</br>';

    // 输出包含HTML结构的小工具内容
    echo $html;

    // 在小工具内容之后调用Panda_CFSwidget的echo_after函数
    Panda_CFSwidget::echo_after($instance);
}
?>
