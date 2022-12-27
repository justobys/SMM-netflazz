<?php
date_default_timezone_set('Asia/Jakarta');
error_reporting(0);
$maintenance = 0; // Maintenance? 1 = ya 0 = tidak
if($maintenance == 1) {
    die("site Maintance");
}
// database
$config['db'] = array(
	'host' => 'sql307.epizy.com',
	'name' => 'epiz_33265989_smm',
	'username' => 'epiz_33265989',
	'password' => 'J1gs5VbsqHS'
);

mysqli_real_escape_string($conn = mysqli_connect($config['db']['host'], $config['db']['username'], $config['db']['password'], $config['db']['name']));
if(!$conn) {
	die("Koneksi Gagal : ".mysqli_connect_error());
	}
$config['web'] = array(
	'url' => 'https://sosmed.me/' // contoh: http://domain.com/
);
// date & time
$date = date("Y-m-d");
$time = date("H:i:s");
require("lib/function.php");
require("lib/setting.php");
?>