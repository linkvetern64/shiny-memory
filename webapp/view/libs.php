<?php
/*Written by Josh Standiford*/
require_once(dirname(__FILE__) . '/../load.php');
session_start();



/*
** Desc:
**	Checks the users credentials, and if they're not valid. Redirect them to specified page.
**  Credentials are tracked through session variables and obtained via verifyUser.php
**
*/
function credCheck(){
	session_start();
	if(!$_SESSION["auth"]){
		header("Location:indexed.php");
	}
}