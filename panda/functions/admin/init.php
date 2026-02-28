<?php
function panda_tools_menu() {
    add_menu_page(
        'Panda Tools',                // 页面标题
        'Panda 工具',                 // 菜单标题
        '',             // 权限
        'panda-tools',                // 菜单slug
        '',      // 页面内容函数
        'dashicons-admin-tools',      // 图标
        81                            // 位置（可选，根据需要调整）
    );

    add_submenu_page(
        'panda-tools',                 // 主菜单slug
        '热门搜索关键词',               // 页面标题
        '热门搜索关键词管理',            // 菜单标题
        'manage_options',              // 权限
        'panda-keywords-manage',      // 子菜单slug
        'panda_keywords_manage_page'  // 页面内容函数
    );

    add_submenu_page(
        'panda-tools',                 // 主菜单slug
        'Robots.txt管理',              // 页面标题
        'Robots.txt管理',              // 菜单标题
        'edit_files',                  // 权限
        'panda-robots-manage',        // 子菜单slug
        'panda_robots_manage_page'    // 页面内容函数
    );

    add_submenu_page(
        'panda-tools',                 // 主菜单slug
        '备份数据库',                  // 页面标题
        '备份数据库',                  // 菜单标题
        'edit_files',                  // 权限
        'panda-backup-database',      // 子菜单slug
        'panda_backup_database_page'  // 页面内容函数
    );
}
add_action('admin_menu', 'panda_tools_menu');