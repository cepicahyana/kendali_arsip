
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
	$nip=$this->m_reff->san($this->input->get_post("nip"));
	$periode=$this->m_reff->san($this->input->get_post("periode"));
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
					$this->db->where("id!=",7);
		$dbja	=	$this->db->get("tr_jenis_absen")->result();
		$ja		=	array();
		$ja[null] = "----";
		foreach($dbja as $dbja){
			$ja[$dbja->id] = $dbja->nama;
		}
		
		$row = "";
		for($i=0;$i<$jml;$i++){
			$n=$n=$this->tanggal->tambah_tgl($tgl1o,$i);
			$tgl    =   $this->tanggal->tambah_tgl($tgl1o,$i);
			$db     =   $this->mdl->cekAbsenFinger($dataDB->nip,$tgl);	
            $hasil  =   isset($db->jenis_absen)?($db->jenis_absen):null;
			$nip    =   $dataDB->nip;

		
			
			$dropdown = form_dropdown("jenis_absen",$ja, $hasil," style='none' onchange='setJenisAbsen(`".$tgl."`,`".$nip."`,this.value,`".$i."`)' ");
			$row.= "<tr>";
			
			//  if($hasil<=3 and $hasil!=null){	 
				$hasilDB = "<td>".$this->tanggal->hariLengkap($n,"/")."</td>
				<td>".$dropdown."</td> ";
				$jam_masuk 		  = isset($db->jam_masuk)?($db->jam_masuk):null;
				$jam_pulang 	  = isset($db->jam_pulang)?($db->jam_pulang):null;
				$lama_bekerja 	  = isset($db->lama_bekerja)?($db->lama_bekerja):null;
				$lembur_terhitung = isset($db->lembur_terhitung)?($db->lembur_terhitung):null;
			
				
			     $hasilDB.='<td style=""> <input id="masuk'.$i.'" size="7" onchange="revAbsen(`'.$nip.'`,`'.$tgl.'`,`'.$i.'`)" type="time" type="text" value="'.substr($jam_masuk,0,5).'"></td>
			             <td style=""><input id="pulang'.$i.'"  type="time" size="7" onchange="revAbsen(`'.$nip.'`,`'.$tgl.'`,`'.$i.'`)" type="text" value="'.substr($jam_pulang,0,5).'"> </td>
			             <td style=""><input id="lembur'.$i.'"   size="7" onchange="setLembur(`'.$nip.'`,`'.$tgl.'`,this.value)" type="text" value="'.substr($lembur_terhitung,0,5).'"> </td>
			             ';
			    $kolom=2+$kolom;
			 	$efektif++;

			//  }else{
			// 	$hasilDB= "<td>".date("d/m/Y", strtotime($n))."</td>";
			// 	$hasilDB.='<td colspan="4"> </td>'; 
			//  }
 
			 
		 
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
					<td>Rp ".number_format($this->mdl->uLembur($nip,$tgl1o,$tgl2o),0,",",".")." <br>(total: ".$this->mdl->jmlLemburJam($nip,$periode). " Jam - dihitung: ".$this->mdl->jmlLemburJamTerhitung($nip,$periode)." Jam)</td>
				</tr>
				<tr>
					<td>KATEGORI</td>
					<td>:</td>
					<td> </td>
					<td>UANG MAKAN</td>
					<td>:</td>
                    <td>Rp ".number_format($this->mdl->uMakan($nip,$tgl1o,$tgl2o),0,",",".")." <br>(".$this->mdl->jmlMakanJam($nip,$periode). " Hari)</td>
				</tr>
			</table>
            <hr>
			<table border='0' class='entry table' width='100%'  >
				<thead>
					<th width='150'>Tanggal</th>
					<th width='100'>Absen</th>
					<th width='100'>Masuk</th>
					<th width='100'>Pulang</th>
					<th width='100'>Lembur (jam)</th>
				</thead>
				".$row."
			</table>
		</page>
		";
	// }
?>
