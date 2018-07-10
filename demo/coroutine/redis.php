<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/10
 * Time: 15:34
 */
/**
 * swoole协程用同步的代码实现异步的功能
 */
//创建一个http_server
$http = new swoole_http_server('0.0.0.0',9501);

//创建一个onRequest
$http->on('request',function ($request,$response){

    //获取redis里面key值的内容，输出到浏览器
    $redis = new Swoole\Coroutine\Redis();
    //连接redis
    $redis->connect('127.0.0.1','6379');
    //接收请求值
    $value = $redis->get($request->get['a']);

    //mysql操作（使用线程 最大耗时为mysql,redis 的最大耗时值）



    //设置头部
    $response->header("Content-Type", "text/plain");
    $response->end($value);
    $redis->close();
});

$http->start();

/*
 * 如果用传统的方式 耗时时长为redis+mysql;
 */












