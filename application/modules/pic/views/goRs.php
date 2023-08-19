<?php
$range = $tgl = $this->m_reff->san($this->input->post("range"));
$kode_istana = $this->m_reff->san($this->input->post("kode_istana"));
$kode_biro = $this->m_reff->san($this->input->post("kode_biro"));
 
$tgl1 = $this->tanggal->range_1($tgl, 0);
$tgl2 = $this->tanggal->range_2($tgl, 1);
$this->db->where("scan","1");
$this->db->where("konfirm_rs>=",$tgl1);
$this->db->where("konfirm_rs<=",$tgl2);
// $this->db->order_by("jml","desc");
// if($this->session->level=="pic_covid"){
//     $this->db->where("kode_istana",$this->session->kode_istana);
//     $this->db->where("kode_biro",$this->session->kode_biro);
// }

if($kode_istana){
    $this->db->where("kode_istana",$kode_istana);
}
if($kode_biro){
    $this->db->where("kode_biro",$kode_biro);
}
$this->db->select("DISTINCT(kode_tempat),kode_istana");

// $this->db->group_by("kode_tempat");
$rs=$this->db->get("v_test")->result();
?>

<p>Tanggal <?php echo $this->tanggal->ind($tgl1, "/") ?> s.d <?php echo $this->tanggal->ind($tgl2, "/") ?></p>

<table class="entry2">
    <tr>
        <th>Tempat test</th>
       
        <?php
        if($this->session->level!="pic_covid"){?>
            <th>Naungan</th>
            <?php  }?>
            <!-- <th>Total Tes</th> -->
            <?php
            $dbtest = $this->mdl->listJenisTes();
            foreach($dbtest as $l){
                echo "<th>".$l->nama."</th>";
            }
            ?>
        </tr>
          
    <?php 
    $total_semua = 0; $row=0;
    foreach($rs as $r){
        // $nama_rs = isset($r->kode_tempat)?$r->kode_tempat:"";
        
        $total="0000";///$r->jml;//$this->db->get_where("v_test",array("kode_tempat"=>$r->kode_tempat,"konfirm_rs>="=>$tgl1,"konfirm_rs<="=>$tgl2))->num_rows();
        $total_semua+=$total;
   ?>
    <tr>
        <td width="300px"><?=$this->m_reff->goField("tm_rs","nama","kode='".$r->kode_tempat."'"); ?></td>
        <?php
        if($this->session->level!="pic_covid"){
          echo "<td> Istana".$this->m_reff->istana($r->kode_istana,"singkat")."</td>";
        }?>
        
        <!-- <td width="100px"><?= $total ?></td> -->
       
        <?php
            $dbtest = $this->mdl->listJenisTes();
            $no=array();$i=1;
            $t=0;
            foreach($dbtest as $l){
                $jml = $this->mdl->jmlTest($range,$l->kode,$r->kode_tempat);
                echo "<td>".$jml."</td>";
                
            }  
            ?>
            </tr>
 
    <?php }?>

    <tr>
    <?php
        if($this->session->level!="pic_covid"){?>
           <td colspan="2"><b>Total</b></td>
            <?php  }else{?>
                <td><b>Total</b></td>
            <?php }    ?>
        
            
            <!-- <td><b><?= $total_semua?></b></td> -->
            <?php
            foreach($dbtest as $l){
                $jml = $this->mdl->jmlTest($range,$l->kode);
                echo "<td><b>".$jml."</b></td>";
            }  
            ?>
            </tr>
</table>