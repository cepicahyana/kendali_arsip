<?php
$get_controller = $this->router->fetch_class();
$f = $this->mdl->getByNip($val)->row();


$id_pegawai = $f->id ?? '';
$nip = $f->nip ?? '';
$nip_baru = $f->nip_baru ?? '';

$id_domis = $id_a ?? '';
$i = $this->mdl->getDomisiliById($id_domis)->row();
$id_domisili = $i->id ?? '';
$sts_hunian = $i->sts_hunian ?? '';
$id_prov = $i->id_prov ?? '';
$id_kab = $i->id_kab ?? '';
$id_kec = $i->id_kec ?? '';
$id_kel = $i->id_kel ?? '';
$alamat = $i->alamat ?? '';

$action_url = (empty($id_domisili)) ? '/insert' : '/update';
?>

<div class="modal-content">
	<div class="modal-header">
		<h5 class="modal-titles" id="defaultModalLabel"><b>Edit Data Domisili</b></h5>
		<button type="button" class="close" aria-label="Close" data-dismiss="modal">
			<span aria-hidden="true">×</span>
		</button>
	</div>


	<div class="modal-body">
		<form action="javascript:submitFormN('modal')" id="modal" url="<?php echo site_url($get_controller . $action_url) ?>" method="post">
			<input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName() ?>" value="<?php echo $this->m_reff->getToken() ?>">
			<input type="hidden" name="id" value="<?php echo $id_pegawai; ?>">
			<input type="hidden" name="fr" value="d">

			<input type="hidden" name="f[nip_pegawai]" value="<?=$nip; ?>">
			<input type="hidden" name="id_a" value="<?php echo $id_domisili; ?>">

			<div class="mb-4 main-content-label">Form data Domisili</div>

			<div class="row">
				<div class="col-md-12">
					<div class="form-group ">
						<div class="row">
							<div class="col-md-3">
								<label class="form-label" for="">Alamat</label>
							</div>
							<div class="col-md-9">
								<textarea name="f[alamat]" id="" class="form-control" rows="2"><?= $alamat ?></textarea>
							</div>
						</div>
					</div>
					<div class="form-group ">
						<div class="row">
							<div class="col-md-3">
								<label class="form-label" for="">Provinsi</label>
							</div>
							<div class="col-md-9">
								<?php
								$dtProv = $this->db->where_in("id_prov", array("31", "32"));
								$dtProv = $this->db->get("provinsi")->result();
								$opProv[] = "-- Pilih Provinsi --";
								foreach ($dtProv as $v) {
									$opProv[$v->id_prov] = $v->nama;
								}
								echo form_dropdown("f[id_prov]", $opProv, $id_prov, " onchange='get_kab()' class='text-black form-control select2'");
								?>
							</div>
						</div>
					</div>
					<div class="form-group ">
						<div class="row">
							<div class="col-md-3">
								<label class="form-label" for="">Kab/Kota</label>
							</div>
							<div class="col-md-9">
								<div id="data_kab"></div>
							</div>
						</div>
					</div>
					<div class="form-group ">
						<div class="row">
							<div class="col-md-3">
								<label class="form-label" for="">Kecamatan</label>
							</div>
							<div class="col-md-9">
								<div id="data_kec"></div>
							</div>
						</div>
					</div>
					<div class="form-group ">
						<div class="row">
							<div class="col-md-3">
								<label class="form-label" for="">Kelurahan</label>
							</div>
							<div class="col-md-9">
								<div id="data_kel"></div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-3">
								<label class="form-label" for="">Status Hunian</label>
							</div>
							<div class="col-md-9">
								<?php
								$options = ["" => "-- Pilih Status Hunian --"];
								$dbSH =  $this->db->get("tr_domisili")->result();
								foreach ($dbSH as $r) {
									$options[$r->nama] = $r->nama;
								}
								echo form_dropdown("f[sts_hunian]", $options, $sts_hunian, "id='' class='text-black form-control select2'");
								unset($options); ?>
							</div>
						</div>
					</div>

				</div>
				
				<div class="col-lg-12 p-1">
					<center>
						<a href="#" class="btn btn-light" onclick="resetFormN()"> reset </a>
						<button class="btn btn-success button_save" onclick="submitFormN('modal')"><i class="fa fa-save"></i> simpan</button>
					</center>
				</div>
			</div>

		</form>
		<div class="row">
			<div class="col-md-12">
				<hr>
				<div id="area_table"></div>
			</div>
		</div>
	</div>
</div>

<script>
	$(function() {
		reload_table_inmodal('d');
		setTimeout(function() {
			get_kab();
		}, 500);
	});
	
	function get_kab() {
		var id_prov = $("[name='f[id_prov]']").val();
		var name = 'f[id_kab]';
		var value = "<?= $id_kab ?>";
		$.post("<?php echo site_url("cek_data_edit/get_kab"); ?>", {
			idprov: id_prov,
			name: name,
			value: value
		}, function(data) {
			$("#data_kab").html(data);
			get_kec();
		});
	}

	function get_kec() {
		var id_kab = $("[name='f[id_kab]']").val();
		var name = 'f[id_kec]';
		var value = "<?= $id_kec ?>";
		$.post("<?php echo site_url("cek_data_edit/get_kec"); ?>", {
			idkab: id_kab,
			name:name,
			value: value
		}, function(data) {
			$("#data_kec").html(data);
			get_kel();
		});
	}
	
	function get_kel() {
		var id_kec = $("[name='f[id_kec]']").val();
		var name = 'f[id_kel]';
		var value = "<?= $id_kel ?>";
		$.post("<?php echo site_url("cek_data_edit/get_kel"); ?>", {
			idkec: id_kec,
			name:name,
			value: value
		}, function(data) {
			$("#data_kel").html(data);
		});
	}
</script>




