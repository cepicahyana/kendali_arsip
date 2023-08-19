<?php
$id	 =	$this->input->post("id");
$kode	 =	$this->input->post("kode");
$sts	 =	$this->input->post("sts");
$data	=	$this->db->get_where("data_file",array("id"=>$id))->row();
?> 
<h5>Upload File </h5>
 
<hr>
 <form method="post" action="<?php echo base_url()?>welcome/update_hasil_rakor" id="uploadfilexl" enctype="multipart/form-data">
<table class="entry table-bordered">
<tr>
<td>
  <input type="hidden" name="sts" value="<?php echo $sts;?>">
Nama File </td><td> <input value="<?php echo $data->nama;?>" required type="text"  style='width:100%' name='nama'>
 
</td> </tr>
<tr>
<td>
Upload file</td>
<td>
<input type="file"    name="userfile"  id="userfile"  accept=".JPG,.JPEG,.PNG,.png,.jpg,.jpeg,.ppt,.pptx,.pdf,.docx,.xlsx,.xls"  >
<br>
<br>
<div style="font-size:11px;color:#A52A2A">- Kapasitas upload file max.25MB <br>- type file yang diizinkan : ptx,pdf,docx,xlsx,jpg,png,zip</div>
</td> 
</tr>
</table>

<br>

<input type="hidden" name="id" value="<?php echo $id;?>" >
<input type="hidden" name="kode" value="<?php echo $kode;?>" >
<center id="btn1">
<button    class="btn fa fa-upload btn-primary has-ripple"> Upload file </button>
</center> 
</form>

 

<br>
<br>
<br>
 
 
 