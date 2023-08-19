<?php
$id = $this->m_reff->san($this->input->post("id"));
$data = $this->db->get_where("tr_jenis_test",array("id"=>$id))->row();
$kode = $data->kode;
$nama = $data->nama;
?>
	                <div class="modal-content">  
                         <div class="modal-header">  <h5 class="modal-titles" id="defaultModalLabel"><b>Edit </b></h5>
						<button type="button" class="close" aria-label="Close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
						</button>
                    </div>


                        <div class="modal-body" >

<form  action="javascript:submitForm('modal_edit')" id="modal_edit" url="<?php echo base_url()?>data_master/update_test"  method="post" enctype="multipart/form-data">
 <input type="hidden" value="<?php echo $id?>" name="id">
 <input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName()?>" value="<?php echo $this->m_reff->getToken()?>">
								<div class=" pd-sm-20 "  >
								 
									<div class="row row-xs align-items-center mg-b-20">
										<div class="col-md-4">
											<label class="form-label mg-b-0" >Kode</label>
								                </div>
										<div class="col-md-8 mg-t-5 mg-md-t-0">
											<input required class="form-control"  name="f[kode]" value="<?php echo $kode ?>" placeholder="kode" type="text">
								                </div>
							                </div>
									<div class="row row-xs align-items-center mg-b-20">
										<div class="col-md-4">
											<label class="form-label mg-b-0">Nama</label>
								                </div>
										<div class="col-md-8 mg-t-5 mg-md-t-0">
											<input class="form-control" required name='f[nama]' value="<?php echo $nama?>" placeholder="nama biro" type="text">
								                </div>
							                </div>
                                            <button  onclick="submitForm('modal_edit')"  
                                    class="float-right btn btn-primary pd-x-30 mg-r-5 mg-t-5"><i class='fa fa-save'></i> Simpan</button>
								 
                                    </div>   
				<!-- /row -->
</form>

</div>
</div>

 