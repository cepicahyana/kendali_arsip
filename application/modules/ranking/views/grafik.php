<div id="grafik"></div>


<?php
$tahun    = $this->input->post("tahun");
$semester = $this->input->post("semester");
$nip      = $this->input->post("nip");
 
if(!$nip){


// $pre_a = $this->mdl->presenstase_predikat("A",$tahun,$semester);
$jml_a = $this->mdl->presenstase_predikat("A",$tahun,$semester);
$jml_b = $this->mdl->presenstase_predikat("B",$tahun,$semester);
$jml_c = $this->mdl->presenstase_predikat("C",$tahun,$semester);
$jml_d = $this->mdl->presenstase_predikat("D",$tahun,$semester);
$jml_e = $this->mdl->presenstase_predikat("E",$tahun,$semester);
// error_reporting(0);
$jml_total = ($jml_a+$jml_b+$jml_c+$jml_d+$jml_e);
if($jml_total<1){
    $per_a = 0;
    $per_b = 0;
    $per_c = 0;
    $per_d = 0;
    $per_e = 0;
}else{
    $per_a = ($jml_a/$jml_total)*100;
    $per_b = ($jml_b/$jml_total)*100;
    $per_c = ($jml_c/$jml_total)*100;
    $per_d = ($jml_d/$jml_total)*100;
    $per_e = ($jml_e/$jml_total)*100;
}

$jmlray=array(
    "A" => $jml_a,
    "B" => $jml_b,
    "C" => $jml_c,
    "D" => $jml_d,
    "E" => $jml_e,
);

$perray=array(
    "A" => $per_a,
    "B" => $per_b,
    "C" => $per_c,
    "D" => $per_d,
    "E" => $per_e,
);

$predikat = null; $diagram=null;
$db_predikat  = $this->m_reff->db_predikat();
foreach($db_predikat as $key=>$val){
    $diagram.="{ name: '".$val."', y: ".number_format($perray[$key],0,",","")." },";
$predikat.= "<tr>
<td>".$val."</td>
<td>".$jmlray[$key]." Orang</td>
<td>".number_format($perray[$key],0,",","")."%</td>
</tr>";
}
?>
<hr>
<b class='text-black'>Presentase predikat dari semester <?=$semester;?> tahun <?=$tahun;?> </b>
<table class="entry2" width="100%">
    <thead>
        <th>Predikat</th>
        <th>Jumlah</th>
        <th>Persentase</th>
    </thead>
<?=$predikat;?>
</table>

<?php }else{ ///jika nip ada

$this->db->where("tahun",$tahun);
$this->db->where("semester",$semester);
$this->db->where("nip",$nip);
$indikator = $this->db->get("penilaian_kinerja_ppnpn")->row();
$nilai          = isset($indikator->data_penilaian)?($indikator->data_penilaian):null;
$hasil_evaluasi = isset($indikator->hasil_evaluasi)?($indikator->hasil_evaluasi):null;
$predikat       = isset($indikator->predikat)?($indikator->predikat):null;
$komentar       = isset($indikator->komentar)?($indikator->komentar):null;
$nilai = json_decode($nilai,TRUE);
$tr = null; $no=1; $diagram="";
foreach($nilai as $key=>$val){
    $diagram.="{ name: '".$val['indikator']."', y: ".$val['nilai']." },";
    $tr.="<tr>
    <td>".$no++."</td>
    <td>".$val['indikator']."</td>
    <td>".$val['skor']."</td>
    <td>".$val['nilai']."</td>
    </tr>";
}

echo "<b class='text-black'> Penilaian dari semester ".$semester." Tahun : ".$tahun."</b>";
echo '<table class="entry2" width="100%">';
echo '<thead><th>No</th><th>Indikator</th><th>Score</th><th>Nilai bobot</th></thead>';
echo $tr;
echo '<tr><td colspan="3" align="right">Nilai akhir</td><td><b>'.$hasil_evaluasi.'</b></td><tr>';
echo '<tr><td colspan="3" align="right">Predikat</td><td><b>'.$this->m_reff->predikat($predikat).'</b></td><tr>';
echo '</table>';
echo '<span class="text-black">Catatan : '.$komentar."</span>";

} ?>

<?php
if($nip){
	$dt = $this->mdl->getNilai($nip);
}else{
	$dt = $this->mdl->getNilaiAkumulasi();
}

$nama=$title=$nilai="";
foreach($dt as $v){
	$nama=$v->nama;
$title.="'".$v->tahun." - semester ".$v->semester."',";
$nilai.=$v->hasil_evaluasi.",";
}
?>
<script>
	Highcharts.chart('grafik', {
    chart: {
        backgroundColor: 'transparent',
        type: 'area'
    },
    title: {
        text: '<?=$nama;?>'
    },
    subtitle: {
       
        align: 'right',
        verticalAlign: 'bottom'
    },
    legend: {
        layout: 'vertical',
         
        x: 100,
        y: 70,
        floating: true,
        borderWidth: 1,
        backgroundColor:
            Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF'
    },
    xAxis: {
        
        categories: [<?=$title;?>]
    },
    yAxis: {
        title: {
            text: 'Nilai'
        }
    },
    plotOptions: {
        area: {
            fillOpacity: 0.5
        }
    },
    credits: {
        enabled: false
    },
    series: [{
        name: '<?=$nama;?>',
        data: [<?=$nilai;?>]
    } ]
});
</script>

<div id="container"></div>


<script>
    // Data retrieved from https://netmarketshare.com/
// Make monochrome colors
var pieColors = (function () {
    var colors = [],
        base = Highcharts.getOptions().colors[0],
        i;

    for (i = 0; i < 10; i += 1) {
        // Start out with a darkened base color (negative brighten), and end
        // up with a much brighter color
        colors.push(Highcharts.color(base).brighten((i - 3) / 7).get());
    }
    return colors;
}());

// Build the chart
Highcharts.chart('container', {
    chart: {
        backgroundColor: 'transparent',
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: ''
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.0f}%</b>'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            colors: pieColors,
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b><br>{point.percentage:.0f} %',
                distance: -50,
                filter: {
                    property: 'percentage',
                    operator: '>',
                    value: 1
                }
            }
        }
    },
    series: [{
        name: 'Share',
        data: [
           <?=$diagram;?>
           
        ]
    }]
});
              
</script>