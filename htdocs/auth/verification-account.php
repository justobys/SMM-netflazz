<?php
session_start();
require("../config.php");
require("../lib/class.phpmailer.php");
$tipe = "Verifikasi Akun";

	    if (isset($_POST['kirim_kode'])) {
	        $email = $conn->real_escape_string(filter($_POST['email']));

	        $cek_pengguna = $conn->query("SELECT * FROM users WHERE email = '$email'");
	        $cek_pengguna_ulang = mysqli_num_rows($cek_pengguna);
	        $data_pengguna = mysqli_fetch_assoc($cek_pengguna);

	        $error = array();
	        if (empty($email)) {
			    $error ['email'] = '*Tidak Boleh Kosong';
	        } else if ($cek_pengguna_ulang == 0 ) {
			    $error ['email'] = '*Email Tidak Ditemukan';
	        } else {

	        if ($data_email['status_akun'] == "Sudah Verifikasi") {
	            $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Akun Kamu Sudah Di Verifikasi.<script>swal("Gagal!", "Akun Kamu Sudah Di Verifikasi.", "error");</script>');

	        } else {

	        $kode_verifikasi = acak_nomor(3).acak_nomor(3);
	        $pengguna = $data_pengguna['username'];

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
	        $mail->Subject = "Verifikasi Akun"; //subyek email
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
                                Silahkan salin kode di bawah dan tempelkan di kolom verifikasi Aplikasi NetSwitch.
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
	            if ($conn->query("UPDATE users SET kode_verifikasi = '$kode_verifikasi' WHERE username = '".$data_pengguna['username']."'") == true) {
                    $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip, Kode Verifikasi Berhasil Dikirim Ke Email Kamu.<script>swal("Berhasil!", "Kode Verifikasi Berhasil Dikirim.", "success");</script>');
                } else {
                    $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.<script>swal("Ups Gagal!", "Sistem Kami Sedang Mengalami Gangguan.", "error");</script>');
                }
            }
        }

	    } else if (isset($_POST['verifikasi'])) {
	        $email = $conn->real_escape_string(filter(trim($_POST['email'])));
	        $kode = $conn->real_escape_string(filter(trim($_POST['kode'])));

            $cek_pengguna = $conn->query("SELECT * FROM users WHERE email = '$email'");
            $cek_pengguna_ulang = mysqli_num_rows($cek_pengguna);
            $data_pengguna = mysqli_fetch_assoc($cek_pengguna);

            $cek_kode = $conn->query("SELECT * FROM users WHERE kode_verifikasi = '$kode'");
            $cek_kode_ulang = mysqli_num_rows($cek_kode);
            $data_kode = mysqli_fetch_assoc($cek_kode);

            $cek_referral = $conn->query("SELECT * FROM setting_referral WHERE status = 'Aktif'");
            $cek_referral_ulang = mysqli_num_rows($cek_referral);
            $data_referral = mysqli_fetch_assoc($cek_referral);

            $error = array();
	        if (empty($email)) {
			    $error ['email'] = '*Tidak Boleh Kosong';
	        } else if ($cek_pengguna_ulang == 0) {
			    $error ['email'] = '*Email Tidak Ditemukan';
	        }
            if (empty($kode)) {
		        $error ['kode'] = '*Tidak Boleh Kosong';
            } else if ($data_pengguna['kode_verifikasi'] <> $kode) {
		        $error ['kode'] = '*Kode Verifikasi Tidak Sesuai';
            } else {

	        if ($data_pengguna['status_akun'] == "Sudah Verifikasi") {
	            $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Akun Kamu Sudah Di Verifikasi.<script>swal("Gagal!", "Akun Kamu Sudah Di Verifikasi.", "error");</script>');

	        } else {

                if ($conn->query("UPDATE users SET status_akun = 'Sudah Verifikasi' WHERE username = '".$data_kode['username']."'") == true) {
                    $conn->query("UPDATE users SET koin = koin+".$data_referral['jumlah']." WHERE username = '".$data_pengguna['uplink_referral']."'");
                    $conn->query("INSERT INTO riwayat_saldo_koin VALUES ('', '".$data_pengguna['uplink_referral']."', 'Koin', 'Penambahan Koin', '".$data_referral['jumlah']."', 'Mendapatkan Koin Melalui Referral Akun Dengan Nama Pengguna :  ".$data_kode['username']."', '$date', '$time')");
                    $conn->query("INSERT INTO riwayat_referral VALUES ('', '".$data_kode['username']."', '".$data_pengguna['uplink_referral']."', '".$data_pengguna['kode_referral']."', '".$data_referral['jumlah']."', '$date', '$time')");
                    $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip, Verifikasi Akun Berhasil, Silahkan Masuk Untuk Melanjutkan Transaksi.<script>swal("Berhasil!", "Akun Kamu Berhasil Di Verifikasi.", "success");</script>');
                } else {
                    $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.<script>swal("Ups Gagal!", "Sistem Kami Sedang Mengalami Gangguan.", "error");</script>');
                }
            }
        }

	    }

        require '../lib/header_home.php';

?>

        <!-- Start Page Verification Account -->
        <div class="login-2" style="background-image: url('');">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-section">
                            <h3>Verifikasi Akun</h3>
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
                                    <div class="form-group form-box">
                                        <input type="email" name="email" class="input-text" placeholder="Masukkan Email Kamu Yang Sudah Terdaftar" value="<?php echo $email; ?>">
                                        <i class="flaticon-email"></i>
                                        <small class="text-danger font-13 pull-right"><?php echo ($error['email']) ? $error['email'] : '';?></small>
                                    </div>
                                    <div class="form-group mb-0">
                                        <button type="submit" class="btn btn-primary btn-block" name="kirim_kode">Kirim Kode</button>
                                    </div>
                                    <br />
                                    <div class="form-group form-box">
                                        <input type="number" name="kode" class="input-text" placeholder="Masukkan Kode Verifikasi">
                                        <i class="flaticon-password"></i>
                                        <small class="text-danger font-13 pull-right"><?php echo ($error['kode']) ? $error['kode'] : '';?></small>
                                    </div>
                                    <div class="form-group mb-0">
                                        <button type="submit" class="btn btn-primary btn-block" name="verifikasi">Verifikasi</button>
                                    </div>
                                    <br />
                                    <p>Sudah Verifikasi Akun ?<a class="text-primary" href="<?php echo $config['web']['url'] ?>auth/login"> <strong>Masuk</strong></a></p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Verification Account -->

<?php
require '../lib/footer_home.php';
?>