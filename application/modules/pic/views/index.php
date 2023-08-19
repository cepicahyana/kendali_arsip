<?php
$dp = $this->db->get_where("admin",array("id_admin"=>$this->session->userdata("id")))->row();
 
    $foto = isset($dp->poto)?($dp->poto):"";
    $nama_pengguna = isset($dp->owner)?($dp->owner):"";
 
?>


					<!-- breadcrumb -->
					<div class="breadcrumb-header justify-content-between">
						<div>
							<h4 class="content-title mb-2">Selamat datang, <?php echo $nama_pengguna?></h4>
							<nav aria-label="breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item "><a href="#">Informasi dibawah ini merupakan hasil kalkulasi keseluruhan data <!--  anda sebagai <span class='badge badge-warning'> <?php echo $this->m_reff->levelName()?>   <?php echo $this->m_reff->area()?>--></a></a></li>
									<!-- <li class="breadcrumb-item active" aria-current="page">Project</li> -->
								</ol>
							</nav>
						</div>
						<div class="d-flex my-auto">
							<div class=" d-flex right-page">
								<!-- <div class="d-flex justify-content-center mr-5">
									<div class="">
										<span class="d-block">
											<span class="label ">POSITIF</span>
										</span>
										<span class="value ">
											<?php echo $this->mdl->sts_positif();?> <i style="font-size:30px;margin-left:10px;color:#FF69B4" class="icon ion-ios-stats "></i>
										</span>
									</div>
									 
								</div>
								<div class="d-flex justify-content-center">
									<div class="">
										<span class="d-block">
											<span class="label">NEGATIF</span>
										</span>
										<span class="value">
                                        <?php echo $this->mdl->sts_negatif();?> <i style="font-size:30px;margin-left:10px;color:orange" class="icon ion-ios-stats "></i>
										</span>
									</div>
								
								</div> -->
							</div>
						</div>
					</div>
					<!-- /breadcrumb -->


 

 

						<!-- row -->
						<div class="row row-sm ">


							<div class="col-xl-8 col-lg-12 col-md-12 col-sm-12">
						 
									 <div id="grafik_laju"></div>
									 <div class="row">	
											
											<div class="col-lg-6 col-xl-6 col-md-6 col-sm-12">
											<div id="grafik_utama"></div>
											</div>

											<div class="col-lg-6 col-xl-6 col-md-6 col-sm-12">
											<div id="grafik_usia"></div>
											</div>
									</div>
				
							</div>




							<div class="col-sm-12 col-md-12 col-lg-12 col-xl-4">
								<div class="  overflow-hidden">
									<div class="  pb-3">
										 

										<table class="table table-hover table-bordered mb-0 text-md-nowrap text-lg-nowrap text-xl-nowrap table-striped ">
												<thead>
													<tr class='bg-danger'> 
														<th style="color:black">POSITIF (+)</th>
														<th  style="color:black"><center>JUMLAH</center></th>
														 
													</tr>
												</thead>
												<tbody>
                                                   
													<tr>
														<td>
															<div class="project-contain">
																<h6 class="mb-1 tx-13"> PNS</h6>
															</div>
														</td>
														<td><center><?php echo $this->mdl->jmlPegawai(1)?></center></td>
												 	</tr>
											 
													<tr>
														<td>
															<div class="project-contain">
																<h6 class="mb-1 tx-13"> PPNPN</h6>
															</div>
														</td>
														<td><center><?php echo $this->mdl->jmlPegawai(2)?></center></td>
												 	</tr>
											 
												 
													<tr>
														<td>
															<div class="project-contain">
																<h6 class="mb-1 tx-13"> Petugas taman</h6>
															</div>
														</td>
														<td><center><?php echo $this->mdl->jmlPegawai(3)?></center></td>
												 	</tr>
											 
												 
													 
													<tr>
														<td>
															<div class="project-contain">
																<h6 class="mb-1 tx-13"> Cleaning service</h6>
															</div>
														</td>
														<td><center><?php echo $this->mdl->jmlPegawai(4)?></center></td>
												 	</tr>
											  	</tbody>
											</table>

 <?php
 if($this->session->level!="pic_covid"){?>
											<br>
											<div class="table-responsive mb-0">
											<table class="table table-hover table-bordered mb-0 text-md-nowrap text-lg-nowrap text-xl-nowrap table-striped ">
												<thead>
													<tr class='bg-danger'> 
														<th style="color:black">KLASIFIKASI BIRO YANG TERPAPAR (+)</th>
														<th  style="color:black"><center>JUMLAH</center></th>
														 
													</tr>
												</thead>
												<tbody>
                                                    <?php
                                                    $kode_istana = $this->session->userdata("kode_istana");
													$kode_biro = $this->session->userdata("kode_biro");
												 if(!$kode_biro){

													if($kode_istana){
														$this->db->where("kode",$kode_istana);
													}
                                                    $wilayah = $this->m_reff->list_istana()->result();
                                                    foreach($wilayah as $val){
                                                        $nama = $val->kode;
                                                        $jml  = $this->mdl->getJmlPositifIstana($val->kode);
                                                    ?>
													<tr>
														<td>
															<div class="project-contain">
																<h6 class="mb-1 tx-13"><?php echo $this->m_reff->istana($nama)?></h6>
															</div>
														</td>
														 
														<td><center><?php echo $jml?></center></td>
													 
													</tr>
												 <?php } 
												 }
												 ?>
                                                    <?php
                                                     
													 if($kode_biro){
														 $this->db->where("kode",$kode_biro);
													 }
                                                    $wilayah = $this->m_reff->list_biro()->result();
                                                    foreach($wilayah as $val){
                                                        $nama = $val->kode;
                                                        $jml  = $this->mdl->getJmlPositifBiro($val->kode);
                                                    ?>
													<tr>
														<td>
															<div class="project-contain">
																<h6 class="mb-1 tx-13"><?php echo $this->m_reff->biro($nama)?></h6>
															</div>
														</td>
														 
														<td><center><?php echo $jml?></center></td>
													 
													</tr>
												 <?php } ?>
												 
													 
												</tbody>
											</table>
										</div>
    

<?php } ?>






	 <br>
											<div class="table-responsive mb-0">
											<table class="table table-hover table-bordered mb-0 text-md-nowrap text-lg-nowrap text-xl-nowrap table-striped ">
												<thead>
													<tr class='bg-info'> 
														<th style="color:black">PREDIKSI PENULARAN</th>
														<th  style="color:black"><center>JUMLAH</center></th>
														 
													</tr>
												</thead>
												<tbody>
                                                    <?php
                                                    
                                                    $wilayah = $this->mdl->getPrediksiPenularan();
                                                    foreach($wilayah as $val){
                                                        $nama = $val->nama;
                                                        $jml  = $this->mdl->getJmlPrediksi($nama);
                                                    ?>
													<tr>
														<td>
															<div class="project-contain">
																<h6 class="mb-1 tx-13"><?php echo $nama?></h6>
															</div>
														</td>
														 
														<td><center><?php echo $jml?></center></td>
													 
													</tr>
												 <?php } ?>
												 
													 
												</tbody>
											</table>

