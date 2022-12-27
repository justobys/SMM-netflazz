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

        <!-- Start Page Price List Social Media -->
        <div class="row">
	        <div class="col-lg-12">
		        <div class="kt-portlet">
			        <div class="kt-portlet__head">
				        <div class="kt-portlet__head-label">
					        <h3 class="kt-portlet__head-title">
					            <i class="flaticon2-tag text-primary"></i>
					            Daftar Harga Layanan Sosial Media
					        </h3>
				        </div>
				        <div class="kt-portlet__head-label">
                            <a href="<?php echo $config['web']['url'] ?>price-list/top-up" class="pull-right btn btn-primary btn-sm"> <i class="fas fa-history"></i> PPOB</a>
                        </div>
			        </div>
			        <div class="kt-portlet__body">
                        <form class="form-horizontal" role="form" method="POST">
							<div class="form-group">
								<label>Kategori</label>
								<select class="form-control" id="kategori" name="kategori">
									<option value="0">Pilih Salah Satu</option>
									<?php
									$cek_kategori = $conn->query("SELECT * FROM kategori_layanan WHERE tipe = 'Sosial Media' ORDER BY nama ASC");
									while ($data_kategori = mysqli_fetch_assoc($cek_kategori)) {
									?>
									<option value="<?php echo $data_kategori['kode']; ?>"><?php echo $data_kategori['nama']; ?></option>
									<?php
									}
									?>
								</select>
							</div>
						</form>
						<div id="layanan"></div>
					</div>
				</div>
			</div>
		</div>
		<!-- End Page Price List Social Media -->

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
			$("#kategori").change(function() {
			    var kategori = $("#kategori").val();
			    $.ajax({
			        url: '<?php echo $config['web']['url']; ?>ajax/service-list-sosmed.php',
			        data: 'kategori=' + kategori,
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