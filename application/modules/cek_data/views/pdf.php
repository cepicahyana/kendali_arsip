<?php
$mpdf = new \Mpdf\Mpdf();
$mpdf->SetDisplayMode('fullpage');

// jenis kelamin
if($pegawai->jk = 'l'){
	$jk = 'Laki-laki';
}else{
	$jk = 'Perempuan';
}

// alamat sesuai KTP
$jp = $pegawai->jenis_pegawai;
$provinsi=$kabupaten=$kecamatan=$kabupaten=$kelurahan=null;
if($pegawai->ktp_prov){
    $provinsi = "Provinsi ".$this->m_reff->provinsi($pegawai->ktp_prov);
}
if($pegawai->ktp_kab){
    $kabupaten = "<br>".ucwords(strtolower($this->m_reff->kabupaten($pegawai->ktp_kab)));
}
if($pegawai->ktp_kec){
    $kecamatan = "<br>Kecamatan ".$this->m_reff->kecamatan($pegawai->ktp_kec);
}
if($pegawai->ktp_kel){
    $kelurahan = "<br>Kelurahan ".$this->m_reff->kelurahan($pegawai->ktp_kel);
}
if($pegawai->ktp_alamat){
    echo "<br>".$pegawai->ktp_alamat;
}

$alamatKTP = $provinsi." ".$kabupaten." ".$kecamatan." ".$kelurahan;
// end alamat sesuai KTP

// alamat domisili
if($pegawai->id_prov){
    $provinsi = "Provinsi ".$this->m_reff->provinsi($pegawai->id_prov);
}
if($pegawai->id_kab){
    $kabupaten = "<br>".ucwords(strtolower($this->m_reff->kabupaten($pegawai->id_kab)));
}
if($pegawai->id_kec){
    $kecamatan = "<br>Kecamatan ".$this->m_reff->kecamatan($pegawai->id_kec);
}
if($pegawai->id_kel){
    $kelurahan = "<br>Kelurahan ".$this->m_reff->kelurahan($pegawai->id_kel);
}
if($pegawai->alamat){
    $alamat = "<br>".$pegawai->alamat;
} 

$alamatDomisili = $provinsi." ".$kabupaten." ".$kecamatan." ".$kelurahan;
// end alamat domisili

// usia pensiun
$usia_pensiun = $pegawai->bup;
$usia_pensiun_tambahan =  $pegawai->bup_tambahan;
// end usia pensiun

// Bank
$rek 	= isset($pegawai->no_rek)?($pegawai->no_rek):"";
$bank 	= isset($pegawai->bank)?($pegawai->bank):"";
$anrek 	= isset($pegawai->an_rek)?($pegawai->an_rek):"";
// End Bank

// NIP or NPP
$nip_npp = $pegawai->jenis_pegawai==1?"NIP":"NPP";
// end NIP or NPP
?>

<?php
$html = '<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>

	<style>
	body {
		font-family: arial;
	}
	tr, th, td{
		font-size: 10pt;
	}
	table {
		width: 100%;
	}
	table, tr, th, td{
		border: 1px solid #000;
		border-collapse: collapse;
		padding: 4px;
	}
	.text-center{
		text-align: center;
	}
	.w40 {
		width: 40%;
	}
	.w5 {
		width: 5%;
	}
	.sky_blue{
		background: #d6e0ff;
	}
</style>
</head>
<body>';
?>

