<?php
  $kode         =   $this->session->userdata("kode");
  $sesi_kode    =   $this->session->userdata("sesi_kode");
  if($sesi_kode==true and $kode )
  {
     $data  =   $this->db->query("select * from data_acara where kode='".$kode."' ")->row();
	 //if(!$data){ redirect("welcome/tutupapp");}
     $tgl   =   $data->tgl;
     $durasi =   $data->durasi;
     if($durasi==1)
     {
         $tgl   =   $this->tanggal->hariLengkap($tgl,"-");
     }else{
         $tgl   =   $this->tanggal->hariLengkap($tgl,"-"). " s/d<br> ".$this->tanggal->hariLengkap($this->tanggal->tambahTgl($tgl,$durasi),"-");
     }
   ?>
    
   <div class="card"> 
    <table class='entry' style='width:100%'>
        <tr>
    <td>Kode Acara</td><td><?php echo $data->kode;?></td>
    </tr>
    <tr>
    <td colspan='2' align='center'> <?php echo $data->agenda;?></td>
    </tr>
    <tr>
    <td>Pelaksanaan </td><td><?php echo $tgl;?></td>
    </tr>
     <tr>
    <td>Total Undangan </td><td><?php 
    $this->db->where("kode_acara",$kode);
    $this->db->where("hapus",0);
     $this->db->where_in("sts_ikutserta",array("1","2"));
    echo $this->db->get_where("data_peserta",array("kode_acara"=>$kode))->num_rows();?></td>
    </tr>
    </table>
    </div>
    <br><br><br>
    <center>
        
   
    <a style="height:70px" href="scan" class='btn btn-lg bg-blue-grey'><br>[ [ SCAN UNDANGAN ] ]</a>
     </center>
    
   <?php
      
      
  }else{ 
?>
 
<center>
    <?php
    if(strlen($kode)>2)
    {
        echo "<span class='col-red'> Kode acara : <u>".$kode."</u>  tidak ditemukan.</span>";
    }
    ?>
<form action="<?php echo base_url()?>welcome/getEvent" method="post">
 <h3>INPUT KODE ACARA:</h3>
<input required type="text" name="kode" class='form-control' style='text-transform: uppercase;font-size:19px;text-align:center' > 
<br>
<button class='btn btn-lg btn-block bg-blue waves-effect'>SUBMIT</button>
</form>
</center>
<br>
 
<?php } ?>


<div class="btn-group" role="group" style="bottom:0;position:absolute;width:100%;margin-left:-14.5px">
                                    <a href="<?php echo base_url()?>welcome/inputUlang" type="button" style="width:50%" class="btn btn-lg bg-blue waves-effect"><i class="material-icons">keyboard</i> INPUT ULANG KODE</a>
                                    <a href='tutupapp' type="button"  style="width:50%" class="btn btn-lg bg-blue-grey waves-effect"><i class="material-icons">power_settings_new</i> KELUAR</a>
                                 
                                </div>

 