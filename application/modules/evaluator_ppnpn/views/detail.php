<?php
      $nip = $this->m_reff->san($this->input->post("nip"));
?>

<style>
    .not_active{
        color: silver;
    }
</style>

<div class="row" id="area_formSubmit">
	<div class="col-sm-12">
        <div class="row clearfix">

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card" >
                    <div class="header mb-3">
                        <nav>
                            <a href="#" class="tab" id="profile">Profile</a> | 
                            <a href="#" class="tab" id="grafik">Grafik Penilaian</a> | 
                            <a href="#" class="tab" id="absen">Rekap Absen</a>
                        </nav>
                    </div>
                    <div class="body" id="body">

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    var nip = "<?php echo $this->m_reff->san($this->input->get_post('nip')) ?>";
    $('.body').load("<?=base_url()?>data_ppnpn/profile?nip="+nip);
    $("#grafik").addClass(" not_active");
    $("#absen").addClass(" not_active");
    
    $('.tab').click(function(){
        var menu = $(this).attr('id');
        if(menu == "profile"){
            $('.body').load("<?=base_url('data_ppnpn/profile?nip='.$nip)?>");
            $("#profile").removeClass(" not_active");
            $("#grafik").addClass(" not_active");
            $("#absen").addClass(" not_active");
        }
        if(menu == "grafik"){
            $('.body').load("<?=base_url('data_ppnpn/grafik?nip='.$nip)?>");
            $("#grafik").removeClass(" not_active");
            $("#profile").addClass(" not_active");
            $("#absen").addClass(" not_active");
        }
        if(menu == "absen"){
            $('.body').load("<?=base_url('data_ppnpn/absen?nip='.$nip)?>");
            $("#absen").removeClass(" not_active");
            $("#grafik").addClass(" not_active");
            $("#profile").addClass(" not_active");
        }
    });
    
</script>