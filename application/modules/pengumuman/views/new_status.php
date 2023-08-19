<?php 
$msg	=	 $this->input->post("msg");
?>


 
<div  id="card<?php echo $id?>">
<div class="d-flex mb-4 pb-3 card card-style  "   > 
  
 
<div class="card mb-0">
<div class="content mb-0">
 
<div class="comment">
<div class="d-flex mb-2">
<div class="align-self-center">
<a href="<?php echo base_url()?>up/profile/<?php echo $idu=$this->m_reff->idu()?>"><img src="<?php echo $this->m_reff->dp()?>" class="rounded-m mr-2" width="45"></a>
</div>
<div class="align-self-center">
<h5 class="mb-0 font-600 font-14"><?php echo $this->m_reff->nama_depan()."  . <span class='color-highlight'> ".$this->m_reff->nama_kelas_alumni()?></h5>
<span class="font-11 d-block mt-n1">Posted: <?php echo $this->tanggal->hariLengkap(date('Y-m-d'),"/")." ".date("H:i:s"); ?></span>
</div>
 
</div>
<p class="opacity-70 mb-4 font-16 color-black" style='line-height:19px'>
<?php echo $msg;?>
</p>
</div>

 

<div id="msg<?php echo $id?>">
 
</div>


</div>
</div>
 <div class="align-self ml-auto" >
 
 <a class="color-red "  onclick="hapus_sts(`<?php echo $id ?>`)" style="margin-left:-160px;margin-top:0px;position:absolute "  href="javascript:void(0)" class="color-red2-dark"> <font color='red' class='fa fa-times-circle pr-2'> Hapus</font></a>
 &nbsp;
<a class="text-blue2-dark " style="margin-left:-100px;margin-top:0px;position:absolute "   href="javascript:replay(`<?php echo $id?>`,`<?php echo $msg?>`)" class="color-theme"><i class="fa fa-share pr-2"></i>Komentari</a>  
</div>
 
</div>
</div>