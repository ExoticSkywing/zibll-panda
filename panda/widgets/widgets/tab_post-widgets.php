<?php
//文章列表-新
Panda_CFSwidget::create('panda_widget_ui_tab_post', array(
    'title'       => 'tab-多栏目文章(新)',
    // 'zib_title'   => true,
    'zib_affix'   => true,
    'zib_show'    => true,
    'description' => '多个TAB栏目切换显示文章，支持各种筛选、排序、多种显示模式、翻页等功能',
    'fields'      => array(
         array(
            'title'   => '标题',
            'id'      => 'panda_title',
            'default' => '最新文章',
            'type'    => 'text',
        ),
        array(
            'title'   => '标题样式',
            'id'      => 'title_style',
            'default' => 'h2',
            'type'    => "select",
            'options' => array(
                '0' => '样式1',
                '55' => '样式2',
                '110' => '样式3',
                '165' => '样式4',
                '220' => '样式5',
                '275' => '样式6',
                '330' => '样式7',
                '385' => '样式8',
            ),
        ),
        array(
            'title'        => '标题右侧链接',
            'id'           => 'title_link',
            'type'         => 'link',
            'add_title'    => '添加链接',
            'edit_title'   => '编辑链接',
            'remove_title' => '删除链接',
            'default'      => array(
                'url'  => '/',
                'text' => '更多<i class="fa fa-angle-right fa-fw"></i>',
            ),
        ),
        array(
            'title'   => '列表样式',
            'id'      => 'style',
            'default' => 'mini',
            'type'    => "radio",
            'inline'  => true,
            'desc'    => '<div class="c-yellow">注意：不同样式尺寸不同，请根据放置的位置合理选择。例如：放在宽度较小的侧边栏，则需选择mini样式，否则显示效果不佳</div>',
            'options' => array(
                'list' => '列表样式',
                'card' => '卡片样式',
                'mini' => 'mini列表',
            ),
        ),
        array(
            'dependency'  => array('style', '==', 'mini'),
            'title'       => 'mini列表配置',
            'id'          => 'mini_opt',
            'default'     => [],
            'inline'      => true,
            'type'        => "checkbox",
            'placeholder' => '不做其它筛选',
            'options'     => array(
                'show_thumb'  => '显示缩略图',
                'show_number' => '显示编号（开启翻页后，只在第一页有效）',
                'show_meta'   => '显示作者、时间、点赞等信息',
            ),
        ),
        array(
            'title'   => '显示数量',
            'id'      => 'count',
            'class'   => '',
            'default' => 6,
            'max'     => 20,
            'min'     => 4,
            'step'    => 1,
            'unit'    => '篇',
            'type'    => 'spinner',
        ),
        array(
            'id'      => 'paginate',
            'title'   => '翻页按钮',
            'default' => '',
            'type'    => "radio",
            'inline'  => true,
            'options' => array(
                ''       => __('不翻页', 'zib_language'),
                'ajax'   => __('AJAX追加列表翻页', 'zib_language'),
                'number' => __('数字翻页按钮', 'zib_language'),
            ),
        ),
        array(
            'id'                     => 'tabs',
            'type'                   => 'group',
            'accordion_title_number' => true,
            'button_title'           => '添加栏目',
            'sanitize'               => false,
            'title'                  => '栏目',
            'default'                => array(
                array(
                    'title'   => '热门推荐',
                    'orderby' => 'views',
                ),
                array(
                    'title'   => '最近更新',
                    'orderby' => 'modified',
                ),
                array(
                    'title'   => '猜你喜欢',
                    'orderby' => 'rand',
                ),
            ),
            'fields'                 => array(
                array(
                    'id'         => 'title',
                    'title'      => '标题（必填）',
                    'desc'       => '栏目显示的标题，支持HTML代码，注意代码规范',
                    'attributes' => array(
                        'rows' => 1,
                    ),
                    'sanitize'   => false,
                    'type'       => 'textarea',
                ),
                array(
                    'id'    => 'cat',
                    'title' => __('分类限制', 'zib_language'),
                    'type'  => 'text',
                ),
                array(
                    'id'    => 'topics',
                    'title' => __('专题限制', 'zib_language'),
                    'desc'  => __('分类或专题限制请填写对应的ID，多个ID请用英文逗号隔开。如：1,2,3。支持负数进行排除，例如：-1,-2,-3。（在后台分类、专题列表中可查看ID）', 'zib_language'),
                    'type'  => 'text',
                ),
                array(
                    'title'       => '商品类型筛选',
                    'id'          => 'zibpay_type',
                    'default'     => [],
                    'inline'      => true,
                    'type'        => "checkbox",
                    'placeholder' => '不做其它筛选',
                    'options'     => array(
                        '1' => '付费阅读',
                        '2' => '付费下载',
                        '5' => '付费图片',
                        '6' => '付费视频',
                    ),
                ),
                array(
                    'title'   => '发布时间限制',
                    'desc'    => '仅显示最近多少天发布的文章，为0则不限制',
                    'id'      => 'limit_day',
                    'class'   => '',
                    'default' => 0,
                    'min'     => 0,
                    'step'    => 5,
                    'unit'    => '天',
                    'type'    => 'spinner',
                ),
                array(
                    'id'       => 'orderby',
                    'type'     => 'select',
                    'default'  => '',
                    'title'    => '排序方式',
                    'subtitle' => '',
                    'options'  => CFS_Module::posts_orderby(),
                ),
                array(
                    'id'      => 'order',
                    'default' => 'desc',
                    'class'   => 'compact',
                    'inline'  => true,
                    'type'    => "radio",
                    'options' => array(
                        'desc' => '升序',
                        'asc'  => '降序',
                    ),
                ),
            ),
        ),
    ),
));

