<style>
.ttm{
	margin-left:430px; 
}
.kop{
	  
}
 

  .tborder{border-collapse: collapse; word-wrap:break-word; word-break: break-all;table-layout: fixed;font-size:12px;}
                 .tborder2{border-collapse: collapse; word-wrap:break-word; word-break: break-all;table-layout: fixed;width:75mm;height:35mm;}
               .tborder td,.tborder  th{word-wrap:break-word;word-break: break-all;border: 1px solid #000;
			   padding-left:5px;padding-right:5px;padding-top:7px;padding-bottom:7px;font-size:12px;text-align:left;}
          .bor{
		  //border:black solid 1px;
		 // padding:15px;
		  border-radius:10px;
		 
		 
		  
		  border:white solid 1px;
		  padding-left:20px;
		  padding-right:10px;
		  padding-top:10px;
		  padding-bottom:1px;
		  border-radius:10px;
	 
		  margin-left:10px;
		  margin-top:10px;
		  }		
.qr{
margin-left: 250px;
margin-top:-28px;
max-width:40px;
font-size:11px;
}	
</style>
 
<table cellspacing="0" cellpadding="0" border='0' >

<?php 
		$id= $this->input->get("id"); 
		$in=$this->m_reff->clearkomaray($id);
		$this->db->where_in("id",$in);
		$file=$this->db->get("data_peserta")->result();
		 if(!$file){
		 echo "</table>"; return false;
		 }
		$tb="";	$t=1;
		  foreach($file as $r)
		  {
			  $x=explode("-",$r->qr);
				$qr=isset($x[1])?($x[1]):"";
				$qr=substr($qr,-5);
			   if($t==1)
			  {
				  $tb.="<tr>";
				  $tb.="<td class='tborder2' ><div class='bor' style=' width:69mm;height:35mm; line-height:17px ;'><b>Yth ".$r->nama."</b><br>".$r->jabatan."<br>di Tempat".$this->m_reff->amankan($r->alamat)."	<br> </div><i class='qr'>".$qr."</i></td>";  
			  } else{
				$tb.="<td  class='size'><div  class='bor' style=' width:69mm;height:35mm; line-height:17px ;'  ><b>Yth ".$r->nama."</b><br>".$r->jabatan."<br>di Tempat".$this->m_reff->amankan($r->alamat)." <br></div><i class='qr'>".$qr."</i></td>";  
				}
				
				if($t==1)
				{ 
				  $t=2; $sts="stop";
				} else{
					 $tb.="</tr>";
					$t=1;  $sts="gerak";
				}
		  }
	  if($sts=="stop")
	  {
		  $tb.="</tr>";
	  }
	  
 
  if(!isset($tb)){ echo "<tr><td>Tidak ada data</td></tr>"; }else{  echo $tb; }
?>
</table>
