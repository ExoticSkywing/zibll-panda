<?php

function money_ranklist_zy() {?>
<style>
@media screen and (max-width: 800px) {  
#uid {  
    display: none;  
}  
#name {  
    display: none;  
}  
} 
#leiji {
    text-align: end;
}
#yaoqing {
    text-align: center;
}
.sidebar .zib-widget.widget_money_ranklist_widget .money-box div ul.else-list li.else-item span#uid {
    display: none;
}
.sidebar .zib-widget.widget_money_ranklist_widget .money-box div ul.else-list li.else-item span#name {
    display: none;
}
.sidebar .title {
	font-size:25px;
	color:var(--theme-color);
	line-height:16px;
	letter-spacing:1px;
	text-align:center;
	margin:auto;
	padding:0px 0 24px 12px;
	background:url(<?php echo panda_pz('static_panda');?>/assets/img/65b1e15fb2df7.png) 100% 0/433px 126px no-repeat;
}
a.top-icon.money-rank-bottom2 {
	display:block;
	width:165px;
	height:53px;
	line-height:45px;
	background:url(<?php echo panda_pz('static_panda');?>/assets/img/65b1e144c9e06.png) no-repeat center/100%;
	font-size:18px;
	color:#fff;
	font-weight:600;
	margin:auto;
	z-index:999;
}
.money-box {
	--green-1:#cff0fb;
	--green-2:#cbf4e4;
	background-image:linear-gradient(150deg,var(--green-1) 20%,var(--green-2) 40%);
	padding:0 12px 12px;
	border-radius:var(--main-radius);
}
.else-list {
    width: 100%;
}
.else-item {
    padding-bottom: 12px;
    transition: all 1s;
    justify-content: center;
    align-items: center;
    display: flex;
}
.gift-name {
    width: 30%;
    font-size: 14px;
    line-height: 30px;
    text-align: justify;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    display: inline-block;
}
.img-box {
    width: 30px;
    height: 30px;
    opacity: 1;
    display: inline-block;
    background-color: #eee;
    border-radius: 30px;
    margin-right: 5px;
}
.elseListbox {
	overflow:hidden;
	overflow-y:scroll;
	position:relative;
	height:300px;
	background:var(--main-bg-color);
	padding:12px;
	border-radius:var(--main-radius);
}
.elseListbox::-webkit-scrollbar {
    width: 0px;
}
.zib-widget.widget_money_ranklist_widget {
    padding: 0;
}
</style>
<script>
$(function(){$.fn.myScroll=function(speed){var $_this=$(this);var myScrollObj={isAnimating:false,pageNum:0,stop:false,getLis:function(){return $_this.children("li")},getLiSize:function(){return this.getLis().length},goToPart:function(n){var _t=this,$lis=_t.getLis(),$firstLi=$lis.eq(0),height=$firstLi.height(),newMarginTop=n*height,$showLi=$lis.eq(n),$isOnLi=$_this.find(".on");if(_t.isAnimating||_t.stop||n>=_t.getLiSize()||n<0){return}_t.isAnimating=true;$showLi.trigger("beginLoad");$isOnLi.trigger("beginLeave");$firstLi.animate({"marginTop":-newMarginTop+"px"},speed,"swing",function(){$isOnLi.trigger("LeaveEnd").removeClass("on");$showLi.addClass("on").trigger("LoadEnd");_t.isAnimating=false;_t.pageNum=n})},preventScroll:function(){this.stop=true},resetScroll:function(){this.stop=false},getNowIndex:function(){return $_this.find(".on").index()},next:function(){var index=this.getNowIndex();this.goToPart(index+1)},prev:function(){var index=this.getNowIndex();this.goToPart(index-1)}};$_this.bind("mousewheel",function(evt,delta){var dir=delta>0?-1:1,$nowLi=$_this.children(".on"),index=$nowLi.index()+dir;myScrollObj.goToPart(index)});$(window).resize(function(){var index=$(".on").index(),$firstLi=myScrollObj.getLis().eq(0),height=$(window).height();$firstLi.css("marginTop",-height*index+"px")});return myScrollObj}});(function($){$.fn.myScroll=function(options){var defaults={speed:40,rowHeight:24};var opts=$.extend({},defaults,options),intId=[];function marquee(obj,step){obj.find("ul").animate({marginTop:'-=1'},0,function(){var s=Math.abs(parseInt($(this).css("margin-top")));if(s>=step){$(this).find("li").slice(0,1).appendTo($(this));$(this).css("margin-top",0)}})}this.each(function(i){var sh=opts["rowHeight"],speed=opts["speed"],_this=$(this);intId[i]=setInterval(function(){if(_this.find("ul").height()<=_this.height()){clearInterval(intId[i])}else{marquee(_this,sh)}},speed);_this.hover(function(){clearInterval(intId[i])},function(){intId[i]=setInterval(function(){if(_this.find("ul").height()<=_this.height()){clearInterval(intId[i])}else{marquee(_this,sh)}},speed)})})}})(jQuery);$('.elseListbox').myScroll({speed:50,rowHeight:47})
</script>
<?php }  
add_action('wp_footer', 'money_ranklist_zy');

