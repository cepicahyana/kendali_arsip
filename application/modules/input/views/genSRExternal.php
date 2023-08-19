		<!--- Animations css --->
		<link href="<?=base_url() ?>assets/pdfclass/style1.css" rel="stylesheet">
 
 
<?php
$query = $data;
$nama = isset($query->nama)?($query->nama):null;
$tempat_lahir = isset($query->tempat_lahir)?($query->tempat_lahir):null;
$tgl_lahir = isset($query->tgl_lahir)?($query->tgl_lahir):null;
$nik = isset($query->nik)?($query->nik):null;
$id_kab = isset($query->id_kab)?($query->id_kab):null; //for get kabupaten
$no_hp = isset($query->no_hp)?($query->no_hp):null;
$kode_istana = isset($query->kode_istana)?($query->kode_istana):null;
$istana = $this->m_reff->istana($kode_istana);
$kode_biro = isset($query->kode_biro)?($query->kode_biro):null;

 
$getKab = $this->db->get_where('kabupaten',['id_kab'=>$id_kab])->row();
$namaKab = isset($getKab->nama)?($getKab->nama):null;
$path  = $this->m_reff->pengaturan(1);
// $tgl_test = $this->tanggal->eng_($tgl_test,"-");
$tahun = substr($tgl_test,0,4);
$qr    =   $this->konversi->img(realpath($path.$tahun."/qr/".$kode_test.".png")); 
$header    =  $this->m_reff->goField("tr_istana","header","where kode='".$kode_istana."'");
 
$nama_rs = isset($getRS->nama)?($getRS->nama):"";
$alamat_rs = isset($getRS->alamat)?($getRS->alamat):"";


?>
 
		<table class="table">
			<tr>
				<td>
               <img src="<?=base_url('plug/img/'.$header)?>" width="100%">
                </td>
			</tr>
		</table>
 
	 
        <p class="text" align="right"><?php echo str_replace("Istana Kepresidenan","",$istana);?>, <?php echo date('d-m-Y')?><p>
		<table width="625"  class="table">
			<tr>
		       <td>
			       <font size="2">Kpd yth.<br><b><?=$nama_rs?></b><br><?=$alamat_rs?></font>
		       </td>
		    </tr>
		</table>
		<br/>
		<table width="625"  class="table">
			<tr>
		       <td>
			       <font size="2">Dengan Hormat<br>Bersama ini, mohon dilakukan Pemeriksaan Tes covid untuk :</font>
		       </td>
		    </tr>
		</table>
		<br>
	 
		<table  class="table">
			<tr class="text2">
				<td>Nama</td>
				<td width="541"> : <?=$nama;?></td>
			</tr>
			<tr>
				<td>NIK</td>
				<td width="525"> :  <?=$nik;?></td>
			</tr>
			<tr>
				<td>Tempat, Tgl Lahir</td>
				<td width="525"> : <?=$tempat_lahir ?>, <?=$this->tanggal->hariLengkap($tgl_lahir,"/") ?> </td>
			</tr>
			<!-- <tr>
				<td>Usia</td>
				<td width="525">: (...) Tahun</td>
			</tr> -->
			 
			<tr>
				<td>Jadwal tes</td>
				<td width="525"> : <?php echo $this->tanggal->hariLengkap($tgl_test,"/")?></td>
			</tr>
			<tr>
				<td>Jenis tes</td>
				<td width="525"> : <?php echo $jenis_tes?></td>
			</tr>
		</table>
		<br>
		<table width="625"  class="table">
			<tr>
		       <td>
			       <font size="2">Mohon  untuk dilakukan tes covid dengan surat hasil tes mohon diupload pada aplikasi kendali covid.<br>Demikian atas perhatian dan kerja kerja samanya, kami ucapkan terimakasih.</font>
		       </td>
		    </tr>
		</table>
		<br>
		<table width="625"  class="table">
			<tr>
				<td><img src="<?=$qr?>" style="float:left;width:100px;height:100px;"><br>
			&nbsp;&nbsp;<?php echo $kode_test;?></td>
				<td width="450"><br><br><br><br></td>
				<!-- <td class="text" align="center" width="200">Jakarta, 01 Desember 2021<br> -->
                <!-- Pimpinan/pejabat<br><br><br><br>(......................................)</td> -->
			</tr>
	     </table>
 
 
