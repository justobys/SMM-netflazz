<?php
session_start();
require '../config.php';
require '../lib/header.php';
?>

        <!-- Start Sub Header -->
        <div class="kt-subheader kt-grid__item" id="kt_subheader">
	        <div class="kt-container">
	            <div class="kt-subheader__main">
		            <h3 class="kt-subheader__title">Penjelasan Status Pesanan</h3>
	                <div class="kt-subheader__breadcrumbs">
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
	                	<span class="kt-subheader__breadcrumbs-separator"></span>
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-link">Halaman Utama</a>
	                	<span class="kt-subheader__breadcrumbs-separator"></span>
	                    <a href="<?php echo $config['web']['url'] ?>page/penjelasan-pesanan" class="kt-subheader__breadcrumbs-link">Penjelasan Status Pesanan</a>
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
									            <h3 class="mt-0 mb-3 header-title"><i class="fa fa-file fa-fw"></i> Penjelasan Status pesanan</h3>
								            </div>
									        <div class="card-body">
									            <span class="badge badge-primary">Pending</span> <br> Pesanan/deposit sedang dalam antian di server.</li><br>
                                                <span class="badge badge-primary">Processing</span> <br> Pesanan sedang dalam proses.</li><br>
                                                <span class="badge badge-primary">Success</span> <br> Pesanan telah berhasil.</li><br>
                                                <span class="badge badge-primary">Partial</span> <br> Pesanan Sudah terproses tapi tercancel. Dan anda hanya akan membayar layanan yang masuk saja.</li><br>
                                                <span class="badge badge-primary">Eror</span> <br> Pesanan di batalkan, dan saldo akan otomatis kembali ke akun.</li><br>
                                                
                                                <br>
                                                    MENGAPA BISA PARTIAL???<br>
                                                    <span class="badge badge-primary">Limit</span> <br> Contoh jika satu layanan dengan maksimal 1.000 followers, kemudian anda membeli 1000 followers 2x di akun yang sama. kemungkinan besar akan terjadi partial. <br>
                                                    Karena akun (followers) yang ada di server tersebut hanya 1.000 followers. <br>
                                                    Jadi anda tidak bisa mengirim 2000 followers walaupun dengan cara 1000 2x pemesanan.<br>
                                                    Jika hal ini terjadi, silahkan gunakan server (Layanan) lainya.<br>
                                                    Hal ini tidak berpengaruh jika berbeda akun.<br>
                                                <br>
                                                    <span class="badge badge-primary">Server overload</span> <br> Overload terjadi karena terlalu banyak pesanan yang masuk sehingga terjadi overload dan partial.<br>
                                                    Untuk pesanan partial, sisa saldo layanan yang tidak masuk akan otomatis kembali ke akun.<br>
                                                <br>
                                                <br>
                                                    <span class="badge badge-primary">Garansi (Refill)</span> <br> Refill adalah isi ulang. Jika anda membeli layanan refill dan ternyata dalam beberapa hari followers berkurang, maka jika pesanan anda drop/turun anda bisa lapor melalui tiket dengan menyertakan id order dan request refill, jika nama layanan auto refill anda tidak perlu lapor ke admin karna proses refill otomatis tapi jika dalam 2x24 jam belum refill maka anda bisa lapor ke admin.</p>
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