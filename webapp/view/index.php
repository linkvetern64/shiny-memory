<?php
    /*import headers*/
    session_start();
    require_once(dirname(__FILE__) . '/../load.php');
    //date_default_timezone_set('America/New_York');

    echo "Testing database\n<br>";

    $db = new DB();

    $result = $db->test();
    foreach ($result as $k => $v) {
        echo($v["ID"] . " " . $v["mood"] . " " . $v["timestamp"] . "<br />");
    }
?>