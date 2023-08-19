<div class="table-responsive">
    <table class="entry2 mb-4" width="100%" font="9px">
        <thead>
            <tr>
                <th>No</th>
                <th>Jenis Keminatan</th>
                <th>Negara</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php $n = 1;
            $h = $this->mdl->getKeminatanByNip($val)->result();
            foreach ($h as $t) {
                $jenis_keminatan = $t->jenis_keminatan ?? '';
                $negara = $t->negara ?? '';

            ?>
                <tr>
                    <td><?= $n++ ?></td>
                    <td><?= $jenis_keminatan; ?></td>
                    <td><?= $negara; ?></td>
                    <td><a href="#" onclick="formTableEdit('<?= $t->id ?? ''; ?>')" title="Edit" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                    <a href="#" onclick="hapusTable('<?= $t->id ?? ''; ?>','<?= $t->jenis_keminatan ?? ''; ?>')" title="Hapus" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>


