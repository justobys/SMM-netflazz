<?php
session_start();
require '../config.php';
require '../lib/session_login_admin.php'; 

        if (isset($_POST['tambah'])) {
            $nama = $conn->real_escape_string(trim($_POST['nama']));
            $kode = $conn->real_escape_string(trim($_POST['kode']));
            $tipe = $conn->real_escape_string(trim($_POST['tipe']));
            $server = $conn->real_escape_string(trim($_POST['server']));

            if (!$nama || !$kode || !$tipe) {
                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Mohon Mengisi Semua Input.');                               
            } else {

                if ($conn->query("INSERT INTO kategori_layanan VALUES ('', '$nama', '$kode', '$tipe', '$server')") == true) {
                    $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip, Kategori Baru Telah Berhasil Ditambahkan.');
                } else {
                    $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.<script>swal("Ups Gagal!", "Sistem Kami Sedang Mengalami Gangguan.", "error");</script>');
                }
            }

        } else if (isset($_POST['ubah'])) {
            $get_id = $conn->real_escape_string(filter($_GET['id_kategori']));
            $nama = $conn->real_escape_string(trim($_POST['nama']));
            $kode = $conn->real_escape_string(trim($_POST['kode']));
            $tipe = $conn->real_escape_string(trim($_POST['tipe']));
            $server = $conn->real_escape_string(trim($_POST['server']));

            $cek_id = $conn->query("SELECT * FROM kategori_layanan WHERE id = '$get_id'");       

            if ($cek_id->num_rows == 0) {
                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Data Tidak Di Temukan.');                                   
            } else {

                if ($conn->query("UPDATE kategori_layanan SET nama = '$nama', kode = '$kode', tipe = '$tipe', server = '$server' WHERE id = '$get_id'") == true) {
                    $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip, Kategori Telah Berhasil Di Ubah.');
                } else {
                    $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.<script>swal("Ups Gagal!", "Sistem Kami Sedang Mengalami Gangguan.", "error");</script>');
                }
            }

        } else if (isset($_POST['hapus'])) {
            $get_id = $conn->real_escape_string(filter($_GET['id_kategori']));

            $cek_kategori = $conn->query("SELECT * FROM kategori_layanan WHERE id = '$get_id'");

            if ($cek_kategori->num_rows == 0) {
                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => ' Ups, Data Tidak Di Temukan.');
            } else {

                if ($conn->query("DELETE FROM kategori_layanan WHERE id = '$get_id'") == true) {
                    $_SESSION['hasil'] = array('alert' => 'success', 'judul' => 'Berhasil', 'pesan' => 'Sip, Kategori Berhasil Di Hapus.');
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
                    <h3 class="kt-subheader__title">Daftar Kategori Layanan</h3>
                    <span class="kt-subheader__separator kt-hidden"></span>
                    <div class="kt-subheader__breadcrumbs">
                        <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                        <span class="kt-subheader__breadcrumbs-separator"></span>
                        <a href="#" class="kt-subheader__breadcrumbs-link">Halaman Admin</a>
                        <span class="kt-subheader__breadcrumbs-separator"></span>
                        <a href="#" class="kt-subheader__breadcrumbs-link">Daftar Kategori Layanan</a>
	                </div>
	            </div>
	        </div>
        </div>
        <!-- End Sub Header -->

        <!-- Start Content -->
        <div class="kt-container kt-grid__item kt-grid__item--fluid">

        <!-- Start Page Data Category Service -->
        <div class="row">
            <div class="col-md-12">
                <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title m-t-0 id="myModalLabel""><i class="mdi mdi-newspaper"></i> Tambah Kategori</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal" role="form" method="POST">
                                    <input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Nama Kategori</label>
                                        <div class="col-md-12">
                                            <input type="text" name="nama" class="form-control" placeholder="Nama Kategori">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Kode Kategori</label>
                                        <div class="col-md-12">
                                            <input type="text" name="kode" class="form-control" placeholder="Kode Kategori">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Tipe</label>
                                        <div class="col-md-12">
                                            <select class="form-control" name="tipe">
                                                <option value="">Pilih Salah Satu...</option>
                                                <option value="Sosial Media">SOSIAL MEDIA</option>
                                                <option value="Top Up">TOP UP</option>
                                                <option value="Pascabayar">PASCABAYAR</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12 control-label">Server <small class="text-danger">*Untuk Tipe SOSIAL MEDIA Jangan Diisi.</small></label>
                                        <div class="col-md-12">
                                            <select class="form-control" name="server">
                                                <option value="">Pilih Salah Satu...</option>
                                                <option value="Pulsa">Pulsa</option>
                                                <option value="E-Money">E-Money</option>
                                                <option value="Data">Data</option>
                                                <option value="Paket SMS Telpon">Paket SMS Telpon</option>
                                                <option value="Games">Games</option>
                                                <option value="PLN">PLN</option>
                                                <option value="Pulsa Internasional">Pulsa Internasional</option>
                                                <option value="Voucher">Voucher</option>
                                                <option value="WIFI ID">WIFI ID</option>
                                                <option value="Pascabayar">Pascabayar</option>
                                            </select>
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
					            <i class="fa fa-list text-primary"></i>
					            Daftar Kategori Layanan
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
                                    <option value="10">10</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                    <option value="250">250</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-4">
                                <label>Cari Nama Kategori</label>
                                <input type="text" class="form-control" name="search" placeholder="Cari Nama Kategori" value="">
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
                                    <th>Nama Kategori</th>
                                    <th>Kode Kategori</th>
                                    <th>Server <small class="text-danger">*Disi Jika Tipe TOP UP & Pascabayar.</small></th>
                                    <th>Tipe</th>
                                    <th width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
<?php 
// start paging config
if (isset($_GET['search'])) {
    $search = $conn->real_escape_string(filter($_GET['search']));

    $cek_kategori = "SELECT * FROM kategori_layanan WHERE nama LIKE '%$search%' ORDER BY id ASC"; // edit
} else {
    $cek_kategori = "SELECT * FROM kategori_layanan ORDER BY id ASC"; // edit
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
$new_query = $cek_kategori." LIMIT $starting_position, $records_per_page";
$new_query = $conn->query($new_query);
// end paging config
while ($data_kategori = $new_query->fetch_assoc()) {
?>
                                <tr> 
                                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>?id_kategori=<?php echo $data_kategori['id']; ?>" class="form-inline" role="form" method="POST">
                                    <input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
                                    <td><input type="text" class="form-control" style="width: 200px;" name="nama" value="<?php echo $data_kategori['nama']; ?>"></td>
                                    <td><input type="text" class="form-control" style="width: 200px;" name="kode" value="<?php echo $data_kategori['kode']; ?>"></td>
                                    <td>
                                        <select class="form-control" style="width: 200px;" name="server">
                                            <option value="<?php echo $data_kategori['server']; ?>"><?php echo $data_kategori['server']; ?></option>
                                            <option value="Pulsa">Pulsa</option>
                                            <option value="E-Money">E-Money</option>
                                            <option value="Data">Data</option>
                                            <option value="Paket SMS Telpon">Paket SMS Telpon</option>
                                            <option value="Games">Games</option>
                                            <option value="PLN">PLN</option>
                                            <option value="Pulsa Internasional">Pulsa Internasional</option>
                                            <option value="Voucher">Voucher</option>
                                            <option value="WIFI ID">WIFI ID</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control" style="width: 200px;" name="tipe">
                                            <option value="<?php echo $data_kategori['tipe']; ?>"><?php echo $data_kategori['tipe']; ?></option>
                                            <option value="Sosial Media">SOSIAL MEDIA</option>
                                            <option value="Top Up">TOP UP</option>
                                            <option value="Pascabayar">PASCABAYAR</option>
                                        </select>
                                    </td>
                                    <td align="text-center">
                                        <button data-toggle="tooltip" title="Ubah" type="submit" name="ubah" class="btn btn-sm btn-bordred btn-warning"><i class="fa fa-pencil-alt" title="Ubah"></i></button>
                                        <button data-toggle="tooltip" title="Hapus" type="submit" name="hapus" class="btn btn-sm btn-bordred btn-danger"><i class="fa fa-trash" title="Hapus"></i></button>
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
$cek_kategori = $conn->query($cek_kategori);
$total_records = mysqli_num_rows($cek_kategori);
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
        <!-- End Page Data Category Service -->

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