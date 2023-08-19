<?php
error_reporting(0);
?>
<style>
    
    .font-16{
        font-size:14px;
    }
    .font-11{
        font-size: 11px;
    }
   
    @media only screen and (min-width: 700px) {
        .akhiri-obrolan{
        margin-left:-80px;
    }
    }
    @media only screen and (max-width: 700px) {
        .geserkanan{
        margin-left:30px;
    }
    .mundurImg{
        margin-left:-25px;
    }
    .geserstatus{
        margin-left:70px;
    }
}

  
    </style>











<div id="newStatus"></div>
<?php
         $db       =    $this->m_reff->dataProfilePegawai();
		 $nama     =    "Anda";
         $jk       =    $db->jk;
		
		  $this->db->order_by("tgl","DESC");
		  $this->db->limit(10,0);
		  $this->db->where("id_sender",$this->m_reff->idu());
$data	= $this->db->get("data_tanya_dokter")->result();
foreach($data as $val){
     
?>


<div  id="card<?php echo $val->id?>">
<div class="  " > 
  
 
 <div class="">
<div class="content mb-0">
 


<div class="card card-body card-style">
    <div class="media d-block d-sm-flex">
	<img align="left" alt="" class="main-img-user avatar-lg mg-sm-r-20 mg-b-20 mg-sm-b-0" src="assets/<?php echo $jk;?>.png">
	<div class="media-body">
        <div class="geserstatus">	
            <h5 class="mg-b-5 tx-inverse tx-15 text-success"><?php echo $nama;?></h5>
            <p  class="font-16"><?php echo $val->msg;?></p>
        </div><hr style='border:white solid 1px'>
<div id="msgReplay">
        <?php
         if(!$val->sts){ //jika belum selesai
$dataKomen = $this->mdl->dataKomen($val->id);
foreach($dataKomen as $kom){ 
    if($kom->id_sender!=$this->m_reff->idu()){
        $komentator = $this->m_reff->goField("data_dokter","nama","where id='".$kom->id_sender."' ");
        $jk_komen   = "dokter_".$this->m_reff->goField("data_dokter","jk","where id='".$kom->id_sender."' ");
    }else{
        $komentator = "<span class='text-success'>".$nama."</span>";
        $jk_komen   = $jk;
    }
    ?>
	<!---- area replay --->
    <div id="com<?php echo $kom->id?>" class='geserkanan'>
    <div class="media d-block d-sm-flex mg-t-25" onclick="hapus_com(`<?php echo $kom->id?>`)">
			<img alt="s" class='mundurImg' align="left" src="assets/<?= $jk_komen ?>.png">
			<div class="media-body">
                <div class="geserkomen">	
                    <h5 class="mg-b-5 tx-inverse tx-15">&nbsp; <?= $komentator; ?>
                    <?php
 if($kom->id_sender==$this->m_reff->idu()){?>

	<a href="javascript:hapus_com(`<?php echo $kom->id?>`)" title='hapus' style="font-size:14px;margin-top:-15px;margin-left:40px;" 
    class="text-danger"><i class="fa fa-times-circle "></i>   </a>
	
	<?php } ?> </h5>

                    <span class="font-11 text-info d-block mt-n1">&nbsp;&nbsp;&nbsp;<?php echo $this->tanggal->hariLengkapJam($kom->tgl)?> wib.</span>
                    <span class="font-16"> &nbsp; <?php echo $kom->msg;?> </span>
                </div>
           </div>
                  
                </div>

    </div>

 
	<!---- area replay --->
<?php }
} ?>
</div>


<div id="msg<?php echo $val->id;?>"></div>

<div class="align-self ml-auto" >
    <hr>
 <?php
 if(!$val->sts){
 if($val->id_sender==$this->m_reff->idu()){
    ?>
 <a  class="bg-info akhiri-obrolan" style="color:white;padding:2px;border-radius:20px;float:left"  onclick="akhiri(`<?php echo $val->id ?>`)"   href="javascript:void(0)"  > <span class="text-info"></span>  <i class="typcn typcn-arrow-forward-outline"></i>  Akhiri obrolan &nbsp;  </a>
 
 <a class="color-red " style="float:right"  onclick="hapus_sts(`<?php echo $val->id ?>`)"   href="javascript:void(0)" class="color-red2-dark"> <span class="text-info">|</span> <font color='red' class='pr-2'> <i class='fa fa-times-circle '></i>  Hapus</font> </a>
 <?php } ?>&nbsp;
<a class="text-blue2-dark " style="float:right;margin-right:5px"   href="javascript:replay(`<?php echo $val->id?>`,`<?php echo $val->msg?>`)" class="color-theme"> 
<i class="fa fa-share pr-2"></i>Tulis komentar </a>  
</div>
<?php }else{
  echo '  <a  class="bg-warning akhiri-obrolan" style="color:black;padding:2px;border-radius:20px;float:right"  onclick="lihat_obrolan(`'.$val->id.'`)"   href="javascript:void(0)"  > <span class="text-info"></span>   <i class="typcn typcn-arrow-forward-outline"></i> 
   '.$this->mdl->jml_obrolan($val->id ).' percakapan &nbsp;  </a>';
 
} ?>
	</div>
</div>
</div>


 






</div>
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
       var param = {limit:limit,<?php echo $this->m_reff->tokenName()?>:token};
        $.ajax({
          type:'post',
          url:'<?php echo base_url()?>tanya_dokter/page_status',
          data: param,
          dataType:"json",
          async: true,
          success: function(val){
            //   token = val["token"];
          $('#lastStatus').append(val["data"]).slideDown('slow');
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
       var param = {limit:limit,<?php echo $this->m_reff->tokenName()?>:token};
        $.ajax({
          type:'post',
          url:'<?php echo base_url()?>tanya_dokter/page_status',
          data: param,
          async: true,
          dataType:"json",
          success: function(data){ 
            // token = val["token"];
          $('#lastStatus').append(val["data"]).slideDown('slow');
        }});
      }
    }});
</script>