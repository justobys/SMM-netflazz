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
		            <h3 class="kt-subheader__title">Riwayat Pesanan</h3>
	                <div class="kt-subheader__breadcrumbs">
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
	                	<span class="kt-subheader__breadcrumbs-separator"></span>
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-link">Halaman Utama</a>
	                	<span class="kt-subheader__breadcrumbs-separator"></span>
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-link">Riwayat Pesanan</a>
	                </div>
	            </div>
	        </div>
        </div>
        <!-- End Sub Header -->

        <!-- Start Content -->
        <div class="kt-container kt-grid__item kt-grid__item--fluid">

        <!-- Start Page History Order -->
        <div class="row">
	        <div class="col-lg-12">
		        <div class="kt-portlet">
			        <div class="kt-portlet__head">
				        <div class="kt-portlet__head-label">
					        <h3 class="kt-portlet__head-title">
					            <i class="flaticon2-shopping-cart-1 text-primary"></i>
					            Riwayat Pesanan
					        </h3>
				        </div>
				        <div class="kt-portlet__head-toolbar">
					        <ul class="nav nav-pills nav-pills-sm nav-pills-label nav-pills-bold" role="tablist">
					            <li class="nav-item">
					                <a class="nav-link active" href="<?php echo $config['web']['url'] ?>history/order" role="tab">
					                Semua
					                </a>
					            </li>
					            <li class="nav-item">
					                <a class="nav-link" href="<?php echo $config['web']['url'] ?>history/order-sosmed" role="tab">
					                Sosial Media
					                </a>
					            </li>
					            <li class="nav-item">
					                <a href="<?php echo $config['web']['url'] ?>history/order-top-up" aria-expanded="false" class="nav-link">
					                Top Up
					                </a>  
					            </li>
					        </ul>
				        </div>
			        </div>
			        <div class="kt-portlet__body">
			            <div class="tab-content">
			                <!-- Start Tab History All Order -->
			                <div role="tabpanel" class="tab-pane fade active show" id="all">
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
                                                <option value="Processing">Processing</option>
                                                <option value="Success">Success</option>
                                                <option value="Error">Error</option>
                                                <option value="Partial">Partial</option>
                                            </select>
                                        </div>                                                
                                        <div class="form-group col-lg-3">
                                            <label>Cari Kode Pesanan</label>
                                            <input type="number" class="form-control" name="cari" placeholder="Masukkan Kode Pesanan Kamu" value="">
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
                                                <th></th>
                                                <th>Kode Pesanan</th>
                                                <th>Tanggal & Waktu</th>
                                                <th>Kategori</th>
                                                <th>Nama Layanan</th>
                                                <th>Target</th>
                                                <th>Harga</th>
                                                <th>Status</th>
                                                <th width="13%">Pengembalian Dana</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
