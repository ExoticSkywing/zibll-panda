<?php
add_action('widgets_init', 'widget_down_line2');
function widget_down_line2()
{
    register_widget('widget_ui_down_line2');
}

class widget_ui_down_line2 extends WP_Widget
{
    public function __construct()
    {
        $widget = array(
            'w_id'        => 'widget_ui_down_line2',
            'w_name'      => 'Panda down-底线2',
            'classname'   => '',
            'description' => '显示底线，建议底部全宽度显示',
        );
        parent::__construct($widget['w_id'], $widget['w_name'], $widget);
    }
    public function widget($args, $instance)
    {
        echo '<div style="position: relative;text-align: center;"><img decoding="async" src="'.panda_pz('static_panda').'/assets/img/widgets/lan2.png">
  <p style="color:#6699FF;position: absolute;top: 30%;left: 50%;margin-left: -40px;font-size: 15px;">你已到达了世界的尽头</p>
</div>';
    }
}