<?php
error_reporting(1);
?>
<style>
    .font-16 {
        font-size: 14px;
    }

    .font-11 {
        font-size: 11px;
    }

    @media only screen and (min-width: 700px) {
        .akhiri-obrolan {
            margin-left: -80px;
        }
    }

    @media only screen and (max-width: 700px) {
        .geserkanan {
            margin-left: 30px;
        }

        .mundurImg {
            margin-left: -25px;
        }

        .geserstatus {
            margin-left: 70px;
        }
    }
</style>











<div id="newStatus"></div>
<?php


//$this->m_reff->goField("data_pegawai", "id, nama, jk", "id=3");



$idDokter = $this->m_reff->idu();
$this->db->order_by("tgl_respon", "asc");
$this->db->limit(10, 0);
$this->db->where("sts", "1");
// $this->db->where("id_dokter",$idDokter);
$data    = $this->db->get("data_tanya_dokter")->result();
$chat    = false;
foreach ($data as $val) {
    $chat = true;
    $this->db->select('id, nama, jk');
    $this->db->where('id', $val->id_sender);
    $getPegawai = $this->db->get('data_pegawai')->row();
    $idPegawai  = $getPegawai->id;
    $jk         = $getPegawai->jk;
    $nama       = (isset($getPegawai->nama)) ? ucwords($getPegawai->nama) : "Anda";
?>

    <div id="card<?php echo $val->id ?>">
        <div class="  ">
            <div class="">
                <div class="content mb-0">
                    <div class="card card-body card-style">
                        <div class="media d-block d-sm-flex">
                            <img align="left" alt="" class="main-img-user avatar-lg mg-sm-r-20 mg-b-20 mg-sm-b-0" src="<?php echo base_url()?>assets/<?php echo $jk; ?>.png">
                            <div class="media-body">
                                <div class="geserstatus">
                                    <h5 class="mg-b-5 tx-inverse tx-15 text-success"><?php echo $nama; ?></h5>
                                <span style="font-size:10px"> <?php echo $this->tanggal->hariLengkapJam($val->tgl, "/");?></span> 
                                    <p class="font-16"><?php echo $val->msg; ?></p>
                           
                                </div>
                                <hr style='border:white solid 1px'>
                                <div id="msg<?php  $val->id; ?>"></div>

                                <div class="align-self ml-auto">
                                    
                                    <?php if ($val->id_sender == $this->m_reff->idu()) { ?>
                                        <a class="bg-info akhiri-obrolan" style="color:white;padding:2px;border-radius:20px;float:left" onclick="akhiri(`<?php echo $val->id ?>`)" href="javascript:void(0)"> <span class="text-info"></span> <i class="typcn typcn-arrow-forward-outline"></i> Akhiri obrolan &nbsp; </a>

                                        <a class="color-red " style="float:right" onclick="hapus_sts(`<?php echo $val->id ?>`)" href="javascript:void(0)" class="color-red2-dark"> <span class="text-info">|</span>
                                            <font color='red' class='pr-2'> <i class='fa fa-times-circle '></i> Hapus</font>
                                        </a>
                                        <?php } ?>&nbsp;

                                        <?php
                                        if($jml=$this->mdl->jml_obrolan($val->id)){
echo '<a class="text-blue2-dark btn btn-warning btn-sm"   href="javascript:replay(`'.$val->id.'`,`'.$val->msg.'`)" class="color-theme"><i class="fa fa-eye pr-2"></i>
 '.$jml.' percakapan  </a>';
                                        }else{
echo '<a class="text-blue2-dark bg-warning" style="border-radius:20px;padding:2px;color:black;float:right;margin-right:5px" href="javascript:replay(`'.$val->id.'`,`'.$val->msg.'`)" class="color-theme">
<i class="fa fa-plant pr-2"></i>Tanggapi sekarang&nbsp;</a>';
                                        }?>
                                        


                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

<?php } ?>

<?php
if(!$chat){
echo "<div class='card card-body'> Pertanyaan belum tersedia. </div>";
}
?>

<div id="lastStatus"></div>




<!--
<center>
<a href="#" style="width:90%" class="btn btn-m btn-full mb-3 rounded-xl text-uppercase font-900 shadow-s bg-brown1-light fa fa-sync-alt"> Tampilkan status sebelumnya</a>
</center>
 -->



<input id="limit" type="hidden" value="10">
<script>
    // DESKTOP PAGINATION SCROLL
    $(window).scroll(function() {
        if ($(window).scrollTop() == $(document).height() - $(window).height()) {
            var limit = $('#limit').val();
            var limit = parseInt(limit);

            var limited = parseInt(limit + 10)
            $('#limit').val(limited);

            // var token = $('.formTrigerCerita').serialize();
            var param = {
                limit: limit,
                <?php echo $this->m_reff->tokenName() ?>: token
            };
            $.ajax({
                type: 'post',
                url: '<?php echo base_url() ?>tanya_dokter/page_status',
                data: param,
                dataType: "json",
                async: true,
                success: function(val) {
                    //   token = val["token"];
                    $('#lastStatus').append(val["data"]).slideDown('slow');
                }
            });
        }
    });

    // MOBILE PAGINATION SCROLL
    $(window).on({
        touchmove: function() {
            // alert($(this).scrollTop()+"_"+$(document).height()+"_"+$(this).height());
            if ($(this).scrollTop() >= $(document).height() - ($(this).height() + 68)) {
                // alert($(document).height());
                //	  alert($(this).scrollTop()+"_"+$(document).height()+"_"+$(this).height());
                var limit = $('#limit').val();
                var limit = parseInt(limit);
                var limited = parseInt(limit + 10)
                $('#limit').val(limited);

                // var token = $('.formTrigerCerita').serialize();
                var param = {
                    limit: limit,
                    <?php echo $this->m_reff->tokenName() ?>: token
                };
                $.ajax({
                    type: 'post',
                    url: '<?php echo base_url() ?>tanya_dokter/page_status',
                    data: param,
                    async: true,
                    dataType: "json",
                    success: function(data) {
                        // token = val["token"];
                        $('#lastStatus').append(val["data"]).slideDown('slow');
                    }
                });
            }
        }
    });
</script>