<?php
    if (!isset($_SESSION['user'])) {
        $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Silahkan Masuk Terlebih Dahulu.');
        exit(header("Location: ".$config['web']['url']."auth/login"));
    }
if (isset($_SESSION['user'])) {
    $check_user = $conn->query("SELECT * FROM users WHERE username = '".$_SESSION['user']['username']."' AND level = 'Developers'");
    $data_user = $check_user->fetch_assoc();
    $check_username = $check_user->num_rows;
    if ($check_username == 0) {
        $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Dilarang Mengakses');    
        exit(header("Location: ".$config['web']['url']));
    }    
	$sess_username = $_SESSION['user']['username'];
}