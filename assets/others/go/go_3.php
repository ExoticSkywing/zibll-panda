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
        setTimeout(link_jump, 6800);
        //延时50S关闭跳转页面，用于文件下载后不会关闭跳转页的问题
        setTimeout(function() {
            window.opener = null;
            window.close();
        }, 50000);
    </script>
    <title><?php echo $title; ?></title>
</head>

<body>
    <body>
      <div id="t-ov">
        <div class="motime">
          <div id="head-body"></div>
          <div id="head-topcover"></div>
          <div id="head-toplogo-bg"></div>
          <div id="head-toplogo"></div>
          <div id="head-toplogo-2"></div>
          <div id="head-bottom"></div>
          <div id="head-bottom-2"></div>
          <div id="head-sw"></div>
          <div id="head-sw-2"></div>
          <div id="head-eye"></div>
          <div id="head-eye-2"></div>
        </div>
      </div>
      <style>
          @import url("https://fonts.googleapis.com/css?family=Lato:300,400|Poppins:300,400,800&display=swap");
* {
  margin: 0;
  padding: 0;
}

body, html {
  overflow: hidden;
}

.container {
  width: 100%;
  height: 100vh;
  background: #232323;
  display: flex;
  justify-content: center;
  align-items: center;
}
.container .box {
  width: 250px;
  height: 250px;
  position: relative;
  display: flex;
  justify-content: center;
  flex-direction: column;
}
.container .box .title {
  width: 100%;
  position: relative;
  display: flex;
  align-items: center;
  height: 50px;
}
.container .box .title .block {
  width: 0%;
  height: inherit;
  background: #ffb510;
  position: absolute;
  animation: mainBlock 2s cubic-bezier(0.74, 0.06, 0.4, 0.92) forwards;
  display: flex;
}
.container .box .title h1 {
  font-family: "Poppins";
  color: #fff;
  font-size: 32px;
  -webkit-animation: mainFadeIn 2s forwards;
  -o-animation: mainFadeIn 2s forwards;
  animation: mainFadeIn 2s forwards;
  animation-delay: 1.6s;
  opacity: 0;
  display: flex;
  align-items: baseline;
  position: relative;
}
.container .box .title h1 span {
  width: 0px;
  height: 0px;
  -webkit-border-radius: 50%;
  -moz-border-radius: 50%;
  border-radius: 50%;
  background: #ffb510;
  -webkit-animation: load 0.6s cubic-bezier(0.74, 0.06, 0.4, 0.92) forwards;
  animation: popIn 0.8s cubic-bezier(0.74, 0.06, 0.4, 0.92) forwards;
  animation-delay: 2s;
  margin-left: 5px;
  margin-top: -10px;
  position: absolute;
  bottom: 13px;
  right: -12px;
}
.container .box .role {
  width: 100%;
  position: relative;
  display: flex;
  align-items: center;
  height: 30px;
  margin-top: -10px;
}
.container .box .role .block {
  width: 0%;
  height: inherit;
  background: #e91e63;
  position: absolute;
  animation: secBlock 2s cubic-bezier(0.74, 0.06, 0.4, 0.92) forwards;
  animation-delay: 2s;
  display: flex;
}
.container .box .role p {
  animation: secFadeIn 2s forwards;
  animation-delay: 3.2s;
  opacity: 0;
  font-weight: 400;
  font-family: "Lato";
  color: #ffffff;
  font-size: 12px;
  text-transform: uppercase;
  letter-spacing: 5px;
}

@keyframes mainBlock {
  0% {
    width: 0%;
    left: 0;
  }
  50% {
    width: 100%;
    left: 0;
  }
  100% {
    width: 0;
    left: 100%;
  }
}
@keyframes secBlock {
  0% {
    width: 0%;
    left: 0;
  }
  50% {
    width: 100%;
    left: 0;
  }
  100% {
    width: 0;
    left: 100%;
  }
}
@keyframes mainFadeIn {
  0% {
    opacity: 0;
  }
  100% {
    opacity: 1;
  }
}
@keyframes popIn {
  0% {
    width: 0px;
    height: 0px;
    background: #e9d856;
    border: 0px solid #ddd;
    opacity: 0;
  }
  50% {
    width: 10px;
    height: 10px;
    background: #e9d856;
    opacity: 1;
    bottom: 45px;
  }
  65% {
    width: 7px;
    height: 7px;
    bottom: 0px;
    width: 15px;
  }
  80% {
    width: 10px;
    height: 10px;
    bottom: 20px;
  }
  100% {
    width: 7px;
    height: 7px;
    background: #e9d856;
    border: 0px solid #222;
    bottom: 13px;
  }
}
@keyframes secFadeIn {
  0% {
    opacity: 0;
  }
  100% {
    opacity: 0.5;
  }
}
footer {
  width: 350px;
  height: 80px;
  background: #ffb510;
  position: absolute;
  right: 0;
  bottom: -80px;
  display: flex;
  justify-content: center;
  align-items: center;
  animation: top 0.8s forwards;
  animation-delay: 4s;
}
footer span {
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 12px;
  color: #232323;
  font-family: "Poppins";
}
footer span i {
  margin-right: 25px;
  font-size: 22px;
  color: #232323;
  animation: icon 2s forwards;
  animation-delay: 4s;
  opacity: 0;
}

@keyframes top {
  0% {
    opacity: 0;
    bottom: -80px;
  }
  100% {
    opacity: 1;
    bottom: 0px;
  }
}
@keyframes icon {
  0% {
    opacity: 0;
    transform: scale(0);
  }
  50% {
    opacity: 1;
    transform: scale(1.3) rotate(-2deg);
  }
  100% {
    opacity: 1;
    bottom: 0px;
  }
}
      </style>
  </head>

<body>
<div class="container">
<div class="box">
<div class="title">
<span class="block"></span>
<h1><?php bloginfo('name'); ?><span></span></h1>
</div>
<div class="role">
<div class="block"></div>
<p>正在跳转中，请稍后...</p> 
</div>
</div>
</div>
</body>


</html>