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
$GetID = $conn->real_escape_string(filter($_GET['id']));
$CekData = $conn->query("SELECT * FROM setting_web WHERE id = '$GetID'");
$Datanya = $CekData->fetch_assoc();
	if (mysqli_num_rows($CekData) == 0) {
		exit("Data Tidak Ditemukan");
	} else {
?>										
		    			<div class="row">
		    				<div class="col-md-12">
								<div class="form-group">
									<label>Short Title</label>
									<input type="text" name="shrt_title" class="form-control" value="<?php echo $Datanya['short_title']; ?>">
								</div>                                    	
								<div class="form-group">
									<label>Title Website</label>
									<input type="text" name="title" class="form-control" value="<?php echo $Datanya['title']; ?>">
								</div>
								<div class="form-group">
									<label>Deskripsi Website</label>
									<textarea type="text" name="deskripsi" class="form-control"><?php echo $Datanya['deskripsi_web']; ?></textarea>
								</div>
								<div class="form-group">
									<label>Kontak Utama</label>
									<input type="text" name="kontak" class="form-control" value="<?php echo $Datanya['kontak_utama']; ?>">
								</div>
								<div class="form-group">
									<label>Lokasi</label>
									<input type="text" name="lokasi" class="form-control" value="<?php echo $Datanya['lokasi']; ?>">
								</div>
								<div class="form-group">
									<label>Kode Pos</label>
									<input type="text" name="kodepos" class="form-control" value="<?php echo $Datanya['kode_pos']; ?>">
								</div>
								<div class="modal-footer">
                                    <button type="submit" class="btn btn-warning" name="ubah"><i class="fa fa-pencil-alt"></i> Ubah</button>
                                </div>
                            </div>
                    	</div>
<?php 
	}
} else {
	exit("Anda Tidak Memiliki Akses!");
}