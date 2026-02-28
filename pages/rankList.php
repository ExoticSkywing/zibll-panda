<?php

/**
 * Template name: Panda子主题-排行榜
 * Description:    ranList page
 */
 
get_header(); ?>
<style>
    /*top*/
.panda_search .search-button-action i {
    font-size: 18px;
}
.Zy-searchpc .search-button-action {
    position: absolute;
    right: 0;
    padding: 0;
    top: 0;
    display: block;
    height: 32px;
    width: 48px;
    padding-right: 4px;
    line-height: 32px;
    text-align: center;
    color: #ffffff;
    background-color: var(--focus-color);
    -webkit-border-radius: 0 16px 16px 0;
    -moz-border-radius: 0 16px 16px 0;
    border-radius: 0 16px 16px 0;
    cursor: pointer;
}
.Zy-searchpc .search-input {
    display: block;
    height: 32px;
    width: 210px;
    margin: 0;
    padding: 0 20px;
    outline: none;
    font-size: 16px;
    line-height: 32px;
    color: #FFB5C3;
    background-color: #FFF4F4;
    border: 1px solid #FFD1D8;
    border-width: 1px 0 1px 1px;
    -webkit-border-radius: 16px 0 0 16px;
    -moz-border-radius: 16px 0 0 16px;
    border-radius: 16px 0 0 16px;
}
.Zy-searchpc .top-search form {
    display: flex;
    background-color: rgb(255 255 255 / 0%);
}
/*dmss*/
.social-top .top-search {
    width: 250px;
    position: absolute;
    right: 150px;
    top: 18px;
}
.Zy-searchpc .top-search {
    width: 250px;
}
/*top-end*/
.page-template .site-header {
    height: 50px;
}
.Zystyle-rank-page {
    width: 1300px;
    margin: auto;
    position: relative;
    background-color: var(--main-bg-color);
    padding: 0 30px 0 10px;
    border-radius: 14px;
    box-shadow: 0 1px 34px 1px hsla(0,0%,44.7%,.16);
}
.RankPageHeader {
    margin: 20px 0 -12px;
    height: 170px;
    text-align: center;
    padding-top: 34px;
    background: url(<?php echo panda_pz('static_panda') ?>/assets/img/rank-header-bg.png) no-repeat 50%/640px 170px;
}
.RankPageHeader .main-title {
    height: 45px;
    font-weight: 700;
    font-size: 32px;
    line-height: 45px;
    text-align: center;
    letter-spacing: 10px;
    color: var(--header-color);
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    margin-bottom: 25px;
}
.Zyuser-list li:nth-child(1) .n1 {
    background: url(<?php echo panda_pz('static_panda') ?>/assets/img/n1.png) no-repeat;
    line-height: 200px!important;
}
.Zyuser-list li:nth-child(2) .n1 {
    background: url(<?php echo panda_pz('static_panda') ?>/assets/img/n2.png) no-repeat;
    line-height: 200px!important;
}
.Zyuser-list li:nth-child(3) .n1 {
    background: url(<?php echo panda_pz('static_panda') ?>/assets/img/n3.png) no-repeat;
    line-height: 200px!important;
}
.RankPageHeader .main-title .title-icon {
    width: 9px;
    height: 16px;
    background: url(<?php echo panda_pz('static_panda') ?>/assets/img/title-prefix.png) 50%/100%;
    margin: 0 14px;
}
.RankPageHeader .main-title .title-icon.suffix {
    margin: 0 3px;
}
.RankPageHeader .Zy-tab-wrap {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
}
.RankPageHeader .header-tab-item.active, .RankPageHeader .header-tab-item:hover {
    color: var(--focus-color);
}
.RankPageHeader .header-tab-item {
    position: relative;
    cursor: pointer;
    font-size: 16px;
    line-height: 22px;
    height: 30px;
    margin-right: 60px;
    margin-left: 100px;
}
.RankPageHeader .header-tab-item.active:after, .RankPageHeader .header-tab-item:hover:after {
    content: "";
    position: absolute;
    left: 50%;
    bottom: 0;
    right: 0;
    width: 14px;
    height: 3px;
    border-radius: 2px;
    background-color: var(--focus-color);
    -webkit-transform: translateX(-50%);
    -ms-transform: translateX(-50%);
    transform: translateX(-50%);
}
.Zystyle-rank-page .rank-page-content .update-time {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    color: #999;
    font-size: 12px;
    margin-bottom: 4px;
}
.Zystyle-rank-page .next-update-time {
    color: #999;
    font-size: 12px;
    padding-left: 32px;
}
.Zystyle-space {
    -webkit-box-flex: 1;
    -ms-flex: 1 1;
    flex: 1 1;
}
.Zystyle-rank-page .rank-page-content .rank-page-list {
    background-color: var(--main-bg-color);
    border-radius: 4px;
    min-height: 400px;
}
.Zystyle-list>ul {
    list-style: none;
}
.Zystyle-game-rank-list-item {
    padding: 17px 0;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
}
.Zystyle-game-rank-list-item .item-rank-mark {
    width: 50px;
    margin-right: 20px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    -webkit-box-flex: 0;
    -ms-flex: none;
    flex: none;
}
.Zystyle-game-rank-list-item .item-rank-mark .rank-mark-number {
    color: #999;
    font-size: 20px;
    min-width: 30px;
    height: 30px;
    border-radius: 15px;
    line-height: 30px;
    padding: 0 8px;
    text-align: center;
    background-color: #eee;
    overflow: hidden;
    white-space: nowrap;
    -o-text-overflow: ellipsis;
    text-overflow: ellipsis;
}
.Zystyle-game-rank-list-item .item-image {
    height: 130px;
    width: 230px;
    margin-right: 20px;
    border-radius: 2px;
    -webkit-box-flex: 0;
    -ms-flex: none;
    flex: none;
    position: relative;
}
.image-box {
    overflow: hidden;
}
.image-box img {
    display: block;
    width: 100%;
    height: 100%;
    background-color: #e8e8e8;
    border-radius: 8px;
}
.Zystyle-game-rank-list-item .item-info {
    -webkit-box-flex: 1;
    -ms-flex: 1 1;
    flex: 1 1;
    min-width: 100px;
}
.Zystyle-game-rank-list-item a:hover, .Zystyle-game-rank-list-item .item-info a:hover {
    color: var(--focus-color);
}
.Zystyle-game-rank-list-item .item-info .item-name {
    display: block;
    margin-top: 8px;
    color: var(--header-color);
    font-size: 16px;
    font-weight: 700;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    overflow: hidden;
    white-space: nowrap;
    -o-text-overflow: ellipsis;
    text-overflow: ellipsis;
}
.Zystyle-game-rank-list-item .item-info .item-sub-info {
    margin-top: 10px;
    color: #999;
    font-size: 12px;
    line-height: 17px;
}
.Zystyle-game-rank-list-item .item-info .item-sub-info span {
    margin-right: 50px;
}
.Zystyle-game-rank-list-item .item-info .item-tags {
    margin-top: 40px;
    height: 24px;
}
.Zystyle-game-tags.text {
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    overflow: hidden;
}
.Zystyle-game-tags, .Zystyle-game-tags .tag {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
}
.Zystyle-game-rank-list-item .item-info .item-tags .tag {
    color: #999;
}
.Zystyle-game-tags.text .tag {
    color: #999;
    padding: 0;
    margin-right: 0;
}
.Zystyle-game-tags .tag {
    height: 20px;
    color: #c5c5c5;
    font-size: 12px;
    padding: 0 8px;
    margin-right: 8px;
    white-space: nowrap;
    -webkit-box-flex: 0;
    -ms-flex: none;
    flex: none;
    -webkit-box-orient: horizontal;
    -webkit-box-direction: normal;
    -ms-flex-direction: row;
    flex-direction: row;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
}
.Zystyle-game-tags .tag span {
    white-space: nowrap;
    text-overflow: ellipsis;
    overflow: hidden;
    width: 950px;
}
        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

