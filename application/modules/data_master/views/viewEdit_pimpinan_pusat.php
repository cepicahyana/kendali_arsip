<?php
$id = $this->m_reff->san($this->input->post("id"));
$data = $this->db->get_where("admin",array("id_admin"=>$id))->row();
$nama = $data->owner ?? '';
$jk = $data->jk ?? '';
$alamat = $data->alamat ?? '';
$telp = $data->telp ?? '';
$email = $data->email ?? '';
$id_istana = $data->kode_istana;
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

		<form  action="javascript:submitForm('modal_edit')" id="modal_edit" url="<?php echo base_url()?>data_master/update_pimpinan_pusat"  method="post" enctype="multipart/form-data">
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

				<!-- <div class="row row-xs align-items-center mg-b-20">
					<div class="col-md-4">
						<label class="form-label mg-b-0">Istana</label>
					</div>
					<div class="col-md-8 mg-t-5 mg-md-t-0">
					 
                        $dataIstana=$this->db->get('tr_istana');

                        $options = array('' => '=== Pilih Istana ===',);
                        foreach ($dataIstana->result() as $di) {
                            $options[$di->nama] = $di->nama;
                        }

                        $attr = array('class' => 'custom-select', 'id' => 'inputGroupSelect04', 'required' => 'required', 'onchange'=>'dataBiro(this.value)');
                        echo form_dropdown('f[istana]', $options, $id_istana, $attr);
                        unset($options);
                        unset($attr);
                        ?>
					</div>
                </div> -->

                <!-- <div  (strtolower($id_istana) == "istana kepresidenan jakarta") ? '': 'hidden'; ?> id="dataBiro" class="row row-xs align-items-center mg-b-20">
					<div class="col-md-4">
						<label class="form-label mg-b-0">Biro </label>
					</div>
					<div class="col-md-8 mg-t-5 mg-md-t-0">
					 
                        $dataBiro=$this->db->get('tr_biro');

                        $options = array('' => '=== Pilih Biro ===',);
                        foreach ($dataBiro->result() as $db) {
                            $options[$db->kode] = $db->nama;
                        }

                        $attr = array('class' => 'custom-select', 'id' => 'inputGroupSelect04');
                        echo form_dropdown('f[kode_biro]', $options, $kode_biro, $attr);
                        unset($options);
                        unset($attr);
                        ?>
					</div>
				</div> -->

                <div class="row row-xs align-items-center mg-b-20">
					<div class="col-md-4">
						<label class="form-label mg-b-0">Nama </label>
					</div>
					<div class="col-md-8 mg-t-5 mg-md-t-0">
						<input class="form-control"   name='f[owner]'  placeholder="nama" type="text" value="<?= $nama; ?>">
					</div>
				</div>

				<!-- <div class="row row-xs align-items-center mg-b-20">
					<div class="col-md-4">
						<label class="form-label mg-b-0">Jenis Kelamin </label>
					</div>
					<div class="col-md-2 mg-t-5 mg-md-t-0">
						<div class="form-check">
						  <input class="form-check-input" type="radio" name="f[jk]" id="exampleRadios1" value="l" <?php if($jk=='l'){ ?> checked=checked <?php } ?>>
						  <label class="form-check-label" for="exampleRadios1">
						    L
						  </label>
						</div>
					</div>
					<div class="col-md-2 mg-t-5 mg-md-t-0">
						<div class="form-check">
						  <input class="form-check-input" type="radio" name="f[jk]" id="exampleRadios2" value="p" <?php if($jk=='p'){ ?> checked=checked <?php } ?>>
						  <label class="form-check-label" for="exampleRadios2">
						    P
						  </label>
						</div>
					</div>
				</div> -->

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
	if(id=="<?php echo $this->m_reff->pengaturan(2);?>"){
    $("#dataBiro").removeAttr("hidden");
	}else {
	$("#dataBiro").attr("hidden",true);
	}
}
</script>