<br>
											<table class="table table-hover table-bordered mb-0 text-md-nowrap text-lg-nowrap text-xl-nowrap table-striped ">
												<thead>
													<tr class='bg-info'> 
														<th style="color:black">KAB/KOTA</th>
														<th  style="color:black"><center>JUMLAH TERPAPAR</center></th>
														 
													</tr>
												</thead>
												<tbody>
                                                    <?php
                                                    
                                                    $wilayah = $this->mdl->get_wilayah();
                                                    foreach($wilayah as $val){
                                                        $nama = $this->m_reff->goField("kabupaten","nama","where id_kab='".$val->id_kab."' ");
                                                    ?>
													<tr>
														<td>
															<div class="project-contain">
																<h6 class="mb-1 tx-13"><?php echo $nama?></h6>
															</div>
														</td>
														 
														<td><center><?php echo $val->jml?></center></td>
													 
													</tr>
												 <?php } ?>
												 
													 
												</tbody>
											</table>
<br>

											<table class="table table-hover table-bordered mb-0 text-md-nowrap text-lg-nowrap text-xl-nowrap table-striped ">
												<thead>
													<tr class='bg-info'> 
														<th style="color:black">JUMLAH MELAKUKAN TES</th>
														<th  style="color:black"><center>JUMLAH</center></th>
														 
													</tr>
												</thead>
												<tbody>
                                                   
													<tr>
														<td>
															<div class="project-contain">
																<h6 class="mb-1 tx-13"> PNS</h6>
															</div>
														</td>
														<td><center><?php echo $this->mdl->totalTest(1)?></center></td>
												 	</tr>
											 
													<tr>
														<td>
															<div class="project-contain">
																<h6 class="mb-1 tx-13"> PPNPN</h6>
															</div>
														</td>
														<td><center><?php echo $this->mdl->totalTest(2)?></center></td>
												 	</tr>
											 
												 
											 
													<tr>
														<td>
															<div class="project-contain">
																<h6 class="mb-1 tx-13"> Petugas taman</h6>
															</div>
														</td>
														<td><center><?php echo $this->mdl->totalTest(3)?></center></td>
												 	</tr>
											 
												 
													 
													<tr>
														<td>
															<div class="project-contain">
																<h6 class="mb-1 tx-13"> Cleaning service</h6>
															</div>
														</td>
														<td><center><?php echo $this->mdl->totalTest(4)?></center></td>
												 	</tr>
											 
												 
													 
													<tr>
														<td>
															<div class="project-contain">
																<h6 class="mb-1 tx-13"> External</h6>
															</div>
														</td>
														<td><center><?php echo $this->mdl->jmlExternal()?></center></td>
												 	</tr>
											 
												 
													 
												</tbody>
											</table>
										</div>
    


									</div>
								</div>
							</div>



							
						</div>
						<!-- /row -->

						<!-- row -->
						<div class="row row-sm">
                        
                          <div class="col-lg-4 col-xl-4 col-md-4 col-sm-12">
                         
							</div>

						
						
							<div class="col-lg-4 col-xl-4 col-md-4 col-sm-12">
                            
							</div>
						
							<div class="col-lg-4 col-xl-4 col-md-4 col-sm-12">
							<div class="table-responsive mb-0">
											




										</div>
							</div>
                     
						</div>
						
                        <br>
						<div class="row row-sm "> </div>
						</div>
						<!-- /row -->
 
				




                        <?php
                        $now        = date("Y-m-d");
                        $dataTgl    = "";
                        $p1         =   0;
                        $p2         =   0;
                        $p3         =   0;
                        $p4         =   0;
                        for($i=6;$i>=0;$i--){
                            $tgl     = $this->tanggal->minTgl($i,$now);
                            $tgle     = $this->tanggal->eng($tgl,"-");
                            $dataTgl.= "'".$tgl."',";
                            $p1.=$this->mdl->jml_positif($tgle,'1').",";
                            $p2.=$this->mdl->jml_positif($tgle,'2').",";
                            $p3.=$this->mdl->jml_positif($tgle,'3').",";
                            $p4.=$this->mdl->jml_positif($tgle,'4').",";
                        }
                        ?>
