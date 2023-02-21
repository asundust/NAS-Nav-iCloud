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
function is_lan($client_ip) {
    $lanIpSubs = [
        '10.',
        '127.',
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

// 内网环境判断
try {
    $url = 'https://ifconfig.me/ip';
    $server_ip = curl_get($url);
    $client_ip = $_SERVER['REMOTE_ADDR'];
    $lan = is_lan($client_ip) || $client_ip == $server_ip;
    $result = ['lan' => $lan, 'ip' => ['client' => $client_ip, 'server' => $server_ip]];
} catch (Exception $exception) {
    $result = ['lan' => false, 'ip' => ['client' => $client_ip, 'server' => '']];
}
die(json_encode($result));
