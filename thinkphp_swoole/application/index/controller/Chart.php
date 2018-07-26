<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/25
 * Time: 16:39
 */
namespace app\index\controller;
use think\Db;
use app\common\lib\Util;
class Chart{
    public function index(){
        //接收数据判断
        if(empty($_POST)){
            Util::show(config('code.error'),'data is empty');
        }

        // 登录
        if(empty($_POST['game_id'])) {
            return Util::show(config('code.error'), 'error');
        }
        if(empty($_POST['content'])) {
            return Util::show(config('code.error'), 'error');
        }

        $data = [
            'user' => "用户".rand(0, 2000),
            'content' => $_POST['content'],
        ];
        foreach($_POST['http_server']->ports[1]->connections as $fd) {
            $_POST['http_server']->push($fd, json_encode($data));
        }
    }
}