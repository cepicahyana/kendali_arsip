
<div class="card card-style">
<div class="content">
<div id="calendar"></div>
</div>
</div>



<script>
$('#calendar').fullCalendar({
      header: {
        left: 'title',
        center: '',
        right: 'prev,next'
      },
       defaultDate: new Date(2021, 8, 28),
	  locale: "id",
      navLinks: true, // can click day/week names to navigate views
      selectable: false,
      selectHelper: true,
	
	  textColor: "white",
      select: function(start, end,id) {
        
        var eventData;
     
          eventData = { 
            start: start,
            id: id,
            end: end
          };
          
		addEvent(title,start.format(),end.format());
        $('#calendar').fullCalendar('renderEvent', eventData, true); // stick? = true
        $('#calendar').fullCalendar('unselect');
      },
      editable: false,
      eventLimit: true, // allow "more" link when too many events
     eventDrop: function(event, delta, revertFunc) {
 
				//   alertify.confirm("<center> Pindah ? </center>",function(){
				//  moveEvent(event.id,event.start.format(),event.end.format())
				// }, function(){ 	 revertFunc();}  );
	  },
	     	 eventClick: function (event, jsEvent, view) { 
		     detailModal(event.id); 
	         },
	  });
	
      function generatecalender() {
            $.ajax({
                url: '<?php echo base_url()?>home/calendaragenda',
                type: 'POST', // Send post data
                data: 'type=fetch',
                async: false,
                success: function (s) {
                    freshevents = s;
                }
            });
            $('#calendar').fullCalendar('addEventSource', JSON.parse(freshevents));
     }
     setTimeout(() => {
        generatecalender();
     }, 300);
  </script>
  
  <script> 
function detailModal(id)
	{   $("#modal_detail").showMenu();
        var url = "<?php echo base_url()?>home/info_detail";
			var param = {
                id:id,
				<?php echo $this->m_reff->tokenName()?>: token
			};
			$.ajax({
				type: "POST",
				dataType: "json",
				data: param,
				url: url,
				beforeSend: function() {
					loading_block("infodet");
				},
				success: function(val) {
					token = val['token'];
                    $("#infodet").html(val['data']);
                    unblock("infodet");
                    // $("#modal_detail").hideMenu();
				}
			});
		 		 
	}
 function close_infodet(){
    $("#modal_detail").hideMenu();
 }
</script>


<div class="card-body">
 
<?php
$this->db->where("nip",$this->m_reff->nip());
$this->db->where("tgl",date('Y-m-d'));
$dt = $this->db->get("data_tugas_harian")->result();
foreach($dt as $v){?>

 
<div class="alert alert-small rounded-s shadow-xl bg-green1-outside" role="alert">
<div><?php echo $v->deskripsi;?>. 
<?php if($v->mulai!="00:00:00"){?>
<i class="text-success"> | <?php echo substr($v->mulai,0,5);?> - <?php echo substr($v->akhir,0,5);?>
</i><?php } ?>
</div>
<button onclick="hapus(`<?=$v->id;?>`,`<?=$v->deskripsi;?>`)" type="button" class="close color-red-dark opacity-60 font-16" 
 aria-label="Close">×</button>
</div>
 
  

<?php } ?>
</div>
 


<script>
    var idHapus;
    function hapus(id,desc){
        idHapus=id;
        $("#del-confirm").showMenu();
        $("#del_desc").html(desc);
    }
    function deletes(){
        
        var url = "<?php echo base_url()?>home/hapusJob";
                var param = {
                    id:idHapus,
				<?php echo $this->m_reff->tokenName()?>: token
			};
			$.ajax({
				type: "POST",
				dataType: "json",
				data: param,
				url: url,
				beforeSend: function() {
					loading_block("del-confirm");
				},
				success: function(val) {
                    $("#del-confirm").hideMenu();
					unblock("del-confirm");
					token = val['token'];
                    success();
                    infoact();
                   
				}
			});
    }
</script>


 
