<?php
session_start();
require '../config.php';
require '../lib/session_login_admin.php';

        if (isset($_POST['tambah_sosmed'])) {
            $PostCode = $conn->real_escape_string($_POST['code']);
            $PostLink = $conn->real_escape_string($_POST['link']);
            $GetKey = $conn->real_escape_string($_POST['api_key']);
            $GetApiID = $conn->real_escape_string($_POST['api_id']);

            if (!$PostCode || !$PostLink || !$GetKey) {
                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Mohon Mengisi Semua Input.');
            } else {

                if ($conn->query("INSERT INTO provider VALUES ('', '$PostCode', '$PostLink', '$GetKey', '$GetApiID')") == true) {
                    $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip, Berhasil Menambahkan Provider Layanan Sosial Media Baru.');
                } else {
                    $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.<script>swal("Ups Gagal!", "Sistem Kami Sedang Mengalami Gangguan.", "error");</script>');
                }
            }

        } else if (isset($_POST['ubah_sosmed'])) {
            $GetID = $conn->real_escape_string($_GET['this_id']);
            $PostCode = $conn->real_escape_string($_POST['code']);
            $PostLink = $conn->real_escape_string($_POST['link']);
            $GetKey = $conn->real_escape_string($_POST['api_key']);
            $GetApiID = $conn->real_escape_string($_POST['api_id']);

            $CheckData = $conn->query("SELECT * FROM provider WHERE id = '$GetID'");

            if ($CheckData->num_rows == 0) {
                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Data Tidak Di Temukan.');
            } else {

                if ($conn->query("UPDATE provider SET code = '$PostCode', link = '$PostLink', api_key = '$GetKey', api_id = '$GetApiID' WHERE id = '$GetID'") == true) {
                    $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip, Provider Layanan Sosial Media Berhasil Di Ubah.');
                } else {
                    $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.<script>swal("Ups Gagal!", "Sistem Kami Sedang Mengalami Gangguan.", "error");</script>');
                }
            }

        } else if (isset($_POST['hapus_sosmed'])) {
            $GetID = $conn->real_escape_string($_GET['this_id']);

            $CheckData = $conn->query("SELECT * FROM provider WHERE id = '$GetID'");

            if ($CheckData->num_rows == 0) {
                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Data Tidak Di Temukan.');
            } else {

                if ($conn->query("DELETE FROM provider WHERE id = '$GetID'") == true) {
                    $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip, Provider Layanan Sosial Media Berhasil Di Hapus.');
                } else {
                    $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.<script>swal("Ups Gagal!", "Sistem Kami Sedang Mengalami Gangguan.", "error");</script>');
                }
            }
        }

        if (isset($_POST['tambah_top_up'])) {
            $PostCode = $conn->real_escape_string($_POST['code']);
            $PostLink = $conn->real_escape_string($_POST['link']);
            $GetKey = $conn->real_escape_string($_POST['api_key']);
            $GetApiID = $conn->real_escape_string($_POST['api_id']);

            if (!$PostCode || !$PostLink || !$GetKey) {
                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Mohon Mengisi Semua Input.');
            } else {

                if ($conn->query("INSERT INTO provider_pulsa VALUES ('', '$PostCode', '$PostLink', '$GetKey', '$GetApiID')") == true) {
                    $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip, Berhasil Menambahkan Provider Layanan Top Up Baru.');
                } else {
                    $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.<script>swal("Ups Gagal!", "Sistem Kami Sedang Mengalami Gangguan.", "error");</script>');
                }
            }

        } else if (isset($_POST['ubah_top_up'])) {
            $id = $conn->real_escape_string($_GET['id']);
            $code = $conn->real_escape_string($_POST['code']);
            $link = $conn->real_escape_string($_POST['link']);
            $key = $conn->real_escape_string($_POST['key']);
            $apiid = $conn->real_escape_string($_POST['api_id']);

            $cek_data = $conn->query("SELECT * FROM provider_pulsa WHERE id = '$id'");

            if ($cek_data->num_rows == 0) {
                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Data Tidak Di Temukan.');
            } else {

                if ($conn->query("UPDATE provider_pulsa SET code = '$code', link = '$link', api_key = '$key' , api_id = '$apiid' WHERE id = '$id'") == true) {
                    $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip, Provider Layanan Top Up Berhasil Di Ubah.');
                } else {
                    $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.<script>swal("Ups Gagal!", "Sistem Kami Sedang Mengalami Gangguan.", "error");</script>');
                }
            }

        } else if (isset($_POST['hapus_top_up'])) {
            $id = $conn->real_escape_string($_GET['id']);

            $cek_data = $conn->query("SELECT * FROM provider_pulsa WHERE id = '$id'");

            if ($cek_data->num_rows == 0) {
                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Data Tidak Di Temukan.');
            } else {

                if ($conn->query("DELETE FROM provider_pulsa WHERE id = '$id'") == true) {
                    $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip, Provider Layanan Top Up Berhasil Di Hapus.');
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

        <!-- Start Page Data Provider Service Social Media -->
        <div class="row">
            <div class="col-md-12">
                <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title m-t-0 id="myModalLabel""><i class="fa fa-cog"></i> Tambah Provider Layanan Sosial Media</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal" role="form" method="POST">
                                    <input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Kode Provider</label>
                                        <div class="col-md-12">
                                            <input type="text" name="code" class="form-control" placeholder="Kode Provider">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Link Provider</label>
                                        <div class="col-md-12">
                                            <input type="text" name="link" class="form-control" placeholder="Link Provider">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">API Key</label>
                                        <div class="col-md-12">
                                            <input type="text" name="api_key" class="form-control" placeholder="API Key">
                                        </div>
                                    </div>
                                    <!---<div class="form-group">
                                        <label class="col-md-12 control-label">API ID <small class="text-danger">*Kosongkan Jika Tidak Dibutuhkan.</small></label>
                                        <div class="col-md-12">
                                            <input type="text" name="api_id" class="form-control" placeholder="API ID">
                                        </div>
                                    </div>--->
                                    <div class="modal-footer">
                                        <button type="reset" class="btn btn-danger"><i class="fa fa-spinners"></i> Ulangi</button>
                                        <button type="submit" class="btn btn-primary" name="tambah_sosmed"><i class="fa fa-plus"></i> Tambah</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
	        <div class="col-lg-12">
		        <div class="kt-portlet">
			        <div class="kt-portlet__head">
				        <div class="kt-portlet__head-label">
					        <h3 class="kt-portlet__head-title">
					            <i class="fa fa-cog text-primary"></i>
					            Daftar Provider Layanan Sosial Media
					        </h3>
				        </div>
			        </div>
			        <div class="kt-portlet__body">
			        <div class="row">
			            <div class="col-6 text-left">
			            <button data-toggle="modal" data-target="#addModal" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah</button>
			            </div>
			        </div>
			        <br />
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
                                    <th>No</th>
                                    <th>Kode Provider</th>
                                    <th>Link Provider</th>
                                    <th>Api Key</th>
                                    <!---<th>Api ID</th>--->
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
<?php
$no = 1;
    $CallDB_Provider = $conn->query("SELECT * FROM provider ORDER BY id DESC"); // edit
    while ($ShowData = $CallDB_Provider->fetch_assoc()) {
?>
                                <tr>
                                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>?this_id=<?php echo $ShowData['id']; ?>" class="form-inline" role="form" method="POST">
                                    <input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
                                    <td scope="row"><?php echo $no++; ?></td>
                                    <td><input type="text" class="form-control" style="width: 200px;" name="code" value="<?php echo $ShowData['code']; ?>"></td>
                                    <td><input type="text" class="form-control" style="width: 300;" name="link" value="<?php echo $ShowData['link']; ?>"></td>
                                    <td><input type="text" class="form-control" style="width: 300;" name="api_key" value="<?php echo $ShowData['api_key']; ?>"></td>
                                    <!---<td><input type="text" class="form-control" style="width: 200px;" name="api_id" value="<?php echo $ShowData['api_id']; ?>"></td>--->
                                    <td align="center">
                                        <button data-toggle="tooltip" title="Ubah" type="submit" name="ubah_sosmed" class="btn btn-sm btn-bordred btn-warning"><i class="fa fa-pencil-alt"></i></button>
                                        <button data-toggle="tooltip" title="Hapus" type="submit" name="hapus_sosmed" class="btn btn-sm btn-bordred btn-danger"><i class="fa fa-trash"></i></button>
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
        <!-- End Page Data Provider Service Social Media -->

        <!-- Start Page Data Provider Service Top Up -->
        <div class="row">
            <div class="col-md-12">
                <div class="modal fade" id="addModall" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title m-t-0 id="myModalLabel""><i class="fa fa-cog"></i> Tambah Provider Layanan Top Up</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal" role="form" method="POST">
                                    <input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Kode Provider</label>
                                        <div class="col-md-12">
                                            <input type="text" name="code" class="form-control" placeholder="Kode Provider">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Link Provider</label>
                                        <div class="col-md-12">
                                            <input type="text" name="link" class="form-control" placeholder="Link Provider">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">API Key</label>
                                        <div class="col-md-12">
                                            <input type="text" name="api_key" class="form-control" placeholder="API Key">
                                        </div>
                                    </div>
                                    <!---<div class="form-group">
                                        <label class="col-md-12 control-label">ID</label>
                                        <div class="col-md-12">
                                            <input type="text" name="api_id" class="form-control" placeholder="ID">
                                        </div>
                                    </div>--->
                                    <div class="modal-footer">
                                        <button type="reset" class="btn btn-danger"><i class="fa fa-spinner"></i> Ulangi</button>
                                        <button type="submit" class="btn btn-primary" name="tambah_top_up"><i class="fa fa-plus"></i> Tambah</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
	        <div class="col-lg-12">
		        <div class="kt-portlet">
			        <div class="kt-portlet__head">
				        <div class="kt-portlet__head-label">
					        <h3 class="kt-portlet__head-title">
					            <i class="fa fa-cog text-primary"></i>
					            Daftar Provider Layanan Top Up
					        </h3>
				        </div>
			        </div>
			        <div class="kt-portlet__body">
			        <div class="row">
			            <div class="col-6 text-left">
			            <button data-toggle="modal" data-target="#addModall" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah</button>
			            </div>
			        </div>
			        <br />
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered nowrap m-0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Provider</th>
                                    <th>Link Provider</th>
                                    <th>Api Key</th>
                                    <!---<th>ID</th>--->
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
<?php
$no = 1;
    $Cek_Provider = $conn->query("SELECT * FROM provider_pulsa ORDER BY id DESC"); // edit
    while ($Data = $Cek_Provider->fetch_assoc()) {
?>
                                <tr>
                                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $Data['id']; ?>" class="form-inline" role="form" method="POST">
                                    <input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
                                    <td scope="row"><?php echo $no++; ?></td>
                                    <td><input type="text" class="form-control" style="width: 200px;" name="code" value="<?php echo $Data['code']; ?>"></td>
                                    <td><input type="text" class="form-control" style="width: 300;" name="link" value="<?php echo $Data['link']; ?>"></td>
                                    <td><input type="text" class="form-control" style="width: 300;" name="key" value="<?php echo $Data['api_key']; ?>"></td>
                                    <!---<td><input type="text" class="form-control" style="width: 200px;" name="api_id" value="<?php echo $Data['api_id']; ?>"></td>--->
                                    <td align="center">
                                        <button data-toggle="tooltip" title="Ubah" type="submit" name="ubah_top_up" class="btn btn-sm btn-bordred btn-warning"><i class="fa fa-pencil-alt"></i></button>
                                        <button data-toggle="tooltip" title="Hapus" type="submit" name="hapus_top_up" class="btn btn-sm btn-bordred btn-danger"><i class="fa fa-trash"></i></button>
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
        <!-- End Page Data Provider Service Top Up -->

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