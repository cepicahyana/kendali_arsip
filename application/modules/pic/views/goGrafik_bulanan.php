<?php
  $tgl = $this->input->post("range");
  $grafik = $this->input->post("type");
  $tgl1 = $this->tanggal->range_1($tgl, 0);
  $tgl2 = $this->tanggal->range_2($tgl, 1);
 

$selisih  = $this->tanggal->selisih($tgl1,$tgl2);
$jmlBulan = number_format($selisih/30,0,",",".");
$batang   = "";
for($i=0;$i<=$jmlBulan;$i++){
    
     $tgli   =   $this->tanggal->tambahBln($tgl1,$i);  
     $entry  =   $tgli;// $this->tanggal->ind_($tgli,"/"); 
     $jml    =   $this->mdl->jmlPerbulan($tgli);
     $batang.= " ['".$entry."', ".$jml."],";
}

  ?>




<div id="grafik-harian"></div>

<script>
    Highcharts.chart('grafik-harian', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Grafik perbulan'
    },
    subtitle: {
        text: 'Tanggal <?php echo $this->tanggal->ind($tgl1,"/")?> s.d <?php echo $this->tanggal->ind($tgl1,"/")?>'
    },
    xAxis: {
        type: 'category',
        labels: {
            rotation: -45,
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Jumlah'
        }
    },
    legend: {
        enabled: false
    },
    tooltip: {
        pointFormat: 'Jumlah :<b>{point.y} Orang</b>'
    },
    series: [{
        name: 'Population',
        data: [
           
            <?php echo $batang;?>
        ],
        dataLabels: {
            enabled: true,
            rotation: -90,
            color: '#FFFFFF',
            align: 'right',
            format: '{point.y}', // one decimal
            y: 10, // 10 pixels down from the top
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
        }
    }]
});
              
</script>