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
									<label>Kategori</label>
									<select class="form-control" name="kategori">
										<option value="<?php echo $data_berita['icon']; ?>"><?php echo $data_berita['icon']; ?></option>
										<option value="PESANAN">PESANAN</option>
										<option value="LAYANAN">LAYANAN</option>
										<option value="DEPOSIT">DEPOSIT</option>
										<option value="PENGGUNA">PENGGUNA</option>
										<option value="PROMO">PROMO</option>
									</select>
								</div>
								<div class="form-group">
									<label>Tipe</label>
                                    <select class="form-control" name="tipe">
										<option value="<?php echo $data_berita['tipe']; ?>"><?php echo $data_berita['tipe']; ?></option>
										<option value="INFO">INFO</option>
										<option value="PERINGATAN">PERINGATAN</option>
										<option value="PENTING">PENTING</option>
                                    </select>
								</div>
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" name="title" class="form-control" placeholder="Title" value="<?php echo $data_berita['title']; ?>">
                                </div>
                                <div class="form-group">
									<label>Konten</label>
									<textarea type="text" name="konten" class="form-control"><?php echo $data_berita['konten']; ?></textarea>
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