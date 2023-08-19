<?php
error_reporting(0);
		  $this->db->where("substr(tgl_lahir,6,5)",date("m-d"));
$data	= $this->db->get("data_alumni")->result();
foreach($data as $val){
     
?>
<div  id="ultah<?php echo $val->id?>">
<div class="d-flex mb-4 pb-3 card card-style  bg-pink1-dark" > 
  
 
 <div class="card mb-0 bg-pink1-dark">
<div class="content mb-0">
 
<div class="comment">
<div class="d-flex mb-2">
<div class="align-self-center">
<a href="<?php echo base_url()?>up/profile/<?php echo $val->id?>"><img src="<?php echo $this->m_reff->dp($val->id)?>" class="rounded-m mr-2" width="45"></a>
</div>
<div class="align-self-center">
<h5 class="mb-0 font-600 font-14"><?php echo $this->m_reff->nama_alumni($val->id)."  . <span class='color-yellow1-dark'> ".$this->m_reff->nama_kelas_alumni($val->id)?></h5>
<span class="font-14 d-block mt-n1 color-white"> <i class="fa fa-gift"></i> Hari ini ulang tahun</span>
</div>
<!--<div class="align-self-center ml-auto">
<a href="javascript:replay(`<?php echo $val->id?>`,`<?php echo $val->msg?>`)" class="color-theme"><i class="fa fa-share pr-2"></i>Balas</a>
</div>-->
</div>
<p class="opacity-70 mb-4 font-16 color-black" style='line-height:19px'>
<?php echo $val->msg;?>
</p>
</div>

<?php
$dataKomenUltah = $this->mdl->dataKomenUltah($val->id,date('Y-m-d'));
foreach($dataKomenUltah as $kom){ ?>
	<!---- area replay --->
	<div id="ucapan<?php echo $kom->id?>">
	<div class="reply pl-5">
	<div class="d-flex mb-2">
	<div class="align-self-center">
	<a href="<?php echo base_url()?>up/profile/<?php echo $kom->id_sender?>"><img src="<?php echo $this->m_reff->dp($kom->id_sender)?>" class="rounded-m mr-2" width="45"></a>
	</div>
	<div class="align-self-center">
	<h5 class="mb-0 font-600 font-14"><?php echo $this->m_reff->nama_alumni($kom->id_sender)." . 
	<span class='color-yellow1-dark'>".$this->m_reff->nama_kelas_alumni($kom->id_sender)?></span></h5>
 
	<?php
 if($kom->id_sender==$this->m_reff->idu()){?>
	<a href="javascript:hapus_ucapan(`<?php echo $kom->id?>`)" style="margin-top:-10px;position:absolute" class="  font-400     color-white">Hapus  </a>
	
	<?php } ?> 
	</div>
	</div>
	<p class="opacity-70 mb-4 font-15 font-400 color-white"  style='line-height:19px;'>
	<span class="color-white"><?php echo $kom->msg;?></span>
	</p>
	</div>
	</div>
	<!---- area replay --->
<?php } ?>
 
<div id="msgultah<?php echo $val->id;?>"></div>




</div>
</div>
 
 <div class="align-self ml-auto" >
 
<a class="color-yellow-dark " style="margin-left:-140px;margin-top:-20px;position:absolute "   href="javascript:ucapkan(`<?php echo $val->id?>`)"  ><b><i class="fa fa-share pr-2"></i><span class="color-white">Kirim ucapan</b></a>  
</div>

</div>
</div>

<?php } ?>






















<div id="newStatus"></div>
<?php
		  $cdate = $this->m_reff->_cdate();
		
		  $this->db->order_by("tgl","DESC");
		  $this->db->limit(10,0);
		  $this->db->where("tgl>=",$cdate);
