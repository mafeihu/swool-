<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/1
 * Time: 9:44
 */
class Ws{
    CONST HOST='0.0.0.0';
    CONST PORT=9912;
    public $ws=null;
    public function __construct()
    {
        $this->ws = new swoole_websocket_server(self::HOST,self::PORT);

        $this->ws->set(
            [
                //设置加载静态页面(配置静态文件根目录，可选)
                'enable_static_handler' => true,
                'document_root' => "/www/swoole/data",

                //task进程设置
                'worker_num' => 2,
                'task_worker_num' => 2, //*必须参数
            ]
        );

        $this->ws->on('open',[$this,'onOpen']);
        $this->ws->on('message',[$this,'onMessage']);
        $this->ws->on('task',[$this,'onTask']);
        $this->ws->on('finish',[$this,'onFinish']);

        $this->ws->on('close',[$this,'onClose']);

        $this->ws->start();
    }


    /**
     * 监听ws连接事件
     * @param $ws
     * @param $request
     */
    public function onOpen($ws,$request){
        //每隔2000ms触发一次
        swoole_timer_tick(2000,function ($timer_id){
            echo 'tick_2000ms'.PHP_EOL;
        });
        print_r("连接用户的唯标识ID:".$request->fd.PHP_EOL);
    }

    /**
     * 监听ws消息事件
     * @param $ws
     * @param $frame
     */
    public function onMessage($ws,$frame){
        echo "set-push-message:{$frame->data}\n";

        $data = [
            'data'=>$frame->data,
            'fd'=>$frame->fd,
        ];
        //投递异步任务
        //注意：程序会继续往下执行，不会等待任务执行完后再继续向下执行
        $ws->task($data);

        //设置定时执行任务(use是swoole一个闭包)
        swoole_timer_after(5000,function () use ($ws,$frame){
           echo "5s-fater\n";
           $ws->push($frame->fd,'server-push:'.date("Y-m-d H:i:s").'--'.$frame->data);
        });
        $ws->push($frame->fd,"server-push:hellow sinWa".date("Y-m-d H:i:s"));
    }

    /**
     * @param $serv
     * @param $task_id
     * @param $src_worker_id
     * @param $data
     * @return string
     */
    public function onTask($serv,$task_id,$src_worker_id,$data){
        print_r($data);
        // 耗时场景 10s
        sleep(10);
        return "on task finish"; // 告诉worker，并返回给onFinish的$data
    }

    /**
     * @param $serv
     * @param $task_id
     * @param $data
     */
    public function onFinish($serv,$task_id,$data){
        echo "taskId:{$task_id}\n";
        echo "finish-data-sucess:{$data}\n";
    }

    /**
     * 监听ws关闭事件
     * @param $ws
     * @param $fd
     */
    public function onClose($ws,$fd){
        echo "clientid:{$fd}\n";
    }
}
$obj = new Ws();