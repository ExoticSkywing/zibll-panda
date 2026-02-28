<?php
// 使用Panda_CFSwidget类创建一个名为'panda_author_widget'的小工具
Panda_CFSwidget::create('panda_author_widget', array(
    'title'       => 'author-创作者计划',
    'zib_title'   => true,
    'zib_affix'   => true,
    'zib_show'    => true,
    'description' => '用于鼓励创作者的激励计划小工具',
    'fields'      => array(
        array(
            'title'       => '内容设置',
            'id'          => 'additional_content',
            'type'        => 'textarea',
            'default'     => '本站开放社区创作者计划泛指通过发布文章、社区帖子和社区提问解惑，以及提供优质评论，为创作者提供收益机会，同时创作者也可与其他用户建立交流和互动.',
            'description' => '输入激励计划的描述内容'
        ),
        array(
            'title'       => '规则详情链接',
            'id'          => 'link',
            'type'        => 'text',
            'default'     => panda_get_domain(),
            'description' => '输入规则详情页面的链接'
        ),
        array(
            'title'       => '积分比例 (1元 = N积分)',
            'id'          => 'conversion_rate',
            'type'        => 'text',
            'default'     => '50',
            'description' => '默认1元=50积分'
        ),
        array(
            'title'       => '点击加入链接',
            'id'          => 'custom_link',
            'type'        => 'text',
            'default'     => panda_get_domain() . 'newposts/',
            'description' => '输入加入创作者计划的链接'
        )
    )
));

// 定义显示小工具的函数
function panda_author_widget($args, $instance) {
    // 获取小工具字段中的值
    $link = !empty($instance['link']) ? $instance['link'] : panda_get_domain();
    $conversion_rate = !empty($instance['conversion_rate']) ? $instance['conversion_rate'] : 50; 
    $custom_link = !empty($instance['custom_link']) ? $instance['custom_link'] : panda_get_domain() . 'newposts/';
    $additional_content = !empty($instance['additional_content']) ? $instance['additional_content'] : '本站开放社区创作者计划...';

    $allusers = get_users(['has_published_posts' => ['post']]);
    $authors_count = count($allusers);

    // 加载样式 (保持原有样式不变)
    $static_panda_url = panda_pz('static_panda');
    wp_enqueue_style('panda-author-widget-style', $static_panda_url . '/assets/css/widgets/author-widget.css', array(), '1.0.0');
    
    // 在小工具内容之前调用Panda_CFSwidget的echo_before函数
    Panda_CFSwidget::echo_before($instance, '');
    
    // 完全保留原有的HTML结构和样式
    ?>
    <div class="panda-author zib-widget"> 
        <span></span> 
        <div class="panda-author-content"> 
            <h3 class="panda-fw-semibold">
                <i class="ti ti-brand-powershell"></i>创作者激励计划
            </h3> 
            <span class="panda-content-int"><?php echo $additional_content; ?>
                <a href="<?php echo esc_url($link); ?>" target="_blank" rel="noopener">规则详情</a>
            </span> 
            <div class="panda-justify-content-between" style="display: flex;">
                <div> 
                    <span style="font-size: 30px;color: var(--theme-color);font-weight: 600; margin-right: 2px;"><?php echo $authors_count; ?></span>位
                    <p>创作者加入</p>
                </div>
                <div> 
                    <span style="font-size: 30px;color: var(--theme-color);font-weight: 600;margin-right: 2px;"><?php echo number_format(calculate_total_points() / $conversion_rate, 2); ?></span>元
                    <p>累计发放收益</p>
                </div>
            </div> 
            <div class="panda-zeromo-joinbtn"> 
                <a href="<?php echo esc_url($custom_link); ?>" class="panda-author-join btn" target="_blank" rel="noopener">立即加入</a> 
                <a href="<?php echo esc_url($link); ?>" class="panda-author-more btn" target="_blank" rel="noopener">规则详情</a> 
            </div>
        </div>
    </div>
    <?php

    // 在小工具内容之后调用Panda_CFSwidget的echo_after函数
    Panda_CFSwidget::echo_after($instance);
}
// 保留原有的辅助函数
function calculate_total_points() {
    global $wpdb;
    $total_points = $wpdb->get_var("SELECT SUM(meta_value) FROM $wpdb->usermeta WHERE meta_key = 'points'");
    return $total_points;
}
function panda_get_domain() {
    return '自定义链接';
}