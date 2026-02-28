<?php
/*
 * @Author        : SCBKW
 * @Url           : scbkw.com
 * @Date          : 2022-10-02 18:08:54
 * @LastEditTime: 2025-08-25 17:52:10
 * @Email         : 528609062@qq.com
 * @Project       : panda
 * @Description   : 一款极其优雅的Zibll子主题
 * @Read me       : 感谢您使用panda，主题源码有详细的注释，支持二次开发。
 * @Remind        : 使用盗版主题会存在各种未知风险。支持正版，从我做起！
 */

$require_once = array(
    // 已优化
    'widgets/ad_img_widgets.php',
    'widgets/adver-widgets.php',
    'widgets/author-widgets.php',
    'widgets/beatips-widgets.php',
    'widgets/block-widgets.php',
    'widgets/contact-widgets.php',
    'widgets/festival-widgets.php',
    'widgets/demo.php',
    'widgets/down_line-widgets.php',//待修改
    'widgets/down_line2-widgets.php',//待修改
    'widgets/hot-widgets.php',
    'widgets/img_post.php',
    'widgets/imgs-widgets.php',
    'widgets/links-widgets.php',
    'widgets/marquee-widgets.php',
    'widgets/new-widgets.php',
    'widgets/onepost-widgets.php',
    'widgets/tab_post-widgets.php',
    'widgets/time-widgets.php',
    'widgets/time-widget.php',
    'widgets/timetip-widgets.php',
    'widgets/timetip2-widgets.php',
    'widgets/tips-widhets.php',
    'widgets/titlelb-widgets.php',
    'widgets/tj1-widgets.php',
    'widgets/tj2-widgets.php',//待修改
    'widgets/tj3-widgets.php',
    'widgets/top_widgets.php',
    'widgets/url-widgets.php',
    'widgets/partner_logo_widget.php',


    
    
    
    'widgets/user-widgets.php',
    'widgets/widgets-author.php',
    'widgets/widgets-money.php',
    'widgets/widget_ui_slider.php',
    'widgets/comment-barrage.php',
);

// 延迟加载各小工具，确保父主题和 CSF 已加载
add_action('zib_require_end', function () use ($require_once) {
    foreach ($require_once as $require) {
        require __DIR__ . '/' . $require;
    }
});


//定义常量
define('PEE_TEMPLATE_DIRECTORYwidgets.php_URI', get_template_directory_uri()); //本主题
define('PEE_ROOT_PATH', dirname(__DIR__) . '/'); //本主题的路径


class Panda_CFSwidget
{
    public static function create($id, $args = array())
    {
        $args = self::args($args);
        CSF::createWidget($id, $args);
    }
    public static function is_size_limit($wp_args = array())
    {
        if (!empty($wp_args['size']) && !empty($wp_args['id']) && is_super_admin()) {
            if ($wp_args['size'] == 'mini' && (!strstr($wp_args['id'], 'sidebar') && !strstr($wp_args['id'], 'nav'))) {
                return true;
            } elseif ($wp_args['size'] == 'big' && (strstr($wp_args['id'], 'sidebar') || strstr($wp_args['id'], 'nav'))) {
                return true;
            }
        }
        return false;
    }
    public static function echo_before($args = array(), $class = 'mb20', $wp_args = array())
    {
        $show_class = self::show_class($args);
        if ($show_class && $show_class !== true) {
            $class .= ' ' . $show_class;
        }
        $affix = !empty($args['sidebar_affix']) ? ' data-affix="true"' : '';

        $title = self::show_title($args);
        do_action('zib_cfswidget_echo_before', $args, $class);
        $class_attr = $class ? ' class="' . esc_attr($class) . '"' : '';
        if (self::is_size_limit($wp_args)) {
            $desc       = $wp_args['size'] == 'mini' ? '此模块宽度较小，PC端放置在此处，显示效果不佳，建议更换到侧边栏等较窄的容器，或者开启仅移动端显示。' : '此模块宽度较大，放置在此处，显示效果不佳，建议更换为全宽度、主内容上下等较宽的容器';
            $size_limit = '<div class="badg btn-block c-red padding-lg"><i class="fa fa-fw fa-info-circle mr10"></i>此模块不推荐放置在此位置！' . $desc . '<br>(当前提醒只会在管理员登录时显示)</div>';
            echo '<div style="padding:6px;background:rgba(255, 0, 143, 0.1);">' . $size_limit;
        }
        echo '<div' . $affix . $class_attr . '>';
        echo $title;
    }

    public static function echo_after($args = array(), $wp_args = array())
    {
        echo '</div>';
        if (self::is_size_limit($wp_args)) {
            echo '</div>';
        }
        do_action('zib_cfswidget_echo_after', $args);
    }

