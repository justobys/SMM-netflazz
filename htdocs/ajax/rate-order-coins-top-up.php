<?php
require("../config.php");

if (isset($_POST['layanan'])) {
	$post_harga = $conn->real_escape_string(filter($_POST['layanan']));
	$cek_harga = $conn->query("SELECT * FROM layanan_pulsa WHERE service_id = '$post_harga' AND status = 'Normal'");
	$cek_rate_koin = $conn->query("SELECT * FROM setting_koin_didapat WHERE status = 'Aktif'");
	$data_rate_koin = mysqli_fetch_assoc($cek_rate_koin);
	if (mysqli_num_rows($cek_harga) == 1) {
		$data_harga = mysqli_fetch_assoc($cek_harga);
		$koin = $data_harga['harga'] * $data_rate_koin['rate'];
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