<?php
    /*import headers*/
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
    <link href="css/styles.css" type="text/css" rel="stylesheet">

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
    Backend testing: <br>
    <form action="register.php" method="post" id="registration">
        <label>E-mail: <input type="text" name="email"></label>
        <label>Password: <input type="text" name="password"></label>
        <label>First Name: <input type="text" name="firstname"></label>
        <button type="submit" class="btn btn-info">Register</button>
    </form>
    <br />
    <br />
    <br />
    <span style="font-size:3em;color:red;">
        <?php
        if(isset($_SESSION["name"])) {
            echo "Hello " . $_SESSION["name"];
        }
        ?>
    </span>
    <br />
    <br />
    <br />
    <form action="login.php" method="post">
        <label>E-mail: <input type="text" name="email"></label>
        <label>Password: <input type="text" name="password"></label>
        <button type="submit" class="btn btn-success">Login</button>
    </form>
    <form action="logout.php"><button type="submit" class="btn btn-danger">Logout</button></form>






    <!-- Javascript Imports Below -->
    <!-- Custom Javascript -->
    <script src="js/ajax.js"></script>
    <script src="js/libs.js"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <!-- End Javascript Imports -->
</body>
</html>
