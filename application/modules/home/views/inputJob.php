
<form id="job" action="javascript:submit('job')" method="post" 
		url="<?php echo base_url()?>home/insert_job">

<h2 class="font-700 mb-n1">INPUT PEKERJAAN</h2>
<span class="color-highlight">Dokumentasikan apa yang anda kerjakan</span>
<br><hr>

<div class="input-style has-borders input-style-2 mb-4">
<span class="color-highlight input-style-1-active">Tanggal</span>
<input id="tgl" name="tgl" type="date" value="<?php echo date('Y-m-d')?>" max="<?php echo date('d-m-Y')?>" min="2021-01-01" 
class="form-control validate-text" placeholder="tanggal">
</div>

 
<div class="input-style input-style-2 input-required mb-">
<span class="color-highlight input-style-1-active">Deskripsi pekerjaan</span>
<em>(required)</em>
<textarea class="form-control" required="" name="f[deskripsi]" type="text" value="cepi"></textarea>
</div>


<div class="input-style has-borders input-style-2 mb-4">
<span class="color-highlight input-style-1-active">Jam mulai</span>
<input type="time" value="2030-12-31" name="f[mulai]"  class="form-control validate-text" id="form6" >
</div>

<div class="input-style has-borders input-style-2 mb-4">
<span class="color-highlight input-style-1-active">Jam selesai</span>
<input type="time" value="2030-12-31"   name="f[akhir]"  class="form-control validate-text" id="form6"  >
</div>

 

<button    class="btn btn-3d btn-m btn-full mb-3 btn-block rounded-xs text-uppercase 
font-900 shadow-s  border-blue-dark bg-blue-light sadow"> KONFIRMASI </button>
 
</form>