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
		            <h3 class="kt-subheader__title">Layanan Promo</h3>
	                <div class="kt-subheader__breadcrumbs">
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
	                	<span class="kt-subheader__breadcrumbs-separator"></span>
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-link">Halaman Utama</a>
	                	<span class="kt-subheader__breadcrumbs-separator"></span>
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-link">Layanan Promo</a>
	                </div>
	            </div>
	        </div>
        </div>
        <!-- End Sub Header -->

        <!-- Start Content -->
        <div class="kt-container kt-grid__item kt-grid__item--fluid">

        <!-- Start Page Service Promo -->
        <div class="row">
	        <div class="col-lg-12">
		        <div class="kt-portlet">
			        <div class="kt-portlet__head">
				        <div class="kt-portlet__head-label">
					        <h3 class="kt-portlet__head-title">
					            <i class="flaticon2-tag text-primary"></i>
					            Daftar Layanan Promo
					        </h3>
				        </div>
			        </div>
			        <div class="kt-portlet__body">
                        <div class="table-responsive">
                            <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
                                <thead>
                                    <tr>
                                        <th>Kategori</th>
                                        <th>Nama Layanan</th>
                                        <th>Harga Normal</th>
                                        <th>Harga Promo</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php 
// start paging config
$cek_promo = $conn->query("SELECT * FROM promo_layanan ORDER BY id DESC"); // edit
while ($data_promo = $cek_promo->fetch_assoc()) {
?>
                                    <tr>
                                        <td><?php echo $data_promo['kategori']; ?></td>
                                        <td><img src="<?php echo $config['web']['url'] ?>assets/media/logo-box/discount.svg" style="height:25px;"> <?php echo $data_promo['layanan']; ?></td>
                                        <td><span class="btn btn-brand btn-elevate btn-pill btn-elevate-air btn-sm">Rp <strike><?php echo number_format($data_promo['harga_normal'],0,',','.'); ?></strike></span></td>
                                        <td>Rp <?php echo number_format($data_promo['harga_promo'],0,',','.'); ?></td>
                                    </tr>   
<?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Service Promo -->

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