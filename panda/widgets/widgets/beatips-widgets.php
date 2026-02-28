<?php
Panda_CFSwidget::create('widget_ui_beatips', array(
    'title'       => 'beatips-滚动播报(炫彩）',  // 小工具的标题
    'zib_title'   => true,  // 是否显示模块标题菜单
    'zib_affix'   => true,  // 是否显示侧栏随动菜单
    'description' => '显示滚动播报，建议侧边栏显示。',  // 小工具的描述
    'fields'      => array(  // 配置小工具的字段
        array(
            'title'       => '不显示背景盒子',  // 字段标题
            'id'          => 'hide_box',  // 字段ID
            'type'        => 'checkbox',  // 字段类型
            'default'     => true,  // 默认值
            'description' => '不显示背景盒子'  // 字段描述
        ),
    )
));

// 定义显示小工具的函数
function widget_ui_beatips($args, $instance)
{
    // 可用于是否显示判断
    $show_class = Panda_CFSwidget::show_class($instance);
    
    // 获取字段值
    $hide_box_value = isset($instance['hide_box']) ? $instance['hide_box'] : false;
    
    // 处理盒子类
    $class = $hide_box_value ? '' : ' zib-widget';
    
    // 在小工具内容之前调用Panda_CFSwidget的echo_before函数
    Panda_CFSwidget::echo_before($instance, '');
    
    // 构建HTML输出
    echo '<div class="user_lists' . $class . '" style="margin:0 0 20px 0;">';
    
    
    // 滚动播报内容
    echo '<section id="custom_html-2" class="widget_text widget widget_custom_html mar16-b">
            <meta charset="utf-8">
            <div class="textwidget custom-html-widget">
            <aside id="php_text-8" 
            class="widget php_text wow fadeInUp" data-wow-delay="0.3s">
            <div class="textwidget widget-text">
                <style type="text/css">
                #beacontainer-box-1{color:#526372;text-transform:uppercase;width:100%;font-size:16px;line-height:50px;text-align:center;padding: 10px;background: linear-gradient(45deg, #C7F5FE 10%, #C7F5FE 40%, #FCC8F8 40%, #FCC8F8 60%, #EAB4F8 60%, #EAB4F8 65%, #F3F798 65%, #F3F798 90%);border-radius: var(--main-radius);}
            #beaflip-box-1{overflow:hidden;height:50px;border-radius:99px}
            #beaflip-box-1 div{height:50px}
            #beaflip-box-1>div>div{color:#fff;display:inline-block;text-align:center;height:50px;width:100%}
            #beaflip-box-1 div:first-child{animation:show 8s linear infinite}
            .beaflip-box-1-1{background-image:linear-gradient(to right,#fa709a 0,#fee140 100%)}
            .beaflip-box-1-2{background-image: linear-gradient(120deg, #e0c3fc 0%, #8ec5fc 100%);}
            .beaflip-box-1-3{background-image: linear-gradient(to right, #b8cbb8 0%, #b8cbb8 0%, #b465da 0%, #cf6cc9 33%, #ee609c 66%, #ee609c 100%);}
            .beaflip-box-1-4{background-image: linear-gradient(to right, #f78ca0 0%, #f9748f 19%, #fd868c 60%, #fe9a8b 100%);}
            .beaflip-box-1-5{background-image: linear-gradient(to right, #74ebd5 0%, #9face6 100%);}
            .beaflip-box-1-6{background-image: linear-gradient(to top, #9795f0 0%, #fbc8d4 100%);}
            @keyframes show{0%{margin-top:-300px}
            5%{margin-top:-250px}
            16.666%{margin-top:-250px}
            21.666%{margin-top:-200px}
            33.332%{margin-top:-200px}
            38.332%{margin-top:-150px}
            49.998%{margin-top:-150px}
            54.998%{margin-top:-100px}
            66.664%{margin-top:-100px}
            71.664%{margin-top:-50px}
            83.33%{margin-top:-50px}
            88.33%{margin-top:0}
            99.996%{margin-top:0}
            100%{margin-top:300px}
            }
                </style>
                <div id="beacontainer-box-1">
            <div class="beacontainer-box-1-1"><svg class="icon" aria-hidden="true"><use xlink:href="#iconxiangwenbiaoqing"></use></svg> 坚持每天来逛逛，会让你 <svg class="icon" aria-hidden="true"><use xlink:href="#iconpaomeiyanbiaoqing"></use></svg></div>
            <div id="beaflip-box-1"><div><div class="beaflip-box-1-1">生活也美好了！</div>
            </div><div><div class="beaflip-box-1-2">心情也舒畅了！</div></div>
            <div><div class="beaflip-box-1-3">走路也有劲了！</div></div><div>
            <div class="beaflip-box-1-4">腿也不痛了！</div></div>
            <div><div class="beaflip-box-1-5">腰也不酸了！</div></div>
            <div><div class="beaflip-box-1-6">工作也轻松了！</div></div>
            </div><div class="beacontainer-box-1-2"><svg class="icon" aria-hidden="true"><use xlink:href="#iconkaixinbiaoqing"></use></svg> 你好我也好，不要忘记哦! <svg class="icon" aria-hidden="true"><use xlink:href="#icondaxiaobiaoqing"></use></svg></div></div></div>
            <div class="clear"></div>
            </aside></div>
            </section>';
    echo '</div>';
    
    // 在小工具内容之后调用Panda_CFSwidget的echo_after函数
    Panda_CFSwidget::echo_after($instance);
}