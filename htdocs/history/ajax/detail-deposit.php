<?php
session_start();
require '../../config.php';
require '../../lib/session_user.php';
if (isset($_POST['id'])) {
	$post_id = $conn->real_escape_string(filter($_POST['id']));
	$cek_depo = $conn->query("SELECT * FROM deposit WHERE id = '$post_id'");
	while ($data_depo = mysqli_fetch_assoc($cek_depo)) {
    if ($data_depo['status'] == "Pending") {
        $label = "warning";
    } else if ($data_depo['status'] == "Error") {
        $label = "danger";
    } else if ($data_depo['status'] == "Success") {
        $label = "success";
    }
?>
<div class="table-responsive">
<table class="table table-striped table-bordered table-box">
<tr>
<th class="table-detail" width="50%">Kode Isi Saldo</th>
<td class="table-detail"><?php echo $data_depo['kode_deposit']; ?></td>
</tr>
<tr>
<th class="table-detail">Jumlah Pembayaran</th>
<td class="table-detail">Rp <?php echo number_format($data_depo['jumlah_transfer'],0,',','.'); ?></td>
</tr>
<tr>
<th class="table-detail">Saldo Yang Di Dapatkan</th>
<td class="table-detail">Rp <?php echo number_format($data_depo['get_saldo'],0,',','.'); ?></td>
</tr>
<tr>
<th class="table-detail">Status</th>
<td class="table-detail"><span class="btn btn-<?php echo $label; ?> btn-elevate btn-pill btn-elevate-air btn-sm"><?php echo $data_depo['status']; ?></td>
</tr>
<tr>
<th class="table-detail">Tanggal & Waktu</th>
<td class="table-detail"><?php echo tanggal_indo($data_depo['date']).','.tanggal_indo($data_depo['time']); ?></td>
</tr>
</table>
</div>
<?php
} 
}