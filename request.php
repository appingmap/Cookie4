<?php

include("config.php");

session_start();

$message = "";
$cookie = "";
$actiontext = "Request";

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == false) {
    $conn->close();
    header("Location: /cookie/index.php");
    exit();
}

if (isset($_GET["action"]) && isset($_GET["id"]) && isset($_GET["cookie"])) {
    $id = $_GET["id"];
    $cookie = $_GET["cookie"];

    if ($_GET["action"] == "go") {
        $actiontext = "Interact";
        $message = requestSession($id, $cookie, false);
    } else if ($_GET["action"] == "check") {
        $actiontext = "Check";
        $message = requestSession($id, $cookie, true);
    } else if ($_GET["action"] == "delete") {
        $actiontext = "Delete";
        $message = deleteSession($id);
    } else {
        $message = "<div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
        <h4 class=\"alert-heading\">Success</h4>
        <hr>
        <p>Bad Request.<br /><a href=\"/cookie4/view.php\" class=\"alert-link\">Return to sessions</a></p>
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
        <span aria-hidden=\"true\">&times;</span></button>
        </div>";
    }
} else {
    $message = "<div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
    <h4 class=\"alert-heading\">Error</h4>
    <hr>
    <p>Bad Request.<br /><a href=\"/cookie4/view.php\" class=\"alert-link\">Return to sessions</a></p>
    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
    <span aria-hidden=\"true\">&times;</span></button>
    </div>";
}

?>

<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Awapt">
    <meta name="description" content="This is the description of the web application.">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Cookie App | Check/Interact</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
    <a class="navbar-brand" href="/cookie4/index.php">Cookie App</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02"
            aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item active">
                <a class="nav-link" href="/cookie4/index.php">Home</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="/cookie4/view.php">View</a>
            </li>
            <li class="nav-item active">
                <?php
                if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {
                    $logintext = "<a class=\"nav-link\" href=\"/cookie4/logout.php\">Logout</a>";
                } else {
                    $logintext = "<a class=\"nav-link\" href=\"/cookie4/login.php\">Login</a>";
                }
                echo $logintext;
                ?>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0" method="GET" action="#">
            <input class="form-control mr-sm-2" type="search" placeholder="Search">
            <button type="submit" class="btn btn-primary my-2 my-sm-0" id="search" name="search">Search</button>
        </form>
    </div>
</nav>
<div class="container">
    <div class="row">
        &nbsp;
    </div>
    <div class="row">
        <p class="display-4"><?php echo $actiontext; ?></p>
        <div class="col-sm-12">
            &nbsp;
        </div>
        <div class="col-sm-12">

        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            &nbsp;
        </div>
        <div class="col">
            &nbsp;
        </div>
        <div class="col-sm-6">
            <?php echo $message;
            $conn->close(); ?>
        </div>
        <div class="col">
            &nbsp;
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>
</html>