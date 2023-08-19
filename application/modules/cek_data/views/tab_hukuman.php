<style>
  .purple th{
    background-color:#d6e0ff;color:black;
  }
  </style>

<?php
$nip    =   $this->input->post("nip");
// $data   =   $this->db->get_where("data_pegawai",["nip"=>$nip])->row();
         
       
$kel    =   $this->db->get_where("tm_hukuman",["nip_pegawai"=>$nip])->result();


?>

 
<div class="table-responsive">
  <div class="  col-md-12">
 

  <div class="body">
<table class="entry2 " width="100%">
                        <thead class="purple">
                          <th>No</th>
                          <th>Jenis hukuman</th>
                          <th>Nomor SK</th>
                          <th>TMT akhir hukuman</th>
                          <th>Masa berlaku</th>
                          <th>No PP</th>
                          <th>Potongan (%)</th>
                          <th>Pelanggaran yang dilakukan</th>
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
    <td>".$val->jenis_hukuman."</td>
    <td>".$val->no_sk."</td>
    <td>".$val->tmt_akhir."</td>
    <td>".$val->masa_berlaku."</td>
    <td>".$val->no_pp."</td>
    <td>".$val->potongan."</td>
    <td>".$val->pelanggaran."</td>
    <td>".$lampiran."</td>
    </tr>";
}
?>
                         
  </table>
</div>

</div>
</div>
   