<?php
$file = $this->input->post("file");
$jab  = $this->input->post("jabatan");
        $this->db->where("title",$jab);
        $this->db->where("org",$file);
$data = $this->db->get("tm_formasi_org")->result();
foreach($data as $val){
    echo $val->subtitle;
echo "<input class='form-control mb-2' type='text' value='".$val->kuota."'>";
}
?>