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
		            <h3 class="kt-subheader__title">Berita & Informasi</h3>
	                <div class="kt-subheader__breadcrumbs">
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
	                	<span class="kt-subheader__breadcrumbs-separator"></span>
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-link">Halaman Utama</a>
	                	<span class="kt-subheader__breadcrumbs-separator"></span>
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-link">Berita & Informasi</a>
	                </div>
	            </div>
	        </div>
        </div>
        <!-- End Sub Header -->

        <!-- Start Content -->
        <div class="kt-container kt-grid__item kt-grid__item--fluid">

        <!-- Start Page News -->
        <div class="row">
	        <div class="col-lg-12">
		        <div class="kt-portlet">
			        <div class="kt-portlet__head">
				        <div class="kt-portlet__head-label">
					        <h3 class="kt-portlet__head-title">
					            <i class="flaticon2-bell text-primary"></i>
					            Berita & Informasi
					        </h3>
				        </div>
			        </div>
			        <?php
			        $cek_berita = $conn->query("SELECT * FROM berita ORDER BY id DESC");
			        while ($data_berita = $cek_berita->fetch_assoc()) {
			        if ($data_berita['tipe'] == "INFO") {
                        $label = "info";
			        } else if ($data_berita['tipe'] == "PERINGATAN") {
                        $label = "warning";
			        } else if ($data_berita['tipe'] == "PENTING") {
                        $label = "danger";
			        }

			        if ($data_berita['icon'] == "PESANAN") {
                        $label_icon = "flaticon2-shopping-cart";
			        } else if ($data_berita['icon'] == "LAYANAN") {
                        $label_icon = "flaticon-signs-1";
			        } else if ($data_berita['icon'] == "DEPOSIT") {
                        $label_icon = "flaticon-coins";
			        } else if ($data_berita['icon'] == "PENGGUNA") {
                        $label_icon = "flaticon2-user";
			        } else if ($data_berita['icon'] == "PROMO") {
                        $label_icon = "flaticon2-percentage";
			        }
			        ?>
        	        <table class="table footable toggle-square">
                    <tbody>
                    <tr>
        	        <td width="20">
        	            <a href="<?php echo $config['web']['url'] ?>page/news-details?id=<?php echo $data_berita['id']; ?>" class="btn btn-<?php echo $label; ?> btn-elevate btn-circle btn-icon"><i class="<?php echo $label_icon; ?>"></i></a>
        	        </td>
        	        <td style="vertical-align: middle !important;">
        	            <h6><a href="<?php echo $config['web']['url'] ?>page/news-details?id=<?php echo $data_berita['id']; ?>" class="text-dark"><?php echo $data_berita['title']; ?></a></h6>
        	        </td>
        	        <td>
        	            <a href="<?php echo $config['web']['url'] ?>page/news-details?id=<?php echo $data_berita['id']; ?>" class="btn btn-brand btn-elevate btn-pill btn-elevate-air btn-sm"><i class="flaticon-eye"></i> Lihat Berita</a>
        	        </td>
        	        </tr>
                    </tbody>
                    </table>
<?php } ?>
                </div>
            </div>
        </div>
        <!-- End Page News -->

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