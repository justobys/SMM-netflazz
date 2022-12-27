<?php
session_start();
require '../config.php';
require '../lib/header.php';
?>

        <!-- Start Sub Header -->
        <div class="kt-subheader kt-grid__item" id="kt_subheader">
	        <div class="kt-container">
	            <div class="kt-subheader__main">
		            <h3 class="kt-subheader__title">Peringkat Bulanan</h3>
	                <div class="kt-subheader__breadcrumbs">
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
	                	<span class="kt-subheader__breadcrumbs-separator"></span>
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-link">Halaman Utama</a>
	                	<span class="kt-subheader__breadcrumbs-separator"></span>
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-link">Peringkat Bulanan</a>
	                </div>
	            </div>
	        </div>
        </div>
        <!-- End Sub Header -->

        <!-- Start Content -->
        <div class="kt-container kt-grid__item kt-grid__item--fluid">

        <!-- Start Page User Ranking -->
        <div class="row">
	        <div class="col-lg-6">
		        <div class="kt-portlet">
			        <div class="kt-portlet__head">
				        <div class="kt-portlet__head-label">
					        <h3 class="kt-portlet__head-title">
					            <i class="flaticon-trophy text-primary"></i>
					            Top 10 Pesanan
					        </h3>
				        </div>
			        </div>
			        <div class="kt-portlet__body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered nowrap m-0">
                                <thead>
                                    <tr>
                                        <th>Peringkat</th>
                                        <th>Nama Pengguna</th>
                                        <th>Jumlah Pesanan</th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								$no = 1;
                                $top_pesanan = $conn->query("SELECT A.* FROM top_users A INNER JOIN (SELECT username,max(jumlah) as maxRev FROM top_users GROUP BY username) B on A.username=B.username and A.jumlah=B.maxRev ORDER BY jumlah DESC LIMIT 10");
                                
								while ($data_pesanan = mysqli_fetch_assoc($top_pesanan)) {
								$userstr = "-".strlen($data_pesanan['username']);
								$usersensor = substr($data_pesanan['username'],$slider_userstr,-4);	
								if ($no == 1) {
									$label = "success";
								} else if ($no == 2) {
									$label = "primary";
								} else if ($no == 3) {
									$label = "dark";
								} else if ($no == 4) {
									$label = "warning";
								} else if ($no == 5) {
									$label = "danger";
								} else {
									$label = "light";
								}
							    ?>
								<tr>
									<td><span class="btn btn-<?php echo $label; ?> btn-elevate btn-pill btn-elevate-air btn-sm"><?php echo $no; ?></span></td>
									<td><span class="btn btn-<?php echo $label; ?> btn-elevate btn-pill btn-elevate-air btn-sm"><?php echo "".$usersensor."****"; ?></span></td>
									<td>Rp <?php echo number_format($data_pesanan['jumlah'],0,',','.'); ?> <span class="btn btn-<?php echo $label; ?> btn-elevate btn-pill btn-elevate-air btn-sm">(Dari <?php echo number_format($data_pesanan['total'],0,',','.'); ?> Pesanan)</span></td>
								</tr>
								<?php
								$no++;
								}
								?>
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
					            <i class="flaticon-trophy text-primary"></i>
					            Top 10 Deposit
					        </h3>
				        </div>
			        </div>
			        <div class="kt-portlet__body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered nowrap m-0">
                                <thead>
                                    <tr>
                                        <th>Peringkat</th>
                                        <th>Nama Pengguna</th>
                                        <th>Jumlah Deposit</th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								$no = 1;
                                $top_deposit = $conn->query("SELECT SUM(deposit.get_saldo) AS tamount, count(deposit.id) AS tcount, deposit.username, users.username FROM deposit JOIN users ON deposit.username = users.username WHERE MONTH(deposit.date) = '".date('m')."' AND YEAR(deposit.date) = '".date('Y')."' AND deposit.status = 'Success' GROUP BY deposit.username ORDER BY tamount DESC LIMIT 10");
								while ($data_deposit = mysqli_fetch_array($top_deposit)) {
								$userstr = "-".strlen($data_deposit['username']);
								$usersensor = substr($data_deposit['username'],$slider_userstr,-4);				
								if ($no == 1) {
									$label = "success";
								} else if ($no == 2) {
									$label = "primary";
								} else if ($no == 3) {
									$label = "dark";
								} else if ($no == 4) {
									$label = "warning";
								} else if ($no == 5) {
									$label = "danger";
								} else {
									$label = "light";
								}
							    ?>
                                    <tr>
									    <td><span class="btn btn-<?php echo $label; ?> btn-elevate btn-pill btn-elevate-air btn-sm"><?php echo $no; ?></span></td>
									    <td><span class="btn btn-<?php echo $label; ?> btn-elevate btn-pill btn-elevate-air btn-sm"><?php echo "".$usersensor."****"; ?></span></td>
									    <td>Rp <?php echo number_format($data_deposit['tamount'],0,',','.'); ?> <span class="btn btn-<?php echo $label; ?> btn-elevate btn-pill btn-elevate-air btn-sm">(Dari <?php echo number_format($data_deposit['tcount'],0,',','.'); ?> Deposit)</span></td>
                                    </tr>
								<?php
								$no++;
								}
								?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 text-center">
        <h2>Top 10 Layanan</h2>
        <p>Berikut Adalah 10 Layanan Dengan Pemesanan Tertinggi.</p>
        </div>
        <div class="row">
	        <div class="offset-lg-2 col-lg-8">
		        <div class="kt-portlet">
			        <div class="kt-portlet__head">
				        <div class="kt-portlet__head-label">
					        <h3 class="kt-portlet__head-title">
					            <i class="flaticon-trophy text-primary"></i>
					            Top 10 Layanan
					        </h3>
				        </div>
			        </div>
			        <div class="kt-portlet__body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered nowrap m-0">
                                <thead>
                                    <tr>
                                        <th>Peringkat</th>
                                        <th>Nama Layanan</th>
                                        <th>Jumlah Pesanan</th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								$no = 1;
                                $top_layanan = $conn->query("SELECT SUM(pembelian_sosmed.harga) AS tamount, count(pembelian_sosmed.id) AS tcount, pembelian_sosmed.layanan, layanan_sosmed.layanan FROM pembelian_sosmed JOIN layanan_sosmed ON pembelian_sosmed.layanan = layanan_sosmed.layanan WHERE pembelian_sosmed.status = 'Success' GROUP BY pembelian_sosmed.layanan ORDER BY tamount DESC LIMIT 10");
								while ($data_layanan = mysqli_fetch_assoc($top_layanan)) {								
								if ($no == 1) {
									$label = "success";
								} else if ($no == 2) {
									$label = "primary";
								} else if ($no == 3) {
									$label = "dark";
								} else if ($no == 4) {
									$label = "warning";
								} else if ($no == 5) {
									$label = "danger";
								} else {
									$label = "light";
								}
							    ?>
								<tr>
									<td><span class="btn btn-<?php echo $label; ?> btn-elevate btn-pill btn-elevate-air btn-sm"><?php echo $no; ?></span></td>
									<td><span class="btn btn-<?php echo $label; ?> btn-elevate btn-pill btn-elevate-air btn-sm"><?php echo $data_layanan['layanan']; ?></span></td>
									<td>Rp <?php echo number_format($data_layanan['tamount'],0,',','.'); ?> <span class="btn btn-<?php echo $label; ?> btn-elevate btn-pill btn-elevate-air btn-sm">(Dari <?php echo number_format($data_layanan['tcount'],0,',','.'); ?> Pesanan)</span></td>
								</tr>
								<?php
								$no++;
								}
								?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page User Ranking -->

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