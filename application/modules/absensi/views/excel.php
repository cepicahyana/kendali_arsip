<?php
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Data Absensi.xls");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
?>

<?php
	$periode = $_GET['periode'];
	$jk = $_GET['jk'];
	$absen = $_GET['absen'];
	$bidang = $_GET['bidang'];
	$kode_istana = $_GET['kode_istana'];
	$data = array();
	$tgl1o=$this->tanggal->range_1($periode);
	$tgl1=$this->tanggal->ind($tgl1o,"/");
	$tgl2o=$this->tanggal->range_2($periode);
	$tgl2=$this->tanggal->ind($tgl2o,"/");
	$jml=$this->tanggal->selisih($tgl1o,$tgl2o)+1;
	$no = 1;
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Excel</title>

	<style>
		* {
		    font-family: arial;
		    font-size: 14px;
		  }
		table{
			width: 100%;
		}
		table, th, td {
			 
		  	border-collapse: collapse;
		}
		.bg-tile{
			font-weight: bold;
			background: #17a2b8;
			color: white;
		}
		.border-bottom{
			border-bottom: 1px solid black;
		}
		.wfo{
			background-color: #008000;
			color: white;
			text-align: center;
			font-weight: bold;
			font-size: 10px;
		}
		.wfh{
			background-color: #008B8B;
			color: white;
			text-align: center;
			font-weight: bold;
			font-size: 10px;
		}
		.theText{
			text-shadow: 1px 1px black;
		}
		.info{
			color: red;
			font-size: 10px;
		}
		.textCenter{
			text-align: center;
		}
	</style>
</head>
<body>
	<table border="1">
		<thead>
			<tr>
				<th class="bg-tile" rowspan="2">NO</th>
				<th class="bg-tile" rowspan="2">NAMA</th>
				<th class="bg-tile" rowspan="2">BAGIAN</th>
				<!-- <th class="bg-tile" rowspan="2">UANG LEMBUR</th>
				<th class="bg-tile" rowspan="2">UANG MAKAN</th> -->
				<th class='bg-tile'   colspan="<?php echo $jml;?>"  align="center" >PERIODE <?php echo $tgl1. " - ". $tgl2?></th>
                <th class="bg-tile" colspan="2">UANG MAKAN</th>
                <th class="bg-tile" colspan="2">LEMBUR</th>
                <th class="bg-tile" colspan="2">LEMBUR SESUAI KETENTUAN</th>
			</tr>
			<tr> 
				<?php
				for($i=0;$i<$jml;$i++){
					echo '<th align="center" class="bg-teal sadow" style="background:#17a2b8; color: #fff;">'.substr($this->tanggal->tambah_tgl($tgl1o,$i),8,2).'</th> ';
				}
				?>
                <th class="bg-tile">Jam</th>  
                <th class="bg-tile">Uang</th>
                <th class="bg-tile">Jam</th>  
                <th class="bg-tile">Uang</th>
                <th class="bg-tile">Jam</th>  
                <th class="bg-tile">Uang</th>
			</tr>
		</thead>
		<tbody>
			<?php
            $list =  $this->mdl->getDataForExcel($periode, $jk, $absen, $bidang, $kode_istana);
			foreach($list as $dataDB) {
				$absen = $this->mdl->getAbsen($dataDB->nip);
				$jamLembur = $this->mdl->jmlLemburJamTerhitung($dataDB->nip,$periode)?? 0;
				$hariLembur = $this->mdl->jmlMakanJam($dataDB->nip,$periode)?? 0;
				$uangLembur = $this->mdl->jmlLembur($dataDB->nip,$periode)?? 0;
				$uangMakan = $this->mdl->jmlMakan($dataDB->nip,$periode)?? 0;
				$lembur = "Rp.". number_format($uangLembur,0,",",".");
				$makan = "Rp.". number_format($uangMakan,0,",",".");
                $biro = $this->mdl->getNamaBiro($dataDB->kode_biro);



                $jmlLembur=0; $lemburdibayar=0; $jmlJamLembur=0;
            // $nip=44;

            // COBA REKAP PERMINGGU
            for($i=0;$i<$jml;$i++){
                $n=$n=$this->tanggal->tambah_tgl($tgl1o,$i);
                $tgl    =   $this->tanggal->tambah_tgl($tgl1o,$i);
                // $db     =   $this->mdl->cekAbsenFingerExcel($tgl);
                // echo json_encode($db);
                $db     =   $this->mdl->cekAbsenFinger($dataDB->nip,$tgl);	
                $hasil  =   isset($db->jenis_absen)?($db->jenis_absen):"";
                // $nip    =   $dataDB->nip;
                $numberOfDay = $this->tanggal->toDay($n);

                if($numberOfDay==7){
                    $jmlLembur+=isset($db->n_lembur)?($db->n_lembur):0; 
                    $jmlJamLembur+=isset($db->lembur_terhitung)?($db->lembur_terhitung):0; 
                    $max = $this->m_umum->max_uang_lembur_perminggu();
                    if($jmlLembur>$max){
                        $jmlLembur = $max;
                        $lemburdibayar = $max+$lemburdibayar;
                    }else{
                        $lemburdibayar = $jmlLembur+$lemburdibayar;
                    }
                    $jmlLembur=0;
                 }else{
                    $jmlLembur+=isset($db->n_lembur)?($db->n_lembur):0; 
                 }
            }

            $rekapLembur = "Rp.". number_format($lemburdibayar,0,",",".");


            
			?>
			<tr>
				<td><?=$no++;?></td>
				<td><?=$dataDB->nama?>
					<span class="info"><?=$absen?></span>
				</td>
                <td><?=$biro?></td>
				<?php
                    for($i=0;$i<$jml;$i++){
                        $row = $this->mdl->presensiExport($dataDB->nip,$i,$periode);
                        echo "<td style='text-align: center;'>".$row."</td>";
                    }
                ?>
                <td class="textCenter"><?= $hariLembur ?> jam</td>
                <td class="textCenter"><?= $makan ?></td>
                <td class="textCenter"><?= $jamLembur ?> jam</td>
                <td class="textCenter"><?= $lembur ?></td>
                <td class="textCenter"><?= $jamLembur ?> jam</td>
                <td class="textCenter"><?= $rekapLembur ?></td>
			</tr>
            <?php } ?>
			
		</tbody>
	</table>
</body>
</html>

