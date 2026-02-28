// 页面加载完毕事件
window.addEventListener('load', function() {
  // 延迟一秒后执行移除加载动画的操作
  setTimeout(function() {
    // 选择加载动画元素
    var loadingElement = document.querySelector('.qj_loading');
    if (loadingElement) {
      // 添加渐隐的过渡效果
      loadingElement.style.transition = 'opacity 0.5s';
      loadingElement.style.opacity = 0;

      // 延迟一定时间后移除元素
      setTimeout(function() {
        loadingElement.remove();
      }, 500);
    }

    // 移除加载动画的相关 CSS
    var cssElement = document.querySelector('#qj_dh_css');
    if (cssElement) {
      cssElement.remove();
    }
  }, 1000);
});

(function($) {
  $(document).ready(function() {
    // 获取 body 元素
    var body = $('body');
    // 获取日夜间切换按钮
    var toggleButton = $('#theme-toggle-btn');

    // 检查是否在浏览器缓存中存储了主题模式
    var isDarkMode = localStorage.getItem('darkMode');

    // 如果存在存储的主题模式，则应用正确的模式
    if (isDarkMode === 'true') {
      body.addClass('dark-theme');
    } else {
      body.removeClass('dark-theme');
    }

    // 给日夜间切换按钮添加点击事件处理程序
    toggleButton.on('click', function() {
      // 切换 dark-theme 类名
      body.toggleClass('dark-theme');

      // 更新存储的主题模式值
      isDarkMode = body.hasClass('dark-theme');
      localStorage.setItem('darkMode', isDarkMode);
    });
  });
})(jQuery);
