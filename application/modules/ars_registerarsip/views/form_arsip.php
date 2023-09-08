<?php
$id = $this->m_reff->san($this->input->post("id"));
$data = $this->db->get_where("ars_trx_arsip",array("id"=>$id))->row();
$nama = isset($data->nama)?($data->nama):null;
$id = isset($data->id)?($data->id):null;
 
?>


<div id="area_submitForm">
	<div class="card custom-card" id="tab">
		<div class="card-body">
			<div class="mg-b-20">
				<h6 class="card-title mb-1">Buat Arsip</h6>
			</div>
			<div class="text-wrap">
				<div class="border">
					<div class="card-body tab-content">
						<form action="javascript:submit('submitForm')" id="submitForm" url="<?php echo base_url()?>ars_registerarsip/update_arsip"
							method="post" enctype="multipart/form-data">
							<input type="hidden" value="<?php echo $id?>" name="id">
							<input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName()?>" value="<?php echo $this->m_reff->getToken()?>">
							<div class="col-md-6">
								<div class="row row-xs align-items-center mg-b-20">
									<div class="col-md-4">
										<label class="form-label mg-b-0 text-black">Jenis Arsip </label>
									</div>
									<div class="col-md-8 mg-t-5 mg-md-t-0">
										<?php 
											$dataray=array();
											$dataray[""]="=== Pilih ===";
											$dataray["1"]="Konvensional";
											$dataray["2"]="Elektronik";
											$dataray["3"]="Audiovisual - Film / Video";
											$dataray["4"]="Audiovisual - Foto";
											$dataray["5"]="Audiovisual - Rekaman Suara / Audio Transkripsi";
											echo form_dropdown("f[jenis]",$dataray,"",'class="select2 form-control text-black " style="width:100%" onchange="change_form_by_type(this.value)"');
										?>
									</div>
								</div>
							</div>
							<hr>
							<div class="col-md-12" id="form_submit"></div>
						
							<div align="right">
								<hr>
								<button onclick="submit('submitForm')" class="btn btn-primary pd-x-30 mg-r-5 mg-t-5"><i
										class='fa fa-save'></i> Simpan</button>
							</div>

						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(function() {
		$('.select2').select2();
	});

	function submit()
    {
        $("#submitForm").ajaxForm({
            url: "<?php echo base_url()?>ars_registerarsip/update_arsip",
            data: $("#submitForm").serialize(),
            method:"POST",
            dataType:"JSON",
            beforeSend: function() {
                loading("area_submitForm");
            },
            success: function(data)
                { 	  
                    token = data["token"];
                    $("#formToken").val(data["token"]);
                    unblock("area_submitForm");

                    if(data["data"].gagal==true)
                    {	  
                        swal(data["data"].info, {
                            icon: "warning",
                            buttons : {
                                confirm : {
                                    className: 'btn btn-primary'
                                }
                            }
                        });
                    }else{
                            
                        swal({
                            title: 'Success!',
                            text: ' ',
                            icon: 'success',
                            timer: 1000,
                            buttons: false,
                        })
                        window.location = "<?php echo site_url('ars_registerarsip');?>";
                        
                    }
                                
                }
        });     
    }

	function change_form_by_type(type){
		var url   = "<?php echo site_url("ars_registerarsip/get_page");?>";
		var param = {<?php echo $this->m_reff->tokenName()?>:token,type:type};
		$.ajax({
			type: "POST",dataType: "json",data: param, url: url,
			success: function(val){
				$("#form_submit").html(val['data']);
				token=val['token'];
				$('.select2').select2();
				
				$('#periode').datepicker({
					format: 'yyyy-mm-dd'
				});

				$("#jadwal_retensi_arsip").on('change', function(){
					var id = $(this).val()
					var url   = "<?php echo site_url("ars_registerarsip/get_jra");?>";
					var param = {<?php echo $this->m_reff->tokenName()?>:token,id:id};
					$.ajax({
						type: "POST",dataType: "json",data: param, url: url,
						success: function(val){
							$("#retensi_aktif").val(val['data']['retensi_aktif']);
							$("#deks_retensi_aktif").val(val['data']['retensi_aktif_deskripsi']);
							$("#retensi_inaktif").val(val['data']['retensi_inaktif']);
							$("#deks_retensi_inaktif").val(val['data']['retensi_inaktif_deskripsi']);
							$("#tindak_lanjut").val(val['data']['nama_tindak_lanjut']);
							$("#detail_jra").css('display','')
						}
					})
				})
			}
		}); 
	}

	function AddUpload() {
        var length = $(".item").length;
		var new_length = length + 1;
        var html = `<tr class="item">
            			<td class="text-center number">${new_length}</td>
            			<td><input type="file" class="itemFile" onchange="UploadFileJquery(this)" name="file_${new_length}" id="file_${new_length}" accept="application/pdf, image/*, audio/*, video/*" accept-size="10" /></td>
            			<td class="text-center"> 
           					 ${length > 0 ? '<button type="button" class="btn btn-xs btn-danger btn-icon" style="padding: 3px 4px" onclick="removelist(this)"><i class="side-menu__icon fe fe-trash" style="color: #FFF"></i></button>' : ''}
            			</td>
					</tr>`;
        $("#JmlUpload").val(new_length);
        $("#ListItem").append(html);
        replacenameFileupload();
    }

    function UploadFile(ini) {
    }

	function UploadFileJquery(ini) {
    }

    function replacenameFileupload() {
        var no = 0;
        $(".itemFile").each(function() {
            $(this).attr("name", "file_" + no).attr("id", "file_" + no);
            no++;
        })
    }

	function removelist(ini) {
        $(ini).parent().parent().remove();
        var no = 1;
        $(".number").each(function() {
            $(this).html(no);
            no++;
        })
		
        $("#JmlUpload").val($(".item").length);

        replacenameFileupload();
    }
</script>