<?php 
session_start();
require '../config.php';
require '../lib/session_login.php';
require '../lib/session_user.php';

        if ($data_user['level'] == 'Member') {
	        $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Dilarang Mengakses!.');
	        exit(header("Location: ".$config['web']['url']));
        }

	    if (isset($_POST['transfer'])) {
	        $post_metode = $conn->real_escape_string(filter($_POST['radio7']));
            $tujuan = $conn->real_escape_string(filter($_POST['tujuan']));
            $jumlah = $conn->real_escape_string(filter($_POST['jumlah']));
            $pin = $conn->real_escape_string(filter($_POST['pin']));

            $cek_tujuan = $conn->query("SELECT * FROM users WHERE username = '$tujuan'");
            $cek_tujuan_rows = mysqli_num_rows($cek_tujuan);

            if ($post_metode == "saldo_top_up") {
		        $post_metodee = "Saldo Top Up";
            }

            $error = array();
            if (empty($post_metode)) {
		        $error ['radio7'] = '*Wajib Pilih Salah Satu.';
            }
            if (empty($tujuan)) {
		        $error ['tujuan'] = '*Tidak Boleh Kosong.';
            }
            if (empty($jumlah)) {
		        $error ['jumlah'] = '*Tidak Boleh Kosong.';
            }
            if (empty($pin)) {
		        $error ['pin'] = '*Tidak Boleh Kosong.';
            } else if ($pin <> $data_user['pin']) {
		        $error ['pin'] = '*PIN Yang Kamu Masukkan Salah.';
            } else {

		    if ($cek_tujuan_rows == 0 ) {
			    $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Nama Pengguna Tujuan Tidak Ditemukan.<script>swal("Ups Gagal!", "Nama Pengguna Tujuan Tidak Ditemukan.", "error");</script>');
		    } else if ($jumlah < 5000 ) {
			    $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Minimal Transfer Saldo Adalah Rp 5.000.<script>swal("Ups Gagal!", "Minimal Transfer Saldo Adalah Rp 5.000.", "error");</script>');
		    } else if ($data_user['saldo_top_up'] < $jumlah ) {
			    $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Saldo Top Up Kamu Tidak Mencukupi Untuk Melakukan Transfer Saldo.<script>swal("Ups Gagal!", "Saldo Top Up Kamu Tidak Mencukupi Untuk Melakukan Transfer Saldo.", "error");</script>');
		    } else {

			            $check_top = $conn->query("SELECT * FROM top_depo WHERE username = '$tujuan'");
			            $data_top = mysqli_fetch_assoc($check_top);
			        if ($conn->query("UPDATE users set $post_metode = $post_metode + $jumlah WHERE username = '$tujuan'") == true) {
				        $conn->query("UPDATE users set saldo_top_up = saldo_top_up - $jumlah, pemakaian_saldo = pemakaian_saldo + $jumlah  WHERE username = '$sess_username'");
                        $conn->query("INSERT INTO riwayat_saldo_koin VALUES ('', '$sess_username', 'Saldo', 'Pengurangan Saldo', '$jumlah', 'Mengurangi Saldo Top Up Melalui Transfer Saldo Ke $tujuan Sejumlah Rp $jumlah', '$date', '$time')");	
                        $conn->query("INSERT INTO riwayat_saldo_koin VALUES ('', '$tujuan', 'Saldo', 'Penambahan Saldo', '$jumlah', 'Mendapatkan $post_metodee Melalui Transfer Saldo Dari $sess_username Sejumlah Rp $jumlah ', '$date', '$time')");
                        $conn->query("INSERT INTO riwayat_transfer VALUES ('', '$post_metodee', '$sess_username', '$tujuan', '$jumlah','$date', '$time')");
					    if (mysqli_num_rows($check_top) == 0) {
				            $insert_topup = $conn->query("INSERT INTO top_depo VALUES ('', 'Deposit', '$tujuan', '$jumlah', '1')");
				        } else {
				            $insert_topup = $conn->query("UPDATE top_depo SET jumlah = ".$data_top['jumlah']."+$jumlah, total = ".$data_top['total']."+1 WHERE username = '$tujuan' AND method = 'Deposit'");
				        }
                        $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip, Berhasil Transfer Saldo.');
				    } else {
				        $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.<script>swal("Ups Gagal!", "Sistem Kami Sedang Mengalami Gangguan.", "error");</script>');
			        }
			    }					
		    }
	    }

        require '../lib/header.php';