//邀请赚佣金函数代码
function money_ranklist($number) {  //$number接收下面小工具传递的参数
    // 随机获取用户  
$random_users = get_users(array(  
    'number' => $number,  // 获取的用户数量  
    'orderby' => 'rand',  // 随机排序用户  
));  
  
// 初始化一个空数组来存储用户ID  
$user_ids = array();  
// 遍历随机获取的用户列表  
foreach ($random_users as $random_user) {  
    // 将每个用户的ID添加到user_ids数组中  
    $user_ids[] = $random_user->ID;  
}  
  
// 将用户ID数组转换为逗号分隔的字符串  
$user_id = implode(',', $user_ids);  
// 初始化一个空数组来存储每个用户的总返利金额  
$total_rebate_prices = array();  
// 再次遍历随机获取的用户列表  
foreach ($random_users as $random_user) {  
    // 获取每个用户的邀请数量  
    $invite_count = get_user_meta($random_user->ID, 'invite_count', true);  
    // 获取每个用户的总返利金额  
    $total_rebate_price = zibpay_get_user_rebate_data($random_user->ID, 'all')['sum'];  
    // 将每个用户的总返利金额存储到total_rebate_prices数组中，以用户ID为键  
    $total_rebate_prices[$random_user->ID] = $total_rebate_price;  
}  
  
// 将存储用户ID的逗号分隔字符串转换回数组  
$user_list = explode(',', $user_id);
// 创建一个空字符串来存储结果  
$output = '';  
// 遍历用户ID列表  
foreach ($user_list as $user_id) {  
    // 定义查询参数  
    $users_args = array(  
        'order'       => 'DESC',  // 按照降序排序  
        'orderby'     => 'user_registered',  // 按照用户注册时间排序  
        'count_total' => true,  // 计算总用户数  
        'meta_query'  => array(  // 自定义查询条件  
            array(  
                'key'     => 'referrer_id',  // 查询的元数据字段名为referrer_id  
                'value'   => $user_id,  // 该字段的值等于当前遍历的用户ID  
                'compare' => '=',  // 等于  
            ),  
        ),  
    );  
    // 创建并执行用户查询  
    $query = new WP_User_Query($users_args);  
    // 获取查询到的总用户数  
    $total_count = $query->get_total();  
    // 获取用户的显示名称和链接  
    $display_name = zib_get_user_name_link($user_id);  
    // 获取用户的头像链接  
    $avatar = get_avatar($user_id);  
    // 获取用户的VIP图标链接（如果有）  
    $vip_icon = zib_get_avatar_badge($user_id);  
    // 如果已经计算过返利价格，则从数组中获取，否则默认为0  
    $total_rebate_price = isset($total_rebate_prices[$user_id]) ? $total_rebate_prices[$user_id] : 0;  
    // 将HTML结果添加到输出字符串中  
    $html .= '<li class="else-item">'; // 开始一个新的列表项  
    $html .= '<span id="uid" class="gift-name" style="font-weight: 600;"><span><svg class="icon" aria-hidden="true"><use xlink:href="#icon-user-color"></use></svg>ID: '.$user_id.' </span></span>'; // 显示用户ID  
    $html .= '<span id="avatar" class="gift-name" style="font-weight: 600;"><span class="img-box avatar-img comt-avatar">'.$avatar.$vip_icon.'</span><span id="name">'.$display_name.'</span></span>'; // 显示用户头像、VIP图标和用户名  
    $html .= '<span id="yaoqing" class="gift-name">已邀请 '.$total_count.' <svg class="icon" aria-hidden="true" data-viewbox="50 0 924 924" viewBox="50 0 924 924"><use xlink:href="#icon-user"></use></svg>位用户</span>'; // 显示已邀请的用户数量和图标  
    $html .= '<span id="leiji" class="gift-name">累计'.$total_rebate_price.'<svg class="em14" aria-hidden="true"><use xlink:href="#icon-money-color-2"></use></svg></span>'; // 显示累计返利价格和图标  
    $html .= '</li>'; // 结束列表项的HTML代码  
} // 结束foreach循环
    return $html; // 返回结果字符串  
}

