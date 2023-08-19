<div class="table-responsive">
    <table class="entry2 mb-4" width="100%" font="9px">
        <thead>
            <tr>
                <th>No</th>
                <th>Jenis hukuman</th>
                <th>Nomor SK</th>
                <th>TMT akhir hukuman</th>
                <th>Masa berlaku</th>
                <th>No PP</th>
                <th>Potongan (%)</th>
                <th>Pelanggaran yang dilakukan</th>
                <th>Lampiran</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php $n = 1;
            $h = $this->mdl->getHukumanByNip($val)->result();
            foreach ($h as $t) {
                $nip_pegawai = $t->nip_pegawai ?? '';
                $jenis_hukuman = $t->jenis_hukuman ?? '';
                $no_sk = $t->no_sk ?? '';
                $tmt_akhir = isset($t->tmt_akhir) ? date('d/m/Y', strtotime($t->tmt_akhir)) : '';
                $masa_berlaku = isset($t->masa_berlaku) ? date('d/m/Y', strtotime($t->masa_berlaku)) : '';
                $no_pp = $t->no_pp ?? '';
                $potongan = $t->potongan ?? '';
                $pelanggaran = $t->pelanggaran ?? '';

                if ($t->file) {
                    $file  =  $this->m_reff->encrypt($t->file);
                    $lampiran =  ' <a  href="' . base_url() . 'download?f=' . $file . '" class="text-info btn-block"> download </a>';
                } else {
                    $lampiran = "-";
                }

            ?>
                <tr>
                    <td><?= $n++ ?></td>
                    <td><?= $jenis_hukuman; ?></td>
                    <td><?= $no_sk; ?></td>
                    <td><?= $tmt_akhir; ?></td>
                    <td><?= $masa_berlaku; ?></td>
                    <td><?= $no_pp; ?></td>
                    <td><?= $potongan; ?></td>
                    <td><?= $pelanggaran; ?></td>
                    <td><?= $lampiran; ?></td>
                    <td>
                        <div class="btn-group"><a href="#" onclick="formTableEdit('<?= $t->id ?? ''; ?>')" title="Edit" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                        <a href="#" onclick="hapusTable('<?= $t->id ?? ''; ?>','<?= $t->jenis_hukuman ?? ''; ?>')" title="Hapus" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>