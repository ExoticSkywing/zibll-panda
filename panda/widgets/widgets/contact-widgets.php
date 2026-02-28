<?php

// 使用Panda_CFSwidget类创建一个名为widget_contact_info的小工具
Panda_CFSwidget::create(
    'widget_contact_info',
    array(
        'title'       => 'contact-联系方式',
        'zib_title'   => true,
        'description' => '显示联系方式，建议侧边栏显示。',
        'fields'      => array(
            array(
                'title'   => '第一个框',
                'id'      => 'first',
                'type'    => 'text',
                'default' => '站长邮箱',
            ),
            array(
                'title'   => '链接',
                'id'      => 'first_url',
                'type'    => 'text',
                'default' => 'https://mail.qq.com/cgi-bin/qm_share?t=qm_mailme&email=邮箱',
            ),
            array(
                'title'   => '第二个框',
                'id'      => 'second',
                'type'    => 'text',
                'default' => '在线投稿',
            ),
            array(
                'title'   => '链接',
                'id'      => 'second_url',
                'type'    => 'text',
                'default' => '/newposts',
            ),
            array(
                'title'   => '第三个框',
                'id'      => 'third',
                'type'    => 'text',
                'default' => '友情链接',
            ),
            array(
                'title'   => '链接',
                'id'      => 'third_url',
                'type'    => 'text',
                'default' => '/links',
            ),
        )
    )
);

// 定义显示小工具的函数
function widget_contact_info($args, $instance)
{
    $show_class = Panda_CFSwidget::show_class($instance);

    $first = $instance['first'];
    $first_url = $instance['first_url'];
    $second = $instance['second'];
    $second_url = $instance['second_url'];
    $third = $instance['third'];
    $third_url = $instance['third_url'];

    $html = '<style type="text/css">
#update_version img{margin:0px 0 15px }#update_version a{width:30%;height:35px;border-radius:3px;text-align:center;line-height:35px;font-size:9pt;color:#fff;font-weight: 700;}.blog_link{background-color:#2ba9fa}.blog_link,.cms_link{float:left;margin-right:5%}.cms_link{background-color:#ff6969}.grid_link{float:left;background-color:#70c041}
</style>
        <div class="zib-widget widget_text"><div id="update_version">
<a href="/" target="_blank" rel="noopener"><img src="'.panda_pz('static_panda').'/assets/img/widgets/back.gif" alt="图片" style="border-radius:5px;"></a>
<a class="blog_link" href="'.$first_url.'" target="_blank" style="background-image: linear-gradient(120deg, #3ca5f6 0%, #a86af9 100%);" rel="noopener">'.$first.'</a>
<a class="cms_link" href="'.$second_url.'" target="_blank" style="background-image: linear-gradient(120deg, #f093fb 0%, #f5576c 100%);" rel="noopener">'.$second.'</a>
<a class="grid_link" href="'.$third_url.'" target="_blank" style="background-image: linear-gradient(to right, #fa709a 0%, #fee140 100%);" rel="noopener">'.$third.'</a>
</div><div><hr></div></div>';

    Panda_CFSwidget::echo_before($instance, '');
    echo $html;
    Panda_CFSwidget::echo_after($instance);
}