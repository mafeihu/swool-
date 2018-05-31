<?php
$server = new swoole_websocket_server("0.0.0.0", 9912);
//配置静态文件根目录，可选
$server->set(
    [
        'enable_static_handler' => true,
        'document_root' => '/www/swoole/data',
    ]
);
//监听websocket连接打开事件
$server->on('open', 'onOpen');
function onOpen($server, $request) {
    print_r($request->fd);
}
// 监听ws消息事件
$server->on('message', function (swoole_websocket_server $server, $frame) {
    echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
    $server->push($frame->fd, "接收到了你的消息:{$frame->data}");
});
$server->on('close', function ($ser, $fd) {
    echo "client {$fd} closed\n";
});

$server->start();