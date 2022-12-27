<?php
session_start();
require '../config.php';
require '../lib/session_user.php';

	    if (isset($_POST['kirim'])) {
			require '../lib/session_login.php';
			$post_subjek = $conn->real_escape_string(filter($_POST['subjek']));
			$post_pesan = $conn->real_escape_string(filter($_POST['pesan']));

	        $error = array();
	        if (empty($post_subjek)) {
			    $error ['subjek'] = '*Tidak Boleh Kosong.';
	        } else if (strlen($post_subjek) > 200) {
			    $error ['subjek'] = '*Maksimal Pengisian Subjek Adalah 200 Karakter.';
	        }
	        if (empty($post_pesan)) {
			    $error ['pesan'] = '*Tidak Boleh Kosong.';
	        } else if (strlen($post_pesan) > 500) {
			    $error ['pesan'] = '*Maksimal Pengisian Pesan Adalah 500 Karakter.';
	        } else {

				$insert_tiket = $conn->query("INSERT INTO tiket VALUES ('', '$sess_username', '$post_subjek', '$post_pesan', '$date', '$time', '$date $time', 'Pending','1','0')");
				if ($insert_tiket == TRUE) {
					$_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip! Tiketmu Berhasil Dibuat, Harap Menunggu Respon Dari Admin Ya.<script>swal("Berhasil!", "Tiketmu Berhasil Dibuat Nih.", "success");</script>');
				} else {
					$_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.<script>swal("Ups Gagal!", "Sistem Kami Sedang Mengalami Gangguan.", "error");</script>');
				}

			}
		}

		require("../lib/header.php");

?>

        <!-- Start Sub Header -->
        <div class="kt-subheader kt-grid__item" id="kt_subheader">
	        <div class="kt-container">
	            <div class="kt-subheader__main">
		            <h3 class="kt-subheader__title">Tiket</h3>
	                <div class="kt-subheader__breadcrumbs">
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
	                	<span class="kt-subheader__breadcrumbs-separator"></span>
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-link">Halaman Utama</a>
	                	<span class="kt-subheader__breadcrumbs-separator"></span>
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-link">Tiket</a>
	                </div>
	            </div>
	        </div>
        </div>
        <!-- End Sub Header -->

        <!-- Start Content -->
        <div class="kt-container kt-grid__item kt-grid__item--fluid">

        <!-- Start Page Help -->
        <div class="row">
	        <div class="col-lg-12">
		        <div class="kt-portlet">
			        <div class="kt-portlet__head">
				        <div class="kt-portlet__head-label">
					        <h3 class="kt-portlet__head-title">
					            <i class="flaticon-multimedia text-primary"></i>
					            Tiket
					        </h3>
				        </div>
			        </div>
			        <div class="kt-portlet__body">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a href="#buat-tiket" data-toggle="tab" aria-expanded="false" class="nav-link">
                                    <span class="d-block d-sm-none"><i class="fa fa-envelope"></i>Buat Tiket</span>
                                    <span class="d-none d-sm-block"><i class="fa fa-envelope"></i>Buat Tiket</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#daftar-tiket" data-toggle="tab" aria-expanded="false" class="nav-link active">      
                                    <span class="d-block d-sm-none"><i class="fa fa-list"></i>Daftar Tiket</span>
                                    <span class="d-none d-sm-block"><i class="fa fa-list"></i>Daftar Tiket</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade" id="buat-tiket">
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
							<div class="alert alert-primary">
							    <div class="alert-text">
									<h4 class="text-uppercase text-white">Tata Cara Pengisian Form Subjek</h4><br />
									<li><strong>Pesanan</strong> : Masalah Mengenai Dengan Pesanan.</li><br />
									<li><strong>Isi Saldo</strong> : Masalah Mengenai Dengan Isi Saldo.</li><br />
									<li><strong>Layanan</strong> : Masalah Mengenai Dengan Layanan.</li><br />
									<li><strong>Lainnya</strong> : Masalah Mengenai Dengan Hal Yang Lainnya.</li>
								</div>
							</div>
							<form class="form-horizontal" method="POST">
								<input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
									<div class="form-group">
										<label class="col-lg-10 control-label">Subjek</label>
										<div class="col-lg-12">
											<select class="form-control" name="subjek" id="subjek">
											    <option value="Pesanan">Pesanan</option>
											    <option value="Isi Saldo">Isi Saldo</option>
											    <option value="Layanan">Layanan</option>
											    <option value="Lainnya">Lainnya</option>
											</select>
										    <span class="form-text text-muted"><?php echo ($error['subjek']) ? $error['subjek'] : '';?></span>
										</div>
									</div>	
									<div class="form-group">
										<label class="col-lg-10 control-label">Pesan</label>
										<div class="col-lg-12">
											<textarea type="text" class="form-control" placeholder="Keluhan Pesanan, Deposit, Tentang Layanan, Atau Yang Lainya" value="<?php echo $post_pesan; ?>" name="pesan"></textarea>
										    <span class="form-text text-muted"><?php echo ($error['pesan']) ? $error['pesan'] : '';?></span>
										</div>
									</div>
									<div class="kt-portlet__foot">
                                        <div class="kt-form__actions">
                                            <div class="row">
                                                <div class="col-lg-5 col-xl-5">
                                                </div>
                                                <div class="col-lg-7 col-xl-7">
                                                    <button type="submit" name="kirim" class="btn btn-primary btn-elevate btn-pill btn-elevate-air">Submit</button>
                                                    <button type="reset" class="btn btn-danger btn-elevate btn-pill btn-elevate-air">Ulangi</button>
                                                </div>
                                            </div>
                                        </div>
									</div>
								</form>
                            </div>
                            <div role="tabpanel" class="tab-pane fade active show" id="daftar-tiket">
                                <form class="form-horizontal" method="GET">
                                    <div class="row">
                                        <div class="form-group col-lg-3">
                                            <label>Tampilkan Beberapa</label>
                                            <select class="form-control" name="tampil">
                                                <option value="10">Default</option>
                                                <option value="20">10</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                            </select>
                                        </div>                                                
                                        <div class="form-group col-lg-3">
                                            <label>Filter Status</label>
                                            <select class="form-control" name="status">
                                                <option value="">Semua</option>
                                                <option value="Pending" >Pending</option>
                                                <option value="Closed" >Closed</option>
                                                <option value="Waiting" >Waiting</option>
                                                <option value="Responded" >Responded</option>
                                            </select>
                                        </div>                                                
                                        <div class="form-group col-lg-3">
                                            <label>Cari Kata Kunci</label>
                                            <input type="text" class="form-control" name="search" placeholder="Cari Kata Kunci" value="">
                                        </div>
                                        <div class="form-group col-lg-3">
                                            <label>Submit</label>
                                            <button type="submit" class="btn btn-block btn-primary">Cari</button>
                                        </div>
                                    </div>
                                </form>
                                <div class="table-responsive">
                                    <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
                                        <thead>
                                            <tr>
                                                <th>Tanggal & Waktu</th>
                                                <th>Update Terakhir</th>
                                                <th>Subjek</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
