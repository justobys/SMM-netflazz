<?php
session_start();
require '../config.php';
require '../lib/session_user.php';
require '../lib/session_login.php';

		if (isset($_GET['kode'])) {
			$kode = filter($_GET['kode']);

			$cek_tagihan = $conn->query("SELECT * FROM pembelian_pascabayar WHERE oid = '$kode' AND user = '$sess_username'");
			$data_tagihan = mysqli_fetch_assoc($cek_tagihan);

	        if ($data_tagihan['status'] == "Pending") {
	            $label = "warning";
	        } else if ($data_tagihan['status'] == "Error") {
	            $label = "danger";     
	        } else if ($data_tagihan['status'] == "Success") {
	            $label = "success";    
	        }

			if ($cek_tagihan->num_rows == 0) {
				header("Location: ".$config['web']['url']."order/pdam");
			} else {

			$cek_pesanan_pln = $conn->query("SELECT * FROM pembelian_pascabayar WHERE user = '$sess_username' AND oid = '$kode'");
			$data_pesanan = mysqli_fetch_assoc($cek_pesanan_pln);

			$order_id = $data_pesanan['oid'];
			$koin = $data_pesanan['koin'];
			$harga = $data_pesanan['harga'];
			$layanan = $data_pesanan['layanan'];
			$provider = $data_pesanan['provider'];

			$cek_provider = $conn->query("SELECT * FROM provider_pulsa WHERE code = '$provider'");
			$data_provider = mysqli_fetch_assoc($cek_provider);

	    if (isset($_POST['confirm'])) {

			if (mysqli_num_rows($cek_provider) == 0) {
				$_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Server Kami Sedang Maintance.<script>swal("Ups Gagal!", "Server Kami Sedang Maintance.", "error");</script>');

			} else if ($data_user['saldo_top_up'] < $harga) {
				$_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Yahh, Saldo Top Up Kamu Tidak Mencukupi Untuk Melakukan Pemesanan Ini.<script>swal("Yahh Gagal!", "Saldo Top Up Kamu Tidak Mencukupi Untuk Melakukan Pemesanan Ini.", "error");</script>');

			} else {

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
		            $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, '.$json_result['data']['message']);
			    } else {

			        if ($provider == "NETFLAZZ") {
		                $sn = $json_result['data']['sn'];
			        }

				if ($conn->query("INSERT INTO history_saldo VALUES ('', '$sess_username', 'Saldo', 'Pengurangan Saldo', '$harga', 'Mengurangi Saldo Top Up Melalui Pemesanan $layanan Dengan Kode Pesanan : WEB-$order_id', '$date', '$time')") == true) {
				    $conn->query("UPDATE users SET saldo_top_up = saldo_top_up-$harga, pemakaian_saldo = pemakaian_saldo+$harga WHERE username = '$sess_username'");
					$conn->query("UPDATE users SET koin = koin+$koin WHERE username = '$sess_username'");
					$conn->query("UPDATE pembelian_pascabayar SET status = 'Success', keterangan = '$sn' WHERE oid = '$order_id'");
					$conn->query("UPDATE semua_pembelian SET status = 'Success' WHERE id_pesan = '$order_id'");
						$_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip, Tagihan Kamu Sudah Dibayar.');
					} else {
						$_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.<script>swal("Ups Gagal!", "Sistem Kami Sedang Mengalami Gangguan.", "error");</script>');
					}
			    }
			}

		} else if (isset($_POST['cancel'])) {
		    $post_kode = $conn->real_escape_string(filter($_POST['cancel']));

		    $cek_order = $conn->query("SELECT * FROM pembelian_pascabayar WHERE oid = '$post_kode'");
		    $data_order = mysqli_fetch_assoc($cek_order);

		    if (mysqli_num_rows($cek_order) == 0) {
		        $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Tagihanmu Tidak Di Temukan.<script>swal("Ups Gagal!", "Tagihanmu Tidak Di Temukan.", "error");</script>');
		    } else if ($data_order['status'] !== "Pending") {
		        $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Tagihanmu Gak Bisa Dibatalkan.<script>swal("Ups Gagal!", "Tagihanmu Gak Bisa Dibatalkan.", "error");</script>');
		    } else {

		    $update = $conn->query("UPDATE pembelian_pascabayar set status = 'Error' WHERE oid = '$post_kode'");
		    $update = $conn->query("UPDATE semua_pembelian set status = 'Error' WHERE id_pesan = '$post_kode'");
		    if ($update == TRUE) {
		        $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip! Tagihanmu Berhasil Di Batalkan.<script>swal("Berhasil!", "Tagihanmu Berhasil Di Batalkan.", "success");</script>');
		    } else {
				$_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.<script>swal("Ups Gagal!", "Sistem Kami Sedang Mengalami Gangguan.", "error");</script>');
		        }
		    }
		}

		require("../lib/header.php");

?>   

        <!-- Start Sub Header -->
        <div class="kt-subheader kt-grid__item" id="kt_subheader">
	        <div class="kt-container">
	            <div class="kt-subheader__main">
		            <h3 class="kt-subheader__title">Konfirmasi Tagihan</h3>
	                <div class="kt-subheader__breadcrumbs">
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
	                	<span class="kt-subheader__breadcrumbs-separator"></span>
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-link">Halaman Utama</a>
	                	<span class="kt-subheader__breadcrumbs-separator"></span>
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-link">Konfirmasi Tagihan</a>
	                </div>
	            </div>
	        </div>
        </div>
        <!-- End Sub Header -->

        <!-- Start Content -->
        <div class="kt-container kt-grid__item kt-grid__item--fluid">

        <!-- Start Page New Confirm PDAM -->
        <div class="row">
	        <div class="offset-lg-2 col-lg-8">
		        <div class="kt-portlet">
			        <div class="kt-portlet__head">
				        <div class="kt-portlet__head-label">
					        <h3 class="kt-portlet__head-title">
					            <i class="flaticon2-shopping-cart text-primary"></i>
					            Konfirmasi Tagihan
					        </h3>
				        </div>
			        </div>
			        <div class="kt-portlet__body">
                    <?php
                    if (isset($_SESSION['hasil'])) {
                    ?>
                    <div class="alert alert-<?php echo $_SESSION['hasil']['alert'] ?> alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <?php echo $_SESSION['hasil']['pesan'] ?>
                    </div>
                    <?php
                    unset($_SESSION['hasil']);
                    }
                    ?>
				    <div class="alert alert-primary">
				        <div class="alert-text">
					        Klik <b>Bayar Tagihan</b> Untuk Melanjutkan Transaksi Anda.
					    </div>
				    </div>
				    <div class="table-responsive">
					    <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
						    <tr>
							    <td><b>Kode Pesanan</b></td>
							    <td><?php echo $data_pesanan['oid']; ?></td>
						    </tr>
						    <tr>
							    <td><b>Nomor Pelanggan</b></td>
							    <td><?php echo $data_pesanan['target']; ?></td>
						    </tr>
						    <tr>
							    <td><b>Nama Pelanggan</b></td>
							    <td><?php echo $data_pesanan['nama_penerima']; ?></td>
						    </tr>
						    <tr>
							    <td><b>Alamat</b></td>
							    <td><?php echo $data_pesanan['deskripsi1']; ?></td>
						    </tr>
						    <tr>
							    <td><b>Jatuh Tempo</b></td>
							    <td><?php echo $data_pesanan['deskripsi2']; ?></td>
						    </tr>
						    <tr>
							    <td><b>Tagihan Untuk</b></td>
							    <td><?php echo $data_pesanan['layanan']; ?></td>
						    </tr>
						    <tr>
							    <td><b>Total Tagihan</b></td>
							    <td>Rp <?php echo number_format($data_pesanan['harga'],0,',','.'); ?></td>
						    </tr>
						    <tr>
							    <td><b>Tanggal & Waktu</b></td>
							    <td><?php echo tanggal_indo($data_pesanan['date']); ?>, <?php echo $data_pesanan['time']; ?></td>
						    </tr>
						    <tr>
							    <td><b>Status</b></td>
							    <td><span class="btn btn-<?php echo $label; ?> btn-elevate btn-pill btn-elevate-air btn-sm"><?php echo $data_pesanan['status']; ?></span></td>
						    </tr>
					    </table>
							<form class="form-horizontal" method="POST">
							<?php if ($data_pesanan['status'] !== "Success" AND $data_pesanan['status'] !== "Error") { ?>
						        <input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
						        <button type="submit" class="btn btn-danger btn-bold" name="cancel" value="<?php echo $data_pesanan['oid']; ?>">Batalkan</button>
							    <button type="submit" class="btn btn-brand btn-bold pull-right" name="confirm">Bayar Tagihan</button>
							</form>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- End Page New Confirm PDAM -->

        </div>
        <!-- End Content -->

        <!-- Start Scrolltop -->
		<div id="kt_scrolltop" class="kt-scrolltop">
		    <i class="fa fa-arrow-up"></i>
		</div>
		<!-- End Scrolltop -->

<?php 
require '../lib/footer.php';
}
} else {
	header("Location: ".$config['web']['url']."order/pdam");
}
?>