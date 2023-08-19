<div class="card-body  iq-card " id="area_lod">
	<div class="card-block">
		<!-- <form id="formSubmit" action="javascript:submitForm('formSubmit')" -->
			<!-- method="post" url="<?php echo site_url()?>format_absen/insert"> -->
			<div class="form-group row">
				<label class="col-sm-4 col-form-label" for="title">Link Text</label>
				<div class="col-sm-8">
					<input id="link_text" type="text" name="link_text" class="form-control" value="<?php echo $this->m_reff->pengaturan(17)?>" required>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-4 col-form-label" for="title">Link Image</label>
				<div class="col-sm-8">
					<input id="link_image" type="text" name="link_image" class="form-control" value="<?php echo $this->m_reff->pengaturan(18)?>" required>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-4 col-form-label" for="title">Key</label>
				<div class="col-sm-8">
					<input id="key" type="text" name="key" class="form-control" value="<?php echo $this->m_reff->pengaturan(19)?>"  required>
				</div>
			</div>
		<!-- </form> -->
	</div>
</div>


<script>
	$( "#link_text" ).change(function() {
		var link_text = $("#link_text").val();
		var param_text = {text:link_text,<?php echo $this->m_reff->tokenName()?>:token};
		$.ajax({
			type: "POST",
			url: "<?php echo site_url()?>akun_wa/updateText",
			data: param_text,
			success:function(data){
				token=data['token'];
				// $( "#link_text" ).val("");
				notif("Link Text, berhasil di update!", "Info", "success");
			}
		});
	});

	$( "#link_image" ).change(function() {
		var link_image = $("#link_image").val();
		var param_image = {image:link_image,<?php echo $this->m_reff->tokenName()?>:token};
		$.ajax({
			type: "POST",
			url: "<?php echo site_url()?>akun_wa/updateImage",
			data: param_image,
			success:function(data){
				token=data['token'];
				// $( "#link_image" ).val("");
				notif("Image, berhasil di update!", "Info", "success");
			}
		});
	});

	$( "#key" ).change(function() {
		var key = $("#key").val();
		var param_key = {key:key,<?php echo $this->m_reff->tokenName()?>:token};
		$.ajax({
			type: "POST",
			url: "<?php echo site_url()?>akun_wa/updateKey",
			data: param_key,
			success:function(data){
				token=data['token'];
				// $( "#key" ).val("");
				notif("Key, berhasil di update!", "Info", "success");
			}
		});
	});
</script>