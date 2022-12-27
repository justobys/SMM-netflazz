<?php
require 'session_login.php';
require 'database.php';
require 'csrf_token.php';
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

        <title><?php echo $data['title']; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta content="<?php echo $data['deskripsi_web']; ?>" name="description" />
        <meta content="MALING" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- Start Favicon -->
        <link rel="icon" href="<?php echo $config['web']['url'] ?>assets/media/logos/favicon.png" type="image/png">
        <!-- End Favicon -->

        <!-- Start CSS -->
        <link href="<?php echo $config['web']['url'] ?>assets/plugins/global/plugins-2.bundle.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $config['web']['url'] ?>assets/css/style-2.bundle.css" rel="stylesheet" type="text/css" />
        <!-- End CSS -->

        <!-- Start Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700">
        <!-- End Fonts -->

        <!-- Start Script JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
        <!-- End Script JS -->
        
        <!-- Start Script Morris Chart -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
        <!-- End Script Morris Chart -->

        <!-- Start Hotjar Tracking -->
        <script>
        (function(h,o,t,j,a,r){
            h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
            h._hjSettings={hjid:1070954,hjsv:6};
            a=o.getElementsByTagName('head')[0];
            r=o.createElement('script');r.async=1;
            r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
            a.appendChild(r);
        })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
        </script>
        <!-- End Hotjar Tracking -->
        
        <!-- Start Global Site Tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-37564768-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'UA-37564768-1');
        </script>
        <!-- End Global Site Tag (gtag.js) - Google Analytics -->

        <!-- Start Body -->
        <body  class="kt-page--loading-enabled kt-page--loading kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header--minimize-menu kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-aside--enabled kt-aside--left kt-aside--fixed kt-page--loading">
