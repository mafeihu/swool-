<?php
echo 'process-start-time：'.date("Ymd H:i:s");
echo PHP_EOL;
$workers = [];

$urls = [
    'http://baidu.com',
    'http://baidu.com?search=singwa',
    'http://baidu.com?search=singwa2',
    'http://baidu.com?search=imooc'
];

//创建多个子进程分别模拟请求url的内容
for ($i=0;$i<4;$i++){
    $process = new swoole_process(function (swoole_process $worker) use($i,$urls){
        // curl
        $content = curlData($urls[$i]);
        //将内容写入管道
        //    echo $content.PHP_EOL;
        $worker->write($content.PHP_EOL);
    },false);
    $pid = $process->start();
    $workers[$pid] = $process;
}
//获取管道内容
foreach($workers as $process) {
    echo $process->read().'sssss';
}
/**
 * 模拟请求URL的内容  1s
 * @param $url
 * @return string
 */
function curlData($url) {
    // curl file_get_contents
    sleep(1);
    return $url . "success".PHP_EOL;
}
echo "process-end-time:".date("Ymd H:i:s");