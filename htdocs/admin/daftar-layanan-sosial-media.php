<?php
session_start();
require '../config.php';
require '../lib/session_login_admin.php'; 

        if (isset($_POST['tambah'])) {
            $sid = $conn->real_escape_string(filter($_POST['sid']));
            $pid = $conn->real_escape_string(trim($_POST['pid']));
            $kategori = $conn->real_escape_string(trim($_POST['kategori']));
            $layanan = $conn->real_escape_string($_POST['layanan']);
            $catatan = $conn->real_escape_string(trim($_POST['catatan']));
            $min = $conn->real_escape_string(trim($_POST['min']));
            $max = $conn->real_escape_string(trim($_POST['max']));
            $harga = $conn->real_escape_string($_POST['harga']);
            $harga_api = $conn->real_escape_string($_POST['harga_api']);
            $status = $conn->real_escape_string(trim($_POST['status']));
            $provider = $conn->real_escape_string(trim($_POST['provider']));   

            if (!$sid || !$pid || !$kategori || !$layanan || !$catatan || !$min || !$max || !$harga || !$harga_api || !$status || !$provider) {
                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Mohon Mengisi Semua Input.');                               
            } else {

                if ($conn->query("INSERT INTO layanan_sosmed VALUES ('', '$sid', '$kategori', '$layanan', '$catatan', '$min', '$max', '$harga', '$harga_api', '$status', '$pid', '$provider', 'SOSIAL MEDIA')") == true) {
                    $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip, Layanan Baru Telah Berhasil Ditambahkan.');
                } else {
                    $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.<script>swal("Ups Gagal!", "Sistem Kami Sedang Mengalami Gangguan.", "error");</script>');
                }
            }

        } else if (isset($_POST['ubah'])) {
            $sid = $conn->real_escape_string(filter($_POST['sid']));
            $pid = $conn->real_escape_string(trim($_POST['pid']));
            $kategori = $conn->real_escape_string(trim($_POST['kategori']));
            $layanan = $conn->real_escape_string($_POST['layanan']);
            $catatan = $conn->real_escape_string(trim($_POST['catatan']));
            $min = $conn->real_escape_string(trim($_POST['min']));
            $max = $conn->real_escape_string(trim($_POST['max']));
            $harga = $conn->real_escape_string($_POST['harga']);
            $harga_api = $conn->real_escape_string($_POST['harga_api']);
            $status = $conn->real_escape_string(trim($_POST['status']));
            $provider = $conn->real_escape_string(trim($_POST['provider']));

            $cek_id = $conn->query("SELECT * FROM layanan_sosmed WHERE service_id = '$sid'");       

            if ($cek_id->num_rows == 0) {
                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Data Tidak Di Temukan.');                                   
            } else {

                if ($conn->query("UPDATE layanan_sosmed SET service_id = '$sid', kategori = '$kategori', layanan = '$layanan', catatan = '$catatan', min = '$min', max = '$max', harga = '$harga', harga_api = '$harga_api', status = '$status', provider_id = '$pid', provider = '$provider' WHERE service_id = '$sid'") == true) {
                    $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip, Layanan Telah Berhasil Di Ubah.');
                } else {
                    $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.<script>swal("Ups Gagal!", "Sistem Kami Sedang Mengalami Gangguan.", "error");</script>');
                }
            }

        } else if (isset($_POST['hapus'])) {
            $post_id = $conn->real_escape_string($_POST['id']);

            $cek_layanan = $conn->query("SELECT * FROM layanan_sosmed WHERE service_id = '$post_id'");

            if ($cek_layanan->num_rows == 0) {
                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Data Tidak Di Temukan.');
            } else {

                if ($conn->query("DELETE FROM layanan_sosmed WHERE service_id = '$post_id'") == true) {
                    $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip, Layanan Berhasil Di Hapus.');
                } else {
                    $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.<script>swal("Ups Gagal!", "Sistem Kami Sedang Mengalami Gangguan.", "error");</script>');
                }
            }
        }

    require("../lib/header_admin.php");

