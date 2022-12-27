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
$get_idkontak = $conn->real_escape_string(filter($_GET['id']));
$cek_kontak = $conn->query("SELECT * FROM kontak_admin WHERE id = '$get_idkontak'");
$data_kontak = $cek_kontak->fetch_assoc();
	if (mysqli_num_rows($cek_kontak) == 0) {
		exit("Data Tidak Ditemukan");
	} else {
?>										
		    <div class="row">
		    	<div class="col-md-12">
					<div class="form-group">
						<label>ID Kontak Admin</label>
						<input type="number" name="id" class="form-control" value="<?php echo $data_kontak['id']; ?>" readonly>
					</div>
					<div class="form-group">
						<label>Nama Lengkap</label>
						<input type="text" name="nama" class="form-control" readonly><?php echo $data_kontak['nama']; ?>
					</div>
					<div class="modal-footer">
					    <button type="submit" class="btn btn-danger" name="hapus_admin"><i class="fa fa-trash"></i> Hapus</button>
					</div>
				</div>
            </div>
<?php
}
} else {
exit("Anda Tidak Memiliki Akses!");
}                 