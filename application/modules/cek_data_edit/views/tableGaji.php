<div class="table-responsive">
    <table class="entry2 mb-4" width="100%" font="9px">
        <thead>
            <tr>
                <th>No</th>
                <th>Pangkat/golongan</th>
                <th>TMT</th>
                <th>Nomor SK</th>
                <th>MK golongan tahun</th>
                <th>MK golongan bulan</th>
                <th>Gapok lama</th>
                <th>Gapok baru</th>
                <th>Keterangan </th>
                <th style="min-width:120px">Edit | Hapus</th>
            </tr>
        </thead>
        <tbody>
            <?php $n = 1;
            $h = $this->mdl->getGajiByNip($val)->result();
            foreach ($h as $t) {
                $golongan = $t->golongan ?? '';
                
                $tmt = isset($t->tmt) ? date('d/m/Y', strtotime($t->tmt)) : '';
                $no_sk = $t->no_sk ?? '';
                $mk_gol_tahun = $t->mk_gol_tahun ?? '';
                $mk_gol_bulan = $t->mk_gol_bulan ?? '';
                $gapok_lama = $t->gapok_lama ?? '';
                $gapok_baru = $t->gapok_baru ?? '';
                $ket = $t->ket ?? '';

            ?>
                <tr>
                    <td><?= $n++ ?></td>
                    <td><?= $this->m_reff->panggol($golongan); ?></td>
                    <td><?= $tmt; ?></td>
                    <td><?= $no_sk; ?></td>
                    <td><?= $mk_gol_tahun; ?></td>
                    <td><?= $mk_gol_bulan; ?></td>
                    <td><?= number_format($gapok_lama,0,",","."); ?></td>
                    <td><?= number_format($gapok_baru,0,",","."); ?></td>
                    <td><?= $ket; ?></td>
                    <td><div class="btn-group"><a href="#" onclick="formTableEdit('<?= $t->id ?? ''; ?>')" title="Edit" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                        <a href="#" onclick="hapusTable('<?= $t->id ?? ''; ?>','<?= $t->golongan ?? ''; ?>')" title="Hapus" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>