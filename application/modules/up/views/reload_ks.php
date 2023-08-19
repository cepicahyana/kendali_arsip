<?php
		 $id = $this->m_reff->idu();
		 $this->db->order_by("id","desc");
		 $this->db->where("id_alumni",$id);
$db	=	 $this->db->get("data_kritik")->result();
 foreach($db as $val){
?>

<div class="d-flex mb-4 pb-3 card card-style  "> 
  
 
 <div class="card mb-0">
<div class="content mb-0">
 
<div class="comment">
 
 
 
 
<span class="font-13  mt-n1 color-highlight"><b>Tanggal: <?php echo $this->tanggal->hariLengkapJam($val->_ctime)?> wib<b/></span>
 
 
<p class="opacity-70 mb-4 font-16 color-black" style="line-height:19px">
<?php echo $val->msg?></p>
</div>
<?php
if($val->respon){?>
 <div class="reply pl-5">
	<div class="d-flex mb-2">
	   
	<p class="opacity-70 mb-4" style="line-height:19px;color:black">
	<span class='color-red2-dark'>Balasan :</span> <br>
	<?php echo $val->respon;?>
	</p>
	</div>

</div>

<?php } ?>
</div>
</div>
<a href="javascript:hapus_ks(`<?php echo $val->id?>`)" style="float:right;margin-right:10px" class="  btn-xxs mb-3 rounded-s text-uppercase   shadow-s border-red2-dark  bg-red2-light">Hapus   </a>


  

</div>
 <?php  } ?>
  