<script>
	Highcharts.chart('grafik_laju', {
    title: {
        text: 'STATISTIK TES DENGAN HASIL POSITIF (+)'
    },
    xAxis: {
        categories: [<?php echo $dataTgl;?>]
    },   yAxis: {
        min: 0,
        title: {
            text: 'Jumlah'
        }
    },
    labels: {
        items: [{
            html: '',
            style: {
                left: '50px',
                top: '18px',
                color: ( // theme
                    Highcharts.defaultOptions.title.style &&
                    Highcharts.defaultOptions.title.style.color
                ) || 'black'
            }
        }]
    },
    series: [{
        type: 'column',
        name: 'PNS',
		color: Highcharts.getOptions().colors[8],
        data: [<?php echo $p1;?>]
    }, {
        type: 'column',
        name: 'PPNPN',
        data: [<?php echo $p2;?>],
		color: Highcharts.getOptions().colors[7],
    }, {
        type: 'column',
        name: 'Petugas Taman',
		color: Highcharts.getOptions().colors[6],
        data: [<?php echo $p3;?>]
    },   
     {
        type: 'column',
        name: 'Cleaning Service',
		color: Highcharts.getOptions().colors[4],
		data: [<?php echo $p4;?>]
    }, 
	 // {
    //     type: 'pie',
    //     name: 'Total ',
    //     data: [{
    //         name: 'PNS',
    //         y: 13,
    //         color: Highcharts.getOptions().colors[8] // Jane's color
    //     }, {
    //         name: 'PPNPN',
    //         y: 23,
    //         color: Highcharts.getOptions().colors[7] // John's color
    //     }, {
    //         name: 'Petugas Taman',
    //         y: 19,
    //         color: Highcharts.getOptions().colors[6] // Joe's color
    //     }, {
    //         name: 'Cleaning Service',
    //         y: 19,
    //         color: Highcharts.getOptions().colors[4] // Joe's color
    //     }],
    //     center: [100, 80],
    //     size: 100,
    //     showInLegend: false,
    //     dataLabels: {
    //         enabled: false
    //     }
    //
	 ]
});
       
</script>

 
                                               


<script>
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
</script>




<script>
// Build the chart
Highcharts.chart('grafik_usia', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie',
		backgroundColor:null
    },
    title: {
        text: 'Klasifikasi Usia'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
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
                format: '<b>{point.name}</b><br>{point.percentage:.1f} %',
                distance: -50,
                filter: {
                    property: 'percentage',
                    operator: '>',
                    value: 4
                }
            }
        }
    },
    series: [{
        name: 'Share',
        data: [
            { name: '< 20thn', y: <?php echo $this->mdl->usiaMin()?> },
            { name: '20 - 30thn', y:  <?php echo $this->mdl->usia(20,30)?>  },
            { name: '30 - 40thn', y:  <?php echo $this->mdl->usia(30,40)?>  },
            { name: '40 - 50thn', y:  <?php echo $this->mdl->usia(40,50)?>  },
            { name: ' > 50thn', y: <?php echo $this->mdl->usiaMax()?> },
         
        ]
    }]
});
</script>





<?php
$negatif       =   $this->mdl->negatif();
$positif       =   $this->mdl->positif();
?>

<script>
// Build the chart
Highcharts.chart('grafik_utama', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
		backgroundColor:null,
        type: 'pie'
    },
    title: {
        text: 'Data terpapar / tidak terpapar'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
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
         
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b><br>{point.percentage:.1f} % <br> {point.y} orang ',
                distance: -50,
                filter: {
                    property: 'percentage',
                    operator: '>',
                    value: 4
                }
            }
        }
    },
    series: [{
        name: 'Total',
        data: [
            { name: 'Tidak terpapar  ', 
                y:  <?php echo $negatif;?>,
                color:"#006400"  },

            { name: 'Terpapar  ',
                 y: <?php echo $positif;?>,
                 color:"#DC143C" },
           
         
        ]
    }]
});
</script>

 
  