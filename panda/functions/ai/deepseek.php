<?php
function deepseek_completions($api_key, $api_url, $text) {
    $header = array(
        'Authorization: Bearer ' . $api_key,
        'Content-type: application/json',
    );
     switch (panda_pz('deepseek_channel')) {
            case 1:
                $model = 'deepseek-chat';
                break;
            case 2:
                $model = 'deepseek-reasoner';
                break;
            default:
                $model = 'deepseek-chat';
                break;
        }
    $params = json_encode(array(
        'messages' => $text,
        'model' => $model,
    ));
    $curl = curl_init($api_url . '/chat/completions');
    $options = array(
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => $header,
        CURLOPT_POSTFIELDS => $params,
        CURLOPT_RETURNTRANSFER => true,
    );
    curl_setopt_array($curl, $options);
    $response = curl_exec($curl);
    $httpcode = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
    $text = "服务器连接错误，请稍后再试！";
    if (200 == $httpcode) {
        $json_array = json_decode($response, true);
        if (isset($json_array['choices'][0]['message']['content'])) {
            $text = str_replace("\n", "n", $json_array['choices'][0]['message']['content']);
        } else {
            $text = "对不起，我不知道该怎么回答。";
        }
    } elseif (429 == $httpcode) {
        $text = "非常抱歉，当前回复速度过快，请稍后再试。";
    } elseif (401 == $httpcode || 400 == $httpcode) {
        $json_array = json_decode($response, true);
        if (isset($json_array['error']['message'])) {
            $error_message = $json_array['error']['message'];
            if (strpos($error_message, 'The OpenAI account associated with this API key has been deactivated') !== false) {
                $text = "您的账号已被封禁，请管理员进入后台确认密钥是否正常。";
            } else {
                $text = $error_message;
            }
        } else {
            $text = "对不起，我不知道该怎么回答。";
        }
    }
    return $text;
}

function ai_deepseek($question) {
    $api_key = panda_pz('deepseek_api_key');
    $api_url = panda_pz('deepseek_api_url');
    if (empty($api_key)) {
        return 'deepseek API 配置错误，请检查设置。';
    }
    $text = array(
        array('role' => 'user', 'content' => $question),

    );
    $response = deepseek_completions($api_key, $api_url, $text);
    return $response;
}

function handle_deepseek_test_channel() {
    if (panda_pz('deepseek_api_key') && panda_pz('deepseek_api_url')) {
        $question = "你是谁";
        $response = ai_deepseek($question);
        wp_send_json_success(array('message' => $response));
    } else {
        wp_send_json_error(array('message' => "Deepseek 配置错误或未启用，请检查设置。"));
    }
}add_action('wp_ajax_deepseek_test_channel', 'handle_deepseek_test_channel');