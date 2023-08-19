<?php
	$msg	=	  $this->m_reff->san($this->input->post("msg"));
	$idm	=	  $this->m_reff->san($this->input->post("idm"));
	$ai     =    ($this->m_reff->ai("data_komentar")-1);
?>


<div id="com<?php echo $ai?>" class='geserkanan'>
    <div class="media d-block d-sm-flex mg-t-25" onclick="hapus_com(`<?php echo $ai?>`)">
			<img alt="" class='mundurImg' align="left" src="<?php echo base_url()?>assets/<?php echo $this->m_reff->peg_jk()?>.png">
			<div class="media-body">
                <div class="geserkomen">	
                    <h5 class="mg-b-5 tx-inverse tx-15 text-success">&nbsp;&nbsp;Anda
                 
 
	<a href="javascript:hapus_com(`<?php echo $ai?>`)" style="font-size:12px;margin-top:-15px;margin-left:40px;" 
    class="fa fa-times-circle text-danger">   </a>
	
	 </h5>

                    <span class="font-11 text-info d-block mt-n1">&nbsp;&nbsp; 
                    <?php echo $this->tanggal->hariLengkapJam(date('Y-m-d H:i:s'))?> wib.</span>
                    <span class="font-16"> &nbsp; <?php echo $msg;?> </span>
                </div>
           </div>
                  
                </div>

    </div>

 

<div id="msg<?php echo $idm;?>"></div>