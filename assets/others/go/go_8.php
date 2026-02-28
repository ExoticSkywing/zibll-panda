<?php
if (
    strlen($_SERVER['REQUEST_URI']) > 384 ||
    strpos($_SERVER['REQUEST_URI'], "eval(") !== false ||
    strpos($_SERVER['REQUEST_URI'], "base64") !== false
) {
    @header("HTTP/1.1 414 Request-URI Too Long");
    @header("Status: 414 Request-URI Too Long");
    @header("Connection: Close");
    @exit;
}

@session_start();

// 处理URL参数
$t_url = !empty($_SESSION['GOLINK']) ? $_SESSION['GOLINK'] : preg_replace('/^url=(.*)$/i', '$1', $_SERVER["QUERY_STRING"]);
if (!empty($t_url)) {
    if ($t_url === base64_encode(base64_decode($t_url))) {
        $t_url = base64_decode($t_url);
    }
    $t_url = htmlspecialchars($t_url);
    
    preg_match('/^(http|https|thunder|qqdl|ed2k|Flashget|qbrowser):\/\//i', $t_url, $matches);
    $site_name = get_bloginfo('name');
    $page_title = $site_name . ' - 网站安全验证中心';
    
    if ($matches) {
        $url = $t_url;
    } else {
        preg_match('/\./i', $t_url, $matche);
        if ($matche) {
            $url = 'http://' . $t_url;
        } else {
            $url = 'http://' . $_SERVER['HTTP_HOST'];
            $page_title = '参数错误 - ' . $site_name;
        }
    }
} else {
    $page_title = '参数缺失 - ' . $site_name;
    $url = 'http://' . $_SERVER['HTTP_HOST'];
}

$url = htmlspecialchars($url);
$domain = parse_url($url, PHP_URL_HOST) ?: $url;


