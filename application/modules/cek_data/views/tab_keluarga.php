<style>
  .purple th{
    background-color:#d6e0ff;color:black;
  }
  </style>

<?php
$nip    =   $this->m_reff->san($this->input->post("nip"));
$data   =   $this->db->get_where("data_pegawai",["nip"=>$nip])->row();

            $this->db->order_by("id_hubungan","asc");
            $this->db->order_by("tgl_lahir","asc");
$kel    =   $this->db->get_where("data_keluarga",["nip_pegawai"=>$nip])->result();
?>

 
<div class="table-responsive">
  <div class="  col-md-12">
 

  <div class="body">
<table class="entry2 " width="100%">
                        <thead class="purple">
                          <th>No</th>
                          <th>Hubungan keluarga</th>
                          <th>Status hubungan</th>
                          <th>Nama</th>
                          <th>NIK</th>
                          <th>Tempat, Tgl lahir</th>
                          <!-- <th>Domisili</th> -->
                          <th>Pekerjaan</th>
                          <th>No BPJS</th>
                          <th>Sts</th>
                        </thead>
                         
<?php
$no = 1;
foreach($kel as $val){
  $sts_hidup    = ($val->sts_hidup==1)?"Hidup":"meninggal";
  $sts_hubungan = null;
  if($val->sts_hubungan){
    $sts_hubungan = $val->sts_hubungan;
  }
    echo "
    <tr>
    <td>".$no++."</td>
    <td>".$this->m_reff->hubungan($val->id_hubungan,$val->jk)."</td>
    <td>".$sts_hubungan."</td>
    <td>".$val->nama."</td>
    <td>".$val->nik."</td>
    <td>".$val->tempat_lahir.", ".$this->tanggal->ind($val->tgl_lahir,"/")."</td>
    <td>".$val->pekerjaan."</td>
    <td>".$val->bpjs."</td>
    <td>".$sts_hidup."</td>
    </tr>";


}
?>
                         
  </table>
</div>

</div>
</div>
  
 <div class="card-body">
 <?php
 if(isset($data->file_kk)){
    $file  =  $this->m_reff->encrypt($data->file_kk);
echo ' <a  href="'.base_url().'download?f='.$file.'" class="text-info btn-block"><i class="fa fa-file"></i> File kartu keluarga</a>';
 }else{
  echo ' <a  href="javascript:alert(`file belum tersedia`)" class="text-secondary btn-block"><i class="fa fa-file"></i> File kartu keluarga</a>';

 }?>


 <?php
 if(isset($data->file_bpjs)){
    $file  =  $this->m_reff->encrypt($data->file_bpjs);
echo ' <a  href="'.base_url().'download?f='.$file.'" class="text-info btn-block"><i class="fa fa-file"></i> File BPJS</a>';
 }else{
  echo ' <a  href="javascript:alert(`file belum tersedia`)" class="text-secondary btn-block"><i class="fa fa-file"></i> File BPJS</a>';

 }?>
<!--  -->
  
</div>

 