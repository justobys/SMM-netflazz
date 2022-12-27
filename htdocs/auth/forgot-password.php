<?php
session_start();
require("../config.php");
require("../lib/class.phpmailer.php");
$tipe = "Lupa Kata Sandi";

        if (isset($_POST['lupa'])) {
            $email = $conn->real_escape_string(filter(trim($_POST['email'])));

            $cek_pengguna = $conn->query("SELECT * FROM users WHERE email = '$email'");
            $cek_pengguna_ulang = mysqli_num_rows($cek_pengguna);
            $data_pengguna = mysqli_fetch_assoc($cek_pengguna);

            $error = array();
            if (empty($email)) {
    		    $error ['email'] = '*Tidak Boleh Kosong';
            } else if ($cek_pengguna_ulang == 0) {
    		    $error ['email'] = '*Email Tidak Ditemukan';
            } else {

            $acakin_password = acak(10).acak_nomor(10);
            $hash_pass = password_hash($acakin_password, PASSWORD_DEFAULT);

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
            $mail->Subject = "Lupa Kata Sandi Akun"; //subyek email
            $mail->AddAddress("$email","");  //tujuan email
            $mail->MsgHTML("Lupa Kata Sandi Akun<br><br><b>Email : $email<br><br>Kata Sandi Baru : $acakin_password<b><br><br>Silahkan Masuk Dengan Menggunakan Kata Sandi Baru Anda dan Ubah Kata Sandi Di pengaturan Akun. Terima Kasih!");
            if ($mail->Send());
                if ($conn->query("UPDATE users SET password = '$hash_pass', random_kode = '$acakin_password' WHERE username = '".$data_pengguna['username']."'") == true) {
                    $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip, Kata Sandi Baru Telah Dikirim Ke Email Kamu.<script>swal("Berhasil!", "Kata Sandi Baru Telah Dikirim Ke Email Kamu.", "success");</script>');
                } else {
                    $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.<script>swal("Ups Gagal!", "Sistem Kami Sedang Mengalami Gangguan.", "error");</script>');    
                }
            }
        }

        require '../lib/header_home.php';

?>

        <!-- Start Page Forgot Password -->
        <div class="login-2" style="background-image: url('');">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-section">
                            <h3>Lupa Kata Sandi</h3>
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
                                        <input type="email" class="input-text" placeholder="Masukkan Email" name="email" value="<?php echo $email; ?>">
                                        <i class="flaticon-mail"></i>
                                        <small class="text-danger font-13 pull-right"><?php echo ($error['email']) ? $error['email'] : '';?></small>
                                    </div>
                                    <div class="form-group mb-0">
                                        <button type="submit" class="btn btn-primary btn-block" name="lupa">Submit</button>
                                    </div>
                                    <br />
                                    <p>Sudah Punya Akun ?<a class="text-primary" href="<?php echo $config['web']['url'] ?>auth/login"> <strong>Masuk</strong></a></p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Forgot Password -->

<?php
require '../lib/footer_home.php';
?>