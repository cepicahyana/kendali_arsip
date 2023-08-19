
<div class="row" id="area_formSubmit">
<div class="col-sm-12">


<div class="card-block">
<h5 class="sub-title">Tambah    </h5><hr>
<form id="formSubmit" action="javascript:submitForm('formSubmit')"
	 method="post" url="<?php echo site_url()?>setting_absen/insert">

     <input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName()?>" value="<?php echo $this->m_reff->getToken()?>">

<div class="row">
    <div class="col-md-12">

        <div class="form-group row">
            <label class="col-sm-4 col-form-label" for="bulan_mulai">Bulan Mulai</label>
            <div class="col-sm-8">
                <select name="f[bulan_mulai]" id="bulan_mulai" class="form-control" required>
                    <option value="1">Januari</option>
                    <option value="2">Februari</option>
                    <option value="3">Maret</option>
                    <option value="4">April</option>
                    <option value="5">Mei</option>
                    <option value="6">Juni</option>
                    <option value="7">Juli</option>
                    <option value="8">Agustus</option>
                    <option value="9">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
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
                echo form_dropdown("f[tgl_mulai]",$dt,null,'id="tgl_mulai"  class="form-control" required');
                ?>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label" for="bulan_akhir">Bulan Akhir</label>
            <div class="col-sm-8">
                <select name="f[bulan_akhir]" id="bulan_akhir" class="form-control" required>
                <option value="1">Januari</option>
                    <option value="2">Februari</option>
                    <option value="3">Maret</option>
                    <option value="4">April</option>
                    <option value="5">Mei</option>
                    <option value="6">Juni</option>
                    <option value="7">Juli</option>
                    <option value="8">Agustus</option>
                    <option value="9">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
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
                echo form_dropdown("f[tgl_akhir]",$dt,null,'id="tgl_akhir"  class="form-control" required');
                ?>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label" for="id_format"> Format absen</label>
            <div class="col-sm-8">
                <select name="f[id_format]" id="id_format" class="form-control">
                    <?php
                        $data = $this->db->get("tm_format_absen")->result();
                        foreach($data as $dt) : ?>

                        <option value="<?=$dt->id?>">  <?=$dt->nama_format?></option>

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
