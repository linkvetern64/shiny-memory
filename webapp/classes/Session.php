<?php
session_start();
/**
 * Created by IntelliJ IDEA.
 * User: josh
 * Date: 6/9/16
 * Time: 11:58 AM
 */
class Session {

    function Session(){

    }

    function push($item){
        array_push($_SESSION, $item);
    }

    function clear(){
        $_SESSION = array();
    }

    public static function printArray(){
        foreach($_SESSION as $k){
            echo "<br>" . $k ;
        }
    }
}
