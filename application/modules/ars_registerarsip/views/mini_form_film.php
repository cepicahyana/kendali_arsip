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
                $dataray[$db->kode] = "{$db->kode} - {$db->nama}";
            }
            echo form_dropdown("f[kka_kode]",$dataray,"",'id="klasifikasi_arsip" class="form-control select2 text-black"  style="width:100%"');
        ?>
    </div>
</div>
<div class="row row-xs align-items-center mg-b-20">
    <div class="col-md-2">
        <label class="form-label mg-b-0 text-black">Nomor Kaset </label>
    </div>
    <div class="col-md-10 mg-t-5 mg-md-t-0">
        <input type="text" class="form-control" name="f[nomor]" value="" placeholder="Nomor Kaset">
    </div>
</div>
<div class="row row-xs align-items-center mg-b-20">
    <div class="col-md-2">
        <label class="form-label mg-b-0 text-black">Kurun Waktu </label>
    </div>
    <div class="col-md-10 mg-t-5 mg-md-t-0">
        <div class="form-group">
            <div class="form-line">
                <input required style='color:black;' type="text" id="periode" name="f[kurun_waktu]" class="cursor form-control">
            </div>
        </div>
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
            $data = $this->db->get("ars_tr_tingkat_perkembangan")->result();
            foreach($data as $db){
                $dataray[$db->id] = $db->nama;
            }
            echo form_dropdown("f[tingkat_perkembangan_id]",$dataray,"",'id="tingkat_perkembangan" class="form-control select2 text-black" style="width:100%"');
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
                    <td><input type="file" class="itemFile" name="file_0" id="file_0" onchange="UploadFile(this)" accept="application/pdf, image/*, audio/*, video/*" accept-size="10">
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

<div class="row row-xs align-items-center mg-b-20"><!-- Belum Memiliki Kolom pada Table -->
    <div class="col-md-2">
        <label class="form-label mg-b-0 text-black">Judul </label>
    </div>
    <div class="col-md-10 mg-t-5 mg-md-t-0">
        <input type="text" class="form-control" name="nf[judul]" value="" placeholder="Judul">
    </div>
</div>
<div class="row row-xs align-items-center mg-b-20"><!-- Belum Memiliki Kolom pada Table -->
    <div class="col-md-2">
        <label class="form-label mg-b-0 text-black">Sub Judul </label>
    </div>
    <div class="col-md-10 mg-t-5 mg-md-t-0">
        <input type="text" class="form-control" name="nf[sub_judul]" value="" placeholder="Sub Judul">
    </div>
</div>
<div class="row row-xs align-items-center mg-b-20"><!-- Belum Memiliki Kolom pada Table -->
    <div class="col-md-2">
        <label class="form-label mg-b-0 text-black">Tipe Kaset </label>
    </div>
    <div class="col-md-10 mg-t-5 mg-md-t-0">
        <?php 
        $dataray=array();
        $dataray[""]="=== Pilih ===";
        echo form_dropdown("nf[tk]",$dataray,"",'id="tipe_kaset" class="form-control select2 text-black"  style="width:100%"');
        ?>
    </div>
</div>
<div class="row row-xs align-items-center mg-b-20"><!-- Belum Memiliki Kolom pada Table -->
    <div class="col-md-2">
        <label class="form-label mg-b-0 text-black">Durasi </label>
    </div>
    <div class="col-md-10 mg-t-5 mg-md-t-0">
        <input type="number" class="form-control" name="nf[durasi]" value="" placeholder="Durasi">
    </div>
</div>
<div class="row row-xs align-items-center mg-b-20"><!-- Belum Memiliki Kolom pada Table -->
    <div class="col-md-2">
        <label class="form-label mg-b-0 text-black">Warna </label>
    </div>
    <div class="col-md-10 mg-t-5 mg-md-t-0">
        <?php 
        $dataray=array();
        $dataray[""]="=== Pilih ===";
        $dataray["0"]="Warna";
        $dataray["1"]="Hitam Putih";
        echo form_dropdown("nf[warna]",$dataray,"",'id="warna" class="form-control select2 text-black" style="width:100%"');
        ?>
    </div>
</div>
<div class="row row-xs align-items-center mg-b-20"><!-- Belum Memiliki Kolom pada Table -->
    <div class="col-md-2">
        <label class="form-label mg-b-0 text-black">Suara </label>
    </div>
    <div class="col-md-10 mg-t-5 mg-md-t-0">
        <?php 
        $dataray=array();
        $dataray[""]="=== Pilih ===";
        $dataray["0"]="Mono";
        $dataray["1"]="Stereo";
        echo form_dropdown("nf[suara]",$dataray,"",'id="suara" class="form-control select2 text-black" style="width:100%"');
        ?>
    </div>
