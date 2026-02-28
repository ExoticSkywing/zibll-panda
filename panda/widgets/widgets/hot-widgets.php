<?php
// 使用 Panda_CFSwidget 类创建一个名为 'widget_hot' 的小工具
Panda_CFSwidget::create('widget_hot', array(
    'title'       => 'hot-热门排名榜',  // 小工具的标题
    'zib_title'   => true,          // 是否显示模块标题菜单
    'zib_affix'   => true,          // 是否显示侧栏随动菜单
    'zib_show'    => true,          // 是否展示小工具显示规则菜单
    'description' => '显示热门排行榜，建议侧边栏显示',  // 小工具的描述
    'fields'      => array(
        // 排行榜1
        array(
            'title'       => '排行榜1名称',
            'id'          => 'hot_1',
            'type'        => 'text',
            'default'     => '建站资源',
        ),
        array(
            'title'       => '排行榜1分类ID',
            'id'          => 'hot_1_cat',
            'type'        => 'text',
            'default'     => '1',
        ),
        array(
            'title'       => '排行榜1显示个数',
            'id'          => 'hot_1_num',
            'type'        => 'text',
            'default'     => '5',
            'description' => '推荐显示5个',
        ),
        array(
            'title'       => '排行榜1跳转按钮文字',
            'id'          => 'hot_1_link_text',
            'type'        => 'text',
            'default'     => '查看完整榜单',
        ),
        array(
            'title'       => '排行榜1跳转链接',
            'id'          => 'hot_1_link',
            'type'        => 'text',
            'default'     => '/hot',
        ),

        // 排行榜2
        array(
            'title'       => '排行榜2名称',
            'id'          => 'hot_2',
            'type'        => 'text',
            'default'     => '子比美化',
        ),
        array(
            'title'       => '排行榜2分类ID',
            'id'          => 'hot_2_cat',
            'type'        => 'text',
            'default'     => '1',
        ),
        array(
            'title'       => '排行榜2显示个数',
            'id'          => 'hot_2_num',
            'type'        => 'text',
            'default'     => '5',
            'description' => '推荐显示5个',
        ),
        array(
            'title'       => '排行榜2跳转按钮文字',
            'id'          => 'hot_2_link_text',
            'type'        => 'text',
            'default'     => '查看完整榜单',
        ),
        array(
            'title'       => '排行榜2跳转链接',
            'id'          => 'hot_2_link',
            'type'        => 'text',
            'default'     => '/hot',
        ),

        // 排行榜3
        array(
            'title'       => '排行榜3名称',
            'id'          => 'hot_3',
            'type'        => 'text',
            'default'     => '软件基地',
        ),
        array(
            'title'       => '排行榜3分类ID',
            'id'          => 'hot_3_cat',
            'type'        => 'text',
            'default'     => '1',
        ),
        array(
            'title'       => '排行榜3显示个数',
            'id'          => 'hot_3_num',
            'type'        => 'text',
            'default'     => '5',
            'description' => '推荐显示5个',
        ),
        array(
            'title'       => '排行榜3跳转按钮文字',
            'id'          => 'hot_3_link_text',
            'type'        => 'text',
            'default'     => '查看完整榜单',
        ),
        array(
            'title'       => '排行榜3跳转链接',
            'id'          => 'hot_3_link',
            'type'        => 'text',
            'default'     => '/hot',
        ),
    )
));

