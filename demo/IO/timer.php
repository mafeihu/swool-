<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/1
 * Time: 9:25
 */
//异步高精度定时器，粒度为毫秒级
/**
 * 毫秒定时器
 */
//每隔2000ms触发一次
swoole_timer_tick(2000,function ($timer_id){
   echo 'tick_2000ms'.PHP_EOL;
});


//3000ms后执行此函数
swoole_timer_after(3000, function () {
    echo "after 3000ms.\n";
});




