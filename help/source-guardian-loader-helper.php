<?php
/*
 * @Author: 苏晨
 * @Url: https://www.scbkw.com
 * @Date: 2025-01-09 14:34:58
 * @LastEditTime: 2025-01-10 10:20:07
 * @Email: 528609062@qq.com
 * @Project: 
 * @Description: 
 */
 
// 定义中文语言包
$languages['zh-cn'] = [
    'title' => 'Source Guardian Loader 安装',
];

// 环境信息数组
$env = [];

// 操作系统信息
$env['os'] = [];
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    $env['os']['name'] = "windows";
    $env['os']['raw_name'] = php_uname();
    $env['os']['bit'] = (PHP_INT_SIZE === 8) ? 64 : 32;
} else {
    $env['os']['name'] = "linux";
    $env['os']['raw_name'] = php_uname();
}

// PHP信息
$env['php'] = [];
$env['php']['version'] = phpversion();

$sapi_type = php_sapi_name();
if ("cli" == $sapi_type) {
    $env['php']['run_mode'] = "cli";
} else {
    $env['php']['run_mode'] = "web";
}

if (PHP_INT_SIZE == 4) {
    $env['php']['bit'] = 32;
} else {
    $env['php']['bit'] = 64;
}
$env['php']['sapi'] = $sapi_type;
$env['php']['ini_loaded_file'] = php_ini_loaded_file();
$env['php']['ini_scanned_files'] = php_ini_scanned_files();
$env['php']['loaded_extensions'] = get_loaded_extensions();
$env['php']['incompatible_extensions'] = ['xdebug', 'ionCube', 'zend_loader'];
$env['php']['loaded_incompatible_extensions'] = [];
$env['php']['extension_dir'] = ini_get('extension_dir');

// 检查加载的扩展中是否包含不兼容的扩展
if (is_array($env['php']['loaded_extensions'])) {
    foreach ($env['php']['loaded_extensions'] as $loaded_extension) {
        foreach ($env['php']['incompatible_extensions'] as $incompatible_extension) {
            if (strpos(strtolower($loaded_extension), strtolower($incompatible_extension)) !== false) {
                $env['php']['loaded_incompatible_extensions'][] = $loaded_extension;
            }
        }
    }
}
$env['php']['loaded_incompatible_extensions'] = array_unique($env['php']['loaded_incompatible_extensions']);

// 判断Source Guardian是否已安装
if (!function_exists('sg_load')) {
    $status = '<span style="color:red;">未安装</span>';
} else {
    $status = '<span style="color:green;">已安装</span>';
}

