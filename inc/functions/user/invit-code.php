<?php
/*
 * @Author        : Qinver
 * @Url           : zibll.com
 * @Date          : 2021-09-22 10:30:38
 * @LastEditTime: 2025-10-15 20:29:49
 * @Email         : 770349780@qq.com
 * @Project       : Zibll子比主题
 * @Description   : 一款极其优雅的Wordpress主题|邀请码相关函数
 * @Read me       : 感谢您使用子比主题，主题源码有详细的注释，支持二次开发。
 * @Remind        : 使用盗版主题会存在各种未知风险。支持正版，从我做起！
 */

function zib_ajax_invit_code_must_verify()
{

    //执行人机验证，验证不通过自动结束并返回提醒
    zib_ajax_man_machine_verification();

    //执行安全验证检查，验证不通过自动结束并返回提醒
    zib_ajax_verify_nonce();

    //执行邀请码验证
    $invit_code = zib_ajax_invit_code_verify();

    zib_send_json_success(array('code' => $invit_code->password, 'msg' => '邀请码有效，请继续完成注册'));
}
add_action('wp_ajax_invit_code_must_verify', 'zib_ajax_invit_code_must_verify');
add_action('wp_ajax_nopriv_invit_code_must_verify', 'zib_ajax_invit_code_must_verify');

//AJAX方式验证邀请码是否存在
function zib_ajax_invit_code_verify($code = null)
{
    if (!$code) {
        $code = !empty($_REQUEST['invit_code']) ? trim($_REQUEST['invit_code']) : false;
    }
    $invit_code_s = _pz('invit_code_s'); //邀请码注册模式

    //必须输入但是用户没有输入，则警告
    if (!$code && $invit_code_s === 'must') {
        zib_send_json_error('请输入邀请码');
    }

    //不是必须，且用户没有输入，退出
    if (!$code) {
        return false;
    }

    //用户输入了
    //邀请码查询
    $invit_code = zib_get_valid_invit_code(esc_sql($code));

    if (empty($invit_code->id)) {
        zib_send_json_error('邀请码无效或已使用' . ($invit_code_s !== 'must' ? '，请修改或删除邀请码' : ''));
    }

    return $invit_code;
}

/**
 * @description: 查询一个有效的邀请码
 * @param {*} $code
 * @return {*}
 */
function zib_get_valid_invit_code($code)
{
    return ZibCardPass::get_row(array('password' => $code, 'type' => 'invit_code', 'status' => '0'));
}

/**
 * @description:使用邀请码
 * @param {*} $user_id
 * @param {*} $invit_code
 * @return {*}
 */
