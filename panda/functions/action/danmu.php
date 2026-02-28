<?php if (!defined('ABSPATH')) {
    die;
}
function danmujs()
{
    $static_panda_url = panda_pz('static_panda');
wp_enqueue_style('danmu-cs', $static_panda_url . '/assets/css/danmu.css', array(), panda_version(), false);
wp_enqueue_script('danmu-js', $static_panda_url . '/assets/js/danmu.js', array('jquery'), panda_version(), true);
}
function danmu_pay_detail_list($order)
{
    $methods    = payment_method_args();
    $order      = (array) $order;
    $pay_detail = maybe_unserialize($order['pay_detail']);
    $lists      = '';
    $i          = 1;
    foreach ($methods as $k => $v) {
        if (!empty($pay_detail[$k])) {
            $lists = $v['name'] == '卡密' ? '充值' : '支付';
            $lists = $v['name'] . $lists . $pay_detail[$k] . $v['currency'];
            $i++;
        }
    }
    return $lists;
}
function payment_method_args()
{

    $payment_method_names = array(
        'wechat'    => array(
            'name' => ' ',
            'currency' => '元',
        ),
        'alipay'    => array(
            'name' => ' ',
            'currency' => '元',
        ),
        'balance'   => array(
            'name' => ' ',
            'currency' => _pz('pay_mark'),
        ),
        'points'    => array(
            'name' => ' ',
            'currency' => '积分'
        ),
        'card_pass' => array(
            'name' => ' ',
            'currency' => ''
        ),
    );

    return $payment_method_names;
}
function pay_type_name($pay_type, $product_id = '', $postid = '')
{
    if (!empty($postid)) {
        if (!get_permalink($postid)) {
            $n = '已删除资源';
        } else {
            $n = '&nbsp购买&nbsp<a class="altitle" target="_blank" href="' . get_permalink($postid) . '" style="color: #fff;">' . get_the_title($postid) . '</a>';
        }
        return $n;
    }
    if ($pay_type == '4' && !empty($product_id)) {
        $playtypename = array(
            'upgrade' => '升级了',
            'pay' => '购买了',
            'renew' => '续费了',
        );
        $user_vip_name = array(
            'vip_1' => _pz('pay_user_vip_1_name'),
            'vip_2' => _pz('pay_user_vip_2_name'),
        );
        $playtype = substr($product_id, strripos($product_id, "_") + 1);
        $playtype = $playtypename[$playtype];
        $vipname = substr($product_id, 0, strrpos($product_id, "_") - 2);
        $vipname = $user_vip_name[$vipname];
        $n = $playtype . $vipname;
        return $n;
    }
    $name = array(
        '1' => '付费阅读',
        '2' => '付费资源',
        '3' => '产品购买',
        '4' => '购买会员',
        '5' => '付费图片',
        '6' => '付费视频',
        '7' => '自动售卡',
        '8' => _pz('pay_mark'),
        '9' => '购买积分',
    );

    $n = isset($name[$pay_type]) ? $name[$pay_type] : '付费内容';

    return $n;
}

function danmu()
{

    global $wpdb;
    $limit = panda_pz('danmu_limit') != 0 ? panda_pz('danmu_limit') : 1;
    $total_trade = $wpdb->get_results("SELECT * FROM $wpdb->zibpay_order WHERE `status` = 1 ORDER BY $wpdb->zibpay_order . `id` DESC LIMIT $limit");
    $returnarray = array();
    foreach ($total_trade as $item) {
        $psy_price = danmu_pay_detail_list($item);
        $product_id = $item->product_id;
        $pay_type_name = pay_type_name($item->order_type, $product_id, $item->post_id);
        $psy_content = $psy_price . $pay_type_name;
        $danmu_auth = panda_pz('danmu_auth');
        $arr = array(
            "type" => "comment",
            "now_user_link" => zib_get_user_home_url($item->user_id),
            "t" => strtotime($item->create_time),
            "avatar" => zib_get_data_avatar($item->user_id),
            "name" => zib_get_user_name("id=$item->user_id&auth=$danmu_auth&level=$danmu_level"),
            "content" =>  $psy_content
        );
        array_push($returnarray, $arr);
    }
    header("Content-Type: application/json");
    echo json_encode($returnarray);
    exit;
}
if (panda_pz('danmu') && !wp_is_mobile()) {
    add_action('wp_enqueue_scripts', 'danmujs');
    add_action('wp_ajax_nopriv_danmu', 'danmu');
    add_action('wp_ajax_danmu', 'danmu');
}
