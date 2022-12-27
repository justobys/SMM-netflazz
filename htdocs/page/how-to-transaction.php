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
		            <h3 class="kt-subheader__title">Cara Transaksi</h3>
	                <div class="kt-subheader__breadcrumbs">
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
	                	<span class="kt-subheader__breadcrumbs-separator"></span>
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-link">Halaman Utama</a>
	                	<span class="kt-subheader__breadcrumbs-separator"></span>
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-link">Cara Transaksi</a>
	                </div>
	            </div>
	        </div>
        </div>
        <!-- End Sub Header -->

        <!-- Start Content -->
        <div class="kt-container kt-grid__item kt-grid__item--fluid">

        <!-- Start Page How To Transaction -->
        <div class="row">
	        <div class="col-lg-12">
	            <div class="row">
				    <div class="kt-portlet kt-portlet--height-fluid">
					    <div class="kt-portlet__body tx-center tx-inverse">
						    <div class="row">
		                        <div class="col-sm-12 col-md-12" style="margin-bottom:50px;">
                                    <center><h3 style="font-size:20px;font-weight:bold;">3 LANGKAH MUDAH UNTUK MEMULAI</h3></center>
                                    <center><p class="lead mg-b-0">Berikut Langkah Untuk Memulai Bisnis Kamu Bersama <b><?php echo $data['short_title']; ?></b>.</p></center>
                                </div>
                                <div class="col-sm-4 col-md-4">
                                    <div class="box-content text-center">
                                        <div class="block-icon">
                                            <img src="<?php echo $config['web']['url'] ?>assets/media/icon/bank-deposit.svg" width="70px">
                                        </div>
                                        <br />
                                        <h3>1. Isi Saldo</h3>
                                        <p>Langkah Pertama Yaitu, Lakukan Isi Saldo Untuk Melakukan Transaksi. Untuk Melihat Cara Melakukan Isi Saldo <a href="<?php echo $config['web']['url'] ?>page/how-to-top-up-balance" target="_blank">Klik Disini</a>.</p>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-md-4">
                                    <div class="box-content text-center">
                                        <div class="block-icon">
                                            <img src="<?php echo $config['web']['url'] ?>assets/media/icon/shopping-cart.svg" width="70px">
                                        </div>
                                        <br />
                                        <h3>2. Mulai Transaksi</h3>
                                        <p>Setelah Kamu Sukses Melakukan Isi Saldo, Kamu Dapat Melakukan Transaksi Di <b><?php echo $data['short_title']; ?></b>.</p>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-md-4">
                                    <div class="box-content text-center">
                                        <div class="block-icon">
                                            <img src="<?php echo $config['web']['url'] ?>assets/media/icon/bell.svg" width="70px">
                                        </div>
                                        <br />
                                        <h3>3. Status Pesanan</h3>
                                        <p>Dan Yang Terakhir, Cek Status Pesananmu <a href="<?php echo $config['web']['url'] ?>history/order" target="_blank">Disini</a>.</p>
                                    </div>
                                </div>
						    </div>
					    </div>
                    </div>
                    <br />
				    <div class="kt-portlet kt-portlet--height-fluid">
					    <div class="kt-portlet__body tx-center tx-inverse">
						    <div class="row">
		                        <div class="col-sm-12 col-md-12" style="margin-bottom:50px;">
                                    <center><h3 style="font-size:20px;font-weight:bold;">2 JALUR TRANSAKSI</h3></center>
                                    <center><p class="lead mg-b-0">Kami Memiliki 2 Jalur Untuk Melakukan Transaksi Di <b><?php echo $data['short_title']; ?></b>.</p></center>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="box-content text-center">
                                        <div class="block-icon">
                                            <img src="<?php echo $config['web']['url'] ?>assets/media/icon/global.svg" width="70px">
                                        </div>
                                        <br />
                                        <h3>Transaksi Via Website</h3>
                                        <p>Jalur Transaksi Melalui Website Yang Dapat Di Akses Melalui Perangkat Komputer/Laptop, & Perangkat Smartphone Android/IOS.</p>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="box-content text-center">
                                        <div class="block-icon">
                                            <img src="<?php echo $config['web']['url'] ?>assets/media/icon/laptop-code.svg" width="70px">
                                        </div>
                                        <br />
                                        <h3>Transaksi Via API (H2H)</h3>
                                        <p>Jika Anda Memiliki Website Sendiri, Kami Menyediakan Jalur Transaksi Via API. Untuk Melihat API Dokumentasi Nya <a href="<?php echo $config['web']['url'] ?>page/api-documentation" target="_blank">Disini</a>.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page How To Transaction -->

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