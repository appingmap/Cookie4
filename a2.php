<?php
include("config.php");
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="utf-8">
</head>
<body>
	<?php
	echo "<a href=\"http://\" onclick=\"myFunction()\">Please login to view more!</a><script>function myFunction(){window.open(\"http://".$hostIP."/cookie4/logins.php\",\"_blank\",\"width=500,height=500\");}</script>";
	?>
</body>
</html>
