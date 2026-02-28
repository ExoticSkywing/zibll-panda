<?php
add_action('widgets_init', 'widget_register_author');

function widget_register_author()
{
    register_widget('widget_ui_home_user_author');
}

function compareAge($a, $b) 
{
    if ($a['renqi'] == $b['renqi']) {
        return 0;
    } elseif ($a['renqi'] < $b['renqi']) {
        return 1;
    } else {
        return -1;
    }
}

class widget_ui_home_user_author extends WP_Widget
{
    public function __construct()
    {
        $widget = array(
            'w_id'        => 'widget_ui_home_user_author',
            'w_name'      => __('Panda 人气作者榜'),
            'classname'   => '',
            'description' => '首页显示网站人气作者榜，多种排序方式.',
        );
        parent::__construct($widget['w_id'], $widget['w_name'], $widget);
    }

    public function widget($args, $instance)
    {
        if (!zib_widget_is_show($instance)) {
            return;
        }

        extract($args);

        $defaults = array(
            'title'        => '',
            'mini_title'   => '',
            'more_but'     => '<i class="fa fa-angle-right fa-fw"></i>更多',
            'more_but_url' => '',
            'hide_box'     => false,
            'number'       => 8,
        );

        $instance = wp_parse_args((array) $instance, $defaults);
        $mini_title = $instance['mini_title'];

        if ($mini_title) {
            $mini_title = '<small class="ml10">' . $mini_title . '</small>';
        }

        $title = $instance['title'];
        $more_but = '';

        if ($instance['more_but'] && $instance['more_but_url']) {
            $more_but = '<div class="pull-right em09 mt3"><a href="' . $instance['more_but_url'] . '" class="muted-2-color">' . $instance['more_but'] . '</a></div>';
        }

        $mini_title .= $more_but;

        if ($title) {
            $title = '<div class="box-body notop"><div class="title-theme">' . $title . $mini_title . '</div></div>';
        }

        echo '<div class="theme-box">';
        echo $title;
        ?>
        <style>
@media (max-width:768px) 
{
    .home-authors .item, .home-authors .group-item .item-images .img-item {
        width: 100%!important;
    }
    .item-author:nth-child(n+4) {
        display:none;
    }
 }

.home-authors .item-tobe-author .meta-avatars img {
    display: inline-block;
    width: 30px;
    height:30px;
    -webkit-border-radius: 100%;
    -moz-border-radius: 100%;
    border-radius: 100%;
    overflow: hidden;
    margin-left: -10px;
    border-radius: 50%;
    transform: translateX(0px);
    overflow: hidden;
    border: 3px solid var(--main-bg-color);
}

.ap-item-meta .cat:before {
    content: '#';
    /* top: 2px; */
    line-height: 19px;
    width: 19px;
    height: 19px;
    margin-right: 5px;
    color: #fe2c55;
    text-align: center;
    float: left;
    background: rgba(254, 44, 85, 0.2);
    border-radius: 50%;
    display: block;
    /* position: absolute; */
    left: 0;
}

.item-author .author-btn .looo {
    line-height: 13px;
    font-size: 13px;
    width: 100%;
    color: #333;
    background: var(--body-bg-color);
}


.item-author .item-wrap:hover .item-top .author-btn,.home-authors .item-tobe-author .item-wrap:hover .item-top .author-btn {
    display: block;
}


.item-author .author-btn {
    position: absolute;
    right: 0;
    top: 90px!important;
    display: none;
    width: 100%
}


.item-author .author-btn .user-s-follow {
   padding:10px;
    text-align: center
}

.looo .msg-icon,.looo .top{
    display:none;
}

.home-authors .part-title{
    font-size: 18px;
}
.home-authors .author-items {
    margin: 0 auto;
    display:flex;
    flex-wrap:wrap;
}
.home-authors .part-title, .part-hot-channel .part-title, .part-zt .part-title, .archive-list-see .part-title, .post-related .part-title, .hunter-recent-hot .part-title, .hunter-last-week .part-title {
    font-size: 21px;
    color: #333333;
    margin-bottom: 50px;
}
.home-authors .part-title .sub-link .icon-btn-bang, .hunter-recent-hot .part-title .sub-link .icon-btn-bang, .hunter-last-week .part-title .sub-link .icon-btn-bang {
    color: #ff6000;
}

.home-authors .item, .home-authors .group-item .item-images .img-item {
    margin-bottom: 30px;
}

.home-authors .item, .home-authors .group-item .item-images .img-item {
    padding: 0 5px;
}

.home-authors .item, .home-authors .group-item .item-images .img-item {
    width: calc(25% - 0px);
}

.author-name .text-ellipsis{
    max-width:80px;
}

.item-author .item-wrap, .home-authors .item-tobe-author .item-wrap {
    padding: 30px 15px 10px;
}

.item-author .item-wrap, .home-authors .item-tobe-author .item-wrap {
    background-color: var(--main-bg-color);
  height:390px;
    -webkit-border-radius: 10px;
    -moz-border-radius: 10px;
    border-radius: 10px;
    overflow: hidden;
    position: relative;
    -webkit-transition: all .2s;
    -o-transition: all .2s;
    transition: all .2s;
}

.item-author .item-bg {
    position: absolute;
    left: 0;
    right: 0;
    top: 0;
    padding-top: 100%;
    overflow: hidden;
}

.item-author .item-bg::before {
    content: '';
    display: block;
    position: absolute;
    left: 0;
    right: 0;
    bottom: 0;
    padding-top: 54%;
    background-color: var(--main-bg-color);
    z-index: 1;
}

.item-author .item-bg .thumb-1 {
    background-image: linear-gradient(120deg, #f6d365 0%, #fda085 100%);
}

.item-author .item-bg .thumb-2 {
   background-image: linear-gradient(120deg, #a1c4fd 0%, #c2e9fb 100%);
    
}

.item-author .item-bg .thumb-3 {
    background-image: linear-gradient(120deg, #e0c3fc 0%, #8ec5fc 100%);
}

.item-author .item-bg .thumb-4 {
 background-image: linear-gradient(to right, #4facfe 0%, #00f2fe 100%);
}

.item-author .item-bg .thumb-5 {
   background-image: linear-gradient(180deg, #2af598 0%, #009efd 100%);
}

.item-author .item-bg .thumb-6{
    background-image: linear-gradient(to top, #ff0844 0%, #ffb199 100%);
}

.item-author .item-bg .thumb-7 {
     background-image: linear-gradient(to top, #4481eb 0%, #04befe 100%);
}

.item-author .item-bg .thumb {
    padding-top: 100%;
    position: absolute;
    left: -50px;
    right: -50px;
    top: -50px;
    width: auto;
  
}

.thumb {
    display: block;
    background-repeat: no-repeat;
    background-position: center;
    -webkit-background-size: cover;
    background-size: cover;
    width: 100%;
    height: 0;
}

.item-author .item-bg::after {
    content: '';
    display: block;
    position: absolute;
    left: 0;
    right: 0;
    bottom: 54%;
    padding-top: 11%;
   
}

.item-author .item-top {
    padding: 15px;
}

.item-author .item-top {
    position: relative;
    -webkit-box-shadow: 0 20px 40px 0 rgba(0,0,0,0.02);
    box-shadow: 0 20px 40px 0 rgba(0,0,0,0.02);
    padding: 15px;
     background: var(--main-bg-color);
    -webkit-border-radius: 11px;
    -moz-border-radius: 11px;
    border-radius: 11px;
    z-index: 1;
}
 
.item-author .author-avatar {
    font-size: 50px;
    top: 0;
}

.home-authors .item  .author-avatar .avatar, .home-authors .group-item .item-images .img-item  .author-avatar .avatar {
    border-color: #ff6000;
}

.item-author .author-avatar .avatar {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    padding-top: 0;
    height: 50px;
    border: 2px solid #ffbc00;
    -webkit-border-radius: 100%;
    -moz-border-radius: 100%;
    border-radius: 100%;
    overflow: hidden;
}

.home-authors .item:nth-child(1) .author-avatar:after, .home-authors .group-item .item-images .img-item:nth-child(1) .author-avatar:after {
    content: '01';
     
}

.home-authors .item:nth-child(2) .author-avatar:after, .home-authors .group-item .item-images .img-item:nth-child(2) .author-avatar:after {
    content: '02';
   
}

.home-authors .item:nth-child(3) .author-avatar:after, .home-authors .group-item .item-images .img-item:nth-child(3) .author-avatar:after {
    content: '03';
     
}

.home-authors .item:nth-child(4) .author-avatar:after, .home-authors .group-item .item-images .img-item:nth-child(4) .author-avatar:after {
    content: '04';
   
}

.home-authors .item:nth-child(5) .author-avatar:after, .home-authors .group-item .item-images .img-item:nth-child(5) .author-avatar:after {
    content: '05';
     
}

.home-authors .item:nth-child(6) .author-avatar:after, .home-authors .group-item .item-images .img-item:nth-child(6) .author-avatar:after {
    content: '06';
   
}

.home-authors .item:nth-child(7) .author-avatar:after, .home-authors .group-item .item-images .img-item:nth-child(7) .author-avatar:after {
    content: '07';
   
}

.item-author .author-avatar 
{
    position: absolute;
    width: 50px;
}

.author-main {
    padding-left: 58px;
}

.item-author .author-name {
    font-size: 20px;
    color:var(--key-color);
    margin-bottom: 25px;
    white-space: nowrap;
}

.item-author .author-info {
    font-size: 13px;
    margin-top: 25px;
    margin-right: -16px;
    margin-left: -16px;
    padding: 0px 16px;
    color: var(--muted-color);
    text-align: center;
    line-height: 30px;
    background: var(--body-bg-color);
    height: 30px;
    border-radius: 4px;
    overflow: hidden;
}

.item-author .author-avatar:after {
    content: '';
    display: block;
    position: absolute;
    left: 50%;
    bottom: 75%;
    margin-left: -25%;
    width: 50%;
    height: 33.3333%;
     background-image: url(<?php echo panda_pz('static_panda');?>/assets/img/65afe5b99031b.png);
    background-position: center;
    background-repeat: no-repeat;
    -webkit-background-size: contain;
    background-size: contain;
    color: #ffffff;
    font-size: 12px;
    line-height: 32px;
    text-align: center;
    -webkit-transform: scale(.8);
    -ms-transform: scale(.8);
    transform: scale(.8);
    -webkit-transform-origin: center bottom;
    -ms-transform-origin: center bottom;
    transform-origin: center bottom;
}

.item-author .author-name {
          font-size: 15px;
    
    display: flex;
    white-space: nowrap;
    margin-bottom: 20px;
    
}

.item-author .author-name .uname {
    display: inline-block;
    vertical-align: middle;
    max-width: 100%;
    overflow: hidden;
    -o-text-overflow: ellipsis;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.item-author .author-meta {
    font-size: 13px;
}

.item-author .author-meta {
    font-size: 12px;
    line-height: 1.5;
    height: 20px;
    overflow: hidden;
    font-weight: normal;
    color: var(--muted-color);
}

.item-author .author-meta span:first-child {
    position: relative;
    margin-right: 5px;
}

.item-author .author-meta {
    font-size: 13px;
}

.btn-orange, .widget-talk .talk-item .talk-wrap:hover .btn, .list-item-home-news .widget-btns .btn:hover, .listitem-widget-job .widget-btns .btn:hover, .list-item-home-job .widget-btns .btn:hover, .search-widget-hotsearch .widget-btns .btn:hover, .group-sidebar .widget-talk .widget-btns .btn {
    background: #ff6000;
    color: #fff;
}
.author-name count{
    display:none;
}
 
.item-author .item-bottom-title {
    font-size: 14px;
    color: #b5b5b5;
    font-weight: normal;
    
}

.item-author .item-bottom {
    font-size: 14px;
    position: relative;
    z-index: 1;
   margin-top:10px;
    height: auto;
    overflow: hidden;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}

.item-author .ap-item {
    font-size: 14px;
}

.home-authors .item-tobe-author .item-btns a:first-child {
    color: #fff!important;
}

.home-authors .item-tobe-author .item-btns a:last-child {
    color: #ff6000!important;
}

.home-authors .item-tobe-author .item-btns a:visited {
    color: inherit;
}
.item-author .ap-item {
    font-size: 12px;
    
}
 
.item-author .ap-item-wrap.has-thumb {
    padding-left: 42%;
     
}
.item-author .ap-item-wrap {
    display: block;
    position: relative;
}
 
.item-author .ap-item-wrap .ap-item-thumb {
    position: absolute;
    left: 0;
    top: 0;
    width: 40%;
    overflow: hidden;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
    height:100%;
}

.item-author .ap-item-wrap .ap-item-thumb .thumb {
    -webkit-transition: all .2s;
    -o-transition: all .2s;
    transition: all .2s;
    padding-top: 70%;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
}

.item-author .ap-item-wrap.has-thumb .ap-item-title {
   height: 40px;
    overflow: hidden;
    font-weight: normal;
    line-height: 20px;
}
 
.item-author .ap-item-wrap .ap-item-title {
    font-size: 14px;
}

.item-author .ap-item-wrap .ap-item-meta {
    font-size: 11px;
}

.home-authors .item-tobe-author .item-wrap {
    background-image: url(<?php echo panda_pz('static_panda');?>/assets/img/65afe5b993334.jpg);
    -webkit-background-size: cover;
    background-size: cover;
    -webkit-background-origin: top center;
    background-origin: top center;
    background-repeat: no-repeat;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    height: 100%;
}

.home-authors .item-tobe-author .tobe-author-wrap {
    position: absolute;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    padding: 30px 20px 20px;
}

.home-authors .item-tobe-author .tobe-author {
    background-color: var(--main-bg-color) ;
    -webkit-border-radius: 10px;
    -moz-border-radius: 10px;
    border-radius: 10px;
    padding: 20px;
    height: 100%;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    position: relative;
}

.home-authors .item-tobe-author .item-title {
      color: #ff6000;
    font-size: 22px;
    margin-bottom: 10px;
    font-weight: 600;
}

.home-authors .item-tobe-author .item-title a {
    display: block;
    color: var(--muted-color);
}

.home-authors .item-tobe-author .item-cont {
    font-size: 16px;
    line-height: 28px;
}

.home-authors .item-tobe-author .item-cont .meta-views{
    font-size:14px;
}

.home-authors .item-tobe-author .item-cont {
    font-size: 16px;
    color: var(--muted-color);
    line-height: 24px;
}
 
.home-authors .item-tobe-author .item-cont .count {
    margin-bottom: 10px;
}

.home-authors .item-tobe-author .item-cont .count strong {
    font-size: 40px;
    color: #ff6000;
}

.home-authors .item-tobe-author .item-cont .count span {
    font-size: 16px;
}

.home-authors .item-tobe-author .item-btns {
    position: absolute;
    left: 20px;
    right: 20px;
    bottom: 20px;
    text-align: center;
}

.home-authors .item-tobe-author .item-btns .btn:first-child {
    padding:10px;
     
}

.home-authors .item-tobe-author .item-btns .btn:last-child {
       width: 46%;
    display: inline-block;
    line-height: 20px;
    border: 1px #ff6000 solid;
    padding: 10px;
    
    
}

.btn-orange, .widget-talk .talk-item .talk-wrap:hover .btn, .list-item-home-news .widget-btns .btn:hover, .listitem-widget-job .widget-btns .btn:hover, .list-item-home-job .widget-btns .btn:hover, .search-widget-hotsearch .widget-btns .btn:hover, .group-sidebar .widget-talk .widget-btns .btn {
    background: #ff6000;
    color: #fff;
}

.home-authors .item-tobe-author .item-btns .btn {
    width: 46%;
    display: inline-block;
    line-height: 20px;
}

.btn-orange-border, .talk-singular-prev-next .item-backhome .item-content .btn {
    background-color: transparent;
    color: #ff6000;
    border: 1px solid #ff6000;
}

.ap-item-meta .cat:before {
    content: '#';
    line-height: 19px;
    width: 19px;
    height: 19px;
    margin-right: 5px;
    color: #fe2c55;
    text-align: center;
    float: left;
    background: rgba(254, 44, 85, 0.2);
    border-radius: 50%;
    display: block;
    left: 0;
}
        </style>
        <div class="home-authors">
            <div class="part-content">
                    <div class="items author-items">
                        <?php
                        $allusers = get_users([
                            'has_published_posts' => ['post'], //post 文章类型，还可以追加 page 以及自定义文章类型
                            //  'exclude' => array(1)
                        ]);
                        
                        $newArrays = array();
                        foreach ($allusers as $alluser) {
                            $newArraya = array('name'=> $alluser->display_name,'renqi'=> get_user_posts_meta_count($alluser->ID, 'views'),'userid'=>$alluser->ID);
                            array_push($newArrays,$newArraya);
                        }

                        usort($newArrays, "compareAge"); // 调用 usort() 函数进行排序
                
                        $bgnum = 0;
                        
                        foreach ($newArrays as $newArray) {
                            ?>    
                            <div class="item item-author">
                                <div class="item-wrap">
                                    <div class="item-bg">
                                        <i class="thumb thumb-<?php echo ++$bgnum; ?>"></i>
                                    </div>
                                    <div class="item-top">
                                        <div class="author-avatar"><?php echo zib_get_data_avatar($newArray['userid']);?><?php echo zib_get_avatar_badge($newArray['userid']); ?></div>
                                            
                                            <div class="author-main">
                                                <p class="author-name">
                                                    <?php echo zib_get_user_name('id='.$newArray['userid'].'&class=flex1 flex ac&follow=true'); ?>          
                                                </p>
                                                
                                                <p class="author-meta">
                                                    <span>影响力 <?php echo $newArray['renqi']; ?></span>
                                                    <span># 投稿数 <?php echo (int) count_user_posts($newArray['userid'], 'post', true); ?></span>
                                                </p>
                                            </div>
            
                                            <div class="author-info">
                                                <p>
                                                    <i class="ico icon-article"></i><?php echo get_user_desc($newArray['userid']); ?>
                                                </p>            
                                            </div>
            
                                            <div class="author-btn">
                                                <div  class="looo">
                                                    <div class="user-s-follow jitheme-button">
                                                        <?php echo zib_get_author_header_btns($newArray['userid']); ?>
                                                    </div>
                                                </div>
                                            </div>  
                                            
                                        </div>
                                        
                                        <div class="item-bottom">
                                            <p class="item-bottom-title">最新更新</p>
                                                <div class="item-bottom-cont">
                                                    <div class="items">
                                                        <?php
                                                            $lzj = new WP_Query(array(
                                                                'posts_per_page' => 2, //每页返回2个
                                                                'post_type' => 'post',
                                                                'post_status'=>'publish',
                                                                'author' => $newArray['userid'],
                                                                'orderby' => 'views',
                                                            ));
                                                            $post = $lzj->post;
                                                            while ($lzj->have_posts()) :$lzj->the_post(); 
                                                            $category  = get_the_category($post->id);
                                                        ?>
                                                        <div class="ap-item">
                                                            <a href="<?php esc_url(the_permalink()); ?>" class="ap-item-wrap has-thumb" target="_blank">
                                                                <div class="ap-item-thumb">
                                                                    <?php echo zib_post_thumbnail(); ?>   
                                                                </div>
        
                                                                <div class="ap-item-main">
                                                                    <p class="ap-item-title">
                                                                        <?php the_title(); ?>
                                                                    </p>
                                                                    <p class="ap-item-meta">
                                                                        <span class="cat">
                                                                            <?php echo  $category [0]->cat_name;?>
                                                                        </span>
                                                                    </p>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    <?php endwhile; ?>     
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php 
                                $count = 0;
                                    if (++$count > 6) { 
                                        break; // 达到指定数量后跳出循环
                                    }
                                    }
                                ?>

                                <div class="item item-tobe-author">
                                    <div class="tobe-wrap" data-eq-height=".item-author" style="height:390px;">
                                        <div class="item-wrap">
                                            <div class="tobe-author-wrap">
                                                <div class="tobe-author">
                                                    <p class="item-title">  
                                                    <i class="fa fa-fw fa-pencil-square-o"></i> 人气作者榜 </p>
                                                <div class="item-cont">
                                                    <p>利用本站庞大的曝光矩阵，全方位提升你的个人影响力，获得更多职场机会和收入。</p>
                                                    <p><span class="meta-item meta-avatars">
                                                        <?php  
                                                        $count2 = 0;
                                                        foreach ($newArrays as $newArray){
                                                            if ($count2 < 5) { // 判断计数器小于3时才输出
                                                                echo zib_get_data_avatar($newArray['userid']) ;  
                                                                $count2++; // 每次输出后将计数器加1
                                                            } else {
                                                                break; // 达到指定数量后跳出循环
                                                            }
                                                        }
                                                        ?>
                                                    </span> 
                                                <span class="meta-item meta-views">人气作者</span></p>
                                        
                                            <p class="count">
                                                <strong><?php echo count($allusers); ?></strong>
                                                <span>位作者加入</span>
                                            </p>
                                        </div>
                                        <div class="item-btns">
                                            <a href="/newposts" target="_blank" class="btn btn-orange">我要投稿</a>
                                            <a href="/user" target="_blank" class="btn btn-orange-border">用户中心</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <?php
        
        echo '</div>';
    }

    public function form($instance)
    {
        $defaults = array(
            'title'        => '',
            'mini_title'   => '',
            'more_but'     => '<i class="fa fa-angle-right fa-fw"></i>更多',
            'more_but_url' => '',
            'number'       => 8,
            'hide_box'     => '',
        );

        $instance = wp_parse_args((array) $instance, $defaults);

        $page_input[] = array(
            'name'  => __('标题：', 'zib_language'),
            'id'    => $this->get_field_name('title'),
            'std'   => $instance['title'],
            'style' => 'margin: 10px auto;',
            'type'  => 'text',
        );
        $page_input[] = array(
            'name'  => __('副标题：', 'zib_language'),
            'id'    => $this->get_field_name('mini_title'),
            'std'   => $instance['mini_title'],
            'style' => 'margin: 10px auto;',
            'type'  => 'text',
        );
        $page_input[] = array(
            'name'  => __('标题右侧按钮->文案：', 'zib_language'),
            'id'    => $this->get_field_name('more_but'),
            'std'   => $instance['more_but'],
            'style' => 'margin: 10px auto;',
            'type'  => 'text',
        );
        $page_input[] = array(
            'name'  => __('标题右侧按钮->链接：', 'zib_language'),
            'id'    => $this->get_field_name('more_but_url'),
            'std'   => $instance['more_but_url'],
            'desc'  => '设置为任意链接',
            'style' => 'margin: 10px auto;',
            'type'  => 'text',
        );
        $page_input[] = array(
            'id'    => $this->get_field_name('hide_box'),
            'std'   => $instance['hide_box'],
            'desc'  => '不显示背景盒子',
            'style' => 'margin: 10px auto;',
            'type'  => 'checkbox',
        );
        
        echo zib_get_widget_show_type_input($instance,$this->get_field_name('show_type'));

        echo zib_edit_input_construct($page_input);
        ?>

	<?php
}
}