<style>
  .purple th{
    background-color:#d6e0ff;color:black;
  }
  </style>
  <?php
  $nip    =   $this->input->post("nip");
  // $data   =   $this->db->get_where("data_pegawai",["nip"=>$nip])->row();

  $golongan =   $this->db->get_where("tm_golongan",["nip_pegawai"=>$nip])->result();
  ?>
  <div class="table-responsive">
  <div class="  col-md-12">
 

  <div class="body">
<table class="entry2 " width="100%">
                        <thead class="purple">
                          <th>No</th>
                          <th>Golongan</th>
                          <th>Pangkat</th>
                          <th>TMT</th>
                          <th>Masa kerja golongan</th>
                          <th>Jenis kenaikan pangkat</th>
                          <th>Tanggal SK</th>
                          <th>No SK</th>
                          <th>Lampiran</th>
                        </thead>
                       
                        <?php
$no = 1;
foreach($golongan as $val){

     
 if($val->file){
    $file  =  $this->m_reff->encrypt($val->file);
$lampiran =  ' <a  href="'.base_url().'download?f='.$file.'" class="text-info btn-block"><i class="fa fa-file"></i> File </a>';
 }else{
  $lampiran = "-";
 } 
    echo "
    <tr>
    <td>".$no++."</td>
    <td>".$val->golongan."</td>
    <td>".$this->m_reff->pangkat($val->golongan)."</td>
    <td>".$val->tmt."</td>
    <td>".$val->masa_kerja."</td>
    <td>".$val->jenis_kenaikan_pangkat."</td>
    <td>".$val->tgl_sk."</td>
    <td>".$val->no_sk."</td>
    <td>".$lampiran."</td>
    </tr>";

}
?>
                        
</table>
</div>
</div>
</div>

 