<style>
    .ijo {
        background-color:#37BC9B;
    }
.highcharts-figure, .highcharts-data-table table {
  min-width: 310px; 
  max-width: 800px;
  margin: 1em auto;
}

#container {
  height: 400px;
}

.highcharts-data-table table {
  font-family: Verdana, sans-serif;
  border-collapse: collapse;
  border: 1px solid #EBEBEB;
  margin: 10px auto;
  text-align: center;
  width: 100%;
  max-width: 500px;
}
.highcharts-data-table caption {
  padding: 1em 0;
  font-size: 1.2em;
  color: #555;
}
.highcharts-data-table th {
  font-weight: 600;
  padding: 0.5em;
}
.highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
  padding: 0.5em;
}
.highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
  background: #f8f8f8;
}
.highcharts-data-table tr:hover {
  background: #f1f7ff;
}
</style>

<script src="<?php echo base_url() ?>assets/js/highcharts.js"></script>
   <script src="<?php echo base_url() ?>assets/js/highcharts-3d.js"></script>





<div class="card card-style rounded-m shadow-xl bg-27" data-card-height="100" >
  <div class="content">
    <div class="d-flex" style="z-index:2;position:absolute">
      <div>
        <h2 class="mb-0 pt-1 text-white">PENILAIAN</h2>
        <p class="text-white font-11 mt-1 mb-3"> Merupakan data rekap tahun berjalan ( <?php echo date('Y')?> ) </p>
      </div>
    </div>
    <div class="card-overlay bg-black opacity-70"></div>
  </div>
</div>

<!-- Tabel Detail Penilaian-->
<div class="card ">
  <div class="card-body mb-2">
    <h3 class="text-center">Hasil Evaluasi</h3>
      <div class="table-responsive text-center ">
        <table class="entry2" width="100%">
          <thead>
              <tr class="ijo text-white">
                  <th scope="col">Tahun</th>
                  <th scope="col">Semester</th>
                  <th scope="col">Nilai</th>
                  <th scope="col">Predikat</th>
                  <th scope="col">#</th>
              </tr>
          </thead>
          <tbody>
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
              $tB = date($t)-4;
              $x = 0;

              $categories_tahun = "";
              $series_nilai = "";
              $categories_hasil_evaluasi = [];
              $penilaian = $this->mdl->getPenilaian($t, $tB);
              foreach ($penilaian as $val) { 
              $categories_hasil_evaluasi[] = $val->hasil_evaluasi;
              $categories_tahun.="'".$val->tahun."-".$val->semester."',"; 
              $series_nilai.= $val->hasil_evaluasi.",";

              ?>
              <tr>
                <td><?= $val->tahun?></td>
                <td><?= $val->semester?></td>
                <td><?= $val->hasil_evaluasi?></td>
                <td><?= $val->predikat?></td>
                <td>
                  <a data-vibrate="100" href="javascript:detailPenilaian()" class="btn btn-border btn-xxs btn-full mb-3 rounded-sm text-uppercase font-900 border-mint-dark color-mint-dark bg-theme" id="tombolRincian"
                  data-target="#modal-detail" data-id="<?= $val->id ?>">
                  Rincian</a>
                </td>
              </tr>
              <?php } ?>
              
          </tbody>
        </table>
      </div><br/>
  </div>
</div>

<!-- Grafik -->
<div class="card card-style">
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
<div class="card card-style">
  <div class="content mb-2">
    <h3 class="text-center">10 nilai terbaik</h3>
    <div class="table-responsive">
      
        
        <table class="entry2" width="100%">
          <thead>
              <tr class="ijo text-white">
                  <th scope="col">No</th>
                  <th scope="col">Nama</th>
      
                  <th scope="col">Nilai</th>
                  <th scope="col">Predikat</th>
              </tr>
          </thead>
          <tbody>
            <?php
            $sms = $this->m_reff->semester();
            $ppnpn = $this->m_umum->dataPPNPNin();
            $this->db->where_in("nip",$ppnpn);
            $this->db->where("tahun",date('Y'));
            $this->db->where("semester",$sms);
            $this->db->limit(10);
            $no = 1;
            $this->db->order_by("hasil_evaluasi","desc");
            $db = $this->db->get("penilaian_kinerja_ppnpn")->result();
            foreach($db as $val){
              $bagian = $this->mdl->bagian($val->nip);
              if(!$bagian){
                $istana = $this->db->get_where("data_pegawai",array("nip"=>$val->nip))->row();
                $istana = isset($istana->kode_istana)?($istana->kode_istana):null;
                $bagian = "Istana ".$this->m_reff->istana($istana,$singkat=true);
              }else{
                $istana = $this->db->get_where("data_pegawai",array("nip"=>$val->nip))->row();
                $istana = isset($istana->kode_istana)?($istana->kode_istana):null;
                $bagian = $bagian." - Istana ".$this->m_reff->istana($istana,$singkat=true);
              }
              echo "<tr>
              <td>".$no++."</td>
              <td>".$val->nama.br()."<i class='text-info'>".$bagian."</i></td>
              <td>".$val->hasil_evaluasi."</td>
              <td>".$this->m_reff->predikat($val->predikat)."</td>
              </tr>";
            }
            ?>
          </tbody>
        </table>
   
    </div>
  </div>
</div>



<script>
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

function tutupPenilaian(){
    $("#modal-detail").hideMenu();
}
</script>

</div>
<!-- MODAL DETAIL PENILAIAN -->
<div id="modal-detail" class="menu menu-box-modal menu-box-round-medium menu-box-detached rounded-s" data-menu-width="350" data-menu-height="420" data-menu-effect="menu-over" data-menu-select="page-components">
  <div id="area_modal-detail">
    <div class="boxed-text-xl mt-4" id="isiModal">
      
    </div>
  </div>
</div>


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

