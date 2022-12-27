<?php
session_start();
require '../config.php';
require '../lib/session_user.php';
require '../lib/header.php';

    	if (isset($_POST['kode_deposit'])) {
    	    $post_kode = $conn->real_escape_string(trim(filter($_POST['kode_deposit'])));

    	    $cek_deposit = $conn->query("SELECT * FROM deposit WHERE kode_deposit = '$post_kode'");
    	    $data_deposit = mysqli_fetch_assoc($cek_deposit);

    	    if (mysqli_num_rows($cek_deposit) == 0) {
    	        $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Isi Saldomu Tidak Di Temukan.<script>swal("Ups Gagal!", "Isi Saldomu Tidak Di Temukan.", "error");</script>');
    	    } else if($data_deposit['status'] !== "Pending" AND $data_deposit['status'] !== "Processing") {
    	        $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Isi Saldomu Gak Bisa Dibatalkan.<script>swal("Ups Gagal!", "Isi Saldomu Gak Bisa Dibatalkan.", "error");</script>');
    	    } else {

    	    $update_deposit = $conn->query("UPDATE deposit set status = 'Error' WHERE kode_deposit = '$post_kode'");
    	    if($update_deposit == TRUE) {
    	        $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip! Isi Saldomu Berhasil Di Batalkan.<script>swal("Berhasil!", "Isi Saldomu Berhasil Di Batalkan.", "success");</script>');
    	    } else {
    			$_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.<script>swal("Ups Gagal!", "Sistem Kami Sedang Mengalami Gangguan.", "error");</script>');
	        }
	    }

        } else if (isset($_POST['confirm'])) {
    	    $post_kode = $conn->real_escape_string(trim(filter($_POST['confirm'])));

    	    $cek_deposit = $conn->query("SELECT * FROM deposit WHERE kode_deposit = '$post_kode' AND date = '$date'");
    	    $data_deposit = mysqli_fetch_assoc($cek_deposit);

    	    $post_jumlah = $data_deposit['jumlah_transfer'];
    	    $post_saldo = $data_deposit['get_saldo'];
    	    $post_tipe = $data_deposit['metode_isi_saldo'];

    	    $cek_mutasi = $conn->query("SELECT * FROM mutasi WHERE kode_deposit = '$post_kode' AND date = '$date'");
    	    $data_mutasi = mysqli_fetch_assoc($cek_mutasi);

    	    $post_status = $data_mutasi['status'];

    	    if (mysqli_num_rows($cek_deposit) == 0) {
    	        $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Isi Saldomu Tidak Di Temukan.<script>swal("Ups Gagal!", "Isi Saldomu Tidak Di Temukan.", "error");</script>');
    	    } else if (mysqli_num_rows($cek_mutasi) == 0) {
    	        $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Dana Kamu Tidak Ditemukan.<script>swal("Ups Gagal!", "Dana Kamu Tidak Ditemukan.", "error");</script>');
    	    } else if ($data_mutasi['status'] == "Dana Belum Masuk") {
    	        $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Dana Belum Kami Terima.<script>swal("Ups Gagal!", "Dana Belum Kami Terima.", "error");</script>');
    	    } else if ($data_deposit['status'] == "Success") {
    	        $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Invoice Sudah Sukses.<script>swal("Ups Gagal!", "Invoice Sudah Sukses.", "error");</script>');
    	    } else {

        	    $check_top = $conn->query("SELECT * FROM top_depo WHERE username = '$sess_username'");
        	    $data_top = mysqli_fetch_assoc($check_top);
        	    $update = $conn->query("UPDATE deposit set status = 'Success' WHERE kode_deposit = '$post_kode'");
        	    $update = $conn->query("UPDATE users SET $post_tipe = $post_tipe + $post_saldo, pemakaian_saldo = pemakaian_saldo + $post_saldo WHERE username = '$sess_username'");
        	    $update = $conn->query("UPDATE mutasi SET status_aksi = 'Sudah Dikonfirmasi' WHERE kode_deposit = '$post_kode'");
        	    $update = $conn->query("UPDATE mutasi_bca SET status = 'READ' WHERE jumlah = '$post_jumlah' AND provider = 'BCA'");
        	    $update = $conn->query("UPDATE mutasi_gopay SET status = 'READ' WHERE amount = '$post_jumlah' AND provider = 'GOPAY'");
        	    $update = $conn->query("UPDATE mutasi_ovo SET status = 'READ' WHERE amount = '$post_jumlah' AND provider = 'OVO'");
        	    if ($update == TRUE) {
            	    $insert = $conn->query("INSERT INTO riwayat_saldo_koin VALUES ('', '$sess_username', 'Saldo', 'Penambahan Saldo', '$post_saldo', 'Mendapatkan Saldo Melalui Isi Saldo Via ".$data_mutasi['tipe']." ".$data_mutasi['provider']." Dengan Kode Isi Saldo : $post_kode', '$date', '$time')");
            	    if($insert == TRUE) {
						if (mysqli_num_rows($check_top) == 0) {
							$insert_topup = $conn->query("INSERT INTO top_depo VALUES ('', 'Deposit', '$sess_username', '$post_saldo', '1')");
						} else {
							$insert_topup = $conn->query("INSERT top_depo SET jumlah = ".$data_top['jumlah']."+$post_saldo, total = ".$data_top['total']."+1 WHERE username = '$sess_username' AND method = 'Deposit'");
						}
            	        $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip! Saldo Kamu Berhasil Dikonfirmasi.<script>swal("Berhasil!", "Saldo Kamu Udah Masuk.", "success");</script>');
            	    } else {
            			$_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.<script>swal("Ups Gagal!", "Sistem Kami Sedang Mengalami Gangguan.", "error");</script>');
        	        }
        	    }
            }
        }

