<style>
td{
    border-bottom:black solid 1px;
    font-size:20px;
    padding-top:10px;
}
</style>
<?php
 

	    
 
$var["isi"]="";
$var["hasil"]="";
$kode=$this->session->userdata("kode");
$tgl_acara=$this->m_reff->goField("data_acara","tgl","where kode='".$kode."' ");
$id=trim($this->input->get_post("v"));
$tgl=$date=date('Y-m-d'); 
 
$this->db->where("qr",$id);
$this->db->where("kode_acara",$kode);


$tglin=date("Y-m-d H:i:s"); 
 
$cek=$this->db->get("data_peserta");
$data=$cek->row();
$sts=isset($data->sts_ikutserta)?($data->sts_ikutserta):"";
$undangan	 =isset($data->jenis)?($data->jenis):"";
$cekin	 	 =isset($data->cekin)?($data->cekin):"";
$sts_hadir	 =isset($data->sts_kehadiran)?($data->sts_kehadiran):"";
//if($undangan==1){ $undangan="Pagi"; }else{ $undangan="Sore"; }
$sstatus=isset($data->status)?($data->status):"";
if($cek->num_rows()) //apakah peserta ada ?
{
			 
	$nama=isset($data->nama)?($data->nama):"";
	$jabatan=isset($data->jabatan)?($data->jabatan):"";
	$alamat=isset($data->alamat)?($data->alamat):""; 
	$blok=isset($data->blok)?($data->blok):"";
	$instansi=isset($data->instansi)?($data->instansi):"";
	//if(!$berlaku){ $berlaku=1; }
	/*------------------------*/
	$titleform="";
             
			$row = array();
		//	$isi="<b>DATA DETAIL REGISTER</b><br> ";
			  if($nama and $jabatan)
			  {
				  $nama_lengkap=$nama." / ".$jabatan;
				  $title="Nama / Penanggung Jawab";
			  }elseif($nama and $jabatan=="")
			  {
				  $nama_lengkap=$nama;
				  $title="Nama";
			  }else{
				   $nama_lengkap=$jabatan;
				   $title="Penanggung Jawab";
			  }
    			$isi=" 			 
				<center>
    			<table class='table' style='text-align:left;color:black;font-weight:bold;width:90%'>";
				if($nama_lengkap){
    			// $isi.="<tr style='text-align:left'><td>".$title."</td><td>:</td><td> ".$nama_lengkap." </td></tr>";
    			$isi.="<tr style='text-align:center'><td   align='center'>  ".$nama."  </td></tr>";
				}
				 if($jabatan){
				 $isi.="<tr style='text-align:center'> <td> ".$jabatan."  </td></tr>";
				 }
				 if($instansi){
				 $isi.="<tr style='text-align:center'><td>  ".$instansi."  </td></tr>";
				 }
				  
			 
				$isi.="</table>";
		 

	if($sts==0 or $sts==null or $sts==3)
	{
					$isi="<center>	<div class='sadow' style='color:red'><h1 style='font-size:40px'  >  TIDAK TERVERIFIKASI  </h1></div>
					<font size='6px'> ".$isi."</font> </div>";
			
			 $var["isi"]=$isi;
			$var["hasil"]="cekal";
	} elseif($sts=="1" or $sts=="2")
	{
			$json=date('Y-m-d H:i:s');///json_decode($data->cekin,true); 
			//$sts_hadir=isset($json[$tgl])?($json[$tgl]):"";
			 
			 if(!$cekin)
			 {
				   
				 	$isi="<center>	<div class='sadow' style='color:green;' ><h1 style='font-size:40px'  >  ✓✓ TERVERIFIKASI </h1></div>
				  <font size='6px'> ".$isi."</font> </div>";
					$var["hasil"]="ok";
					 $var["isi"]=$isi;
					 
					 if($tgl_acara==$tgl){
						$this->api->updateStatusPeserta($id,1);
					 }
			 }else 
			 {
				  
				 	$isi="<center>	<div class='sadow' style='color:green; '><h1 style='font-size:40px;color:green;' > ✓✓ TERVERIFIKASI  </h1></div>
				 <p class='sadosw' style='font-size:35px;color:red'> <b> <span style='font-size:16px'>previous scan<br></span>  ".substr($cekin,10,9)." WIB</b></p>
				 <font size='6px'> ".$isi."</font> </div>";
					$var["hasil"]="ok";
					 $var["isi"]=$isi; 
					 
			 } 
			
			 
			 
	}
	
 
}else
{
$isi="<div class='sadow'><center>
<h1><img width='100px' src='".base_url()."plug/img/warning.png'> <br> <font color='red'>".$id."  <br>TIDAK TERDAFTAR !!</h1> </font> </center></div>";
			 $var["isi"]=$isi;
			 $var["hasil"]="no";
}
echo br().br().$var["isi"]; 
?>
 
<div class="btn-group" role="group" style="bottom:95;position:fixed;width:100%;margin-left:0px">
  <center>
       <a href='back' type="button" style="width:100%;min-height:200px;" class="  btn-lg bg-teal waves-effect">
       <img width='100px' src="<?php echo base_url()?>plug/img/scanicon.png">
       </a>
  </center> 
 
 </div>	    