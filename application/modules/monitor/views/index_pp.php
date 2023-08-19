<?php
$dp = $this->db->get_where("admin",array("id_admin"=>$this->session->userdata("id")))->row();
$level = $this->session->userdata("level");
 
    $foto = isset($dp->poto)?($dp->poto):"";
    $nama_pengguna = isset($dp->owner)?($dp->owner):"";
 
?>


					<!-- breadcrumb -->
					<div class="breadcrumb-header justify-content-between">
						<div>
							<h4 class="content-title mb-2">Selamat datang, <?php echo $nama_pengguna?></h4>
							<nav aria-label="breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#">Selamat datang dihalaman kendali ppnpn</a></li>
									<!-- <li class="breadcrumb-item active" aria-current="page">Project</li> -->
								</ol>
							</nav>
						</div>
						<div class="d-flex my-auto">
							<div class=" d-flex right-page">
								<div class="d-flex justify-content-center">
									<div>
										<span class="d-block">
											<span class="label ">STATUS HARI INI</span>
										</span>
										<span class="value ">
											<?php echo $hari = $this->tanggal->hariLengkap(date("Y-m-d"),"/") ?>
										</span>
									</div>
									 
								</div>
							</div>
						</div>
					</div>
					<!-- /breadcrumb -->


					<!-- main-content-body -->
					<div class="main-content-body">
						<?php
						$wfo=$this->mdl->jmlAbsen(1);
						$wfh=$this->mdl->jmlAbsen(2);
						$dinas=$this->mdl->jmlAbsen(3);
						$izinsakit=$this->mdl->jmlAbsen(["4","5"]);
						$totalPPNPN=$this->mdl->jmlPPNPN("pimpinan");
						$sudahAbsenPPNPN=$this->mdl->jmlAbsen(["1","2","3","4","5"]);
						?>

						<div class="row row-sm ">
							<div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
								<div class="card">
									<div class="card-body">
										<div class="row">
											<div class="col-auto align-self-center ">
												<div class="feature mt-0 mb-0">
													<span class="project bg-primary-transparent text-primary">
														<i class="far fa-building"></i>
													</span>
										        </div>
							                </div>
											<div class="col">
												<div class="text-right">
													<div class="h2"><?= $wfo;?></div>
										        </div>
										        <p class="float-right">Bekerja dikantor</p>
										    </div>
						                </div>
						            </div>
					           	</div>
							</div>
							<div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
								<div class="card">
									<div class="card-body">
										<div class="row">
											<div class="col-auto align-self-center ">
												<div class="feature mt-0 mb-0">
													<span class="project bg-warning-transparent" style="color: #ffb177;">
														<i class="fas fa-home"></i>
													</span>
										        </div>
							                </div>
											<div class="col">
												<div class="text-right">
													<div class="h2"><?= $wfh;?></div>
										        </div>
										        <p class="float-right">Bekerja dirumah</p>
										    </div>
						                </div>
						            </div>
					           	</div>
							</div>
							<div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
								<div class="card">
									<div class="card-body">
										<div class="row">
											<div class="col-auto align-self-center ">
												<div class="feature mt-0 mb-0">
													<span class="project bg-danger-transparent " style="color: #e64141;">
														<i class="fas fa-car"></i>
													</span>
										        </div>
							                </div>
											<div class="col">
												<div class="text-right">
													<div class="h2"><?= $dinas;?></div>
										        </div>
										        <p class="float-right">DINAS</p>
										    </div>
						                </div>
						            </div>
					           	</div>
							</div>
							<div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
								<div class="card">
									<div class="card-body">
										<div class="row">
											<div class="col-auto align-self-center ">
												<div class="feature mt-0 mb-0">
													<span class="project bg-info-transparent" style="color: #00d0ff;">
														<i class="fas fa-clinic-medical"></i>
													</span>
										        </div>
							                </div>
											<div class="col">
												<div class="text-right">
													<div class="h2"><?= $izinsakit;?></div>
										        </div>
										        <p class="float-right">IZIN + SAKIT</p>
										    </div>
						                </div>
						            </div>
					           	</div>
							</div>
						</div>

						<!-- bidang ppnpn + presensi hari ini -->
						<div class="card-deck row mb-4">
							<div class="card col-xl-4 col-lg-4 col-md-4 col-sm-12">
								<div class="card-body">
									<?php 
									if ($sudahAbsenPPNPN > 0): ?>
									<div id="grafik_utama"></div>
									<?php else: ?>
										<div class="mb-1">&nbsp;</div>
									<?php endif; ?>

									<div class="row">
										<div class="col-md-6 col-6 text-center">
											<div class="task-box primary mb-0">
												<p class="mb-0 tx-12">Total PPNPN</p>
												<h3 class="mb-0"><?= $totalPPNPN;?></h3>
											</div>
										</div>
										<div class="col-md-6 col-6 text-center">
											<div class="task-box danger  mb-0">
												<p class="mb-0 tx-12">Telah Absen</p>
												<h3 class="mb-0"><?= $sudahAbsenPPNPN; ?></h3>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="card col-xl-8 col-lg-8 col-md-8 col-sm-12">
	                    		<div class="card-header">
	                                <h4 class="card-title">Presensi hari ini <?php echo $hari?></h4>
	                            </div>
	                            <div class="card-body">
	                            	<?php 
	                            	$db = $this->mdl->absenToDay();
	                            	if (count($db) < 1): ?>
	                            		<div class="alert alert-danger" role="alert">
			                                 data belum tersedia.
			                            </div>
	                            	<?php else:?>
	                            	<ul class="list-group wd-md-100p">
			                    		<?php
										foreach($db as $val){
										$p = $this->mdl->getPPNPN($val->nip); 
										$nama = isset($p->nama)?($p->nama):"";
										$jk = isset($p->jk)?($p->jk):"";

										if($jk=="l"){
										$ava = base_url()."assets/images/l.jpg";
										}else{
										$ava = base_url()."assets/images/p.jpg";
										}
										$ja = $this->m_reff->goField("tr_jenis_absen","nama","where id='".$val->jenis_absen."'");

										?>
										<li class="list-group-item d-flex justify-content-between">
											<div class="flex-shrink-1">
												<img alt="" class="wd-30 rounded-circle mg-r-15" src="<?php echo $ava;?>">
											</div>
											<div class="wd-70p">
												<h6 class="tx-13 tx-inverse tx-semibold mg-b-0"><?=$nama;?></h6>
												<span class="d-block tx-11 text-primary"><?php echo $ja;?></span>
											</div>
											<div class="text-center mg-r-15 text-primary ">
												<span class="font-weight-semibold p-0"><?= $val->jam_masuk;?></span>
												<br><span class="font-weight-normal">Masuk</span>
											</div>
											<div class="text-center mg-r-15 text-black">
												<span class="font-weight-semibold p-0"><?= isset($val->jam_pulang)?($val->jam_pulang):"-";?></span>
												<br><span class=" font-weight-normal">Pulang</span>
											</div>
											<div class="text-center text-danger">
												<span class="font-weight-semibold p-0"><?php echo isset($val->telat)?($val->telat):"-";?></span>
												<br><span class=" font-weight-normal">Telat</span>
											</div>
											
										</li>
										<?php } ?>
									</ul>
									<?php endif ?>
	                            </div>
	                        </div>
                    	</div>
	                    <!-- bidang ppnpn + presensi hari ini -->

	                    <!-- jumlah ppnpn + kegiatan hari ini -->
						<div class="card-deck row mb-4">
							<div class="card col-xl-4 col-lg-4 col-md-4 col-sm-12">
	                            <div class="card-header">
	                                <h4 class="card-title" style="text-align: center;">Jumlah PPNPN</h4>
	                                <i data-feather="help-circle" class="font-medium-3 text-muted cursor-pointer"></i>
	                            </div>
	                            <div class="card-body">
	                                <?php
									$dtchar="";
									foreach($this->mdl->countPPNPN_ByBagian() as $val){
										$dtchar.="['".$val->bagian.": ".$val->jml." org',".$val->jml."],";
									?>
		                        	<div class="progress mb-3">
										<div aria-valuemax="100" aria-valuemin="0" aria-valuenow="60" style="height: 30px;font-weight: bolder;font-size: 13px; text-align: left; padding-left: 15px;" class="progress-bar wd-80p bg-primary" role="progressbar"><?php echo $val->bagian;?></div>
										<div aria-valuemax="100" aria-valuemin="0" aria-valuenow="60"  style="height: 30px;font-weight: bolder; color:  #000; font-size: 13px;" class="progress-bar wd-20p bg-light" role="progressbar"><?php echo $val->jml;?></div>
							        </div>
								   <?php } ?>
	                            </div>
	                        </div>
	                    	<div class="card col-xl-8 col-lg-8 col-md-8 col-sm-12">
	                    		<div class="card-header">
	                                <h4 class="card-title">Kegiatan PPNPN hari ini <?php echo $hari?></h4>
	                            </div>
	                            <div class="card-body">
	                            	<?php 
	                            	$db = $this->mdl->getKegiatanHarian();
	                            	if (count($db) < 1): ?>
	                            		<div class="alert alert-danger" role="alert">
			                                data belum tersedia.
			                            </div>
	                            	<?php else: ?>
	                            	<ul class="list-group wd-md-100p">
										<?php
										foreach($db as $val){
											$p = $this->mdl->getPPNPN($val->nip); 
											$nama = isset($p->nama)?($p->nama):"";
											$jk = isset($p->jk)?($p->jk):"";

											if($jk=="l"){
											$ava = base_url()."assets/images/l.jpg";
											}else{
											$ava = base_url()."assets/images/p.jpg";
											}?>
										<li class="list-group-item d-flex justify-content-between">
											<div class="flex-shrink-1">
												<img alt="" class="wd-30 rounded-circle mg-r-15" src="<?php echo $ava;?>">
											</div>
											<div class="wd-70p">
												<h6 class="tx-13 tx-inverse tx-semibold mg-b-0"><?=$nama;?></h6>
												<span class="d-block tx-11 text-primary"><?= $val->deskripsi;?></span>
											</div>
											<div class="text-center mg-r-15 text-danger ">
												<span class="font-weight-semibold p-0"><?= substr($val->mulai,0,5);?> s/d <?= substr($val->akhir,0,5);?></span>
												<br><span class="font-weight-normal">Waktu Pelaksanaan</span>
											</div>
											
										</li>
										<?php } ?>
									</ul>
									<?php endif; ?>
	                            </div>
	                        </div>
	                    </div>
	                    <!-- jumlah ppnpn + kegiatan hari ini -->

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
        text: 'Presentase Kehadiran PPNPN <br> <?= $hari;?>'
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
                format: '<b>{point.name}</b><br>{point.percentage:.1f} % <br>{point.y} orang',
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
            {
            	name: 'WFO', 
                y: <?= $wfo;?>,
                // y: 17,
                color:"#3858f9"
            },
            {
            	name: 'WFH',
            	y: <?= $wfh;?>,
            	//y: 8,
                color:"#ffb177"
            },
            {
            	name: 'Dinas',
            	y: <?= $dinas;?>,
            	// y: 4,
                color:"#e64141"
            },
            {
            	name: 'Izin + Sakit',
            	y: <?= $izinsakit;?>,
            	// y: 5,
                color:"#00d0ff"
            },
           
         
        ]
    }]
});
</script>