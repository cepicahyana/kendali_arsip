<div class="col-md-3 mb-3">
    <select name="tahun" id="thn" class="form-control" onchange="loadKonten()">
    <?php
        $YNow = date('Y');
        for ($thn=$YNow; $thn > ($YNow-10); $thn--) { ?>
            <option value="<?=$thn?>"><?=$thn?></option>
    <?php }
    ?>
    </select>
</div>

<div id="konten"></div>

<script>
    loadKonten();

    function loadKonten(){
        var nip = "<?=$this->input->get_post('nip')?>";
        var tahun = $("#thn option:selected").val();
        var url = "<?php echo site_url("data_ppnpn/dataAbsen");?>";
        var param = {nip:nip, tahun:tahun, <?= $this->m_reff->tokenName()?>:token };
        $.ajax({
            type: "POST",dataType: "json",data: param, url: url,
            success: function(val) {
                token=val['token'];
                $("#konten").html(val['data']);
            }
        });
    }
</script>