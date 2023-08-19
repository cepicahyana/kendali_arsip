
<style type="text/css">
	.tb {
	  border-collapse: collapse;
	}

		.tb tr td {
		  border: 1px solid black;
		  padding: 5px;
		  text-align: center;
		}
</style>

<?php  
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
?>
<?php
	// foreach($data as $dataDB){ //looping semua ppnpn
		$masuk 		= 0;
		$alfa		= 0; 
		$kolom		= 0;
		$hasilDB	= "";
		$efektif 	= 0;
		//$jamMasuk 	= 0;
		//$jamTelat 	= "";
		$telat 		= 0;

		
		$row = "";
		for($i=0;$i<$jml;$i++){
			$n=$n=$this->tanggal->tambah_tgl($tgl1o,$i);
			$tgl    =   $this->tanggal->tambah_tgl($tgl1o,$i);
			$db     =   $this->mdl->cekAbsenFinger($dataDB->nip,$tgl);	
            $hasil  =   isset($db->jenis_absen)?($db->jenis_absen):"";
			$nip    =   $dataDB->nip;
			$row .= "<tr>";
			$hasilDB = "<td>".date("d/m/Y", strtotime($n))."</td>
            <td>".$this->mdl->jenis_absen($hasil)."</td> ";

		 
			     $hasilDB.='<td style=""> <font color="#7CFC00">`</font>'.substr($db->jam_masuk,0,5).'</td>
			             <td style=""><font color="#7CFC00">`</font>'.substr($db->jam_pulang,0,5).' </td>
                         <td>'.substr($db->lama_bekerja,0,5).'</td>
			             <td>'.substr($db->telat,0,5).'</td>
			             <td>'.substr($db->lembur,0,5).'</td>
                         <td>'.number_format($db->n_uang_makan,0,",",".").'</td>
			             <td>'.number_format($db->n_lembur,0,",",".").'</td>
			           
                       
			             ';
			    $kolom=2+$kolom;
			 	$efektif++;

			 
			 
		 
			 $row.=$hasilDB;
			 $row.="</tr>";	 
		}

		

		echo "
			<page orientation='portrait' >
			<table width='100%' class='entry2'>
				<tr>
					<td width='50'>NAMA</td>
					<td>:</td>
					<td width='250'>".$dataDB->nama."</td>
					<td>TERLAMBAT</td>
					<td>:</td>
					<td width='270'>".$this->mdl->tTelat($nip,$tgl1o,$tgl2o)." Hari</td>
				</tr>
				<tr>
					<td>PIN</td>
					<td>:</td>
					<td>".$dataDB->nip."</td>
					<td>UANG LEMBUR</td>
					<td>:</td>
					<td>Rp ".number_format($this->mdl->uLembur($nip,$tgl1o,$tgl2o),0,",",".")."</td>
				</tr>
				<tr>
					<td>KATEGORI</td>
					<td>:</td>
					<td> </td>
					<td>UANG MAKAN</td>
					<td>:</td>
                    <td>Rp ".number_format($this->mdl->uMakan($nip,$tgl1o,$tgl2o),0,",",".")."</td>
				</tr>
			</table>
            <hr>
			<table border='0' class='entry table' width='100%'  >
				<thead>
					<th width='150'>Tanggal</th>
					<th width='150'>Absen</th>
					<th width='100'>Masuk</th>
					<th width='100'>Pulang</th>
                    <th width='121'>Lama Bekerja</th>
					<th width='130'>Telat</th>
					<th width='130'>Lembur</th>
					<th width='130'>Uang makan</th>
					<th width='130'>Uang lembur</th>
					
				</thead>
				".$row."
			</table>
		</page>
		";
	// }
?>