function zib_use_invit_code($user_id, $invit_code_obj)
{
    global $wpdb;
    $user_id = (int) $user_id;
    $invite_id = isset($invit_code_obj->id) ? (int) $invit_code_obj->id : 0;
    $fail = function($status) use ($invite_id) {
        // 注册调用方不消费返回值，日志只记录兑换行标识及状态，不记录邀请码或用户资料。
        error_log('[xingxy-invite-points] invite_id=' . $invite_id . ' status=' . $status);
        return false;
    };
    if ($user_id < 1 || $invite_id < 1) return $fail('invalid_redemption');

    // 必须以实际兑换记录为准，不能信任调用者携带的奖励或旧状态。
    $invite = ZibCardPass::get_row(array('id' => $invite_id, 'type' => 'invit_code'));
    if (!$invite || !is_object($invite) || $invite->type !== 'invit_code') return $fail('redemption_unavailable');
    if ($invite->status === 'used') {
        // 已兑换的同一使用者只恢复积分，不能重复发放余额、会员或经验。
        return zib_invit_code_points_reward($user_id, $invite) === true ? true : $fail('points_pending_or_unavailable');
    }
    if ($invite->status !== '0') return $fail('redemption_denied');

    $meta = is_array($invite->meta) ? $invite->meta : array();
    if (array_key_exists('xingxy_points_reward', $meta)) return $fail('invalid_intent');
    $points = !empty($meta['reward']['points']) && _pz('points_s') ? (int) $meta['reward']['points'] : 0;
    $meta['user_id'] = $user_id;
    $meta['xingxy_points_reward'] = array(
        'version' => 1, 'invite_id' => $invite_id, 'user_id' => $user_id,
        'amount' => $points, 'state' => $points !== 0 ? 'pending' : 'none',
    );

    // 状态与不可变积分意图在同一次条件更新中落库；另一使用者不能抢占已兑换行。
    $claimed = $wpdb->update($wpdb->zibpay_card_password, array(
        'status' => 'used', 'meta' => maybe_serialize($meta), 'modified_time' => current_time('mysql'),
    ), array(
        'id' => $invite_id, 'type' => 'invit_code', 'status' => '0', 'meta' => maybe_serialize($invite->meta),
    ), array('%s', '%s', '%s'), array('%d', '%s', '%s', '%s'));
    if ($claimed === false) return $fail('redemption_write_failed');
    if ($claimed !== 1) {
        // 另一请求已经兑换时，仅允许同一使用者恢复同一笔积分。
        return zib_invit_code_points_reward($user_id, $invite) === true ? true : $fail('points_pending_or_unavailable');
    }

    $persisted = ZibCardPass::get_row(array('id' => $invite_id, 'type' => 'invit_code'));
    if (!is_object($persisted) || $persisted->status !== 'used' || $persisted->meta !== $meta) return $fail('redemption_readback_failed');
    do_action('zib_use_invit_code', $user_id, $persisted);
    // action 不传播返回值：只读确认，不在此处悄悄重试失败的积分调用。
    return zib_invit_code_points_reward($user_id, $persisted, false) === true ? true : $fail('points_pending_or_unavailable');
}

/**
 * 恢复邀请码兑换的积分奖励；只使用已兑换行中持久化的使用者与金额。
 * $apply=false 仅检查确认状态，供不传播返回值的 action 调用方使用。
 */
function zib_invit_code_points_reward($user_id, $invit_code, $apply = true)
{
    global $wpdb;
    $user_id = (int) $user_id;
    $invit_code = (array) $invit_code;
    $invite_id = isset($invit_code['id']) ? (int) $invit_code['id'] : 0;
    if ($user_id < 1 || $invite_id < 1) return false;
    $invite = ZibCardPass::get_row(array('id' => $invite_id, 'type' => 'invit_code'));
    if (!is_object($invite) || $invite->type !== 'invit_code' || $invite->status !== 'used'
        || !is_array($invite->meta) || ($invite->meta['user_id'] ?? null) !== $user_id) return false;

    $terms = $invite->meta['xingxy_points_reward'] ?? null;
    if (!is_array($terms) || array_keys($terms) !== array('version', 'invite_id', 'user_id', 'amount', 'state')
        || $terms['version'] !== 1 || $terms['invite_id'] !== $invite_id || $terms['user_id'] !== $user_id
        || !is_int($terms['amount'])) return false;
    if ($terms['amount'] === 0) return $terms['state'] === 'none';
    if ($terms['state'] === 'confirmed') return true;
    if ($terms['state'] !== 'pending' || !$apply || !_pz('points_s')
        || !function_exists('zibpay_update_user_points')) return false;

    $result = zibpay_update_user_points($user_id, array(
        'order_num' => '',
        'value' => $terms['amount'],
        'type' => '邀请奖励',
        'desc' => '使用邀请码注册奖励',
        'event_namespace' => 'site.invite_code',
        'event_id' => 'invite-' . $invite_id . '-user-' . $user_id,
    ));
    if ($result !== true) return false;

    $meta = $invite->meta;
    $meta['xingxy_points_reward']['state'] = 'confirmed';
    $updated = $wpdb->update($wpdb->zibpay_card_password, array(
        'meta' => maybe_serialize($meta), 'modified_time' => current_time('mysql'),
    ), array(
        'id' => $invite_id, 'type' => 'invit_code', 'status' => 'used', 'meta' => maybe_serialize($invite->meta),
    ), array('%s', '%s'), array('%d', '%s', '%s', '%s'));
    if ($updated === false) return false;
    // 同一事件的并发确认也必须读回同一使用者、金额及最终状态。
    $persisted = ZibCardPass::get_row(array('id' => $invite_id, 'type' => 'invit_code'));
    return is_object($persisted) && $persisted->type === 'invit_code' && $persisted->status === 'used'
        && is_array($persisted->meta) && ($persisted->meta['user_id'] ?? null) === $user_id
        && ($persisted->meta['xingxy_points_reward'] ?? null) === $meta['xingxy_points_reward'];
}

