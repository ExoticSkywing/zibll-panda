<?php
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
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="robots" content="noindex, nofollow" />
    <title><?php echo $title; ?></title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover" />
  <meta http-equiv="Cache-Control" content="no-transform" />
  <meta http-equiv="Cache-Control" content="no-siteapp" />
  <meta name="renderer" content="webkit"/>
  <meta name="force-rendering" content="webkit"/>
  <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1"/>
    <link rel="shortcut icon" type="image/ico" href="/favicon.ico">
    <script>
  function link_jump()
  {
    //禁止其他网站使用我们的跳转页面
    var MyHOST = new RegExp("<?php echo $_SERVER['HTTP_HOST']; ?>");
    if (!MyHOST.test(document.referrer)) {
       location.href="https://" + MyHOST;
    }
    location.href="<?php echo $url; ?>";
  }
    //延时1S跳转，可自行修改延时时间
  //setTimeout(link_jump, 1500);
  //延时50S关闭跳转页面，用于文件下载后不会关闭跳转页的问题
  setTimeout(function(){window.opener=null;window.close();}, 50000);
  </script>
<style>
      *,:after,:before{box-sizing:border-box}body.reader-black-font,body.reader-black-font .history-mode .view-area,body.reader-black-font .history-mode .view-area pre,body.reader-black-font .main .kalamu-area,body.reader-black-font .main .markdown .text,body.reader-black-font input,body.reader-black-font select,body.reader-black-font textarea{font-family:-apple-system,SF UI Text,Arial,PingFang SC,Hiragino Sans GB,Microsoft YaHei,WenQuanYi Micro Hei,sans-serif}body{background:#f6f7f8}.ext-link__wrapper{position:absolute;width:620px;padding:40px 0;border-radius:6px;text-align:center;top:118px;left:50%;-webkit-transform:translateX(-50%);-ms-transform:translateX(-50%);transform:translateX(-50%);background-color:#fff;box-shadow:0 1px 3px rgba(27,95,160,.1);overflow:hidden}.title{font-size:22px;color:#2f2f2f}.sub-title{font-size:16px;color:#888;margin-top:8px}.link-bd{display:-webkit-box;display:-webkit-flex;display:-ms-flexbox;display:flex;-webkit-box-align:center;-webkit-align-items:center;-ms-flex-align:center;align-items:center;width:460px;margin:12px auto 0;padding:10px;border-radius:4px;background:#ebf6ff;border:1px solid #dceaf5;zoom:1}.link-bd:after,.link-bd:before{content:" ";display:table}.link-bd .link-bd__icon{-webkit-flex-shrink:0;-ms-flex-negative:0;flex-shrink:0;display:flex;align-items:center;width:40px;justify-content:center;height:40px;line-height:40px;font-size:20px;background:#bcc6d8;text-align:center;border-radius:2px}.link-btn{text-align:center;font-size:0;margin-top:24px}.link-bd .link-bd__text{font-size:14px;color:#006cbe;margin-left:10px;overflow:hidden;-o-text-overflow:ellipsis;text-overflow:ellipsis;white-space:nowrap}.link-btn__text{display:inline-block;width:144px;height:44px;line-height:43px;border-radius:22px;font-size:14px;color:#006cbe;border:1px solid #006cbe;cursor:pointer;text-decoration:none}.link-btn__text:hover{color:#fff;background:#006cbe}
.alert-footer {
  margin: 0 auto;
  height: 90px;
  width: 130px;
  padding-top: 30px;
}
.alert-footer-icon {
  float: left;
  margin-top: 10px;
  margin-right: 6px;
}
.alert-footer-text {
  float: left;
  border-left: 2px solid #EEE;
  padding: 3px 0 0 5px;
  height: 60px;
  color: #0B85CC;
  font-size: 12px;
  text-align: left;
  
}
.alert-footer-text p {
  color: #7A7A7A;
  font-size: 22px;
  line-height: 18px;
  margin-top: 0px;
}
</style>
</head>
<body>    
<div class="ext-link__wrapper">
        <img src="<?php echo panda_pz('static_panda');?>/assets/img/share_topbar.png" width="200" style="margin-bottom: 30px;">
        <div class="title">您即将从<?php bloginfo('name'); ?>转到外部网站</div>
        <div class="sub-title">跳转网站安全性未知，是否继续</div>
        <div class="link-bd">
            <div class="link-bd__icon"><svg t="1585116627498" class="icon" viewBox="0 0 1024 1024" version="1.1"
                    xmlns="http://www.w3.org/2000/svg" p-id="2855" width="32" height="32">
                    <path
                        d="M580.906667 682.496a8.96 8.96 0 0 0-12.501334 0l-129.109333 129.152c-59.818667 59.818667-160.682667 66.133333-226.688 0-66.133333-66.133333-59.733333-166.912 0-226.688l129.109333-129.152a8.917333 8.917333 0 0 0 0-12.544L297.514667 399.061333a8.917333 8.917333 0 0 0-12.544 0l-129.152 129.066667a240.256 240.256 0 0 0 0 340.053333 240.213333 240.213333 0 0 0 340.053333 0l129.066667-129.109333a8.917333 8.917333 0 0 0 0-12.586667l-43.989334-43.989333h-0.042666zM868.224 155.733333a240.554667 240.554667 0 0 1 0 340.138667l-129.109333 129.152a8.917333 8.917333 0 0 1-12.544 0l-44.202667-44.202667a8.96 8.96 0 0 1 0-12.629333l129.109333-129.066667c59.818667-59.818667 66.133333-160.597333 0-226.730666-66.005333-66.133333-166.869333-59.818667-226.688 0l-129.066666 129.194666a8.96 8.96 0 0 1-12.544 0L399.061333 297.514667a8.96 8.96 0 0 1 0-12.544l129.237334-129.152a240.213333 240.213333 0 0 1 339.925333 0v-0.042667z m-247.210667 201.045334l43.946667 43.989333a8.917333 8.917333 0 0 1 0 12.544l-251.562667 251.562667a8.917333 8.917333 0 0 1-12.544 0l-44.032-43.946667a8.917333 8.917333 0 0 1 0-12.544l251.690667-251.605333a8.96 8.96 0 0 1 12.544 0h-0.042667z"
                        fill="#006CBE" fill-opacity=".87" p-id="2856"></path>
                </svg></div>
            <div class="link-bd__text"><?php echo $url; ?></div>
        </div>
        <div class="link-btn">
            <a href="javascript:void(0);" onclick="javascript:window.location.href='<?php echo $url; ?>'" class="link-btn__text">继续前往</a>
      <a href="/" class="link-btn__text" style="margin-left:100px;">回到主页</a>
        </div>
        <div class="alert-footer">
        <svg width="46px" height="42px" class="alert-footer-icon">
          <circle fill-rule="evenodd" clip-rule="evenodd" fill="#7B7B7B" stroke="#DEDFE0" stroke-width="2" stroke-miterlimit="10" cx="21.917" cy="21.25" r="17"/>
          <path fill="#FFF" d="M22.907,27.83h-1.98l0.3-2.92c-0.37-0.22-0.61-0.63-0.61-1.1c0-0.71,0.58-1.29,1.3-1.29s1.3,0.58,1.3,1.29 c0,0.47-0.24,0.88-0.61,1.1L22.907,27.83z M18.327,17.51c0-1.98,1.61-3.59,3.59-3.59s3.59,1.61,3.59,3.59v2.59h-7.18V17.51z M27.687,20.1v-2.59c0-3.18-2.59-5.76-5.77-5.76s-5.76,2.58-5.76,5.76v2.59h-1.24v10.65h14V20.1H27.687z"/>
          <circle fill-rule="evenodd" clip-rule="evenodd" fill="#FEFEFE" cx="35.417" cy="10.75" r="6.5"/>
          <polygon fill="#7B7B7B" stroke="#7B7B7B" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="35.417,12.16 32.797,9.03 31.917,10.07 35.417,14.25 42.917,5.29 42.037,4.25 "/>
        </svg>
        <div class="alert-footer-text"><p>secure</p>安全加密 </div>
      </div>
    </div>
</body>
</html>