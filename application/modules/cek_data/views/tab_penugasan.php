<style>
  .purple th{
    background-color:#d6e0ff;color:black;
  }
  </style>

<?php
$nip    =   $this->m_reff->san($this->input->post("nip"));
// $data   =   $this->db->get_where("data_pegawai",["nip"=>$nip])->row();
         
            $this->db->order_by("tmt","desc");
$kel    =   $this->db->get_where("tm_penugasan",["nip_pegawai"=>$nip])->result();
?>

 
<div class="table-responsive">
  <div class="  col-md-12">
 

  <div class="body">
<table class="entry2 " width="100%">
                        <thead class="purple">
                          <th>No</th>
                          <th>Nama jabatan</th>
                          <th>Penugasan jabatan lainnya</th>
                          <th>TMT</th>
                          <th>TGL SK</th>
                          <th>Nomor SK</th>
                          <th>Masa berlaku</th>
                        </thead>
                         
<?php
$no = 1;
foreach($kel as $val){
  
    echo "
    <tr>
    <td>".$no++."</td>
    <td>".$val->nama_penjab."</td>
    <td>".$val->penjab_lainnya."</td>
    <td>".$this->tanggal->ind($val->tmt,"/")."</td>
    <td>".$this->tanggal->ind($val->tgl_sk,"/")."</td>
    <td>".$val->no_sk."</td>
    <td>".$val->masa_berlaku."</td>
   
    </tr>";


}
?>
                         
  </table>
</div>

</div>
</div>
   