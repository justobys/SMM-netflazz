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
$cek_data = $conn->query("SELECT * FROM kontak_website WHERE id = '$get_id'");
$data_faq = $cek_data->fetch_assoc();
	if (mysqli_num_rows($cek_data) == 0) {
		exit("Data Tidak Ditemukan");
	} else {
?>										
		    			<div class="row">
		    				<div class="col-md-12">
								<div class="form-group">
									<label class="col-md-12 control-label">ID Kontak Website</label>
									<div class="col-md-12">
                                        <input type="number" name="id" class="form-control" value="<?php echo $data_faq['id']; ?>" readonly>
									</div>
								</div>
                                <div class="form-group">
                                    <label class="col-md-12 control-label">Nomor WhatsApp</label>
                                    <div class="col-md-12">
                                        <input type="number" name="no_wa" class="form-control" placeholder="Nomor WhatsApp" value="<?php echo $data_faq['no_wa']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12 control-label">Link Facebook</label>
                                    <div class="col-md-12">
                                        <input type="text" name="link_fb" class="form-control" placeholder="Link Facebook" value="<?php echo $data_faq['link_fb']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12 control-label">Link Instagram</label>
                                    <div class="col-md-12">
                                        <input type="text" name="link_ig" class="form-control" placeholder="Link Instagram" value="<?php echo $data_faq['link_ig']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12 control-label">Email</label>
                                    <div class="col-md-12">
                                        <input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo $data_faq['email']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12 control-label">Alamat</label>
                                    <div class="col-md-12">
                                        <input type="text" name="alamat" class="form-control" placeholder="Alamat" value="<?php echo $data_faq['alamat']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12 control-label">Kode POS</label>
                                    <div class="col-md-12">
                                        <input type="number" name="kode_pos" class="form-control" placeholder="Kode POS" value="<?php echo $data_faq['kode_pos']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12 control-label">Jam Kerja</label>
                                    <div class="col-md-12">
                                        <input type="text" name="jam_kerja" class="form-control" placeholder="Jam Kerja" value="<?php echo $data_faq['jam_kerja']; ?>">
                                    </div>
                                </div>
								<div class="modal-footer">
                                    <button type="submit" class="btn btn-warning" name="ubah_web"><i class="fa fa-pencil-alt"></i> Ubah</button>
                                </div>
                            </div>
                    	</div>
<?php
}
} else {
exit("Anda Tidak Memiliki Akses!");
}