<head>
	<!-- Title -->
		<title> Kendali DATA </title>
        <script src="<?php echo base_url()?>assets/plugins/jquery/jquery.min.js"></script>
		<!--- Favicon --->
		<link rel="icon" href="<?php echo base_url()?>landingpage/logokendali.png" type="image/x-icon"/>
		<!--- Style css --->
		<link href="<?php echo base_url()?>assets/css/style-org.css" rel="stylesheet"> 
   </head>




<script>
    var token = "<?php echo $this->m_reff->getToken()?>";
	function detail(id){
		$("#detail").modal();
        $(".modal-body").html("mohon tunggu...");
  
                var url   = "<?=base_url()?>cek_data/detail";
                    var param = {id:id, ci_csrf_token:token};
                    $.ajax({
                        type: "POST",dataType: "json",data: param, url: url,
                        success: function(val){
                             token=val['token'];
                            $(".modal-body").html(val['data']);
                        }
                    });
       
	}
	
	function setQuota(id,val){
		 
                var url   = "<?=base_url()?>organisasi/setQuota";
                    var param = {id:id,val:val,ci_csrf_token:token};
                    $.ajax({
                        type: "POST",dataType: "json",data: param, url: url,
                        success: function(val){
                             token=val['token']; 
                        }
                    });
	}

    function newTab(link){
        window.open(
            link,
            '_blank'  
            );
    }
	
</script>


<div class="modal effect-newspaper" id="detail" style="z-index:1500" role="dialog">
    <div class="modal-dialog modal-md" id="area_modal" role="document">
		<div id="isi">
		<div class="modal-content">
    <div class="modal-header">  <h5 class="modal-titles" id="defaultModalLabel"><b>SET QUOTA</b></h5>
		<button type="button" class="close" aria-label="Close" data-dismiss="modal">
	    	<span aria-hidden="true">×</span>
		</button>
	</div>
	<div class="modal-body">
		 
	</div>
</div>
	</div>
</div>
</div><!-- /.modal-dialog --> 
</div>
</div>	

<!--- Moment js --->
<script src="<?php echo base_url()?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- <script src="<?php echo base_url()?>assets/js/custom.js"></script> -->
<!-- <script src="<?php echo base_url()?>assets/plugins/moment/moment.js"></script> -->