?>

        <!-- Start Sub Header -->
        <div class="kt-subheader kt-grid__item" id="kt_subheader">
	        <div class="kt-container">
	            <div class="kt-subheader__main">
		            <h3 class="kt-subheader__title">Riwayat Isi Saldo</h3>
	                <div class="kt-subheader__breadcrumbs">
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
	                	<span class="kt-subheader__breadcrumbs-separator"></span>
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-link">Halaman Utama</a>
	                	<span class="kt-subheader__breadcrumbs-separator"></span>
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-link">Riwayat Isi Saldo</a>
	                </div>
	            </div>
	        </div>
        </div>
        <!-- End Sub Header -->

        <!-- Start Content -->
        <div class="kt-container kt-grid__item kt-grid__item--fluid">

        <!-- Start Page History Top Up Balance -->
        <div class="row">
	        <div class="col-lg-12">
		        <div class="kt-portlet">
			        <div class="kt-portlet__head">
				        <div class="kt-portlet__head-label">
					        <h3 class="kt-portlet__head-title">
					            <i class="flaticon2-time text-primary"></i>
					            Riwayat Isi Saldo
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
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
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
                                <input type="number" class="form-control" name="cari" placeholder="Masukkan Kode Isi Saldo Kamu" value="">
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
                                    <th>Kode Isi Saldo</th>
                                    <th>Tanggal & Waktu</th>
                                    <th>Tipe Pembayaran</th>
                                    <th>Penerima</th>
                                    <th>Keterangan</th>
                                    <th>Jumlah Pembayaran</th>
                                    <th>Saldo Yang Di Dapatkan</th>
                                    <th>Status</th>
                                    <th>Detail</th>
                                </tr>
                            </thead>
                            <tbody>
