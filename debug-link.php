<?php
require_once('../../../wp-load.php');

$user_id = 26;
$url = 'https://xingxy.manyuzo.com/shop/304.html';
echo "zibpay_get_rebate_link(26, url): " . zibpay_get_rebate_link($user_id, $url) . "\n";
echo "function_exists('xingxy_generate_referral_url') ? " . (function_exists('xingxy_generate_referral_url') ? 'YES' : 'NO') . "\n";
