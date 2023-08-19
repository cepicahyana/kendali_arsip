<div class="table-responsive">
    <table class="entry2 mb-4" width="100%" font="9px">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Istitusi</th>
                <th>Jenjang</th>
                <th>Tahun lulus</th>
                <th>Jurusan</th>
                <th>IPK Terakhir</th>
                <th>Nomor Ijazah</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php $n = 1;
            $h = $this->mdl->getPendidikanByNip($val)->result();
            foreach ($h as $t) {
                $istitusi = $t->istitusi ?? '';
                $id_jenjang = $t->id_jenjang ?? '';

                $dbjenjang=$this->db->get_where('tr_pendidikan',array('id'=>$id_jenjang))->row();
                $jenjang = $dbjenjang->nama ?? '';

                $tahun_lulus = $t->tahun_lulus ?? '';
                $jurusan = $t->jurusan ?? '';
                $ipk = $t->ipk ?? '';
                $no_ijazah = $t->no_ijazah ?? '';
            ?>
                <tr>
                    <td><?= $n++ ?></td>
                    <td><?= $istitusi; ?></td>
                    <td><?= $jenjang; ?></td>
                    <td><?= $tahun_lulus; ?></td>
                    <td><?= $jurusan; ?></td>
                    <td><?= $ipk; ?></td>
                    <td><?= $no_ijazah; ?></td>
                    <td><a href="#" onclick="formTableEdit('<?= $t->id ?? ''; ?>')" title="Edit" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                    <a href="#" onclick="hapusTable('<?= $t->id ?? ''; ?>','<?= $t->istitusi ?? ''; ?>')" title="Hapus" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>