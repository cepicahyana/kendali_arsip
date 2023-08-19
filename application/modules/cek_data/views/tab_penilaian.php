<style>
  .purple th{
    background-color:#d6e0ff;color:black;
  }
  </style>

<?php
$nip    =   $this->m_reff->san($this->input->post("nip"));
// $data   =   $this->db->get_where("data_pegawai",["nip"=>$nip])->row();
         
       
$kel    =   $this->db->get_where("tm_penilaian_kinerja",["nip_pegawai"=>$nip])->result();
?>

 
<div class="table-responsive">
  <div class="  col-md-12">
 

  <div class="body">
<table class="entry2 " width="100%">
                        <thead class="purple">
                          <th>No</th>
                          <th>Tahun</th>
                          <th>Nilai rata-rata</th>
                          <th>Pejabat penilai</th>
                          <th>Atasan pejabat penilai</th>
                          <th>Keterangan</th>
                          <th>Lampiran</th>
                        </thead>
                         
<?php
$no = 1;
foreach($kel as $val){
    if($val->file){
        $file  =  $this->m_reff->encrypt($val->file);
    $lampiran =  ' <a  href="'.base_url().'download?f='.$file.'" class="text-info btn-block"> download </a>';
     }else{
      $lampiran = "-";
     }
    echo "
    <tr>
    <td>".$no++."</td>
    <td>".$val->tahun."</td>
    <td>".$val->nilai."</td>
    <td>".$val->pejabat_penilai."</td>
    <td>".$val->atasan_pejabat_penilai."</td>
    <td>".$val->ket."</td>
    <td>".$lampiran."</td>
    </tr>";
}
?>
                         
  </table>
</div>

</div>
</div>
   