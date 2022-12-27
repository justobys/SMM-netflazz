<?php
session_start();
require '../config.php';
require '../lib/session_login_admin.php';

        if (isset($_POST['tambah_admin'])) {
            $nama = $conn->real_escape_string(filter($_POST['nama']));
            $jabatan = $conn->real_escape_string($_POST['jabatan']);
            $deskripsi = $conn->real_escape_string(filter($_POST['deskripsi']));
            $lokasi = $conn->real_escape_string(filter($_POST['lokasi']));
            $jam_kerja = $conn->real_escape_string(filter($_POST['jam_kerja']));
            $email = $conn->real_escape_string(filter($_POST['email']));
            $no_hp = $conn->real_escape_string(filter($_POST['no_hp']));
            $link_fb = $conn->real_escape_string(filter($_POST['link_fb']));
            $link_ig = $conn->real_escape_string(filter($_POST['link_ig']));

            if (!$nama || !$jabatan || !$deskripsi || !$lokasi || !$jam_kerja || !$email || !$no_hp || !$link_fb || !$link_ig) {
                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Mohon Mengisi Semua Input.');
            } else {

                if ($conn->query("INSERT INTO kontak_admin VALUES ('', '$nama', '$jabatan', '$deskripsi', '$lokasi', '$jam_kerja', '$email', '$no_hp', '$link_fb', '$link_ig')") == true) {
                    $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip, Berhasil Menambahkan Kontak Admin Baru.');
                } else {
                    $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.<script>swal("Ups Gagal!", "Sistem Kami Sedang Mengalami Gangguan.", "error");</script>');
                }
            }

        } else if (isset($_POST['ubah_admin'])) {
            $id = $conn->real_escape_string($_POST['id']);
            $nama = $conn->real_escape_string(filter($_POST['nama']));
            $jabatan = $conn->real_escape_string($_POST['jabatan']);
            $deskripsi = $conn->real_escape_string(filter($_POST['deskripsi']));
            $lokasi = $conn->real_escape_string(filter($_POST['lokasi']));
            $jam_kerja = $conn->real_escape_string(filter($_POST['jam_kerja']));
            $email = $conn->real_escape_string(filter($_POST['email']));
            $no_hp = $conn->real_escape_string(filter($_POST['no_hp']));
            $link_fb = $conn->real_escape_string(filter($_POST['link_fb']));
            $link_ig = $conn->real_escape_string(filter($_POST['link_ig']));

            $cek_kontak = $conn->query("SELECT * FROM kontak_admin WHERE id = '$id'");

            if ($cek_kontak->num_rows == 0) {
                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Data Tidak Di Temukan.');
            } else {

                if ($conn->query("UPDATE kontak_admin SET nama = '$nama', jabatan = '$jabatan', deskripsi = '$deskripsi', lokasi = '$lokasi', jam_kerja = '$jam_kerja', email = '$email', no_hp = '$no_hp', link_fb = '$link_fb', link_ig = '$link_ig' WHERE id = '$id'") == true) {
                    $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip, Kontak Admin Berhasil Di Ubah.');
                } else {
                    $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.<script>swal("Ups Gagal!", "Sistem Kami Sedang Mengalami Gangguan.", "error");</script>');
                }
            }

        } else if (isset($_POST['hapus_admin'])) {
            $id = $conn->real_escape_string($_GET['id']);

            $cek_kontak = $conn->query("SELECT * FROM kontak_admin WHERE id = '$id'");

            if ($cek_kontak->num_rows == 0) {
                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Data Tidak Di Temukan.');
            } else {

                if ($conn->query("DELETE FROM kontak_admin WHERE id = '$id'") == true) {
                    $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip, Kontak Admin Berhasil Di Hapus.');
                } else {
                    $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.<script>swal("Ups Gagal!", "Sistem Kami Sedang Mengalami Gangguan.", "error");</script>');
                }
            }
        }

        if (isset($_POST['ubah_web'])) {
            $id = $conn->real_escape_string($_POST['id']);
            $link_fb = $conn->real_escape_string(filter($_POST['link_fb']));
            $link_ig = $conn->real_escape_string(filter($_POST['link_ig']));
            $no_wa = $conn->real_escape_string(filter($_POST['no_wa']));
            $email = $conn->real_escape_string(filter($_POST['email']));
            $alamat = $conn->real_escape_string(filter($_POST['alamat']));
            $kode_pos = $conn->real_escape_string(filter($_POST['kode_pos']));
            $jam_kerja = $conn->real_escape_string(filter($_POST['jam_kerja']));

            $cek_kontak = $conn->query("SELECT * FROM kontak_website WHERE id = '$id'");

            if ($cek_kontak->num_rows == 0) {
                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Data Tidak Di Temukan.');
            } else {

                if ($conn->query("UPDATE kontak_website SET link_fb = '$link_fb', link_ig = '$link_ig', no_wa = '$no_wa', email = '$email', alamat = '$alamat', kode_pos = '$kode_pos', jam_kerja = '$jam_kerja' WHERE id = '$id'") == true) {
                    $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip, Kontak Website Berhasil Di Ubah.');
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
                    <h3 class="kt-subheader__title">Daftar Kontak</h3>
                    <span class="kt-subheader__separator kt-hidden"></span>
                    <div class="kt-subheader__breadcrumbs">
                        <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                        <span class="kt-subheader__breadcrumbs-separator"></span>
                        <a href="#" class="kt-subheader__breadcrumbs-link">Halaman Admin</a>
                        <span class="kt-subheader__breadcrumbs-separator"></span>
                        <a href="#" class="kt-subheader__breadcrumbs-link">Daftar Kontak</a>
	                </div>
	            </div>
	        </div>
        </div>
        <!-- End Sub Header -->

        <!-- Start Content -->
        <div class="kt-container kt-grid__item kt-grid__item--fluid">

        <!-- Start Page Data Contact Admin -->
        <div class="row">
            <div class="col-md-12">
                <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title m-t-0 id="myModalLabel""><i class="fa fa-gears"></i> Tambah Kontak Admin</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal" role="form" method="POST">
                                    <input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Nama Lengkap</label>
                                        <div class="col-md-12">
                                            <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Jabatan</label>
                                        <div class="col-md-12">
                                            <input type="text" name="jabatan" class="form-control" placeholder="Jabatan">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Deskripsi</label>
                                        <div class="col-md-12">
                                            <input type="text" name="deskripsi" class="form-control" placeholder="Deskripsi">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Alamat Rumah</label>
                                        <div class="col-md-12">
                                            <input type="text" name="lokasi" class="form-control" placeholder="Alamat Rumah">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Jam Kerja</label>
                                        <div class="col-md-12">
                                            <input type="text" name="jam_kerja" class="form-control" placeholder="Jam Kerja">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Email</label>
                                        <div class="col-md-12">
                                            <input type="email" name="email" class="form-control" placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Nomor WhatsApp</label>
                                        <div class="col-md-12">
                                            <input type="number" name="no_hp" class="form-control" placeholder="Nomor WhatsApp">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Link Facebook</label>
                                        <div class="col-md-12">
                                            <input type="text" name="link_fb" class="form-control" placeholder="Link Facebook">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Link Instagram</label>
                                        <div class="col-md-12">
                                            <input type="text" name="link_ig" class="form-control" placeholder="Link Instagram">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="reset" class="btn btn-danger"><i class="fa fa-spinner"></i> Ulangi</button>
                                        <button type="submit" class="btn btn-primary" name="tambah_admin"><i class="fa fa-plus"></i> Tambah</button>
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
					            <i class="fa fa-phone text-primary"></i>
					            Daftar Kontak Admin
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
                                    <th>Nama Lengkap</th>
                                    <th>Jabatan</th>
                                    <th>Deskripsi</th>
                                    <th>Alamat Rumah</th>
                                    <th>Jam Kerja</th>
                                    <th>Email</th>
                                    <th>Nomor WhatsApp</th>
                                    <th>Link Facebook</th>
                                    <th>Link Instagram</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
<?php
if (isset($_GET['search'])) {
    $search = $conn->real_escape_string(filter($_GET['search']));

    $cek_kontak = "SELECT * FROM kontak_admin WHERE nama LIKE '%$search%' ORDER BY id DESC"; // edit
} else {
    $cek_kontak = "SELECT * FROM kontak_admin ORDER BY id DESC"; // edit
}
if (isset($_GET['search'])) {
$cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
$records_per_page = $cari_urut; // edit
} else {
    $records_per_page = 10; // edit
}

$starting_position = 0;
if(isset($_GET["halaman"])) {
    $starting_position = ($conn->real_escape_string(filter($_GET["halaman"]))-1) * $records_per_page;
}
$new_query = $cek_kontak." LIMIT $starting_position, $records_per_page";
$new_query = $conn->query($new_query);
// end paging config
while ($data_kontak = $new_query->fetch_assoc()) {
?>
                                <tr>
                                    <td><?php echo $data_kontak['nama']; ?></td>
                                    <td><?php echo $data_kontak['jabatan']; ?></td>
                                    <td><?php echo $data_kontak['deskripsi']; ?></td>
                                    <td><?php echo $data_kontak['lokasi']; ?></td>
                                    <td><?php echo $data_kontak['jam_kerja']; ?></td>
                                    <td><?php echo $data_kontak['email']; ?></td>
                                    <td><?php echo $data_kontak['no_hp']; ?></td>
                                    <td><?php echo $data_kontak['link_fb']; ?></td>
                                    <td><?php echo $data_kontak['link_ig']; ?></td>
                                    <td align="center">
                                        <a href="javascript:;" onclick="users('<?php echo $config['web']['url']; ?>admin/ajax/kontak-admin/ubah?id=<?php echo $data_kontak['id']; ?>')" class="btn btn-sm btn-warning"><i class="fa fa-pencil-alt" title="Ubah"></i></a>
                                        <a href="javascript:;" onclick="users('<?php echo $config['web']['url']; ?>admin/ajax/kontak-admin/hapus?id=<?php echo $data_kontak['id']; ?>')" class="btn btn-sm btn-danger"><i class="fa fa-trash" title="Hapus"></i></a>
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
        <!-- End Page Data Contact Admin -->

        <!-- Start Page Data Contact Website -->
        <div class="row">
	        <div class="col-lg-12">
		        <div class="kt-portlet">
			        <div class="kt-portlet__head">
				        <div class="kt-portlet__head-label">
					        <h3 class="kt-portlet__head-title">
					            <i class="fa fa-phone text-primary"></i>
					            Daftar Kontak Website
					        </h3>
				        </div>
			        </div>
			        <div class="kt-portlet__body">
                    <div class="table-responsive">
                        <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
                            <thead>
                                <tr>
                                    <th>Nomor WhatsApp</th>
                                    <th>Link Facebook</th>
                                    <th>Link Instagram</th>
                                    <th>Email</th>
                                    <th>Alamat</th>
                                    <th>Kode POS</th>
                                    <th>Jam Kerja</th>
                                    <th width="5%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
<?php
if (isset($_GET['search'])) {
    $search = $conn->real_escape_string(filter($_GET['search']));

    $cek_kontak = "SELECT * FROM kontak_website WHERE email LIKE '%$search%' ORDER BY id DESC"; // edit
} else {
    $cek_kontak = "SELECT * FROM kontak_website ORDER BY id DESC"; // edit
}
if (isset($_GET['search'])) {
$cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
$records_per_page = $cari_urut; // edit
} else {
    $records_per_page = 10; // edit
}

$starting_position = 0;
if(isset($_GET["halaman"])) {
    $starting_position = ($conn->real_escape_string(filter($_GET["halaman"]))-1) * $records_per_page;
}
$new_query = $cek_kontak." LIMIT $starting_position, $records_per_page";
$new_query = $conn->query($new_query);
// end paging config
while ($data_kontak = $new_query->fetch_assoc()) {
?>                                       
                                <tr>
                                    <td><?php echo $data_kontak['no_wa']; ?></td>
                                    <td><?php echo $data_kontak['link_fb']; ?></td>
                                    <td><?php echo $data_kontak['link_ig']; ?></td>
                                    <td><?php echo $data_kontak['email']; ?></td>
                                    <td><?php echo $data_kontak['alamat']; ?></td>
                                    <td><?php echo $data_kontak['kode_pos']; ?></td>
                                    <td><?php echo $data_kontak['jam_kerja']; ?></td>
                                    <td align="text-center">
                                        <a href="javascript:;" onclick="users('<?php echo $config['web']['url']; ?>admin/ajax/kontak-website/ubah?id=<?php echo $data_kontak['id']; ?>')" class="btn btn-sm btn-warning"><i class="fa fa-pencil-alt" title="Ubah"></i></a>
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
        <!-- End Page Data Contact Website -->

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
                                <h4 class="modal-title mt-0" id="myModalLabel"><i class="fa fa-phone text-primary"></i> Kontak</h4>
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