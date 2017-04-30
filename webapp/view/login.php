<?php
/**
 * Created by IntelliJ IDEA.
 * User: Joshua Standiford
 * Date: 10/6/2016
 *
 */
require_once(dirname(__FILE__) . '/../load.php');
session_start();
$db = new DB();
//Parse and flush $_POST !!!!!
$pass = $db->authorize($_POST["email"], $_POST["password"]);
$_SESSION["auth"] = false;

if (hash_equals($pass, crypt($_POST["password"], $pass))) {
    $_SESSION["auth"] = true;
}



if($_SESSION["auth"]){
    $_SESSION["name"] = $db->getName($_POST["email"]);
    $_SESSION["email"] = $_POST["email"];
    $_SESSION["wrongPass"] = false;
    header("Location:index.php");
}
else{
    $_SESSION["wrongPass"] = true;
    //Redirect to error page
    header("Location:index.php");
}

