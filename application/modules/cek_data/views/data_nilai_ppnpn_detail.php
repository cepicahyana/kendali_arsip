<?php
$nip   = $this->input->post("nip");
$tahun = $this->input->post("tahun");
$this->db->where("semester",1);
$this->db->where("tahun",$tahun);
$this->db->where("nip",$nip);
$dataDB = $this->db->get("penilaian_kinerja_ppnpn")->row();
$semester = isset($dataDB->semester)?($dataDB->semester):null;
$db = isset($dataDB->data_penilaian)?($dataDB->data_penilaian):null;
$id_nilai = isset($dataDB->id)?($dataDB->id):null;
$db = json_decode($db,TRUE);
if($db){
	$nom=1;$detail_for=""; $val=null;
	foreach($db as $key=>$val){
		$detail_for.="<tr>
		<td>".$nom++."</td>
		<td align='left'>".$val['indikator']."</td>
		<td>".$val['skor']."</td>
		<td>".$val['nilai']."</td>
		</tr>";
	}
?>
 
<b>Semester 1</b> 
<a target='_blank' style='margin-top:-5px' href="<?=base_url();?>ranking/download?id=<?=$id_nilai?>" class='btn btn-sm btn-info float-right'>Download</a>
<table class='entry2' width='100%'>
			<thead class='bg-info'>
			<th>No</th>
			<th>Indikator</th>
			<th>Skor/Nilai</th>
			<th> bobot</th>
			</thead>
			<?=$detail_for;?>
			<tr>
			<td colspan='3' style='text-align:right'><b>Nilai Akhir</b></td>
			<td><b><?=$dataDB->hasil_evaluasi;?></b></td>
			</tr>
			<tr>
			<td colspan='3' style='text-align:right'><b>Predikat</b></td>
			<td><b><?=$this->m_reff->predikat($dataDB->predikat);?></b></td>
			</tr>
			<tr>
			<td colspan='4'>
			<b>Hasil evaluasi/catatan:</b><br>
			<?=$dataDB->komentar;?>
			</td>
			</tr>
			</table>
<?php } ?>

            <?php
$this->db->where("semester",2);
$this->db->where("tahun",$tahun);
$this->db->where("nip",$nip);
$dataDB = $this->db->get("penilaian_kinerja_ppnpn")->row();
$db = isset($dataDB->data_penilaian)?($dataDB->data_penilaian):null;
$id_nilai = isset($dataDB->id)?($dataDB->id):null;

$db = json_decode($db,TRUE);
if($db){ 
	$nom=1;$detail_for=""; $val=null;
	foreach($db as $key=>$val){
		$detail_for.="<tr>
		<td>".$nom++."</td>
		<td align='left'>".$val['indikator']."</td>
		<td>".$val['skor']."</td>
		<td>".$val['nilai']."</td>
		</tr>";
	}	
	
	
	?>
<hr>
<b>Semester 2</b> <a target='_blank' style='margin-top:-5px' href="<?=base_url();?>ranking/download?id=<?=$id_nilai?>" class='btn btn-sm btn-info float-right'>Download</a>
<table class='entry2' width='100%'>
			<thead class='bg-info'>
			<th>No</th>
			<th>Indikator</th>
			<th>Skor/Nilai</th>
			<th> bobot</th>
			</thead>
			<?=$detail_for;?>
			<tr>
			<td colspan='3' style='text-align:right'><b>Nilai Akhir</b></td>
			<td><b><?=$dataDB->hasil_evaluasi;?></b></td>
			</tr>
			<tr>
			<td colspan='3' style='text-align:right'><b>Predikat</b></td>
			<td><b><?=$this->m_reff->predikat($dataDB->predikat);?></b></td>
			</tr>
			<tr>
			<td colspan='4'>
			<b>Hasil evaluasi/catatan:</b><br>
			<?=$dataDB->komentar;?>
			</td>
			</tr>
			</table>
			<?php } ?>