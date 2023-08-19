 
 
 
 
<!-- Grafik -->
<div class="">
  <div class="content mb-2">
    <h3 class="text-center">Grafik Penilaian</h3>

    <div class="table-responsive">
      <figure class="highcharts-figure">
        <div id="container"></div>
        <p class="highcharts-description">
        </p>
      </figure>
    </div>
  </div>
</div> 

<?php
              $penilaian = [];
              $i=0;
              $thn = [];
              $getPegawai = $this->mdl->getPegawai();
              foreach ($getPegawai->result() as $t) {
                $thn[] = $t->tahun;
                $id_pegawai = $t->nip;
                $i++;
              }
              $t = date('Y');
              $tB = date($t)-10;
              $x = 0;

              $categories_tahun = "";
              $series_nilai = "";
              $categories_hasil_evaluasi = [];
              $penilaian = $this->mdl->getPenilaian($t, $tB);
              foreach ($penilaian as $val) { 
              $categories_hasil_evaluasi[] = $val->hasil_evaluasi;
              $categories_tahun.="'".$val->tahun."-".$val->semester."',"; 
              $series_nilai.= $val->hasil_evaluasi.",";
              } ?>


<!-- Tabel Detail Penilaian-->
<div>
  <div class="card-bodys">
    <h3 class="text-center">Hasil Evaluasi</h3>
      <div class="table-responsive  ">
        
            
      <div class="col-md-3">
       
            <?php
            $YNow = date('Y');
            for ($thn=$YNow; $thn > ($YNow-10); $thn--) { 
                $options[$thn] = "Tahun ".$thn;
            }

            $attr = array('id' => 'tahun', 'onchange'=>'datatable()', 'class' => 'form-control', 'required' => 'required', 'style' => 'width:100%;');
            echo form_dropdown('tahun', $options, set_value('tahun'), $attr);
            unset($options);
            unset($attr);?>	
        </div> 
        <br>
        <div id="dataTable">
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
        </div>
      </div><br/>
  </div>
</div>





<script>
    datatable();
function datatable(){
    var tahun_dipilih = $("#tahun").val();
    var url = "<?php echo base_url()?>cek_data/data_nilai_ppnpn_detail";
    var nip = "<?php echo $this->input->post("nip");?>";
    var param = {
        tahun:tahun_dipilih,nip:nip,
        <?php echo $this->m_reff->tokenName()?>: token
    };
    $.ajax({
        type: "POST",
        dataType: "json",
        data: param,
        url: url,
        beforeSend: function() {
            loading("dataTable");
        },
        success: function(val) {
            token = val['token'];
            $("#dataTable").html(val['data']);
            unblock("dataTable");
            // $("#modal_rincian").hideMenu();
        }
    });
}





function detailPenilaian(id){
    $("#modal-detail").showMenu();
 }

 $(document).ready(function() {
  $(document).on('click', '#tombolRincian', function() {
    var id = $(this).data('id');
    var url = "<?php echo base_url()?>penilaian_front/info_detail";
    var param = {
        id:$(this).data('id'),
        <?php echo $this->m_reff->tokenName()?>: token
    };
    $.ajax({
        type: "POST",
        dataType: "json",
        data: param,
        url: url,
        beforeSend: function() {
            loading_block("isiModal");
        },
        success: function(val) {
            token = val['token'];
            $("#isiModal").html(val['data']);
            unblock("isiModal");
            // $("#modal_rincian").hideMenu();
        }
    });
  })
})
 
</script>

 

<!-- HIGHCHARTS PENILAIAN -->
<script>
Highcharts.chart('container', {
  chart: {
    type: 'spline'
  },
  title: {
    text: ''
  },
  subtitle: {
    text: ''
  },
  xAxis: {
    categories: [
      <?= $categories_tahun ?>
    ],
    crosshair: true
  },
  yAxis: {
    min: 0,
    title: {
      text: 'Hasil Evaluasi'
    }
  },
  tooltip: {
    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
      '<td style="padding:0"><b>{point.y:.2f}</b></td></tr>',
    footerFormat: '</table>',
    shared: true,
    useHTML: true
  },
  plotOptions: {
    column: {
      pointPadding: 0.2,
      borderWidth: 0
    }
  },
  series: [{
    name: 'Nilai',
    data: [<?= $series_nilai ?>]
  }]
});

document.getElementById('small').addEventListener('click', function () {
    chart.setSize(400);
});

document.getElementById('large').addEventListener('click', function () {
    chart.setSize(600);
});

document.getElementById('auto').addEventListener('click', function () {
    chart.setSize(null);
});

</script>

