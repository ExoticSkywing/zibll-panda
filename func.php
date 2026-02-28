<?php
/*
 * @Author: 苏晨
 * @Url: https://www.scbkw.com
 * @Date: 2025-01-09 16:42:44
 * @LastEditTime: 2025-08-21 14:39:22
 * @Email: 528609062@qq.com
 * @Project: 
 * @Description: 
 */

function panda_version()
{
    $auth = '4.0.5';
    return $auth;
}

function panda_name(){
    $name = 'Panda子主题';
    return $name;
}

// 获取及设置主题配置参数
function panda_pz($name, $default = false, $subname = '')
{
	//声明静态变量，加速获取
	static $options = null;
	if ($options === null) {
		$options = get_option('panda_options');
	}
	if (isset($options[$name])) {
		if ($subname) {
			return isset($options[$name][$subname]) ? $options[$name][$subname] : $default;
		} else {
			return $options[$name];
		}
	}
	return $default;
}
if(!function_exists('sg_load')){
    function sg_admin_notice() {
        ?>
       <div class="notice notice-warning">
            <p style="color:#ff2f86"><span class="dashicons-before dashicons-heart"></span></p>
            <b style="font-size: 1.2em;color:#ff2f86;">欢迎使用Panda子主题</b>
            <p>当前主题依赖Source Guardian Compiler扩展，请根据教程安装</p>
            <p><a class="button button-primary"href="../wp-content/themes/panda/help/source-guardian-loader-helper.php">立即安装</a>
            <a style="margin-left: 10px;" class="button" target="_blank" href="https://www.scbkw.com/1150.html/">查看教程</a>
            <a style="margin-left: 10px;" class="button" target="_blank" href="https://www.scbkw.com/">访问官网</a></p>
        </div>
        <?php
    }
    add_action('admin_notices', 'sg_admin_notice');
    
}elseif (extension_loaded('swoole_loader')) {
    $message = '';
    function sw_admin_notice() {
        ?>
        <div class="notice notice-warning">
            <p style="color:#ff2f86"><span class="dashicons-before dashicons-heart"></span></p>
            <b style="font-size: 1.2em;color:#ff2f86;">欢迎使用Panda子主题</b>
            <p>当前主题依赖Source Guardian Compiler扩展，此子主题不与Swoole Compiler扩展兼容，请先完成扩展卸载</p>
            <a style="margin-left: 10px;" class="button" target="_blank" href="https://www.scbkw.com/">访问官网</a></p>
        </div>
        <?php
    }
    add_action('admin_notices','sw_admin_notice');
} else{
    // 对接子主题核心文件
    require_once get_theme_file_path('/panda/functions.php');
    
    $require_once = array(
        'others-func.php',
    );
    
    foreach ($require_once as $require) {
        require_once get_theme_file_path('/' . $require);
    }
    
    // 加载 Xingxy 自定义功能模块
    $xingxy_init = get_theme_file_path('/xingxy/init.php');
    if (file_exists($xingxy_init)) {
        require_once $xingxy_init;
    }
}

// 前端投稿编辑器扩展
// 1.剪切（cut）复制（copy）粘贴（paste）撤销（undo）重做（redo）居中（justifycenter）
// 2.加粗（bold）斜体（italic）左对齐（justifyleft）右对齐（justfyright）
// 3.两端对齐（justfyfull）插入超链接（link）取消超链接（unlink）插入图片（image）
// 4.清除格式（removeformat）下划线（underline）删除线（strikethrough）
// 5.锚文本（anchor）新建文本（newdocument）
// 6.字体颜色（forecolor）字体背景色（backcolor）
// 7.格式选择（formmatselect）字体选择（fontselect）字号选择（fontsizeselect）
// 8.样式选择（styleselect）无序列表（bullist）编号列表（numlist）
// 9.减少缩进（outdent）缩进（indent）帮助（wp_help）
// 10打开HTML代码编辑器（code）水平线（hr）清除冗余代码（cleanup）
// 11.上标（sub）下标（sup）特殊符号（charmap）插入more标签（wp_more）
// 12.插入分页标签（wp_page）
// 13.隐藏按钮显示开关（wp_adv）
// 14.隐藏按钮区起始部分（wp_adv_start）
// 15.隐藏按钮区结束部分（wp_adv_end）
// 16.拼写检查（spellchecker）
function add_editor_buttons($buttons) {
    $buttons[] = 'cleanup';
    $buttons[] = 'hr';
    $buttons[] = 'del';
    $buttons[] = 'sub';
    $buttons[] = 'sup';
    $buttons[] = 'undo';
    $buttons[] = 'anchor';
    $buttons[] = 'backcolor';
    $buttons[] = 'wp_page';
    $buttons[] = 'charmap';
    return $buttons;
}add_filter("mce_buttons_3", "add_editor_buttons");


//取消 webP 格式环境检查
add_filter('plupload_default_settings', function($defaults) {
	$defaults['webp_upload_error'] = false;
	return $defaults;
}, 10, 1);
 
add_filter('plupload_init', function($plupload_init) {
	$plupload_init['webp_upload_error'] = false;
	return $plupload_init;
}, 10, 1);
