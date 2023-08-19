<?php
 if($this->session->userdata("level")=="admin") {
    echo $this->load->view("temp_user/navbar_admin");
} elseif($this->session->userdata("level")=="broadcast") {
    echo $this->load->view("temp_user/navbar_broadcast");
} else{
    echo $this->load->view("temp_user/navbar_pimpinan");
}

?>
    
