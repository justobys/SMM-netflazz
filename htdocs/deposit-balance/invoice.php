<?php
session_start();
require '../config.php';
require '../lib/session_user.php';
require '../lib/header.php';

		if (isset($_GET['kode_deposit'])) {
			$post_kode = filter($_GET['kode_deposit']);
			$cek_deposit = $conn->query("SELECT * FROM deposit WHERE kode_deposit = '$post_kode' AND username = '$sess_username'");
			$data_deposit = mysqli_fetch_assoc($cek_deposit);

			if ($data_deposit['status'] == "Pending") {
	            $label = "warning";
			} else if($data_deposit['status'] == "Error") {
	            $label = "danger";
			} else if($data_deposit['status'] == "Success") {
	            $label = "success";
			}

			if ($cek_deposit->num_rows == 0) {
	            header("Location: ".$config['web']['url']."history/deposit");
			} else {

?>

        <!-- Start Sub Header -->
        <div class="kt-subheader kt-grid__item" id="kt_subheader">
	        <div class="kt-container">
	            <div class="kt-subheader__main">
		            <h3 class="kt-subheader__title">Invoice</h3>
	                <div class="kt-subheader__breadcrumbs">
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
	                	<span class="kt-subheader__breadcrumbs-separator"></span>
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-link">Halaman Utama</a>
	                	<span class="kt-subheader__breadcrumbs-separator"></span>
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-link">Invoice</a>
	                </div>
	            </div>
	        </div>
        </div>
        <!-- End Sub Header -->

        <!-- Start Content -->
        <div class="kt-container kt-grid__item kt-grid__item--fluid">

        <!-- Start Page Invoice Top Up Balance -->
		<div class="kt-portlet">
            <div class="kt-portlet__body kt-portlet__body--fit">
                <div class="kt-invoice-1">
                    <div class="kt-invoice__head" style="background-image: url(https://image.freepik.com/free-vector/abstract-minimal-white-background_23-2148887988.jpg);">
                        <div class="kt-invoice__container">
                            <div class="kt-invoice__brand">
						        <h1 class="kt-invoice__title text-primary">INVOICE</h1>
                                <div href="#" class="kt-invoice__logo">
							        <a href="#"><img src="<?php echo $config['web']['url'] ?>assets/media/logos/netflazz.png" height="44" width="165"></a>
							        <span class="kt-invoice__desc">
								        <span class="text-primary"><?php echo $data['lokasi']; ?></span>
								        <span class="text-primary">Kode POS <?php echo $data['kode_pos']; ?></span>
							        </span>
						        </div>
					        </div>
                            <div class="kt-invoice__items">
                                <div class="kt-invoice__item text-primary">
                                    <span class="kt-invoice__subtitle text-primary">TANGGAL & WAKTU</span>
                                    <span class="kt-invoice__text text-primary"><?php echo tanggal_indo($data_deposit['date']); ?>, <?php echo $data_deposit['time']; ?></span>
                                </div>
                                <div class="kt-invoice__item text-primary">
                                    <span class="kt-invoice__subtitle">KODE INVOICE</span>
                                    <span class="kt-invoice__text text-primary"><?php echo $data_deposit['kode_deposit']; ?></span>
                                </div>
                                <div class="kt-invoice__item text-primary">
                                    <span class="kt-invoice__subtitle">STATUS</span>
                                    <span class="kt-invoice__text"><span class="btn btn-<?php echo $label; ?> btn-elevate btn-pill btn-elevate-air btn-sm"><?php echo $data_deposit['status']; ?></span></span>
                                </div>
                            </div>
                        </div>
                    </div>
			        <div class="kt-invoice__footer">
				        <div class="kt-invoice__container">
					        <div class="table-responsive">
						        <table class="table">
							        <thead>
								        <tr>
									        <th>TIPE BANK</th>
									        <th>PENERIMA</th>
									        <th>KETERANGAN</th>
									        <th>SALDO YANG DIDAPATKAN</th>
									        <th>JUMLAH PEMBAYARAN</th>
								        </tr>
							        </thead>
							        <tbody>
								        <tr>
									        <td><?php echo $data_deposit['provider']; ?></td>
									        <td><?php echo $data_deposit['penerima']; ?></td>
									        <td><?php echo $data_deposit['catatan']; ?></td>
									        <td>Rp <?php echo number_format($data_deposit['get_saldo'],0,',','.'); ?></td>
									        <td class="kt-font-danger kt-font-xl kt-font-boldest">Rp <?php echo number_format($data_deposit['jumlah_transfer'],0,',','.'); ?></td>
							    	    </tr>
						    	    </tbody>
					    	    </table>
				    	    </div>
			    	    </div>
			        </div>
			        <div class="kt-invoice__actions">
                        <div class="kt-invoice__container">
                            <button type="button" class="btn btn-label-brand btn-bold" onclick="window.print();">Print Invoice</button>
                        <form class="form-horizontal" role="form" method="POST" action="<?php echo $config['web']['url'] ?>history/deposit">
                    <?php if($data_deposit['status'] !== "Success" AND $data_deposit['status'] !== "Error") { ?>
                            <input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
                            <button type="submit" class="btn btn-danger btn-bold" name="kode_deposit" value="<?php echo $data_deposit['kode_deposit']; ?>">Batalkan</button>
                            <button type="submit" class="btn btn-brand btn-bold" name="confirm" value="<?php echo $data_deposit['kode_deposit']; ?>">Konfirmasi</button>
                        </form>
                        </div>
                    </div>
			        <?php } ?>
                </div>
            </div>
        </div>

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
	header("Location: ".$config['web']['url']."deposit/history");
}
?>