$data	= $this->db->get("update_status")->result();
foreach($data as $val){
    
    $reader   =   $val->reader;
    if(strpos($reader,",".$this->m_reff->idu().",")===false){
        $reader = $val->reader.",".$this->m_reff->idu().",";
    	$this->db->where("id",$val->id);
    	$this->db->set("reader",$reader);
    	$this->db->update("update_status");
    }
    
    
	
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
<h5 class="mb-0 font-600 font-14"><?php echo $this->m_reff->nama_alumni($val->id_sender)."  . <span class='color-highlight'> ".$this->m_reff->nama_kelas_alumni($val->id_sender)?></h5>
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

<?php
$dataKomen = $this->mdl->dataKomen($val->id);
foreach($dataKomen as $kom){ ?>
	<!---- area replay --->
	<div id="com<?php echo $kom->id?>">
	<div class="reply pl-5">
	<div class="d-flex mb-2">
	<div class="align-self-center">
	<a href="<?php echo base_url()?>up/profile/<?php echo $kom->id_sender?>"><img src="<?php echo $this->m_reff->dp($kom->id_sender)?>" class="rounded-m mr-2" width="45"></a>
	</div>
	<div class="align-self-center">
	<h5 class="mb-0 font-600 font-14"><?php echo $this->m_reff->nama_alumni($kom->id_sender)." . 
	<span class='color-highlight'>".$this->m_reff->nama_kelas_alumni($kom->id_sender)?></span></h5>
	<span class="font-11 d-block mt-n1">Posted : <?php echo $this->tanggal->hariLengkapJam($kom->tgl)?></span>
	<?php
 if($kom->id_sender==$this->m_reff->idu()){?>
	<a href="javascript:hapus_com(`<?php echo $kom->id?>`)" style="margin-top:-10px;position:absolute" class="  font-400     color-red2-light">Hapus balasan</a>
	
	<?php } ?> 
	</div>
	</div>
	<p class="opacity-70 mb-4"  style='line-height:19px;color:black'>
	<?php echo $kom->msg;?>
	</p>
	</div>
	</div>
	<!---- area replay --->
<?php } ?>
 <div id="msg<?php echo $val->id;?>"></div>




</div>
</div>
 
 <div class="align-self ml-auto" >
 <?php
 if($val->id_sender==$this->m_reff->idu()){?>
 <a class="color-red "  onclick="hapus_sts(`<?php echo $val->id ?>`)" style="margin-left:-160px;margin-top:0px;position:absolute "  href="javascript:void(0)" class="color-red2-dark"> <font color='red' class='fa fa-times-circle pr-2'> Hapus</font></a>
 <?php } ?>&nbsp;
<a class="text-blue2-dark " style="margin-left:-100px;margin-top:0px;position:absolute "   href="javascript:replay(`<?php echo $val->id?>`,`<?php echo $val->msg?>`)" class="color-theme"><i class="fa fa-share pr-2"></i>Komentari</a>  
</div>

</div>
</div>

<?php } ?>


<div id="lastStatus"></div>




 <!--
<center>
<a href="#" style="width:90%" class="btn btn-m btn-full mb-3 rounded-xl text-uppercase font-900 shadow-s bg-brown1-light fa fa-sync-alt"> Tampilkan status sebelumnya</a>
</center>
 -->



<input id="limit" type="hidden" value="10">
<script>
// DESKTOP PAGINATION SCROLL
    $(window).scroll(function(){
      if ($(window).scrollTop() == $(document).height() - $(window).height()){
        var limit=$('#limit').val();
        var limit = parseInt(limit);

       	var limited = parseInt(limit+10)
        $('#limit').val(limited);

       // var token = $('.formTrigerCerita').serialize();

        $.ajax({
          type:'post',
          url:'<?php echo base_url()?>hallo/page_status',
          data: {limit:limit},
          async: true,
          success: function(data){
          $('#lastStatus').append(data).slideDown('slow');
        }});
      }
    });

    // MOBILE PAGINATION SCROLL
    $(window).on({touchmove : function(){
// alert($(this).scrollTop()+"_"+$(document).height()+"_"+$(this).height());
      if ($(this).scrollTop() >= $(document).height() - ($(this).height()+68)){
		 // alert($(document).height());
	//	  alert($(this).scrollTop()+"_"+$(document).height()+"_"+$(this).height());
        var limit=$('#limit').val();
        var limit = parseInt(limit); 
       	var limited = parseInt(limit+10)
        $('#limit').val(limited);

       // var token = $('.formTrigerCerita').serialize();

        $.ajax({
          type:'post',
          url:'<?php echo base_url()?>hallo/page_status',
          data: {limit:limit},
          async: true,
          success: function(data){ 
          $('#lastStatus').append(data).slideDown('slow');
        }});
      }
    }});
</script>