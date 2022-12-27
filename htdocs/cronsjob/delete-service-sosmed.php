<?php
   require_once("../config.php");

$CallDB = $conn->query("SELECT * FROM layanan_sosmed WHERE tipe = 'SOSIAL MEDIA' AND server = 's1'");

if (mysqli_num_rows($CallDB) == 0) {
	die("Data Layanan Sosial Media Tidak Ditemukan.");
} else {
	while($ThisData = $CallDB->fetch_assoc()) {
		$Provider = $ThisData['provider'];
		if ($conn->query("DELETE FROM layanan_sosmed WHERE provider = 'NETFLAZZ-SMM' AND server = 's1'") == true) {
			echo "Data Layanan Sosial Media Berhasil Di Hapus.<br />";
    	} else {
			echo "Gagal Menampilkan Data Layanan Sosial Media.<br />";
		}
	}
}
?>