<?php
/**
 * Template name: Panda子主题-友链导航美化页面
 * Description:   带有详情的导航美化页面
 */
// 在任何输出之前处理链接详情与重定向，避免 Headers already sent 报错
$post_id = get_queried_object_id();
$is_link_detail = isset($_GET['link_id']) && is_numeric($_GET['link_id']);
$current_link = null;
if ($is_link_detail) {
    $current_link = get_bookmark((int)$_GET['link_id']);
    if (!$current_link) {
        wp_redirect(get_permalink($post_id));
        exit;
    }
    if (isset($_GET['update_visit']) && $_GET['update_visit'] == 1) {
        $current_visits = get_post_meta($current_link->link_id, 'link_visit_count', true);
        $new_visits = empty($current_visits) ? 1 : (int)$current_visits + 1;
        update_post_meta($current_link->link_id, 'link_visit_count', $new_visits);
        wp_redirect($current_link->link_url);
        exit;
    }
}

// 逻辑处理完毕后再加载模板头部，确保未产生任何输出
get_header();

// 读取Zibll页面模板配置
// 兼容：若不存在函数则回退为默认
$page_links_content_s       = function_exists('zib_get_post_meta') ? zib_get_post_meta($post_id, 'page_links_content_s', true) : false;
$page_links_content_position = function_exists('zib_get_post_meta') ? (zib_get_post_meta($post_id, 'page_links_content_position', true) ?: 'top') : 'top';
$page_links_search_s        = function_exists('zib_get_post_meta') ? zib_get_post_meta($post_id, 'page_links_search_s', true) : false;
$page_links_search_types    = function_exists('zib_get_post_meta') ? zib_get_post_meta($post_id, 'page_links_search_types', true) : array();
$page_links_category        = function_exists('zib_get_post_meta') ? zib_get_post_meta($post_id, 'page_links_category', true) : array();
$page_links_style           = function_exists('zib_get_post_meta') ? zib_get_post_meta($post_id, 'page_links_style', true) : 'card';
$page_links_orderby         = function_exists('zib_get_post_meta') ? zib_get_post_meta($post_id, 'page_links_orderby', true) : 'name';
$page_links_order           = function_exists('zib_get_post_meta') ? zib_get_post_meta($post_id, 'page_links_order', true) : 'ASC';
$page_links_limit           = function_exists('zib_get_post_meta') ? (int) zib_get_post_meta($post_id, 'page_links_limit', true) : 0;
$page_links_go_s            = function_exists('zib_get_post_meta') ? zib_get_post_meta($post_id, 'page_links_go_s', true) : false;
$page_links_blank_s         = function_exists('zib_get_post_meta') ? zib_get_post_meta($post_id, 'page_links_blank_s', true) : false;
$page_links_nofollow_s      = function_exists('zib_get_post_meta') ? zib_get_post_meta($post_id, 'page_links_nofollow_s', true) : true;
$page_links_submit_s        = function_exists('zib_get_post_meta') ? zib_get_post_meta($post_id, 'page_links_submit_s', true) : false;
$page_links_submit_title    = function_exists('zib_get_post_meta') ? (zib_get_post_meta($post_id, 'page_links_submit_title', true) ?: '申请入驻导航') : '申请入驻导航';
$page_links_submit_dec      = function_exists('zib_get_post_meta') ? (zib_get_post_meta($post_id, 'page_links_submit_dec', true) ?: '填写您的网站信息，审核通过后将展示在导航页中，请勿提交违规内容') : '填写您的网站信息，审核通过后将展示在导航页中，请勿提交违规内容';
$page_links_submit_sign_s   = function_exists('zib_get_post_meta') ? (zib_get_post_meta($post_id, 'page_links_submit_sign_s', true) ?: true) : true;
$page_links_submit_cats     = function_exists('zib_get_post_meta') ? (zib_get_post_meta($post_id, 'page_links_submit_cats', true) ?: array()) : array();

// 根据选择的分类ID获取term对象，保留原排序
$selected_link_terms = array();
if (!empty($page_links_category) && is_array($page_links_category)) {
    foreach ($page_links_category as $tid) {
        $term_obj = get_term($tid, 'link_category');
        if ($term_obj && !is_wp_error($term_obj)) {
            $selected_link_terms[] = $term_obj;
        }
    }
}


function get_link_visit_count($link_id) {
    $visits = get_post_meta($link_id, 'link_visit_count', true);
    return empty($visits) ? 0 : (int)$visits;
}

function get_link_heat_stars($link_id) {
    $visits = get_link_visit_count($link_id);
    $star_count = 0;
    if ($visits >= 100) {
        $star_count = 5;
    } elseif ($visits >= 51) {
        $star_count = 4;
    } elseif ($visits >= 31) {
        $star_count = 3;
    } elseif ($visits >= 11) {
        $star_count = 2;
    } elseif ($visits >= 1) {
        $star_count = 1;
    }
    $stars_html = '<span class="panda-heat-stars">';
    for ($i = 1; $i <= $star_count; $i++) {
        $stars_html .= '<i class="fa fa-star" style="color:#ffc107;"></i>';
    }
    for ($i = $star_count + 1; $i <= 5; $i++) {
        $stars_html .= '<i class="fa fa-star-o" style="color:#ddd;"></i>';
    }
    $stars_html .= '</span>';
    return $stars_html;
}
?>
<style>

    /* 自定义图片代码在下面 */


