<?php
   require_once("../config.php");

$CallDB = $conn->query("SELECT * FROM kategori_layanan WHERE tipe = 'Top Up'");

if (mysqli_num_rows($CallDB) == 0) {
	die("Data Kategori Top Up Tidak Ditemukan.");
} else {
	while($ThisData = $CallDB->fetch_assoc()) {
		if ($conn->query("DELETE FROM kategori_layanan WHERE tipe = 'Top Up'") == true) {
			echo "Data Kategori Top Up Berhasil Di Hapus.<br />";
    	} else {
			echo "Gagal Menampilkan Data Kategori Top Up.<br />";
		}
	}
}
?>