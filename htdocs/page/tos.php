<?php
session_start();
require '../config.php';
require '../lib/header.php';
?>

        <!-- Start Sub Header -->
        <div class="kt-subheader kt-grid__item" id="kt_subheader">
	        <div class="kt-container">
	            <div class="kt-subheader__main">
		            <h3 class="kt-subheader__title">Ketentuan Layanan</h3>
	                <div class="kt-subheader__breadcrumbs">
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
	                	<span class="kt-subheader__breadcrumbs-separator"></span>
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-link">Halaman Utama</a>
	                	<span class="kt-subheader__breadcrumbs-separator"></span>
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-link">Ketentuan Layanan</a>
	                </div>
	            </div>
	        </div>
        </div>
        <!-- End Sub Header -->

        <!-- Start Content -->
        <div class="kt-container kt-grid__item kt-grid__item--fluid">

        <!-- Start Page Tos -->
        <div class="row">
	        <div class="col-lg-12">
		        <div class="kt-portlet">
			        <div class="kt-portlet__head">
				        <div class="kt-portlet__head-label">
					        <h3 class="kt-portlet__head-title">
					            <i class="flaticon2-information text-primary"></i>
					            Ketentuan Layanan
					        </h3>
				        </div>
			        </div>
			        <div class="kt-portlet__body">
			        <h2>Layanan Yang Disediakan Oleh <?php echo $data['short_title']; ?> Telah Ditetapkan Kesepakatan-Kesepakatan Berikut.</h2><br />
			        <?php         
			        $cek_konten = $conn->query("SELECT * FROM ketentuan_layanan WHERE tipe = 'Layanan'");
			        while ($data_konten = $cek_konten->fetch_assoc()) {
			        ?>
			        <br /></span> <?php echo $data_konten['konten']; ?><br />
                    <?php } ?>
                    </div>                    
                </div>
            </div>
        </div>
        <!-- End Page Tos -->

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