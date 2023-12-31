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
        <label class="form-label mg-b-0 text-black">Uraian Informasi Arsip </label>
    </div>
    <div class="col-md-10 mg-t-5 mg-md-t-0">
        <div class="form-group">
            <div class="form-line">
                <textarea class=" form-control" name="f[uraian]"  type="text"></textarea>
            </div>
        </div>
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
        <label class="form-label mg-b-0 text-black">Jumlah </label>
    </div>
    <div class="col-md-10 mg-t-5 mg-md-t-0">
        <input type="number" class="form-control" name="f[jumlah]" value="" placeholder="Jumlah">
    </div>
</div>
<div class="row row-xs align-items-center mg-b-20">
    <div class="col-md-2">
        <label class="form-label mg-b-0 text-black">Deskripsi </label>
    </div>
    <div class="col-md-10 mg-t-5 mg-md-t-0">
        <div class="form-group">
            <div class="form-line">
                <textarea class=" form-control" name="f[deskripsi]" type="text"></textarea>
            </div>
        </div>
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
        <label class="form-label mg-b-0 text-black">Lokasi Ruang Simpan </label>
    </div>
    <div class="col-md-10 mg-t-5 mg-md-t-0">
        <input type="text" class="form-control" name="f[lokasi]" value="" placeholder="lokasi">
    </div>
</div>
<div class="row row-xs align-items-center mg-b-20">
    <div class="col-md-2">
        <label class="form-label mg-b-0 text-black">Nomor Folder </label>
    </div>
    <div class="col-md-10 mg-t-5 mg-md-t-0">
        <input type="text" class="form-control" name="f[nomor_folder]" value="" placeholder="Nomor Folder">
    </div>
</div>
<div class="row row-xs align-items-center mg-b-20">
    <div class="col-md-2">
        <label class="form-label mg-b-0 text-black">Nomor Boks Arsip </label>
    </div>
    <div class="col-md-10 mg-t-5 mg-md-t-0">
        <input type="text" class="form-control" name="f[nomor_boks]" value="" placeholder="Nomor Boks Arsip">
    </div>
</div>
<div class="row row-xs align-items-center mg-b-20">
    <div class="col-md-2">
        <label class="form-label mg-b-0 text-black">Jadwal Retensi Arsip </label>
    </div>
    <div class="col-md-10 mg-t-5 mg-md-t-0">
        <?php 
        $dataray=array();
        $dataray[""]="=== Pilih ===";
        $data = $this->db->get("ars_tr_jra")->result();
        foreach($data as $db){
            $dataray[$db->id] = $db->nama;
        }
        echo form_dropdown("f[jra]",$dataray,"",'id="jadwal_retensi_arsip" class="form-control select2 text-black" style="width:100%"');
        ?>
    </div>
    <div class="card custom-card mg-t-20" id="detail_jra" style="display: none;">
        <div class="card-body">
            <div class="row row-xs align-items-center mg-b-20">
                <div class="col-md-3">
                    <label class="form-label mg-b-0 text-black">Retensi Aktif </label>
                </div>
                <div class="col-md-9 mg-t-5 mg-md-t-0">
                    <input type="text" class="form-control" id="retensi_aktif" disabled>
                </div>
            </div>
            <div class="row row-xs align-items-center mg-b-20">
                <div class="col-md-3">
                    <label class="form-label mg-b-0 text-black">Deskripsi Retensi Aktif </label>
                </div>
                <div class="col-md-9 mg-t-5 mg-md-t-0">
                    <input type="text" class="form-control" id="deks_retensi_aktif" disabled>
                </div>
            </div>
            <div class="row row-xs align-items-center mg-b-20">
                <div class="col-md-3">
                    <label class="form-label mg-b-0 text-black">Retensi InAktif </label>
                </div>
                <div class="col-md-9 mg-t-5 mg-md-t-0">
                    <input type="text" class="form-control" id="retensi_inaktif" disabled>
                </div>
            </div>
            <div class="row row-xs align-items-center mg-b-20">
                <div class="col-md-3">
                    <label class="form-label mg-b-0 text-black">Deskripsi Retensi InAktif </label>
                </div>
                <div class="col-md-9 mg-t-5 mg-md-t-0">
                    <input type="text" class="form-control" id="deks_retensi_inaktif" disabled>
                </div>
            </div>
            <div class="row row-xs align-items-center mg-b-20">
                <div class="col-md-3">
                    <label class="form-label mg-b-0 text-black">Tindak Lanjut </label>
                </div>
                <div class="col-md-9 mg-t-5 mg-md-t-0">
                    <input type="text" class="form-control" id="tindak_lanjut" disabled>
                </div>
            </div>
        </div>
    </div>
</div>