<?php
$html.='
	<table>
		<tr>
			<td class="w40">Nama</td>
			<td class="text-center w5">:</td>
			<td>'.$pegawai->nama.'</td>
		</tr>
		<tr>
			<td class="w40">Jenis Kelamin</td>
			<td class="text-center w5">:</td>
			<td>'.$jk.'</td>
		</tr>
		<tr>
			<td class="w40">Tempat, tanggal lahir</td>
			<td class="text-center w5">:</td>
			<td>'.ucfirst($pegawai->tempat_lahir).', '.$pegawai->tgl_lahir.'</td>
		</tr>
		<tr>
			<td class="w40">NIK</td>
			<td class="text-center w5">:</td>
			<td>'.$pegawai->nik.'</td>
		</tr>
		<tr>
			<td class="w40">No HP</td>
			<td class="text-center w5">:</td>
			<td>'.$pegawai->no_hp.'</td>
		</tr>
		<tr>
			<td class="w40">Email</td>
			<td class="text-center w5">:</td>
			<td>'.$pegawai->email.'</td>
		</tr>
		<tr>
			<td class="w40">Gol. Darah</td>
			<td class="text-center w5">:</td>
			<td>'.$pegawai->id_goldar.'</td>
		</tr>
		<tr>
			<td class="w40">Nomor BPJS</td>
			<td class="text-center w5">:</td>
			<td>'.$pegawai->bpjs.'</td>
		</tr>
		<tr>
			<td class="w40">Alamat sesuai KTP</td>
			<td class="text-center w5">:</td>
			<td>'.$alamatKTP.'</td>
		</tr>
		<tr>
			<td class="w40">Alamat sesuai Domisili</td>
			<td class="text-center w5">:</td>
			<td>'.$alamatDomisili.'</td>
		</tr>
	</table>

	<hr>

	<table>
		<tr>
			<td class="w40">Usia</td>
			<td class="text-center w5">:</td>
			<td>'.$this->tanggal->hitungUsia($pegawai->tgl_lahir).'</td>
		</tr>
		<tr>
			<td class="w40">Status Perkawinan</td>
			<td class="text-center w5">:</td>
			<td>'.$pegawai->sts_menikah.'</td>
		</tr>
		<tr>
			<td class="w40">Usia Pensiun</td>
			<td class="text-center w5">:</td>
			<td>'.$usia_pensiun.'</td>
		</tr>
		<tr>
			<td class="w40">Jml anggota keluarga (istri & anak)</td>
			<td class="text-center w5">:</td>
			<td>'.$this->mdl->jmlKeluarga($pegawai->nip,[3,4]).'</td>
		</tr>
		<tr>
			<td class="w40">Jml Penghargaan</td>
			<td class="text-center w5">:</td>
			<td>'.$this->mdl->jmlPenghargaan($pegawai->nip).'</td>
		</tr>
	</table>

	<hr>

	<table>
		<tr>
			<td class="w40">Nomor Rekening</td>
			<td class="text-center w5">:</td>
			<td>'.$rek.'</td>
		</tr>
		<tr>
			<td class="w40">Nama Bank</td>
			<td class="text-center w5">:</td>
			<td>'.$bank.'</td>
		</tr>
		<tr>
			<td class="w40">Atas Nama</td>
			<td class="text-center w5">:</td>
			<td>'.$anrek.'</td>
		</tr>
	</table>

	<br><br>
	
	<table>
		<tr>
			<td colspan="3" class="sky_blue"><b>Data Kepegawaian</b></td>	
		</tr>
	
		<tr>
			<td class="w40">Status keaktifan</td>
			<td class="text-center w5">:</td>
			<td>'.$pegawai->sts_keaktifan.'</td>
		</tr>
		<tr>
			<td class="w40">'.$nip_npp.'</td>
			<td class="text-center w5">:</td>
			<td>'.$pegawai->nip.'</td>
		</tr>
		<tr>
			<td class="w40">Jabatan</td>
			<td class="text-center w5">:</td>
			<td>'.$pegawai->jabatan.'</td>
		</tr>
		<tr>
			<td class="w40">Penugasan jabatan lain</td>
			<td class="text-center w5">:</td>
			<td>'.$pegawai->penjab_lain.'</td>
		</tr>
		<tr>
			<td class="w40">Golongan</td>
			<td class="text-center w5">:</td>
			<td>'.$pegawai->golongan.'</td>
		</tr>
		<tr>
			<td class="w40">Instansi</td>
			<td class="text-center w5">:</td>
			<td>'.$this->m_reff->istana($pegawai->kode_istana).'</td>
		</tr>
		<tr>
			<td class="w40">Deputi</td>
			<td class="text-center w5">:</td>
			<td>'.$this->m_reff->deputi($pegawai->kode_biro).'</td>
		</tr>
		<tr>
			<td class="w40">Biro</td>
			<td class="text-center w5">:</td>
			<td>'.$this->m_reff->biro($pegawai->kode_biro).'</td>
		</tr>
		<tr>
			<td class="w40">Bagian</td>
			<td class="text-center w5">:</td>
			<td>'.$pegawai->bagian.'</td>
		</tr>
		<tr>
			<td class="w40">Subbagian</td>
			<td class="text-center w5">:</td>
			<td>'.$pegawai->subbagian.'</td>
		</tr>
		<tr>
			<td class="w40">No.KARPEG</td>
			<td class="text-center w5">:</td>
			<td>'.$pegawai->karpeg.'</td>
		</tr>
		<tr>
			<td class="w40">TMT setpres</td>
			<td class="text-center w5">:</td>
			<td>'.$pegawai->tmt.'</td>
		</tr>
		<tr>
			<td class="w40">Status Kepegawaian</td>
			<td class="text-center w5">:</td>
			<td>'.$pegawai->sts_kepegawaian.'</td>
		</tr>
		<tr>
			<td class="w40">Batas usia pensiun</td>
			<td class="text-center w5">:</td>
			<td>'.$pegawai->bup.'</td>
		</tr>
		<tr>
			<td class="w40">Batas usia pensiun tambahan</td>
			<td class="text-center w5">:</td>
			<td>'.$pegawai->bup_tambahan.'</td>
		</tr>
		<tr>
			<td class="w40">Batas usia pensiun tambahan</td>
			<td class="text-center w5">:</td>
			<td>'.$pegawai->bup_tambahan.'</td>
		</tr>
	</table>'
