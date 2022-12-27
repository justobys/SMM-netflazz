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
		            <h3 class="kt-subheader__title">Api Dokumentasi</h3>
	                <div class="kt-subheader__breadcrumbs">
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
	                	<span class="kt-subheader__breadcrumbs-separator"></span>
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-link">Halaman Utama</a>
	                	<span class="kt-subheader__breadcrumbs-separator"></span>
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-link">Api Dokumentasi</a>
	                </div>
	            </div>
	        </div>
        </div>
        <!-- End Sub Header -->

        <!-- Start Content -->
        <div class="kt-container kt-grid__item kt-grid__item--fluid">

        <!-- Start Page API Documentation -->
        <div class="row">
	        <div class="col-lg-12">
		        <div class="kt-portlet">
			        <div class="kt-portlet__head">
				        <div class="kt-portlet__head-label">
					        <h3 class="kt-portlet__head-title">
					            <i class="fa fa-code text-primary"></i>
					            Api Dokumentasi
					        </h3>
				        </div>
			        </div>
			        <div class="kt-portlet__body">
				        <div class="table-responsive">
				            <table class="table table-bordered">
					            <tbody>
						            <tr>
							            <td>HTTP Method</td>
							            <td>POST</td>
						            </tr>
						            <tr>
							            <td>API URL</td>
							            <td><?php echo $config['web']['url'] ?>api</td>
						            </tr>
						            <tr>
							            <td>Format Respons</td>
							            <td>JSON</td>
						            </tr>
						            <tr>
							            <td>Api Kategori</td>
							            <td><form class="form-horizontal" role="form" method="POST">
									            <div class="form-group">
										            <div class="col-md-8 pull-left">
											            <select class="form-control" id="api">
											            	<option value="0">Pilih salah satu...</option>
											            	<option value="api_social_media">Api Sosial Media</option>
											            	<option value="api_top_up">Api Top Up</option>
											            	<option value="api_pascabayar">Api Pascabayar</option>
												        <option value="api_account_information">Api Informasi Akun</option>
												        <option value="api_id_comment">Api ID Komentar</option>
											            </select>
										            </div>
									            </div>
								            </form>
							            </td>
						            </tr>
					            </tbody>
				            </table>
				        </div>
				    </div>
			    </div>
		    </div>
		</div>
		<!-- End Page API Documentation -->

		</div>
		<!-- End Content -->

        <!-- Start Scrolltop -->
		<div id="kt_scrolltop" class="kt-scrolltop">
		    <i class="fa fa-arrow-up"></i>
		</div>
		<!-- End Scrolltop -->

		<div id="fitur"></div>
		<script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.js"></script>
		<script type="text/javascript">
	       var htmlobjek;
            $(document).ready(function(){
                $("#api").change(function(){
                    var api = $("#api").val();
                $.ajax({
                    url: '<?php echo $config['web']['url'] ?>ajax/api-include.php',
                    data: 'api='+api,
                    type: 'POST',
                    dataType: 'html',
                    success: function(msg){
                        $("#fitur").html(msg);
                    }
                });
            });
        });
		</script>

<?php
include("../lib/footer.php");
?>