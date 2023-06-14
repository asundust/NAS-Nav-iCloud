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

// // 是否能访问主机IP
// function canLan()
// {
//     $url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https://' : 'http://') . $_SERVER['SERVER_ADDR'] . ':' . $_SERVER['SERVER_PORT'];
//     $content = curl_get($url);
//     if (strpos($content, $_SERVER['SCRIPT_NAME']) !== false) {
//         return true;
//     }
//     return false;
// }

// debug
$isDebug = false;

// 内网环境判断
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
        // if (!$result) {
        //     // 判断是否能访问内网IP，应用场景例如为VPN连入内网，不需要可注释
        //     $result = canLan();
        //     $fun = 'canLan';
        // }
    }
    // 返回消息
    $result = ['lan' => $result, 'ip' => ['client' => $client_ip, 'server' => isset($server_ip) ? $server_ip : '']];
    if ($isDebug) {
        $result['fun'] = $fun;
    }
} catch (Exception $exception) {
    // 默认消息
    $result = ['lan' => false, 'ip' => ['client' => $client_ip, 'server' => '']];
    if ($isDebug) {
        $result['exception'] = $exception->getMessage();
    }
}
die(json_encode($result));
