<?php
session_start();
require '../config.php';
require '../lib/session_login_admin.php'; 

        if (isset($_POST['tambah'])) {
            $nama_depan = $conn->real_escape_string(filter($_POST['nama_depan']));
            $nama_belakang = $conn->real_escape_string(filter($_POST['nama_belakang']));
            $email = $conn->real_escape_string(trim($_POST['email']));
            $no_hp = $conn->real_escape_string(filter($_POST['no_hp']));
            $username = $conn->real_escape_string(filter($_POST['username']));
            $password = $conn->real_escape_string(trim($_POST['password']));
            $saldo_sosmed = $conn->real_escape_string(filter($_POST['saldo_sosmed']));
            $saldo_top_up = $conn->real_escape_string(filter($_POST['saldo_top_up']));
            $level = $conn->real_escape_string($_POST['level']);
            $pin = $conn->real_escape_string(filter($_POST['pin']));

            $hash_pass = password_hash($password, PASSWORD_DEFAULT);

            $cek_username = $conn->query("SELECT * FROM users WHERE username = '$username'");
            $cek_email = $conn->query("SELECT * FROM users WHERE email = '$email'");
            $cek_no_hp = $conn->query("SELECT * FROM users WHERE no_hp = '$no_hp'");
            $api_key =  acak(20);
            $terdaftar = "$date $time";
            $kode_referral = acak(3).acak_nomor(4);

            if (!$nama_depan || !$nama_belakang || !$email || !$no_hp || !$username || !$password || !$level || !$pin) {
                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Mohon Mengisi Semua Input.');
            } else if ($level != "Member" AND $level != "Agen") {
                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Input Tidak Sesuai.');
            } else if ($cek_username->num_rows > 0) {
                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Nama Pengguna <strong>'.$username.'</strong> Sudah Terdaftar.'); 
            } else if ($cek_email->num_rows > 0) {
                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Email <strong>'.$email.'</strong> Sudah Terdaftar.');
            } else if ($cek_no_hp->num_rows > 0) {
                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Nomor HP <strong>'.$no_hp.'</strong> Sudah Terdaftar.');
            } else if (strlen($username) < 5) { 
                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Nama Pengguna Minimal 5 Karakter.'); 
            } else if (strlen($password) < 5) { 
                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Kata Sandi Minimal 5 Karakter.');                              
            } else {

                if ($conn->query("INSERT INTO users VALUES ('', '$nama_depan', '$nama_belakang', '$nama_depan $nama_belakang', '$email', '$username', '$hash_pass', '$saldo_sosmed', '$saldo_top_up', '0', '$level', 'Aktif', 'Sudah Verifikasi', '$pin', '$api_key', '$sess_username', '$sess_username', '$date', '$time', '0', '$no_hp', '', 'SM-$kode_referral', '', '', '')") == true) {
                    $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip, Pengguna Baru Telah Berhasil Ditambahkan.');
                } else {
                    $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.<script>swal("Ups Gagal!", "Sistem Kami Sedang Mengalami Gangguan.", "error");</script>');
                }
            }

        } else if (isset($_POST['ubah'])) {
            $get_id = $conn->real_escape_string($_POST['id']);
            $email = $conn->real_escape_string(trim($_POST['email']));
            $no_hp = $conn->real_escape_string(trim($_POST['no_hp']));
            $username = $conn->real_escape_string(trim($_POST['username']));
            $password = $conn->real_escape_string(trim($_POST['password']));
            $saldo_sosmed = $conn->real_escape_string(trim($_POST['saldo_sosmed']));
            $saldo_top_up = $conn->real_escape_string(trim($_POST['saldo_top_up']));
            $koin = $conn->real_escape_string(trim($_POST['koin']));
            $level = $conn->real_escape_string($_POST['level']);
            $status_akun = $conn->real_escape_string($_POST['status_akun']);
            $pin = $conn->real_escape_string(trim($_POST['pin']));

           

            $cek_users = $conn->query("SELECT * FROM users WHERE id = '$get_id'");

            if ($cek_users->num_rows == 0) {
                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Nama Pengguna Tidak Di Temukan.');
            } else {
                if($password == true) {
                     $password_hash = password_hash($password, PASSWORD_DEFAULT);
                     $simpan = $conn->query("UPDATE users SET email = '$email', no_hp = '$no_hp', username = '$username', password = '$password_hash', saldo_sosmed = '$saldo_sosmed', saldo_top_up = '$saldo_top_up', koin = '$koin', level = '$level', status = '$status_akun', pin = '$pin' WHERE id = '$get_id'");
                } else {
                     $simpan = $conn->query("UPDATE users SET email = '$email', no_hp = '$no_hp', username = '$username', saldo_sosmed = '$saldo_sosmed', saldo_top_up = '$saldo_top_up', koin = '$koin', level = '$level', status = '$status_akun', pin = '$pin' WHERE id = '$get_id'");
                }
                    if ($simpan == true) {
                    $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip, Data Pengguna Berhasil Di Ubah.');
                } else {
                    $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.<script>swal("Ups Gagal!", "Sistem Kami Sedang Mengalami Gangguan.", "error");</script>');
                }
            }

        } else if (isset($_POST['hapus'])) {
            $post_id = $conn->real_escape_string($_POST['id']);

            $cek_users = $conn->query("SELECT * FROM users WHERE id = '$post_id'");

            if ($cek_users->num_rows == 0) {
                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Nama Pengguna Tidak Di Temukan.');
            } else {

                if ($conn->query("DELETE FROM users WHERE id = '$post_id'") == true) {
                    $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip, Pengguna Berhasil Di Hapus.');
                } else {
                    $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.<script>swal("Ups Gagal!", "Sistem Kami Sedang Mengalami Gangguan.", "error");</script>');
                }
            }

        } else if (isset($_POST['ganti_api_key'])) {
            $post_id = $conn->real_escape_string($_GET['id']);

            $cek_users = $conn->query("SELECT * FROM users WHERE id = '$post_id'");

            $api_key =  acak(20);

            if ($cek_users->num_rows == 0) {
                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Nama Pengguna Tidak Di Temukan');
            } else {

                if ($conn->query("UPDATE  users SET api_key = '$api_key' WHERE id = '$post_id'") == true) {
                    $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip, API Key Berhasil Di Ubah.');
                } else {
                    $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.<script>swal("Ups Gagal!", "Sistem Kami Sedang Mengalami Gangguan.", "error");</script>');
                }
            }
        }

        $cek_pengguna_sosmed = $conn->query("SELECT SUM(saldo_sosmed) AS total FROM users WHERE level != 'Developers' AND status = 'Aktif'");
        $total_saldo_sosmed_pengguna = $cek_pengguna_sosmed->fetch_assoc();

        $cek_pengguna_top_up = $conn->query("SELECT SUM(saldo_top_up) AS total FROM users WHERE level != 'Developers' AND status = 'Aktif'");
        $total_saldo_top_up_pengguna = $cek_pengguna_top_up->fetch_assoc();

        require("../lib/header_admin.php");

