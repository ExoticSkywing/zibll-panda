<?php

class RouteAuthOption
{
    /** 启用功能:此功仅做某些调试时使用,不适用插件时请在插件管理中禁用 */
    public $enable = true;

    /** 调试模式:默认关闭,如需调试请启用 */
    public $debug  = false;
    /** 用户分组表:请勿修改默认分类 */
    public $userGropTable = [
        '_Logged+' => ['mode' => 'userLevel', 'key' => [1, 2, 3, 4]],    // 普通用户+vip1+vip2+认证用户
        '_Vip1+'   => ['mode' => 'userLevel', 'key' => [2, 3, 4]],       // vip1+vip2+认证用户
        '_Vip2+'   => ['mode' => 'userLevel', 'key' => [3, 4]],          // vip2+认证用户
        '_Auth+'   => ['mode' => 'userLevel', 'key' => [4]],             // 认证用户

        'grop1'    => ['mode' => 'userId', 'key' => [1,2]],      //示例
        'grop2'    => ['mode' => 'userLevel', 'key' => [0, 1]],  //示例
    ];

    public $log; // 添加这一行
    public $routeParent = []; // 添加这一行
    public $allow = false; // 添加这一行
    /** 路由权限表 */
}

/** 挂载函数 */
add_action('template_redirect', 'RouteAuth', 0);

/** 引入设置文件 */


function RouteAuth()
{
    /** 实例化设置 */
    $OP = new RouteAuthOption;
    /** 初始化设置 */
    OptionInit($OP);

    // 权限判断
    authCheck2($OP);
    if ($OP->userLevel==5) {
        runlog($OP, '管理员访问,默认放行');
        $OP->allow=true;
    }
    if ($OP->debug){
        echo $OP->log;
        exit;
    }
    if (true!== $OP->allow) {
        require 'ErrorPage.php';
        die;
        exit;
    }

}

/**
 * 权限检查
 */
function authCheck($OP)
{
    runlog($OP, '执行权限检查');
    /** 先判断当前路由的直接权限 */
    runlog($OP, '检查当前路由的直接访问权限');
    $table=getSomeAuthTable($OP,$OP->routeType,[$OP->routeId]); // 获取有关的权限列表
    if (!empty($table)) {
        foreach ($table as $key => $item) {
            $OP->allow = false;
            if (in_array($item['allowgrop'], $OP->userGrop)) $OP->allow = true; //如果当前用户在允许通过的权限组中
            if ($OP->allow == false) break;   // 只要有一个权限组不让访问,则不能访问
        }
    }else{
        runlog($OP, '未找到直接权限控制设置',-1);
        $OP->allow=true;
    }
    runlog($OP, halt($OP->allow,'是否允许访问'));

    /** 判断当前页面直接上级的权限 */
    if ($OP->allow == true) {
        runlog($OP, '检查当前路由直接上级访问权限');
        /** 当上方判断通过时才有必要进入本判断 */
        if (PHP_VERSION_ID < 80000){
            $table=getSomeAuthTable($OP,'term', $OP->routeParent); // 获取有关的权限列表
        }
        if (!empty($table)) {
            foreach ($table as $key => $item) {
                $OP->allow = false;
                if (in_array($item['allowgrop'], $OP->userGrop)) $OP->allow = true; //如果当前用户在允许通过的权限组中
                if ($OP->allow == false) break;   // 只要有一个权限组不让访问,则不能访问
            }
        }else{
            runlog($OP, '未找到上级权限控制设置',-1);
            $OP->allow = true;
        }
        runlog($OP, halt($OP->allow, '是否允许访问'));
    }
    runlog($OP, halt($OP->allow, '最终判断结果'));
    runlog($OP, '权限检查结束',1);
    return $OP->allow;
}


/**
 * 权限检查
 */
function authCheck2($OP)
{
    runlog($OP, '执行权限检查');
    /** 先判断当前路由的直接权限 */
    runlog($OP, '检查当前路由的直接访问权限');
    $table = getSomeAuthTable($OP, $OP->routeType, [$OP->routeId]); // 获取有关的权限列表
    if (!empty($table)) {
        foreach ($table as $key => $item) {
            $OP->allow = false;
            if (in_array($item['allowgrop'], $OP->userGrop)) $OP->allow = true; //如果当前用户在允许通过的权限组中
            if ($OP->allow === true) break;   // 只要有一个权限组让访问,则能访问
        }
    } else {
        runlog($OP, '未找到直接权限控制设置', -1);
        $OP->allow = null;
    }
    runlog($OP, halt($OP->allow, '是否允许访问'));

    /** 判断当前页面直接上级的权限 */
    if ($OP->allow === null) {
        runlog($OP, '检查当前路由直接上级访问权限');
        /** 当上方判断通过时才有必要进入本判断 */
        if (PHP_VERSION_ID < 80000){
            $table=getSomeAuthTable($OP,'term', $OP->routeParent); // 获取有关的权限列表
        }
        if (!empty($table)) {
            foreach ($table as $key => $item) {
                $OP->allow = false;
                if (in_array($item['allowgrop'], $OP->userGrop)) $OP->allow = true; //如果当前用户在允许通过的权限组中
                if ($OP->allow === true) break;   // 只要有一个权限组允许访问,则能访问
            }
        } else {
            runlog($OP, '未找到上级权限控制设置', -1);
            $OP->allow = null;
        }
        runlog($OP, halt($OP->allow, '是否允许访问'));
    }
    if ($OP->allow === null) $OP->allow=true;
    runlog($OP, halt($OP->allow, '最终判断结果'));
    runlog($OP, '权限检查结束', 1);
    return $OP->allow;
}

