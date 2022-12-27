<?php
session_start();
require '../config.php';
require '../lib/header.php';
?>

        <!-- Start Sub Header -->
        <div class="kt-subheader kt-grid__item" id="kt_subheader">
	        <div class="kt-container">
	            <div class="kt-subheader__main">
		            <h3 class="kt-subheader__title">Daftar Layanan</h3>
	                <div class="kt-subheader__breadcrumbs">
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
	                	<span class="kt-subheader__breadcrumbs-separator"></span>
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-link">Halaman Utama</a>
	                	<span class="kt-subheader__breadcrumbs-separator"></span>
	                    <a href="#" class="kt-subheader__breadcrumbs-link">Daftar Layanan</a>
	                </div>
	            </div>
	        </div>
        </div>
        <!-- End Sub Header -->

        <!-- Start Content -->
        <div class="kt-container kt-grid__item kt-grid__item--fluid">

        <!-- Start Page Price List Top Up -->
        <div class="row">
	        <div class="col-lg-12">
		        <div class="kt-portlet">
			        <div class="kt-portlet__head">
				        <div class="kt-portlet__head-label">
					        <h3 class="kt-portlet__head-title">
					            <i class="flaticon2-tag text-primary"></i>
					            Daftar Harga Layanan Top Up
					        </h3>
				        </div>
				        <div class="kt-portlet__head-label">
                            <a href="<?php echo $config['web']['url'] ?>price-list/social-media" class="pull-right btn btn-primary btn-sm"> <i class="fas fa-history"></i> SOSMED</a>
                        </div>
			        </div>
			        <div class="kt-portlet__body">
                        <form class="form-horizontal" role="form" method="POST">
							<div class="form-group">
								<label>Tipe</label>
								<select class="form-control" id="tipe" name="tipe">
									<option value="">Pilih Salah Satu</option>
									<option value="Pulsa">Pulsa</option>
									<option value="E-Money">E-Money</option>
									<option value="Data">Data</option>
									<option value="Paket SMS Telpon">Paket SMS Telpon</option>
									<option value="Games">Games</option>
									<option value="PLN">PLN</option>
									<option value="Pulsa Internasional">Pulsa Internasional</option>
									<option value="Voucher">Voucher</option>
									<option value="WIFI ID">WIFI ID</option>
								</select>
							</div>
							<div class="form-group">
								<label>Kategori</label>
								<select class="form-control" id="operator" name="operator">
									<option value="0">Pilih Tipe Dahulu</option>
								</select>
							</div>
						</form>
						<div id="layanan"></div>
					</div>
				</div>
			</div>
		</div>
		<!-- End Page Price List Top Up -->

        </div>
        <!-- End Content -->

        <!-- Start Scrolltop -->
		<div id="kt_scrolltop" class="kt-scrolltop">
		    <i class="fa fa-arrow-up"></i>
		</div>
		<!-- End Scrolltop -->

		<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
		<script type="text/javascript">
		$(document).ready(function() {
		    $("#tipe").change(function() {
			    var tipe = $("#tipe").val();
		        $.ajax({
			        url: '<?php echo $config['web']['url']; ?>ajax/type-top-up.php',
			        data: 'tipe=' + tipe,
			        type: 'POST',
			        dataType: 'html',
			        success: function(msg) {
				        $("#operator").html(msg);
			        }
		        });
	        });
			$("#operator").change(function() {
			    var tipe = $("#tipe").val();
			    var operator = $("#operator").val();
			    $.ajax({
			        url: '<?php echo $config['web']['url']; ?>ajax/service-list-top-up.php',
			        data  : 'tipe=' +tipe + '&operator=' + operator,
			        type: 'POST',
			        dataType: 'html',
			        success: function(msg) {
				        $("#layanan").html(msg);
			        }
		        });
	        });
		});
		</script>

<?php
include("../lib/footer.php");
?>