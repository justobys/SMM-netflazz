<?php
session_start();
require("../config.php");
require("../lib/header.php");  

if (!isset($_SESSION['user'])) {
    $_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Autentikasi Dibutuhkan', 'pesan' => 'Silahkan Login Terlebih Dahulu.');
	exit(header("Location: ".$config['web']['url']."auth/login"));
}else{
    $check_user = $conn->query("SELECT * FROM users WHERE username = '".$_SESSION['user']['username']."'");
    $data_user = $check_user->fetch_assoc();
    $check_username = $check_user->num_rows;
    if ($check_username == 0) {
        exit(header("Location: ".$config['web']['url']."logout.php"));
    } else if ($data_user['status'] == "Tidak Aktif") {
        exit(header("Location: ".$config['web']['url']."logout.php"));
    }
	$sess_username = $_SESSION['user']['username'];
	
    $update_news = $conn->query("UPDATE users SET read_news = '1' WHERE username = '$sess_username'");
}

// if (isset($_POST['layanan'])) {
// 	$post_layanan = $conn->real_escape_string($_POST['layanan']);
// 	$cek_layanan = $conn->query("SELECT * FROM layanan_pulsa WHERE service_id = '$post_layanan' AND status = 'Normal'");
// 	if (mysqli_num_rows($cek_layanan) == 1) {
// 		$data_layanan = mysqli_fetch_assoc($cek_layanan);
// 		$hasil = $data_layanan['harga'];
// 		echo $hasil;
// 	} else {
// 		die("0");
// 	}
// } else {
// 	die("0");
// }