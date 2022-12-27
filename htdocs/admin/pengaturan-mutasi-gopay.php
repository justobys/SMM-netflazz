<?php
session_start();
require '../config.php';
require '../lib/session_login_admin.php';
require '../lib/gopay-class.php';
        
        $data_gopay = mysqli_query($conn, "SELECT * FROM gopay WHERE id = 'S1'")->fetch_assoc();
        $gopay = (!$data_gopay['nomor']) ? '' : new GoPay();

        if(isset($_POST['nomorlog'])) {
            $post_nomor = $conn->real_escape_string(trim($_POST['nomor']));
            $accept = $gopay->sendRequest($post_nomor);
            
            if($accept == TRUE) {
                $conn->query("UPDATE gopay SET device = '$accept', nomor = '$post_nomor' WHERE id = 'S1'");
                $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip, SMS Verifikasi Berhasil Dikirim..');
            } else {
                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan');
            }
            } if(isset($_POST['smslog'])) {
            $post_sms = $conn->real_escape_string(trim($_POST['sms']));
            $accept = $gopay->konfirmasiCode($data_gopay['device'],$post_sms,$data_gopay['nomor']);
            if($accept == true) {
                $conn->query("UPDATE gopay SET kode = '$post_sms', token = '$accept' WHERE id = 'S1'");
                $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip, Autentikasi Berhasil.');
            } else {
                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan');
            }
            } if(isset($_POST['reset'])) {
            $accept = $conn->query("UPDATE gopay SET nomor = '', device = '', kode = '', pin = '', token = '' WHERE id = 'S1'");
            if($accept == true) {
                $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip, Data Berhasil Di Reset.');
            } else {
                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan');
            }
            } if(isset($_POST['cek'])) {
            $acc = json_decode($gopay->seeMutation($data_gopay['token']), true);
            if($acc['success'] == true) {
                $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip, Tidak Ada Data Yang Error Terdeteksi.');
            } else {
                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => $acc['data']);
            }
      }

        require '../lib/header_admin.php';

