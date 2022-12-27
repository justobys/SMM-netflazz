<?php
require_once ("../config.php");
if (isset($_POST['method'])) {
$method = $conn->real_escape_string(filter($_POST['method']));
$cek_rate = $conn->query("SELECT * FROM setting_koin WHERE id = '$method'");
$cek_hasil = $cek_rate->fetch_array();
$menghitung = $cek_hasil['rate'];
echo $menghitung;
}
