<div class="table-responsive">
    <table class="entry2 mb-4" width="100%" font="9px">
        <thead>
            <tr>
                <th>No</th>
                <th>Alamat</th>
                <th>Wilayah</th>
                <th>Status Hunian</th>
                <th>Saat ini</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php $n = 1;
            $h = $this->mdl->getDomisiliByNip($val)->result();
            foreach ($h as $t) {
                  if ($t->id_prov) {
                    $prov = "Provinsi " . $this->m_reff->provinsi($t->id_prov);
                  }else{
                    $prov = "Provinsi ";
                  }
                  if ($t->id_kab) {
                    $kab = "<br>" . ucwords(strtolower($this->m_reff->kabupaten($t->id_kab)));
                  }else{
                    $kab = "<br>Kab/Kota ";
                  }
                  if ($t->id_kec) {
                    $kec =  "<br>Kecamatan " . $this->m_reff->kecamatan($t->id_kec);
                  }else{
                    $kec = "<br>Kecamatan ";
                  }
                  if ($t->id_kel) {
                    $kel =  "<br>Kelurahan " . $this->m_reff->kelurahan($t->id_kel);
                  }else{
                    $kel = "<br>Kelurahan ";
                  }
                  if ($t->alamat) {
                    $alamat =  "<br>" . $t->alamat;
                  }else{
                    $alamat = "";
                  }

                  $status=$t->sts ?? '';
                  if($status==1){
                    $sts="ya";
                  }else{
                    $sts="-";
                  }
            ?>
                <tr>
                    <td><?= $n++ ?></td>
                    <td><?= $alamat ?></td>
                    <td><?= $prov ?><?= $kab ?><?= $kec ?><?= $kel ?></td>
                    <td><?= $t->sts_hunian ?? ''; ?></td>
                    <td><?= $sts  ?></td>
                    <td>
                    <a href="#" onclick="setDomisili('<?= $t->id ?? ''; ?>','<?= $t->alamat ?? ''; ?>')" title="Set default" class="btn btn-sm btn-purple"><i class="fas fa-check"></i> set</a>  
                    <a href="#" onclick="formTableEdit('<?= $t->id ?? ''; ?>')" title="Edit" class="btn btn-sm btn-info"><i class="fas fa-edit"></i> Edit</a>
                    <a href="#" onclick="hapusTable('<?= $t->id ?? ''; ?>','<?= $t->alamat ?? ''; ?>')" title="Hapus" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Hapus</a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>