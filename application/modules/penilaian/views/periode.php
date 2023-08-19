 
               <div class="row">
                  <div class="col-lg-12" id="page-body"><div class="card-body  iq-card " id="area_formSubmit">
	<div class="card-block">
		<form id="formSubmit" action="javascript:submitFormNoResset('formSubmit')" 
			method="post" url="<?php echo base_url() ?>penilaian/update_periode">
			<div class="form-group row">
				<label class="col-sm-4 col-form-label" for="title">Rentang tanggal penilaian</label>
				<div class="col-sm-8">
					<input id="periode" type="text" name="periode" class="form-control" style="color:black" value="<?=$periode?>" required>
				</div>
			</div>
		<button onclick="submitFormNoResset('formSubmit')" class="btn btn-primary btn-sm float-right"><i class="fa fa-save"></i> Simpan</button>
		</form>
        <br>
	</div>
</div>

</div>
 
            </div>



            
 <script>
    function reload_table(){
        return false;
    }
 
$('#periode').daterangepicker({
    "showDropdowns": false,
    "autoApply": true,
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
	// "startDate":moment().startOf('month'),
	// "endDate":moment().endOf('month'),
    // "endDate":  moment().subtract(1, 'month').endOf('month'),
    "opens": "left"
}, function(start, end, label) {
  console.log('New date range selected: ' + start.format('DD-MM-YYYY') + ' to ' + end.format('DD-MM-YYYY') + ' (predefined range: ' + label + ')');
 
});
</script>  