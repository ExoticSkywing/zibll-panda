<?php

get_header();?>
<main class="container">
    <div class="plate-tab zib-widget">
        <div class="text-center mb10" style="padding:15px 0;">
            <img style="width:280px;opacity: .7;" src="/wp-content/themes/zibll/img/null-cap.svg">
            <p style="margin-top:10px;" class="em09 muted-3-color separator">抱歉！您暂无查看此页面内容的权限</p>
        </div>
        <div class="hide-post mt20">
            <div class=""><i class="fa fa-unlock-alt mr6"></i>该页面内容已隐藏</div>
            <p class="mt6 em09 muted-3-color separator">您可以联系<span style="color:#fe3459"><?php echo panda_pz('mail_ids')?></span>,或者返回上一页</p>
            <div class="text-center em09 mt20">
                <p>
                    <a target="_blank" style="color:#fff" href="https://wpa.qq.com/msgrd?v=3&uin=<?php echo panda_pz('QQ_ids')?>&site=qq&menu=yes&jumpflag=1"class="but jb-blue padding-lg">
                    
                        申请
                    </a>
                    <a href="/" class="ml10 but jb-yellow padding-lg">
                        返回
                    </a>
                </p>
            </div>
        </div>
    </div>
</main>
<?php get_footer();return;?>