;?>



<!-- Keluarga -->
<?php


$nip    =   $pegawai->nip;
$data   =   $this->db->get_where("data_pegawai",["nip"=>$nip])->row();
            $this->db->order_by("id_hubungan","asc");
            $this->db->order_by("tgl_lahir","asc");
$kel    =   $this->db->get_where("data_keluarga",["nip_pegawai"=>$nip])->result();

$html.='
	<br><br>
	<table>
		<thead>
			<tr class="sky_blue">
				<th>No</th>
				<th>Hubungan Keluarga</th>
				<th>Status Hubungan</th>
				<th>Nama</th>
				<th>NIK</th>
				<th>Tempat, tgl lahir</th>
				<th>Pekerjaan</th>
				<th>No BPJS</th>
				<th>Sts</th>
			</tr>
		</thead>
		<tbody>';

		$no = 1;
		foreach($kel as $val){
			$sts_hidup    = ($val->sts_hidup==1)?"Hidup":"meninggal";
			$sts_hubungan = null;
			if($val->sts_hubungan){
			    $sts_hubungan = $val->sts_hubungan;
			}

			$html.='
				<tr>
					<td>'.$no++.'</td>
					<td>'.$this->m_reff->hubungan($val->id_hubungan,$val->jk).'</td>
					<td>'.$sts_hubungan.'</td>
					<td>'.$val->nama.'</td>
					<td>'.$val->nik.'</td>
					<td>'.$val->tempat_lahir.", ".$this->tanggal->ind($val->tgl_lahir,"/").'</td>
					<td>'.$val->pekerjaan.'</td>
					<td>'.$val->bpjs.'</td>
					<td>'.$sts_hidup.'</td>
				</tr>
			';
		}

$html .='
		</tbody>
	</table>';
?>


<!-- Domisili -->
<?php
$nip    =   $pegawai->nip;
$data   =   $this->db->get_where("data_pegawai",["nip"=>$nip])->row();
            $this->db->order_by("id","desc");
$kel    =   $this->db->get_where("tm_domisili",["nip_pegawai"=>$nip])->result();

