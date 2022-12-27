<?php
require("../config.php");

if (isset($_POST['kategori'])) {
	$post_kategori = $conn->real_escape_string(filter($_POST['kategori']));
	$cek_layanan = $conn->query("SELECT * FROM layanan_pascabayar WHERE kategori = '$post_kategori' AND status = 'Normal' ORDER BY service_id ASC");
	?>
	<option value="0">Pilih Salah Satu</option>
	<?php
	while ($data_layanan = mysqli_fetch_assoc($cek_layanan)) {
	?>
	<option value="<?php echo $data_layanan['service_id'];?>"><?php echo $data_layanan['layanan'];?></option>
	<?php
	}
} else {
?>
<option value="0">Error.</option>
<?php
}