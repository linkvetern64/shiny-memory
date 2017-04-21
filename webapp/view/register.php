<?php
    require_once(dirname(__FILE__) . '/../load.php');
    session_start();
    $db = new DB();
/**
 * Created by IntelliJ IDEA.
 * User: Josh
 * Date: 10/6/2016
 * Time: 6:40 PM
 */

    //check if any account information exists, if it does kick it back.
    //$db->getName("");

    $username = 'Admin';
    $password = $_POST["password"];

    // A higher "cost" is more secure but consumes more processing power
    $cost = 10;

    // Create a random salt
    $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');

    // Prefix information about the hash so PHP knows how to verify it later.
    // "$2a$" Means we're using the Blowfish algorithm. The following two digits are the cost parameter.
    $salt = sprintf("$2a$%02d$", $cost) . $salt;



    // Hash the password with the salt
    $hash = crypt($password, $salt);
    $_POST["password"] = $hash;


    //sanitize post and send it through
    if($db->submit($_POST)){
        header("Location:home.php");
    }
    else{
        //Kick back with updated webpage displaying detail problems
        header("Location:index.php");
    }

    // Make an ajax call that verifies information on the fly.