<?php
session_start();
require '../config.php';
require '../lib/session_login_admin.php';

        if (isset($_POST['tambah'])) {
            $kategori = $conn->real_escape_string(trim($_POST['kategori']));
            $title = $conn->real_escape_string(trim($_POST['title']));
            $tipe = $conn->real_escape_string(trim($_POST['tipe']));
            $konten = $conn->real_escape_string(trim($_POST['konten']));

            if (!$kategori || !$title || !$tipe || !$konten) {
                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Mohon Mengisi Semua Input.');
            } else {

                $insert = $conn->query("INSERT INTO berita VALUES ('', '$date', '$time', '$kategori', '$title', '$tipe', '$konten')");
                $update_user = $conn->query("UPDATE users SET read_news = '0'");
                if ($insert == TRUE) {
                    $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip, Berhasil Menambahkan Berita Baru.');
                } else {
                    $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.<script>swal("Ups Gagal!", "Sistem Kami Sedang Mengalami Gangguan.", "error");</script>');
                }
            }

        } else if (isset($_POST['ubah'])) {
            $post_id = $conn->real_escape_string($_POST['id']);
            $kategori = $conn->real_escape_string(trim($_POST['kategori']));
            $title = $conn->real_escape_string(trim($_POST['title']));
            $tipe = $conn->real_escape_string(trim($_POST['tipe']));
            $konten = $conn->real_escape_string(trim($_POST['konten']));

            $cek_berita = $conn->query("SELECT * FROM berita WHERE id = '$post_id'");

            if ($cek_berita->num_rows == 0) {
                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Data Tidak Di Temukan.');                                   
            } else {

                $update = $conn->query("UPDATE berita SET icon = '$kategori', title = '$title', tipe = '$tipe', konten = '$konten' WHERE id = '$post_id'");
                if ($update == TRUE) {
                    $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip, Berita Berhasil Di Ubah.');
                } else {
                    $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.<script>swal("Ups Gagal!", "Sistem Kami Sedang Mengalami Gangguan.", "error");</script>');
                }
            }

        } else if (isset($_POST['hapus'])) {
            $post_id = $conn->real_escape_string($_POST['id']);

            $cek_berita = $conn->query("SELECT * FROM berita WHERE id = '$post_id'");

            if ($cek_berita->num_rows == 0) {
                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Data Tidak Di Temukan.');
            } else {

                $delete = $conn->query("DELETE FROM berita WHERE id = '$post_id'");
                if ($delete == TRUE) {
                    $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip, Berita Berhasil Di Hapus.');
                } else {
                    $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.<script>swal("Ups Gagal!", "Sistem Kami Sedang Mengalami Gangguan.", "error");</script>');
                }
            }
        }

        require '../lib/header_admin.php';

?>
<div class="row">
	        <div class="col-lg-12">
		        <div class="kt-portlet">
			        <div class="kt-portlet__head">
				        <div class="kt-portlet__head-label">
<div class="content-wrapper">
   <section class="content">
    <a href="tambah_artikel.php" name="simpan" class="btn btn-success">Tambah Data</a>
        <h3>Tabel Data Artikel</h3>
            <div class="well">  
                <table id="muzakki" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nomor</th>
                            <th>Judul Artikel</th>
                            <th>Isi Artikel</th>
                            <th>Gambar</th>
                            
                            <th>Nama Mustahiq</th>
                            <th>Nama Penginput</th>
                            <th>Edit</th>
                            <th>Hapus</th>
                        </tr>
                    </thead>
                     <tbody>
                      <?php
                      $no = 1;
                      while ($a = mysqli_fetch_assoc($result)) {
                      
                      ?>
     
                    <tr>
                        <td><?php echo  $no;?></td>
                        <td><?php echo  $a['judul_artikel']; ?></td>                      
                        <td><?php echo  substr($a['isi_artikel'],0,50); ?>......</td>
                        <td><a href="<?php echo  $a['gambar']; ?>">Lihat Gambar</a></td>
                        
                        <td><?php echo $a['nama_mustahiq'];?></td>
                        <td><?php echo $a['nama_admin'];?></td>
                        <td><a href="edit_artikel.php?id=<?= $a['id_artikel'];?>" name="simpan" class="btn btn-primary">Edit</td>
                        <td><a href="hapus_artikel.php?id=<?= $a['id_artikel'];?>" onclick="return confirm('Data akan dihapus ?')" name="simpan" class="btn btn-danger">Hapus</td>
                    </tr>
                        <?php
                        $no++;
                        }
                        ?>
                    </tbody>
                </table>  
            </div>
   </section>
</div>
</div>
</div>
</div>
</div>
</div>

        <script src="media/js/jquery.dataTables.min.js"></script>
        <script src="media/js/dataTables.bootstrap.js"></script>
        <script>
            $(document).ready( function () {
          $('#muzakki').DataTable({
            responsive:true
          });
      } );
        </script> 

<?php
require '../lib/footer_admin.php';
?>