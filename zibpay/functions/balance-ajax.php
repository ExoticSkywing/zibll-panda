<?php
/*
 * @Author        : Qinver
 * @Url           : zibll.com
 * @Date          : 2021-04-17 17:49:02
 * @LastEditTime: 2023-10-26 19:49:42
 * @Email         : 770349780@qq.com
 * @Project       : Zibll子比主题
 * @Description   : 一款极其优雅的Wordpress主题|用户余额系统
 * @Read me       : 感谢您使用子比主题，主题源码有详细的注释，支持二次开发。
 * @Remind        : 使用盗版主题会存在各种未知风险。支持正版，从我做起！
 */

//余额充值
function zibpay_ajax_balance_charge_modal()
{

    $user_id = get_current_user_id();

    echo zibpay_get_balance_charge_modal($user_id);
    exit;
}
add_action('wp_ajax_balance_charge_modal', 'zibpay_ajax_balance_charge_modal');

//购买积分
function zibpay_ajax_points_pay_modal()
{

    $user_id = get_current_user_id();

    echo zibpay_get_points_pay_modal($user_id);
    exit;
}
add_action('wp_ajax_points_pay_modal', 'zibpay_ajax_points_pay_modal');

//转账
function zibpay_ajax_pay_transfer_modal()
{

    $type      = !empty($_REQUEST['type']) ? $_REQUEST['type'] : 'points';
    $recipient = !empty($_REQUEST['recipient']) ? (int) $_REQUEST['recipient'] : 0;

    echo zibpay_get_pay_transfer_modal($type, $recipient);
    exit;
}
add_action('wp_ajax_pay_transfer_modal', 'zibpay_ajax_pay_transfer_modal');

//搜索转账用户明细
function zibpay_ajax_transfer_user_search()
{

    $type = !empty($_REQUEST['type']) ? $_REQUEST['type'] : 'points';
    $s    = !empty($_POST['s']) ? strip_tags(trim($_POST['s'])) : '';

    $lists       = '';
    $exclude     = array(get_current_user_id()); //排除自己
    $ice_perpage = 30; //最多30个
    $users_args  = array(
        'search'         => '*' . $s . '*',
        'exclude'        => $exclude,
        'search_columns' => array('user_email', 'user_nicename', 'display_name', 'user_login'),
        'count_total'    => false,
        'number'         => $ice_perpage,
        'fields'         => ['ID'],
        'meta_query'     => array(
            'relation' => 'OR', //排除禁封用户
            array(
                'key'     => 'banned',
                'value'   => array(1, 2),
                'compare' => 'NOT IN',
            ),
            array(
                'key'     => 'banned',
                'compare' => 'NOT EXISTS',
            ),
        ),
    );
    $user_search = new WP_User_Query($users_args);
    $users       = $user_search->get_results();

    if ($users) {
        foreach ($users as $user) {
            $lists .= zibpay_get_transfer_recipient_user_card($user->ID);
        }
    }

    if ($lists) {
        zib_send_json_success(array('data' => $lists, 'remind' => '请选择用户转账'));
    } else {
        zib_send_json_success(array('data' => zib_get_null('', 40, 'null-user.svg', '', 0, 150), 'remind' => '未找到相关用户'));
    }
    exit;
}
add_action('wp_ajax_transfer_user_search', 'zibpay_ajax_transfer_user_search');

function zibpay_ajax_pay_transfer()
{
    // An owned points request reaches the idempotent ledger before cached balances.
    if (($_REQUEST['type'] ?? 'points') !== 'balance') {
        try {
            $managed_points = apply_filters('xingxy_ecosystem_points_transfer_managed', false);
            if ($managed_points !== false) {
                if ($managed_points !== true || !class_exists('Xingxy_Ecosystem_Points_Transfer_Theme')) {
                    zib_send_json_error('转账暂不可用，请稍后重试');
                    return;
                }
                $sender = get_current_user_id();
                $target = Xingxy_Ecosystem_Points_Transfer_Theme::post_integer('recipient', PHP_INT_MAX);
                $gross = Xingxy_Ecosystem_Points_Transfer_Theme::post_integer('price', Xingxy_Ecosystem_Points_Ledger::MAX_POINTS);
                $fee = Xingxy_Ecosystem_Points_Transfer_Theme::fee_amount($gross, _pz('points_service_charge'));
                $managed = apply_filters('xingxy_ecosystem_points_transfer', null,
                    $sender, $target, $gross, $fee, $_POST['operation_id'] ?? null, '', '');
                if (!is_array($managed) || ($managed['ok'] ?? null) !== true || !is_bool($managed['replayed'] ?? null)) {
                    zib_send_json_error('转账暂不可用，请稍后重试');
                    return;
                }
                if (!$managed['replayed']) {
                    do_action('pay_transfer', 'points', wp_get_current_user(), get_userdata($target), $gross, _pz('points_service_charge'));
                }
                zib_send_json_success(['msg' => '转账成功', 'reload' => true]);
                return;
            }
        } catch (Throwable $exception) {
            zib_send_json_error('转账暂不可用，请稍后重试');
            return;
        }
    }

    $type      = !empty($_REQUEST['type']) ? $_REQUEST['type'] : 'points';
    $price     = !empty($_REQUEST['price']) ? ($type === 'balance' ? round((float) $_REQUEST['price'], 2) : (int) $_REQUEST['price']) : 0;
    $recipient = !empty($_REQUEST['recipient']) ? (int) $_REQUEST['recipient'] : 0;

    if ($price <= 0) {
        zib_send_json_error('请输入有效的转账金额');
    }

    //权限判断
    if (!zib_current_user_can($type . '_transfer')) {
        zib_send_json_error('权限不足');
    }

    $current_user    = wp_get_current_user();
    $current_user_id = $current_user->ID;

    //转账对象判断
    $recipient_user = get_userdata($recipient);
    if (!isset($recipient_user->display_name)) {
        zib_send_json_error('转账用户不存在，请重新选择');
    }

    if ($type === 'balance') {
        $type_name      = '余额';
        $max_val        = zibpay_get_user_balance($current_user_id);
        $service_charge = _pz('pay_balance_transfer_service_charge');
        $func           = 'zibpay_update_user_balance';
    } else {
        $type_name      = '积分';
        $max_val        = zibpay_get_user_points($current_user_id);
        $service_charge = _pz('points_service_charge');
        $func           = 'zibpay_update_user_points';
    }

    if ($max_val < $price) {
        zib_send_json_error('您的' . $type_name . '不足，最多可转账' . $max_val);
    }

    //准备转账
    $add = array(
        'value' => $service_charge ? ($price - $price * $service_charge / 100) : $price,
        'type'  => '转账',
        'desc'  => '来自用户[' . $current_user->display_name . ']的转账',
    );
    $del = array(
        'value' => -$price,
        'type'  => '转账',
        'desc'  => '转账给用户[' . $recipient_user->display_name . ']',
    );
    call_user_func($func, $recipient, $add);
    call_user_func($func, $current_user_id, $del);

    do_action('pay_transfer', $type, $current_user, $recipient_user, $price, $service_charge);

    zib_send_json_success(['msg' => '转账成功', 'reload' => true]);
}
add_action('wp_ajax_pay_transfer', 'zibpay_ajax_pay_transfer');

