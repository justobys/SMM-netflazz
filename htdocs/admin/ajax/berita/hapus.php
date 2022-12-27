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
$get_idberita = $conn->real_escape_string(filter($_GET['id']));
$cek_berita = $conn->query("SELECT * FROM berita WHERE id = '$get_idberita'");
$data_berita = $cek_berita->fetch_assoc();
	if (mysqli_num_rows($cek_berita) == 0) {
		exit("Data Tidak Ditemukan");
	} else {
?>
		    <div class="row">
		    	<div class="col-md-12">
					<div class="form-group">
						<label>ID Berita</label>
						<input type="number" name="id" class="form-control" value="<?php echo $data_berita['id']; ?>" readonly>
					</div>
					<div class="form-group">
						<label>Title</label>
						<textarea type="text" name="konten" class="form-control" readonly><?php echo $data_berita['title']; ?></textarea>
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