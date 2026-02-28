<?php
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {
    $static_panda_url = panda_pz('static_panda');
    wp_enqueue_style('panda-festival-widget-style', $static_panda_url . '/assets/css/widgets/festival-widgets.css', array(), '1.0.0');
}

// 使用Panda_CFSwidget类创建一个名为widget_festival_reminder的小工具
Panda_CFSwidget::create(
    'widget_festival_reminder',
    array(
        'title'       => 'festival-节日提醒',
        'description' => '显示下一个节日的信息',
    )
);

// 定义显示小工具的函数
function widget_festival_reminder($args, $instance)
{
    $show_class = Panda_CFSwidget::show_class($instance);

    $nextFestival = get_next_festival();

    $title = $instance['title'];
    $mini_title = $instance['mini_title'];

    $html = '';
    if ($title) {
        $xbt = '';
        if($mini_title){
            $xbt = '<small class="ml10">'.$mini_title.'</small>';
        }
        $html .= '<h2 class="panda-widget-title">'.$title.$xbt.'</h2>';
    }

    $html .= '<div class="panda-zx">';
    $html .= '<span>' . $nextFestival['name'] . '</span>';
    $html .= '<div class="panda-zx-n">';
    $html .= '<strong style="margin-bottom:1px;">' . $nextFestival['greetings'][0] . '</strong>';
    $html .= '<strong style="margin-top:1px;">' . $nextFestival['greetings'][1] . '</strong>';
    $html .= '</div></div>';
    $html .= '<div class="panda-zx-underline">';
    $html .= '<span>' . $nextFestival['date']->format('Y年m月d日') . '</span>';
    $html .= '</div>';

    Panda_CFSwidget::echo_before($instance, '');
    echo $html;
    Panda_CFSwidget::echo_after($instance);
}

function get_next_festival() {
    $today = new DateTime();

    $festivals = [
        '元旦节' => [
            'date' => '01-01',
            'greetings' => ['新年快乐', '万事如意'],
        ],
        '春节' => [
            'date' => '02-10',
            'greetings' => ['新春快乐', '合家团圆'],
        ],
        '元宵节' => [
            'date' => '02-26',
            'greetings' => ['元宵快乐', '团团圆圆'],
        ],
        '清明节' => [
            'date' => '04-04',
            'greetings' => ['清明安康', '敬佑先祖'],
        ],
        '劳动节' => [
            'date' => '05-01',
            'greetings' => ['劳动光荣', '幸福快乐'],
        ],
        '端午节' => [
            'date' => '06-14',
            'greetings' => ['端午安康', '粽香四溢'],
        ],
        '七夕节' => [
            'date' => '08-14',
            'greetings' => ['七夕快乐', '爱情甜蜜'],
        ],
        '中秋节' => [
            'date' => '09-19',
            'greetings' => ['中秋快乐', '月圆人圆'],
        ],
        '国庆节' => [
            'date' => '10-01',
            'greetings' => ['国庆快乐', '繁荣昌盛'],
        ],
        '重阳节' => [
            'date' => '10-28',
            'greetings' => ['重阳祭祖', '身体健康'],
        ],
        '新年' => [
            'date' => '12-31',
            'greetings' => ['新年快乐', '喜迎新年'],
        ],
    ];

    $nextFestival = null;
    $nextFestivalDate = null;

    foreach ($festivals as $name => $festival) {
        $festivalDate = DateTime::createFromFormat('Y-m-d', date('Y') . '-' . $festival['date']);
        if ($festivalDate < $today) {
            $festivalDate->modify('+1 year');
        }
        if ($nextFestivalDate === null || $festivalDate < $nextFestivalDate) {
            $nextFestival = $name;
            $nextFestivalDate = $festivalDate;
        }
    }

    return [
        'name' => $nextFestival,
        'date' => $nextFestivalDate,
        'greetings' => $festivals[$nextFestival]['greetings'],
    ];
}
?>