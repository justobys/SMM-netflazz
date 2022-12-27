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
$get_idpengguna = $conn->real_escape_string(filter($_GET['id']));
$cek_pengguna = $conn->query("SELECT * FROM users WHERE id = '$get_idpengguna'");
$data_pengguna = $cek_pengguna->fetch_assoc();
	if (mysqli_num_rows($cek_pengguna) == 0) {
		exit("Data Tidak Ditemukan");
	} else {
?>										
		    <div class="row">
		    	<div class="col-md-12">
					<div class="form-group">
						<label>ID Pengguna</label>
						<input type="number" name="id" class="form-control" value="<?php echo $data_pengguna['id']; ?>" readonly>
					</div>
					<div class="form-group">
						<label>Nama Pengguna</label>
						<input type="text" name="username" class="form-control" value="<?php echo $data_pengguna['username']; ?>" readonly>
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