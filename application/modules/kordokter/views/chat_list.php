<!-- <style>
    #img-dok{
        margin-right: 20px;
    }
    #msg-dok{
        align-self: end;
    }
    #span-dok{
        align-self: end;
    }

    @media (min-width: 576px){
        #media-dok{
            margin-right: 20px;
        }
    }
    @media (max-width: 575px){
        #media-dok{
            margin-right: 10px;
        }
    }
</style> -->

<?php
$idu = $this->session->userdata("id");
$id_msg = $this->input->post("id");

// TODO get data tanya_dokter
// $this->db->where('id', $ids_msg);

$data_tanya_dokter = $this->db->get("data_tanya_dokter")->result();
foreach ($data_tanya_dokter as $valTanya) {
    echo '
        <div class="clearfix"></div>
        <div class="media">
            <div class="main-img-user online" id="img-dok"><img alt="" src="assets/' . $this->m_reff->peg_jk() . '.png"></div>
            <div class="media-body" id="media-dok">
                <div class="main-msg-wrapper" id="msg-dok">
                    ' . $valTanya->msg . '
                </div>
                <div id="span-dok">
                    <span>' . $this->tanggal->hariLengkapJam($valTanya->tgl, "/") . '</span> <a href=""><i class="icon ion-android-more-horizontal"></i></a>
                </div>
            </div>
        </div>';
}

// get data komentar dari dokter
$this->db->where('id_msg', $id_msg);
//$this->db->where('id_sender', 3);
$this->db->order_by("tgl", "asc");
$data_komentar = $this->db->get("data_komentar")->result();
$i=0;
foreach ($data_komentar as $val) {
    if($i==0){
        $idu = $val->id_sender;
    }else{
        $idu=null;
    }$i++;
  
    $komentator = $this->m_reff->goField("data_dokter", "nama", "where id='" . $val->id_sender . "' ");
    $jk_komen   = "dokter_" . $this->m_reff->goField("data_dokter", "jk", "where id='" . $val->id_sender . "' ");

    if ($idu == $val->id_sender) {
        // echo '<div class="clearfix"></div>
        // <div class="speech-bubble speech-right color-black  " style="min-width:150px">

        // <span style="color:black;font-size:16px;">'.$val->msg.'</span> <br><br>
        // <span style="font-size:10px;margin-left:-2px;position:absolute;width:200px;margin-top:-10px;color:black">'.$this->tanggal->hariLengkapJam($val->tgl,"/").'</span>
        // </div>';
        echo '<div class="media flex-row-reverse" id="msg'.$val->id.'">
        <div class="main-img-user online"><img alt="" src="assets/' . $jk_komen . '.png"></div>
        <div class="media-body">
            <div class="main-msg-wrapper">
            ' . $val->msg . '
            </div>
                <div>
                    <span>
                    ' . $this->tanggal->hariLengkapJam($val->tgl, "/") . ' 
                    </span>
                        
                    </div>
                </div>
    </div>';
    } else {
        // echo '<div class="clearfix"></div>
        // <div class="spee xch-bubble bg-highlight speech-left color-white" style="min-width:150px">

        // <span style="color:white;font-size:16px;">'.$val->msg.'</span> <br><br>
        //  <span style="font-size:10px;margin-left:-2px;position:absolute;width:200px;margin-top:-10px;color:white">'.$this->tanggal->hariLengkapJam($val->tgl,"/").'</span>

        // </div>';
        echo '
        <div class="clearfix"></div>
        <div class="media">
            <div class="main-img-user online"><img alt="" src="assets/' . $this->m_reff->peg_jk() . '.png"></div>
            <div class="media-body">
                <div class="main-msg-wrapper">
               ' . $val->msg . '
                        </div>
                <div>
                    <span>' . $this->tanggal->hariLengkapJam($val->tgl, "/") . '</span> 
                        </div>
                    </div>
                </div>';
    }
} ?>
<div id="isiChat"></div>