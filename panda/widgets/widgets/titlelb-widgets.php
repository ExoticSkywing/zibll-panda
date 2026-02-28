<?php
Panda_CFSwidget::create('widget_titlelb', array(
    'title'       => 'titlelb-仿张洪的块的导航',
    'zib_title'   => false,
    'zib_affix'   => false,
    'zib_show'    => false,
    'description' => '显示特定分类目录下的文章，可设置两行布局',
    'fields'      => array(
        array(
            'content'       => '仅电脑端显示',
            'type'        => 'submessage',
        ),
        array(
            'content'       => '左边设置',
            'type'        => 'submessage',
        ),
        array(
            'class'   => 'compact',
            'title'       => '标题第一行',
            'id'          => 'title_1',
            'type'        => 'text',
            'default'     => '分享设计',
        ),
        array(
            'class'   => 'compact',
            'title'       => '标题第二行',
            'id'          => 'title_2',
            'type'        => 'text',
            'default'     => '与科技生活',
        ),
        array(
            'class'   => 'compact',
            'title'       => '悬停显示文字',
            'id'          => 'hover_text',
            'type'        => 'text',
            'default'     => '随便逛逛',
        ),
        array(
            'class'   => 'compact',
            'title'       => '悬停点击跳转链接',
            'id'          => 'hover_link',
            'type'        => 'text',
            'default'     => '/?random',
        ),
        array(
            'class'       =>'compact',
            'title'       => '第一个块的文字',
            'id'          => 'block_1_text',
            'type'        => 'text',
            'default'     => '必看精选',
        ),
        array(
            'class'       =>'compact',
            'title'       => '第一个块的链接',
            'id'          => 'block_1_link',
            'type'        => 'text',
            'default'     => '/tags/必看/',
        ),
        array(
            'class'       =>'compact',
            'title'       => '第二个块的文字',
            'id'          => 'block_2_text',
            'type'        => 'text',
            'default'     => '热门文章',
        ),
        array(
            'class'       =>'compact',
            'title'       => '第二个块的链接',
            'id'          => 'block_2_link',
            'type'        => 'text',
            'default'     => '/tags/热门/',
        ),
        array(
            'class'       =>'compact',
            'title'       => '第三个块的文字',
            'id'          => 'block_3_text',
            'type'        => 'text',
            'default'     => '实用教程',
        ),
        array(
            'class'       =>'compact',
            'title'       => '第三个块的链接',
            'id'          => 'block_3_link',
            'type'        => 'text',
            'default'     => '/tags/教程/',
        ),

        array(
            'content'     =>'右边设置',
            'type'        =>'submessage',
        ),

        array(
            'class'       =>'compact',
            'title'       =>'背景图片',
            'id'          =>'bg_img',
            'type'        =>'upload',
            'default'     =>panda_pz('static_panda').'/assets/img/2025021267ac7a8b0db341739356809808.png',
        ),
        array(
            'class'       =>'compact',
            'title'       =>'第一行内容',
            'id'          =>'content_1',
            'type'        =>'text',
            'default'     =>'苏晨博客网',
        ),
        array(
            'class'       =>'compact',
            'title'       =>'第二行内容',
            'id'          =>'content_2',
            'type'        =>'text',
            'default'     =>'记录生活 留住感动',
        ),
        array(
            'class'       =>'compact',
            'title'       =>'按钮文字',
            'id'          =>'btn_text',
            'type'        =>'text',
            'default'     =>'随便看看',
        ),
        array(
            'class'       =>'compact',
            'title'       =>'按钮链接',
            'id'          =>'btn_link',
            'type'        =>'text',
            'default'     =>'/?random',
        ),
    )
));