.Zystyle-list li:nth-child(-n+3) .rank-mark-number {
    background: #ffedae;
    color: #fb7a18;
}
@media screen and (max-width:768px){
.user-cover-button {
    position: absolute;
    top: 12px!important;
    right: 12px!important;
}
.Zystyle-index {
    background: var(--main-bg-color);
    padding: 0;
}
.Zystyle-rank-page {
    width: auto;
    margin: auto;
    position: relative;
    background-color: var(--main-bg-color);
    padding: 0;
}
.RankPageHeader {
    margin: 0;
    height: 150px;
    text-align: center;
    padding-top: 34px;
    background: url(<?php echo panda_pz('static_panda') ?>/assets/img/rank-header-bg.png) no-repeat 50%/640px 170px;
}
.RankPageHeader .main-title {
    height: 45px;
    font-weight: 700;
    font-size: 32px;
    line-height: 45px;
    margin-bottom: 25px;
}
.RankPageHeader .header-tab-item {
    position: relative;
    cursor: pointer;
    font-size: 16px;
    line-height: 22px;
    height: 30px;
    margin-right: 30px;
    margin-left: auto;
}
.Zystyle-game-rank-list-item {
    padding: 17px 0;
    display: flex;
}
.Zystyle-game-rank-list-item .item-rank-mark {
    width: auto;
    margin-right: -5px;
    margin-left: 5px;
}
.Zystyle-game-rank-list-item .item-image {
    height: 60px;
    width: 100px;
    margin-right: 10px;
    border-radius: 2px;
    -webkit-box-flex: 0;
    -ms-flex: none;
    flex: none;
    position: relative;
    margin-left: 10px;
}
.Zystyle-game-rank-list-item .item-info .item-name {
    display: block;
    margin-top: auto;
    margin-right: 10px;
    font-size: 12px;
    font-weight: 600;
}
.Zystyle-game-rank-list-item .item-info {
    min-width: 0;
}
.Zystyle-game-rank-list-item .item-info .item-sub-info {
    margin-top: 10px;
    color: #999;
    font-size: 12px;
    line-height: 17px;
}
.Zystyle-game-rank-list-item .item-info .item-tags {
    display: none;
}
.Zystyle-game-rank-list-item .item-info .item-sub-info span {
    margin-right: 30px;
}
.Zystyle-game-rank-list-item .item-rank-mark .rank-mark-number {
    font-size: 12px;
    min-width: 20px;
    height: 20px;
    line-height: 20px;
    padding: 0;
}
.Zyuser-list {
    padding-top: 10px;
}
.Zyuser-list li {
    position: relative;
    margin-left: 52px;
    padding: 2px 20px 2px 0;
}
.Zyuser-list.zuozhe-list2 li .l2 {
    position: relative;
    padding: 0 0 0 60px!important;
    height: 65px;
}
.Zyuser-list li .zuozheinfo .user {
    width: 50px!important;
}
.Zyuser-list li .zuozheinfo .user img.avatar {
    width: 50px!important;
    height: 50px!important;
}
.Zyuser-list li .moblv {
    /* position: relative; */
    margin-top: -10px;
}
.Zyuser-list li .cate {
    position: absolute;
    top: 0;
    left: 150px;
}
.Zyuser-list li .daib {
    display: none;
}
.Zyuser-list li .l3 {
    display: none;
}
#rank_list {
    margin-left: 0;
}
.Zyuser-list li .zuozheinfo .user {
    height: auto!important;
}
#rank_list .user i.zibll-vrenzhengguanli {
    right: 0!important;
}
.Zyuser-list li .cate span {
    position: relative;
    margin-left: auto!important;
}
}
/*作者榜*/
.Zyuser-list {
    margin-bottom: 20px;
}
.Zyuser-list li {
    position: relative;
    margin-left: 52px;
    padding: 22px 100px 2px 0;
}
.Zyuser-list li .l1 {
    position: absolute;
    top: 0;
    left: -52px;
    width: 38px;
    height: 100%;
}
.Zyuser-list li .l1 .nums.n1 {
    margin-top: -20px;
    height: 38px;
    width: 38px;
    overflow: hidden;
}
.Zyuser-list li .l1 .nums {
    font-size: 12px;
    position: absolute;
    top: 50%;
    left: 0;
    margin-top: -19px;
    height: 34px;
    line-height: 34px;
    width: 34px;
    text-align: center;
    border-radius: 100%;
    background-color: #f7f9f8;
    color: #8ea1a7;
    font-size: 18px;
    font-weight: 700;
}
.Zyuser-list.zuozhe-list2 li .l2 {
    position: relative;
    padding: 10px 0 0 130px;
}
.Zyuser-list li .l2 {
    position: relative;
    padding-left: 254px;
    height: 135px;
}
.zuozhe-list2 li .zuozheinfo {
    vertical-align: middle;
}
.Zyuser-list li .zuozheinfo .user {
    position: absolute;
    top: 0;
    left: 0;
    width: 150px;
    height: 110px;
}
.Zyuser-list li .zuozheinfo .user img.avatar {
    width: 120px;
    height: 120px;
    border-radius: 100%;
    display: block;
    overflow: hidden;
    background-color: var(--main-bg-color);
}
.Zyuser-list li .zuozheinfo .name {
    display: inline-block;
    height: 24px;
    line-height: 24px;
    color: var(--header-color);
    max-width: 180px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    vertical-align: top;
    font-size: 16px;
    font-weight: 700;
    margin-bottom: 10px;
}
.Zyuser-list li .cate {
    width: 100%;
    overflow: hidden;
    color: #ccc;
}
.Zyuser-list li .cate span {
    position: relative;
    /*margin-left: -15px;*/
}
.Zyuser-list li .cate em {
    margin: 0 5px;
    font-size: 12px;
    color: #8ea1a7;
    font-style: normal;
}
.Zyuser-list li .daib, .Zyuser-list li .daib a {
    color: #666;
}
.Zyuser-list li .daib {
    height: 24px;
    white-space: nowrap;
    text-overflow: ellipsis;
    overflow: hidden;
}
.Zyuser-list li .hdry {
    height: 20px;
    line-height: 20px;
    margin-top: 5px;
    color: #666;
}
.srank .badge {
    height: 20px;
    margin-left: 5px;
}
.badge {
    display: inline-block;
    vertical-align: middle;
}
.Zyuser-list li .l3 {
    position: absolute;
    right: 0;
    top: 0;
    width: 100px;
    vertical-align: middle;
    text-align: center;
    height: 100%;
}
.qianlValue {
    text-align: right;
    color: #999;
    margin-top: -20px;
    height: 40px;
    position: absolute;
    width: 100%;
    left: 0;
    top: 50%;
    font-size: 12px;
    line-height: 18px;
}
.qianlValue span {
    color: var(--focus-color);
    position: relative;
    cursor: pointer;
    display: inline-block;
    vertical-align: text-bottom;
    margin-bottom: 5px;
}
.qianlValue span em {
    font-size: 22px;
    display: inline-block;
    font-style: normal;
}
.Zyuser-list li .daib a:hover {
    color: var(--focus-color);
}
#rank_list {
    margin-left: 10px;
}
#rank_list .user i.zibll-vrenzhengguanli {
    right: 45px;
}
/*end*/
.panel-body .zibllfont {
    margin-right: 7px;
    color: var(--focus-color);
}
@media screen and (min-width: 850px){
/*user*/
.Zy-style-dm.author .user-panel {
    position: relative;
    width: 100%;
    margin-top: -165px;
    padding: 0 20px 0 70px;
    display: flex;
    padding-bottom: 70px;
}
.Zy-style-dm.author .user-panel .avatar {
    z-index: 1;
}
.Zy-style-dm.author .user-panel .avatar {
    border-radius: 99px;
}
.Zy-style-dm.author .avatar:hover .editor-avatar {
    opacity: 1;
    visibility: visible;
    border-radius: 99px;
}
.Zy-style-dm.author .user-panel-info {
    font-size: 24px;
    font-weight: 600;
    padding-top: 0;
    padding-left: 0;
    display: flex;
    justify-content: space-between;
    flex-grow: 1;
    align-items: flex-end;
    position: initial;
    top: 150px;
}
.Zy-style-dm.author .user-panel-info .user-panel-info-ss {
    font-size: 24px;
    font-weight: 600;
    padding-top: 0;
    padding-left: 90px;
    justify-content: space-between;
    flex-grow: 1;
    align-items: flex-end
}
.Zy-style-dm.author .user-panel-info .user-panel-editor-button {
    text-align: center;
    position: absolute;
    right: 24px;
    top: auto;
}
.Zy-style-dm.author .author-page-right {
    margin-right: 16px;
    position: relative;
    width: 290px;
    margin-top: -150px;
    background: var(--main-bg-color);
    border-top-left-radius: 88px;
    border-top-right-radius: 88px;
    box-shadow: 0 1px 34px 1px hsla(0,0%,44.7%,.16);
    z-index: 0;
}
.Zy-style-dm.author .author-page-left {
    flex: 1;
    margin-top: -70px;
    margin-left: 0;
    position: relative;
    width: 100%;
    border-radius: 20px;
    /* box-shadow: 0 11px 34px 11px hsla(0,0%,44.7%,.16); */
    z-index: 0;
}
.Zy-style-dm.author .author-page-right-in {
    padding: 0;
    top: 77px;
}
.Zy-style-dm .author-header {
    border-top-left-radius: 99px;
    border-top-right-radius: 99px;
}
.Zy-usermore {
    position: absolute;
    right: 140px;
    margin: -30px 0;
}
}