<?php 
// start paging config
if (isset($_GET['cari'])) {
    $cari_oid = $conn->real_escape_string(filter($_GET['cari']));
    $cari_status = $conn->real_escape_string(filter($_GET['status']));

    $cek_pesanan = "SELECT * FROM semua_pembelian WHERE id_order LIKE '%$cari_oid%' AND status LIKE '%$cari_status%' AND user = '$sess_username' ORDER BY id DESC"; // edit
} else {
    $cek_pesanan = "SELECT * FROM semua_pembelian WHERE user = '$sess_username' ORDER BY id DESC"; // edit
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
    if ($data_pesanan['status'] == "Pending") {
        $label = "warning";
    } else if ($data_pesanan['status'] == "Partial") {
        $label = "danger";
    } else if ($data_pesanan['status'] == "Error") {
        $label = "danger";    
    } else if ($data_pesanan['status'] == "Processing") {
        $label = "primary";    
    } else if ($data_pesanan['status'] == "Success") {
        $label = "success";    
    }
    if ($data_pesanan['refund'] == "0") {
        $icon2 = "times-circle";
        $label2 = "danger"; 
    } else if ($data_pesanan['refund'] == "1") {
        $icon2 = "check";
        $label2 = "success";
    }
?>
                                            <tr>
                                                <td align="center"><?php if($data_pesanan['place_from'] == "API") { ?><i class="fa fa-random"></i><?php } else { ?><i class="flaticon-globe"></i><?php } ?></td>
                                                <td><button class="view_all_order btn btn-primary btn-elevate btn-pill btn-elevate-air btn-sm" data-toggle="modal" id="<?php echo $data_pesanan['id']; ?>" data-target='#myDetailAll'><?php echo $data_pesanan['id_order']; ?></button></td>
                                                <td><?php echo tanggal_indo($data_pesanan['date']); ?>, <?php echo $data_pesanan['time']; ?></td>
                                                <td><?php echo $data_pesanan['kategori']; ?></td>
                                                <td><?php echo $data_pesanan['layanan']; ?></td>
                                                <td style="min-width: 200px;">
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm" value="<?php echo $data_pesanan['target']; ?>" id="target-<?php echo $data_pesanan['oid']; ?>" readonly="">
                                                    <button data-toggle="tooltip" title="Copy Target" class="btn btn-primary btn-sm" type="button" onclick="copy_to_clipboard('target-<?php echo $data_pesanan['oid']; ?>')"><i class="fas fa-copy text-warning"></i></button>
                                                </div>
                                                <td>Rp <?php echo number_format($data_pesanan['harga'],0,',','.'); ?></td>
                                                <td><span class="btn btn-<?php echo $label; ?> btn-elevate btn-pill btn-elevate-air btn-sm"><?php echo $data_pesanan['status']; ?></span></td>
                                                <td><span class="btn btn-<?php echo $label2; ?> btn-elevate btn-circle btn-icon"><i class="fa fa-<?php echo $icon2; ?>"></i></span></td>
                                                <td align="center">
                                                    <a href="<?php echo $config['web']['url'] ?>page/receipt?oid=<?php echo $data_pesanan['id_pesan']; ?>" class="btn btn-primary btn-elevate btn-circle btn-icon"><i class="fa fa-receipt"></i></a>
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
$cek_pesanan = $conn->query($cek_pesanan);
$total_records = mysqli_num_rows($cek_pesanan);
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

                                        </ul>
                                    </div>
                                </div>
			                </div>
			                <!-- End Tab History All Order -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page History Order -->

        </div>
        <!-- End Content -->

        <!-- Start Scrolltop -->
		<div id="kt_scrolltop" class="kt-scrolltop">
		    <i class="fa fa-arrow-up"></i>
		</div>
		<!-- End Scrolltop -->

        <!-- Start Modal History All Order -->
        <div class="modal fade" id="myDetailAllOrder" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		    <div class="modal-dialog" role="document">
			    <div class="modal-content">
				    <div class="modal-header">
                    <h4 class="modal-title mt-0" id="myModalLabel"><i class="flaticon-eye text-primary"></i> Detail Pesanan</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
				    </div>
				    <div class="modal-body" id="data_all_order">
				    </div>
				    <div class="modal-footer">
				    	<button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
				    </div>
			    </div>
		    </div>
	    </div>
	    <!-- End Modal History All Order -->

        <!-- Start Modal History Order Social Media -->
        <div class="modal fade" id="myDetailSosmed" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		    <div class="modal-dialog" role="document">
			    <div class="modal-content">
				    <div class="modal-header">
                    <h4 class="modal-title mt-0" id="myModalLabel"><i class="flaticon-eye text-primary"></i> Detail Pesanan Sosial Media</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
				    </div>
				    <div class="modal-body" id="data_sosmed_order">
				    </div>
				    <div class="modal-footer">
				    	<button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
				    </div>
			    </div>
		    </div>
	    </div>
	    <!-- End Modal History Order Social Media -->

        <!-- Start Modal History Order Top Up -->
        <div class="modal fade" id="myDetailTopUp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		    <div class="modal-dialog" role="document">
			    <div class="modal-content">
				    <div class="modal-header">
                    <h4 class="modal-title mt-0" id="myModalLabel"><i class="flaticon-eye text-primary"></i> Detail Pesanan Top Up</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
				    </div>
				    <div class="modal-body" id="data_top_up_order">
				    </div>
				    <div class="modal-footer">
				    	<button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
				    </div>
			    </div>
		    </div>
	    </div>
	    <!-- End Modal History Order Top Up -->

<?php
require '../lib/footer.php';
?>

	    <script type="text/javascript">
	    function copy_to_clipboard(element) {
	        var copyText = document.getElementById(element);
	        copyText.select();
	        document.execCommand("copy");
	    }
	    </script>

	    <script type="text/javascript">
	        $(document).ready(function(){
		        $('.view_all_order').click(function(){
		        	var id = $(this).attr("id");
			        $.ajax({
				        url: '<?php echo $config['web']['url']; ?>history/ajax/detail-order.php',
				        method: 'post',		
				        data: {id:id},	
				        success:function(data){	
					        $('#data_all_order').html(data);
					        $('#myDetailAllOrder').modal("show");
				        }
			        });
		        });
	        });
	    </script>