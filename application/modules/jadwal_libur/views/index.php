<script>
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        defaultDate: '<?php echo date('Y-m-d');?>',
        locale: "id",
        navLinks: true, // can click day/week names to navigate views
        selectable: true,
        selectHelper: true,

        select: function(start, end) {
        var title = prompt('Keterangan libur:');
        var eventData;
            if (title) {
                eventData = {
                    title: title,
                    start: start,
                    end: end,
                    backgroundColor: 'red',
                };

            addEvent(title,start.format(),end.format());

            //   $('#calendar').fullCalendar('renderEvent', eventData, true); // stick? = true
            }

            $('#calendar').fullCalendar('unselect');
        },

        editable: true,
        eventLimit: true, // allow "more" link when too many events
        eventDrop: function(event, delta, revertFunc) {
            alertify.confirm("<center> Pindah ? </center>",function(){
                moveEvent(event.id,event.start.format(),event.end.format())
			}, function(){ 	 
                revertFunc();
            });
	    },

	    eventResize: function(event, delta, revertFunc) {

        alertify.confirm("<center> Ubah ? </center>",function(){
                moveEvent(event.id,event.start.format(),event.end.format())
            }, function(){ 	 
                revertFunc();
            } );
        },
        eventClick: function (event, jsEvent, view) { 
            detailModal(event.id,event.title); 
        }
    });

	getFreshEvents();
    function getFreshEvents() {
        $.ajax({
            url: '<?php echo base_url(); ?>jadwal_libur/process',
            type: 'POST', // Send post data
            data: 'type=fetch',
            async: false,
            success: function (s) {
                freshevents = s;
            }
        });

        $('#calendar').fullCalendar('addEventSource', JSON.parse(freshevents));
    }
</script>

<div class="card">
    <div class="card-body">
        <div id="calendar"></div>
    </div>
</div>




<script>

function hapus(id){  
    alertify.confirm("<center> Hapus ? </center>",function(){
	$('#calendar').fullCalendar('removeEventSources');
        $.post("<?php echo site_url("jadwal_libur/hapus"); ?>",{id:id},function(data){ 
            $("#modal_libur").modal("hide");
            $("#mdl_formSubmit").modal("hide");
            getFreshEvents();
        });
	});
}

function save(id){  
	$('#calendar').fullCalendar('removeEventSources');
    var title=$('textarea#title').val();
    $.post("<?php echo site_url("jadwal_libur/update"); ?>",{id:id,title:title},function(data){ 
        $("#mdl_formSubmit").modal("hide");
        getFreshEvents();
    }); 
}

function addEvent(ket,start,end){
    $('#calendar').fullCalendar('removeEventSources');
    $.post("<?php echo site_url("jadwal_libur/add"); ?>",{ket:ket,start:start,end:end},function(data){ 
        getFreshEvents();
    });
}

function moveEvent(id,start,end){
    $.post("<?php echo site_url("jadwal_libur/moveEvent"); ?>",{id:id,start:start,end:end},function(data){ 

    }); 

}

function detailModal(id,title){
    $("#mdl_formSubmit").modal("show");

    $.post("<?php echo site_url("jadwal_libur/info"); ?>",{id:id,title:title},function(data){ 
        $("#c-tamu").html(data);
        $(".sub-title").html("<i class='fa fa-info-circle'></i> &nbsp;Informasi Libur");
    });
}
</script>

<!----------------------------------MODAL-------------------------------------------->					
<div class="modal  fade" id="mdl_formSubmit" tabindex="-9991" style="z-index:1199" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
 	<div id="mdl_size" class="modal-dialog modal-lg" role="document">
 		<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
 			<div class="modal-content">
                <div class="modal-body">
                    <div class="row" id="area_formSubmit">
                        <div class="col-sm-12">
                            <div class="card-block">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h5 class="sub-title">Tambah    </h5><hr>
                            </div>
                            <span id="c-tamu"></span>
                        </div>
                    </div>
 				</div>
 			</div>
 		</div>
 	</div>
 </div>

