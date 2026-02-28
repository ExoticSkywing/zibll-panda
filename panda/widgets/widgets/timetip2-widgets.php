<?php
// 使用Panda_CFSwidget类创建一个名为'widget_ui_timetip'的小工具
Panda_CFSwidget::create('widget_ui_timetip2', array(
    'title'       => 'timetip2-动态时钟与温馨问候语',  // 小工具的标题
    'zib_title'   => true,  // 是否显示模块标题菜单
    'zib_affix'   => true,  // 是否显示侧栏随动菜单
    'description' => '显示动态时钟与温馨问候语，建议侧边栏显示。',  // 小工具的描述
    'fields'      => array()  // 配置小工具的字段（暂无额外字段）
));

// 定义显示小工具的函数
function widget_ui_timetip2($args, $instance)
{
    // 可用于是否显示判断
    $show_class = Panda_CFSwidget::show_class($instance);//值为1或者0

    // 构建HTML输出
    $html = '';
    
    // 添加JavaScript
    $html .= '<div class="dynamic-greeting">
        <div class="time-section">
            <div class="time-display">
                <span id="hours">00</span>
                <span class="colon">:</span>
                <span id="minutes">00</span>
                <span class="colon">:</span>
                <span id="seconds">00</span>
            </div>
            <div class="date-display" id="date"></div>
        </div>
        <div class="greeting-section">
            <div class="greeting-text" id="greeting"></div>
            <div class="greeting-tip" id="tip"></div>
        </div>
    </div>

    <style>
 .dynamic-greeting {background: linear-gradient(145deg, #ffffff, #f0f0f0);border-radius: 15px;padding: 20px;box-shadow: 5px 5px 15px rgba(0,0,0,0.1), -5px -5px 15px rgba(255,255,255,0.8);margin: 20px 0;transition: all 0.3s ease;}.dynamic-greeting:hover {transform: translateY(-2px);box-shadow: 7px 7px 20px rgba(0,0,0,0.12), -7px -7px 20px rgba(255,255,255,0.9);}.time-section {text-align: center;margin-bottom: 15px;padding-bottom: 15px;border-bottom: 1px solid rgba(0,0,0,0.05);}.time-display {font-size: 2.5em;font-weight: 700;color: #007AFF;font-family: "SF Pro Display", -apple-system, BlinkMacSystemFont, sans-serif;text-shadow: 2px 2px 4px rgba(0,0,0,0.1);}.time-display .colon {animation: blink 1s infinite;opacity: 1;}@keyframes blink {50% {opacity: 0;}}.date-display {font-size: 1em;color: #666;margin-top: 5px;}.greeting-section {padding: 10px;background: rgba(255,255,255,0.7);border-radius: 10px;}.greeting-text {font-size: 1.2em;color: #333;font-weight: 600;margin-bottom: 8px;}.greeting-tip {font-size: 0.9em;color: #666;line-height: 1.5;}body.dark-theme .dynamic-greeting {background: linear-gradient(145deg, #2d2d2d, #1a1a1a);box-shadow: 5px 5px 15px rgba(0,0,0,0.3), -5px -5px 15px rgba(255,255,255,0.05);}body.dark-theme .time-display {color: #0A84FF;}body.dark-theme .greeting-section {background: rgba(0,0,0,0.2);}body.dark-theme .greeting-text {color: #fff;}body.dark-theme .greeting-tip, body.dark-theme .date-display {color: #999;}
    </style>

    <script>
function updateTime(){const now=new Date();const hours=now.getHours().toString().padStart(2,"0");const minutes=now.getMinutes().toString().padStart(2,"0");const seconds=now.getSeconds().toString().padStart(2,"0");document.getElementById("hours").textContent=hours;document.getElementById("minutes").textContent=minutes;document.getElementById("seconds").textContent=seconds;const options={weekday:"long",year:"numeric",month:"long",day:"numeric"};document.getElementById("date").textContent=now.toLocaleDateString("zh-CN",options)}function updateGreeting(){fetch("https://api.ahfi.cn/api/getGreetingMessage?type=json").then(response=>response.json()).then(data=>{if(data.code===200){document.getElementById("greeting").textContent=data.data.greeting;document.getElementById("tip").textContent=data.data.tip}}).catch(error=>{console.error("获取问候语失败:",error);const hour=new Date().getHours();let defaultGreeting="";if(hour<6)defaultGreeting="凌晨好";else if(hour<11)defaultGreeting="早上好";else if(hour<14)defaultGreeting="中午好";else if(hour<18)defaultGreeting="下午好";else defaultGreeting="晚上好";document.getElementById("greeting").textContent=defaultGreeting;document.getElementById("tip").textContent="愿你今天心情愉快！"})}document.addEventListener("DOMContentLoaded",function(){updateTime();updateGreeting();setInterval(updateTime,1000);setInterval(updateGreeting,60000);if(document.documentElement.getAttribute("data-theme")==="dark"){document.body.classList.add("dark-theme")}});
    </script>';

    // 在小工具内容之前调用Panda_CFSwidget的echo_before函数
    Panda_CFSwidget::echo_before($instance, '');

    // 输出小工具内容
    echo $html;

    // 在小工具内容之后调用Panda_CFSwidget的echo_after函数
    Panda_CFSwidget::echo_after($instance);
}
?>