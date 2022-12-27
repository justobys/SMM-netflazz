<?php
session_start();
require '../config.php';
require '../lib/session_login_admin.php'; 

        if (isset($_POST['ubah'])) {
            $PostStitle = $conn->real_escape_string(trim($_POST['shrt_title']));
            $PostTitle = $conn->real_escape_string(trim($_POST['title']));
            $PostDescWeb = $conn->real_escape_string(trim($_POST['deskripsi']));
            $PostKontak = $conn->real_escape_string(trim($_POST['kontak']));
            $PostLokasi = $conn->real_escape_string(trim($_POST['lokasi']));
            $PostKodePos = $conn->real_escape_string(trim($_POST['kodepos']));

            if ($conn->query("UPDATE setting_web SET short_title = '$PostStitle', title = '$PostTitle', deskripsi_web = '$PostDescWeb', kontak_utama = '$PostKontak', lokasi = '$PostLokasi', kode_pos = '$PostKodePos' WHERE id = '1'") == true) {
                $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip, Pengaturan Website Telah Berhasil Di Ubah.');                    
            } else {
                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.<script>swal("Ups Gagal!", "Sistem Kami Sedang Mengalami Gangguan.", "error");</script>');
            }
        }
        
        require("../lib/header_admin.php");

?>       

        <!-- Start Sub Header -->
        <div class="kt-subheader kt-grid__item" id="kt_subheader">
	        <div class="kt-container ">
	            <div class="kt-subheader__main">
                    <h3 class="kt-subheader__title">Pengaturan Website</h3>
                    <span class="kt-subheader__separator kt-hidden"></span>
                    <div class="kt-subheader__breadcrumbs">
                        <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                        <span class="kt-subheader__breadcrumbs-separator"></span>
                        <a href="#" class="kt-subheader__breadcrumbs-link">Halaman Admin</a>
                        <span class="kt-subheader__breadcrumbs-separator"></span>
                        <a href="#" class="kt-subheader__breadcrumbs-link">Pengaturan Website</a>
	                </div>
	            </div>
	        </div>
        </div>
        <!-- End Sub Header -->

        <!-- Start Content -->
        <div class="kt-container kt-grid__item kt-grid__item--fluid">

        <!-- Start Page Data Setting Website -->
        <div class="row">
	        <div class="col-lg-12">
		        <div class="kt-portlet">
			        <div class="kt-portlet__head">
				        <div class="kt-portlet__head-label">
					        <h3 class="kt-portlet__head-title">
					            <i class="fa fa-globe text-primary"></i>
					            Pengaturan Website
					        </h3>
				        </div>
			        </div>
			        <div class="kt-portlet__body">
                    <?php
                    if (isset($_SESSION['hasil'])) {
                    ?>
                    <div class="alert alert-<?php echo $_SESSION['hasil']['alert'] ?> alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <?php echo $_SESSION['hasil']['pesan'] ?>
                    </div>
                    <?php
                    unset($_SESSION['hasil']);
                    }
                    ?>
                    <div class="table-responsive">
                        <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
                            <thead>
                                <tr>
                                    <th>Short Title</th>
                                    <th>Title Website</th>
                                    <th>Deskripsi Website</th>
                                    <th>Kontak Utama</th>
                                    <th>Lokasi</th>
                                    <th>Kode Pos</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
<?php 
$CekData = $conn->query("SELECT * FROM setting_web WHERE id = '1'"); // edit
while ($ShowData = $CekData->fetch_assoc()) {
?>
                                <tr> 
                                    <td><?php echo $ShowData['short_title']; ?></td>
                                    <td><?php echo $ShowData['title']; ?></td>
                                    <td><textarea rows="5" cols="100" name="konten" class="form-control" readonly><?php echo $ShowData['deskripsi_web']; ?></textarea></td>
                                    <td><?php echo $ShowData['kontak_utama']; ?></td>
                                    <td><?php echo $ShowData['lokasi']; ?></td>
                                    <td><?php echo $ShowData['kode_pos']; ?></td>
                                    <td align="center">
                                        <a href="javascript:;" onclick="users('<?php echo $config['web']['url']; ?>admin/ajax/pengaturan-website/ubah?id=1')" class="btn btn-sm btn-warning"><i class="fa fa-pencil-alt" title="Ubah"></i></a>
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
        <!-- End Page Data Setting Website -->

        </div>
        <!-- End Content -->

        <!-- Start Scrolltop -->
		<div id="kt_scrolltop" class="kt-scrolltop">
		    <i class="fa fa-arrow-up"></i>
		</div>
		<!-- End Scrolltop -->

		<script type="text/javascript">
            function users(url) {
                $.ajax({
                    type: "GET",
                    url: url,
                    beforeSend: function() {
                        $('#modal-detail-body').html('Sedang Memuat...');
                    },
                    success: function(result) {
                        $('#modal-detail-body').html(result);
                    },
                    error: function() {
                        $('#modal-detail-body').html('Terjadi Kesalahan.');
                    }
                });
                $('#modal-detail').modal();
            }
		</script>

        <div class="row">
            <div class="col-md-12">     
                <div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"  aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title mt-0" id="myModalLabel"><i class="fa fa-globe text-primary"></i> Pengaturan Website</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal" role="form" method="POST">
                                    <input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
                                    <div id="modal-detail-body"></div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<?php
require '../lib/footer_admin.php';
?>