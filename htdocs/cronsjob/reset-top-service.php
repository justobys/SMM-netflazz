<?php
   require_once("../config.php");

$CallDB = $conn->query("SELECT * FROM top_layanan");

if (mysqli_num_rows($CallDB) == 0) {
	die("Data Top 5 Layanan Tidak Ditemukan.");
} else {
	while($ThisData = $CallDB->fetch_assoc()) {
		$Method = $ThisData['method'];
		if ($conn->query("DELETE FROM top_layanan WHERE method = '$Method'") == true) {
			echo "Data Top 5 Layanan Berhasil Di Hapus.<br />";
    	} else {
			echo "Gagal Menampilkan Data Top 5 Layanan.<br />";
		}
	}
}
?>