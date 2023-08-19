<?php
    $data = $this->mdl->getDataEdit();
    $id = isset($data->id)?($data->id):'';
    $nama_format = isset($data->nama_format)?($data->nama_format):'';
    $jam_masuk = isset($data->jam_masuk)?($data->jam_masuk):'';
    $jam_pulang = isset($data->jam_pulang)?($data->jam_pulang):'';
    $nominal_lembur = isset($data->nominal_lembur)?($data->nominal_lembur):'';
    $uang_makan = isset($data->uang_makan)?($data->uang_makan):'';
    $jam_mulai_lembur = isset($data->jam_mulai_lembur)?($data->jam_mulai_lembur):'';
    $max_lembur_weekday = isset($data->max_lembur_weekday)?($data->max_lembur_weekday):'';
    $max_lembur_weekend = isset($data->max_lembur_weekend)?($data->max_lembur_weekend):'';
    $sts = isset($data->sts)?($data->sts):'';
    $jamin_umak = isset($data->jamin_umak)?($data->jamin_umak):'';

?>


<div class="row" id="area_formSubmit">
<div class="col-sm-12">


<div class="card-block">
<h5 class="sub-title">Edit</h5><hr>
<form id="formSubmit" action="javascript:submitForm('formSubmit')"
	 method="post" url="<?php echo site_url()?>format_absen/update">


<!-- id -->
<input type="hidden" name="id" value="<?=$id?>">

<div class="row">
    <div class="col-md-6">
        <div class="form-group row">
            <label class="col-sm-4 col-form-label" for="nama_format">Nama Format</label>
            <div class="col-sm-8">
                <input id="nama_format" name="f[nama_format]" class="form-control" value="<?=$nama_format?>" required>
            </div>
        </div> 

        <div class="form-group row">
            <label class="col-sm-4 col-form-label" for="jam_masuk">Jam Masuk</label>
            <div class="col-sm-8">
                <input id="jam_masuk" name="f[jam_masuk]" class="form-control" value="<?=$jam_masuk?>" required>
            </div>
        </div> 

        <div class="form-group row">
            <label class="col-sm-4 col-form-label" for="jam_pulang">Jam Pulang</label>
            <div class="col-sm-8">
                <input id="jam_pulang" name="f[jam_pulang]" class="form-control" value="<?=$jam_pulang?>" required>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label" for="nominal_lembur">Nominal Lembur (Rp)</label>
            <div class="col-sm-8">
                <input id="nominal_lembur" type="text" name="f[nominal_lembur]" class="form-control" value="<?=$nominal_lembur?>" required>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label" for="uang_makan">Uang Makan (Rp)</label>
            <div class="col-sm-8">
                <input id="uang_makan" type="text" name="f[uang_makan]" class="form-control" value="<?=$uang_makan?>" required>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group row">
            <label class="col-sm-4 col-form-label" for="jam_mulai_lembur">Jam Mulai Lembur (Jam)</label>
            <div class="col-sm-8">
                <input id="jam_mulai_lembur" name="f[jam_mulai_lembur]" class="form-control" value="<?=$jam_mulai_lembur?>" required>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label" for="max_lembur_weekday">Mak. lembur hari kerja (Jam)</label>
            <div class="col-sm-8">
                <input id="max_lembur_weekday" type="text" name="f[max_lembur_weekday]" class="form-control" value="<?=$max_lembur_weekday?>" required>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4 col-form-label" for="max_lembur_weekend">Mak. lembur hari libur (Jam)</label>
            <div class="col-sm-8">
                <input id="max_lembur_weekend" type="text" name="f[max_lembur_weekend]" class="form-control" value="<?=$max_lembur_weekend?>" required>
            </div>
        </div>

        <div class="form-group row">
        <!-- <label class="col-sm-4 col-form-label">Status</label>
        <div class="col-sm-8">
            <div class="radio d-inline-block mr-3">
            <label> 	<input type="radio" name="f[sts]" value="1" <?php echo ($sts == 1 ? 'checked' : '');?>>
                Aktif</label>
            </div>

            <div class="radio d-inline-block mr-3">
                <label><input type="radio" name="f[sts]" value="0" <?php echo ($sts == 0 ? 'checked' : '');?>>
                Non Aktif</label>
            </div>
        </div> -->

        <div class="form-group row">
            <label class="col-sm-4 col-form-label" for="jamin_umak">Jam lembur Minimal untuk Uang Makan (Jam)</label>
            <div class="col-sm-8">
                <input id="jamin_umak" type="text" name="f[jamin_umak]" class="form-control" value="<?=$jamin_umak?>" required>
            </div>
        </div>
    </div>
</div>

</div>



 <center>
 <button class="btn btn-primary mb-5 pull-right" onclick="javascript:submitForm('formSubmit')"><i class="fa fa-save"></i> UPDATE</button>
 </center>
</form>


</div>
</div>

</div>
<script>
$('#jam_masuk').daterangepicker({
        timePicker : true,
        singleDatePicker:true,
        timePicker24Hour : true,
        timePickerIncrement : 1,
        timePickerSeconds : true,
        locale : {
            format : 'HH:mm:ss'
        }
    }).on('show.daterangepicker', function(ev, picker) {
        picker.container.find(".calendar-table").hide();
});

$('#jam_pulang').daterangepicker({
        timePicker : true,
        singleDatePicker:true,
        timePicker24Hour : true,
        timePickerIncrement : 1,
        timePickerSeconds : true,
        locale : {
            format : 'HH:mm:ss'
        }
    }).on('show.daterangepicker', function(ev, picker) {
        picker.container.find(".calendar-table").hide();
});

$('#jam_mulai_lembur').daterangepicker({
        timePicker : true,
        singleDatePicker:true,
        timePicker24Hour : true,
        timePickerIncrement : 1,
        timePickerSeconds : true,
        locale : {
            format : 'HH:mm:ss'
        }
    }).on('show.daterangepicker', function(ev, picker) {
        picker.container.find(".calendar-table").hide();
});
</script>