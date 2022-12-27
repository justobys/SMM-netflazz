<?php
require("../config.php");

if (isset($_POST['total'])) {
	$post_total = $conn->real_escape_string(filter($_POST['total']));
	$post_layanan = $conn->real_escape_string(filter($_POST['layanan']));
	$cek_total = $conn->query("SELECT * FROM layanan_sosmed WHERE service_id = '$post_layanan' AND status = 'Aktif'");
	$cek_rate_koin = $conn->query("SELECT * FROM setting_koin_didapat WHERE status = 'Aktif'");
	$data_rate_koin = mysqli_fetch_assoc($cek_rate_koin);
	if (mysqli_num_rows($cek_total) == 1) {
		$data_total = mysqli_fetch_assoc($cek_total);
		$koin = ($data_total['harga'] / 1000) * $data_rate_koin['rate'];
	?>

							<span class="form-text text-warning">Kamu Mendapatkan <?php echo number_format($koin,0,',','.'); ?> Koin</span>
<?php
} else {
?>
							<span class="form-text text-danger">Ups, Layanan Tidak Ditemukan.</span>
<?php
}
} else {
?>
							<span class="form-text text-danger">Ups Terjadi Kesalahan, Silahkan Hubungi Admin.</span>
<?php
}