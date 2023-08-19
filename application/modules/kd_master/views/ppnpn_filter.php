<?php
$get_controller = $this->router->fetch_class();
$id_pegawai = ''; ?>
<div class="modal-content">
    <div class="modal-header">  <h5 class="modal-titles" id="defaultModalLabel"><b>Filter Data PPNPN</b></h5>
		<button type="button" class="close" aria-label="Close" data-dismiss="modal">
	    	<span aria-hidden="true">×</span>
		</button>
	</div>


	<div class="modal-body">
		   
			<table class="table table-bordered mg-b-0 text-md-nowrap">
				 
				 
				<tr>
					<td>Istana </td>
					<td>
                    
                        <?php
                        $dtIstana[null] = "---  pilih   ---";
                        $db=$this->m_reff->list_istana()->result();
                        foreach($db as $db){
                            $dtIstana[$db->kode] = $db->istana;
                        }
                        echo form_dropdown("f_istana", $dtIstana, $this->session->userdata("f_istana"), "class='text-black form-control' onchange='setFilter(`f_istana`,this.value)'") ?>
            
					</td> 
				 
					<td>Biro </td>
					<td>
                    <?php
					$dtBiro[null] = "--- pilih ---";
					$db=$this->m_reff->list_biro()->result();
					foreach($db as $db){
						$dtBiro[$db->kode] = $db->biro;
					}
				  	echo form_dropdown("f_biro", $dtBiro, $this->session->userdata("f_biro"), "class='text-black form-control' onchange='setFilter(`f_biro`,this.value)'") ?>
 		
					</td> 
				</tr>
                <tr>
					<td>Bagian </td>
					<td>
                    <?php
					$dtBidang[null] = "--- pilih ---";
					$db=$this->m_reff->list_bagian(1)->result();
					foreach($db as $db){
						$dtBidang[$db->bagian] = $db->bagian;
					}
				  	echo form_dropdown("f_bagian", $dtBidang, $this->session->userdata("f_bagian"), "id='f_bagian' class='testselect2 SumoUnder' multiple onchange='setFilterOption(`f_bagian`)'") ?>
 		
					</td> 
				
					<td>Subbagian </td>
					<td>
                    <?php
                    $dt = array();
					// $dt[null] = "--- pilih ---";
					$db=$this->m_reff->list_subbagian(1)->result();
					foreach($db as $db){
						$dt[$db->subbagian] = $db->subbagian;
					}
				  	echo form_dropdown("f_subbagian", $dt, $this->session->userdata("f_subbagian"), "id='f_subbagian' class='testselect2 SumoUnder' multiple onchange='setFilterOption(`f_subbagian`)'") ?>
 		
					</td> 
				</tr>
                <tr>
                    <td>Golongan</td>
                    <td>
                    <?php
                    $dt = array();
					// $dt[null] = "--- pilih spesifik ---";
					$db=$this->m_reff->list_golongan();
					foreach($db as $dbs){
						$dt[$dbs->id] = $dbs->golongan." - ".$dbs->pangkat;
					}
                   
				  	echo form_dropdown("f_golongan", $dt, $this->session->userdata("f_golongan"), "id='f_golongan' class='testselect2 SumoUnder' multiple onchange='setFilterOption(`f_golongan`)'") ?>
 		
                    </td>
                    <td> Rentang Usia </td>
                    <td>
                    <input name="f_usia_min"  onchange='setFilter(`f_usia_min`,this.value)' type="number" value="<?php echo $this->session->userdata("f_usia_min");?>" style="max-width:60px">
                    sampai 
                    <input name="f_usia_max" onchange='setFilter(`f_usia_max`,this.value)' type="number"  value="<?php echo $this->session->userdata("f_usia_max");?>" style="max-width:60px"> Tahun
                    </td>
                </tr>
                <tr>
                    <td style="min-width:100px"> Masa kerja  </td>
                    <td> 
                    <input name="f_masker_min"   onchange='setFilter(`f_masker_min`,this.value)' type="number" value="<?php echo $this->session->userdata("f_masker_min");?>" style="max-width:70px">
                    &nbsp;&nbsp;&nbsp;sampai &nbsp;&nbsp;&nbsp;
                    <input name="f_masker_max"   onchange='setFilter(`f_masker_max`,this.value)' type="number"  value="<?php echo $this->session->userdata("f_masker_max");?>" style="max-width:70px;  "> Tahun
                       
                     </td>
                
                    <td style="min-width:100px"> sisa pensiun  </td>
                    <td> 
                    <input name="f_pensiun_min"  onchange='setFilter(`f_pensiun_min`,this.value)' type="number" value="<?php echo $this->session->userdata("f_pensiun_min");?>"  style="max-width:60px">
                    sampai 
                    <input name="f_pensiun_max" onchange='setFilter(`f_pensiun_max`,this.value)' type="number"  value="<?php echo $this->session->userdata("f_pensiun_max");?>" style="max-width:60px"> tahun
                     </td>
                </tr>
                <tr>
                <td>Jabatan </td>
                <td>
                <?php
                    $dt = array();
					 
					$db=$this->m_reff->list_jabatan();
					foreach($db as $dbs){
						$dt[$dbs->jabatan] = $dbs->jabatan;
					} 
				  	echo form_dropdown("f_jabatan", $dt,$this->session->userdata("f_jabatan"), "id='f_jabatan' class='testselect2 SumoUnder' multiple onchange='setFilterOption(`f_jabatan`)'") ?>
                   
                </td>

                    <td>Jumlah Tanggungan </td>
                    <td> Lebih dari : <input name="f_jml_tanggungan" value="<?php echo $this->session->userdata("f_jml_tanggungan");?>" type="number"  onchange='setFilter(`f_jml_tanggungan`,this.value)' style="width:64px"> Orang</td>
                    
                </tr>
                <tr>
                <td>Asal Provinsi</td>
                    <td>
                    <?php
                    $dt = array();
					$dt[null] = "--- pilih  ---";
					$db=$this->db->get("provinsi")->result();
					foreach($db as $dbs){
						$dt[$dbs->id_prov] = $this->m_reff->provinsi($dbs->id_prov);
					} 
				  	echo form_dropdown("f_provinsi_ktp", $dt, $this->session->userdata("f_provinsi_ktp"), "class='text-black form-control'  onchange='setFilter(`f_provinsi_ktp`,this.value)'") ?>
                    </td>
                    <td>Domisili</td>
                    <td>
                    <?php
                    $dt = array();
					$dt[null] = "--- pilih  ---";
					$db=$this->m_reff->domisili();
					foreach($db as $dbs){
						$dt[$dbs->id_prov] = $this->m_reff->provinsi($dbs->id_prov);
					} 
				  	echo form_dropdown("f_provinsi_domisili", $dt, $this->session->userdata("f_provinsi_domisili"), "class='text-black form-control' onchange='setFilter(`f_provinsi_domisili`,this.value)'") ?>
                    </td>
                </tr>
                <tr>
                    <td>Jenjang pendidikan</td>
                    <td>
                    <?php
                    $dt = array();
					// $dt[null] = "--- pilih  ---";
					$db=$this->m_reff->list_jp();
					foreach($db as $dbs){
						$dt[$dbs->id_jp] = $dbs->id_jp;
					} 
				  	echo form_dropdown("f_jp", $dt, $this->session->userdata("f_jp"), "id='f_jp' class='testselect2 SumoUnder' multiple='multiple' onchange='setFilterOption(`f_jp`)'") ?>
                    
                    </td>
                    <td>Penghargaan</td>
                    <td >
                        
                        <div class="row mb-3">
                    <div class="col-lg-6">
										<label class="rdiobox"><input onclick='setFilter(`f_penghargaan`,`ya`)' <?php  if($this->session->userdata("f_penghargaan")=='ya'){ echo 'checked';}; ?> name="penghargaan" type="radio"> <span>Memiliki</span></label>
                    </div>
                    <div class="col-lg-6">
                                        <label class="rdiobox"><input onclick='setFilter(`f_penghargaan`,`no`)' <?php  if($this->session->userdata("f_penghargaan")=='no'){ echo 'checked';}; ?> name="penghargaan" type="radio"> <span>Tidak memiliki</span></label>
					 </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Hukuman/pelanggaran</td>
                    <td >
                        <div class="row mb-3">
                    <div class="col-lg-7">
										<label class="rdiobox"><input name="f_hukuman" type="radio" onclick='setFilter(`f_hukuman`,`ya`)' <?php  if($this->session->userdata("f_hukuman")=='ya'){ echo 'checked';}; ?> > <span>Pernah dihukum/melanggar</span></label>
                    </div>
                    <div class="col-lg-5">
                                        <label class="rdiobox"><input name="f_hukuman" onclick='setFilter(`f_hukuman`,`no`)' <?php  if($this->session->userdata("f_hukuman")=='no'){ echo 'checked';}; ?>  type="radio"> <span>Tidak pernah</span></label>
					 </div>
                        </div>
                    </td>
                 
                    <td>Riwayat penyakit</td>
                    <td >
                        <div class="row mb-3">
                    <div class="col-lg-7">
										<label class="rdiobox"><input name="f_rm" onclick='setFilter(`f_rm`,`ya`)' <?php  if($this->session->userdata("f_rm")=='ya'){ echo 'checked';}; ?> type="radio"> <span>Memiliki riwayat</span></label>
                    </div>
                    <div class="col-lg-5">
                                        <label class="rdiobox"><input name="f_rm" onclick='setFilter(`f_rm`,`no`)' <?php  if($this->session->userdata("f_rm")=='no'){ echo 'checked';}; ?> type="radio"> <span>Tidak punya </span></label>
					 </div>
                        </div>
                    </td>
                </tr>
				<tr>
					<td></td>
					<td>

					<td>Status Covid saat ini</td>
                    <td >
                        <div class="row mb-3">
                    <div class="col-lg-6">
										<label class="rdiobox"><input name="f_covid" onclick='setFilter(`f_covid`,`ya`)' <?php  if($this->session->userdata("f_covid")=='ya'){ echo 'checked';}; ?> type="radio"> <span>Terpapar</span></label>
                    </div>
                    <div class="col-lg-6">
                                        <label class="rdiobox"><input name="f_covid" onclick='setFilter(`f_covid`,`no`)' <?php  if($this->session->userdata("f_covid")=='no'){ echo 'checked';}; ?> type="radio"> <span>Tidak terpapar </span></label>
					 </div>
                        </div>
                    </td>
					</td>
				</tr>
			</table>

			<div class="col-lg-12 p-1">
                <br>
                <div class="alert alert-info"> Sebelum memfilter disarankan agar melakukan syncron data 
                    terlebih dahulu agar data yang ditampilakan sesuai dengan data terbaru dari sistem kepegawaian.<br>
                    Terakhir data diperbaharui : <?= $this->m_reff->pengaturan(32);?> Wib.</div>
				<center>
					<button class="btn btn-light button_save" onclick="resset()">  Resset filter</button>
					<button class="btn btn-success button_save" onclick="submit_filter()">  <i class='fa fa-search'></i> Cari berdasarkan filter</button>
				</center>
			</div>
 
	</div>