/**
 * 初始化设置
 *
 */
function OptionInit($OP)
{
    /** 初始化数据记载 */
    runlog($OP, '初始化设置');

    /** 获取当前用户数据 */
    runlog($OP, '获取当前用户数据');
    $level = 0;
    if (is_user_logged_in() == true)          $level = 1; // 普通用户
    if (zib_get_user_vip_level() == 1)        $level = 2; // 1级vip
    if (zib_get_user_vip_level() == 2)        $level = 3; // 2级vip
    if (zib_is_user_auth() == true)           $level = 4; // 认证用户
    if (current_user_can('level_10') == true) $level = 5; // 管理员
    $OP->userLevel = $level;
    $OP->userId = get_current_user_id();
    unset($level);
    runlog($OP, halt($OP->userId,'用户ID'),3);
    runlog($OP, halt($OP->userLevel, '用户等级'),3);
    runlog($OP, '用户数据获取完成',1);


    /** 获取路由数据 */
    runlog($OP, '获取当前路由数据');
    $type='none';
    if (true == is_category()) $type = 'category';
    if (true == is_tag())      $type = 'tag';
    if (true == is_page())     $type = 'page';
    if (true == is_home())     $type = 'home';
    if (true == is_single()) {
        $type = 'single';
        foreach (get_the_category() as $key => $item) {
            $OP->routeParent[] = $item->term_id;
        }
    }
    $OP->routeType=$type;
    $OP->routeId= get_queried_object_id();
    unset($type);
    runlog($OP, halt($OP->routeType,'路由类型'),3);
    runlog($OP, halt($OP->routeId,'当前路由页面ID'),3);
    if (PHP_VERSION_ID < 80000){
        runlog($OP, halt($OP->routeParent,'当前路由页面父级ID'),3);
    }
    runlog($OP, '路由数据获取完成',1);

    /** 获取当前用户所属分组 */
    runlog($OP, '获取当前所属用户分组');
    $userGrop = [];
    foreach ($OP->userGropTable as $name => $grop) {
        $key=0;
        if ($grop['mode'] == 'userLevel') {
            $key = $OP->userLevel;
        }
        if ($grop['mode'] == 'userId') {
            $key = $OP->userId;
        }
        if (true == in_array($key, $grop['key'])) $userGrop[] = $name;
    }
    $OP->userGrop = $userGrop;
    unset($userGrop);
    runlog($OP, halt($OP->userGrop, '用户所属分组'),3);
    runlog($OP,'用户分组获取完成',1);


    /** 过滤未启用的路由设置 */
    runlog($OP, '过滤未启用的路由设置');

    $data=[];

    $routeAuthTable = [
        [   // 示例
            'type'  => 'tag',       // category(分类),tag(标签),single(文章),page(单页)
            'ids'   => explode(',', panda_pz('tag_ids')),         // id
            'allowgrop'  => '_Auth+',  // 可以访问的用户组
            'enable' => true             //是否启用
        ],
        [   // 示例
            'type'  => 'tag',       // category(分类),tag(标签),single(文章),page(单页)
            'ids'   => explode(',', panda_pz('sviptag_ids')),         // id
            'allowgrop'  => '_Vip2+',  // 可以访问的用户组
            'enable' => true             //是否启用
        ],
        [   // 示例
            'type'  => 'tag',       // category(分类),tag(标签),single(文章),page(单页)
            'ids'   => explode(',', panda_pz('viptag_ids')),         // id
            'allowgrop'  => '_Vip1+',  // 可以访问的用户组
            'enable' => true             //是否启用
        ],
        [   // 示例
            'type'  => 'tag',       // category(分类),tag(标签),single(文章),page(单页)
            'ids'   => explode(',', panda_pz('usertag_ids')),         // id
            'allowgrop'  => '_Logged+',  // 可以访问的用户组
            'enable' => true             //是否启用
        ],
        [   // 示例
            'type'  => 'category',       // category(分类),tag(标签),single(文章),page(单页)
            'ids'   => explode(',', panda_pz('AUth_ids')),         // id
            'allowgrop'  => '_Auth+',  // 可以访问的用户组
            'enable' => true,             //是否启用

        ],
        [   // 示例
            'type'  => 'category',       // category(分类),tag(标签),single(文章),page(单页)
            'ids'   => explode(',', panda_pz('svipAUth_ids')),         // id
            'allowgrop'  => '_Vip2+',  // 可以访问的用户组
            'enable' => true,             //是否启用

        ],
        [   // 示例
            'type'  => 'category',       // category(分类),tag(标签),single(文章),page(单页)
            'ids'   => explode(',', panda_pz('vipAUth_ids')),         // id
            'allowgrop'  => '_Vip1+',  // 可以访问的用户组
            'enable' => true,             //是否启用

        ],
        [   // 示例
            'type'  => 'category',       // category(分类),tag(标签),single(文章),page(单页)
            'ids'   => explode(',', panda_pz('userAUth_ids')),         // id
            'allowgrop'  => '_Logged+',  // 可以访问的用户组
            'enable' => true,             //是否启用

        ],
        [   // 示例
            'type'  => 'single',
            'ids'   => explode(',', panda_pz('single_ids')),
            'allowgrop'  => '_Auth+',
            'enable' => true
        ],
        [   // 示例
            'type'  => 'single',
            'ids'   => explode(',', panda_pz('svipsingle_ids')),
            'allowgrop'  => '_Vip2+',
            'enable' => true
        ],
        [   // 示例
            'type'  => 'single',
            'ids'   => explode(',', panda_pz('vipsingle_ids')),
            'allowgrop'  => '_Vip1+',
            'enable' => true
        ],
        [   // 示例
            'type'  => 'single',
            'ids'   => explode(',', panda_pz('usersingle_ids')),
            'allowgrop'  => '_Logged+',
            'enable' => true
        ],
        [   // 示例
            'type'  => 'page',
            'ids'   => explode(',', panda_pz('page_ids')),
            'allowgrop'  => '_Auth+',
            'enable' => true
        ],
        [   // 示例
            'type'  => 'page',
            'ids'   => explode(',', panda_pz('svippage_ids')),
            'allowgrop'  => '_Vip2+',
            'enable' => true
        ],
        [   // 示例
            'type'  => 'page',
            'ids'   => explode(',', panda_pz('vippage_ids')),
            'allowgrop'  => '_Vip1+',
            'enable' => true
        ],
        [   // 示例
            'type'  => 'page',
            'ids'   => explode(',', panda_pz('userpage_ids')),
            'allowgrop'  => '_Logged+',
            'enable' => true
        ],
    ];
    foreach ($routeAuthTable as $key => $item) {
        if (true == $item['enable']) $data[]=$item;
    }
    $routeAuthTable=$data;
    unset($data);
    runlog($OP, halt($routeAuthTable, '已启用的路由设置'), 3);
    runlog($OP, '过滤完成', 1);
    runlog($OP, '初始化完成', 1);
}