?>

        <!-- Start Sub Header -->
        <div class="kt-subheader kt-grid__item" id="kt_subheader">
	        <div class="kt-container ">
	            <div class="kt-subheader__main">
                    <h3 class="kt-subheader__title">Daftar Pengguna</h3>
                    <span class="kt-subheader__separator kt-hidden"></span>
                    <div class="kt-subheader__breadcrumbs">
                        <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                        <span class="kt-subheader__breadcrumbs-separator"></span>
                        <a href="#" class="kt-subheader__breadcrumbs-link">Halaman Admin</a>
                        <span class="kt-subheader__breadcrumbs-separator"></span>
                        <a href="#" class="kt-subheader__breadcrumbs-link">Daftar Pengguna</a>
	                </div>
	            </div>
	        </div>
        </div>
        <!-- End Sub Header -->

        <!-- Start Content -->
        <div class="kt-container kt-grid__item kt-grid__item--fluid">

        <!-- Start Page Data Users -->
        <div class="row">
            <div class="col-md-12">
                <div class="kt-portlet">
                    <a href="<?php echo $config['web']['url'] ?>admin/daftar-pengguna" class="kt-iconbox btn btn-danger">
                        <div class="kt-portlet__body">
                            <div class="kt-iconbox__body">
                                <div class="kt-iconbox__icon">
 				                    <img src="<?php echo $config['web']['url'] ?>assets/media/icon/user.svg" width="60px">
                                </div>
                                <div class="kt-iconbox__desc text-left">
                                    <h4 class="kt-iconbox__title">
								        <font color="white">Rp <?php echo number_format($total_saldo_sosmed_pengguna['total']+$total_saldo_top_up_pengguna['total'],0,',','.'); ?> (Dari <?php echo $total_pengguna; ?> Pengguna)</font>
							        </h4>
                                    <div class="kt-iconbox__content">
                                        <font color="white">Total Saldo Seluruh Pengguna</font>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="modal fade bs-example-modal-lg" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title m-t-0"><i class="fa fa-user text-primary"></i> Tambah Pengguna</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal" role="form" method="POST">
                                    <input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Nama Depan</label>
                                        <div class="col-md-12">
                                            <input type="text" name="nama_depan" class="form-control" placeholder="Nama Depan">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Nama Belakang</label>
                                        <div class="col-md-12">
                                            <input type="text" name="nama_belakang" class="form-control" placeholder="Nama Belakang">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Email</label>
                                        <div class="col-md-12">
                                            <input type="email" name="email" class="form-control" placeholder="Email Aktif">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Nomor HP <small class="text-danger">*Format Nomor HP Wajib 62.</small></label>
                                        <div class="col-md-12">
                                            <input type="number" name="no_hp" class="form-control" placeholder="Nomor HP">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Nama Pengguna</label>
                                        <div class="col-md-12">
                                            <input type="text" name="username" class="form-control" placeholder="Nama Pengguna">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Kata Sandi</label>
                                        <div class="col-md-12">
                                            <input type="text" name="password" class="form-control" placeholder="Kata Sandi">
                                        </div>
                                    </div>
                                    <!--<div class="form-group">
                                        <label class="col-md-12 control-label">Saldo Sosial Media</label>
                                        <div class="col-md-12">
                                            <input type="number" name="saldo_sosmed" class="form-control" placeholder="Saldo Sosial Media">
                                        </div>
                                    </div>-->
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Saldo</label>
                                        <div class="col-md-12">
                                            <input type="number" name="saldo_top_up" class="form-control" placeholder="Saldo">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Level</label>
                                        <div class="col-md-12">
                                            <select class="form-control" name="level">
                                                <option value="Member">Member</option>
                                                <option value="Agen">Agen</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">PIN</label>
                                        <div class="col-md-12">
                                            <input type="number" name="pin" class="form-control" placeholder="PIN Transaksi Harus 6 Digit">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="reset" class="btn btn-danger"><i class="fa fa-spinner"></i> Ulangi</button>
                                        <button type="submit" class="btn btn-primary" name="tambah"><i class="fa fa-plus"></i> Tambah</button>
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
					            <i class="fa fa-users text-primary"></i>
					            Daftar Pengguna
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
                    <form class="form-horizontal" method="GET">
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label>Tampilkan Beberapa</label>
                                <select class="form-control" name="tampil">
                                    <option value="10">Default</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>                                                          
                            <div class="form-group col-lg-4">
                                <label>Cari Kata Kunci</label>
                                <input type="text" class="form-control" name="search" placeholder="Cari Kata Kunci" value="">
                            </div>
                            <div class="form-group col-lg-4">
                                <label>Submit</label>
                                <button type="submit" class="btn btn-block btn-primary">Filter</button>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">        
                        <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama Lengkap</th>
                                    <th>Nama Pengguna</th>
                                    <!--<th>Saldo Sosial Media</th>-->
                                    <th>Saldo</th>
                                    <th>Koin</th>
                                    <th>Level</th>
                                    <th>Api Key</th>
                                    <th>Status</th>
                                    <th>Status Akun</th>
                                    <th>Tanggal Terdaftar</th>
                                    <th width="14%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