//管理员后台添加或扣除余额或者积分
function zibpay_ajax_admin_update_user_balance_or_points()
{
    // Admin points adjustments use the same explicit ownership boundary.
    if (($_REQUEST['action'] ?? null) !== 'admin_update_user_balance') {
        try {
            $managed_points = apply_filters('xingxy_ecosystem_points_transfer_managed', false);
            if ($managed_points !== false) {
                if ($managed_points !== true || !class_exists('Xingxy_Ecosystem_Points_Transfer_Theme')) {
                    zib_send_json_error('操作暂不可用，请稍后重试');
                    return;
                }
                $target = Xingxy_Ecosystem_Points_Transfer_Theme::post_integer('user_id', PHP_INT_MAX);
                $amount = Xingxy_Ecosystem_Points_Transfer_Theme::post_integer('val', Xingxy_Ecosystem_Points_Ledger::MAX_POINTS);
                if ($amount !== null && ($_POST['type'] ?? null) !== 'add') { $amount = -$amount; }
                $managed = apply_filters('xingxy_ecosystem_points_admin_adjust', null,
                    $target, $amount, Xingxy_Ecosystem_Points_Transfer_Theme::description(),
                    $_POST['operation_id'] ?? null, get_current_user_id());
                if (!is_array($managed) || ($managed['ok'] ?? null) !== true || !is_bool($managed['replayed'] ?? null)) {
                    zib_send_json_error('操作暂不可用，请稍后重试');
                    return;
                }
                zib_send_json_success('操作成功，请刷新页面后查看最新数据');
                return;
            }
        } catch (Throwable $exception) {
            zib_send_json_error('操作暂不可用，请稍后重试');
            return;
        }
    }


    if (!is_super_admin()) {
        zib_send_json_error('权限不足，仅管理员可操作');
    }

    $action  = $_REQUEST['action'];
    $user_id = !empty($_REQUEST['user_id']) ? (int) $_REQUEST['user_id'] : 0;
    $val     = !empty($_REQUEST['val']) ? ($action === 'admin_update_user_balance' ? round((float) $_REQUEST['val'], 2) : (int) $_REQUEST['val']) : 0;
    $decs    = !empty($_REQUEST['decs']) ? esc_attr($_REQUEST['decs']) : '';
    $type    = !empty($_REQUEST['type']) ? $_REQUEST['type'] : '';

    if (!$type) {
        zib_send_json_error('请选择添加或扣除');
    }

    if ($val <= 0) {
        zib_send_json_error('请输入数额');
    }

    if (!$user_id) {
        zib_send_json_error('数据或环境异常');
    }

    $val = $type === 'add' ? $val : -$val;

    $data = array(
        'value' => $val, //值 整数为加，负数为减去
        'type'  => '管理员手动' . ($type === 'add' ? '添加' : '扣除'),
        'desc'  => $decs, //说明
    );

    if ($action === 'admin_update_user_balance') {
        //余额管理
        if (!_pz('pay_balance_s')) {
            zib_send_json_error('余额功能已关闭');
        }
        zibpay_update_user_balance($user_id, $data);
    } else {
        //积分管理
        if (!_pz('points_s')) {
            zib_send_json_error('积分功能已关闭');
        }
        zibpay_update_user_points($user_id, $data);
    }

    zib_send_json_success('操作成功，请刷新页面后查看最新数据');

}
add_action('wp_ajax_admin_update_user_balance', 'zibpay_ajax_admin_update_user_balance_or_points');
add_action('wp_ajax_admin_update_user_points', 'zibpay_ajax_admin_update_user_balance_or_points');
