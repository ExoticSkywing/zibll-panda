<?php
// 使用Panda_CFSwidget类创建一个名为'widget_ui_authent_home_user_listsents'的小工具
Panda_CFSwidget::create('widget_ui_authent_home_user_listsents', array(
    'title'       => 'Panda 首页用户列表',  // 小工具的标题
    'zib_title'   => true,  // 是否显示模块标题菜单
    'description' => '首页显示网站用户列表，多种排序方式。',  // 小工具的描述
    'fields'      => array(  // 配置小工具的字段
        array(
            'title'       => '第一格名',  // 字段标题
            'id'          => 'title_1',  // 字段ID，用于在前端引用
            'type'        => 'text',  // 字段类型，文本框
            'default'     => '新朋友',  // 字段的默认值
            'description' => '请输入第一个标签的名称'  // 字段描述，说明用途
        ),
        array(
            'title'       => '第二格名',  // 字段标题
            'id'          => 'title_2',  // 字段ID，用于在前端引用
            'type'        => 'text',  // 字段类型，文本框
            'default'     => '尊贵VIP',  // 字段的默认值
            'description' => '请输入第二个标签的名称'  // 字段描述，说明用途
        ),
        array(
            'title'       => '每格显示数量',  // 字段标题
            'id'          => 'number',  // 字段ID，用于在前端引用
            'type'        => 'number',  // 字段类型，数字
            'default'     => 13,  // 字段的默认值
            'description' => '设置每个标签显示的用户数量'  // 字段描述，说明用途
        ),
    )
));

