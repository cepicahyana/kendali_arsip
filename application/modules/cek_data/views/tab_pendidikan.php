<style>
  .purple th{
    background-color:#d6e0ff;color:black;
  }
  </style>

<?php
$nip    =   $this->m_reff->san($this->input->post("nip"));
// $data   =   $this->db->get_where("data_pegawai",["nip"=>$nip])->row();
         
            $this->db->order_by("id_jenjang","desc");
$kel    =   $this->db->get_where("tm_pendidikan",["nip_pegawai"=>$nip])->result();

        
$keminatan    =   $this->db->get_where("tm_keminatan",["nip_pegawai"=>$nip])->result();
$pelatihan    =   $this->db->get_where("tm_pelatihan",["nip_pegawai"=>$nip])->result();
?>

 
<div class="table-responsive">
  <div class="  col-md-12">
 

  <div class="body">
      <h4>Riwayat pendidikan</h4>
<table class="entry2 " width="100%">
                        <thead class="purple">
                          <th>No</th>
                          <th>Nama Istitusi</th>
                          <th>Jenjang</th>
                          <th>Tahun lulus</th>
                          <th>Jurusan</th>
                          <th>IPK/Terakhir</th>
                          <th>Nomor Ijazah</th>
                     
                        </thead>
                         
<?php
$no = 1;
foreach($kel as $val){
   
    if($val->no_ijazah){
       $file  =  $this->m_reff->encrypt("dok/".$nip."/".$val->no_ijazah);
   $no_ijazah =  ' <a  href="'.base_url().'download?f='.$file.'" class="text-info btn-block"><i class="fa fa-file"></i> '.$val->no_ijazah.'</a>';
    }else{
     $no_ijazah = $val->no_ijazah;
    }
     

    echo "
    <tr>
    <td>".$no++."</td>
    <td>".$val->istitusi."</td>
    <td>".$this->m_reff->goField("tr_pendidikan","nama","where id='".$val->id_jenjang."'")."</td> 
    <td>".$val->tahun_lulus."</td> 
    <td>".$val->jurusan."</td>
    <td>".$val->ipk."</td>
    <td>".$val->no_ijazah."</td>
    </tr>";


}
?>
                         
  </table>
</div>
<hr>
<div class="body">
      <h4>Kemintaan</h4>
<table class="entry2 " width="100%">
                        <thead class="purple">
                          <th>No</th>
                          <th>Jenis Keminatan</th>
                          <th>Negara</th>
                        </thead>
                         
<?php
$no = 1;
foreach($keminatan as $val){
   
     
    echo "
    <tr>
    <td>".$no++."</td>
    <td>".$val->jenis_keminatan."</td>
    <td>".$val->negara."</td>
    </tr>";


}
?>
                         
  </table>
</div>
<hr>
<div class="body">
      <h4>Pelatihan</h4>
<table class="entry2 " width="100%">
                        <thead class="purple">
                          <th>No</th>
                          <th>Jenis pelatihan</th>
                          <th>Nama pelatihan</th>
                          <th>Tgl pelaksanaan</th>
                          <th>Lama pelatihan</th>
                          <th>Instansi penyelenggara</th>
                          <th>Nomor sertifikat</th>
                        </thead>
                         
<?php
$no = 1;
foreach($pelatihan as $val){
    if($val->no_sertifikat){
        $file  =  $this->m_reff->encrypt("dok/".$nip."/".$val->no_sertifikat);
    $no_sertifikat =  ' <a  href="'.base_url().'download?f='.$file.'" class="text-info btn-block"><i class="fa fa-file"></i> '.$val->no_sertifikat.'</a>';
     }else{
      $no_sertifikat = $val->no_sertifikat;
     }
      
     
    echo "
    <tr>
    <td>".$no++."</td>
    <td>".$val->jenis_pelatihan."</td>
    <td>".$val->nama_pelatihan."</td>
    <td>".$val->tgl_pelaksanaan."</td>
    <td>".$val->lama_pelatihan."</td>
    <td>".$val->instansi_penyelenggara."</td>
    <td>".$no_sertifikat."</td>
    </tr>";


}
?>
                         
  </table>
</div>

</div>
</div>
   