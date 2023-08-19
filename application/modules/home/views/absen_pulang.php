<?php

        $this->db->where("nip",$this->m_reff->nip());
		$this->db->where("tgl",date('Y-m-d'));
		$cek = $this->db->get("data_absen")->row();
        $jenis_absen = isset($cek->jenis_absen)?($cek->jenis_absen):null;
		$jam_pulang  = isset($cek->jam_pulang)?($cek->jam_pulang):date('H:i:s');
		$jam_masuk   = isset($cek->jam_masuk)?($cek->jam_masuk):date('H:i:s');
		$ket_lembur  = isset($cek->ket_lembur)?($cek->ket_lembur):null;

$jamSetingMasuk =   $this->m_umum->jam_masuk();
if($jam_masuk==0){
    $jam_masuk_min = $jamSetingMasuk;
}else{
    $jam_masuk_min = $jam_masuk;
}
 
  $jLembur=$this->m_umum->hitungLembur($jam_masuk_min,$jam_pulang);
  $jLembur = substr($jLembur,0,2);
 
if($jLembur!="00" and $jLembur!="" and $jLembur!=null){
    $form  = "<textarea name='txtLembur' style='min-height:230px;font-size:14px' placeholder='Tulis apa yang anda kerjakan pada lembur kali ini...'
     class='form-control' name='catatan_lembur'>".$ket_lembur."</textarea>";
    $title = "<p style='line-height:14px;margin-top:10px'>Anda terhitung lembur, silahkan 
    isi pekerjaan lembur anda sebagai syarat sah anda lembur.</p>";
    $btn   = '<button  onclick="setAbsen(6)" class="btn btn-3d btn-m btn-full mb-3 btn-block rounded-xs text-uppercase 
    font-900 shadow-s  border-brown-dark bg-brown-light sadow">  TIDAK LEMBUR </button>';
    echo "<script>
    document.getElementById('menu-welcome-modal-pulang').setAttribute('style', 'display: block; height: 520px; width: 310px;'); 
    </script>";
}else{

    $title  =   "";
    $btn    =   "";
    $form   =   "<input type='hidden' name='txtLembur' value=' '></input>";
    echo "<script>
    document.getElementById('menu-welcome-modal-pulang').setAttribute('style', 'display: block; height: 180px; width: 310px;'); 
    </script>";
}
?>


<h2 class="font-700 mb-n1">ABSEN PULANG</h2>
<?php echo $title;?>
<?php echo $form;?><br>
<button  onclick="konfirmasiPulang(`<?=$jenis_absen;?>`)" class="btn btn-3d btn-m btn-full mb-3 btn-block rounded-xs text-uppercase 
font-900 shadow-s  border-blue-dark bg-blue-light sadow"> KONFIRMASI </button>
 <?= $btn ?>
<br>