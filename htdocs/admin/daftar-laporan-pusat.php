<?php
session_start();
require '../config.php';
require '../lib/session_login_admin.php'; 
require '../lib/header_admin.php';
?>

        <!-- Start Sub Header -->
        <div class="kt-subheader kt-grid__item" id="kt_subheader">
	        <div class="kt-container ">
	            <div class="kt-subheader__main">
                    <h3 class="kt-subheader__title">Daftar Provider</h3>
                    <span class="kt-subheader__separator kt-hidden"></span>
                    <div class="kt-subheader__breadcrumbs">
                        <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                        <span class="kt-subheader__breadcrumbs-separator"></span>
                        <a href="#" class="kt-subheader__breadcrumbs-link">Halaman Admin</a>
                        <span class="kt-subheader__breadcrumbs-separator"></span>
                        <a href="#" class="kt-subheader__breadcrumbs-link">Daftar Provider</a>
	                </div>
	            </div>
	        </div>
        </div>
        <!-- End Sub Header -->

        <!-- Start Content -->
        <div class="kt-container kt-grid__item kt-grid__item--fluid">

        <!-- Start Page Data Laporan Pusat -->
        <div class="row">
	        <div class="col-lg-12">
		        <div class="kt-portlet">
			        <div class="kt-portlet__head">
				        <div class="kt-portlet__head-label">
					        <h3 class="kt-portlet__head-title">
					            <i class="fa fa-list text-primary"></i>
					            Daftar Saldo Pusat
					        </h3>
				        </div>
			        </div>
			        <div class="kt-portlet__body">
                        <div class="table-responsive">
                            <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
                                <thead>
                                    <tr>
                                        <th>Update Terakhir</th>
                                        <th>Saldo</th>
                                        <th>Tipe</th>
                                        <th>Provider</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php
$no = 1;
    $CallDB_Provider = $conn->query("SELECT * FROM cek_akun ORDER BY id DESC"); // edit
    while ($ShowData = $CallDB_Provider->fetch_assoc()) {
?>
                                    <tr> 
                                        <td><?php echo tanggal_indo($ShowData['date']); ?>, <?php echo $ShowData['time']; ?></td>
                                        <td width="10%"><span class="badge badge-primary">Rp <?php echo number_format($ShowData['saldo'],0,',','.'); ?></span></td>
                                        <td width="10%"><span class="badge badge-success"><?php echo $ShowData['tipe']; ?></span></td>
                                        <td width="10%"><span class="badge badge-warning"><?php echo $ShowData['provider']; ?></span></td>
                                        </td>                                 
                                    </tr>  
<?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Data Laporan Pusat -->

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