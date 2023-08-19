<style>
  .purple th{
    background-color:#d6e0ff;color:black;
  }
  </style>
<?php
$nip    =   $this->m_reff->san($this->input->post("nip"));
$data   =   $this->db->get_where("data_pegawai",["nip"=>$nip])->row();
if(!isset($data)){
  return false;
}
?>
<table class="entry2" width="100%">
  <thead class="purple">
    <th colspan="2"><i class="fa fa-user-tie"></i> Data kepegawaian
  <i class="float-right" style="color:blue;font-weight:normal">syncron: <?php echo ($data->sync)??"-";?></i>
  </th>
</thead>
                        <tr>
                              <td width="200px">Status keaktifan</td>
                              <td><?=$data->sts_keaktifan;?></td>
                          </tr>
                        <tr>
                              <td><?php echo $data->jenis_pegawai==1?"NIP Lama":"NPP"; ?></td>
                              <td><?=$data->nip;?></td>
                          </tr>
                          <?php if($data->jenis_pegawai==1){  ?>
                          <tr>
                              <td>NIP Baru</td>
                              <td><?=$data->nip_baru;?></td>
                          </tr>
                          <?php } ?>
                          <tr>
                              <td>Jabatan</td>
                              <td><?=$data->jabatan;?></td>
                          </tr>
                          <tr>
                              <td>Jenjang jabatan</td>
                              <td><?=$data->jenjang_jabatan;?></td>
                          </tr>
                          <tr>
                              <td>TMT Jabatan</td>
                              <td><?=$data->tmt_jabatan_akhir;?></td>
                          </tr>
                          <tr>
                              <td>Penugasan jabatan lain</td>
                              <td><?=$data->penjab_lain;?></td>
                          </tr>
                          <tr>
                              <td>Golongan</td>
                              <td><?=$data->golongan;?></td>
                          </tr>
                        <tr>
                              <td width="200px">Instansi</td>
                              <td><?=$this->m_reff->istana($data->kode_istana);?></td>
                          </tr>
                        <tr>
                              <td width="200px">Deputi</td>
                              <td><?=$this->m_reff->deputi($data->kode_biro);?></td>
                          </tr>
                        <tr>
                              <td width="200px">Biro</td>
                              <td><?=$this->m_reff->biro($data->kode_biro);?></td>
                          </tr>
                        <tr>
                              <td width="200px">Bagian</td>
                              <td><?=$data->bagian;?></td>
                          </tr>
                        <tr>
                              <td width="200px">Subbagian</td>
                              <td><?=$data->subbagian;?></td>
                          </tr>
                        <tr>
                              <td width="200px">No.KARPEG</td>
                              <td><?=$data->karpeg;?></td>
                          </tr>
                        <tr>
                              <td width="200px">TMT setpres</td>
                              <td><?=$this->tanggal->ind($data->tmt,"-");?></td>
                          </tr>
                        <tr>
                              <td width="200px">Status Kepegawaian</td>
                              <td><?=$data->sts_kepegawaian;?></td>
                          </tr>
                        <tr>
                              <td width="200px">Batas usia pensiun</td>
                              <td><?=$data->bup;?></td>
                          </tr>
                        <tr>
                              <td width="200px">Batas usia pensiun tambahan</td>
                              <td><?=$data->bup_tambahan;?></td>
                          </tr>
                       
                        </table>


                        <div class="card-bodys"><br>


 <?php
 if($data->file_nip){
    $file  =  $this->m_reff->encrypt($data->file_nip);
echo ' <a  href="'.base_url().'download?f='.$file.'" class="text-info btn-block"><i class="fa fa-file"></i> File Penetapan NIP</a>';
 }else{
  echo ' <a  href="javascript:alert(`file belum tersedia`)" class="text-secondary btn-block"><i class="fa fa-file"></i> File Penetapan NIP</a>';

 }?>

 <?php
 if($data->file_karpeg){
    $file  =  $this->m_reff->encrypt($data->file_karpeg);
echo ' <a  href="'.base_url().'download?f='.$file.'" class="text-info btn-block"><i class="fa fa-file"></i> File Kartu Pegawai</a>';
 }else{
  echo ' <a  href="javascript:alert(`file belum tersedia`)" class="text-secondary btn-block"><i class="fa fa-file"></i> File Kartu Pegawai</a>';

 }?>




 