.RankPageHeader .header-tab-item.active, .RankPageHeader .header-tab-item:hover {
    color: var(--focus-color);
}
.RankPageHeader .header-tab-item.active:after, .RankPageHeader .header-tab-item:hover:after {
    content: "";
    position: absolute;
    left: 50%;
    bottom: 0;
    right: 0;
    width: 14px;
    height: 3px;
    border-radius: 2px;
    background-color: var(--focus-color);
    -webkit-transform: translateX(-50%);
    -ms-transform: translateX(-50%);
    transform: translateX(-50%);
}
.Zystyle-game-rank-list-item a:hover, .Zystyle-game-rank-list-item .item-info a:hover {
    color: var(--focus-color);
}
@media (max-width: 800px){.c{display: none;}}

.fluid-widget .posts-item:not(.card), .site-layout-1 .posts-item:not(.card) {
    margin: 8px;
    display: inline-flex;
    width: calc(100% - 16px);
}
</style>
<main class="container">
    <div class="content-wrap">
        <div class="content-layout">
       <div class="RankPageHeader">
	      <div class="main-title">
		     <div class="title-icon"></div>
		     <span>排行榜</span>
		     <div class="title-icon suffix"></div>
		  </div>
		  <div class="Zy-tab-wrap">
		    <div class="header-tab-item popularity active">
			   <span class="sub-title popularity-btn">活跃榜</span>
			</div>
			<div class="header-tab-item popularity">
			   <span class="sub-title activity-btn">人气榜</span>
			</div>
			<div class="header-tab-item popularity">
			   <span class="sub-title recommendation-tab">推荐榜</span>
			</div>
			<div class="header-tab-item popularity">
			   <span class="sub-title user-ranking-tab">用户榜</span>
			</div>
		  </div>
       </div>
	   <div class="rank-page-content">
	      <div class="update-time">
		     <div class="next-update-time">榜单刷新时间：实时刷新</div>
			 <div class="Zystyle-space"></div>
		  </div>
		  <div class="rank-page-list Zystyle-content-block">
		     <div class="Zystyle-list rank-list tab-content popularity-tab active">
                <?php echo get_popularity_ranking(); ?>
		     </div>
		     <div class="Zystyle-list rank-list tab-content activity-tab">
                 <?php echo get_activity_rankings(); ?>
		     </div>
             <div class="Zystyle-list rank-list tab-content recommendation-tab">
			    <?php echo get_recommendation_rankings(); ?>
		     </div>
             <div class="Zystyle-list rank-list tab-content user-ranking-tab">
			    <?php echo get_user_ranking(); ?>
		     </div>
		  </div>
       </div>
        </div>
    </div>
