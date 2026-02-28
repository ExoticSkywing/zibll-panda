<?php
Panda_CFSwidget::create('widget_imgs', array(
    'title'       => 'imgs-横向滚动图集',
    'zib_title'   => true,
    'zib_affix'   => false,
    'zib_show'    => false,
    'description' => '显示特定分类目录下的文章，可设置两行布局',
    'fields'      => array(
        array(
            'title'    => '背景图片1',
            'id'      => 'bg_img1',
            'type'    => 'upload',
            'default' => panda_pz('static_panda').'/assets/img/pic.webp',
        ),
        array(
            'title'    => '背景图片2',
            'id'      => 'bg_img2',
            'type'    => 'upload',
            'default' => panda_pz('static_panda').'/assets/img/pic.webp',
        ),
        array(
            'title'    => '顶部图片',
            'id'      => 'top_img',
            'type'    => 'upload',
            'default' => panda_pz('static_panda').'/assets/img/title.png',
        ),
    )
));

// 定义显示小工具的函数
function widget_imgs($args, $instance)
{
    // 可用于是否显示判断
    $show_class = Panda_CFSwidget::show_class($instance);//值为1或者0

    // 在小工具内容之前调用Panda_CFSwidget的echo_before函数
    Panda_CFSwidget::echo_before($instance, '');
    
    $img1 = $instance['bg_img1'];
    $img2 = $instance['bg_img2'];
    $img = $instance['top_img'];
    ?>
    <style>
    .item.scroll{left:0px;width:100%;height:420px;background-size:auto 100%;pointer-events:none;background-position:center center;background-repeat:no-repeat;transition:opacity 0.3s ease 0s;white-space:nowrap;overflow:hidden;position:relative;font-size:0;background:#000;word-wrap:break-word;box-sizing:border-box;outline:none;}
    .item.scroll{left:0px;width:100%;height:420px;background-size:auto 100%;pointer-events:none;background-position:center center;background-repeat:no-repeat;transition:opacity 0.3s ease 0s;white-space:nowrap;overflow:hidden;position:relative;font-size:0;background:#000;word-wrap:break-word;box-sizing:border-box;outline:none;}
    .item.scroll .scroll-image{position:relative;height:100%;transform:translateX(0px);animation:banner 40s linear infinite;opacity:0.5;border:0;-ms-interpolation-mode:bicubic;vertical-align:middle;}
    .hVBrzU{position:absolute;top:70px;left:0px;right:0px;text-align:center;font-size:16px;white-space:normal;width:100%;margin:auto;}
    .statics{position:static;margin-top:-76px;padding-left:16px;padding-right:16px;margin-left:auto;margin-right:auto;margin-bottom:20px;}
    @media (max-width:767px){.static{display:none}
    }
    @media (max-width:767px){.home-course{display:none}
    .home-subjects{display:none}
    }
    .statics .flex{padding:0;margin:0;display:flex;}
    @media (max-width:767px){.statics{display:none}
    }
    .statics li.st_one{flex:1;margin-right:10px;border-radius:6px;overflow:hidden;position:relative;box-shadow:0 2px 5px rgba(0,0,0,.2);list-style:none;transition:all .3s ease-out;}
    .statics li.st_one:hover{transform:translateY(5px);}
    .statics li.st_one:last-child{margin-right:0;}
    .statics .st_one .card-main{width:100%;}
    .statics .active-card-title{position:absolute;bottom:0;color:#fff;background:-webkit-gradient(linear,left bottom,left top,color-stop(0,rgba(0,0,0,.7)),to(transparent));width:100%;padding:12px 20px;font-size:16px;margin:0;}
    @media screen and (max-width:900px){.item.scroll{height:200px;margin-top:0;}
    }
    .sc-1wssj0-17 img{display:inline-block;}
    @-webkit-keyframes banner{from{-webkit-transform:translateX(0);-ms-transform:translateX(0);transform:translateX(0);}
    to{-webkit-transform:translateX(-100%);-ms-transform:translateX(-100%);transform:translateX(-100%);}
    }
    @keyframes banner{from{-webkit-transform:translateX(0);-ms-transform:translateX(0);transform:translateX(0);}
    to{-webkit-transform:translateX(-100%);-ms-transform:translateX(-100%);transform:translateX(-100%);}
    }
    .item img{display:inline-block;height:auto;max-width:100%;vertical-align:middle;}
    .home_row{margin-top:16px;}
    .home_row_0{margin-top:3px;}
    .home_row_0 .panda_wrapper,.home_row_0 .panda_wrapper .box{width:100% !important;box-shadow:none;}
    .box{box-shadow:none;}
    .lazy{opacity:1;}
    .sc-1wssj0-17 img{width:auto;}
    </style>
    <div class="home_row">
        <div class="panda_wrapper">
            <div class="home-row-left fa3795 content-area ">
                <div class="">
                    <div id="html-box-sdadsgfd" class="html-box">
                        <div id="html-box-head1" class="html-box">
                            <div class="toptu">
                                <div class="item scroll">
                                    <img class="scroll-image lazyloaded"
                                        src="<?php echo $img1; ?>"
                                        data-was-processed="true">
                                    <img class="scroll-image lazyloaded"
                                        src="<?php echo $img2; ?>"
                                        data-was-processed="true">
                                    <div class="sc-1wssj0-17 hVBrzU">
                                        <img src="<?php echo $img; ?>"
                                            class="lazyloaded" data-was-processed="true">
                                    </div>
                                </div>
                            </div>
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
