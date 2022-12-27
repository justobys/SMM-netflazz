<?php
require('config.php');
// --------------------------------------------------------------//
// --------------------------------------------------------------//
//  author , ilman sunannudin
// have any project? you can contact me at https://m-pedia.my.id.
// facebook https://facebook.com/ilman.sn
// PLEASE DO NOT DELETE THIS COPYRIGHT IF YOU ARE A HUMAN.
// ------------------------------------------------------------------//
// ------------------------------------------------------------------//
header('content-type: application/json');
$data = json_decode(file_get_contents('php://input'), true);
file_put_contents('whatsapp.txt', '[' . date('Y-m-d H:i:s') . "]\n" . json_encode($data) . "\n\n", FILE_APPEND);
$message = $data['data']['body']; // ini menangkap pesan masuk
$type = $data['type'];
$from = $data['data']['from']; // ini menangkap nomor pengirim pesan
$nomor = preg_replace('/@c.us/', '', $from); // nomor yang sudah di bersihkan, hanya angka


function beliproduk($db, $nomor)
{
    $data = $db->query("SELECT * FROM data_pembeli WHERE no_hp = '$nomor'");
    if ($data->num_rows > 0) {
        $datapembeli = $data->fetch_array();
        if ($datapembeli['saldo'] < 1000) {
            return 'Maaf saldo kamu tidak cukup, Saldomu berjumlah RP ' . $datapembeli['saldo'] . '';
        }
        $data2 = $db->query("SELECT * FROM data_pembeli WHERE no_hp = '$nomor'");
        $datapembeli = $data2->fetch_array();
        $saldo = $datapembeli['saldo'];
        $ambilproduk = $db->query("SELECT * FROM data_jual WHERE status = 'Belum terjual' ORDER BY RAND() LIMIT 1");
        if ($ambilproduk->num_rows < 1) {
            return 'Maaf produk sedang habis, tunggu kami restock';
        }
        $produk = $ambilproduk->fetch_array();
        $harga = 1000;
        $jumlahsaldototal = $saldo - $harga;
        $kurangisaldo = $db->query("UPDATE data_pembeli SET saldo = '$jumlahsaldototal' WHERE no_hp = '$nomor' ");
        if ($kurangisaldo) {
            $produknya = $produk['produk'];
            $ubah = $db->query("UPDATE data_jual SET status = 'Sudah terjual' WHERE produk ='$produknya'");
            return 'Pembelian berhasil Nomor hp => *' . $produknya . '*';
        } else {
            return 'Pembelian gagal, silahkan hubungi admin';
        }
    } else {
        return 'nomor tidak terdaftar, untuk daftar silahkan ketik *daftar*';
    }
}

function daftar($db, $nomor)
{
    $data = $db->query("SELECT * FROM data_pembeli WHERE no_hp = '$nomor'");
    if ($data->num_rows > 0) {
        return 'Nomor anda = ' . $nomor . ' Sudah terdaftar';
    } else {
        $insert = $db->query("INSERT INTO data_pembeli VALUES('','$nomor','0')");
        if (!$insert) {
            return 'Pendaftaran gagal, silahkan hubungi admin';
        } else {
            return 'Nomor anda *' . $nomor . '* Berhasil di daftarkan, ';
        }
    }
}
if ($type == 'chat') {
    if (strtolower($message) == 'beliproduk') {
        $jawaban = beliproduk($db, $nomor);
        $result = [
            'type' => 'message', // type message = kirim pesan biasa
            'data' => [
                'mode' => 'chat', // mode chat = chat biasa
                'pesan' => $jawaban
            ]
        ];
    } else if (strtolower($message) == 'daftar') {
        $jawaban = daftar($db, $nomor);
        $result = [
            'type' => 'message',  // type message = kirim pesan biasa
            'data' => [
                'mode' => 'chat', // mode reply = reply pessan
                'pesan' => $jawaban
            ]
        ];
    } else if (strtolower($message) == 'gambar') {
        $result = [
            'type' => 'picture', // type picture = kirim pesan gambar
            'data' => [
                'caption' => 'ini picture',
                'url' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRZ2Ox4zgP799q86H56GbPMNWAdQQrfIWD-Mw&usqp=CAU'
            ]
        ];
    }
}
print json_encode($result);


// kami akan memberitahu jika update. :)