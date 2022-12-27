<?php
session_start();
require '../config.php';
require '../lib/session_login_admin.php';
require '../lib/header_admin.php';

        // ===== Halaman Admin ===== //

        // Data Grafik Pesanan Sosial Media
        $check_order_today = $conn->query("SELECT * FROM pembelian_sosmed WHERE date ='$date'");

        $oneday_ago = date('Y-m-d', strtotime("-1 day"));
        $check_order_oneday_ago = $conn->query("SELECT * FROM pembelian_sosmed WHERE date ='$oneday_ago'");

        $twodays_ago = date('Y-m-d', strtotime("-2 day"));
        $check_order_twodays_ago = $conn->query("SELECT * FROM pembelian_sosmed WHERE date ='$twodays_ago'");

        $threedays_ago = date('Y-m-d', strtotime("-3 day"));
        $check_order_threedays_ago = $conn->query("SELECT * FROM pembelian_sosmed WHERE date ='$threedays_ago'");

        $fourdays_ago = date('Y-m-d', strtotime("-4 day"));
        $check_order_fourdays_ago = $conn->query("SELECT * FROM pembelian_sosmed WHERE date ='$fourdays_ago'");

        $fivedays_ago = date('Y-m-d', strtotime("-5 day"));
        $check_order_fivedays_ago = $conn->query("SELECT * FROM pembelian_sosmed WHERE date ='$fivedays_ago'");

        $sixdays_ago = date('Y-m-d', strtotime("-6 day"));
        $check_order_sixdays_ago = $conn->query("SELECT * FROM pembelian_sosmed WHERE date ='$sixdays_ago'");

        // Data Selesai

        // Data Grafik Pesanan Top Up
        $check_order_pulsa_today = $conn->query("SELECT * FROM pembelian_pulsa WHERE date ='$date'");

        $oneday_ago = date('Y-m-d', strtotime("-1 day"));
        $check_order_pulsa_oneday_ago = $conn->query("SELECT * FROM pembelian_pulsa WHERE date ='$oneday_ago'");

        $twodays_ago = date('Y-m-d', strtotime("-2 day"));
        $check_order_pulsa_twodays_ago = $conn->query("SELECT * FROM pembelian_pulsa WHERE date ='$twodays_ago'");

        $threedays_ago = date('Y-m-d', strtotime("-3 day"));
        $check_order_pulsa_threedays_ago = $conn->query("SELECT * FROM pembelian_pulsa WHERE date ='$threedays_ago'");

        $fourdays_ago = date('Y-m-d', strtotime("-4 day"));
        $check_order_pulsa_fourdays_ago = $conn->query("SELECT * FROM pembelian_pulsa WHERE date ='$fourdays_ago'");

        $fivedays_ago = date('Y-m-d', strtotime("-5 day"));
        $check_order_pulsa_fivedays_ago = $conn->query("SELECT * FROM pembelian_pulsa WHERE date ='$fivedays_ago'");

        $sixdays_ago = date('Y-m-d', strtotime("-6 day"));
        $check_order_pulsa_sixdays_ago = $conn->query("SELECT * FROM pembelian_pulsa WHERE date ='$sixdays_ago'");

        // Data Selesai

        // Data Grafik Pesanan Pascabayar
        $check_order_pascabayar_today = $conn->query("SELECT * FROM pembelian_pascabayar WHERE date ='$date'");

        $oneday_ago = date('Y-m-d', strtotime("-1 day"));
        $check_order_pascabayar_oneday_ago = $conn->query("SELECT * FROM pembelian_pascabayar WHERE date ='$oneday_ago'");

        $twodays_ago = date('Y-m-d', strtotime("-2 day"));
        $check_order_pascabayar_twodays_ago = $conn->query("SELECT * FROM pembelian_pascabayar WHERE date ='$twodays_ago'");

        $threedays_ago = date('Y-m-d', strtotime("-3 day"));
        $check_order_pascabayar_threedays_ago = $conn->query("SELECT * FROM pembelian_pascabayar WHERE date ='$threedays_ago'");

        $fourdays_ago = date('Y-m-d', strtotime("-4 day"));
        $check_order_pascabayar_fourdays_ago = $conn->query("SELECT * FROM pembelian_pascabayar WHERE date ='$fourdays_ago'");

        $fivedays_ago = date('Y-m-d', strtotime("-5 day"));
        $check_order_pascabayar_fivedays_ago = $conn->query("SELECT * FROM pembelian_pascabayar WHERE date ='$fivedays_ago'");

        $sixdays_ago = date('Y-m-d', strtotime("-6 day"));
        $check_order_pascabayar_sixdays_ago = $conn->query("SELECT * FROM pembelian_pascabayar WHERE date ='$sixdays_ago'");

        // Data Selesai

