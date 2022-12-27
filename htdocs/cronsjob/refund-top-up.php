<?php
require("../config.php");

$check_order = $conn->query("SELECT * FROM pembelian_pulsa WHERE status IN ('Error') AND refund = '0'");

if (mysqli_num_rows($check_order) == 0) {
	die("Pesanan Berstatus Error Tidak Ditemukan.");
} else {
	while($data_order = mysqli_fetch_assoc($check_order)) {
		$o_oid = $data_order['oid'];
		$o_poid = $data_order['provider_oid'];
		$layanan = $data_order['layanan'];

		    $priceone = $data_order['harga'];
		    $refund = $priceone;
		    $buyer = $data_order['user'];

			$update_user = $conn->query("UPDATE users SET saldo_top_up = saldo_top_up+$refund, pemakaian_saldo = pemakaian_saldo+$refund WHERE username = '$buyer'");
			$update_order = $conn->query("INSERT INTO riwayat_saldo_koin VALUES ('', '$buyer', 'Saldo', 'Penambahan Saldo', '$refund', 'Pengembalian Dana Dari Pemesanan $layanan Akibat Status Pesanan Error Dengan Kode Pesanan : $o_oid', '$date', '$time')");
    		$update_order = $conn->query("UPDATE pembelian_pulsa SET refund = '1'  WHERE oid = '$o_oid'");
    		$update_order = $conn->query("UPDATE semua_pembelian SET refund = '1'  WHERE id_pesan = '$o_oid'");
    		if ($update_order == TRUE) {
    			echo "===============<br>Pengembalian Dana Top Up<br><br>Kode Pesanan : $o_oid<br>Nama Pengguna : $buyer<br>Rp $refund<br>===============<br>";
    		} else {
    			echo "Gagal Menampilkan Data Pengembalian Dana Top Up.<br />";
    		}
	}
}
?>