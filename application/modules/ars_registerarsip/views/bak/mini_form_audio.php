<div class="row row-xs align-items-center mg-b-20">
    <div class="col-md-2">
        <label class="form-label mg-b-0 text-black">Klasifikasi Arsip </label>
    </div>
    <div class="col-md-10 mg-t-5 mg-md-t-0">
        <?php 
        $dataray=array();
        $dataray[""]="=== Pilih ===";
        $data = $this->db->get("ars_tr_kka")->result();
        foreach($data as $db){
            $dataray[$db->id] = "{$db->kode} - {$db->nama}";
        }
        echo form_dropdown("f[kka]",$dataray,"",'id="klasifikasi_arsip" class="form-control select2 text-black"  style="width:100%"');
        ?>
    </div>
</div>
<div class="row row-xs align-items-center mg-b-20">
    <div class="col-md-2">
        <label class="form-label mg-b-0 text-black">Nomor Arsip </label>
    </div>
    <div class="col-md-10 mg-t-5 mg-md-t-0">
        <input type="text" class="form-control" name="f[no_arsip]" value="" placeholder="Nomor Arsip">
    </div>
</div>
<div class="row row-xs align-items-center mg-b-20">
    <div class="col-md-2">
        <label class="form-label mg-b-0 text-black">Tingkat Perkembangan </label>
    </div>
    <div class="col-md-10 mg-t-5 mg-md-t-0">
        <?php 
            $dataray=array();
            $dataray[""]="=== Pilih ===";
            $dataray["1"]="Asli / Master";
            $dataray["2"]="Kopi Master";
            $dataray["3"]="Repro";
            $dataray["4"]="Kopi";
            echo form_dropdown("f[t_perkembangan]",$dataray,"",'class="select2 form-control text-black" style="width:100%"');
        ?>
    </div>
</div>
<div class="row row-xs align-items-center mg-b-20">
    <div class="col-md-2">
        <label class="form-label mg-b-0 text-black">Upload Arsip </label>
    </div>
    <div class="col-md-10 mg-t-5 mg-md-t-0">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th width="50px">No</th>
                    <th>File Upload</th>
                    <th width="102px">Aksi</th>
                </tr>
            </thead>
            <tbody id="ListItem">
                <tr class="item">
                    <td class="text-center number">1</td>
                    <td><input type="file" class="itemFile" name="f[file_0]" id="file_0" onchange="UploadFile(this)" accept="application/pdf, image/*, audio/*, video/*" accept-size="10">
                    </td>
                    <td class="text-center"></td>
                </tr>
            </tbody>
            <tfoot>
                <tr class="text-right">
                    <input type="hidden" name="JmlUpload" id="JmlUpload" value="0">
                    <td colspan="4"><a href="javascript:void(0)" onclick="AddUpload()" class="btn btn-xs btn-info">Tambah Upload</a></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<hr>

<div class="row row-xs align-items-center mg-b-20">
    <div class="col-md-2">
        <label class="form-label mg-b-0 text-black">Produksi </label>
    </div>
    <div class="col-md-10 mg-t-5 mg-md-t-0">
        <?php 
            $dataray=array();
            $dataray[""]="=== Pilih ===";
            $dataray["1"]="Biro Pers";
            $dataray["2"]="Media";
            $dataray["3"]="Informasi";
            echo form_dropdown("f[tp]",$dataray,"",'class="select2 form-control text-black " style="width:100%"');
        ?>
    </div>
</div>
<div class="row row-xs align-items-center mg-b-20">
    <div class="col-md-2">
        <label class="form-label mg-b-0 text-black">Format </label>
    </div>
    <div class="col-md-10 mg-t-5 mg-md-t-0">
        <?php 
            $dataray=array();
            $dataray[""]="=== Pilih ===";
            $dataray["1"]="Master";
            $dataray["2"]="Copy";
            echo form_dropdown("f[format]",$dataray,"",'class="select2 form-control text-black" style="width:100%"');
        ?>
    </div>
</div>
<div class="row row-xs align-items-center mg-b-20">
    <div class="col-md-2">
        <label class="form-label mg-b-0 text-black">Tanggal Rekaman </label>
    </div>
    <div class="col-md-10 mg-t-5 mg-md-t-0">
        <div class="form-group">
            <div class="form-line">
                <input required style='color:black;' type="text" id="tanggal" name="f[tanggal]" class="cursor form-control">
            </div>
        </div>
    </div>
</div>
<div class="row row-xs align-items-center mg-b-20">
    <div class="col-md-2">
        <label class="form-label mg-b-0 text-black">Kecepatan </label>
    </div>
    <div class="col-md-10 mg-t-5 mg-md-t-0">
        <input type="text" class="form-control" name="f[kecepatan]" value="" placeholder="Kecepatan">
    </div>
</div>
<div class="row row-xs align-items-center mg-b-20">
    <div class="col-md-2">
        <label class="form-label mg-b-0 text-black">Durasi </label>
    </div>
    <div class="col-md-10 mg-t-5 mg-md-t-0">
        <input type="text" class="form-control" name="f[durasi]" value="" placeholder="Durasi">
    </div>
</div>
<div class="row row-xs align-items-center mg-b-20">
    <div class="col-md-2">
        <label class="form-label mg-b-0 text-black">Jenis Suara </label>
    </div>
    <div class="col-md-10 mg-t-5 mg-md-t-0">
        <?php 
        $dataray=array();
        $dataray[""]="=== Pilih ===";
        $dataray["0"]="Mono";
        $dataray["1"]="Stereo";
        echo form_dropdown("f[jenis_suara]",$dataray,"",'id="jenis_suara" class="form-control select2 text-black" style="width:100%"');
        ?>
    </div>
</div>
<div class="row row-xs align-items-center mg-b-20">
    <div class="col-md-2">
        <label class="form-label mg-b-0 text-black">Mutu Suara </label>
    </div>
    <div class="col-md-10 mg-t-5 mg-md-t-0">
        <input type="text" class="form-control" name="f[mutu_suara]" value="" placeholder="Mutu Suara">
    </div>
</div>
<div class="row row-xs align-items-center mg-b-20">
    <div class="col-md-2">
        <label class="form-label mg-b-0 text-black">Asal Koleksi </label>
    </div>
    <div class="col-md-10 mg-t-5 mg-md-t-0">
        <input type="text" class="form-control" name="f[asal_koleksi]" value="" placeholder="Asal Koleksi">
    </div>
</div>
<div class="row row-xs align-items-center mg-b-20">
    <div class="col-md-2">
        <label class="form-label mg-b-0 text-black">Ringkasan Isi </label>
    </div>
    <div class="col-md-10 mg-t-5 mg-md-t-0">
        <input type="text" class="form-control" name="f[ringkasan_isi]" value="" placeholder="Ringkasan Isi">
    </div>
</div>
<div class="row row-xs align-items-center mg-b-20">
    <div class="col-md-2">
        <label class="form-label mg-b-0 text-black">Jangka Waktu Simpan </label>
    </div>
    <div class="col-md-10 mg-t-5 mg-md-t-0">
        <input type="number" class="form-control" name="f[jangka_waktu_simpan]" value="" placeholder="Jangka Waktu Simpan">
    </div>
</div>
<script>
    $('#tanggal').datepicker({
        format: 'mm-dd-yyyy'
    });
    $('#kurun_waktu').datepicker({
        format: "yyyy",
        viewMode: "years", 
        minViewMode: "years"
    });
</script>