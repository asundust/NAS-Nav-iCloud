<?php
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

try {
    $url = 'https://ifconfig.me/ip';
    $server_ip = curl_get($url);
    $lan = $_SERVER['REMOTE_ADDR'] == $server_ip;
    $result = ['lan' => $lan, 'ip' => ['client' => $_SERVER['REMOTE_ADDR'], 'server' => $server_ip]];
} catch (Exception $exception) {
    $result = ['lan' => false, 'ip' => ['client' => $_SERVER['REMOTE_ADDR'], 'server' => '']];
}
die(json_encode($result));