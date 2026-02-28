<?php

/**
 * Template name: Panda子主题-资源下载
 * Description:   Panda子主题-资源下载
 */

if (empty($_GET['post'])) {
  get_header();
  get_template_part('template/content-404');
  get_footer();
  exit;
}
get_header();
$post_id = $_GET['post'];

function zibpay_get_down_html($post_id)
{
  $pay_mate = get_post_meta($post_id, 'posts_zibpay', true);
  $html = '';
  if (empty($pay_mate['pay_type']) || empty($pay_mate['pay_type']) || $pay_mate['pay_type'] != '2') {
    return get_template_part('template/content-404');
  };
  
  //文章略缩图
  $thumbnail = zib_post_thumbnail('full', '', true, $post_id);
  
  // 查询是否已经购买
  $paid_obj = zibpay_is_paid($post_id);
  $posts_title = get_the_title($post_id) . get_post_meta($post_id, 'subtitle', true);
  $pay_title = !empty($pay_mate['pay_title']) ? $pay_mate['pay_title'] : $posts_title;
  $pay_doc = $pay_mate['pay_doc'];
  $pay_details = $pay_mate['pay_details'];
  $user_qx = zibpay_get_post_down_buts($pay_mate, $paid_obj['paid_type'], $post_id);
  if ($paid_obj) {
    //已经购买直接显示下载盒子

    $paid_name = zibpay_get_paid_type_name($paid_obj['paid_type']);
    $paid_name2 = '<badge class="img-badge left jb-red" style="z-index: 2;font-size: 12px;padding: 2px 10px;line-height: 1.4;" img-badge="" left=""><i class="fa fa-check mr6" aria-hidden="true"></i>' . $paid_name . '</badge>';
    if($paid_name =='推广会员免费'||$paid_name =='代理会员免费'){
        $dowmbox = '<div style="/*margin-bottom:3em;*/">' . $user_qx . '</div>';
    }else{
        $dowmbox = '<div style="/*margin-bottom:3em;*/"><span class="badg c-red btn-block">免费资源不占用会员的免费下载次数</span>' . $user_qx . '</div>';
    }
    $pay_extra_hide = !empty($pay_mate['pay_extra_hide']) ? '<div class="pay-extra-hide">' . $pay_mate['pay_extra_hide'] . '</div>' : '';
    
    if ($paid_obj['paid_type'] == 'free' && _pz('pay_free_logged_show') && !is_user_logged_in()) {
      $dowmbox = '<div class="alert jb-yellow em12" style="margin: 2em 0;"><b>免费资源，请登录后下载</b></div>';
      $pay_extra_hide = '<div class="text-center pay-extra-hide">';
      $pay_extra_hide .= '<p class="box-body muted-2-color">请先登录！</p>';
      $pay_extra_hide .= '<p>';
      $pay_extra_hide .= '<a href="javascript:;" class="signin-loader but jb-blue padding-lg"><i class="fa fa-fw fa-sign-in mr10" aria-hidden="true"></i>登录</a>';
      $pay_extra_hide .= '<a href="javascript:;" class="signup-loader ml10 but jb-yellow padding-lg"><i data-class="icon mr10" data-viewbox="0 0 1024 1024" data-svg="signup" aria-hidden="true"></i>注册</a>';
      $pay_extra_hide .= '</p>';
      $pay_extra_hide .= zib_social_login(false);
      $pay_extra_hide .= '</div>';
    }
    
    $html = '<div class="download-demo">';
    $html .= '<div class="download-xiyang"><div class="download-right">';
    /*获取文章略缩图*/
    $html .= '<div class="download-sty item-thumbnail">' . $paid_name2 . '<img src="'.$thumbnail.'" /></div>';
    
    $html .= '<span class="display">' . $paid_name2 . '</span><div class="article-header download-theme-box"><div class="article-title" style="margin-top: 0;"><span class="download-file-name"></span><a href="' . get_permalink($post_id) . '#posts-pay">' . $pay_title . '</a></div></div>';

    $html .= '<div>' . $pay_doc . '</div>';
    $html .= '<div class="muted-2-color em09">' . $pay_details . '</div>';

    $html .= '<div>' . $dowmbox . $pay_extra_hide . '</div></div>';
    $html .= '</div></div>';
    
  } else {
    //未购买
    $html = '<div class="article-header theme-box"><div class="article-title"><a href="' . get_permalink($post_id) . '#posts-pay">' . $pay_title . '</a></div></div>';

    $html .= '<div>' . $pay_doc . '</div>';
    $html .= '<div class="muted-2-color em09" style="margin: 2em 0;">' . $pay_details . '</div>';
    $html .= '<div class="alert jb-red em12" style="margin: 2em 0;"><b>暂无下载权限</b></div>';
    $html .= '<a style="margin-bottom: 2em;" href="' . get_permalink($post_id) . '#posts-pay" class="but jb-yellow padding-lg"><i class="fa fa-long-arrow-left" aria-hidden="true"></i><span class="ml10">返回文章</span></a>';
  }

  return $html;
}

?>
<style>
.mb10{display:none;}
.but-download>.but,.but-download>span{min-width: 200px;padding: .5em;margin-top: 10px;}.pay-extra-hide{background: var(--muted-border-color);display: block;margin: 10px;padding: 20px;color: var(--muted-color);border-radius: 4px;}
/*下载样式*/

