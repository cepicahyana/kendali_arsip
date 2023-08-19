<?php
$id	=	$this->session->userdata("id");
$this->db->where("id_admin",$id);
$db	=	$this->db->get("admin")->row();

$owner = isset($db->owner)?($db->owner):"";
$nip = isset($db->nip)?($db->nip):"";
$poto = isset($db->poto)?($db->poto):"default.jpg";
$username = isset($db->username)?($db->username):"";
$last_login = isset($db->last_login)?($db->last_login):"";
$id_admin = isset($db->id_admin)?($db->id_admin):"";
$email = isset($db->email)?($db->email):"";
$level = isset($db->level)?($db->level):"";
$telp = isset($db->telp)?($db->telp):"";
$alamat = isset($db->alamat)?($db->alamat):"";
$istana = isset($db->istana)?($db->istana):"";
$kode_biro = isset($db->kode_biro)?($db->kode_biro):"";

// get Level
$dataLevel = $this->mdl->getLevel($level);
$nama_level = isset($dataLevel->nama)?($dataLevel->nama):"";

// get Biro
$dataLevel = $this->mdl->getBiro($kode_biro);
$nama_biro = isset($dataLevel->nama)?($dataLevel->nama):"";
?>


<style>
	@media only screen and (min-width: 768px){
		#tabel{
			margin-left: -20%;
		}

		#owner{
			margin-left: -20%;
		}

		#foto{
			width:50%;
			margin-left: 5%;
		}
	}

	@media only screen and (max-width: 768px){
		/* layar mobile */
		#owner{
			margin-top: 10px;
			text-align: center;
		}

		#tabel{
			margin-top: -6%;
		}

		#foto{
			width:50%;
		}
	}
</style>


<?php echo $this->session->flashdata('msg') ?>
<div class="row">
  	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				<div class="box box-primary">
					<div class="box-body box-profile">
						<div class="row">
							<div class="col-md-6 text-center">
								<img id="foto" class="profile-user-img img-responsive img-circle" src="<?= base_url('plug/img/dp/'.$poto); ?>" style="border-radius: 15px;">
							</div>

							<div class="col-md-6">
								<h3 class="" id="owner"><?=$owner?></h3><br><br>
								<table class="table table-bordered" id="tabel">
									<tr>
										<td width="30%"><b>Nama</b></td>
										<td width="10%">:</td>
										<td><?=$owner?></td>
									</tr>
									<tr>
										<td width="30%"><b>NIP</b></td>
										<td width="10%">:</td>
										<td><?=$nip?></td>
									</tr>
									<tr>
										<td width="30%"><b>Satuan Kerja</b></td>
										<td width="10%">:</td>
										<td><?=$istana?></td>
									</tr>
									<tr>
										<td width="30%"><b>Biro</b></td>
										<td width="10%">:</td>
										<td><?=$nama_biro?></td>
									</tr>
									<tr>
                                    <td width="40%" rowspan="3"><b>Akses sebagai</b></td>
                                    <td width="10%" rowspan="3">:</td>
                                    <?php
									
                                        $this->db->where("nip", $nip);
                                        $this->db->where("level", 12); //12 level id pimpinan_ppnpn
                                        $cekLevelAdmin = $this->db->get("admin")->num_rows();

                                        if($cekLevelAdmin){ ?>
                                            <td>
                                                <a href="<?=base_url('welcome?nip='.$this->m_reff->encrypt($nip).'&level='.$this->m_reff->encrypt($level))?>" class="btn btn-sm btn-primary" style="margin: 1px 3px 1px 3px;">Masuk sebagai Pimpinan</a>
                                            </td>
                                    <?php } 
                                    ?>
                                </tr>
                                <tr>
                                    <?php
                                        $this->db->where("nip", $nip);
                                        $this->db->where("level_indikasi", 11); //11 level id pegawai
                                        $cekLevelPegawai = $this->db->get("data_pegawai")->num_rows();

                                        if($cekLevelPegawai){ ?>
                                            <td>
                                                <a href="<?=base_url('welcome?nip='.$this->m_reff->encrypt($nip).'&level='.$this->m_reff->encrypt($level))?>" class="btn btn-sm btn-success" style="margin: 1px 3px 1px 3px;">Masuk sebagai Pegawai</a>
                                            </td>
									<?php }
                                    ?>
                                </tr>
                                <tr>
                                    <?php
                                        $this->db->where("nip", $nip);
                                        $this->db->where("level", 2); //2 id level super_admin
                                        $cekLevelAdmin = $this->db->get("admin")->num_rows();

                                        if($cekLevelAdmin){?>
                                            <td>
                                                <a href="<?=base_url('welcome?nip='.$this->m_reff->encrypt($nip).'&level='.$this->m_reff->encrypt($level))?>" class="btn btn-sm btn-danger" style="margin: 1px 3px 1px 3px;">Masuk sebagai Super Admin</a>
                                            </td>
									<?php } 
                                    ?>
                                </tr>
								</table>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
  	</div>
	<!-- <div class="col-sm-9">
		<div class="card">
			<div class="card-body">
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#settings" data-toggle="tab">Ubah Identitas</a></li>
					</ul>
					<div class="tab-content">
						<div class="active tab-pane" id="settings">
							<form class="form-horizontal" action="<?php echo base_url('profile_admin/editProfile') ?>" method="POST" enctype="multipart/form-data">
								<input type="hidden" name="id" value="<?php echo $id_admin;?>">
								<div class="form-group">
									<label class="col-sm-2 control-label">Nama</label>
									<div class="col-sm-10">
										<input type="text" class="form-control"  name="f[owner]" value="<?php echo $owner?>" >
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">NIP</label>
									<div class="col-sm-10">
										<input type="text" class="form-control"  name="f[nip]" value="<?php echo $nip?>" >
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Email</label>
									<div class="col-sm-10">
										<input type="email" class="form-control" name="f[email]" value="<?php echo $email?>" >
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Telp</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="f[telp]" value="<?php echo $telp?>" >
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Alamat</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="f[alamat]" value="<?php echo $alamat?>" >
									</div>
								</div>
								<div class="form-group">
								<label class="col sm-2 control-label">Foto profil</label>
									<div class="col-sm-5">
									<input type="file" name="image" class="form-control">

									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-10">
										<button type="submit" class="btn btn-primary">Save Changes</button>
									</div>
								</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div> -->
</div>
