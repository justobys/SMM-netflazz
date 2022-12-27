<?php
session_start();
require '../config.php';
$tipe = "Masuk";

if (isset($_COOKIE['cookie_token'])) {
	$data = $conn->query("SELECT * FROM users WHERE cookie_token='" . $_COOKIE['cookie_token'] . "'");
	if (mysqli_num_rows($data) > 0) {
		$hasil = mysqli_fetch_assoc($data);
		$_SESSION['user'] = $hasil;
	}
}

if (isset($_SESSION['user'])) {
	header("Location: " . $config['web']['url']);
} else {

	if (isset($_POST['masuk'])) {
		$username = $conn->real_escape_string(filter($_POST['username']));
		$password = $conn->real_escape_string(filter($_POST['password']));

		$cek_pengguna = $conn->query("SELECT * FROM users WHERE username = '$username'");
		$cek_pengguna_ulang = mysqli_num_rows($cek_pengguna);
		$data_pengguna = mysqli_fetch_assoc($cek_pengguna);

		$verif_password = password_verify($password, $data_pengguna['password']);

		$error = array();
		if (empty($username)) {
			$error['username'] = '*Tidak Boleh Kosong';
		} else if ($cek_pengguna_ulang == 0) {
			$error['username'] = '*Pengguna Tidak Terdaftar';
		}
		if (empty($password)) {
			$error['password'] = '*Tidak Boleh Kosong';
		} else if ($verif_password <> $data_pengguna['password']) {
			$error['password'] = '*Kata Sandi Anda Salah';
		} else {

			if ($data_pengguna['status'] == "Tidak Aktif") {
				$_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Akun Sudah Tidak Aktif.<script>swal("Gagal!", "Akun Sudah Tidak Aktif.", "error");</script>');
			} else if ($data_pengguna['status_akun'] == "Belum Verifikasi") {
				$_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Akun Kamu Belum Di Verifikasi.<script>swal("Gagal!", "Akun Kamu Belum Di Verifikasi.", "error");</script>');
			} else {

				if ($cek_pengguna_ulang == 1) {
					if ($verif_password == true) {
						$remember = isset($_POST['remember']) ? TRUE : false;
						if ($remember == TRUE) {
							$cookie_token = md5($username);
							$conn->query("UPDATE users SET cookie_token='" . $cookie_token . "' WHERE username='" . $username . "'");
							setcookie('cookie_token', $cookie_token, time() + 60 * 60 * 24 * 365, '/');
						}
						$conn->query("INSERT INTO aktifitas VALUES ('','$username', 'Masuk', '" . get_client_ip() . "','$date','$time')");
						$_SESSION['user'] = $data_pengguna;
						exit(header("Location: " . $config['web']['url']));
					} else {
						$_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.<script>swal("Ups Gagal!", "Sistem Kami Sedang Mengalami Gangguan.", "error");</script>');
					}
				}
			}
		}
	}
}

require '../lib/header_home.php';

?>



<!-- Start Page Login -->
<div class="login-2" style="background-image: url('');">
	<div class="container">
		<div class="row">
		    <div class="col-md-6 d-none d-sm-block">
                <img src="<?php echo $config['web']['url'] ?>assets/media/logos/netflazz.png" alt="Image" class="img-fluid" style="max-width: 100% !important;">
            </div>
			<div class="col-lg-6">
				<div class="form-section">
					<div style="margin-bottom:15px">
					    <div class="">
					        <a href="<?php echo $config['web']['url'] ?>/auth/login">
					            <img src="<?php echo $config['web']['url'] ?>assets/media/logos/netflazz.png" width="140" class="img" alt="Reseller NetFlazz.com">
					        </a>
					    </div>
					 </div>
					<?php
					if (isset($_SESSION['hasil'])) {
					?>
						<div class="alert alert-<?php echo $_SESSION['hasil']['alert'] ?> alert-dismissible" role="alert">
							<?php echo $_SESSION['hasil']['pesan'] ?>
						</div>
					<?php
						unset($_SESSION['hasil']);
					}
					?>
					
					<div class="alert alert-success alert-dismissible">
						<p>Belum Verifikasi Akun? <a href="<?php echo $config['web']['url'] ?>auth/verification-account"> <strong style="color:#354da1">Verifikasi Disini</strong></a></p>
					</div>
					<div class="login-inner-form">
						<form class="form-horizontal" role="form" method="POST">
							<input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
							<div class="form-group form-box">
								<input type="text" name="username" class="input-text" placeholder="Username" value="<?php echo $username; ?>" required>
								<i class="flaticon-user"></i>
								<small class="text-danger font-13 pull-right"><?php echo ($error['username']) ? $error['username'] : ''; ?></small>
							</div>
							<div class="form-group form-box">
								<input type="password" name="password" class="input-text" placeholder="Kata Sandi" required>
								<i class="flaticon-password"></i>
								<small class="text-danger font-13 pull-right"><?php echo ($error['password']) ? $error['password'] : ''; ?></small>
							</div>
							<div class="checkbox clearfix">
								<div class="form-check checkbox-theme">
									<input class="form-check-input" type="checkbox" value="1" id="rememberMe" name="remember">
									<label class="form-check-label" for="rememberMe">
										Ingat Saya
									</label>
								</div>
								<span class="pull-right"><a class="text-primary" href="<?php echo $config['web']['url'] ?>auth/forgot-password"><strong>Lupa Kata Sandi?</strong></a></span>
							</div>
							<div class="form-group mb-0">
								<button type="submit" class="btn btn-primary btn-block" name="masuk">Masuk</button>
							</div>
							<br />
							
							<p>Belum Punya Akun ?<a class="text-primary" href="<?php echo $config['web']['url'] ?>auth/register"> <strong>Daftar</strong></a></p>
							<br />
							<p>Belum Verifikasi Akun ?<a class="text-primary" href="<?php echo $config['web']['url'] ?>auth/verification-account"> <strong>Verifikasi Disini</strong></a></p>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End Page Login -->

<?php
require '../lib/footer_home.php';
?>
