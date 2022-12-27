<?php
session_start();
require '../config.php';
require '../lib/session_user.php';

	    if (isset($_POST['pesan'])) {
		    require '../lib/session_login.php';
		    $post_tipe = $conn->real_escape_string(filter($_POST['kategori']));
		    $post_layanan = $conn->real_escape_string(filter($_POST['layanan']));
		    $post_target = $conn->real_escape_string(filter($_POST['target']));
		    $post_pin = $conn->real_escape_string(filter($_POST['pin']));

		    $cek_layanan = $conn->query("SELECT * FROM layanan_pascabayar WHERE service_id = '$post_layanan' AND status = 'Normal'");
		    $data_layanan = mysqli_fetch_assoc($cek_layanan);

		    $cek_pesanan = $conn->query("SELECT * FROM pembelian_pascabayar WHERE target = '$post_target' AND status = 'Pending'");
		    $data_pesanan = mysqli_fetch_assoc($cek_pesanan);

		    $cek_rate_koin = $conn->query("SELECT * FROM setting_koin_didapat WHERE status = 'Aktif'");
		    $data_rate_koin = mysqli_fetch_assoc($cek_rate_koin);

		    $order_id = acak_nomor(3).acak_nomor(4);
            $provider = $data_layanan['provider'];
            $provider_id = $data_layanan['provider_id'];

		    $cek_provider = $conn->query("SELECT * FROM provider_pulsa WHERE code = '$provider'");
		    $data_provider = mysqli_fetch_assoc($cek_provider);

		    $cek_rate = $conn->query("SELECT * FROM setting_rate WHERE tipe = 'Pascabayar'");
		    $data_rate = mysqli_fetch_assoc($cek_rate);

            $error = array();
            if (empty($post_tipe)) {
		        $error ['kategori'] = '*Wajib Pilih Salah Satu.';
            }
            if (empty($post_layanan)) {
		        $error ['layanan'] = '*Wajib Pilih Salah Satu.';
            }
            if (empty($post_target)) {
		        $error ['target'] = '*Tidak Boleh Kosong.';
            }
            if (empty($post_pin)) {
		        $error ['pin'] = '*Tidak Boleh Kosong.';
            } else if ($post_pin <> $data_user['pin']) {
		        $error ['pin'] = '*PIN Yang Kamu Masukkan Salah.';
            } else {

		    if (mysqli_num_rows($cek_layanan) == 0) {
			    $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Layanan Tidak Tersedia.<script>swal("Ups Gagal!", "Layanan Tidak Tersedia.", "error");</script>');

		    } else if (mysqli_num_rows($cek_provider) == 0) {
			    $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Server Kami Sedang Maintance.<script>swal("Ups Gagal!", "Server Kami Sedang Maintance.", "error");</script>');

		    } else if ($data_user['saldo_top_up'] < $tagihan) {
			    $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Yahh, Saldo Top Up Kamu Tidak Mencukupi Untuk Melakukan Pemesanan Ini.<script>swal("Yahh Gagal!", "Saldo Top Up Kamu Tidak Mencukupi Untuk Melakukan Pemesanan Ini.", "error");</script>');

		    } else if (mysqli_num_rows($cek_pesanan) == 1) {
		        $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Sepertinya Tagihan Kamu Sudah Ada Silahkan Cek Riwayat Pesanan Kamu.<script>swal("Ups Gagal!", "Tagihan Kamu Belum Dibayar.", "error");</script>');

		    } else {

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
            	'buyer_sku_code' => $data_layanan['provider_id'],
            	'customer_no' => "$post_target",
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
		            $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, '.$json_result['data']['message']);
			    } else {

			        if ($provider == "NETFLAZZ") {
		                $order_id = $json_result['data']['ref_id'];
		                $cust_name = $json_result['data']['customer_name'];
		                $admin = $json_result['data']['admin'];
		                $jumlah_peserta = $json_result['data']['desc']['jumlah_peserta'];
		                $alamat = $json_result['data']['desc']['alamat'];
		                $tagihan = $admin;
			        }

			    $koin = $tagihan * $data_rate_koin['rate'];
			    if ($conn->query("INSERT INTO pembelian_pascabayar VALUES ('','$order_id', '$order_id', '$provider_id', '$sess_username', '".$data_layanan['layanan']."', '$tagihan', '".$data_rate['rate']."', '$koin', '$post_target', '$cust_name', '$jumlah_peserta', '$alamat', '', '', 'Tagihan Kamu Ditemukan', 'Pending', '$date', '$time', 'Website', '$provider', '0')") == true) {
			        $conn->query("INSERT INTO semua_pembelian VALUES ('','WEB-$order_id','$order_id', '$sess_username', '".$data_layanan['kategori']."', '".$data_layanan['layanan']."', '$tagihan', '$post_target', 'Pending', '$date', '$time', 'WEB', '0')");
    			        $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip, Tagihan Kamu Telah Kami Terima.');
				    } else {
					    $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.<script>swal("Ups Gagal!", "Sistem Kami Sedang Mengalami Gangguan.", "error");</script>');
				    }
			    }
		    }
	    }

	    } else if (isset($_POST['kode'])) {
	        $post_kode = $conn->real_escape_string(filter($_POST['kode']));

	        $cek_pesanan = $conn->query("SELECT * FROM pembelian_pascabayar WHERE oid = '$post_kode'");
	        $data_pesanan = mysqli_fetch_assoc($cek_pesanan);

	        if (mysqli_num_rows($cek_pesanan) == 0) {
	            $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Tagihanmu Tidak Di Temukan.<script>swal("Ups Gagal!", "Tagihanmu Tidak Di Temukan.", "error");</script>');
	        } else if ($data_pesanan['status'] !== "Pending") {
	            $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Tagihanmu Gak Bisa Dibatalkan.<script>swal("Ups Gagal!", "Tagihanmu Gak Bisa Dibatalkan.", "error");</script>');
	        } else {

	        $update = $conn->query("UPDATE pembelian_pascabayar set status = 'Error' WHERE oid = '$post_kode'");
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
		            <h3 class="kt-subheader__title">Pemesanan Baru</h3>
	                <div class="kt-subheader__breadcrumbs">
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
	                	<span class="kt-subheader__breadcrumbs-separator"></span>
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-link">Halaman Utama</a>
	                	<span class="kt-subheader__breadcrumbs-separator"></span>
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-link">Pemesanan Baru</a>
	                </div>
	            </div>
	        </div>
        </div>
        <!-- End Sub Header -->

        <!-- Start Content -->
        <div class="kt-container kt-grid__item kt-grid__item--fluid">

        <!-- Start Page New Bill BPJS Pascabayar -->
        <div class="row">
	        <div class="col-lg-7">
		        <div class="kt-portlet">
			        <div class="kt-portlet__head">
				        <div class="kt-portlet__head-label">
					        <h3 class="kt-portlet__head-title">
					            <i class="flaticon2-shopping-cart text-primary"></i>
					            Pemesanan BPJS Kesehatan
					        </h3>
				        </div>
			        </div>
			        <div class="kt-portlet__body">
					<?php
					$cek_pesanan = $conn->query("SELECT * FROM pembelian_pascabayar WHERE user = '$sess_username' AND status = 'Pending' ORDER BY id DESC");
					while ($data_pesanan = $cek_pesanan->fetch_assoc()) {
					?>
					<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
					<script>
						var url = "<?php echo $config['web']['url'] ?>order/confirm-bpjs?kode=<?php echo $data_pesanan['oid']; ?>"; // URL Tujuan
						var count = 1; // dalam detik
						function countDown() {
							if (count > 0) {
							    count--;
							    var waktu = count + 1;
							    setTimeout("countDown()", 1000);
							} else {
							    window.location.href = url;
							}
						}
						countDown();
					</script>
					<?php } ?>
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
                        <form class="form-horizontal" method="POST">
	                        <input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
							<div class="form-group row">
								<label class="col-xl-3 col-lg-3 col-form-label">Kategori</label>
								<div class="col-lg-9 col-xl-6">
									<select class="form-control" name="kategori" id="kategori">
										<option value="0">Pilih Salah Satu</option>
										<?php
										$cek_kategori = $conn->query("SELECT * FROM kategori_layanan WHERE server = 'Pascabayar' AND kode = 'BPJS KESEHATAN' ORDER BY nama ASC");
										while ($data_kategori = mysqli_fetch_assoc($cek_kategori)) {
										?>
										<option value="<?php echo $data_kategori['kode']; ?>"><?php echo $data_kategori['nama']; ?></option>
										<?php
										}
										?>
								    </select>
								    <span class="form-text text-muted"><?php echo ($error['kategori']) ? $error['kategori'] : '';?></span>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-xl-3 col-lg-3 col-form-label">Layanan</label>
								<div class="col-lg-9 col-xl-6">
									<select class="form-control" name="layanan" id="layanan">
										<option value="0">Pilih Kategori Dahulu</option>
									</select>
									<span class="form-text text-muted"><?php echo ($error['layanan']) ? $error['layanan'] : '';?></span>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-xl-3 col-lg-3 col-form-label">Tujuan</label>
								<div class="col-lg-9 col-xl-6">
								    <input type="text" name="target" class="form-control" placeholder="Nomor Pelanggan">
								    <span class="form-text text-muted"><?php echo ($error['target']) ? $error['target'] : '';?></span>
								</div>
							</div>
                            <div class="form-group row">
                                <label class="col-xl-3 col-lg-3 col-form-label">PIN</label>
                                <div class="col-lg-9 col-xl-6">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="la la-lock text-primary"></i></span></div>
                                        <input type="password" name="pin" class="form-control" placeholder="Masukkan PIN Kamu">
                                    </div>
                                    <span class="form-text text-muted"><?php echo ($error['pin']) ? $error['pin'] : '';?></span>
                                </div>
                            </div>
                            <div class="kt-portlet__foot">
                                <div class="kt-form__actions">
                                    <div class="row">
                                        <div class="col-lg-3 col-xl-3">
                                        </div>
                                        <div class="col-lg-9 col-xl-9">
                                            <button type="submit" name="pesan" class="btn btn-primary btn-elevate btn-pill btn-elevate-air">Submit</button>
                                            <button type="reset" class="btn btn-danger btn-elevate btn-pill btn-elevate-air">Ulangi</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
						</form>
					</div>
				</div>
	        </div>

	        <div class="col-lg-5">
		        <div class="kt-portlet">
			        <div class="kt-portlet__head">
				        <div class="kt-portlet__head-label">
					        <h3 class="kt-portlet__head-title">
					            <i class="flaticon-alert text-primary"></i>
					            Informasi
					        </h3>
				        </div>
			        </div>
			        <div class="kt-portlet__body">
						<ul>
							<li>Pesan Layanan BPJS Kesehatan Masukkan Nomor Pelanggan Dengan Benar, Contoh 324253566352.</li>
							<li>Harap Masukan Nomor Pelanggan Dengan Benar, Tidak Ada Pengembalian Dana Untuk Kesalahan Pengguna Yang Pesanannya Sudah Terlajur Di Pesan.</li>
							<li>Jika Butuh Bantuan Silahkan Hubungi Kontak Kami.</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!-- End Page New Bill BPJS Kesehatan -->

        <!-- Start Page History Bill BPJS Kesehatan -->
        <div class="row">
	        <div class="col-lg-12">
		        <div class="kt-portlet">
			        <div class="kt-portlet__head">
				        <div class="kt-portlet__head-label">
					        <h3 class="kt-portlet__head-title">
					            <i class="flaticon2-time text-primary"></i>
					            Riwayat Pesanan BPJS Kesehatan
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
                    <form class="form-horizontal" method="GET">
                        <div class="row">
                            <div class="form-group col-lg-3">
                                <label>Tampilkan Beberapa</label>
                                <select class="form-control" name="tampil">
                                    <option value="10">Default</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Filter Status</label>
                                <select class="form-control" name="status">
                                    <option value="">Semua</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Success">Success</option>
                                    <option value="Error">Error</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Cari Kode Pesanan</label>
                                <input type="number" class="form-control" name="cari" placeholder="Masukkan Kode Pesanan Kamu" value="">
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Submit</label>
                                <button type="submit" class="btn btn-block btn-primary">Cari</button>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Kode Pesanan</th>
                                    <th>Tanggal & Waktu</th>
                                    <th>Nama Layanan</th>
                                    <th>Nomor Pelanggan</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Keterangan</th>
                                    <th>Harga</th>
                                    <th>Status</th>
                                    <th>Pengembalian Dana</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
<?php 
// start paging config
if (isset($_GET['cari'])) {
    $cari_oid = $conn->real_escape_string(filter($_GET['cari']));
    $cari_status = $conn->real_escape_string(filter($_GET['status']));

    $cek_pesanan = "SELECT * FROM pembelian_pascabayar WHERE oid LIKE '%$cari_oid%' AND status LIKE '%$cari_status%' AND user = '$sess_username' AND kategori = 'BPJS KESEHATAN' ORDER BY id DESC"; // edit
} else {
    $cek_pesanan = "SELECT * FROM pembelian_pascabayar WHERE user = '$sess_username' AND kategori = 'BPJS KESEHATAN' ORDER BY id DESC"; // edit
}
if (isset($_GET['cari'])) {
$cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
$records_per_page = $cari_urut; // edit
} else {
    $records_per_page = 10; // edit
}

$starting_position = 0;
if(isset($_GET["halaman"])) {
    $starting_position = ($conn->real_escape_string(filter($_GET["halaman"]))-1) * $records_per_page;
}
$new_query = $cek_pesanan." LIMIT $starting_position, $records_per_page";
$new_query = $conn->query($new_query);
// end paging config
while ($data_pesanan = $new_query->fetch_assoc()) {
    if ($data_pesanan['status'] == "Pending") {
        $label = "warning";
    } else if ($data_pesanan['status'] == "Error") {
        $label = "danger";     
    } else if ($data_pesanan['status'] == "Success") {
        $label = "success";    
    }
    if ($data_pesanan['refund'] == "0") {
        $icon2 = "times-circle";
        $label2 = "danger"; 
    } else if ($data_pesanan['refund'] == "1") {
        $icon2 = "check";
        $label2 = "success";
    }
?>
                                <tr>
                                    <td align="center"><?php if($data_pesanan['place_from'] == "API") { ?><i class="fa fa-random"></i><?php } else { ?><i class="flaticon-globe"></i><?php } ?></td>
                                    <td><span class="btn btn-primary btn-elevate btn-pill btn-elevate-air btn-sm"><?php echo $data_pesanan['oid']; ?></span></td>
                                    <td><?php echo tanggal_indo($data_pesanan['date']); ?>, <?php echo $data_pesanan['time']; ?></td>
                                    <td><?php echo $data_pesanan['layanan']; ?></td>
                                    <td style="min-width: 200px;">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm" value="<?php echo $data_pesanan['target']; ?>" id="target-<?php echo $data_pesanan['oid']; ?>" readonly="">
                                        <button data-toggle="tooltip" title="Copy Nomor Pelanggan" class="btn btn-primary btn-sm" type="button" onclick="copy_to_clipboard('target-<?php echo $data_pesanan['oid']; ?>')"><i class="fas fa-copy text-warning"></i></button>
                                    </div>
                                    </td>
                                    <td style="min-width: 200px;">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm" value="<?php echo $data_pesanan['nama_penerima']; ?>" id="nama_penerima-<?php echo $data_pesanan['oid']; ?>" readonly="">
                                        <button data-toggle="tooltip" title="Copy Nama Pelanggan" class="btn btn-primary btn-sm" type="button" onclick="copy_to_clipboard('nama_penerima-<?php echo $data_pesanan['oid']; ?>')"><i class="fas fa-copy text-warning"></i></button>
                                    </div>
                                    </td>
                                    <td><?php echo $data_pesanan['keterangan']; ?></td>
                                    <td>Rp <?php echo number_format($data_pesanan['harga'],0,',','.'); ?></td>
                                    <td><span class="btn btn-<?php echo $label; ?> btn-elevate btn-pill btn-elevate-air btn-sm"><?php echo $data_pesanan['status']; ?></span>
                                    <td><span class="btn btn-<?php echo $label2; ?> btn-elevate btn-circle btn-icon"><i class="fa fa-<?php echo $icon2; ?>"></i></span></td>
 								    <td align="center">
								        <a href="<?php echo $config['web']['url'] ?>order/confirm-bpjs?kode=<?php echo $data_pesanan['oid']; ?>" class="btn btn-primary btn-elevate btn-circle btn-icon"><i class="flaticon-eye"></i></a>
								    </td>
                                </tr>
<?php } ?>
                            </tbody>
                        </table>
                        <br>
                            <div class="kt-pagination kt-pagination--brand kt-pagination--circle">
                                <ul class="kt-pagination__links">
<?php
// start paging link
if (isset($_GET['cari'])) {
$cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
} else {
$cari_urut =  10;
}  
if (isset($_GET['cari'])) {
    $cari_oid = $conn->real_escape_string(filter($_GET['cari']));
    $cari_status = $conn->real_escape_string(filter($_GET['status']));
    $cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
} else {
    $self = $_SERVER['PHP_SELF'];
}
$cek_pesanan = $conn->query($cek_pesanan);
$total_records = mysqli_num_rows($cek_pesanan);
echo "<li class='disabled page-item'><a href='#'>Total Data : ".$total_records."</a></li>";
if($total_records > 0) {
    $total_pages = ceil($total_records/$records_per_page);
    $current_page = 1;
    if(isset($_GET["halaman"])) {
        $current_page = $conn->real_escape_string(filter($_GET["halaman"]));
        if ($current_page < 1) {
            $current_page = 1;
        }
    }
    if($current_page > 1) {
        $previous = $current_page-1;
    if (isset($_GET['cari'])) {
    $cari_oid = $conn->real_escape_string(filter($_GET['cari']));
    $cari_status = $conn->real_escape_string(filter($_GET['status']));
    $cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
        echo "<li class='kt-pagination__link--first'><a href='".$self."?halaman=1&tampil=".$cari_urut."&status=".$cari_status."&cari=".$cari_oid."'><i class='fa fa-angle-double-left kt-font-brand'></i></a></li>";
        echo "<li class='kt-pagination__link--first'><a href='".$self."?halaman=".$previous."&tampil=".$cari_urut."&status=".$cari_status."&cari=".$cari_oid."'><i class='fa fa-angle-left kt-font-brand'></i></a></li>";
} else {
        echo "<li class='kt-pagination__link--first'><a href='".$self."?halaman=1'><i class='fa fa-angle-double-left kt-font-brand'></i></a></li>";
        echo "<li class='kt-pagination__link--first'><a href='".$self."?halaman=".$previous."'><i class='fa fa-angle-left kt-font-brand'></i></a></li>";
}
}
    // limit page
    $limit_page = $current_page+3;
    $limit_show_link = $total_pages-$limit_page;
    if ($limit_show_link < 0) {
        $limit_show_link2 = $limit_show_link*2;
        $limit_link = $limit_show_link - $limit_show_link2;
        $limit_link = 3 - $limit_link;
    } else {
        $limit_link = 3;
    }
    $limit_page = $current_page+$limit_link;
    // end limit page
    // start page
    if ($current_page == 1) {
        $start_page = 1;
    } else if ($current_page > 1) {
        if ($current_page < 4) {
            $min_page  = $current_page-1;
        } else {
            $min_page  = 3;
        }
        $start_page = $current_page-$min_page;
    } else {
        $start_page = $current_page;
    }
    // end start page
    for($i=$start_page; $i<=$limit_page; $i++) {
    if (isset($_GET['cari'])) {
    $cari_oid = $conn->real_escape_string(filter($_GET['cari']));
    $cari_status = $conn->real_escape_string(filter($_GET['status']));
    $cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
        if($i==$current_page) {
            echo "<li class='kt-pagination__link--active'><a href='#'>".$i."</a></li>";
        } else {
            echo "<li class='kt-pagination__link--first'><a href='".$self."?halaman=".$i."&tampil=".$cari_urut."&status=".$cari_status."&cari=".$cari_oid."'>".$i."</a></li>";
        }
    } else {
        if($i==$current_page) {
            echo "<li class='kt-pagination__link--active'><a href='#'>".$i."</a></li>";
        } else {
            echo "<li class='kt-pagination__link--first'><a href='".$self."?halaman=".$i."'>".$i."</a></li>";
        }        
    }
    }
    if($current_page!=$total_pages) {
        $next = $current_page+1;
    if (isset($_GET['cari'])) {
    $cari_oid = $conn->real_escape_string(filter($_GET['cari']));
    $cari_status = $conn->real_escape_string(filter($_GET['status']));
    $cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
        echo "<li class='kt-pagination__link--first'><a href='".$self."?halaman=".$next."&tampil=".$cari_urut."&status=".$cari_status."&cari=".$cari_oid."'><i class='fa fa-angle-right kt-font-brand'></i></a></li>";
        echo "<li class='kt-pagination__link--first'><a href='".$self."?halaman=".$total_pages."&tampil=".$cari_urut."&status=".$cari_status."&cari=".$cari_oid."'><i class='fa fa-angle-double-right kt-font-brand'></i></a></li>";
} else {
        echo "<li class='kt-pagination__link--first'><a href='".$self."?halaman=".$next."'><i class='fa fa-angle-right kt-font-brand'></i></a></li>";
        echo "<li class='kt-pagination__link--first'><a href='".$self."?halaman=".$total_pages."'><i class='fa fa-angle-double-right kt-font-brand'></i></a></li>";
    }
}
}
// end paging link
?>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page History Bill BPJS Kesehatan -->

        </div>
        <!-- End Content -->

        <!-- Start Scrolltop -->
		<div id="kt_scrolltop" class="kt-scrolltop">
		    <i class="fa fa-arrow-up"></i>
		</div>
		<!-- End Scrolltop -->

		<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
		<script type="text/javascript">
		$(document).ready(function() {
		    $("#kategori").change(function() {
			    var kategori = $("#kategori").val();
			    $.ajax({
			        url: '<?php echo $config['web']['url']; ?>ajax/service-pascabayar.php',
			        data: 'kategori=' + kategori,
			        type: 'POST',
			        dataType: 'html',
			        success: function(msg) {
				        $("#layanan").html(msg);
			        }
		        });
	        });
	    });
		</script>

<?php
require ("../lib/footer.php");
?>

	    <script type="text/javascript">
	    function copy_to_clipboard(element) {
	        var copyText = document.getElementById(element);
	        copyText.select();
	        document.execCommand("copy");
	    }
	    </script>