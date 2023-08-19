<div class="container-fluids">

<?php
$wfo=$this->mdl->jmlAbsen(1);
$wfh=$this->mdl->jmlAbsen(2);
$dinas=$this->mdl->jmlAbsen(3);
$izinsakit=$this->mdl->jmlAbsen(["4","5"]);
$sudahAbsenPPNPN=$this->mdl->jmlAbsen(["1","2","3","4","5"]);
$totalPPNPN=$this->mdl->jmlPPNPN();
?>
               <div class="row">
                  <div class="col-sm-12">
				  <b class="text-black">Status hari ini <?php echo $hari = $this->tanggal->hariLengkap(date("Y-m-d"),"/") ?></b><br/>
                     <div class="row">
                     <div class="col-md-6 col-lg-3">
                           <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                              <div class="iq-card-body iq-bg-primary rounded">
                                 <div class="d-flex align-items-center justify-content-between">
                                    <div class="rounded-circle iq-card-icon bg-primary"><i class="ri-user-fill"></i></div>
                                    <div class="text-right">                                 
                                       <h2 class="mb-0"><span class="counter"><?= $wfo;?></span></h2>
                                       <h5 class="">WFO</h5>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>

                     <div class="col-md-6 col-lg-3">
                           <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                              <div class="iq-card-body iq-bg-warning rounded">
                                 <div class="d-flex align-items-center justify-content-between">
                                    <div class="rounded-circle iq-card-icon bg-warning"><i class="ri-user-fill"></i></div>
                                    <div class="text-right">
                                       <h2 class="mb-0"><span class="counter"><?= $wfh;?></span></h2>
                                       <h5 class="">WFH</h5>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>

                     <div class="col-md-6 col-lg-3">
                           <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                              <div class="iq-card-body iq-bg-danger rounded">
                                 <div class="d-flex align-items-center justify-content-between">
                                    <div class="rounded-circle iq-card-icon bg-danger"><i class="ri-user-fill"></i></div>
                                    <div class="text-right">                                 
                                       <h2 class="mb-0"><span class="counter"><?= $dinas;?></span></h2>
                                       <h5 class="">DINAS</h5>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     
						<div class="col-md-6 col-lg-3">
                           <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                              <div class="iq-card-body iq-bg-info rounded">
                                 <div class="d-flex align-items-center justify-content-between">
                                    <div class="rounded-circle iq-card-icon bg-info"><i class="ri-user-fill"></i></div>
                                    <div class="text-right">                                 
                                       <h2 class="mb-0"><span class="counter"><?= $izinsakit;?></span></h2>
                                       <h5 class="">IZIN + SAKIT</h5>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                         
                         
                     </div>
                  </div>
                  <div class="col-lg-4">
                     <div class="iq-card iq-card-block iq-card-stretch iq-card-height ">
                        <div class="iq-card-body">
                           <div class="user-details-block">
                              
                              <div class="text-center mt-3">
                                 <h4><b>Presentase Kehadiran PPNPN <br> <?= $hari;?></b></h4>
                                 <br><br>
								 <div id="bidang" class='hc'  style="width:100%;height:200px;margin:0"></div>

                              </div>
                              <hr>
                              <ul class="doctoe-sedual d-flex align-items-center justify-content-between p-0">
                                 <li class="text-center">
                                    <h3 class="counter"><?= $totalPPNPN;?></h3>
                                    <span>Total PPNPN</span>
                                  </li>
                                  <li class="text-center">
                                    <h3 class="counter"><?= $sudahAbsenPPNPN; ?></h3>
                                    <span>Telah absen</span>
                                  </li>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-8">
                     <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                        <div class="iq-card-header d-flex justify-content-between">
                           <div class="iq-header-title">
                              <h4 class="card-title">Presensi hari ini <?php echo $hari?></h4>
                           </div>
                        </div>
                        <div class="card-body">
						         
                           <?php
      						   $db = $this->mdl->absenToDay();
                           if (count($db) < 1) { ?>
                              <div class="alert alert-danger" role="alert">
                                 data belum tersedia.
                              </div>
                           <?php } else { ?>
                           <ul class="doctors-lists m-0 p-0">
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
      							 <li class="d-flex mb-4 align-items-center">
      								<div class="user-img img-fluid"><img src="<?php echo $ava;?>" alt="story-img" class="rounded-circle avatar-40"></div>
      								<div class="media-support-info ml-3">
      								   <h6><?=$nama;?></h6>
      								   <p class="mb-0 font-size-12 text-primary"><?php echo $ja;?></p>
      								</div>
      								<div class="iq-card-header-toolbar d-flex align-items-center">
      								   <div class="dropdown show">
      									  <span class='text-primary'> Masuk : <?php echo $val->jam_masuk;?></span> 
      									  | <span class='text-black'> Pulang : <?php echo isset($val->jam_pulang)?($val->jam_pulang):"-";?> </span>
      									  | <span class='text-danger'>Telat :<?php echo isset($val->telat)?($val->telat):"-";?>  </span>
      									  
      								   </div>
      								</div>
      							 </li>
      							<?php } ?>
                           </ul>
                           <?php } ?>
      						  
      						</div>
      					</div>
                  </div>                   
               </div>
               <div class="row">
                
                 
                  <div class="col-lg-4">
                     <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                        <div class="iq-card-header d-flex justify-content-between">
                           <div class="iq-header-title">
                              <h4 class="card-title">Jumlah PPNPN </h4>
                           </div>
                        </div>
					

                        <div class="iq-card-body hospital-mgt">
							
						<?php
							$dtchar="";
							foreach($this->mdl->countPPNPN_ByBagian() as $val){ 
							$dtchar.="['".$val->bagian.": ".$val->jml." org',".$val->jml."],";
							?>
                           <div class="progress mb-3" style="height: 30px;">
                              <div class="progress-bar bg-primary" role="progressbar" style="width: 80%;" aria-valuenow="15" 
							  aria-valuemin="0" aria-valuemax="100"><?php echo $val->bagian;?></div>
                              <div class="progress-bar bg-grey" role="progressbar" style="width: 20%" aria-valuenow="30" 
							  aria-valuemin="0" aria-valuemax="100"><?php echo $val->jml;?></div>
                           </div>
						   <?php } ?>
                         </div>

						
                     </div>
                  </div>
            
                   
                  <div class="col-lg-8">
                     <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                        <div class="iq-card-header d-flex justify-content-between">
                           <div class="iq-header-title">
						   <h4 class="card-title"> Kegiatan PPNPN hari ini <?php echo $this->tanggal->hariLengkap(date('Y-m-d'),"/")?></h4>
                           </div>
                        </div>
                        <div class="iq-card-body">
                           <?php 
                           $db = $this->mdl->getKegiatanHarian();
                           if (count($db) < 1): ?>
                              <div class="alert alert-danger" role="alert">
                                data belum tersedia.
                              </div>
                           <?php else: ?>
         						<ul class="doctors-lists m-0 p-0">
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
         							 
         							  ?>
         							 <li class="d-flex mb-4 align-items-center">
         								<div class="user-img img-fluid"><img src="<?php echo $ava;?>" alt="story-img" class="rounded-circle avatar-40"></div>
         								<div class="media-support-info ml-3">
         								   <h6><?=$nama;?></h6>
         								   <p class="mb-0 font-size-12 text-primary"><?= $val->deskripsi;?></p>
         								</div>
         								<div class="iq-card-header-toolbar d-flex align-items-center">
         								   <div class="dropdown show">
         									  <span class='text-danger'> mulai : <?= substr($val->mulai,0,5);?> s.d <?= substr($val->akhir,0,5);?></span> 
         								   
         								   </div>
         								</div>
         							 </li>
         							<?php } ?>
         						  </ul> 
                        <?php endif ?>
                        </div>
                     </div>
                  </div>
               </div>
               
            </div>

			<script>
				Highcharts.chart('bidang', {
					
					credits: {
                   enabled: false
               },
             chart: {
         		plotBackgroundColor: null,
                 plotBorderWidth: null,
                 plotShadow: false,
         		backgroundColor:null,
                 type:'pie',
             },
             title: {
                 text: '',
                 align: 'center',
                 verticalAlign: 'middle',
                 y: 10
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
      				dataLabels: {
                      enabled: false
                  },
                  
                  startAngle: -90,
                  endAngle: 90,
                  center: ['50%', '75%'],
                  size: '180%'
               }
             },
             colors: ['#089bab', '#ffb177', '#e64141', '#00d0ff'],
             series: [{
                 type: 'pie',
                 name: 'Jumlah',
                 innerSize: '50%',
                 data: [
                     ['WFO: <?= $wfo;?> org',<?= $wfo;?>],
                     ['WFH: <?= $wfh;?> org',<?= $wfh;?>],
                     ['Dinas: <?= $dinas;?> org',<?= $dinas;?>],
                     ['Izin + Sakit: <?= $izinsakit;?> org',<?= $izinsakit;?>],
                     <?php //echo $dtchar;?>
                 ]
             }]
         });
			</script>