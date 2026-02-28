<?php
/*
 * @Author: 苏晨
 * @Url: https://www.scbkw.com
 * @Date: 2025-02-19 00:11:43
 * @LastEditTime: 2025-08-25 10:09:45
 * @Email: 528609062@qq.com
 * @Project: 
 * @Description: 
 */

 /*调用子比默认GO跳转*/
if (panda_pz('go_style')=='null') {
    if (file_exists(get_theme_file_path('/assets/others/go/go.php'))) {
        require_once get_theme_file_path('/assets/others/go/go.php');
    }
}

/*调用GO跳转模板1*/
if (panda_pz('go_style')=='1') {
    if (file_exists(get_theme_file_path('/assets/others/go/go_1.php'))) {
        require_once get_theme_file_path('/assets/others/go/go_1.php');
    }
}

/*调用GO跳转模板2*/
if (panda_pz('go_style')=='2') {
    if (file_exists(get_theme_file_path('/assets/others/go/go_2.php'))) {
        require_once get_theme_file_path('/assets/others/go/go_2.php');
    }
}

/*调用GO跳转模板3*/
if (panda_pz('go_style')=='3') {
    if (file_exists(get_theme_file_path('/assets/others/go/go_3.php'))) {
        require_once get_theme_file_path('/assets/others/go/go_3.php');
    }
}

/*调用GO跳转模板4*/
if (panda_pz('go_style')=='4') {
    if (file_exists(get_theme_file_path('/assets/others/go/go_4.php'))) {
        require_once get_theme_file_path('/assets/others/go/go_4.php');
    }
}

/*调用GO跳转模板5*/
if (panda_pz('go_style')=='5') {
    if (file_exists(get_theme_file_path('/assets/others/go/go_5.php'))) {
        require_once get_theme_file_path('/assets/others/go/go_5.php');
    }
}
/*调用GO跳转模板6*/
if (panda_pz('go_style')=='6') {
    if (file_exists(get_theme_file_path('/assets/others/go/go_6.php'))) {
        require_once get_theme_file_path('/assets/others/go/go_6.php');
    }
}
/*调用GO跳转模板7*/
if (panda_pz('go_style')=='7') {
    if (file_exists(get_theme_file_path('/assets/others/go/go_7.php'))) {
        require_once get_theme_file_path('/assets/others/go/go_7.php');
    }
}
/*调用GO跳转模板8*/
if (panda_pz('go_style')=='8') {
    if (file_exists(get_theme_file_path('/assets/others/go/go_8.php'))) {
        require_once get_theme_file_path('/assets/others/go/go_8.php');
    }
}