.panda-search-wrap {
    height: 320px;
    /* 替换里面的图片即可！ */
    background-image: url(https://img.alicdn.com/imgextra/i3/2210123621994/O1CN01Y99mwQ1QbIqgsIMTp_!!2210123621994.jpg);
    background-size: cover;
    background-position: center;
    border-radius: var(--panda-radius);
    position: relative;
    margin-bottom: 30px;
    overflow: hidden;
}


html{scroll-behavior:smooth;scroll-padding-top:70px}body{margin:0;padding:0;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,sans-serif;background-color:#f8f9fa;color:#333;scrollbar-width:thin}:root{--panda-primary:#4285f4;--panda-primary-light:#e8f0fe;--panda-primary-hover:#3367d6;--panda-gray:#f5f7fa;--panda-gray-deep:#e9ecef;--panda-border:#dee2e6;--panda-text-secondary:#6c757d;--panda-radius:8px;--panda-shadow:0 3px 12px rgba(0,0,0,0.06);--panda-shadow-hover:0 6px 16px rgba(0,0,0,0.08);--heat-star-color:#ffc107}.panda-wrapper{max-width:1200px;margin:0 auto;padding:0 15px}.panda-radius{border-radius:var(--panda-radius)}.panda-mb20{margin-bottom:20px}.panda-mt20{margin-top:20px}.panda-breadcrumb{padding:12px 0;font-size:14px;color:var(--panda-text-secondary)}.panda-breadcrumb a{color:var(--panda-primary);transition:color 0.2s}.panda-breadcrumb a:hover{color:var(--panda-primary-hover)}.panda-breadcrumb span{margin:0 6px}.panda-links-container{display:flex;gap:24px;margin-top:24px}.panda-nav{width:220px;flex-shrink:0}.panda-nav-box{position:sticky;top:24px;background-color:#fff;border-radius:var(--panda-radius);box-shadow:var(--panda-shadow);overflow:hidden}.panda-nav-header{padding:16px 20px;background:linear-gradient(120deg,var(--panda-primary),var(--panda-primary-hover));color:#fff;font-weight:500;font-size:16px;display:flex;align-items:center;gap:10px}.panda-nav-header i{font-size:18px}.panda-nav-list{padding:8px 0}.panda-nav-item{margin:4px 0}.panda-nav-link{display:flex;align-items:center;gap:8px;padding:10px 20px;font-size:14px;transition:all 0.25s;position:relative}.panda-nav-link::before{content:'';width:4px;height:4px;border-radius:50%;background-color:var(--panda-text-secondary);opacity:0;transition:opacity 0.25s}.panda-nav-link:hover{background-color:var(--panda-gray);color:var(--panda-primary)}.panda-nav-link.active{background-color:var(--panda-primary-light);color:var(--panda-primary);font-weight:500}.panda-nav-link.active::before{opacity:1;background-color:var(--panda-primary)}.panda-submit-btn{display:block;width:calc(100% - 40px);margin:16px auto;padding:12px 0;text-align:center;background-color:var(--panda-primary);color:#fff;border-radius:var(--panda-radius);font-size:14px;font-weight:500;transition:all 0.25s;box-shadow:0 2px 6px rgba(66,133,244,0.2)}.panda-submit-btn:hover{background-color:var(--panda-primary-hover);box-shadow:0 4px 8px rgba(66,133,244,0.3);transform:translateY(-1px)}.panda-content{flex-grow:1}

.panda-search-mask{position:absolute;top:0;left:0;width:100%;height:100%;background-color:rgba(0,0,0,0.35);backdrop-filter:blur(2px)}.panda-search-inner{position:relative;z-index:2;height:100%;display:flex;flex-direction:column;justify-content:center;align-items:center;padding:0 15px;max-width:900px;margin:0 auto}.panda-search-title{color:#fff;font-size:26px;margin-bottom:20px;font-weight:500;text-shadow:0 2px 4px rgba(0,0,0,0.3)}.search-tmenu{display:flex;justify-content:center;gap:25px;margin-bottom:18px}.search-tmenu li{color:#fff;font-size:15px;cursor:pointer;padding:6px 8px;border-radius:4px;opacity:0.9;transition:all 0.2s}.search-tmenu li:hover{opacity:1;background-color:rgba(255,255,255,0.1)}.search-tmenu li.active{opacity:1;font-weight:500;background-color:rgba(255,255,255,0.2)}.sousk{width:100%;margin-bottom:18px}#pandaSearchForm{width:100%;display:flex;border-radius:var(--panda-radius);overflow:hidden;box-shadow:0 4px 16px rgba(0,0,0,0.25)}#searchinput{flex-grow:1;height:52px;padding:0 20px;border:none;font-size:15px;outline:none;background-color:#fff}#searc-submit{width:100px;height:52px;border:none;background-color:var(--panda-primary);color:#fff;font-size:15px;font-weight:500;cursor:pointer;transition:background-color 0.2s}#searc-submit:hover{background-color:var(--panda-primary-hover)}.subnav{width:100%}.subnav-item{display:none}.subnav-item.active{display:block}.search-bmenu{display:flex;flex-wrap:wrap;justify-content:center;gap:12px}.search-bmenu li{padding:6px 14px;background-color:rgba(255,255,255,0.15);color:#fff;border-radius:20px;font-size:13px;cursor:pointer;transition:all 0.2s}.search-bmenu li:hover{background-color:rgba(255,255,255,0.25)}.search-bmenu li.on{background-color:var(--panda-primary);font-weight:500}.panda-links-section{background-color:#fff;border-radius:var(--panda-radius);padding:20px;box-shadow:var(--panda-shadow);margin-bottom:30px;transition:box-shadow 0.25s}.panda-links-section:hover{box-shadow:var(--panda-shadow-hover)}.panda-links-header{padding-bottom:12px;border-bottom:1px solid var(--panda-border);margin-bottom:20px;display:flex;justify-content:space-between;align-items:center}.panda-links-title{font-size:18px;font-weight:500;color:#333;margin:0;display:flex;align-items:center;gap:8px}.panda-links-title::before{content:'';width:4px;height:20px;background-color:var(--panda-primary);border-radius:2px}.panda-links-count{color:var(--panda-text-secondary);font-size:14px;margin-left:10px;font-weight:normal}.panda-links-list{display:flex;flex-direction:column;gap:12px}.panda-link-card{display:flex;align-items:center;padding:16px;background-color:var(--panda-gray);border-radius:var(--panda-radius);transition:all 0.25s;position:relative;overflow:hidden}.panda-link-card:hover{background-color:var(--panda-primary-light);transform:translateY(-2px);box-shadow:0 4px 12px rgba(66,133,244,0.1)}.panda-link-icon{width:52px;height:52px;border-radius:50%;background-color:#fff;overflow:hidden;margin-right:18px;flex-shrink:0;box-shadow:0 2px 6px rgba(0,0,0,0.05)}.panda-link-icon img{width:100%;height:100%;object-fit:cover}.panda-link-content{flex-grow:1;overflow:hidden}.panda-link-name{font-size:16px;font-weight:500;margin:0 0 6px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;color:#333}.panda-link-desc{font-size:13px;color:var(--panda-text-secondary);margin:0 0 4px;line-height:1.5;display:-webkit-box;-webkit-line-clamp:1;-webkit-box-orient:vertical;overflow:hidden}.panda-link-heat{display:flex;align-items:center;gap:8px;font-size:12px;color:#999;margin:0}.panda-heat-stars i{font-size:12px;margin:0 1px}.panda-link-actions{display:flex;gap:10px;margin-left:15px;flex-shrink:0}.panda-link-btn{padding:6px 16px;border-radius:4px;font-size:13px;font-weight:500;transition:all 0.25s;text-align:center;cursor:pointer}.panda-link-detail{background-color:#fff;color:var(--panda-primary);border:1px solid var(--panda-primary)}.panda-link-detail:hover{background-color:var(--panda-primary);color:#fff}.panda-link-visit{background-color:var(--panda-primary);color:#fff;border:1px solid var(--panda-primary)}.panda-link-visit:hover{background-color:var(--panda-primary-hover);border-color:var(--panda-primary-hover)}.panda-detail-wrap{background-color:#fff;border-radius:var(--panda-radius);padding:24px;box-shadow:var(--panda-shadow);margin-top:24px}.panda-detail-header{display:flex;align-items:center;gap:20px;padding-bottom:20px;border-bottom:1px solid var(--panda-border);margin-bottom:20px}.panda-detail-icon{width:80px;height:80px;border-radius:50%;background-color:var(--panda-gray);overflow:hidden;flex-shrink:0;box-shadow:0 3px 8px rgba(0,0,0,0.08)}.panda-detail-icon img{width:100%;height:100%;object-fit:cover}.panda-detail-header-content{flex-grow:1}.panda-detail-title{font-size:24px;font-weight:500;margin:0 0 8px;color:#333}.panda-detail-header-heat{display:flex;align-items:center;gap:10px;margin-bottom:12px}.panda-detail-heat-count{font-size:14px;color:var(--panda-text-secondary)}.panda-detail-heat-stars i{font-size:14px;margin:0 2px;color:var(--heat-star-color)}.panda-detail-url{font-size:14px;color:var(--panda-primary);margin:0 0 12px;word-break:break-all}.panda-detail-header-actions{display:flex;gap:12px;flex-shrink:0}.panda-detail-btn{padding:8px 20px;border-radius:4px;font-size:14px;font-weight:500;transition:all 0.25s;text-align:center;cursor:pointer}.panda-detail-content{padding:10px 0}.panda-detail-section{margin-bottom:24px}.panda-detail-section-title{font-size:16px;font-weight:500;margin:0 0 12px;color:#333;display:flex;align-items:center;gap:8px}.panda-detail-section-title::before{content:'';width:4px;height:16px;background-color:var(--panda-primary);border-radius:2px}.panda-detail-desc{font-size:15px;color:#555;line-height:1.8;margin:0;padding:12px;background-color:var(--panda-gray);border-radius:var(--panda-radius)}.panda-detail-meta{display:flex;flex-wrap:wrap;gap:20px;padding:12px;background-color:var(--panda-gray);border-radius:var(--panda-radius)}.panda-detail-meta-item{display:flex;align-items:center;gap:8px;font-size:14px;color:var(--panda-text-secondary)}.panda-detail-meta-label{font-weight:500;color:#333}.panda-back-list{display:inline-flex;align-items:center;gap:8px;padding:8px 16px;background-color:var(--panda-gray);border-radius:var(--panda-radius);font-size:14px;color:#333;transition:all 0.25s;margin-top:10px}.panda-back-list:hover{background-color:var(--panda-primary-light);color:var(--panda-primary)}@media (max-width:992px){.panda-link-actions,.panda-detail-header-actions{flex-direction:column;gap:6px}.panda-link-btn,.panda-detail-btn{padding:5px 12px;font-size:12px}.panda-detail-header{flex-direction:column;align-items:flex-start;gap:15px}.panda-detail-header-actions{width:100%;flex-direction:row;justify-content:flex-end;margin-top:10px}.search-tmenu{gap:15px}.search-tmenu li{font-size:14px}.search-bmenu{gap:8px}.search-bmenu li{padding:5px 12px;font-size:12px}}@media (max-width:768px){.panda-nav{display:none}.panda-links-container{gap:15px;margin-top:15px}.panda-search-wrap{height:280px}.panda-search-title{font-size:22px;margin-bottom:15px}#searchinput{height:48px;font-size:14px}#searc-submit{width:90px;height:48px;font-size:14px}.panda-link-card{padding:12px;flex-direction:column;align-items:flex-start}.panda-link-icon{width:48px;height:48px;margin-right:0;margin-bottom:12px}.panda-link-actions{width:100%;margin-left:0;margin-top:12px;flex-direction:row;justify-content:flex-end}.panda-detail-wrap{padding:16px}.panda-detail-icon{width:60px;height:60px}.panda-detail-title{font-size:20px}.panda-detail-meta{gap:15px}.panda-mobile-nav{display:block;margin-bottom:20px}}.panda-mobile-nav{display:none;background-color:#fff;border-radius:var(--panda-radius);box-shadow:var(--panda-shadow);overflow:hidden}.panda-mobile-nav-header{padding:14px 20px;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid var(--panda-border);font-weight:500;font-size:15px;color:#333}.panda-mobile-nav-toggle{background:none;border:none;font-size:18px;cursor:pointer;color:var(--panda-text-secondary);transition:color 0.25s}.panda-mobile-nav-toggle:hover{color:var(--panda-primary)}.panda-mobile-nav-list{max-height:0;overflow:hidden;transition:max-height 0.3s ease}.panda-mobile-nav-list.show{max-height:500px}.panda-mobile-nav-item{border-bottom:1px solid var(--panda-border)}.panda-mobile-nav-item:last-child{border-bottom:none}.panda-mobile-nav-link{display:block;padding:12px 20px;font-size:14px;color:#333;transition:all 0.25s}.panda-mobile-nav-link:hover{background-color:var(--panda-gray);color:var(--panda-primary)}.panda-mobile-nav-link.active{background-color:var(--panda-primary-light);color:var(--panda-primary);font-weight:500}.panda-mobile-submit{padding:12px 20px}.panda-mobile-submit-btn{display:block;width:100%;padding:12px 0;text-align:center;background-color:var(--panda-primary);color:#fff;border-radius:var(--panda-radius);font-size:14px;font-weight:500;transition:all 0.25s}.panda-mobile-submit-btn:hover{background-color:var(--panda-primary-hover)}.panda-backtop{position:fixed;bottom:30px;right:30px;width:44px;height:44px;background-color:var(--panda-primary);color:#fff;border-radius:50%;display:flex;justify-content:center;align-items:center;box-shadow:0 4px 12px rgba(66,133,244,0.3);cursor:pointer;opacity:0;visibility:hidden;transition:all 0.3s;z-index:99;font-size:18px}.panda-backtop:hover{background-color:var(--panda-primary-hover);transform:translateY(-3px);box-shadow:0 6px 16px rgba(66,133,244,0.4)}.panda-backtop.show{opacity:1;visibility:visible}.panda-empty{background-color:#fff;border-radius:var(--panda-radius);padding:40px 20px;text-align:center;box-shadow:var(--panda-shadow);margin-top:24px}.panda-empty-icon{font-size:48px;color:var(--panda-gray-deep);margin-bottom:16px}.panda-empty-text{font-size:16px;color:var(--panda-text-secondary);margin:0 0 20px}.panda-empty-btn{display:inline-block;padding:10px 24px;background-color:var(--panda-primary);color:#fff;border-radius:var(--panda-radius);font-size:14px;font-weight:500;transition:all 0.25s}.panda-empty-btn:hover{background-color:var(--panda-primary-hover)}
</style>

<body class="archive post-type-archive post-type-archive-links">
    <div id="page" class="site">
        <div id="content" class="site-content">
            <div class="panda-wrapper">
                <?php if (!$is_link_detail): ?>
                    <?php
                    // 搜索引擎模块（置于页面上方，使用zibll渲染）
                    if ($page_links_search_s && function_exists('zib_link_get_search_cover')) {
                        echo zib_link_get_search_cover();
                    }
                    // 页面内容显示（顶部）
                    if ($page_links_content_s && $page_links_content_position === 'top') {
                        echo '<div class="panda-links-section">';
                        the_content();
                        echo '</div>';
                    }
                    ?>
                <?php endif; ?>
                <div class="panda-mobile-nav">
                    <div class="panda-mobile-nav-header">
                        <span>网址分类导航</span>
                        <button class="panda-mobile-nav-toggle" id="pandaMobileNavToggle">
                            <i class="fa fa-chevron-down"></i>
                        </button>
                    </div>
                    <div class="panda-mobile-nav-list" id="pandaMobileNavList">
                        <?php
                        if (!empty($selected_link_terms)):
                            foreach ($selected_link_terms as $key => $link_cat):
                                $active = $key == 0 ? 'active' : '';
                                echo '<div class="panda-mobile-nav-item">';
                                echo '<a href="#panda-link-' . $link_cat->term_id . '" class="panda-mobile-nav-link ' . $active . '" data-catid="' . $link_cat->term_id . '">';
                                echo $link_cat->name;
                                echo '</a></div>';
                            endforeach;
                        else:
                            echo '<div class="panda-mobile-nav-item"><span style="padding:12px 20px;display:block;color:var(--panda-text-secondary);">请在页面模板配置中选择显示的链接分类</span></div>';
                        endif;
                        ?>
                        <?php if ($page_links_submit_s): ?>
                        <div class="panda-mobile-submit">
                            <a href="#submit-links-modal" data-toggle="modal" class="panda-mobile-submit-btn">
                                申请入驻
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if (!$is_link_detail): ?>
                <div class="panda-links-container">
                    <div class="panda-nav">
                        <div class="panda-nav-box">
                            <div class="panda-nav-header">
                                <i class="fa fa-compass"></i>
                                <span>网址导航</span>
                            </div>
                            <ul class="panda-nav-list" id="pandaNavList">
                                <?php
                                if (!empty($selected_link_terms)):
                                    foreach ($selected_link_terms as $key => $link_cat):
                                        $active = $key == 0 ? 'active' : '';
                                        echo '<li class="panda-nav-item">';
                                        echo '<a href="#panda-link-' . $link_cat->term_id . '" class="panda-nav-link ' . $active . '" data-catid="' . $link_cat->term_id . '">';
                                        echo $link_cat->name;
                                        echo '</a></li>';
                                    endforeach;
                                else:
                                    echo '<li class="panda-nav-item"><span style="padding:0 20px;font-size:14px;color:var(--panda-text-secondary);">暂无分类数据</span></li>';
                                endif;
                                ?>
                            </ul>
                            <?php if ($page_links_submit_s): ?>
                            <a href="#submit-links-modal" data-toggle="modal" class="panda-submit-btn">
                                申请入驻
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="panda-content">
                        <?php if ($page_links_search_s): ?>
                        <div class="panda-search-wrap">
                            <div class="panda-search-mask"></div>
                            <div class="panda-search-inner">
                                <h2 class="panda-search-title"><?php global $post;echo get_the_title($post); ?> · <?php echo get_bloginfo('name');?></h2>
                                <ul class="search-tmenu">
                                    <li class="active">
                                        <span>常用</span>
                                    </li>
                                    <li>
                                        <span>工具</span>
                                    </li>
                                    <li>
                                        <span>社区</span>
                                    </li>
                                    <li>
                                        <span>灵感</span>
                                    </li>
                                </ul>
                                <div class="sousk">
                                    <form id="pandaSearchForm" class="shadow b2-radius" action="/?s=" method="get" target="_blank">
                                        <input id="searchinput" class="" type="text" placeholder="站内搜索" autocomplete="off">
                                        <button id="searc-submit" class="jitheme-site-search" type="submit">搜索</button>
                                    </form>
                                    <div class="b2-links-yl">
                                    </div>
                                </div>
                                <div class="subnav">
                                    <div class="subnav-item active">
                                        <ul class="search-bmenu uk-padding-remove">
                                            <li class="search-item on" url="/?s=">站内</li>
                                            <li class="search-item" url="https://www.baidu.com/s?wd=">百度</li>
                                            <li class="search-item" url="https://www.google.com/search?q=">Google</li>
                                            <li class="search-item" url="https://www.so.com/s?q=">360</li>
                                            <li class="search-item" url="https://www.sogou.com/web?query=">搜狗</li>
                                            <li class="search-item" url="https://cn.bing.com/search?q=">必应</li>
                                            <li class="search-item" url="https://yz.m.sm.cn/s?q=">神马</li>
                                        </ul>
                                    </div>
                                    <div class="subnav-item">
                                        <ul class="search-bmenu uk-padding-remove">
                                            <li class="search-item on" url="http://rank.chinaz.com/all/">权重查询</li>
                                            <li class="search-item" url="http://link.chinaz.com/">友链检测</li>
                                            <li class="search-item" url="https://icp.aizhan.com/">备案查询</li>
                                            <li class="search-item" url="http://ping.chinaz.com/">PING检测</li>
                                            <li class="search-item" url="http://tool.chinaz.com/Links/?DAddress=">死链检测</li>
                                        </ul>
                                    </div>
                                    <div class="subnav-item">
                                        <ul class="search-bmenu uk-padding-remove">
                                            <li class="search-item on" url="https://www.zhihu.com/search?type=content&q=">知乎</li>
                                            <li class="search-item" url="http://weixin.sogou.com/weixin?type=2&query=">微信</li>
                                            <li class="search-item" url="http://s.weibo.com/weibo/">微博</li>
                                            <li class="search-item" url="https://www.douban.com/search?q=">豆瓣</li>
                                        </ul>
                                    </div>
   
                                    <div class="subnav-item">
                                        <ul class="search-bmenu uk-padding-remove">
                                            <li class="search-item on" url="https://huaban.com/search/?q=">花瓣</li>
                                            <li class="search-item" url="https://dribbble.com/search/">dribbble</li>
                                            <li class="search-item" url="https://www.behance.net/search?search=">behance</li>
                                            <li class="search-item" url="http://www.zcool.com.cn/search/content?&word=">站酷</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php
                        if (!empty($selected_link_terms)):
                            foreach ($selected_link_terms as $link_cat) :
                                $args = array(
                                    'orderby'  => $page_links_orderby ? $page_links_orderby : 'name',
                                    'order'    => $page_links_order ? $page_links_order : 'ASC',
                                    'limit'    => $page_links_limit ? (int) $page_links_limit : -1,
                                    'category' => $link_cat->term_id,
                                );
                                $bookmarks = get_bookmarks($args);
                                if (empty($bookmarks)) continue;
                        ?>
                        <div class="panda-links-section">
                            <div class="panda-links-header">
                                <h3 class="panda-links-title" id="panda-link-<?php echo $link_cat->term_id ?>">
                                    <?php echo $link_cat->name; ?>
                                    <span class="panda-links-count">(<?php echo count($bookmarks); ?>个)</span>
                                </h3>
                            </div>
                            <div class="panda-links-list">
                                <?php foreach ($bookmarks as $bookmark): 
                                    $visit_count = get_link_visit_count($bookmark->link_id);
                                    $heat_stars = get_link_heat_stars($bookmark->link_id);
                                ?>
                                <div class="panda-link-card">
                                    <div class="panda-link-icon">
                                        <?php if ($bookmark->link_image): ?>
                                            <img src="<?php echo $bookmark->link_image; ?>" alt="<?php echo $bookmark->link_name; ?>">
                                        <?php else: ?>
                                            <img src="https://www.vxras.com/wp-content/uploads/2024/05/猫爪.png" alt="默认图标">
                                        <?php endif; ?>
                                    </div>
                                    <div class="panda-link-content">
                                        <h4 class="panda-link-name"><?php echo $bookmark->link_name; ?></h4>
                                        <p class="panda-link-desc"><?php echo $bookmark->link_description ?: '暂无网站描述'; ?></p>
                                        <p class="panda-link-heat">
                                            访问量：<?php echo $visit_count; ?>次 <?php echo $heat_stars; ?>
                                        </p>
                                    </div>
                                    <div class="panda-link-actions">
                                        <a href="<?php echo add_query_arg('link_id', $bookmark->link_id, get_permalink($post_id)); ?>" class="panda-link-btn panda-link-detail" title="查看详情">详情</a>
                                        <?php
                                        $fallback_url = $bookmark->link_url;
                                        if ($page_links_go_s) {
                                            if (function_exists('zib_get_gourl')) {
                                                $fallback_url = zib_get_gourl($bookmark->link_url);
                                            } else {
                                                $fallback_url = add_query_arg('golink', base64_encode($bookmark->link_url), home_url('/'));
                                            }
                                        }
                                        $rel_attr = $page_links_nofollow_s ? 'nofollow noopener' : 'noopener';
                                        ?>
                                        <a href="javascript:;" class="panda-link-btn panda-link-visit" data-linkid="<?php echo $bookmark->link_id; ?>" data-linkurl="<?php echo esc_attr($fallback_url); ?>" rel="<?php echo esc_attr($rel_attr); ?>">直达</a>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endforeach; else: ?>
                        <div class="panda-empty">
                            <div class="panda-empty-icon">
                                <i class="fa fa-folder-open-o"></i>
                            </div>
                            <p class="panda-empty-text">暂无链接数据</p>
                            <?php if (current_user_can('manage_links')): ?>
                            <a href="<?php echo admin_url('link-manager.php'); ?>" target="_blank" class="panda-empty-btn">
                                前往添加链接
                            </a>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php
                // 页面内容显示（底部）
                if ($page_links_content_s && $page_links_content_position === 'bottom') {
                    echo '<div class="panda-links-section">';
                    the_content();
                    echo '</div>';
                }
                ?>
                <?php else: ?>
                <div class="panda-links-container">
                    <div class="panda-nav">
                        <div class="panda-nav-box">
                            <div class="panda-nav-header">
                                <i class="fa fa-compass"></i>
                                <span>网址导航</span>
                            </div>
                            <ul class="panda-nav-list" id="pandaNavList">
                                <?php
                                $current_link_cat_ids = wp_get_object_terms($current_link->link_id, 'link_category', array('fields' => 'ids'));
                                $current_cat_id = !empty($current_link_cat_ids) ? $current_link_cat_ids[0] : 0;
                                if (!empty($selected_link_terms)):
                                    foreach ($selected_link_terms as $key => $link_cat):
                                        $active = $link_cat->term_id == $current_cat_id ? 'active' : '';
                                        echo '<li class="panda-nav-item">';
                                        echo '<a href="' . add_query_arg(array('link_id' => null), get_permalink($post_id)) . '#panda-link-' . $link_cat->term_id . '" class="panda-nav-link ' . $active . '" data-catid="' . $link_cat->term_id . '">';
                                        echo $link_cat->name;
                                        echo '</a></li>';
                                    endforeach;
                                else:
                                    echo '<li class="panda-nav-item"><span style="padding:0 20px;font-size:14px;color:var(--panda-text-secondary);">暂无分类数据</span></li>';
                                endif;
                                ?>
                            </ul>
                            <a href="#submit-links-modal" data-toggle="modal" class="panda-submit-btn">
                                申请入驻
                            </a>
                        </div>
                    </div>

                    <div class="panda-content">
                        <div class="panda-breadcrumb">
                            <a href="<?php echo get_permalink($post_id); ?>">网址导航</a>
                            <span>/</span>
                            <?php
                            $link_cats = wp_get_object_terms($current_link->link_id, 'link_category');
                            if (!empty($link_cats) && !is_wp_error($link_cats)):
                                $cat = $link_cats[0];
                                echo '<a href="' . add_query_arg(array('link_id' => null), get_permalink($post_id)) . '#panda-link-' . $cat->term_id . '">' . $cat->name . '</a>';
                                echo '<span>/</span>';
                            endif;
                            ?>
                            <span>网站详情</span>
                        </div>

                        <div class="panda-detail-wrap">
                            <div class="panda-detail-header">
                                <div class="panda-detail-icon">
                                    <?php if ($current_link->link_image): ?>
                                        <img src="<?php echo $current_link->link_image; ?>" alt="<?php echo $current_link->link_name; ?>">
                                    <?php else: ?>
                                        <img src="https://www.vxras.com/wp-content/uploads/2024/05/猫爪.png" alt="默认图标">
                                    <?php endif; ?>
                                </div>
                                <div class="panda-detail-header-content">
                                    <h1 class="panda-detail-title"><?php echo $current_link->link_name; ?></h1>
                                    <div class="panda-detail-header-heat">
                                        <div class="panda-detail-heat-count">访问量：<?php echo get_link_visit_count($current_link->link_id); ?>次</div>
                                        <div class="panda-detail-heat-stars"><?php echo get_link_heat_stars($current_link->link_id); ?></div>
                                    </div>
                                    <div class="panda-detail-url"><?php echo $current_link->link_url; ?></div>
                                </div>
                                <div class="panda-detail-header-actions">
                                    <?php
                                    $detail_href = $current_link->link_url;
                                    if ($page_links_go_s) {
                                        if (function_exists('zib_get_gourl')) {
                                            $detail_href = zib_get_gourl($current_link->link_url);
                                        } else {
                                            $detail_href = add_query_arg('golink', base64_encode($current_link->link_url), home_url('/'));
                                        }
                                    }
                                    $detail_target = $page_links_blank_s ? '_blank' : '_self';
                                    $detail_rel = $page_links_nofollow_s ? 'nofollow noopener' : 'noopener';
                                    ?>
                                    <a href="<?php echo esc_url($detail_href); ?>" class="panda-link-btn panda-link-visit" data-linkid="<?php echo $current_link->link_id; ?>" data-linkurl="<?php echo esc_attr($current_link->link_url); ?>" target="<?php echo esc_attr($detail_target); ?>" rel="<?php echo esc_attr($detail_rel); ?>">直达网站</a>
                                    <a href="<?php echo get_permalink($post_id); ?>#panda-link-<?php echo $current_cat_id; ?>" class="panda-link-btn panda-link-detail">返回列表</a>
                                </div>
                            </div>

                            <div class="panda-detail-content">
                                <div class="panda-detail-section">
                                    <h3 class="panda-detail-section-title">网站描述</h3>
                                    <p class="panda-detail-desc">
                                        <?php echo !empty($current_link->link_description) ? nl2br($current_link->link_description) : '暂无网站描述信息'; ?>
                                    </p>
                                </div>

                                <div class="panda-detail-section">
                                    <h3 class="panda-detail-section-title">网站信息</h3>
                                    <div class="panda-detail-meta">
                                        <div class="panda-detail-meta-item">
                                            <span class="panda-detail-meta-label">所属分类：</span>
                                            <span>
                                                <?php
                                                if (!empty($link_cats) && !is_wp_error($link_cats)):
                                                    echo $cat->name;
                                                else:
                                                    echo '未分类';
                                                endif;
                                                ?>
                                            </span>
                                        </div>
                                        <div class="panda-detail-meta-item">
                                            <span class="panda-detail-meta-label">总访问量：</span>
                                            <span><?php echo get_link_visit_count($current_link->link_id); ?>次</span>
                                        </div>
                                        <div class="panda-detail-meta-item">
                                            <span class="panda-detail-meta-label">链接热度：</span>
                                            <span><?php echo get_link_heat_stars($current_link->link_id); ?></span>
                                        </div>
                                        <div class="panda-detail-meta-item">
                                            <span class="panda-detail-meta-label">链接类型：</span>
                                            <span><?php echo $current_link->link_rel ? $current_link->link_rel : '普通链接'; ?></span>
                                        </div>
                                        <div class="panda-detail-meta-item">
                                            <span class="panda-detail-meta-label">链接状态：</span>
                                            <span><?php echo $current_link->link_visible == 'Y' ? '已显示' : '未显示'; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <a href="<?php echo add_query_arg(array('link_id' => null), get_permalink($post_id)) . '#panda-link-' . $current_cat_id; ?>" class="panda-back-list">
                                <i class="fa fa-arrow-left"></i>
                                <span>返回上一级分类列表</span>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="panda-backtop" id="pandaBacktop">
        <i class="fa fa-chevron-up"></i>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const GO_S = <?php echo $page_links_go_s ? 'true' : 'false'; ?>;
            const OPEN_TARGET_BLANK = <?php echo $page_links_blank_s ? 'true' : 'false'; ?>;
            <?php if (!$is_link_detail): ?>
            const searchTmenu = document.querySelectorAll('.search-tmenu li');
            const subnavItems = document.querySelectorAll('.subnav-item');
            const sceneData = [
                { placeholder: '站内搜索', defaultUrl: '/?s=' },
                { placeholder: '权重查询(不带http/https)', defaultUrl: 'http://rank.chinaz.com/all/' },
                { placeholder: '知乎搜索', defaultUrl: 'https://www.zhihu.com/search?type=content&q=' },
                { placeholder: '花瓣搜索', defaultUrl: 'https://huaban.com/search/?q=' }
            ];

            searchTmenu.forEach((item, index) => {
                item.addEventListener('click', function() {
                    searchTmenu.forEach(li => li.classList.remove('active'));
                    this.classList.add('active');
                    subnavItems.forEach(sub => sub.classList.remove('active'));
                    subnavItems[index].classList.add('active');
                    const defaultUrl = sceneData[index].defaultUrl;
                    const placeholder = sceneData[index].placeholder;
                    document.getElementById('pandaSearchForm').action = defaultUrl;
                    document.getElementById('searchinput').placeholder = placeholder;
                    const currentSubItems = subnavItems[index].querySelectorAll('.search-item');
                    currentSubItems.forEach(li => li.classList.remove('on'));
                    currentSubItems[0].classList.add('on');
                });
            });

            const allSearchItems = document.querySelectorAll('.search-item');
            allSearchItems.forEach(item => {
                item.addEventListener('click', function() {
                    const parentList = this.parentElement;
                    parentList.querySelectorAll('.search-item').forEach(li => li.classList.remove('on'));
                    this.classList.add('on');
                    const url = this.getAttribute('url');
                    const placeholder = this.textContent;
                    document.getElementById('pandaSearchForm').action = url;
                    document.getElementById('searchinput').placeholder = placeholder;
                });
            });

            const searchForm = document.getElementById('pandaSearchForm');
            const searchInput = document.getElementById('searchinput');
            const searchBtn = document.getElementById('searc-submit');
            
            searchBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const val = searchInput.value.trim();
                if (val) {
                    window.open(searchForm.action + encodeURIComponent(val));
                } else {
                    alert('请输入搜索内容');
                }
            });

            searchForm.addEventListener('keydown', function(e) {
                if (e.keyCode === 13) {
                    e.preventDefault();
                    const val = searchInput.value.trim();
                    if (val) {
                        window.open(searchForm.action + encodeURIComponent(val));
                    } else {
                        alert('请输入搜索内容');
                    }
                }
            });
            <?php endif; ?>

            const mobileNavToggle = document.getElementById('pandaMobileNavToggle');
            const mobileNavList = document.getElementById('pandaMobileNavList');
            if (mobileNavToggle && mobileNavList) {
                const mobileNavIcon = mobileNavToggle.querySelector('i');
                
                mobileNavToggle.addEventListener('click', function() {
                    mobileNavList.classList.toggle('show');
                    mobileNavIcon.classList.toggle('fa-chevron-down');
                    mobileNavIcon.classList.toggle('fa-chevron-up');
                });

                document.querySelectorAll('.panda-mobile-nav-link').forEach(link => {
                    link.addEventListener('click', function() {
                        mobileNavList.classList.remove('show');
                        mobileNavIcon.classList.add('fa-chevron-down');
                        mobileNavIcon.classList.remove('fa-chevron-up');
                    });
                });
            }

            <?php if (!$is_link_detail): ?>
            const navLinks = document.querySelectorAll('.panda-nav-link, .panda-mobile-nav-link');
            const sections = document.querySelectorAll('.panda-links-title');
            
            window.addEventListener('scroll', function() {
                const scrollTop = window.scrollY;
                
                sections.forEach(section => {
                    const sectionTop = section.offsetTop - 120;
                    const sectionBottom = sectionTop + section.parentElement.offsetHeight;
                    const catId = section.id.replace('panda-link-', '');
                    
                    if (scrollTop >= sectionTop && scrollTop < sectionBottom) {
                        navLinks.forEach(link => {
                            link.classList.remove('active');
                            if (link.getAttribute('data-catid') === catId) {
                                link.classList.add('active');
                            }
                        });
                    }
                });

                toggleBacktop(scrollTop);
            });

            document.getElementById('pandaSearchForm').action = '/?s=';
            document.getElementById('searchinput').placeholder = '站内搜索';
            <?php else: ?>
            window.addEventListener('scroll', function() {
                toggleBacktop(window.scrollY);
            });
            <?php endif; ?>

            const backtop = document.getElementById('pandaBacktop');
            if (backtop) {
                backtop.addEventListener('click', function() {
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                });

                toggleBacktop(window.scrollY);
            }

            function toggleBacktop(scrollTop) {
                if (backtop) {
                    if (scrollTop > 600) {
                        backtop.classList.add('show');
                    } else {
                        backtop.classList.remove('show');
                    }
                }
            }
            <?php if (!$is_link_detail): ?>
            const visitBtns = document.querySelectorAll('.panda-link-visit[data-linkid]');
            visitBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const linkId = this.getAttribute('data-linkid');
                    const fallbackUrl = this.getAttribute('data-linkurl');
                    jQuery.ajax({
                        url: '<?php echo admin_url('admin-ajax.php'); ?>',
                        type: 'POST',
                        data: {
                            action: 'update_link_visit_count',
                            link_id: linkId
                        },
                        success: function(response) {
                            let targetUrl = null;
                            if (response && response.success && response.data) {
                                if (GO_S && response.data.go_link_url) {
                                    targetUrl = response.data.go_link_url;
                                } else if (response.data.link_url) {
                                    targetUrl = response.data.link_url;
                                }
                            }
                            if (!targetUrl && fallbackUrl) {
                                targetUrl = fallbackUrl;
                            }
                            if (targetUrl) {
                                window.open(targetUrl, OPEN_TARGET_BLANK ? '_blank' : '_self');
                            }
                        },
                        error: function() {
                            if (fallbackUrl) {
                                window.open(fallbackUrl, OPEN_TARGET_BLANK ? '_blank' : '_self');
                            }
                        }
                    });
                });
            });
            <?php else: ?>
            // 详情页按钮：点击时也先计数，再打开go链接
            const detailVisitBtn = document.querySelector('.panda-link-visit[data-linkid]');
            if (detailVisitBtn) {
                detailVisitBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const linkId = this.getAttribute('data-linkid');
                    const fallbackUrl = this.getAttribute('data-linkurl');
                    const goHref = this.getAttribute('href');
                    jQuery.ajax({
                        url: '<?php echo admin_url('admin-ajax.php'); ?>',
                        type: 'POST',
                        data: {
                            action: 'update_link_visit_count',
                            link_id: linkId
                        },
                        complete: function() {
                            const targetUrl = goHref || fallbackUrl;
                            window.open(targetUrl, OPEN_TARGET_BLANK ? '_blank' : '_self');
                        }
                    });
                });
            }
            <?php endif; ?>
        });
    </script>
</body>

<?php
if (function_exists('zib_submit_links_modal') && $page_links_submit_s) {
    $submit_args = array(
        'title' => zib_get_post_meta($post_id, 'page_links_submit_title', true) ?: '申请入驻导航',
        'dec'   => zib_get_post_meta($post_id, 'page_links_submit_dec', true) ?: '填写您的网站信息，审核通过后将展示在导航页中，请勿提交违规内容',
        'sign'  => zib_get_post_meta($post_id, 'page_links_submit_sign_s', true) ?: true,
        'cats'  => zib_get_post_meta($post_id, 'page_links_submit_cats', true) ?: array(),
    );
    echo zib_submit_links_modal($submit_args);
}
get_footer();
?>