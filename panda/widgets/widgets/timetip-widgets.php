<?php
// 使用Panda_CFSwidget类创建一个名为'widget_ui_timetip'的小工具
Panda_CFSwidget::create('widget_ui_timetip', array(
    'title'       => 'timetip-动态时钟与温馨问候语',  // 小工具的标题
    'zib_title'   => true,  // 是否显示模块标题菜单
    'zib_affix'   => true,  // 是否显示侧栏随动菜单
    'description' => '显示动态时钟与温馨问候语，建议侧边栏显示。',  // 小工具的描述
    'fields'      => array()  // 配置小工具的字段（暂无额外字段）
));

// 定义显示小工具的函数
function widget_ui_timetip($args, $instance)
{
    // 可用于是否显示判断
    $show_class = Panda_CFSwidget::show_class($instance);//值为1或者0

    // 构建HTML输出
    $html = '<div class="greeting-container" style="margin:0 0 20px 0;">';
    $html .= '<div class="clock-face">';
    $html .= '<div class="clock-time" id="clock-time"></div>';
    $html .= '</div>';
    $html .= '<div class="greeting-text">';
    $html .= '<div class="greeting" id="greeting"></div>';
    $html .= '<div class="tip" id="tip"></div>';
    $html .= '</div>';
    $html .= '</div>';
    
    // 添加CSS样式
    $html .= '<style>
        .greeting-container {
            width: 100%;
            height: 150px;
            background-color: #f5f5f5;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px;
            font-family: Arial, sans-serif;
        }
        .clock-face {
            width: 100px;
            height: 100px;
            background-color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .clock-time {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        .greeting-text {
            flex: 1;
            margin-left: 20px;
        }
        .greeting {
            font-size: 20px;
            color: #007bff;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .tip {
            font-size: 16px;
            color: #666;
            line-height: 1.5;
        }
    </style>';
    
    // 添加JavaScript
    $html .= '<script>
        function updateClock() {
            const now = new Date();
            const hours = now.getHours().toString().padStart(2, \'0\');
            const minutes = now.getMinutes().toString().padStart(2, \'0\');
            const seconds = now.getSeconds().toString().padStart(2, \'0\');
            document.getElementById(\'clock-time\').textContent = `${hours}:${minutes}:${seconds}`;
        }
    
        function updateGreeting() {
            fetch(\'https://api.ahfi.cn/api/getGreetingMessage?type=json\')
                .then(response => response.json())
                .then(data => {
                    document.getElementById(\'greeting\').textContent = data.data.greeting;
                    document.getElementById(\'tip\').textContent = data.data.tip;
                })
                .catch(error => console.error(\'Error fetching the greeting message:\', error));
        }
    
        document.addEventListener(\'DOMContentLoaded\', function() {
            updateClock();
            updateGreeting();
            setInterval(updateClock, 1000);
            setInterval(updateGreeting, 60000);
        });
    </script>';

    // 在小工具内容之前调用Panda_CFSwidget的echo_before函数
    Panda_CFSwidget::echo_before($instance, '');

    // 输出小工具内容
    echo $html;

    // 在小工具内容之后调用Panda_CFSwidget的echo_after函数
    Panda_CFSwidget::echo_after($instance);
}
?>