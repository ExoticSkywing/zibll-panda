<?php
/*
 * @Author        : Qinver
 * @Url           : zibll.com
 * @Date          : 2020-09-29 13:18:36
 * @LastEditTime: 2025-02-24 16:04:31
 * @Email         : foxccs@qq.com
 * @Project       : Zibll子比主题
 * @Description   : 一款极其优雅的Wordpress主题
 * @Read me       : 感谢您使用子比主题，主题源码有详细的注释，支持二次开发。
 * @Remind        : 使用盗版主题会存在各种未知风险。支持正版，从我做起！
 * @----本go页面有狐狸资源网（WWW.FOXCCS.COM）进行二次修改，禁止搬运，支持正版------。
 */

if (
    strlen($_SERVER['REQUEST_URI']) > 384 ||
    strpos($_SERVER['REQUEST_URI'], "eval(") ||
    strpos($_SERVER['REQUEST_URI'], "base64")
) {
    @header("HTTP/1.1 414 Request-URI Too Long");
    @header("Status: 414 Request-URI Too Long");
    @header("Connection: Close");
    @exit;
}
//通过QUERY_STRING取得完整的传入数据，然后取得url=之后的所有值，兼容性更好

@session_start();
$t_url = !empty($_SESSION['GOLINK']) ? $_SESSION['GOLINK'] : preg_replace('/^url=(.*)$/i', '$1', $_SERVER["QUERY_STRING"]);
//数据处理
if (!empty($t_url)) {
    //判断取值是否加密
    if ($t_url == base64_encode(base64_decode($t_url))) {
        $t_url = base64_decode($t_url);
    }
    //防止xss
    $t_url = htmlspecialchars($t_url);

    //对取值进行网址校验和判断
    preg_match('/^(http|https|thunder|qqdl|ed2k|Flashget|qbrowser):\/\//i', $t_url, $matches);
    $wiiui_title = get_bloginfo('name');
    $title = $wiiui_title . ' - 安全中心';
    if ($matches) {
        $url   = $t_url;
        // $title = '页面加载中,请稍候...';
    } else {
        preg_match('/\./i', $t_url, $matche);
        if ($matche) {
            $url   = 'http://' . $t_url;
            // $title = '页面加载中,请稍候...';
        } else {
            $url   = 'http://' . $_SERVER['HTTP_HOST'];
            $title = '参数错误，正在返回首页...';
        }
    }
} else {
    $title = '参数缺失，正在返回首页...';
    $url   = 'http://' . $_SERVER['HTTP_HOST'];
}

$url = str_replace('&', '&', $url);
?>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="robots" content="noindex, nofollow" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <?php echo "<link rel='apple-touch-icon-precomposed icon' href='" . _pz('iconpng') . "' type='image/x-icon'/>"; ?>
    <noscript>
        <meta http-equiv="refresh" content="1;url='<?php echo $url; ?>';">
    </noscript>
    <script>
        function link_jump() {
            var MyHOST = new RegExp(window.location.host);
            if (!MyHOST.test(document.referrer)) {
                location.href = "/" + MyHOST;
            }
            location.href = "<?php echo $url; ?>"; // 替换为你的目标URL
        }

        function startCountdown(duration, display) {
            var timer = duration, seconds;
            setInterval(function () {
                seconds = parseInt(timer % 60, 10);

                display.textContent = seconds;

                if (--timer < 0) {
                    timer = duration;
                    link_jump();
                }
            }, 1000);
        }

        window.onload = function () {
            var timeLeft = 5; // 倒计时时间（秒）
            var countdownDisplay = document.getElementById('countdown');
            startCountdown(timeLeft, countdownDisplay);
        };

        // 延时50S关闭跳转页面，用于文件下载后不会关闭跳转页的问题
        setTimeout(function() {
            window.opener = null;
            window.close();
        }, 50000);
    </script>
    <link rel="stylesheet" id="_fontawesome-css" href="//cdn.staticfile.org/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css" media="all">
    <title>
        <?php echo $title; ?>
    </title>
    <style>
        body,html{padding:0;margin:0}
        body{background:#f5f6f7;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif}
        a{cursor:default;text-decoration:none;word-wrap:break-word;word-break:break-all}
        .wiiuii-go-main{display:flex;width:100%;height:100%;justify-content:center;align-items:center}
        .wiiuii-go-container{position: relative;max-width:28em;height:auto;display:inline-block;background:#fff;margin:10px;padding:1.5em;border-radius:5px;box-shadow:0 0 10px rgba(116,116,116,.1)}
        .wiiuii-go-content a{color:#036af4}
        .wiiuii-go-content a:hover{color:#e91e63}
        .wiiuii-go-logo{text-align:center;width:auto;height:65px;margin-bottom:10px}
        .wiiuii-go-logo img{max-width:100%;height:100%}
        .wiiuii-go-msg{cursor:default;text-align:center;padding:10px 5px;font-weight:700;color:rgba(255, 0, 0, 0.85);background:rgba(255, 0, 0, 0.1);border-radius:5px}
        .wiiuii-go-button-item{text-align:right}
        .wiiuii-go-button{display:inline-block;border-radius:99px;padding:10px 15px;background:rgba(116,116,116,.1);transition:all .5s}
        .wiiuii-go-button a{font-weight:700;font-size:14px;color:#333}
        .wiiuii-go-button:hover{color:#000;background:rgba(116,116,116,.2)}
        .wiiuii-goid-item{position:absolute;top:10px;left:10px;border-radius:4px;overflow:hidden;background:#ffd07c}
        .wiiuii-goid-title{padding:0 4px;background:#ffa400}
        .wiiuii-goid-text{padding-right:5px}
        .wiiuii-go-container hr{border: 0;height: 0.05em;background: #eee;}
    </style>
</head>

<body>
    <div class="wiiuii-go-main">
        <div class="wiiuii-go-container">
            <div class="wiiuii-goid-item">
                <b class="wiiuii-goid-title">GID</b>
                <span class="wiiuii-goid-text">LINK<?php echo hexdec($url); ?></span>
            </div>
            <br />
            <div class="wiiuii-go-logo">
                <?php echo zib_get_adaptive_theme_img(_pz('logo_src'), _pz('logo_src_dark')); ?>
            </div>
            <div class="wiiuii-go-content">
                <div class="wiiuii-go-msg">
                    <span><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> 您即将离开<?php echo $wiiui_title; ?>，请注意您的账号和财产安全。</span>
                </div>
                <p>访问链接：<a onclick="location.replace('<?php echo $url; ?>')" title="<?php echo $url; ?>"><?php echo $url; ?></a></p>
            </div>
            <hr>
            <div class="wiiuii-go-button-item">
                <div class="wiiuii-go-button">
                    <a onclick="location.replace('//<?php echo $_SERVER['HTTP_HOST']; ?>')">返回首页</a>
                </div>
                <div class="wiiuii-go-button">
                    <a onclick="location.replace('<?php echo $url; ?>')">继续访问 <span style="font-weight: bold; color: red;" id="countdown"></span>秒</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>