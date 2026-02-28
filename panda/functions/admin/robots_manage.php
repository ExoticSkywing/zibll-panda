<?php
/*
 * @Author: 苏晨
 * @Url: https://www.scbkw.com
 * @Date: 2025-01-13 13:39:50
 * @LastEditTime: 2025-01-13 14:52:11
 * @Email: 528609062@qq.com
 * @Project: 
 * @Description: 
 */


//Robots.txt管理页面内容
function panda_robots_manage_page() {
    // 确保只有管理员可以访问这个功能
    if ( !current_user_can('manage_options') ) {
        return;
    }

    // 检查是否是POST请求并且有数据提交
    if ( isset( $_POST['robots_txt_save'] ) && check_admin_referer('save_robots_txt', 'robots_txt_nonce') ) {
        $robots_content = sanitize_textarea_field( wp_unslash( $_POST['robots_txt_content'] ) );
        $file_path = ABSPATH . 'robots.txt';
        
        // 尝试保存robots.txt文件
        if ( file_put_contents($file_path, $robots_content) !== false ) {
            echo '<div id="message" class="updated"><p>Robots.txt 文件已成功更新。</p></div>';
        } else {
            echo '<div id="message" class="error"><p>无法保存 Robots.txt 文件，请检查服务器权限设置。</p></div>';
        }
    }

    // 获取现有的robots.txt文件内容，如果没有则不显示任何内容
    $file_path = ABSPATH . 'robots.txt';
    $robots_content = '';

    if ( file_exists($file_path) ) {
        $robots_content = file_get_contents($file_path);
    }

    ?>
    <div class="wrap">
        <h1>Robots规则管理</h1>
        <p>请在此处编辑您的 <code>robots.txt</code> 文件。此文件用于告知搜索引擎哪些页面不应被抓取。</p>
        
        <form method="post" action="" style="max-width: 800px; margin-top: 20px;">
            <?php wp_nonce_field('save_robots_txt', 'robots_txt_nonce'); ?>
            <div>
                <div>
                    <p><strong>基本规则示例：</strong></p>
                    <ul>
                        <li><strong>允许所有抓取:</strong><code>User-agent: *</code>、<code>Disallow:</code></li>
                        <li><strong>禁止所有抓取:</strong><code>User-agent: *</code>、<code>Disallow: /</code></li>
                        <li><strong>禁止特定路径:</strong><code>User-agent: *</code>、<code>Disallow: /admin/</code></li>
                        <li><strong>指定特定蜘蛛行为:</strong><code>User-agent: Googlebot</code>、<code>Allow: /</code>、<code>Disallow: /private/</code></li>
                        <li><strong>Sitemap声明:<code>Sitemap:<?php echo esc_url( 'https://' . $_SERVER['HTTP_HOST'] . '/wp-sitemap.xml' ); ?></code></li>
                    </ul>
                </div>
                <div>
                    <label for="robots_txt_content" style="font-weight: bold; font-size: 16px;">编辑 Robots.txt 文件</label><br /><br />
                    <textarea name="robots_txt_content" id="robots_txt_content" rows="20" cols="80" style="width: 100%; padding: 10px; font-family: monospace; font-size: 14px; line-height: 1.6; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;"><?php echo esc_textarea( $robots_content ); ?></textarea>
                </div>
            </div>
            <input type="submit" name="robots_txt_save" value="保存更改" class="button button-primary" />
        </form>
        <p>演示内容</p>
                    <code># 禁止所有搜索引擎爬虫访问以下目录和文件</br>
                        User-agent: *</br>
                        # 禁止访问WordPress后台管理目录</br>
                        Disallow: /wp-admin/</br>
                        # 允许访问用于处理AJAX请求的文件</br>
                        Allow: /wp-admin/admin-ajax.php</br>
                        # 禁止访问插件和主题目录，防止敏感代码和文件被公开</br>
                        Disallow: /wp-content/plugins/</br>
                        Disallow: /wp-content/themes/</br>
                        # 禁止搜索引擎抓取搜索结果页面</br>
                        Disallow: /?s=</br>
                        # 如果您有特定的目录或页面不希望被搜索引擎抓取，可以取消以下注释并添加相应的路径</br>
                        # Disallow: /private-directory/</br>
                        # Disallow: /private-page.html</br>
                        # 如果您的网站有XML网站地图，请取消以下注释并添加网站地图的URL</br>
                        Sitemap: <?php echo esc_url( 'https://' . $_SERVER['HTTP_HOST'] . '/wp-sitemap.xml' ); ?>
                    </code>
    </div>
    <?php
}
