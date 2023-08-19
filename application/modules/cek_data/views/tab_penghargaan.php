<style>
  .purple th{
    background-color:#d6e0ff;color:black;
  }
  </style>

<?php
$nip    =   $this->m_reff->san($this->input->post("nip"));
// $data   =   $this->db->get_where("data_pegawai",["nip"=>$nip])->row();
          
$kel    =   $this->db->get_where("tm_penghargaan",["nip_pegawai"=>$nip])->result();
?>

 
<div class="table-responsive">
  <div class="  col-md-12">
 

  <div class="body">
<table class="entry2 " width="100%">
                        <thead class="purple">
                          <th>No</th>
                          <th>Jenis penghargaan</th>
                          <th>Instansi penyelenggara</th>
                          <th>Pemberi penghargaan</th>
                          <th>Nomor / ID</th>
                          <th>Tangal penerimaan</th>
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
    <td>".$val->jenis."</td>
    <td>".$val->instansi_pemberi."</td>
    <td>".$val->pemberi_penghargaan."</td>
    <td>".$val->nomor."</td>
     <td>".$this->tanggal->ind($val->tgl,"/")."</td>
     <td>".$lampiran."</td>
    </tr>";


}
?>
                         
  </table>
</div>

</div>
</div>
   