<?php
$tgl = $this->input->post("range");
$type = $this->input->post("type");

$tgl1 = $this->tanggal->range_1($tgl, 0);
$tgl2 = $this->tanggal->range_2($tgl, 1);

 
 
$rs=$this->db->where("konfirm_rs>=",$tgl1);
$rs=$this->db->where("konfirm_rs<=",$tgl2);
$rs=$this->db->order_by("kode_istana");
 
// if($this->session->level=="pic_covid"){
//     $this->db->where("kode_istana",$this->session->kode_istana);
//     $this->db->where("kode_biro",$this->session->kode_biro);
// }

if($kode_istana=$this->session->userdata("kode_istana")){
    $this->db->where("kode_istana",$kode_istana);
}
if($kode_biro=$this->session->userdata("kode_biro")){
    $this->db->where("kode_biro",$kode_biro);
}
$this->db->select("*,count(*) as jml");
$this->db->group_by("kode_tempat");
$rs=$this->db->get("v_test")->result();

?>

<h5 class="text-center"><span>Rekap Total Periksa berdasarkan Rumah sakit</span></h5>
<p class="text-center">Tanggal <?php echo $this->tanggal->ind($tgl1, "/") ?> s.d <?php echo $this->tanggal->ind($tgl2, "/") ?></p>
<table class="table table-bordered table-striped" style="width:100%">
    <tr>
        <th>Tempat test</th>
       
        <?php
        if($this->session->level!="pic_covid"){?>
            <th>Naungan</th>
            <?php  }?>
            <th>Total yang periksa</th>
        </tr>
      
    <?php foreach($rs as $r){
        // $nama_rs = isset($r->kode_tempat)?$r->kode_tempat:"";
        
        $total=$r->jml;//$this->db->get_where("v_test",array("kode_tempat"=>$r->kode_tempat,"konfirm_rs>="=>$tgl1,"konfirm_rs<="=>$tgl2))->num_rows();
    ?>
    <tr>
        <td><?=$this->m_reff->goField("tm_rs","nama","kode='".$r->kode_tempat."'"); ?></td>
        <?php
        if($this->session->level!="pic_covid"){
          echo "<td>".$this->m_reff->istana($r->kode_istana)."</td>";
        }?>
        <td><?= $total ?></td>
    </tr>
    <?php }?>
</table>