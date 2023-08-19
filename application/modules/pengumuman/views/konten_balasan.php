<?php
	$msg	=	 $this->input->post("msg");
	$idm	=	 $this->input->post("idm");
	$ai     =    ($this->m_reff->ai("data_komentar")-1);
?>


<!---- area replay --->
<div id="com<?php echo $ai?>">
    

<div class="reply pl-5">
<div class="d-flex mb-2">
<div class="align-self-center">
<a href="<?php echo base_url()?>up/profile/<?php echo $this->m_reff->idu()?>"><img src="<?php echo $this->m_reff->dp($this->m_reff->idu())?>" class="rounded-m mr-2" width="45"></a>
</div>
<div class="align-self-center">
<h5 class="mb-0 font-600 font-14"><?php echo $this->m_reff->nama_lengkap();?></h5>
<span class="font-11 d-block mt-n1">Posted : <?php echo $this->tanggal->hariLengkapJam(date('Y-m-d H:i:s'))?></span>
 
	<a href="javascript:hapus_com(`<?php echo $ai?>`)" style="margin-top:-10px;position:absolute" class="  font-400     color-red2-light">Hapus balasan</a>
	
 

</div>
<!--<div class="align-self-center ml-auto">
<a href="#" class="color-theme"><i class="fa fa-share pr-2"></i>Reply</a>
</div>-->
</div>
<p class="opacity-70 mb-4"  style='line-height:19px;color:black'>
<?php echo $msg;?>
</p>
</div>

</div>
<!---- area replay --->

<div id="msg<?php echo $idm;?>"></div>