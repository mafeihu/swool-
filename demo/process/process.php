<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/4
 * Time: 14:36
 */
/**
 * 进程就是正在运行的程序的一个实例
 */
$process = new swoole_process('callback_function',false);

$pid = $process->start();

// php redis.php
function callback_function(swoole_process $process){
    /**
     * 参数一:Php执行环境变量
     * 参数二:执行的文件
     */
    $process->exec("/usr/local/php/bin/php", [__DIR__.'/../server/http_server.php']);
}

echo $pid . PHP_EOL;
//回收结束运行的子进程
swoole_process::wait();