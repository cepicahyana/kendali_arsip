<?php
$id	=	$this->m_reff->san($this->input->post("id"));
$this->db->where("id", $id);
$db	=	$this->db->get("data_alumni")->row();
if(!isset($db)){
	echo "content not found!"; return false;
}
?>
<div class="row" id="area_formSubmit">
	<div class="col-sm-12">

		<div class="card-block">
			<h5 class="sub-title">Edit </h5>
			<hr>

			<form id="formSubmit" action="javascript:submitForm('formSubmit')" method="post" url="<?php echo base_url() ?>data_alumni/update">
				<input type="hidden" name="id" value="<?php echo $db->id; ?>">
				<div class="form-group row">

					<!-- username -->
					<!-- <label class="col-sm-5 col-form-label">Username</label>
					<div class="col-sm-6">
						<input type="text" name="f[username]" value="<?php echo $db->username ?>" required class="form-controls">
					</div> -->

					<!-- nama depan -->
					<label class="col-sm-5 col-form-label">Nama Depan</label>
					<div class="col-sm-6">
						<input type="text" name="f[nama_depan]" value="<?php echo $db->nama_depan ?>" required class="form-controls">
					</div>

					<!-- nama belakang -->
					<label class="col-sm-5 col-form-label">Nama Belakang </label>
					<div class="col-sm-6">
						<input type="text" name="f[nama_belakang]" value="<?php echo $db->nama_belakang ?>"   class="form-controls">
					</div>

					<!-- email -->
					<label class="col-sm-5 col-form-label">Email </label>
					<div class="col-sm-6">
						<input type="text" name="f[email]" value="<?php echo $db->email ?>"   class="form-controls">
					</div>
 

					<!-- jenis kelamin  -->
					<label class="col-sm-5 col-form-label">Jenis Kelamin</label>
					<div class="col-sm-6">

						<select name="f[jk]" value="<?php echo $db->jk ?>" required class="form-controls">
							<option value="l">Laki-Laki</option>
							<option value="p">Perempuan</option>
						</select>
					</div>

					<!-- no tlp  -->
					<label class="col-sm-5 col-form-label">Nomer Telepon</label>
					<div class="col-sm-6">
						<input type="text" name="f[hp]" value="<?php echo $db->hp ?>" required class="form-controls">
					</div>

					<!-- alamat  -->
					<label class="col-sm-5 col-form-label">Alamat</label>
					<div class="col-sm-6">
						<input type="text" name="f[alamat]" value="<?php echo $db->alamat ?>"   class="form-controls">
					</div>

					<!-- kelas 1  -->
					<label class="col-sm-5 col-form-label">Kelas 1</label>
					<div class="col-sm-6">
						<?php
						$dtkelas = array();
						$kelas=$this->db->get_where("tr_kelas",array("id_tingkat"=>1))->result();
						foreach ($kelas as $k) :
							$dtkelas[$k->id] = $k->nama_kelas;
						endforeach;
						echo form_dropdown("f[id_kelas_1]", $dtkelas, $db->id_kelas_1, "class='form-control' ") ?>
					</div>

					<!-- kelas 2  -->
					<label class="col-sm-5 col-form-label">Kelas 2</label>
					<div class="col-sm-6">
						<?php
						$dtkelas = array();
						$kelas=$this->db->get_where("tr_kelas",array("id_tingkat"=>2))->result();
						foreach ($kelas as $k) :
							$dtkelas[$k->id] = $k->nama_kelas;
						endforeach;
						echo form_dropdown("f[id_kelas_2]", $dtkelas, $db->id_kelas_2, "class='form-control' ") ?>
					</div>

					<!-- kelas 3  -->
					<label class="col-sm-5 col-form-label">Kelas 3</label>
					<div class="col-sm-6">
						<?php
						$dtkelas = array();
						$kelas=$this->db->get_where("tr_kelas",array("id_tingkat"=>3))->result();
						foreach ($kelas as $k) :
							$dtkelas[$k->id] = $k->nama_kelas;
						endforeach;
						echo form_dropdown("f[id_kelas_3]", $dtkelas, $db->id_kelas_3, "class='form-control' ") ?>
					</div>

					<!-- tahun lulus  -->
					<label class="col-sm-5 col-form-label">Tahun Lulus</label>
					<div class="col-sm-6">
						<?php
						$dttahunlulus = array();
						foreach ($tahunLulus as $tl) :
							$dttahunlulus[$tl->id] = $tl->tahun;
						endforeach;

						echo form_dropdown("f[id_tahun]", $dttahunlulus, $db->id_tahun, "class='form-control' ") ?>

					</div>

					<!-- goldar  -->
					<label class="col-sm-5 col-form-label">Golongan Darah</label>
					<div class="col-sm-6">
						<?php
						$dtgoldar = array();
						foreach ($goldar as $g) :
							$dtgoldar[$g->id] = $g->nama;
						endforeach;

						echo form_dropdown("f[id_goldar]", $dtgoldar, $db->id_goldar, "class='form-control' ") ?>

					</div>

					<!-- agama  -->
					<label class="col-sm-5 col-form-label">Agama</label>
					<div class="col-sm-6">
						<?php
						$dtagama = array();
						foreach ($agama as $agm) :
							$dtagama[$agm->id] = $agm->nama;
						endforeach;

						echo form_dropdown("f[id_agama]", $dtagama, $db->id_agama, "class='form-control' ") ?>

					</div>

					<!-- Jenjang Pendidikan  -->
					<label class="col-sm-5 col-form-label">Pendidikan</label>
					<div class="col-sm-6">
						<?php
						$dtjp = array();
						foreach ($jp as $j) :
							$dtjp[$j->id] = $j->nama;
						endforeach;

						echo form_dropdown("f[id_jp]", $dtjp, $db->id_jp, "class='form-control' ") ?>

					</div>

					<!-- status pekerjaan 
					<label class="col-sm-5 col-form-label">Status Pekerjaan</label>
					<div class="col-sm-6">
						<select name="f[sts_pekerjaan]" value="<?php echo $db->sts_pekerjaan ?>" required class="form-controls">
							<!-- <option value="1">Bekerja</option>
							<option value="2">Belum Bekerja</option>
						</select>
					</div> -->

					<!-- profesi  -->
					<label class="col-sm-5 col-form-label">Profesi</label>
					<div class="col-sm-6">
						<?php
						$dtpekerjaan = array();
						foreach ($pekerjaan as $p) :
							$dtpekerjaan[$p->id] = $p->nama;
						endforeach;
						echo form_dropdown("f[id_pekerjaan]", $dtpekerjaan, $db->id_pekerjaan, "class='form-control' ") ?>

					</div>

					<!-- Penghasilan   -->
					<!-- <label class="col-sm-5 col-form-label">Penghasilan</label>
					<div class="col-sm-6"> -->
						<?php
						$dtpenghasilan = array();
						foreach ($penghasilan as $pg) :
							$dtpenghasilan[$pg->id] = $pg->penghasilan;
						endforeach;
						echo form_dropdown("f[id_penghasilan]", $dtpenghasilan, $db->id_penghasilan, "class='form-control' ") ?>
					<!-- </div> -->

					<!-- status Pernikahan  -->
					<label class="col-sm-5 col-form-label">Status Pernikahan</label>
					<div class="col-sm-6">
					 
							<?php
					 $kawin[0]=" --- pilih ---";
					  $kawin[1]=" Belum kawin";
					   $kawin[2]=" Kawin";
					    $kawin[3]=" Bercerai";
						echo form_dropdown("f[sts_menikah]", $kawin, $db->sts_menikah, "class='form-control' ") ?>
					</div>

					<!-- jumlah anak  -->
					<label class="col-sm-5 col-form-label">Jumlah Anak</label>
					<div class="col-sm-6">
						<input type="text" name="f[jml_anak]" value="<?php echo $db->jml_anak ?>"   class="form-controls">
					</div>

				</div>

				<center>
					<button class="btn btn-primary mb-3 pull-right" onclick="javascript:submitForm('formSubmit')"><i class="fa fa-save"></i> SIMPAN</button>
				</center>
			</form>

		</div>
	</div>
</div>