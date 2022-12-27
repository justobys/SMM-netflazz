<?php
	require("../config.php");

	$check_order = $conn->query("SELECT * FROM pembelian_pulsa WHERE status IN ('Pending')");

	if (mysqli_num_rows($check_order) == 0) {
	  die("Pesanan Berstatus Pending Tidak Ditemukan.");
	} else {
	  while($data_order = mysqli_fetch_assoc($check_order)) {
	    $o_oid = $data_order['oid'];
	    $o_poid = $data_order['provider_oid'];
	    $o_provider = $data_order['provider'];
	    $username = $data_order['user'];
	    $koin = $data_order['koin'];
	    $layanan = $data_order['layanan'];
	    $provider = $data_order['provider'];
	  if ($o_provider == "MANUAL") {
	    echo "Pesanan Manual<br />";
	  } else {

        $getService = $conn->query("SELECT * FROM layanan_pulsa WHERE layanan = '$layanan' AND provider = '$provider'");
        $getDataService = mysqli_fetch_assoc($getService);

		$check_provider = $conn->query("SELECT * FROM provider_pulsa WHERE code = 'NETFLAZZ-PPOB'");
		$data_provider = mysqli_fetch_assoc($check_provider);

		$p_apikey = $data_provider['api_key'];
		$p_api_id = $data_provider['api_id'];
        $p_link = $data_provider['link'];
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

        $sn = $json_result['data']['sn'];
        $status = $json_result['data']['status'];


	    if ($status == "Success") {
	      $update_order = $conn->query("INSERT INTO riwayat_saldo_koin VALUES ('', '$username', 'Koin', 'Penambahan Koin', '$koin', 'Mendapatkan Koin Melalui Pemesanan $layanan Dengan Kode Pesanan : $o_oid', '$date', '$time')");
	      $update_order = $conn->query("UPDATE users SET koin = koin+$koin WHERE username = '$username'");
	    }
	    $update_order = $conn->query("UPDATE semua_pembelian SET status = '$status' WHERE id_pesan = '$o_oid'");
	    $update_order = $conn->query("UPDATE pembelian_pulsa SET status = '$status', keterangan = '$sn' WHERE oid = '$o_oid'");
	    if ($update_order == TRUE) {
	      echo "===============<br>Berhasil Menampilkan Data Status Top Up<br><br>ID Pesanan : $o_oid<br>Keterangan : $sn<br>Status : $status<br>===============<br>";
	    } else {
	      echo "Gagal Menampilkan Data Status Top Up.<br />";
	    }
	  }
	}
  }
?>