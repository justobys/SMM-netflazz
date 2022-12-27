<?php
require("../config.php");

if (isset($_POST['layanan'])) {
	$post_layanan = $conn->real_escape_string(filter($_POST['layanan']));
	$cek_layanan = $conn->query("SELECT * FROM layanan_pulsa WHERE service_id = '$post_layanan' AND status = 'Normal'");
	if (mysqli_num_rows($cek_layanan) == 1) {
		$data_layanan = mysqli_fetch_assoc($cek_layanan);
		$hasil = $data_layanan['harga'];
		echo $hasil;
	} else {
		die("0");
	}
} else {
	die("0");
}