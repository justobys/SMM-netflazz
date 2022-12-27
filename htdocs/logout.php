<?php
session_start();
require("config.php");

$insert_user = $conn->query("INSERT INTO aktifitas VALUES ('', '".$_SESSION['user']['username']."', 'Keluar', '".get_client_ip()."', '$date', '$time')");
if ($insert_user == TRUE) {
unset($_SESSION['user']);
unset($_COOKIE['cookie_token']);
setcookie("cookie_token",'');
exit(header("Location: ".$config['web']['url']."auth/login"));
}
				