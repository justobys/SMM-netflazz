<?php
require_once ("../config.php");
$nominal = $conn->real_escape_string(filter($_POST['jumlah']));
$cek_rate = $conn->query("SELECT * FROM setting_rate WHERE tipe = 'Saldo OVO Custom'");
$cek_hasil = $cek_rate->fetch_array();
$menghitung = $nominal + $cek_hasil['rate'];
echo ceil($menghitung);
?>