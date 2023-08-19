<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-titles" id="defaultModalLabel"><b>Riwayat obrolan </b></h5>
        <button type="button" class="close" aria-label="Close" data-dismiss="modal">
            <span aria-hidden="true">×</span>
        </button>
    </div>


    <?php
    error_reporting(0);
    ?>


    <?php
    $db       =    $this->m_reff->dataProfilePegawai();
    $nama     =    $db->nama;
    $jk       =    $db->jk;

    $this->db->order_by("tgl", "DESC");
    $this->db->where("id", $this->input->post("id"));
    $this->db->where("id_sender", $this->m_reff->idu());
    $data    = $this->db->get("data_tanya_dokter")->result();
    foreach ($data as $val) {
    ?>


        <div id="card<?php echo $val->id ?>">
            <div class="  ">


                <div class="">
                    <div class="content mb-0">



                        <div class="  card-body card-style">
                            <div class="media d-block d-sm-flex">
                                <img align="left" alt="" class="main-img-user avatar-lg mg-sm-r-20 mg-b-20 mg-sm-b-0" src="assets/<?php echo $jk; ?>.png">
                                <div class="media-body">
                                    <div class="geserstatus">
                                        <h5 class="mg-b-5 tx-inverse tx-15"><?php echo $nama; ?></h5>
                                        <p class="font-16"><?php echo $val->msg; ?></p>
                                    </div>
                                    <hr style='border:white solid 1px'>
                                    <?php

                                    $dataKomen = $this->mdl->dataKomen($val->id);
                                    foreach ($dataKomen as $kom) {
                                        if ($kom->id_sender != $this->m_reff->idu()) {
                                            $komentator = $this->m_reff->goField("data_dokter", "nama", "where id='" . $kom->id_sender . "' ");
                                            $jk_komen   = "dokter_" . $this->m_reff->goField("data_dokter", "jk", "where id='" . $kom->id_sender . "' ");
                                        } else {
                                            $komentator = "<span class='text-success'>" . $nama . "</span>";
                                            $jk_komen   = $jk;
                                        } ?>
                                        <!---- area replay --->
                                        <div id="com<?php echo $kom->id ?>" class='geserkanan'>
                                            <div class="media d-block d-sm-flex mg-t-25">
                                                <img alt="s" class='mundurImg' align="left" src="assets/<?= $jk_komen ?>.png">
                                                <div class="media-body">
                                                    <div class="geserkomen">
                                                        <h5 class="mg-b-5 tx-inverse tx-15">&nbsp;&nbsp;<?= $komentator; ?></h5>

                                                        <span class="font-11 text-info d-block mt-n1">&nbsp;&nbsp; <?php echo $this->tanggal->hariLengkapJam($kom->tgl) ?> wib.</span>
                                                        <span class="font-16"> &nbsp; <?php echo $kom->msg; ?> </span>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>

                                        <!---- area replay --->
                                    <?php
                                    } ?>

                                </div>
                            </div>

                        </div>
                    </div>


                </div>
            </div>

        <?php } ?>