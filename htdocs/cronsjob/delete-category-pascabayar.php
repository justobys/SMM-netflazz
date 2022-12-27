<?php
   require_once("../config.php");

$CallDB = $conn->query("SELECT * FROM kategori_layanan WHERE tipe = 'Pascabayar'");

if (mysqli_num_rows($CallDB) == 0) {
	die("Data Kategori Pascabayar Tidak Ditemukan.");
} else {
	while($ThisData = $CallDB->fetch_assoc()) {
		if ($conn->query("DELETE FROM kategori_layanan WHERE tipe = 'Pascabayar'") == true) {
			echo "Data Kategori Pascabayar Berhasil Di Hapus.<br />";
    	} else {
			echo "Gagal Menampilkan Data Kategori Pascabayar.<br />";
		}
	}
}
?>