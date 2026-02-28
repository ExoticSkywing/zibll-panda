<?php

function connect_to_api($url, $apiKey, $data) {
    $headers = [
        'Authorization: Bearer ' . $apiKey,
        'Content-Type: application/json'
    ];

    // 初始化cURL会话
    $ch = curl_init();
    // 设置cURL选项
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 获取响应内容

    // 执行cURL会话
    $response = curl_exec($ch);

    // 检查是否有错误发生
    if (curl_errno($ch)) {
        echo 'Curl error: ' . curl_error($ch);
        $response = false;
    }

    // 关闭cURL资源
    curl_close($ch);

    return $response;
}

function get_response_from_api($question) {
    $url = 'https://dashscope.aliyuncs.com/compatible-mode/v1/chat/completions';
    $apiKey = panda_pz('tyws_app_key');
    $model = "";
    switch (panda_pz('tyws_channel')) {
        case '1':
            $model = "qwen2.5-3b-instruct";
            break;
        case '2':
            $model = "qwen2.5-1.5b-instruct";
            break;
        case '3':
            $model = "qwen2.5-0.5b-instruct";
            break;
        case '4':
            $model = "qwen-max";
            break;
        case '5':
            $model = "qwen-plus";
            break;
        case '6':
            $model = panda_pz('tyws_channel_custom');
            break;
    }
    $data = [
        "model" => $model,
        "messages" => [
            [
                "role" => "user",
                "content" => $question
            ]
        ]
    ];

    $response = connect_to_api($url, $apiKey, $data);
    if ($response) {
        $response_data = json_decode($response, true);
        if (isset($response_data['choices'][0]['message']['content'])) {
            return $response_data['choices'][0]['message']['content'];
        }
    }
    return '无法获取响应内容';
}

function test_ty_callback() {
    if (panda_pz('tyws_app_key')) {
        $question = "你是谁？";
        $response = get_response_from_api($question);
        wp_send_json_success(array('message' => $response));
    } else {
        wp_send_json_error(array('message' => "通义万相 配置错误或未启用，请检查设置。"));
    }
}
add_action('wp_ajax_test_ty', 'test_ty_callback');