<?php
$kode = $this->m_reff->san($this->input->post("kode"));
$kodut = $this->m_reff->san($this->input->post("kodut"));
$token = $this->m_reff->getToken();
$db    = $this->db->get_where("data_keluarga",array("kode_test"=>$kode))->row();
if(!isset($db)){   return false; }
?>
	                <div class="modal-content">  
                         <div class="modal-header">  <h5 class="modal-titles" id="defaultModalLabel"><b> kondisi <?php echo $db->nama;?></b></h5>
						<button type="button" class="close" aria-label="Close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
						</button>
                    </div>


                        <div class="modal-body" >
					<center><b>Bagaimana perkembangan kondisinya hari ini ?</b></center><hr>
<?php
$data = $this->db->get("tr_kondisi")->result();
foreach($data as $val){
echo '<div onclick="pilih_kondisi_keluarga(`'.$kode.'`,`'.$val->id.'`,`'.$token.'`,`'.$kodut.'`)" class="cursor alert alert-outline-danger" role="alert">  '.$val->kondisi.' </div>';
}?>
 <div onclick='setSembuhKel(`<?=$kode;?>`)'  class="cursor alert alert-outline-danger" role="alert"> Sudah sembuh </div>

</div>
</div>


<script>

 
function setSembuhKel(kode){
                            swal({
                                title: 'Apakah telah sembuh ?',
                                text: '',
                                type: 'warning',
                                buttons:{
                                    cancel: {
                                        visible: true,
                                        text : 'batal',
                                        className: 'btn btn-danger'
                                    },        			
                                    confirm: {
                                        text : 'Ya',
                                        className : 'btn btn-success'
                                    }
                                }
                            }).then((willDelete) => {
                                if (willDelete) {
                                    swal("success", {
                                        icon: "success",
                                        buttons : {
                                            confirm : {
                                                className: 'btn btn-success'
                                            }
                                        }
                                    });
                                    
                                    var url   = "<?php echo site_url("dpegawai/setSembuhByKodeKel");?>";
                                    var param = {<?php echo $this->m_reff->tokenName()?>:token,kode:kode};
                                    $.ajax({
                                    type: "POST",dataType: "json",data: param, url: url,
                                    success: function(val){
                                        token=val['token'];
                                        $("#mdl_modal").modal("hide");
                                        reload_table();
                                    }
                                    });

                                }
                                });
}



             
</script>