</main>
    <script>
    jQuery(document).ready(function($) {
        $('.popularity-btn').click(function() {
            $('.Zy-tab-wrap div').removeClass('active');
            $(this).parent().addClass('active');
            
            $('.tab-content').removeClass('active');
            $('.popularity-tab').addClass('active');
        });
        
        $('.activity-btn').click(function() {
            $('.Zy-tab-wrap div').removeClass('active');
            $(this).parent().addClass('active');
            
            $('.tab-content').removeClass('active');
            $('.activity-tab').addClass('active');
        });
        
        $('.recommendation-tab').click(function() {
            $('.Zy-tab-wrap div').removeClass('active');
            $(this).parent().addClass('active');
            
            $('.tab-content').removeClass('active');
            $('.recommendation-tab').addClass('active');
        });
        
        $('.user-ranking-tab').click(function() {
            $('.Zy-tab-wrap div').removeClass('active');
            $(this).parent().addClass('active');
            
            $('.tab-content').removeClass('active');
            $('.user-ranking-tab').addClass('active');
        });
    });
    </script>
<?php
function get_popularity_ranking() {
    $args = array(
        'posts_per_page' => 10,
        'meta_key' => 'views',
        'orderby' => 'meta_value_num',
        'order' => 'DESC'
    );
    $query = new WP_Query($args);
    
    $output = '<ul>';
    $rank = 1;
    while ($query->have_posts()) {
        $query->the_post();
        $output .= '<posts class="posts-item list ajax-item flex">';
        $output .= '<div class="Zystyle-game-rank-list-item first">';
        $output .= '<div class="item-rank-mark"><div class="rank-mark-number first">'.$rank.'</div></div>';
        $output .= '<a class="Zystyle-link item-image image-box" href="'.get_permalink().'" target="_blank">
        ' . zib_post_thumbnail($img_src) . '
        </a>';
        $output .= '<div class="item-info"><a class="Zystyle-link item-name" href="'.get_permalink().'" target="_blank">'.get_the_title().'</a><div class="item-sub-info"><span>作者：<a href="'.get_author_posts_url(get_the_author_meta('ID')).'">'.get_the_author().'</a></span><span>时间：'.get_the_date().' </span><span>分类：'.get_the_category_list(', ').' </span></div><div class="Zystyle-game-tags text item-tags">
							   <div class="tag tags">
							      <span>'.get_the_excerpt().'</span>
							   </div>
							</div></div>';
        $output .= '</div>';
        $output .= '</posts>';
        $rank++;
    }
    $output .= '</ul>';
    
    wp_reset_postdata();
    
    return $output;
}

