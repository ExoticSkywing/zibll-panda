<?php

add_action('widgets_init', 'widget_down_line');
function widget_down_line()
{
    register_widget('widget_ui_down_line');
}

class widget_ui_down_line extends WP_Widget
{
    public function __construct()
    {
        $widget = array(
            'w_id'        => 'widget_ui_down_line',
            'w_name'      => 'Panda down-底线',
            'classname'   => '',
            'description' => '显示底线，建议底部全宽度显示',
        );
        parent::__construct($widget['w_id'], $widget['w_name'], $widget);
    }
    public function widget($args, $instance)
    {
        echo '<style>.lastpagenotice_noticewrap{color:hsla(0, 2.1%, 18.8%, 0.6);}.lastpagenotice_noticewrap img{height:73px; width:88px; margin:0 auto}.lastpagenotice_noticewrap .lastpagenotice_text{display:block; position:absolute; font-size:15px; line-height:20px; top:50%; -webkit-transform:translateY(-50%); -ms-transform:translateY(-50%); transform:translateY(-50%); left:-webkit-calc(50% + 60px); left:calc(50% + 60px)}.lastpagenotice_noticewrap .lastpagenotice_line{width:100%; height:1px; background-color:hsla(0,0%,100%,.05); position:absolute; bottom:0}.app_normal{text-align:center; position:relative}</style><div class="app_normal window" style="padding-top:" data-reactroot=""><div class="common_container lastpagenotice_noticewrap"><img src="'.panda_pz('static_panda').'/assets/img/widgets/lan.png" data-spm-anchor-id="a2ha1.14919748_WEBHOME_GRAY.0.i1"><div class="lastpagenotice_text"  style="color:#6699FF;font-weight:bold;">我也是有底线哒~</div><div class="lastpagenotice_line"></div></div></div>';
    }
}