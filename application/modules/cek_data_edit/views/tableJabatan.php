<div class="table-responsive">
    <table class="entry2 mb-4" width="100%" font="9px">
        <thead>
            <tr>
                <th>No</th>
                <th>Jenis Jabatan</th>
                <th>Nama Jabatan</th>
                <th>Grade</th>
                <th>TMT</th>
                <th>Tanggal SK Jabatan</th>
                <th>No SK Jabatan</th>
                <th>Tanggal SK Eselon</th>
                <th>No SK Eselon</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php $n = 1;
            $h = $this->mdl->getJabatanByNip($val)->result();
            foreach ($h as $t) {
                $jenis = $t->jenis ?? '';
                $grade = $t->grade ?? '';
                $nama = $t->nama ?? '';
                $tmt = isset($t->tmt) ? date('d/m/Y', strtotime($t->tmt)) : '';

                $no_sk_jabatan = $t->no_sk_jabatan ?? '';
                $tgl_sk_jabatan = isset($t->tgl_sk_jabatan) ? date('d/m/Y', strtotime($t->tgl_sk_jabatan)) : '';

                $tgl_sk_eselon = isset($t->tgl_sk_eselon) ? date('d/m/Y', strtotime($t->tgl_sk_eselon)) : '';
                $no_sk_eselon = $t->no_sk_eselon ?? '';

            ?>
                <tr>
                    <td><?= $n++ ?></td>
                    <td><?= $jenis; ?></td>
                    <td><?= $nama; ?></td>
                    <td><?= $grade; ?></td>
                    <td><?= $tmt; ?></td>
                    <td><?= $tgl_sk_jabatan; ?></td>
                    <td><?= $no_sk_jabatan; ?></td>
                    <td><?= $tgl_sk_eselon; ?></td>
                    <td><?= $no_sk_eselon; ?></td>
                    <td><a href="#" onclick="formTableEdit('<?= $t->id ?? ''; ?>')" title="Edit" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                    <a href="#" onclick="hapusTable('<?= $t->id ?? ''; ?>','<?= $t->no_sk ?? ''; ?>')" title="Hapus" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>