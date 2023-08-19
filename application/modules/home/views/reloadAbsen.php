<?php
$jam          = $this->mdl->dataAbsen();
$jam_masuk    = isset($jam->jam_masuk)?($jam->jam_masuk." WIB"):null;   
$jam_pulang   = isset($jam->jam_pulang)?($jam->jam_pulang." WIB"):null;
$jenis_absen  = isset($jam->jenis_absen)?($jam->jenis_absen):null;
$jenis_absen  = $this->m_reff->goField("tr_jenis_absen","nama","where id='".$jenis_absen."'");

if(isset($jam)){

    if($jam_masuk){
        $icon_jm = '<i class="fa fa-check-circle color-mint-dark"></i>';
    }else{
        $icon_jm = '<i class="fa fa-dot-circle color-dark-light"></i>';
    }
    if($jam_pulang){
        $icon_jp = '<i class="fa fa-check-circle color-mint-dark"></i>';
        $border_jp = 'border-mint-dark ';
        $text_jp = 'color-mint-dark';
    }else{
        $icon_jp = '<i class="fa fa-dot-circle color-dark-light"></i>';
        $border_jp = 'border-dark-dark ';
        $text_jp = "";
    }
    
    ?>
<div class="list-group list-boxes">

<a href="javascript:inputJob()" class="border border-blue-dark rounded-s shadow-s">
<span> <b>INPUT PEKERJAAN</b></span>
<!-- <strong class='<?= $text_jp;?>'><?php echo $jam_pulang; ?>  </strong> -->
<i class="fa fa-dot-circle  color-blue-dark"></i>
</a>


<a href="javascript:absen()" class="border border-mint-dark rounded-s shadow-xs"> 
<span><b>ABSEN  </b></span>
<strong class='color-mint-dark'> <?php echo $jam_masuk; ?>  - <?php echo $jenis_absen;?> </strong>
<?php echo $icon_jm;?>
</a>

<?php

if($jenis_absen=="WFO" or $jenis_absen=="DINAS"){?>
<a href="javascript:absen_pulang()" class="border <?= $border_jp;?> rounded-s shadow-s">
<span><b>ABSEN PULANG</b></span>
<strong class='<?= $text_jp;?>'><?php echo $jam_pulang; ?>  </strong>
<?php echo $icon_jp;?>
</a>
 <?php } ?>

</div>

<?php } ?>


 