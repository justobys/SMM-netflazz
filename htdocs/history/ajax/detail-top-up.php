<?php
session_start();
require '../../config.php';
require '../../lib/session_user.php';
if (isset($_POST['id'])) {   
	$post_id = $conn->real_escape_string(filter($_POST['id']));
	$cek_pesanan = $conn->query("SELECT * FROM pembelian_pulsa WHERE id = '$post_id'");
	while($data_pesanan = $cek_pesanan->fetch_assoc()) {
    if ($data_pesanan['status'] == "Pending") {
        $label = "warning";
    } else if ($data_pesanan['status'] == "Error") {
        $label = "danger";
    } else if ($data_pesanan['status'] == "Success") {
        $label = "success";
    }
?>
<div class="table-responsive">
<table class="table table-striped table-bordered table-box">
<tr>
<th class="table-detail" width="50%">Kode Pesanan</th>
<td class="table-detail"><?php echo $data_pesanan['oid']; ?></td>
</tr>
<tr>
<th class="table-detail">Tujuan</th>
<td class="table-detail"><?php echo $data_pesanan['target']; ?></td>
</tr>
<tr>
<th class="table-detail">Keterangan</th>
<td class="table-detail"><?php echo $data_pesanan['keterangan']; ?></td>
</tr>
<tr>
<th class="table-detail">Via</th>
<td class="table-detail"><?php if($data_pesanan['place_from'] == "API") { ?><i class="fa fa-random"></i><?php } else { ?><i class="flaticon-globe"></i><?php } ?></td>
</tr>
<tr>
<th class="table-detail">Status</th>
<td class="table-detail"><span class="btn btn-<?php echo $label; ?> btn-elevate btn-pill btn-elevate-air btn-sm"><?php echo $data_pesanan['status']; ?></td>
</tr>
<th class="table-detail">Tanggal & Waktu</th>
<td class="table-detail"><?php echo tanggal_indo($data_pesanan['date']).','.tanggal_indo($data_pesanan['time']); ?></td>
</tr>
</table>
</div>
<?php 
}
}