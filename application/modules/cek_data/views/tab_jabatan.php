<style>
  .purple th{
    background-color:#d6e0ff;color:black;
  }
  </style>
  <?php
$nip    =   $this->m_reff->san($this->input->post("nip"));
  // $data   =   $this->db->get_where("data_pegawai",["nip"=>$nip])->row();

  $list   =   $this->db->get_where("tm_jabatan",["nip_pegawai"=>$nip])->result();
  ?>
  <div class="table-responsive">
  <div class="  col-md-12">
 

  <div class="body">
<table class="entry2 " width="100%">
                        <thead class="purple">
                          <th>No</th>
                          <th>Jenis Jabatan</th>
                          <th>Nama Jabatan</th>
                          <th>Grade</th>
                          <th>TMT</th>
                          <th>TGL SK JABATAN</th>
                          <th>No.SK JABATAN</th>
                      
                          <th>TGL SK ESELON</th>
                          <th>No.SK ESELON</th>
                        
                        </thead>
                       
                        <?php

 

$no = 1;
foreach($list as $val){

     
 if($val->file_sk_jabatan){
    $file  =  $this->m_reff->encrypt("dok/".$nip."/".$val->file_sk_jabatan);
$file_sk_jabatan =  ' <a  href="'.base_url().'download?f='.$file.'" class="text-info btn-block"><i class="fa fa-file"></i>
 '.$val->no_sk_jabatan.'</a>';
 $no_sk_jabatan = $file_sk_jabatan;
}else{
  $file_sk_jabatan = "-";
  $no_sk_jabatan = $val->no_sk_jabatan;
 } 


 if($val->file_sk_eselon){
    $file  =  $this->m_reff->encrypt("dok/".$nip."/".$val->file_sk_eselon);
    $file_sk_eselon =  ' <a  href="'.base_url().'download?f='.$file.'" class="text-info btn-block"><i class="fa fa-file"></i>
    '.$val->no_sk_eselon.'</a>';
    $no_sk_eselon = $file_sk_eselon;
}else{
  $file_sk_eselon = "-";
  $no_sk_eselon   = $val->no_sk_eselon;
 } 
    echo "
    <tr>
    <td>".$no++."</td>
    <td>".$val->nama."</td>
    <td>".$val->jenis."</td>
    <td>".$val->grade."</td>
    <td>".$val->tmt."</td>
    <td>".$val->tgl_sk_jabatan."</td>
    <td>".$no_sk_jabatan."</td>
 
    <td>".$val->tgl_sk_eselon."</td>
    <td>".$no_sk_eselon."</td>
    </tr>";

}
?>
                        
</table>
</div>
</div>
</div>

 