// 定义小工具类  
class Money_Ranklist_Widget extends WP_Widget {  
  
    // 构造函数  
    public function __construct() {    
    parent::__construct(    
        'money_ranklist_widget', // 小工具的唯一ID    
        __('Panda 邀请佣金滚动', 'textdomain'), // 小工具的名称    
        array(  
            'description' => __('随机显示多名用户的邀请信息以及佣金信息', 'textdomain'),  
        ) // 小工具的描述    
    );    
}
    // 输出小工具内容  
    public function widget($args, $instance) {  
    // 开始小工具输出前的一些准备工作  
    echo $args['before_widget'];  
  
    // 调用你的money_ranklist函数并输出内容  
    echo '<div class="money-box">';  
    echo '<div class="title"><a class="top-icon money-rank-bottom2">'.$instance['title'].'</a></div>';  
    echo '<div class="elseListbox">';  
    echo '<ul class="else-list">';  
    // 在这里调用 money_ranklist() 函数，并将 $instance['number'] 作为参数传递给它  
    echo money_ranklist($instance['number']);    
    echo '</ul>';  
    echo '</div>';  
    echo '</div>';  
  
    // 结束小工具输出  
    echo $args['after_widget'];  
}
    // 输出小工具设置表单  
    public function form($instance) {  
        // 输出设置表单，例如一个标题输入框  
        $title = !empty($instance['title']) ? $instance['title'] : __('邀请赚佣金', 'textdomain');  
        $number = !empty($instance['number']) ? $instance['number'] : __('20', 'textdomain');
        ?>  
        <p>  
            <label for="<?php echo $this->get_field_id('title'); ?>">标题名称</label>  
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">  
        </p>  
        <p>  
            <label for="<?php echo $this->get_field_id('number'); ?>">显示用户数量</label>  
            <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo esc_attr($number); ?>">  
        </p>  
        <?php  
    }  
    // 保存小工具设置  
    public function update($new_instance, $old_instance) {  
    // 处理表单提交，更新标题和显示的用户数量  
    $instance = $old_instance;  
    $instance['title'] = !empty($new_instance['title']) ? strip_tags($new_instance['title']) : '';  
    $instance['number'] = !empty($new_instance['number']) ? intval($new_instance['number']) : ''; // 将用户输入的数字转换为整数并应用到实例中  
    return $instance;  
}
}  

// 注册小工具  
function register_money_ranklist_widget() {  
    register_widget('Money_Ranklist_Widget');  
}  
add_action('widgets_init', 'register_money_ranklist_widget');