/**
 * 获取指定类型路由权限设置
 */
function getSomeAuthTable($OP,$type,$ids)
{
    // print_r($type);
    // print_r($ids);
    // exit;
    $routeAuthTable = [
        [   // 示例
            'type'  => 'tag',       // category(分类),tag(标签),single(文章),page(单页)
            'ids'   => explode(',', panda_pz('tag_ids')),         // id
            'allowgrop'  => '_Auth+',  // 可以访问的用户组
            'enable' => true             //是否启用
        ],
        [   // 示例
            'type'  => 'tag',       // category(分类),tag(标签),single(文章),page(单页)
            'ids'   => explode(',', panda_pz('sviptag_ids')),         // id
            'allowgrop'  => '_Vip2+',  // 可以访问的用户组
            'enable' => true             //是否启用
        ],
        [   // 示例
            'type'  => 'tag',       // category(分类),tag(标签),single(文章),page(单页)
            'ids'   => explode(',', panda_pz('viptag_ids')),         // id
            'allowgrop'  => '_Vip1+',  // 可以访问的用户组
            'enable' => true             //是否启用
        ],
        [   // 示例
            'type'  => 'tag',       // category(分类),tag(标签),single(文章),page(单页)
            'ids'   => explode(',', panda_pz('usertag_ids')),         // id
            'allowgrop'  => '_Logged+',  // 可以访问的用户组
            'enable' => true             //是否启用
        ],
        [   // 示例
            'type'  => 'category',       // category(分类),tag(标签),single(文章),page(单页)
            'ids'   => explode(',', panda_pz('AUth_ids')),         // id
            'allowgrop'  => '_Auth+',  // 可以访问的用户组
            'enable' => true,             //是否启用

        ],
        [   // 示例
            'type'  => 'category',       // category(分类),tag(标签),single(文章),page(单页)
            'ids'   => explode(',', panda_pz('svipAUth_ids')),         // id
            'allowgrop'  => '_Vip2+',  // 可以访问的用户组
            'enable' => true,             //是否启用

        ],
        [   // 示例
            'type'  => 'category',       // category(分类),tag(标签),single(文章),page(单页)
            'ids'   => explode(',', panda_pz('vipAUth_ids')),         // id
            'allowgrop'  => '_Vip1+',  // 可以访问的用户组
            'enable' => true,             //是否启用

        ],
        [   // 示例
            'type'  => 'category',       // category(分类),tag(标签),single(文章),page(单页)
            'ids'   => explode(',', panda_pz('userAUth_ids')),         // id
            'allowgrop'  => '_Logged+',  // 可以访问的用户组
            'enable' => true,             //是否启用

        ],
        [   // 示例
            'type'  => 'single',
            'ids'   => explode(',', panda_pz('single_ids')),
            'allowgrop'  => '_Auth+',
            'enable' => true
        ],
        [   // 示例
            'type'  => 'single',
            'ids'   => explode(',', panda_pz('svipsingle_ids')),
            'allowgrop'  => '_Vip2+',
            'enable' => true
        ],
        [   // 示例
            'type'  => 'single',
            'ids'   => explode(',', panda_pz('vipsingle_ids')),
            'allowgrop'  => '_Vip1+',
            'enable' => true
        ],
        [   // 示例
            'type'  => 'single',
            'ids'   => explode(',', panda_pz('usersingle_ids')),
            'allowgrop'  => '_Logged+',
            'enable' => true
        ],
        [   // 示例
            'type'  => 'page',
            'ids'   => explode(',', panda_pz('page_ids')),
            'allowgrop'  => '_Auth+',
            'enable' => true
        ],
        [   // 示例
            'type'  => 'page',
            'ids'   => explode(',', panda_pz('svippage_ids')),
            'allowgrop'  => '_Vip2+',
            'enable' => true
        ],
        [   // 示例
            'type'  => 'page',
            'ids'   => explode(',', panda_pz('vippage_ids')),
            'allowgrop'  => '_Vip1+',
            'enable' => true
        ],
        [   // 示例
            'type'  => 'page',
            'ids'   => explode(',', panda_pz('userpage_ids')),
            'allowgrop'  => '_Logged+',
            'enable' => true
        ],
    ];
    if ($type == 'term') {
        foreach ($routeAuthTable as $key => $item) {
            if ($item['type'] == 'category' || $item['type'] == 'tag') $data[] = $item;
        }
    }else{
        foreach ($routeAuthTable as $key => $item) {
            if ($item['type'] == $type) $data[] = $item;
        }
    }
    // print_r($data);
    // print_r('---------------');
    // exit;
    if (empty($data)) return;
    if (empty($ids)) return;
    $_data=[];
    foreach ($data as $key => $item) {
        foreach ($ids as $key => $id) {
            if (in_array($id,$item['ids'])) {$_data[]=$item;break;}
        }
    }
    if (empty($_data)) return;
    return $_data;
}

