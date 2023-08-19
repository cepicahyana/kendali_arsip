<div class="table-responsive">
    <table class="entry2 mb-4" width="100%" font="9px">
        <thead >
            <tr>
                <th>No</th>
                <th>Golongan/Pangkat</th>
        
                <th>Masa Kerja</th>
                <th>Jenis Kenaikan Pangkat</th>
                <th>Tmt</th>
                <th>Tanggal SK</th>
                <th>No SK</th>
                <th>Lampiran</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php $n = 1;
            $h = $this->mdl->getGolonganByNip($val)->result();
            foreach ($h as $t) {
                $nip_pegawai = $t->nip_pegawai ?? '';
                $golongan = $t->golongan ?? '';
                $masa_kerja = isset($t->masa_kerja) ? date('d/m/Y', strtotime($t->masa_kerja)) : '';
                $jenis_kenaikan_pangkat = $t->jenis_kenaikan_pangkat ?? '';
                $tmt = isset($t->tmt) ? date('d/m/Y', strtotime($t->tmt)) : '';
                $tgl_sk = isset($t->tgl_sk) ? date('d/m/Y', strtotime($t->tgl_sk)) : '';
                $no_sk = $t->no_sk ?? '';

                if ($t->file) {
                    $file  =  $this->m_reff->encrypt($t->file);
                    $lampiran =  ' <a  href="' . base_url() . 'download?f=' . $file . '" class="text-info btn-block"><i class="fa fa-file"></i> File </a>';
                } else {
                    $lampiran = "-";
                }
            ?>
                <tr>
                    <td><?= $n++ ?></td>
                    <td><?= $golongan; ?> - <?= $this->m_reff->pangkat($golongan); ?></td>
                    <td><?= $masa_kerja; ?></td>
                    <td><?= $jenis_kenaikan_pangkat; ?></td>
                    <td><?= $tmt; ?></td>
                    <td><?= $tgl_sk; ?></td>
                    <td><?= $no_sk; ?></td>
                    <td><?= $lampiran; ?></td>
                    <td>
                        <div class="btn-group"><a href="#" onclick="formTableEdit('<?= $t->id ?? ''; ?>')" title="Edit" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                        <a href="#" onclick="hapusTable('<?= $t->id ?? ''; ?>','<?= $t->no_sk ?? ''; ?>')" title="Hapus" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>