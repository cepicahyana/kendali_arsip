 <?php
 $qrcode 	=	$this->m_reff->pengaturan(1).substr($data->tgl,0,4)."/qr/".$data->qrcode.".png";
$db=$data;

 $clinical	=	isset($db->clinical)?($db->clinical):"";
 $clinical	=	str_replace("-","<br/>",$clinical);
 $nik		=	$db->nik;
 $ultah			=	"";
 $gender		=	"";
 //3175082507790012
//  $this->db->where("nik",$nik);
 if($tblpeg=="data_external")
 {
	$tgllahir	=	null;
 }else{
	 $datapeg   = 	$this->db->get($tblpeg)->row();
	 $tgllahir	=	isset($datapeg->tgl_lahir)?($datapeg->tgl_lahir):"";	
	 $ultah		=	$this->tanggal->hitungUsia($tgllahir);
	 $gender	=	isset($datapeg->jk)?($datapeg->jk):"";	
	 if(strtoupper($gender)=="L"){
		 $gender	=	"Male";
	 }else{
		 $gender	=	"Female";
	 }
 }
 ?>
	 <style type="text/css">
		*{margin:2px;}
		body {
		  font-family: 'Open Sans', sans-serif; font-size: 8pt;
		}
		td{
			padding: 2px;
		}
	</style>
 <body>
	<!-- section 1 -->
	<table>
		<tr>
			<td width="300px" valign="top">
         
				<img src="<?=base_url()."plug/rs/bunda/bunda.jpg";?>" width="200px" style="margin: 0 0 0 25px;"/>
			</td>
			<td width="300px" valign="top">
				<img style="margin-top:-40px" src="<?=base_url().'plug/rs/bunda/diagnos.png';?>" width="220px"  >
			</td>
			<td align="right" style="padding-top:0px" valign="top"> 
				<p >
					<b>RSUD Bunda Jakarta</b><br>
					Jl. Teuku Cik Ditiro No. 21<br>
					Menteng - Jakarta Pusat 10350<br>
					Indonesia<br>
					Call Center : 1-500-799
				</p>
				<br>
				<p>
					<b>Clinical Pathologist :</b><br>
					<?php echo $clinical;?>
				</p>
			</td>
		</tr>
	</table>

	<table>
		<tr>
			<td>
				<!-- section 2 -->
				<table class="table" style="margin: 0 0 0 25px;">
					<tr style="border: 1px solid #000; border-collapse: collapse;">
						<td ><b>Name</b></td>
						<td ><b>:</b></td>
						<td ><b><?=$db->nama;?></b></td>
					</tr>
					<tr >
						<td ><b>Laboratory number</b></td>
						<td ><b>:</b></td>
						<td ><b><?=$db->no_lab;?></b></td>
					</tr>
					<tr >
						<td ><b>Customer ID</b></td>
						<td ><b>:</b></td>
						<td ><b><?=$db->cosid;?></b></td>
					</tr>
					<tr >
						<td >Identity</td>
						<td >:</td>
						<td ><?=$kode_test?></td>
					</tr>
					<tr >
						<td >Birth Date / Age</td>
						<td >:</td>
						<td ><?=$ultah?></td>
					</tr>
					<tr >
						<td >Gender</td>
						<td >:</td>
						<td ><?=$gender?></td>
					</tr>
					<tr >
						<td >Address</td>
						<td >:</td>
						<td >-</td>
					</tr>
					<tr >
						<td >Phone / Email</td>
						<td >:</td>
						<td >/</td>
					</tr>
				</table>
			</td>

			<td>
				<!-- section 3 -->
				<table class="table-row" style="margin: 0 0 0 25px;">
					<tr >
						<td >Order Time</td>
						<td >:</td>
						<td ><?=$db->scan_time?></td>
					</tr>
					<tr >
						<td >Sampling Time</td>
						<td >:</td>
						<td ><?=$db->sampling?></td>
					</tr>
					<tr >
						<td >Received Time</td>
						<td >:</td>
						<td ><?=$db->received?></td>
					</tr>
					<tr >
						<td >Referrer</td>
						<td >:</td>
						<td >Sekretariat Presiden RI</td>
					</tr>
					<tr >
						<td >Referrer Address</td>
						<td >:</td>
						<td ></td>
					</tr>
					<tr >
						<td >Doctor</td>
						<td >:</td>
						<td >-</td>
					</tr>
					<tr >
						<td >Clinical Information</td>
						<td >:</td>
						<td >-</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

	<br><br>
	<!-- section 4 -->
	<table style="width:90%;  margin-left: auto; margin-right: auto; border-collapse: separate; border-spacing: 0px;">
		<tr style="font-weight: bold; border-top:1px solid #000; border-bottom:1px solid #000;">
			<th style="border-top:1px solid #000; border-bottom:1px solid #000;text-align: left; padding: 5px;">LABORATORY TEST</th>
			<th style="border-top:1px solid #000; border-bottom:1px solid #000;text-align: left">RESULT</th>
			<th style="border-top:1px solid #000; border-bottom:1px solid #000;text-align: left">REFERENCE VALUE</th>
			<th style="border-top:1px solid #000; border-bottom:1px solid #000;text-align: left">UNIT</th>
			<th style="border-top:1px solid #000; border-bottom:1px solid #000;text-align: left">DESCRIPTION</th>
		</tr>
		<tr>
			<td colspan="4">
				<b>MOLECULAR AND GENOMICS</b><br>
				<small>RT-PCR SARS-CoV-2</small>
			</td>
		</tr>

		<!-- Looping Data -->
		<tr style="">
			<td>Ct Orf-1ab Gene</td>
			<td><?=$db->cto_result?></td>
			<td><?=$db->cto_value?></td>
			<td></td>
			<td></td>
		</tr>
		<tr style="">
			<td>Ct N Gene</td>
			<td><?=$db->ctn_result;?></td>
			<td><?=$db->ctn_value;?></td>
			<td></td>
			<td></td>
		</tr>
		<tr style="">
			<td>Conclusion</td>
			<td><?php
			if($db->hasil=="+"){
				echo "Positif";
			}elseif($db->hasil=="-"){
				echo "Negatif";
			}else{
				echo $db->hasil;
			}
			;?></td>
			<td>
				
			<?php
			if($db->hasil_ref=="+"){
				echo "Positif";
			}elseif($db->hasil_ref=="-"){
				echo "Negatif";
			}else{
				echo $db->hasil_ref;
			}
			
			;?>
		</td>
			<td></td>
			<td></td>
		</tr>
		<!-- /.Looping Data -->

	</table>
	<hr style="width: 90%; border:0; border-top: 1px solid #000; margin-left: auto; margin-right: auto;">
	
	<br>

	<div style="width: 90%; margin-left: auto; margin-right: auto;line-height:1">
		 PCR SARS CoV-2 is a molecular test that detect SARS CoV-2 material in received specimen. <br>
		 PCR SARS CoV-2 merupakan pemeriksaan molekular yang mendeteksi genetik virus SARS CoV-2 dari spesimen. 
 	</div>
