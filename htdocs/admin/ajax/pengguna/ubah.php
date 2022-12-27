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
                                    <label>Nama Lengkap</label>
                                    <input type="text" name="username" class="form-control" value="<?php echo $data_pengguna['nama']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" value="<?php echo $data_pengguna['email']; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Nomor HP <small class="text-danger">*Format Nomor HP Wajib 62.</small></label>
                                    <input type="number" class="form-control" name="no_hp" value="<?php echo $data_pengguna['no_hp']; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Nama Pengguna</label>
                                    <input type="text" name="username" class="form-control" value="<?php echo $data_pengguna['username']; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Kata Sandi <small class="text-danger">*Kosongkan Jika Tidak Diubah.</small></label>
                                    <input type="text" name="password" class="form-control" value="">
                                </div>
                                <!--<div class="form-group">
                                    <label>Saldo Sosial Media</label>
                                    <input type="number" name="saldo_sosmed" class="form-control" value="<?php echo $data_pengguna['saldo_sosmed']; ?>">
                                </div>-->
                                <div class="form-group">
                                    <label>Saldo</label>
                                    <input type="number" name="saldo_top_up" class="form-control" value="<?php echo $data_pengguna['saldo_top_up']; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Koin</label>
                                    <input type="number" name="koin" class="form-control" value="<?php echo $data_pengguna['koin']; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Level</label>
                                    <select class="form-control" name="level">
                                        <option value="<?php echo $data_pengguna['level']; ?>"><?php echo $data_pengguna['level']; ?> (Terpilih)</option>
                                        <option value="Member">Member</option>
                                        <option value="Agen">Agen</option>
                                        <option value="Developers">Developers</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Status Akun</label>
                                    <select class="form-control" name="status_akun">
                                        <option value="<?php echo $data_pengguna['status']; ?>"><?php echo $data_pengguna['status']; ?> (Terpilih)</option>
                                        <option value="Aktif">Aktif</option>
                                        <option value="Tidak Aktif">Tidak Aktif</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>PIN</label>
                                    <input type="number" name="pin" class="form-control" value="<?php echo $data_pengguna['pin']; ?>">
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