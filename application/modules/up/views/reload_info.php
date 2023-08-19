<?php
		 $this->db->where("id",$this->m_reff->idu());
$db	=	 $this->db->get("data_pegawai")->row();
$id_bidang = isset($db->id_bidang)?($db->id_bidang):null;
$bidang = $this->m_umum->bidang($id_bidang);
$nip = isset($db->nip)?($db->nip):null;
$bagian = isset($db->bagian)?($db->bagian):null;
$subbagian = isset($db->subbagian)?($db->subbagian):null;
$tempat_lahir = isset($db->tempat_lahir)?($db->tempat_lahir):null;
$tgl_lahir = isset($db->tgl_lahir)?($db->tgl_lahir):null;
$no_hp = isset($db->no_hp)?($db->no_hp):null;
$agama = isset($db->agama)?($db->agama):null;
$email = isset($db->email)?($db->email):null;
$bagian = isset($db->bagian)?($db->bagian):null;
$nama = isset($db->nama)?($db->nama):null;
$foto = isset($db->foto)?($db->foto):null;
 $istana = isset($db->kode_istana)?($db->kode_istana):null;
$istana = $this->m_reff->istana($istana);
$biro = isset($db->kode_biro)?($db->kode_biro):null;
$biro = $this->m_reff->biro($biro);
$level = isset($db->level_indikasi)?($db->level_indikasi):null;


// jenis kelamin
$jenis_kelamin = isset($db->jk)?($db->jk):null;
if($jenis_kelamin == "l"){
	$jk = "Laki-laki";
}else{
	$jk = "Perempuan";
}



?>

<style>
	@media only screen and (min-width: 768px){
		#tabel{
			margin-left: -20%;
			margin-top: 7%;
		}
	}
</style>




<div class="card card-style">
<div class="content">
<div class="d-flex">
<div>
<img src="<?php echo $this->m_reff->dp_ppnpn()?>" width="50" class="mr-3 bg-highlight rounded-xl">
</div>
<div>
<h1 class="mb-0 pt-1"><?php echo $db->nama?> </h1>
<b><?php echo $bagian;?> -  <?php echo $subbagian?></b>
<br> 
 </div>
</div>
  
</div>
</div>




<div class="card card-style">
	<div class="content mb-0">
		<h3 class="font-600 text-center">Profile</h3>
		<div class="row">
			<div class="col-md-6 text-center">
				<img class="profile-user-img img-responsive img-circle mt-5 mb-3" src="<?php echo $this->m_reff->dp_ppnpn()?>" style="border-radius: 15px; width:50%;">
				
			</div>
			<div class="col-md-6">				
				<table class="table table-bordered" id="tabel">
					<tr>
						<td width="40%"><b>Nama</b></td>
						<td width="10%">:</td>
						<td><?=$nama?></td>
					</tr>
					<tr>
						<td width="40%"><b>NPP</b></td>
						<td width="10%">:</td>
						<td><?=$nip?></td>
					</tr>
					<tr>
						<td width="40%"><b>Satuan Kerja</b></td>
						<td width="10%">:</td>
						<td><?=$istana?></td>
					</tr>
					<tr>
						<td width="40%"><b>Biro</b></td>
						<td width="10%">:</td>
						<td><?=$biro?></td>
					</tr>
					 
					<!-- <tr> -->
						<!-- <?php
							// $this->db->where("nip", $nip);
							// $this->db->where("level_indikasi", 11); //11 level id pegawai
							// $cekLevelPegawai = $this->db->get("data_pegawai")->row();

							// if($cekLevelPegawai != ""){
								// <td>
								//     <a href="" class="btn btn-sm btn-success" style="margin: 1px 3px 1px 3px;">Masuk sebagai Pegawai</a>
								// </td>;
							// }else{
						
							// }
						// ?>
					</tr> -->
					<tr>
						<?php
							$this->db->where("nip", $nip);
							$this->db->where("level", 2); //2 id level super admin
							$cekLevelAdmin = $this->db->get("admin")->num_rows();

							if($cekLevelAdmin){ ?>
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

 
 

 



<script>
function simpan_akun(){
	loading_block("loading_akun");
	var username = $("[name='username']").val();
	var pass 	 = $("[name='pass']").val();
	var pass2	 = $("[name='pass2']").val();
	if(pass=="" || username==""){
		$('#notification-1').toast('show');
		$('#msgNotif').html('username atau password tidak boleh kosong');
		unblock("loading_akun");
		return false;
	}
	if(pass!=pass2){
			unblock("loading_akun");
		$('#notification-1').toast('show');
		$('#msgNotif').html('Password yang anda ketik tidak sama!');
		return false;
	}
	$.post("<?php echo base_url()?>up/save_password",{username:username,pass:pass,pass2:pass2}, function(data, status){
			unblock("loading_akun");
		  if(data==false){
			  $('#notification-1').toast('show');
			  $('#msgNotif').html('Silahkan cari username atau password lain!');
		  }else{
			  $('#notification-1').toast('show');
			  $('#msgNotif').html('Berhasil disimpan!');
		  }
	  }); 
}
function finish(){
			 $('#notification-1').toast('show');
			  $('#msgNotif').html('Berhasil disimpan!');
}
function hidennotif(){
	  $('#notification-1').toast('hide');
}
</script>

</div>
<div onclick="hidennotif()" id="notification-1" data-dismiss="notification-1" data-delay="10000" data-autohide="true" 
class="notification notification-ios bg-magenta2-dark">
<span class="notification-icon">
<i class="fa fa-bell"></i>
<em>Informasi</em>
<i data-dismiss="notification-1" class="fa fa-times-circle"></i>
</span>
<h1 class="font-15 color-white mb-n3" id="msgNotif">....</h1>
 <br>
</div>



