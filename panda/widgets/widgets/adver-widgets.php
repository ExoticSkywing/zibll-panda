<?php
Panda_CFSwidget::create('widget_ui_adver', array(
    'title'       => 'adver-会员广告小模块',  // 小工具的标题
    'zib_title'   => true,  // 是否显示模块标题菜单
    'zib_affix'   => true,  // 是否显示侧栏随动菜单
    'description' => '显示会员广告小模块，建议侧边栏显示。',  // 小工具的描述
    'fields'      => array(  // 配置小工具的字段
        array(
            'title'       => '第一行显示内容',  
            'id'          => 'text_1',  
            'type'        => 'text',  
            'default'     => '成为永久黄金会员本站免费下载',  
            'description' => '广告第一行文字内容'  
        ),
        array(
            'title'       => '第二行显示内容',  
            'id'          => 'text_2',  
            'type'        => 'text',  
            'default'     => '每日更新只出精品资源',  
            'description' => '广告第二行文字内容'  
        ),
        array(
            'title'       => '不显示背景盒子',  
            'id'          => 'hide_box',  
            'type'        => 'checkbox',  
            'default'     => true,  
            'description' => '是否隐藏背景盒子'  
        )
    )
));

// 定义显示小工具的函数
function widget_ui_adver($args, $instance)
{
    // 可用于是否显示判断
    $show_class = Panda_CFSwidget::show_class($instance);
    
    // 在小工具内容之前调用Panda_CFSwidget的echo_before函数
    Panda_CFSwidget::echo_before($instance, '');
    
    // 获取实例值
    $text_1 = isset($instance['text_1']) ? $instance['text_1'] : '成为永久黄金会员本站免费下载';
    $text_2 = isset($instance['text_2']) ? $instance['text_2'] : '每日更新只出精品资源';
    $hide_box = isset($instance['hide_box']) ? $instance['hide_box'] : false;
    
    // 构建小工具HTML
    $class = $hide_box ? '' : ' zib-widget';
    
    echo '<div class="user_lists' . $class . '">';
    
    echo '<style>
    .widget-adss .asr {
        display: block;
        padding: 30px 15px;
        text-align: center;
        color: #fff !important;
        background: #64ddbb;
        border-radius: 4px;
        overflow: hidden;
    }
    
    .widget-adss .asr .btn {
        margin-top: 20px;
        font-weight: normal;
        border-radius: 100px;
        text-align: center;
        vertical-align: top;
        user-select: none;
        -webkit-transition: all .3s ease-in-out;
        -moz-transition: all .3s ease-in-out;
        transition: all .3s ease-in-out;
        padding: 4px 30px;
        line-height: inherit;
    }
    .btn-outline {
        color: #fff;
        background-color: transparent;
        border: 1px solid #fff;
    }
    .btn-outline:hover,.btn-outline:focus,.btn-outline.focus {
        color: #555;
        background-color: #fff;
    }
    .ztw-bj {
        background-color: #d9534f;
        background-image: linear-gradient(#fc423c 33.19%, #f6f1f1 71.01%, #25a6a2);
        color: #fff;
        this-bj: linear-gradient(75deg, #2f3b42 0%, #3e516d 39%, #222538 100%);
    }
    </style>

    <div class="ztw-bj zib-widget mb10-sm ztw-bj">
        <div class="colorful-make" style="transform: rotate(-9deg) scale(0.7);"></div>
        <div class="text-center">
            <div class="">
                <div class="ac"><b class="em14">' . $text_1 . '</b></div>
                <div style="width:100%;word-wrap: break-word;" class="em09 opacity8">' . $text_2 . '</div><br>
                <a style="--this-color:#f2c97d;--this-bg:rgba(62,62,67,0.9);" class="mt6 but radius jb-red px12 p2-10 pay-vip" vip-level="2" data-toggle="tooltip" data-placement="left" title="" href="javascript:;" data-original-title="开通会员">立即查看<i style="margin:0 0 0 6px;" class="fa fa-angle-right em12"></i></a>
            </div>
        </div>
    </div>';
    echo '</div>';
    
    // 在小工具内容之后调用Panda_CFSwidget的echo_after函数
    Panda_CFSwidget::echo_after($instance);
}
?>