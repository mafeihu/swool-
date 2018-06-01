<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/31
 * Time: 21:10
 */

//使用Task功能，必须先设置 task_worker_num，并且必须设置Server的onTask和onFinish事件回调函数。
class Ws{
    CONST HOST='0.0.0.0';
    CONST PORT=9912;
    public $ws = null;
    public function __construct()
    {
        $this->ws = new swoole_websocket_server(self::HOST,self::PORT);

        //设置请求地址静态页面
        $this->ws->set(
            [
                'enable_static_handler' => true,
                'document_root' => '/www/swoole/data',
                'worker_num' => 2,
                'task_worker_num' => 2,
            ]
        );
        //注册Server的事件回调函数
        $this->ws->on('open',[$this,'onOpen']);
        $this->ws->on('message',[$this,'onMessage']);
        $this->ws->on('task',[$this,'OnTask']);
        $this->ws->on('finish',[$this,'OnFinish']);
        $this->ws->on('close',[$this,'onClose']);

        $this->ws->start();
    }
    /**
    * 监听ws连接事件
    * @param $ws
    * @param $request
    */
    public function onOpen($ws,$request)
    {
        print_r($request->fd);
    }

    /**
     * 监听ws消息事件
     * @param $ws
     * @param $frame
     */
    public function onMessage($ws,$frame)
    {
        echo "ser-push-message:{$frame->data}\n";
        $data = [
            'task' => 1,
            'fd' => $frame->fd,
        ];
        //投递异步任务
        //注意：程序会继续往下执行，不会等待任务执行完后再继续向下执行
        $ws->task($data);
        //客户端会马上收到以下信息
        $ws->push($frame->fd,'server-push'.date("Y-m-d H:i:s"));
    }


    /**
     * @param $serv
     * @param $taskId
     * @param $workerId
     * @param $data
     * @return string
     */
    public function OnTask( $serv, $task_id, $src_worker_id, $data){
        print_r($data);
        // 耗时场景 10s
        sleep(10);
        return "on task finish"; // 告诉worker，并返回给onFinish的$data
    }

    public function OnFinish( $serv, $task_id, $data){
        echo "taskId:{$task_id}\n";
        echo "finish-data-sucess:{$data}\n";
    }

    /**
     * close
     * @param $ws
     * @param $fd
     */
    public function onClose($ws, $fd) {
        echo "clientid:{$fd}\n";
    }
}
$obj = new Ws();