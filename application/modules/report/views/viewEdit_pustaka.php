<?php
$id = $this->input->post("id");
$data = $this->db->get_where("tm_pustaka",array("id"=>$id))->row();
if(!isset($data)){
	echo "data tidak tersedia!";
	return false;
}
$id = $data->id;
$nama = $data->nama;
?>
	                <div class="modal-content">  
                         <div class="modal-header">  <h5 class="modal-titles" id="defaultModalLabel"><b>Edit </b></h5>
						<button type="button" class="close" aria-label="Close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
						</button>
                    </div>


                        <div class="modal-body" id="area_modal">

<form  action="javascript:submitForm('modal')" id="modal" url="<?php echo base_url()?>report/update_pustaka"  method="post" enctype="multipart/form-data">
 <input type="hidden" value="<?php echo $id?>" name="id">
 <input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName()?>" value="<?php echo $this->m_reff->getToken()?>">
								<div class=" pd-sm-20 "  >
								 
								 
									<div class="row row-xs align-items-center mg-b-20">
										<div class="col-md-3">
											<label class="form-label mg-b-0">File</label>
								                </div>
										<div class="col-md-9 mg-t-5 mg-md-t-0">
											<input class="form-control"   name='file'  type="file">
								                </div>
							        </div>
                                    <div class="row row-xs align-items-center mg-b-20">
										<div class="col-md-3">
											<label class="form-label mg-b-0">Nama</label>
								                </div>
										<div class="col-md-9 mg-t-5 mg-md-t-0">
											<input class="form-control" value="<?=$data->nama?>" required name='f[nama]' value="<?php echo $nama?>" placeholder="nama biro" type="text">
								                </div>
							        </div>
                                    <div class="row row-xs align-items-center mg-b-20">
										<div class="col-md-3">
											<label class="form-label mg-b-0">Keterangan</label>
								                </div>
										<div class="col-md-9 mg-t-5 mg-md-t-0">
                                        <textarea class="form-control"   name='f[ket]'  placeholder="keterangan..." type="text"><?=$data->ket?></textarea>
                                                 </div>
							        </div>


                                            <button  onclick="submitForm('modal')"  
                                    class="float-right btn btn-primary pd-x-30 mg-r-5 mg-t-5"><i class='fa fa-save'></i> Simpan</button>
								 
                                    </div>   
				<!-- /row -->
</form>

</div>
</div>

 