</div>

<!-- <script>
$("#dataBiro").hide();
function dataBiro(id) {
	var is = id.toLowerCase();
	if(is=="<?php echo $this->m_reff->kode_istana_jakarta()?>"){
  	    $("#dataBiro").show();
	}else {
		$("#dataBiro").hide();
	}
}
</script> -->


<script>
$(function() {
	//muti
	window.asd = $('.SlectBox').SumoSelect({ csvDispCount: 3, selectAll:true, captionFormatAllSelected: "Yeah, OK, so everything." });
	window.Search = $('.search-box').SumoSelect({ csvDispCount: 3, search: true, searchText:'Enter here.' });
	window.sb = $('.SlectBox-grp-src').SumoSelect({ csvDispCount: 3, search: true, searchText:'Enter here.', selectAll:true });
	$('.testselect1').SumoSelect();
	$('.testselect2').SumoSelect();
	$('.selectsum1').SumoSelect({ okCancelInMulti: true, selectAll: true });
	$('.selectsum2').SumoSelect({ selectAll: true });
	
});
</script>

<script>
    function setFilter(key,value){
        var url = "<?php echo site_url($get_controller."/set_filter");?>";
		var param = {<?php echo $this->m_reff->tokenName()?>:token,key:key,value:value};
		$.ajax({
			type: "POST",dataType: "json",data: param, url: url,
			success: function(val){
				token=val['token'];
                reload_table();
			}
		});
    }

    function setFilterOption(key){
        var options = document.getElementById(key).selectedOptions;
        var values = Array.from(options).map(({ value }) => value);
        setFilter(key,values);
    }
    function resset(){
        swal({
			title: 'resset filter ?',
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
				swal("data filter telah direset", {
					icon: "success",
					buttons : {
						confirm : {
							className: 'btn btn-success'
						}
					}
				});

				var url   = "<?=base_url();?>kd_master/resset";
				var param = {ci_csrf_token:token};
				$.ajax({
					type: "POST",dataType: "json",data: param, url: url,
					success: function(val){
                        $("#mdl_modal_filter").modal("hide");
						token=val['token'];
                        reload_table();
					 
					}
				});
			}
		});
    }
    function submit_filter(){
        $("#mdl_modal_filter").modal("hide");
        reload_table();
    }
</script>