    public static function show_title($args = array())
    {
        if (empty($args['title'])) {
            return;
        }

        $title    = $args['title'];
        $subtitle = !empty($args['subtitle']) ? $args['subtitle'] : '';
        $subtitle = $subtitle ? '<small class="ml10">' . $subtitle . '</small>' : '';

        $link_url   = !empty($args['title_link']['url']) ? $args['title_link']['url'] : '';
        $link_text  = !empty($args['title_link']['text']) ? $args['title_link']['text'] : '<i class="fa fa-angle-right fa-fw"></i>更多';
        $link_blank = !empty($args['title_link']['target']) && $args['title_link']['target'] == '_blank' ? ' target="_blank"' : '';

        $more_but = $link_url ? '<div class="pull-right em09 mt3"><a' . $link_blank . ' href="' . $link_url . '" class="muted-2-color">' . $link_text . '</a></div>' : '';
        return '<div class="box-body notop"><div class="title-theme">' . $title . $subtitle . $more_but . '</div></div>';
    }

    //可用于是否显示判断
    public static function show_class($instance)
    {
        $show_type = isset($instance['show_type']) ? $instance['show_type'] : 'all';

        $wp_is_mobile = wp_is_mobile();
        if ($show_type == 'only_pc' && $wp_is_mobile) {
            return '';
        }

        if ($show_type == 'only_sm' && !$wp_is_mobile) {
            return '';
        }

        if (!empty($instance['show_id_type']) && !empty($instance['show_ids'])) {
            if (is_singular()) {
                $the_id   = get_the_ID();
                $show_ids = preg_split("/,|，|\s|\n/", $instance['show_ids']);

                if ($instance['show_id_type'] == 'show' && !in_array($the_id, $show_ids)) {
                    return '';
                }
                if ($instance['show_id_type'] == 'hide' && in_array($the_id, $show_ids)) {
                    return '';
                }
            }
        }
        if ($show_type == 'only_pc') {
            return 'hidden-xs';
        }

        if ($show_type == 'only_sm') {
            return 'visible-xs-block';
        }

        return true;
    }
    public static function args($args = array())
    {
        $args['title'] = 'Panda ' . $args['title'];
        $more_args     = array();
        if (!empty($args['zib_title'])) {
            unset($args['zib_title']);
            $more_args[] = array(
                'title'      => '模块标题',
                'id'         => 'title',
                'default'    => '',
                'attributes' => array(
                    'rows' => 1,
                ),
                'type'       => 'textarea',
            );
            $more_args[] = array(
				'class'    => 'compact',
                'dependency' => array('title', '!=', ''),
                'title'      => ' ',
                'subtitle'   => '副标题',
                'class'      => 'compact',
                'id'         => 'subtitle',
                'default'    => '',
                'attributes' => array(
                    'rows' => 1,
                ),
                'type'       => 'textarea',
            );
            $more_args[] = array(
				'class'    => 'compact',
                'dependency'   => array('title', '!=', ''),
                'title'        => '标题右侧链接',
                'class'        => 'compact',
                'id'           => 'title_link',
                'desc'         => '标题、副标题均支持HTML代码，请注意代码规范！',
                'type'         => 'link',
                'add_title'    => '添加链接',
                'edit_title'   => '编辑链接',
                'remove_title' => '删除链接',
            );
        }
        if (!empty($args['zib_affix'])) {
            unset($args['zib_affix']);
            $more_args[] = array(
                'title'    => '侧栏随动',
                'subtitle' => '',
                'id'       => 'sidebar_affix',
                'label'    => '仅在侧边栏有效',
                'type'     => 'switcher',
                'default'  => false,
            );
        }
        if (!empty($args['zib_show'])) {
            unset($args['zib_show']);
            $more_args[] = array(
                'title'   => __("显示规则", 'zib_language'),
                'id'      => 'show_type',
                'type'    => 'radio',
                'default' => 'all',
                'options' => array(
                    'all'     => 'PC端/移动端均显示',
                    'only_pc' => '仅在PC端显示',
                    'only_sm' => '仅在移动端显示',
                ),
            );

            $more_args[] = array(
                'title'   => __('按ID显示或隐藏', 'zib_language'),
                'id'      => 'show_id_type',
                'type'    => 'radio',
                'default' => '',
                'options' => array(
                    'show' => '仅在以下ID中显示',
                    'hide' => '在以下ID中隐藏',
                ));
            $more_args[] = array(
                'id'    => 'show_ids',
                'class' => 'compact',
                'type'  => 'text',
                'desc'  => '<span class="px12">当此模块添加在文章、帖子、板块页面时候，可以通过此处设置ID，来控制显示或隐藏此模块，多个ID用英文逗号隔开。<br>例如：1,2,3</span>',
            );
        }
        $args['fields'] = array_merge($more_args, isset($args['fields']) && is_array($args['fields']) ? $args['fields'] : []);
        return $args;
    }
}
