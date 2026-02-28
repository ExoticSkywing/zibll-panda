<?php

/*  用户随机头像教程 */
if (panda_pz('user_avatar_random_style')) {
    function zib2_sign_in($user_id) {
        if (!$user_id) {
            return;
        }
        $static_panda_url = panda_pz('static_panda');
        $social_login = get_user_meta($user_id, 'oauth_new', true);
        $avatars_base_dir = $static_panda_url . '/assets/img/tx/'; 
        $avatars = glob($avatars_base_dir . '*.{jpg,jpeg,png,gif}', GLOB_BRACE | GLOB_NOSORT);
        if (empty($avatars)) {
            return;
        }
        $random_avatar_path = $avatars[array_rand($avatars)];
        $url = home_url($static_panda_url . '/assets/img/tx/' . basename($random_avatar_path));
        zib_update_user_meta($user_id, 'custom_avatar_id', 1);
        zib_update_user_meta($user_id, 'custom_avatar', $url);
    }
    add_action('user_register', 'zib2_sign_in');
}

/* 头像用户头像呼吸灯效果 */
if (panda_pz('user_avatar_light_style')) {
    function user_avatar_light_style() {
        echo '<style>.avatar {border-radius: 50%;animation: light 4s ease-in-out infinite;transition: 0.5s;}</style>';
    } add_action('wp_head', 'user_avatar_light_style');
}

/* 用户头像鼠标经过效果 */
if (panda_pz('user_avatar_hover_style')) {
    function user_avatar_hover_style() {
        echo '<style>.avatar:hover {transform: scale(1.15) rotate(720deg);}@keyframes light {0% {box-shadow: 0 0 4px #f00;}25% {box-shadow: 0 0 16px #0f0;}50% {box-shadow: 0 0 4px #00f;}75% {box-shadow: 0 0 16px #0f0;}100% {box-shadow: 0 0 4px #f00;}}</style>';
    } add_action('wp_head', 'user_avatar_hover_style');
}

if(panda_pz('user_avatar_shake_style')){
    function user_avatar_shake_style(){
        echo '<style>.avatar {animation: shake 0.82s cubic-bezier(0.36, 0.07, 0.19, 0.97) infinite;transform: translate3d(0, 0, 0);}</style>';
    }add_action('wp_head', 'user_avatar_shake_style');
}

