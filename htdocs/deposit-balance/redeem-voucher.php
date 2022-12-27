<?php
session_start();
require("../config.php");
require '../lib/session_user.php';

        if (isset($_POST['redeem'])) {
	        require '../lib/session_login.php';
	        $post_metode = $conn->real_escape_string(filter($_POST['radio6']));
		    $post_kode = $conn->real_escape_string(filter($_POST['kode']));
		    $post_pin = $conn->real_escape_string(filter($_POST['pin']));

		    
            $cek_kodevoucher = $conn->query("SELECT * FROM kode_voucher WHERE kode = '$post_kode'");
            $cek_kodevoucher_ulang = mysqli_num_rows($cek_kodevoucher);
            $data_kodevoucher = mysqli_fetch_assoc($cek_kodevoucher);

            if ($post_metode == "saldo_sosmed"){
			    $post_metodee = "Saldo Sosial Media";
            } else if($post_metode == "saldo_top_up"){
			    $post_metodee = "Saldo Top Up";
            }

            $tipe_saldo = "saldo_top_up";

            $error = array();
            if (empty($post_metode)) {
		        $error ['radio6'] = '*Wajib Pilih Salah Satu.';
            }
            if (empty($post_kode)) {
		    $error ['kode'] = '*Tidak Boleh Kosong';
	    } else if ($data_kodevoucher['status'] == "Sudah Dipakai") {
		    $error ['kode'] = '*Kode Voucher Sudah Dipakai';
	    }
            if (empty($post_pin)) {
		        $error ['pin'] = '*Tidak Boleh Kosong.';
            } else if ($post_pin <> $data_user['pin']) {
		        $error ['pin'] = '*PIN Yang Kamu Masukkan Salah.';
            } else {

            if (mysqli_num_rows($cek_kodevoucher) == 1) {
	            $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Kode Voucher Tidak Ditemukan.<script>swal("Gagal!", "Kode Voucher Tidak Ditemukan.", "error");</script>');
	    } else {

	                    $get_saldo = $data_kodevoucher['jumlah'];
		                $update = $conn->query("UPDATE users set $tipe_saldo = $tipe_saldo + $get_saldo WHERE username = '$sess_username'");
		                $update = $conn->query("UPDATE kode_voucher SET status = 'Sudah Dipakai' WHERE kode = '$post_kode'");
		            if ($update == TRUE) {
                            $insert = $conn->query("INSERT INTO riwayat_saldo_koin VALUES ('', '$sess_username', 'Saldo', 'Penambahan Saldo', '$get_saldo', 'Mendapatkan Saldo Melalui Redeem Kode Voucher', '$date', '$time')");
	                        
	                    if ($insert == TRUE) {
   		                    $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip! Kamu Berhasil Melakukan Redeem Kode Voucher.<script>swal("Berhasil!", "Kamu Berhasil Melakukan Redeem Kode Voucher.", "success");</script>');
		                } else {
			                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.<script>swal("Ups Gagal!", "Sistem Kami Sedang Mengalami Gangguan.", "error");</script>');
	                    }
	                }
	            }
            }
        }

	    require("../lib/header.php");

?>

        <!-- Start Sub Header -->
        <div class="kt-subheader kt-grid__item" id="kt_subheader">
	        <div class="kt-container">
	            <div class="kt-subheader__main">
		            <h3 class="kt-subheader__title">Redeem Voucher</h3>
	                <div class="kt-subheader__breadcrumbs">
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
	                	<span class="kt-subheader__breadcrumbs-separator"></span>
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-link">Halaman Utama</a>
	                	<span class="kt-subheader__breadcrumbs-separator"></span>
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-link">Redeem Voucher</a>
	                </div>
	            </div>
	        </div>
        </div>
        <!-- End Sub Header -->

        <!-- Start Content -->
        <div class="kt-container kt-grid__item kt-grid__item--fluid">

        <!-- Start Page Redeem Voucher -->
        <div class="row">
	        <div class="offset-lg-2 col-lg-8">
		        <div class="kt-portlet">
			        <div class="kt-portlet__head">
				        <div class="kt-portlet__head-label">
					        <h3 class="kt-portlet__head-title">
					            <i class="flaticon-coins text-primary"></i>
					            Redeem Voucher Ke Saldo
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
						<form class="form-horizontal" role="form" method="POST">
						    <input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
							<div class="form-group row">
								<label class="col-xl-3 col-lg-3 col-form-label">Kode Voucher</label>
								<div class="col-lg-9 col-xl-6">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text text-primary"><i class="fa fa-code text-primary"></i></span></div>
                                        <input type="number" class="form-control" name="kode" placeholder="Masukkan Kode Voucher">
                                    </div>
									<span class="form-text text-muted"><?php echo ($error['kode']) ? $error['kode'] : '';?></span>
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
                                            <button type="submit" name="redeem" class="btn btn-primary btn-elevate btn-pill btn-elevate-air">Submit</button>
                                            <button type="reset" class="btn btn-danger btn-elevate btn-pill btn-elevate-air">Ulangi</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Withdraw Coin To Balance -->

        </div>
        <!-- End Content -->

        <!-- Start Scrolltop -->
		<div id="kt_scrolltop" class="kt-scrolltop">
		    <i class="fa fa-arrow-up"></i>
		</div>
		<!-- End Scrolltop -->


<?php
require '../lib/footer.php';
?>