<?php
$level = $this->session->userdata('level');
if($level=="admin_data" or $level=="super_admin"){
    $this->load->view("temp_main_data/menu_admin_data");
}
?>

