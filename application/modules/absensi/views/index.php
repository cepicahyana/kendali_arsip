 	<div class="card-body  iq-card " id="area_lod">

	 <div class="col-md-3 col-sx-12 col-xs-12 pull-right">
		<input required style='color:black;min-width:180px;margin-left:-20px' type="text" id="periode" name="periode" class="cursor form-control" onchange="getData()" >
	</div>
                                 

			<div class="row">
			<?php 
		 	$level = $this->session->userdata("level");
		 	// status admin
		 	if ($level === 'admin_ppnpn' or $level==='super_admin' or !$this->session->userdata('kode_istana')): ?>
			<div class="col-md-4 mb-4">
 				<?php
					$dtIstana[null] = "-- Filter Instana   --";
					$db=$this->m_reff->list_istana()->result();
					foreach($db as $db){
						$dtIstana[$db->kode] = $db->istana;
					}
					echo form_dropdown("kode_istana", $dtIstana, "", "class='text-black form-control' onchange='getData()'") ?>
 			</div>
			  
			<?php endif; 
		 	// status admin
		 	if ($level === 'admin_ppnpn' or $level==='super_admin' or !$this->session->userdata('kode_biro')): ?>
		 
			 <div class="col-md-4 mb-4">
 				<?php
					$dtBiro[null] = "-- Filter Biro   --";
					$db=$this->m_reff->list_biro()->result();
					foreach($db as $db){
						$dtBiro[$db->kode] = $db->biro;
					}
					echo form_dropdown("kode_biro", $dtBiro, "", "class='text-black form-control' onchange='getData()'") ?>
 			</div>
			<?php endif ?>

			<div class="col-md-4 mb-4">
 				<?php
					$dtBidang[null] = "-- Filter Bagian PPNPN --";
					$db=$this->m_reff->list_bagian(2)->result();
					foreach($db as $db){
						$dtBidang[$db->bagian] = $db->bagian;
					}
				  	echo form_dropdown("bidang", $dtBidang, null, "class='text-black form-control' onchange='getData()'") ?>
 			</div>
 
 			<!-- <div class="col-md-4 mb-4">
 				<?php
					$dtJk[null] = "-- Filter  gender--";
					$dtJk["l"] = "Laki-Laki";
					$dtJk["p"] = "Perempuan";

					echo form_dropdown("jk", $dtJk, "", "class='text-black form-control' onchange='getData()' ") ?>
 			</div> -->
 			 
 		</div>
		 </div>

		 <div class="  card">
			<div class="card-body">
				<div class="col-md-12 table-responsive">
					<div id="dataAbsen"></div>
			</div>
		 </div>
 	</div>
 
  



 <script>
	function getData() {
		loading("dataAbsen");
		var url   = "<?php echo site_url("absensi/range_absen");?>";
		var periode = $("#periode").val();
		var kode_istana = $("[name='kode_istana']").val();
		var kode_biro = $("[name='kode_biro']").val();
		var absen = $("[name='absen']").val();
		var bidang = $("[name='bidang']").val();
		var jk = $("[name='jk']").val();
		var param = {absen:absen,kode_biro:kode_biro,kode_istana:kode_istana,jk:jk,bidang:bidang,periode:periode,<?php echo $this->m_reff->tokenName()?>:token};
				$.ajax({
						type: "POST",dataType: "json",data: param, url: url,
						success: function(val){
							unblock("dataAbsen");
							token=val['token'];
							$("#dataAbsen").html(val['data']);
						}
				});	
 	}


 	function detail(nip,periode) {
		$("#mdl_formSubmit").modal();
		$("#mdlValue").html("mohon tunggu...");
		var url   = "<?php echo site_url("absensi/detail");?>";
				var param = {nip:nip,periode:periode,<?php echo $this->m_reff->tokenName()?>:token};
				$.ajax({
						type: "POST",dataType: "json",data: param, url: url,
						success: function(val){
							token=val['token'];
							$("#mdlValue").html(val['data']);
						}
				});	
 	}
 	function detailTgl(nip,tgl) {
		$("#mdl_formSubmit").modal();
		$("#mdlValue").html("mohon tunggu...");
		var url   = "<?php echo site_url("absensi/detailTgl");?>";
		var param = {nip:nip,tgl:tgl,<?php echo $this->m_reff->tokenName()?>:token};
				$.ajax({
						type: "POST",dataType: "json",data: param, url: url,
						success: function(val){
							token=val['token'];
							$("#mdlValue").html(val['data']);
						}
				});	
 	}
 </script>
 
 


 <!-- Modal -->
 <div class="modal  fade" id="mdl_formSubmit" tabindex="-9991" style="z-index:1199" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
 	<div id="mdl_size" class="modal-dialog modal-lg" role="document">
 		<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
 			<div class="modal-content">
 				<div class="modal-body">
 					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
 						<span aria-hidden="true">&times;</span>
 					</button>
 					<div id="mdlValue"></div>
 				</div>
 			</div>
 		</div>
 	</div>
 </div>





 
 <script>
$('#periode').daterangepicker({
    "showDropdowns": true,
    ranges: {
      //  'Hari ini': [moment(), moment()],
      //  'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
       
    //    '30 Hari yang lalu': [moment().subtract(29, 'days'), moment()],
        'Bulan ini': [moment().startOf('month'), moment().endOf('month')],
        'Bulan kemarin': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
    "locale": {
        "format": "DD/MM/YYYY",
        "separator": " - ",
        "applyLabel": "Apply",
        "cancelLabel": "Cancel",
        "fromLabel": "From",
        "toLabel": "To",
        "customRangeLabel": "Sesuaikan",
        "weekLabel": "W",
        "daysOfWeek": [
			"Min",
            "Sen",
            "Sel",
            "Rab",
            "Kam",
            "Jum",
            "Sab",
             
        ],
        "monthNames": [
            "Januari",
            "Februari",
            "Maret",
            "April",
            "Mei",
            "Juni",
            "Juli",
            "Agustus",
            "September",
            "Oktober",
            "November",
            "Desember"
        ],
        "firstDay": 1
    },
    // "startDate": moment().subtract(1, 'month').startOf('month'),
	"startDate":moment().startOf('month'),
	"endDate":moment().endOf('month'),
    // "endDate":  moment().subtract(1, 'month').endOf('month'),
    "opens": "left"
}, function(start, end, label) {
  console.log('New date range selected: ' + start.format('DD-MM-YYYY') + ' to ' + end.format('DD-MM-YYYY') + ' (predefined range: ' + label + ')');
 
});
</script>