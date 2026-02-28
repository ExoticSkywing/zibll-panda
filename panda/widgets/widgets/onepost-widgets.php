<?php
// 使用Panda_CFSwidget类创建一个名为'widget_ui_oneposts'的小工具
Panda_CFSwidget::create('widget_ui_oneposts', array(
    'title'       => 'onepost-单行文章列表',  // 小工具的标题
    'zib_title'   => true,  // 是否显示模块标题菜单
    'description' => '显示文章列表，只显示一行，自动横向滚动',  // 小工具的描述
    'fields'      => array(  // 配置小工具的字段
        array(
            'title'       => '标题',  // 字段标题
            'id'          => 'first_title',  // 字段ID，用于在前端引用
            'type'        => 'text',  // 字段类型，文本框
            'default'     => 'MAC应用',  // 字段的默认值
        ),
        array(
            'title'       => '副标题',  // 字段标题
            'id'          => 'mini_title',  // 字段ID，用于在前端引用
            'type'        => 'text',  // 字段类型，文本框
            'default'     => '让Mac生产力爆棚!',  // 字段的默认值
        ),
        array(
            'title'       => '按钮文案',  // 字段标题
            'id'          => 'onepost_more_but',  // 字段ID，用于在前端引用
            'type'        => 'text',  // 字段类型，文本框
            'default'     => '更多<i class="fa fa-angle-right fa-fw"></i>',  // 字段的默认值
        ),
        array(
            'title'       => '按钮链接',  // 字段标题
            'id'          => 'onepost_more_but_url',  // 字段ID，用于在前端引用
            'type'        => 'text',  // 字段类型，文本框
            'default'     => '',  // 字段的默认值
        ),
        array(
            'title'       => '分类限制',  // 字段标题
            'id'          => 'cat',  // 字段ID，用于在前端引用
            'type'        => 'text',  // 字段类型，文本框
            'default'     => '',  // 字段的默认值
        ),
        array(
            'title'       => '专题限制',  // 字段标题
            'id'          => 'topics',  // 字段ID，用于在前端引用
            'type'        => 'text',  // 字段类型，文本框
            'default'     => '',  // 字段的默认值
        ),
        array(
            'title'       => '显示数目',  // 字段标题
            'id'          => 'limit',  // 字段ID，用于在前端引用
            'type'        => 'number',  // 字段类型，数字
            'default'     => 6,  // 字段的默认值
        ),
        array(
            'title'       => '限制时间（最近X天）',  // 字段标题
            'id'          => 'limit_day',  // 字段ID，用于在前端引用
            'type'        => 'number',  // 字段类型，数字
            'default'     => '',  // 字段的默认值
        ),
        array(
            'title'       => '排序方式',  // 字段标题
            'id'          => 'orderby',  // 字段ID，用于在前端引用
            'type'        => 'select',  // 字段类型，下拉选择
            'options'     => array(
                'comment_count' => '评论数',
                'views'         => '浏览量',
                'like'          => '点赞数',
                'favorite'      => '收藏数',
                'sales_volume'  => '销售数量',
                'date'          => '发布时间',
                'modified'      => '更新时间',
                'rand'          => '随机排序'
            ),
            'default'     => 'views',  // 字段的默认值
        )
    )
));

