<?php
  $tgl = $this->input->post("range");
  $grafik = $this->input->post("type");
  $tgl1 = $this->tanggal->range_1($tgl, 0);
  $tgl2 = $this->tanggal->range_2($tgl, 1);
//   if ($tgl1) {
//       $tgl = " and konfirm_rs BETWEEN '" . $tgl1 . " 00:00:00' AND '" . $tgl2 . " 23:59:59' ";
//   }


// //   if ($grafik == "tdetail" or $grafik == "gdetail") {
// //       $group_by = "";
// //       $select = "*";
// //   }
//   if ($grafik == "1") {
//       $group_by = "group by SUBSTRING(konfirm_rs,1,10)";
//       $select = "count(*) as jml,konfirm_rs as entry";
//   }
//   if ($grafik == "tm" or $grafik == "gm") {
//       $group_by = "group by YEARWEEK(SUBSTRING(entry,1,10))";
//       $select = "CONCAT('minggu ke:',WEEK(konfirm_rs),'-',YEAR(konfirm_rs)) AS entry,count(*) as jml";
//   }
//   if ($grafik == "tb" or $grafik == "gb") {
//       $group_by = "group by MONTH(SUBSTRING(entry,1,10))";
//       $select = "CONCAT(MONTH(entry),'-',YEAR(entry)) AS entry,count(*) as jml";
//   }
//   if ($grafik == "tt" or $grafik == "gt") {
//       $group_by = "group by YEAR(SUBSTRING(entry,1,10))";
//       $select = "YEAR(entry) AS entry,count(*) as jml";
//   }

//   $filter="";
//   if($this->session->userdata("kode_biro")){
//       $filter.="and kode_biro='".$this->session->userdata("kode_biro")."'";
//   }else{
//     $filter.="and id_istana='".$this->session->userdata("id_istana")."'";
//   }

//   $filter = "";

//   $query = "SELECT $select FROM v_test WHERE 1=1 $filter $tgl ";

//   $db = $this->db->query($query)->result();
// $batang="";
//   foreach($db as $val){
//         $batang = " ['".$val->entry."', $val->jml],";
//   }


$selisih = $this->tanggal->selisih($tgl1,$tgl2);
$batang  = "";
for($i=0;$i<=$selisih;$i++){
     $tgli   =   $this->tanggal->tambahTgl($tgl1,$i);  
     $entry  =   $this->tanggal->ind($tgli,"/"); 
     $jml    =   $this->mdl->jmlPerhari($tgli);
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
        text: 'Grafik perhari'
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