
					<!-- breadcrumb -->
					<div class="breadcrumb-header justify-content-between">
						<div>
							<h4 class="content-title mb-2">Akun</h4>
							<nav aria-label="breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#"> Akun whatsapp</a></li>
									<!-- <li class="breadcrumb-item active" aria-current="page">Project</li> -->
								</ol>
							</nav>
						</div>
						 
					</div>
					<!-- /breadcrumb -->
                    <div class="card">
                <div class="card-header">
                    <h5>Akun Whatsapp</h5>
                </div>
                <div class="card-body" id="refresh">

                    <div class="card-body  iq-card " id="area_lod">
	<div class="card-block">
		<!-- <form id="formSubmit" action="javascript:submitForm('formSubmit')" -->
			<!-- method="post" url="<?php echo site_url()?>format_absen/insert"> -->
			<div class="form-group row">
				<label class="col-sm-4 col-form-label" for="title">API Link Text</label>
				<div class="col-sm-8">
					<input id="link_text" onchange="setChange(23,this.value)" type="text" name="link_text" class="form-control" value="<?php echo $this->m_reff->pengaturan(23)?>" required>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-4 col-form-label" for="title">API Link File</label>
				<div class="col-sm-8">
					<input id="link_image" onchange="setChange(24,this.value)"  type="text" name="link_image" class="form-control" value="<?php echo $this->m_reff->pengaturan(24)?>" required>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-4 col-form-label" for="title">Key</label>
				<div class="col-sm-8">
					<input id="key" type="text" onchange="setChange(25,this.value)"  name="key" class="form-control" value="<?php echo $this->m_reff->pengaturan(25)?>"  required>
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
			url: "<?php echo site_url()?>notifikasi/updateText",
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