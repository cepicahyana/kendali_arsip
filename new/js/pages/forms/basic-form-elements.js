$(function () {
    //Textare auto growth
    autosize($('textarea.auto-growth'));

    //Datetimepicker plugin
    $('.datetimepicker').bootstrapMaterialDatePicker({
        format: 'dddd DD MMMM YYYY - HH:mm',
        clearButton: true,
        weekStart: 1
    }); 
	 
  

    $('.datepicker').bootstrapMaterialDatePicker({
        format: 'dddd DD MMMM YYYY',
        clearButton: true,
        weekStart: 1,
        time: false
    });

    $('.timepicker').bootstrapMaterialDatePicker({
        format: 'HH:mm',
        clearButton: true,
        date: false
    });
	
	$('#dateend').bootstrapMaterialDatePicker({ weekStart : 0 });
	$('#datestart').bootstrapMaterialDatePicker({ weekStart : 0 }).on('change', function(e, date)
	{
	$('#dateend').bootstrapMaterialDatePicker('setMinDate', date);
	}); 
	
});