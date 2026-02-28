<?php
// 使用Panda_CFSwidget类创建一个名为'widget_ui_new'的小工具
Panda_CFSwidget::create('widget_ui_new', array(
    'title'       => 'NEW居中标题样式美化',  // 小工具的标题
    'description' => '显示NEW居中标题样式美化，建议全宽度显示。',  // 小工具的描述
    'fields'      => array(  // 配置小工具的字段
        array(
            'title'       => '大标题',  // 字段标题
            'id'          => 'title',  // 字段ID，用于在前端引用
            'type'        => 'text',  // 字段类型，文本框
            'default'     => 'NEW',  // 字段的默认值
            'description' => '请输入大标题内容'  // 字段描述，说明用途
        ),
        array(
            'title'       => '副标题',  // 字段标题
            'id'          => 'mini_title',  // 字段ID，用于在前端引用
            'type'        => 'text',  // 字段类型，文本框
            'default'     => '学无止境，活到老，学到老',  // 字段的默认值
            'description' => '请输入副标题内容'  // 字段描述，说明用途
        )
    )
));

// 定义显示小工具的函数
function widget_ui_new($args, $instance)
{
    // 可用于是否显示判断
    $show_class = Panda_CFSwidget::show_class($instance);//值为1或者0

    // 获取小工具字段值
    $title = $instance['title'];
    $mini_title = $instance['mini_title'];
    
    // 构建小工具的HTML输出
    $html = '<div class="emoji-container">';
    $html .= '<div class="emoji-title">'.esc_html($title).'</div>';
    $html .= '<div class="emoji-separator emoji-sub emoji-sm">'.esc_html($mini_title).'</div>';
    $html .= '</div>';
    
    $html .= '<style>
        .emoji-container{display:flex;flex-direction:column;align-items:center;text-align:center}
        .emoji-separator:before,.emoji-separator:after{content:"";background:#777;flex:1;height:1px;margin:0 10px;max-width:16%}
        .emoji-separator{display:flex;align-items:center;justify-content:center;width:100%}
        .emoji-sub{color:#8c92a1!important}
        .emoji-sm{font-size:14px}
        .emoji-title{font-size:24px;font-weight:bold;color:green}
    </style>';

    // 在小工具内容之前调用Panda_CFSwidget的echo_before函数
    Panda_CFSwidget::echo_before($instance, '');

    // 输出小工具内容
    echo $html;

    // 在小工具内容之后调用Panda_CFSwidget的echo_after函数
    Panda_CFSwidget::echo_after($instance);
}
?>