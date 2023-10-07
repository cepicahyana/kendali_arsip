<div class="row row-xs align-items-top mg-b-20">
	<div class="col-md-3">
		<label class="form-label mg-b-0 text-black">Pegawai</label>
	</div>
	<div class="col-md-9 mg-t-5 mg-md-t-0">
	<?php 
				$kd_organisasi=substr($kode_organisasi,4,2);
				
				?>
		<table id="tblPegawai" class="table table-striped table-bordered table-hover" style="width:100%">
			<thead>
				<th>Nama Pegawai</th>
				<th>Posisi</th>
				<th>#</th>
			</thead>
			<tbody id="tbody">
				
				<?php if($uuid){?>
					<?php 
					$get_emplyee=$this->db->get_where('ars_tr_uk_employee',array('uk_uuid'=>$uuid))->result();
					$x=0;
					foreach($get_emplyee as $em){
						$xi=$x++;
						$employee_uuid=$em->uuid??null;
						$employee_nip=$em->employee_nip??null;
						$posisi_type=$em->posisi_type??null;
						$getnama=$this->db->get_where('data_pegawai',array('nip'=>$employee_nip))->row();
						$employee_nama=$getnama->nama??'';
						$employee_bagian=$getnama->bagian??'';
						$empl_nama=$employee_nama.' ('.$employee_bagian.')';
						?>

					<tr id="R<?=$xi?>" >
						<td style="width:100px">
						<?php 
						$valray=array();
						$valray[""]="=== Pilih ===";
						$this->db->where('kode_biro',$kd_organisasi);
						$db = $this->db->get('data_pegawai')->result();
						foreach($db as $v)
						{
							$valray[$v->nip]=$v->nama." (".$v->bagian.")";
						}
						echo form_dropdown("nip_pegawai[]",$valray,$employee_nip,'class="form-control select2 pb-2" required');
						?>
						</td>
						<td style="width:100px">
						<?php 
						$valray=array();
						$valray[""]="=== Pilih ===";
						$db = $this->db->get('ars_tr_posisi_tipe')->result();
						foreach($db as $v)
						{
							$valray[$v->kode]=$v->nama;
						}
						echo form_dropdown("posisi[]",$valray,$posisi_type,'class="form-control select2 pb-2" required');
						?>
						</td>
						<td style="width:10px">
							<button type="button" dtuuid="<?=$employee_uuid?>" dtnama="<?=$empl_nama?>" class="font14 btn btn-sm ti-trash bg-danger remove"></button>
						</td>
					</tr>
					<?php }?>
				<?php }else{?>
				<tr id="R0">
					<td style="width:100px">
					<?php 
					$valray=array();
					$valray[""]="=== Pilih ===";
					$this->db->where('kode_biro',$kd_organisasi);
					$db = $this->db->get('data_pegawai')->result();
					foreach($db as $v)
					{
						$valray[$v->nip]=$v->nama." (".$v->bagian.")";
					}
					echo form_dropdown("nip_pegawai[]",$valray,'','class="form-control select2 pb-2" required');
					?>
					</td>
					<td style="width:100px">
					<?php 
					$valray=array();
					$valray[""]="=== Pilih ===";
					$db = $this->db->get('ars_tr_posisi_tipe')->result();
					foreach($db as $v)
					{
						$valray[$v->kode]=$v->nama;
					}
					echo form_dropdown("posisi[]",$valray,'','class="form-control select2 pb-2" required');
					?>
					</td>
					<td style="width:10px">
						<button type="button" class="font14 btn btn-sm ti-trash bg-danger remove"></button>
					</td>
				</tr>
				<?php }?>
			</tbody>
		</table>
		<button type="button" id="tambah_pegawai" class="font14 btn btn-sm ti-plus bg-success tx-white mg-t-0"> Tambah Pegawai</button>
	</div>
</div>

<script>
	function selectRefresh() {
		$('.select2').select2({
			dropdownParent: $('#form_isi'),
			tags: true,
			placeholder: "=== Pilih ===",
			allowClear: true,
			width: '100%'
		});
	}
	$(function() {
		selectRefresh();

		// Denotes total number of rows
		var rowIdx = 0;
		// jQuery button click event to add a row
		$('#tambah_pegawai').on('click', function () { 
			// Adding a row inside the tbody.
			$('#tbody').append(`
				<tr id="R${++rowIdx}">
					<td style="width:100px">
					<?php 
					$valray=array();
					$valray[""]="=== Pilih ===";
					$this->db->where('kode_biro',$kd_organisasi);
					$db = $this->db->get('data_pegawai')->result();
					foreach($db as $v)
					{
						$valray[$v->nip]=$v->nama." (".$v->bagian.")";
					}
					echo form_dropdown("nip_pegawai[]",$valray,'','class="form-control select2 pb-2" required');
					?>
					</td>
					<td style="width:100px">
					<?php 
					$valray=array();
					$valray[""]="=== Pilih ===";
					$db = $this->db->get('ars_tr_posisi_tipe')->result();
					foreach($db as $v)
					{
						$valray[$v->kode]=$v->nama;
					}
					echo form_dropdown("posisi[]",$valray,'','class="form-control select2 pb-2" required');
					?>
					</td>
					<td style="width:10px">
						<button type="button" class="font14 btn btn-sm ti-trash bg-danger remove"></button>
					</td>
				</tr>
				`);
				selectRefresh();
		});

		// jQuery button click event to remove a row.
		$('#tbody').on('click', '.remove', function () {
			
			var dtuuid = $(this).attr('dtuuid');
			var dtnama = $(this).attr('dtnama');
			
			if(dtuuid!=null){
				confirm("apakah data "+dtnama+" akan dihapus ?");
				var url   = "<?php echo site_url("ars_master/remove_employe_uk");?>";
				var param = {<?php echo $this->m_reff->tokenName()?>:token,id: dtuuid};
				$.ajax({
					type: "POST",dataType: "json",data: param, url: url,
					success: function(val){
						token=val['token'];
					}
				});
				
			}

			// Getting all the rows next to the row
			// containing the clicked button
			var child = $(this).closest('tr').nextAll();
			// Iterating across all the rows 
			// obtained to change the index
			child.each(function () {
			// Getting <tr> id.
			var id = $(this).attr('id');
			
			// Getting the <p> inside the .row-index class.
			var idx = $(this).children('.row-index').children('p');
			// Gets the row number from <tr> id.
			var dig = parseInt(id.substring(1));
			// Modifying row index.
			idx.html(`Row ${dig - 1}`);
			// Modifying row id.
			$(this).attr('id', `R${dig - 1}`);
		});

		// Removing the current row.
		$(this).closest('tr').remove();
			// Decreasing total number of rows by 1.
			rowIdx--;
		});
		
	});
</script>