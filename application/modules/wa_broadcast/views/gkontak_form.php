<?php
$get_controller = $this->router->fetch_class();
$id_kontak = $this->input->post('id') ?? '' ;
$q = $this->mdl_kg->getById($id_kontak)->row();
$nama = $q->nama ?? '';
$jabatan = $q->jabatan ?? '';
$instansi = $q->instansi ?? '';
$email = $q->email ?? '';
$no_hp = $q->no_hp ?? '';

$action_url = ('' !== $id_kontak) ? '/update_group_kontak' : '/insert_group_kontak' ;

?>
<div class="modal-content">
    <div class="modal-header">  <h5 class="modal-titles" id="defaultModalLabel"><b>Kontak Group</b></h5>
		<button type="button" class="close" aria-label="Close" data-dismiss="modal">
	    	<span aria-hidden="true">×</span>
		</button>
	</div>


	<div class="modal-body">
		<form  action="javascript:submitForm('modal')" id="modal" url="<?php echo site_url($get_controller.$action_url)?>"  method="post">
			<input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName()?>" value="<?php echo $this->m_reff->getToken()?>">
			<?php 
			echo form_hidden('f[id_group]', $this->input->post('group'));
			echo form_hidden('id', $id_kontak);?>

			<div class="form-group ">
				<div class="row">
					<div class="col-md-3">
						<label class="form-label" for="nama">Nama</label>
					</div>
					<div class="col-md-9">
						<input name="f[nama]" id="nama" type="text" class="form-control" value="<?= set_value('nama', $nama);?>">
					</div>
				</div>
			</div>
			<div class="form-group ">
				<div class="row">
					<div class="col-md-3">
						<label class="form-label" for="jabatan">Jabatan</label>
					</div>
					<div class="col-md-9">
						<input name="f[jabatan]" id="jabatan" type="text" class="form-control" value="<?= set_value('jabatan', $jabatan);?>">
					</div>
				</div>
			</div>
			<div class="form-group ">
				<div class="row">
					<div class="col-md-3">
						<label class="form-label" for="instansi">Instansi</label>
					</div>
					<div class="col-md-9">
						<input name="f[instansi]" id="instansi" type="text" class="form-control" value="<?= set_value('instansi', $instansi);?>">
					</div>
				</div>
			</div>
			<div class="form-group ">
				<div class="row">
					<div class="col-md-3">
						<label class="form-label" for="email">E-mail</label>
					</div>
					<div class="col-md-9">
						<input name="f[email]" id="email" type="email" class="form-control" value="<?= set_value('email', $email);?>">
					</div>
				</div>
			</div>
			<div class="form-group ">
				<div class="row">
					<div class="col-md-3">
						<label class="form-label" for="hp">Nomor HP</label>
					</div>
					<div class="col-md-9">
						<input name="f[no_hp]" id="hp" type="text" class="form-control" value="<?= set_value('no_hp', $no_hp);?>">
					</div>
				</div>
			</div>

			<div class="col-lg-12 p-1">
				<center>
					<button class="btn btn-success button_save" onclick="submitForm('modal')"><i class="fa fa-save"></i> simpan</button>
				</center>
			</div>
		</form>
	</div>
</div>

<script>
	var id_kontak = '<?= ($id_kontak ?? ''); ?>';
	function get_kontak() {
		var biro = $('#biro').val();
		// AJAX request
		$.ajax({
			url: '<?= site_url($get_controller.'/option_biro'); ?>',
			method: 'post',
			data: {
				biro: biro
			},
			dataType: 'json',
			success: function(response) {
				// Remove options
				$('#kontak').find('option').not(':first').remove();

				$.each(response, function(key, val) {
					var kontak_selected = '';
					/*if (key == id_kontak) {
						kontak_selected =  'selected="selected"';
					}*/
					$('#kontak').append('<option value="' + key +'" ' + kontak_selected + '>' + val + '</option>');
				});
			}
		});
	}
</script>