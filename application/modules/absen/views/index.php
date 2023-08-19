<div class="card card-style rounded-m shadow-xl bg-27" data-card-height="100" >
<div class="content">
<div class="d-flex" style="z-index:2;position:absolute">
 
<div>
<h2 class="mb-0 pt-1 text-white">REKAPITULASI ABSEN</h2>
<p class="text-white font-11 mt-1 mb-3"> Merupakan data rekap tahun berjalan ( <?php echo date('Y')?> ) </p>
</div>
</div>
<div class="card-overlay bg-black opacity-70"></div>
</div>
</div>


<div class="card-body">

<div>
<div class="row mt-3 pt-1 mb-3">

<div class="col-6">
    <div class="card bg-21 rounded-m shadowl" style="height: 181px;">
        <div class="card-body">
            <h4 class="color-white">HADIR</h4>
            <p class="color-white" style="font-size:20px">
                <?php echo $this->mdl->jmlHadir(array("1","2"))?>
            </p>
            <a data-vibrate="100" href="javascript:openRincian()" class="btn btn-xxs btn-full mb-3 rounded-sm text-uppercase font-900 bg-mint-dark" id="tombolHadir">Rincian</a>
        </div>
        <div class="card-overlay bg-black opacity-70 rounded-m shadow-l"></div>
        <div class="card-overlay dark-mode-tint rounded-m shadow-l"></div>
    </div>
</div>

<div class="col-6">
    <div class="card bg-23 rounded-m shadowl" style="height: 181px;">
    <div class="card-body">
    <h4 class="color-white">SAKIT</h4>
    <p class="color-white" style="font-size:20px">
    <?php echo $this->mdl->jmlHadir(5)?>
    </p>
    
    </div>
    <div class="card-overlay bg-black opacity-70 rounded-m shadow-l"></div>
    <div class="card-overlay dark-mode-tint rounded-m shadow-l"></div>
    </div> 
</div>

<div class="col-6">
    <div class="card bg-24 rounded-m shadowl" style="height: 181px;">
    <div class="card-body">
    <h4 class="color-white">IZIN</h4>
    <p class="color-white" style="font-size:20px">
    <?php echo $this->mdl->jmlHadir(4)?>
    </p>
    
    </div>
    <div class="card-overlay bg-black opacity-70 rounded-m shadow-l"></div>
    <div class="card-overlay dark-mode-tint rounded-m shadow-l"></div>
    </div> 
</div>

<div class="col-6">
    <div class="card bg-26 rounded-m shadowl" style="height: 181px;">
    <div class="card-body">
    <h4 class="color-white">TANPA KET.</h4>
    <p class="color-white" style="font-size:20px">
    <?php echo $this->mdl->jmlHadir(7)?>
    </p>
    
    </div>
    <div class="card-overlay bg-black opacity-70 rounded-m shadow-l"></div>
    <div class="card-overlay dark-mode-tint rounded-m shadow-l"></div>
    </div> 
</div>


 

</div>


</div>
</div>


<!----------- Kalender ---------->

<div class="card card-style" style="margin-top:-3 0px">
<div class="content">
<div id="calendar"></div>
</div>
</div>


<script>
    $( document ).ready(function() {
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
                // }, function(){    revertFunc();}  );
      },
             eventClick: function (event, jsEvent, view) { 
             detailModal(event.id); 
             },
      });


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
    {   $("#modal_rincian").showMenu();
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
                    // $("#modal_rincian").hideMenu();
                }
            });
                 
    }
 function close_infodet(){
    $("#modal_rincian").hideMenu();
 }
</script>



<div id="modal_rincian" class="menu menu-box-modal menu-box-round-medium menu-box-detached rounded-s" data-menu-width="370" data-menu-height="450" data-menu-effect="menu-over" data-menu-select="page-components">
<div class="boxed-text-xl mt-4">
<div id="infodet"></div>
 </div>
</div>

<!-- The Modal -->
<div class="modal" id="modalHadir">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal body -->
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal">&times;</button><br>
        <div class="text-center">
        <h4 class="mb-0 pt-1">REKAPITULASI ABSEN</h4>
            <p class="font-11 mt-1 mb-3"> Merupakan data rekap tahun berjalan ( <?php echo date('Y')?> ) </p>
        </div>

        
      </div>

    </div>
  </div>
</div>



<script>
function openRincian(id){
    $("#modal-detail").showMenu();
}
function tutupRincian(){
    $("#modal-detail").hideMenu();
}
</script>

<!-- MODAL DETAIL PENILAIAN -->
<div id="modal-detail" class="menu menu-box-modal menu-box-round-medium menu-box-detached rounded-s" data-menu-width="350" data-menu-height="400" data-menu-effect="menu-over" data-menu-select="page-components">
  <div id="area_modal-detail">
    <div class="boxed-text-xl mt-4" id="isiModal">
        <div class="text-center">
            <h4 class="mb-0 pt-1">REKAPITULASI ABSEN</h4>
            <p class="font-11 mt-1 mb-3"> Merupakan data rekap tahun berjalan ( <?php echo date('Y')?> ) </p>
        </div>
        <table class="table table-borderless text-center rounded-sm shadow-l text-center" style="overflow: hidden; margin-top: 5px;">
            <thead>
                <tr>
                    <th class="bg-mint-dark border-dark1-dark color-white">Jenis Absen</th>
                    <th class="bg-mint-dark border-dark1-dark color-white">Jumlah</th>
                </tr>
            </thead>
            <tbody>
            <tr>
                <td>WFO</td>
                <td class="bg-light"><?php echo $this->mdl->jmlHadir(1)?></td>
            </tr>
            <tr>
                <td>WFH</td>
                <td class="bg-light"><?php echo $this->mdl->jmlHadir(2)?></td>
            </tr>
            <tr>
                <td>Dinas</td>
                <td class="bg-light"><?php echo $this->mdl->jmlHadir(3)?></td>
            </tr>
            </tbody>
        </table>
        <a href="javascript:tutupRincian()" class="btn btn-m btn-full mb-3 rounded-xs text-uppercase font-900 shadow-s bg-dark2-dark">Tutup</a>
    </div>
  </div>
</div>