$html .='
	<br><br>
	<table>
		<tr colspan="7" class="sky_blue">
			<td><b>Domisili saat ini : </b><br>
			'.$alamatDomisili.'
			</td>
		</tr>
	</table>

	<br>

	<table>
		<thead>
			<tr class="sky_blue">
				<th>No</th>
				<th>Status</th>
				<th>Provinsi</th>
				<th>Kab/Kota</th>
				<th>Kecamatan</th>
				<th>Kelurahan</th>
				<th>Alamat</th>
			</tr>
		</thead>
		<tbody>';
		$no = 1;
		foreach($kel as $val){
			$html.='
				<tr>
					<td>'.$no++.'</td>
					<td>'.$val->sts_hunian.'</td>
					<td>'.$this->m_reff->provinsi($val->id_prov).'</td>
					<td>'.$this->m_reff->kabupaten($val->id_kab).'</td>
					<td>'.$this->m_reff->kecamatan($val->id_kec).'</td>
					<td>'.$this->m_reff->kelurahan($val->id_kel).'</td>
					<td>'.$val->alamat.'</td>
				</tr>
			';
		}
$html.='
		</tbody>
	</table>
';

?> 


<!-- Golongan -->
<?php
$nip    =   $pegawai->nip;
$data   =   $this->db->get_where("data_pegawai",["nip"=>$nip])->row();
$golongan =   $this->db->get_where("tm_golongan",["nip_pegawai"=>$nip])->result();

$html .='
	<br><h4>Riwayat golongan</h4>
	<table>
		<thead>
			<tr class="sky_blue">
		      	<th>No</th>
		      	<th>Golongan</th>
		      	<th>Pangkat</th>
		      	<th>TMT</th>
		      	<th>Masa kerja golongan</th>
		      	<th>Jenis kenaikan pangkat</th>
		      	<th>Tanggal SK</th>
		      	<th>No SK</th>
		  
	      	</tr>
	    </thead>
		<tbody>';
		$no = 1;
		foreach($golongan as $val){
		if($val->file){
		    $file  =  $this->m_reff->encrypt("dok/".$data->nip."/".$val->file);
			$lampiran =  ' <a  href="'.base_url().'download?f='.$file.'" class="text-info btn-block"><i class="fa fa-file"></i> File Akta Lahir</a>';
		}else{
			$lampiran = "-";
		} 
			$html.='
				<tr>
					<td>'.$no++.'</td>
					<td>'.$val->golongan.'</td>
					<td>'.$this->m_reff->pangkat($val->golongan).'</td>
					<td>'.$val->tmt.'</td>
					<td>'.$val->masa_kerja.'</td>
					<td>'.$val->jenis_kenaikan_pangkat.'</td>
					<td>'.$val->tgl_sk.'</td>
					<td>'.$val->no_sk.'</td>
				 
				</tr>
			';
		}
$html.='
		</tbody>
	</table>
';?> 


<!-- Jabatan -->
<?php
$nip    =   $pegawai->nip;
$data   =   $this->db->get_where("data_pegawai",["nip"=>$nip])->row();
$list   =   $this->db->get_where("tm_jabatan",["nip_pegawai"=>$nip])->result();

