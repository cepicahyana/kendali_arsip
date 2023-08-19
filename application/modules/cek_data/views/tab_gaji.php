<style>
  .purple th{
    background-color:#d6e0ff;color:black;
  }
  </style>

<?php
$nip    =   $this->input->post("nip");
// $data   =   $this->db->get_where("data_pegawai",["nip"=>$nip])->row();
         
            $this->db->order_by("tmt","desc");
$kel    =   $this->db->get_where("tm_gaji",["nip_pegawai"=>$nip])->result();
?>

 
<div class="table-responsive">
  <div class="  col-md-12">
 

  <div class="body">
<table class="entry2 " width="100%">
                        <thead class="purple">
                          <th>No</th>
                          <th>Pangkat/golongan</th>
                          <th>TMT</th>
                          <th>Nomor SK</th>
                          <th>MK golongan tahun</th>
                          <th>MK golongan bulan</th>
                          <th>Gapok lama</th>
                          <th>Gapok baru</th>
                          <th>Keterangan </th>
                        </thead>
                         
<?php
$no = 1;
foreach($kel as $val){
  
    echo "
    <tr>
    <td>".$no++."</td>
    <td>".$this->m_reff->panggol($val->golongan)."</td>
    <td>".$val->tmt."</td> 
    <td>".$val->no_sk."</td>
    <td>".$val->mk_gol_tahun."</td>
    <td>".$val->mk_gol_bulan."</td>
    <td>".number_format($val->gapok_lama,0,",",".")."</td>
    <td>".number_format($val->gapok_baru,0,",",".")."</td>
    <td>".$val->ket."</td>
    </tr>";
}
?>
                         
  </table>
</div>

</div>
</div>
   