function get_activity_rankings() {
    $args = array(
        'posts_per_page' => 10,
        'orderby' => 'comment_count',
        'order' => 'DESC'
    );
    $query = new WP_Query($args);
    
    $output = '<ul>';
    $rank = 1;
    while ($query->have_posts()) {
        $query->the_post();
        $output .= '<posts class="posts-item list ajax-item flex">';
        $output .= '<div class="Zystyle-game-rank-list-item first">';
        $output .= '<div class="item-rank-mark"><div class="rank-mark-number first">'.$rank.'</div></div>';
        $output .= '<a class="Zystyle-link item-image image-box" href="'.get_permalink().'" target="_blank">
        ' . zib_post_thumbnail($img_src) . '
        </a>';
        $output .= '<div class="item-info"><a class="Zystyle-link item-name" href="'.get_permalink().'" target="_blank">'.get_the_title().'</a><div class="item-sub-info"><span>作者：<a href="'.get_author_posts_url(get_the_author_meta('ID')).'">'.get_the_author().'</a></span><span>时间：'.get_the_date().' </span><span>分类：'.get_the_category_list(', ').' </span></div><div class="Zystyle-game-tags text item-tags">
							   <div class="tag tags">
							      <span>'.get_the_excerpt().'</span>
							   </div>
							</div></div>';
        $output .= '</div>';
        $output .= '</posts>';
        $rank++;
    }
    $output .= '</ul>';
    
    wp_reset_postdata();
    
    return $output;
}
function get_recommendation_rankings() {
    $args = array(
        'posts_per_page' => 10,
        'orderby' => 'rand'
    );
    $query = new WP_Query($args);
    
    $output = '<ul>';
    $rank = 1;
    while ($query->have_posts()) {
        $query->the_post();
        $output .= '<posts class="posts-item list ajax-item flex">';
        $output .= '<div class="Zystyle-game-rank-list-item first">';
        $output .= '<div class="item-rank-mark"><div class="rank-mark-number first">'.$rank.'</div></div>';
        $output .= '<a class="Zystyle-link item-image image-box" href="'.get_permalink().'" target="_blank">
        ' . zib_post_thumbnail($img_src) . '
        </a>';
        $output .= '<div class="item-info"><a class="Zystyle-link item-name" href="'.get_permalink().'" target="_blank">'.get_the_title().'</a><div class="item-sub-info"><span>作者：<a href="'.get_author_posts_url(get_the_author_meta('ID')).'">'.get_the_author().'</a></span><span>时间：'.get_the_date().' </span><span>分类：'.get_the_category_list(', ').' </span></div><div class="Zystyle-game-tags text item-tags">
							   <div class="tag tags">
							      <span>'.get_the_excerpt().'</span>
							   </div>
							</div></div>';
        $output .= '</div>';
        $output .= '</posts>';
        $rank++;
    }
    $output .= '</ul>';
    
    wp_reset_postdata();
    
    return $output;
}

