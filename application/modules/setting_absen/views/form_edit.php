<?php
$id = $this->input->post("id");
$this->db->where("id",$id);
$data	= $this->db->get("pengaturan_absen")->row();

$bulan_mulai = isset($data->bulan_mulai)?($data->bulan_mulai): "";
$tgl_mulai = isset($data->tgl_mulai)?($data->tgl_mulai): "";
$bulan_akhir = isset($data->bulan_akhir)?($data->bulan_akhir): "";
$tgl_akhir = isset($data->tgl_akhir)?($data->tgl_akhir): "";
$id_format = isset($data->id_format)?($data->id_format): "";



?> 
<div class="row" id="area_formSubmit">
<div class="col-sm-12">


<div class="card-block">
<h5 class="sub-title">Edit</h5><hr>
<form id="formSubmit" action="javascript:submitForm('formSubmit')"
	 method="post" url="<?php echo site_url()?>setting_absen/update">

     <input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName()?>" value="<?php echo $this->m_reff->getToken()?>">

     <input type="hidden" name="id" value="<?=$id?>">

<div class="row">
    <div class="col-md-12">

        <div class="form-group row">
            <label class="col-sm-4 col-form-label" for="bulan_mulai">Bulan Mulai</label>
            <div class="col-sm-8">
                <select name="f[bulan_mulai]" id="bulan_mulai" class="form-control" required>
                    <option value="1" <?php if($bulan_mulai == '1'){ print 'selected' ;} ?>>Januari</option>
                    <option value="2" <?php if($bulan_mulai == '2'){ print 'selected' ;} ?>>Februari</option>
                    <option value="3" <?php if($bulan_mulai == '3'){ print 'selected' ;} ?>>Maret</option>
                    <option value="4" <?php if($bulan_mulai == '4'){ print 'selected' ;} ?>>April</option>
                    <option value="5" <?php if($bulan_mulai == '5'){ print 'selected' ;} ?>>Mei</option>
                    <option value="6" <?php if($bulan_mulai == '6'){ print 'selected' ;} ?>>Juni</option>
                    <option value="7" <?php if($bulan_mulai == '7'){ print 'selected' ;} ?>>Juli</option>
                    <option value="8" <?php if($bulan_mulai == '8'){ print 'selected' ;} ?>>Agustus</option>
                    <option value="9" <?php if($bulan_mulai == '9'){ print 'selected' ;} ?>>September</option>
                    <option value="10" <?php if($bulan_mulai == '10'){ print 'selected' ;} ?>>Oktober</option>
                    <option value="11" <?php if($bulan_mulai == '11'){ print 'selected' ;} ?>>November</option>
                    <option value="12" <?php if($bulan_mulai == '12'){ print 'selected' ;} ?>>Desember</option>
                </select>
            </div>
        </div> 

        <div class="form-group row">
            <label class="col-sm-4 col-form-label" for="Tanggal Mulai">Tanggal Mulai</label>
            <div class="col-sm-8">
            <?php
                $dt = array();
                for($i=1;$i<=31;$i++){
                    $dt[$i]=$i;
                }
                echo form_dropdown("f[tgl_mulai]",$dt,$tgl_mulai,'id="tgl_mulai"  class="form-control" required');
                ?>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label" for="bulan_akhir">Bulan Akhir</label>
            <div class="col-sm-8">
                <select name="f[bulan_akhir]" id="bulan_akhir" class="form-control" required>
                <option value="1" <?php if($bulan_akhir == '1'){ print 'selected' ;} ?>>Januari</option>
                    <option value="2" <?php if($bulan_akhir == '2'){ print 'selected' ;} ?>>Februari</option>
                    <option value="3" <?php if($bulan_akhir == '3'){ print 'selected' ;} ?>>Maret</option>
                    <option value="4" <?php if($bulan_akhir == '4'){ print 'selected' ;} ?>>April</option>
                    <option value="5" <?php if($bulan_akhir == '5'){ print 'selected' ;} ?>>Mei</option>
                    <option value="6" <?php if($bulan_akhir == '6'){ print 'selected' ;} ?>>Juni</option>
                    <option value="7" <?php if($bulan_akhir == '7'){ print 'selected' ;} ?>>Juli</option>
                    <option value="8" <?php if($bulan_akhir == '8'){ print 'selected' ;} ?>">Agustus</option>
                    <option value="9" <?php if($bulan_akhir == '9'){ print 'selected' ;} ?>>September</option>
                    <option value="10" <?php if($bulan_akhir == '10'){ print 'selected' ;} ?>>Oktober</option>
                    <option value="11" <?php if($bulan_akhir == '11'){ print 'selected' ;} ?>>November</option>
                    <option value="12" <?php if($bulan_akhir == '12'){ print 'selected' ;} ?>>Desember</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label" for="tgl_akhir">Tanggal Akhir</label>
            <div class="col-sm-8">
              
                <?php
                $dt = array();
                for($i=1;$i<=31;$i++){
                    $dt[$i]=$i;
                }
                echo form_dropdown("f[tgl_akhir]",$dt,$tgl_akhir,'id="tgl_akhir"  class="form-control" required');
                ?>


            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label" for="id_format"> Format Absen</label>
            <div class="col-sm-8">
                <select name="f[id_format]" id="id_format" class="form-control">
                    <?php
                        $data = $this->db->get("tm_format_absen")->result();
                        foreach($data as $dt) : ?>

                        <option value="<?=$dt->id?>" <?php if($dt->id == $id_format){ print 'selected' ;} ?>> <?=$dt->nama_format?></option>

                        <?php 
                        endforeach;
                    ?>
                </select>
            </div>
        </div>
    </div>
</div>
    <button class="btn btn-primary mb-2 pull-right mt-3" onclick="javascript:submitForm('formSubmit')"><i class="fa fa-save"></i> SIMPAN</button>
    
</div>
</form>


</div>
</div>
