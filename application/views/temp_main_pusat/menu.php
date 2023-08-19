<?php
$level = $this->session->userdata('level');
if($level=="pimpinan_pusat"){
    $this->load->view("temp_main_pusat/menu_pimpinan_pusat");
}
?>