// 下载地址数组
$download_url = [
    'linux'=>[
        'nosafety'=>[
            '7.0'=> 'https://www.scbkw.com/wp-others/sg/linux/nosafety/ixed.7.0.lin',
            '7.1'=> 'https://www.scbkw.com/wp-others/sg/linux/nosafety/ixed.7.1.lin',
            '7.2'=> 'https://www.scbkw.com/wp-others/sg/linux/nosafety/ixed.7.2.lin',
            '7.3'=> 'https://www.scbkw.com/wp-others/sg/linux/nosafety/ixed.7.3.lin',
            '7.4'=> 'https://www.scbkw.com/wp-others/sg/linux/nosafety/ixed.7.4.lin',
            '8.0'=> 'https://www.scbkw.com/wp-others/sg/linux/nosafety/ixed.8.0.lin',
            '8.1'=> 'https://www.scbkw.com/wp-others/sg/linux/nosafety/ixed.8.1.lin',
            '8.2'=> 'https://www.scbkw.com/wp-others/sg/linux/nosafety/ixed.8.2.lin',
            '8.3'=> 'https://www.scbkw.com/wp-others/sg/linux/nosafety/ixed.8.3.lin',
        ],
        'safety'=>[
            '7.0'=> 'https://www.scbkw.com/wp-others/sg/linux/safety/ixed.7.0ts.lin',
            '7.1'=> 'https://www.scbkw.com/wp-others/sg/linux/safety/ixed.7.1ts.lin',
            '7.2'=> 'https://www.scbkw.com/wp-others/sg/linux/safety/ixed.7.2ts.lin',
            '7.3'=> 'https://www.scbkw.com/wp-others/sg/linux/safety/ixed.7.3ts.lin',
            '7.4'=> 'https://www.scbkw.com/wp-others/sg/linux/safety/ixed.7.4ts.lin',
            '8.0'=> 'https://www.scbkw.com/wp-others/sg/linux/safety/ixed.8.0ts.lin',
            '8.1'=> 'https://www.scbkw.com/wp-others/sg/linux/safety/ixed.8.1ts.lin',
            '8.2'=> 'https://www.scbkw.com/wp-others/sg/linux/safety/ixed.8.2ts.lin',
            '8.3'=> 'https://www.scbkw.com/wp-others/sg/linux/safety/ixed.8.3ts.lin',
        ]
    ],
    'windows'=>[
        '32' => [
            'nosafety'=>[
                '7.0'=> 'https://www.scbkw.com/wp-others/sg/window/x86/nosafety/ixed.7.0.win',
                '7.1'=> 'https://www.scbkw.com/wp-others/sg/window/x86/nosafety/ixed.7.1.win',
                '7.2'=> 'https://www.scbkw.com/wp-others/sg/window/x86/nosafety/ixed.7.2.win',
                '7.3'=> 'https://www.scbkw.com/wp-others/sg/window/x86/nosafety/ixed.7.3.win',
                '7.4'=> 'https://www.scbkw.com/wp-others/sg/window/x86/nosafety/ixed.7.4.win',
                '8.0'=> 'https://www.scbkw.com/wp-others/sg/window/x86/nosafety/ixed.8.0.win',
                '8.1'=> 'https://www.scbkw.com/wp-others/sg/window/x86/nosafety/ixed.8.1.win',
                '8.2'=> 'https://www.scbkw.com/wp-others/sg/window/x86/nosafety/ixed.8.2.win',
                '8.3'=> 'https://www.scbkw.com/wp-others/sg/window/x86/nosafety/ixed.8.3.win',
            ],
            'safety'=>[
                '7.0'=> 'https://www.scbkw.com/wp-others/sg/window/x86/safety/ixed.7.0ts.win',
                '7.1'=> 'https://www.scbkw.com/wp-others/sg/window/x86/safety/ixed.7.1ts.win',
                '7.2'=> 'https://www.scbkw.com/wp-others/sg/window/x86/safety/ixed.7.2ts.win',
                '7.3'=> 'https://www.scbkw.com/wp-others/sg/window/x86/safety/ixed.7.3ts.win',
                '7.4'=> 'https://www.scbkw.com/wp-others/sg/window/x86/safety/ixed.7.4ts.win',
                '8.0'=> 'https://www.scbkw.com/wp-others/sg/window/x86/safety/ixed.8.0ts.win',
                '8.1'=> 'https://www.scbkw.com/wp-others/sg/window/x86/safety/ixed.8.1ts.win',
                '8.2'=> 'https://www.scbkw.com/wp-others/sg/window/x86/safety/ixed.8.2ts.win',
                '8.3'=> 'https://www.scbkw.com/wp-others/sg/window/x86/safety/ixed.8.3ts.win',
            ]
        ],
        '64' => [
            'nosafety'=>[
                '7.0'=> 'https://www.scbkw.com/wp-others/sg/window/x64/nosafety/ixed.7.0.win',
                '7.1'=> 'https://www.scbkw.com/wp-others/sg/window/x64/nosafety/ixed.7.1.win',
                '7.2'=> 'https://www.scbkw.com/wp-others/sg/window/x64/nosafety/ixed.7.2.win',
                '7.3'=> 'https://www.scbkw.com/wp-others/sg/window/x64/nosafety/ixed.7.3.win',
                '7.4'=> 'https://www.scbkw.com/wp-others/sg/window/x64/nosafety/ixed.7.4.win',
                '8.0'=> 'https://www.scbkw.com/wp-others/sg/window/x64/nosafety/ixed.8.0.win',
                '8.1'=> 'https://www.scbkw.com/wp-others/sg/window/x64/nosafety/ixed.8.1.win',
                '8.2'=> 'https://www.scbkw.com/wp-others/sg/window/x64/nosafety/ixed.8.2.win',
                '8.3'=> 'https://www.scbkw.com/wp-others/sg/window/x64/nosafety/ixed.8.3.win',
            ],
            'safety'=>[
                '7.0'=> 'https://www.scbkw.com/wp-others/sg/window/x64/safety/ixed.7.0ts.win',
                '7.1'=> 'https://www.scbkw.com/wp-others/sg/window/x64/safety/ixed.7.1ts.win',
                '7.2'=> 'https://www.scbkw.com/wp-others/sg/window/x64/safety/ixed.7.2ts.win',
                '7.3'=> 'https://www.scbkw.com/wp-others/sg/window/x64/safety/ixed.7.3ts.win',
                '7.4'=> 'https://www.scbkw.com/wp-others/sg/window/x64/safety/ixed.7.4ts.win',
                '8.0'=> 'https://www.scbkw.com/wp-others/sg/window/x64/safety/ixed.8.0ts.win',
                '8.1'=> 'https://www.scbkw.com/wp-others/sg/window/x64/safety/ixed.8.1ts.win',
                '8.2'=> 'https://www.scbkw.com/wp-others/sg/window/x64/safety/ixed.8.2ts.win',
                '8.3'=> 'https://www.scbkw.com/wp-others/sg/window/x64/safety/ixed.8.3ts.win',
            ]
        ]
    ],
];

