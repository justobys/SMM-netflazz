<?php
session_start();
require '../config.php';
require '../lib/session_login_admin.php';

        if (isset($_POST['ubah'])) {
            $id = $conn->real_escape_string($_GET['this_id']);
            $level = $conn->real_escape_string($_POST['level']);
            $harga = $conn->real_escape_string(filter($_POST['harga']));
            $saldo_sosmed = $conn->real_escape_string($_POST['saldo_sosmed']);
            $saldo_top_up = $conn->real_escape_string($_POST['saldo_top_up']);

            $cek_data = $conn->query("SELECT * FROM harga_kode_undangan WHERE id = '$id'");

            if ($cek_data->num_rows == 0) {
                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Data Tidak Di Temukan.');
            } else {

                if ($conn->query("UPDATE harga_kode_undangan SET level = '$level', harga = '$harga', saldo_sosmed = '$saldo_sosmed', saldo_top_up = '$saldo_top_up' WHERE id = '$id'") == true) {
                    $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip, Harga Kode Undangan Berhasil Di Ubah.');
                } else {
                    $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.<script>swal("Ups Gagal!", "Sistem Kami Sedang Mengalami Gangguan.", "error");</script>');
                }
            }
        }

        require '../lib/header_admin.php';

?>

        <!-- Start Sub Header -->
        <div class="kt-subheader kt-grid__item" id="kt_subheader">
	        <div class="kt-container ">
	            <div class="kt-subheader__main">
                    <h3 class="kt-subheader__title">Daftar Harga Kode Undangan</h3>
                    <span class="kt-subheader__separator kt-hidden"></span>
                    <div class="kt-subheader__breadcrumbs">
                        <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                        <span class="kt-subheader__breadcrumbs-separator"></span>
                        <a href="#" class="kt-subheader__breadcrumbs-link">Halaman Admin</a>
                        <span class="kt-subheader__breadcrumbs-separator"></span>
                        <a href="#" class="kt-subheader__breadcrumbs-link">Daftar Harga Kode Undangan</a>
	                </div>
	            </div>
	        </div>
        </div>
        <!-- End Sub Header -->

        <!-- Start Content -->
        <div class="kt-container kt-grid__item kt-grid__item--fluid">

        <!-- Start Page Data Price Code Reffreal -->
        <div class="row">
	        <div class="col-lg-12">
		        <div class="kt-portlet">
			        <div class="kt-portlet__head">
				        <div class="kt-portlet__head-label">
					        <h3 class="kt-portlet__head-title">
					            <i class="fa fa-money-bill text-primary"></i>
					            Daftar Harga Kode Undangan
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
                                    <th>Level</th>
                                    <th>Harga</th>
                                    <th>Saldo Sosial Media</th>
                                    <th>Saldo Top Up</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
<?php
$no = 1;
    $CallDB_Provider = $conn->query("SELECT * FROM harga_kode_undangan ORDER BY id DESC"); // edit
    while ($ShowData = $CallDB_Provider->fetch_assoc()) {
?>                                        
                                <tr>
                                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>?this_id=<?php echo $ShowData['id']; ?>" class="form-inline" role="form" method="POST">
                                    <input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
                                    <td><input type="text" class="form-control" style="width: 200px;" name="level" value="<?php echo $ShowData['level']; ?>" readonly></td>
                                    <td><input type="text" class="form-control" style="width: 200px;" name="harga" value="<?php echo $ShowData['harga']; ?>"></td>
                                    <td><input type="text" class="form-control" style="width: 200px;" name="saldo_sosmed" value="<?php echo $ShowData['saldo_sosmed']; ?>"></td>
                                    <td><input type="text" class="form-control" style="width: 200px;" name="saldo_top_up" value="<?php echo $ShowData['saldo_top_up']; ?>"></td>
                                    <td align="center">
                                        <button data-toggle="tooltip" title="Ubah" type="submit" name="ubah" class="btn btn-sm btn-bordred btn-warning"><i class="fa fa-pencil-alt"></i></button>
                                    </td>
                                    </form>
                                </tr>
<?php } ?>                                        
                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Data Price Code Reffreal -->

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