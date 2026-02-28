<?php 

//翻页按钮美化
if (panda_pz('fanyeanniu')) {
    function fanyeanniu() {?>
        <style>.pagenav .current {background: linear-gradient(90deg, #7de4d7 0%, #ff89ee 100%);color: #fff!important;}</style>
    <?php }add_action('wp_head', 'fanyeanniu');
}

//给幻灯片下方加一个虚雾效果
if (panda_pz('index_slide_effect')) {

    function index_slide_effect() {?>
        <style>
.header-slider-container .swiper-slide::before {
    content: '';
    display: block;
    position: absolute;
    left: 0;
    top: 80%;
    right: 0;
    bottom: 0;
    -ms-transform: scale(1);
    transform: scale(1);
   background: linear-gradient(180deg, rgba(252, 252, 252, 0) 0%, rgba(252, 252, 252, 0.05) 10%, rgba(252, 252, 252, 0.1) 20%, rgba(252, 252, 252, 0.2) 30%, rgba(252, 252, 252, 0.5) 50%, rgba(252, 252, 252, 0.8) 70%, #f5f6f7 100%);
    z-index: 1;
}
.dark-theme .header-slider-container .swiper-slide::before {
    content: '';
    display: block;
    position: absolute;
    left: 0;
    top: 50%;
    right: 0;
    bottom: 0;
    -ms-transform: scale(1);
    transform: scale(1);
    background: linear-gradient(180deg, rgba(255, 255, 255, 0) 0%, #292a2d 100%);
    z-index: 1;
}
        </style>
        <?php }
    add_action('wp_head', 'index_slide_effect');
}

/* 首页文章点击更多按钮 */
if (panda_pz('index_more_btn_style')) {
    function index_more_btn_style() {
        echo '<style>.theme-pagination .ajax-next a, .theme-pagination .order-ajax-next a{border-radius: 30px; padding: 15px 0; color: var(--muted-color); background-color:var(--main-bg-color);color: #FF0033;display: block;opacity: 1;font-weight:bold;}</style>';
    } add_action('wp_head', 'index_more_btn_style');
}

/* 首页文章列表悬停上浮 */
if (panda_pz('index_post_hover_style')) {
    function index_post_hover_style() {
        echo '<style>@media screen and (min-width: 980px){.tab-content .posts-item:not(article){transition: all 0.3s;}.tab-content .posts-item:not(article):hover{transform: translateY(-10px); box-shadow: 0 8px 10px ';
        echo panda_pz('index_post_hover_style_color');
        echo ';}}</style>';
    } add_action('wp_head', 'index_post_hover_style');
}

/*文章列表摇晃的悬停上浮效果*/
if (panda_pz('index_post_shake_style')) {
    function index_post_shake_style(){?>
        <style>.tab-content .posts-item:not(article):hover{opacity: 1;z-index: 99;border-radius: 20px;transform: translateY(-5px);box-shadow: 0 3px 20px rgba(0, 0, 0, .25);animation: index-link-active 1s cubic-bezier(0.315, 0.605, 0.375, 0.925) forwards;}@keyframes index-link-active {0%{transform: perspective(2000px) rotateX(0) rotateY(0) translateZ(0);}16%{transform: perspective(2000px) rotateX(10deg) rotateY(5deg) translateZ(32px);}100%{transform: perspective(2000px) rotateX(0) rotateY(0) translateZ(65px);}</style>
    <?php } add_action('wp_head', 'index_post_shake_style');
}

//列表图片特效
if (panda_pz('index_post_img_effect')) {
    function index_post_img_effect(){?>
        <style>.hover-zoom-img-sm:hover img,.hover-zoom-sm:hover,.posts-item.mult-thumb .thumb-items>span>img:hover,.posts-item:hover .item-thumbnail img,.posts-mini:hover img {transform: scale(1.2) rotate(5deg);}</style>
    <?php }
    add_action('wp_head', 'index_post_img_effect');
}

//文章列表悬停萝莉
if (panda_pz('index_post_hover_loli', false)) {
function index_post_hover_loli(){  ?>
    <style>
    /*首页文章列表悬停可爱萝莉*/
@media screen and (min-width:980px) {
.tab-content .posts-row>*:hover {
    transition:all <?php echo panda_pz('index_post_hover_time',false);?>s;
    content: " ";
    right: -50px;
    background-size: contain;
    background-position: center right;
    background-image: url(<?php echo panda_pz('index_post_hover_img',false);?>);
    background-repeat: no-repeat;
}
}
        </style>
<?php }add_action('wp_footer', 'index_post_hover_loli');
}

/*卡片列表图片动效*/
if (panda_pz('card_list_img_effect')) {
    function card_list_img_effect() {
        echo '<style>.card:hover .item-thumbnail a img {-webkit-animation: jumps-data-v-6bdef187 1.2s ease 1;animation: jumps-data-v-6bdef187 1.2s ease 1;}@keyframes jumps-data-v-6bdef187 {0% { transform: translate(0)}10% {transform: translateY(5px) scaleX(1.2) scaleY(.8); }30% {transform: translateY(-13px) scaleX(1) scaleY(1) rotate(5deg)}50% {transform: translateY(0) scale(1) rotate(0)}55% {transform: translateY(0) scaleX(1.1) scaleY(.9) rotate(0)}70% {transform: translateY(-4px) scaleX(1) scaleY(1) rotate(-2deg)}80% {transform: translateY(0) scaleX(1) scaleY(1) rotate(0)}85% {transform: translateY(0) scaleX(1.05) scaleY(.95) rotate(0)}to {transform: translateY(0) scaleX(1) scaleY(1)}}</style>';
    } add_action('wp_footer', 'card_list_img_effect');
}

/* 文章缩略图的动态圆圈 */
if (panda_pz('post_thumbnail_circle_style')) {
    function post_thumbnail_circle_style() {?>
        <style>.item-thumbnail:before {content: '';position: absolute;top: 0;left: 0;right: 0;bottom: 0;background: rgba(0,0,0,0);transition: background .35s;border-radius: 8px;z-index: 2;max-width: 765px;margin: 0 auto;pointer-events: none;}.item-thumbnail:after {content: '';position: absolute;top: 50%;left: 50%;width: 50px;height: 50px;margin: -25px 0 0 -25px;background: url(<?php echo panda_pz('post_thumbnail_circle_style_img'); ?>);background-repeat: no-repeat;background-size: 100% 100%;z-index: 3;-webkit-transform: scale(2);transform: scale(2);transition: opacity .35s,-webkit-transform .35s;transition: transform .35s,opacity .35s;transition: transform .35s,opacity .35s,-webkit-transform .35s;opacity: 0;pointer-events: none;}.item-thumbnail:hover:before {background: rgba(0,0,0,.5)}.item-thumbnail:hover:after {-webkit-transform: scale(1);transform: scale(1);opacity: 1}</style>
    <?php } add_action('wp_head', 'post_thumbnail_circle_style');
}

/* 文章随机彩色标签 */
if (panda_pz('page_tag_style')) {
    function page_tag_style() {
        echo '<style>.article-tags{margin-bottom: 10px}.article-tags a{padding: 4px 10px;background-color: #19B5FE;color: white;font-size: 12px;line-height: 16px;font-weight: 400;margin: 0 5px 5px 0;border-radius: 2px;display: inline-block}.article-tags a:nth-child(5n){background-color: #4A4A4A;color: #FFF}.article-tags a:nth-child(5n+1){background-color: #ff5e5c;color: #FFF}.article-tags a:nth-child(5n+2){background-color: #ffbb50;color: #FFF}.article-tags a:nth-child(5n+3){background-color: #1ac756;color: #FFF}.article-tags a:nth-child(5n+4){background-color: #19B5FE;color: #FFF}.article-tags a:hover{background-color: #1B1B1B;color: #FFF}</style>';
    } add_action('wp_head', 'page_tag_style');
}

//分类栏目
if (panda_pz('category_bg_style')=='1') {
    function category_bg_style() {?>
        <style>
        .index-tab ul>li.active {
            color: #ffffff00!important;
            background-color: #ffffff00!important;
            border-radius: 6px;
            z-index: 1;
            position: relative;
            height: 39px;
            line-height: 44px;
            background: url(<?php echo panda_pz('static_panda');?>/assets/img/bg-category.png) repeat;
            -webkit-background-size: 91px 39px;
            -moz-background-size: 91px 39px;
            background-size: 91px 39px;
        }
        .index-tab ul>li {
            display: inline-block;
            padding: 2px 17px;
            font-weight: 500;
            border-radius: 20px;
            margin: 0 1px;
        }</style>
        <?php }
        add_action('wp_head', 'category_bg_style');
}
if (panda_pz('category_bg_style')=='2') {
    function category_bg_style() {?>
    <style>
.index-tab ul>li.active{background-image:linear-gradient(to right,#566fee 10%,#a1aff5 100%);border:0;padding:8px 14px;box-shadow:0 0 8px 0 rgba(95,95,95,.15);border-radius:6px;}
.index-tab ul>li{display:inline-flex;align-items:center;padding:2px 17px;font-weight:500;border-radius:20px;margin:0 1px;}
</style>
<?php 
    }
    add_action('wp_head', 'category_bg_style');
}
//卡片列表显示三个点
if (panda_pz('card_list_dot_style')) {
    function card_list_dot_style() {
        echo '<style>
.posts-item.card {
    padding: 35px 10px 10px 10px !important;
}
.posts-item {
    position: relative !important;
}
.posts-item.card::before {
    content: "";
    display: block;
    background: #fc625d;
    top: 13px;
    left: 15px;
    border-radius: 50%;
    width: 9px;
    height: 9px;
    box-shadow: 16px 0 #fdbc40, 32px 0 #35cd4b;
    margin: 0px 2px -7px;
    z-index: 1;
    position: absolute;
}
</style>';
    } add_action('wp_head', 'card_list_dot_style');
}

//卡片模式数量修改
if (panda_pz('card_list_num')!='0') {
    function card_list_num() {
        echo '<style>@media (min-width: 992px){
posts.posts-item.card.ajax-item {
    width: calc('.panda_pz('card_list_num').'%  - 16px);
}
}</style>';
    } add_action('wp_head', 'card_list_num');
}

// 标题悬浮效果
if(panda_pz('post_title_hover_style') != '0'){
    function post_title_hover_style(){
        switch (panda_pz('post_title_hover_style')) {
            case '1':
                echo '<style>
.posts-item .item-heading>a{background:linear-gradient(to right,#ec695c,#61c454) no-repeat right bottom;background-size:0 2px;transition:background-size 1300ms}.posts-item .item-heading>a:hover{background-position-x:left;background-size:100% 5px}
.article-title>a{background:linear-gradient(to right,#ec695c,#61c454) no-repeat right bottom;background-size:0 2px;transition:background-size 1300ms}.article-title>a:hover{background-position-x:left;background-size:100% 5px}
.zib-widget .text-ellipsis>a{background:linear-gradient(to right,#ec695c,#61c454) no-repeat right bottom;background-size:0 2px;transition:background-size 1300ms}.zib-widget .text-ellipsis>a:hover{background-position-x:left;background-size:100% 5px}
.zib-widget .text-ellipsis-2>a{background:linear-gradient(to right,#ec695c,#61c454) no-repeat right bottom;background-size:0 2px;transition:background-size 1300ms}.zib-widget .text-ellipsis-2>a:hover{background-position-x:left;background-size:100% 5px}</style>
';
                break;
            case '2':
                echo '<style>
                .item-heading :hover,.text-ellipsis :hover,.text-ellipsis-2 :hover,.links-lists :hover {background-image: -webkit-linear-gradient(30deg, #32c5ff 25%, #b620e0 50%, #f7b500 75%, #20e050 100%);-webkit-text-fill-color: transparent;-webkit-background-clip: text;-webkit-background-size: 200% 100%;-webkit-animation: maskedAnimation 4s infinite linear;}@keyframes maskedAnimation {0% {background-position: 0 0}100% {background-position: -100% 0}}
                </style>';
                break;
            }
        } add_action('wp_head', 'post_title_hover_style');
}
                


// 文章内图片圆角
if (panda_pz('post_radius')) {
    function post_radius(){?>
        <style>.wp-posts-content img {border-radius: <?php echo panda_pz('post_radius_s');?>px;}</style>
        <?php }add_action('wp_head', 'post_radius');
}

if(panda_pz('post_title_style') != '0' && panda_pz('post_title_style')!= '3'){
function post_title_style(){
/*将h1-h5标题美化成猫爪*/
    switch (panda_pz('post_title_style')) {
        case '1':
            $post_title_img_h1 = panda_pz('static_panda').'/assets/img/h/cat.svg';
            $post_title_img_h2 = panda_pz('static_panda').'/assets/img/h/cat.svg';
            $post_title_img_h3 = panda_pz('static_panda').'/assets/img/h/cat.svg';
            $post_title_img_h4 = panda_pz('static_panda').'/assets/img/h/cat.svg';
            $post_title_img_h5 = panda_pz('static_panda').'/assets/img/h/cat.svg';
            break;
        case '2':
            $post_title_img_h1 = panda_pz('static_panda').'/assets/img/h/wave.svg';
            $post_title_img_h2 = panda_pz('static_panda').'/assets/img/h/wave.svg';
            $post_title_img_h3 = panda_pz('static_panda').'/assets/img/h/wave.svg';
            $post_title_img_h4 = panda_pz('static_panda').'/assets/img/h/wave.svg';
            $post_title_img_h5 = panda_pz('static_panda').'/assets/img/h/wave.svg';
            break;
        case 'diy':
            $post_title_img_h1 = panda_pz('post_title_img_h1');
            $post_title_img_h2 = panda_pz('post_title_img_h2');
            $post_title_img_h3 = panda_pz('post_title_img_h3');
            $post_title_img_h4 = panda_pz('post_title_img_h4');
            $post_title_img_h5 = panda_pz('post_title_img_h5');
            break;
    }
    ?>
                <style>
                .title-theme {
                    padding: 0px 0px 0px 45px!important;
                    background: url(<?php echo $post_title_img_h1; ?>) 10px center no-repeat;
                    background-size: 30px 20px;
                    color: #566889;
                }
                .title-theme:before {
                display:none;
                }
                .wp-posts-content>h1.wp-block-heading{
                    padding: 0px 0px 0px 45px!important;
                    background: url(<?php echo $post_title_img_h2; ?>) 10px center no-repeat;
                    background-size: 30px 20px;
                }
                .wp-posts-content>h2.wp-block-heading{
                    padding: 0px 0px 0px 45px!important;
                    background: url(<?php echo $post_title_img_h3; ?>) 10px center no-repeat;
                    background-size: 30px 20px;
                }
                .wp-posts-content>h3.wp-block-heading{
                    padding: 0px 0px 0px 45px!important;
                    background: url(<?php echo $post_title_img_h4; ?>) 10px center no-repeat;
                    background-size: 30px 20px;
                }
                .wp-posts-content>h4.wp-block-heading{
                    padding: 0px 0px 0px 45px!important;
                    background: url(<?php echo $post_title_img_h5; ?>) 10px center no-repeat;
                    background-size: 30px 20px;
                }
                .wp-posts-content>h1.wp-block-heading:before{
                    display:none;
                }
                .wp-posts-content>h2.wp-block-heading:before{
                    display:none;
                }
                .wp-posts-content>h3.wp-block-heading:before{
                    display:none;
                }
                .wp-posts-content>h4.wp-block-heading:before{
                    display:none;
                }
                </style>
            <?php
        }add_action('wp_head', 'post_title_style');
}

if (panda_pz('post_title_style') == '3'){
    function post_title_style_3(){
        ?>
        <style>
.article-content > .wp-posts-content > h1,.article-content .wp-posts-content > h2,.article-content .wp-posts-content > h3{z-index:1;}
.article-content > .wp-posts-content > h1:hover::before,.article-content > .wp-posts-content > h2:hover::before,.article-content > .wp-posts-content > h1:hover::after,.article-content > .wp-posts-content > h2:hover::after,.article-content > .wp-posts-content > h3:hover::before{transform:scale(1.2) !important;transform-origin:center !important;transition:0.4s;}
/* h1 样式 */
.article-content .wp-posts-content h1::before,.article-content .wp-posts-content h1::after{background:linear-gradient(#3390ff,transparent) !important;/* h1 的颜色 */
}
.article-content .wp-posts-content h1::before{height:40px !important;width:40px !important;box-shadow:none !important;opacity:0.6 !important;border-radius:50% !important;top:-5px !important;left:-10px !important;z-index:1;}
.article-content .wp-posts-content h1::after{content:"";opacity:0.6;position:absolute;transition:0.4s;border-radius:50%;width:13px;height:13px;top:-20px;left:20px;}
/* h2 样式 */
.article-content .wp-posts-content h2::before,.article-content .wp-posts-content h2::after{background:linear-gradient(#33ff57,transparent) !important;/* h2 的颜色 */
}
.article-content .wp-posts-content h2::before{height:30px !important;width:30px !important;box-shadow:none !important;opacity:0.6 !important;border-radius:50% !important;top:-5px !important;left:-10px !important;z-index:1;}
.article-content .wp-posts-content h2::after{content:"";opacity:0.6;position:absolute;transition:0.4s;border-radius:50%;width:10px;height:10px;top:-15px;left:15px;}
/* h3 样式 */
.article-content .wp-posts-content h3::before{height:20px !important;width:20px !important;box-shadow:none !important;opacity:0.6 !important;background:linear-gradient(#3390ff,transparent) !important;/* h3 的颜色 */
 border-radius:50% !important;top:-5px !important;left:-10px !important;z-index:1;}
</style> 
        <?php
    }add_action('wp_head', 'post_title_style_3');
}

//文章内代码高亮美化
if(panda_pz('post_code_highlight')){
    function post_code_highlight(){
        ?>
        <style>
        .enlighter::before {
            content: "";
            display: block;
            background: #fc625d;
            top: 9px;
            left: 15px;
            border-radius: 50%;
            width: 15px;
            height: 15px;
            box-shadow: 20px 0 #fdbc40, 40px 0 #35cd4b;
            margin: 0px 2px -7px;
            z-index: 1;
            position: absolute;
        }

        .enlighter-overflow-scroll.enlighter-v-standard .enlighter {
            padding: 35px 0 12px 0;
        }
    </style>
    <?php } add_action('wp_head', 'post_code_highlight');
}

/* 文章添加关键词链接 */
if (panda_pz('add_keywords_link')) {
    function add_keywords_link($content){
        $limit = 1;$posttags = get_the_tags();if ($posttags) {foreach($posttags as $tag) {$link = get_tag_link($tag->term_id);$keyword = $tag->name;$cleankeyword = stripslashes($keyword);$url = '<a target="_blank" href="'.$link.'" title="'.str_replace('%s', addcslashes($cleankeyword, '$'), __('View all posts in %s')).'">'.addcslashes($cleankeyword, '$').'</a>';$regEx = '\'(?!((<.*?)|(<a.*?)))('. $cleankeyword . ')(?!(([^<>]*?)>)|([^>]*?</a>))\'s';$content = preg_replace($regEx,$url,$content,$limit);}}return $content;
    }add_filter( 'the_content', 'add_keywords_link', 1 );
}

/*超链接下波浪线*/
if (panda_pz('link_wave_style')) {
    function link_wave_style() {?>
    <style>
    .wp-posts-content a:hover {color:#ff4500;text-decoration:none;background:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 4'%3E%3Cpath fill='none' stroke='%23FF4500' d='M0 3.5c5 0 5-3 10-3s5 3 10 3 5-3 10-3 5 3 10 3'/%3E%3C/svg%3E")repeat-x 0 100%;background-size:20px auto;animation:waveMove 1s infinite linear}
    @keyframes waveMove{from{background-position:0 100%}
    to{background-position:-20px 100%}
    }
    </style>
    <?php } add_action('wp_head', 'link_wave_style');
}

/* 图片外发光 */
if (panda_pz('img_shadow_style')) {
    function img_shadow_style(){?>
        <style>.wp-posts-content img:hover {box-shadow:0px 0px 8px <?php echo panda_pz('img_shadow_style_color'); ?>;}</style>
    <?php } add_action('wp_head', 'img_shadow_style');
}

/*七彩标签云样式*/
if (panda_pz('page_tag_color_style')=='1') {
    function page_tag_color_style(){?>
        <style>.widget-tag-cloud.author-tag .but{ position: relative; padding: 1px 4px 2px 4px;margin: 0px 4px 0px 3px;border: 1px solid #e6e7e8; border-radius: 18px; text-decoration: none; white-space: nowrap;-o-box-shadow: 6px 4px 8px 0 rgba(151,142,136,.34);-ms-box-shadow: 6px 4px 8px 0 rgba(151,142,136,.34);-moz-box-shadow: 6px 4px 8px 0 rgba(151,142,136,.34);-webkit-box-shadow: 6px 4px 8px 0 rgba(151,142,136,.34);box-shadow: 6px 4px 8px 0 rgba(151,142,136,.34);-ms-filter:"progid:DXImageTransform.Microsoft.Shadow(Strength=4,Direction=135, Color='#000000')";filter: progid:DXImageTransform.Microsoft.Shadow(color='#969696', Direction=125, Strength=1);}.author-tag a:nth-child(7n+1):hover{color:#ffffff; background-color:rgba(255,78,106,.8)}.author-tag a:nth-child(7n+2):hover{color:#ffffff; background-color:#ffaa73}.author-tag a:nth-child(7n+3):hover{color:#ffffff; background-color:#fed466}.author-tag a:nth-child(7n+4):hover{color:#ffffff; background-color:#3cdc82}.author-tag a:nth-child(7n+5):hover{color:#ffffff; background-color:#64dcf0}.author-tag a:nth-child(7n+6):hover{color:#ffffff; background-color:#64b9ff}.author-tag a:nth-child(7n+7):hover{color:#ffffff; background-color:#b4b4ff}.author-tag a:nth-child(7n+1){background-color:rgba(255,78,106,.15); color:rgba(255,78,106,.8)}.author-tag a:nth-child(7n+2){background-color:rgba(255,170,115,.15); color:#ffaa73}.author-tag a:nth-child(7n+3){background-color:rgba(254,212,102,.15); color:#fed466}.author-tag a:nth-child(7n+4){background-color:rgba(60,220,130,.15); color:#3cdc82}.author-tag a:nth-child(7n+5){background-color:rgba(100,220,240,.15); color:#64dcf0}.author-tag a:nth-child(7n+6){background-color:rgba(100,185,255,.15); color:#64b9ff}.author-tag a:nth-child(7n+7){background-color:rgba(180,180,255,.15); color:#b4b4ff}</style>
    <?php } add_action('wp_head', 'page_tag_color_style');
}

if (panda_pz('page_tag_color_style')=='2') {
    function page_tag_color_style2(){?>
    <style>
                   .widget-tag-cloud.author-tag .but:hover{opacity: 1;}
    .widget-tag-cloud.author-tag .but{opacity: 0.6;line-height: 20px !important;padding: 4px 10px !important;font-size: 12px !important;}
    .widget-tag-cloud.author-tag .but:nth-child(5n){background-color: #4A4A4A;color: #FFF}
    .widget-tag-cloud.author-tag .but:nth-child(5n+1){background-color: #ff5e5c;color: #FFF}
    .widget-tag-cloud.author-tag .but:nth-child(5n+2){background-color: #ffbb50;color: #FFF}
    .widget-tag-cloud.author-tag .but:nth-child(5n+3){background-color: #1ac756;color: #FFF}
    .widget-tag-cloud.author-tag .but:nth-child(5n+4){background-color: #19B5FE;color: #FFF}
    </style>
    <?php } add_action('wp_head', 'page_tag_color_style2');
}


/* 文章图片自动添加alt和title */
if (panda_pz('img_alt_title')) {
    function image_alt_tag($content){ $img_alt_title_sz = panda_pz('img_alt_title_sz');
        global $post;preg_match_all('/<img (.*?)\/>/', $content, $images);
        if(!is_null($images)) {
            foreach($images[1] as $index => $value)
            {
                if ($img_alt_title_sz['alt']  == '1') {
                    $alt = ''. get_the_title().'';
                }
                if ($img_alt_title_sz['alt']  == '2') {
                    $alt = ''. get_the_title().'-'. get_bloginfo('name').'';
                }
                if ($img_alt_title_sz['title']  == '1') {
                    $title = ''. get_the_title().'';
                }
                if ($img_alt_title_sz['title']  == '2') {
                    $title = ''. get_the_title().'-'. get_bloginfo('name').'';
                }
                $new_img = str_replace('<img', '<img alt="'. $alt .'" title="'. $title .'"', $images[0][$index]);
                $content = str_replace($images[0][$index], $new_img, $content);
            }
        }
        return $content;
    } add_filter('the_content', 'image_alt_tag', 99999);
}

/* 删除文章自动删除图片附件 */
if (panda_pz('shanchu_fujian')) {
    function post_and_attachments($post_ID) {
        global $wpdb;
        //删除特色图片
        $thumbnails = $wpdb->get_results( "SELECT * FROM $wpdb->postmeta WHERE meta_key = '_thumbnail_id' AND post_id = $post_ID" );
        foreach ( $thumbnails as $thumbnail ) {
            wp_delete_attachment( $thumbnail->meta_value, true );
        }
        //删除图片附件
        $attachments = $wpdb->get_results( "SELECT * FROM $wpdb->posts WHERE post_parent = $post_ID AND post_type = 'attachment'" );
        foreach ( $attachments as $attachment ) {
            wp_delete_attachment( $attachment->ID, true );
        }
        $wpdb->query( "DELETE FROM $wpdb->postmeta WHERE meta_key = '_thumbnail_id' AND post_id = $post_ID" );
    } add_action('before_delete_post', 'post_and_attachments');
}

// 文章摘要
if (panda_pz('ai_excerpt')) {
    function ai_excerpt() {
        // 获取文章的Description
        $post = get_post();
        $description = panda_description($post->ID);
        ?>
        <link rel="stylesheet" href="<?php echo panda_pz('static_panda');?>/assets/css/ai.css">
        <script src="<?php echo panda_pz('static_panda');?>/assets/js/ai.js"></script>
        <div class="post-PandaAI">
                <div class="PandaAI-title">
                    <i class="PandaAI-title-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48px" height="48px" viewBox="0 0 48 48">
                            <g id="Panda AI" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <path d="M34.717885,5.03561087 C36.12744,5.27055371 37.079755,6.60373651 36.84481,8.0132786 L35.7944,14.3153359 L38.375,14.3153359 C43.138415,14.3153359 47,18.1768855 47,22.9402569 L47,34.4401516 C47,39.203523 43.138415,43.0650727 38.375,43.0650727 L9.625,43.0650727 C4.861585,43.0650727 1,39.203523 1,34.4401516 L1,22.9402569 C1,18.1768855 4.861585,14.3153359 9.625,14.3153359 L12.2056,14.3153359 L11.15519,8.0132786 C10.920245,6.60373651 11.87256,5.27055371 13.282115,5.03561087 C14.69167,4.80066802 16.024865,5.7529743 16.25981,7.16251639 L17.40981,14.0624532 C17.423955,14.1470924 17.43373,14.2315017 17.43948,14.3153359 L30.56052,14.3153359 C30.56627,14.2313867 30.576045,14.1470924 30.59019,14.0624532 L31.74019,7.16251639 C31.975135,5.7529743 33.30833,4.80066802 34.717885,5.03561087 Z M38.375,19.4902885 L9.625,19.4902885 C7.719565,19.4902885 6.175,21.0348394 6.175,22.9402569 L6.175,34.4401516 C6.175,36.3455692 7.719565,37.89012 9.625,37.89012 L38.375,37.89012 C40.280435,37.89012 41.825,36.3455692 41.825,34.4401516 L41.825,22.9402569 C41.825,21.0348394 40.280435,19.4902885 38.375,19.4902885 Z M14.8575,23.802749 C16.28649,23.802749 17.445,24.9612484 17.445,26.3902253 L17.445,28.6902043 C17.445,30.1191812 16.28649,31.2776806 14.8575,31.2776806 C13.42851,31.2776806 12.27,30.1191812 12.27,28.6902043 L12.27,26.3902253 C12.27,24.9612484 13.42851,23.802749 14.8575,23.802749 Z M33.1425,23.802749 C34.57149,23.802749 35.73,24.9612484 35.73,26.3902253 L35.73,28.6902043 C35.73,30.1191812 34.57149,31.2776806 33.1425,31.2776806 C31.71351,31.2776806 30.555,30.1191812 30.555,28.6902043 L30.555,26.3902253 C30.555,24.9612484 31.71351,23.802749 33.1425,23.802749 Z" id="形状结合" fill="#444444" fill-rule="nonzero"></path>
                            </g>
                        </svg>
                    </i>
                    <div class="PandaAI-title-text"><?php echo panda_pz('ai_title');?></div>
                    <?php if (panda_pz('animation')){?>
                    <div class="PandaAI-tag  loadingAI" id="PandaAI-tag"><?php echo panda_pz('ai_tags');?></div>
                    <?php }else{
                        echo '<div class="PandaAI-tag">'. panda_pz('ai_tags').'</div>';
                    } ?>
                </div>
                <?php if (panda_pz('animation')){?>
                    <div class="PandaAI-explanation" data-summary="<?php echo $description;?>"><span class="blinking-cursor"></span></div>
                <?php }else{ ?>
                    <div class="PandaAI-explanation"><?php echo $description;?></div>
                <?php } ?>
            </div>
        <?php
    }add_action('zib_posts_content_before', 'ai_excerpt');
}
function panda_description($echo = true)
{
    global $new_description;
    if ($new_description) {
        if ($echo) {
            // 如果需要输出，可以保留这部分代码
            // echo "<meta name=\"description\" content=\"$new_description\">\n";
            // 现在我们只返回 $new_description
            return $new_description;
        } else {
            return $new_description;
        }
    }

    global $s, $post;
    $description = '';
    $blog_name   = get_bloginfo('name');

    if (is_singular()) {
        // 获取自定义描述
        $description = trim(zib_get_post_meta($post->ID, 'description', true));

        if (!$description) {
            // 如果没有自定义描述，则获取摘要
            $description = zib_get_excerpt(210, '...', $post);
            $description = mb_substr($description, 0, 200, 'utf-8');
        }

        if (!$description) {
            // 如果没有摘要，则使用博客名称和页面标题
            $description = $blog_name . "-" . trim(wp_title('', false));
        }

    } elseif (is_home()) {
        // 首页描述
        $description = _pz('description');
    } elseif (is_category() || is_tax('topics') || is_tag()) {
        // 分类、标签描述
        global $wp_query;
        $cat_ID      = get_queried_object_id();
        $description = _get_tax_meta($cat_ID, 'description');
        if (!$description) {
            $description = trim(strip_tags(term_description()));
        }

        if (!$description) {
            // 如果分类没有描述，则使用分类名称和博客名称
            $description = single_term_title('', false) . zib_get_delimiter_blog_name();
        }

    } elseif (is_archive()) {
        // 归档页面描述
        $description = $blog_name . "'" . trim(wp_title('', false)) . "'";
    } elseif (is_search()) {
        // 搜索结果页面描述
        $description = $blog_name . ": '" . esc_html($s, 1) . "' 的搜索结果";
    } else {
        // 其他页面描述
        $description = $blog_name . "'" . trim(wp_title('', false)) . "'";
    }

    // 转义特殊字符
    $description = esc_attr($description);

    if ($echo) {
        // 如果需要输出，可以取消注释以下行
        // echo "<meta name=\"description\" content=\"$description\">\n";
        // 现在我们只返回 $description
        return $description;
    } else {
        return $description;
    }
}

/* 文章顶部添加最后更新时间或过期失效提示 */
if (panda_pz('posts_gqts')) {
    function article_time_update() { $posts_gqts_sz = panda_pz('posts_gqts_sz');
        $date = get_the_modified_time('Y-m-d H:i:s');
        $content= '
            <div class="article-timeout">
                <div class="article-timeout-text">
                    文章最后更新时间：<span>'. $date .'</span>' .$posts_gqts_sz['text']. '
                </div>
            </div>
            <style>
                .article-timeout{
                    background: rgba(255, 188, 68, .38);
                    color: #333;
                    margin: 0 0 20px;
                    border-radius: 8px;
                    position: relative;
                    text-align: center;
                    background-image: url(https://img.alicdn.com/imgextra/i1/2210123621994/O1CN017ZFVO81QbIjgNEl4Q_!!2210123621994.png);
                    background-clip: padding-box;
                    background-size: cover;
                    background-repeat: no-repeat;
                    background-attachment: scroll;
                    background-position: 50% 50%;
                    background-blend-mode: normal;
                }
                .article-timeout .article-timeout-text {
                    padding: 6px;
                }
                .article-timeout .article-timeout-text span {
                    color: #f60;
                    margin: 0 3px;
                }
                </style>
        ';
        echo $content;
    } 
    if (panda_pz('posts_gqts_position') == 'foot') {
        add_action('zib_posts_content_after', 'article_time_update');
    }if (panda_pz('posts_gqts_position') == 'head') {
        add_action('zib_posts_content_before', 'article_time_update');
    }
}

/* 文章链接文本自动加超链接 */
if (panda_pz('posts_links',false)) {
    add_filter('the_content', 'make_clickable');
}

//文章阴影边缘
if (panda_pz('post_shadow_style')) {
    function post_shadow_style(){?>
        <style>.article{border-radius:var(--main-radius);
        box-shadow: 1px 1px 3px 3px <?php echo panda_pz('post_shadow_style_color'); ?>;
        -moz-box-shadow: 1px 1px 3px 3px <?php echo panda_pz('post_shadow_style_color'); ?>;}
        .article:hover{box-shadow: 1px 1px 5px 5px <?php echo panda_pz('post_shadow_style_color'); ?>
            ; -moz-box-shadow: 1px 1px 5px 5px <?php echo panda_pz('post_shadow_style_color'); ?>;}    </style>
    <?php }
    add_action('wp_head', 'post_shadow_style');
}

//
function wp_aatags_html2text($ep) {
    $search = array("'<script[^>]*?>.*?</script>'si", "'<[\/\!]*?[^<>]*?>'si", "'([\r\n])[\s]+'", "'&(quot|#34|#034|#x22);'i", "'&(amp|#38|#038|#x26);'i", "'&(lt|#60|#060|#x3c);'i", "'&(gt|#62|#062|#x3e);'i", "'&(nbsp|#160|#xa0);'i", "'&(iexcl|#161);'i", "'&(cent|#162);'i", "'&(pound|#163);'i", "'&(copy|#169);'i", "'&(reg|#174);'i", "'&(deg|#176);'i", "'&(#39|#039|#x27);'", "'&(euro|#8364);'i", "'&a(uml|UML);'", "'&o(uml|UML);'", "'&u(uml|UML);'", "'&A(uml|UML);'", "'&O(uml|UML);'", "'&U(uml|UML);'", "'&szlig;'i");
    $replace = array("", "", "\\1", "\"", "&", "<", ">", " ", chr(161), chr(162), chr(163), chr(169), chr(174), chr(176), chr(39), chr(128), "ä", "ö", "ü", "Ä", "Ö", "Ü", "ß");
    return preg_replace($search, $replace, $ep);
}

function wp_aatags_sanitize($taglist) {
    $special_chars = array('?', '、', '。', '“', '”', '《', '》', '！', '，', '：', '？', '.', '[', ']', '/', '\\', '\=', '<', '>', ':', ';', '\'', '"', '&', '$', '#', '*', '(', ')', '|', '~', '`', '!', '{', '}', '%', '+', chr(0));
    $taglist = preg_replace("#\x{00a0}#siu", ' ', $taglist);
    $taglist = str_replace($special_chars, '', $taglist);
    $taglist = str_replace(array('%20', '+'), '-', $taglist);
    $taglist = preg_replace('/[\d]+/', '', $taglist);
    $taglist = preg_replace('/[\r\n     -]+/', '-', $taglist);
    $taglist = trim($taglist, ',-_');
    return $taglist;
}

function wp_aatags_keycontents($keys, $num) {
    $request = wp_remote_request('https://cws.9sep.org/extract/json', array('method' => 'POST', 'timeout' => 9, 'body' => array('text' => $keys, 'topk' => $num)));
    if (wp_remote_retrieve_response_code($request) != 200) {
        return 'rEr';
    } else {
        return wp_remote_retrieve_body($request);
    }
}

function wp_aatags_kwsiconv($kws) {
    return wp_aatags_sanitize(@json_decode($kws, true)['kws']);
}

// 文章自动标签
function wp_aatags_alts($post_ID, $post_title, $post_content) {
    $tags = get_tags(array('hide_empty' => false));
    $tagx = panda_pz('post_auto_tags_range'); // 标签处理范围
    $number = panda_pz('post_auto_tags_num'); // 自动标签数量
    echo $tagx;
    
    switch ($tagx) {
        case 3:
            $d = strtolower($post_title);
            break;
        case 2:
            $d = strtolower(wp_trim_words($post_content, 999, '') . ' ' . $post_title);
            break;
        default:
            $d = strtolower(wp_trim_words($post_content, 333, '') . ' ' . $post_title);
            break;
    }

    if ($tags) {
        $i = 0;
        foreach ($tags as $tag) {
            if (strpos($d, strtolower($tag->name)) !== false) {
                wp_set_post_tags($post_ID, $tag->name, true);
                $i++;
            }
            
            if ($i == $number) {
                break;
            }
        }
    }
}

function wp_aatags_run($post_ID) {
    $tags = panda_pz('post_auto_tags_range'); // 标签处理范围
    $number = panda_pz('post_auto_tags_num'); // 自动标签数量

    global $wpdb;

    if (get_post($post_ID)->post_type == 'post' && !wp_is_post_revision($post_ID) && !get_the_tags($post_ID)) {
        $post_title = get_post($post_ID)->post_title;
        $post_content = get_post($post_ID)->post_content;
        
        switch ($tags) {
            case 3:
                $requix = strtolower($post_title . ' ' . wp_trim_words($post_content, 333, ''));
                break;
            case 2:
                $requix = strtolower($post_title . ' ' . wp_trim_words($post_content, 999, ''));
                break;
            default:
                $requix = strtolower($post_title);
                break;
        }
        
        $body = wp_aatags_keycontents(wp_aatags_html2text($requix), $number);
        
        if ($body != 'rEr') {
            $keywords = wp_aatags_kwsiconv($body);
            wp_add_post_tags($post_ID, $keywords);
        } else {
            wp_aatags_alts($post_ID, $post_title, $post_content);
        }
    }
}
if (panda_pz('post_auto_tags', false))
{
    add_action('publish_post', 'wp_aatags_run');
    add_action('edit_post', 'wp_aatags_run');
}



//关注公众号可见
function panda_gzh(){if(panda_pz('post_auth_wx',false)){?>
    <style>
.post_hide_box, .secret-password{padding: 10px;overflow: hidden;clear: both;}
.post_hide_box .post-secret{font-size: 18px; line-height:20px; color:#e74c3c; margin:5px;}
.post_hide_box form{ margin:15px 0;}
.post_hide_box form span{ font-size:18px; font-weight:700;}
.post_hide_box .erweima{ margin-left:20px; margin-right:16px;}
.post_hide_box input[type=password]{ color: #9ba1a8; padding: 6px; background-color: #f6f6f6; border: 1px solid #e4e6e8; font-size: 12px;-moz-transition: border .25s linear,color .25s linear,background-color .25s linear; -webkit-transition: border .25s linear,color .25s linear,background-color .25s linear; -o-transition: border .25s linear,color .25s linear,background-color .25s linear; transition: border .25s linear,color .25s linear,background-color .25s linear;}
.post_hide_box input[type=submit] { background: #F88C00; border: none; border: 2px solid;border-color: #F88C00; border-left: none; border-top: none; padding: 0px;width: 100px; height: 38px; color: #fff; outline: 0;border-radius: 0 0 2px 0; font-size: 16px;}
.post_hide_box .details span{color:#e74c3c;}
.post_hide_box .details 
span{color:#e74c3c;}
.gzhhide{background:#fff;border-radius:10px;padding:20px;margin:15px 0;position:relative;box-shadow:0 0 20px #d0d0d0}
.gzhhide .gzhtitle{position:relative;font-size:17px;font-weight:700;color:#6c80a7;padding:6px 140px 0 40px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.gzhhide .gzhtitle .fa{position:absolute;left:0;font-size:35px;top:0}
.gzh-content{padding:20px 140px 15px 0;font-size:14px;color:#777}
.gzhbox{padding:0 140px 10px 0}
.gzhbox input{width:45%;border:none;color:#737373;font-size:13px;height:35px;line-height:35px;background:#f2f2f2;border-radius:4px;outline:none;float:left;padding:0 10px}
.gzhbox button{width:20%;margin-left:15%;border:none;background:#3b8cff;color:#fff;padding:5px 0;font-size:14px;border-radius:5px}
.gzhhide .gzhcode{position:absolute;width:140px;height:140px;right:20px;top:50%;margin-top:-50px}
#vivideo{height:200px}
.gzhhide .gzhtitle i {font-style:normal;}
.hidden-box.show {padding-top: 35px;}
.hidden-box {padding: 10px;margin: 20px 0;border: 1px dashed var(--focus-color);border-radius: var(--main-radius);position: relative;}
.hidden-box.show .hidden-text {padding: 3px 10px;font-size: 13px;top: 0;border-radius: 0 0 8px 0;line-height: 1.4;z-index: 1;left: 0;position: absolute;border-bottom: 1px dashed var(--focus-color);border-right: 1px dashed var(--focus-color);}
.hidden-text {color: var(--focus-color);padding: 10px;text-align: center;display: block;}
/*手机适配*/
@media (max-width: 520px){
.gzhhide .gzhtitle{padding:9px 0 0 30px;overflow:hidden;font-size:14px;}
.gzh-content{padding:0;font-size:12px;}
.gzhhide .gzhcode{width: 70px;height: 70px;top: 80%;}
.gzhbox{padding: 12px 90px 0 0;}
.gzhbox button{width: 40%;padding: 2px;}
.gzhbox input{height: 32px;}};
    </style>
<?php }}add_action('wp_head','panda_gzh');
if(panda_pz('post_auth_wx',false)){
    //WordPress文章部分内容关注微信公众号后可见
    function weixingzh_secret_content($atts, $content=null){
        extract(shortcode_atts(array('key'=>null,'keyword'=>null), $atts));
        if(isset($_POST['secret_key']) && $_POST['secret_key']==$key){
            return '<div class="hidden-box show"><div class="hidden-text">[输入密码后可见]隐藏内容</div><div class="secret-password">'.$content.'</div></div>';
        } else {
            return '
        <div class="gzhhide">
            <div class="gzhtitle">抱歉！隐藏内容，请输入密码后可见！<i class="fa fa-lock"></i><span></span></div>
                <div class="gzh-content">请打开微信扫描右边的二维码回复关键字“<span><b>'.$keyword.'</b></span>”获取密码，也可以微信直接搜索“<span style="font-weight: bold;color: '. panda_pz('post_auth_wx_color') .'">'. panda_pz('post_auth_wx_name') .'</span>”关注微信公众号获取密码。
                <div class="gzhcode" style="background: url('. panda_pz('post_auth_wx_img') .');background-size: 100%;" width="140" height="140" alt="'. panda_pz('post_auth_wx_name') .'"></div>
            </div>
        <div class="gzhbox"><form action="'.get_permalink().'" method="post">
        <input type="password" size="20" name="secret_key">
        <button type="submit">立即提取</button></form></div></div>';
        }
    }
    add_shortcode('weixingzh', 'weixingzh_secret_content');
// 后台文本编辑框中添加公众号隐藏简码按钮
    function wpsites_add_weixingzh_quicktags() {
        if (wp_script_is('quicktags')){
            ?>
            <script type="text/javascript">
                QTags.addButton( 'weixingzh', '公众号隐藏', '【weixingzh keyword="关键字" key="验证码"】隐藏内容【/weixingzh】',"" );//记得把【】改成[ ]
            </script>
            <?php
        }
    }
    add_action( 'admin_print_footer_scripts', 'wpsites_add_weixingzh_quicktags' );
}

function prefix_insert_post_ads($content){
	$pattern = "/<p>.*?<\/p>/";
	$paragraph_count = preg_match_all($pattern,$content); //计算文章的段落数量

	if(panda_pz('adsense_on') && $paragraph_count >= 8 && is_single()){ // 如果文章的段落数量少于8段，则不会插入文章段落广告
		$paragraph_count -=2;
		$insert_paragraph=rand(3,$paragraph_count);
		$ad_code = panda_pz('adsense_js');
		return prefix_insert_after_paragraph( $ad_code, $insert_paragraph, $content );
	}
	return $content;
}
add_filter( 'the_content', 'prefix_insert_post_ads' );
// 插入广告所需的功能代码
function prefix_insert_after_paragraph( $insertion, $paragraph_id, $content ) {
	$closing_p = '</p>';
	$paragraphs = explode( $closing_p, $content );

	foreach ($paragraphs as $index => $paragraph) {
		if ( trim( $paragraph ) ) {
		$paragraphs[$index] .= $closing_p;
		}
		if ( $paragraph_id == $index + 1 ) {
			$paragraphs[$index] .= $insertion;
		}
	}
	return implode( '', $paragraphs );
}

//专题&分类聚合卡片上移美化
if (panda_pz('card_list_up',false)) {
    function card_list_up(){ ?>
        <style>
            .term-aggregation {margin-top: 20px;}
           .term-aggregation .term-img {width: 18.5em;}
.clearfix .graphic{margin-top: -40px;}
@media screen and (min-width:1024px) and  (max-width: 1240px) {
  .term-aggregation .term-img {width: 19.8em;}
  .em14 {display: none !important;}
  .text-ellipsis-2 {display: none !important;}}
@media screen and (min-width:768px) and (max-width:1023px) {
  .term-aggregation .term-img {width: 14em;}
  .em14 {display: none !important;}
  .text-ellipsis-2 {display: none !important;}}
        </style>
    <?php }
add_action('wp_footer', 'card_list_up');
}

//置顶文章加入到显示文章数量内
if (panda_pz('index_sticky_post',false)) {
    function modify_pre_get_posts($query) {
        if ($query->is_home() && $query->is_main_query()) {
                $sticky_posts = get_option('sticky_posts');
                $sticky_count = count($sticky_posts);
                $posts_per_page = get_option('posts_per_page');
                if (!$query->is_paged()) {
                    if ($sticky_count > 0) {
                        $query->set('posts_per_page', $posts_per_page - $sticky_count);
                    }
                } else {
                    if (!empty($sticky_posts)) {
                        $query->set('post__not_in', $sticky_posts);
                        $offset = ( $query->query_vars['paged'] - 1 ) * $posts_per_page - count($sticky_posts);
                        $query->set('offset', $offset);
                    }
            }
        }   
    }
    add_action('pre_get_posts', 'modify_pre_get_posts');
    function adjust_pagination() {
        if (is_home()) {
            global $wp_query;
            $sticky_posts = get_option('sticky_posts');
            $sticky_count = count($sticky_posts);
            $posts_per_page = get_option('posts_per_page');
            
            // 获取非置顶文章总数
            $args = array(
                'post_type' => 'post',
                'post_status' => 'publish',
                'post__not_in' => $sticky_posts,
                'fields' => 'ids',
                'posts_per_page' => -1,
                'no_found_rows' => true,
            );
            $non_sticky_query = new WP_Query($args);
            $non_sticky_count = $non_sticky_query->post_count;
            
            // 第1页显示的普通文章数
            $first_page_posts = $posts_per_page - $sticky_count;
            
            // 剩余普通文章数
            $remaining_posts = $non_sticky_count - $first_page_posts;
            
            // 计算总页数：第1页 + 剩余页数
            if ($remaining_posts > 0) {
                $total_pages = 1 + ceil($remaining_posts / $posts_per_page);
            } else {
                $total_pages = 1;
            }
            
            $wp_query->max_num_pages = $total_pages;
        }
    }
    add_action('wp', 'adjust_pagination');

}

function count_content_characters($content) {
    $content = wp_strip_all_tags($content); // 去除 HTML 标签
    return mb_strlen($content, 'UTF-8');    // 统计 UTF-8 字符数
}

// 文章页顶部样式
if (panda_pz('post_top_style',false)) {
    function post_top_style(){
        if (is_singular('post')){
            $post = get_post();
            $posts_id = $post->ID;
            $content = get_the_content();
            $word_count = count_content_characters($content);
            $read_time = ceil($word_count / 200);
            $views = _cut_count((string) get_post_meta($posts_id, 'views', true));
            $tags = get_the_tags($post->ID);
            $tags_html = '';
            $count = 5;
            if (!empty($tags[0])) {
                $ii     = 0;
                $tags_s = arraySort($tags, 'count');
                if (!empty($tags_s[0])) {
                    foreach ($tags_s as $tag_id) {
                        $ii++;
                        $url = get_tag_link($tag_id);
                        $tag = get_tag($tag_id);
                        $tags_html .= '<span class="tag"><a href="' . $url . ' " target="_blank">'. $tag->name .'</a></span>';
                        if ($count && $count == $ii) {
                            break;
                        }
                    }
                }
            }               
            $categories = get_the_category();
            $category_html = "";
            if (!empty($categories)) {
                $category = $categories[0];
                $category_html = '<span class="category">'. esc_html($category->name). "</span> ";
            }
            $post_top_style1 = panda_pz('post_top_style1');
            $post_top_style2 = panda_pz('post_top_style2');
            $post_top_style3 = panda_pz('post_top_style3');

            $post_top_style = panda_pz('post_top_style');
            switch ($post_top_style) {
                case 1:
                    ?>
                        <style>
                        :root{
                            --head_bg_color: <?php echo $post_top_style1['bg_color']; ?>;
                        }
                        </style>
                        <link rel="stylesheet" href="<?php echo panda_pz("static_panda");?>/assets/css/post/post_head.css">
                        <div class="post-header-7e7 b post-header">
                            <div class="group-singular-bg b bg_1">
                                <div class="b-wrap">
                                    <i class="img">
                                    <?php 
                                        $lazy_attr = zib_is_lazy('lazy_other', true) ? 'class="fit-cover lazyload" src="' . zib_get_lazy_thumb() . '" data-' : 'class="fit-cover"';

                                        $video_pic      = !empty($pay_mate['video_pic']) ? '<img ' . $lazy_attr . 'src="' . esc_attr($pay_mate['video_pic']) . '" alt="付费视频-' . esc_attr($pay_title) . '">' : zib_post_thumbnail();
                                        $post_thumbnail = $video_pic;
                                        $post_thumbnail .= '<div class="absolute graphic-mask" style="opacity: 0.2;"></div>';
                                        $post_thumbnail .= '<div class="abs-center text-center"><i class="fa fa-play-circle-o fa-4x opacity8" aria-hidden="true"></i></div>';
                                        $post_thumbnail = zib_post_thumbnail();
                                        echo $post_thumbnail;
                                    ?>
                                    </i></div>
                            </div>
                            <div class="container">
                                <h1 class="post-title"><?php echo get_the_title();?></h1>
                                <h4 class="post-meta">
                                    <span class="meta-item meta-date"><i class="fa fa-calendar-o"></i> <?php echo get_the_date();?></span>
                                    <span class="meta-item meta-author"><i class="fa fa-user"></i> 作者： <?php echo get_the_author();?></span>
                                    <span class="meta-item meta-views"><i class="fa fa-eye"></i> 阅读 <?php echo get_post_view_count('', '');?></span>
                                    <span class="meta-item meta-word"><i class="fa fa-file-text-o"></i> 本文共计 <?php echo $word_count;?> 个字</span>
                                    <span class="meta-item meta-read"> <i class="fa fa-clock-o"></i> 阅读本文需 <?php echo $read_time;?> 分钟 </span>
                                </h4>
                                <div class="post-tags">
                                    <div class="tags-content">
                                        <div class="tags-items items">
                                            <?php 
                                                $tags = get_the_tags($post->ID);
                                                $html = '';
                                                if (!empty($tags[0])) {
                                                    $ii     = 0;
                                                    $tags_s = arraySort($tags, 'count');
                                                    if (!empty($tags_s[0])) {
                                                        foreach ($tags_s as $tag_id) {
                                                            $ii++;
                                                            $url = get_tag_link($tag_id);
                                                            $tag = get_tag($tag_id);
                                                            $html .= '<div class="item"><a class="tag item-wrap" href="' . $url . ' " target="_blank"># '. $tag->name .'</a></div>';
                                                            if ($count && $count == $ii) {
                                                                break;
                                                            }
                                                        }
                                                    }
                                                }
                                            echo $html;
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    break;
                case 2:
                    ?>
                        <style>
                            :root{
                                --head_bg_color: <?php echo $post_top_style2['bg_color']; ?>;
                            }
                        </style>
                        <link rel="stylesheet" href="<?php echo panda_pz('static_panda');?>/assets/css/post/post_head2.css">
                        <div class="panda_head_box">
                            <div class="panda-tags-container">
                                <div class="mulu_one_two"><?php echo $category_html;?></div>
                                <div class="tags"><?php echo $tags_html;?></div>
                            </div>
                            <h1 class="panda-head_info_post_title"><?php echo get_the_title();?></h1>
                            <div class="panda_footer_meta">
                                <span class="meta-item meta-date"><i class="fa fa-calendar-o"></i> <?php echo get_the_date();?></span>
                                <span class="meta-item meta-author"><i class="fa fa-user"></i> 作者： <?php echo get_the_author();?></span>
                                <span class="meta-item meta-views"><i class="fa fa-eye"></i> 阅读 <?php echo get_post_view_count('', '');?></span>
                                <span class="meta-item meta-word"><i class="fa fa-file-text-o"></i> 本文共计 <?php echo $word_count;?> 个字</span>
                                <span class="meta-item meta-read"> <i class="fa fa-clock-o"></i> 阅读本文需 <?php echo $read_time;?> 分钟 </span>
                            </div>
                            <div class="panda_waves"><svg class="panda_waves" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28" preserveAspectRatio="none"
                                    shape-rendering="auto">
                                    <defs>
                                        <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z">
                                        </path>
                                    </defs>
                                    <g class="parallax">
                                        <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(255,255,255,0.7)"></use>
                                        <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(255,255,255,0.5)"></use>
                                        <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(255,255,255,0.3)"></use>
                                        <use xlink:href="#gentle-wave" x="48" y="7" fill="rgb(245, 246, 247)"></use>
                                    </g>
                                </svg>
                            </div>
                        </div>
                    <?php
                    break;
                case 3:
                    ?>
                    <style>
                        :root{
                            --head_bg_color: <?php echo $post_top_style3['bg_color']; ?>;
                        }
                    </style>
                    <link rel="stylesheet" href="<?php echo panda_pz('static_panda');?>/assets/css/post/post_head3.css">
                    <div class="panda_head_box">
                        <div class="panda-tags-container">
                            <div class="mulu_one_two"><?php echo $category_html;?></div>
                            <div class="tags"><?php echo $tags_html;?></div>
                        </div>
                        <h1 class="panda-head_info_post_title"><?php echo get_the_title();?></h1>
                        <div class="panda_footer_meta">
                            <span class="meta-item meta-date"><i class="fa fa-calendar-o"></i> <?php echo get_the_date();?></span>
                            <span class="meta-item meta-author"><i class="fa fa-user"></i> 作者： <?php echo get_the_author();?></span>
                            <span class="meta-item meta-views"><i class="fa fa-eye"></i> 阅读 <?php echo get_post_view_count('', '');?></span>
                            <span class="meta-item meta-word"><i class="fa fa-file-text-o"></i> 本文共计 <?php echo $word_count;?> 个字</span>
                            <span class="meta-item meta-read"> <i class="fa fa-clock-o"></i> 阅读本文需 <?php echo $read_time;?> 分钟 </span>
                        </div>
                    </div>
                    <?php
                    break;
            }
            if(panda_pz('post_top_title')){
                echo '<style>.article-header .article-title{display:none;}</style>';
            }
        }
    }
    if(!wp_is_mobile()){
        add_action('wp_head', 'post_top_style');
    }
    if(wp_is_mobile() && !panda_pz('post_top_mobile',false)){
        add_action('wp_head', 'post_top_style');
    }
}

if(panda_pz('index_barrage_comment')&& !wp_is_mobile()){
    // 注册自定义 REST API 接口
function register_hot_comments_endpoint() {
    register_rest_route('myapi/v1', '/hot-comments', array(
        'methods' => 'GET',
        'callback' => 'get_hot_comments',
    ));
  }
  
  add_action('rest_api_init', 'register_hot_comments_endpoint');
  function get_hot_comments() {
    $args = array(
        'numberposts' => 10,       // 获取随机 10 篇文章
        'post_status' => 'publish',
        'orderby'     => 'rand', 
    );
    $posts = get_posts($args);
    $data = [];
  
    if (empty($posts)) {
        return new WP_REST_Response([], 200);
    }
    foreach ($posts as $post) {
        $comments = get_comments(array(
            'post_id' => $post->ID,
            'status'  => 'approve',
            'orderby' => 'comment_date_gmt',
        ));
        if (!empty($comments)) {
            $data[] = [
                'id'       => $post->ID,
                'title'    => get_the_title($post->ID),
                'comments' => array_map(function ($comment) {
                    return [
                        'author'  => $comment->comment_author,
                        'content' => $comment->comment_content, 
                    ];
                }, $comments),
            ];
        }
    }
  
    return new WP_REST_Response($data, 200);
  }
  
  // 弹幕评论
  function zib_comments_danmu(){
    ?>
  <div id="panda-com-danmu-popup-window" class="panda-com-danmu-show-popup-window">
  <div class="panda-com-danmu-popup-header">
    <span class="panda-com-danmu-popup-title">热评</span>
    <span class="panda-com-danmu-popup-author"></span>
  </div>
  <div class="panda-com-danmu-popup-window-divider"></div>
  <div class="panda-com-danmu-popup-window-content">
    <div class="panda-com-danmu-popup-tip">加载中...</div>
  </div>
  </div>
  
  <style>
  #panda-com-danmu-popup-window{min-width:300px;max-width:500px;bottom:20px;right:20px;position:fixed;z-index:1002;color:#363636;padding:8px 16px;border-radius:12px;transition:opacity 0.3s ease,transform 0.3s ease;background-color:rgba(255,255,255,0.85);border:1px solid #e3e8f7;max-height:300px;opacity:0;transform:translateY(20px);display:flex;flex-direction:column;justify-content:flex-start;}
  #panda-com-danmu-popup-window.panda-com-danmu-show{opacity:1;transform:translateY(0);}
  .panda-com-danmu-popup-window.show{opacity:1;transform:translateY(0);display:block;}
  .panda-com-danmu-popup-header{display:flex;align-items:center;margin-bottom:8px;}
  .panda-com-danmu-popup-title{font-size:14px;font-weight:bold;background:#363636;color:#fff;padding:4px 8px;border-radius:4px;margin-right:8px;}
  .panda-com-danmu-popup-author{font-size:14px;font-weight:600;color:#363636;}
  .panda-com-danmu-popup-window-divider{width:100%;height:1px;background:#e3e8f7;margin:5px 0;}
  .panda-com-danmu-popup-window-content{font-size:15px;word-wrap:break-word;max-width:450px;white-space:normal;text-overflow:ellipsis;}
  .panda-com-danmu-popup-window-content p{margin:0;padding:0;line-height:1.5;}
  </style>
  
  <script>
    let popupTimer;
    let posts = [];
    let commentsCache = {};
  
    async function fetchPopupContent() {
      await loadPosts();
      showNextPostComment();
    }
  
    async function loadPosts() {
      try {
        const response = await fetch("../wp-json/myapi/v1/hot-comments");
        const postList = await response.json();
  
        if (Array.isArray(postList) && postList.length > 0) {
          posts = postList;
        } else {
          posts = [];
        }
      } catch (error) {
        showError("加载热评文章列表失败，请稍后再试。");
      }
    }
  
    async function showNextPostComment() {
      if (posts.length === 0) {
        await fetchPopupContent();
        return;
      }
  
      const randomPostIndex = Math.floor(Math.random() * posts.length);
      const post = posts[randomPostIndex];
  
      if (!post || !Array.isArray(post.comments) || post.comments.length === 0) {
        await fetchPopupContent();
        return;
      }
  
      if (commentsCache[post.id]) {
        displayComment(post.id, commentsCache[post.id]);
      } else {
        commentsCache[post.id] = post.comments;
        displayComment(post.id, post.comments);
      }
    }
  
    function displayComment(postId, comments) {
      const randomComment = comments[Math.floor(Math.random() * comments.length)];
      let commentContent = randomComment.content.trim();
      commentContent = replaceEmojis(commentContent);
  
      if (commentContent) {
        const popup = document.getElementById("panda-com-danmu-popup-window");
        popup.classList.remove("panda-com-danmu-show");
        clearTimeout(popupTimer);
  
        setTimeout(() => {
          document.querySelector(".panda-com-danmu-popup-author").innerText = `${randomComment.author}`;
          document.querySelector(".panda-com-danmu-popup-window-content").innerHTML = `<p>${commentContent}</p>`;
          popup.classList.add("panda-com-danmu-show");
  
          popupTimer = setTimeout(() => {
            popup.classList.remove("panda-com-danmu-show");
            fetchPopupContent();
          }, 5000);
        }, 300);
      } else {
        showError("该帖子没有评论内容。");
      }
    }
  
    function replaceEmojis(commentContent) {
      const imgUrlPrefix = "../wp-content/themes/zibll/img/smilies/";
      const regex = /\[g=(.*?)\]/g;
      return commentContent.replace(regex, (match, p1) => {
        return `<img style="display:inline" src="${imgUrlPrefix}${p1}.gif" alt="${p1}" width="20" height="20" />`;
      });
    }
  
    function showError(message) {
      document.querySelector(".panda-com-danmu-popup-window-content").innerHTML = `<p>${message}</p>`;
      document.getElementById("panda-com-danmu-popup-window").classList.add("panda-com-danmu-show");
    }
  
    fetchPopupContent();
  </script>
    <?php
  }add_action('wp_footer','zib_comments_danmu');
}

if(panda_pz('index_post_hover_border_style')){
    function post_hover_border_style(){
        ?>
        <style>
            .card{box-shadow:0.3em 0.3em 0.7em #00000015;border:rgba(0,0,0,.05) 0.2em solid;}
            .card:hover{border:#006fff 0.2em solid;transition:border 1s;}
        </style>
        <?php
    }add_action('wp_footer','post_hover_border_style');
}

if(panda_pz('index_login_modal')){
    function zibll_enqueue_styles() {
        wp_enqueue_style('bottom_login_styles', panda_pz('static_panda') . '/assets/css/login.css');
    }
    add_action('wp_enqueue_scripts', 'zibll_enqueue_styles'); 

    function zibll_Add_ons_footer_sidebar_display() {
        if (is_user_logged_in()) {
            return; 
        }

        $sidebar_html = '
        <div class="wapnone">
        <div class="footSideBar footNoSideBar" style="" data-v-468191f6="">
            <div class="left_warp">
                <p class="left_word">一键注册登录，免费下载更多的资源教程</p>
                <ul class="login_ad_list">
                    '.panda_pz('index_login_modal_content').'
                </ul>
            </div>
            <div class="login-button signin-loader">
                <div class="login-button_wrapper">
                    <span>立即登录</span>
                    <div class="circle circle-1"></div>
                    <div class="circle circle-2"></div>
                    <div class="circle circle-3"></div>
                    <div class="circle circle-4"></div>
                    <div class="circle circle-5"></div>
                    <div class="circle circle-6"></div>
                    <div class="circle circle-7"></div>
                    <div class="circle circle-8"></div>
                    <div class="circle circle-9"></div>
                    <div class="circle circle-10"></div>
                    <div class="circle circle-11"></div>
                    <div class="circle circle-12"></div>
                </div>
            </div>
        </div>
    </div>
        ';

        echo $sidebar_html; 
    }
    add_action('wp_footer', 'zibll_Add_ons_footer_sidebar_display');
}


/*文章开头大于50浏览量出现热帖图片*/
if(panda_pz('post_hot_img')){
    add_filter('the_content', 'add_lu_content_beforde');
    function add_lu_content_beforde( $content ) {
    if( !is_feed() && !is_home() && is_singular() && is_main_query() ) {
    $viewnum= (int) get_post_meta( get_the_ID(), 'views', true );
        if ($viewnum > panda_pz('post_hot_img_num')){  //这里是浏览量大于50
            $before_content = '<img style="position: absolute; right: 400px; top:0px;  pointer-events: none; z-index: 10;" src="'.panda_pz('post_hot_img_url').'" alt="热帖" >'; //图片地址修改成自己的
        $lu = $before_content . $content;
            }
    else{$lu = $content;}}
    return $lu;
    }
}