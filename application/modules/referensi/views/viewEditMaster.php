 <?php $database=$this->db->get_where("pengaturan",array("id"=>$this->input->post("id")))->row();  
 if(!isset($database)){
     echo "data tidak tersedia!";
     return false;
 }
		 
 ?>		
<input type="hidden" name="id" value="<?php echo $database->id;?>"> 
							 
  <div class="row clearfix">
                                    <div class="col-lg-3 col-md-3  form-control-label">
                                        <label for="email_address_2" class="col-black"  style='margin-top:15px'>ID </label>
                                    </div>
                                    <div class="col-lg-8 col-md-8  ">
                                        <div class="form-group">
                                            <div class="form-line"  >
											<input   required class=" form-control" name="f[id]" value="<?php echo $database->id;?>"  type="text">
                                            </div>
                                        </div>
                                    </div>
                                </div>   
							<div class="row clearfix">
                                    <div class="col-lg-3 col-md-3  form-control-label">
                                        <label for="email_address_2" class="col-black"  style='margin-top:15px'> Nama Pengaturan  </label>
                                    </div>
                                    <div class="col-lg-8 col-md-8  ">
                                        <div class="form-group">
                                            <div class="form-line"  >
											<input   required class=" form-control" name="f[title]" value="<?php echo $database->title;?>" type="text">
                                            </div>
                                        </div>
                                    </div>
                                </div> 
									
						  <div class="row clearfix">
                                    <div class="col-lg-3 col-md-3  form-control-label">
                                        <label for="email_address_2" class="col-black"  style='margin-top:15px'>Value</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8  ">
                                        <div class="form-group">
                                            <div class="form-line"  >
											<textarea     class=" form-control" name="f[val]"  type="text"><?php echo $database->val;?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>  
									   
									
								 
							   