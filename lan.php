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

function startsWith(string $string, string $subString): bool
{
    return str_starts_with($string, $subString);
}

try {
    $url = 'https://ifconfig.me/ip';
    $server_ip = curl_get($url);
    $client_ip = $_SERVER['REMOTE_ADDR'];
    //lan:是否是本地
    $lan = startsWith($client_ip, "192.") || $client_ip == $server_ip;
    $result = ['lan' => $lan, 'ip' => ['client' => $client_ip, 'server' => $server_ip]];
} catch (Exception $exception) {
    $result = ['lan' => false, 'ip' => ['client' => $client_ip, 'server' => '']];
}
die(json_encode($result));
