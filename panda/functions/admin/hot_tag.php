<?php 

function panda_keywords_manage_page() {
    // 获取筛选类型（多选）
    $filter_types = isset($_GET['filter_types']) ? $_GET['filter_types'] : []; // 获取筛选类型

    // 处理添加新词提交
    if (isset($_POST['submit_add_keyword'])) {
        $new_keyword = sanitize_text_field($_POST['new_keyword']);
        $search_count = intval($_POST['search_count']);
        $keyword_type = sanitize_text_field($_POST['keyword_type']);
        
        if (!empty($new_keyword)) {
            // 获取现有的热词列表
            $keywords = zib_get_option('search_keywords');
            if (!is_array($keywords)) {
                $keywords = [];
            }
            
            // 添加新词
            $keywords[$new_keyword . '&type=' . $keyword_type] = $search_count;

            // 对整个数组按照搜索次数进行排序（降序）
            arsort($keywords); 

            // 更新热词列表
            zib_update_option('search_keywords', $keywords);
        }
    }

    // 处理修改提交
    if (isset($_POST['submit_edit_keyword'])) {
        $old_key = sanitize_text_field($_POST['old_key']);
        $new_keyword = sanitize_text_field($_POST['edit_keyword']);
        $new_count = intval($_POST['edit_count']);
        $new_type = sanitize_text_field($_POST['edit_type']);
        
        if (!empty($old_key) && !empty($new_keyword)) {
            $keywords = zib_get_option('search_keywords');
            if (is_array($keywords) && isset($keywords[$old_key])) {
                unset($keywords[$old_key]);
                $keywords[$new_keyword . '&type=' . $new_type] = $new_count;
                arsort($keywords);
                zib_update_option('search_keywords', $keywords);
            }
        }
    }

    // 处理批量操作（删除）
    if (isset($_POST['bulk_action']) && $_POST['bulk_action'] == 'delete' && isset($_POST['selected_keywords'])) {
        $selected_keywords = $_POST['selected_keywords'];

        // 获取现有的热词列表
        $keywords = zib_get_option('search_keywords');
        if (is_array($keywords)) {
            foreach ($selected_keywords as $keyword) {
                // 删除选中的关键词
                unset($keywords[$keyword]);
            }

            // 更新热词列表
            zib_update_option('search_keywords', $keywords);
        }
    }

    // 获取和排序热词列表
    $keywords = zib_get_option('search_keywords'); // 获取搜索关键词
    if (!empty($keywords)) {
        arsort($keywords); // 确保排序，降序
    }

    // 筛选类型判断
    if (!empty($filter_types)) {
        $filtered_keywords = [];
        foreach ($keywords as $key => $value) {
            // 解析 type 参数并确定显示的类型
            $keyword_type = 'unknown';
            if (preg_match('/&type=(post|user|forum|plate)/', $key, $matches)) {
                $keyword_type = $matches[1];
            }

            // 如果关键词类型不在筛选条件中，则跳过
            if (!in_array($keyword_type, $filter_types) && $keyword_type !== 'unknown') {
                continue;
            }

            // 保留符合条件的关键词
            $filtered_keywords[$key] = $value;
        }
        $keywords = $filtered_keywords; // 更新关键词数组为过滤后的结果
    }

    ?>
    <div class="wrap">
        <h1>热门搜索关键词</h1>
        <div>
            <button id="add_new_keyword" class="button">添加热词</button>
            <button id="bulk_delete" class="button">批量删除</button><br>
            <!-- 筛选框：文章、用户、论坛、板块、其他 -->
            <form method="get" action="<?php echo admin_url('admin.php'); ?>" style="display: inline-block;">
                <input type="hidden" name="page" value="zib_keywords" />
                <div style="display: flex; gap: 10px; align-items: center;">
                    <label style="margin-right: 10px;">筛选类型：</label>
                    <label style="margin-right: 10px;">
                        <input type="checkbox" name="filter_types[]" value="post" <?php echo in_array('post', $filter_types) ? 'checked' : ''; ?>>
                        文章
                    </label>
                    <label style="margin-right: 10px;">
                        <input type="checkbox" name="filter_types[]" value="user" <?php echo in_array('user', $filter_types) ? 'checked' : ''; ?>>
                        用户
                    </label>
                    <label style="margin-right: 10px;">
                        <input type="checkbox" name="filter_types[]" value="forum" <?php echo in_array('forum', $filter_types) ? 'checked' : ''; ?>>
                        论坛
                    </label>
                    <label style="margin-right: 10px;">
                        <input type="checkbox" name="filter_types[]" value="plate" <?php echo in_array('plate', $filter_types) ? 'checked' : ''; ?>>
                        板块
                    </label>
                    <input type="submit" value="筛选" class="button" />
                </div>
            </form>
        </div>

        <!-- 表格：显示关键词数据 -->
        <form method="post" action="" id="keywords_form">
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select_all" style="margin:auto;"/></th> <!-- 复选框 -->
                        <th>#</th> <!-- 序号列 -->
                        <th>关键词</th>
                        <th>搜索次数</th>
                        <th>搜索类型</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($keywords)) {
                        $i = 1;
                        foreach ($keywords as $key => $value) {
                            // 解析 type 参数并确定显示的类型
                            $keyword_type = 'unknown';
                            if (preg_match('/&type=(post|user|forum|plate)/', $key, $matches)) {
                                $keyword_type = $matches[1];
                            }
                            // 只保留关键词部分，不显示 &type=post 之后的部分
                            $keyword_base = strtok($key, '&'); // 获取 `&type=post` 前面的部分

                            // 根据类型决定显示的搜索类型
                            $type = '其他'; // 默认值
                            switch ($keyword_type) {
                                case 'post':
                                    $type = '文章';
                                    break;
                                case 'user':
                                    $type = '用户';
                                    break;
                                case 'forum':
                                    $type = '论坛';
                                    break;
                                case 'plate':
                                    $type = '板块';
                                    break;
                                case 'other':
                                    $type = '其他';
                                    break;
                            }

                            echo "<tr>
                                <td><input type='checkbox' name='selected_keywords[]' value='$key' /></td> <!-- 复选框 -->
                                <td>$i</td> <!-- 序号 -->
                                <td>$keyword_base</td>
                                <td>$value</td>
                                <td>$type</td>
                                <td>
                                    <button type='button' class='button edit_keyword' 
                                        data-keyword='$keyword_base' 
                                        data-count='$value' 
                                        data-type='$keyword_type' 
                                        data-fullkey='$key'>编辑</button>
                                    <button class='button delete_keyword' data-keyword='$key'>删除</button>
                                </td>
                            </tr>";
                            $i++; // 增加序号
                        }
                    }
                    ?>
                </tbody>
            </table>
        </form>
    </div>

    <!-- 拟态框：用于添加新热词 -->
    <div id="add_keyword_modal" style="display: none;" class="modal">
        <div class="modal-content">
            <span id="close_modal" class="close">&times;</span>
            <h2>添加新热词</h2>
            <form method="post" action="">
                <p>
                    <label for="new_keyword">关键词：</label>
                    <input type="text" name="new_keyword" required />
                </p>

                <p>
                    <label for="search_count">搜索次数：</label>
                    <input type="number" name="search_count" required />
                </p>

                <p>
                    <label for="keyword_type">搜索类型：</label>
                    <select name="keyword_type" required>
                        <option value="post">文章</option>
                        <option value="user">用户</option>
                        <option value="forum">论坛</option>
                        <option value="plate">板块</option>
                    </select>
                </p>

                <input type="submit" name="submit_add_keyword" value="添加" class="button" />
            </form>
        </div>
    </div>

    <!-- 修改热词的模态框 -->
    <div id="edit_keyword_modal" class="modal">
        <div class="modal-content">
            <span class="close" id="close_edit_modal">&times;</span>
            <h2>修改热词</h2>
            <form method="post" action="">
                <input type="hidden" name="old_key" id="edit_old_key">
                
                <p>
                    <label for="edit_keyword">关键词：</label>
                    <input type="text" name="edit_keyword" id="edit_keyword" required />
                </p>

                <p>
                    <label for="edit_count">搜索次数：</label>
                    <input type="number" name="edit_count" id="edit_count" required />
                </p>

                <p>
                    <label for="edit_type">搜索类型：</label>
                    <select name="edit_type" id="edit_type" required>
                        <option value="post">文章</option>
                        <option value="user">用户</option>
                        <option value="forum">论坛</option>
                        <option value="plate">板块</option>
                    </select>
                </p>

                <input type="submit" name="submit_edit_keyword" value="修改" class="button button-primary" />
            </form>
        </div>
    </div>

    <style>
        .modal {
            display: none; /* 初始状态不显示 */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }


        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 300px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>

    <script>
        // 获取元素
        var modal = document.getElementById("add_keyword_modal");
        var btn = document.getElementById("add_new_keyword");
        var span = document.getElementById("close_modal");

        // 打开模态框
        btn.onclick = function() {
            modal.style.display = "block";
        }

        // 关闭模态框
        span.onclick = function() {
            modal.style.display = "none";
        }

        // 如果用户点击窗口外部，关闭模态框
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // 全选/全不选复选框
        document.getElementById("select_all").onclick = function() {
            var checkboxes = document.querySelectorAll("input[name='selected_keywords[]']");
            for (var checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        }
         // 删除关键词
        const deleteButtons = document.querySelectorAll('.delete_keyword');
        deleteButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                const keyword = button.dataset.keyword;

                if (confirm('确定删除此关键词吗？')) {
                    const formData = new FormData();
                    formData.append('action', 'delete_keyword');
                    formData.append('keyword', keyword);

                    // 发送 AJAX 请求删除关键词
                    fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('关键词删除成功');
                            location.reload(); // 刷新页面
                        } else {
                            alert('删除失败，请重试');
                        }
                    });
                }
            });
        });

        // 添加修改功能的 JavaScript
        document.addEventListener('DOMContentLoaded', function() {
            const editModal = document.getElementById("edit_keyword_modal");
            const closeEditBtn = document.getElementById("close_edit_modal");
            const editButtons = document.querySelectorAll('.edit_keyword');

            // 关闭修改模态框
            closeEditBtn.onclick = function() {
                editModal.style.display = "none";
            }

            // 点击编辑按钮时打开模态框并填充数据
            editButtons.forEach(function(button) {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const keyword = this.dataset.keyword;
                    const count = this.dataset.count;
                    const type = this.dataset.type;
                    const fullkey = this.dataset.fullkey;

                    // 填充表单数据
                    document.getElementById('edit_old_key').value = fullkey;
                    document.getElementById('edit_keyword').value = keyword;
                    document.getElementById('edit_count').value = count;
                    document.getElementById('edit_type').value = type;

                    // 显示模态框
                    editModal.style.display = "block";
                });
            });

            // 点击窗口外部时关闭修改模态框
            window.onclick = function(event) {
                if (event.target == editModal) {
                    editModal.style.display = "none";
                }
                // 保持原有的模态框关闭功能
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        });

        // 添加批量删除功能
        document.getElementById('bulk_delete').addEventListener('click', function(e) {
            e.preventDefault();
            const selectedBoxes = document.querySelectorAll("input[name='selected_keywords[]']:checked");
            
            if (selectedBoxes.length === 0) {
                alert('请至少选择一个关键词');
                return;
            }

            if (confirm('确定要删除选中的 ' + selectedBoxes.length + ' 个关键词吗？')) {
                const formData = new FormData();
                formData.append('action', 'bulk_delete_keywords');
                
                selectedBoxes.forEach(box => {
                    formData.append('keywords[]', box.value);
                });

                // 发送 AJAX 请求删除关键词
                fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('成功删除 ' + selectedBoxes.length + ' 个关键词');
                        location.reload(); // 刷新页面
                    } else {
                        alert('删除失败，请重试');
                    }
                });
            }
        });
    </script>
    <?php
}


