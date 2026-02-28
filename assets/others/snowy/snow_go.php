<?php
/*
 * @Author        : 李初一
 * @Url           : zbtool.cn
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
    $t_url = htmlspecialchars($t_url, ENT_QUOTES, "UTF-8");
    $t_url = str_replace(array("'", '"'), array("&#39;", "&#34;"), $t_url);
    $t_url = str_replace(array("\r", "\n"), array("&#13;", "&#10;"), $t_url);
    $t_url = str_replace(array("\t"), array("&#9;"), $t_url);
    $t_url = str_replace(array("\x0B"), array("&#11;"), $t_url);
    $t_url = str_replace(array("\x0C"), array("&#12;"), $t_url);
    $t_url = str_replace(array("\x0D"), array("&#13;"), $t_url);

    //对取值进行网址校验和判断
    preg_match('/^(http|https|thunder|qqdl|ed2k|Flashget|qbrowser):\/\//i', $t_url, $matches);
    if ($matches) {
        $url   = $t_url;
        $title = '页面加载中,请稍候...';
    } else {
        preg_match('/\./i', $t_url, $matche);
        if ($matche) {
            $url   = 'http://' . $t_url;
            $title = '页面加载中,请稍候...';
        } else {
            $url   = 'http://' . $_SERVER['HTTP_HOST'];
            $title = '参数错误，正在返回首页...';
        }
    }
} else {
    $title = '参数缺失，正在返回首页...';
    $url   = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];
}

//禁止其它网站跳转此页面
$host    = zib_get_url_top_host($_SERVER['HTTP_HOST']);
$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
if (!empty($referer) && !preg_match('/' . preg_quote($host, '/') . '/i', $referer)) {
    $url   = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];
    $title = '非法请求，正在返回首页...';
}

$url = str_replace(['&amp;amp;', '&amp;'], '&', $url);
?>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="robots" content="noindex, nofollow" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <?php zib_head_favicon();?>
    <noscript>
        <meta http-equiv="refresh" content="1;url='<?php echo $url; ?>';">
    </noscript>
    <title><?php echo $title; ?></title>
    <style type="text/css">
body {
  margin: 0;
}
.banner {
  width: 100vw;
  height: 100vh;
  position: relative;
  display: flex;
  justify-content: center;
  align-items: center;
  background: rgb(226, 24, 58);
  background: linear-gradient(
    to bottom,
    rgba(226, 24, 58, 1) 0%,
    rgba(199, 0, 23, 1) 65%,
    rgba(199, 0, 23, 1) 100%
  );
}
.banner_content {
  display: flex;
  position: relative;
  z-index: 1;
  flex-direction: column;
  text-align: center;
}
span {
  font-size: 2.2rem;
  font-weight: bold;
  color: #fff;
  text-shadow: 0px 4px 12px #000000ba;
}
h1 {
  margin: 0;
  font-size: 3.5rem;
  color: #fff;
  text-shadow: 0px 4px 12px #000000ba;
}
#canvas {
  position: absolute;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
}
    </style>
</head>
<body>
<section class="banner">
  <canvas id="canvas"> </canvas>

  <div class="banner_content"> 
    <span>🎄</span> 
    <span>Merry</span>
    <h1>Christmas</h1>
  </div>
</section>

<script>
const SNOW_COUNT = 300;

function startAnimation() {
  const CANVAS_WIDTH = window.innerWidth;
  const CANVAS_HEIGHT = window.innerHeight;
  const MIN = 0;
  const MAX = CANVAS_WIDTH;

  const canvas = document.getElementById("canvas");
  const ctx = canvas.getContext("2d");

  canvas.width = CANVAS_WIDTH;
  canvas.height = CANVAS_HEIGHT;

  function clamp(number, min = MIN, max = MAX) {
    return Math.max(min, Math.min(number, max));
  }

  function random(factor = 1) {
    return Math.random() * factor;
  }

  function degreeToRadian(deg) {
    return deg * (Math.PI / 180);
  }

  // All the properties for Circle
  class Circle {
    radius = 0;
    x = 0;
    y = 0;
    vx = 0;
    vy = 0;

    constructor(ctx) {
      this.ctx = ctx;
      this.reset();
    }

    draw() {
      this.ctx.beginPath();
      this.ctx.fillStyle = `rgba(255,255,255,${0.8})`;
      this.ctx.arc(this.x, this.y, this.radius, 0, 2 * Math.PI);
      this.ctx.fill();
      this.ctx.closePath();
    }

    reset() {
      this.radius = random(2.5);
      this.x = random(CANVAS_WIDTH);
      this.y = this.y ? 0 : random(CANVAS_HEIGHT);
      this.vx = clamp((Math.random() - 0.5) * 0.4, -0.4, 0.4);
      this.vy = clamp(random(1.5), 0.1, 0.8) * this.radius * 0.5;
    }
  }

  // Array for storing all the generated circles
  let circles = [];

  // Generate circles
  for (let i = 0; i < SNOW_COUNT; i++) {
    circles.push(new Circle(ctx));
  }

  // Clear canvas
  function clearCanvas() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
  }

  // start and end cordinates of canvas
  let canvasOffset = {
    x0: ctx.canvas.offsetLeft,
    y0: ctx.canvas.offsetTop,
    x1: ctx.canvas.offsetLeft + ctx.canvas.width,
    y1: ctx.canvas.offsetTop + ctx.canvas.height
  };

  function animate() {
    clearCanvas();

    circles.forEach((e) => {
      // reset the circle if it collides on border
      if (
        e.x <= canvasOffset.x0 ||
        e.x >= canvasOffset.x1 ||
        e.y <= canvasOffset.y0 ||
        e.y >= canvasOffset.y1
      ) {
        e.reset();
      }

      // Drawing path using polar cordinates
      e.x = e.x + e.vx;
      e.y = e.y + e.vy;
      e.draw();
    });

    requestAnimationFrame(animate);
  }

  animate();
}

startAnimation();

window.addEventListener("resize", startAnimation);
</script>

    <script>
        function link_jump() {
            location.href = "<?php echo ($url); ?>";
        }

        //延时1S跳转，可自行修改延时时间
        setTimeout(link_jump, 1500);
        //延时15S关闭跳转页面，用于文件下载后不会关闭跳转页的问题
        setTimeout(function() {
            window.opener = null;
            window.close();
        }, 15000);
    </script>
</body>
</html>