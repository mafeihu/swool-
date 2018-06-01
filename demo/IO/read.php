<?php
/**
 * 读取文件
 * __DIR__
 * 文件不存在会返回false
 * 成功打开文件立即返回true
 * 数据读取完毕后会回调指定的callback函数。
 */
//函数风格
$result1 = swoole_async_readfile(__DIR__."/1.txt", function($filename, $fileContent) {
    echo "filename:".$filename.PHP_EOL;  // \n \r\n
    echo "content:".$fileContent.PHP_EOL;
});
//命名空间风格
$result2 = Swoole\Async::readfile(__DIR__."/1.txt", function($filename, $fileContent) {
    echo "filename:".$filename.PHP_EOL;  // \n \r\n
    echo "content:".$fileContent.PHP_EOL;
});
var_dump($result1.'函数风格');
var_dump($result2.'命名空间风格');
echo "start".PHP_EOL;

