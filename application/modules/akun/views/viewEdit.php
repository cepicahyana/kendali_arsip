 <?php $database=$this->db->get_where("admin",array("id_admin"=>$this->input->post("id")))->row();  
        if(!isset($database->id_admin) or !$this->input->post("id")){
            return false;
        }
 ?>		
<input type="hidden" name="id" value="<?php echo $database->id_admin;?>"> 
							 	
						  <div class="row clearfix">
                                    <div class="col-lg-3 col-md-3  form-control-label">
                                        <label for="email_address_2" class="col-black"  style='margin-top:15px'>Nama </label>
                                    </div>
                                    <div class="col-lg-8 col-md-8  ">
                                        <div class="form-group">
                                            <div class="form-line"  >
											<input   required class=" form-control" name="f[owner]" value="<?php echo $database->owner;?>" type="text">
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
											<input   required class=" form-control" name="f[nip]" value="<?php echo $database->nip;?>" type="text">
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
											$level[29]="Petugas Scan";
											$level[30]="Broadcast";
											 
											echo form_dropdown("f[level]",$level,$database->level,"class='form-control' ");
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
											echo form_dropdown("f[sts_aktivasi]",$act,$database->sts_aktivasi,"class='form-control' ");
											?>
                                            </div>
                                        </div>
                                    </div>
                                </div>