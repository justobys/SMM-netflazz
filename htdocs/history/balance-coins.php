<?php
session_start();
require '../config.php';
require '../lib/session_user.php';
require '../lib/header.php';
?>

        <!-- Start Sub Header -->
        <div class="kt-subheader kt-grid__item" id="kt_subheader">
	        <div class="kt-container">
	            <div class="kt-subheader__main">
		            <h3 class="kt-subheader__title">Riwayat Pemakaian Saldo</h3>
	                <div class="kt-subheader__breadcrumbs">
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
	                	<span class="kt-subheader__breadcrumbs-separator"></span>
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-link">Halaman Utama</a>
	                	<span class="kt-subheader__breadcrumbs-separator"></span>
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-link">Riwayat Pemakaian Saldo</a>
	                </div>
	            </div>
	        </div>
        </div>
        <!-- End Sub Header -->

        <!-- Start Content -->
        <div class="kt-container kt-grid__item kt-grid__item--fluid">

        <!-- Start Page History Balance Usage -->
        <div class="row">
	        <div class="col-lg-12">
		        <div class="kt-portlet">
			        <div class="kt-portlet__head">
				        <div class="kt-portlet__head-label">
					        <h3 class="kt-portlet__head-title">
					            <i class="flaticon2-time text-primary"></i>
					            Riwayat Pemakaian Saldo
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
                                        <option value="20">10</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                </div>                                                
                                <div class="form-group col-lg-4">
                                    <label>Filter Tipe</label>
                                    <select class="form-control" name="tipe">
                                        <option value="">Semua</option>
                                        <option value="Penambahan Saldo">Penambahan Saldo</option>
                                        <option value="Pengurangan Saldo">Pengurangan Saldo</option>
                                        <option value="Penambahan Koin">Penambahan Koin</option>
                                        <option value="Pengurangan Koin">Pengurangan Koin</option>
                                    </select>
                                </div>                                                
                                <div class="form-group col-lg-4">
                                    <label>Submit</label>
                                    <button type="submit" class="btn btn-block btn-primary">Cari</button>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal & Waktu</th>
                                    <th>Jumlah</th>
                                    <th>Keterangan</th>
                                </tr>
                                </thead>
                                <tbody>
<?php 
// start paging config
if (isset($_GET['tipe'])) {
    $cari_tipe = $conn->real_escape_string(filter($_GET['tipe']));

    $cek_data = "SELECT * FROM riwayat_saldo_koin WHERE aksi LIKE '%$cari_tipe%' AND username = '$sess_username' ORDER BY id DESC"; // edit
} else {
    $cek_data = "SELECT * FROM riwayat_saldo_koin WHERE username = '$sess_username' ORDER BY id DESC"; // edit
}
if (isset($_GET['tipe'])) {
$cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
$records_per_page = $cari_urut; // edit
} else {
    $records_per_page = 10; // edit
}

$starting_position = 0;
if(isset($_GET["halaman"])) {
    $starting_position = ($conn->real_escape_string(filter($_GET["halaman"]))-1) * $records_per_page;
}
$new_query = $cek_data." LIMIT $starting_position, $records_per_page";
$new_query = $conn->query($new_query);
$no = $starting_position+1;
// end paging config
while ($view_data = $new_query->fetch_assoc()) {
    if ($view_data['tipe'] == "Saldo") {
        $label = "success";
        $icon = "la la-credit-card";
    } else if ($view_data['tipe'] == "Koin") {
        $label = "primary";
        $icon = "flaticon-coins";
    }
    if ($view_data['aksi'] == "Penambahan Saldo") {
        $label = "primary";
    } else if ($view_data['aksi'] == "Pengurangan Saldo") {
        $label = "danger";
    }
    if ($view_data['aksi'] == "Penambahan Koin") {
        $label = "primary";
    } else if ($view_data['aksi'] == "Pengurangan Koin") {
        $label = "danger";
    }
?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo tanggal_indo($view_data['date']); ?>, <?php echo $view_data['time']; ?></td>
                                    <td width="20%"><span class="btn btn-<?php echo $label; ?> btn-elevate btn-pill btn-elevate-air btn-sm">Rp. <?php echo number_format($view_data['nominal'],0,',','.'); ?></span></td>
                                    <td><?php echo $view_data['pesan']; ?></td>
                                </tr>   
<?php } ?>
                                </tbody>
                            </table>
                            <br>
                            <div class="kt-pagination kt-pagination--brand kt-pagination--circle">
                                <ul class="kt-pagination__links">
<?php
// start paging link
if (isset($_GET['tipe'])) {
$cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
} else {
$cari_urut =  10;
}  
if (isset($_GET['tipe'])) {
    $cari_tipe = $conn->real_escape_string(filter($_GET['tipe']));
    $cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
    $self = $_SERVER['PHP_SELF'];
} else {
    $self = $_SERVER['PHP_SELF'];
}
$cek_data = $conn->query($cek_data);
$total_records = mysqli_num_rows($cek_data);
echo "<li class='disabled page-item'><a href='#'>Total Data : ".$total_records."</a></li>";
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
    if (isset($_GET['tipe'])) {
    $cari_tipe = $conn->real_escape_string(filter($_GET['tipe']));
    $cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
        echo "<li class='kt-pagination__link--first'><a href='".$self."?halaman=1&tampil=".$cari_urut."&tipe=".$cari_tipe."'><i class='fa fa-angle-double-left kt-font-brand'></i></a></li>";
        echo "<li class='kt-pagination__link--first'><a href='".$self."?halaman=".$previous."&tampil=".$cari_urut."&tipe=".$cari_tipe."'><i class='fa fa-angle-left kt-font-brand'></i></a></li>";
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
    if (isset($_GET['tipe'])) {
    $cari_tipe = $conn->real_escape_string(filter($_GET['tipe']));
    $cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
        if($i==$current_page) {
            echo "<li class='kt-pagination__link--active'><a href='#'>".$i."</a></li>";
        } else {
            echo "<li class='kt-pagination__link--first'><a href='".$self."?halaman=".$i."&tampil=".$cari_urut."&tipe=".$cari_tipe."'>".$i."</a></li>";
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
    if (isset($_GET['tipe'])) {
    $cari_tipe = $conn->real_escape_string(filter($_GET['tipe']));
    $cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
        echo "<li class='kt-pagination__link--first'><a href='".$self."?halaman=".$next."&tampil=".$cari_urut."&tipe=".$cari_tipe."'><i class='fa fa-angle-right kt-font-brand'></i></a></li>";
        echo "<li class='kt-pagination__link--first'><a href='".$self."?halaman=".$total_pages."&tampil=".$cari_urut."&tipe=".$cari_tipe."'><i class='fa fa-angle-double-right kt-font-brand'></i></a></li>";
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
        <!-- End Page History Balance Usage -->

        </div>
        <!-- End Content -->
<?php
require '../lib/footer.php';
?>