.but-download{display: table-cell;}.download-article{margin-bottom: 40px !important;padding: 0 10px;width: 100%;margin: 0 auto;}
.download-demo{margin: 10px 0;}.download-xiyang{padding: 0 0 20px;display: flex;justify-content: center;align-items: center;}
.download-sty{text-align: center;height: 260px;border-radius: 8px;position: relative;}@media (max-width:530px){.but-download {display: block;}
.but-download>.but, .but-download>span{min-width: 100% !important;}}@media (max-width:700px){.download-sty{display: none;}.download-right{padding: 10px !important;height: 100% !important;width: 100%;}.download-theme-box{margin-top: 24px;}}@media (min-width:700px){.display{display: none;}}@media (min-width: 1100px){.download-article{width:100%;}}@media (max-width: 950px){.download-notice{display: flex;}.head h2{font-size: 30px !important;}}.download-sty img{position: relative; }.download-theme-box{margin:10px 0 20px 0;text-align: center;}.download-right{margin-left: 6px;border: 1px solid #f04494;padding: 24px;border-radius: 8px;position: relative;}.download-file-name{font-size: 20px;}
.but-download>.but,.but-download>span{min-width: 130px;padding: .5em;margin-top: 10px;}.pay-extra-hide{background: var(--muted-border-color);display: block;margin: 10px;padding: 20px;color: var(--muted-color);border-radius: 4px;}
.panel{margin-bottom: 10px; background-color: #fff; border: 1px solid var(--theme-color); border-radius: 4px; -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.05); box-shadow: 0 1px 1px rgba(0,0,0,.05);}
.panel-heading{padding: 10px 15px;border-top-left-radius: 3px;border-top-right-radius: 3px;color: #fff;background-color: var(--focus-color);}/*边框部分颜色*/
.panel-heading h3{margin-top: 0;margin-bottom: 0;font-size: 14px;color: #0000FF;font-family: inherit;font-weight: 500;line-height: 1.1;}
.panel-body .shengming{line-height:25px;font-size:14px;color:#C33;}
.head{height: 80px;letter-spacing: 8px;color: #fff;background: url(//21lhz.cn/cdn/dl_head.png) center no-repeat;text-align: center;border-radius: 10px 10px 0 0;position: relative;top: -20px;margin: -10px;margin-bottom: 20px;}
.head h2{line-height: 90px;font-size: 40px;}
.download-notice {padding: 24px;border-top: 1px solid #e5e5e5;position: relative;margin: 0px -10px;border-radius: 0 0 8px 8px;}
.download-notice-title {width: 190px;height: 100px;margin-right: 18px;margin-top: 4px;padding-top: 32px;border-right: 1px solid #ccc;text-align: center;font-size: 28px;color: #999;font-family: microsoft yahei;font-weight: 700;}
.download-notice-ico {width: 36px;height: 29px;background-position: 0 -372px;}
.ico {background-image: url(//21lhz.cn/cdn/ico_png24.png);background-repeat: no-repeat;}
.fl {float: left;display: inline;}.red1 {color: #eb0064;font-size: 14px;}.mb5 {margin-right: 5px;margin-bottom: 5px;}.vertical-middle {vertical-align: middle;}.download-notice-detail p {font: 13px/1.25 "microsoft yahei",simsun,arial;}
.popTipBox {padding: 5px 10px;text-indent: 2em;border: 1px solid #ffd8c0;background-color: #fff9f3;font-size: 13px;color: #e10074;line-height: 22px;}
.but-download a{margin-left: 10px;margin-right: 4px;}
</style>
<main class="container">
  <div class="content-wrap">
    <div class="content-layout">
      <?php while (have_posts()) : the_post(); ?>
        <?php echo zib_get_page_header(); ?>

        <div class="zib-widget article download-article">
          <?php
          echo zibpay_get_down_html($post_id);
          $page_links_content_s = get_post_meta(get_queried_object_id(), 'page_show_content', true);
          if ($page_links_content_s) {
            the_content();
            wp_link_pages(
              array(
                'before'           => '<p class="text-center post-nav-links radius8 padding-6">',
                'after'            => '</p>',
              )
            );
            echo '</div>';
          }
          ?>
        <!--开始-->
       
        <dl class="download-notice clearfix zib-widget">
            <dt class="fl download-notice-title"><span class="inline-block vertical-middle mr5 mb5 download-notice-ico ico"></span>注意事项</dt>
            <dd class="download-notice-detail">
                <p><b class="red1"><p style="text-align:center" id="tf_lgz">本站大部分下载资源收集于网络，只做学习和交流使用，版权归原作者所有。</p></b></p>
                <p>若为付费资源，请在下载后24小时之内自觉删除，若作商业用途，请到原网站购买，由于未及时购买和付费发生的侵权行为，与本站无关。</p>
                <p>本站发布的内容若侵犯到您的权益，请联系<b>本站</b>删除，我们将及时处理！</p>
                <p><b>如下载有问题请重新下载，文件自下载之日起，可免费重复下载。若文件有问题，请及时联系<b>本站</b>处理。</b></p>
            </dd>
        </dl>
          <?php  the_content(); ?>
        <?php endwhile; ?>
        </div>
        <?php comments_template('/template/comments.php', true); ?>
    </div>
  </div>
  <?php get_sidebar(); ?>
</main>

<?php get_footer(); ?>