<?php
/**
 * Created by PhpStorm.
 * User: 王
 * Date: 2019/9/7
 * Time: 16:09
 */
namespace App\Tools;
class Tools {
    public $redis;
    public function __construct()
    {
        $this->redis = new \Redis();
        $this->redis->connect('127.0.0.1','6379');
    }
}