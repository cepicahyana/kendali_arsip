<?php
$id = $this->input->post("id");
$data = $this->db->get_where("admin",array("id_admin"=>$id))->row();
$nama = $data->owner ?? '';
$jk = $data->jk ?? '';
$alamat = $data->alamat ?? '';
$telp = $data->telp ?? '';
$email = $data->email ?? '';
$kode_istana = $data->kode_istana;
$kode_biro = $data->kode_biro;
$nip = $data->nip;
?>

<div class="row" id="area_formSubmit">
    <div class="col-md-12">

        <div class="card-block">
            <h5 class="sub-title">Edit    </h5><hr>
                <div class="row">
                    <div class="col-md-12">
                        <form id="formSubmit" action="javascript:submitForm('formSubmit')" method="post" url="<?php echo site_url()?>akun_ppnpn/update_akun_admin">
                        <input type="hidden" value="<?php echo $id?>" name="id">
                        <input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName()?>" value="<?php echo $this->m_reff->getToken()?>">

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="nip">NIP</label>
                            <div class="col-sm-8">
                                <input id="nip" name="f[nip]" class="form-control" value="<?=$nip?>" required>
                            </div>
                        </div> 

                        <!-- <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Istana</label>
                            <div class="col-sm-8">
                          
                                $dataIstana=$this->db->get('tr_istana');

                                $options = array('' => '=== Pilih Istana ===',);
                                foreach ($dataIstana->result() as $di) {
                                    $options[$di->kode] = $di->istana;
                                }

                                $attr = array('class' => 'form-control', 'id' => 'inputGroupSelect04', 'required' => 'required','onchange'=>'dataBiro(this.value)');
                                echo form_dropdown('f[kode_istana]', $options, $kode_istana, $attr);
                                unset($options);
                                unset($attr);
                                ?>
                            </div>
                        </div> -->
<!-- 
                        <div id="dataBiro" class="form-group row">
                            <label class="col-sm-4 col-form-label">Biro</label>
                            <div class="col-sm-8">
                               
                                $dataBiro=$this->db->get('tr_biro');

                                $options = array('' => '=== Pilih Biro ===',);
                                foreach ($dataBiro->result() as $db) {
                                    $options[$db->kode] = $db->biro;
                                }

                                $attr = array('class' => 'form-control', 'id' => 'inputGroupSelect04');
                                echo form_dropdown('f[kode_biro]', $options, $kode_biro, $attr);
                                unset($options);
                                unset($attr);
                                ?>
                            </div>
                        </div> -->

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="owner">owner</label>
                            <div class="col-sm-8">
                                <input id="owner" type="text" name="f[owner]" class="form-control" value="<?=$nama?>" required>
                            </div>
                        </div>
                        <!-- <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Jenis Kelamin </label>
                            <div class="col-sm-2">
                                <div class="form-check">
                                <input class="form-check-input" type="radio" name="f[jk]" id="exampleRadios1" value="l" <?php if($jk=='l'){ ?> checked=checked <?php } ?>>
                                <label class="form-check-label" for="exampleRadios1">
                                    L
                                </label>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-check">
                                <input class="form-check-input" type="radio" name="f[jk]" id="exampleRadios2" value="p" <?php if($jk=='p'){ ?> checked=checked <?php } ?>>
                                <label class="form-check-label" for="exampleRadios2">
                                    P
                                </label>
                                </div>
                            </div>
                        </div> -->
                        <!-- <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="alamat">Alamat</label>
                            <div class="col-sm-8">
                                <input id="alamat" name="f[alamat]" class="form-control" value="<?=$alamat?>" required>
                            </div>
                        </div>  -->
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="telp">No. Telpon</label>
                            <div class="col-sm-8">
                                <input id="telp" name="f[telp]" class="form-control" value="<?=$telp?>"  >
                            </div>
                        </div> 
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label" for="email">Email</label>
                            <div class="col-sm-8">
                                <input id="email" name="f[email]" class="form-control" value="<?=$email?>"  >
                            </div>
                        </div> 
                        <button class="btn btn-primary mb-5 pull-right" onclick="javascript:submitForm('formSubmit')"><i class="fa fa-save"></i> SIMPAN</button>
                        </form>
                    </div>
                </div>
        </div>
    
    </div>
<div>

<script>
function dataBiro(id) {
    if(id=="<?=$this->m_reff->pengaturan(2);?>"){
    $("#dataBiro").removeAttr("hidden");
	}else {
	$("#dataBiro").attr("hidden",true);
	}
}
</script>