<?php
require("../config.php");

$check_order = $conn->query("SELECT * FROM pembelian_sosmed WHERE status IN ('Error','Partial') AND refund = '0'");

if (mysqli_num_rows($check_order) == 0) {
	die("Pesanan Berstatus Error Atau Partial Tidak Ditemukan.");
} else {
	while($data_order = mysqli_fetch_assoc($check_order)) {
		$o_oid = $data_order['oid'];
		$o_poid = $data_order['provider_oid'];
		$u_remains = $data_order['remains'];
		$layanan = $data_order['layanan'];

		    $priceone = $data_order['harga'] / $data_order['jumlah'];
		    $refund = $priceone * $u_remains;
		    $buyer = $data_order['user'];
		    if ($u_remains == 0) {
		        $refund = $data_order['harga'];
		    }

			$update_user = $conn->query("UPDATE users SET saldo_sosmed = saldo_sosmed+$refund, pemakaian_saldo = pemakaian_saldo+$refund WHERE username = '$buyer'");
			$update_order = $conn->query("INSERT INTO riwayat_saldo_koin VALUES ('', '$buyer', 'Saldo', 'Penambahan Saldo', '$refund', 'Pengembalian Dana Dari Pemesanan $layanan Akibat Status Pesanan Error/Partial Dengan Kode Pesanan : $o_oid', '$date', '$time')");
    		$update_order = $conn->query("UPDATE pembelian_sosmed SET refund = '1'  WHERE oid = '$o_oid'");
    		$update_order = $conn->query("UPDATE semua_pembelian SET refund = '1'  WHERE id_pesan = '$o_oid'");
    		if ($update_order == TRUE) {
    			echo "===============<br>Pengembalian Dana Sosial Media<br><br>Kode Pesanan : $o_oid<br>Nama Pengguna : $buyer<br>Rp $refund<br>===============<br>";
    		} else {
    			echo "Gagal Menampilkan Data Pengembalian Dana Sosial Media.<br />";
    		}
	}
}