</div>
<div class="row row-xs align-items-center mg-b-20"><!-- Belum Memiliki Kolom pada Table -->
    <div class="col-md-2">
        <label class="form-label mg-b-0 text-black">Bahasa </label>
    </div>
    <div class="col-md-10 mg-t-5 mg-md-t-0">
        <input type="text" class="form-control" name="nf[bahasa]" value="" placeholder="Bahasa">
    </div>
</div>
<div class="row row-xs align-items-center mg-b-20"><!-- Belum Memiliki Kolom pada Table -->
    <div class="col-md-2">
        <label class="form-label mg-b-0 text-black">Tokoh </label>
    </div>
    <div class="col-md-10 mg-t-5 mg-md-t-0">
        <input type="text" class="form-control" name="nf[tokoh]" value="" placeholder="Tokoh">
    </div>
</div>
<div class="row row-xs align-items-center mg-b-20"><!-- Belum Memiliki Kolom pada Table -->
    <div class="col-md-2">
        <label class="form-label mg-b-0 text-black">Lokasi </label>
    </div>
    <div class="col-md-10 mg-t-5 mg-md-t-0">
        <input type="text" class="form-control" name="nf[lokasi]" value="" placeholder="Lokasi">
    </div>
</div>
<div class="row row-xs align-items-center mg-b-20"><!-- Belum Memiliki Kolom pada Table -->
    <div class="col-md-2">
        <label class="form-label mg-b-0 text-black">Sinopsis </label>
    </div>
    <div class="col-md-10 mg-t-5 mg-md-t-0">
        <div class="form-group">
            <div class="form-line">
                <textarea class="form-control" name="nf[sinopsis]"  type="text"></textarea>
            </div>
        </div>
    </div>
</div>
<div class="row row-xs align-items-center mg-b-20"><!-- Belum Memiliki Kolom pada Table -->
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
            echo form_dropdown("nf[produksi]",$dataray,"",'class="select2 form-control text-black " style="width:100%"');
        ?>
    </div>
</div>
<div class="row row-xs align-items-center mg-b-20"><!-- Belum Memiliki Kolom pada Table -->
    <div class="col-md-2">
        <label class="form-label mg-b-0 text-black">Tahun Produksi </label>
    </div>
    <div class="col-md-10 mg-t-5 mg-md-t-0">
        <div class="form-group">
            <div class="form-line">
                <input required style='color:black;' type="text" id="t_produksi" name="nf[t_produksi]" class="cursor form-control">
            </div>
        </div>
    </div>
</div>
<div class="row row-xs align-items-center mg-b-20"><!-- Belum Memiliki Kolom pada Table -->
    <div class="col-md-2">
        <label class="form-label mg-b-0 text-black">Editor </label>
    </div>
    <div class="col-md-10 mg-t-5 mg-md-t-0">
        <input type="text" class="form-control" name="nf[editor]" value="" placeholder="Editor">
    </div>
</div>
<div class="row row-xs align-items-center mg-b-20">
    <div class="col-md-2">
        <label class="form-label mg-b-0 text-black">Lokasi Simpan </label>
    </div>
    <div class="col-md-10 mg-t-5 mg-md-t-0">
        <?php 
            $dataray=array();
            $dataray[""]="=== Pilih ===";
            $data = $this->db->get("ars_trx_lokasi")->result();
            foreach($data as $db){
                $dataray[$db->kode] = $db->nama;
            }
            echo form_dropdown("f[location_kode]",$dataray,"",'id="lokasi" class="form-control select2 text-black" style="width:100%"');
        ?>
    </div>
</div>
<div class="row row-xs align-items-center mg-b-20"><!-- Belum Memiliki Kolom pada Table -->
    <div class="col-md-2">
        <label class="form-label mg-b-0 text-black">Jangka Waktu Simpan </label>
    </div>
    <div class="col-md-10 mg-t-5 mg-md-t-0">
        <input type="number" class="form-control" name="nf[jangka_waktu_simpan]" value="" placeholder="Jangka Waktu Simpan">
    </div>
</div>
<script>
    $('#t_produksi').datepicker({
        format: "yyyy",
        viewMode: "years", 
        minViewMode: "years"
    });
</script>


<script>
    $('#periode').daterangepicker({
    "singleDatePicker": true,
    "showDropdowns": true,
    "autoApply": true,
    "locale": {
        "format": "YYYY-MM-DD",
        "separator": " - ",
        "applyLabel": "Apply",
        "cancelLabel": "Cancel",
        "fromLabel": "From",
        "toLabel": "To",
        "customRangeLabel": "Custom",
        "weekLabel": "W",
        "daysOfWeek": [
            "Min",
            "Sen",
            "Sel",
            "Rab",
            "Kam",
            "Jum",
            "Sab"
        ],
        "monthNames": [
            "Januar",
            "Februari",
            "Maret",
            "April",
            "Mei",
            "Juni",
            "Juli",
            "Augustus",
            "September",
            "Oktober",
            "November",
            "Desember"
        ],
        "firstDay": 1
    },
 
}, function(start, end, label) {
  console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
});
</script>