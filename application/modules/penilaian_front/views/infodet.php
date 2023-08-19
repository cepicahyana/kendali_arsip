<?php 
$id  =   $this->input->post("id");
        $this->db->where("id",$id);
$db  =   $this->db->get("penilaian_kinerja_ppnpn")->row();
if(!isset($db)){
    echo "data tidak ditemukan!"; 
   return false;
}
$komentar = isset($db->komentar)?($db->komentar):"";
?>

<style>
.ijo {
    background-color:#37BC9B;
}
</style>

<div class="">
    <h4 class="mb-4 pt-1">INDIKATOR PENILAIAN</h4>
    </div>
<div class="table-responsive">
    <table class="entry2 table-borderless" width="99%">
        <thead>
            <tr class="ijo text-white">
                <th class="text-left">Indikator</th>
                <!-- <th>Bobot</th>
                <th>Skor</th> -->
                <th>Nilai</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $indikator = $db->data_penilaian;
        $indi = json_decode($indikator);
        if(isset($indi)){
                    foreach ($indi as $in) { ?>
                        <tr>
                            <td class="text-left"><?= $in->indikator; ?></td>
                            <!-- <td><?= $in->bobot; ?></td>
                            <td><?= $in->skor; ?></td> -->
                            <td class="text-center"><?= $in->nilai; ?></td>
                        </tr> 

                    <?php } 
        }?>
        </tbody>
    </table>

    <table class="entry2 table-borderless mt-5" width="99%">
        <thead>
            <tr class="">
                <th>Evaluasi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?=$komentar?></td>
            </tr>
        </tbody>
    </table>
</div>
<br>
<a href="javascript:tutupPenilaian()" class="btn btn-m  mb-3 rounded-xs text-uppercase font-900 shadow-s bg-dark-light">Tutup</a>