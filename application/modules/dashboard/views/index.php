<?php
$dp = $this->db->get_where("admin",array("id_admin"=>$this->session->userdata("id")))->row();
$level = $this->session->userdata("level");
 
    $foto = isset($dp->poto)?($dp->poto):"";
    $nama_pengguna = isset($dp->owner)?($dp->owner):"";
 
?>


					<!-- breadcrumb -->
					<div class="breadcrumb-header justify-content-between">
						<div>
							<h4 class="content-title mb-2">Hai, <?php echo $nama_pengguna?></h4>
							<nav aria-label="breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#">Selamat datang dihalaman monitoring data covid</a></li>
									<!-- <li class="breadcrumb-item active" aria-current="page">Project</li> -->
								</ol>
							</nav>
						</div>
						<div class="d-flex my-auto">
							<div class=" d-flex right-page">
								<div class="d-flex justify-content-center mr-5">
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
								
								</div>
							</div>
						</div>
					</div>
					<!-- /breadcrumb -->


					<!-- main-content-body -->
					<div class="main-content-body">
						<div class="row row-sm">
							<div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
								<div class="card overflow-hidden project-card">
									<div class="card-body">
										<div class="d-flex">
											<div class="my-auto">
												<svg enable-background="new 0 0 469.682 469.682" version="1.1"  class="mr-4 ht-60 wd-60 my-auto primary" viewBox="0 0 469.68 469.68" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
													<path d="m120.41 298.32h87.771c5.771 0 10.449-4.678 10.449-10.449s-4.678-10.449-10.449-10.449h-87.771c-5.771 0-10.449 4.678-10.449 10.449s4.678 10.449 10.449 10.449z"/>
													<path d="m291.77 319.22h-171.36c-5.771 0-10.449 4.678-10.449 10.449s4.678 10.449 10.449 10.449h171.36c5.771 0 10.449-4.678 10.449-10.449s-4.678-10.449-10.449-10.449z"/>
													<path d="m291.77 361.01h-171.36c-5.771 0-10.449 4.678-10.449 10.449s4.678 10.449 10.449 10.449h171.36c5.771 0 10.449-4.678 10.449-10.449s-4.678-10.449-10.449-10.449z"/>
													<path d="m420.29 387.14v-344.82c0-22.987-16.196-42.318-39.183-42.318h-224.65c-22.988 0-44.408 19.331-44.408 42.318v20.376h-18.286c-22.988 0-44.408 17.763-44.408 40.751v345.34c0.68 6.37 4.644 11.919 10.449 14.629 6.009 2.654 13.026 1.416 17.763-3.135l31.869-28.735 38.139 33.959c2.845 2.639 6.569 4.128 10.449 4.18 3.861-0.144 7.554-1.621 10.449-4.18l37.616-33.959 37.616 33.959c5.95 5.322 14.948 5.322 20.898 0l38.139-33.959 31.347 28.735c3.795 4.671 10.374 5.987 15.673 3.135 5.191-2.98 8.232-8.656 7.837-14.629v-74.188l6.269-4.702 31.869 28.735c2.947 2.811 6.901 4.318 10.971 4.18 1.806 0.163 3.62-0.2 5.224-1.045 5.493-2.735 8.793-8.511 8.361-14.629zm-83.591 50.155-24.555-24.033c-5.533-5.656-14.56-5.887-20.376-0.522l-38.139 33.959-37.094-33.959c-6.108-4.89-14.79-4.89-20.898 0l-37.616 33.959-38.139-33.959c-6.589-5.4-16.134-5.178-22.465 0.522l-27.167 24.033v-333.84c0-11.494 12.016-19.853 23.51-19.853h224.65c11.494 0 18.286 8.359 18.286 19.853v333.84zm62.693-61.649-26.122-24.033c-4.18-4.18-5.224-5.224-15.673-3.657v-244.51c1.157-21.321-15.19-39.542-36.51-40.699-0.89-0.048-1.782-0.066-2.673-0.052h-185.47v-20.376c0-11.494 12.016-21.42 23.51-21.42h224.65c11.494 0 18.286 9.927 18.286 21.42v333.32z"/>
													<path d="m232.21 104.49h-57.47c-11.542 0-20.898 9.356-20.898 20.898v104.49c0 11.542 9.356 20.898 20.898 20.898h57.469c11.542 0 20.898-9.356 20.898-20.898v-104.49c1e-3 -11.542-9.356-20.898-20.897-20.898zm0 123.3h-57.47v-13.584h57.469v13.584zm0-34.482h-57.47v-67.918h57.469v67.918z"/>
												</svg>
											</div>
											<div class="project-content">
												<h6>PNS</h6>
												<ul>
													<li style='border-bottom:green solid 1px'>
														<b class='text-orange'>Terpapar</b>
														<span class='text-orange'>2</span>
													</li>

													<li>
														<b class='text-info'>Tidak terpapar</b>
														<span class='text-info'>16</span>
													</li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
								<div class="card  overflow-hidden project-card">
									<div class="card-body">
										<div class="d-flex">
											<div class="my-auto">
												<svg enable-background="new 0 0 438.891 438.891" class="mr-4 ht-60 wd-60 my-auto danger" version="1.1" viewBox="0 0 438.89 438.89" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
													<path d="m347.97 57.503h-39.706v-17.763c0-5.747-6.269-8.359-12.016-8.359h-30.824c-7.314-20.898-25.6-31.347-46.498-31.347-20.668-0.777-39.467 11.896-46.498 31.347h-30.302c-5.747 0-11.494 2.612-11.494 8.359v17.763h-39.707c-23.53 0.251-42.78 18.813-43.886 42.318v299.36c0 22.988 20.898 39.706 43.886 39.706h257.04c22.988 0 43.886-16.718 43.886-39.706v-299.36c-1.106-23.506-20.356-42.068-43.886-42.319zm-196.44-5.224h28.735c5.016-0.612 9.045-4.428 9.927-9.404 3.094-13.474 14.915-23.146 28.735-23.51 13.692 0.415 25.335 10.117 28.212 23.51 0.937 5.148 5.232 9.013 10.449 9.404h29.78v41.796h-135.84v-41.796zm219.43 346.91c0 11.494-11.494 18.808-22.988 18.808h-257.04c-11.494 0-22.988-7.314-22.988-18.808v-299.36c1.066-11.964 10.978-21.201 22.988-21.42h39.706v26.645c0.552 5.854 5.622 10.233 11.494 9.927h154.12c5.98 0.327 11.209-3.992 12.016-9.927v-26.646h39.706c12.009 0.22 21.922 9.456 22.988 21.42v299.36z"/>
													<path d="m179.22 233.57c-3.919-4.131-10.425-4.364-14.629-0.522l-33.437 31.869-14.106-14.629c-3.919-4.131-10.425-4.363-14.629-0.522-4.047 4.24-4.047 10.911 0 15.151l21.42 21.943c1.854 2.076 4.532 3.224 7.314 3.135 2.756-0.039 5.385-1.166 7.314-3.135l40.751-38.661c4.04-3.706 4.31-9.986 0.603-14.025-0.19-0.211-0.391-0.412-0.601-0.604z"/>
													<path d="m329.16 256.03h-120.16c-5.771 0-10.449 4.678-10.449 10.449s4.678 10.449 10.449 10.449h120.16c5.771 0 10.449-4.678 10.449-10.449s-4.678-10.449-10.449-10.449z"/>
													<path d="m179.22 149.98c-3.919-4.131-10.425-4.364-14.629-0.522l-33.437 31.869-14.106-14.629c-3.919-4.131-10.425-4.364-14.629-0.522-4.047 4.24-4.047 10.911 0 15.151l21.42 21.943c1.854 2.076 4.532 3.224 7.314 3.135 2.756-0.039 5.385-1.166 7.314-3.135l40.751-38.661c4.04-3.706 4.31-9.986 0.603-14.025-0.19-0.211-0.391-0.412-0.601-0.604z"/>
													<path d="m329.16 172.44h-120.16c-5.771 0-10.449 4.678-10.449 10.449s4.678 10.449 10.449 10.449h120.16c5.771 0 10.449-4.678 10.449-10.449s-4.678-10.449-10.449-10.449z"/>
													<path d="m179.22 317.16c-3.919-4.131-10.425-4.363-14.629-0.522l-33.437 31.869-14.106-14.629c-3.919-4.131-10.425-4.363-14.629-0.522-4.047 4.24-4.047 10.911 0 15.151l21.42 21.943c1.854 2.076 4.532 3.224 7.314 3.135 2.756-0.039 5.385-1.166 7.314-3.135l40.751-38.661c4.04-3.706 4.31-9.986 0.603-14.025-0.19-0.21-0.391-0.411-0.601-0.604z"/>
													<path d="m329.16 339.63h-120.16c-5.771 0-10.449 4.678-10.449 10.449s4.678 10.449 10.449 10.449h120.16c5.771 0 10.449-4.678 10.449-10.449s-4.678-10.449-10.449-10.449z"/>
												</svg>
											</div>
											<div class="project-content">
												<h6>PPPK</h6>
												<ul>
													<li style='border-bottom:green solid 1px'>
														<b class='text-orange'>Terpapar</b>
														<span class='text-orange'>2</span>
													</li>

													<li>
														<b class='text-info'>Tidak terpapar</b>
														<span class='text-info'>16</span>
													</li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
								<div class="card overflow-hidden project-card">
									<div class="card-body">
										<div class="d-flex">
											<div class="my-auto">
												<svg enable-background="new 0 0 477.849 477.849" class="mr-4 ht-60 wd-60 my-auto success" version="1.1" viewBox="0 0 477.85 477.85" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
													<path d="m374.1 385.52c71.682-74.715 69.224-193.39-5.492-265.08-34.974-33.554-81.584-52.26-130.05-52.193-103.54-0.144-187.59 83.676-187.74 187.22-0.067 48.467 18.639 95.077 52.193 130.05l-48.777 65.024c-5.655 7.541-4.127 18.238 3.413 23.893s18.238 4.127 23.893-3.413l47.275-63.044c65.4 47.651 154.08 47.651 219.48 0l47.275 63.044c5.655 7.541 16.353 9.069 23.893 3.413 7.541-5.655 9.069-16.353 3.413-23.893l-48.775-65.024zm-135.54 24.064c-84.792-0.094-153.51-68.808-153.6-153.6 0-84.831 68.769-153.6 153.6-153.6s153.6 68.769 153.6 153.6-68.769 153.6-153.6 153.6z"/>
													<path d="m145.29 24.984c-33.742-32.902-87.767-32.221-120.67 1.521-32.314 33.139-32.318 85.997-8e-3 119.14 6.665 6.663 17.468 6.663 24.132 0l96.546-96.529c6.663-6.665 6.663-17.468 0-24.133zm-106.55 82.398c-12.186-25.516-1.38-56.08 24.136-68.267 13.955-6.665 30.175-6.665 44.131 0l-68.267 68.267z"/>
													<path d="m452.49 24.984c-33.323-33.313-87.339-33.313-120.66 0-6.663 6.665-6.663 17.468 0 24.132l96.529 96.529c6.665 6.663 17.468 6.663 24.132 0 33.313-33.322 33.313-87.338 0-120.66zm-14.08 82.449-68.301-68.301c19.632-9.021 42.79-5.041 58.283 10.018 15.356 15.341 19.371 38.696 10.018 58.283z"/>
													<path d="m238.56 136.52c-9.426 0-17.067 7.641-17.067 17.067v96.717l-47.787 63.71c-5.655 7.541-4.127 18.238 3.413 23.893s18.238 4.127 23.893-3.413l51.2-68.267c2.216-2.954 3.413-6.547 3.413-10.24v-102.4c1e-3 -9.426-7.64-17.067-17.065-17.067z"/>
												</svg>
											</div>
											<div class="project-content">
												<h6>OUTSOURCHING</h6>
												<ul>
													<li style='border-bottom:green solid 1px'>
														<b class='text-orange'>Terpapar</b>
														<span class='text-orange'>2</span>
													</li>

													<li>
														<b class='text-info'>Tidak terpapar</b>
														<span class='text-info'>16</span>
													</li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
						 
						</div>

						<!-- row -->
						<div class="row row-sm ">


							<div class="col-xl-8 col-lg-12 col-md-12 col-sm-12">
								<div class="card overflow-hidden">
									<div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">
										<div class="d-flex justify-content-between">
											<h4 class="card-title mg-b-10">Grafik</h4>
											<i class="mdi mdi-dots-horizontal text-gray"></i>
										</div>
										<!-- <p class="tx-12 text-muted mb-2">
                                            Kondisi status pegawai setiap hari selama 14 hari kebelakang
                                        </p> -->
									</div>
									<div class="card-body pd-y-7">
									 <div id="grafik_laju"></div>
									</div>
								</div>
							</div>




							<div class="col-sm-12 col-md-12 col-lg-12 col-xl-4">
								<div class="card overflow-hidden">
									<div class="card-body pb-3">
										<div class="d-flex justify-content-between">
											<h4 class="card-title mg-b-10">Klasifikasi Biro</h4>
											<i class="mdi mdi-dots-horizontal text-gray"></i>
										</div> 
										<div class="table-responsive mb-0 projects-stat tx-14">
											<table class="table table-hover table-bordered mb-0 text-md-nowrap text-lg-nowrap text-xl-nowrap  ">
												<thead>
													<tr>
														<th>BIRO</th>
														<th>Persen</th>
													</tr>
												</thead>
												<tbody>
                                                    <?php
                                                    $db =   $this->m_reff->getDataBiroPositif();
                                                    $no=1;
                                                    foreach($db as $val){
                                                        echo '
                                                        <tr>
														<td>
															<div class="project-names">
																<h6 style="color:black" class="bg-purple-transparent d-inline-block mr-2 text-center">'.$no++.'</h6>
																<p class="d-inline-block font-weight-semibold mb-0">'.$val->biro.'
                                                                <br><span class=" text-success" style="font-size:12px">Positif (+) : '.$val->jml.' orang</span>
                                                                </p>
                                                                
															</div>
														</td>
														<td>
															<div class="text-orange"><b>'.$this->mdl->persentaseCovid($val->biro,$val->jml).'%</b></div>
														</td>
													</tr>

';
                                                    }
                                                    ?>
                        
													
									
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
                            <div id="grafik_utama"></div>
							</div>

							<div class="col-lg-4 col-xl-4 col-md-4 col-sm-12">
                            <div id="grafik_biro"></div>
							</div>
						
							<div class="col-lg-4 col-xl-4 col-md-4 col-sm-12">
                            <div id="grafik_usia"></div>
							</div>
						
						
                     
						</div>
						<!-- /row -->
                        <br>
						<!-- row -->
						<div class="row row-sm ">
							<div class="col-md-4 col-xl-4">


                            <div class="card overflow-hidden review-project">
									<div class="card-body">
										 
									 	<div class="table-responsive mb-0">
											<table class="table table-hover table-bordered mb-0 text-md-nowrap text-lg-nowrap text-xl-nowrap table-striped ">
												<thead>
													<tr class='bg-purple'> 
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
										</div>
                                        
									</div>
								</div>









								<div class="card overflow-hidden review-project">
									<div class="card-body">
										 
									 	<div class="table-responsive mb-0">
											<table class="table table-hover table-bordered mb-0 text-md-nowrap text-lg-nowrap text-xl-nowrap table-striped ">
												<thead>
													<tr class='bg-danger'> 
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
										</div>
                                        
									</div>
								</div>



                            

							</div>



                            <div class="col-xl-4 col-lg-4 col-md-4">
								<div class="card overflow-hidden ">
									 
									<div class="card-body p-0">
										<div class="activity ">
											<div class="activity-list">
                                                <?php
                                                $dbkondisi = $this->mdl->dataKondisi();
                                                foreach($dbkondisi as $val){
                                                    $g = $val->gejala;
                                                    $g = str_replace('"','',$g);
                                                    $g = str_replace('[','',$g);
                                                    $gejala = str_replace(']','',$g);


                                                    if(strtolower($val->kondisi)=="membaik"){
                                                        $kondisi = "<span class='text-success'>Membaik</span>";
                                                        $text = "text-success";
                                                    }elseif(strtolower($val->kondisi)=="memburuk"){
                                                        $kondisi = "<span class='text-danger'>Memburuk</span>";
                                                        $text = "text-danger";
                                                    }elseif(strtolower($val->kondisi)=="stagnan"){
                                                        $kondisi = "<span class='text-info'>Stagnan</span>";
                                                        $text = "text-info";
                                                    }else{
                                                        $kondisi = "";
                                                        $text = "";
                                                    }
                                                ?>
												<img src="<?php echo base_url()?>assets/img/faces/user.png" alt="" class="img-activity">
												<div class="time-activity ">
													<div class="item-activity">
													<p class="mb-0"><span class="h6 mr-1">Adam Berry</span><span class="text-muted tx-13"> 
                                                        Menyatakan</span> <span class="h6 ml-1 added-project"> 
                                                            <?php echo $kondisi;?></span></p>
                                                            <span class="<?php echo $text?>"><?php echo $gejala?><span><br>
                                                            <small class="text-muted ">
                                                               <?php echo $this->tanggal->hariLengkap3($val->tgl)?></small> 
                                                            </div>
												</div>
											  <?php } ?>
											</div>
										</div>
									</div>
								</div>
							</div>





                            <div class="col-md-4 col-lg-4 col-xl-4">
								<div class="card">
									 
									<div class="pl-4 pr-4 pt-2 pb-3">
										<div class="">
											<div class="row">
												<div class="col-md-6 col-6 text-center">
													<div class="task-box primary mb-0">
														<p class="mb-0 tx-12">Isolasi Mandiri</p>
														<h3 class="mb-0"><?php echo $this->mdl->isolasi_mandiri()?></h3>
													</div>
												</div>
												<div class="col-md-6 col-6 text-center">
													<div class="task-box danger  mb-0">
														<p class="mb-0 tx-12">DIRAWAT</p>
														<h3 class="mb-0"><?php echo $this->mdl->isolasi_rs()?></h3>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="task-stat pb-0">
