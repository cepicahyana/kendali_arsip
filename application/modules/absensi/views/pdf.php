<?php		
$mpdf = new \Mpdf\Mpdf();
$mpdf->SetDisplayMode('fullpage');

$html = '
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>
<style>
	table{
		font-family: Arial, Helvetica, sans-serif;
	}
	#tabelAtas, td{
		font-size: 11px;
		padding: 0 5px 0 5px;
	#tabelBawah{
		font-size: 11px;
	}
	th{
		background: #0fb3c2;
		font-size: 11px;
		color: white;
		padding: 0 5px 0 5px;
	}
	table, th, td{
		border: 1px solid black;
		border-collapse: collapse;
	}
</style>
';

$jamSetingMasuk=$this->m_reff->pengaturan(4);  
$nip=$this->input->get_post("nip");
$periode=$this->input->get_post("periode");
$tgl1o=$this->tanggal->range_1($periode);
$tgl1=$this->tanggal->ind($tgl1o,"/");
$tgl2o=$this->tanggal->range_2($periode);
$tgl2=$this->tanggal->ind($tgl2o,"/");
$jml=$this->tanggal->selisih($tgl1o,$tgl2o)+1;

$dataDB=$this->mdl->_getDataPPNPN($nip);
$isi="";$no=1;$row="";

$masuk 		= 0;
$alfa		= 0; 
$kolom		= 0;
$hasilDB	= "";
$efektif 	= 0;
$telat 		= 0;

