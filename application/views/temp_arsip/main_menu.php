<?php
$level = $this->session->userdata("level");
$this->load->view("temp_arsip/menu_".$level);
?>