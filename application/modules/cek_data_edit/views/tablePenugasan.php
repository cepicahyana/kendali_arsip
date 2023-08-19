<div class="table-responsive">
    <table class="entry2 mb-4" width="100%" font="9px">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Jabatan</th>
                <th>Penugasan Jabatan Lainnya</th>
                <th>TMT</th>
                <th>Tanggal SK</th>
                <th>No SK atan</th>
                <th>Masa Berlaku</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php $n = 1;
            $h = $this->mdl->getPenugasanByNip($val)->result();
            foreach ($h as $t) {
                $nama_penjab = $t->nama_penjab ?? '';
                $penjab_lainnya = $t->penjab_lainnya ?? '';

                $tmt = isset($t->tmt) ? date('d/m/Y', strtotime($t->tmt)) : '';
                $tgl_sk = isset($t->tgl_sk) ? date('d/m/Y', strtotime($t->tgl_sk)) : '';
                $no_sk = $t->no_sk ?? '';
                $masa_berlaku = isset($t->masa_berlaku) ? date('d/m/Y', strtotime($t->masa_berlaku)) : '';

            ?>
                <tr>
                    <td><?= $n++ ?></td>
                    <td><?= $nama_penjab; ?></td>
                    <td><?= $penjab_lainnya; ?></td>
                    <td><?= $tmt; ?></td>
                    <td><?= $tgl_sk; ?></td>
                    <td><?= $no_sk; ?></td>
                    <td><?= $masa_berlaku; ?></td>
                    <td><a href="#" onclick="formTableEdit('<?= $t->id ?? ''; ?>')" title="Edit" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                    <a href="#" onclick="hapusTable('<?= $t->id ?? ''; ?>','<?= $t->no_sk ?? ''; ?>')" title="Hapus" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>