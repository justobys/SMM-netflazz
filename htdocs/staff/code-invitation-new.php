<?php 
session_start();
require '../config.php';
require '../lib/session_login.php';
require '../lib/session_user.php';

		if ($data_user['level'] == 'Member') {
			$_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Dilarang Mengakses!.');
			exit(header("Location: ".$config['web']['url']));
		}

		if (isset($_POST['buat'])) {
	        $level = $conn->real_escape_string(filter($_POST['level']));
	        $pin = $conn->real_escape_string(filter($_POST['pin']));

	        $kode = acak_nomor(3).acak_nomor(4);

	        $cek_pendaftaran = $conn->query("SELECT * FROM harga_kode_undangan WHERE level = '$level'");
	        $data_pendaftaran = $cek_pendaftaran->fetch_assoc();

	        $error = array();
	        if (empty($level)) {
			    $error ['level'] = '*Wajib Pilih Salah Satu.';
	        }
	        if (empty($pin)) {
			    $error ['pin'] = '*Tidak Boleh Kosong.';
	        } else if ($pin <> $data_user['pin']) {
			    $error ['pin'] = '*PIN Yang Kamu Masukkan Salah.';
	        } else {

			if ($data_user['level'] == "Member") {
				$_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Akun Member Tidak Memiliki Izin Untuk Mengakses Fitur Ini.<script>swal("Ups Gagal!", "Akun Member Tidak Memiliki Izin Untuk Mengakses Fitur Ini.", "error");</script>');

			} else if ($data_user['saldo_top_up'] < $data_pendaftaran['harga']) {
				$_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Yahh, Saldo Top Up Kamu Tidak Mencukupi Untuk Melakukan Buat Kode Undangan.<script>swal("Yahh Gagal!", "Saldo Top Up Kamu Tidak Mencukupi Untuk Melakukan Buat Kode Undangan.", "error");</script>');

			} else {

					$update = $conn->query("UPDATE users SET saldo_top_up = saldo_top_up-".$data_pendaftaran['harga'].", pemakaian_saldo = pemakaian_saldo + ".$data_pendaftaran['harga']." WHERE username = '$sess_username'");
					if ($update == TRUE) {
							$insert = $conn->query("INSERT INTO kode_undangan VALUES ('', '$level', '$sess_username', '$kode', '".$data_pendaftaran['saldo_sosmed']."', '".$data_pendaftaran['saldo_top_up']."', 'Belum Dipakai', '$date', '$time')");
							$insert = $conn->query("INSERT INTO riwayat_saldo_koin VALUES ('', '$sess_username', 'Saldo', 'Pengurangan Saldo', '".$data_pendaftaran['harga']."', 'Mengurangi Saldo Top Up Melalui Buat Kode Undangan Baru Dengan Kode Undangan : $kode', '$date', '$time')");
						if ($insert == TRUE) {
							$_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip, Kode Undangan Berhasil Dibuat.');
						} else {
						    $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.<script>swal("Ups Gagal!", "Sistem Kami Sedang Mengalami Gangguan.", "error");</script>');
					    }
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
		            <h3 class="kt-subheader__title">Kode Undangan</h3>
	                <div class="kt-subheader__breadcrumbs">
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
	                	<span class="kt-subheader__breadcrumbs-separator"></span>
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-link">Halaman Utama</a>
	                	<span class="kt-subheader__breadcrumbs-separator"></span>
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-link">Kode Undangan</a>
	                </div>
	            </div>
	        </div>
        </div>
        <!-- End Sub Header -->

        <!-- Start Content -->
        <div class="kt-container kt-grid__item kt-grid__item--fluid">

        <!-- Start Page Code Reffreal -->
        <div class="row">
	        <div class="col-md-2"></div><div class="col-md-8">
		        <div class="kt-portlet">
			        <div class="kt-portlet__head">
				        <div class="kt-portlet__head-label">
					        <h3 class="kt-portlet__head-title">
					            <i class="fa fa-key text-primary"></i>
					            Kode Undangan
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
                    <form class="form-horizontal" role="form" method="POST">
	                    <input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
							<div class="form-group row">
								<label class="col-xl-3 col-lg-3 col-form-label">Level</label>
								<div class="col-lg-9 col-xl-6">
									<select class="form-control" name="level" id="level">
									    <option value="0">Pilih Salah Satu</option>
									    <?php if ($data_user['level'] == "Member"){ ?>
									    <?php } else if ($data_user['level'] == "Agen"){ ?>
									    <option value="Member">Member</option>
									    <?php } else if ($data_user['level'] == "Developers") { ?>
									    <option value="Member">Member</option>
									    <option value="Agen">Agen</option>
									    <?php } ?>
								    </select>
								    <span class="form-text text-muted"><?php echo ($error['level']) ? $error['level'] : '';?></span>
								</div>
							</div>
							<div id="catatan"></div>
                            <div class="form-group row">
                                <label class="col-xl-3 col-lg-3 col-form-label">PIN</label>
                                <div class="col-lg-9 col-xl-6">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="la la-lock text-primary"></i></span></div>
                                        <input type="password" name="pin" class="form-control" placeholder="Masukkan PIN Kamu">
                                    </div>
                                    <span class="form-text text-muted"><?php echo ($error['pin']) ? $error['pin'] : '';?></span>
                                </div>
                            </div>
                            <div class="kt-portlet__foot">
                                <div class="kt-form__actions">
                                    <div class="row">
                                        <div class="col-lg-3 col-xl-3">
                                        </div>
                                        <div class="col-lg-9 col-xl-9">
                                            <button type="submit" name="buat" class="btn btn-primary btn-elevate btn-pill btn-elevate-air">Submit</button>
                                            <button type="reset" class="btn btn-danger btn-elevate btn-pill btn-elevate-air">Ulangi</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
						</form>
					</div>
				</div>
	        </div>
	    </div>

	    <div class="row">
	        <div class="col-md-2"></div><div class="col-md-8">
		        <div class="kt-portlet">
			        <div class="kt-portlet__head">
				        <div class="kt-portlet__head-label">
					        <h3 class="kt-portlet__head-title">
					            <i class="flaticon2-time text-primary"></i>
					            Daftar Kode Undangan Yang Dibuat Oleh Anda
					        </h3>
				        </div>
			        </div>
			        <div class="kt-portlet__body">
                    <form class="form-horizontal" method="GET">
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label>Tampilkan Beberapa</label>
                                <select class="form-control" name="tampil">
                                    <option value="10">Default</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                    <option value="250">250</option>
                                </select>
                            </div>                                                
                            <div class="form-group col-lg-4">
                                <label>Cari Kode Undangan</label>
                                <input type="number" class="form-control" name="aksi" placeholder="Cari Kode Undangan">
                            </div>                                
                            <div class="form-group col-lg-4">
                                <label>Submit</label>
                                <button type="submit" class="btn btn-block btn-primary">Filter</button>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
						<table id="datatable-responsive" class="table table-striped table-bordered nowrap">
							<thead>
							    <tr>
								    <th>No</th>
								    <th>Tanggal & Waktu</th>
								    <th>Kode</th>
								    <th>Level</th>
								    <!--<th>Saldo Sosial Media</th>-->
								    <th>Saldo</th>
								    <th>Status</th>
							    </tr>
							</thead>
							<tbody>
<?php 
// start paging config
$no=1;
if (isset($_GET['tampil'])) {
    $cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
    $cari_aksi = $conn->real_escape_string(filter($_GET['aksi']));

    $cek_riwayat = "SELECT * FROM kode_undangan WHERE kode LIKE '%$cari_aksi%' AND uplink = '$sess_username' ORDER BY id DESC"; // edit
} else {
    $cek_riwayat = "SELECT * FROM kode_undangan WHERE uplink = '$sess_username' ORDER BY id DESC"; // edit
}
if (isset($_GET['tampil'])) {
$cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
$records_per_page = $cari_urut; // edit
} else {
    $records_per_page = 10; // edit
}

$starting_position = 0;
if(isset($_GET["halaman"])) {
    $starting_position = ($conn->real_escape_string(filter($_GET["halaman"]))-1) * $records_per_page;
}
$new_query = $cek_riwayat." LIMIT $starting_position, $records_per_page";
$new_query = $conn->query($new_query);
$no = $starting_position+1;
// end paging config
while ($data_riwayat = $new_query->fetch_assoc()) {
    if ($data_riwayat['status'] == "Belum Dipakai") {
        $label = "primary";
    } else if ($data_riwayat['status'] == "Sudah Dipakai") {
        $label = "danger";
    }
?>
							    <tr>
								    <th scope="row"><span class="badge badge-dark"><?php echo $no++ ?></span></th>
								    <td><?php echo tanggal_indo($data_riwayat['date']); ?>, <?php echo $data_riwayat['time']; ?></td>
								    <td style="min-width: 150px;">
				<div class="input-group">
				<input type="text" class="form-control form-control-sm" value="<?php echo $data_riwayat['kode']; ?>" id="target-<?php echo $data_riwayat['id']; ?>" readonly="">
                                <button data-toggle="tooltip" title="Copy Target" class="btn btn-primary btn-sm" type="button" onclick="copy_to_clipboard('target-<?php echo $data_riwayat['id']; ?>')"><i class="fas fa-copy text-warning"></i></button>
                                                                    </div>
								    <td><span class="badge badge-success"><?php echo $data_riwayat['level']; ?></span></td>
								    <!--<td><span class="badge badge-warning">Rp <?php echo number_format($data_riwayat['saldo_sosmed'],0,',','.'); ?></span></td>-->
								    <td><span class="badge badge-danger">Rp <?php echo number_format($data_riwayat['saldo_top_up'],0,',','.'); ?></span></td>
								    <td><span class="btn btn-<?php echo $label; ?> btn-elevate btn-pill btn-elevate-air btn-sm"><?php echo $data_riwayat['status']; ?></span></td>
							    </tr>
<?php } ?>
							</tbody>
                        </table>
                        <br>
                            <div class="kt-pagination kt-pagination--brand kt-pagination--circle">
                                <ul class="kt-pagination__links">
<?php
// start paging link
if (isset($_GET['tampil'])) {
$cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
} else {
$cari_urut =  10;
}  
if (isset($_GET['tampil'])) {
    $cari_aksi = $conn->real_escape_string(filter($_GET['aksi']));
    $cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
} else {
    $self = $_SERVER['PHP_SELF'];
}
$cek_riwayat = $conn->query($cek_riwayat);
$total_records = mysqli_num_rows($cek_riwayat);
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
    if (isset($_GET['tampil'])) {
    $cari_aksi = $conn->real_escape_string(filter($_GET['aksi']));
    $cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
        echo "<li class='kt-pagination__link--first'><a href='".$self."?halaman=1&tampil=".$cari_urut."&aksi=".$cari_aksi."'><i class='fa fa-angle-double-left kt-font-brand'></i></a></li>";
        echo "<li class='kt-pagination__link--first'><a href='".$self."?halaman=".$previous."&tampil=".$cari_urut."&aksi=".$cari_aksi."'><i class='fa fa-angle-left kt-font-brand'></i></a></li>";
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
    if (isset($_GET['tampil'])) {
    $cari_aksi = $conn->real_escape_string(filter($_GET['aksi']));
    $cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
        if($i==$current_page) {
            echo "<li class='kt-pagination__link--active'><a href='#'>".$i."</a></li>";
        } else {
            echo "<li class='kt-pagination__link--first'><a href='".$self."?halaman=".$i."&tampil=".$cari_urut."&aksi=".$cari_aksi."'>".$i."</a></li>";
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
    if (isset($_GET['tampil'])) {
    $cari_aksi = $conn->real_escape_string(filter($_GET['aksi']));
    $cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
        echo "<li class='kt-pagination__link--first'><a href='".$self."?halaman=".$next."&tampil=".$cari_urut."&aksi=".$cari_aksi."'><i class='fa fa-angle-right kt-font-brand'></i></i></a></li>";
        echo "<li class='kt-pagination__link--first'><a href='".$self."?halaman=".$total_pages."&tampil=".$cari_urut."&aksi=".$cari_aksi."'><i class='fa fa-angle-double-right kt-font-brand'></i></a></li>";
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
        <!-- End Page Code Reffreal -->

        </div>
        <!-- End Content -->

        <!-- Start Scrolltop -->
		<div id="kt_scrolltop" class="kt-scrolltop">
		    <i class="fa fa-arrow-up"></i>
		</div>
		<!-- End Scrolltop -->
		
		<script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.js"></script>
		<script type="text/javascript">
	        function copy_to_clipboard(element) {
	            var copyText = document.getElementById(element);
	            copyText.select();
	            document.execCommand("copy");
	        }
	        </script>
		<script type="text/javascript">
		$(document).ready(function() {
		    $("#level").change(function() {
		        var level = $("#level").val();
		        $.ajax({
			        url: '<?php echo $config['web']['url']; ?>ajax/code-invitation.php',
			        data: 'level=' + level,
			        type: 'POST',
			        dataType: 'html',
			        success: function(msg) {
				        $("#catatan").html(msg);
			        }
		        });
	        });
	    });
		</script>

<?php
require '../lib/footer.php';
?>