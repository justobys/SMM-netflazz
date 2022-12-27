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
		            <h3 class="kt-subheader__title">Pembayaran Isi Saldo</h3>
	                <div class="kt-subheader__breadcrumbs">
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
	                	<span class="kt-subheader__breadcrumbs-separator"></span>
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-link">Halaman Utama</a>
	                	<span class="kt-subheader__breadcrumbs-separator"></span>
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-link">Pembayaran Isi Saldo</a>
	                </div>
	            </div>
	        </div>
        </div>
        <!-- End Sub Header -->

        <!-- Start Content -->
        <div class="kt-container kt-grid__item kt-grid__item--fluid">

        <!-- Start Page Method Top Up Balance -->
	    <div class="col-lg-12">
		    <div class="kt-portlet text-center">
	            <table class="table table-bordered mb-0">
                    <tbody>
                        <tr>
                            <th>
                                <a href="">
                                    <a href="#" class="btn-loading"><img src="https://p-store.net/images/payment-icon/bank_bri.png" style="height:100%;max-height:30px;margin:10px 20px" />
                                </a>
                            </th>
                            <th>
                                <a href="">
                                    <a href="#" class="btn-loading"><img src="https://p-store.net/images/payment-icon/bank_bca.png" style="height:100%;max-height:30px;margin:10px 20px" />
                                </a>
                            </th>
                        </tr>
                        <tr>
                            <th>
                                <a href="">
                                    <a href="#" class="btn-loading"><img src="https://p-store.net/images/payment-icon/bank_mandiri.png" style="height:100%;max-height:30px;margin:10px 20px" />
                                </a>
                            </th>
                            <th>
                                <a href="">
                                    <a href="#" class="btn-loading"><img src="<?php echo $config['web']['url'] ?>assets/media/blog/jenius.png" style="height:100%;max-height:30px;margin:10px 20px" />
                                </a>
                            </th>
                        </tr>
                        <tr>
                            <th>
                                <a href="">
                                    <a href="#" class="btn-loading"><img src="https://p-store.net/images/payment-icon/ovo.png" style="height:100%;max-height:30px;margin:10px 20px" />
                                </a>
                            </th>
                            <th>
                                <a href="">
                                    <a href="#" class="btn-loading"><img src="https://p-store.net/images/payment-icon/gopay.png" style="height:100%;max-height:30px;margin:10px 20px" />
                                </a>
                            </th>
                        </tr>
                        <tr>
                            <th>
                                <a href="">
                                    <a href="#" class="btn-loading"><img src="https://p-store.net/images/payment-icon/alfamart.png" style="height:100%;max-height:30px;margin:10px 20px" />
                                </a>
                            </th>
                            <th>
                                <a href="">
                                    <a href="#" class="btn-loading"><img src="<?php echo $config['web']['url'] ?>assets/media/blog/dana.png" style="height:100%;max-height:30px;margin:10px 20px" />
                                </a>
                            </th>
                        </tr>
                        <tr>
                            <th>
                                <a href="">
                                    <a href="#" class="btn-loading"><img src="<?php echo $config['web']['url'] ?>assets/media/blog/telkomsel.png" style="height:100%;max-height:30px;margin:10px 20px" />
                                </a>
                            </th>
                            <th>
                                <a href="">
                                    <a href="#" class="btn-loading"><img src="<?php echo $config['web']['url'] ?>assets/media/blog/xl.png" style="height:100%;max-height:30px;margin:10px 20px" />
                                </a>
                            </th>
                        </tr>
                    </tbody>
	            </table>
	        </div>
	    </div>
        <!-- End Page Method Top Up Balance -->

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