<?php
session_start();
require '../config.php';
require '../lib/session_user.php';

        if (isset($_POST['pesan'])) {
		    require '../lib/session_login.php';
		    $post_link = $conn->real_escape_string(filter($_POST['link']));
		    $post_target = $conn->real_escape_string(filter($_POST['target']));

            $error = array();
            if (empty($post_link)) {
    		    $error ['link'] = '*Tidak Boleh Kosong .';
            }
            if (empty($post_target)) {
    		    $error ['target'] = '*Tidak Boleh Kosong.';
            } else {
            $cek_id = json_decode(file_get_contents('https://cloud-panel.net/api/id-comment.php?link='.$post_link.'&username='.$post_target), true);
    		if ($cek_id['count'] == 0) {
    		$_SESSION['hasil_batch'][] = array('alert' => 'danger', 'pesan' => 'Ups, ID Komentar Tidak Ditemukan '.$cek_id.'.<script>swal("Ups Gagal!", "ID Komentar Tidak Ditemukan.", "error");</script>');
	    } else {
		foreach($cek_id['result'] as $cek_data_ig) {
	        $_SESSION['hasil_batch'][] = array('alert' => 'success', 'pesan' => 'Sip, Cek ID Komentar Berhasil.<br /><br />ID Komentar : '.$cek_data_ig['id'].'<br />Komentar : '.$cek_data_ig['text'].'<br />');
				}
			}
		}
	}
require("../lib/header.php");

?>

        <!-- Start Sub Header -->
        <div class="kt-subheader kt-grid__item" id="kt_subheader">
	        <div class="kt-container">
	            <div class="kt-subheader__main">
		            <h3 class="kt-subheader__title"> Cek ID Komentar</h3>
	                <div class="kt-subheader__breadcrumbs">
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
	                	<span class="kt-subheader__breadcrumbs-separator"></span>
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-link">Halaman Utama</a>
	                	<span class="kt-subheader__breadcrumbs-separator"></span>
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-link">Cek ID Komentar</a>
	                </div>
	            </div>
	        </div>
        </div>
        <!-- End Sub Header -->

        <!-- Start Content -->
        <div class="kt-container kt-grid__item kt-grid__item--fluid">

        <!-- Start Page Cek ID Komentar -->
        <div class="row">
            <div class="col-xl-12 m-b-30">
		        <div class="btn-group flex-wrap mb-4" role="group">
		            <a href="<?php echo $config['web']['url'] ?>order/social-media" class="btn btn-primary">Social Media</a>
		        </div>
		        <div class="btn-group flex-wrap mb-4" role="group">
		            <a href="<?php echo $config['web']['url'] ?>order/id-comment" class="btn btn-primary active">Cek ID Komentar</a>
		        </div>
			</div>
		</div>
        <div class="row">
	        <div class="col-lg-7">
		        <div class="kt-portlet">
			        <div class="kt-portlet__head">
				        <div class="kt-portlet__head-label">
					        <h3 class="kt-portlet__head-title">
					            <i class="flaticon2-shopping-cart text-primary"></i>
					            Cek ID Komentar
					        </h3>
				        </div>
			        </div>
			        <div class="kt-portlet__body">
                    <?php
                    if (isset($_SESSION['hasil_batch'])) {
                    ?>
                    <?php foreach($_SESSION['hasil_batch'] as $msg_result) { 
                    ?>
                    <div class="alert alert-<?php echo $msg_result['alert'] ?> alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <?php echo $msg_result['pesan'] ?>
                    </div>
                    <?php
                    }
                    ?>
                    <?php
                    unset($_SESSION['hasil_batch']);
                    }
                    ?>
                        <form class="form-horizontal" method="POST">
	                        <input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">   										    
						<div class="form-group row">
								<label class="col-xl-3 col-lg-3 col-form-label">Link/URL</label>
								<div class="col-lg-9 col-xl-6">
									<input type="text" name="link" class="form-control" placeholder="Masukan Link/URL" value="<?php echo $post_link; ?>">
									<span class="form-text text-muted"><?php echo ($error['link']) ? $error['link'] : '';?></span>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-xl-3 col-lg-3 col-form-label">Username Instagram</label>
								<div class="col-lg-9 col-xl-6">
									<input type="text" name="target" class="form-control" placeholder="Masukan Username Instagram" value="<?php echo $post_target; ?>">
									<span class="form-text text-muted"><?php echo ($error['target']) ? $error['target'] : '';?></span>
								</div>
							</div>
                            <div class="kt-portlet__foot">
                                <div class="kt-form__actions">
                                    <div class="row">
                                        <div class="col-lg-3 col-xl-3">
                                        </div>
                                        <div class="col-lg-9 col-xl-9">
                                            <button type="submit" name="pesan" class="btn btn-primary btn-elevate btn-pill btn-elevate-air">Submit</button>
                                            <button type="reset" class="btn btn-danger btn-elevate btn-pill btn-elevate-air">Ulangi</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
						</form>
					</div>
				</div>
	        </div>
	        <div class="col-lg-5">
		        <div class="kt-portlet">
			        <div class="kt-portlet__head">
				        <div class="kt-portlet__head-label">
					        <h3 class="kt-portlet__head-title">
					            <i class="flaticon-alert text-primary"></i>
					            Informasi
					        </h3>
				        </div>
			        </div>
			        <div class="kt-portlet__body">
						<ul>
							<li>Pastikan Username Yang Di Input Benar Dan Valid.</li>
							<li>Pastikan Link/URL Akun Target Tidak Berstatus Private.</li>
							<li>Masukan Link/URL seperti berikut : <code>https://www.instagram.com/p/BdHSq1LB8xX/</code>.</li>
							<li>Jika Butuh Bantuan Silahkan Hubungi Kontak Kami.</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!-- End Page Cek ID Komentar -->

        </div>
        <!-- End Content -->

        <!-- Start Scrolltop -->
		<div id="kt_scrolltop" class="kt-scrolltop">
		    <i class="fa fa-arrow-up"></i>
		</div>
		<!-- End Scrolltop -->

<?php
	require ("../lib/footer.php");
?>