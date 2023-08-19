<?php
$kode	 =	$this->input->post("kode");
$sts	 =	$this->input->post("sts");
?> 
<h5>Upload File </h5>
 
<hr>
 <form method="post" action="<?php echo base_url()?>welcome/save_hasil_rakor" id="uploadfilexl" enctype="multipart/form-data">
<table class="entry table-bordered">
<tr>
<td>
 <input type="hidden" name="sts" value="<?php echo $sts;?>">
Nama File </td><td> <input required type="text" accept=".JPG,.JPEG,.PNG,.png,.jpg,.jpeg,.ppt,.pptx,.pdf,.docx,.xlsx,.xls" style='width:100%' name='nama'>
 
</td> </tr>
<tr>
<td>
Upload file</td>
<td>
<input type="file" required  name="userfile"  id="userfile"    >
<br>
<br>
<div style="font-size:11px;color:#A52A2A">- Kapasitas upload file max.25MB <br>- type file yang diizinkan : ptx,pdf,docx,xlsx,jpg,png,zip</div>
</td> 
</tr>
</table>

<br>

<input type="hidden" name="kode" value="<?php echo $kode;?>" >
<center id="btn1">
<button    class="btn fa fa-upload btn-primary has-ripple"> Upload file </button>
</center> 
</form>

 

<br>
<br>
<br>
 
 
 