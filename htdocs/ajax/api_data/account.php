<?php
$config['web']['url'] = $config['web']['url'];
?>
        <!-- Start Content -->
        <div class="kt-container kt-grid__item kt-grid__item--fluid">

        <!-- Start Page API Account Information -->
        <div class="row">
	        <div class="col-lg-12">
		        <div class="kt-portlet kt-portlet--height-fluid">
			        <div class="kt-portlet__body">
        <h3>Menampilkan Data Akun</h3>
        <b>URL Permintaan</b>
        <div class="alert alert-elevate alert-primary">
             <?php echo $config['web']['url'] ?>api/account
        </div>
        <div class="table-responsive">
        	<table class="table table-bordered">
        		<tr>
        			<th width="50%">Parameter</th>
        			<th>Keterangan</th>
        		</tr>
        		<tr>
        			<td>api_key</td>
        			<td>API Key Kamu</td>
        		</tr>
        		<tr>
        			<td>action</td>
        			<td>akun</td>
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
        	"status": true,
        	"data": {
        		"nama_pengguna": "Reseller NetFlazz",
			"sisa_saldo_sosmed": "10000"
			"sisa_saldo_top_up": "10000"

        	}
        }
        </pre>
        			    </td>
        			    <td>
        <pre>
        {
        	"status": false,
        	"data": {
        		"pesan": "API Key Kamu Salah"
        	}
        }
        </pre>
        <b>Kemungkinan Pesan Yang Ditampilkan:</b>
        <ul>
        	<li>Permintaan Tidak Sesuai</li>
        	<li>API Key Kamu Salah</li>
        	<li>Pengguna Tidak Ditemukan</li>
        </ul>
        			    </td>
        		    </tr>
        	    </table>
            </div>
        </div>