$normalizedUrl = $url;
if (!preg_match('/^https?:\/\//i', $normalizedUrl)) {
    $normalizedUrl = 'http://' . $normalizedUrl;
}
$encodedUrl = rawurlencode($normalizedUrl);
$snapshotWidth = 1024;
$snapshotHeight = 768;
$snapshotQuality = 80;
$mshotsUrl = "https://s0.wp.com/mshots/v1/{$encodedUrl}?w={$snapshotWidth}&h={$snapshotHeight}&quality={$snapshotQuality}";
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="robots" content="noindex, nofollow">
    <link rel="shortcut icon" href="https://blgo.ax24.cn/wp-content/uploads/2025/08/favicon.ico" type="image/x-icon">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #165DFF;
            --primary-light: #E8F3FF;
            --primary-dark: #0E42CC;
            --danger: #F53F3F;
            --danger-light: #FFECE8;
            --warning: #FF7D00;
            --warning-light: #FFF7E8;
            --success: #00B42A;
            --success-light: #E8FFEA;
            --gray-50: #F2F3F5;
            --gray-100: #E5E6EB;
            --gray-200: #C9CDD4;
            --gray-300: #86909C;
            --gray-400: #4E5969;
            --gray-500: #1D2129;
            --text: var(--gray-500);
            --text-light: var(--gray-400);
            --border-radius: 12px;
            --border-radius-sm: 6px;
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            --shadow-hover: 0 8px 30px rgba(0, 0, 0, 0.12);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Inter", "Microsoft YaHei", "Segoe UI", Roboto, sans-serif;
        }
        
        body {
            background-color: #F7F8FA;
            color: var(--text);
            line-height: 1.5;
            padding: 30px 0;
            font-size: 15px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 16px;
        }
        
        .card {
            background-color: #fff;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            margin-bottom: 24px;
            transition: var(--transition);
        }
        
        .card:hover {
            box-shadow: var(--shadow-hover);
        }
        
        .card-header {
                  
            background: linear-gradient(135deg, rgba(22, 93, 255, 0.9), rgba(22, 93, 255, 0.7));
            color: #fff;
            padding: 20px 24px;
            font-size: 20px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        
        .card-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.15) 0%, rgba(255, 255, 255, 0) 100%);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        
        .card-header .content {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
        }
        
        .card-header .contact-buttons {
            position: relative;
            z-index: 1;
            display: flex;
            gap: 12px;
        }
        
        .contact-btn {
            background-color: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 14px;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none; 
        }
        
        .contact-btn:hover {
            background-color: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        .card-header .icon {
            font-size: 24px;
            margin-right: 12px;
        }
        
        .card-body {
            padding: 24px;
        }
        
        .main-content {
            display: flex;
            gap: 24px;
            margin-bottom: 24px;
        }
        
        .left-column {
            flex: 1;
        }
        
        .right-column {
            flex: 1.2;
        }
        
        .warning-notice {
            background-color: var(--warning-light);
            border-left: 4px solid var(--warning);
            padding: 16px 20px;
            margin-bottom: 24px;
            border-radius: 0 var(--border-radius-sm) var(--border-radius-sm) 0;
            display: flex;
            align-items: center;
            transition: var(--transition);
        }
        
        .warning-notice:hover {
            transform: translateX(2px);
        }
        
        .warning-notice i {
            color: var(--warning);
            font-size: 22px;
            margin-right: 12px;
            flex-shrink: 0;
        }
        
        .url-display {
            background-color: var(--gray-50);
            border: 1px solid var(--gray-100);
            border-radius: var(--border-radius-sm);
            padding: 16px 20px;
            margin-bottom: 24px;
            word-break: break-all;
            position: relative;
            transition: var(--transition);
        }
        
        .url-display:hover {
            border-color: var(--primary-light);
            background-color: var(--primary-light);
        }
        
        .url-display::before {
            content: "目标网址";
            position: absolute;
            top: -10px;
            left: 16px;
            background-color: #fff;
            padding: 0 8px;
            font-size: 13px;
            color: var(--gray-400);
            font-weight: 500;
        }
        
        .info-section {
            margin-bottom: 32px;
        }
        
        .info-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 16px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--gray-100);
            display: flex;
            align-items: center;
            color: var(--gray-500);
        }
        
        .info-title i {
            color: var(--primary);
            margin-right: 10px;
            font-size: 20px;
        }
        
        .snapshot-container {
            border: 1px solid var(--gray-100);
            border-radius: var(--border-radius);
            overflow: hidden;
            background-color: #fff;
            margin-bottom: 24px;
            transition: var(--transition);
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        
        .snapshot-container:hover {
            border-color: var(--primary-light);
            box-shadow: 0 2px 12px rgba(22, 93, 255, 0.08);
        }
        
        .snapshot-header {
            background-color: var(--gray-50);
            padding: 12px 16px;
            border-bottom: 1px solid var(--gray-100);
            display: flex;
            align-items: center;
            font-size: 14px;
        }
        
        .browser-dots {
            display: flex;
            gap: 6px;
            margin-right: 16px;
        }
        
        .dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            transition: var(--transition);
        }
        
        .dot-red {
            background-color: #FF5A5A;
        }
        
        .dot-red:hover {
            transform: scale(1.2);
        }
        
        .dot-yellow {
            background-color: #FFC850;
        }
        
        .dot-yellow:hover {
            transform: scale(1.2);
        }
        
        .dot-green {
            background-color: #56D364;
        }
        
        .dot-green:hover {
            transform: scale(1.2);
        }
        
        .snapshot-url {
            color: var(--gray-400);
            flex: 1;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            font-family: "Consolas", monospace;
        }
        
        .snapshot-img-container {
            width: 100%;
            overflow: hidden;
            position: relative;
            flex: 1;
            min-height: 400px;
            background-color: var(--gray-50);
        }
        
        .snapshot-loading {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: rgba(255, 255, 255, 0.8);
            z-index: 10;
            transition: opacity 0.3s ease;
        }
        
        .snapshot-loading i {
            font-size: 36px;
            color: var(--primary);
            animation: spin 1.5s linear infinite;
            position: relative;
        }
        
        .snapshot-loading i::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 120%;
            height: 120%;
            border-radius: 50%;
            border: 2px solid rgba(22, 93, 255, 0.2);
            transform: translate(-50%, -50%);
            animation: pulse 2s infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        @keyframes pulse {
            0% { transform: translate(-50%, -50%) scale(0.8); opacity: 1; }
            100% { transform: translate(-50%, -50%) scale(1.5); opacity: 0; }
        }
        
        .snapshot-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.6s ease, opacity 0.4s ease;
            opacity: 0;
        }
        
        .snapshot-img.loaded {
            transform: scale(1);
            opacity: 1;
        }
        
        .snapshot-img:hover {
            transform: scale(1.03);
        }
        
        .snapshot-placeholder {
            padding: 80px 20px;
            text-align: center;
            color: var(--gray-400);
        }
        
        .snapshot-refresh {
            margin-top: 12px;
            color: var(--primary);
            background: none;
            border: 1px solid var(--primary);
            padding: 6px 18px;
            border-radius: 20px;
            font-size: 14px;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
        }
        
        .snapshot-refresh i {
            transition: transform 0.5s ease;
        }
        
        .snapshot-refresh:hover {
            background-color: var(--primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(22, 93, 255, 0.25);
        }
        
        .snapshot-refresh:hover i {
            transform: rotate(180deg);
        }
        
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 24px;
            margin: 24px 0;
            flex-wrap: wrap;
        }
        
        .btn {
            padding: 14px 48px;
            border-radius: var(--border-radius-sm);
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            position: relative;
            overflow: hidden;
            text-decoration: none;
        }
        
        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: 0.5s;
        }
        
        .btn:hover::before {
            left: 100%;
        }
        
        .btn-cancel {
            background-color: #fff;
            color: var(--gray-500);
            border: 1px solid var(--gray-100);
        }
        
        .btn-cancel:hover {
            background-color: var(--gray-50);
            border-color: var(--gray-200);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
        
        .btn-continue {
            background-color: var(--primary);
            color: #fff;
        }
        
        .btn-continue:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(22, 93, 255, 0.3);
        }
        
        .safety-tips {
            background-color: var(--danger-light);
            border-radius: var(--border-radius-sm);
            padding: 16px 20px;
            margin: 24px 0;
            font-size: 14px;
            color: var(--danger);
            border-left: 4px solid var(--danger);
            transition: var(--transition);
        }
        
        .safety-tips:hover {
            transform: translateX(2px);
        }
        
        .safety-tips strong {
            font-weight: 600;
        }
        
        
        .ad-section {
            margin-top: 30px;
            border-radius: var(--border-radius-sm);
            overflow: hidden;
        }
        
        .ad-image-container {
            margin-bottom: 12px;
            border-radius: var(--border-radius-sm);
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transition: var(--transition);
        }
        
        .ad-image-container:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
            transform: translateY(-2px);
        }
        
        .ad-image {
            width: 100%;
            height: auto;
            display: block;
            border: none;
        }
        
        .ad-text-container {
            display: flex;
            gap: 12px;
        }
        
        .ad-text {
            flex: 1;
            background-color: var(--gray-50);
            border: 1px solid var(--gray-100);
            border-radius: var(--border-radius-sm);
            padding: 12px 16px;
            text-align: center;
            color: var(--primary);
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
        }
        
        .ad-text:hover {
            background-color: var(--primary-light);
            border-color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(22, 93, 255, 0.1);
        }
        
        .footer-info {
            text-align: center;
            font-size: 14px;
            color: var(--gray-400);
            padding: 20px 0 10px;
            position: relative;
        }
        
        .footer-info::before {
            content: '';
            position: absolute;
            top: 0;
            left: 15%;
            width: 70%;
            height: 1px;
            background-color: var(--gray-100);
        }
        
        .footer-info p {
            margin-bottom: 8px;
        }
        
        @media (max-width: 992px) {
            .main-content {
                flex-direction: column;
            }
            
            .snapshot-img-container {
                min-height: 320px;
            }
        }
        
        @media (max-width: 768px) {
            .action-buttons {
                flex-direction: column;
                gap: 12px;
                padding: 0 16px;
            }
            
            .btn {
                width: 100%;
                padding: 14px 0;
            }
            
            .card-header {
                padding: 16px 20px;
                font-size: 18px;
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }
            
            .card-header .contact-buttons {
                width: 100%;
                justify-content: flex-start;
            }
            
            .card-body {
                padding: 20px;
            }
            
            .ad-text {
                padding: 10px 12px;
                font-size: 14px;
            }
        }
        
        @media (max-width: 480px) {
            body {
                padding: 20px 0;
            }
            
            .card-header {
                font-size: 16px;
            }
            
            .card-body {
                padding: 16px;
            }
            
            .warning-notice, .safety-tips {
                padding: 12px 16px;
            }
            
            .snapshot-img-container {
                min-height: 240px;
            }
            
            .contact-btn {
                padding: 5px 12px;
                font-size: 13px;
            }
            
            .ad-text-container {
                flex-direction: column;
                gap: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- 页面标题卡片 -->
        <div class="card">
            <div class="card-header">
                <div class="content">
                    <i class="fas fa-shield-alt icon"></i>
                    <?php bloginfo( 'name' ); ?>
                </div>
                <div class="contact-buttons">
                    <a href="<?php echo panda_pz('go_8_qq'); ?>" 
                       class="contact-btn" 
                       target="_blank" 
                       rel="noopener noreferrer">
                        <i class="fab fa-qq"></i> 联系站长
                    </a>
                    <a href="mailto:<?php echo panda_pz('go_8_email'); ?>" 
                       class="contact-btn">
                        <i class="fas fa-envelope"></i> 发送邮件
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="main-content">
                    <!-- 左侧列 - 提示信息 -->
                    <div class="left-column">
                        <div class="warning-notice">
                            <i class="fas fa-exclamation-circle"></i>
                            <div>您即将离开当前平台，访问第三方网站。请确认该网站的安全性后再进行访问。</div>
                        </div>
                        
                        <div class="url-display">
                            <?php echo $url; ?>
                        </div>
                        
                        <!-- 安全提示 -->
                        <div class="safety-tips">
                            <strong>安全提示：</strong>请勿在陌生网站输入银行卡密码、身份证号等敏感信息。如发现虚假网站或诈骗行为，请立即举报。
                        </div>
                        
                        <!-- 操作按钮 -->
                        <div class="action-buttons">
                            <button class="btn btn-cancel" id="cancelBtn">
                                <i class="fas fa-arrow-left"></i> 返回上一页
                            </button>
                            <button class="btn btn-continue" id="continueBtn">
                                <i class="fas fa-external-link-alt"></i> 继续访问
                            </button>
                        </div>
                        
                        <!-- 广告位 -->
                        <div class="ad-section">
                            <!-- 第一行：图片广告 -->
                            <!-- <a href="这里修改为你需要跳转的网站链接" target="_blank" rel="noopener noreferrer" class="ad-image-container">
                                <img src="这里修改为你的图片地址" alt="广告图片" class="ad-image">
                            </a> -->
                        </div>
                    </div>
                    
                    <!-- 右侧列 - 屏幕快照 -->
                    <div class="right-column">
                        <div class="info-section">
                            <h3 class="info-title">
                                <i class="fas fa-desktop"></i> 网站快照预览
                            </h3>
                            <div class="snapshot-container">
                                <div class="snapshot-header">
                                    <div class="browser-dots">
                                        <div class="dot dot-red"></div>
                                        <div class="dot dot-yellow"></div>
                                        <div class="dot dot-green"></div>
                                    </div>
                                    <div class="snapshot-url"><?php echo $domain; ?></div>
                                </div>
                                <div class="snapshot-img-container">
                                    <div class="snapshot-loading" id="snapshotLoader">
                                        <i class="fas fa-spinner fa-spin"></i>
                                    </div>
                                    <img src="<?php echo $mshotsUrl; ?>" 
                                         alt="网页快照" 
                                         class="snapshot-img"
                                         loading="lazy"
                                         onload="this.classList.add('loaded'); document.getElementById('snapshotLoader').style.opacity='0'; setTimeout(() => document.getElementById('snapshotLoader').style.display='none', 300);"
                                         onerror="handleSnapshotError()">
                                </div>
                                <div style="text-align: center; padding: 12px;">
                                    <button class="snapshot-refresh" onclick="refreshSnapshot()">
                                        <i class="fas fa-sync-alt"></i> 刷新快照
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- 页脚信息 -->
        <div class="footer-info">
            <p>安全验证中心旨在保护用户上网安全，本验证结果仅供参考</p>
            <p>© 2025  <?php bloginfo( 'name' ); ?> 版权所有</p>
        </div>
    </div>

    <script>
        // 保存原始快照URL，用于刷新功能
        const originalSnapshotUrl = "<?php echo $mshotsUrl; ?>";
        
        // 取消访问按钮
        document.getElementById('cancelBtn').addEventListener('click', function() {
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> 返回中...';
            this.disabled = true;
            
            // 尝试返回上一页，如果不行则跳转到首页
            setTimeout(() => {
                if (history.length > 1) {
                    history.back();
                } else {
                    location.href = 'http://<?php echo $_SERVER['HTTP_HOST']; ?>';
                }
            }, 600);
        });
        
        // 继续访问按钮
        document.getElementById('continueBtn').addEventListener('click', function() {
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> 跳转中...';
            this.disabled = true;
            
            setTimeout(() => {
                location.replace('<?php echo $url; ?>');
            }, 800);
        });
        
        // 处理快照加载错误
        function handleSnapshotError() {
            const container = document.querySelector('.snapshot-img-container');
            container.innerHTML = `
                <div class="snapshot-placeholder">
                    <i class="fas fa-exclamation-circle" style="font-size: 36px; margin-bottom: 12px; color: var(--danger);"></i>
                    <p>网页快照加载失败</p>
                    <button class="snapshot-refresh" onclick="refreshSnapshot()">
                        <i class="fas fa-sync-alt"></i> 重试
                    </button>
                </div>
            `;
        }
        
        // 刷新快照功能
        function refreshSnapshot() {
            const container = document.querySelector('.snapshot-img-container');
            // 添加随机参数防止缓存
            const randomParam = Math.random().toString(36).substring(7);
            const newSnapshotUrl = originalSnapshotUrl + (originalSnapshotUrl.includes('?') ? '&' : '?') + 'rand=' + randomParam;
            
            container.innerHTML = `
                <div class="snapshot-loading" id="snapshotLoader">
                    <i class="fas fa-spinner fa-spin"></i>
                </div>
                <img src="${newSnapshotUrl}" 
                     alt="刷新后的网页快照" 
                     class="snapshot-img"
                     loading="lazy"
                     onload="this.classList.add('loaded'); document.getElementById('snapshotLoader').style.opacity='0'; setTimeout(() => document.getElementById('snapshotLoader').style.display='none', 300);"
                     onerror="handleSnapshotError()">
            `;
        }
        
        // 添加页面载入动画
        document.addEventListener('DOMContentLoaded', function() {
            const card = document.querySelector('.card');
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 100);
        });
    </script>
</body>
</html>