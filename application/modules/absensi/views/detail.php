
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

		$row = "";$jmlLembur=0; $lemburdibayar=0; $jmlUangMakan=0; $jamLembur=0; $uang_makan_perbulan=0; $uang_lembur_perbulan=0; $jam_lembur_perbulan=0;

		for($i=0;$i<$jml;$i++){
			$n=$n=$this->tanggal->tambah_tgl($tgl1o,$i);
			$tgl    =   $this->tanggal->tambah_tgl($tgl1o,$i);
			$db     =   $this->mdl->cekAbsenFinger($nip,$tgl);	

			$jam_lembur_perbulan += isset($db->lembur_terhitung)?($db->lembur_terhitung):0;
			
			$uang_makan_perbulan += isset($db->n_uang_makan)?($db->n_uang_makan):0;
			// echo $uang_makan_perbulan."<br>";
			
			$uang_lembur_perbulan += isset($db->n_lembur)?($db->n_lembur):0;
			// echo $uang_lembur_perbulan."<br>";

            $hasil  =   isset($db->jenis_absen)?($db->jenis_absen):"";
			// $nip    =   $dataDB->nip;
			$numberOfDay = $this->tanggal->toDay($n);
			$row .= "<tr>";
			$hasilDB = "<td>".$this->tanggal->hariLengkap($n,"/")."</td>
            <td>".$this->mdl->jenis_absen($hasil)."</td> ";
			
			if($hasil==1 or $hasil==2 or $hasil==3){//ada
			 	   
			     $hasilDB.='<td style="">  '.substr($db->jam_masuk,0,5).'</td>
			             <td style=""> '.substr($db->jam_pulang,0,5).' </td>
                         <td>'.substr($db->lama_bekerja,0,5).'</td>
			             <td>'.substr($db->telat,0,5).'</td>
			             <td>'.$db->lembur_terhitung.' jam <span style="font-size:12px">('.substr($db->lembur,0,5).')</span></td>
                         <td>Rp.'.number_format($db->n_uang_makan,0,",",".").' <span style="font-size:11px"></td>
			             <td>Rp.'.number_format($db->n_lembur,0,",",".").' <span style="font-size:11px"> </td>
			           
                       
			             ';
			    $kolom=2+$kolom;
			 	$efektif++;

			 }
			 elseif($hasil==2){//tidak
			   //  $hasil='<td  style="background-color:#F08080">&#10006;</td>';
			 	//$jamTelat=$this->mdl->selisih($this->mdl->absenPulang($tgl,$nip),$this->mdl->absenDatang($tgl,$nip));
			    $hasilDB.='<td style=""> <font color="#F08080">`</font>'.$this->mdl->absenDatang($tgl,$nip).' </td>
			             <td style=""><font color="#F08080">`</font>'.$this->mdl->absenPulang($tgl,$nip).' </td>
			             <td></td>
			             <td></td>
                         <td></td> 
                         <td></td> 
                         <td></td> 
			             ';
			    $alfa++;
			    $kolom=2+$kolom;
			    $efektif++;
			 }
			 elseif($hasil==3){//libur masuk
			    $hasilDB.='<td style="">Libur</td><td style="background-color:#FAFAD2">Libur</td>
			    			<td></td>
			    			<td></td>
			    			<td></td>
			    			<td></td>
			    			<td></td>
			    ';  
			    $kolom=2+$kolom;
			 }
			 elseif($hasil==6){//   
			   $hasilDB.='<td style="" colspan="2">Sabtu</td>
			   			 <td></td>
			   			 <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
			   ';  
			   $kolom=1+$kolom;
			 }
			 elseif($hasil==7){//   
		       $hasilDB.='<td style="" colspan="2">Minggu</td>
		       				<td></td>
		       				<td></td>
                            <td></td>
                            <td></td>
                            <td></td>
							
		       ';
			    $kolom=1+$kolom;
			 }
			 else{//libur off
			  // $hasilDB='<i class="material-icons col-pink">event</i>';
			    $hasilDB.='<td style="" colspan="2">-</td>
			    			<td></td>
			    			<td></td>
                            <td></td> 
                            <td></td> 
                            <td></td> 
			    ';  
			    $kolom=2+$kolom;
			 }
			 
			 if($numberOfDay==7){
				$jmlLembur+=isset($db->n_lembur)?($db->n_lembur):0;
				$max = $this->m_umum->max_uang_lembur_perminggu();
				
				$jmlUangMakan+=isset($db->n_uang_makan)?($db->n_uang_makan):0;
				$nominal_uang_makan = "Rp.".number_format($jmlUangMakan,0,",",".");

				$jamLembur += isset($db->lembur_terhitung)?($db->lembur_terhitung):0;
				

				if($jmlLembur>$max){
				
					$nominal = "<strike>Rp.".number_format($jmlLembur,0,",",".")."</strike> - Rp".number_format($max,0,",",".");
					$jmlLembur = $max;
					$lemburdibayar = $max+$lemburdibayar;

					
				}else{
					$nominal = "Rp.".number_format($jmlLembur,0,",",".");
					$lemburdibayar = $jmlLembur+$lemburdibayar;
				}
				
				
				$hasilDB.= "<tr style='background-color:#089bab;color:white; text-align: center;'>
				<td colspan='6'><b>Rekap lembur perminggu : </b>
				</td>
				<td>".$jamLembur." Jam</td>
				<td><b>".$nominal_uang_makan."</b></td>
				<td><b>".$nominal."</b></td>
			
				</tr>"; 
				$jmlLembur=0;
				$jmlUangMakan=0;
				$jamLembur=0;
			 }else{
				$jmlUangMakan+=isset($db->n_uang_makan)?($db->n_uang_makan):0;
				$jmlLembur+=isset($db->n_lembur)?($db->n_lembur):0; 
				$jamLembur+= isset($db->lembur_terhitung)?($db->lembur_terhitung):0;
			 }

			 $row.=$hasilDB;
			//  $row.="</tr>";	 
		}


		$row.= "<tr style='background-color:black;color:white'>
		<td colspan='6' class='text-center'><b>TOTAL UANG LEMBURAN SESUAI KETENTUAN :</b> 
		</td>
		<td>".$jam_lembur_perbulan." Jam</td>
		<td class='text-center'><b>Rp.".number_format($uang_makan_perbulan,0,",",".")."</b></td>
		<td class='text-center'><b>Rp.".number_format($lemburdibayar,0,",",".")."</b></td>
		</tr>"; 

		echo "
		
		<a onclick='print_pdf()' class='font14 btn btn-sm btn-light ti-reload text-dark mb-2'>PDF</a>
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
					<td>NPP</td>
					<td>:</td>
					<td>".$dataDB->nip."</td>
					<td>UANG LEMBUR</td>
					<td>:</td>
					<td>Rp ".number_format($this->mdl->uLembur($nip,$tgl1o,$tgl2o),0,",",".")." <br>(total: ".$this->mdl->jmlLemburJam($nip,$periode). " Jam - dihitung: ".$this->mdl->jmlLemburJamTerhitung($nip,$periode)." Jam)
					<br>
					Tervalidasi : Rp.".number_format($lemburdibayar,0,",",".")." <br>
					<i>(Sesuai ketentuan)</i>
					</td>
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


<script>
	function print_pdf(){
		var nip = '<?=$_POST['nip']?>';
		var periode = '<?=$_POST['periode']?>';
		window.location.href = "<?php echo site_url('absensi/printPDF?nip='.$nip.'&periode='.$periode);?>";
	}
</script>