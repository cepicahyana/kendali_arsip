 <?php
    $db       =    $this->m_reff->dataProfilePegawai();
    $nama     =    "Anda";
    $jk       =    $db->jk;

    //   $cdate = $this->m_reff->_cdate(); 
    //   $this->db->where("tgl>=",$cdate);
    $limit    =     $this->input->post("limit");
    $this->db->order_by("tgl_respon", "asc");
    $this->db->limit(10, ($limit));
    $this->db->where("id_sender", $this->m_reff->idu());
    $data    = $this->db->get("data_tanya_dokter")->result();
    foreach ($data as $val) {
        if ($val->id_sender != $this->m_reff->idu()) {
            $komentator = $this->m_reff->goField("data_dokter", "nama", "where id='" . $val->id_sender . "' ");
            $jk_komen   = "dokter_" . $this->m_reff->goField("data_dokter", "jk", "where id='" . $val->id_sender . "' ");
        } else {
            $komentator = "<span class='text-success'>" . $nama . "</span>";
            $jk_komen   = $jk;
        }
    ?>


     <div id="card<?php echo $val->id ?>">
         <div class="  ">


             <div class="">
                 <div class="content mb-0">



                     <div class="card card-body card-style">
                         <div class="media d-block d-sm-flex">
                             <img align="left" alt="" class="main-img-user avatar-lg mg-sm-r-20 mg-b-20 mg-sm-b-0" src="assets/l.png">
                             <div class="media-body">
                                 <div class="geserstatus">
                                     <h5 class="mg-b-5 tx-inverse tx-15 text-success">Anda</h5>
                                     <p class="font-16"><?php echo $val->msg; ?></p>
                                 </div>

                                 <div id="msg<?php echo $val->id; ?>"></div>

                                 <div class="align-self ml-auto">
                                     <a class="bg-warning akhiri-obrolan" style="color:black;padding:2px;border-radius:20px;float:right" onclick="lihat_obrolan(`<?php echo $val->id; ?>'`)" href="javascript:void(0)"> <span class="text-info"></span> <i class="typcn typcn-arrow-forward-outline"></i>
                                         <?php echo $this->mdl->jml_obrolan($val->id); ?> percakapan &nbsp; </a>

                                 </div>

                             </div>
                         </div>
                     </div>









                 </div>
             </div>


         </div>
     </div>

 <?php } ?>


 <div id="lastStatus"></div>