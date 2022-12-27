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
                    <h3 class="kt-subheader__title">Daftar Tombol Jadwal</h3>
                    <span class="kt-subheader__separator kt-hidden"></span>
                    <div class="kt-subheader__breadcrumbs">
                        <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                        <span class="kt-subheader__breadcrumbs-separator"></span>
                        <a href="#" class="kt-subheader__breadcrumbs-link">Halaman Admin</a>
                        <span class="kt-subheader__breadcrumbs-separator"></span>
                        <a href="#" class="kt-subheader__breadcrumbs-link">Daftar Tombol Jadwal</a>
	                </div>
	            </div>
	        </div>
        </div>
        <!-- End Sub Header -->

        <!-- Start Content -->
        <div class="kt-container kt-grid__item kt-grid__item--fluid">
        
         <!-- Start Page Data Schedule Button Akun -->
        <div class="row">
	        <div class="col-lg-12">
		        <div class="kt-portlet">
			        <div class="kt-portlet__head">
				        <div class="kt-portlet__head-label">
					        <h3 class="kt-portlet__head-title">
					            <i class="fa fa-cog text-primary"></i>
					            Daftar Tombol Jadwal Profile
					        </h3>
				        </div>
			        </div>
			        <div class="kt-portlet__body">
                    <div class="table-responsive">
                        <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
                            <thead>
                                <tr>
                                    <th>Akun Saldo</th>
                                    <th>Akun Diamond</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td width="5%"><a href="<?php echo $config['web']['url'] ?>cronsjob/check-account-top-up" class="badge badge-warning" target="_blank">Ambil Akun Saldo</span></a></td>
                                    <td width="5%"><a href="<?php echo $config['web']['url'] ?>cronsjob/check-account-sosmed" class="badge badge-warning" target="_blank">Ambil Akun Diamond</span></a></td>
                                </tr>
                                <tr>
                                    <td width="5%"><a href="<?php echo $config['web']['url'] ?>cronsjob/delete-check-account-center-top-up" class="badge badge-warning" target="_blank">Hapus Akun Saldo</span></a></td>
                                    <td width="5%"><a href="<?php echo $config['web']['url'] ?>cronsjob/delete-check-account-center-sosmed" class="badge badge-warning" target="_blank">Hapus Akun Diamond</span></a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Data Schedule Button Akun -->
        
        <!-- Start Page Data Schedule Button Social Media -->
        <div class="row">
	        <div class="col-lg-12">
		        <div class="kt-portlet">
			        <div class="kt-portlet__head">
				        <div class="kt-portlet__head-label">
					        <h3 class="kt-portlet__head-title">
					            <i class="fa fa-cog text-primary"></i>
					            Daftar Tombol Jadwal Sosial Media
					        </h3>
				        </div>
			        </div>
			        <div class="kt-portlet__body">
                    <div class="table-responsive">
                        <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
                            <thead>
                                <tr>
                                    <th>Kategori</th>
                                    <th>Layanan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td width="5%"><a href="<?php echo $config['web']['url'] ?>cronsjob/get-category-sosmed" class="badge badge-success" target="_blank">Ambil Kategori</span></a></td>
                                    <td width="5%"><a href="<?php echo $config['web']['url'] ?>cronsjob/get-service-sosmed" class="badge badge-primary" target="_blank">Ambil Layanan</span></a></td>
                                    <td width="5%"><a href="<?php echo $config['web']['url'] ?>cronsjob/get-status-sosmed" class="badge badge-danger" target="_blank">Ambil Status</span></a></td>
                                </tr>
                                <tr>
                                    <td width="5%"><a href="<?php echo $config['web']['url'] ?>cronsjob/delete-category-sosmed" class="badge badge-success" target="_blank">Hapus Kategori</span></a></td>
                                    <td width="5%"><a href="<?php echo $config['web']['url'] ?>cronsjob/delete-service-sosmed" class="badge badge-primary" target="_blank">Hapus Layanan</span></a></td>
                                    <td width="5%"><span class="badge badge-dark">Tidak Ada Tombol</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Data Schedule Button Social Media -->

        <!-- Start Page Data Schedule Button Top Up -->
        <div class="row">
	        <div class="col-lg-12">
		        <div class="kt-portlet">
			        <div class="kt-portlet__head">
				        <div class="kt-portlet__head-label">
					        <h3 class="kt-portlet__head-title">
					            <i class="fa fa-cog text-primary"></i>
					            Daftar Tombol Jadwal Top Up
					        </h3>
				        </div>
			        </div>
			        <div class="kt-portlet__body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered nowrap m-0">
                            <thead>
                                <tr>
                                    <th>Kategori</th>
                                    <th>Layanan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td width="5%"><a href="<?php echo $config['web']['url'] ?>cronsjob/get-category-top-up" class="badge badge-success" target="_blank">Ambil Kategori</span></a></td>
                                    <td width="5%"><a href="<?php echo $config['web']['url'] ?>cronsjob/get-service-top-up" class="badge badge-primary" target="_blank">Ambil Layanan</span></a></td>
                                    <td width="5%"><a href="<?php echo $config['web']['url'] ?>cronsjob/get-status-top-up" class="badge badge-danger" target="_blank">Ambil Status</span></a></td>
                                </tr>
                                <tr>
                                    <td width="5%"><a href="<?php echo $config['web']['url'] ?>cronsjob/delete-category-top-up" class="badge badge-success" target="_blank">Hapus Kategori</span></a></td>
                                    <td width="5%"><a href="<?php echo $config['web']['url'] ?>cronsjob/delete-service-top-up" class="badge badge-primary" target="_blank">Hapus Layanan</span></a></td>
                                    <td width="5%"><span class="badge badge-dark">Tidak Ada Tombol</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Data Schedule Button Top Up -->

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