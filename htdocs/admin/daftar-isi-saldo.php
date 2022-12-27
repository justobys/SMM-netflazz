<?php
session_start();
require '../config.php';
require '../lib/session_login_admin.php';

        if (isset($_POST['ubah'])) {
            $get_id = $conn->real_escape_string($_GET['id_deposit']);
            $status = $conn->real_escape_string($_POST['status']);

            $deponya = $conn->query("SELECT * FROM deposit WHERE kode_deposit = '$get_id'");
            $datanya = $deponya->fetch_assoc();

            $tipe = $datanya['metode_isi_saldo'];
            $username = $datanya['username'];
            $saldo = $datanya['get_saldo'];

            if ($deponya->num_rows == 0) {
                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Data Isi Saldo Tidak Ditemukan.');
            } else if ($datanya['status'] == "Success") { 
                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Status Isi Saldo Dengan Kode : '.$get_id.' Sudah Berstatus Success');
            } else {

            if ($conn->query("UPDATE deposit SET status = '$status'  WHERE kode_deposit = '$get_id'") == true) {
                if ($status == "Success") {
                    $conn->query("UPDATE users set $tipe = $tipe + $saldo WHERE username = '$username'");
                    $conn->query("INSERT INTO history_saldo VALUES ('', '$username', 'Saldo', 'Penambahan Saldo', '$saldo', 'Mendapatkan Saldo Isi Saldo Via ".$datanya['tipe']." ".$datanya['provider']." Dengan Kode Isi Saldo : $get_id', '$date', '$time')");
                    $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip, Data Deposit Berhasil Di Update.');
                } else {
                    $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip, Data Deposit Berhasil Di Update.');
                }
                } else {
                    $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.<script>swal("Ups Gagal!", "Sistem Kami Sedang Mengalami Gangguan.", "error");</script>');
                }
            }

        } else if (isset($_POST['hapus'])) {
            $get_id = $conn->real_escape_string($_GET['id_deposit']);

            $cek_deponya = $conn->query("SELECT * FROM deposit WHERE kode_deposit = '$get_id'");

            if ($cek_deponya->num_rows == 0) {
                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Data Deposit Tidak Ditemukan.');
            } else {

                if ($conn->query("DELETE FROM deposit WHERE kode_deposit = '$get_id'") == TRUE) {
                    $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip, Data Deposit Berhasil Di Hapus.');
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
                    <h3 class="kt-subheader__title">Daftar Isi Saldo</h3>
                    <span class="kt-subheader__separator kt-hidden"></span>
                    <div class="kt-subheader__breadcrumbs">
                        <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                        <span class="kt-subheader__breadcrumbs-separator"></span>
                        <a href="#" class="kt-subheader__breadcrumbs-link">Halaman Admin</a>
                        <span class="kt-subheader__breadcrumbs-separator"></span>
                        <a href="#" class="kt-subheader__breadcrumbs-link">Daftar Isi Saldo</a>
	                </div>
	            </div>
	        </div>
        </div>
        <!-- End Sub Header -->

        <!-- Start Content -->
        <div class="kt-container kt-grid__item kt-grid__item--fluid">

        <!-- Start Page Data Deposit Balance -->
        <div class="row">
            <div class="col-md-12">
                <div class="kt-portlet">
                    <a href="<?php echo $config['web']['url'] ?>admin/daftar-isi-saldo" class="kt-iconbox btn btn-success">
                        <div class="kt-portlet__body">
                            <div class="kt-iconbox__body">
                                <div class="kt-iconbox__icon">
 				                    <img src="<?php echo $config['web']['url'] ?>assets/media/icon/bank-deposit.svg" width="60px">
                                </div>
                                <div class="kt-iconbox__desc text-left">
                                    <h4 class="kt-iconbox__title">
								        <font color="white">Rp <?php echo number_format($data_deposit['total'],0,',','.'); ?> (Dari <?php echo $count_deposit; ?> Isi Saldo)</font>
							        </h4>
                                    <div class="kt-iconbox__content">
                                        <font color="white">Total Isi Saldo</font>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
	        <div class="col-lg-12">
		        <div class="kt-portlet">
			        <div class="kt-portlet__head">
				        <div class="kt-portlet__head-label">
					        <h3 class="kt-portlet__head-title">
					            <i class="fa fa-credit-card text-primary"></i>
					            Daftar Isi Saldo
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
                    <form class="form-horizontal" method="GET">
                        <div class="row">
                            <div class="form-group col-lg-3">
                                <label>Tampilkan Beberapa</label>
                                <select class="form-control" name="tampil">
                                    <option value="10">Default</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                    <option value="250">250</option>
                                </select>
                            </div>                                                
                            <div class="form-group col-lg-3">
                                <label>Filter Status</label>
                                <select class="form-control" name="status">
                                    <option value="">Semua</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Success">Success</option>
                                    <option value="Error">Error</option>
                                </select>
                            </div>                                                
                            <div class="form-group col-lg-3">
                                <label>Cari Kode Isi Saldo</label>
                                <input type="text" class="form-control" name="cari" placeholder="Cari Kode Isi Saldo" value="">
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Submit</label>
                                <button type="submit" class="btn btn-block btn-primary">Filter</button>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
                            <thead>
                                <tr>
                                    <th>Tanggal & Waktu</th>
                                    <th>Kode Deposit</th>
                                    <th>Nama Pengguna</th>
                                    <th>Tipe</th>
                                    <th>Provider</th>
                                    <th>Metode</th>
                                    <!--<th>Pengirim</th>-->
                                    <!--<th>Penerima</th>-->
                                    <th>Keterangan</th>
                                    <th>Jumlah Transfer</th>
                                    <th>Saldo Didapat</th>
                                    <th width="10%">Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
<?php 
// start paging config
if (isset($_GET['cari'])) {
    $cari_oid = $conn->real_escape_string(filter($_GET['cari']));
    $cari_status = $conn->real_escape_string(filter($_GET['status']));

    $cek_depo = "SELECT * FROM deposit WHERE kode_deposit LIKE '%$cari_oid%' AND status LIKE '%$cari_status%' ORDER BY id DESC"; // edit
} else {
    $cek_depo = "SELECT * FROM deposit ORDER BY id DESC"; // edit
}
if (isset($_GET['cari'])) {
$cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
$records_per_page = $cari_urut; // edit
} else {
    $records_per_page = 10; // edit
}

$starting_position = 0;
if(isset($_GET["halaman"])) {
    $starting_position = ($conn->real_escape_string(filter($_GET["halaman"]))-1) * $records_per_page;
}
$new_query = $cek_depo." LIMIT $starting_position, $records_per_page";
$new_query = $conn->query($new_query);
// end paging config
while ($data_depo = $new_query->fetch_assoc()) {
?>
                                    <tr>
                                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>?id_deposit=<?php echo $data_depo['kode_deposit']; ?>" class="form-inline" role="form" method="POST"> 
                                        <input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
                                        <td><?php echo tanggal_indo($data_depo['date']); ?>, <?php echo $data_depo['time']; ?></span></td>
                                        <td width="5%"><span class="badge badge-primary"><?php echo $data_depo['kode_deposit']; ?></span></td>
                                        <td width="7%"><span class="badge badge-success"><?php echo $data_depo['username']; ?></span></td>
                                        <td width="5%"><span class="badge badge-warning"><?php echo $data_depo['tipe']; ?></span></td>
                                        <td width="5%"><span class="badge badge-danger"><?php echo $data_depo['provider']; ?></span></td>
                                        <td width="5%"><span class="badge badge-info"><?php if ($data_depo['metode_isi_saldo'] == "saldo_sosmed") { ?>Isi Saldo Sosial Media</i></span><?php } else { ?>Isi Saldo Top Up</span><?php } ?></td>
                                        <!--<td><?php echo $data_depo['pengirim']; ?></td>-->
                                        <!--<td><?php echo $data_depo['penerima']; ?></td>-->
                                        <td><?php echo $data_depo['catatan']; ?></td>
                                        <td width="5%"><span class="badge badge-dark">Rp <?php echo number_format($data_depo['jumlah_transfer'],0,',','.'); ?></span></td>                                        
                                        <td width="5%"><span class="badge badge-danger">Rp <?php echo number_format($data_depo['get_saldo'],0,',','.'); ?></span></td>                                        
                                        <td>
                                            <select class="form-control" style="width: 150px;" name="status">
                                            <?php if ($data_depo['status'] == "Success") { ?>
                                            <option value="<?php echo $data_depo['status']; ?>"><?php echo $data_depo['status']; ?></option>
                                            <?php } else { ?>
                                            <option value="<?php echo $data_depo['status']; ?>"><?php echo $data_depo['status']; ?></option>
                                            <option value="Success">Success</option>
                                            <option value="Pending">Pending</option>
                                            <option value="Error">Error</option>
                                            <?php
                                            }
                                            ?>
                                            </select>
                                        </td>
                                        <td align="text-center">
                                            <button data-toggle="tooltip" title="Ubah" type="submit" name="ubah" class="btn btn-sm btn-bordred btn-primary"><i class="fa fa-pencil-alt"></i></button>
                                            <button data-toggle="tooltip" title="Hapus" type="submit" name="hapus" class="btn btn-sm btn-bordred btn-danger"><i class="fa fa-trash"></i></button>
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
if (isset($_GET['cari'])) {
$cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
} else {
$cari_urut =  10;
}  
if (isset($_GET['cari'])) {
    $cari_oid = $conn->real_escape_string(filter($_GET['cari']));
    $cari_status = $conn->real_escape_string(filter($_GET['status']));
    $cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
} else {
    $self = $_SERVER['PHP_SELF'];
}
$cek_depo = $conn->query($cek_depo);
$total_records = mysqli_num_rows($cek_depo);
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
    if (isset($_GET['cari'])) {
    $cari_oid = $conn->real_escape_string(filter($_GET['cari']));
    $cari_status = $conn->real_escape_string(filter($_GET['status']));
    $cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
        echo "<li class='kt-pagination__link--first'><a href='".$self."?halaman=1&tampil=".$cari_urut."&status=".$cari_status."&cari=".$cari_oid."'><i class='fa fa-angle-double-left kt-font-brand'></i></a></li>";
        echo "<li class='kt-pagination__link--first'><a href='".$self."?halaman=".$previous."&tampil=".$cari_urut."&status=".$cari_status."&cari=".$cari_oid."'><i class='fa fa-angle-left kt-font-brand'></i></a></li>";
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
            echo "<li class='active page-item'><a class='page-link' href='#'>".$i."</a></li>";
        } else {
            echo "<li class='kt-pagination__link--first'><a href='".$self."?halaman=".$i."&tampil=".$cari_urut."&status=".$cari_status."&cari=".$cari_oid."'>".$i."</a></li>";
        }
    } else {
        if($i==$current_page) {
            echo "<li class='active page-item'><a class='page-link' href='#'>".$i."</a></li>";
        } else {
            echo "<li class='kt-pagination__link--first'><a href='".$self."?halaman=".$i."'>".$i."</a></li>";
        }        
    }
    }
    if($current_page!=$total_pages) {
        $next = $current_page+1;
    if (isset($_GET['cari'])) {
    $cari_oid = $conn->real_escape_string(filter($_GET['cari']));
    $cari_status = $conn->real_escape_string(filter($_GET['status']));
    $cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
        echo "<li class='kt-pagination__link--first'><a href='".$self."?halaman=".$next."&tampil=".$cari_urut."&status=".$cari_status."&cari=".$cari_oid."'><i class='fa fa-angle-right kt-font-brand'></i></a></li>";
        echo "<li class='kt-pagination__link--first'><a href='".$self."?halaman=".$total_pages."&tampil=".$cari_urut."&status=".$cari_status."&cari=".$cari_oid."'><i class='fa fa-angle-double-right kt-font-brand'></i></a></li>";
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
        <!-- End Page Data Deposit Balance -->

        <!-- Start Scrolltop -->
		<div id="kt_scrolltop" class="kt-scrolltop">
		    <i class="fa fa-arrow-up"></i>
		</div>
		<!-- End Scrolltop -->

<?php
require '../lib/footer_admin.php';
?>
	    <script type="text/javascript">
	    function copy_to_clipboard(element) {
	        var copyText = document.getElementById(element);
	        copyText.select();
	        document.execCommand("copy");
	    }
	    </script>