// 处理 AJAX 删除请求
add_action('wp_ajax_delete_keyword', 'zib_delete_keyword');
function zib_delete_keyword() {
    // 确保有关键词和权限
    if (!isset($_POST['keyword']) || !current_user_can('manage_options')) {
        wp_send_json_error(['message' => '权限不足或缺少关键词']);
    }

    $keyword = sanitize_text_field($_POST['keyword']);

    // 获取现有的热词列表
    $keywords = zib_get_option('search_keywords');
    if (is_array($keywords) && isset($keywords[$keyword])) {
        unset($keywords[$keyword]); // 删除关键词
        zib_update_option('search_keywords', $keywords); // 更新列表
        wp_send_json_success(); // 返回成功响应
    }

    wp_send_json_error(['message' => '关键词不存在']);
}

// 在 PHP 部分添加批量删除的 AJAX 处理函数
add_action('wp_ajax_bulk_delete_keywords', 'zib_bulk_delete_keywords');
function zib_bulk_delete_keywords() {
    // 检查权限
    if (!current_user_can('manage_options')) {
        wp_send_json_error(['message' => '权限不足']);
    }

    // 检查是否有选中的关键词
    if (!isset($_POST['keywords']) || !is_array($_POST['keywords'])) {
        wp_send_json_error(['message' => '未选择关键词']);
    }

    // 获取现有的热词列表
    $keywords = zib_get_option('search_keywords');
    if (!is_array($keywords)) {
        wp_send_json_error(['message' => '关键词列表无效']);
    }

    // 删除选中的关键词
    foreach ($_POST['keywords'] as $keyword) {
        $keyword = sanitize_text_field($keyword);
        if (isset($keywords[$keyword])) {
            unset($keywords[$keyword]);
        }
    }

    // 更新关键词列表
    zib_update_option('search_keywords', $keywords);
    wp_send_json_success();
}
