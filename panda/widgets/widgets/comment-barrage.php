<?php
// 名称: WIIUII - 评论弹幕模块
// 描述:由星语一人独立制作并美化,更多精彩美化请关注“星语的小木屋（WIIUII.CN）。
// 版本:V1.0.0

class wiiuiiCommentBarrage extends WP_Widget{

	function __construct(){
	    
		$widget_ops = array('classname' => 'wiiuiiCommentBarrage', 'description' => '星语独立开发显示网站评论弹幕小模块（更多精彩美化请关注“星语的小木屋（WIIUII.CN）”）');
		parent::__construct( false, 'Panda comment-评论弹幕模块', $widget_ops);
	}
	
	function form($instance){
		$instance = wp_parse_args(
			(array)$instance,
			array(
				'title' => '评论弹幕',
				'comment_num' => 30,
				'in_display' => 'all'
			)
		);
		$title = htmlspecialchars($instance['title']);
		$comment_num = htmlspecialchars($instance['comment_num']);
		$in_display_all =  $instance['in_display'] == 'all' ? 'checked' : '';
		$in_display_pc =  $instance['in_display'] == 'pc' ? 'checked' : '';
		$in_display_sm =  $instance['in_display'] == 'sm' ? 'checked' : '';
	    
	   // 后台HTML
		$wiui_html_style = '<style>.wiiuii-stamode-main>div{margin:5px auto}.wiiuii-stamode-img img{margin: 5px auto;max-height:90px;display:inline-block;vertical-align:middle;border-radius:5px}.wiiuii-stamode-con{display:flex;flex-direction:row}.wiiuii-stamode-con>input{width:100%}.wiiuii-stamode-con>.button{margin-left:5px}</style>';
		$wiui_html = $wiui_html_style;
		$wiui_html .= '<div class="wiiuii-stamode-main">';
		$wiui_html .= '<div><div><b>标题</b></div>';
		$wiui_html .= '<div><input style="width:100%" id="'.$this->get_field_id('title') .'" name="'.$this->get_field_name('title').'" type="text" value="'.$instance['title'].'" /></div></div>';
		$wiui_html .= '<div><div><b>弹幕评论数</b><i style="color:red;">每行的评论数必须一样，3n</i></div>';
		$wiui_html .= '<div><input style="width:100%" id="'.$this->get_field_id('comment_num') .'" name="'.$this->get_field_name('comment_num').'" type="text" value="'.$instance['comment_num'].'" /></div></div>';
		// 显示规则
		$wiui_html .= '<div><div><b>显示效果</b></div>';
		$wiui_html .= '<div><label><input style="vertical-align:-3px;margin-right:4px;" class="radio" type="radio" id="'.$this->get_field_id('in_display').'" name="'.$this->get_field_name('in_display').'" '. $in_display_all . ' value="all"/> PC端/移动端均显示</label></div>';
		$wiui_html .= '<div><label><input style="vertical-align:-3px;margin-right:4px;" class="radio" type="radio" id="'.$this->get_field_id('in_display').'" name="'.$this->get_field_name('in_display').'" '. $in_display_sm . ' value="sm"/> 仅在手机端显示</label></div>';
		$wiui_html .= '<div><label><input style="vertical-align:-3px;margin-right:4px;" class="radio" type="radio" id="'.$this->get_field_id('in_display').'" name="'.$this->get_field_name('in_display').'" '. $in_display_pc . ' value="pc"/> 仅在电脑端显示</label></div></div>';
		$wiui_html .= '</div>';
		$wiui_html .= '<b style="color:red;">*最好不要放到侧边栏，建议放到首页-底部全宽度。</b>';
		
		echo $wiui_html;
		
	}
	
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] = strip_tags(stripslashes($new_instance['title']));
		$instance['comment_num'] = strip_tags(stripslashes($new_instance['comment_num']));
		$instance['in_display'] = $new_instance['in_display']; 
		
		return $instance;
	}
	
	function widget($args, $instance){
		extract($args); 
		$title = apply_filters('widget_title',empty($instance['title']) ? '&nbsp;' : $instance['title']);
		$comment_num = empty($instance['comment_num']) ? 30 : $instance['comment_num'];
		if($instance['in_display'] == 'pc'){
		    $in_display = 'hidden-xs';
		}else if($instance['in_display'] == 'sm'){
		    $in_display = 'visible-xs-block';
		}
        // 前端HTML
		echo '<div class="mb20 ' . $in_display . '">';
		echo '<div class="box-body notop"><div class="title-theme">'. $title .'</div></div>';
		echo $before_widget;
		$this->wiiuii_get_websitestat($comment_num);
		echo '</div>';
		echo $after_widget;
    $static_panda_url = panda_pz('static_panda');
    wp_enqueue_script('wiiuii_script', $static_panda_url . '/assets/js/comment-barrage-min.js', array('jquery'));
	}
	
	function wiiuii_get_websitestat($comment_num){
		$wiiuii_args = array(
		    'status' => 'approve',
		    'number' => $comment_num,
		    'order' => 'desc'
		    );
		$comments = get_comments($wiiuii_args);
		$left_num = array(0,50,100);
		foreach($comments as $index => $comment) {
		    $wiui_html_comment = '<li class="wiui_widgets-barrage-item"><div class="wiui_widgets-author-tx">'.get_avatar($comment->user_id,40).'</div><div class="wiui_widgets-author-info"><b class="wiui_widgets-author-name">'.zib_comment_filters($comment->comment_author).'</b><p class="wiui_widgets-author-comment">&nbsp;&nbsp;' . zib_comment_filters($comment->comment_content) . '</p></div></li>';
		    $wiui_comment_num = $comment_num / 3;
		    if($index < $wiui_comment_num){
		        $wiui_html_one .= $wiui_html_comment;
		    }else if($index < ($wiui_comment_num * 2)){
    		    $wiui_html_two .= $wiui_html_comment;
		    }else{
    		    $wiui_html_three .= $wiui_html_comment;
		    }
		}
		$wiui_html = '<style>.wiui_widgets-comment-barrage{width:100%;height:260px;padding:20px 0;background-color:var(--body-bg-color);box-sizing:border-box;overflow:hidden;border-radius: 5px}.wiui_widgets-barrage-container{position:relative;width:100%;height:100%}.wiui_widgets-barrage-row{position:absolute;display:flex;flex-direction:row;align-content:center;align-items:center;align-items:flex-start}.wiui_widgets-barrage-row>.wiui_widgets-barrage-item{width:300px;height:60px;display:flex;margin-right:10px;padding:5px;background-color:var(--main-bg-color);color:var(--main-color);align-items:flex-start;flex-direction:row;align-content:center;overflow:hidden;border-radius:8px;box-shadow:0 0 10px rgba(243,243%,243%,40%)}.wiui_widgets-barrage-item>.wiui_widgets-author-tx{width:45px;height:45px;flex:none;overflow:hidden;border-radius:99px}.wiui_widgets-barrage-item>.wiui_widgets-author-tx img{max-width:100%;max-height:100%}.wiui_widgets-author-info{flex:auto;margin-left:5px}.wiui_widgets-author-info>.wiui_widgets-author-name::after{content:":"}.wiui_widgets-author-info>.wiui_widgets-author-comment{font-size:14px;display:-webkit-box;-webkit-box-orient:vertical;-webkit-line-clamp:2;overflow:hidden;line-height:16px}.wiui_widgets-author-comment>img{width: 20px!important; height: 20px!important;}.wiui_widgets-barrage-item:hover{height:100%;z-index:9}.wiui_widgets-barrage-item:hover .wiui_widgets-author-comment{-webkit-box-orient:unset;-webkit-line-clamp:unset;overflow:unset}.wiui_widgets-comments-one{top:0}.wiui_widgets-comments-two{top:80px}.wiui_widgets-comments-three{top:160px}</style>';
		$wiui_html .= '<div class="wiui_widgets-comment-barrage"><div class="wiui_widgets-barrage-container">';
		$wiui_html .= '<ul class="wiui_widgets-barrage-row wiui_widgets-comments-one" data-index="1">';
        $wiui_html .= $wiui_html_one;
        $wiui_html .= '</ul>';
        $wiui_html .= '<ul class="wiui_widgets-barrage-row wiui_widgets-comments-two" data-index="2">';
        $wiui_html .= $wiui_html_two;
        $wiui_html .= '</ul>';
        $wiui_html .= '<ul class="wiui_widgets-barrage-row wiui_widgets-comments-three" data-index="3">';
        $wiui_html .= $wiui_html_three;
        $wiui_html .= '</ul>';
        $wiui_html .= '</div></div>';
        
        echo $wiui_html;
		
	}
	// 子比主题评论内容过滤【图片/表情】函数，感谢老唐的函数
	function zib_comment_filters($cont, $type = '', $lazy = true)
    {
        $cont = convert_smilies($cont);
    
        $cont = preg_replace('/\[img=(.*?)\]/', '<img class="box-img lazyload" src="$1" alt="评论图片' . zib_get_delimiter_blog_name() . '">', $cont);
    
        if ('noimg' == $type) {
            $cont = preg_replace('/\<img(.*?)\>/', '[图片]', $cont);
            $cont = preg_replace('/\[code]([\s\S]*)\[\/code]/', '[代码]', $cont);
        } else {
            $cont = str_replace('[code]', '<pre><code>', $cont);
            $cont = str_replace('[/code]', '</code></pre>', $cont);
        }
    
        $cont = preg_replace('/\[g=(.*?)\]/', '<img class="smilie-icon" src="' . ZIB_TEMPLATE_DIRECTORY_URI . '/img/smilies/$1.gif" alt="表情[$1]' . zib_get_delimiter_blog_name() . '">', $cont);
        if (zib_is_lazy('lazy_comment') && $lazy) {
            $cont = str_replace(' src=', ' src="' . zib_get_lazy_thumb() . '" data-src=', $cont);
        }
    
        $cont = wp_kses_post($cont);
        
        return $cont;
    }
    
}

function wiiuiiCommentBarrage(){
    
	register_widget('wiiuiiCommentBarrage');
}

add_action('widgets_init','wiiuiiCommentBarrage');

?>