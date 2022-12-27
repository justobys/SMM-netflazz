<?php
session_start();
require '../config.php';
require '../lib/session_login_admin.php';

        if (isset($_POST['ubah'])) {
            $get_oid = $conn->real_escape_string($_GET['order_id']);
            $status = $conn->real_escape_string($_POST['status']);
            $keterangan = $conn->real_escape_string($_POST['keterangan']);

            $cek_orders = $conn->query("SELECT * FROM pembelian_pascabayar WHERE oid = '$get_oid'");
            $data_orders = $cek_orders->fetch_array(MYSQLI_ASSOC);

            $username = $data_orders['user'];
            $koin = $data_orders['koin'];
            $layanan = $data_orders['layanan'];

            if ($cek_orders->num_rows == 0) {
                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Data Pesanan Tidak Ditemukan.');
            } else {

                if ($conn->query("UPDATE pembelian_pascabayar SET status = '$status', keterangan = '$keterangan'  WHERE oid = '$get_oid'") == true) {
                    if ($status == "Success") {
                        $update = $conn->query("INSERT INTO history_saldo VALUES ('', '$username', 'Koin', 'Penambahan Koin', '$koin', 'Mendapatkan Koin Melalui Pemesanan $layanan Dengan Kode Pesanan : WEB-$get_oid', '$date', '$time')");
                        $update = $conn->query("UPDATE users SET koin = koin+$koin WHERE username = '$username'");
                    }
                    $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip, Data Pesanan Berhasil Di Ubah.');
                } else {
                    $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.<script>swal("Ups Gagal!", "Sistem Kami Sedang Mengalami Gangguan.", "error");</script>');
                }
            }

        } else if (isset($_POST['hapus'])) {
            $get_oid = $conn->real_escape_string($_GET['order_id']);

            $cek_orders = $conn->query("SELECT * FROM pembelian_pascabayar WHERE oid = '$get_oid'");

            if ($cek_orders->num_rows == 0) {
                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Data Pesanan Tidak Ditemukan.');
            } else {

                if ($conn->query("DELETE FROM pembelian_pascabayar WHERE oid = '$get_oid'") == true){
                    $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip, Data Pesanan Berhasil Di Hapus.');
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
                    <h3 class="kt-subheader__title">Daftar Pesanan</h3>
                    <span class="kt-subheader__separator kt-hidden"></span>
                    <div class="kt-subheader__breadcrumbs">
                        <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                        <span class="kt-subheader__breadcrumbs-separator"></span>
                        <a href="#" class="kt-subheader__breadcrumbs-link">Halaman Admin</a>
                        <span class="kt-subheader__breadcrumbs-separator"></span>
                        <a href="#" class="kt-subheader__breadcrumbs-link">Daftar Pesanan</a>
	                </div>
	            </div>
	        </div>
        </div>
        <!-- End Sub Header -->

        <!-- Start Content -->
        <div class="kt-container kt-grid__item kt-grid__item--fluid">

        <!-- Start Page Data Orders Pascabayar -->
        <div class="row">
            <div class="col-md-12">
                <div class="kt-portlet">
                    <a href="<?php echo $config['web']['url'] ?>admin/daftar-pesanan-pascabayar" class="kt-iconbox btn btn-danger">
                        <div class="kt-portlet__body">
                            <div class="kt-iconbox__body">
                                <div class="kt-iconbox__icon">
 				                    <img src="<?php echo $config['web']['url'] ?>assets/media/icon/bill.svg" width="60px">
                                </div>
                                <div class="kt-iconbox__desc text-left">
                                    <h4 class="kt-iconbox__title">
								        <font color="white">Rp <?php echo number_format($data_pesanan_pascabayar['total'],0,',','.'); ?> (Dari <?php echo $count_pesanan_pascabayar; ?> Pesanan)</font>
							        </h4>
                                    <div class="kt-iconbox__content">
                                        <font color="white">Total Pemesanan Pascabayar Pengguna</font>
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
					            <i class="flaticon2-shopping-cart text-primary"></i>
					            Daftar Pesanan Pascabayar
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
                                <label>Cari Kode Pesanan</label>
                                <input type="number" class="form-control" name="cari" placeholder="Cari Kode Pesanan" value="">
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
                                    <th>Kode Pesanan</th>
                                    <th>Kode Provider</th>
                                    <th>ID Layanan</th>
                                    <th>Nama Pengguna</th>
                                    <th>Nama Layanan</th>
                                    <th>Nomor Pelanggan</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Keterangan</th>
                                    <th>Harga</th>
                                    <th>Koin Didapat</th>
                                    <th>Status</th>
                                    <th>API</th>
                                    <th>Provider</th>
                                    <th>Pengembalian Dana</th>
                                    <th width="100%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
<?php 
// start paging config
if (isset($_GET['cari'])) {
    $cari_oid = $conn->real_escape_string(filter($_GET['cari']));
    $cari_status = $conn->real_escape_string(filter($_GET['status']));

    $cek_pesanan = "SELECT * FROM pembelian_pascabayar WHERE oid LIKE '%$cari_oid%' AND status LIKE '%$cari_status%' ORDER BY id DESC"; // edit
} else {
    $cek_pesanan = "SELECT * FROM pembelian_pascabayar ORDER BY id DESC"; // edit
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
$new_query = $cek_pesanan." LIMIT $starting_position, $records_per_page";
$new_query = $conn->query($new_query);
// end paging config
while ($data_pesanan = $new_query->fetch_assoc()) {
?>
                                <tr>
                                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>?order_id=<?php echo $data_pesanan['oid']; ?>" class="form-inline" role="form" method="POST"> 
                                    <input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
                                    <td><?php echo tanggal_indo($data_pesanan['date']); ?>, <?php echo $data_pesanan['time']; ?></td>
                                    <td width="5%"><span class="badge badge-primary"><?php echo $data_pesanan['oid']; ?></span></td>
                                    <td width="5%"><span class="badge badge-success"><?php echo $data_pesanan['provider_oid']; ?></span></td>
                                    <td width="5%"><span class="badge badge-dark"><?php echo $data_pesanan['id_layanan']; ?></span></td>
                                    <td width="5%"><span class="badge badge-warning"><?php echo $data_pesanan['user']; ?></span></td>
                                    <td><?php echo $data_pesanan['layanan']; ?></td>
                                    <td style="min-width: 200px;">
                                        <div class="input-group">
                                        <input type="text" class="form-control form-control-sm" value="<?php echo $data_pesanan['target']; ?>" id="target-<?php echo $data_pesanan['oid']; ?>" readonly="">
                                        <button data-toggle="tooltip" title="Copy Nomor Pelanggan" class="btn btn-primary" type="button" onclick="copy_to_clipboard('target-<?php echo $data_pesanan['oid']; ?>')"><i class="fas fa-copy text-warning"></i></button>
                                        </div>
                                    </td>
                                    <td style="min-width: 200px;">
                                        <div class="input-group">
                                        <input type="text" class="form-control form-control-sm" value="<?php echo $data_pesanan['nama_penerima']; ?>" id="nama_penerima-<?php echo $data_pesanan['oid']; ?>" readonly="">
                                        <button data-toggle="tooltip" title="Copy Nama Pelanggan" class="btn btn-primary" type="button" onclick="copy_to_clipboard('nama_penerima-<?php echo $data_pesanan['oid']; ?>')"><i class="fas fa-copy text-warning"></i></button>
                                        </div>
                                    </td>
                                    <td style="min-width: 200px;">
                                        <div class="input-group">
                                        <input type="text" class="form-control form-control-sm" name="keterangan" value="<?php echo $data_pesanan['keterangan']; ?>" id="keterangan-<?php echo $data_pesanan['oid']; ?>">
                                        <button data-toggle="tooltip" title="Copy Keterangan" class="btn btn-primary" type="button" onclick="copy_to_clipboard('keterangan-<?php echo $data_pesanan['oid']; ?>')"><i class="fas fa-copy text-warning"></i></button>
                                        </div>
                                    </td>
                                    <td width="5%"><span class="badge badge-danger">Rp <?php echo number_format($data_pesanan['harga'],0,',','.'); ?></span></td>
                                    <td width="5%"><span class="badge badge-dark"><?php echo number_format($data_pesanan['koin'],0,',','.'); ?></span></td>
                                    <td>
                                        <select class="form-control" style="width: 100px;" name="status">
                                            <option value="<?php echo $data_pesanan['status']; ?>"><?php echo $data_pesanan['status']; ?></option>
                                            <option value="Pending">Pending</option>
                                            <option value="Success">Success</option>
                                            <option value="Error">Error</option>
                                        </select>
                                    </td>                                        
                                    <td><?php if($data_pesanan['place_from'] == "API") { ?><span class="badge badge-success"><i class="fa fa-check"></i></span><?php } else { ?><span class="badge badge-danger"><i class="fa fa-times"></i></span><?php } ?></td>
                                    <td width="5%"><span class="badge badge-info"><?php echo $data_pesanan['provider']; ?></span></td>
                                    <td><?php if($data_pesanan['refund'] == "1") { ?><span class="badge badge-success"><i class="fa fa-check"></i></span><?php } else { ?><span class="badge badge-danger"><i class="fa fa-times"></i></span><?php } ?></td>
                                    <td align="text-center">
                                        <button data-toggle="tooltip" title="Ubah" type="submit" name="ubah" class="btn btn-sm btn-bordred btn-primary"><i class="fa fa-edit"></i></button>
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
$cek_pesanan = $conn->query($cek_pesanan);
$total_records = mysqli_num_rows($cek_pesanan);
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
            echo "<li class='kt-pagination__link--active'><a href='#'>".$i."</a></li>";
        } else {
            echo "<li class='kt-pagination__link--first'><a href='".$self."?halaman=".$i."&tampil=".$cari_urut."&status=".$cari_status."&cari=".$cari_oid."'>".$i."</a></li>";
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
<br />
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Data Orders Pascabayar -->

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