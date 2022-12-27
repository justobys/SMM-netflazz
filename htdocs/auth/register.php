<?php
session_start();
require '../config.php';
require("../lib/class.phpmailer.php");
$tipe = "Daftar";

function dapetin($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        $data = curl_exec($ch);
        curl_close($ch);
        return json_decode($data, true);
}
        if (isset($_POST['daftar'])) {
            $nama_depan = $conn->real_escape_string(filter($_POST['nama_depan']));
            $nama_belakang = $conn->real_escape_string(filter($_POST['nama_belakang']));
            $email = $conn->real_escape_string(filter($_POST['email']));
            $username = $conn->real_escape_string(filter($_POST['username']));
            $no_hp = $conn->real_escape_string(filter($_POST['no_hp']));
            $password = $conn->real_escape_string(filter($_POST['password']));
            $password2 = $conn->real_escape_string(filter($_POST['password2']));
            $pin = $conn->real_escape_string(filter($_POST['pin']));
            $kode_referral = $conn->real_escape_string(filter($_POST['kode_referral']));
            $ip = $_SERVER['REMOTE_ADDR'];
            $cek_ip = $conn->query("SELECT * FROM ip WHERE ip = '$ip'");

            $cek_email = $conn->query("SELECT * FROM users WHERE email = '$email'");
            $cek_email_ulang = mysqli_num_rows($cek_email);
            $data_email = mysqli_fetch_assoc($cek_email);
            
            $cek_ref = $conn->query("SELECT * FROM setting_referral");
            $cek_ref_ulang = mysqli_num_rows($cek_ref);
            $data_ref = mysqli_fetch_assoc($cek_ref);

            $cek_pengguna = $conn->query("SELECT * FROM users WHERE username = '$username'");
            $cek_pengguna_ulang = mysqli_num_rows($cek_pengguna);
            $data_pengguna = mysqli_fetch_assoc($cek_pengguna);

            $cek_no_hp = $conn->query("SELECT * FROM users WHERE no_hp = '$no_hp'");
            $cek_no_hp_ulang = mysqli_num_rows($cek_no_hp);
            $data_no_hp = mysqli_fetch_assoc($cek_no_hp);

            $cek_kode = $conn->query("SELECT * FROM users WHERE kode_referral = '$kode_referral'");
            $cek_kode_ulang = mysqli_num_rows($cek_kode);
            $data_kode = mysqli_fetch_assoc($cek_kode);
            $user_reff = $data_kode['username'];
            

            $kode_ref = acak(3).acak_nomor(4);

            $error = array();
            if (empty($nama_depan)) {
    		    $error ['nama_depan'] = '*Tidak Boleh Kosong';
            }
            if (empty($nama_belakang)) {
    		    $error ['nama_belakang'] = '*Tidak Boleh Kosong';
            } else if (empty($email)) {
    		    $error ['email'] = '*Tidak Boleh Kosong';
            } else if ($cek_email->num_rows > 0) {
    		    $error ['email'] = '*Email Sudah Terdaftar';
            } else if (empty($username)) {
    		    $error ['username'] = '*Tidak Boleh Kosong';
            } else if (strlen($username) < 5) {
    		    $error ['username'] = '*Nama Pengguna Minimal 5 Karakter';
            } else if ($cek_pengguna->num_rows > 0) {
    		    $error ['username'] = '*Nama Pengguna Sudah Terdaftar';
            } else if (empty($no_hp)) {
    		    $error ['no_hp'] = '*Tidak Boleh Kosong';
            } else if (!preg_match("/628/",$no_hp)) {
    		    $error ['no_hp'] = '*Format Nomor HP Harus 628';
            } else if ($cek_no_hp->num_rows > 0) {
    		    $error ['no_hp'] = '*Nomor HP Sudah Terdaftar';
            } else if (empty($password)) {
    		    $error ['password'] = '*Tidak Boleh Kosong';
            } else if (strlen($password) < 6) {
    		    $error ['password'] = '*Minimal 6 Karakter';
            } else if (empty($password2)) {
    		    $error ['password2'] = '*Tidak Boleh Kosong';
            } else if ($password <> $password2) {
    		    $error ['password2'] = '*Konfirmasi Kata Sandi Tidak Sesuai';
            } else if (empty($pin)) {
    		    $error ['pin'] = '*Tidak Boleh Kosong.';
            } else if (strlen($pin) <> 6 ){
    		    $error ['pin'] = '*PIN Harus 6 Digit.';
            } else if ($_POST['accept'] !== "true") {
	            $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Silahkan Setujui Ketentuan Layanan Kami Sebelum Mendaftar.<script>swal("Gagal!", "Silahkan Setujui Ketentuan Layanan Kami Sebelum Mendaftar.", "error");</script>');
            } else if ($cek_ip->num_rows > 0) {
                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Kamu telah mendaftarkan akun sebelumnya.'); 
            } else {

                $hash_password = password_hash($password, PASSWORD_DEFAULT);
                $kode_verifikasi = acak_nomor(3).acak_nomor(3);
                $api_key =  acak(20);
            $mail = new PHPMailer;
	        $mail->IsSMTP();
	        $mail->SMTPSecure = 'ssl'; 
	        $mail->Host = "mail.celullar.my.id"; //host masing2 provider email
	        $mail->SMTPDebug = 2;
	        $mail->Port = 465;
	        $mail->SMTPAuth = true;
	        $mail->Username = "support@celullar.my.id"; //user email
	        $mail->Password = "Pache220999"; //password email
	        $mail->SetFrom("support@celullar.my.id","NetSwitch"); //set email pengirim
	        $mail->Subject = "Verifikasi Akun Anda"; //subyek email
	        $mail->AddAddress("$email","");  //tujuan email
	        $mail->MsgHTML("<html>

<head>
    
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge' />
    <meta name='author' content='RAP Code'>
    <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.0.7/css/all.css'>
    <link href='https://fonts.googleapis.com/css?family=Dosis' rel='stylesheet'>
    <style type='text/css'>
        body,table,td,a{-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}table,td{mso-table-lspace:0pt;mso-table-rspace:0pt}table{border-collapse:collapse!important}body{font-family:'Dosis';height:100%!important;margin:0!important;padding:0!important;width:100%!important}a[x-apple-data-detectors]{color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important}@media screen and (max-width:600px){h1{font-size:32px!important;line-height:32px!important}}div[style*='margin: 16px 0;']{margin:0!important}
    </style>
</head>

<body style='background-color:#f4f4f4;margin:0 !important;padding:0 !important;'>
    <div
        style='display:none;font-size:1px;color:#fefefe;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;'>
        Kami senang Anda ada di sini! Bersiaplah untuk menggunakan akun baru Anda.
    </div>

    <table border='0' cellpadding='0' cellspacing='0' width='100%'>
        <tr>
            <td bgcolor='#354da1' align='center'>
                <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width:600px;'>
                    <tr>
                        <td style='padding-bottom:40px;'></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor='#354da1' align='center' style='padding:0px 10px 0px 10px;'>
                <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                    <tr>
                        <td bgcolor='#ffffff' align='center' valign='top'
                            style='padding:40px 20px 20px 20px;border-radius:4px 4px 0px 0px;letter-spacing:4px;line-height:48px;'>
                            <h1 style='color: #111111;font-size:48px;font-weight:bold;margin:0;'>
                                Selamat Datang!
                            </h1>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor='#f4f4f4' align='center' style='padding:0px 10px 0px 10px;'>
                <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width:600px;'>
                    <tr>
                        <td bgcolor='#ffffff' align='left' style='padding:20px 30px 40px 30px;line-height:25px;'>
                            <p style='color:#666666;font-size:18px;font-weight:bold;margin:0;'>
                            Hallo $pengguna
                            <br />
                            <br />
                                Untuk dapat login dengan akun yang telah didaftarkan, anda perlu mengkonfirmasi dengan menggunakan kode di bawah ini.<br /><br />
                                Silahkan salin kode di bawah dan tempelkan di kolom verifikasi NetSwitch.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor='#ffffff' align='left'>
                            <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                                <tr>
                                    <td bgcolor='#ffffff' align='center' style='padding:40px 30px 60px 30px;'>
                                        <table border='0' cellspacing='0' cellpadding='0'>
                                            <tr>
                                                <td align='center' style='border-radius:3px;padding:0 20px 0 20px' bgcolor='#354da1'>
                                                  <h2 style='color: #fff;'>$kode_verifikasi</h2>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor='#ffffff' align='left' style='padding:0px 30px 0px 30px;line-height:25px;'>
                            <p style='color:#666666;font-size: 18px;font-weight:bold;margin:0;'>
                                Jika Anda tidak merasa melakukan pendaftaran dan verifikasi di NetSwitch abaikan email ini dan jangan berikan kode verifikasi ke siapapun (termasuk pihak NetSwitch)
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor='#ffffff' align='left'
                            style='padding:0px 30px 40px 30px;border-radius:0px 0px 4px 4px;line-height:25px;'>
                            <p style='color:#666666;font-size:18px;font-weight:bold;margin:0;'>
                            <br>
                                Terimakasih,<br>
                                
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor='#f4f4f4' align='center' style='padding:30px 10px 0px 10px;'>
                <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width:600px;'>
                    <tr>
                        <td bgcolor='#f4f4f4' align='left' style='padding:0px 30px 30px 30px;line-height:18px;'>
                            <p style='color:#666;font-size:14px;font-weight:bold;margin:0;text-align:center;'>
                                Anda menerima email ini karena Anda baru saja mendaftar untuk akun baru di NetSwitch,<br />
                                <a href='https://celullar.my.id/' target='_blank'
                                    style='color:#111111;text-decoration:none;'>Lihat di Browser</a>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor='#f4f4f4' align='left'
                            style='padding:0px 30px 30px 30px;color:#666666;font-size:14px;font-weight:bold;line-height:18px;'>
                            <p style='margin:0;text-align:center;'>
                                Made with <i class='fa fa-heart' style='color:red;'></i> by NetSwitch
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>");
	        
	        if ($mail->Send());              
	                    if ($conn->query("INSERT INTO users VALUES ('', '$nama_depan', '$nama_belakang', '$nama_depan $nama_belakang', '$email', '$username', '$hash_password', '0', '0', '0', 'Member', 'Aktif', 'Belum Verifikasi', '$pin', '$api_key', 'Pendaftaran Gratis', '$user_reff', '$date', '$time', '0', '$no_hp', '$kode_verifikasi', 'JP-$kode_ref', '', '0', '')") == true) {
                        $conn->query("INSERT INTO ip VALUES ('', '$username', '$ip')");
                        $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip, Akun Kamu Berhasil Di Daftarkan, Silahkan Masukan OTP yang Telah dikirimkan ke Email Anda.<script>swal("Berhasil!", "Silahkan Masukan OTP yang Telah dikirimkan ke Email Anda.", "success");</script>');
                        exit(header("Location: ".$config['web']['url']."auth/verification-account"));
                    } else {
                        $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.<script>swal("Ups Gagal!", "Sistem Kami Sedang Mengalami Gangguan.", "error");</script>');
                    }
                }
            }

        require '../lib/header_home.php';

?>

        <!-- Start Page Register -->
        <div class="login-2" style="background-image: url('<?php echo $config['web']['url'] ?>assets/media/bg/');">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-section">
                            <h3>Daftar Akun</h3>
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
                            <div class="login-inner-form">
                                <form class="form-horizontal" role="form" method="POST">
                                    <input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
                                    <div class="row">
                                        <div class="form-group form-box col-md-6 col-12">
                                            <input type="text" class="input-text" placeholder="Nama Depan" name="nama_depan" value="<?php echo $nama_depan; ?>">
                                            <i class="flaticon-user"></i>
                                            <small class="text-danger font-13 pull-right"><?php echo ($error['nama_depan']) ? $error['nama_depan'] : '';?></small>
                                        </div>
                                        <div class="form-group form-box col-md-6 col-12">
                                            <input type="text" class="input-text" placeholder="Nama Belakang" name="nama_belakang" value="<?php echo $nama_belakang; ?>">
                                            <i class="flaticon-user"></i>
                                            <small class="text-danger font-13 pull-right"><?php echo ($error['nama_belakang']) ? $error['nama_belakang'] : '';?></small>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group form-box col-md-6 col-12">
                                            <input type="email" class="input-text" placeholder="Email Aktif" name="email" value="<?php echo $email; ?>">
                                            <i class="flaticon-mail"></i>
                                            <small class="text-danger font-13 pull-right"><?php echo ($error['email']) ? $error['email'] : '';?></small>
                                        </div>
                                        <div class="form-group form-box col-md-6 col-12">
                                            <input type="number" class="input-text" placeholder="Nomor HP" name="no_hp" value="<?php echo $no_hp; ?>">
                                            <i class="fa fa-phone"></i>
                                            <small class="text-danger font-13 pull-right"><?php echo ($error['no_hp']) ? $error['no_hp'] : '';?></small>
                                        </div>
                                    </div>
                                    <div class="form-group form-box">
                                        <input type="text" class="input-text" placeholder="Nama Pengguna" name="username" value="<?php echo $username; ?>">
                                        <i class="flaticon-user"></i>
                                        <small class="text-danger font-13 pull-right"><?php echo ($error['username']) ? $error['username'] : '';?></small>
                                    </div>
                                    <div class="form-group form-box">
                                        <input type="password" class="input-text" placeholder="Kata Sandi" name="password" value="<?php echo $password; ?>">
                                        <i class="flaticon-password"></i>
                                        <small class="text-danger font-13 pull-right"><?php echo ($error['password']) ? $error['password'] : '';?></small>
                                    </div>
                                    <div class="form-group form-box">
                                        <input type="password" class="input-text" placeholder="Konfirmasi Kata Sandi" name="password2" value="<?php echo $password2; ?>">
                                        <i class="flaticon-password"></i>
                                        <small class="text-danger font-13 pull-right"><?php echo ($error['password2']) ? $error['password2'] : '';?></small>
                                    </div>
                                    <div class="form-group form-box">
                                        <input type="number" class="input-text" placeholder="PIN Transaksi Harus 6 Digit" name="pin" value="<?php echo $pin; ?>">
                                        <i class="fa fa-key"></i>
                                        <small class="text-danger font-13 pull-right"><?php echo ($error['pin']) ? $error['pin'] : '';?></small>
                                    </div>
                                    <div class="checkbox clearfix">
                                        <div class="form-check checkbox-theme">
                                            <input class="form-check-input" type="checkbox" value="true" name="accept" id="rememberMe">
                                            <label class="form-check-label" for="rememberMe">
                                                Saya Setuju Dengan Ketentuan Layanan
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group mb-0">
                                        <button type="submit" class="btn btn-primary btn-block" name="daftar">Daftar</button>
                                    </div>
                                    <br />
                                    <p>Sudah Punya Akun?<a href="<?php echo $config['web']['url'] ?>auth/login"> <u>Masuk</u></a></p>
                                    <br>
							        <p><a href="<?php echo $config['web']['url'] ?>dashboard">KEMBALI</a></p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Register -->

<?php
require '../lib/footer_home.php';
?>