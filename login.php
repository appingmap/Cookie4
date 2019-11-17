<?php

include("config.php");

session_start();

$message = "";

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {
    $conn->close();
    header("Location: /cookie4/view.php");
    exit();
}

if (isset($_POST["login"])) {
    $uname = isset($_POST["uname"]) ? $_POST["uname"] : "";
    $uname = mysqli_real_escape_string($conn, $uname);
    $password = isset($_POST["password"]) ? $_POST["password"] : "";
    $password = mysqli_real_escape_string($conn, $password);

    if ($uname == "" or $password == "") {
        $message = "<div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
        <h4 class=\"alert-heading\">Error</h4>
        <hr>
        <p>Please enter all the fields.<br /><a href=\"/cookie4/signup.php\" class=\"alert-link\">or Sign Up</a></p>
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
        <span aria-hidden=\"true\">&times;</span></button>
        </div>";
    } else {
        $query = "Select * from users where uname = '" . $uname . "'";
        $rows = $conn->query($query);

        if (!$rows) {
            die("Error: " . $conn->error);
        } else {
            $row = $rows->fetch_object();
            if ($row) {
                $uname = $row->uname;
                $passhash = $row->password;
                $salt = $row->salt;
                $password = $password . $salt;
                $password = hash("sha1", $password, false);
                if ($password == $passhash) {
                    session_regenerate_id();
                    $_SESSION["uname"] = $uname;
                    $_SESSION["loggedin"] = true;
                    header("Location: /cookie4/view.php");
                    exit;
                } else {
                    $message = "<div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
                    <h4 class=\"alert-heading\">Error</h4>
                    <hr>
                    <p>Username or password is incorrect.<br /><a href=\"/cookie4/signup.php\" class=\"alert-link\">or Sign Up</a></p>
                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                    <span aria-hidden=\"true\">&times;</span></button>
                    </div>";
                }
            } else {
                $message = "<div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
                <h4 class=\"alert-heading\">Error</h4>
                <hr>
                <p>Username or password is incorrect. <br /><a href=\"/cookie4/signup.php\" class=\"alert-link\">or Sign Up</a></p>
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                <span aria-hidden=\"true\">&times;</span></button>
                </div>";
            }
        }
    }
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
    <title>Cookie App | Login</title>
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
                <a class="nav-link" href="/cookie4/signup.php">SignUp</a>
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
        <p class="display-4">Login</p>
        <div class="col-sm-12">
            &nbsp;
        </div>
        <div class="col-sm-12">
            <form method="POST" action="/cookie4/login.php" id="frmlogin">
                <div class="form-group">
                    <strong><label for="uname">Username</label></strong>
                    <input type="text" class="form-control" id="uname" name="uname" aria-describedby="uname"
                    placeholder="Enter username">
                    <small id="unamehelp" class="form-text text-muted"><em>Username can contain any letters or numbers,
                    without spaces.</em></small>
                </div>
                <div class="form-group">
                    <strong><label for="password">Password</label></strong>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    <small id="password" class="form-text text-muted"><em>Password should be at least 4 characters.</em></small>
                </div>
                <button type="submit" class="btn btn-primary" id="login" name="login">Login</button>
            </form>
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