<?php
// start paging config
$no = 1;
if (isset($_GET['cari'])) {
    $cari_id = $conn->real_escape_string(filter($_GET['cari']));
    $cari_status = $conn->real_escape_string(filter($_GET['status']));

    $cek_depo = "SELECT * FROM deposit WHERE kode_deposit LIKE '%$cari_id%' AND status LIKE '%$cari_status%' AND username = '$sess_username' ORDER BY id DESC"; // edit
} else {
    $cek_depo = "SELECT * FROM deposit WHERE username = '$sess_username' ORDER BY id DESC"; // edit
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
    if ($data_depo['status'] == "Pending") {
        $label = "warning";
    } else if ($data_depo['status'] == "Error") {
        $label = "danger";     
    } else if ($data_depo['status'] == "Success") {
        $label = "success";    
    }
?>
                                <tr>
                                    <td><button class="view_deposit btn btn-primary btn-elevate btn-pill btn-elevate-air btn-sm" data-toggle="modal" id="<?php echo $data_depo['id']; ?>" data-target='#myDetail'><?php echo $data_depo['kode_deposit']; ?></button></td>
                                    <td><?php echo tanggal_indo($data_depo['date']); ?>, <?php echo $data_depo['time']; ?></td>
                                    <td><?php echo $data_depo['provider']; ?></td>
                                    <td><?php echo $data_depo['penerima']; ?></td>
                                    <td><?php echo $data_depo['catatan']; ?></td>
                                    <td>Rp <?php echo number_format($data_depo['jumlah_transfer'],0,',','.'); ?></td>
                                    <td>Rp <?php echo number_format($data_depo['get_saldo'],0,',','.'); ?></td>
                                    <td><span class="btn btn-<?php echo $label; ?> btn-elevate btn-pill btn-elevate-air btn-sm"><?php echo $data_depo['status']; ?></span>
 								    <td align="center">
								        <a href="<?php echo $config['web']['url'] ?>deposit-balance/invoice?kode_deposit=<?php echo $data_depo['kode_deposit']; ?>" class="btn btn-primary btn-elevate btn-circle btn-icon"><i class="flaticon-eye"></i></a>
								    </td>
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
    $cari_id = $conn->real_escape_string(filter($_GET['cari']));
    $cari_status = $conn->real_escape_string(filter($_GET['status']));
    $cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
        echo "<li class='kt-pagination__link--first'><a href='".$self."?halaman=1&tampil=".$cari_urut."&status=".$cari_status."&cari=".$cari_id."'><i class='fa fa-angle-double-left kt-font-brand'></i></a></li>";
        echo "<li class='kt-pagination__link--first'><a href='".$self."?halaman=".$previous."&tampil=".$cari_urut."&status=".$cari_status."&cari=".$cari_id."'><i class='fa fa-angle-left kt-font-brand'></i></a></li>";
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
    $cari_id = $conn->real_escape_string(filter($_GET['cari']));
    $cari_status = $conn->real_escape_string(filter($_GET['status']));
    $cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
        if($i==$current_page) {
            echo "<li class='kt-pagination__link--active'><a href='#'>".$i."</a></li>";
        } else {
            echo "<li class='kt-pagination__link--first'><a href='".$self."?halaman=".$i."&tampil=".$cari_urut."&status=".$cari_status."&cari=".$cari_id."'>".$i."</a></li>";
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
    if (isset($_GET['cari'])) {
    $cari_id = $conn->real_escape_string(filter($_GET['cari']));
    $cari_status = $conn->real_escape_string(filter($_GET['status']));
    $cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
        echo "<li class='kt-pagination__link--first'><a href='".$self."?halaman=".$next."&tampil=".$cari_urut."&status=".$cari_status."&cari=".$cari_id."'><i class='fa fa-angle-right kt-font-brand'></i></a></li>";
        echo "<li class='kt-pagination__link--first'><a href='".$self."?halaman=".$total_pages."&tampil=".$cari_urut."&status=".$cari_status."&cari=".$cari_id."'><i class='fa fa-angle-double-right kt-font-brand'></i></a></li>";
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
        <!-- End Page History Top Up Balance -->

        </div>
        <!-- End Content -->

        <!-- Start Scrolltop -->
		<div id="kt_scrolltop" class="kt-scrolltop">
		    <i class="fa fa-arrow-up"></i>
		</div>
		<!-- End Scrolltop -->

        <!-- Start Modal History Top Up Balance -->
        <div class="modal fade" id="myDetail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		    <div class="modal-dialog" role="document">
			    <div class="modal-content">
				    <div class="modal-header">
                    <h4 class="modal-title mt-0" id="myModalLabel"><i class="flaticon-eye text-primary"></i> Detail Isi Saldo</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
				    </div>
				    <div class="modal-body" id="data_deposit">
				    </div>
				    <div class="modal-footer">
					    <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
				    </div>
			    </div>
		    </div>
	    </div>
	    <!-- End Modal History Top Up Balance -->

<?php
require '../lib/footer.php';
?>

	    <script type="text/javascript">
	        $(document).ready(function(){
		        $('.view_deposit').click(function(){
		        	var id = $(this).attr("id");
			        $.ajax({
				        url: '<?php echo $config['web']['url']; ?>history/ajax/detail-deposit.php',
				        method: 'post',		
				        data: {id:id},	
				        success:function(data){	
					        $('#data_deposit').html(data);
					        $('#myDetail').modal("show");
				        }
			        });
		        });
	        });
	    </script>