// 解析PHP操作系统、版本和安全性
$_php_os = $env['os']['name'];
$_php_v = substr($env['php']['version'], 0, 3);
$_is_safety = (empty($sysInfo['thread_safety'])) ? 'nosafety' : 'safety';

// 获取下载URL
if ($_php_os == 'windows') {
    $_php_bit = $env['os']['bit'];
    $the_os_downurl = $download_url[$_php_os][$_php_bit][$_is_safety][$_php_v];
} else {
    $the_os_downurl = $download_url[$_php_os][$_is_safety][$_php_v];
}

preg_match('/\/([^\/]+\.[a-z]+)[^\/]*$/', $the_os_downurl, $down_name);

// 构建Web页面
if ('web' == $env['php']['run_mode']) {
    $language = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 4);
    if (preg_match("/zh-c/i", $language)) {
        $env['lang'] = "zh-cn";
        $wizard_lang = $env['lang'];
    }
    
    $html = '';
    
    // 构建HTML头部
    $html_header = '<!doctype html>
    <html lang="zh-cn">
      <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Bootstrap CSS -->
        <link href="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/4.1.0/css/bootstrap.min.css" rel="stylesheet">
        <title>%s</title>
        <style>
            .list_info {display: inline-block; width: 12rem;}
            .bold_text {font-weight: bold;}
            .code {color:#007bff;font-size: medium;}
        </style>
      </head>
      <body class="bg-light"> 
      ';
    $html_header = sprintf($html_header, $languages[$wizard_lang]['title']);
    
    // 构建HTML主体
    $html_body = '<div class="container">';
    $html_body_nav = '<div class="py-5 text-center"  style="padding-bottom: 1rem!important;">';
    $html_body_nav .= '<h2>Source Guardian 安装向导</h2>';
    $html_body_nav .= '<p class="lead">Panda子主题需要Source Guardian扩展，支持PHP7.2~8.3，推荐7.4</p>';
    $html_body_nav .=  '</div><hr>';
    
    // 构建环境信息部分
    $html_body_environment = '
    <div class="col-12"  style="padding-top: 1rem!important;">
        <h5 class="text-center">检查当前环境</h5>
        <ul class="list-unstyled text-small">';
    $html_body_environment .= '<li><span class="list_info">操作系统 : </span>' . $env['os']['raw_name'] . '</li>';
    $html_body_environment .= '<li><span class="list_info">PHP版本 : </span>' . $env['php']['version'] . '</li>';
    $html_body_environment .= '<li><span class="list_info">PHP运行环境 : </span>' . $env['php']['sapi'] . '</li>';
    $html_body_environment .= '<li><span class="list_info">PHP配置文件 : </span>'  . $env['php']['ini_loaded_file'] . '</li>';
    $html_body_environment .= '<li><span class="list_info">PHP扩展安装目录 : </span>' . $env['php']['extension_dir'] . '</li>';
    $html_body_environment .= '<li><span class="list_info">是否安装Source Guardian : </span>' . $status;


    $html_body_environment .= '<hr>';
    $html_body_environment .= '<div class="col-12"  style="padding-top: 1rem!important;">
        <h5 class="text-center">自动安装和配置Source Guardian Loader</h5>
        <ul class="list-unstyled text-small">';
    $html_body_environment .= '<li>宝塔、1panle、DirectAdmin、phpstudy或其他面板中查找PHP扩展：sg15 安装重启即可<li>';
    
    // 构建Loader安装部分
    $html_body_loader = '<hr>';
    
    if (empty($html_error)) {
        $html_body_loader .= '<div class="col-12" style="padding-top: 1rem!important;">';
        $html_body_loader .= '<h5 class="text-center">手动安装和配置Source Guardian Loader</h5>';
        $html_body_loader .= '<p><span class="bold_text">1 - <a class="btn btn-primary" target="_blank" href="'.$the_os_downurl.'">点击下载 '.$_php_os.' PHP'.$_php_v.' Source Guardian Loader扩展文件</a></span></p>';
    
        $html_body_loader .= '<p><span class="bold_text">2 - 安装Source Guardian Loader</span></p><p>将刚才下载的Source Guardian Loader扩展文件（'.$down_name[1].'）上传到当前PHP的扩展安装目录中：<br/><pre class="code">' . $env['php']['extension_dir'] . '</pre></p>';
    
        $html_body_loader .= '<p><span class="bold_text">3 - 修改php.ini配置</span>（如已修改配置，请忽略此步骤，不必重复添加）</p><p>';
        $html_body_loader .= '编辑此PHP配置文件：<span class="code">'.$env['php']['ini_loaded_file'].'</span>，在此文件底部结尾处加入如下配置<br/>';
        if ($env['os']['name'] ==  "windows") {
            $html_body_loader .= '<pre class="code">extension='.$down_name[1].'</pre><small>注意：需要名称和刚才上传到当前PHP的扩展安装目录中的文件名一致</small>';
        } else {
            $html_body_loader .= '<pre class="code">extension='.$down_name[1].'</pre><small>注意：需要名称和刚才上传到当前PHP的扩展安装目录中的文件名一致</small>';
        }
        $html_body_loader .= '</p>';
        $html_body_loader .= '<p><span class="bold_text">4 - 重启服务器</span></p><p>重启PHP或者重启服务器</p>';
        $html_body_loader .= '<p><span class="bold_text">5 - <a class="btn btn-primary" href="javascript:location.reload()">刷新页面</a></span>，当前环境中安装Source Guardian显示已安装则说明安装成功</p>';
        $html_body_loader .= '</div>';
    }

    $html_body .= $html_body_nav . '<div class="row">' . $html_body_environment  . $html_body_loader . '</div>';
    $html_body .= '</div>';
    
    // 构建HTML尾部
    $html_footer = '
        <script src="../wp-content/themes/panda/assets/js/jquery.min.js"></script>
        <script src="../wp-content/themes/panda/assets/js/axios.min.js"></script>
        <script src="../wp-content/themes/panda/assets/js/bootstrap.min.js"></script>
        </body>
    </html>';
    
    $html = $html_header .  $html_body . $html_footer;
    
    echo $html;
}