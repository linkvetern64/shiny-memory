<?php
session_start();
/**
 * Created by IntelliJ IDEA.
 * User: josh
 * Date: 5/27/16
 * Time: 1:08 PM
 * Desc:
 *   This file is used to import classes globally across files
 *   and initialize the sessions
 */
$classDir = dirname(__FILE__) . "/classes/";

$classes = scandir($classDir);

foreach($classes as $class){
    if(pathinfo($classDir . $class)['extension'] == "php"){
        require_once($classDir . $class);
    }
}
?>