$html .='
	<br><br><h4>Riwayat Jabatan</h4>
	<table>
		<thead>
			<tr class="sky_blue">
		      	<th>No</th>
		      	<th>Jenis Jabatan</th>
              	<th>Nama Jabatan</th>
              	<th>Grade</th>
              	<th>TMT</th>
              	<th>TGL SK JABATAN</th>
              	<th>No.SK JABATAN</th>
              	<th>TGL SK ESELON</th>
              	<th>No.SK ESELON</th>
	      	</tr>
	    </thead>
		<tbody>';
		$no = 1;
		foreach($list as $val){
			if($val->file_sk_jabatan){
				$file  =  $this->m_reff->encrypt("dok/".$data->nip."/".$val->file_sk_jabatan);
				$file_sk_jabatan =  ' <a  href="'.base_url().'download?f='.$file.'" class="text-info btn-block"><i class="fa fa-file"></i>
					'.$val->no_sk_jabatan.'</a>';
					$no_sk_jabatan = $file_sk_jabatan;
			}else{
				$file_sk_jabatan = "-";
				$no_sk_jabatan = $val->no_sk_jabatan;
			} 

			if($val->file_sk_eselon){
			    $file  =  $this->m_reff->encrypt("dok/".$data->nip."/".$val->file_sk_eselon);
			    $file_sk_eselon =  ' <a  href="'.base_url().'download?f='.$file.'" class="text-info btn-block"><i class="fa fa-file"></i>
				    '.$val->no_sk_eselon.'</a>';
			    $no_sk_eselon = $file_sk_eselon;
			}else{
				$file_sk_eselon = "-";
				$no_sk_eselon   = $val->no_sk_eselon;
			}

			$html.='
				<tr>
					<td>'.$no++.'</td>
					<td>'.$val->nama.'</td>
					<td>'.$val->jenis.'</td>
					<td>'.$val->grade.'</td>
					<td>'.$val->tmt.'</td>
					<td>'.$val->tgl_sk_jabatan.'</td>
					<td>'.$no_sk_jabatan.'</td>
					<td>'.$no_sk_eselon.'</td>
					<td>'.$val->tgl_sk_eselon.'</td>
				</tr>
			';
		}
$html.='
		</tbody>
	</table>
';?> 


<!-- Penugasan -->
<?php
$nip    =   $pegawai->nip;
$data   =   $this->db->get_where("data_pegawai",["nip"=>$nip])->row();
            $this->db->order_by("tmt","desc");
$kel    =   $this->db->get_where("tm_penugasan",["nip_pegawai"=>$nip])->result();

$html .='
	<br><h4>Riwayat penugasan</h4>
	<table>
		<thead>
			<tr class="sky_blue">
		      	<th>No</th>
		      	<th>Nama jabatan</th>
              	<th>Penugasan jabatan lainnya</th>
              	<th>TMT</th>
              	<th>TGL SK</th>
              	<th>Nomor SK</th>
              	<th>Masa berlaku</th>
	      	</tr>
	    </thead>
		<tbody>';
		$no = 1;
		foreach($kel as $val){
		$html.='
			<tr>
				<td>'.$no++.'</td>
				<td>'.$val->nama_penjab.'</td>
			    <td>'.$val->penjab_lainnya.'</td>
			    <td>'.$this->tanggal->ind($val->tmt,"/").'</td>
			    <td>'.$this->tanggal->ind($val->tgl_sk,"/").'</td>
			    <td>'.$val->no_sk.'</td>
			    <td>'.$val->masa_berlaku.'</td>
			</tr>
		';
		}
$html.='
		</tbody>
	</table>
';?> 


<!-- Pendidikan & Minat -->
<?php
$nip    =   $pegawai->nip;
$data   =   $this->db->get_where("data_pegawai",["nip"=>$nip])->row();
            $this->db->order_by("id_jenjang","desc");
$kel    =   $this->db->get_where("tm_pendidikan",["nip_pegawai"=>$nip])->result();
$html .='
	<br>
	<h4>Riwayat pendidikan</h4>
	<table>
		<thead>
			<tr class="sky_blue">
		      	<th>No</th>
		      	<th>Nama Istitusi</th>
              	<th>Jenjang</th>
              	<th>Tahun lulus</th>
              	<th>Jurusan</th>
              	<th>IPK/Terakhir</th>
              	<th>Nomor Ijazah</th>
	      	</tr>
	    </thead>
		<tbody>';
		$no = 1;
		foreach($kel as $val){
			if($val->no_ijazah){
       			$file  =  $this->m_reff->encrypt("dok/".$data->nip."/".$val->no_ijazah);
   				$no_ijazah =  ' <a  href="'.base_url().'download?f='.$file.'" class="text-info btn-block"><i class="fa fa-file"></i> '.$val->no_ijazah.'</a>';
    		}else{
     			$no_ijazah = $val->no_ijazah;
    		}
		$html.='
			<tr>
			    <td>'.$no++.'</td>
			    <td>'.$val->istitusi.'</td>
			    <td>'.$this->m_reff->goField('tr_pendidikan','nama','where id="'.$val->id_jenjang.'"').'</td> 
			    <td>'.$val->tahun_lulus.'</td> 
			    <td>'.$val->jurusan.'</td>
			    <td>'.$val->ipk.'</td>
			    <td>'.$val->no_ijazah.'</td>
		    </tr>
		';
		}
