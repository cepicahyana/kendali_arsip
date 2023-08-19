<?php
$kode = $this->m_reff->san($this->input->post("kode"));
$kode_utama = $this->m_reff->san($this->input->post("kodut"));
$kondisi = $this->m_reff->san($this->input->post("kondisi"));

$db      = $this->db->get_where("data_test",array("kode"=>$kode))->row();
if(!isset($db)){   return false; }
$isolasi = isset($db->isolasi)?($db->isolasi):"";

?>
	                <div class="modal-content">  
                         <div class="modal-header">  <h5 class="modal-titles" id="defaultModalLabel"><b>Update harian </b></h5>
						<button type="button" class="close" aria-label="Close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
						</button>
                    </div>


                        <div class="modal-body" >
					<center><b>Silahkan pilih sesuai kondisi:</b></center><hr>
					<form  action="javascript:submitForm('modal_kondisi')" 
					id="modal_kondisi" url="<?php echo base_url()?>dpegawai/update_kondisi"  method="post" enctype="multipart/form-data">
 <input type="hidden" name="kondisi" value="<?php echo $kondisi?>">
 <input type="hidden" name="kode" value="<?php echo $kode?>">
 <input type="hidden" name="kode_utama" value="<?php echo $kode_utama?>">
 <input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName()?>" value="<?php echo $this->m_reff->getToken()?>">
<?php
 $data = $this->db->get("tr_indikasi")->result();
foreach($data as $val){
	
echo '<div class="col-lg-12 p-1 alert alert-info"> <label class="ckbox"><input  type="checkbox" name="gejala[]" value="'.$val->id.'"><span  style="line-height:20px">'.$val->indikasi.'</span></label> </div>';
}
?>

<?php
// $data = $this->db->get("tr_gejala")->result();
// foreach($data as $val){
	
// echo '<div class="col-lg-12 p-1"> <label class="ckbox"><input  type="checkbox" name="gejala[]" value="'.$val->nama.'"><span>'.$val->nama.'</span></label> </div>';
// }
?>
<div class="col-lg-12 p-1"> <span>Keluhan yang dirasakan: <textarea type="text" name="f[ket]" class='form-control'></textarea> </span> </div>
<br>
<h5 class="card-titles ">  Isolasi saat ini:</h5>
 
 <div class="pos-relative -mt-2">
 <?php
$data = $this->db->get("tr_isolasi")->result();
foreach($data as $val){

	if($isolasi = $val->kode){
        $cekedisolasi = "checked";
    }else{
        $cekedisolasi = "";
    }

echo '<div class="col-lg-12 p-1"> <label class="rdiobox"><input  '.$cekedisolasi.' required type="radio" name="f[isolasi]" value="'.$val->kode.'"><span>'.$val->nama.'</span></label> </div>';
}?>
<!-- <hr>
<h5>Pilih kelompok kondisi dibawah ini sesuai yang anda rasakan saat ini:</h5>
<div class="alert alert-info">
batuk, flu, demam
</div>
<div class="alert alert-info">
sesak nafas, 
</div> -->
<hr>



<!-- <div class="col-lg-12 p-1"> <span>Lainnya: <input type="text" name="perawatan[]" class='form-control'> </span> </div> -->

</div>


 <!-- <div  onclick="set(`sembuh`)" class="cursor alert alert-outline-info" role="alert"> Sembuh</div> -->
 <div class="col-lg-12 p-1"><center>
<button class="btn btn-success" onclick="submitForm('modal_kondisi')"><i class="fa fa-save"></i> simpan</button>
</center>
</div>

</form>

</div>

</div>


 <script>

function reload_table(){
 
}


					 
 </script>