// 定义显示小工具的函数
function widget_ui_authent_home_user_listsents($args, $instance)
{
    // 可用于是否显示判断
    $show_class = Panda_CFSwidget::show_class($instance);//值为1或者0

    // 获取小工具字段值
    $title_1 = $instance['title_1'];
    $title_2 = $instance['title_2'];
    $number = $instance['number'];
    
    // 构建HTML输出
    $html = '<div class="theme-box">';
    
    // 添加CSS样式
    $html .= '<style>
    .hot-top { width: 100%; background: var(--main-bg-color); margin-bottom: 25px; padding: 22px 0; position: relative; height: 145px; overflow: hidden; border-radius: 10px; box-shadow: 0 0 10px var(--main-shadow); }
    .hot-top .note { position: absolute; top: 10px; right: -50px; z-index: 1; width: 140px; height: 20px; background: #2997f7; color: #fff; line-height: 20px; transform: rotate(45deg); text-align: center; font-size: 12px; }
    .hot-top .left { float: left; height: 100%; margin-left: 10px; }
    .hot-top .left span { display: block; width: 100px; height: 45px; line-height: 45px; background: #f6f6f6; text-align: center; font-size: 15px; color: #989898; margin-bottom: 13px; cursor: pointer; border-radius: 10px; }
    .hot-top .left span:last-child { margin-bottom: 0; }
    .hot-top .left .hover { background: #2997f7; color: #FFF; position: relative; }
    .hot-top .left .hover:after { content: ""; width: 0; height: 0; border-top: 7px solid transparent; border-bottom: 7px solid transparent; border-left: 10px solid #2997f7; position: absolute; top: 15.5px; right: -10px; z-index: 1; }
    .hot-top .right { float: left; width: calc(100% - 125px); margin-left: 15px; height: 100%; }
    .hot-top .right-main { height: 90%; white-space: nowrap; overflow-y: hidden; overflow-x: auto; margin-bottom: 40px; }
    .hot-top .right-main:last-child { margin-bottom: 0px; }
    .hot-top .right-overflow { transition: 0.4s all; transform: translateY(0); }
    .hot-top .right .top-ul { height: 138px; }
    .hot-top .right .top-ul li { width: 78px; margin: 0; display: inline-block; }
    .hot-top .right .top-ul li a { display: block; }
    .hot-top .right .top-ul li a .list-img { width: 100%; height: 78px; line-height: 78px; text-align: center; border-radius: 10px; }
    .hot-top .right .top-ul li a .list-img img { width: 90%; height: 90%; }
    .hot-top .right .top-ul li a .list-img img:hover { opacity: 0.8; }
    .hot-top .right .top-ul li a h3 { margin-top: 7px; font-size: 13px; line-height: 25px; height: 25px; overflow: hidden; text-align: center; }
    @media (max-width: 425px) {
        .hot-top { padding: 22px 0; height: 148px; }
        .hot-top .left span { width: 70px; margin-left: 10px; }
        .hot-top .right { width: calc(100% - 95px); margin-left: 15px; }
        .hot-top .right-main { margin-bottom: 30px; }
        .hot-top .right .top-ul { height: 145px; }
        .hot-top .left { margin-left: 0; }
    }
    @media (min-width: 768px) {
        .hot-top .right { width: calc(100% - 125px); margin-left: 15px; }
        .hot-top .right .top-ul li { margin: auto 8px; }
    }
    </style>';
    
    // 用户列表HTML结构
    $html .= '<div class="hot-top layui-clear">
        <span class="note">榜上有名</span>
        <div class="left">
            <span class="hover" id="lively_online" onmouseenter="lively_online()">' . esc_html($title_1) . '</span>
            <span class="" id="contribution" onmouseenter="contribution()">' . esc_html($title_2) . '</span>
        </div>
        <div class="right">
            <div class="right-overflow" id="yhturns" style="transform: translateY(0px);">
                <div class="right-main">
                    <ul class="layui-clear top-ul">';
    
    // 获取最新用户
    global $wpdb;
    $lzj1 = $wpdb->get_results("SELECT id, display_name FROM $wpdb->users ORDER BY id DESC LIMIT " . intval($number));
    $user_ids = array_column($lzj1, 'id');
    
    if (!empty($user_ids)) {
        $user_query = new WP_User_Query(array(
            'include' => $user_ids,
            'orderby' => 'id',
            'order'   => 'DESC'
        ));
        $users = $user_query->get_results();
        
        if (!empty($users)) {
            foreach ($users as $user) {
                $avatar_img = zib_get_data_avatar($user->ID);
                $user_home_url = zib_get_user_home_url($user->ID);
                $html .= '<li>
                    <a href="' . esc_url($user_home_url) . '">
                        <div class="list-img">
                            <span class="avatar-img avatar-lg">' . $avatar_img . '</span>
                        </div>
                        <h3>' . esc_html($user->display_name) . '</h3>
                    </a>
                </li>';
            }
        } else {
            $html .= '<li>没有用户</li>';
        }
    } else {
        $html .= '<li>没有用户</li>';
    }
    
    $html .= '</ul>
                </div>
                <div class="right-main">
                    <ul class="layui-clear top-ul">';
    
    // 获取VIP用户
    $lzj2 = $wpdb->get_results("SELECT user_id FROM $wpdb->usermeta where meta_key='vip_level' and (meta_value='1' or meta_value='2') order by user_id desc limit " . intval($number));
    $string2 = '';
    foreach ($lzj2 as $result) {
        $string2 .= $result->user_id . ',';
    }
    
    if (!empty($string2)) {
        $user_query = new WP_User_Query(array('include' => rtrim($string2, ',')));
        if (!empty($user_query->results)) {
            foreach ($user_query->results as $user) {
                $avatar_img = zib_get_data_avatar($user->ID);
                $vip_icon = zib_get_avatar_badge($user->ID);
                $user_home_url = zib_get_user_home_url($user->ID);
                $html .= '<li>
                    <a href="' . esc_url($user_home_url) . '">
                        <div class="list-img">
                            <span class="avatar-img avatar-lg">' . $avatar_img . $vip_icon . '</span>
                        </div>
                        <h3>' . esc_html($user->display_name) . '</h3>
                    </a>
                </li>';
            }
        } else {
            $html .= '<li>没有用户</li>';
        }
    } else {
        $html .= '<li>没有用户</li>';
    }
    
    $html .= '</ul>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function lively_online() {
            document.getElementById("lively_online").className = "hover";
            document.getElementById("contribution").className = "";
            document.getElementById("yhturns").style = "transform: translateY(0px);";
        }
        function contribution() {
            document.getElementById("lively_online").className = "";
            document.getElementById("contribution").className = "hover";
            document.getElementById("yhturns").style = "transform: translateY(-180px);";
        }
    </script>';
    
    $html .= '</div>';

    // 在小工具内容之前调用Panda_CFSwidget的echo_before函数
    Panda_CFSwidget::echo_before($instance, $title);

    // 输出小工具内容
    echo $html;

    // 在小工具内容之后调用Panda_CFSwidget的echo_after函数
    Panda_CFSwidget::echo_after($instance);
}
?>