$html.='
		</tbody>
	</table>
';?> 


<!-- Keminatan -->
<?php
$nip    =   $pegawai->nip;
$keminatan    =   $this->db->get_where("tm_keminatan",["nip_pegawai"=>$nip])->result();

$html .='
	<br><br>
	<h4>Keminatan</h4>
	<table>
		<thead>
			<tr class="sky_blue">
		      	<th>No</th>
		      	<th>Jenis Keminatan</th>
              	<th>Negara</th>
	      	</tr>
	    </thead>
		<tbody>';
		$no = 1;
		foreach($keminatan as $val){
		$html.='
			<tr>
				<td>'.$no++.'</td>
			    <td>'.$val->jenis_keminatan.'</td>
			    <td>'.$val->negara.'</td>
		    </tr>
		';
		}
$html.='
		</tbody>
	</table>
';?> 


<!-- Pelatihan -->
<?php
$pelatihan    =   $this->db->get_where("tm_pelatihan",["nip_pegawai"=>$nip])->result();

$html .='
	<br>
	<h4>Pelatihan</h4>
	<table>
		<thead>
			<tr class="sky_blue">
		      	<th>No</th>
		      	<th>Jenis pelatihan</th>
				<th>Nama pelatihan</th>
				<th>Tgl pelaksanaan</th>
				<th>Lama pelatihan</th>
				<th>Instansi penyelenggara</th>
				<th>Nomor sertifikat</th>
	      	</tr>
	    </thead>
		<tbody>';
		$no = 1;
		foreach($pelatihan as $val){
		    if($val->no_sertifikat){
		        $file  =  $this->m_reff->encrypt("dok/".$data->nip."/".$val->no_sertifikat);
			    $no_sertifikat =  $val->no_sertifikat;
		    }else{
		    	$no_sertifikat = $val->no_sertifikat;
		    }
		$html.='
			<tr>
				<td>'.$no++.'</td>
			    <td>'.$val->jenis_pelatihan.'</td>
			    <td>'.$val->nama_pelatihan.'</td>
			    <td>'.$val->tgl_pelaksanaan.'</td>
			    <td>'.$val->lama_pelatihan.'</td>
			    <td>'.$val->instansi_penyelenggara.'</td>
			    <td>'.$no_sertifikat.'</td>
		    </tr>
		';
		}
$html.='
		</tbody>
	</table>
';?> 


<!-- Penghargaan -->
<?php
$data   =   $this->db->get_where("data_pegawai",["nip"=>$nip])->row();
$kel    =   $this->db->get_where("tm_penghargaan",["nip_pegawai"=>$nip])->result();

$html .='
	<br><br>
	 
	<h4>Penghargaan</h4>
	<table>
		<thead>
			<tr class="sky_blue">
		      	<th>No</th>
				<th>Jenis penghargaan</th>
                <th>Instansi penyelenggara</th>
                <th>Pemberi penghargaan</th>
                <th>Nomor / ID</th>
                <th>Tangal penerimaan</th>
               
	      	</tr>
	    </thead>
		<tbody>';
		$no = 1;
		foreach($kel as $val){
		    if($val->file){
		        $file  =  $this->m_reff->encrypt("dok/".$data->nip."/".$val->file);
			    $lampiran =  ' <a  href="'.base_url().'download?f='.$file.'" class="text-info btn-block"> download </a>';
		    }else{
			    $lampiran = $val->no_sertifikat;
		    }
		$html.='
			<tr>
				<td>'.$no++.'</td>
			    <td>'.$val->jenis.'</td>
			    <td>'.$val->instansi_pemberi.'</td>
			    <td>'.$val->pemberi_penghargaan.'</td>
			    <td>'.$val->nomor.'</td>
			    <td>'.$this->tanggal->ind($val->tgl,"/").'</td>
			  
		    </tr>
		';
		}
