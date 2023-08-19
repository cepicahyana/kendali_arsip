<?php
$idu = $this->session->userdata("id");
$id_msg = $this->m_reff->sanitize($this->input->post("id"));
// $idu    = $this->m_reff->goField("data_komentar_admin","id_sender","where id='".$id_msg."'");
 
 
// TODO get data tanya_dokter
$this->db->where('id', $id_msg);
$valTanya = $this->db->get("data_tanya_admin")->row();
if(!isset($valTanya)){
    echo "data tidak ditemukan";
    return false;
}
$sts = $valTanya->sts;
    echo '
        <div class="clearfix"></div>
        <div class="media">
            <div class="main-img-user online"><img alt="" src="assets/' . $this->m_reff->peg_jk($valTanya->id) . '.png"></div>
            <div class="media-body">
                <div class="main-msg-wrapper">
               ' . $valTanya->msg . '
                        </div>
                <div>
                    <span>' . $this->tanggal->hariLengkapJam($valTanya->tgl, "/") . '</span> <a href=""><i class="icon ion-android-more-horizontal"></i></a>
                        </div>
                    </div>
                </div>';


// get data komentar dari dokter
$this->db->where('id_msg', $id_msg);
//$this->db->where('id_sender', 3);
$this->db->order_by("tgl", "asc");
$data_komentar = $this->db->get("data_komentar_admin")->result();
$jk_komen   = $this->m_reff->pic_jk();

foreach ($data_komentar as $val) {
    $namaPic = "<span class='text-info'>".$this->m_reff->goField("admin","owner","where id_admin='".$val->id_sender."'")."</span>";
 
    // $komentator = $this->m_reff->goField("data_dokter", "nama", "where id='" . $val->id_sender . "' ");
  if($sts==1){
    $btnhapus = "";
  }else{
    $btnhapus = '<a href="javascript:hapus_chat(`'.$val->id.'`)" class="text-danger"><i class="icon ion-android-more-horizontal"></i> . hapus </a>';
  }

    if ($idu == $val->id_sender) {
        // echo '<div class="clearfix"></div>
        // <div class="speech-bubble speech-right color-black  " style="min-width:150px">

        // <span style="color:black;font-size:16px;">'.$val->msg.'</span> <br><br>
        // <span style="font-size:10px;margin-left:-2px;position:absolute;width:200px;margin-top:-10px;color:black">'.$this->tanggal->hariLengkapJam($val->tgl,"/").'</span>
        // </div>';
        echo '<div class="media flex-row-reverse" id="msg'.$val->id.'">
        <div class="main-img-user online"><img alt="" src="'.base_url().'assets/cs' . $jk_komen . '.png"></div>
        <div class="media-body"><span>'.$namaPic.'</span>
            <div class="main-msg-wrapper">
            ' . $val->msg . '
                    </div>
            <div>
                <span>
                ' . $this->tanggal->hariLengkapJam($val->tgl, "/") . ' 
                </span> '.$btnhapus.'
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