<?php
if (isset($_GET['search'])) {
    $search = $conn->real_escape_string(filter($_GET['search']));
    $nama = $conn->real_escape_string(filter($_GET['search']));
    $uplink = $conn->real_escape_string(filter($_GET['search']));
    $email = $conn->real_escape_string(filter($_GET['search']));

    $cek_pengguna = "SELECT * FROM users WHERE username LIKE '%$search%' ORDER BY id ASC"; // edit
} else {
    $cek_pengguna = "SELECT * FROM users ORDER BY id ASC"; // edit
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
$new_query = $cek_pengguna." LIMIT $starting_position, $records_per_page";
$new_query = $conn->query($new_query);
while ($data_pengguna = $new_query->fetch_assoc()) {
if ($data_pengguna['status'] == "Aktif") {
    $label = "success";
} else if ($data_pengguna['status'] == "Tidak Aktif") {
    $label = "danger";  
}
if ($data_pengguna['status_akun'] == "Sudah Verifikasi") {
    $label2 = "primary";
} else if ($data_pengguna['status_akun'] == "Belum Verifikasi") {
    $label2 = "danger";  
}
?>                                        
                                <tr>
                                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $data_pengguna['id']; ?>" class="form-inline" role="form" method="POST">
                                    <td width="3%"><span class="badge badge-dark"><?php echo $data_pengguna['id']; ?></span></th>
                                    <td><?php echo $data_pengguna['nama']; ?></td>
                                    <td width="10%"><span class="badge badge-primary"><?php echo $data_pengguna['username']; ?></span></td>
                                    <!--<td width="5%"><span class="badge badge-success">Rp <?php echo number_format($data_pengguna['saldo_sosmed'],0,',','.'); ?></span></td>-->
                                    <td width="5%"><span class="badge badge-warning">Rp <?php echo number_format($data_pengguna['saldo_top_up'],0,',','.'); ?></span></td>
                                    <td width="5%"><span class="badge badge-danger"><?php echo number_format($data_pengguna['koin'],0,',','.'); ?></span></td>
                                    <td width="5%"><span class="badge badge-info"><?php echo $data_pengguna['level']; ?></span></td>
                                    <td><?php echo $data_pengguna['api_key']; ?>
                                        <input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
                                        <button type="submit" name="ganti_api_key" class="btn btn-sm btn-bordred btn-dark"><i class="fa fa-exchange-alt" title="Ganti API Key"></i></button>   
                                    </td>
                                    <td><span class="badge badge-<?php echo $label; ?>"><?php echo $data_pengguna['status']; ?></span></td>
                                    <td><span class="badge badge-<?php echo $label2; ?>"><?php echo $data_pengguna['status_akun']; ?></span></td>
                                    <td><?php echo tanggal_indo($data_pengguna['date']); ?>, <?php echo $data_pengguna['time']; ?></td>
                                    <td align="text-center">
                                        <a href="javascript:;" onclick="users('<?php echo $config['web']['url']; ?>admin/ajax/pengguna/view?id=<?php echo $data_pengguna['id']; ?>')" class="btn btn-sm btn-primary"><i class="fa fa-list" title="Lihat"></i></a>
                                        <a href="javascript:;" onclick="users('<?php echo $config['web']['url']; ?>admin/ajax/pengguna/ubah?id=<?php echo $data_pengguna['id']; ?>')" class="btn btn-sm btn-warning"><i class="fa fa-pencil-alt" title="Ubah"></i></a>
                                        <a href="javascript:;" onclick="users('<?php echo $config['web']['url']; ?>admin/ajax/pengguna/hapus?id=<?php echo $data_pengguna['id']; ?>')" class="btn btn-sm btn-danger"><i class="fa fa-trash" title="Hapus"></i></a>
                                    </td>                                                
                                    </form>
                                </tr>
<?php } ?>                                        
                            </tbody>
                        </table>
                        <br>
                            <div class="kt-pagination kt-pagination--brand kt-pagination--circle">
                                <ul class="kt-pagination__links">
<?php
// start paging link
if (isset($_GET['search'])) {
$cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
} else {
$cari_urut =  10;
}  
if (isset($_GET['search'])) {
    $search = $conn->real_escape_string(filter($_GET['search']));
    $cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
} else {
    $self = $_SERVER['PHP_SELF'];
}
$cek_pengguna = $conn->query($cek_pengguna);
$total_records = mysqli_num_rows($cek_pengguna);
echo "<li class='page-item disabled'><a href='#'>Total Data : ".$total_records."</a></li>";
if($total_records > 0) {
    $total_pages = ceil($total_records/$records_per_page);
    $current_page = 1;
    if(isset($_GET["halaman"])) {
        $current_page = $conn->real_escape_string(filter($_GET["halaman"]));
        if ($current_page < 1) {
            $current_page = 1;
        }
    }
    if($current_page > 1) {
        $previous = $current_page-1;
if (isset($_GET['search'])) {
    $search = $conn->real_escape_string(filter($_GET['search']));
    $cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
        echo "<li class='kt-pagination__link--first'><a href='".$self."?halaman=1&tampil=".$cari_urut."&search=".$search."'><i class='fa fa-angle-double-left kt-font-brand'></i></a></li>";
        echo "<li class='kt-pagination__link--first'><a href='".$self."?halaman=".$previous."&tampil=".$cari_urut."&search=".$search."'><i class='fa fa-angle-left kt-font-brand'></i></a></li>";
} else {
        echo "<li class='kt-pagination__link--first'><a href='".$self."?halaman=1'><i class='fa fa-angle-double-left kt-font-brand'></i></a></li>";
        echo "<li class='kt-pagination__link--first'><a href='".$self."?halaman=".$previous."'><i class='fa fa-angle-left kt-font-brand'></i></a></li>";
}
}
    // limit page
    $limit_page = $current_page+3;
    $limit_show_link = $total_pages-$limit_page;
    if ($limit_show_link < 0) {
        $limit_show_link2 = $limit_show_link*2;
        $limit_link = $limit_show_link - $limit_show_link2;
        $limit_link = 3 - $limit_link;
    } else {
        $limit_link = 3;
    }
    $limit_page = $current_page+$limit_link;
    // end limit page
    // start page
    if ($current_page == 1) {
        $start_page = 1;
    } else if ($current_page > 1) {
        if ($current_page < 4) {
            $min_page  = $current_page-1;
        } else {
            $min_page  = 3;
        }
        $start_page = $current_page-$min_page;
    } else {
        $start_page = $current_page;
    }
    // end start page
    for($i=$start_page; $i<=$limit_page; $i++) {
if (isset($_GET['search'])) {
    $search = $conn->real_escape_string(filter($_GET['search']));
    $cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
        if($i==$current_page) {
            echo "<li class='kt-pagination__link--active'><a href='#'>".$i."</a></li>";
        } else {
            echo "<li class='kt-pagination__link--first'><a href='".$self."?halaman=".$i."&tampil=".$cari_urut."&search=".$search."'>".$i."</a></li>";
        }
    } else {
        if($i==$current_page) {
            echo "<li class='kt-pagination__link--active'><a href='#'>".$i."</a></li>";
        } else {
            echo "<li class='kt-pagination__link--first'><a href='".$self."?halaman=".$i."'>".$i."</a></li>";
        }        
    }
    }
    if($current_page!=$total_pages) {
        $next = $current_page+1;
if (isset($_GET['search'])) {
    $search = $conn->real_escape_string(filter($_GET['search']));
    $cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
        echo "<li class='kt-pagination__link--first'><a href='".$self."?halaman=".$next."&tampil=".$cari_urut."&search=".$search."'><i class='fa fa-angle-right kt-font-brand'></i></a></li>";
        echo "<li class='kt-pagination__link--first'><a href='".$self."?halaman=".$total_pages."&tampil=".$cari_urut."&search=".$search."'><i class='fa fa-angle-double-right kt-font-brand'></i></a></li>";
} else {
        echo "<li class='kt-pagination__link--first'><a href='".$self."?halaman=".$next."'><i class='fa fa-angle-right kt-font-brand'></i></a></li>";
        echo "<li class='kt-pagination__link--first'><a href='".$self."?halaman=".$total_pages."'><i class='fa fa-angle-double-right kt-font-brand'></i></a></li>";
    }
}
}
// end paging link
?>                  
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Data Users -->

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
                                <h4 class="modal-title mt-0" id="myModalLabel"><i class="fa fa-user text-primary"></i> Pengguna</h4>
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