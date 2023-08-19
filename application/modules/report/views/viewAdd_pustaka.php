 
	                <div class="modal-content">  
                         <div class="modal-header">  <h5 class="modal-titles" id="defaultModalLabel"><b>Tambah </b></h5>
						<button type="button" class="close" aria-label="Close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
						</button>
                    </div>


                        <div class="modal-body" id="area_modal">

<form  action="javascript:submitForm('modal')" id="modal" url="<?php echo base_url()?>report/insert_pustaka"  method="post" enctype="multipart/form-data">
 <input type="hidden" value="<?php echo $this->input->post("tbl");?>" name="tbl">
 <input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName()?>" value="<?php echo $this->m_reff->getToken()?>">
								<div class=" pd-sm-20 "  >
								 
									<div class="row row-xs align-items-center mg-b-20">
										<div class="col-md-3">
											<label class="form-label mg-b-0" >File</label>
								                </div>
										<div class="col-md-9 mg-t-5 mg-md-t-0">
											<input  class="form-control" type="file" name="file"  placeholder="kode" type="text">
								                </div>
							        </div>

                                    <div class="row row-xs align-items-center mg-b-20">
										<div class="col-md-3">
											<label class="form-label mg-b-0" >Nama file</label>
								                </div>
										<div class="col-md-9 mg-t-5 mg-md-t-0">
											<input    class="form-control"  name="f[nama]"  placeholder="Nama file" type="text">
								                </div>
							        </div>

									<div class="row row-xs align-items-center mg-b-20">
										<div class="col-md-3">
											<label class="form-label mg-b-0">keterangan</label>
								                </div>
										<div class="col-md-9 mg-t-5 mg-md-t-0">
											<textarea class="form-control"   name='f[ket]'  placeholder="keterangan..." type="text"></textarea>
                                            
								                </div>
							                </div>
                                            <button  onclick="submitForm('modal')"  
                                    class="float-right btn btn-primary pd-x-30 mg-r-5 mg-t-5"><i class='fa fa-save'></i> Simpan</button>
								 
                                    </div>   
				<!-- /row -->
</form>

</div>
</div>

 