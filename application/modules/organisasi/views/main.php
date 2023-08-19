 
					<!-- breadcrumb -->
					<div class="breadcrumb-header justify-content-between">
						<div>
							<h4 class="content-title mb-2">Formasi <? echo $nama_file;?> </h4>
							<nav aria-label="breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item">
                                      </ol>
							</nav>
                        </div>
                        <a target="_blank" href="<?=site_url("organisasi/bagan/".$bagan)?>" class="float-right full-right btn   btn-secondary">
                          <i class="fe fe-maximize"></i>   Tampilan penuh  </a>
						
					</div>
					<!-- /breadcrumb -->


					<!-- main-content-body -->
					<div class="main-content-body">
					 
						<div class="row row-sm">
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
								<div class="card">
									<div class="card-body">
										<div class="row" id="bagan">
                                        <!-- <iframe src="<?php echo base_url()?>organisasi/bagan/<?=$bagan?>" width="100%" height="800px">
                                        </iframe> -->
										</div>
						            </div>
					           	</div>
							</div> 
						</div>
					</div>


<script>
	function loadbag(file){
		var url   = "<?php echo site_url("organisasi/bagan");?>";
							var param = {
								file:file,
								<?php echo $this->m_reff->tokenName()?>:token
								};
							$.ajax({
									type: "POST",dataType: "json",data: param, url: url,
									success: function(val){
										
										$(".content").html(val['data']);
										token=val['token'];
									 
									}
							});	
	}
</script>