?>

        <!-- Start Sub Header -->
        <div class="kt-subheader kt-grid__item" id="kt_subheader">
	        <div class="kt-container">
	            <div class="kt-subheader__main">
		            <h3 class="kt-subheader__title">Transfer Saldo</h3>
	                <div class="kt-subheader__breadcrumbs">
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
	                	<span class="kt-subheader__breadcrumbs-separator"></span>
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-link">Halaman Utama</a>
	                	<span class="kt-subheader__breadcrumbs-separator"></span>
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-link">Transfer Saldo</a>
	                </div>
	            </div>
	        </div>
        </div>
        <!-- End Sub Header -->

        <!-- Start Content -->
        <div class="kt-container kt-grid__item kt-grid__item--fluid">

        <!-- Start Page Transfer Balance -->
        <div class="row">
	        <div class="col-md-2"></div><div class="col-md-8">
		        <div class="kt-portlet">
			        <div class="kt-portlet__head">
				        <div class="kt-portlet__head-label">
					        <h3 class="kt-portlet__head-title">
					            <i class="fa fa-exchange-alt text-primary"></i>
					            Transfer Saldo
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
						        <label class="col-xl-3 col-lg-3 col-form-label">Transfer Saldo Ke</label>
						        <div class="col-lg-9 col-xl-6">
							         <div class="kt-radio-list">
								        <label class="kt-radio kt-radio--bold kt-radio--brand">
									        <input type="radio" name="radio7" id="metod" value="saldo_top_up">Saldo Pengguna
									        <span></span>
								        </label>
								        <span class="form-text text-muted"><?php echo ($error['radio7']) ? $error['radio7'] : '';?></span>
							        </div>
						        </div>
							</div>
							<div class="form-group row">
								<label class="col-xl-3 col-lg-3 col-form-label">Nama Pengguna Tujuan</label>
								<div class="col-lg-9 col-xl-6">
									<input type="text" name="tujuan" class="form-control" placeholder="Nama Pengguna Tujuan" value="<?php echo $tujuan; ?>">
									<span class="form-text text-muted"><?php echo ($error['tujuan']) ? $error['tujuan'] : '';?></span>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-xl-3 col-lg-3 col-form-label">Jumlah Transfer</label>
								<div class="col-lg-9 col-xl-6">
									<input type="number" name="jumlah" class="form-control" placeholder="Jumlah Transfer" value="<?php echo $jumlah; ?>">
									<span class="form-text text-muted"><?php echo ($error['jumlah']) ? $error['jumlah'] : '';?></span>
								</div>
							</div>
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
                                            <button type="submit" name="transfer" class="btn btn-primary btn-elevate btn-pill btn-elevate-air">Submit</button>
                                            <button type="reset" class="btn btn-danger btn-elevate btn-pill btn-elevate-air">Ulangi</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
						</div>    
					</form>
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
					            Daftar Riwayat Transfer Saldo
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
                                <label>Cari Penerima</label>
                                <input type="text" class="form-control" name="aksi" placeholder="Cari Penerima">
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
								    <th>No</th>
								    <th>Tanggal & Waktu</th>
								    <th>Tipe</th>
								    <th>Penerima</th>
								    <th>Jumlah</th>
							    </tr>
							</thead>
							<tbody>
<?php 
// start paging config
$no=1;
if (isset($_GET['tampil'])) {
    $cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
    $cari_aksi = $conn->real_escape_string(filter($_GET['aksi']));

    $cek_riwayat = "SELECT * FROM riwayat_transfer WHERE penerima LIKE '%$cari_aksi%' AND pengirim = '$sess_username' ORDER BY id DESC"; // edit
} else {
    $cek_riwayat = "SELECT * FROM riwayat_transfer WHERE pengirim = '$sess_username' ORDER BY id DESC"; // edit
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
?>
							    <tr>
								    <th scope="row"><span class="badge badge-dark"><?php echo $no++ ?></span></th>
								    <td><?php echo tanggal_indo($data_riwayat['date']); ?>, <?php echo $data_riwayat['time']; ?></td>
								    <td><span class="badge badge-primary"><?php echo $data_riwayat['tipe']; ?></span></td>
								    <td><span class="badge badge-success"><?php echo $data_riwayat['penerima']; ?></span></td>
								    <td><span class="badge badge-warning">Rp <?php echo number_format($data_riwayat['jumlah'],0,',','.'); ?></span></td>
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
        <!-- End Page Transfer Balance -->

        </div>
        <!-- End Content -->

        <!-- Start Scrolltop -->
		<div id="kt_scrolltop" class="kt-scrolltop">
		    <i class="fa fa-arrow-up"></i>
		</div>
		<!-- End Scrolltop -->

<?php
require '../lib/footer.php';
?>