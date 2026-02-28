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
    
<head>
  <meta charset="UTF-8">
  <title>CSS "Loading" Animation</title>

  <style>
    :root {
      --tf: linear;
      --effect: hover 1s var(--tf) infinite;
    }

    * {
      margin: 0;
    }

    body {
      display: flex;
      width: 100vw;
      height: 100vh;
      background: black;
      align-items: center;
      justify-content: center;
    }

    div {
      text-align: center;
    }

    p {
      display: inline-block;
      text-transform: uppercase;
      text-align: center;
      font-size: 4em;
      font-family: arial;
      font-weight: 600;
      transform: scale(.5);
      color: #121212;
      -webkit-text-stroke: 2px gray;
    }

    p:nth-child(1) {
      animation: var(--effect);
    }

    p:nth-child(2) {
      animation: var(--effect) .125s;
    }

    p:nth-child(3) {
      animation: var(--effect) .25s;
    }

    p:nth-child(4) {
      animation: var(--effect) .375s;
    }

    p:nth-child(5) {
      animation: var(--effect) .5s;
    }

    p:nth-child(6) {
      animation: var(--effect) .675s;
    }

    p:nth-child(7) {
      animation: var(--effect) .75s;
    }

    @keyframes hover {
      0% {
        transform: scale(.5);
        color: #121212;
        -webkit-text-stroke: 2px gray;
      }

      20% {
        transform: scale(1);
        color: pink;
        -webkit-text-stroke: 3px red;
        filter: drop-shadow(0 0 1px black)drop-shadow(0 0 1px black)drop-shadow(0 0 3px red)drop-shadow(0 0 5px red)hue-rotate(10turn);
      }

      50% {
        transform: scale(.5);
        color: #121212;
        -webkit-text-stroke: 2px gray;
      }


    }
  </style>

</head>

<body>

  <div>
    <p><?php bloginfo('name'); ?></p>
  </div>

</body>

    
</body>

</html>