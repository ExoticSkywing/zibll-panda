<?php
// 二次元风格热门文章排行榜
Panda_CFSwidget::create('widget_rank', array(
    'title'       => '二次元风格热门文章排行',
    'zib_title'   => true,
    'zib_affix'   => true,
    'zib_show'    => true,
    'description' => '二次元风格热门文章排行',
    'fields'      => array(
        array('title' => '排行榜1名称', 'id' => 'hot_1', 'type' => 'text', 'default' => '建站资源'),
        array('title' => '排行榜1分类ID', 'id' => 'hot_1_cat', 'type' => 'text', 'default' => '1'),
        array('title' => '排行榜1显示个数', 'id' => 'hot_1_num', 'type' => 'text', 'default' => '5'),
        array('title' => '排行榜1跳转文字', 'id' => 'hot_1_link_text', 'type' => 'text', 'default' => '更多'),
        array('title' => '排行榜1跳转链接', 'id' => 'hot_1_link', 'type' => 'text', 'default' => '/more'),
        array('title' => '排行榜2名称', 'id' => 'hot_2', 'type' => 'text', 'default' => '美化分享'),
        array('title' => '排行榜2分类ID', 'id' => 'hot_2_cat', 'type' => 'text', 'default' => '1'),
        array('title' => '排行榜2显示个数', 'id' => 'hot_2_num', 'type' => 'text', 'default' => '5'),
        array('title' => '排行榜2跳转文字', 'id' => 'hot_2_link_text', 'type' => 'text', 'default' => '更多'),
        array('title' => '排行榜2跳转链接', 'id' => 'hot_2_link', 'type' => 'text', 'default' => '/more'),
        array('title' => '排行榜3名称', 'id' => 'hot_3', 'type' => 'text', 'default' => '软件基地'),
        array('title' => '排行榜3分类ID', 'id' => 'hot_3_cat', 'type' => 'text', 'default' => '1'),
        array('title' => '排行榜3显示个数', 'id' => 'hot_3_num', 'type' => 'text', 'default' => '5'),
        array('title' => '排行榜3跳转文字', 'id' => 'hot_3_link_text', 'type' => 'text', 'default' => '更多'),
        array('title' => '排行榜3跳转链接', 'id' => 'hot_3_link', 'type' => 'text', 'default' => '/more'),
        array('title' => '标题显示行数', 'id' => 'hot_title_line', 'type' => 'text', 'default' => '1'),
    )
));

