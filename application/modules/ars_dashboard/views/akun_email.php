<?php 
$get_controller = $this->router->fetch_class(); ?>
					<!-- breadcrumb -->
					<div class="breadcrumb-header justify-content-between">
						<div>
							<h4 class="content-title mb-2">Akun</h4>
							<nav aria-label="breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#"> Akun Email</a></li>
									<!-- <li class="breadcrumb-item active" aria-current="page">Project</li> -->
								</ol>
							</nav>
						</div>
						 
					</div>
					<!-- /breadcrumb -->
                    <div class="card">
                <div class="card-header">
                    <h5>Akun Email</h5>
                </div>
                <div class="card-body" id="refresh">

                    <div class="card-body  iq-card " id="area_lod">
	<div class="card-block">
		<!-- <form id="formSubmit" action="javascript:submitForm('formSubmit')" -->
			<!-- method="post" url="<?php echo site_url()?>format_absen/insert"> -->
			<div class="form-group row">
				<label class="col-sm-2 col-form-label" for="title">Email</label>
				<div class="col-sm-10">
					<input id="link_text" onchange="setChange(28,this.value)" type="text" name="link_text" class="form-control" value="<?php echo $this->m_reff->pengaturan(28)?>" required>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-2 col-form-label" for="title">Usermail</label>
				<div class="col-sm-10">
					<input id="link_image" onchange="setChange(26,this.value)"  type="text" name="link_image" class="form-control" value="<?php echo $this->m_reff->pengaturan(26)?>" required>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-2 col-form-label" for="title">Password</label>
				<div class="col-sm-10">
					<input id="key" type="text" onchange="setChange(27,this.value)"  name="key" class="form-control" value="<?php echo $this->m_reff->pengaturan(27)?>"  required>
				</div>
			</div>
		<!-- </form> -->
	</div>
</div>

</div>
</div>
<script>
function setChange(id,val){
		$.ajax({
			type: "POST",
			url: "<?php echo site_url($get_controller);?>/updateText",
			data: "val="+val+"&id="+id,
			success:function(data){
                token = data["token"];
				swal("success", {
						icon: "success",
						buttons : {
							confirm : {
								className: 'btn btn-success'
							}
						}
                })
			}
		});
    }
</script>