?>

        <!-- Start Sub Header -->
        <div class="kt-subheader kt-grid__item" id="kt_subheader">
	        <div class="kt-container ">
	            <div class="kt-subheader__main">
                    <h3 class="kt-subheader__title">Daftar Layanan</h3>
                    <span class="kt-subheader__separator kt-hidden"></span>
                    <div class="kt-subheader__breadcrumbs">
                        <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                        <span class="kt-subheader__breadcrumbs-separator"></span>
                        <a href="#" class="kt-subheader__breadcrumbs-link">Halaman Admin</a>
                        <span class="kt-subheader__breadcrumbs-separator"></span>
                        <a href="#" class="kt-subheader__breadcrumbs-link">Daftar Layanan</a>
	                </div>
	            </div>
	        </div>
        </div>
        <!-- End Sub Header -->

        <!-- Start Content -->
        <div class="kt-container kt-grid__item kt-grid__item--fluid">

        <!-- Start Page Data Service Social Media -->
        <div class="row">
            <div class="col-md-12">
                <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title m-t-0 id="myModalLabel""><i class="fa fa-list text-primary"></i> Tambah Layanan</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal" role="form" method="POST">
                                    <input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">ID Layanan</label>
                                        <div class="col-md-12">
                                            <input type="number" name="sid" class="form-control" placeholder="ID Layanan">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">ID Provider</label>
                                        <div class="col-md-12">
                                            <input type="text" name="pid" class="form-control" placeholder="ID Provider">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Kategori</label>
                                        <div class="col-md-12">
                                            <select class="form-control" name="kategori">
                                                <option value="">Pilih Salah Satu...</option>
                                                <?php
                                                $cek_kategori = $conn->query("SELECT * FROM kategori_layanan WHERE tipe = 'Sosial Media' ORDER BY nama ASC");
                                                while ($data_kategori = $cek_kategori->fetch_assoc()) {
                                                ?>
                                                <option value="<?php echo $data_kategori['kode']; ?>"><?php echo $data_kategori['nama']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Layanan</label>
                                        <div class="col-md-12">
                                            <input type="text" name="layanan" class="form-control" placeholder="Nama Layanan">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Keterangan</label>
                                        <div class="col-md-12">
                                            <textarea type="text" name="catatan" class="form-control" placeholder="Keterangan"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Minimal Pemesanan</label>
                                        <div class="col-md-12">
                                            <input type="number" name="min" class="form-control" placeholder="Minimal Pemesanan">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Maksimal Pemesanan</label>
                                        <div class="col-md-12">
                                            <input type="number" name="max" class="form-control" placeholder="Maksimal Pemesanan">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Harga WEB/1000</label>
                                        <div class="col-md-12">
                                            <input type="number" name="harga" class="form-control" placeholder="Harga WEB/1000">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Harga API/1000</label>
                                        <div class="col-md-12">
                                            <input type="number" name="harga_api" class="form-control" placeholder="Harga API/1000">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Status</label>
                                        <div class="col-md-12">
                                            <select class="form-control" name="status">
                                                <option value="">Pilih Salah Satu...</option>
                                                <option value="Aktif">Aktif</option>
                                                <option value="Tidak Aktif">Tidak Aktif</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Provider</label>
                                        <div class="col-md-12">
                                            <select class="form-control" name="provider">
                                                <option value="">Pilih Salah Satu...</option>
                                                <?php
                                                $cek_provider = $conn->query("SELECT * FROM provider ORDER BY id ASC");
                                                while ($data_provider = $cek_provider->fetch_assoc()) {
                                                ?>
                                                <option value="<?php echo $data_provider['code']; ?>"><?php echo $data_provider['code']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="reset" class="btn btn-danger"><i class="fa fa-spinner"></i> Ulangi</button>
                                        <button type="submit" class="btn btn-primary" name="tambah"><i class="fa fa-add"></i> Tambah</button>
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
					            <i class="fa fa-list text-primary"></i>
					            Daftar Layanan Sosial Media
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
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                    <option value="250">250</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-4">
                                <label>Cari Nama Layanan</label>
                                <input type="text" class="form-control" name="search" placeholder="Cari Nama Layanan" value="">
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
                                    <!--<th>ID Layanan</th>-->
                                    <th>ID Provider</th>
                                    <th>Kategori</th>
                                    <th>Nama Layanan</th>
                                    <th>Keterangan</th>
                                    <th>Minimal Pesan</th>
                                    <th>Maksimal Pesan</th>
                                    <th>Harga WEB/1000</th>
                                    <th>Harga API/1000</th>
                                    <th>Status</th>
                                    <th>Provider</th>
                                    <th width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
<?php 
// start paging config
if (isset($_GET['search'])) {
    $search = $conn->real_escape_string(filter($_GET['search']));

    $cek_layanan = "SELECT * FROM layanan_sosmed WHERE layanan LIKE '%$search%' ORDER BY id ASC"; // edit
} else {
    $cek_layanan = "SELECT * FROM layanan_sosmed ORDER BY id ASC"; // edit
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
$new_query = $cek_layanan." LIMIT $starting_position, $records_per_page";
$new_query = $conn->query($new_query);
// end paging config
while ($data_layanan = $new_query->fetch_assoc()) {
?>
                                <tr> 
                                    <!--<td><?php echo $data_layanan['service_id']; ?></td>-->
                                    <td><?php echo $data_layanan['provider_id']; ?></td>
                                    <td><?php echo $data_layanan['kategori']; ?></td>
                                    <td><?php echo $data_layanan['layanan']; ?></td>
                                    <td><?php echo $data_layanan['catatan']; ?></td>
                                    <td><?php echo $data_layanan['min']; ?></td>
                                    <td><?php echo $data_layanan['max']; ?></td>
                                    <td><?php echo number_format($data_layanan['harga'],0,',','.'); ?></td>
                                    <td><?php echo number_format($data_layanan['harga_api'],0,',','.'); ?></td>
                                    <td><?php echo $data_layanan['status']; ?></td>
                                    <td><?php echo $data_layanan['provider']; ?></td>
                                    <td align="text-center">
                                        <a href="javascript:;" onclick="users('<?php echo $config['web']['url']; ?>admin/ajax/layanan-sosmed/ubah?id_layanan=<?php echo $data_layanan['id']; ?>')" class="btn btn-sm btn-warning"><i class="fa fa-pencil-alt" title="Ubah"></i></a>
                                        <a href="javascript:;" onclick="users('<?php echo $config['web']['url']; ?>admin/ajax/layanan-sosmed/hapus?id_layanan=<?php echo $data_layanan['id']; ?>')" class="btn btn-sm btn-danger"><i class="fa fa-trash" title="Hapus"></i></a>
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
        echo "<li class='kt-pagination__link--first'><a href='".$self."?halaman=".$next."'><i class='fa fa-angle-right kt-font-brand'></i></i></a></li>";
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
        <!-- End Page Data Service Social Media -->

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
                                <h4 class="modal-title mt-0" id="myModalLabel"><i class="fa fa-list text-primary"></i> Layanan</h4>
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