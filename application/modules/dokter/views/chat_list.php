<?php
$idu = $this->session->userdata("id");
$id_msg = $this->input->post("id");

// TODO get data tanya_dokter
$this->db->where('id', $id_msg);

$data_tanya_dokter = $this->db->get("data_tanya_dokter")->result();
foreach ($data_tanya_dokter as $valTanya) {
    echo '
        <div class="clearfix"></div>
        <div class="media">
            <div class="main-img-user online"><img alt="" src="assets/' . $this->m_reff->peg_jk() . '.png"></div>
            <div class="media-body">
                <div class="main-msg-wrapper">
               ' . $valTanya->msg . '
                        </div>
                <div>
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
foreach ($data_komentar as $val) {
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
                </span><a class="text-danger" href="javascript:hapus_chat(`'.$val->id.'`)"><i class="icon text-danger ion-android-more-horizontal"></i>.Hapus</a>
                    </div>
                </div>
    </div>';
    } else {
        // echo '<div class="clearfix"></div>
        // <div class="speech-bubble bg-highlight speech-left color-white" style="min-width:150px">

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