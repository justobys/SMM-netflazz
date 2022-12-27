<?php
$config['web']['url'] = $config['web']['url'];
?>
        <!-- Start Content -->
        <div class="kt-container kt-grid__item kt-grid__item--fluid">

        <!-- Start Page API ID Comment -->
        <div class="row">
	        <div class="col-lg-12">
		        <div class="kt-portlet kt-portlet--height-fluid">
			        <div class="kt-portlet__body">
        <h3>Menampilkan ID Komentar</h3>
        <b>URL Permintaan</b>
        <div class="alert alert-elevate alert-primary">
             <?php echo $config['web']['url'] ?>api/id-comment
        </div>
        <div class="table-responsive">
        	<table class="table table-bordered">
        		<tr>
        			<th width="50%">Parameter</th>
        			<th>Keterangan</th>
        		</tr>
        		<tr>
        			<td>link</td>
        			<td>Link Target</td>
        		</tr>
        		<tr>
        			<td>username</td>
        			<td>Username Target</td>
        		</tr>
        	</table>
        </div>
        <h4>Contoh Respon Yang Ditampilkan</h4>
            <div class="table-responsive">
        	    <table class="table table-bordered">
        		    <tr>
        			    <th width="50%">Respon Sukses</th>
        			    <th>Respon Gagal</th>
        		    </tr>
        		    <tr>
        			    <td>
        <pre>
        {
        	"id": "123456789",
		"text": "Netflazz.com Terbaik"

        }
        </pre>
        			    </td>
        			    <td>
        <pre>
        {
        	"result": "ID Komentar Tidak Ditemukan"
        }
        </pre>
        <b>Kemungkinan Pesan Yang Ditampilkan:</b>
        <ul>
        	<li>ID Komentar Tidak Ditemukan</li>
        </ul>
        			    </td>
        		    </tr>
        	    </table>
            </div>
        </div>