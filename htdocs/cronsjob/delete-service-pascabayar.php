<?php
   require_once("../config.php");

$CallDB = $conn->query("SELECT * FROM layanan_pascabayar WHERE tipe = 'PASCABAYAR'");

if (mysqli_num_rows($CallDB) == 0) {
	die("Data Layanan Pascabayar Tidak Ditemukan.");
} else {
	while($ThisData = $CallDB->fetch_assoc()) {
		$Provider = $ThisData['provider'];
		if ($conn->query("DELETE FROM layanan_pascabayar WHERE provider = '$Provider'") == true) {
			echo "Data Layanan Pascabayar Berhasil Di Hapus.<br />";
    	} else {
			echo "Gagal Menampilkan Data Layanan Pascabayar.<br />";
		}
	}
}
?>