?>
        <!-- Start Sub Header -->
        <div class="kt-subheader kt-grid__item" id="kt_subheader">
	        <div class="kt-container ">
	            <div class="kt-subheader__main">
                    <h3 class="kt-subheader__title">Halaman Admin</h3>
                    <span class="kt-subheader__separator kt-hidden"></span>
                    <div class="kt-subheader__breadcrumbs">
                        <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                        <span class="kt-subheader__breadcrumbs-separator"></span>
                        <a href="#" class="kt-subheader__breadcrumbs-link">Halaman Admin</a>
	                </div>
	            </div>
	        </div>
        </div>
        <!-- End Sub Header -->

        <!-- Start Content -->
        <div class="kt-container kt-grid__item kt-grid__item--fluid">

        <!-- Start Page Box Data -->
        <div class="row">
            <div class="col-md-12">
                <div class="kt-portlet">
                    <a href="<?php echo $config['web']['url'] ?>admin/daftar-pengguna" class="kt-iconbox btn btn-danger">
                        <div class="kt-portlet__body">
                            <div class="kt-iconbox__body">
                                <div class="kt-iconbox__icon">
 				                    <img src="<?php echo $config['web']['url'] ?>assets/media/icon/user.svg" width="60px">
                                </div>
                                <div class="kt-iconbox__desc text-left">
                                    <h4 class="kt-iconbox__title">
								        <font color="white"><?php echo $total_pengguna; ?> Pengguna</font>
							        </h4>
                                    <div class="kt-iconbox__content">
                                        <font color="white">Total Pengguna</font>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="kt-portlet">
                    <a href="<?php echo $config['web']['url'] ?>admin/daftar-pesanan-sosial-media" class="kt-iconbox btn btn-primary">
                        <div class="kt-portlet__body">
                            <div class="kt-iconbox__body">
                                <div class="kt-iconbox__icon">
 				                    <img src="<?php echo $config['web']['url'] ?>assets/media/icon/instagram.svg" width="60px">
                                </div>
                                <div class="kt-iconbox__desc text-left">
                                    <h4 class="kt-iconbox__title">
								        <font color="white">Rp <?php echo number_format($data_pesanan_sosmed['total'],0,',','.'); ?> (Dari <?php echo $count_pesanan_sosmed; ?> Pesanan)</font>
							        </h4>
                                    <div class="kt-iconbox__content">
                                        <font color="white">Total Pemesanan Sosial Media</font>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="kt-portlet">
                    <a href="<?php echo $config['web']['url'] ?>admin/daftar-pesanan-top-up" class="kt-iconbox btn btn-warning">
                        <div class="kt-portlet__body">
                            <div class="kt-iconbox__body">
                                <div class="kt-iconbox__icon">
				                    <img src="<?php echo $config['web']['url'] ?>assets/media/icon/smartphone.svg" width="60px">
				                </div>
                                <div class="kt-iconbox__desc text-left">
                                    <h4 class="kt-iconbox__title">
								        <font color="white">Rp <?php echo number_format($data_pesanan_pulsa['total'],0,',','.'); ?> (Dari <?php echo $count_pesanan_pulsa; ?> Pesanan)</font>
							        </h4>
                                    <div class="kt-iconbox__content">
                                        <font color="white">Total Pemesanan Top Up</font>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="kt-portlet">
                    <a href="<?php echo $config['web']['url'] ?>admin/daftar-isi-saldo" class="kt-iconbox btn btn-success">
                        <div class="kt-portlet__body">
                            <div class="kt-iconbox__body">
                                <div class="kt-iconbox__icon">
				                    <img src="<?php echo $config['web']['url'] ?>assets/media/icon/bank-deposit.svg" width="60px">
				                </div>
                                <div class="kt-iconbox__desc text-left">
                                    <h4 class="kt-iconbox__title">
								        <font color="white">Rp <?php echo number_format($data_deposit['total'],0,',','.'); ?> (Dari <?php echo $count_deposit; ?> Isi Saldo)</font>
							        </h4>
                                    <div class="kt-iconbox__content">
                                        <font color="white">Total Isi Saldo</font>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <!-- End Page Box Data -->

        <!-- Start Page Data Laporan Talk Per Month -->
        <div class="row">
	        <div class="col-lg-6">
		        <div class="kt-portlet">
			        <div class="kt-portlet__head">
				        <div class="kt-portlet__head-label">
					        <h3 class="kt-portlet__head-title">
					            <i class="fa fa-book text-primary"></i>
					            Laporan Penghasilan Layanan Sosial Media Bulanan
					        </h3>
				        </div>
			        </div>
			        <div class="kt-portlet__body">
                        <div class="table-responsive">
                            <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
                                <thead>
                                    <tr>
                                        <th>Total Pesanan</th>
                                        <th>Penghasilan Kotor</th>
                                        <th>Penghasilan Bersih</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr> 
                                        <td><span class="badge badge-primary"><?php echo $CountProfitSosmed; ?></span></td>
                                        <td><span class="badge badge-success">Rp <?php echo number_format($AllSosmed['total'],0,',','.') ?></span></td>
                                        <td><span class="badge badge-warning">Rp <?php echo number_format($ProfitSosmed['total'],0,',','.'); ?></span></td>
                                    </tr>  
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

	        <div class="col-lg-6">
		        <div class="kt-portlet">
			        <div class="kt-portlet__head">
				        <div class="kt-portlet__head-label">
					        <h3 class="kt-portlet__head-title">
					            <i class="fa fa-book text-primary"></i>
					            Laporan Penghasilan Layanan Top Up Bulanan
					        </h3>
				        </div>
			        </div>
			        <div class="kt-portlet__body">
                        <div class="table-responsive">
                            <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
                                <thead>
                                    <tr>
                                        <th>Total Pesanan</th>
                                        <th>Penghasilan Kotor</th>
                                        <th>Penghasilan Bersih</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr> 
                                        <td><span class="badge badge-primary"><?php echo $CountProfitPulsa; ?></span></td>
                                        <td><span class="badge badge-success">Rp <?php echo number_format($AllPulsa['total'],0,',','.') ?></span></td>
                                        <td><span class="badge badge-warning">Rp <?php echo number_format($ProfitPulsa['total'],0,',','.'); ?></span></td>
                                    </tr>  
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Data Talk Per Month -->

        <!-- Start Order Chart -->
        <div class="row">
	        <div class="col-lg-12">
		        <div class="kt-portlet">
			        <div class="kt-portlet__head">
				        <div class="kt-portlet__head-label">
					        <h3 class="kt-portlet__head-title">
					            <i class="flaticon-graph text-primary"></i>
					            Grafik Pesanan 7 Hari Terakhir
					        </h3>
				        </div>
			        </div>
			        <div class="kt-portlet__body">
			        <div class="chart" id="line-chart" style="height: 300px;"></div>
			        <script>
                    $(function () {
                        "use strict";
                        var line = new Morris.Area({
                            element: 'line-chart',
                            resize: true,
                            behaveLikeLine: true,
                            data: [
                                {w: '<?php echo $date; ?>', x: <?php echo mysqli_num_rows($check_order_today); ?>, y: <?php echo mysqli_num_rows($check_order_pulsa_today); ?>, z: <?php echo mysqli_num_rows($check_order_pascabayar_today); ?>},
                                {w: '<?php echo $oneday_ago; ?>', x: <?php echo mysqli_num_rows($check_order_oneday_ago); ?>, y: <?php echo mysqli_num_rows($check_order_pulsa_oneday_ago); ?>, z: <?php echo mysqli_num_rows($check_order_pascabayar_oneday_ago); ?>},
                                {w: '<?php echo $twodays_ago; ?>', x: <?php echo mysqli_num_rows($check_order_twodays_ago); ?>, y: <?php echo mysqli_num_rows($check_order_pulsa_twodays_ago); ?>, z: <?php echo mysqli_num_rows($check_order_pascabayar_twodays_ago); ?>},
                                {w: '<?php echo $threedays_ago; ?>', x: <?php echo mysqli_num_rows($check_order_threedays_ago); ?>, y: <?php echo mysqli_num_rows($check_order_pulsa_threedays_ago); ?>, z: <?php echo mysqli_num_rows($check_order_pascabayar_threedays_ago); ?>},
                                {w: '<?php echo $fourdays_ago; ?>', x: <?php echo mysqli_num_rows($check_order_fourdays_ago); ?>, y: <?php echo mysqli_num_rows($check_order_pulsa_fourdays_ago); ?>, z: <?php echo mysqli_num_rows($check_order_pascabayar_fourdays_ago); ?>},
                                {w: '<?php echo $fivedays_ago; ?>', x: <?php echo mysqli_num_rows($check_order_fivedays_ago); ?>, y: <?php echo mysqli_num_rows($check_order_pulsa_fivedays_ago); ?>, z: <?php echo mysqli_num_rows($check_order_pascabayar_fivedays_ago); ?>},
                                {w: '<?php echo $sixdays_ago; ?>', x: <?php echo mysqli_num_rows($check_order_sixdays_ago); ?>, y: <?php echo mysqli_num_rows($check_order_pulsa_sixdays_ago); ?>, z: <?php echo mysqli_num_rows($check_order_pascabayar_sixdays_ago); ?>}
                            ],
                            xkey: 'w',
                            ykeys: ['x','y','z'],
                            labels: ['Pesanan Sosial Media','Pesanan Top Up','Pesanan Pascabayar'],
                            lineColors: ['#f35864','#3399ff','FFFF00'],
                            pointSize: 0,
                            lineWidth: 0,
                            hideHover: 'auto',
                            redraw: true,
                        });
                    });
			        </script>
			        </div>
		        </div>
            </div>
        </div>
        <!-- End Order Chart -->

        </div>
        <!-- End Content -->

        <!-- Start Scrolltop -->
		<div id="kt_scrolltop" class="kt-scrolltop">
		    <i class="fa fa-arrow-up"></i>
		</div>
		<!-- End Scrolltop -->

<?php
require '../lib/footer_admin.php';
?>