$html.='
		</tbody>
	</table>
';?>


<!-- Penilaian Kinerja -->
<?php
$data   =   $this->db->get_where("data_pegawai",["nip"=>$nip])->row();
$kel    =   $this->db->get_where("tm_penilaian_kinerja",["nip_pegawai"=>$nip])->result();

$html .='
	<br><br>
	<h4>Penilaian</h4>
	<table>
		<thead>
			<tr class="sky_blue">
		      	<th>No</th>
				<th>Tahun</th>
              	<th>Nilai rata-rata</th>
              	<th>Pejabat penilai</th>
              	<th>Atasan pejabat penilai</th>
              	<th>Keterangan</th>
               
	      	</tr>
	    </thead>
		<tbody>';
		$no = 1;
		foreach($kel as $val){
		    if($val->file){
		        $file  =  $this->m_reff->encrypt("dok/".$data->nip."/".$val->file);
			    $lampiran =  ' <a  href="'.base_url().'download?f='.$file.'" class="text-info btn-block"> download </a>';
		    }else{
		    	$lampiran = "-";
		    }
		$html.='
			<tr>
				<td>'.$no++.'</td>
			    <td>'.$val->tahun.'</td>
			    <td>'.$val->nilai.'</td>
			    <td>'.$val->pejabat_penilai.'</td>
			    <td>'.$val->atasan_pejabat_penilai.'</td>
			    <td>'.$val->ket.'</td>
			    
		    </tr>
		';
		}
$html.='
		</tbody>
	</table>
';?>


<!-- Hukuman -->
<?php
$data   =   $this->db->get_where("data_pegawai",["nip"=>$nip])->row();    
$kel    =   $this->db->get_where("tm_hukuman",["nip_pegawai"=>$nip])->result();

$html .='
	<br><br>
	<h4>Hukuman</h4>
	<table>
		<thead>
			<tr class="sky_blue">
		      	<th>No</th>
				<th>Jenis hukuman</th>
                <th>Nomor SK</th>
                <th>TMT akhir hukuman</th>
                <th>Masa berlaku</th>
                <th>No PP</th>
                <th>Potongan (%)</th>
                <th>Pelanggaran yang dilakukan</th>
 
	      	</tr>
	    </thead>
		<tbody>';
		$no = 1;
		foreach($kel as $val){
		    if($val->file){
		        $file  =  $this->m_reff->encrypt("dok/".$data->nip."/".$val->file);
			    $lampiran =  ' <a  href="'.base_url().'download?f='.$file.'" class="text-info btn-block"> download </a>';
		    }else{
			     $lampiran = "-";
		    }
		$html.='
			<tr>
				<td>'.$no++.'</td>
			   	<td>'.$val->jenis_hukuman.'</td>
			   	<td>'.$val->no_sk.'</td>
			   	<td>'.$val->tmt_akhir.'</td>
			   	<td>'.$val->masa_berlaku.'</td>
			   	<td>'.$val->no_pp.'</td>
			   	<td>'.$val->potongan.'</td>
			   	<td>'.$val->pelanggaran.'</td>
		 
		    </tr>
		';
		}
$html.='
		</tbody>
	</table>
';?>


<!-- Rekam Medis -->
<?php
$data   =   $this->db->get_where("data_pegawai",["nip"=>$nip])->row();
$kel    =   $this->db->get_where("tm_medis",["nip_pegawai"=>$nip])->result();

