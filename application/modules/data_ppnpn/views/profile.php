<?php
    $nip        = $this->input->get_post("nip");
    $getPegawai = $this->db->get_where("data_pegawai", ["nip"=>$nip])->row();

    $nama       = isset($getPegawai->nama)?($getPegawai->nama):null;
    $nip        = isset($getPegawai->nip)?($getPegawai->nip):null;
    $istana     = isset($getPegawai->kode_istana)?($getPegawai->kode_istana):null;
    $istana     =   $this->m_reff->istana($istana);
    $jabatan    = isset($getPegawai->jabatan)?($getPegawai->jabatan):null;
    $bagian     = isset($getPegawai->bagian)?($getPegawai->bagian):null;
    $subbagian     = isset($getPegawai->subbagian)?($getPegawai->subbagian):null;
    $no_hp      = isset($getPegawai->no_hp)?($getPegawai->no_hp):null;
    $email      = isset($getPegawai->email)?($getPegawai->email):null;
    $id      = isset($getPegawai->id)?($getPegawai->id):null;

    // foto profile
    $foto = isset($getPegawai->foto)?($getPegawai->foto):null;
    if($foto != ""){
        $foto = $getPegawai->foto;
    }else{
        $foto = "default.jpg";
    }
    // end foto profile

    // nama biro
    $kode_biro = isset($getPegawai->kode_biro)?($getPegawai->kode_biro):null;
    $nama_biro = $this->m_reff->biro($kode_biro);
    // end nama biro

?>

<div class="row">
    <div class="col-4 text-center">
        <div class="card" style="width: 14rem;">
        <img class="card-img-top" src="<?=$this->m_reff->dp_ppnpn($id)?>" alt="Card image cap">
            <div class="card-body">
            <h5 class="card-title"><b><?=$nama?></b></h5>
            </div>
        </div>
        <img src="" alt="">
    </div>
    <div class="col-8">
        <table class="table table-bordered">
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td><?=$nama?></td>
            </tr>
            <tr>
                <td>NPP</td>
                <td>:</td>
                <td><?=$nip?></td>
            </tr>
            <tr>
                <td>Satuan Kerja</td>
                <td>:</td>
                <td><?=$istana?></td>
            </tr>
            <tr>
                <td>Biro</td>
                <td>:</td>
                <td><?=$nama_biro?></td>
            </tr>
           
            <tr>
                <td>Bagian</td>
                <td>:</td>
                <td><?=$bagian?></td>
            </tr>
            <tr>
                <td>Subbagian</td>
                <td>:</td>
                <td><?=$subbagian?></td>
            </tr>
            <tr>
                <td>No HP</td>
                <td>:</td>
                <td><?=$no_hp?></td>
            </tr>
            <tr>
                <td>Email</td>
                <td>:</td>
                <td><?=$email?></td>
            </tr>
        </table>
    </div>
</div>
                        