/**
 * @description: 自动创建邀请码
 * @param {*} $num
 * @param {*} $price
 * @param {*} $rand_number
 * @param {*} $rand_password
 * @return {*}
 */
function zib_generate_invit_code($num, $rand_password = 8, $reward = array(), $other = '')
{
    $meta = array('reward' => $reward);
    $time = current_time('mysql');
    $data = [];

    for ($i = 1; $i <= $num; $i++) {
        $data[] = ZibCardPass::add(array(
            'password'      => ZibCardPass::rand_password($rand_password),
            'type'          => 'invit_code',
            'create_time'   => $time,
            'modified_time' => $time,
            'status'        => '0', //正常
            'meta'          => $meta,
            'other'         => $other,
        ));
    }

    return $data;
}

/**
 * @description: 获取奖励的文字介绍
 * @param {*} $reward
 * @return {*}
 */
function zib_get_invit_code_reward_text($reward = array(), $separator = '、')
{
    if (!$reward) {
        return '';
    }
    $data = array();

    foreach (CFS_Module::invit_code_reward() as $type) {
        $key  = $type['id'];
        $name = trim($type['title']) ? trim($type['title']) : $type['subtitle'];
        if (!empty($reward[$key])) {
            $data[] = $name . '：' . $reward[$key];
        }
    }

    if (!$data) {
        return '';
    }

    return implode($separator, $data);
}

//奖励
function zib_use_invit_code_reward($user_id, $invit_code)
{
    $invit_code = (array) $invit_code;
    $reward     = !empty($invit_code['meta']['reward']) ? (array) $invit_code['meta']['reward'] : false;

    if (!$reward) {
        return;
    }

    $points_result = true;
    foreach ($reward as $k => $v) {
        if (!$v) {
            continue;
        }
        switch ($k) {
            case 'level_integral':
                $v = (int) $v;
                if ($v && _pz('user_level_s')) {
                    zib_add_user_level_integral($user_id, $v, 'invit_code', true);
                }
                break;

            case 'points':
                $v = (int) $v;
                if ($v && _pz('points_s')) {
                    if (zib_invit_code_points_reward($user_id, $invit_code) !== true) {
                        $points_result = false;
                    }
                }
                break;

            case 'balance':
                $v = (float) $v;
                if ($v && _pz('pay_balance_s')) {
                    $data = array(
                        'order_num' => '', //订单号
                        'value'     => $v, //值 整数为加，负数为减去
                        'type'      => '邀请奖励', //中文说明
                        'desc'      => '使用邀请码注册奖励', //说明
                    );
                    zibpay_update_user_balance($user_id, $data);
                }
                break;

            case 'vip':
                $v = (int) $v;
                if ($v > 0 && _pz('pay_user_vip_' . $v . '_s')) {
                    $vip_time = !empty($reward['vip_time']) ? $reward['vip_time'] : 0;
                    $exp_date = 0;
                    if (strtolower($vip_time) === 'permanent') {
                        $exp_date = 'Permanent';
                    } else {
                        $exp_date = (int) $vip_time;
                        if ($exp_date > 0) {
                            $exp_date = date('Y-m-d 23:59:59', strtotime("+$exp_date day", strtotime(current_time('Y-m-d H:i:s'))));
                        }
                    }

                    if ($exp_date) {
                        $data = array(
                            'vip_level' => $v, //等级
                            'exp_date'  => $exp_date, //有效截至时间
                            'type'      => '邀请奖励', //中文说明
                            'desc'      => '使用邀请码注册赠送', //说明
                        );
                        zibpay_update_user_vip($user_id, $data);
                    }

                }
                break;
        }
    }

    return $points_result;
}
add_action('zib_use_invit_code', 'zib_use_invit_code_reward', 10, 2);

//用户自己有邀请码
//和推荐返利绑定
