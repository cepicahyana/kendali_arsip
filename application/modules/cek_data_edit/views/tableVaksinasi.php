<div class="table-responsive">
    <table class="entry2 mb-4" width="100%" font="9px">
        <thead>
            <tr>
                <th>No</th>
                <th>Jenis vaksin</th>
                <th>Tanggal vaksin</th>
                <th>Ket</th>
                <th>Edit | Hapus</th>
            </tr>
        </thead>
        <tbody>
            <?php $n = 1;
            $h = $this->mdl->getVaksinasiByNip($val)->result();
            foreach ($h as $t) {
                $jenis_vaksin = $t->jenis_vaksin ?? '';
                $tgl_vaksin = isset($t->tgl_vaksin) ? date('d/m/Y', strtotime($t->tgl_vaksin)) : '';
                $ket = $t->ket ?? '';

            ?>
                <tr>
                    <td><?= $n++ ?></td>
                    <td><?= $tgl_vaksin; ?></td>
                    <td><?= $jenis_vaksin; ?></td>
                    <td><?= $ket; ?></td>
                    <td>
                        <div class="btn-group"><a href="#" onclick="formTableEdit('<?= $t->id ?? ''; ?>')" title="Edit" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                    <a href="#" onclick="hapusTable('<?= $t->id ?? ''; ?>','<?= $t->jenis_vaksin ?? ''; ?>')" title="Hapus" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a></td>
                    </div>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>