<?php
// 使用Panda_CFSwidget类创建一个名为'widget_ui_block'的小工具
Panda_CFSwidget::create('widget_ui_block', array(
    'title'       => 'block-用户封禁情况',  // 小工具的标题
    'zib_title'   => true,  // 是否显示模块标题菜单
    'zib_affix'   => true,  // 是否显示侧栏随动菜单
    'zib_show'    => true,  // 是否展示小工具显示规则菜单
    'description' => '显示网站用户被封禁情况，建议侧边栏显示。',  // 小工具的描述
    'fields'      => array(  // 配置小工具的字段
        array(
            'title'       => '标题',  // 字段标题
            'id'          => 'title',  // 字段ID
            'type'        => 'text',  // 字段类型
            'default'     => '',  // 默认值
            'description' => '小工具的主标题'  // 字段描述
        ),
        array(
            'title'       => '副标题',  
            'id'          => 'mini_title',  
            'type'        => 'text',  
            'default'     => '',  
            'description' => '小工具的副标题'  
        ),
        array(
            'title'       => '更多按钮文案',  
            'id'          => 'more_but',  
            'type'        => 'text',  
            'default'     => '<i class="fa fa-angle-right fa-fw"></i>更多',  
            'description' => '显示在更多按钮上的文字'  
        ),
        array(
            'title'       => '更多按钮链接',  
            'id'          => 'more_but_url',  
            'type'        => 'text',  
            'default'     => '',  
            'description' => '更多按钮跳转的链接'  
        ),
        array(
            'title'       => '隐藏背景盒子',  
            'id'          => 'hide_box',  
            'type'        => 'checkbox',  
            'default'     => false,  
            'description' => '是否隐藏背景盒子'  
        ),
        array(
            'title'       => '显示数量',  
            'id'          => 'number',  
            'type'        => 'number',  
            'default'     => 10,  
            'description' => '显示的用户数量'  
        ),
        array(
            'title'       => '排序字段',  
            'id'          => 'orderby',  
            'type'        => 'select',  
            'options'     => array(
                'banned' => '黑名单'
            ),
            'default'     => 'banned',  
            'description' => '选择排序的字段'  
        ),
        array(
            'title'       => '排序顺序',  
            'id'          => 'order',  
            'type'        => 'select',  
            'options'     => array(
                'ASC' => '升序',
                'DESC' => '降序'
            ),
            'default'     => 'DESC',  
            'description' => '选择排序顺序'  
        )
    )
));

// 定义显示小工具的函数
function widget_ui_block($args, $instance) {
    // 可用于是否显示判断
    $show_class = Panda_CFSwidget::show_class($instance);

    // 在小工具内容之前调用Panda_CFSwidget的echo_before函数
    Panda_CFSwidget::echo_before($instance, '');

    // 输出CSS样式
    echo "<style>
        .font-hidden{overflow: hidden;white-space: nowrap;text-overflow: ellipsis;}
        .panda_tc_mb-5{text-align:center;margin-bottom: -5px;}
        .panda-widget-title {position: relative;padding: 0 0 14px 20px !important;margin-top: 5px;border-bottom: 1px solid #f5f6f7;font-size: 16px;font-weight: 600;color: #18191a;width: 100%;}
        .panda-widget-title:after {left: 12px !important;}
        .panda-widget-title:before, .panda-widget-title:after {position: absolute;transform: skewX(-15deg);content: '';width: 3px;height: 16px;background: var(--theme-color);top: 0;left: 4px;bottom: 10%;transition: .4s;}
    </style>";

    // 获取参数
    $shu = $instance['number'];
    $orderby = $instance['orderby'];
    $order = $instance['order'];
    
    global $wpdb;
    $used = $wpdb->get_results("SELECT meta_value,user_id,meta_key FROM {$wpdb->usermeta} WHERE meta_key='$orderby' AND meta_value !='0' ORDER BY user_id $order LIMIT $shu");
    
    // 构建HTML输出
    $html = '<div class="theme-box">';
    $html .= '<div class="user_lists' . (!$instance['hide_box'] ? ' zib-widget' : '') . '">';
    
    // 标题部分
    if ($instance['title']) {
        $xbt = $instance['mini_title'] ? '<small class="ml10">'.$instance['mini_title'].'</small>' : '';
        $html .= '<h2 class="panda-widget-title font-hidden">'.$instance['title'].''.$xbt.'</h2>';
    }
    
    // 用户列表
    foreach ($used as $k) {
        $user = zib_get_user_name_link($k->user_id);
        $is_ban = zib_get_user_ban_info($k->user_id);
        $userimg = zib_get_avatar_box($k->user_id, 'avatar-img forum-avatar');
        $time = $is_ban['time'];
        $datetime = date("jS H:i", strtotime("$time"));
        
        $html .= '<div class="posts-mini border-bottom relative">';
        $html .= $userimg;
        $html .= '<div class="posts-mini-con em09 ml10 flex xx jsb"> <p class="flex jsb">';
        $html .= '<span class="flex1 flex"><name class="inflex ac relative-h"><a href="' . zib_get_user_home_url($k->user_id) . '">' . $user . '</a></name><span class="flex0 icon-spot muted-3-color" title="封禁时间：' . ($is_ban['banned_time'] ? $is_ban['banned_time'] : '永久') . '">' . $datetime. '</span></p>';
        $html .= '<div class="flex jsb muted-2-color font-hidden">'.$is_ban['reason'].'</div></div> ';
        $html .= '<div class="flex jsb xx text-right flex0 ml10"><div class="text-right em5"><span class="badge pull-right cursor" title="封禁状态">' . (2 == $is_ban['type'] ? '禁封中' : '小黑屋') . '</span></div></div></div>';
    }
    
    // 底部更多链接
    if ($used) {
        $html .= '<div class="mt10 panda_tc_mb-5"><a href="'.$instance['more_but_url'].'" class="muted-2-color c-blue">'.$instance['more_but'].'</a></div>';
    } else {
        $html .= zib_get_ajax_null('暂无'.$instance['title'].'成员', 0);
    }
    
    $html .= '</div></div>';
    
    // 输出HTML
    echo $html;

    // 在小工具内容之后调用Panda_CFSwidget的echo_after函数
    Panda_CFSwidget::echo_after($instance);
}
?>