<br>
	<div style="width: 90%; margin-left: auto; margin-right: auto;">
		<small>Sample type : Nasopharyngeal & Oropharyngeal Swab</small><br>
		<small>Method &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: Real Time RT-PCR nucleic acid amplifcation test (real time RT-PCR)</small>
	</div>
	
	<!-- footer -->
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    
    <hr style="width: 90%; border:0; border-top: 1px solid #000; margin-left: auto; margin-right: auto;">
	
	<div style="width: 90%;margin-left: auto; margin-right: auto;">
		<small>*This document has been electronically validated</small><br>
		<small>Validation Time : <?php echo $db->validator_time;?> by <?php echo $db->validator;?></small><br>
		<small>Result Created Time :  <?php echo date("d/m/Y H:i:s");?> by KENDALI ISTANA</small>
	</div>

	<!-- page -->
	<!-- <div style="width: 90%; margin-left: auto; margin-right: auto;">
		<p style="text-align: right; z-index: 1;">Page : 1 / 1</p>	
	</div> -->

	<!-- qrcode -->
	<table style="width: 80%; margin-left: 400px; margin-top:-10px;margin-right: auto; z-index: 1;">
		<tr style="text-align:right;">
			<td style="width: 55%;">
				<img src="<?=$qrcode;?>" style="width: 100px;">	
			</td>
			<td width="200px" align="right">
				<img src="<?=base_url().'plug/rs/bunda/bmhs.png';?>" style="width: 120px;">
			</td>
		</tr>
	</table>
	
	<!-- /.footer -->
 
	<!-- logo kanan bawah -->
	<!-- <img src="<?=base_url().'plug/rs/bunda/logo.png';?>" style="margin-top: -70px; margin-left: 465px; width:300px; position: absolute;"> -->
 
</body></html>