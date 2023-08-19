<?php
$level = $this->session->userdata("level");
if($level=="admin_covid" or $level=="super_admin" or $level=="pimpinan_covid"){
    $this->load->view("temp_main/menu_admin");
}elseif($level=="pegawai" or $level=="ppnpn"){
    $this->load->view("temp_main/menu_pegawai");
}elseif($level=="rs"){
    $this->load->view("temp_main/menu_rs");
}elseif($level=="pic_covid"){
    $this->load->view("temp_main/menu_pic");
}elseif($level=="dokter"){
    $this->load->view("temp_main/menu_dokter");
}elseif($level=="kordokter"){
    $this->load->view("temp_main/menu_kordokter");
}
?>

