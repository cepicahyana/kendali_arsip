<style> 
 #isi{
padding-top:83px;
padding-left:10px;
padding-right:10px;
padding-bottom:10px;
margin-left:-15px;
 }
 	  
.garuda{
width:80px;
margin-top:30px;
margin-left:290px;
position:absolute;
}
.center{
background-color:red;
width:660px;
}
.area{
margin-left:-26px;
margin-top:40px;
//background-color:white;
}
.absolute{
position:absolute;
margin-top:13px;
}
 
table tr td{
	padding:1px;
	spaccing
}	
 
     .barkode{
         margin-top:288px;
        // text-align:right;
         margin-left:586px;
         position:absolute;
         float:right;
         margin-bottom:-68px;
		 color:black;
     }
     .barkodeTitle{
         font-size:7px;
         margin-left:17px;
		  color:black;
     }
	  .monotype{
	    font-family:monotypecorsiva;
		  
	}
 </style>
 
 
 
<?php
		$kode_acara=$this->input->get("kode"); 
		$id=$this->input->get("id"); 
		$in=$this->m_reff->clearkomaray($id);
		$this->db->where_in("id",$in);
		$peserta=$this->db->get("data_peserta")->result();
	
		 $data=$this->db->query("select * from data_acara where kode='".$kode_acara."' ")->row();
		$tahun=substr($data->tgl,0,4);
		
 
		
foreach($peserta as $val)
{
 	 
	  $link=$this->m_reff->pengaturan(25)."/files/".$tahun."/".$kode_acara."/qr/".$val->qr.".png";
	  if(!file_exists($link)){
		  $this->m_reff->qr($kode_acara,$val->qr);
	  };
	 
?>

  

<page orientation="lanscape"    > 
<div class="bor" > 
<div id="isi" >
 
  
<!-----------> 
<div class="area">
<?php echo $data->template_1;?>
</div>
<!----------->
 
 </div>
 
 

 <?php
      $link=$this->m_reff->pengaturan(25)."/files/".$tahun."/".$kode_acara."/qr/".$val->qr.".png";
 if(file_exists($link)){?>
 
 <div class="barkode">
 <div >
 <img style='width:50px' src='<?php echo realpath($link) ?>'>  
 </div>
 <?php
	$x=explode("-",$val->qr);
 echo " <div  class='barkodeTitle'>".$x[1]."</div> </div>";?>
 
 <?php } ?>
 

 
 
</div>

</page>
 

<?php }

 

 

 