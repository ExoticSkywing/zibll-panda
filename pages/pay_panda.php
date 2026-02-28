<?php

 /**
 * Template name: Panda子主题-子主题推荐
 * Description:   tj
 */
// 预加载所需样式，确保在 <head> 输出
add_action('wp_enqueue_scripts', function(){
    $static_panda_url = panda_pz('static_panda');
    wp_enqueue_style('pay_page-css', $static_panda_url . '/assets/css/pay-zibll.css');
});
get_header();
function get_pay_zibll_random_bg() {
    $colors = [
        '--linear-bg-1',
        '--linear-bg-2',
        '--linear-bg-3',
        '--linear-bg-4',
        '--linear-bg-5',
        '--linear-bg-6',
        '--linear-bg-7',
        '--linear-bg-8',
        '--linear-bg-9',
        '--linear-bg-10',
    ];

    $randomIndex = array_rand($colors);
    return $colors[$randomIndex];
}
?>
<link rel='dns-prefetch' href='//s.w.org' rel="nofollow" />
<main role="main">
<?php if (panda_pz('pay_panda_price')){?>
<div class="countdown-activity flex jc" style="margin-top:-20px">
<div class="activity-content flex ac" style="margin-bottom: 20px;">
<div class="activity-title mr10"><?php echo panda_pz('pay_panda_title');?></div>
<div class="activity-desc"><?php echo panda_pz('pay_panda_desc');?></div></div>
<div class="countdown-content badg jb-yellow radius flex jc" style="margin-bottom: 20px;">
<div class="countdown-desc">活动倒计时</div>
<div class="countdown-time flex0 em09-sm badg jb-vip2 radius" data-over-text="活动已结束" data-countdown="<?php echo panda_pz('panda_time');?>">X天X小时X分X秒</div></div></div><!--活动时间修改-->
<?php } ?>

<div class="product-container" style="opacity: 0;">
<div class="product-box relative">
<div class="product-background absolute" style="background:var(<?php echo get_pay_zibll_random_bg(); ?>);"></div>
<div class="product-row relative">
<div class="payrow-6 payrow-left">
<div class="relative zib-slider">
<div class="new-swiper swiper-c pay-slides"  data-effect="slide" data-loop="true" data-interval=" data-autoplay="1"" data-spaceBetween="15" style="">
<div class="swiper-wrapper">
<div class="swiper-slide "><span>
<!--轮播图开始-->
<img class="lazyload swiper-lazy radius8"  data-src="<?php echo panda_pz('static_panda');?>/assets/img/screenshot.png"
src="<?php echo panda_pz('static_panda');?>/assets/img/pay_zibll/kongbai.svg"></span></div><div class="swiper-slide "><span>
<img class="lazyload swiper-lazy radius8"  data-src="<?php echo panda_pz('static_panda');?>/assets/img/screenshot.png"
src="<?php echo panda_pz('static_panda');?>/assets/img/pay_zibll/kongbai.svg"></span></div><div class="swiper-slide "><span>
<img class="lazyload swiper-lazy radius8"  data-src="<?php echo panda_pz('static_panda');?>/assets/img/screenshot.png"
src="<?php echo panda_pz('static_panda');?>/assets/img/pay_zibll/kongbai.svg"></span></div><div class="swiper-slide "><span>
<img class="lazyload swiper-lazy radius8"  data-src="<?php echo panda_pz('static_panda');?>/assets/img/screenshot.png"
src="<?php echo panda_pz('static_panda');?>/assets/img/pay_zibll/kongbai.svg"></span></div></div>
<!--轮播图结束-->
<div class="swiper-button-prev"></div>
<div class="swiper-button-next"></div>
<div class="swiper-pagination kaoyou"></div></div></div>
<?php if(panda_pz('pay_panda_button')){ ?>
<div class="more-but text-center">
    <a class="but hollow c-white" href="<?php echo panda_pz('pay_panda_bubtton_url1');?>" rel="nofollow" target="_blank"><?php echo panda_pz('pay_panda_bubtton_text1');?></a>
    <a class="but hollow c-white" href="<?php echo panda_pz('pay_panda_bubtton_url2');?>" rel="nofollow" target="_blank"><?php echo panda_pz('pay_panda_bubtton_text2');?></a>
<!--能运行就不要动-->
</div>
<?php } ?>
</div><div class="payrow-6 payrow-right"><div class="pay-content"><div class="product-header">Panda子主题</div>
<!--能运行就不要动-->
<div class="product-doc">
    <div>简约优雅的设计风格、模块化组件、商城支付系统<br>社区论坛系统、深度SEO优化、专注阅读体验</div>
<div class="mt6">
    <a target="_blank" href="<?php echo panda_pz('panda_link');?>" class="but c-white font-bold px12 p2-10">赠送官网推广会员，享20%推荐奖励
    <i class="ml6 fa fa-angle-right em12"></i></a>
</div></div>
<div class="px13"><b class="em3x"><span class="pay-mark">￥</span><?php echo panda_pz('panda_pay');?></b><!--现价修改-->
<div class="inline-block ml10 text-left">
<badge><i class="fa fa-fw fa-bolt"></i>限时特惠</badge><br/>
<span class="original-price"><span class="pay-mark">￥</span><?php echo panda_pz('panda_code');?></span></div></div><!--原价修改-->
<div class="badg badg-lg payvip-icon"><?php echo panda_pz('panda_desc_vip');?></div>
<div class="product-pay">
<a href="<?php echo panda_pz('panda_link');?>" rel="nofollow"  class="but jb-red signin-loader" target="—_blank">
    <i class="fa fa-angle-right" aria-hidden="true"></i>立即购买</a>
<a href="<?php echo panda_pz('panda_aut');?>" class="but jb-red signin-loader" target="—_blank">
    <i class="fa fa-angle-right" aria-hidden="true"></i>联系客服</a>
</div></form>
<div class="relative product-details box-body radius8">
<?php echo panda_pz('panda_details');?>

</div></div></div></div></div></div>

<!--表头样式代码开始-->
<style>
.shop-single-z-btn .shouquan_guanli_anniu{
display: block;
text-align: center;
border-radius: 4px;
background-image: linear-gradient(300deg,#4c4d51 5%,#2a2a31 15%,#85858a 40%,#393a3c 60%,#393838 80%,#5e5f62 100%);
color: #fff;
}
.countdown-activity{background:linear-gradient(135deg, #f411ff 10%, #14d4df 100%);}
.jb-yellow, .order-type-3 .pay-tag{--this-bg:linear-gradient(135deg, #ff554f 10%, #facf28 100%);}
@media screen and (min-width: 900px){
    .shop-single-z-btn .shouquan_guanli_anniu{
        font-size: 16px;
        height: 50px;
        line-height: 50px;
    }
}
@media screen and (max-width: 900px){
    .shop-single-z-btn .shouquan_guanli_anniu{
        font-size: 15px;
        line-height: 40px;
    }
}
</style>
<!--表头样式代码结束-->

<div class="container">
<div class="theme-box article-content">
<article class="article wp-posts-content">

<?php the_content(  ); ?>
<?php comments_template('/template/comments.php', true); ?>
</div></div>
</main>
<?php
get_footer();