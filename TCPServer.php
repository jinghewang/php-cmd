<?php
/**
 * Created by PhpStorm.
 * User: hbd
 * Date: 2017/3/2
 * Time: 下午12:36
 */

$serv = new swoole_server("127.0.0.1", 9511);


$serv->on('start', function ($serv){
    echo "start\n";
});


$serv->on('connect', function ($serv, $fd){
    echo "Client：connect:$fd\n";
    $serv->tick(2000, function() use ($serv, $fd) {
        $msg = "这是一条定时消息". time() ."\n";
        echo $msg;
        //$serv->send($fd, $msg);

        foreach($serv->connections as $tempFD)
        {
            $serv->send($tempFD,"有新用户加入---1 for apple\n");
        }

    });
});


$serv->on('receive', function ($serv, $fd, $from_id, $data) {

    echo "receive :fd: $fd,from_id: $from_id,data: $data";

    //根据收到的消息做出不同的响应
    switch($data)
    {
        case 1:
        {
            foreach($serv->connections as $tempFD)
            {
                $serv->send($tempFD,"1 for apple\n");
            }
            break;
        }
        case 2:
        {
            $serv->send($fd,"2 for boy\n");
            break;
        }
        default:
        {
            $serv->send($fd,"Others is default\n");
        }
    }
});

$serv->on('close', function ($serv, $fd) {
    echo "Client: Close.\n";
});
$serv->start();