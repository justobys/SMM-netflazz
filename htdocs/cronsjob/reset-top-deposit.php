<?php
   require_once("../config.php");

$CallDB = $conn->query("SELECT * FROM top_depo");

if (mysqli_num_rows($CallDB) == 0) {
	die("Data Top 5 Isi Saldo Tidak Ditemukan.");
} else {
	while($ThisData = $CallDB->fetch_assoc()) {
		$Method = $ThisData['method'];
		if ($conn->query("DELETE FROM top_depo WHERE method = '$Method'") == true) {
			echo "Data Top 5 Isi Saldo Berhasil Di Hapus.<br />";
    	} else {
			echo "Gagal Menampilkan Data Top 5 Isi Saldo.<br />";
		}
	}
}
?>