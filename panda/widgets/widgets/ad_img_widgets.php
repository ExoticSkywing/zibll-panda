<?php
Panda_CFSwidget::create('widget_ad_img', array(
  'title'       => 'ad-图片轮播',
  'zib_title'   => true,
  'zib_affix'   => false,
  'zib_show'    => false,
  'description' => '显示特定分类目录下的文章，可设置两行布局',
  'fields'      => array(
    array(
      'title'   => '广告信息',
      'id'      => 'ad',
      'type'          => 'group',
      'button_title'  => '添加数据',
      'fields' => array(
        array(
          'title'    => '广告名称',
          'id'       => 'name',
          'type'     => 'text',
        ),
        array(
          'id'          => 'type',
          'type'        => 'select',
          'title'       => '类型',
          'placeholder' => '请选择',
          'default'     => 'url',
          'options'     => array(
            'url'      => '链接',
            'ajax'      => '按钮',
          ),
        ),
        array(
          'title'   => '广告图',
          'id'      => 'ad_img',
          'preview' => true,
          'library' => 'image',
          'type'    => 'upload',
        ),
        array(
          'title'    => '链接',
          'id'       => 'ad_url',
          'type'     => 'text',
          'desc'     => '<div style="color:#ff5521;"><i class="fa fa-fw fa-info-circle fa-fw"></i>按钮：使用action获取ajax数据的</div>例如：' . esc_url(home_url('/')) . 'wp-admin/admin-ajax.php?action=checkin_details_modal<br>填写action后面的checkin_details_modal即可<br><div style="color:#ff5521;"><i class="fa fa-fw fa-info-circle fa-fw"></i>链接：使用网站链接进行跳转</div>',
        ),
      ),
      'default'    => array(
          array(
            'name' => '广告1',
            'type' => 'url',
            'ad_img' => panda_pz('static_panda') . '/assets/img/ad_img/1.webp',
            'ad_url' => 'https://www.baidu.com',
          ),
          array(
            'name' => '广告2',
            'type' => 'url',
            'ad_img' => panda_pz('static_panda') . '/assets/img/ad_img/2.webp',
            'ad_url' => 'https://www.baidu.com',
          ),
          array(
            'name' => '广告3',
            'type' => 'url',
            'ad_img' => panda_pz('static_panda') . '/assets/img/ad_img/3.webp',
            'ad_url' => 'https://www.baidu.com',
          ),
          array(
            'name' => '广告4',
            'type' => 'url',
            'ad_img' => panda_pz('static_panda') . '/assets/img/ad_img/4.webp',
            'ad_url' => 'https://www.baidu.com',
          ),
          array(
            'name' => '广告5',
            'type' => 'url',
            'ad_img' => panda_pz('static_panda') . '/assets/img/ad_img/5.webp',
            'ad_url' => 'https://www.baidu.com',
          ),
          array(
            'name' => '广告6',
            'type' => 'url',
            'ad_img' => panda_pz('static_panda') . '/assets/img/ad_img/6.webp',
            'ad_url' => 'https://www.baidu.com',
          ),
        ),
    ),
    array(
      'title'   => '电脑端高度',
      'desc'   => '',
      'id'      => 'pc_height',
      'default' => 80,
      'unit'     => 'PX',
      'max'      => 10000,
      'min'      => 5,
      'step'     => 5,
      'type'     => 'spinner',
    ),
    array(
      'title'   => '移动端高度',
      'desc'   => '',
      'id'      => 'mobile_height',
      'default' => 60,
      'unit'     => 'PX',
      'max'      => 10000,
      'min'      => 5,
      'step'     => 5,
      'type'     => 'spinner',
    ),
    array(
      'title'   => '电脑端显示数量',
      'desc'   => '',
      'id'      => 'pc_num',
      'default' => 6,
      'unit'     => '个',
      'min'      => 1,
      'step'     => 1,
      'type'     => 'spinner',
    ),
    array(
      'title'   => '移动端显示数量',
      'desc'   => '',
      'id'      => 'mobile_num',
      'default' => 2,
      'unit'     => '个',
      'min'      => 1,
      'step'     => 1,
      'type'     => 'spinner',
    ),
  )
));

function widget_ad_img($args, $instance)
{

  Panda_CFSwidget::echo_before($instance, '');

  $html = '<div class="widget widget-demo">';
  $html .= '
    <style>
    .sort-config-icon {
      width: 100%;
      height: '.$instance['pc_height'].'px;
      border-radius: 8px;
      box-shadow: 0 10px 15px rgba(0, 0, 0, 0.3);
      object-fit: cover;
    }  
    @media (max-width: 768px) {
      .sort-config-icon {
        height: '.$instance['mobile_height'].'px;
      }
    }
    </style>
    <link rel="stylesheet" href="' . panda_pz('static_panda') . '/assets/css/ad_img.css">
    <script src="' . panda_pz('static_panda') . '/assets/js/swiper-bundle.min.js"></script>
    <div class="carousel-wrapper">
      <div class="swiper-container">
      <div class="swiper-wrapper">
      ';
      // 循环输出广告信息
      foreach ($instance['ad'] as $ad) {
        if ($ad['type'] == 'url') {
          $ad_url = 'target="_blank" href="'.$ad['ad_url'].'"';
        } else {
          $ad_url .= 'data-class="modal-mini full-sm" href="javascript:;" data-remote="' . add_query_arg(['action' => $ad['ad_url']], admin_url('admin-ajax.php')) . '"  data-toggle="RefreshModal"';
        }
        $html .= '
          <div class="swiper-slide">
            <a '. $ad_url .'>
              <picture class="picture"
                <source type="image/webp" srcset="' . $ad['ad_img'] . '">
                <img class="sort-config-icon" alt="' . $ad['name'] . '" src="' . $ad['ad_img'] . '">
              </picture>
            </a>
          </div>
        ';
      }
      $html .=
      '
      </div>
    </div>
    <div class="swiper-button-next" tabindex="0" role="button" aria-label="Next slide"></div>
    <div class="swiper-button-prev" tabindex="0" role="button" aria-label="Previous slide"></div>
  </div><script>
    var swiper = new Swiper(".swiper-container", {
      slidesPerView: '. $instance['mobile_num'].', 
      spaceBetween: 15,
      loop: true,
      autoplay: {
        delay: 3000,
        disableOnInteraction: false
      },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      breakpoints: {
        768: {
          slidesPerView: '. $instance['pc_num'].',
          spaceBetween: 10,
        },
        576: {
          slidesPerView: 1,
          spaceBetween: 5,
        }
      }
    });
  </script>';
  $html .= '</div>';
  echo $html;
  Panda_CFSwidget::echo_after($instance);
}