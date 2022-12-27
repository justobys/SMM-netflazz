<?php
session_start();
require '../config.php';
require '../lib/session_user.php';
require '../lib/header.php';

	    if (isset($_GET['id'])) {
		    $id = filter($_GET['id']);

		    $cek_berita = $conn->query("SELECT * FROM berita WHERE id = '$id'");
		    $data_berita = mysqli_fetch_assoc($cek_berita);

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

		    if ($cek_berita->num_rows == 0) {
			    header("Location: ".$config['web']['url']."page/news");
		    } else {

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

        <!-- Start Page News Details -->
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
                    <div class="kt-portlet__body">
                        <div class="kt-notes">
                            <div class="kt-notes__items">
                                <div class="kt-notes__item">
                                    <div class="kt-notes__media">
                                        <span class="kt-notes__icon">
                                            <i class="<?php echo $label_icon; ?> text-primary"></i>
                                        </span>
                                    </div>
                                    <div class="kt-notes__content"> 
                                        <div class="kt-notes__section">
                                            <div class="kt-notes__info">
                                                <a href="<?php echo $config['web']['url'] ?>page/news?id=<?php echo $data_berita['id']; ?>" class="kt-notes__title">
                                                    <?php echo $data_berita['title']; ?>
                                                </a>
                                                <span class="kt-notes__desc">
                                                    (<?php echo tanggal_indo($data_berita['date']); ?>)
                                                </span>
                                                <span class="kt-badge kt-badge--<?php echo $label; ?> kt-badge--inline"><?php echo $data_berita['tipe']; ?></span>
                                            </div>
                                            <div class="kt-subheader__wrapper" data-toggle="kt-tooltip" title="" data-original-title="Mau Lihat?">
                                                <a href="<?php echo $config['web']['url'] ?>page/news?id=<?php echo $data_berita['id']; ?>" class="btn btn-sm btn-icon-md btn-icon">
                                                </a>
                                            </div>
                                        </div>
                                        <span class="kt-notes__body">
                                            <?php echo nl2br($data_berita['konten']); ?>
                                        </span>  
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End News Details -->

        </div>
        <!-- End Content -->

        <!-- Start Scrolltop -->
		<div id="kt_scrolltop" class="kt-scrolltop">
		    <i class="fa fa-arrow-up"></i>
		</div>
		<!-- End Scrolltop -->

<?php ?>

<?php 
require '../lib/footer.php';
}
} else {
	header("Location: ".$config['web']['url']."page/news");
}
?>