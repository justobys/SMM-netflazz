<?php
   require_once("../config.php");

$CallDB = $conn->query("SELECT * FROM cek_akun WHERE tipe = 'TOP UP'");

if (mysqli_num_rows($CallDB) == 0) {
	die("Data Informasi Akun Top Up Tidak Ditemukan.");
} else {
	while($ThisData = $CallDB->fetch_assoc()) {
		$Provider = $ThisData['provider'];
		if ($conn->query("DELETE FROM cek_akun WHERE provider = '$Provider'") == true) {
			echo " Data Informasi Akun Top Up Berhasil Dihapus.<br />";
    	} else {
			echo "Gagal Menampilkan Data Informasi Akun Top Up.<br />";
		}
	}
}
?>