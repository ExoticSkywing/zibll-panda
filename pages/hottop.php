<?php 
/**
 * Template name: Panda子主题-热榜排行
 * Description:   hottop page
 */
// 预加载热榜页样式，确保在 <head> 输出
add_action('wp_enqueue_scripts', function(){
    $static_panda_url = panda_pz('static_panda');
    wp_enqueue_style('index-css', $static_panda_url . '/assets/css/hottop.css');
});
get_header();
    $cats = panda_pz('hottop_1',false);
    $dsjfl = panda_pz('hottop_2',false);
?>

	<div class="hbbg">
		<div class="container">
			<i class="hbg">
			</i>
		</div>
	</div>
	<div id="app">
		<div class="hot-header">
			<div class="container">
				<h1 class="hlogo">
					<a>
						<i class="title">超级热榜</i>
						<img src="<?php echo panda_pz('static_panda').'/assets/img/chaojirebang.svg'; ?>" alt="超级热榜">
					</a>
				</h1>
			</div>
		</div>
		<div class="part-home-first">
			<div class="b-wrap container">
				<div class="items flex">
					<div class="part-home-hotsearch ph-item">
						<div class="p-wrap">
							<h2 class="p-title">
								<strong class="title">
									<a>热搜榜</a>
								</strong>
								<i class="subtitle">更新时间：<?php echo current_time('Y-m-d H:i:s'); ?>（实时）</i>
							</h2>
							<div class="p-content">
								<div class="items flex">
									<ul class="list">
										<?php
										// 假设从 zib_get_option 获取的数组是关联数组，包含关键词和它们的出现次数
										$hottop_search_keywords = zib_get_option('search_keywords');

										// 判断是否是数组
										if (is_array($hottop_search_keywords)) {
											// 获取前 8 个关键词
											$first_part = array_slice($hottop_search_keywords, 0, 8);
											foreach ($first_part as $keyword => $count) { 
												// 清除 $keyword 中的 &type=post 等部分
												$cleaned_keyword = preg_replace('/(&type=[^&]*)/', '', $keyword);
												?>
												<li class="p-item hotsearch-item">
													<i class="num"></i>
													<a href="<?php echo esc_url(site_url('?s=' . $cleaned_keyword)); ?>" target="_blank">
														<?php echo esc_html($cleaned_keyword); ?> (<?php echo esc_html($count); ?>)
														<i class="icon icon-talk-hot-2"></i>
													</a>
												</li>
											<?php }
										} else {
											echo '没有关键词';
										}
										?>
									</ul>
									<ul class="list">
										<?php
										// 判断是否是数组
										if (is_array($hottop_search_keywords)) {
											// 获取从第 9 个开始的 8 个关键词
											$second_part = array_slice($hottop_search_keywords, 8, 8);
											foreach ($second_part as $keyword => $count) { 
												// 清除 $keyword 中的 &type=post 等部分
												$cleaned_keyword = preg_replace('/(&type=[^&]*)/', '', $keyword);
												?>
												<li class="p-item hotsearch-item">
													<i class="num"></i>
													<a href="<?php echo esc_url(site_url('?s=' . $cleaned_keyword)); ?>" target="_blank">
														<?php echo esc_html($cleaned_keyword); ?> (<?php echo esc_html($count); ?>)
														<i class="icon icon-talk-hot-2"></i>
													</a>
												</li>
											<?php }
										} else {
											
										}
										?>
									</ul>
								</div>
							</div>
							<div class="p-btns">
								<a  class="btnpro">榜单实时更新</a>
							</div>
						</div>
					</div>
					<div class="part-home-news ph-item">
						<div class="p-wrap">
							<h2 class="p-title">
								<strong class="title">
									<a href="<?php echo esc_url(get_category_link($dsjfl)); ?>" target="_blank">
									<?php echo get_cat_name($dsjfl);?>
									</a>
								</strong>
								<i class="subtitle">更新时间：<?php echo current_time('Y-m-d H:i:s'); ?>（实时）</i>
							</h2>
							<div class="p-content">
								<div class="items flex">
									<ul class="list">
									<?php 
									    $args = $products = new WP_Query( array(
							                   'cat'=>$dsjfl, //分类目录
							                   'posts_per_page' => 8,
							                   'post_type'=>'post',
							                   'post_status'=>'published',
							                   )); 
							                   while ($products->have_posts()) : $products->the_post(); 
							         ?>
									    <li class="p-item">
											<i class="num">

											</i>
											<a href="<?php esc_url(the_permalink()); ?>" target="_blank">
												<?php the_title(); ?>
											</a>
										</li>
								<?php endwhile;?>
									</ul>
								</div>
							</div>
							<div class="p-btns">
								<a href="<?php echo esc_url(get_category_link($dsjfl)); ?>" target=_blank class="btnpro">
									查看全部
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="r-content">
			<div class="container">
				<div class="r-wrap">
					<div class="sidebar">
						<div class="part-sidebar">
							<div class="menus">
								<ul class="list">
									<li>
										<a href="<?php echo esc_url(home_url()); ?>">
											<i class="icon iconfont icon-zhuye1">
											</i>
											返回主站
										</a>
									</li>
									<li class="active">
										<a>
											<i class="icon iconfont icon-weixiao">
											</i>
											全部榜单
										</a>
									</li>
								
								
								</ul>
							</div>
						</div>
					</div>
					<div class="main">
						<div class="home-list flex sm:f-2">
						    <?php foreach ($cats as $cat){ ?>
							<div class="part-home-post f-item ph-item">
								<div class="f-box p-wrap">
									<h2 class="p-title">
										<strong class="title">
										<a href="<?php echo esc_url(get_category_link($cat)); ?>">
											<?php echo get_cat_name($cat); ?>
											</a>
											<img src="<?php echo panda_pz('static_panda').'/assets/img/yuebang.svg'; ?>" style="width: 35px;">
										</strong>
										<i class="bang-ico">
											<i class="icon icon-list-day">
											</i>
										</i>
										<i class="subtitle">更新时间：<?php echo current_time('Y-m-d'); ?></i>
									</h2>
									<div class="p-content">
									    <?php query_posts('cat='.$cat.'&showposts=6&orderby=views'); 
										$i=1;?>
									    <?php while (have_posts()) : the_post(); ?>
										<div class="p-items">
										    <div class="p-item article-item post-item">
												<a href="<?php esc_url(the_permalink()); ?>" target="_blank" class="item-wrap">
													<div class="item-num">
														<i class="num">
											
														</i>
													</div>
													<div class="item-main">
														<div class="item-thumb">
														<?php echo zib_post_thumbnail(); ?>
														</div>
														<h2 class="item-title">
															<?php the_title(); ?>
														</h2>
														<h4 class="item-tag">
															<i class="tag tag-hot">
																实时热榜NO.	<?php echo $i++;  ?>
															</i>
														</h4>
													</div>
												</a>
											</div>
										</div><?php endwhile;?>
									</div>
									<div class="p-btns">
										<a   class="btnpro">
											实时更新榜单
										</a>
									</div>
								</div>
							</div>
						<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php get_footer(); ?>