function panda_widget_ui_tab_post($args, $instance)
{

    $show_class = Zib_CFSwidget::show_class($instance);
    if (!$show_class || empty($instance['tabs'])) {
        return;
    }

    $style = $instance['style'] ? $instance['style'] : 'list';
    $class = 'widget-tab-post style-' . $style;
    $class .= $style == 'mini' ? ' posts-mini-lists zib-widget' : ' index-tab relative-h';

    $main_html = '';
    $widget_id = $args['widget_id'];
    $id_base   = 'panda_widget_ui_tab_post';
    $index     = str_replace($id_base . '-', '', $widget_id);

    $placeholder = ''; //
    if ($style == 'mini') {
        $placeholder = str_repeat('<div class="posts-mini"><div class="placeholder k1"></div></div>', $instance['count']);
        $mini_opt    = $instance['mini_opt'] ? $instance['mini_opt'] : array();
        if (in_array('show_thumb', $mini_opt)) {
            $placeholder = str_repeat('<div class="posts-mini "><div class="mr10"><div class="item-thumbnail placeholder"></div></div><div class="posts-mini-con flex xx flex1 jsb"><div class="placeholder t1"></div><div class="placeholder s1"></div></div></div>', $instance['count']);
        }
    } else {
        $placeholder_type = $style == 'card' ? 'card' : 'lists';
        $placeholder      = zib_get_post_placeholder($placeholder_type, $instance['count']);
    }

    $tabs_con  = '';
    $tabs_nav  = '';
    $tabs_i    = 1;
    $tabs      = $instance['tabs'];
    $ajax_href = add_query_arg(array(
        'action' => 'ajax_widget_ui',
        'id'     => $id_base,
        'index'  => $index,
    ), admin_url('/admin-ajax.php'));

    foreach ($instance['tabs'] as $tabs_key => $tabs) {
        if (empty($tabs['title'])) {
            continue;
        }
        $tab_id    = $widget_id . '-' . $tabs_i;
        $nav_class = $tabs_i == 1 ? 'active' : '';
        $con_class = $tabs_i == 1 ? ' active in' : '';

        $con_html = '';
        if ($tabs_i == 1) {
            $con_html = panda_widget_ui_tab_post_ajax($instance, true, add_query_arg('tab', $tabs_key, $ajax_href), $tabs_key);
        } else {
            $con_html .= '<span class="post_ajax_trigger hide"><a ajaxpager-target=".widget-ajaxpager" href="' . add_query_arg('tab', $tabs_key, $ajax_href) . '" class="ajax_load ajax-next ajax-open" no-scroll="true"></a></span>';
        }
        $con_html .= '<div class="post_ajax_loader" style="display: none;">' . $placeholder . '</div>';

        $tabs_nav .= '<li class="' . $nav_class . '"><a' . ($tabs_i !== 1 ? ' data-ajax' : '') . ' data-toggle="tab" href="#' . $tab_id . '">' . $tabs['title'] . '</a></li>';
        $tabs_con .= '<div class="tab-pane fade' . $con_class . '" id="' . $tab_id . '"><div class="widget-ajaxpager">' . $con_html . '</div></div>';

        $tabs_i++;
    }

    if (!$tabs_nav) {
        return;
    }

    $title_style = isset($instance['title_style']) ? $instance['title_style'] : 0;

    $main_html = '<style>
    .panda-index-title {
  align-items: center;
  display: flex;
  justify-content: space-between;
}

.panda-index-title h2 {
  background-image: url('. panda_pz('static_panda').'/assets/img/title.svg);
  background-position: 0 -'. $title_style .'px;
  background-repeat: no-repeat;
  font-size: 22px;
  height: 37px;
  padding-left: 45px;
  padding-top: 2px;
      margin-top: 0px;
    margin-bottom: 0px;
}

@media (max-width: 768px) {
  .panda-index-title {
    flex-direction: column;
  }

  .panda-index-title h2 {
    background-color: initial;
    background-image: url('. panda_pz('static_panda').'/assets/img/title.svg);
    background-position: 0 -275px;
    background-repeat: no-repeat;
    font-size: 22px;
    height: 37px;
    margin: 1px 20px -10px -10px;
    padding-left: 45px;
    padding-top: 2px;
    position: relative;
  }

  .panda-index-title ul {
    overflow-x: auto;
    scrollbar-width: none;
    text-wrap-mode: nowrap;
    display: flex;
    justify-content: space-between;
    margin-left: 0;
    margin-top: 10px;
    white-space-collapse: collapse;
    width: 100%;
  }

  .panda-index-title ul::-webkit-scrollbar {
    display: none;
  }
}

.widget-tab-post.index-tab .list-inline {
    margin-bottom: 0px;
}

    </style>
    <div class="panda-index-title-bottom relative' . ($style == 'card' ? ' mb20' : '') . '">
    <div class="panda-index-title">
                <h2>' . esc_html($instance['panda_title']) . '</h2>
    <ul class="list-inline scroll-x no-scrollbar' . ($style == 'mini' ? ' tab-nav-theme' : '') . '">
        ' . $tabs_nav . '
        <li><a href="'.$instance['title_link']['url'].'">'.$instance['title_link']['text'].'</a></li>
    </ul>
    </div>
    </div>
    <div class="tab-content">
        ' . $tabs_con . '
    </div>';

    //开始输出
    Zib_CFSwidget::echo_before($instance, $class);
    echo $main_html;
    Zib_CFSwidget::echo_after($instance);
}

