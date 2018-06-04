<?php
$redisClient = new swoole_redis;//Swoole\Redis
$redisClient->connect('127.0.0.1',6379,function (swoole_redis $redis_client,$result){
    echo "connect redis";
    var_dump($result);
    //set
    $redis_client->set('key', 'swoole', function (swoole_redis $client, $result) {
        echo "==================================set===============================================".PHP_EOL;
        var_dump($result);
    });
    //get
    $redis_client->get('key',function (swoole_redis $client,$result){
        echo "==================================get===============================================".PHP_EOL;
        var_dump($result);
        $client->close();
    });

    //all
    $redis_client->keys('*',function (swoole_redis $client,$resutl){
        echo "==================================keys===============================================".PHP_EOL;
       var_dump($resutl);
        $client->close();
    });
});

echo 'start'.PHP_EOL;














//
//
//<?php
//$redisClient = new swoole_redis;// Swoole\Redis
//$redisClient->connect('127.0.0.1', 6379, function(swoole_redis $redisClient, $result) {
//echo "connect".PHP_EOL;
//var_dump($result);
//
//// 同步 redis (new Redis())->set('key',2);
///*$redisClient->set('singwa_1', time(), function(swoole_redis $redisClient, $result) {
//var_dump($result);
//});*/
//
///*$redisClient->get('singwa_1', function(swoole_redis $redisClient, $result) {
//var_dump($result);
//$redisClient->close();
//});*/
//$redisClient->keys('*gw*', function(swoole_redis $redisClient, $result) {
//var_dump($result);
//$redisClient->close();
//});
//
//});
//echo "start".PHP_EOL;