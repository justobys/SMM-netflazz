<?php
require("../config.php");

$check_order = $conn->query("SELECT * FROM pembelian_sosmed WHERE status IN ('Pending','Processing','In Progress')");

if (mysqli_num_rows($check_order) == 0) {
	die("Pesanan Berstatus Pending Tidak Ditemukan.");
} else {
	while ($data_order = mysqli_fetch_assoc($check_order)) {
		$o_oid = $data_order['oid'];
		$o_poid = $data_order['provider_oid'];
		$o_provider = $data_order['provider'];
		$username = $data_order['user'];
		$koin = $data_order['koin'];
		$layanan = $data_order['layanan'];
		if ($o_provider == "MANUAL") {
			echo "Pesanan Manual<br />";
		} else {

			$check_provider = $conn->query("SELECT * FROM provider WHERE code = 'NETFLAZZ-SMM'");
			$data_provider = mysqli_fetch_assoc($check_provider);

			$p_link = $data_provider['link'];
			$p_apikey = $data_provider['api_key'];
			$p_api_id = $data_provider['api_id'];

			$api_postdata = "api_key=$p_apikey&action=status&id=$o_poid";

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $p_link);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $api_postdata);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			$chresult = curl_exec($ch);
			curl_close($ch);
			$json_result = json_decode($chresult, true);
print_r ($json_result);
			if ($json_result['data']['status'] == "Pending") {
				$u_status = "Pending";
			} else if ($json_result['data']['status'] == "Processing") {
				$u_status = "Processing";
			} else if ($json_result['data']['status'] == "Partial") {
				$u_status = "Partial";
			} else if ($json_result['data']['status'] == "Error") {
				$u_status = "Error";
			} else if ($json_result['data']['status'] == "Success") {
				$u_status = "Success";
			} else {
				$u_status = $json_result['data']['status'];
			}

			$u_start = $json_result['data']['start_count'];
			$u_remains = $json_result['data']['remains'];

			if ($u_status == "Success") {
				$update = $conn->query("INSERT INTO riwayat_saldo_koin VALUES ('', '$username', 'Koin', 'Penambahan Koin', '$koin', 'Mendapatkan Koin Melalui Pemesanan $layanan Dengan Kode Pesanan : $o_oid', '$date', '$time')");
				$update = $conn->query("UPDATE users SET koin = koin+$koin WHERE username = '$username'");
			}
			$update_order = $conn->query("UPDATE semua_pembelian SET status = '$u_status' WHERE id_pesan = '$o_oid'");
			$update_order = $conn->query("UPDATE pembelian_sosmed SET status = '$u_status', start_count = '$u_start', remains = '$u_remains' WHERE provider_oid = '$o_poid'");
			if ($update_order == TRUE) {
				echo "===============<br>Berhasil Menampilkan Data Status Sosial Media<br><br>ID Pesanan : $o_oid<br>Start Count : $u_start<br>Remains : $u_remains<br>Status : $u_status<br>===============<br>";
			} else {
				echo "Gagal Menampilkan Data Status Sosial Media.<br />";
			}
		}
	}
}
