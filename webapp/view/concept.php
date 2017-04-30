<?php
/**
 * Created by:
 * User: Josh
 * Date: 4/29/2017
 * Time: 6:58 PM
 */
session_start();
require_once(dirname(__FILE__) . '/../load.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Shiny Memory</title>
    <link rel='shortcut icon' href='img/favicon.ico' type='image/x-icon'/ >

    <!-- Bootstrap Core CSS -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Theme CSS -->
    <!--<link href="css/styles.css" type="text/css" rel="stylesheet">-->
    <link href="css/concept.css" type="text/css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery -->
    <!--<script src="vendor/jquery/jquery.min.js"></script>

    -->

    <!-- AJAX Prototype Import -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js">jQuery.noConflict();</script>
    <script src="https://ajax.googleapis.com/ajax/libs/prototype/1.7.3.0/prototype.js"></script>


    <script type="text/javascript">
        //var JQ = $.noConflict(); //Need JQUERY.NOCONFLICT();  Otherwise prototypes methods will be overwritten
        jQuery(function ($) {
            // The dollar sign will equal jQuery in this scope
            $('.modal')
                .on('show.bs.modal', function() {
                    populate(this.id);
                });
        });

    </script>
</head>
<body>
    <!-- Navbar 54px tall, 12padding top and bottom-->
    <nav class="navbar navbar-inverse navbar-fixed-top nav-custom">
        <div class="col-lg-2">
            <div class="input-group">
                <form action="error.php" method="GET">
                    <!-- Add search, buttons, badges -->
                    <!-- <input type="text" class="form-control" placeholder="Search..."> -->
                </form>
            </div>
        </div>
    </nav>
    <div id="container">
        <!-- Modify action to .php script you want to execute on submit -->
        <form id="login-container" action="" method="POST">
            <!-- Adds title with sub-title -->
            <span class="header-title text-center">Template 1</span>
            <span class="header-sub text-center">Subtext</span>
            <br /><br /><br />

            <!-- -->
            <div class="col-3">
                <input type="text" name="email" class="form-control login-field f-left" placeholder="email">
                <input type="password" name="password" class="form-control login-field f-right" placeholder="password">
            </div>

            <!-- -->
            <span class="EULA"> By signing up you agree to privacy policy and end-user license agreement. </span>

            <!-- -->
            <submit id="sign-up" class="btn btn-success">Sign up</submit>
        </form>
        <div id="apps">
            <a href='http://play.google.com/store/?pcampaignid=MKT-Other-global-all-co-prtnr-py-PartBadge-Mar2515-1' class="img-float f-left"><img alt='Get it on Google Play' class="img-resize" src='https://play.google.com/intl/en_us/badges/images/generic/en_badge_web_generic.png'/></a>
            <a href='' class="img-float f-right"><img alt='Get it on App Store' class="img-resize" src='img/app-store-button.png'/></a>
        </div>
    </div>
</body>