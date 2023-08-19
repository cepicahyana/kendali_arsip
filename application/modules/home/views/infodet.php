<?php
$id     =   $this->input->post("id");
$this->db->where("id",$id);
$db     =   $this->db->get("data_absen")->row();
if(!isset($db)){ echo "data absen tidak ditemukan!"; return false;}
$tgl    = $this->tanggal->hariLengkap($db->tgl,"/");
?>

<h2 class="font-700 mb-n1 title_infodet"><?php echo $tgl;?></h2>
 <br>
 <table class="entry2" width="100%">
    <tr>
        <td>Absen Masuk</td><td><?php echo substr($db->jam_masuk,0,5)?></td>
    </tr>
    <tr>
        <td>Absen Pulang</td><td><?php echo substr($db->jam_pulang,0,5)?></td>
    </tr>
    <?php 
    if($db->jam_pulang!="00:00:00" and $db->jam_pulang!=null){
        ?>
    <tr>
        <td>Lama bekerja</td><td><?php echo $this->tanggal->hitungJam($db->tgl." ".$db->jam_masuk,$db->tgl." ".$db->jam_pulang); ?></td>
    </tr>
    <?php } ?>
</table>
 <br>
 
 <?php
 if($db->ket_lembur){?>
 <div style="text-align:left">Alasan lembur :</div>
<div style='color:black;margin-top:-10px;text-align:left'> <?php echo $db->ket_lembur?></div>
 <br/>
 <?php } ?>
<table class="entry2" width="100%">
   
<?php
$this->db->where("nip",$this->m_reff->nip());
$this->db->where("tgl",$db->tgl);
$dt = $this->db->get("data_tugas_harian")->result();
foreach($dt as $v){?>

 <tr><td align="left">

 <?php echo $v->deskripsi;?>. 
<?php if($v->mulai!="00:00:00"){?>
<i class="text-success" style="font-size:11px"> | <?php echo substr($v->mulai,0,5);?> - <?php echo substr($v->akhir,0,5);?>
</i><?php } ?>
 
</td>
</tr>
 
  

<?php } ?>
</table>
 
 <br>
<center>
<a href="javascript:close_infodet()" class="close-menu btn btn-sm  button-s shadow-l
 rounded-s text-uppercase font-900 bg-green1-dark">close</a>
</center>
<br>