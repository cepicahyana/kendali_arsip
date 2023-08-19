<?php
$tahun=$this->m_reff->san($this->input->get_post("tahun"));
?>
		 
	<div class="row">				
 			
	
	<div class="col-md-12">
	<div id="datamad" ></div>
	</div>	
	</div>
	<br>
	 <div class="col-md-12 clearfix">&nbsp;</div>
	  
		
		 	

<script>
 
    
	
	$('#calendar').fullCalendar({
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay'
      },
       defaultDate: new Date(<?php echo $tahun;?>, <?php echo (date("m")-1);?>, <?php echo date("d");?>),
	  locale: "id",
      navLinks: true, // can click day/week names to navigate views
      selectable: false,
      selectHelper: true,
      select: function(start, end,id,id_acara) {
        
        var eventData;
     
          eventData = { 
            start: start,
            id: id,
            id_acara: id_acara,
            end: end
          };
		   addEvent(title,start.format(),end.format());un
          $('#calendar').fullCalendar('renderEvent', eventData, true); // stick? = true
		 
        $('#calendar').fullCalendar('unselect');
      },
      editable: false,
      eventLimit: true, // allow "more" link when too many events
     eventDrop: function(event, delta, revertFunc) {
 
				  alertify.confirm("<center> Pindah ? </center>",function(){
				 moveEvent(event.id,event.start.format(),event.end.format())
				}, function(){ 	 revertFunc();}  );
			
	 },
	  
			eventClick: function (event, jsEvent, view) { 
		//	if(event.id_acara=="<?php echo $this->mdl->id_acara()?>"){
                detailModal(event.id,event.id_acara,event.title); 
		//	}else{
		//		notif("Acara ini tidak dapat dilihat.");
		//	}
            },
	 
	  
    });
	
	
	
 	agenda();
	//	agenda_lain();
	

	
   
	 function agenda() {
            $.ajax({
                url: '<?php echo base_url()?>/dashboard/getAgenda',
                type: 'POST', // Send post data
                data: 'type=fetch',
                async: false,
                success: function (s) {
                    freshevents = s;
                }
            });
            $('#calendar').fullCalendar('addEventSource', JSON.parse(freshevents));
			
        }
 
 agenda_presiden();
 agenda_ibn();
 agenda_kementerian();
 agenda_setpres();
	 function agenda_presiden() {
            $.ajax({
                url: '<?php echo base_url()?>/dashboard/agenda_presiden',
                type: 'POST', // Send post data
                data: 'type=fetch',
                async: false,
                success: function (s) {
                    freshevents = s;
                }
            });
            $('#calendar').fullCalendar('addEventSource', JSON.parse(freshevents));
			
        }
	function agenda_ibn() {
            $.ajax({
                url: '<?php echo base_url()?>/dashboard/agenda_ibn',
                type: 'POST', // Send post data
                data: 'type=fetch',
                async: false,
                success: function (s) {
                    freshevents = s;
                }
            });
            $('#calendar').fullCalendar('addEventSource', JSON.parse(freshevents));
			
        }
	function agenda_kementerian() {
            $.ajax({
                url: '<?php echo base_url()?>/dashboard/agenda_kementerian',
                type: 'POST', // Send post data
                data: 'type=fetch',
                async: false,
                success: function (s) {
                    freshevents = s;
                }
            });
            $('#calendar').fullCalendar('addEventSource', JSON.parse(freshevents));
			
        }
	function agenda_setpres() {
            $.ajax({
                url: '<?php echo base_url()?>/dashboard/agenda_setpres',
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
<style>

   

  #calendar {
    max-width: 90%;
    margin: 0 auto;
  }

</style>
 
 
<div  class="card"><br>
  <div id='calendar'></div>
  <br>
</div>


<script> 
 function detailModal(id,id_acara,title)
    {	 
        if(id_acara==1){
            var mdl="und_rakor";
        }else if(id_acara==2){
            var mdl="und_presiden";
        }else if(id_acara==3){
            var mdl="und_ibn";
        }else if(id_acara==4){
            var mdl="und_mensesneg";
        }else{
            var mdl="und_kasetpres";
        } 
		$("#modal_libur").modal("show");
       $.post("<?php echo base_url()?>"+mdl+"/detail",{id:id,title:title},function(data){ 
                $("#c-tamu").html(data);
                $(".modal-titlet").html("<i class='fa fa-info-circle'></i> &nbsp; "+title);
            });
     
        
  }
  
    
</script>



 
  
	 <div class="col-md-12 clearfix">&nbsp;</div>
	 
	  
			

<?php
 $datablok=$this->db->query("select distinct(id_jenis_kegiatan) as id_jenis_kegiatan ,count(*) as jml
 from data_acara where id_jenis_kegiatan!='' and year(tgl)='".$tahun."' group by id_jenis_kegiatan")->result();
$bo="";
foreach($datablok as $val)
{
	$bo.="{
                name: '".$this->m_reff->goField("tr_jenis_kegiatan","nama","where id='".$val->id_jenis_kegiatan."'")."',
                y: ".$val->jml.", 
                 
            },";
}
$divisi=$bo;

$datablok=$this->db->query("select distinct(id_jenis_kegiatan) as acara ,count(*) as jml
 from data_acara where id_jenis_kegiatan!='' and year(tgl)='".$tahun."' group by id_jenis_kegiatan")->result();

$bo="";
foreach($datablok as $val)
{
	$bo.="{
                name: '".$val->acara."',
                y: ".$val->jml.", 
                 
            },";
}
$acara=$bo;
?>
	 
   
	 
		
 
  
<?php
 $tgl="";
 $tgl2="";
$t=$this->db->query("select SUBSTR(tgl,1,7) AS tgl from data_acara where YEAR(tgl)='".$tahun."' GROUP BY SUBSTR(tgl,1,7)  ")->result();
foreach($t as $vt)
{
	$tt=$this->tanggal->bln_tahun($vt->tgl."-01");
	$tgl.="'".$tt."',"; 
	$tgl2.=$vt->tgl.","; 
}
  $tgl2		=	substr($tgl2,0,-1);
  $datat	=	explode(",",$tgl2);
 
$seris="";
$data=$this->db->query("select distinct(id_acara) as v from data_acara  ")->result();
foreach($data as $v)
{	
	  $isi=""; 
	foreach($datat as $tglz)
	{	
		$c=$this->db->query("select * from data_acara where substr(tgl,1,7)='".$tglz."' and id_acara='".$v->v."'  ")->num_rows();
		$isi.=$c.",";
	}
	
	$seris.="{
        name: '".$this->m_reff->goField("tr_jenis_undangan","alias","where id='".$v->v."'")."',
        data: [".$isi."]
    }, ";
}



 
?>	  	  
	  
<script>
Highcharts.chart('datamad', {
   chart: {
        type: 'column',
		backgroundColor: "rgba(0,0,0,0)"
    },
    title: {
        text: 'Kegiatan Perbulan'
    },
    xAxis: {
        categories: [<?php echo $tgl;?>]
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Total Kegiatan'
        },
        stackLabels: {
            enabled: true,
            style: {
                fontWeight: 'bold',
                color: ( // theme
                    Highcharts.defaultOptions.title.style &&
                    Highcharts.defaultOptions.title.style.color
                ) || 'gray'
            }
        }
    },
    legend: {
        align: 'right',
        x: -30,
        verticalAlign: 'top',
        y: 25,
        floating: true,
        backgroundColor: 'transparent',
        borderColor: '#CCC',
        borderWidth: 1,
        shadow: false
    },
    tooltip: {
        headerFormat: '<b>{point.x}</b><br/>',
        pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
    },
    plotOptions: {
        column: {
            stacking: 'normal',
            dataLabels: {
                enabled: true
            }
        }
    },
    series: [ <?php echo $seris; ?>]
});
</script>

	 