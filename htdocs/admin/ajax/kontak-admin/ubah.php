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
                                    <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap" value="<?php echo $data_kontak['nama']; ?>">
                                </div>
								<div class="form-group">
                                    <label>Jabatan</label>
                                    <input type="text" name="jabatan" class="form-control" placeholder="Jabatan" value="<?php echo $data_kontak['jabatan']; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Deskripsi</label>
                                    <input type="text" name="deskripsi" class="form-control" placeholder="Deskripsi" value="<?php echo $data_kontak['deskripsi']; ?>">
                                </div>
                                <div class="form-group">
									<label>Alamat Rumah</label>
									<input type="text" name="lokasi" class="form-control" placeholder="Alamat Rumah" value="<?php echo $data_kontak['lokasi']; ?>">
								</div>
                                <div class="form-group">
                                    <label>Jam Kerja</label>
                                    <input type="text" name="jam_kerja" class="form-control" placeholder="Jam Kerja" value="<?php echo $data_kontak['jam_kerja']; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" name="email" class="form-control" placeholder="Jam Kerja" value="<?php echo $data_kontak['email']; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Nomor WhatsApp</label>
                                    <input type="number" name="no_hp" class="form-control" placeholder="Nomor WhatsApp" value="<?php echo $data_kontak['no_hp']; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Link Facebook</label>
                                    <input type="text" name="link_fb" class="form-control" placeholder="Link Facebook" value="<?php echo $data_kontak['link_fb']; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Link Instagram</label>
                                    <input type="text" name="link_ig" class="form-control" placeholder="Link Instagram" value="<?php echo $data_kontak['link_ig']; ?>">
                                </div>
								<div class="modal-footer">
                                    <button type="submit" class="btn btn-warning" name="ubah_admin"><i class="fa fa-pencil-alt"></i> Ubah</button>
                                </div>
                            </div>
                    	</div>
<?php
}
} else {
exit("Anda Tidak Memiliki Akses!");
}