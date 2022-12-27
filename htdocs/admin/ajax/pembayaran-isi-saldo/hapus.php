<?php
session_start();
require '../../../config.php';
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	if (!isset($_SESSION['user'])) {
			exit("Anda Tidak Memiliki Akses!");
	}
	if (!isset($_GET['data'])) {
		exit("Anda Tidak Memiliki Akses!");
	} 		
$get_id = $conn->real_escape_string(filter($_GET['data']));
$cek_metod = $conn->query("SELECT * FROM metode_depo WHERE id = '$get_id'");
$data_metod = $cek_metod->fetch_assoc();
	if (mysqli_num_rows($cek_metod) == 0) {
		exit("Data Tidak Ditemukan");
	} else {
?>
		    <div class="row">
		    	<div class="col-md-12">
					<div class="form-group">
						<label>ID Pembayaran Isi Saldo</label>
						<input type="number" name="id" class="form-control" value="<?php echo $data_metod['id']; ?>" readonly>
					</div>
                    <div class="form-group">
						<label>Provider</label>
						<input type="text" name="nama" class="form-control" value="<?php echo $data_metod['provider']; ?>" readonly>
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