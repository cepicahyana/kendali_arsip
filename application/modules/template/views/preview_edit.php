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
padding-top:83px;
padding-left:10px;
padding-right:10px;
padding-bottom:10px;
margin-left:-15px;
 }

   .tborder{border-collapse: collapse; word-wrap:break-word; word-break: break-all;table-layout: fixed;font-size:12px;}
                 .tborder2{border-collapse: collapse; word-wrap:break-word; word-break: break-all;table-layout: fixed;width:200mm;font-size:11px;}
               .tborder td,.tborder  th{word-wrap:break-word;word-break: break-all; 
			    font-size:12px;text-align:left;}
 		.mono{
	 // line-height:30px;
	}	     
	.monop{
	    padding:5px;
	}
	.monop2{
	    padding-top:2px;
	    padding-bottom:3px;
	}.monop3{
	    padding-top:2px;
	    padding-bottom:2px;
	}.monop4{
	    padding-top:4px;
	     
	}
	.sempit tr td{
padding:0;
}
 
.garuda{
width:80px;
margin-left:302px;
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
margin-top:15px;
}
 
table tr td{
	padding:1px;
	spaccing
}	
</style>
 
 
 
 
 

<style>
    
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
<style>
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
 </style>
 <div class="barkode">
 <div >
 <img style='width:50px' src='<?php echo realpath($link) ?>'>  
 </div>
 <?php
 
 echo " <div  class='barkodeTitle'>123456</div> </div>";?>
 
 <?php } ?>
 
 
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
 
 
</div>

</page>
 
 