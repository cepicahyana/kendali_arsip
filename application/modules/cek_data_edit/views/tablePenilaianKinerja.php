<div class="table-responsive">
    <table class="entry2 mb-4" width="100%" font="9px">
        <thead>
            <tr>
                <th>No</th>
                <th>Tahun</th>
                <th>Nilai rata-rata</th>
                <th>Pejabat Penilai</th>
                <th>Atasan Pejabat Penilai</th>
                <th>Ket</th>
                <th>Lampiran</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php $n = 1;
            $h = $this->mdl->getPenilaianKinerjaByNip($val)->result();
            foreach ($h as $t) {
                $nip_pegawai = $t->nip_pegawai ?? '';
                $tahun = $t->tahun ?? '';
                $nilai = $t->nilai ?? '';
                $pejabat_penilai = $t->pejabat_penilai ?? '';
                $atasan_pejabat_penilai = $t->atasan_pejabat_penilai ?? '';
                $ket = $t->ket ?? '';

                if ($t->file) {
                    $file  =  $this->m_reff->encrypt($t->file);
                    $lampiran =  ' <a  href="' . base_url() . 'download?f=' . $file . '" class="text-info btn-block"> download </a>';
                } else {
                    $lampiran = "-";
                }

            ?>
                <tr>
                    <td><?= $n++ ?></td>
                    <td><?= $tahun; ?></td>
                    <td><?= $nilai; ?></td>
                    <td><?= $pejabat_penilai; ?></td>
                    <td><?= $atasan_pejabat_penilai; ?></td>
                    <td><?= $ket; ?></td>
                    <td><?= $lampiran; ?></td>
                    <td>
                        <div class="btn-group"><a href="#" onclick="formTableEdit('<?= $t->id ?? ''; ?>')" title="Edit" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                        <a href="#" onclick="hapusTable('<?= $t->id ?? ''; ?>','<?= $t->tahun ?? ''; ?>')" title="Hapus" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
            </div>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>