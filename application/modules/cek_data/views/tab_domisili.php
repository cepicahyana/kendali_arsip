<style>
  .purple th{
    background-color:#d6e0ff;color:black;
  }
  </style>

<?php
$nip    =   $this->m_reff->san($this->input->post("nip"));
$data   =   $this->db->get_where("data_pegawai",["nip"=>$nip])->row();
            $this->db->order_by("id","desc");
$kel    =   $this->db->get_where("tm_domisili",["nip_pegawai"=>$nip])->result();
$dth = isset($data->sts_hunian)?($data->sts_hunian):null;
?>
<div class="table-responsive">
  <div class="  col-md-12">
 

  <div class="body">
<!-- <h4>Domisili saat ini</h4> -->

                         <div class="alert alert-primary">
                      <b class="text-dange"> <i class="fa fa-home"></i>  
                      Domisili saat ini :  <?php echo $dth;?>  </b>
                         <br>
                                <?php
                                if(isset($data->id_prov)){
                                    echo "Provinsi ".$this->m_reff->provinsi($data->id_prov);
                                }
                                if(isset($data->id_kab)){
                                    echo "<br>".ucwords(strtolower($this->m_reff->kabupaten($data->id_kab)));
                                }
                                if(isset($data->id_kec)){
                                    echo "<br>Kecamatan ".$this->m_reff->kecamatan($data->id_kec);
                                }
                                if(isset($data->id_kel)){
                                    echo "<br>Kelurahan ".$this->m_reff->kelurahan($data->id_kel);
                                }
                                if(isset($data->alamat)){
                                    echo "<br>".$data->alamat;
                                } 
                              ?>
                           
                         </div>

</table>
 
<table class="entry2 " width="100%">
                        <thead class="purple">
                          <th>No</th>
                          <th>Status</th>
                          <th>Provinsi</th>
                          <th>Kab/Kota</th>
                          <th>Kecamatan</th>
                          <th>Kelurahan</th>
                          <th>Alamat</th>
                        </thead>
                      
<?php
$no = 1;
foreach($kel as $val){
   
    echo "
    <tr>
    <td>".$no++."</td>
    <td>".$val->sts_hunian."</td>
    <td>".$this->m_reff->provinsi($val->id_prov)."</td>
    <td>".$this->m_reff->kabupaten($val->id_kab)."</td>
    <td>".$this->m_reff->kecamatan($val->id_kec)."</td>
    <td>".$this->m_reff->kelurahan($val->id_kel)."</td>
    <td>".$val->alamat."</td>
    </tr>";
}
?>
                        
  </table>
</div>
</div>
 