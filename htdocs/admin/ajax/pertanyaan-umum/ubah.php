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
$cek_data = $conn->query("SELECT * FROM pertanyaan_umum WHERE id = '$get_id'");
$data_faq = $cek_data->fetch_assoc();
	if (mysqli_num_rows($cek_data) == 0) {
		exit("Data Tidak Ditemukan");
	} else {
?>										
		    			<div class="row">
		    				<div class="col-md-12">
								<div class="form-group">
									<label>ID Pertanyaan Umum</label>
									<input type="number" name="id" class="form-control" value="<?php echo $data_faq['id']; ?>" readonly>
								</div>
                                <div class="form-group">
                                    <label>Number</label>
                                    <input type="text" name="number" class="form-control" placeholder="Number" value="<?php echo $data_faq['number']; ?>">
                                </div>
								<div class="form-group">
									<label>Tipe</label>
									<select class="form-control" name="tipe">
										<option value="<?php echo $data_faq['tipe']; ?>"><?php echo $data_faq['tipe']; ?></option>
										<option value="Akun">Akun</option>
										<option value="Pesanan">Pesanan</option>
										<option value="Sosial Media">Sosial Media</option>
										<option value="Top Up">Top Up</option>
										<option value="Isi Saldo">Isi Saldo</option>
										<option value="Koin">Koin</option>
										<option value="Voucher">Voucher</option>
										<option value="Pengembalian Dana">Pengembalian Dana</option>
										<option value="Status">Status</option>
										<option value="API Dokumentasi">API Dokumentasi</option>
                                    </select>
								</div>
                                <div class="form-group">
                                    <label>Title</label>
                                    <input  type="text" name="title" class="form-control" placeholder="Title" value="<?php echo $data_faq['title']; ?>">
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