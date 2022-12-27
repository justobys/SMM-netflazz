<?php
session_start();
require '../config.php';
require '../lib/header.php';
?>

        <!-- Start Sub Header -->
        <div class="kt-subheader kt-grid__item" id="kt_subheader">
	        <div class="kt-container">
	            <div class="kt-subheader__main">
		            <h3 class="kt-subheader__title">Kontak Kami</h3>
	                <div class="kt-subheader__breadcrumbs">
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
	                	<span class="kt-subheader__breadcrumbs-separator"></span>
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-link">Halaman Utama</a>
	                	<span class="kt-subheader__breadcrumbs-separator"></span>
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-link">Kontak Kami</a>
	                </div>
	            </div>
	        </div>
        </div>
        <!-- End Sub Header -->
        
        <!-- Start Content -->
        <div class="kt-container  kt-grid__item kt-grid__item--fluid">

		<!-- Start App -->
        <div class="kt-grid kt-grid--desktop kt-grid--ver kt-grid--ver-desktop kt-app">

        <!-- Start App Aside Mobile Toggle -->
        <button class="kt-app__aside-close" id="kt_contact_aside_close">
        <i class="la la-close"></i>
        </button>
        <!-- End App Aside Mobile Toggle -->

        <!-- Start App Aside -->
        <div class="kt-grid__item kt-app__toggle kt-app__aside" id="kt_contact_aside">

        <?php
        $cek_kontak = $conn->query("SELECT * FROM kontak_website ORDER BY id DESC");
        while ($data_kontak = $cek_kontak->fetch_assoc()) {
        ?>
        <!--Start Portlet -->
        <div class="kt-portlet">
            <div class="kt-portlet__body">
                <!-- Start Page Contact Website -->
                <div class="kt-widget kt-widget--user-profile-4">
                    <div class="kt-widget__head">
                        <div class="kt-widget__media">
                            <img class="kt-widget__img kt-hidden" src="<?php echo $config['web']['url'] ?>assets/media/logos/logo1.png" alt="image">
                            <div class="kt-widget__pic kt-widget__pic--success kt-font-success kt-font-boldest kt-font-light kt-hidden-">
                                <img class="kt-widget__pic kt-widget__pic--success kt-font-success kt-font-boldest kt-font-light kt-hidden-" src="<?php echo $config['web']['url'] ?>assets/media/logos/logo1.png" alt="image">
                            </div>
                        </div>       
                        <div class="kt-widget__content">
                            <div class="kt-widget__section">
                                <a href="#" class="kt-widget__username">
                                    <?php echo $data['title']; ?>
                                </a>
                                <div class="kt-widget__button">
                                    <button type="button" class="btn btn-label-warning btn-sm">Aktif</button>
                                </div>
                                <div class="kt-widget__action text-center">                             
                                    <a href="<?php echo $data_kontak['link_fb']; ?>" class="btn btn-icon btn-circle btn-label-facebook" target="_blank">
                                        <i class="flaticon-facebook-logo-button"></i>
                                    </a>
                                    <a href="<?php echo $data_kontak['link_ig']; ?>" class="btn btn-icon btn-circle btn-label-instagram" target="_blank">
                                        <i class="flaticon-instagram-logo"></i>
                                    </a>
                                    <a href="https://api.whatsapp.com/send?phone=<?php echo $data_kontak['no_wa']; ?>" class="btn btn-icon btn-circle btn-label-instagram" target="_blank">
                                        <i class="flaticon-whatsapp"></i>
                                    </a>
                                </div>
                            </div>
                        </div>  
                    </div>
                </div>
                <!-- End Page Contact Website -->
            </div>
        </div>
        <!-- End Portlet -->
        <?php
        }
        ?>

        </div>
        <!-- End App Aside -->  

        <!-- Start App Content -->
        <div class="kt-grid__item kt-grid__item--fluid kt-app__content">

        <!-- Start Section -->
        <div class="row">
        <?php
        $cek_kontak = $conn->query("SELECT * FROM kontak_admin ORDER BY id DESC");
        while ($data_kontak = $cek_kontak->fetch_assoc()) {
        ?>
            <div class="col-lg-6">
                <!-- Start Page Contact Admin -->
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-portlet__head kt-portlet__head--noborder">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title"></h3>
                        </div>
                        <div class="kt-portlet__head-toolbar"></div>
                    </div>
                    <div class="kt-portlet__body">
                        <div class="kt-widget kt-widget--user-profile-2">
                            <div class="kt-widget__head">
                                <div class="kt-widget__media">
                                    <img class="kt-widget__img kt-hidden-" src="<?php echo $config['web']['url'] ?>assets/media/logos/logo1.png" alt="image">
                                    <div class="kt-widget__pic kt-widget__pic--success kt-font-success kt-font-boldest kt-hidden">
                                        ArCode
                                    </div>
                                </div>
                                <div class="kt-widget__info">
                                    <a href="#" class="kt-widget__username">
                                        <?php echo $data_kontak['nama']; ?>
                                    </a>
                                    <span class="kt-widget__desc">
                                        <?php echo $data_kontak['jabatan']; ?>
                                    </span>
                                </div>
                            </div>
                            <div class="kt-widget__body">
                                <div class="kt-widget__section">
                                    <?php echo $data_kontak['deskripsi']; ?>
                                </div>                                        
                                <div class="kt-widget__item">
                                    <div class="kt-widget__contact">
                                        <span class="kt-widget__label">Email :</span>
                                        <a href="#" class="kt-widget__data"><?php echo $data_kontak['email']; ?></a>
                                    </div>
                                    <div class="kt-widget__contact">
                                        <span class="kt-widget__label">WhatsApp :</span>
                                        <a href="#" class="kt-widget__data"><?php echo $data_kontak['no_hp']; ?></a>
                                    </div>
                                    <div class="kt-widget__contact">
                                        <span class="kt-widget__label">Jam Kerja :</span>
                                        <span class="kt-widget__data"><?php echo $data_kontak['jam_kerja']; ?></span>
                                    </div>
                                    <!--<div class="kt-widget__contact">
                                        <span class="kt-widget__label">Lokasi :</span>
                                        <span class="kt-widget__data"><?php echo $data_kontak['lokasi']; ?></span>
                                    </div>-->
                                </div>
                            </div>
                            <br />
                            <br />
                            <div class="kt-widget__action text-center">                             
                                <a href="<?php echo $data_kontak['link_fb']; ?>" class="btn btn-icon btn-circle btn-label-facebook" target="_blank">
                                    <i class="flaticon-facebook-logo-button"></i>
                                </a>
                                <a href="<?php echo $data_kontak['link_ig']; ?>" class="btn btn-icon btn-circle btn-label-instagram" target="_blank">
                                    <i class="flaticon-instagram-logo"></i>
                                </a>
                                <a href="https://api.whatsapp.com/send?phone=<?php echo $data_kontak['no_hp']; ?>" class="btn btn-icon btn-circle btn-label-instagram" target="_blank">
                                    <i class="flaticon-whatsapp"></i>
                                </a>                            
                            </div>
                        </div>         
                    </div>
                </div>
                <!-- End Page Contact Admin -->
            </div>
        <?php
        }
        ?>
        </div>
        <!-- End Section -->

        </div>
        <!-- End App Content -->

        </div>
        <!-- End App -->

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