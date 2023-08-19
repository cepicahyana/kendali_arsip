<div class="table-responsive">
    <table class="entry2 mb-4" width="100%" font="9px">
        <thead>
            <tr>
                <th>No</th>
                <th>Hubungan keluarga</th>
                <th>Status hubungan</th>
                <th>Nama</th>
                <th>NIK</th>
                <th>Tempat, Tgl lahir</th>
                <th>Pekerjaan</th>
                <th>No BPJS</th>
                <th>Sts</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php $n = 1;
            $h = $this->mdl->getKeluargaByNip($val)->result();
            foreach ($h as $t) {
                $idhubungan = $t->id_hubungan    ?? '';
                // $dbhubungan = $this->db->get_where('tr_hubungan', array('id' => $idhubungan))->row();
                $hub        = $this->m_reff->hubungan($idhubungan,$t->jk);
                $tgl_lahir = isset($t->tgl_lahir) ? date('d/m/Y', strtotime($t->tgl_lahir)) : '';
                $status = $t->sts_hidup ?? '';
                if ($status == 1) {
                    $sts_hidup = 'hidup';
                } else {
                    $sts_hidup = 'meninggal';
                }
            ?>
                <tr>
                    <td><?= $n++ ?></td>
                    <td><?= $hub;?></td>
                    <td><?= $t->sts_hubungan ?? ''; ?></td>
                    <td><?= $t->nama ?? ''; ?></td>
                    <td><?= $t->nik ?? ''; ?></td>
                    <td><?= $t->tempat_lahir ?? ''; ?>, <?= $tgl_lahir ?></td>
                    <td><?= $t->pekerjaan ?? ''; ?></td>
                    <td><?= $t->bpjs ?? ''; ?></td>
                    <td><?= $sts_hidup ?></td>
                    <td>
                    <div  class="btn-group">
                    <a href="#" onclick="formTableEdit('<?= $t->id ?? ''; ?>')" title="Edit" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                    <a href="#" onclick="hapusTable('<?= $t->id ?? ''; ?>','<?= $t->nama ?? ''; ?>')" title="Hapus" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                    </div>
                </td>

                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>