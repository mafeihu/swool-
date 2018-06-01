<?php
class AsyncMySql{
    public $dbSource = '';
    /**
     * mysql连接配置参数
     * @var array
     */
    public $dbConfig = [];

    public function __construct()
    {
        //new swool_mysql
        $this->dbSource = new swoole_mysql;

        //设置配置参数
        $this->dbConfig = [
            'host' => '192.168.199.136',
            'port' => 3306,
            'user' => 'root',
            'password' => 'mfh0828',
            'database' => 'test',
            'charset' => 'utf8', //指定字符集
            'timeout' => 2,  // 可选：连接超时时间（非查询超时时间），默认为SW_MYSQL_CONNECT_TIMEOUT（1.0）
        ];
    }


    public function execute($id,$username){
        $this->dbSource->connect($this->dbConfig,function ($db,$result) use($id,$username){
            echo 'mysql-connect'.PHP_EOL;
            //连接失败获取错误信息
            if($result === false){
                var_dump($db->connect_error);
            }

            //sql
            $sql  = $sql = 'select * from runoob_tbl';
            // query (add select update delete)
            $db->query($sql,function ($db,$result)
            {
               if($result === false)
               {
                    var_dump($db->error);
               }
               elseif ($result === true)
               {
                   //add update delete
                   var_dump($db->affected_row);
               }
               else
               {
                   print_r($result);
               }
               $db->close();
            });
        });
        return true;
    }
}

$obj  = new AsyncMySql();
$flag = $obj->execute(1,'ceshi');
var_dump($flag).PHP_EOL;
echo 'start'.PHP_EOL;