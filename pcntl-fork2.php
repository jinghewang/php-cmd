<?php

include_once "inc.php";


for ($i = 0; $i < 10; $i++) {
    $pid = pcntl_fork();

    if ($pid == -1) {
        die('can not fork.');
    } elseif ($pid) {

    } else {
        dummy_business();
        echo 'quit' . $i . PHP_EOL;
        break;
    }
}


function dummy_business(){
    global $host,$db, $user, $password;
    $conn = mysqli_connect($host, $user, $password) or die(mysqli_error());
    mysqli_select_db($conn, $db);
    for ($i = 0; $i < 10000; $i++) {
        $rs = mysqli_query($conn, 'SELECT num FROM rp_counter WHERE id = 1');
        mysqli_free_result($rs);
        $row = mysqli_fetch_array($rs);
        $num = $row[0];
        mysqli_query($conn, "UPDATE rp_counter SET num = {$num} + 1 WHERE id = 1");
    }
    mysqli_close($conn);
}
