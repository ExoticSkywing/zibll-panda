<?php
// 使用Panda_CFSwidget类创建一个名为'widget_ui_tj3'的小工具
Panda_CFSwidget::create('widget_ui_tj3', array(
    'title'       => 'tj3-统计(炫彩条）',  // 小工具的标题
    'zib_title'   => true,  // 是否显示模块标题菜单
    'description' => '显示统计，建议底部全宽度显示。',  // 小工具的描述
    'fields'      => array(  // 配置小工具的字段
        array(
            'title'       => '建站时间',  // 字段标题
            'id'          => 'time',  // 字段ID，用于在前端引用
            'type'        => 'text',  // 字段类型，文本框
            'default'     => '2024-5-16 00:00:00',  // 字段的默认值
            'description' => '请输入建站时间，格式：YYYY-MM-DD HH:MM:SS'  // 字段描述，说明用途
        )
    )
));

// 定义显示小工具的函数
function widget_ui_tj3($args, $instance)
{
    // 可用于是否显示判断
    $show_class = Panda_CFSwidget::show_class($instance);//值为1或者0

    // 获取小工具字段值
    $time = $instance['time'];
    
    // 获取统计数据
    global $wpdb;
    $users = $wpdb->get_var("SELECT COUNT(ID) FROM $wpdb->users");
    $count_posts = wp_count_posts();
    $published_posts = $count_posts->publish;
    
    $count = 0;
    $views = $wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE meta_key='views'");
    foreach($views as $key=>$value){
        $meta_value = $value->meta_value;
        if($meta_value != ' '){
            $count += (int)$meta_value;
        }
    }
    
    $today = getdate();
    $query = new WP_Query('year=' . $today["year"] . '&monthnum=' . $today["mon"] . '&day=' . $today["mday"]);
    $postsNumber = $query->found_posts;
    $wdyx_time = floor((time()-strtotime($time))/86400);
    
    // 构建HTML输出
    $html = '<div id="caired" style="margin:0 0 20px 0;">';
    $html .= '<div class="cai">';
    $html .= '<ul>';
    $html .= '<li><span>' . $users . '</span><p>会员总数</p></li>';
    $html .= '<li><span>' . $published_posts . '</span><p>文章总数</p></li>';
    $html .= '<li><span>' . $count . '</span><p>浏览总数</p></li>';
    $html .= '<li><span>' . $postsNumber . '</span><p>今日发布</p></li>';
    $html .= '<li><span>' . $wdyx_time . '天</span><p>稳定运行</p></li>';
    $html .= '</ul>';
    $html .= '</div>';
    $html .= '</div>';
    
    // 添加CSS样式
    $html .= '<style>
        #caired{
            height: 100%;
            width: 100%;
            margin: 0;
            padding: 0;
            font-family: "montserrat";
            background-image: -webkit-linear-gradient(45deg,#2c3e50,#27ae60,#2980b9,#e74c3c,#8e44ad);
            background-size: 400%;
            animation: bganimation 15s infinite;
            border-radius: 10px;
        }
        @keyframes bganimation {
            0%{ background-position: 0% 50%; }
            50%{ background-position: 100% 50%; }
            100%{ background-position: 0% 50%; }
        }
        #caired .cai ul{ display: flex; }
        #caired .cai ul li{ width: 20%; color: #fff; text-align: center; }
        #caired .cai ul li span{ font-size: 24px; font-family: Arial; }
        #caired .cai{ font-weight:700; padding:20px 0 20px 0; }
        @media screen and (max-width: 768px){
            #caired .cai ul li span{ font-size: 20px; font-family: Arial; }
        }
    </style>';

    // 在小工具内容之前调用Panda_CFSwidget的echo_before函数
    Panda_CFSwidget::echo_before($instance, '');

    // 输出小工具内容
    echo $html;

    // 在小工具内容之后调用Panda_CFSwidget的echo_after函数
    Panda_CFSwidget::echo_after($instance);
}
?>