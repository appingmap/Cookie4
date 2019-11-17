<?php
// Database server connection settings
$dbserver = "localhost"; //DB server address
$dbname = "cookie"; //DB name
$dbuser = "root"; //DB username
$dbpassword = ""; //DB password

// Connects to the DB server
$conn = new mysqli($dbserver, $dbuser, $dbpassword, $dbname);

// Checks the server connection
if ($conn->connect_error) {
    die("Connection error: " . $conn->connect_error);
}

function generateRandomString()
{
    $length = 4;
    $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function decodeCookie($cookie)
{
    return base64_decode($cookie);
}

function getHeaders()
{
    $request = "";
    $method = isset($_SERVER["REQUEST_METHOD"]) ? $_SERVER["REQUEST_METHOD"] : "Unknown";
    $uri = isset($_SERVER["REQUEST_URI"]) ? $_SERVER["REQUEST_URI"] : "Unknown";
    $protocol = isset($_SERVER["SERVER_PROTOCOL"]) ? $_SERVER["SERVER_PROTOCOL"] : "Unknown";
    $firstline = $method . " " . $uri . " " . $protocol . "<br />";
    $request .= $firstline;

    foreach (getallheaders() as $name => $value) {
        $request .= "$name: $value<br />";
    }
    return $request;
}

function requestSession($id, $cookie, $action)
{
    if ($action == true)
        $curlreturntransfer = true;
    else
        $curlreturntransfer = false;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://192.168.204.130/bWAPP/portal.php"); //IP address of beebox
    //curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, $curlreturntransfer);
    curl_setopt($ch, CURLOPT_NOBODY, false);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:68.0) Gecko/20100101 Firefox/68.0");
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_FAILONERROR, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
        "Accept-Language: en-US,en;q=0.5",
        "Accept-Encoding: gzip, deflate",
        "Referrer: http://192.168.204.130/bWAPP/login.php",
        "Connection: keep-alive",
        "Cookie: " . $cookie,
        "Cache-Control: max-age=0"
    ));
    //curl_setopt($ch, CURLOPT_VERBOSE, true);

    $output = curl_exec($ch);

    if (curl_errno($ch)) {
        echo "cURL error: " . curl_error($ch);
    } else {
        $code = @curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($code == "200") {
            $query = "Update cookies Set State = 2 where Id = '" . $id . "'";
            $rows = $GLOBALS["conn"]->query($query);
            if (!$rows) {
                die("Error: " . $conn->error);
            }
            $message = "<div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
            <h4 class=\"alert-heading\">Success</h4>
            <hr>
            <p>Live Session.<br /><a href=\"/cookie4/view.php\" class=\"alert-link\">Return to sessions</a></p>
            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
            <span aria-hidden=\"true\">&times;</span></button>
            </div>";
        } else {
            $query = "Update cookies Set State = 3 where Id = '" . $id . "'";
            $rows = $GLOBALS["conn"]->query($query);
            if (!$rows) {
                die("Error: " . $conn->error);
            }
            $message = "<div class=\"alert alert-info alert-dismissible fade show\" role=\"alert\">
            <h4 class=\"alert-heading\">Info</h4>
            <hr>
            <p>Expired Session.<br /><a href=\"/cookie4/view.php\" class=\"alert-link\">Return to sessions</a></p>
            <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
            <span aria-hidden=\"true\">&times;</span></button>
            </div>";
        }
    }
    curl_close($ch);
    return $message;
}

function deleteSession($id)
{
    $query = "Delete from cookies where Id = '" . $id . "'";
    $rows = $GLOBALS["conn"]->query($query);
    if (!$rows) {
        die("Error: " . $conn->error);
    }
    $message = "<div class=\"alert alert-info alert-dismissible fade show\" role=\"alert\">
    <h4 class=\"alert-heading\">Info</h4>
    <hr>
    <p>Session <em>#" . $id . "</em> is deleted.<br /><a href=\"/cookie4/view.php\" class=\"alert-link\">Return to sessions</a></p>
    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
    <span aria-hidden=\"true\">&times;</span></button>
    </div>";
    return $message;
}

?>