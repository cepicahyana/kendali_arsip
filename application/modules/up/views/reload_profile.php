<?php
		 $id = $this->input->get("id");
		 $this->db->where("id",$id);
$db	=	 $this->db->get("data_alumni")->row();
if($db->jk=="l"){
	$jk="Laki-laki";
}else{
	$jk="Perempuan";
}
?>
<div class="card card-style">
<div class="content">
<div class="d-flex">
<div>
<img src="<?php echo $this->m_reff->dp($id)?>" width="50" class="mr-3 bg-highlight rounded-xl">
</div>
<div>
<h1 class="mb-0 pt-1"><?php echo $db->nama_depan?> <?php echo $db->nama_belakang?></h1>
 <!--<h4 class='color-highlight'>Lulusan tahun : <?php echo $this->m_reff->tahun_lulus($db->id)?></h4>
 -->
 </div>
</div>
  
</div>
</div>


<style>
  td{
	font-size:18px;
	padding:5px;
}
</style>
 

 
<div class="card card-style" id="area_formProfile">
<div class="content mb-0">
<h3 class="font-600">Profile</h3>
 
<table class='entry' border='1' width="100%">

<tr>
<td>Nama</td> 
<td><?php echo $db->nama_depan?> <?php echo $db->nama_belakang?></td>
</tr>

<tr>
<td>Gender</td> 
<td><?php echo $jk?></td>
</tr>

<tr>
<td>Agama</td> 
<td><?php echo $this->m_reff->goField("tr_agama","nama","where id='".$db->id_agama."' ")?></td>
</tr>

<tr>
<td>T/T/L</td> 
<td><?php echo $db->tempat_lahir.",".$this->tanggal->ind($db->tgl_lahir,"/")?></td>
</tr>

<tr>
<td>Nomor Hp</td> 
<td><a href="https://wa.me/<?php echo $this->m_reff->hpwa($db->hp);?>"><?php echo $db->hp?></a></td>
</tr>
<tr>
<td>Email</td> 
<td><?php echo $db->email?></td>
</tr>

<tr>
<td>Pekerjaan</td> 
<td><?php echo $this->m_reff->goField("tr_pekerjaan","nama","where id='".$db->id_pekerjaan."' ")?></td>
</tr>

<tr>
<td colspan="2">Alamat Pekerjaan : <br>
<?php echo $db->alamat_pekerjaan;?></td>
</tr>


<tr>
<td>Pendidikan</td> 
<td><?php echo $this->m_reff->goField("tr_jp","nama","where id='".$db->id_jp."' ")?></td>
</tr>


<tr>
<td>Status Perkawinan</td> 
<td><?php echo $this->m_reff->goField("tr_perkawinan","nama","where id='".$db->sts_menikah."' ")?></td>
</tr>


<tr>
<td>Jml anak</td> 
<td><?php echo $db->jml_anak?></td>
</tr>




<tr>
<td>Gol.Darah</td> 
<td><?php echo $this->m_reff->goField("tr_goldar","nama","where id='".$db->id_goldar."' ")?></td>
</tr>


<tr>
<td colspan="2">Domisili saat ini: <br>
 <?php echo $db->alamat?></td>
</tr>
</table>

 
  </div>   <br>  
  </div>
 
 
 
 
 
 
 
 
 
 

 
<div class="card card-style" id="area_formProfile">
<div class="content mb-0">
<h3 class="font-600">Riwayat kelas</h3>
 
<table class='entry' border='1' width="100%">

<tr>
<td>Kelas 1</td> 
<td><?php echo $this->m_reff->goField("tr_kelas","nama_kelas","where id='".$db->id_kelas_1."' ")?></td>
</tr>

<tr>
<td>Kelas 2</td> 
<td><?php echo $this->m_reff->goField("tr_kelas","nama_kelas","where id='".$db->id_kelas_2."' ")?></td>
</tr>

<tr>
<td>Kelas 3</td> 
<td><?php echo $this->m_reff->goField("tr_kelas","nama_kelas","where id='".$db->id_kelas_3."' ")?></td>
</tr> 
 
</table>
   
 
  </div><br>
  </div>
 
 
  
