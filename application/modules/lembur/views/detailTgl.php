<?php
$tgl     =   $this->m_reff->san($this->input->post("tgl"));
$nip     =   $this->m_reff->san($this->input->post("nip"));
$this->db->where("tgl",$tgl);
$this->db->where("nip",$nip);
$db     =   $this->db->get("data_absen")->row();
if(!isset($db)){
    echo "data tidak ditemukan!";
    return false;
}
$tgl    = $this->tanggal->hariLengkap($db->tgl,"/");
?>

<h4 class="font-700 mb-n1 title_infodet"><?php echo $tgl;?></h4>
 <br>
 <table class="entry2" width="100%">
    <tr>
        <td width="200px" colspan="2">
          <b style="text-transform:uppercase" class='text-primary'> <i class='fa fa-user'></i> <?php echo $this->m_reff->goField("data_pegawai","nama","where nip='".$nip."'");?>
            - 
            <?php echo $this->m_reff->jenis_absen($db->jenis_absen)?> </b> </td>
    </tr>
    <tr>
        <td width="200px">Absen Masuk</td><td><?php echo substr($db->jam_masuk,0,5)?> WIB</td>
    </tr>
    <tr>
        <td>Absen Pulang</td><td><?php echo substr($db->jam_pulang,0,5)?> WIB</td>
    </tr>
    <tr>
        <td>Terlambat</td><td><?php echo $this->tanggal->sebutanWaktu(substr($db->telat,0,5))?> </td>
    </tr>
    <tr>
        <td>Lama lembur</td><td><?php echo $this->tanggal->sebutanWaktu(substr($db->lembur,0,5))?> </td>
    </tr>
    <?php 
    if($db->jam_pulang!="00:00:00" and $db->jam_pulang!=null){
        ?>
    <tr>
        <td>Lama bekerja</td><td><?php echo $this->tanggal->sebutanWaktu(substr($db->lama_bekerja,0,5))?></td>
    </tr>
    <?php } ?>
</table>
 <br>
 <div class="divider divider-margins bg-highlight"></div>
 
<table class="entry2" width="100%">
   <thead>
       <th>No</th>
       <th>Kegiatan</th>
    </thead>
<?php
$this->db->where("nip",$nip);
$this->db->where("tgl",$this->input->post("tgl"));
$dt = $this->db->get("data_tugas_harian")->result();
$no=1;
foreach($dt as $v){?>

 <tr>
 <td width="50px"><?php echo $no++;?></td>    
 <td align="left">

 <?php echo $v->deskripsi;?>. 
<?php if($v->mulai!="00:00:00"){?>
<i class="text-success" style="font-size:11px"> | <?php echo substr($v->mulai,0,5);?> - <?php echo substr($v->akhir,0,5);?>
</i><?php } ?>
 
</td>
</tr>
 
  

<?php } ?>
</table>
 
 