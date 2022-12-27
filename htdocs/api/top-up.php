<?php
require '../config.php';
header('Content-Type: application/json');
if ($maintenance == 1) {
	$hasilnya = array('status' => false, 'data' => array('pesan' => 'Maintenance'));
	exit(json_encode($hasilnya, JSON_PRETTY_PRINT));
}
if (isset($_POST['api_key']) AND isset($_POST['action'])) {
	$apinya = $conn->real_escape_string($_POST['api_key']);
	$aksinya = $_POST['action'];

	if (!$apinya || !$aksinya) {
		$hasilnya = array('status' => false, 'data' => array('pesan' => 'Ups, Permintaan Tidak Sesuai.'));

	} else {
		$cek_usernya = $conn->query("SELECT * FROM users WHERE api_key = '$apinya'");
		$datanya = $cek_usernya->fetch_assoc();
		if (mysqli_num_rows($cek_usernya) == 1) {
			if ($aksinya == 'pemesanan') {
				if (isset($_POST['layanan']) AND isset($_POST['target'])) {
					$layanan = $conn->real_escape_string(trim(filter($_POST['layanan'])));
					$target = $conn->real_escape_string(trim(filter($_POST['target'])));

					if (!$layanan || !$target) {
						$hasilnya = array('status' => false, 'data' => array('pesan' => 'Ups, Permintaan Tidak Sesuai.'));
					} else {

						$cek_layanan = $conn->query("SELECT * FROM layanan_pulsa WHERE service_id = '$layanan' AND status = 'Normal'");
						$data_layanan = $cek_layanan->fetch_assoc();

						$cek_rate = $conn->query("SELECT * FROM setting_rate WHERE tipe = 'Top Up'");
						$data_rate = mysqli_fetch_assoc($cek_rate);

						$cek_rate_koin = $conn->query("SELECT * FROM setting_koin_didapat WHERE status = 'Aktif'");
						$data_rate_koin = mysqli_fetch_assoc($cek_rate_koin);

						if (mysqli_num_rows($cek_layanan) == 0) {
							$hasilnya = array('status' => false, 'data' => array('pesan' =>'Ups, Layanan Tidak Tersedia.'));
						} else {

							$order_id = acak_nomor(3).acak_nomor(4);
							$provider = $data_layanan['provider'];
							$koin = $data_layanan['harga_api'] * $data_rate_koin['rate'];

							 if ($datanya['saldo_top_up'] < $data_layanan['harga_api']) {
								$hasilnya = array('status' => false, 'data' => array('pesan' =>'Ups, Saldo Top Up Kamu Tidak Mencukupi Untuk Melakukan Pemesanan Via API.'));
							} else {

								$cek_provider = $conn->query("SELECT * FROM provider_pulsa WHERE code = '$provider'");
								$data_provider = $cek_provider->fetch_assoc();

		    $api_link = $data_provider['link'];
		    $api_key = $data_provider['api_key'];
		    $api_id = $data_provider['api_id'];

		    if ($provider == "MANUAL") {
			    $api_postdata = "";
		    } else if ($provider == "NETFLAZZ") {
		    $sign = md5($api_id.$api_key.$order_id);
            $api_postdata = array( 
            	'username' => $api_id,
            	'buyer_sku_code' => $data_layanan['provider_id'],
            	'customer_no' => "$target",
            	'ref_id' => $order_id,
            	'sign' => $sign
            );
            $header = array(
                'Content-Type: application/json',
            );
			} else {
				die("System Error!");
			}

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $api_link);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($api_postdata));
                $chresult = curl_exec($ch);
                curl_close($ch);
                $json_result = json_decode($chresult, true);
                $result = json_decode($chresult);
                // print_r($result);

			    if ($provider == "NETFLAZZ" && $json_result['data']['status'] == "Gagal") {
			        $hasilnya = array('status' => false, 'data' => array('pesan' => 'Ups, '.$json_result['data']['message'].''));
			    } else {

			        if ($provider == "NETFLAZZ") {
		                $provider_oid = $order_id;
			        }

									if ($conn->query("INSERT INTO pembelian_pulsa VALUES ('','API-$order_id', '$provider_oid', '".$datanya['username']."', '".$data_layanan['layanan']."', '".$data_layanan['harga_api']."', '".$data_rate['rate']."', '$koin', '$target', '', 'Pending', '$date', '$time', 'API', '$provider', '0')") == true) {
										$conn->query("UPDATE users SET saldo_top_up = saldo_top_up-".$data_layanan['harga_api'].", pemakaian_saldo = pemakaian_saldo+".$data_layanan['harga_api']." WHERE username = '".$datanya['username']."'");
										$conn->query("INSERT INTO riwayat_saldo_koin VALUES ('', '".$datanya['username']."', 'Saldo', 'Pengurangan Saldo', '".$data_layanan['harga_api']."', 'Mengurangi Saldo Top Up Melalui Pemesanan Top Up Via API Dengan Kode Pesanan : API-$order_id', '$date', '$time')");
			                            $conn->query("INSERT INTO semua_pembelian VALUES ('','API-$order_id', '$order_id', '".$datanya['username']."', '".$data_layanan['kategori']."', '".$data_layanan['layanan']."', '".$data_layanan['harga_api']."', '$target', 'Pending', '$date', '$time', 'API', '0')");
										$hasilnya = array('status' => true, 'data' => array('id' => $order_id));
										} else {
										$hasilnya = array('status' => false, 'data' => array('pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.'));
									}
								}
							}
						}
					}
				} else {
					$hasilnya = array('status' => false, 'data' => array('pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.'));
				}

			} else if ($aksinya == 'status') {
				if (isset($_POST['id'])) {
					$order_id = $conn->real_escape_string(trim($_POST['id']));
					$cek_pesanan = $conn->query("SELECT * FROM pembelian_pulsa WHERE oid = '$order_id' AND user = '".$datanya['username']."'");
					$data_pesanan = mysqli_fetch_array($cek_pesanan);

					if (mysqli_num_rows($cek_pesanan) == 0) {
						$hasilnya = array('status' => false, 'data' => array('pesan' => 'Ups, Kode Pesanan Kamu Tidak Di Temukan.'));
					} else {
						$hasilnya = array('status' => true, 'data' => array("id" => $data_pesanan['oid'], 'status' => $data_pesanan['status'], 'catatan' => $data_pesanan['keterangan']));
					}
				} else {
					$hasilnya = array('status' => false, 'data' => array('pesan' => 'Ups, Permintaan Tidak Sesuai.'));
				}

			} else if ($aksinya == 'layanan') {
					$cek_layanan = $conn->query("SELECT * FROM layanan_pulsa ORDER BY service_id ASC");
					while($rows = mysqli_fetch_array($cek_layanan)){
					$hasilnya = "-";
					$this_data[] = array('sid' => $rows['service_id'], 'operator' => $rows['operator'], 'layanan' => $rows['layanan'], 'harga' => $rows['harga_api'],'status' => $rows['status'],'tipe' => $rows['tipe']);
                }
					$hasilnya = array('status' => true, 'data' => $this_data);
			} else {
				$hasilnya = array('status' => false, 'data' => array('pesan' => 'Ups, Permintaan Salah.'));
			}
		} else {
			$hasilnya = array('status' => false, 'data' => array('pesan' => 'Ups, Api Key Kamu Salah.'));
		}
	}
} else {
	$hasilnya = array('status' => false, 'data' => array('pesan' => 'Ups, Permintaan Tidak Sesuai.'));
}

print(json_encode($hasilnya, JSON_PRETTY_PRINT));