<?php
$dbact = $this->mdl->data_activity(14);
foreach($dbact as $val){
    if($val->hasil=="-"){
        $hasil = "<span class='text-success'>negatif(-)</span>";
        $text  = "text-success";
    }elseif($val->hasil=="+"){
        $hasil = "<span class='text-danger'>positif(+)</span>";
        $text  = "text-danger";
    }else{
        $hasil = "";
        $text  = "";
    }

    $biro =  $this->m_reff->goField("data_pegawai","biro","where nip='".$val->nip."'");

?>
										<div class="d-flex tasks">
											<div class="mb-0">
												<div class="h6 fs-15 mb-0"><i class="far fa-dot-circle <?php echo $text; ?> mr-2"></i>
                                                <?php echo $val->nama;?> . <span class='text-dark'><?php echo $biro;?></span></div>
												<span class="text-muted tx-11 ml-4">
                                                    <?php echo $this->tanggal->hariLengkap3($val->konfirm_rs)?>
                                                </span>
											</div>
											<span class="float-right ml-auto"><?php echo $hasil?></span>
										</div>
<?php } ?>			 
									</div>
								</div>
							</div>


						</div>
						<!-- /row -->
 
				




                        <?php
                        $now        = date("Y-m-d");
                        $dataTgl    = "";
                        $p1         =   0;
                        $p2         =   0;
                        $p3         =   0;
                        for($i=14;$i>=0;$i--){
                            $tgl     = $this->tanggal->minTgl($i,$now);
                            $tgle     = $this->tanggal->eng($tgl,"-");
                            $dataTgl.= "'".$tgl."',";
                            $p1.=$this->mdl->jml_positif($tgle,'p1').",";
                            $p2.=$this->mdl->jml_positif($tgle,'p2').",";
                            $p3.=$this->mdl->jml_positif($tgle,'p3').",";
                        }
                        ?>
     <script>
    Highcharts.chart('grafik_laju', {
    chart: {
        type: 'area'
    },
    title: {
        text: 'Statistik selamat 14 hari kebelakang'
    },
    xAxis: {
        categories: [<?php echo $dataTgl; ?>]
    },
    yAxis: {
        title: {
            text: 'Jumlah'
        }
    },

    credits: {
        enabled: false
    },
    series: [{
        name: 'PNS',
        data: [<?php echo $p1;?>]
    }, {
        name: 'PPPK',
        data: [<?php echo $p2;?>]
    }, {
        name: 'OUTSOURCHING',
        data: [<?php echo $p3;?>]
    }]
});
      
                        </script>

 


<?php 
                                               
                                                    $biro="";
                                                    foreach($db as $val){
                                                        $biro.="{ name: '".$val->biro."', y: ".$val->jml." },";
                                                    }
 ?>


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

// Build the chart
Highcharts.chart('grafik_biro', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Klasifikasi Biro'
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
            <?php echo $biro;?>
        ]
    }]
});
</script>




<script>
// Build the chart
Highcharts.chart('grafik_usia', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
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
        type: 'pie'
    },
    title: {
        text: 'Klasifikasi keseluruhan'
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

 
  