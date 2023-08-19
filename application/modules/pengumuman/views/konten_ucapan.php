<?php
	$msg	=	 $this->input->post("msg");
	$idm	=	 $this->input->post("idm");
	$ai     =    ($this->m_reff->ai("data_ultah")-1);
?>


<!---- area replay --->
<div id="ultah<?php echo $ai?>">
    

<div class="ultah pl-5">
<div class="d-flex mb-2">
<div class="align-self-center">
<a href="<?php echo base_url()?>up/profile/<?php echo $this->m_reff->idu()?>"><img src="<?php echo $this->m_reff->dp($this->m_reff->idu())?>" class="rounded-m mr-2" width="45"></a>
</div>
<div class="align-self-center">
	<h5 class="mb-0 font-600 font-14"><?php echo $this->m_reff->nama_alumni($idm)." . 
	<span class='color-yellow1-dark'>".$this->m_reff->nama_kelas_alumni($idm)?></span></h5>
 
 
	<a href="javascript:hapus_ucapan(`<?php echo $ai?>`)" style="margin-top:-5px;position:absolute" class="  font-400     color-white">Hapus  </a>
	
 

</div>
<!--<div class="align-self-center ml-auto">
<a href="#" class="color-theme"><i class="fa fa-share pr-2"></i>Reply</a>
</div>-->
</div>
<p class="opacity-70 mb-4 font-16 font-400 color-white"  style='line-height:19px;color:white'>
<span class="color-white"><?php echo $msg;?></span>
</p>
</div>

</div>
<!---- area replay --->

<div id="msgultah<?php echo $idm;?>"></div>