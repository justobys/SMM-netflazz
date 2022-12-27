<?php
session_start();
require '../config.php';
require '../lib/session_user.php';
require '../lib/header.php';

		$cek_kode = $conn->query("SELECT * FROM kode_referral WHERE username = '$sess_username'");
		$data_kode = mysqli_fetch_assoc($cek_kode);

		$cek_referral = $conn->query("SELECT * FROM setting_referral WHERE status = 'Aktif'");
		$data_referral = mysqli_fetch_assoc($cek_referral);

?>

        <!-- Start Sub Header -->
        <div class="kt-subheader kt-grid__item" id="kt_subheader">
	        <div class="kt-container">
	            <div class="kt-subheader__main">
		            <h3 class="kt-subheader__title">Program Referral</h3>
	                <div class="kt-subheader__breadcrumbs">
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
	                	<span class="kt-subheader__breadcrumbs-separator"></span>
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-link">Halaman Utama</a>
	                	<span class="kt-subheader__breadcrumbs-separator"></span>
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-link">Program Referral</a>
	                </div>
	            </div>
	        </div>
        </div>
        <!-- End Sub Header -->

        <!-- Start Content -->
        <div class="kt-container kt-grid__item kt-grid__item--fluid">

        <!-- Start Page Program Referral -->
        <div class="row">
	        <div class="col-lg-5">
		        <div class="kt-portlet">
			        <div class="kt-portlet__head">
				        <div class="kt-portlet__head-label">
					        <h3 class="kt-portlet__head-title">
					            <i class="fa fa-gift text-primary"></i>
					            Program Referral
					        </h3>
				        </div>
			        </div>
			        <div class="kt-portlet__body">
						<div class="form-group row">
							<label class="col-lg-10 control-label">Kode Referral Kamu</label>
							<div class="col-lg-12">
								<input type="text" class="form-control" placeholder="0" value="<?php echo $data_user['kode_referral']; ?>" readonly>
							</div>
						</div>
                    </div>
                </div>
            </div>
	        <div class="col-lg-7">
		        <div class="kt-portlet">
			        <div class="kt-portlet__head">
				        <div class="kt-portlet__head-label">
					        <h3 class="kt-portlet__head-title">
					            <i class="flaticon-alert text-primary"></i>
					            Informasi
					        </h3>
				        </div>
			        </div>
			        <div class="kt-portlet__body">
						<ul>
							<li>Beritahu Dan Ajak Teman, Keluarga, Sanak Saudara, Orang Spesial Atau Siapapun Untuk Ikut Bergabung Di <?php echo $data['short_title']; ?> Melalui Kode Referral Kamu Saat Mendaftarkan Akun.</li>
							<li>Setelah Orang Yang Kamu Ajak Mendaftar Melalui Kode Referral Kamu, Maka Kamu Akan Mendapatkan <?php echo number_format($data_referral['jumlah'],0,',','.'); ?> Koin.</li>
							<li>Contoh Kamu Berhasil Mengajak Teman Dengan Memasukan Kode Referral Kamu Saat Mendaftar Akun, Kemudian Teman Kamu Telah Melakukan Verifikasi Akun, Maka Kamu Akan Mendapatakan <?php echo number_format($data_referral['jumlah'],0,',','.'); ?> Koin Gratis Otomatis Langsung Masuk.</li>
						    <li>Koin Yang Kamu Dapatkan Bisa Di Tarik Ke Saldo.</li>
						    <li>Tanpa Syarat Terbuka Untuk Semua Member <?php echo $data['short_title']; ?>. Yuk Mulai Kumpulkan Bonusnya Dari Sekarang!</li>
						    <li>Status Program Referral <?php echo $data['short_title']; ?> Saat Ini <span class="badge badge-primary"><?php echo $data_referral['status']; ?></span></li>
						    <li>Jika Butuh Bantuan Silahkan Hubungi Kontak Kami.</li>
						</ul>
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
					            <i class="flaticon2-time text-primary"></i>
					            Daftar Pengguna Yang Menggunakan Kode Referral Kamu
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
                                <label>Cari Nama Pengguna</label>
                                <input type="text" class="form-control" name="aksi" placeholder="Cari Nama Pengguna">
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
								    <th>Nama Pengguna</th>
								    <th>Jumlah Bonus</th>
							    </tr>
							</thead>
							<tbody>
<?php 
// start paging config
$no=1;
if (isset($_GET['tampil'])) {
    $cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
    $cari_aksi = $conn->real_escape_string(filter($_GET['aksi']));

    $cek_riwayat = "SELECT * FROM riwayat_referral WHERE username LIKE '%$cari_aksi%' AND uplink = '$sess_username' ORDER BY id DESC"; // edit
} else {
    $cek_riwayat = "SELECT * FROM riwayat_referral WHERE uplink = '$sess_username' ORDER BY id DESC"; // edit
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
								    <td><span class="badge badge-primary"><?php echo $data_riwayat['username']; ?></span></td>
								    <td><span class="badge badge-warning"><?php echo number_format($data_riwayat['jumlah'],0,',','.'); ?> Koin</span></td>
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
        <!-- End Page Program Referral -->

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