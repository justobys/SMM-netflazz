<?php
session_start();
require '../config.php';
require '../lib/session_user.php';
require '../lib/header.php';
?>

        <!-- Start Sub Header -->
        <div class="kt-subheader kt-grid__item" id="kt_subheader">
	        <div class="kt-container">
	            <div class="kt-subheader__main">
		            <h3 class="kt-subheader__title">Cara Isi Saldo</h3>
	                <div class="kt-subheader__breadcrumbs">
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
	                	<span class="kt-subheader__breadcrumbs-separator"></span>
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-link">Halaman Utama</a>
	                	<span class="kt-subheader__breadcrumbs-separator"></span>
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-link">Cara Isi Saldo</a>
	                </div>
	            </div>
	        </div>
        </div>
        <!-- End Sub Header -->

        <!-- Start Content -->
        <div class="kt-container kt-grid__item kt-grid__item--fluid">

        <!-- Start Page How To Top Up Balance -->
        <div class="row">
	        <div class="col-lg-12">
				<div class="kt-portlet kt-portlet--height-fluid">
					<div class="kt-portlet__body tx-center tx-inverse">
						<div class="row">
		                    <div class="col-sm-12 col-md-12" style="margin-bottom:50px;">
                                <center><h3 style="font-size:20px;font-weight:bold;">CARA ISI SALDO</h3></center>
                                <center><p class="lead mg-b-0">Setelah Mendaftar Di <b><?php echo $data['short_title']; ?></b>, Langkah Selanjutnya Adalah Isi Saldonya Agar Kamu Dapat Melakukan Transaksi Di <b><?php echo $data['short_title']; ?></b>.</p></center>
		                    </div>
		                    <div class="col-sm-4 col-md-4">
                                <div class="box-content text-center">
                                    <div class="block-icon">
                                        <img src="<?php echo $config['web']['url'] ?>assets/media/icon/bank-deposit.svg" width="70px">
                                    </div>
                                    <br />
                                    <h3>1. Buat Isi Saldo</h3>
                                    <p>Langkah Pertama, Lakukan Buat Isi Saldonya Pada Halaman Utama Dengan Memilih Icon Isi Saldo Lalu Memilih Tipe Isi Saldonya, Kami Menyediakan 2 Tipe Isi Saldonya Yaitu PULSA TRANSFER & BANK TRANSFER, Setelah Itu Isi Form Yang Di Sediakan Pada Fitur Isi Saldonya.</p>
                                </div>
                            </div>
		                    <div class="col-sm-4 col-md-4">
                                <div class="box-content text-center">
                                    <div class="block-icon">
                                        <img src="<?php echo $config['web']['url'] ?>assets/media/icon/paper-plane.svg" width="70px">
                                    </div>
                                    <br />
                                    <h3>2. Transfer Pembayaran</h3>
                                    <p>Langkah Kedua, Kamu Akan Di Alihkan Ke Fitur Invoice Isi Saldo Dan Di Minta Untuk Melakukan Transfer Sejumlah Nominal Transfer Yang Tertera Pada Detail Isi Saldo Tersebut, Disarankan Untuk Transfer Pembayaran Sesuai Nominal Transfer Yang Tertera Pada Invoice Isi Saldo Tersebut.</p>
                                </div>
		                    </div>
		                    <div class="col-sm-4 col-md-4">
                                <div class="box-content text-center">
                                    <div class="block-icon">
                                        <img src="<?php echo $config['web']['url'] ?>assets/media/icon/confirm.svg" width="70px">
                                    </div>
                                    <br />
                                    <h3>3. Konfirmasi Pembayaran</h3>
                                    <p>Langkah Terakhir, Konfirmasi Pembayaran Kamu Dengan Cara Klik Tombol Konfirmasi Untuk Isi Saldo Tipe Bank Transfer, Saldo Kamu Akan Bertambah Otomatis Oleh System. Disarankan Yang Menggunakan Tipe Isi Saldo Bank Transfer Untuk Melakukan Isi Saldonya Pada Jam Online Bank, Jika Ada Kesalahan Transfer Harap Langsung Menghubungi (CS) Bantuan <b><?php echo $data['short_title']; ?></b>.</p>
                                </div>
		                    </div>
		                    <br>
		                    <br>
		                    <div class="col-sm-12 col-md-12">
                                <div class="box-content text-center">
                                    <div class="block-icon">
                                        <center><h3 style="font-size:20px;font-weight:bold;"><font color =''>MENDUKUNG PEMBAYARAN DARI METODE BERIKUT</font></h3></center>
                                    </div>
                                    <div style="text-align:center;padding-top:20px">
                                        <img src="https://dms.artajasa.co.id/dms/images/qris_logo.png" style="height:100%;max-height:40px;margin:10px 20px" />
                                        <img src="https://ik.imagekit.io/Tridicdn/tripaypayment/images/payment-channel/ytBKvaleGy1605201833.png" style="height:100%;max-height:30px;margin:10px 20px" />
                                        <img src="https://ik.imagekit.io/Tridicdn/tripaypayment/images/payment-channel/8WQ3APST5s1579461828.png" style="height:100%;max-height:40px;margin:10px 20px" />
                                        <img src="https://ik.imagekit.io/Tridicdn/tripaypayment/images/payment-channel/n22Qsh8jMa1583433577.png" style="height:100%;max-height:30px;margin:10px 20px" />
                                        <img src="https://ik.imagekit.io/Tridicdn/tripaypayment/images/payment-channel/KHcqcmqVFQ1607091889.png" style="height:100%;max-height:30px;margin:10px 20px" />
                                        <img src="https://ik.imagekit.io/Tridicdn/tripaypayment/images/payment-channel/jiGZMKp2RD1583433506.png" style="height:100%;max-height:30px;margin:10px 20px" />
                                        <img src="https://ik.imagekit.io/Tridicdn/tripaypayment/images/payment-channel/aQTdaUC2GO1593660384.png" style="height:100%;max-height:30px;margin:10px 20px" />
                                    </div>
                                </div>
		                    </div>
						</div>
					</div>
				</div>
            </div>
        </div>
        <!-- End Page How To Top Up Balance -->

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