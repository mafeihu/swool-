<?php

//创建server服务监听127.0.0.1:9501
$serv = new swoole_server('127.0.0.1',9501);

$serv->set(array(
    'reactor_num' => 4, //worker进程数 cpu1-4
    'max_request' => 1000,
));

//监听连接进入事件
/**
 * $fd客户端连接的唯一标识
 * $reactor_id 线程id
 */
$serv->on('connect', function ($serv, $fd,$reactor_id){
    echo "Client:{$reactor_id} - {$fd}-Connect.\n";
});

//监听数据接收事件
$serv->on('receive', function ($serv, $fd, $reactor_id, $data) {
    $serv->send($fd, "Server:{$reactor_id} - {$fd}: ".$data);
});

//监听关闭事件
$serv->on('close', function ($serv, $fd) {
    echo "Client: Close.\n";
});

//开启swoole服务
$serv->start();