?>

        <!-- Start Sub Header -->
        <div class="kt-subheader kt-grid__item" id="kt_subheader">
	        <div class="kt-container ">
	            <div class="kt-subheader__main">
                    <h3 class="kt-subheader__title">Pengaturan Mutasi GOPAY</h3>
                    <span class="kt-subheader__separator kt-hidden"></span>
                    <div class="kt-subheader__breadcrumbs">
                        <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                        <span class="kt-subheader__breadcrumbs-separator"></span>
                        <a href="#" class="kt-subheader__breadcrumbs-link">Halaman Admin</a>
                        <span class="kt-subheader__breadcrumbs-separator"></span>
                        <a href="#" class="kt-subheader__breadcrumbs-link">Pengaturan Mutasi GOPAY</a>
	                </div>
	            </div>
	        </div>
        </div>
        <!-- End Sub Header -->

        <!-- Start Content -->
        <div class="kt-container kt-grid__item kt-grid__item--fluid">

        <!-- Start Page Data Pengaturan Mutation GOPAY -->
        <div class="row">
	        <div class="offset-lg-2 col-lg-8">
		        <div class="kt-portlet">
			        <div class="kt-portlet__head">
				        <div class="kt-portlet__head-label">
					        <h3 class="kt-portlet__head-title">
					            <i class="fa fa-credit-card text-primary"></i>
					            Pengaturan Mutasi GOPAY
					        </h3>
				        </div>
			        </div>
			        <div class="kt-portlet__body">
                    <?php if (isset($_SESSION['hasil'])) {
                    if($_SESSION['hasil']['alert'] == 'success') {
                    ?>
                    <div class="alert alert-<?php echo $_SESSION['hasil']['alert'] ?> alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <div id="respon"></div>
                    </div>
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
                    <script>
                        var url = "<?php echo $config['web']['url'] ?>admin/pengaturan-mutasi-gopay"; // URL Tujuan
                        var count = 2; // dalam detik
                        function countDown() {
                            if (count > 0) {
                                count--;
                                var waktu = count + 1;
                                $('#respon').html('<?php echo $_SESSION['hasil']['pesan'] ?> Halaman Akan Refresh Otomatis Dalam ' + waktu + ' Detik.');
                                setTimeout("countDown()", 1000);
                            } else {
                                window.location.href = url;
                            }
                        }
                        countDown();
                    </script>
                    <?php } else { ?>
                    <div class="alert alert-<?php echo $_SESSION['hasil']['alert'] ?> alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <?php echo $_SESSION['hasil']['pesan'] ?>
                    </div>
                    <?php } unset($_SESSION['hasil']); } ?>
                    <form class="form-horizontal" method="POST">
                        <input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
                        <div class="row">
                            <div class="form-group col-8">
                                <label>Nomor GOPAY</label>
                                <input type="number" class="form-control" name="nomor" value="<?= $data_gopay['nomor'] ?>">
                            </div>
                            <div class="form-group col-4">
                                <label>&nbsp;</label>
                                <button type="submit" name="nomorlog" class="btn btn-outline-brand form-control">Login</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-8">
                                <label>Verifikasi SMS</label>
                                <input type="number" class="form-control" name="sms" value="<?= $data_gopay['kode'] ?>">
                            </div>
                            <div class="form-group col-4">
                                <label>&nbsp;</label>
                                <button type="submit" name="smslog" class="btn btn-outline-brand form-control">Verifikasi</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <button type="submit" name="reset" class="btn btn-danger form-control">Reset</button>
                            </div>
                            <div class="form-group col-6">
                                <button type="submit" name="cek" class="btn btn-primary form-control">Cek</button>
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
					            <i class="fa fa-list text-primary"></i>
					            Daftar Mutasi GOPAY
					        </h3>
				        </div>
			        </div>
			        <div class="kt-portlet__body">
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
                                    <option value="10">10</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                    <option value="250">250</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-4">
                                <label>Cari Deskripsi</label>
                                <input type="text" class="form-control" name="search" placeholder="Cari Deskripsi" value="">
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
                                    <th>Invoice</th>
                                    <th>Saldo</th>
                                    <th>Deskripsi</th>
                                </tr>
                            </thead>
                            <tbody>
<?php 
// start paging config
if (isset($_GET['search'])) {
    $search = $conn->real_escape_string(filter($_GET['search']));

    $cek_layanan = "SELECT * FROM mutasi_gopay WHERE descript LIKE '%$search%' ORDER BY id DESC"; // edit
} else {
    $cek_layanan = "SELECT * FROM mutasi_gopay ORDER BY id DESC"; // edit
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
$new_query = $cek_layanan." LIMIT $starting_position, $records_per_page";
$new_query = $conn->query($new_query);
$no = $starting_position+1;
// end paging config
while ($data_layanan = $new_query->fetch_assoc()) {
?>
                                <tr> 
                                    <th><span class="badge badge-dark"><?php echo $no++ ?></th>
                                    <td><?php echo $data_layanan['datetime']; ?></td>
                                    <td><?php echo $data_layanan['invoice']; ?></td>
                                    
                                    <td><span class="badge badge-success">Rp <?php echo number_format($data_layanan['amount'],0,',','.'); ?></td>
                                    <td><?php echo $data_layanan['descript']; ?></td>
                                    
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
$cek_layanan = $conn->query($cek_layanan);
$total_records = mysqli_num_rows($cek_layanan);
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
    if (isset($_GET['cari'])) {
    $cari_oid = $conn->real_escape_string(filter($_GET['cari']));
    $cari_status = $conn->real_escape_string(filter($_GET['status']));
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
        <!-- End Page Data Pengaturan Mutation GOPAY -->

        </div>
        <!-- End Content -->

        <!-- Start Scrolltop -->
		<div id="kt_scrolltop" class="kt-scrolltop">
		    <i class="fa fa-arrow-up"></i>
		</div>
		<!-- End Scrolltop -->

<?php
require '../lib/footer_admin.php';
?>