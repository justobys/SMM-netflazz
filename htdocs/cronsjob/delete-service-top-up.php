<?php
   require_once("../config.php");

$CallDB = $conn->query("SELECT * FROM layanan_pulsa WHERE server = 'TOP UP'");

if (mysqli_num_rows($CallDB) == 0) {
	die("Data Layanan Top Up Tidak Ditemukan.");
} else {
	while($ThisData = $CallDB->fetch_assoc()) {
		$Provider = $ThisData['provider'];
		if ($conn->query("DELETE FROM layanan_pulsa WHERE provider = '$Provider'") == true) {
			echo "Data Layanan Top Up Berhasil Di Hapus.<br />";
    	} else {
			echo "Gagal Menampilkan Data Layanan Top Up.<br />";
		}
	}
}
?>