function widget_rank($args, $instance)
{
    Panda_CFSwidget::echo_before($instance, '');
    ?>
    <style>
        .rank-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 15px; /* 小工具底部空隙 */
        }
        @media (max-width: 1024px) {
            .rank-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 768px) {
            .rank-container {
                grid-template-columns: 1fr;
            }
        }
        .rank-block {
            position: relative;
            background: var(--main-bg-color);
            border-radius: 14px;
            box-shadow: 0 6px 14px rgba(0,0,0,0.08);
            overflow: hidden;
            transition: transform 0.25s ease;
        }
        .rank-block:hover {
            transform: translateY(-6px) scale(1.02);
        }
        .rank-header {
            background: linear-gradient(135deg, #ff9de6, #9dd9ff);
            color: #fff;
            padding: 12px 16px;
            font-weight: bold;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
            height: 44px; /* 固定高度 */
            overflow: hidden; /* 隐藏溢出 */
            white-space: nowrap; /* 不换行 */
            text-overflow: ellipsis; /* 文本溢出显示省略号 */
        }
        .rank-header::before {
            content: "★";
            font-size: 18px;
            flex-shrink: 0; /* 防止图标被压缩 */
        }
        .rank-list {
            display: flex;
            flex-direction: column;
        }
        .rank-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            border-bottom: 1px dashed #f3c2ff;
            text-decoration: none;
            color: #444;
            transition: background 0.2s ease, transform 0.2s ease;
        }
        .rank-item:hover {
            background: rgba(255, 237, 255, 0.4);
            transform: translateX(4px);
        }
        .rank-num {
            flex-shrink: 0;
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background: #ccc;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: bold;
            padding-top: 3px;
        }
        .rank-num.top1 { background: linear-gradient(135deg, #ff5f6d, #ffc371); }
        .rank-num.top2 { background: linear-gradient(135deg, #42e695, #3bb2b8); }
        .rank-num.top3 { background: linear-gradient(135deg, #a18cd1, #fbc2eb); }
        .rank-thumb {
            flex-shrink: 0;
            width: 48px;
            height: 48px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0,0,0,0.15);
        }
        .rank-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .rank-info {
            flex: 1;
            min-width: 0; /* 防止flex项目溢出 */
        }
        .rank-title {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 4px;
            line-height: 1.3;
            color: var(--key-color);
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: <?php echo $instance["hot_title_line"]?>; /* 限制显示一行 */
            -webkit-box-orient: vertical;
            height: <?php echo ($instance["hot_title_line"] * 18)."px"?>; /* 固定高度，一行文字 */
        }
        .rank-meta {
            font-size: 12px;
            color: var(--muted-color);
        }
        .rank-footer {
            text-align: center;
            padding: 10px;
            background: rgba(255, 237, 255, 0.5);
        }
        .rank-footer a {
            font-size: 14px;
            color: #ff6bb5;
            text-decoration: none;
            font-weight: bold;
        }
        .rank-footer a:hover {
            text-decoration: underline;
        }
    </style>

    <div class="rank-container">
        <?php for ($i = 1; $i <= 3; $i++): ?>
            <?php
                $title = $instance["hot_{$i}"];
                $cat_id = $instance["hot_{$i}_cat"];
                $num = $instance["hot_{$i}_num"];
                $link_text = $instance["hot_{$i}_link_text"];
                $link = $instance["hot_{$i}_link"];
                $phnum = 0;
                
                // 生成缓存键名
                $cache_key = 'widget_rank_cache_' . $i . '_' . $cat_id . '_' . $num;
                $cached_data = get_transient($cache_key);
                
                // 如果没有缓存或缓存过期，重新查询数据
                if (false === $cached_data) {
                    $args_query = array(
                        'cat' => $cat_id,
                        'showposts' => $num,
                        'orderby' => 'meta_value_num',
                        'meta_key' => 'views',
                        'order' => 'DESC'
                    );
                    query_posts($args_query);
                    
                    $posts_data = array();
                    while (have_posts()) : the_post();
                        $post_data = array(
                            'permalink' => get_permalink(),
                            'thumbnail' => zib_post_thumbnail('', 'thumbnail'),
                            'title' => get_the_title(),
                            'views' => get_post_view_count('', '')
                        );
                        $posts_data[] = $post_data;
                    endwhile;
                    wp_reset_query();
                    
                    // 缓存24小时
                    set_transient($cache_key, $posts_data, DAY_IN_SECONDS);
                    $cached_data = $posts_data;
                }
            ?>
            <div class="rank-block">
                <div class="rank-header" title="<?php echo esc_attr($title); ?>"><?php echo esc_html($title); ?></div>
                <div class="rank-list">
                    <?php foreach ($cached_data as $index => $post_data): $phnum = $index + 1; ?>
                        <a class="rank-item" href="<?php echo esc_url($post_data['permalink']); ?>" target="_blank" rel="nofollow">
                            <div class="rank-num <?php echo $phnum <= 3 ? 'top'.$phnum : ''; ?>"><?php echo $phnum; ?></div>
                            <div class="rank-thumb"><?php echo $post_data['thumbnail']; ?></div>
                            <div class="rank-info">
                                <div class="rank-title" title="<?php echo esc_attr($post_data['title']); ?>"><?php echo esc_html($post_data['title']); ?></div>
                                <div class="rank-meta"><?php echo esc_html($post_data['views']); ?> 热度</div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
                <?php if (!empty($link) && !empty($link_text)): ?>
                    <div class="rank-footer"><a href="<?php echo esc_url($link); ?>" target="_blank" rel="nofollow"><?php echo esc_html($link_text); ?></a></div>
                <?php endif; ?>
            </div>
        <?php endfor; ?>
    </div>
    <?php
    Panda_CFSwidget::echo_after($instance);
}
?>