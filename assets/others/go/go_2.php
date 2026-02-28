<?php
/*
 * @Author        : 小鱼
 * @Url           : wiiui.cn
 * @Date          : 2022-08-08 13:18:36
 * @LastEditTime: 2022-08-08 17:54:39
 * @Email         : 33076460@qq.com
 * @Project       : 小鱼工具箱
 * @Description   : 基于子比主题开发的工具箱组件
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
        $t_url =  base64_decode($t_url);
    }
    //防止xss
    $t_url =  htmlspecialchars($t_url);

    //对取值进行网址校验和判断
    preg_match('/^(http|https|thunder|qqdl|ed2k|Flashget|qbrowser):\/\//i', $t_url, $matches);
    if ($matches) {
        $url = $t_url;
        $title = '页面加载中,请稍候...';
    } else {
        preg_match('/\./i', $t_url, $matche);
        if ($matche) {
            $url = 'http://' . $t_url;
            $title = '页面加载中,请稍候...';
        } else {
            $url = 'http://' . $_SERVER['HTTP_HOST'];
            $title = '参数错误，正在返回首页...';
        }
    }
} else {
    $title = '参数缺失，正在返回首页...';
    $url = 'http://' . $_SERVER['HTTP_HOST'];
}
?>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="robots" content="noindex, nofollow" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <noscript>
        <meta http-equiv="refresh" content="1;url='<?php echo $url; ?>';">
    </noscript>
    <script>
        function link_jump() {
            //禁止其他网站使用我们的跳转页面
            var MyHOST = new RegExp("<?php echo $_SERVER['HTTP_HOST']; ?>");
            if (!MyHOST.test(document.referrer)) {
                location.href = "http://" + MyHOST;
            }
            location.href = "<?php echo $url; ?>";
        }
        //延时1S跳转，可自行修改延时时间
        setTimeout(link_jump, 3000);
        //延时50S关闭跳转页面，用于文件下载后不会关闭跳转页的问题
        setTimeout(function() {
            window.opener = null;
            window.close();
        }, 50000);
    </script>
    <title><?php echo $title; ?></title>
</head>

<body>
 <style>
        body {
            margin: 0
        }

        body {
            height: 100%
        }

        #loading {
            -webkit-box-pack: center;
            justify-content: center;
            -webkit-box-align: center;
            align-items: center;
            display: -webkit-box;
            display: flex;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #fff
        }

        .io-black-mode #loading {
            background: #1b1d1f
        }
    </style>
</head>

<body class="io-grey-mode">
    <div id="loading">
        <style>
            .loader {
                position: absolute;
                top: 50%;
                margin-left: -50px;
                left: 50%;
                animation: speeder 0.4s linear infinite
            }

            .loader-text {
                position: absolute;
                text-transform: uppercase;
                left: 50%;
                top: 53%;
                margin-left: -20px
            }

            .loader>span {
                height: 5px;
                width: 35px;
                background: #000;
                position: absolute;
                top: -19px;
                left: 60px;
                border-radius: 2px 10px 1px 0
            }

            .base span {
                position: absolute;
                width: 0;
                height: 0;
                border-top: 6px solid transparent;
                border-right: 100px solid #000;
                border-bottom: 6px solid transparent
            }

            .base span:before {
                content: "";
                height: 22px;
                width: 22px;
                border-radius: 50%;
                background: #000;
                position: absolute;
                right: -110px;
                top: -16px
            }

            .base span:after {
                content: "";
                position: absolute;
                width: 0;
                height: 0;
                border-top: 0 solid transparent;
                border-right: 55px solid #000;
                border-bottom: 16px solid transparent;
                top: -16px;
                right: -98px
            }

            .face {
                position: absolute;
                height: 12px;
                width: 20px;
                background: #000;
                border-radius: 20px 20px 0 0;
                transform: rotate(-40deg);
                right: -125px;
                top: -15px
            }

            .face:after {
                content: "";
                height: 12px;
                width: 12px;
                background: #000;
                right: 4px;
                top: 7px;
                position: absolute;
                transform: rotate(40deg);
                transform-origin: 50% 50%;
                border-radius: 0 0 0 2px
            }

            .loader>span>span {
                width: 30px;
                height: 1px;
                background: #000;
                position: absolute;
                animation: fazer1 0.2s linear infinite
            }

            .loader>span>span:nth-child(2) {
                top: 3px;
                animation: fazer2 0.4s linear infinite
            }

            .loader>span>span:nth-child(3) {
                top: 1px;
                animation: fazer3 0.4s linear infinite;
                animation-delay: -1s
            }

            .loader>span>span:nth-child(4) {
                top: 4px;
                animation: fazer4 1s linear infinite;
                animation-delay: -1s
            }

            @keyframes fazer1 {
                0% {
                    left: 0
                }

                100% {
                    left: -80px;
                    opacity: 0
                }
            }

            @keyframes fazer2 {
                0% {
                    left: 0
                }

                100% {
                    left: -100px;
                    opacity: 0
                }
            }

            @keyframes fazer3 {
                0% {
                    left: 0
                }

                100% {
                    left: -50px;
                    opacity: 0
                }
            }

            @keyframes fazer4 {
                0% {
                    left: 0
                }

                100% {
                    left: -150px;
                    opacity: 0
                }
            }

            @keyframes speeder {
                0% {
                    transform: translate(2px, 1px) rotate(0deg)
                }

                10% {
                    transform: translate(-1px, -3px) rotate(-1deg)
                }

                20% {
                    transform: translate(-2px, 0px) rotate(1deg)
                }

                30% {
                    transform: translate(1px, 2px) rotate(0deg)
                }

                40% {
                    transform: translate(1px, -1px) rotate(1deg)
                }

                50% {
                    transform: translate(-1px, 3px) rotate(-1deg)
                }

                60% {
                    transform: translate(-1px, 1px) rotate(0deg)
                }

                70% {
                    transform: translate(3px, 1px) rotate(-1deg)
                }

                80% {
                    transform: translate(-2px, -1px) rotate(1deg)
                }

                90% {
                    transform: translate(2px, 1px) rotate(0deg)
                }

                100% {
                    transform: translate(1px, -2px) rotate(-1deg)
                }
            }

            .longfazers {
                position: absolute;
                width: 100%;
                height: 100%
            }

            .longfazers span {
                position: absolute;
                height: 2px;
                width: 20%;
                background: #000
            }

            .longfazers span:nth-child(1) {
                top: 20%;
                animation: lf 0.6s linear infinite;
                animation-delay: -5s
            }

            .longfazers span:nth-child(2) {
                top: 40%;
                animation: lf2 0.8s linear infinite;
                animation-delay: -1s
            }

            .longfazers span:nth-child(3) {
                top: 60%;
                animation: lf3 0.6s linear infinite
            }

            .longfazers span:nth-child(4) {
                top: 80%;
                animation: lf4 0.5s linear infinite;
                animation-delay: -3s
            }

            @keyframes lf {
                0% {
                    left: 200%
                }

                100% {
                    left: -200%;
                    opacity: 0
                }
            }

            @keyframes lf2 {
                0% {
                    left: 200%
                }

                100% {
                    left: -200%;
                    opacity: 0
                }
            }

            @keyframes lf3 {
                0% {
                    left: 200%
                }

                100% {
                    left: -100%;
                    opacity: 0
                }
            }

            @keyframes lf4 {
                0% {
                    left: 200%
                }

                100% {
                    left: -100%;
                    opacity: 0
                }
            }

            .io-black-mode .loader>span {
                background: #f1404b
            }

            .io-black-mode .base span {
                border-right-color: #f1404b
            }

            .io-black-mode .base span:before {
                background: #f1404b
            }

            .io-black-mode .base span:after {
                border-right-color: #f1404b
            }

            .io-black-mode .face {
                background: #f1404b
            }

            .io-black-mode .face:after {
                background: #f1404b
            }

            .io-black-mode .loader>span>span {
                background: #f1404b
            }

            .io-black-mode .longfazers span {
                background: #f1404b
            }
        </style>
        <div class='loader'>
            <span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </span>
            <div class='base'>
                <span></span>
                <div class='face'></div>
            </div>
        </div>
        <div class='longfazers'>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>
        <p class="loader-text">奔向新世界...</p>
    </div>
</body>
</body>


</html>