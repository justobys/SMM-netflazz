<?php
session_start();
require '../../../config.php';
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	if (!isset($_SESSION['user'])) {
			exit("Anda Tidak Memiliki Akses!");
	}
	if (!isset($_GET['id_layanan'])) {
		exit("Anda Tidak Memiliki Akses!");
	} 		
$get_id = $conn->real_escape_string(filter($_GET['id_layanan']));
$cek_layanan = $conn->query("SELECT * FROM layanan_pascabayar WHERE service_id = '$get_id'");
$data_layanan = $cek_layanan->fetch_assoc();
	if (mysqli_num_rows($cek_layanan) == 0) {
		exit("Data Tidak Ditemukan");
	} else {
?>
		    <div class="row">
		    	<div class="col-md-12">
					<div class="form-group">
						<label>ID Layanan</label>
						<input type="text" name="id" class="form-control" value="<?php echo $data_layanan['service_id']; ?>" readonly>
					</div>
                    <div class="form-group">
						<label>Nama Layanan</label>
						<input type="text" name="layanan" class="form-control" value="<?php echo $data_layanan['service_id']; ?>" readonly>
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