<?php
session_start();
require '../../../config.php';
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	if (!isset($_SESSION['user'])) {
			exit("Anda Tidak Memiliki Akses!");
	}
	if (!isset($_GET['id'])) {
		exit("Anda Tidak Memiliki Akses!");
	} 		
$get_id = $conn->real_escape_string(filter($_GET['id']));
$cek_data = $conn->query("SELECT * FROM ketentuan_layanan WHERE id = '$get_id'");
$data_faq = $cek_data->fetch_assoc();
	if (mysqli_num_rows($cek_data) == 0) {
		exit("Data Tidak Ditemukan");
	} else {
?>
		    <div class="row">
		    	<div class="col-md-12">
					<div class="form-group">
						<label>ID Ketentuan Layanan</label>
						<input type="number" name="id" class="form-control" value="<?php echo $data_faq['id']; ?>" readonly>
					</div>
					<div class="form-group">
						<label>Tipe</label>
						<textarea type="text" name="konten" class="form-control" readonly><?php echo $data_faq['tipe']; ?></textarea>
					</div>
					<div class="modal-footer">
					    <button type="submit" class="btn btn-danger" name="hapus"><i class="fa fa-trash"></i> Hapus</button>
					</div>
				</div>
            </div>
<?php
}
} else {
exit("Anda Tidak Memiliki Akses!");
}                 