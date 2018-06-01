<?php
$http = new swoole_http_server("192.168.199.136", 8801);
$http->on('request', function($request, $response) {
    $content = [
        'date:' => date("Ymd H:i:s"),
        'get:' => $request->get,
        'post:' => $request->post,
        'header:' => $request->header,
    ];
    swoole_async_writefile(__DIR__."/access.log", json_encode($content).PHP_EOL, function($filename){
        // todo
    }, FILE_APPEND);
    $response->end("response：". json_encode($request->get));
});

$http->start();