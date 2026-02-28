<?php
// 定义小工具的类 EfanWebsitestat
class EfanWebsitestat extends WP_Widget{
 
function __construct(){
// 定义小工具的构造函数
$widget_ops = array('classname' => 'widget_Websitestat', 'description' => '显示网站的统计信息，建议侧边栏');
parent::__construct(false, 'Panda tj2-侧边栏统计（多图型）', $widget_ops);
}
 
function form($instance){
// 表单函数,控制后台显示
// $instance 为之前保存过的数据
// 如果之前没有数据的话,设置默认量
$instance = wp_parse_args(
(array)$instance,
array(
'title' => '网站信息统计',
'establish_time' => '2021-01-01'
)
);
 
$title = htmlspecialchars($instance['title']);
$establish_time = htmlspecialchars($instance['establish_time']);
 
// 表格布局输出表单
$output = '<table>';
$output .= '<tr><td>标题</td><td>';
$output .= '<input id="'.$this->get_field_id('title') .'" name="'.$this->get_field_name('title').'" type="text" value="'.$instance['title'].'" />';
$output .= '</td></tr><tr><td>建站时间：</td><td>';
$output .= '<input id="'.$this->get_field_id('establish_time') .'" name="'.$this->get_field_name('establish_time').'" type="text" value="'.$instance['establish_time'].'" />';
$output .= '</td></tr></table>';
echo $output;
}
 
function update($new_instance, $old_instance){
// 更新数据的函数
$instance = $old_instance;
// 数据处理
$instance['title'] = strip_tags(stripslashes($new_instance['title']));
$instance['establish_time'] = strip_tags(stripslashes($new_instance['establish_time']));
return $instance;
}
 
function widget($args, $instance){
extract($args); //展开数组
echo '<div class="zib-widget">';
$title = apply_filters('widget_title',empty($instance['title']) ? ' ' : $instance['title']);
$establish_time = empty($instance['establish_time']) ? '2021-01-01' : $instance['establish_time'];
echo $before_title . $title . $after_title;
echo '<div class="widgest-boys"><ul>';
$this->efan_get_websitestat($establish_time);
echo '</ul></div></div>';
}
 
function efan_get_websitestat($establish_time){
// 相关数据的获取
global $wpdb;
$count_posts = wp_count_posts();
$published_posts = $count_posts->publish;
$comments_count = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->comments");
$time = floor((time()-strtotime($establish_time))/86400);
$count_tags = wp_count_terms('post_tag');
$count_pages = wp_count_posts('page');
$link = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->links WHERE link_visible = 'Y'");
$users = $wpdb->get_var("SELECT COUNT(ID) FROM $wpdb->users");
$last = $wpdb->get_results("SELECT MAX(post_modified) AS MAX_m FROM $wpdb->posts WHERE (post_type = 'post' OR post_type = 'page') AND (post_status = 'publish' OR post_status = 'private')");
$last = date('Y-m-d', strtotime($last[0]->MAX_m));
$total_views = $wpdb->get_var("SELECT SUM(meta_value+0) FROM $wpdb->postmeta WHERE meta_key = 'views'");
// 显示数据
$output = '<div class="widgest-bg widgest-bg1"><div class="widgest-main"><div class="widgest-meat"><li>文章总数：';
$output .= $published_posts;
$output .= ' 篇</li></div></div></div>';
$output .= '<div class="widgest-bg widgest-bg2"><div class="widgest-main"><div class="widgest-meat"><li>评论数目：';
$output .= $comments_count;
$output .= ' 条</li></div></div></div>';
$output .= '<div class="widgest-bg widgest-bg3"><div class="widgest-main"><div class="widgest-meat"><li>标签总数：';
$output .= $count_tags;
$output .= ' 个</li></div></div></div>';
$output .= '<div class="widgest-bg widgest-bg4"><div class="widgest-main"><div class="widgest-meat"><li>浏览次数：';
$output .= $total_views;
$output .= ' 次</li></div></div></div>';
$output .= '<div class="widgest-bg widgest-bg5"><div class="widgest-main"><div class="widgest-meat"><li>友链总数：';
$output .= $link;
$output .= ' 个</li></div></div></div>';
$output .= '<div class="widgest-bg widgest-bg6"><div class="widgest-main"><div class="widgest-meat"><li>用户总数：';
$output .= $users;
$output .= ' 个</li></div></div></div>';
$output .= '<div class="widgest-bg widgest-bg7"><div class="widgest-main"><div class="widgest-meat"><li>运行天数：';
$output .= $time;
$output .= ' 天</li></div></div></div>';
$output .= '<div class="widgest-bg widgest-bg8"><div class="widgest-main"><div class="widgest-meat"><li>建站时间：';
$output .= $establish_time;
$output .= '</li></div></div></div>';
$output .= '<div class="widgest-bg widgest-bg9"><div class="widgest-main"><div class="widgest-meat"><li>最后更新：';
$output .= $last;
$output .= '</li></div></div></div>';
// 页面生成耗时+数据库查询
$output .= '<div class="widgest-bg widgest-bg10"><div class="widgest-main"><div class="widgest-meat"><li>数据查询：';
$output .= get_num_queries();
$output .= ' 次 </li></div></div></div>';
$output .= '<div class="widgest-bg widgest-bg11"><div class="widgest-main"><div class="widgest-meat"><li>生成耗时：';
$output .= timer_stop(0,5);
$output .= '秒</li></div></div></div>';
$output .= '<style>
.widget_Websitestat h3{font-weight:700;}.widgest-boys{overflow:hidden;}.widgest-boys .widgest-bg{margin: 4px; background-size: cover; background-repeat: no-repeat; background-position: center center; cursor: pointer; border-radius: 8px;}.widgest-boys .widgest-main{align-items: center; place-content: flex-start space-around; display: flex;}.widgest-boys .widgest-meat{display: block; margin-block-start: 1em; margin-block-end: 1em; margin-inline-start: 0px; margin-inline-end: 0px; color: rgb(255, 255, 255); font-weight: 700 !important; line-height: 1.5 !important;}.widgest-bg:not(article){transition: all 0.3s;}.widgest-bg:not(article):hover{transform: translateX(-10px);}
.widgest-bg1{background-image: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)),url('.panda_pz('static_panda').'/assets/img/widgets/tj4/1.jpg);}
.widgest-bg2{background-image: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)),url('.panda_pz('static_panda').'/assets/img/widgets/tj4/2.jpg);}
.widgest-bg3{background-image: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)),url('.panda_pz('static_panda').'/assets/img/widgets/tj4/3.jpg);}
.widgest-bg4{background-image: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)),url('.panda_pz('static_panda').'/assets/img/widgets/tj4/4.jpg);}
.widgest-bg5{background-image: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)),url('.panda_pz('static_panda').'/assets/img/widgets/tj4/5.jpg);}
.widgest-bg6{background-image: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)),url('.panda_pz('static_panda').'/assets/img/widgets/tj4/6.jpg);}
.widgest-bg7{background-image: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)),url('.panda_pz('static_panda').'/assets/img/widgets/tj4/7.jpg);}
.widgest-bg8{background-image: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)),url('.panda_pz('static_panda').'/assets/img/widgets/tj4/8.jpg);}
.widgest-bg9{background-image: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)),url('.panda_pz('static_panda').'/assets/img/widgets/tj4/9.jpg);}
.widgest-bg10{background-image: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)),url('.panda_pz('static_panda').'/assets/img/widgets/tj4/10.jpg);}
.widgest-bg11{background-image: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)),url('.panda_pz('static_panda').'/assets/img/widgets/tj4/11.jpg);}
</style>';
 
echo $output;
}
}
 
function EfanWebsitestat(){
// 注册小工具
register_widget('EfanWebsitestat');
}
 
add_action('widgets_init','EfanWebsitestat');
 
?>