$html .='
	<br>
	<h4>Riwayat Medis</h4>
	<table>
		<thead>
			<tr class="sky_blue">
		      	<th>No</th>
				<th>Tahun dialami</th>
              	<th>Jenis Penyakit</th>
              	<th>Penanganan</th> 
	      	</tr>
	    </thead>
		<tbody>';
		$no = 1;
		foreach($kel as $val){
		$html.='
			<tr>
				<td>'.$no++.'</td>
			    <td>'.$val->tahun.'</td>
			    <td>'.$val->jenis_penyakit.'</td>
			    <td>'.$val->penanganan.'</td>
		    </tr>
		';
		}
$html.='
		</tbody>
	</table>
';?>


<!-- Riwayat Vaksinasi -->
<?php
$vaksin =   $this->db->get_where("tm_vaksin",["nip_pegawai"=>$nip])->result();

$html .='
	<br>
	<h4>Riwayat Vaksinasi</h4>
	<table>
		<thead>
			<tr class="sky_blue">
		      	<th>No</th>
				<th>Tahun dialami</th>
				<th>Jenis vaksin</th>
				<th>Penanganan</th> 
	      	</tr>
	    </thead>
		<tbody>';
		$no = 1;
		foreach($vaksin as $val){
		$html.='
			<tr>
				<td>'.$no++.'</td>
			    <td>'.$val->tgl_vaksin.'</td>
			    <td>'.$val->jenis_vaksin.'</td>
			    <td>'.$val->ket.'</td>
		    </tr>
		';
		}
$html.='
		</tbody>
	</table>
';?>


<!-- Riwayat Tes Covid -->
<?php
$tes    =   $this->db->get_where("v_test",["jenis_pegawai!="=>null,"nip"=>$nip])->result();

$html .='
	<br>
	<h4>Riwayat Tes Covid</h4>
	<table>
		<thead>
			<tr class="sky_blue">
		      	<th>No</th>
				<th>Tanggal test</th>
              	<th>Tempat test</th>
              	<th>Jenis test</th>
              	<th>Hasil test</th> 
	      	</tr>
	    </thead>
		<tbody>';
		$no = 1;
		foreach($tes as $val){
		$html.='
			<tr>
				<td>'.$no++.'</td>
			    <td>'.$val->konfirm_rs.'</td>
			    <td>'.$this->m_reff->tempat_tes($val->kode_tempat).'</td>
			    <td>'.$this->m_reff->jenis_tes($val->kode_jenis).'</td>
			    <td>'.$val->hasil.'</td>
		    </tr>
		';
		}
$html.='
		</tbody>
	</table>
';?>


<!-- Gaji -->
<?php
$data   =   $this->db->get_where("data_pegawai",["nip"=>$nip])->row();
            $this->db->order_by("tmt","desc");
$kel    =   $this->db->get_where("tm_gaji",["nip_pegawai"=>$nip])->result();

$html .='
	<br><br>
	<table>
		<thead>
			<tr class="sky_blue">
		      	<th>No</th>
				<th>Pangkat/golongan</th>
				<th>TMT</th>
				<th>Nomor SK</th>
				<th>MK golongan tahun</th>
				<th>MK golongan bulan</th>
				<th>Gapok lama</th>
				<th>Gapok baru</th>
				<th>Keterangan </th>
	      	</tr>
	    </thead>
		<tbody>';
		$no = 1;
		foreach($kel as $val){
		$html.='
			<tr>
				<td>'.$no++.'</td>
			    <td>'.$this->m_reff->panggol($val->golongan).'</td>
			    <td>'.$val->tmt.'</td> 
			    <td>'.$val->no_sk.'</td>
			    <td>'.$val->mk_gol_tahun.'</td>
			    <td>'.$val->mk_gol_bulan.'</td>
			    <td>'.number_format($val->gapok_lama,0,",",".").'</td>
			    <td>'.number_format($val->gapok_baru,0,",",".").'</td>
			    <td>'.$val->ket.'</td>
		    </tr>
		';
		}
$html.='
		</tbody>
	</table>
';?>


<?php
$html.='
</body>
</html>';
?>

<?php
$mpdf->WriteHTML($html);
$mpdf->Output('Data Pegawai.pdf', 'D');
?>