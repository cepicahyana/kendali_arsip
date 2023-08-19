<?php
$data = $this->mdl->getInfo();
foreach($data as $val){
?>
 
<div class="d-flex mb-4 pb-3 card card-style  "> 
<div class="content">
<h4 class="font-22 font-900"><?php echo $val->judul?></h4>
<span class="color-highlight font-14 mt-n2 mb-3 fa fa-calendar-alt"> Hari <?php echo $this->tanggal->hariLengkapJam($val->tgl)?></span>
<p class="font-22">
<?php echo $val->isi;?>
<hr>
<br> 
<?php
if($val->type_file==1){
    $file = $this->m_reff->pengaturan(1)."info/".$val->file_name;
    echo "<img width='100%' src='".$this->konversi->img($file)."'/>";
}elseif($val->type_file==2){
      $file = base_url()."info/".$val->file_name;
    echo '
    <video  width="100%"  height="240" controls>
  <source src="'.$file.'" type="video/mp4">
  
Your browser does not support the video tag.
</video>
    ';
}elseif($val->type_file==3){
      $file = base_url()."download?f=".$this->m_reff->encrypt("info/".$val->file_name);
    echo '<a target="_blank" class="btn btn-full btn-block bg-blue2-dark fa fa-file" href="'.$file.'"> Download  </a> ';
}
?>
</p> 
</div>
</div>

<?php } ?>