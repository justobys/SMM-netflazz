<?php
session_start();
require '../config.php';
require '../lib/header.php';
?>

        <!-- Start Sub Header -->
        <div class="kt-subheader kt-grid__item" id="kt_subheader">
	        <div class="kt-container">
	            <div class="kt-subheader__main">
		            <h3 class="kt-subheader__title">Tutorial Marketplace</h3>
	                <div class="kt-subheader__breadcrumbs">
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
	                	<span class="kt-subheader__breadcrumbs-separator"></span>
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-link">Halaman Utama</a>
	                	<span class="kt-subheader__breadcrumbs-separator"></span>
	                    <a href="<?php echo $config['web']['url'] ?>page/tutorial-marketplace" class="kt-subheader__breadcrumbs-link">Tutorial Marketplace</a>
	                </div>
	            </div>
	        </div>
        </div>
        <!-- End Sub Header -->

        <!-- Start Content -->
        <div class="kt-container kt-grid__item kt-grid__item--fluid">

        <!-- Start Page Faq Tab -->
            <div class="row">
	            <div class="col-lg-12">
		            <div class="kt-portlet kt-portlet--height-fluid kt-sc-2">
			            <div class="kt-portlet__body">
				            <div class="kt-infobox">
					            <div class="kt-infobox__body">
					                <div class="accordion accordion-light">
					                	<div class="card">
								            <div class="card-header">
									            <h3 class="mt-0 mb-3 header-title">“Tutorial Order Produk Terjual NEW ALGORITMA ”</h3>
								            </div>
									        <div class="card-body">
									           <p>
									               Untuk meningkatkan toko baru atau starseller yg ingin launching produk barunya, karena  kalau berjualan di shopee tidak ada yang beli / produknya tidak ada yang terjual itu akan sangat minim menimbulkan ketertarikan konsumen untuk Checkout. Kalau garansi kita tidak ada ya, karena kaka order tentu tau resikonya. <br><br>
									               Tapi dari orderan sebelumnya kami belum pernah ada laporan akun yang terkena banned shopee, karena kaki tidak menggunakan aplikasi / software diluar shopee ( pihak ke tiga )<br><br>
									               Kami juga menggunakan akun real untuk proses pengerjaan produk terjual dan kami memproses setiap akunnya berbeda device serta berbeda IP adress jadi kemungkinan aman.
									           </p>
									        </div>
									        <div class="card-header">
									            <h3 class="mt-0 mb-3 header-title">1. NEW ALGORITMA Produk Terjual</h3>
									        </div>
									        <div class="card-body">
									            <p>
									                MENDAPATKAN CASHBACK DAN BARANG YANG AKAN DIKIRIM KE ALAMAT SELLER untuk proses layanan ini kita membutuhkan di bawah ini - username | password | Link Produk seting pengaturan anda untuk mematikan OTP terlebih dahulu - isi data dengan username&password - proses ini membutuhkan wahtu 5-7 jam Ingat kita tidak membutuhkan pin atau OTP apapun Tidak Merubah Harga apapun<br><br>
									            </p>
									        </div>
							            </div>
							        </div>
					            </div>
				            </div>
			            </div>
		            </div>
	            </div>
	        </div>
        <!-- End Page Faq Tab -->

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