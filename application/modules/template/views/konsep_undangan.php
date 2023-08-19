<style> 
 #isi{
padding-top:30px;
padding-left:10px;
padding-right:10px;
padding-bottom:10px;
 }
 	  
.garuda{
width:80px;
margin-top:30px;
margin-left:333px;
position:absolute;
}
.center{
background-color:red;
width:660px;
}
.area{
margin-left:-26px;
margin-top:45px;
//background-color:white;
}
.absolute{
position:absolute;
margin-top:25px;
}
 
.area table{
margin-left:40px;
}
     .monotype{
	    font-family:monotypecorsiva;
		  
	}	
 </style>
 
 <style>
 /*backimg="<?php echo base_url()?>plug/img/bg2.png"*/
.ttm{
	margin-left:430px; 
}
.kop{
	  
}
 #bg{
 //background-image:url(<?php echo base_url()?>plug/img/bg2.png);
 //  background-size: cover;
 height:99.9%;
 }
 #isi{
padding-top:20px;
//padding-left:10px;
padding-right:10px;
padding-bottom:10px;

 }

  .tborder{border-collapse: collapse; word-wrap:break-word; word-break: break-all;table-layout: fixed;font-size:12px;}
                 .tborder2{border-collapse: collapse; word-wrap:break-word; word-break: break-all;table-layout: fixed;width:200mm}
               .tborder td,.tborder  th{word-wrap:break-word;word-break: break-all;border: 1px solid #000;
			   padding-left:5px;padding-right:5px;padding-top:15px;padding-bottom:15px;font-size:12px;text-align:left;}
	.mono{
	 font-weight: 1600;
	}		   
        	.monop2{
	    padding:10px;
	}      
</style>


<?php
		$kode_acara=$this->input->get_post("kode"); 
		 
		 $data=$this->db->query("select * from data_acara where kode='".$kode_acara."' ")->row();
		$tahun=substr($data->tgl,0,4);
  
?>


 <?php
 $kode_acara=$data->kode;
  $persetujuan=$data->persetujuan;
?>



<page    > 

  <div align='right'><i>Konsep: <?php echo $this->tanggal->hariLengkap3(date('Y-m-d'))?>, pukul <?php echo date("H:i"); ?> WIB </i></div>  
 <div class="bor" > 
<div id="isi" >
 
<div align="center" class="absolute">
<img class="garuda absolute"  align="center" src="<?php echo realpath("plug/img/garuda.png")?>">
</div>
 
<!-----------> 
<div class="area">
<?php echo $data->template_1;?>
</div>
<!----------->
 
 </div>
 
 
 
 

 
 
</div>

   
  
  <br> <br>
  <table class="tborder">
      <tr><td colspan='2'><b>Paraf Persetujuan</b></td></tr>
                                <?php
                                $persetujuan=json_decode($persetujuan,TRUE); 
                                foreach($persetujuan as $key=>$val)
                                {?>
                                <tr><td>
                                   <?php echo $this->m_reff->goField("tr_persetujuan","pejabat","where id='".$key."' ");?>
                                </td><td style="width:200px"></td></tr>
                                <?php } ?>
 
</table>




 
</page>
 


 
 
 

