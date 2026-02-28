<?php

// 备份数据库页面
function panda_backup_database_page() {
    global $wpdb;

    // 确保数据库目录存在
    $backup_dir = ABSPATH . 'database';
    if (!file_exists($backup_dir)) {
        mkdir($backup_dir, 0755);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // 获取数据库表的列表
        $tables = $wpdb->get_results('SHOW TABLES', ARRAY_N);

        // 导出所有表的数据
        $sql_dump = '';
        foreach ($tables as $table) {
            $table_name = $table[0];
            $create_table = $wpdb->get_row("SHOW CREATE TABLE $table_name", ARRAY_N);
            $sql_dump .= "\n-- Table structure for `$table_name` --\n";
            $sql_dump .= $create_table[1] . ";\n\n";

            $rows = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);
            foreach ($rows as $row) {
                $columns = array_keys($row);
                $values = array_map(function($value) {
                    return "'" . esc_sql($value) . "'";
                }, array_values($row));
                $sql_dump .= "INSERT INTO `$table_name` (`" . implode('`, `', $columns) . "`) VALUES (" . implode(', ', $values) . ");\n";
            }
        }

        // 创建备份文件名
        $timestamp = date('Y-m-d_H-i-s');
        $backup_file = $backup_dir . '/wp-database-backup-' . $timestamp . '.sql';

        // 保存为备份文件
        file_put_contents($backup_file, $sql_dump);

        // 显示成功消息
        echo '<div class="updated"><p>数据库备份成功！<a href="' . site_url('database/wp-database-backup-' . $timestamp . '.sql') . '" target="_blank">下载备份文件</a></p></div>';
    }

    // 删除文件功能
    if (isset($_GET['delete_backup']) && !empty($_GET['delete_backup'])) {
        $file_to_delete = $backup_dir . '/' . basename($_GET['delete_backup']);
        if (file_exists($file_to_delete)) {
            unlink($file_to_delete); // 删除文件
            echo '<div class="updated"><p>备份文件已删除。</p></div>';
        }
    }

    ?>
    <div class="wrap">
        <h1>备份数据库</h1>
        <form method="POST">
            <input type="submit" class="button button-primary" value="备份数据库">
        </form>
        <h2>备份记录</h2>
        <table class="widefat">
            <thead>
                <tr>
                    <th>备份时间</th>
                    <th>备份文件</th>
                    <th>文件大小</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // 读取数据库备份文件夹中的文件
                $backup_files = array_diff(scandir($backup_dir), array('..', '.')); // 排除. 和 ..

                foreach ($backup_files as $file) {
                    // 仅显示.sql文件
                    if (pathinfo($file, PATHINFO_EXTENSION) == 'sql') {
                        // 提取文件名中的时间戳（例如 wp-database-backup-2025-01-13_07-27-41.sql）
                        $timestamp = substr($file, strlen('wp-database-backup-'), -4); 
                        
                        // 格式化时间戳为更易读的格式（例如 2025年01月13日 07:27:41）
                        $date = DateTime::createFromFormat('Y-m-d_H-i-s', $timestamp);
                        $formatted_date = $date ? $date->format('Y年m月d日 H:i:s') : $timestamp;

                        // 获取文件大小
                        $file_size = filesize($backup_dir . '/' . $file);
                        $formatted_size = size_format($file_size, 2); // 使用WordPress自带的size_format函数，格式化为可读的大小

                        // 删除链接
                        $delete_url = add_query_arg('delete_backup', $file);

                        echo '<tr>';
                        echo '<td>' . esc_html($formatted_date) . '</td>';
                        echo '<td>' . esc_html($file) . '</td>';
                        echo '<td>' . esc_html($formatted_size) . '</td>';
                        echo '<td><a href="' . esc_url(site_url('database/' . $file)) . '" target="_blank">下载</a> | <a href="' . esc_url($delete_url) . '" onclick="return confirm(\'确定要删除这个备份文件吗?\')">删除</a></td>';
                        echo '</tr>';
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
    <?php
}