function get_user_ranking() {
    $args = array(
        'number' => 10,
        'orderby' => 'post_count comment_count',
        'order' => 'DESC'
    );
    $users = get_users($args);
    $current_user_id = get_current_user_id();
    $current_user_avatar = get_avatar($current_user_id, 100);
    $current_user_link = get_author_posts_url($current_user_id);
    $current_user_post_count = get_usernumposts($current_user_id);

    $output = '<div class="Zyuser-list zuozhe-list2"><ul id="rank_list">';
    $rank = 1;
    foreach ($users as $user) {
        $user_id = $user->ID;
        $avatar = ($user_id == $current_user_id) ? $current_user_avatar : get_avatar($user_id, 100);
        $user_link = ($user_id == $current_user_id) ? $current_user_link : get_author_posts_url($user_id);
        $post_count = ($user_id == $current_user_id) ? $current_user_post_count : get_usernumposts($user_id);
        $user_posts = get_posts(array(
            'author' => $user_id,
            'posts_per_page' => 3,
            'orderby' => 'date',
            'order' => 'DESC'
        ));

        $output .= '<li>';
        $output .= ' <div class="l1"><div class="nums n1">'.$rank.'</div></div>';
        $output .= ' <div class="l2">
 <a href="'.$user_link.'" class="zuozheinfo" target="_blank">
 <div class="user avatar-img" >
 '.$avatar.'
 '.($user_data['user_title'] ? $user_data['verify_icon'] : '').'
  </div>
 <span class="name">'.$user->display_name.' ' . zibpay_get_vip_icon(zib_get_user_vip_level($user_id), 'mr3') . zib_get_user_auth_badge($user_id, 'ml3') .zib_get_medal_wear_icon($user_id, 'ml3') . zib_get_user_level_badge($user_id, 'ml3') . '</span>
 </a>
 <p class="cate">
 <span class="c">
 / <em>作品 '.$post_count.'</em>
 / <em>评论 '.get_user_comment_count($user_id).'</em>
 / <em>粉丝 '.get_user_meta($user_id, 'followed-user-count', true).'</em>
 </span>
 </p>
 <p class="daib"> 作品：';
        if (!empty($user_posts)) {
            foreach ($user_posts as $post) {
                $output .= '<a href="'.get_permalink($post->ID).'" target="_blank">'.$post->post_title.'</a>、';
            }
            $output = rtrim($output, '、');
        } else {
            $output .= '暂无作品';
        }
        $output .= '</p>
  </div>';
        $output .= ' <div class="l3">
 <div class="qianlValue">';
        if (!empty($post_count)) {
            $influence = ($post_count + $post_comment) * 1274;
            $output .= '<span><em class="tip"><i></i>' . get_user_posts_meta_count($user_id, 'views') . '</em></span>';
        } else {
            $output .= '<span><em class="tip"><i></i>0</em></span>';
        }
        $output .= '<br>人气值</div>
 </div>';
        $output .= '</li>';
        $rank++;
    }
    $output .= '</ul></div>';

    return $output;
}

?>
<?php
get_footer();