/**
 * 运行日志
 *
 * @param obj     $obj    存储内容的对象
 * @param string  $data   日志内容
 * @param boolean $return 内容颜色:-1=红色,0=黑色,1=绿色,2=蓝色,3=变量蓝
 */
function runlog($obj, $data, $color=0)
{
    switch ($color) {
        case -1: $color = '#ea2027'; break;
        case  0: $color = '#000000'; break;
        case  1: $color = '#009432'; break;
        case  2: $color = '#0078d4'; break;
        case  3: $color = '#1e3799'; break;
    }
    $log = '</br>';
    $log.= '<span style="color:'.$color.'">';
    $log.= $data;
    $log.= '</span>';
    if (PHP_VERSION_ID < 80000){
        $obj->log.=$log;
    }
    unset($log);
}


/**
 * 调试输出
 * @param mixed   $vars   要输出的变量
 * @param string  $tip  提示信息
 * @param boolean $return 是否讲调试结果返回
 *
 * @version 2.0
 *
 * @author CALEB
 */
function halt($vars, $tip = '',$return = true)
{
    $content='<pre>';
    if ($vars === true) $vars = 'true';
    if ($vars === false) $vars = 'false';
    if ($vars === null) $vars = 'null';
    if ($tip !== '') $content .= "<STRONG>{$tip}:</STRONG>";
    $content.= htmlspecialchars(print_r($vars, true));
    $content .= "</pre>";
    if (true == $return) return $content;
    echo $content;
    return null;

}