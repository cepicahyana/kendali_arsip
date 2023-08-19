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
</style>
 
  
<style>
 .tablersvp{
       margin-top:340px;
        // text-align:right;
        
         position:absolute;
         float:right;
           margin-bottom:-68px;
 }
     
     	.rsvp{
	    border-collapse: collapse; word-wrap:break-word; word-break: break-all;table-layout: fixed;font-size:9px;
	    width:300px;
	}
		.rsvp2{
	    border-collapse: collapse; word-wrap:break-word; word-break: break-all;table-layout: fixed;font-size:9px;padding-top:10px;
	    width:255px;
	}
 </style>
  


<page orientation="lanscape"  class="white" > 
<div class="bor" > 
<div id="isi" >
 
<div align="center" class="absolute">
<img class="garuda absolute"  align="center" src="<?php echo realpath("plug/img/garuda.png")?>">
</div>
 
<!-----------> 
<div class="area">
<?php echo $data->isi;?>
</div>
<!----------->
 
 </div>
 
 
 <?php
      $link="plug/img/qr.png";
 if(file_exists($link)){?>

 <div class="barkode">
 <div >
 <img style='width:50px' src='<?php echo realpath($link) ?>'>  
 </div>
 <?php
 
 echo " <div  class='barkodeTitle'>123456</div> </div>";?>
 
 <?php } ?>
 

 
 
</div>

</page>
 
 