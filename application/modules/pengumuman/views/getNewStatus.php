<div id="newStatus"></div>
<?php 
		  $this->db->where("tgl>=",$this->m_reff->cAlumni()); 
		  $this->db->order_by("tgl","DESC"); 
		  $this->db->not_like("reader",",".$this->m_reff->idu().","); 
$data	= $this->db->get("update_status")->result();
foreach($data as $val){
	$reader = $val->reader.",".$this->m_reff->idu().",";
	$this->db->where("id",$val->id);
	$this->db->set("reader",$reader);
	$this->db->update("update_status");
?>
<div  id="card<?php echo $val->id?>">
<div class="d-flex mb-4 pb-3 card card-style  " > 
  
 
 <div class="card mb-0">
<div class="content mb-0">
 
<div class="comment">
<div class="d-flex mb-2">
<div class="align-self-center">
<a href="<?php echo base_url()?>up/profile/<?php echo $val->id_sender?>"><img src="<?php echo $this->m_reff->dp($val->id_sender)?>" class="rounded-m mr-2" width="45"></a>
</div>
<div class="align-self-center">
<h5 class="mb-0 font-600 font-14"><?php echo $this->m_reff->nama_alumni($val->id_sender)?></h5>
<span class="font-11 d-block mt-n1">Posted: <?php echo $this->tanggal->hariLengkapJam($val->tgl); ?></span>
</div>
<!--<div class="align-self-center ml-auto">
<a href="javascript:replay(`<?php echo $val->id?>`,`<?php echo $val->msg?>`)" class="color-theme"><i class="fa fa-share pr-2"></i>Balas</a>
</div>-->
</div>
<p class="opacity-70 mb-4 font-16 color-black" style='line-height:19px'>
<?php echo $val->msg;?>
</p>
</div>
 
 <div id="msg<?php echo $val->id;?>"></div>




</div>
</div>
 
 <div class="align-self ml-auto" >
 <?php
 if($val->id_sender==$this->m_reff->idu()){?>
 <a class="color-red "  onclick="hapus_sts(`<?php echo $val->id ?>`)" style="margin-left:-160px;margin-top:0px;position:absolute " href="javascript:void(0)"  class="color-red2-dark"> <font color='red' class='fa fa-times-circle pr-2'> Hapus</font></a>
 <?php } ?>&nbsp;
<a class="text-blue2-dark " style="margin-left:-100px;margin-top:0px;position:absolute "   href="javascript:replay(`<?php echo $val->id?>`,`<?php echo $val->msg?>`)" class="color-theme"><i class="fa fa-share pr-2"></i>Komentari</a>  
</div>

</div>
</div>

<?php } ?>


<div id="lastStatus"></div>

 