$row = "";
	
	$html.='
	 
			<table id="tabelAtas" width="100%">
				<tr>
					<td width="50">NAMA</td>
					<td>:</td>
					<td width="250">'.$dataDB->nama.'</td>
					<td>TERLAMBAT</td>
					<td>:</td>
					<td width="270">'.$this->mdl->tTelat($nip,$tgl1o,$tgl2o).' Hari</td>
				</tr>
				<tr>
					<td>NPP</td>
					<td>:</td>
					<td>'.$dataDB->nip.'</td>
					<td>UANG LEMBUR</td>
					<td>:</td>
					<td>Rp '.number_format($this->mdl->uLembur($nip,$tgl1o,$tgl2o),0,",",".").'</td>
				</tr>
				<tr>
					<td>KATEGORI</td>
					<td>:</td>
					<td> </td>
					<td>UANG MAKAN</td>
					<td>:</td>
					<td>Rp '.number_format($this->mdl->uMakan($nip,$tgl1o,$tgl2o),0,",",".").'</td>
				</tr>
			</table>
			<hr width="60%">
			<table id="tabelBawah" width="100%">
				<thead>
				<tr>
					<th>Tanggal</th>
					<th>Absen</th>
					<th>Masuk</th>
					<th>Pulang</th>
					<th>Lama Bekerja</th>
					<th>Telat</th>
					<th>Lembur</th>
					<th>Uang Makan</th>
					<th>Uang Lembur</th>
				</tr>
				</thead>
				<tbody>';
				$jmlLembur=0; $lemburdibayar=0; $jmlUangMakan=0; $jamLembur=0; $uang_makan_perbulan=0; $uang_lembur_perbulan=0; $jam_lembur_perbulan=0;
				for($i=0;$i<$jml;$i++){
					$n=$n=$this->tanggal->tambah_tgl($tgl1o,$i);
					$tgl    =   $this->tanggal->tambah_tgl($tgl1o,$i);
					$db     =   $this->mdl->cekAbsenFinger($dataDB->nip,$tgl);

					$jam_lembur_perbulan += isset($db->lembur_terhitung)?($db->lembur_terhitung):0;
			
					$uang_makan_perbulan += isset($db->n_uang_makan)?($db->n_uang_makan):0;
					// echo $uang_makan_perbulan."<br>";
					
					$uang_lembur_perbulan += isset($db->n_lembur)?($db->n_lembur):0;
					// echo $uang_lembur_perbulan."<br>";

					$hasil  =   isset($db->jenis_absen)?($db->jenis_absen):"";
					$nip    =   $dataDB->nip;
					$numberOfDay = $this->tanggal->toDay($n);

					$row.=
						$html.='<tr>'
					;
					$hasilDB=
						$html.='<td style="text-align: center;">'.$this->tanggal->hariLengkap($n,"/").'</td><td>'.$this->mdl->jenis_absen($hasil).'</td>';
					;
			
					if($hasil==1 or $hasil==2 or $hasil==3){
						$hasilDB.=
						$html.='<td style="text-align: center;"><font style="color:#7CFC00"></font>'.substr($db->jam_masuk,0,5).'</td>
								<td style="text-align: center;"><font color="#7CFC00"></font>'.substr($db->jam_pulang,0,5).' </td>
								<td style="text-align: center;">'.substr($db->lama_bekerja,0,5).'</td>
								<td style="text-align: center;">'.substr($db->telat,0,5).'</td>
								<td style="text-align: center;">'.$db->lembur_terhitung.' jam</td>
								<td style="text-align: right;">Rp.'.number_format($db->n_uang_makan,0,",",".").'<span style="font-size:11px;"></td>
								<td style="text-align: right;">Rp.'.number_format($db->n_lembur,0,",",".").' <span style="font-size:11px;"></td>';
						;
						$kolom=2+$kolom;
						$efektif++;
					}
					elseif($hasil==2){
						$hasilDB.=
						$html.='<td><font color="#F08080"></font>'.$this->mdl->absenDatang($tgl,$nip).'<td>
								<td><font color="#F08080"></font>'.$this->mdl->absenPulang($tgl,$nip).'</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>';
								$alfa++;
						;
						$kolom=2+$kolom;
						$efektif++;
					}
					elseif($hasil==3){
						$hasilDB.=
						$html.='<td style="">Libur</td><td style="background-color:#FAFAD2">Libur</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>';
						;
						$kolom=2+$kolom;
					}
					elseif($hasil==6){
						$hasilDB.=
							$html.='<td style="" colspan="2">Sabtu</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>';
						;
						$kolom=1+$kolom;
					}
					elseif($hasil==7){
						$hasilDB.=
							$html.='<td style="" colspan="2">Minggu</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>';
						;
						$kolom=1+$kolom;
					}
					else{
						$hasilDB.=
							$html.='<td style="" colspan="2">-</td>
							<td></td>
							<td></td>
							<td></td> 
							<td></td> 
							<td></td> ';
						;
						$kolom=2+$kolom;
					}
					
					if($numberOfDay==7){
						$jmlLembur+=isset($db->n_lembur)?($db->n_lembur):0;
						$max = $this->m_umum->max_uang_lembur_perminggu();
						$jmlUangMakan+=isset($db->n_uang_makan)?($db->n_uang_makan):0;
						$nominal_uang_makan = "Rp.".number_format($jmlUangMakan,0,",",".");
						$jamLembur += isset($db->lembur_terhitung)?($db->lembur_terhitung):0;

						if($jmlLembur>$max){
							$jmlLembur = $max;
							$nominal = "<strike>Rp ".number_format($jmlLembur,0,",",".")."</strike> - Rp".number_format($max,0,",",".");
							$lemburdibayar = $max+$lemburdibayar;
						}else{
							$nominal = "Rp.".number_format($jmlLembur,0,",",".");
							$lemburdibayar = $jmlLembur+$lemburdibayar;
						}
						$hasilDB.= $html.='<tr style="background-color:#089bab;">
						<td colspan="6" style="color: #fff;"><b>Rekap lembur perminggu : </b></td>
						<td style="color: white; text-align: center;"><b>'.$jamLembur.' Jam</b></td>
						<td style="color: white; text-align: right;"><b>'.$nominal_uang_makan.'</b></td>
						<td style="color: white; text-align: right;"><b>'.$nominal.'</b></td>
					
						</tr>';
						$jmlLembur=0;
						$jmlUangMakan=0;
						$jamLembur=0;
					}else{
						$jmlUangMakan+=isset($db->n_uang_makan)?($db->n_uang_makan):0;
						$jmlLembur+=isset($db->n_lembur)?($db->n_lembur):0; 
						$jamLembur+= isset($db->lembur_terhitung)?($db->lembur_terhitung):0;
					}
					
						$row.=$hasilDB;
				}

				$row.= $html.='<tr style="background-color:black;">
				<td colspan="6" style="color: #fff;"><b>TOTAL UANG LEMBURAN SESUAI KETENTUAN :</b>
				</td>
				<td style="color: white; text-align: center;"><b>'.$jam_lembur_perbulan.' Jam</b></td>
				<td style="color: white; text-align: right;"><b>Rp.'.number_format($uang_makan_perbulan,0,",",".").'</b></td>
				<td style="color: white; text-align: right;"><b>Rp.'.number_format($lemburdibayar,0,",",".").'</b></td>
				</tr>';
				;

				$html.='
				</tbody>
			</table>
 ';




	
$html .= '</body>
</html>';

$mpdf->WriteHTML($html);
$mpdf->Output();

?>
