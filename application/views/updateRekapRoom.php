<?php
$kodeE	=	$this->input->post("kode");
$kode	=	$this->m_reff->decrypt($kodeE);
$vicon	=	$this->input->post("vicon");
	if($vicon==1){
		$type="_gladi";
	}else{
		$type="";
	}
 
$dbroom	=	$this->db->get_where("zoom_room",array("kode_acara"=>$kode));
 ?>	
 	
		 
 
 
<table class="table table-bordered table-hover  dataTable no-footer"> 
<thead>
<th>NO</th>
<th>ROOM</th>
<th align='center'><center>TOTAL PESERTA</center></th>
<?php 
if($vicon!=2){?> 
<th align='center'>LINK JOIN</th>
<?php } ?>
<th align='center'><center>SUDAH BERGABUNG</center></th>
</thead>
<?php
$no=1;$tJoin=$tLink=$tPeserta=0;
foreach($dbroom->result() as $val){ 	

$jmlPeserta	=	$this->mdl->jmlPeserta($val->kode,$kode);	
$link		=	$this->mdl->jmlLink($val->kode,$kode);	
$join		=	$this->mdl->jmlJoin($val->kode,$kode,$type);	
 
if($vicon==2){
	 echo "<tr>
	 <td>".$no++."</td>
	 <td>".$val->nama."</td>
	 <td align='center'>".$jmlPeserta."</td> 
	 <td align='center'>".$join."</td>
	  
	 </tr>";
}else{
	 echo "<tr>
	 <td>".$no++."</td>
	 <td>".$val->nama."</td>
	 <td align='center'>".$jmlPeserta."</td>
	 <td align='center'>".$link."</td>
	 <td align='center'>".$join."</td>
	  
	 </tr>";
}
	$tPeserta+=$jmlPeserta;
	$tJoin+=$join;
	$tLink+=$link;
 	
  } ?>	
  <tr>
  <td colspan="2" align="right"><b>Total</b></td>
  <td align="center"><b><?php echo $tPeserta;?></b></td>
  <?php
  if($vicon!=2){?>
  <td align="center"><b><?php echo $tLink;?></b></td>
  <?php } ?>
  <td align="center"><b><?php echo $tJoin;?></b></td>
  </tr>
</table> 
 
 