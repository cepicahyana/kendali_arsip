<?php
$id = $this->m_reff->san($this->input->post("id"));
$data = $this->db->get_where("tm_rs",array("id"=>$id))->row();
$kode = $data->kode ?? '';
$nama = $data->nama ?? '';
$telp = $data->telp ?? '';
$email = $data->email ?? '';
$alamat = $data->alamat ?? '';
$username = $data->username ?? '';
$id_istana = $data->kode_istana ?? '';
?>
<div class="modal-content">  
	<div class="modal-header">  <h5 class="modal-titles" id="defaultModalLabel"><b>Edit </b></h5>
		<button type="button" class="close" aria-label="Close" data-dismiss="modal">
			<span aria-hidden="true">×</span>
		</button>
	</div>


	<div class="modal-body" >

		<form  action="javascript:submitForm('modal_edit')" id="modal_edit" url="<?php echo base_url()?>data_master/update_rs"  method="post" enctype="multipart/form-data">
			<input type="hidden" value="<?php echo $id?>" name="id">
			<input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName()?>" value="<?php echo $this->m_reff->getToken()?>">

			<div class=" pd-sm-20 "  >

				<div class="row row-xs align-items-center mg-b-20">
					<div class="col-md-4">
						<label class="form-label mg-b-0">Istana</label>
					</div>
					<div class="col-md-8 mg-t-5 mg-md-t-0">
						<?php
	                    $dataIstana=$this->db->get('tr_istana');

	                    $options = array('' => '=== Pilih Istana ===',);
	                    foreach ($dataIstana->result() as $di) {
	                        $options[$di->kode] = $di->istana;
	                    }

	                    $attr = array('class' => 'custom-select', 'id' => 'inputGroupSelect04', 'required' => 'required');
	                    echo form_dropdown('f[kode_istana]', $options, $id_istana, $attr);
	                    unset($options);
	                    unset($attr);
	                    ?>
					</div>
	            </div>

				<div class="row row-xs align-items-center mg-b-20">
					<div class="col-md-4">
						<label class="form-label mg-b-0" >Kode</label>
					</div>
					<div class="col-md-8 mg-t-5 mg-md-t-0">
						<input required class="form-control" value="<?php echo $kode?>"  name="f[kode]"   placeholder="kode" type="text">
					</div>
				</div>
				<div class="row row-xs align-items-center mg-b-20">
					<div class="col-md-4">
						<label class="form-label mg-b-0">Nama rumah sakit </label>
					</div>
					<div class="col-md-8 mg-t-5 mg-md-t-0">
						<input class="form-control" value="<?php echo $nama?>" required name='f[nama]'  placeholder="nama biro" type="text">
					</div>
				</div>
				<div class="row row-xs align-items-center mg-b-20">
					<div class="col-md-4">
						<label class="form-label mg-b-0">Telp </label>
					</div>
					<div class="col-md-8 mg-t-5 mg-md-t-0">
						<input class="form-control" value="<?php echo $telp?>" required name='f[telp]'  placeholder="nama biro" type="text">
					</div>
				</div>
				<div class="row row-xs align-items-center mg-b-20">
					<div class="col-md-4">
						<label class="form-label mg-b-0">Email </label>
					</div>
					<div class="col-md-8 mg-t-5 mg-md-t-0">
						<input class="form-control" value="<?php echo $email?>" required name='f[email]'  placeholder="nama biro" type="email">
					</div>
				</div>
				<div class="row row-xs align-items-center mg-b-20">
					<div class="col-md-4">
						<label class="form-label mg-b-0">Alamat </label>
					</div>
					<div class="col-md-8 mg-t-5 mg-md-t-0">
						<textarea class="form-control" required name='f[alamat]'  placeholder="alamat"><?php echo $alamat?></textarea>
					</div>
				</div>

				<!-- <hr>
				<div class="row row-xs align-items-center mg-b-20">
					<div class="col-md-4">
						<label class="form-label mg-b-0">Username </label>
					</div>
					<div class="col-md-8 mg-t-5 mg-md-t-0">
						<input class="form-control"  required name='f[username]' value="<?php echo $username?>" placeholder="nama biro" type="text">
					</div>
				</div>
				<div class="row row-xs align-items-center mg-b-20">
					<div class="col-md-4">
						<label class="form-label mg-b-0">Password </label>
					</div>
					<div class="col-md-8 mg-t-5 mg-md-t-0">
						<input class="form-control"   name='password'  placeholder="diisi hanya jika akan ganti password" type="text">
					</div>
				</div>
				<div class="row row-xs align-items-center mg-b-20">
					<div class="col-md-4">
						<label class="form-label mg-b-0">Ketik ulang Password </label>
					</div>
					<div class="col-md-8 mg-t-5 mg-md-t-0">
						<input class="form-control"   name='c_password'  placeholder="ketik ulang password" type="text">
					</div>
				</div> -->


				<button  onclick="submitForm('modal_edit')"  
				class="float-right btn btn-primary pd-x-30 mg-r-5 mg-t-5"><i class='fa fa-save'></i> Simpan</button>

			</div>   
			<!-- /row -->
		</form>

	</div>
</div>

