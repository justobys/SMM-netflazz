<?php
require("../config.php");

if (isset($_POST['tipe'])) {
	$post_tipe = $conn->real_escape_string(filter($_POST['tipe']));
	$cek_layanan = $conn->query("SELECT * FROM kategori_layanan WHERE server = '$post_tipe' ORDER BY nama ASC");
	?>
	<option value="0">Pilih Salah Satu</option>
	<?php
	while ($data_layanan = $cek_layanan->fetch_assoc()) {
	?>
	<option value="<?php echo $data_layanan['kode'];?>"><?php echo $data_layanan['nama'];?></option>
	<?php
	}
} else {
?>
<option value="0">Error.</option>
<?php
}