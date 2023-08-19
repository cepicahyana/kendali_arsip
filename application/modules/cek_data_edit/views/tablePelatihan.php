<div class="table-responsive">
    <table class="entry2 mb-4" width="100%" font="9px">
        <thead>
            <tr>
                <th>No</th>
                <th>Jenis pelatihan</th>
                <th>Nama pelatihan</th>
                <th>Tgl pelaksanaan</th>
                <th>Lama pelatihan</th>
                <th>Instansi penyelenggara</th>
                <th>Nomor sertifikat</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php $n = 1;
            $h = $this->mdl->getPelatihanByNip($val)->result();
            foreach ($h as $t) {
                $nip_pegawai = $t->nip_pegawai ?? '';

                $tgl_pelaksanaan = isset($t->tgl_pelaksanaan) ? date('d/m/Y', strtotime($t->tgl_pelaksanaan)) : '';
           
                $jenis_pelatihan = $t->jenis_pelatihan ?? '';
                $nama_pelatihan = $t->nama_pelatihan ?? '';
                $lama_pelatihan = $t->lama_pelatihan ?? '';
                $instansi_penyelenggara = $t->instansi_penyelenggara ?? '';

                if ($t->no_sertifikat) {
                    $file  =  $this->m_reff->encrypt($t->file_sertifikat);
                    $no_sertifikat =  ' <a  href="' . base_url() . 'download?f=' . $file . '" class="text-info btn-block"><i class="fa fa-file"></i> ' . $t->no_sertifikat . '</a>';
                } else {
                    $no_sertifikat = $t->no_sertifikat;
                }

            ?>
                <tr>
                    <td><?= $n++ ?></td>
                    <td><?= $jenis_pelatihan; ?></td>
                    <td><?= $nama_pelatihan; ?></td>
                    <td><?= $tgl_pelaksanaan; ?></td>
                    <td><?= $lama_pelatihan; ?></td>
                    <td><?= $instansi_penyelenggara; ?></td>
                    <td><?= $no_sertifikat; ?></td>
                    <td>
                        <div class="btn-group">
                            <a href="#" onclick="formTableEdit('<?= $t->id ?? ''; ?>')" title="Edit" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                        <a href="#" onclick="hapusTable('<?= $t->id ?? ''; ?>','<?= $t->nama_pelatihan ?? ''; ?>')" title="Hapus" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>