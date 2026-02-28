<?php
// 使用Panda_CFSwidget类创建一个名为'widget_ui_tj1'的小工具
Panda_CFSwidget::create('widget_ui_tj1', array(
    'title'       => 'tj1-底部统计',  // 小工具的标题
    'description' => '显示统计，建议底部全宽度显示。',  // 小工具的描述
    'fields'      => array(  // 配置小工具的字段
        array(
            'title'       => '建站时间',  // 字段标题
            'id'          => 'time',  // 字段ID，用于在前端引用
            'type'        => 'text',  // 字段类型，文本框
            'default'     => '2024-5-16 00:00:00',  // 字段的默认值
            'description' => '请输入建站时间，格式：YYYY-MM-DD HH:MM:SS'  // 字段描述，说明用途
        ),
        array(
            'title'       => '表盘选择',  // 字段标题
            'id'          => 'clock',  // 字段ID，用于在前端引用
            'type'        => 'radio',  // 字段类型，单选按钮
            'options'     => array(
                '1' => '彩色表盘',
                '2' => '太空人表盘'
            ),
            'default'     => '1',  // 字段的默认值
            'description' => '选择时钟表盘样式'  // 字段描述，说明用途
        )
    )
));

// 定义显示小工具的函数
function widget_ui_tj1($args, $instance)
{
    // 可用于是否显示判断
    $show_class = Panda_CFSwidget::show_class($instance);//值为1或者0

    // 获取小工具字段值
    $time = $instance['time'];
    $clock = $instance['clock'];
    
    // 计算统计数据
    $count_posts = wp_count_posts();
    $published_posts = $count_posts->publish;
    $post_wpdb = get_posts_count_from_last_168h('post');
    $wdyx_time = floor((time()-strtotime($time))/86400);
    global $wpdb;
    $users = $wpdb->get_var("SELECT COUNT(ID) FROM $wpdb->users");
    $post_view = nd_get_all_view();
    
    // 构建HTML输出
    $html = '<script type="text/javascript">';
    $html .= 'var stat_wzzs = "' . $published_posts . '";'; // 文章总数
    $html .= 'var stat_bzfb = "' . $post_wpdb . '";'; // 本周发布
    $html .= 'var stat_yxsj = "' . $wdyx_time . '";'; // 运行时间
    $html .= 'var stat_zcyh = "' . $users . '";'; // 用户总数
    $html .= 'var stat_zfwl = "' . $post_view . '";'; // 总访问量
    $html .= '</script>';
    
    $html .= '<script src="' . esc_url(panda_pz('static_panda') . '/assets/js/widgets/tj1.js') . '"></script>';
    
    $html .= '<div class="textwidget custom-html-widget"><div id="mizhi-info-wg-mian">';
    $html .= '<div class="mizhi-info-item">';
    $html .= '<div class="mizhi-wz-item">';
    $html .= '<div class="mizhi-wz-sty mizhi-wzzs-item">';
    $html .= '<svg class="icon fa-2x" aria-hidden="true"><use xlink:href="#icon-wenzhang"></use></svg>';
    $html .= '<span class="mizhi-i-num"><script type="text/javascript">document.write(stat_wzzs);</script>篇</span>';
    $html .= '<span class="frame-bg" title="文章数目">文章数目</span>';
    $html .= '</div>';
    $html .= '<div class="mizhi-wz-sty mizhi-jrfb-item">';
    $html .= '<svg class="icon fa-2x" aria-hidden="true"><use xlink:href="#icon-benzhoudianjihou-copy"></use></svg>';
    $html .= '<span class="mizhi-i-num"><script type="text/javascript">document.write(stat_bzfb);</script>篇</span>';
    $html .= '<span class="frame-bg" title="本周发布">本周发布</span>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '<div class="mizhi-yhzs-item">';
    $html .= '<svg class="icon fa-2x" aria-hidden="true"><use xlink:href="#icon-yonghu"></use></svg>';
    $html .= '<span class="mizhi-i-num"><script type="text/javascript">document.write(stat_zcyh);</script>位</span>';
    $html .= '<span class="frame-bg" title="注册用户">注册用户</span>';
    $html .= '</div>';
    $html .= '<div class="mizhi-yxsj-item">';
    $html .= '<svg class="icon fa-2x" aria-hidden="true"><use xlink:href="#icon-daojishi"></use></svg>';
    $html .= '<span class="mizhi-i-num"><script type="text/javascript">document.write(stat_yxsj);</script>天</span>';
    $html .= '<span class="frame-bg" title="运行时间">运行时间</span>';
    $html .= '</div>';
    $html .= '<div class="mizhi-llzs-item">';
    $html .= '<svg class="icon fa-2x" aria-hidden="true"><use xlink:href="#icon-yanjing-"></use></svg>';
    $html .= '<span class="mizhi-i-num"><script type="text/javascript">document.write(stat_zfwl);</script>次</span>';
    $html .= '<span class="frame-bg" title="浏览次数">浏览次数</span>';
    $html .= '</div>';
    $html .= '<div class="mizhi-sjcs-item">';
    $html .= '<div class="mizhi-sjcj-m">';
    $html .= '<span class="mizhi-i-num">—— 今天是 ——</span>';
    $html .= '<div id="mizhi-date-text"></div>';
    $html .= '<div id="mizhi-week-text"></div>';
    $html .= '<div class="mizhi-meo-item">';
    $html .= '<img id="mizhi-meos" src="' . esc_url(panda_pz('static_panda') . '/assets/img/widgets/tj1/week-1.webp') . '" alt="emo">';
    $html .= '</div>';
    $html .= '<div class="mizhi-sjcj-content">';
    $html .= '<span id="mizhi-fatalism"></span>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';    
    $html .= '<div class="mizhi-sjcs-item2"><iframe src="' . esc_url(panda_pz('static_panda') . '/assets/others/widgets/clock/' . $clock) . '" width="290" height="290" frameborder="no"></iframe></div>'; 
    $html .= '</div>';
    $html .= '</div>';
    
    $html .= '<script>';
    $html .= '$(function () {';
    $html .= 'var myDate = new Date();';
    $html .= 'var year = myDate.getFullYear();';
    $html .= 'var mon = myDate.getMonth() + 1;';
    $html .= 'var date = myDate.getDate();';
    $html .= 'var week = myDate.getDay();';
    $html .= 'var weeks = ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六"];';
    $html .= '$("#mizhi-date-text").html(year + "年" + mon + "月" + date + "日" + weeks[week]);';
    $html .= 'if (week > 0 && week < 5) {';
    $html .= '$("#mizhi-fatalism").html("再坚持一下还有" + (5 - week) + "天就到周末啦！");';
    $html .= '} else if (week === 5) {';
    $html .= '$("#mizhi-fatalism").html("啊啊啊，明天就是周末啦！");';
    $html .= '} else {';
    $html .= '$("#mizhi-fatalism").html("今天是周末，好好放肆玩一下吧！");';
    $html .= '}';
    $html .= '$("#mizhi-meos").attr("src", "' . esc_url(panda_pz('static_panda')) . '/assets/img/widgets/tj1/week-" + week + ".webp");';
    $html .= '});';
    $html .= '$("#mizhi-info-wg-mian").parents(".zib-widget").css({padding: "0", background: "none"});';
    $html .= '</script>';
    
    $html .= '</div>';
    $html .= '<link rel="stylesheet" href="' . esc_url(panda_pz('static_panda') . '/assets/css/widgets/tj1.css') . '" type="text/css">';

    // 在小工具内容之前调用Panda_CFSwidget的echo_before函数
    Panda_CFSwidget::echo_before($instance, '');

    // 输出小工具内容
    echo $html;

    // 在小工具内容之后调用Panda_CFSwidget的echo_after函数
    Panda_CFSwidget::echo_after($instance);
}
?>