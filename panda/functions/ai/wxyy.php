<?php
class Sample {
    private $apiKey;
    private $secretKey;
    private $channel;

    public function __construct() {
        $this->apiKey = panda_pz('wyy_api_key');
        $this->secretKey = panda_pz('wyy_app_secret');
        $this->channel = panda_pz('wyy_channel');
    }

    /**
     * 获取鉴权签名（Access Token）
     *
     * @return string 鉴权签名信息（Access Token）
     */
    private function getAccessToken() {
        $url = "https://aip.baidubce.com/oauth/2.0/token";
        $postData = http_build_query([
            'grant_type' => 'client_credentials',
            'client_id' => $this->apiKey,
            'client_secret' => $this->secretKey
        ]);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            // 处理错误
            curl_close($ch);
            throw new Exception('Curl error: ' . curl_error($ch));
        }
        curl_close($ch);

        $responseData = json_decode($response, true);
        if (isset($responseData['error'])) {
            // 处理API错误
            throw new Exception("API Error: " . $responseData['error_description']);
        }

        return $responseData['access_token'];
    }

    /**
     * 发送请求到AI API
     *
     * @param string $accessToken 鉴权签名
     * @param string $message 要发送的消息
     * @return array API的响应
     */
    private function sendRequest($accessToken, $message) {
        // 根据 channel 的值设置 URL 中的模型名称
        switch (panda_pz('wyy_channel')) {
            case 1:
                $model = 'ernie-speed-128k';
                break;
            case 2:
                $model = 'ernie-lite-8k';
                break;
            case 3:
                $model = 'ernie-3.5-128k';
                break;
            case 4:
                $model = 'completions_pro';
                break;
            case 5:
                $model = panda_pz('wyy_channel_custom');
                break;
            default:
                $model = 'ernie-lite-8k';
                break;
        }

        $url = "https://aip.baidubce.com/rpc/2.0/ai_custom/v1/wenxinworkshop/chat/{$model}?access_token=" . urlencode($accessToken);
        $data = [
            'messages' => [
                ['role' => 'user', 'content' => $message]
            ]
        ];
        $jsonData = json_encode($data, JSON_UNESCAPED_UNICODE);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            // 处理错误
            curl_close($ch);
            throw new Exception('Curl error: ' . curl_error($ch));
        }
        curl_close($ch);

        $responseData = json_decode($response, true);
        if (isset($responseData['result'])) {
            // 获取 result 字段
            return $responseData['result'];
        }

        return null; // 如果没有 result 字段，返回 null
    }

    /**
     * 处理连接并发送请求
     *
     * @param string $message 要发送的消息
     * @return string API的响应
     */
    public function processRequest($message) {
        try {
            $accessToken = $this->getAccessToken();
            $result = $this->sendRequest($accessToken, $message);
            return $result ? $result : 'No result returned.';
        } catch (Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }
}



add_action('wp_ajax_test_wxyy', 'test_wxyy_callback');

function test_wxyy_callback() {
    if (panda_pz('wyy_api_key') && panda_pz('wyy_app_secret')) {
        $sample = new Sample();
        $response = $sample->processRequest('你是谁');
        wp_send_json_success(array('message' => $response));
    } else {
        wp_send_json_error(array('message' => "文心一言 配置错误或未启用，请检查设置。"));
    }
}