<style>
@import url('https://fonts.googleapis.com/css2?family=Nunito:wght@200&display=swap');
</style>
    	<!-- Start Page -->

    	<!-- Start Header Mobile -->
    	<div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed">
	        <div class="kt-header-mobile__logo">
		        <a href="<?php echo $config['web']['url'] ?>">admin
			        <img alt="Logo" src="<?php echo $config['web']['url'] ?>assets/media/logos/netflazz.png" height="50" width="170"/>
		        </a>
	        </div>
	        <div class="kt-header-mobile__toolbar">
			<button class="kt-header-mobile__toolbar-toggler kt-header-mobile__toolbar-toggler--left" id="kt_aside_mobile_toggler"><span></span></button>
		        
		        <button class="kt-header-mobile__toolbar-topbar-toggler" id="kt_header_mobile_topbar_toggler"><i class="flaticon-more-1"></i></button>
	        </div>
    	</div>
    	<!-- End Header Mobile -->

    	<!-- Start Grid -->
    	<div class="kt-grid kt-grid--hor kt-grid--root">
		    <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
			    <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">

    	<!--Start Header -->
        <div id="kt_header" class="kt-header kt-header--fixed" data-ktheader-minimize="on">
	        <div class="kt-container kt-container--fluid">

		<!-- Start Header Menu -->
		<button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
		<div class="kt-header-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_header_menu_wrapper">
    	    <button class="kt-aside-toggler kt-aside-toggler--left" id="kt_aside_toggler"><span></span></button>
	        <div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile"></div>
		</div>
		<!-- End Header Menu -->

		<!-- Start Brand -->
		<div class="kt-header__brand   kt-grid__item" id="kt_header_brand">
			<a class="kt-header__brand-logo" href="<?php echo $config['web']['url'] ?>admin">
		        <img alt="Logo" src="<?php echo $config['web']['url'] ?>assets/media/logos/netflazz.png" height="50" width="170"/>		
			</a>		
		</div>
		<!-- End Brand -->

		<!-- Start Header Topbar -->
		<div class="kt-header__topbar kt-grid__item">

		<!-- Start User Bar -->
		<div class="kt-header__topbar-item kt-header__topbar-item--user">
		    <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">
			    <span class="kt-header__topbar-welcome">Hallo,</span>
			    <span class="kt-header__topbar-username"><?php echo $data_user['username']; ?></span>
			    <span class="kt-header__topbar-icon"><b>P</b></span>
			    <img alt="Pic" src="<?php echo $config['web']['url'] ?>assets/media/icon/user.jpg" class="kt-hidden"/>
		    </div>
		<div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-xl">

		<!-- Start Head -->
		<div class="kt-user-card kt-user-card--skin-dark kt-notification-item-padding-x" style="background-image: url(<?php echo $config['web']['url'] ?>assets/media/bg/bg-2.png)">
            <div class="kt-user-card__avatar">
                <img class="kt-hidden" alt="Pic" src="<?php echo $config['web']['url'] ?>assets/media/icon/user.jpg" />
                <span class="kt-badge kt-badge--lg kt-badge--rounded kt-badge--bold kt-font-success">P</span>
            </div>
            <div class="kt-user-card__name">
                <?php echo $data_user['nama']; ?>
            </div>
        </div>
        <!-- End Head -->

        <!-- Start Navigation -->
        <div class="kt-notification">
            <a href="<?php echo $config['web']['url'] ?>page/profile" class="kt-notification__item">
                <div class="kt-notification__item-icon">
                    <i class="flaticon2-calendar-3 kt-font-success"></i>
                </div>
                <div class="kt-notification__item-details">
                    <div class="kt-notification__item-title kt-font-bold">
                        Profile
                    </div>
                    <div class="kt-notification__item-time">
                        Pengaturan Akun
                    </div>
                </div>
            </a>
            <a href="<?php echo $config['web']['url'] ?>history/account-activity" class="kt-notification__item">
                <div class="kt-notification__item-icon">
                    <i class="flaticon2-rocket-1 kt-font-danger"></i>
                </div>
                <div class="kt-notification__item-details">
                    <div class="kt-notification__item-title kt-font-bold">
                        Aktifitas
                    </div>
                    <div class="kt-notification__item-time">
                        Riwayat Akun
                    </div>
                </div>
            </a>
            <a href="<?php echo $config['web']['url'] ?>history/balance" class="kt-notification__item">
                <div class="kt-notification__item-icon">
                    <i class="flaticon-coins kt-font-primary"></i>
                </div>
                <div class="kt-notification__item-details">
                    <div class="kt-notification__item-title kt-font-bold">
                        Saldo
                    </div>
                    <div class="kt-notification__item-time">
                        Riwayat Pemakaian Saldo
                    </div>
                </div>
            </a>
            <a href="<?php echo $config['web']['url'] ?>history/order" class="kt-notification__item">
                <div class="kt-notification__item-icon">
                    <i class="flaticon2-shopping-cart kt-font-warning"></i>
                </div>
                <div class="kt-notification__item-details">
                    <div class="kt-notification__item-title kt-font-bold">
                        Pesanan
                    </div>
                    <div class="kt-notification__item-time">
                        Tagihan Pesanan <span class="kt-badge kt-badge--danger kt-badge--inline kt-badge--pill kt-badge--rounded">0 Pending</span>
                    </div>
                </div>
            </a>
            <div class="kt-notification__custom kt-space-between">
                <a href="<?php echo $config['web']['url'] ?>logout" class="btn btn-label btn-label-brand btn-sm btn-bold">Keluar</a>
            </div>
        </div>
        <!-- End Navigation -->

	        </div>
        </div>
        <!-- End User Bar -->

        </div>
        <!-- End Header Topbar -->

	        </div>
        </div>
        <!-- End Header -->

		<!-- Start Aside -->
		<button class="kt-aside-close " id="kt_aside_close_btn"><i class="la la-close"></i></button>
		<div class="kt-aside  kt-aside--fixed  kt-grid__item kt-grid kt-grid--desktop kt-grid--hor-desktop" id="kt_aside">

		<!-- Start Aside Menu -->
		<div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
		    <div id="kt_aside_menu" class="kt-aside-menu" data-ktmenu-vertical="1" data-ktmenu-scroll="1">		
			    <ul class="kt-menu__nav ">
				    <li class="kt-menu__item" aria-haspopup="true">
				        <a href="<?php echo $config['web']['url'] ?>" class="kt-menu__link">
				            <i class="kt-menu__link-icon fa fa-home"></i>
				            <span class="kt-menu__link-text">Halaman Member</span>
				        </a>
				    </li>
				    <li class="kt-menu__item" aria-haspopup="true">
				        <a href="<?php echo $config['web']['url'] ?>admin" class="kt-menu__link">
				            <i class="kt-menu__link-icon fa fa-home"></i>
				            <span class="kt-menu__link-text">Halaman Admin</span>
				        </a>
				    </li>
				    <li class="kt-menu__section">
				        <h4 class="kt-menu__section-text">Menu</h4>
				        <i class="kt-menu__section-icon flaticon-more-v2"></i>
				    </li>
				    <li class="kt-menu__item" aria-haspopup="true">
				        <a href="<?php echo $config['web']['url'] ?>admin/daftar-pengguna" class="kt-menu__link">
				            <i class="kt-menu__link-icon fa fa-user"></i>
				            <span class="kt-menu__link-text">Daftar Pengguna</span>
				        </a>
				    </li>
				    <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
				        <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
				            <i class="kt-menu__link-icon fa fa-cart-plus"></i>
				            <span class="kt-menu__link-text">Daftar Pesanan</span><i class="kt-menu__ver-arrow la la-angle-right"></i>
				        </a>
				        <div class="kt-menu__submenu ">
				            <span class="kt-menu__arrow"></span>
				            <ul class="kt-menu__subnav">
				                <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true">
				                    <span class="kt-menu__link">
				                        <span class="kt-menu__link-text">Daftar Pesanan</span>
				                    </span>
				                </li>
				                <li class="kt-menu__item" aria-haspopup="true">
				                    <a href="<?php echo $config['web']['url'] ?>admin/daftar-pesanan-sosial-media" class="kt-menu__link">
				                        <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
				                        <span></span>
				                        </i>
				                        <span class="kt-menu__link-text">Sosial Media</span>
				                    </a>
				                </li>
				                <li class="kt-menu__item" aria-haspopup="true">
				                    <a href="<?php echo $config['web']['url'] ?>admin/daftar-pesanan-top-up" class="kt-menu__link">
				                        <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
				                        <span></span>
				                        </i>
				                        <span class="kt-menu__link-text">Top Up</span>
				                    </a>
				                </li>
				            </ul>
				        </div>
				    </li>
				    <li class="kt-menu__item  kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
				        <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
				            <i class="kt-menu__link-icon fa fa-list"></i>
				            <span class="kt-menu__link-text">Daftar Layanan</span><i class="kt-menu__ver-arrow la la-angle-right"></i>
				        </a>
				        <div class="kt-menu__submenu ">
				            <span class="kt-menu__arrow"></span>
				            <ul class="kt-menu__subnav">
				                <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true">
				                    <span class="kt-menu__link">
				                        <span class="kt-menu__link-text">Daftar Layanan</span>
				                    </span>
				                </li>
				                <li class="kt-menu__item" aria-haspopup="true">
				                    <a href="<?php echo $config['web']['url'] ?>admin/daftar-layanan-sosial-media" class="kt-menu__link">
				                        <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
				                        <span></span>
				                        </i>
				                        <span class="kt-menu__link-text">Sosial Media</span>
				                    </a>
				                </li>
				                <li class="kt-menu__item" aria-haspopup="true">
				                    <a href="<?php echo $config['web']['url'] ?>admin/daftar-layanan-top-up" class="kt-menu__link">
				                        <i class="kt-menu__link-bullet kt-menu__link-bullet--dot">
				                        <span></span>
				                        </i>
				                        <span class="kt-menu__link-text">Top Up</span>
				                    </a>
				                </li>
				                </ul>
				        </div>
				    </li>
				    <li class="kt-menu__item" aria-haspopup="true">
				        <a href="<?php echo $config['web']['url'] ?>admin/daftar-kategori-layanan" class="kt-menu__link">
				            <i class="kt-menu__link-icon fa fa-list-alt"></i>
				            <span class="kt-menu__link-text">Daftar Kategori</span>
				        </a>
				    </li>
				    <li class="kt-menu__item" aria-haspopup="true">
				        <a href="<?php echo $config['web']['url'] ?>admin/daftar-tiket" class="kt-menu__link">
				            <i class="kt-menu__link-icon fa fa-paper-plane"></i>
				            <span class="kt-menu__link-text">Daftar Tiket</span> <?php if (mysqli_num_rows($TiketAdmin) !== 0) { ?><span class="badge badge-primary"><?php echo mysqli_num_rows($TiketAdmin); ?></span><?php } ?>
				        </a>
				    </li>
				    <li class="kt-menu__item" aria-haspopup="true">
				        <a href="<?php echo $config['web']['url'] ?>admin/daftar-layanan-promo" class="kt-menu__link">
				            <i class="kt-menu__link-icon fa fa-list-alt"></i>
				            <span class="kt-menu__link-text">Daftar Layanan Promo</span>
				        </a>
				    </li>
				    <li class="kt-menu__item" aria-haspopup="true">
				        <a href="<?php echo $config['web']['url'] ?>admin/daftar-berita" class="kt-menu__link">
				            <i class="kt-menu__link-icon fa fa-bell"></i>
				            <span class="kt-menu__link-text">Daftar Berita</span>
				        </a>
				    </li>
				    <li class="kt-menu__item" aria-haspopup="true">
				        <a href="<?php echo $config['web']['url'] ?>admin/daftar-ketentuan-layanan" class="kt-menu__link">
				            <i class="kt-menu__link-icon flaticon2-information"></i>
				            <span class="kt-menu__link-text">Daftar Ketentuan Layanan</span>
				        </a>
				    </li>
				    <li class="kt-menu__item" aria-haspopup="true">
				        <a href="<?php echo $config['web']['url'] ?>admin/daftar-pertanyaan-umum" class="kt-menu__link">
				            <i class="kt-menu__link-icon fa fa-layer-group"></i>
				            <span class="kt-menu__link-text">Daftar Pertanyaan Umum</span>
				        </a>
				    </li>
				    <li class="kt-menu__item" aria-haspopup="true">
				        <a href="<?php echo $config['web']['url'] ?>admin/daftar-kontak" class="kt-menu__link">
				            <i class="kt-menu__link-icon fa fa-phone"></i>
				            <span class="kt-menu__link-text">Daftar Kontak</span>
				        </a>
				    </li>
				    <li class="kt-menu__section ">
				        <h4 class="kt-menu__section-text">Pengaturan Mutasi</h4>
				        <i class="kt-menu__section-icon flaticon-more-v2"></i>
				    </li>
				    <li class="kt-menu__item" aria-haspopup="true">
				        <a href="<?php echo $config['web']['url'] ?>admin/daftar-mutasi" class="kt-menu__link">
				            <i class="kt-menu__link-icon fa fa-credit-card"></i>
				            <span class="kt-menu__link-text">Semua Mutasi</span>
				        </a>
				    </li>
				    <li class="kt-menu__item" aria-haspopup="true">
				        <a href="<?php echo $config['web']['url'] ?>admin/daftar-isi-saldo" class="kt-menu__link">
				            <i class="kt-menu__link-icon fa fa-credit-card"></i>
				            <span class="kt-menu__link-text">Daftar Isi Saldo</span>
				        </a>
				    </li>
				    <li class="kt-menu__section ">
				        <h4 class="kt-menu__section-text">Aktifitas</h4>
				        <i class="kt-menu__section-icon flaticon-more-v2"></i>
				    </li>
				    <li class="kt-menu__item" aria-haspopup="true">
				        <a href="<?php echo $config['web']['url'] ?>admin/daftar-aktifitas-pengguna" class="kt-menu__link">
				            <i class="kt-menu__link-icon fa fa-users"></i>
				            <span class="kt-menu__link-text">Aktifitas Pengguna</span>
				        </a>
				    </li>
				    <li class="kt-menu__item" aria-haspopup="true">
				        <a href="<?php echo $config['web']['url'] ?>admin/daftar-penggunaan-saldo-koin" class="kt-menu__link">
				            <i class="kt-menu__link-icon fa fa-history"></i>
				            <span class="kt-menu__link-text">Penggunaan Saldo</span>
				        </a>
				    </li>
				    <li class="kt-menu__item" aria-haspopup="true">
				        <a href="<?php echo $config['web']['url'] ?>admin/daftar-transfer-saldo" class="kt-menu__link">
				            <i class="kt-menu__link-icon fa fa-exchange-alt"></i>
				            <span class="kt-menu__link-text">Transfer Saldo</span>
				        </a>
				    </li>
				    <li class="kt-menu__section ">
				        <h4 class="kt-menu__section-text">Pengaturan</h4>
				        <i class="kt-menu__section-icon flaticon-more-v2"></i>
				    </li>
				    <li class="kt-menu__item" aria-haspopup="true">
				        <a href="<?php echo $config['web']['url'] ?>admin/pengaturan-website" class="kt-menu__link">
				            <i class="kt-menu__link-icon fa fa-globe"></i>
				            <span class="kt-menu__link-text">Website</span>
				        </a>
				    </li>
				    <li class="kt-menu__item" aria-haspopup="true">
				        <a href="<?php echo $config['web']['url'] ?>admin/daftar-pembayaran-isi-saldo" class="kt-menu__link">
				            <i class="kt-menu__link-icon fa fa-credit-card"></i>
				            <span class="kt-menu__link-text">Deposit Manual</span>
				        </a>
				    </li>
                      <li class="kt-menu__item" aria-haspopup="true">
				        <a href="<?php echo $config['web']['url'] ?>admin/pengaturan-keuntungan-bulanan" class="kt-menu__link">
				            <i class="kt-menu__link-icon fa fa-money-bill"></i>
				            <span class="kt-menu__link-text">Keuntungan Layanan</span>
				        </a>
				    </li>
				    <li class="kt-menu__item" aria-haspopup="true">
				        <a href="<?php echo $config['web']['url'] ?>admin/pengaturan-keuntungan-harga-layanan" class="kt-menu__link">
				            <i class="kt-menu__link-icon fa fa-money-bill"></i>
				            <span class="kt-menu__link-text">Keuntungan Harga Layanan</span>
				        </a>
				    </li>
				    <li class="kt-menu__section ">
				        <h4 class="kt-menu__section-text">Lainnya</h4>
				        <i class="kt-menu__section-icon flaticon-more-v2"></i>
				    </li>
				    <li class="kt-menu__item" aria-haspopup="true">
				        <a href="<?php echo $config['web']['url'] ?>admin/provider-layanan" class="kt-menu__link">
				            <i class="kt-menu__link-icon fa fa-cog"></i>
				            <span class="kt-menu__link-text">Provider Layanan</span>
				        </a>
				    </li>
				    <li class="kt-menu__item" aria-haspopup="true">
				        <a href="<?php echo $config['web']['url'] ?>admin/daftar-laporan-pusat" class="kt-menu__link">
				            <i class="kt-menu__link-icon fa fa-book"></i>
				            <span class="kt-menu__link-text">Laporan Saldo Pusat</span>
				        </a>
				    </li>
				    <li class="kt-menu__item" aria-haspopup="true">
				        <a href="<?php echo $config['web']['url'] ?>admin/tombol-jadwal" class="kt-menu__link">
				            <i class="kt-menu__link-icon fa fa-calendar"></i>
				            <span class="kt-menu__link-text">Tombol Jadwal</span>
				        </a>
				    </li>
		        </ul>
		    </div>
	    </div>
	    <!-- End Aside Menu -->

        </div>
        <!-- End Aside -->

		<div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
			<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">