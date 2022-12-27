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
			if ($aksinya == 'cek-tagihan') {
				if (isset($_POST['layanan']) AND isset($_POST['target'])) {
					$layanan = $conn->real_escape_string(trim(filter($_POST['layanan'])));
					$target = $conn->real_escape_string(trim(filter($_POST['target'])));

					if (!$layanan || !$target) {
						$hasilnya = array('status' => false, 'data' => array('pesan' => 'Ups, Permintaan Tidak Sesuai.'));
					} else {

						$cek_layanan = $conn->query("SELECT * FROM layanan_pascabayar WHERE service_id = '$layanan' AND status = 'Normal'");
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
							$provider_id = $data_layanan['provider_id'];

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
                'commands' => "inq-pasca",
            	'username' => $api_id,
            	'buyer_sku_code' => $layanan,
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
		                $order_id = $json_result['data']['ref_id'];
		                $cust_name = $json_result['data']['customer_name'];
		                $admin = $json_result['data']['selling_price'];
		                $tagihan = $admin;
			        }

								$koin = $tagihan * $data_rate_koin['rate'];
								if ($conn->query("INSERT INTO pembelian_pascabayar VALUES ('','$order_id', '$order_id', '$provider_id', '".$datanya['username']."', '".$data_layanan['kategori']."', '".$data_layanan['layanan']."', '$tagihan', '".$data_rate['rate']."', '$koin', '$target', '$cust_name', '-', '-', '-', '-', 'Tagihan Kamu Ditemukan', 'Pending', '$date', '$time', 'API', '$provider', '0')") == true) {
			                        $conn->query("INSERT INTO semua_pembelian VALUES ('','API-$order_id', '$order_id', '".$datanya['username']."', '".$data_layanan['kategori']."', '".$data_layanan['layanan']."', '$tagihan', '$target', 'Pending', '$date', '$time', 'API', '0')");
									$hasilnya = array('status' => true, 'data' => array('id' => $order_id, 'nama_pelanggan' => $cust_name, 'admin' => $tagihan));
									} else {
									$hasilnya = array('status' => false, 'data' => array('pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.'));
								}
							}
						}
					}
				} else {
					$hasilnya = array('status' => false, 'data' => array('pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.'));
				}

			} else if ($aksinya == 'bayar-tagihan') {
				if (isset($_POST['id']) AND isset($_POST['layanan']) AND isset($_POST['target'])) {
				    $order_id = $conn->real_escape_string(trim($_POST['id']));
					$layanan = $conn->real_escape_string(trim(filter($_POST['layanan'])));
					$target = $conn->real_escape_string(trim(filter($_POST['target'])));

					if (!$order_id || !$layanan || !$target) {
						$hasilnya = array('status' => false, 'data' => array('pesan' => 'Ups, Permintaan Tidak Sesuai.'));
					} else {

							$provider = $data_layanan['provider'];
							$provider_id = $data_layanan['provider_id'];

							$cek_pesanan = $conn->query("SELECT * FROM pembelian_pascabayar WHERE user = '".$datanya['username']."' AND oid = '$order_id'");
							$data_pesanan = mysqli_fetch_assoc($cek_pesanan);

							if (mysqli_num_rows($cek_pesanan) == 0) {
								$hasilnya = array('status' => false, 'data' => array('pesan' =>'Ups, Kode Pesanan Kamu Tidak Di Temukan.'));
							} else {

							$order_id = $data_pesanan['oid'];
							$koin = $data_pesanan['koin'];
							$harga = $data_pesanan['harga'];
							$layanan = $data_pesanan['layanan'];
							$provider = $data_pesanan['provider'];

							if ($datanya['saldo_top_up'] < $harga) {
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
                'commands' => "pay-pasca",
            	'username' => $api_id,
            	'buyer_sku_code' => $data_pesanan['id_layanan'],
            	'customer_no' => $data_pesanan['target'],
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
                //print_r($result);

			    if ($provider == "NETFLAZZ" && $json_result['data']['status'] == "Gagal") {
			        $hasilnya = array('status' => false, 'data' => array('pesan' => 'Ups, '.$json_result['data']['message'].''));
			    } else {

			        if ($provider == "NETFLAZZ") {
		                $sn = $json_result['data']['sn'];
			        }

								if ($conn->query("INSERT INTO riwayat_saldo_koin VALUES ('', '".$datanya['username']."', 'Saldo', 'Pengurangan Saldo', '$harga', 'Mengurangi Saldo Top Up Melalui Pemesanan $layanan Dengan Kode Pesanan : API-$order_id', '$date', '$time')") == true) {
									$conn->query("INSERT INTO riwayat_saldo_koin VALUES ('', '".$datanya['username']."', 'Koin', 'Penambahan Koin', '$koin', 'Mendapatkan Koin Melalui Pemesanan $layanan Dengan Kode Pesanan : API-$order_id', '$date', '$time')");
									$conn->query("UPDATE users SET saldo_top_up = saldo_top_up-$harga, pemakaian_saldo = pemakaian_saldo+$harga WHERE username = '".$datanya['username']."'");
									$conn->query("UPDATE pembelian_pascabayar SET status = 'Success', keterangan = '$sn' WHERE oid = '$order_id'");
									$conn->query("UPDATE semua_pembelian SET status = 'Success' WHERE id_pesan = '$order_id'");
									$conn->query("UPDATE users SET koin = koin+$koin WHERE username = '".$datanya['username']."'");
									$hasilnya = array('status' => true, 'data' => array('id' => $order_id, 'status' => 'Success', 'catatan' => $sn));
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

			} else if ($aksinya == 'batalkan') {
				if (isset($_POST['id'])) {
				    $order_id = $conn->real_escape_string(trim($_POST['id']));

					if (!$order_id) {
						$hasilnya = array('status' => false, 'data' => array('pesan' => 'Ups, Permintaan Tidak Sesuai.'));
					} else {

						$cek_pesanan = $conn->query("SELECT * FROM pembelian_pascabayar WHERE user = '".$datanya['username']."' AND oid = '$order_id'");
						$data_pesanan = mysqli_fetch_assoc($cek_pesanan);

						if (mysqli_num_rows($cek_pesanan) == 0) {
							$hasilnya = array('status' => false, 'data' => array('pesan' =>'Ups, Kode Pesanan Kamu Tidak Di Temukan.'));
						} else {

						if ($conn->query("UPDATE pembelian_pascabayar set status = 'Error' WHERE oid = '$order_id'") == true) {
						    $conn->query("UPDATE semua_pembelian set status = 'Error' WHERE id_pesan = '$order_id'");
						    $hasilnya = array('status' => true, 'data' => array('id' => $order_id, 'status' => 'Error'));
							} else {
							$hasilnya = array('status' => false, 'data' => array('pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.'));
						}
					}
				}
				} else {
					$hasilnya = array('status' => false, 'data' => array('pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.'));
				}

			} else if ($aksinya == 'layanan') {
					$cek_layanan = $conn->query("SELECT * FROM layanan_pascabayar ORDER BY service_id ASC");
					while($rows = mysqli_fetch_array($cek_layanan)){
					$hasilnya = "-";
					$this_data[] = array('sid' => $rows['service_id'], 'kategori' => $rows['kategori'], 'layanan' => $rows['layanan'], 'status' => $rows['status'],'tipe' => $rows['tipe']);
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