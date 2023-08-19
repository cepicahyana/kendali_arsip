<?php
$id = $this->m_reff->san($this->input->post("id"));
$data = $this->db->get_where("admin",array("id_admin"=>$id))->row();
if(!isset($data->id_admin)){
	return false;
}
$nama = $data->owner ?? '';
$jk = $data->jk ?? '';
$alamat = $data->alamat ?? '';
$telp = $data->telp ?? '';
$email = $data->email ?? '';
$kode_istana = $data->kode_istana;
$kode_biro = $data->kode_biro;
$nip = $data->nip;
?>

<div class="modal-content">  
	<div class="modal-header">  <h5 class="modal-titles" id="defaultModalLabel"><b>Tambah </b></h5>
		<button type="button" class="close" aria-label="Close" data-dismiss="modal">
			<span aria-hidden="true">×</span>
		</button>
	</div>


	<div class="modal-body" >

		<form  action="javascript:submitForm('modal_edit')" id="modal_edit" url="<?php echo base_url()?>akun_data/update_akun_admin"  method="post" enctype="multipart/form-data">
			<input type="hidden" value="<?php echo $id?>" name="id">
			<input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName()?>" value="<?php echo $this->m_reff->getToken()?>">
			
			<div class=" pd-sm-20 "  >
			<div class="row row-xs align-items-center mg-b-20">
					<div class="col-md-4">
						<label class="form-label mg-b-0">NIP </label>
					</div>
					<div class="col-md-8 mg-t-5 mg-md-t-0">
						<input class="form-control"   name='f[nip]'  placeholder="nip" type="text" value="<?= $nip; ?>">
					</div>
				</div>

			 
                <div class="row row-xs align-items-center mg-b-20">
					<div class="col-md-4">
						<label class="form-label mg-b-0">Nama </label>
					</div>
					<div class="col-md-8 mg-t-5 mg-md-t-0">
						<input class="form-control"   name='f[owner]'  placeholder="nama" type="text" value="<?= $nama; ?>">
					</div>
				</div>

				<div class="row row-xs align-items-center mg-b-20">
					<div class="col-md-4">
						<label class="form-label mg-b-0">Jenis Kelamin </label>
					</div>
					<div class="col-md-3 mg-t-5 mg-md-t-0">
						<div class="form-check">
						  <input class="form-check-input" type="radio" name="f[jk]" id="exampleRadios1" value="l" <?php if($jk=='l'){ ?> checked=checked <?php } ?>>
						  <label class="form-check-label" for="exampleRadios1">
						    Laki-laki
						  </label>
						</div>
					</div>
					<div class="col-md-2 mg-t-5 mg-md-t-0">
						<div class="form-check">
						  <input class="form-check-input" type="radio" name="f[jk]" id="exampleRadios2" value="p" <?php if($jk=='p'){ ?> checked=checked <?php } ?>>
						  <label class="form-check-label" for="exampleRadios2">
						    Perempuan
						  </label>
						</div>
					</div>
				</div>

				<!-- <div class="row row-xs align-items-center mg-b-20">
					<div class="col-md-4">
						<label class="form-label mg-b-0">Alamat </label>
					</div>
					<div class="col-md-8 mg-t-5 mg-md-t-0">
						<input class="form-control"   name='f[alamat]'  placeholder="alamat" type="text" value="<?= $alamat; ?>">
					</div>
				</div> -->
				<div class="row row-xs align-items-center mg-b-20">
					<div class="col-md-4">
						<label class="form-label mg-b-0">No. Telepon </label>
					</div>
					<div class="col-md-8 mg-t-5 mg-md-t-0">
						<input class="form-control"   name='f[telp]'   placeholder="nomor telepon" type="text" value="<?= $telp; ?>">
					</div>
				</div>
				<div class="row row-xs align-items-center mg-b-20">
					<div class="col-md-4">
						<label class="form-label mg-b-0">Email </label>
					</div>
					<div class="col-md-8 mg-t-5 mg-md-t-0">
						<input class="form-control"   name='f[email]'   placeholder="email" type="email" value="<?= $email; ?>">
					</div>
				</div>

				<hr>
			 

				<button  onclick="submitForm('modal_edit')"  
				class="float-right btn btn-primary pd-x-30 mg-r-5 mg-t-5"><i class='fa fa-save'></i> Simpan</button>

			</div>   
			<!-- /row -->
		</form>

	</div>
</div>

<script>
function dataBiro(id) {
	if(id==1){
    $("#dataBiro").removeAttr("hidden");
	}else {
	$("#dataBiro").attr("hidden",true);
	}
}
</script>