// 定义显示小工具的函数
function widget_hot($args, $instance)
{
    echo '<style>
            /** 首页排行榜列表 **/
.syphimg{
    width: 90px;
    height:60px;
    margin-right: 5px;
}
.syphimg img{
       border-radius: 8px;
    
}
.list.clearfix {
  display: flex;
  justify-content: space-between;
    flex-wrap: wrap;

}

.list.clearfix .panda_new_post_label {
    display: none;
}

.ranking-item {
    margin:0 auto;
  position: relative;
  width: calc(33.333% - 10px );
  /* height: 400px; */
  /* margin-right: 10px; */
  /* margin-left: 10px; */
  background:var(--main-bg-color);
  /* box-shadow: 0 2px 6px 0 rgb(55 55 55 / 7%); */
  /* border-radius: 8px; */
  box-shadow: 0 0 10px var(--main-shadow);
  border-radius: var(--main-radius);
  margin-bottom: 20px;
}

a.top-icon.js-rank-bottom1 {
  display: block;
  width: 129px;
  height: 43px;
  line-height: 32px;
  position: absolute;
  left: 112px;
  top: -7px;
  background: url('.panda_pz('static_panda').'/assets/img/widgets/hot/ranking1.png) no-repeat center/100%;
  font-size: 18px;
  color: #fff;
  font-weight: 600;
  text-align: center;
}

a.top-icon.js-rank-bottom2 {
  display: block;
  width: 129px;
  height: 43px;
  line-height: 32px;
  position: absolute;
  left: 112px;
  top: -7px;
  background: url('.panda_pz('static_panda').'/assets/img/widgets/hot/ranking2.png) no-repeat center/100%;
  font-size: 18px;
  color: #fff;
  font-weight: 600;
  text-align: center;
}

a.top-icon.js-rank-bottom3 {
  display: block;
  width: 129px;
  height: 43px;
  line-height: 32px;
  position: absolute;
  left: 112px;
  top: -7px;
  background: url('.panda_pz('static_panda').'/assets/img/widgets/hot/ranking3.png) no-repeat center/100%;
  font-size: 18px;
  color: #fff;
  font-weight: 600;
  text-align: center;
}
.class-box {
  margin-top: 60px;
}

a.class-item.js-rank {
  display: block;
  width: 100%;
  height: 80px;
  display: flex;
  align-items: center;
  margin-bottom: 20px;
}

.num-icon.num-icon1 {
  width: 40px;
  height: 22px;
  background: url('.panda_pz('static_panda').'/assets/img/widgets/hot/top1.png) no-repeat center/100%;
  margin: 0 12px 0 15px;
}

img.class-pic {
  width: 90px;
  border-radius: 8px;
  margin-right: 5px;
}

.class-info {
  width: 190px;
  font-size: 12px;
}

.name {
  color: var(--key-color);
  line-height: 20px;
  font-weight: 400;
  margin-bottom: 2px;
  text-overflow: ellipsis;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  overflow: hidden;
  -webkit-box-orient: vertical;
}

.price {
  color: #f01414;
  font-weight: 600;
  margin-bottom: 2px;
}

.study-num {
  color: #9199a1;
  font-weight: 400;
}

.num-icon.num-icon2 {
  background: url('.panda_pz('static_panda').'/assets/img/widgets/hot/top2.png) no-repeat center/100%;
  margin: 0 12px 0 15px;
  width: 40px;
  height: 22px;
}

.num-icon.num-icon3 {
  background: url('.panda_pz('static_panda').'/assets/img/widgets/hot/top3.png) no-repeat center/100%;
  margin: 0 12px 0 15px;
  width: 40px;
  height: 22px;
}

.num-icon.num-icon4 {
  background: url('.panda_pz('static_panda').'/assets/img/widgets/hot/top4.png) no-repeat center/100%;
  margin: 0 12px 0 15px;
  width: 40px;
  height: 22px;
}

.num-icon.num-icon5 {
  background: url('.panda_pz('static_panda').'/assets/img/widgets/hot/top5.png) no-repeat center/100%;
  margin: 0 12px 0 15px;
  width: 40px;
  height: 22px;
}


a.bottom-link.js-rank-bottom {
  width: 120px;
  height: 24px;
  display: flex;
  justify-content: center;
  align-items: center;
  margin: 0 auto;
  font-size: 12px;
  color: #fff;
  line-height: 12px;
  font-weight: 500;
  background-image: linear-gradient(270deg, #4063ffa3 0, #409eff 100%);
  border-radius: 12px;
  margin-bottom: 20px;
}

/* 增加媒体查询以针对小屏幕设备 */
@media (max-width: 768px) {
  .list.clearfix {
    display: block;
  }
  .ranking-item {
    width: 100%;
    margin-bottom: 20px;
    padding: 0 0 10px 0;
  }
  .class-box {
    margin-top: 20px;
    padding-top: 45px;
  }
  .class-item.js-rank {
    display: flex;
    align-items: center;
    margin-bottom: 100px;
  }
  .num-icon {
    margin-right: 10px;
  }
  .class-info {
    width: calc(100% - 100px);
  }
  .name {
    margin-bottom: 5px;
  }
  .price, .study-num {
    display: block;
  }
  .bottom-link.js-rank-bottom {
    margin-bottom: 20px;
  }
} 
</style>
';
    // 是否显示判断
    $show_class = Panda_CFSwidget::show_class($instance);

    // 输出前置内容（用于兼容主题）
    Panda_CFSwidget::echo_before($instance, '');

    // HTML 开始
    echo '<div id="syphb" class="container list clearfix">';

    // 循环输出3个排行榜
    for ($i = 1; $i <= 3; $i++) {
        $cat_id   = $instance['hot_'.$i.'_cat'];
        $num      = $instance['hot_'.$i.'_num'];
        $title    = $instance['hot_'.$i];
        $link     = $instance['hot_'.$i.'_link'];
        $link_txt = $instance['hot_'.$i.'_link_text'];

        echo '<div class="ranking-item">';
        echo '<a class="top-icon js-rank-bottom'.$i.'">'.$title.'</a>';
        echo '<div class="class-box">';

        // 查询文章
        $query = new WP_Query(array(
            'cat'            => $cat_id,
            'posts_per_page' => $num,
            'orderby'        => 'meta_value_num',
            'meta_key'       => 'views',
            'order'          => 'DESC'
        ));

        $rank = 0;
        while ($query->have_posts()) : $query->the_post();
            $rank++;
            echo '<a class="class-item js-rank" href="'.get_permalink().'" target="_blank">';
            echo '<div class="num-icon num-icon'.$rank.'"></div>';
            echo '<span class="syphimg">'.zib_post_thumbnail().'</span>';
            echo '<div class="class-info">';
            echo '<div class="name">'.get_the_title().'</div>';
            echo '<span class="badg b-theme badg-sm">'.get_post_view_count('', '').'热度值</span>';
            echo '<span class="badg b-green badg-sm">'.get_post_comment_count('评论[', ']').'</span>';
            echo '<span class="badg b-yellow badg-sm">'.get_post_favorite_count('收藏[', ']').'</span>';
            echo '</div></a>';
        endwhile;
        wp_reset_postdata();

        echo '</div>'; // end class-box

        // 如果有完整榜单按钮
        if (!empty($link) && !empty($link_txt)) {
            echo '<a class="bottom-link js-rank-bottom" target="_blank" href="'.$link.'" rel="noopener nofollow ugc">';
            echo '<span>'.$link_txt.'</span><i class="imv2-chevrons-right"></i></a>';
        }

        echo '</div>'; // end ranking-item
    }

    echo '</div>'; // end container

    // 输出后置内容（用于兼容主题）
    Panda_CFSwidget::echo_after($instance);
}