// 定义显示小工具的函数
function widget_ui_oneposts($args, $instance)
{
    // 可用于是否显示判断
    $show_class = Panda_CFSwidget::show_class($instance);//值为1或者0

    // 获取小工具字段值
    $first_title = $instance['first_title'];
    $mini_title = $instance['mini_title'];
    $onepost_more_but = $instance['onepost_more_but'];
    $onepost_more_but_url = $instance['onepost_more_but_url'];
    $in_affix = $instance['in_affix'];
    $limit = $instance['limit'];
    $limit_day = $instance['limit_day'];
    $cat = $instance['cat'];
    $topics = $instance['topics'];
    $orderby = $instance['orderby'];

    // 构建查询参数
    $args = array(
        'post_status'         => 'publish',
        'cat'                 => str_replace('，', ',', $cat),
        'order'               => 'DESC',
        'showposts'           => $limit,
        'no_found_rows'       => true, 
        'ignore_sticky_posts' => 1,
    );

    if ($orderby !== 'views' && $orderby !== 'favorite' && $orderby !== 'like' && $orderby !== 'sales_volume') {
        $args['orderby'] = $orderby;
    } else {
        $args['orderby']    = 'meta_value_num';
        $args['meta_query'] = array(
            array(
                'key'   => $orderby,
                'order' => 'DESC',
            ),
        );
    }

    if ($topics) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'topics',
                'terms'    => preg_split("/,|，|\s|\n/", $topics),
            ),
        );
    }

    if ($limit_day > 0) {
        $current_time = current_time('Y-m-d H:i:s');
        $args['date_query'] = array(
            array(
                'after'     => date('Y-m-d H:i:s', strtotime("-" . $limit_day . " day", strtotime($current_time))),
                'before'    => $current_time,
                'inclusive' => true,
            ),
        );
    }

    // 构建HTML输出
    $mini_title_html = $mini_title ? '<span class="title-sub-name">' . esc_html($mini_title) . '</span>' : '';
    $onepost_more_but_html = ($onepost_more_but && $onepost_more_but_url) ? '<div class="header__btn-wrapper"><a href="' . esc_url($onepost_more_but_url) . '" class="button---AUM5ZP text---pn4pHz medium---OGt5iw header__btn">' . $onepost_more_but . '</a></div>' : '';
    
    $title_html = $first_title ? '<div class="training-camp__header">
        <div class="header__title-wrapper">
        <div class="container123">
        <span class="title">' . esc_html($first_title) . '</span>
        <span class="title-2">&nbsp;/&nbsp;</span>
        <span class="mini-title" style="font-size: 18px; top:auto">' . $mini_title_html . '</span>
        </div></div>' . $onepost_more_but_html . '</div>' : '';

    $in_affix_attr = $in_affix ? ' data-affix="true"' : '';

    // 查询文章
    $the_query = new WP_Query($args);
    $list_args = array('type' => 'card');

    // 构建完整HTML
    $html = '<div' . $in_affix_attr . ' class="theme-box">';
    $html .= '<section class="sec-wrapper index-center-block training-camp__wrapper">';
    $html .= $title_html;
    $html .= '<div class="sec-bd">';
    $html .= '<div class="swiper-container swiper-scroll" data-slideClass="posts-item" style="width:100%;">';
    $html .= '<div class="swiper-wrapper">';
    
    // 文章列表内容将通过zib_posts_list函数输出
    ob_start();
    zib_posts_list($list_args, $the_query);
    $html .= ob_get_clean();
    
    $html .= '</div>';
    $html .= '<div class="swiper-button-prev"></div><div class="swiper-button-next"></div>';
    $html .= '</div>';
    $html .= '</section>';
    $html .= '</div>';

    // 添加CSS样式
    $html .= '<style>
        .sec-wrapper {margin-bottom: 10px;}
        .training-camp__wrapper {
            --green-1: #cff0fb;
            --green-2: #cbf4e4;
            --green-3: #22ab80;
            --gray-1: #667280;
            --white-1: #fff;
            --white-2: #f5f7fa;
            background-image: linear-gradient(150deg,var(--green-1) 20%,var(--green-2) 40%);
            padding: 0 12px 12px;
            border-radius: 16px;
        }
        button.button---AUM5ZP.text---pn4pHz.medium---OGt5iw.header__btn {
            background: #ffffff00;
            border: 1px solid #fc3c2d00;
            border-radius: 0px;
        }
        .training-camp__wrapper .training-camp__header {
            padding: 24px 0 24px 12px;
            display: -webkit-flex;
            display: flex;
            gap: 18px;
            background: url(' . panda_pz('static_panda') . '/assets/img/65b1e15fb2df7.png) 100% 0/433px 126px no-repeat;
        }
        .training-camp__wrapper .header__title-wrapper {
            display: -webkit-flex;
            display: flex;
            -webkit-align-items: center;
            align-items: center;
            gap: 0px;
        }
        .training-camp__wrapper .title__img-wrapper {
            display: -webkit-flex;
            display: flex;
            -webkit-align-items: center;
            top: 0;
            height: 20px;
        }
        .training-camp__wrapper .header__btn-wrapper {
            margin-left: auto;
            display: -webkit-flex;
            display: flex;
        }
        .training-camp__wrapper .header__btn-wrapper button[class*=button---] {
            height: 20px;
            line-height: 20px;
            padding: 0 12px;
        }
        .training-camp__wrapper .header__btn {
            display: -webkit-flex;
            display: flex;
            -webkit-align-items: center;
            align-items: center;
            font-size: 14px;
            color: var(--green-3);
        }
        .medium---OGt5iw {
            height: 36px;
            padding: 8px 24px;
            font-size: 14px;
        }
        .outlined---BKvHAe, .text---pn4pHz {
            background-color: initial;
            color: #3e454d;
        }
        .button---AUM5ZP {
            position: relative;
            display: inline-block;
            height: 36px;
            padding: 8px 24px;
            border-radius: 22px;
            cursor: pointer;
            border: unset;
            font-size: 14px;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }
        .ke-icon---zeGrGg+i {
            display: inline-block;
            vertical-align: middle;
        }
        .training-camp__wrapper>div.sec-bd {
            background-color: var(--body-bg-color);
            gap: 12px;
        }
        .sec-wrapper .sec-bd {
            position: relative;
            display: -webkit-flex;
            display: flex;
            -webkit-flex-wrap: wrap;
            flex-wrap: wrap;
            gap: 24px;
        }
        .training-camp__wrapper .sec-bd {
            padding: 12px;
            border-radius: 16px;
        }
        img.title-macyingyong {
            height: 50px;
        }
        .container123 {
            display: flex;
            align-items: center;
            font-family: Arial, sans-serif;
            font-weight: bold;
            color: #3e454d;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: clamp(16px, 3vw, 24px);
        }
        .container123 .title-2 {
            font-size: clamp(14px, 2.5vw, 20px);
            margin: 0 4px;
        }
        .container123 .mini-title {
            font-size: clamp(12px, 2vw, 18px);
            font-weight: normal;
            color: #666;
            top: auto;
        }
        @media (max-width: 640px) {
            .training-camp__header {
                gap: 8px;
                padding: 16px 0 16px 8px;
                background-size: 200px 80px;
            }
            .header__btn-wrapper {
                margin-left: auto;
            }
            .header__btn-wrapper .header__btn {
                font-size: clamp(12px, 2.5vw, 14px);
                padding: 4px 12px;
                height: auto;
                line-height: 1.2;
            }
        }
    </style>';

    // 在小工具内容之前调用Panda_CFSwidget的echo_before函数
    Panda_CFSwidget::echo_before($instance, '');

    // 输出小工具内容
    echo $html;

    // 在小工具内容之后调用Panda_CFSwidget的echo_after函数
    Panda_CFSwidget::echo_after($instance);
}
?>