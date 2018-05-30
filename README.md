###swoole安装及配置
**下载源码包**
>git clone https://gitee.com/swoole/swoole.git

**配置编译**
>/usr/local/php/bin/phpize    //生成configure

>./configure --with-php-config=/usr/local/php/bin/php-config

**构架安装**
>make

>make install

**配置**
>php -i | grep php.ini   //找出php的配置文件php.ini

>extension=swoole    //添加其扩展

**查看扩展**
>php -m

**其他命令**
>netstat -anp | grep 9000

>telnet 127.0.0.1 9501


