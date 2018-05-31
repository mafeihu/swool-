<?php

//连接 swoole tcp服务
$swoole_client = new swoole_client(SWOOLE_SOCK_TCP);

if(!$swoole_client->connect('127.0.0.1', 9501)){
    echo '连接失败';
    exit;
}

//php cli常量
fwrite(STDOUT,'请输入消息:');
$msg = trim(fgets(STDIN));

//发时效性给tcp server服务器
$swoole_client->send($msg);

//接收server的数据c
$result = $swoole_client->recv();

echo $result."\n";
