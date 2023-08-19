<div class="row" id="area_formSubmit">
	<div class="col-sm-12">


 
	<?php
 $token=date('His');
 ?>
                <div class="row clearfix">
                <!-- Task Info -->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card" >
                        <div class="header"> 
						
						
                       <div class="col-md-3 col-sx-12 col-xs-12 pull-right">
                            <input required style='min-width:180px;margin-left:-20px' type="text" id="periode" name="periode" class="cursor form-contdrol" onchange="getData()" >
                       </div>
                                               
						
						<h3>Presensi </h3>
                           
                        </div>
						<br>
						    <div class="body">
                      
						  
				 <div   id="area_lod">
			            <div   id="dataget">
                            					
						</div>						
					</div>	
                           
                        </div>
                        
                        
                        
                    </div>
                     
                    
                    
                </div>
                <!-- #END# Task Info -->
				

 
	
 <script>	 
 
function getData()
{	
	loading("dataget");
	var tgl=$("#periode").val();
	var nip = "<?php echo $this->input->post("nip")?>";
	var url = "<?php echo base_url()?>koreksi_absen/getDataPresensi";
	var param = {periode:tgl,nip:nip,<?php echo $this->m_reff->tokenName()?>:token};
				$.ajax({
						type: "POST",dataType: "json",data: param, url: url,
						success: function(val){
							token=val['token'];
							$("#dataget").html(val['data']); 
							unblock("dataget");
						}
				});	
}
</script>	   




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
    // "endDate":  moment().subtract(1, 'month').endOf('month'),
    "startDate":moment().startOf('month'),
	"endDate":moment().endOf('month'),
    "opens": "left"
}, function(start, end, label) {
  console.log('New date range selected: ' + start.format('DD-MM-YYYY') + ' to ' + end.format('DD-MM-YYYY') + ' (predefined range: ' + label + ')');
 
});
</script>

	 

	
	</div>
</div>