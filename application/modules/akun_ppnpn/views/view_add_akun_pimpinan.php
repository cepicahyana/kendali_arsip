<div class="row" id="area_formSubmit">
    <div class="col-md-12">

        <div class="card-block">
            <h5 class="sub-title">Tambah    </h5><hr>
                <div class="row">
                    <div class="col-md-12">
                        <form id="formSubmit" action="javascript:submitForm('formSubmit')" method="post" url="<?php echo site_url()?>akun_ppnpn/insert_akun_pimpinan">
                        <input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName()?>" value="<?php echo $this->m_reff->getToken()?>">

                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label" for="nip">NIP LAMA / NIP BARU / NIP SSO</label>
                            <div class="col-sm-11">
                                <input id="nip" name="nip" onchange="getDataPns()" class="form-control" value="" required>
                            </div>
                            <div class="col-sm-1">
                               <button type="button" style="margin-top:3px;margin-left:-20px" class="btn btn-light btn-mini"> cari</button>
                            </div>
                        </div> 
                       

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Istana</label>
                            <div class="col-sm-8">
                                <?php
                                $dataIstana=$this->db->get('tr_istana');

                                $options = array('' => '=== Pilih Istana ===',);
                                foreach ($dataIstana->result() as $di) {
                                    $options[$di->kode] = $di->istana;
                                }

                                $attr = array('class' => 'form-control', 'id' => 'inputGroupSelect04', 'required' => 'required','onchange'=>'dataBiro(this.value)');
                                echo form_dropdown('f[kode_istana]', $options, null, $attr);
                                unset($options);
                                unset($attr);
                                ?>
                            </div>
                        </div>

                        <div id="dataBiro" class="form-group row">
                            <label class="col-sm-4 col-form-label">Biro</label>
                            <div class="col-sm-8">
                                <?php
                                $dataBiro=$this->db->get('tr_biro');

                                $options = array('' => '=== Pilih Biro ===',);
                                foreach ($dataBiro->result() as $db) {
                                    $options[$db->kode] = $db->biro;
                                }

                                $attr = array('class' => 'form-control', 'id' => 'inputGroupSelect04');
                                echo form_dropdown('f[kode_biro]', $options, null, $attr);
                                unset($options);
                                unset($attr);
                                ?>
                            </div>
                        </div>

                        
                     <div id="isi"></div>
                         <br/>
                        
                        <button id="tombol" class="btn btn-primary mb-5 pull-right" onclick="javascript:submitForm('formSubmit')"><i class="fa fa-save"></i> SIMPAN</button>
                        </form>
                    </div>
                </div>
        </div>
    
    </div>
<div>

<script>
    function dataBiro(id) {
    var is = id.toLowerCase();
        if(is=="<?=$this->m_reff->pengaturan(2);?>"){
            $("#dataBiro").show();
        }else {
            $("#dataBiro").hide();
        }
    }
    function getDataPns(){
	$("#isi").html("<br><br><br>");
	loading("isi");
	var val =$("[name='nip']").val();
	var url   = "<?php echo site_url("portal/getDataPns");?>";
	var param = {nip:val,<?php echo $this->m_reff->tokenName()?>:token};
	$.ajax({
		type: "POST",dataType: "json",data: param, url: url,
		success: function(val) {
			unblock("isi");
			token=val['token'];
			$("#isi").html(val['data']);
			if(val['tombol']==true){
				$("#tombol").show();
			}else{
				$("#tombol").hide();
			}
		}
	});

}
</script>