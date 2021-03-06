<?php
class Ws {

    CONST HOST = "0.0.0.0";
    CONST PORT = 9912;
    public $ws = null;
    public function __construct() {
        $this->ws = new swoole_websocket_server(self::HOST, self::PORT);
        //配置静态文件根目录，可选
        $this->ws->set(
            [
            'enable_static_handler' => true,
            'document_root' => "/www/swoole/data",
            ]
        );
        $this->ws->on("open", [$this, 'onOpen']);
        $this->ws->on("message", [$this, 'onMessage']);
        $this->ws->on("close", [$this, 'onClose']);

        $this->ws->start();
    }
    /**
    * 监听ws连接事件
    * @param $ws
    * @param $request
    */
    public function onOpen($ws, $request) {
        print_r($request->fd);
    }

    /**
    * 监听ws消息事件
    * @param $ws
    * @param $frame
    */
    public function onMessage($ws, $frame) {
        echo "ser-push-message:{$frame->data}\n";
        $ws->push($frame->fd, "server-push:".date("Y-m-d H:i:s").'你接收到的信息:'.$frame->data);
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