 
								 
					 
							  <div class="row clearfix">
                                    <div class="col-lg-3 col-md-3  form-control-label">
                                        <label for="email_address_2" class="col-black"  style='margin-top:15px'>Nama </label>
                                    </div>
                                    <div class="col-lg-8 col-md-8  ">
                                        <div class="form-group">
                                            <div class="form-line"  >
											<input   required class=" form-control" name="f[owner]"  type="text">
                                            </div>
                                        </div>
                                    </div>
                                </div>  

								<div class="row clearfix">
                                    <div class="col-lg-3 col-md-3  form-control-label">
                                        <label for="email_address_2" class="col-black"  style='margin-top:15px'>NIP/ID </label>
                                    </div>
                                    <div class="col-lg-8 col-md-8  ">
                                        <div class="form-group">
                                            <div class="form-line"  >
											<input   required class=" form-control" name="f[nip]"  type="text">
                                            </div>
                                        </div>
                                    </div>
                                </div> 
								
								<div class="row clearfix">
                                    <div class="col-lg-3 col-md-3  form-control-label">
                                        <label for="email_address_2" class="col-black" style='margin-top:15px'>Level</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8  ">
                                        <div class="form-group">
                                            <div class="form-line"  >
											<?php
											$level[18]="Admin";
											$level[28]="Pimpinan";
											$level[29]="Petugas scan";
											$level[30]="broadcast";
										 
											echo form_dropdown("f[level]",$level,"","class='form-control' ");
											?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
								
								<div class="row clearfix">
                                    <div class="col-lg-3 col-md-3  form-control-label">
                                        <label for="email_address_2" class="col-black" style='margin-top:15px'>Status Aktivasi</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8  ">
                                        <div class="form-group">
                                            <div class="form-line"  >
											<?php
											$act["enable"]="Aktif";
											$act["disable"]="Non-aktif"; 
											echo form_dropdown("f[sts_aktivasi]",$act,"","class='form-control' ");
											?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
								 
  