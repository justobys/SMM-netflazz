<?php
require("../config.php");

if (isset($_POST['layanan'])) {
	$post_layanan = $conn->real_escape_string(filter($_POST['layanan']));
	$cek_layanan = $conn->query("SELECT * FROM layanan_sosmed WHERE service_id = '$post_layanan' AND status = 'Aktif'");
	if (mysqli_num_rows($cek_layanan) == 1) {
		$data_layanan = mysqli_fetch_assoc($cek_layanan);
		$result = $data_layanan['harga'] / 1000;
		echo $result;
	} else {
		die("0");
	}
} else {
	die("0");
}