function panda_widget_ui_tab_post_ajax($instance, $no_ajax = false, $ajax_url = null, $tab = 0)
{

    $paged      = zib_get_the_paged();
    $style      = $instance['style'] ? $instance['style'] : 'list';
    $paginate   = $instance['paginate'] ? $instance['paginate'] : '';
    $paged_size = $instance['count'];
    $ajax_url   = $ajax_url ?: zib_get_current_url();
    $tab        = $tab ? $tab : (isset($_REQUEST['tab']) ? (int) $_REQUEST['tab'] : 0);

    $posts_args = array(
        'cat'         => $instance['tabs'][$tab]['cat'],
        'topics'      => $instance['tabs'][$tab]['topics'],
        'zibpay_type' => isset($instance['tabs'][$tab]['zibpay_type']) ? $instance['tabs'][$tab]['zibpay_type'] : '',
        'orderby'     => $instance['tabs'][$tab]['orderby'],
        'order'       => isset($instance['tabs'][$tab]['order']) && $instance['tabs'][$tab]['order'] === 'asc' ? 'ASC' : 'DESC',
        'count'       => $instance['count'],
        'limit_day'   => isset($instance['tabs'][$tab]['limit_day']) ? (int) $instance['tabs'][$tab]['limit_day'] : 0,
    );

    //不需要翻页
    if (!$paginate) {
        $posts_args['no_found_rows'] = true;
        $paged                       = 1;
    }

    $posts_query = zib_get_posts_query($posts_args);
    $lists       = '';
    $mini_number = $paged * $paged_size - $paged_size;

    if ($posts_query->have_posts()) {
        while ($posts_query->have_posts()): $posts_query->the_post();
            if ($style == 'card') {
                $lists .= zib_posts_mian_list_card(array());
            } elseif ($style == 'mini') {
            $mini_opt = $instance['mini_opt'] ? $instance['mini_opt'] : array();

            $mini_args = array(
                'class'       => 'ajax-item',
                'show_thumb'  => in_array('show_thumb', $mini_opt),
                'show_meta'   => in_array('show_meta', $mini_opt),
                'show_number' => in_array('show_number', $mini_opt),
                'echo'        => false,
            );
            $mini_number++;
            $lists .= zib_posts_mini_while($mini_args, $mini_number);
        } else {
            $lists .= zib_posts_mian_list_list(array('is_mult_thumb' => 'disable', 'is_no_thumb' => 'disable'));
        }

        endwhile;
        wp_reset_query();
    }
    if (1 == $paged && !$lists) {
        $lists = zib_get_ajax_null('暂无内容', 10);
    }

    //分页paginate
    if ($paginate === 'ajax') {
        $lists .= zib_get_ajax_next_paginate($posts_query->found_posts, $paged, $paged_size, $ajax_url, 'text-center theme-pagination ajax-pag', 'next-page ajax-next', '', 'paged', 'no', '.widget-ajaxpager');
    } elseif ($paginate === 'number') {
        $lists .= zib_get_ajax_number_paginate($posts_query->found_posts, $paged, $paged_size, $ajax_url, 'ajax-pag', 'next-page ajax-next', 'paged', '.widget-ajaxpager');
    } else {
        $lists .= '<div class="ajax-pag hide"><div class="next-page ajax-next"><a href="#"></a></div></div>';
    }

    if ($no_ajax) {
        return $lists;
    }
    zib_ajax_send_ajaxpager($lists, false, 'widget-ajaxpager');

}