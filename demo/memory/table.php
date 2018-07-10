<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/10
 * Time: 14:28
 */

//创建一个内存表
$table = new swoole_table(1024);

//设置几个字段
$table->column('id',$table::TYPE_INT,4);
$table->column('name',$table::TYPE_STRING,64);
$table->column('age',$table::TYPE_INT,3);

//进行创建
$table->create();

//设置字段值
$table->set('singwa1', ['id' => 1, 'name' => 'test1', 'age' => 20]);

//另一种设置值的方法
$table['singwa2'] = [
    'id' => 2, 'name' => 'test2', 'age' => 30
];


//获取值
$value = $table->get('singwa1');
var_dump($value);












