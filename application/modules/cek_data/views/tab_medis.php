<style>
  .purple th{
    background-color:#d6e0ff;color:black;
  }
  </style>

<?php
$nip    =   $this->m_reff->san($this->input->post("nip"));
// $data   =   $this->db->get_where("data_pegawai",["nip"=>$nip])->row();
         
       
$kel    =   $this->db->get_where("tm_medis",["nip_pegawai"=>$nip])->result();
$vaksin =   $this->db->get_where("tm_vaksin",["nip_pegawai"=>$nip])->result();
            $this->db->order_by("konfirm_rs","desc");
$tes    =   $this->db->get_where("v_test",["jenis_pegawai!="=>null,"nip"=>$nip])->result();
?>

 
<div class="table-responsive">
  <div class="  col-md-12">
 
<h4>Riwayat medis</h4>
  <div class="body">
<table class="entry2 " width="100%">
                        <thead class="purple">
                          <th>No</th>
                          <th>Tgl MCU</th>
                          <th>Kesimpulan</th>
                          <th>Saran tindak lanjut</th> 
                          <th>File hasil MCU</th> 
                        </thead>
                         
<?php
$no = 1;
foreach($kel as $val){

  if($val->file_mcu){
    $file  =  $this->m_reff->encrypt($val->file_mcu);
$file_mcu =  ' <a  href="'.base_url().'download?f='.$file.'" class="text-info btn-block"><i class="fa fa-file"></i> Hasil mcu</a>';
 }else{
  $file_mcu = "-";
 }
     
    echo "
    <tr>
    <td>".$no++."</td>
    <td>".$val->tgl_mcu."</td>
    <td>".$val->kesimpulan."</td>
    <td>".$val->saran."</td>
    <td>".$file_mcu."</td>
    
    </tr>";
}
?>
                         
  </table>
</div>
<hr>

<h4>Riwayat vaksinasi</h4>
  <div class="body">
<table class="entry2 " width="100%">
                        <thead class="purple">
                          <th>No</th>
                          <th>Tahun dialami</th>
                          <th>Jenis vaksin</th>
                          <th>Penanganan</th> 
                        </thead>
                         
<?php
$no = 1;
foreach($vaksin as $val){
     
    echo "
    <tr>
    <td>".$no++."</td>
    <td>".$val->tgl_vaksin."</td>
    <td>".$val->jenis_vaksin."</td>
    <td>".$val->ket."</td>
    
    </tr>";
}
?>
                         
  </table>
</div>
 
<hr>

<h4>Riwayat tes covid</h4>
  <div class="body">
<table class="entry2 " width="100%">
                        <thead class="purple">
                          <th>No</th>
                          <th>Tanggal test</th>
                          <th>Tempat test</th>
                          <th>Jenis test</th>
                          <th>Hasil test</th> 
                        </thead>
                         
<?php
$no = 1;
foreach($tes as $val){
     
    echo "
    <tr>
    <td>".$no++."</td>
    <td>".$val->konfirm_rs."</td>
    <td>".$this->m_reff->tempat_tes($val->kode_tempat)."</td>
    <td>".$this->m_reff->jenis_tes($val->kode_jenis)."</td>
    <td>".$val->hasil."</td>
    
    </tr>";
}
?>
                         
  </table>
</div>

</div>
</div>
   