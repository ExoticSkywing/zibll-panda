<?php
Panda_CFSwidget::create('panda_widget_ui_img_post', array(
    'title'       => 'img-图片文章列表',
    'description' => '显示特定分类目录下的文章，可设置两行布局',
    'fields'      => array(
        array(
            'id'       => 'img_title',
            'title'    => '标题:',
            'default'  => '美图展示',
            'type'     => 'text',
        ),
        array(
            'id'           => 'link',
            'type'         => 'link',
            'title'        => '更多按钮',
            'default'      => array(
                'text' => '更多 <i class="fa fa-angle-right em12"></i>',
                'url'  => '',
            ),
            'add_title'    => '添加按钮',
            'edit_title'   => '编辑按钮',
            'remove_title' => '删除按钮',
        ),
        array(
            'id'          => 'term_id',
            'title'       => '添加分类、专题',
            'desc'        => '选择并排序需要的分类、专题，如选择的分类(专题)下没有文章则不会显示',
            'options'     => 'categories',
            'query_args'  => array(
                'taxonomy' => array('topics', 'category'),
                'orderby'  => 'taxonomy',
            ),
            'placeholder' => '输入关键词以搜索分类或专题',
            'ajax'        => true,
            'settings'    => array(
                'min_length' => 2,
            ),
            'chosen'      => true,
            'multiple'    => true,
            'sortable'    => true,
            'type'        => 'select',
        ),
        array(
            'id'       => 'orderby',
            'type'     => 'select',
            'default'  => '',
            'title'    => '排序方式',
            'subtitle' => '',
            'options'  => array(
                'date'          => '发布时间',
                'modified'      => '更新时间',
                'views'         => '浏览数量',
                'like'          => '点赞数量',
                'comment_count' => '评论数量',
                'favorite'      => '收藏数量',
                'rand'          => '随机排序',
            ),
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
        array(
            'id'       => 'part_1',
            'title'    => '第一行显示数量',
            'class'    => 'button-mini',
            'default'  => 5,
            'options'  => array(
                1  => '1个',
                2  => '2个',
                3  => '3个',
                4  => '4个',
                5  => '5个',
            ),
            'type'     => 'button_set',
        ),
        array(
            'id'       => 'part_2',
            'title'    => '第二行显示数量',
            'class'    => 'button-mini',
            'default'  => 5,
            'options'  => array(
                0 => '0个',
                1 => '1个',
                2 => '2个',
                3 => '3个',
                4 => '4个',
                5 => '5个',
            ),
            'type'     => 'button_set',
        ),
    )
));

function panda_widget_ui_img_post($args, $instance)
{
    ?>
    <style>
        .panda-custom-widget { background:none; padding:0; box-shadow:none; margin:0; margin-bottom:10px; }
        .panda-posts-row { display:flex; flex-wrap:wrap; gap:10px; margin-bottom: 10px; }
        .panda-post-list-item { overflow:hidden; border-radius:5px; flex:1 1 calc(20% - 10px); box-sizing:border-box; margin-bottom:1px; position:relative; }
        @media screen and (max-width:768px){.panda-posts-row{margin-bottom:0;}
        .panda-posts-row .panda-post-list-item{flex:1 1 calc(50% - 10px);}
        .panda-posts-row .panda-post-list-item:last-child:nth-child(odd){flex:1 1 100%;}
        }
        .panda-post-module-thumb img { width:100%; height:268px; object-fit:cover; border-radius:5px; transition:transform 0.3s ease; }
        .panda-post-module-thumb img:hover { transform:scale(1.1); }
        .panda-post-info { position:absolute; bottom:0; width:100%; background:linear-gradient(to bottom,transparent,rgba(0,0,0,0.6) 100%); color:#fff; text-align:center; padding:15px 0; }
        .panda-post-info h2 { font-size:1em; margin:0; padding:0 5px; overflow:hidden; white-space:nowrap; text-overflow:ellipsis; }
        .panda-post-info a { text-decoration:none; color:#fff; }
        .panda-post-meta { position:absolute; top:0; width:100%; display:flex; justify-content:space-between; padding:5px; color:#fff; }
        .panda-post-meta .panda-post-views { padding:2px 5px; border-radius:3px; opacity:0; transition:opacity 0.3s ease; }
        .panda-post-module-thumb:hover .panda-post-meta .panda-post-views { opacity:1; }
        .panda-post-meta .panda-post-images { padding:2px 5px; border-radius:3px; }
        .panda-widget-title-wrapper { display:flex; justify-content:space-between; align-items:center; }
        .panda-widget-title-wrapper h2 { background:url(<?php echo panda_pz('static_panda'); ?>/assets/img/title.svg) 0px -110px no-repeat; position:relative; margin-left:-10px; margin-right:20px; height:37px; padding-left:45px; padding-top:2px; font-size:22px; margin-bottom:10px; margin-top:0px;}
        .panda-sort-link { font-size:0.9em; color:#0073aa; text-decoration:none; margin-right:10px; }
        .panda-sort-link:hover { text-decoration:underline; }
        .panda-more-link { text-decoration:none; margin-bottom:5px;}
        .panda-more-link:hover { text-decoration:none; }
    </style>
    <?php
    $title = !empty($instance['img_title']) ? $instance['img_title'] : '';
    $first_row = !empty($instance['part_1']) ? absint($instance['part_1']) : 3;
    $second_row = isset($instance['part_2']) ? absint($instance['part_2']) : 2;
    $total_posts = $first_row + $second_row;
    $cat = !empty($instance['term_id']) ? $instance['term_id'] : '';
    $orderby = !empty($instance['orderby']) ? $instance['orderby'] : 'date';
    $order = !empty($instance['order']) ? $instance['order'] : 'desc';

    $query_args = array(
        'post_status'         => 'publish',
        'cat'                 => $cat,
        'posts_per_page'      => $total_posts,
        'ignore_sticky_posts' => 1,
    );

    // 根据不同的排序方式设置查询参数
    switch ($orderby) {
        case 'views':
            $query_args['meta_key'] = 'views';
            $query_args['orderby'] = 'meta_value_num';
            break;
        case 'like':
            $query_args['meta_key'] = 'like_count';
            $query_args['orderby'] = 'meta_value_num';
            break;
        case 'favorite':
            $query_args['meta_key'] = 'favorite_count';
            $query_args['orderby'] = 'meta_value_num';
            break;
        case 'modified':
        case 'date':
        case 'comment_count':
        case 'rand':
            $query_args['orderby'] = $orderby;
            break;
    }

    $query_args['order'] = $order;

    $the_query = new WP_Query($query_args);
    
    $link = !empty($instance['link']) ? $instance['link'] : '';
    $before_title = '<div class="panda-widget-title-wrapper"><h2 class="widget-title">';
    $after_title = '</h2>';
    if (!empty($title)) {
        echo $before_title . $title . $after_title;
        if (!empty($link['url']) && !empty($link['text'])) {
            $link_target = !empty($link['target']) ? 'target="_blank"' : '';
            echo '<a href="' . $link['url'] . '" class="panda-more-link but jb-blue radius" '. $link_target . '>' . $link['text'] . '</a>';
        }
        echo '</div>'; 
    }
    echo '<div class="panda-posts-row">';
    $post_count = 0;
    while ($the_query->have_posts()) {
        $the_query->the_post();
        $views = format_views(get_post_meta(get_the_ID(), 'views', true));
        $images = get_image_count();
        
        // 只在 PC 端进行分割
        if (!wp_is_mobile() && $post_count == $first_row) {
            echo '</div><div class="panda-posts-row">';
        }
        
        echo '<div class="panda-post-list-item">';
        echo '<div class="panda-item-in">';
        echo '<div class="panda-post-module-thumb">';
        echo '<a class="panda-thumb-link" href="' . get_permalink() . '" target="_blank" rel="nofollow noopener">';
        echo get_post_thumbnail();
        echo '</a>';
        echo '<div class="panda-post-meta">';
        echo '<div class="panda-post-views"><i class="fa fa-eye"></i> ' . $views . '</div>';
        echo '<div class="panda-post-images"><i class="fa fa-picture-o"></i> ' . $images . '</div>';
        echo '</div>';
        echo '</div>';
        echo '<div class="panda-post-info">';
        echo '<h2><a href="' . get_permalink() . '" target="_blank" rel="noopener">' . get_the_title() . '</a></h2>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        $post_count++;
    }
    wp_reset_postdata();
    echo '</div>';
}

function format_views($views)
{
    if ($views >= 10000) {
        return round($views / 10000, 2) . 'w';
    }
    return $views;
}

function get_image_count()
{
    global $post;
    $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
    $count = isset($matches[1]) ? count($matches[1]) : 0;

    $content = do_shortcode($post->post_content);
    $output = preg_match_all('/<a.*?href=[\'"]([^\'"]+\.(?:jpe?g|png|gif|bmp|webp))[\'"].*?>.*?<\/a>/i', $content, $matches);
    $count += isset($matches[1]) ? count($matches[1]) : 0;

    return $count;
}

function get_post_thumbnail()
{
    global $post;
    $size = 'medium'; 
    $thumbnail_url = get_post_meta($post->ID, 'thumbnail_url', true);

    if (has_post_thumbnail($post->ID)) {
        return get_the_post_thumbnail($post->ID, $size, array('class' => 'panda-post-thumb', 'alt' => get_the_title()));
    } elseif ($thumbnail_url) {
        return sprintf('<img src="%s" class="panda-post-thumb" alt="%s">', $thumbnail_url, get_the_title());
    } else {
        $first_image = zib_post_thumbnail();
        if ($first_image) {
            return $first_image;
        } else {
            $category = get_the_category();
            foreach ($category as $cat) {
                $cat_img_url = zib_get_taxonomy_img_url($cat->cat_ID, $size);
                if ($cat_img_url) {
                    return sprintf('<img src="%s" class="panda-post-thumb" alt="%s">', $cat_img_url, get_the_title());
                }
            }
            return zib_get_lazy_thumb('default');
        }
    }
}
