<?php
$id = $this->m_reff->san($this->input->post("id"));
?>
<div class="modal-content">  
	<div class="modal-header">  <h5 class="modal-titles" id="defaultModalLabel"><b>Tambah </b></h5>
		<button type="button" class="close" aria-label="Close" data-dismiss="modal">
			<span aria-hidden="true">×</span>
		</button>
	</div>


	<div class="modal-body" >

		<form  action="javascript:submitForm('modal_edit')" id="modal_edit" url="<?php echo base_url()?>data_master/insert_dr"  method="post" enctype="multipart/form-data">
			<input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName()?>" value="<?php echo $this->m_reff->getToken()?>">
			
			<div class=" pd-sm-20 "  >

				 

				<div class="row row-xs align-items-center mg-b-20">
					<div class="col-md-4">
						<label class="form-label mg-b-0" >Kode</label>
					</div>
					<div class="col-md-8 mg-t-5 mg-md-t-0">
						<input required class="form-control"  name="f[nip]"   placeholder="kode" type="text">
					</div>
				</div>
				<div class="row row-xs align-items-center mg-b-20">
					<div class="col-md-4">
						<label class="form-label mg-b-0">Nama dokter </label>
					</div>
					<div class="col-md-8 mg-t-5 mg-md-t-0">
						<input class="form-control" required name='f[nama]'   placeholder="nama dokter" type="text">
					</div>
				</div>
				<div class="row row-xs align-items-center mg-b-20">
					<div class="col-md-4">
						<label class="form-label mg-b-0">Jenis Kelamin </label>
					</div>
					<div class="col-md-4 mg-t-5 mg-md-t-0">
						<div class="form-check">
						  <input class="form-check-input" type="radio" name="f[jk]" id="exampleRadios1" value="l"  >
						  <label class="form-check-label" for="exampleRadios1">
						    Laki-laki
						  </label>
						</div>
					</div>
					<div class="col-md-4 mg-t-5 mg-md-t-0">
						<div class="form-check">
						  <input class="form-check-input" type="radio" name="f[jk]" id="exampleRadios2" value="p">
						  <label class="form-check-label" for="exampleRadios2">
						    Perempuan
						  </label>
						</div>
					</div>
				</div>
				<div class="row row-xs align-items-center mg-b-20">
					<div class="col-md-4">
						<label class="form-label mg-b-0">Telp </label>
					</div>
					<div class="col-md-8 mg-t-5 mg-md-t-0">
						<input class="form-control" required name='f[telp]'  placeholder="telp" type="text">
					</div>
				</div>
				<div class="row row-xs align-items-center mg-b-20">
					<div class="col-md-4">
						<label class="form-label mg-b-0">Email </label>
					</div>
					<div class="col-md-8 mg-t-5 mg-md-t-0">
						<input class="form-control" required name='f[email]'   placeholder="email" type="email">
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
