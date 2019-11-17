<?php
include("config.php");

session_start();

$message = "";

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {
    $conn->close();
    header("Location: /cookie4/view.php");
    exit();
}

if (isset($_POST["signup"])) {
    $uname = isset($_POST["uname"]) ? $_POST["uname"] : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";
    $passwordconf = isset($_POST["passwordconf"]) ? $_POST["passwordconf"] : "";
    $salt = generateRandomString();

    if ($uname == "" or $password == "" or $passwordconf == "") {
        $message = "<div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
        <h4 class=\"alert-heading\">Error</h4>
        <hr>
        <p>Please enter all the fields.<br /><a href=\"/cookie4/login.php\" class=\"alert-link\">or Login</a></p>
        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
        <span aria-hidden=\"true\">&times;</span></button>
        </div>";
    } else {
        if (preg_match("/^[a-z\d_]{2,20}$/i", $uname) == false) {
            $message = "<div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
            <h4 class=\"alert-heading\">Error</h4>
            <hr>
            <p>Please choose a valid user name.<br /><a href=\"/cookie4/login.php\" class=\"alert-link\">or Login</a></p>
            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
            <span aria-hidden=\"true\">&times;</span></button>
            </div>";
        } else {
            if ($password != $passwordconf) {
                $message = "<div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
                <h4 class=\"alert-heading\">Error</h4>
                <hr>
                <p>The passwords don't match.<br /><a href=\"/cookie4/login.php\" class=\"alert-link\">or Login</a></p>
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                <span aria-hidden=\"true\">&times;</span></button>
                </div>";
            } else {
                $uname = mysqli_real_escape_string($conn, $uname);
                $uname = htmlspecialchars($uname, ENT_QUOTES, "UTF-8");
                $password = mysqli_real_escape_string($conn, $password);
                $password = $password . $salt;
                $password = hash("sha1", $password, false);

                $query = "Select * from users where uname = '" . $uname . "'";
                $rows = $conn->query($query);

                if (!$rows) {
                    die("Error: " . $conn->error);
                }

                $row = $rows->fetch_object();
                if (!$row) {
                    $query = "Insert into users values ('', '" . $uname . "', '" . $password . "', '" . $salt . "')";
                    $rows = $conn->query($query);

                    if (!$rows) {
                        die("Error: " . $conn->error);
                    }
                    $conn->close();
                    $message = "<div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
                    <h4 class=\"alert-heading\">Success</h4>
                    <hr>
                    <p>The user is created. Go to <a href=\"/cookie4/login.php\" class=\"alert-link\">Login page</a> to log in.</p>
                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                    <span aria-hidden=\"true\">&times;</span></button>
                    </div>";
                } else {
                    $message = "<div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
                    <h4 class=\"alert-heading\">Error</h4>
                    <hr>
                    <p>The user already exists.<br /><a href=\"/cookie4/login.php\" class=\"alert-link\">or Login</a></p>
                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                    <span aria-hidden=\"true\">&times;</span></button>
                    </div>";
                }
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
    <title>Cookie App | Register</title>
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
                <a class="nav-link" href="/cookie4/login.php">Login</a>
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
        <p class="display-4">Sign Up</p>
        <div class="col-sm-12">
            &nbsp;
        </div>
        <div class="col-sm-12">
            <form method="POST" action="/cookie4/signup.php" id="frmsignup" name="frmsignup">
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
                <div class="form-group">
                    <strong><label for="password">Password Confirmation</label></strong>
                    <input type="password" class="form-control" id="passwordconf" name="passwordconf"
                           placeholder="Confirm password">
                    <small id="passwordconf" class="form-text text-muted"><em>Please confirm your password.</em></small>
                </div>
                <button type="submit" class="btn btn-primary" id="signup" name="signup">Sign Up</button>
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
            <?php echo $message; ?>
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