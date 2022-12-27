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
                                    <label>Nomer</label>
                                    <input type="number" name="nomer" class="form-control" placeholder="Nomer" value="<?php echo $data_faq['nomer']; ?>">
                                </div>
								<div class="form-group">
									<label>Tipe</label>
									<select class="form-control" name="tipe">
										<option value="<?php echo $data_faq['tipe']; ?>"><?php echo $data_faq['tipe']; ?> (Terpilih)</option>
										<option value="Umum">Umum</option>
										<option value="Layanan">Layanan</option>
                                    </select>
								</div>
                                <div class="form-group">
									<label>Konten</label>
									<textarea type="text" name="konten" class="form-control"><?php echo $data_faq['konten']; ?></textarea>
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