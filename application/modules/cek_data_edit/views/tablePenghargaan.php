<div class="table-responsive">
    <table class="entry2 mb-4" width="100%" font="9px">
        <thead>
            <tr>
                <th>No</th>
                <th>Jenis penghargaan</th>
                <th>Instansi penyelenggara</th>
                <th>Pemberi penghargaan</th>
                <th>Nomor / ID</th>
                <th>Tangal penerimaan</th>
                <th>Lampiran</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php $n = 1;
            $h = $this->mdl->getPenghargaanByNip($val)->result();
            foreach ($h as $t) {
                $nip_pegawai = $t->nip_pegawai ?? '';
                $jenis = $t->jenis ?? '';
                $instansi_pemberi = $t->instansi_pemberi ?? '';
                $pemberi_penghargaan = $t->pemberi_penghargaan ?? '';
                $nomor = $t->nomor ?? '';
                $tgl = isset($t->tgl) ? date('d/m/Y', strtotime($t->tgl)) : '';
                if ($t->file) {
                    $file  =  $this->m_reff->encrypt($t->file);
                    $lampiran =  ' <a  href="' . base_url() . 'download?f=' . $file . '" class="text-info btn-block"> download </a>';
                } else {
                    $lampiran = "-";
                }

            ?>
                <tr>
                    <td><?= $n++ ?></td>
                    <td><?= $jenis; ?></td>
                    <td><?= $tgl; ?></td>
                    <td><?= $instansi_pemberi; ?></td>
                    <td><?= $pemberi_penghargaan; ?></td>
                    <td><?= $nomor; ?></td>
                    <td><?= $lampiran; ?></td>
                    <td>
                        <div class="btn-group">
                        <a href="#" onclick="formTableEdit('<?= $t->id ?? ''; ?>')" title="Edit" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                        <a href="#" onclick="hapusTable('<?= $t->id ?? ''; ?>','<?= $t->jenis ?? ''; ?>')" title="Hapus" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>