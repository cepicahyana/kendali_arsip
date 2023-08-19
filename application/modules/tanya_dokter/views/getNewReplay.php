<?php
	$msg	=	 $this->input->post("msg");
	$idm	=	 $this->input->post("idm");
	// $ai     =    ($this->m_reff->ai("data_komentar")-1);

    $data_msg = $this->mdl->getReplay();
    if(!$data_msg){
        return false;
    }


    foreach($data_msg as $val){ 
        
            $komentator = $this->m_reff->goField("data_dokter","nama","where id='".$val->id_sender."' ");
            $jk_komen   = "dokter_".$this->m_reff->goField("data_dokter","jk","where id='".$val->id_sender."' ");
     
        ?>
        <div id="com<?php echo $val->id?>" class='geserkanan'>
        <div class="media d-block d-sm-flex mg-t-25" onclick="hapus_com(`<?php echo $val->id?>`)">
                <img alt="" class='mundurImg' align="left" src="<?php echo base_url()?>assets/<?php echo $jk_komen;?>.png">
                <div class="media-body">
                    <div class="geserkomen">	
                        <h5 class="mg-b-5 tx-inverse tx-15 text-success">&nbsp;&nbsp; <?php echo $komentator; ?>
                     
<!--      
        <a href="javascript:hapus_com(`<?php echo $val->id?>`)" style="font-size:12px;margin-top:-15px;margin-left:40px;" 
        class="fa fa-times-circle text-danger">   </a> -->
        
         </h5>
    
                        <span class="font-11 text-info d-block mt-n1">&nbsp;&nbsp; 
                        <?php echo $this->tanggal->hariLengkapJam(date('Y-m-d H:i:s'))?> wib.</span>
                        <span class="font-16"> &nbsp; <?php echo $val->msg;?> </span>
                    </div>
               </div>
                      
                    </div>
    
        </div>
 <?php   } ?>




 
 