// 定义显示小工具的函数
function widget_titlelb($args, $instance)
{
    // 可用于是否显示判断
    $show_class = Panda_CFSwidget::show_class($instance);//值为1或者0

    // 在小工具内容之前调用Panda_CFSwidget的echo_before函数
    Panda_CFSwidget::echo_before($instance, '');
    $title_1 = $instance['title_1'];
    $title_2 = $instance['title_2'];
    $hover_text = $instance['hover_text'];
    $hover_link = $instance['hover_link'];
    $block_1_text = $instance['block_1_text'];
    $block_1_link = $instance['block_1_link'];
    $block_2_text = $instance['block_2_text'];
    $block_2_link = $instance['block_2_link'];
    $block_3_text = $instance['block_3_text'];
    $block_3_link = $instance['block_3_link'];
    $bg_img = $instance['bg_img'];
    $content_1 = $instance['content_1'];
    $content_2 = $instance['content_2'];
    $btn_text = $instance['btn_text'];
    $btn_link = $instance['btn_link'];

    ?>
    <link rel="stylesheet" href="<?php echo panda_pz('static_panda'); ?>/assets/css/titlelb.css">
    <div id="home_top">
        <div class="recent-top-post-group" id="recent-top-post-group">
            <div class="recent-post-top" id="recent-post-top">
                <div id="bannerGroup">
                    <div id="banners">
                        <div class="banners-title">
                            <div class="banners-title-big">
                                <?php echo $title_1;?>
                            </div>
                            <div class="banners-title-big">
                                <?php echo $title_2;?>
                            </div>
                        </div>
                        <div class="tags-group-all">
                            <div class="tags-group-wrapper">
                                <div class="tags-group-icon-pair">
                                    <div class="tags-group-icon" style="background:#989bf8">
                                        <img title="AfterEffects"
                                            onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'"
                                            class="entered exited"
                                            src="https://p.zhheo.com/20239df3f66615b532ce571eac6d14ff21cf072602.png!cover">
                                    </div>
                                    <div class="tags-group-icon" style="background:#ffffff">
                                        <img src="https://p.zhheo.com/2023e0ded7b724a39f12d59c3dc8fbdc7cbe074202.png!cover"
                                            title="Sketch"
                                            onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'">
                                    </div>
                                </div>
                                <div class="tags-group-icon-pair">
                                    <div class="tags-group-icon" style="background:#57b6e6">
                                        <img title="Docker"
                                            onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'"
                                            class="entered exited"
                                            src="https://p.zhheo.com/20231108a540b2862d26f8850172e4ea58ed075102.png!cover">
                                    </div>
                                    <div class="tags-group-icon" style="background:#4082c3">
                                        <img src="https://p.zhheo.com/2023e4058a91608ea41751c4f102b131f267075902.png!cover"
                                            title="Photoshop"
                                            onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'">
                                    </div>
                                </div>
                                <div class="tags-group-icon-pair">
                                    <div class="tags-group-icon" style="background:#ffffff">
                                        <img src="https://p.zhheo.com/20233e777652412247dd57fd9b48cf997c01070702.png!cover"
                                            title="FinalCutPro"
                                            onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'"
                                            data-ll-status="" class="entered ">
                                    </div>
                                    <div class="tags-group-icon" style="background:#ffffff">
                                        <img src="https://p.zhheo.com/20235c0731cd4c0c95fc136a8db961fdf963071502.png!cover"
                                            title="Python"
                                            onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'">
                                    </div>
                                </div>
                                <div class="tags-group-icon-pair">
                                    <div class="tags-group-icon" style="background:#eb6840">
                                        <img title="Swift"
                                            onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'"
                                            class="entered "
                                            src="https://p.zhheo.com/202328bbee0b314297917b327df4a704db5c072402.png!cover"
                                            data-ll-status="">
                                    </div>
                                    <div class="tags-group-icon" style="background:#8f55ba">
                                        <img title="Principle"
                                            onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'"
                                            class="entered exited"
                                            src="https://p.zhheo.com/2023f76570d2770c8e84801f7e107cd911b5073202.png!cover">
                                    </div>
                                </div>
                                <div class="tags-group-icon-pair">
                                    <div class="tags-group-icon" style="background:#f29e39">
                                        <img title="illustrator"
                                            onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'"
                                            class="entered "
                                            src="https://p.zhheo.com/20237359d71b45ab77829cee5972e36f8c30073902.png!cover"
                                            data-ll-status="">
                                    </div>
                                    <div class="tags-group-icon" style="background:#2c51db">
                                        <img src="https://p.zhheo.com/20237c548846044a20dad68a13c0f0e1502f074602.png!cover"
                                            title="CSS3"
                                            onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'"
                                            data-ll-status="" class="entered ">
                                    </div>
                                </div>
                                <!--www.tyzyj.cn -->
                                <div class="tags-group-icon-pair">
                                    <div class="tags-group-icon" style="background:#f7cb4f">
                                        <img title="JS"
                                            onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'"
                                            class="entered "
                                            src="https://p.zhheo.com/2023786e7fc488f453d5fb2be760c96185c0075502.png!cover"
                                            data-ll-status="">
                                    </div>
                                    <div class="tags-group-icon" style="background:#e9572b">
                                        <img title="HTML"
                                            onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'"
                                            class="entered "
                                            src="https://p.zhheo.com/202372b4d760fd8a497d442140c295655426070302.png!cover"
                                            data-ll-status="">
                                    </div>
                                </div>
                                <div class="tags-group-icon-pair">
                                    <div class="tags-group-icon" style="background:#df5b40">
                                        <img title="Git"
                                            onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'"
                                            class="entered "
                                            src="https://p.zhheo.com/2023ffa5707c4e25b6beb3e6a3d286ede4c6071102.png!cover"
                                            data-ll-status="">
                                    </div>
                                    <div class="tags-group-icon" style="background:#1f1f1f">
                                        <img title="Rhino"
                                            onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'"
                                            class="entered "
                                            src="https://p.zhheo.com/20231ca53fa0b09a3ff1df89acd7515e9516173302.png!cover"
                                            data-ll-status="">
                                    </div>
                                </div>
                                <div class="tags-group-icon-pair">
                                    <div class="tags-group-icon" style="background:#989bf8">
                                        <img title="AfterEffects"
                                            onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'"
                                            class="entered exited"
                                            src="https://p.zhheo.com/20239df3f66615b532ce571eac6d14ff21cf072602.png!cover">
                                    </div>
                                    <div class="tags-group-icon" style="background:#ffffff">
                                        <img title="Sketch"
                                            onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'"
                                            class="entered exited"
                                            src="https://p.zhheo.com/2023e0ded7b724a39f12d59c3dc8fbdc7cbe074202.png!cover">
                                    </div>
                                </div>
                                <div class="tags-group-icon-pair">
                                    <div class="tags-group-icon" style="background:#57b6e6">
                                        <img title="Docker"
                                            onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'"
                                            class="entered exited"
                                            src="https://p.zhheo.com/20231108a540b2862d26f8850172e4ea58ed075102.png!cover">
                                    </div>
                                    <div class="tags-group-icon" style="background:#4082c3">
                                        <img title="Photoshop"
                                            onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'"
                                            class="entered exited"
                                            src="https://p.zhheo.com/2023e4058a91608ea41751c4f102b131f267075902.png!cover">
                                    </div>
                                </div>
                                <div class="tags-group-icon-pair">
                                    <div class="tags-group-icon" style="background:#ffffff">
                                        <img title="FinalCutPro"
                                            onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'"
                                            class="entered exited"
                                            src="https://p.zhheo.com/20233e777652412247dd57fd9b48cf997c01070702.png!cover">
                                    </div>
                                    <div class="tags-group-icon" style="background:#ffffff">
                                        <img title="Python"
                                            onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'"
                                            class="entered exited"
                                            src="https://p.zhheo.com/20235c0731cd4c0c95fc136a8db961fdf963071502.png!cover">
                                    </div>
                                </div>
                                <div class="tags-group-icon-pair">
                                    <div class="tags-group-icon" style="background:#eb6840">
                                        <img title="Swift"
                                            onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'"
                                            class="entered exited"
                                            src="https://p.zhheo.com/202328bbee0b314297917b327df4a704db5c072402.png!cover">
                                    </div>
                                    <div class="tags-group-icon" style="background:#8f55ba">
                                        <img title="Principle"
                                            onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'"
                                            class="entered exited"
                                            src="https://p.zhheo.com/2023f76570d2770c8e84801f7e107cd911b5073202.png!cover">
                                    </div>
                                </div>
                                <div class="tags-group-icon-pair">
                                    <div class="tags-group-icon" style="background:#f29e39">
                                        <img title="illustrator"
                                            onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'"
                                            class="entered exited"
                                            src="https://p.zhheo.com/20237359d71b45ab77829cee5972e36f8c30073902.png!cover">
                                    </div>
                                    <div class="tags-group-icon" style="background:#2c51db">
                                        <img title="CSS3"
                                            onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'"
                                            class="entered exited"
                                            src="https://p.zhheo.com/20237c548846044a20dad68a13c0f0e1502f074602.png!cover">
                                    </div>
                                </div>
                                <div class="tags-group-icon-pair">
                                    <div class="tags-group-icon" style="background:#f7cb4f">
                                        <img src="https://p.zhheo.com/2023786e7fc488f453d5fb2be760c96185c0075502.png!cover"
                                            title="JS"
                                            onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'">
                                    </div>
                                    <div class="tags-group-icon" style="background:#e9572b">
                                        <img src="https://p.zhheo.com/202372b4d760fd8a497d442140c295655426070302.png!cover"
                                            title="HTML"
                                            onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'">
                                    </div>
                                </div>
                                <div class="tags-group-icon-pair">
                                    <div class="tags-group-icon" style="background:#df5b40">
                                        <img src="https://p.zhheo.com/2023ffa5707c4e25b6beb3e6a3d286ede4c6071102.png!cover"
                                            title="Git"
                                            onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'">
                                    </div>
                                    <div class="tags-group-icon" style="background:#1f1f1f">
                                        <img src="https://p.zhheo.com/20231ca53fa0b09a3ff1df89acd7515e9516173302.png!cover"
                                            title="Rhino"
                                            onerror="this.onerror=null;this.src='https://bu.dusays.com/2023/03/03/6401a79030db5.png'">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a id="banner-hover" href="<?php echo $hover_link;?>" data-pjax-state="">
                            <i class="heofont icon-right">
                            </i>
                            <span class="bannerText">
                                <?php echo $hover_text;?>
                            </span>
                        </a>
                    </div>
                    <div class="categoryGroup">
                        <div class="categoryItem">
                            <a class="categoryButton wniui_one" href="<?php echo $block_1_link;?>" data-pjax-state="">
                                <span class="categoryButtonText">
                                    <?php echo $block_1_text;?>
                                </span>
                                <i class="heofont icon-star-smile-fill">
                                </i>
                            </a>
                        </div>
                        <div class="categoryItem">
                            <a class="categoryButton wniui_two" href="<?php echo $block_2_link;?>" data-pjax-state="">
                                <span class="categoryButtonText">
                                    <?php echo $block_2_text;?>
                                </span>
                                <i class="heofont icon-fire-fill">
                                </i>
                            </a>
                        </div>
                        <div class="categoryItem">
                            <a class="categoryButton wniui_three" href="<?php echo $block_3_link;?>" data-pjax-state="">
                                <span class="categoryButtonText">
                                    <?php echo $block_3_text;?>
                                </span>
                                <i class="heofont icon-book-mark-fill">
                                </i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="topGroup">
                    <div class="todayCard" id="todayCard" style="z-index: 1;">
                        <div class="todayCard-info">
                            <div class="todayCard-tips">
                                <?php echo $content_1;?>
                            </div>
                            <div class="todayCard-title"><?php echo $content_2;?>
                            </div>
                        </div>
                        <div class="todayCard-cover"
                            style="background: url('<?php echo $bg_img;?>') no-repeat center /cover">
                        </div>
                        <div class="banner-button-group">
                            <a class="banner-button" href="<?php echo $btn_link;?>">
                                <i class="heofont icon-add-circle-fill">
                                </i>
                                <span class="banner-button-text">
                                    <?php echo $btn_text;?>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php

    // 在小工具内容之后调用Panda_CFSwidget的echo_after函数
    Panda_CFSwidget::echo_after($instance);
}
?>
