<?php
$idu    =     $this->session->userdata("id");
$this->db->where("(sender='" . $this->input->post("id") . "' and receiver='" . $idu . "')");
$this->db->or_where("(receiver='" . $this->input->post("id") . "' and sender='" . $idu . "')");
$this->db->order_by("tgl", "asc");
$data    =     $this->db->get("data_chat")->result();
foreach ($data as $val) {

    if ($idu == $val->sender) {
        // echo '<div class="clearfix"></div>
        // <div class="speech-bubble speech-right color-black  " style="min-width:150px">

        // <span style="color:black;font-size:16px;">'.$val->msg.'</span> <br><br>
        // <span style="font-size:10px;margin-left:-2px;position:absolute;width:200px;margin-top:-10px;color:black">'.$this->tanggal->hariLengkapJam($val->tgl,"/").'</span>
        // </div>';
        echo '	<div class="media flex-row-reverse">
        <div class="main-img-user online"><img alt="" src="assets/' . $this->m_reff->peg_jk() . '.png">                </div>
        <div class="media-body">
            <div class="main-msg-wrapper">
            ' . $val->msg . '
                    </div>
            <div>
                <span>
                ' . $this->tanggal->hariLengkapJam($val->tgl, "/") . ' 
                </span> <a href=""><i class="icon ion-android-more-horizontal"></i></a>
                    </div>
                </div>
    </div>
';
    } else {
        // echo '<div class="clearfix"></div>
        // <div class="speech-bubble bg-highlight speech-left color-white" style="min-width:150px">

        // <span style="color:white;font-size:16px;">'.$val->msg.'</span> <br><br>
        //  <span style="font-size:10px;margin-left:-2px;position:absolute;width:200px;margin-top:-10px;color:white">'.$this->tanggal->hariLengkapJam($val->tgl,"/").'</span>

        // </div>';
        echo '
        <div class="clearfix"></div>
        <div class="media">
            <div class="main-img-user online"><img alt="" src="assets/' . $this->m_reff->peg_jk() . '.png">                </div>
            <div class="media-body">
                <div class="main-msg-wrapper">
               ' . $val->msg . '
                        </div>
                <div>
                    <span>' . $this->tanggal->hariLengkapJam($val->tgl, "/") . '</span> <a href=""><i class="icon ion-android-more-horizontal"></i></a>
                        </div>
                    </div>
                </div>';
    }
} ?>
<div id="isiChat"></div>