<?php

// CURL请求
function curl_get($url)
{
    $headerArray = ["Content-type:application/json;", "Accept:application/json"];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headerArray);
    return curl_exec($ch);
}

// 是否局域网IP
function isLanIp($client_ip)
{
    $lanIpSubs = [
        '10.',
        '127.0.0.1',
        '172.16.',
        '172.17.',
        '172.18.',
        '172.19.',
        '172.20.',
        '172.21.',
        '172.22.',
        '172.23.',
        '172.24.',
        '172.25.',
        '172.26.',
        '172.27.',
        '172.28.',
        '172.29.',
        '172.30.',
        '172.31.',
        '192.168.',
    ];
    foreach ($lanIpSubs as $lanIpSub) {
        if (strpos($client_ip, $lanIpSub) !== false) {
            return true;
        }
    }
    return false;
}

// 获取内网地址
function getLanService()
{
    return ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https://' : 'http://') . $_SERVER['SERVER_ADDR'] . ':' . $_SERVER['SERVER_PORT'];
}

// debug开关
$isDebug = false;

// 变量
$tryLanStatus = true; // 尝试内网访问开关（判断是否能访问内网IP，应用场景例如为VPN连入内网）

// 函数入口
$type = isset($_GET['type']) ? $_GET['type'] : 'base';
if ($type == 'base') {
    // 客户端IP
    $client_ip = $_SERVER['REMOTE_ADDR'];
    try {
        // 是否局域网IP
        $result = isLanIp($client_ip);
        $fun = 'isLanIp';
        if (!$result) {
            // 获取主机外网IP判断
            $url = 'https://ifconfig.me/ip';
            $server_ip = curl_get($url);
            $result = $client_ip == $server_ip;
            $fun = 'clientAndServer';
        }
        // 返回消息
        $result = [
            'lan' => $result,
            'ip' => [
                'client' => $client_ip,
                'server' => isset($server_ip) ? $server_ip : '',
            ],
            'try_can_lan' => [
                'try_lan_status' => $tryLanStatus,
                'lan_address' => getLanService(),
            ]
        ];
        if ($isDebug) {
            $result['fun'] = $fun;
        }
    } catch (Exception $exception) {
        // 默认消息
        $result = ['lan' => false];
        if ($isDebug) {
            $result['exception'] = $exception->getMessage();
        }
    }
    die(json_encode($result));
} else if ($type == 'try_lan') {
    // 能访问代表为内网服务可用
    $data = [
        'lan' => true,
    ];
    $jsonData = json_encode($data);
    $callback = $_GET['callback'];
    header('Content-Type: application/javascript');
    echo $callback . '(' . $jsonData . ');';
} else {
    // 其他情况均为错误
    $result = ['error_message' => 'Type类型错误'];
    die(json_encode($result));
}