if(panda_pz('widget_user_avatar_shake_style')){
    function widget_user_avatar_shake_style(){
        echo '    <style>/*小工具头像跳动*/
.user-avatar .avatar-img, .img-ip:hover, .w-a-info img {
   -webkit-animation: swing 3s .4s ease both;
   -moz-animation: swing 3s .4s ease both;
}
@-webkit-keyframes swing {
   20%, 40%, 60%, 80%, 100% {
       -webkit-transform-origin:top center
   }
   20% {
       -webkit-transform:rotate(15deg)
   }
   40% {
       -webkit-transform:rotate(-10deg)
   }
   60% {
       -webkit-transform:rotate(5deg)
   }
   80% {
       -webkit-transform:rotate(-5deg)
   }
   100% {
       -webkit-transform:rotate(0deg)
   }
}
@-moz-keyframes swing {
   20%, 40%, 60%, 80%, 100% {
       -moz-transform-origin:top center
   }
   20% {
       -moz-transform:rotate(15deg)
   }
   40% {
       -moz-transform:rotate(-10deg)
   }
   60% {
       -moz-transform:rotate(5deg)
   }
   80% {
       -moz-transform:rotate(-5deg)
   }
   100% {
       -moz-transform:rotate(0deg)
   }
}</style>';
    }add_action('wp_head', 'widget_user_avatar_shake_style');
}
//彩色昵称
if (panda_pz('user_color_name_style')) {
    function user_color_name_style(){?>
        <style>
            .display-name{
            background-image: -webkit-linear-gradient(90deg, #07c160, #fb6bea 25%, #3aedff 50%, #fb6bea 75%, #28d079);
            -webkit-text-fill-color: transparent;
            -webkit-background-clip: text;
            background-size: 100% 600%;
            animation: wzw 10s linear infinite;
            }
            @keyframes wzw {
            0% {
            background-position: 0 0;
            }
            100% {
            background-position: 0 -300%;
            }
            }
        </style>
    <?php }
    add_action('wp_head', 'user_color_name_style');
}

//昵称抖动
if (panda_pz('user_name_shake_style')) {

    function user_name_shake_style(){?>
    <style>.display-name {
  animation: animate 0.5s linear infinite;
}

@keyframes animate {
  0%, 100% {
    text-shadow: -1.5px -1.5px 0 #0ff, 1.5px 1.5px 0 #f00;
  }
  25% {
    text-shadow: 1.5px 1.5px 0 #0ff, -1.5px -1.5px 0 #f00;
  }
  50% {
    text-shadow: 1.5px -1.5px 0 #0ff, 1.5px -1.5px 0 #f00;
  }
  75% {
    text-shadow: -1.5px 1.5px 0 #0ff, -1.5px 1.5px 0 #f00;
  }
}</style>
    <?php }
    add_action('wp_head', 'user_name_shake_style');
}

//用户信息
if((panda_pz('user_center_join_style')) || (panda_pz('user_center_uid_style'))) {
function panda_user_to_desc($desc,$user_id){
    $user_id_html='';
    if (panda_pz('user_center_join_style')){
        $user_id_html.= '<span class="but c-theme"><svg class="icon" aria-hidden="true"><use xlink:href="#icon-user-color"></use></svg>加入小窝'.zib_get_user_join_days($user_id).'天啦～</span>';
    }
    if (panda_pz('user_center_uid_style')){
        $user_id_html.= '<span class="but c-theme"><i class="fa fa-id-card-o"></i>UID：' . $user_id . '</span>';
    }
    $desc = $user_id_html . $desc;
    return $desc;
}
add_filter('user_page_header_desc', 'panda_user_to_desc', 10, 2);
if (panda_pz('user_center_join_style')){
    function panda_user_to_iden($desc,$user_id){
        $user_id_html= '<span class="but c-theme"><svg class="icon" aria-hidden="true"><use xlink:href="#icon-user-color"></use></svg>加入小窝'.zib_get_user_join_days($user_id).'天啦～</span>';
        $desc = $user_id_html . $desc;
        return $desc;
    }
    add_filter('author_header_identity', 'panda_user_to_iden', 10, 2);
}
}

//开通会员自动认证
if (panda_pz('custom_payment_order_success')) {
    function custom_payment_order_success($order) {
        global $wpdb;
        $product_id = $wpdb->get_var($wpdb->prepare("SELECT product_id FROM {$wpdb->zibpay_order} WHERE order_num = %s", $order->order_num));
        $vip_id  =['vip_1', 'vip_2'];   
        foreach ($vip_id as $item) {  
            if (strpos($product_id, $item) !== false) {  
                $product_id=$item;  
                break; 
            }  
        }
        if (in_array($product_id, panda_pz('custom_payment_order_success_vip'))) {
            $user_id = get_current_user_id();
            zib_add_user_auth($user_id, array(
                'name' => panda_pz('user_auth_info_style'),
                'desc' => panda_pz('user_auth_desc_style'),
            ));
        }
    }
    
    add_action('payment_order_success', 'custom_payment_order_success');
}

function zb_vip_add_member($user_id)
{
    //注册赠送会员
    $set_level = panda_pz('zb_vip_lever'); //会员等级
    if(panda_pz('zb_vip_time') == 'Permanent'){
        $set_time  = 'Permanent';
    }else{
        $set_time  = date('Y-m-d H:i', strtotime('+' .panda_pz('zb_vip_time') .' day')); //
    }
    update_user_meta($user_id, 'vip_level', $set_level);
    update_user_meta($user_id, 'vip_exp_date', $set_time);
}
if(panda_pz('panda_vip',false)){
    add_action('user_register', 'zb_vip_add_member');
}
    
function zb_auth_add_member($user_id)
{
    //注册添加认证
    $auth_info = array(
        'name' => panda_pz('zb_auth_title'), //认证名称
        'desc' => panda_pz('zb_auth_descript'), //认证说明
        'time' => current_time('Y-m-d H:i'),
    );
    zib_add_user_auth($user_id, $auth_info);
}
if(panda_pz('register_auth_iso',false)){
    add_action('user_register', 'zb_auth_add_member');
}
    
    
/****支付成功后为用户赠送会员 */
if(panda_pz('buy_product_vip',false)){
    function zb_api_pay_success($pay_order)
    {
        $pay_order = (array) $pay_order;
        $post_id   = $pay_order['post_id'];
        $user_id   = $pay_order['user_id'];
        if(panda_pz('zb_product_vip_time') == 'Permanent'){
            $vip_time  = 'Permanent';
        }else{
            $vip_time  = date('Y-m-d H:i', strtotime('+' . panda_pz('zb_product_vip_time') .' day'));
        }
        if ($user_id && $post_id && $post_id == panda_pz('zb_product_vip_post')) {
            update_user_meta($user_id, 'vip_exp_date', $vip_time);
            update_user_meta($user_id, 'vip_level', panda_pz('zb_product_vip_lever'));
        }
    }add_action('payment_order_success', 'zb_api_pay_success');
}

if(panda_pz('user_buy_post_auth_style')){
    // 购买文章自动认证
function zibll_add_meta_box() {
    add_meta_box(
        'zibll_auth_meta_box',           
        '认证用户设置',
        'zibll_auth_meta_box_callback',
        'post',
        'side'
    );
}
add_action('add_meta_boxes', 'zibll_add_meta_box');

function zibll_auth_meta_box_callback($post) {
    // 获取元数据
    $is_enabled = get_post_meta($post->ID, '_zibll_auth_enabled', true);
    $name = get_post_meta($post->ID, '_zibll_auth_name', true);
    $desc = get_post_meta($post->ID, '_zibll_auth_desc', true);

    ?>
    <p>
        <label for="zibll_auth_enabled">
            <input type="checkbox" name="zibll_auth_enabled" id="zibll_auth_enabled" value="1" <?php checked($is_enabled, 1); ?> />
            启用认证用户功能
        </label>
    </p>
    <p>
        <label for="zibll_auth_name">认证名称：</label>
        <input type="text" name="zibll_auth_name" id="zibll_auth_name" value="<?php echo esc_attr($name); ?>" placeholder="默认：认证用户" />
    </p>
    <p>
        <label for="zibll_auth_desc">认证描述：</label>
        <input type="text" name="zibll_auth_desc" id="zibll_auth_desc" value="<?php echo esc_attr($desc); ?>" placeholder="默认：赞助会员" />
    </p>
    <p>
        <ul>
            <li>启用后请确保已打开付费下载</li>
            <li>购买后将会自动认证，无需审核</li>
            <li>留空认证名称或描述则使用默认值</li>
        </ul>
    </p>
    <?php
}

function zibll_save_post_meta($post_id) {

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['zibll_auth_enabled'])) {
        update_post_meta($post_id, '_zibll_auth_enabled', 1);
    } else {
        delete_post_meta($post_id, '_zibll_auth_enabled');
    }

    if (isset($_POST['zibll_auth_name'])) {
        update_post_meta($post_id, '_zibll_auth_name', sanitize_text_field($_POST['zibll_auth_name']));
    } else {
        delete_post_meta($post_id, '_zibll_auth_name');
    }

    if (isset($_POST['zibll_auth_desc'])) {
        update_post_meta($post_id, '_zibll_auth_desc', sanitize_text_field($_POST['zibll_auth_desc']));
    } else {
        delete_post_meta($post_id, '_zibll_auth_desc');
    }
}
add_action('save_post', 'zibll_save_post_meta');

function zibll_users_zidongrenzheng($pay_order) {
    $pay_order = (array) $pay_order;
    $post_id   = $pay_order['post_id'];
    $user_id   = $pay_order['user_id'];

    $is_enabled = get_post_meta($post_id, '_zibll_auth_enabled', true);
    if ($is_enabled) {
        $name = get_post_meta($post_id, '_zibll_auth_name', true);
        $desc = get_post_meta($post_id, '_zibll_auth_desc', true);

        // 设置默认值
        if (empty($name)) {
            $name = '认证用户';
        }
        if (empty($desc)) {
            $desc = '赞助会员';
        }

        // 添加认证操作
        zib_add_user_auth($user_id, array(
            'name' => $name,
            'desc' => $desc,
        ));
    }
}
add_action('payment_order_success', 'zibll_users_zidongrenzheng');
}