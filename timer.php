<?php
/**
 * Created by PhpStorm.
 * User: hbd
 * Date: 2017/7/23
 * Time: 下午9:41
 */

$user_param = [123,456];

swoole_timer_tick(1000, function($timer_id,$params){
    print_r($timer_id);
    print_r($params);
},$user_param);