<?php
session_start();
require '../config.php';
require '../lib/session_login_admin.php';

        if (isset($_POST['tambah'])) {
            $number = $conn->real_escape_string(filter($_POST['number']));
            $tipe = $conn->real_escape_string(filter($_POST['tipe']));
            $title = $conn->real_escape_string(trim($_POST['title']));
            $konten = $conn->real_escape_string(trim($_POST['konten']));

            if (!$number || !$tipe || !$title || !$konten) {
                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Mohon Mengisi Semua Input.');
            } else {

                $insert = $conn->query("INSERT INTO pertanyaan_umum VALUES ('', '$number', '$tipe', '$title', '$konten')");
                if ($insert == TRUE) {
                    $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip, Berhasil Menambahkan Pertanyaan Umum Baru.');
                } else {
                    $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.<script>swal("Ups Gagal!", "Sistem Kami Sedang Mengalami Gangguan.", "error");</script>');
                }
            }

        } else if (isset($_POST['ubah'])) {
            $post_id = $conn->real_escape_string($_POST['id']);
            $number = $conn->real_escape_string(filter($_POST['number']));
            $tipe = $conn->real_escape_string(filter($_POST['tipe']));
            $title = $conn->real_escape_string(trim($_POST['title']));
            $konten = $conn->real_escape_string(trim($_POST['konten']));

            $cek_data = $conn->query("SELECT * FROM pertanyaan_umum WHERE id = '$post_id'");   

            if ($cek_data->num_rows == 0) {
                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Data Tidak Di Temukan.');                                   
            } else {

                $update = $conn->query("UPDATE pertanyaan_umum SET number = '$number', tipe = '$tipe', title = '$title', konten = '$konten' WHERE id = '$post_id'");
                if ($update == TRUE) {
                    $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip, Pertanyaan Umum Berhasil Di Ubah.');
                } else {
                    $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.<script>swal("Ups Gagal!", "Sistem Kami Sedang Mengalami Gangguan.", "error");</script>');
                }
            }

        } else if (isset($_POST['hapus'])) {
            $post_id = $conn->real_escape_string($_POST['id']);

            $cek_data = $conn->query("SELECT * FROM pertanyaan_umum WHERE id = '$post_id'");

            if ($cek_data->num_rows == 0) {
                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Data Tidak Di Temukan.');
            } else {

                $delete = $conn->query("DELETE FROM pertanyaan_umum WHERE id = '$post_id'");
                if ($delete == TRUE) {
                    $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip, Pertanyaan Umum Berhasil Di Hapus.');
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
                    <h3 class="kt-subheader__title">Daftar Pertanyaan Umum</h3>
                    <span class="kt-subheader__separator kt-hidden"></span>
                    <div class="kt-subheader__breadcrumbs">
                        <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                        <span class="kt-subheader__breadcrumbs-separator"></span>
                        <a href="#" class="kt-subheader__breadcrumbs-link">Halaman Admin</a>
                        <span class="kt-subheader__breadcrumbs-separator"></span>
                        <a href="#" class="kt-subheader__breadcrumbs-link">Daftar Pertanyaan Umum</a>
	                </div>
	            </div>
	        </div>
        </div>
        <!-- End Sub Header -->

        <!-- Start Content -->
        <div class="kt-container kt-grid__item kt-grid__item--fluid">

        <!-- Start Page Data FAQ -->
        <div class="row">
            <div class="col-md-12">
                <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title m-t-0 id="myModalLabel""><i class="fa fa-reply text-primary"></i> Tambah Pertanyaan Umum</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal" role="form" method="POST">
                                    <input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
                                    <div class="form-group row">
                                        <label class="col-md-12 control-label">Number</label>
                                        <div class="col-md-12">
                                            <input type="text" name="number" class="form-control" placeholder="Contoh : One, Two, Three, Four, Five">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-12 control-label">Tipe</label>
                                        <div class="col-md-12">
                                            <select class="form-control" name="tipe">
                                                <option value="">Pilih Salah Satu</option>
                                                <option value="Akun">Akun</option>
                                                <option value="Pesanan">Pesanan</option>
                                                <option value="Sosial Media">Sosial Media</option>
                                                <option value="Top Up">Top Up</option>
                                                <option value="Isi Saldo">Isi Saldo</option>
                                                <option value="Koin">Koin</option>
                                                <option value="Voucher">Voucher</option>
                                                <option value="Pengembalian Dana">Pengembalian Dana</option>
                                                <option value="Status">Status</option>
                                                <option value="API Dokumentasi">API Dokumentasi</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-12 control-label">Title</label>
                                        <div class="col-md-12">
                                            <input type="text" name="title" class="form-control" placeholder="Title">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-12 control-label">Konten</label>
                                        <div class="col-md-12">
                                            <textarea type="text" name="konten" class="form-control" placeholder="Konten"></textarea>
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
					            <i class="fa fa-reply text-primary"></i>
					            Daftar Pertanyaan Umum
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
                                    <option value="20">10</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>                                                
                            <div class="form-group col-lg-4">
                                <label>Filter Tipe</label>
                                <select class="form-control" name="tipe">
                                    <option value="">Semua</option>
                                    <option value="Akun">Akun</option>
                                    <option value="Pesanan">Pesanan</option>
                                    <option value="Sosial Media">Sosial Media</option>
                                    <option value="Top Up">Top Up</option>
                                    <option value="Isi Saldo">Isi Saldo</option>
                                    <option value="Koin">Koin</option>
                                    <option value="Voucher">Voucher</option>
                                    <option value="Pengembalian Dana">Pengembalian Dana</option>
                                    <option value="Status">Status</option>
                                    <option value="Status">API Dokumentasi</option>
                                </select>
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
                                    <th>Number</th>
                                    <th>Tipe</th>
                                    <th>Title</th>
                                    <th>Konten</th>
                                    <th width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
<?php 
// start paging config
if (isset($_GET['tipe'])) {
    $cari_tipe = $conn->real_escape_string(filter($_GET['tipe']));

    $cek_data = "SELECT * FROM pertanyaan_umum WHERE tipe LIKE '%$cari_tipe%' ORDER BY id DESC"; // edit
} else {
    $cek_data = "SELECT * FROM pertanyaan_umum ORDER BY id DESC"; // edit
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
?>
                                <tr>
                                    <td width="10%"><span class="badge badge-primary"><?php echo $no++; ?></span></td>
                                    <td width="10%"><span class="badge badge-success"><?php echo $view_data['number']; ?></span></td>
                                    <td width="10%"><span class="badge badge-warning"><?php echo $view_data['tipe']; ?></span></td>
                                    <td><?php echo $view_data['title']; ?></td>
                                    <td><?php echo $view_data['konten']; ?></td>
                                    <td align="center">
                                        <a href="javascript:;" onclick="users('<?php echo $config['web']['url']; ?>admin/ajax/pertanyaan-umum/ubah?id=<?php echo $view_data['id']; ?>')" class="btn btn-sm btn-warning"><i class="fa fa-pencil-alt" title="Edit"></i></a>
                                        <a href="javascript:;" onclick="users('<?php echo $config['web']['url']; ?>admin/ajax/pertanyaan-umum/hapus?id=<?php echo $view_data['id']; ?>')" class="btn btn-sm btn-danger"><i class="fa fa-trash" title="Hapus"></i></a>
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
        echo "<li class='page-item'><a class='page-link' href='".$self."?halaman=".$total_pages."&tampil=".$cari_urut."&tipe=".$cari_tipe."'><i class='fa fa-angle-double-right kt-font-brand'></i></a></li>";
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
        <!-- End Page Data FAQ -->

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
                                <h4 class="modal-title mt-0" id="myModalLabel"><i class="fa fa-reply text-primary"></i> Pertanyaan Umum</h4>
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