<?php 
// start paging config
if (isset($_GET['search'])) {
    $cari = $conn->real_escape_string(filter($_GET['search']));
    $cari_status = $conn->real_escape_string(filter($_GET['status']));

    $cek_tiket = "SELECT * FROM tiket WHERE subjek LIKE '%$cari%' AND status LIKE '%$cari_status%' AND user = '$sess_username' ORDER BY id DESC"; // edit
} else {
    $cek_tiket = "SELECT * FROM tiket WHERE user = '$sess_username' ORDER BY id DESC"; // edit
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
$new_query = $cek_tiket." LIMIT $starting_position, $records_per_page";
$new_query = $conn->query($new_query);
// end paging config
while ($data_tiket = $new_query->fetch_assoc()) {
    if ($data_tiket['status'] == "Pending") {
        $label = "warning";
        $btn = "";
    } else if ($data_tiket['status'] == "Closed") {
        $label = "danger";
        $btn = "disabled";
    } else if ($data_tiket['status'] == "Waiting") {
        $label = "info";   
        $btn = ""; 
    } else if ($data_tiket['status'] == "Responded") {
        $label = "success";
        $btn = "";       
    }
?>
                                            <tr>
                                                <td><?php echo tanggal_indo($data_tiket['date']); ?>, <?php echo $data_tiket['time']; ?></td>
                                                <td><?php echo time_elapsed_string($data_tiket['update_terakhir']); ?></td>
                                                <td><span class="btn btn-warning btn-elevate btn-pill btn-elevate-air btn-sm"><?php echo $data_tiket['subjek']; ?></span></td>
                                                <td><span class="btn btn-<?php echo $label; ?> btn-elevate btn-pill btn-elevate-air btn-sm"><?php echo $data_tiket['status']; ?></span></td>
                                                <td align="center"><a href="<?php echo $config['web']['url']; ?>page/help-reply?id=<?php echo $data_tiket['id']; ?>" class="btn btn-primary btn-elevate btn-pill btn-elevate-air btn-sm <?php echo $btn; ?>" ><i class="fa fa-reply"></i> Balas</a></td>
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
    $cari = $conn->real_escape_string(filter($_GET['search']));
    $cari_status = $conn->real_escape_string(filter($_GET['status']));
    $cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
} else {
    $self = $_SERVER['PHP_SELF'];
}
$cek_tiket = $conn->query($cek_tiket);
$total_records = mysqli_num_rows($cek_tiket);
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
    $cari = $conn->real_escape_string(filter($_GET['search']));
    $cari_status = $conn->real_escape_string(filter($_GET['status']));
    $cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
        echo "<li class='kt-pagination__link--first'><a href='".$self."?halaman=1&tampil=".$cari_urut."&status=".$cari_status."&search=".$cari."'><i class='fa fa-angle-double-left kt-font-brand'></i></a></li>";
        echo "<li class='kt-pagination__link--first'><a href='".$self."?halaman=".$previous."&tampil=".$cari_urut."&status=".$cari_status."&search=".$cari."'><i class='fa fa-angle-left kt-font-brand'></i></a></li>";
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
    if (isset($_GET['cari'])) {
    $cari_oid = $conn->real_escape_string(filter($_GET['cari']));
    $cari_status = $conn->real_escape_string(filter($_GET['status']));
    $cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
        if($i==$current_page) {
            echo "<li class='kt-pagination__link--active'><a href='#'>".$i."</a></li>";
        } else {
            echo "<li class='kt-pagination__link--first'><a href='".$self."?halaman=".$i."&tampil=".$cari_urut."&status=".$cari_status."&search=".$cari."'>".$i."</a></li>";
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
    $cari = $conn->real_escape_string(filter($_GET['search']));
    $cari_status = $conn->real_escape_string(filter($_GET['status']));
    $cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
        echo "<li class='kt-pagination__link--first'><a href='".$self."?halaman=".$next."&tampil=".$cari_urut."&status=".$cari_status."&search=".$cari."'><i class='fa fa-angle-right kt-font-brand'></i></a></li>";
        echo "<li class='kt-pagination__link--first'><a href='".$self."?halaman=".$total_pages."&tampil=".$cari_urut."&status=".$cari_status."&search=".$cari."'><i class='fa fa-angle-double-right kt-font-brand'></i></a></li>";
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
            </div>
        </div>
        <!-- End Page Help -->

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