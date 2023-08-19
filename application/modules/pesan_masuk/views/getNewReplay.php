<?php
	$msg	=	 $this->m_reff->sanitize($this->input->post("msg"));
	$idm	=	 $this->m_reff->sanitize($this->input->post("idm"));
	// $ai     =    ($this->m_reff->ai("data_komentar_admin")-1);

    $data_msg = $this->mdl->getReplay();
    if(!$data_msg){
        return false;
    }


    foreach($data_msg as $val){ 
        
            $komentator = $this->m_reff->goField("admin","owner","where id_admin='".$val->id_sender."' ");
            $jk_komen   = $this->m_reff->goField("data_pegawai","jk","where id='".$val->id_sender."' ");
            $this->mdl->updateKomen($val->id);
     
      
           echo '
        <div class="clearfix"></div>
        <div class="media">
            <div class="main-img-user online"><img alt="" src="assets/cs' . $this->m_reff->pic_jk() . '.png"></div>
            <div class="media-body">
                <div class="main-msg-wrapper">
               ' . $val->msg . '
                        </div>
                <div>
                    <span>' . date("H:i:s"). '</span> 
                   
                        </div>
                    </div>
                </div>';
    } ?>




 
 