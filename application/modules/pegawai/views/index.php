 
 

<!-- breadcrumb -->
					<div class="breadcrumb-header justify-content-between">
						<div>
							 
						</div>
						


					</div>
					<!-- /breadcrumb -->

 <div class="col-md-12 row">
 <div class="col-md-3">
<select class="form-control testselect1 " style="width:100%" data-show-subtext="true">
                                        
                                            <option value="">=== Filter status covid === </option>
                                            <option value="positif">Positif covid</option>
                                            <option value="negatif">Negatif covid</option>
                                  
                                    </select>
</div>
						<div class="col-md-3">
<select class="form-control SlectBox" data-show-subtext="true">
                                        
                                            <option value="">=== Filter biro ===</option>
											<?php
											$data = $this->db->get("data_biro")->result();
											foreach($data as $val){
												echo "<option value='".$val->id."'>".$val->nama."</option>";
											}
											?>
                                           
                                    </select>
</div>
<div class="row col-md-12"><br/></div>
 </div>
    <div class="card">
         
        <div class="row card-body" style='padding-top:10px;padding-bottom:20px'>

        	<div class="col-md-12" id="area_lod">
        		
        		<table id='table' width="100%" class="tabel black table-striped table-bordered table-hover dataTable">
				  	<thead>
				  		<tr>
				  				<th class='thead'  width='15px'>&nbsp;NO</th>
									<th class='thead' >NAMA</th> 
									<th class='thead' >BIRO</th> 
									<th class='thead' ><center>STS COVID</center></th>	  
									<th class='thead' >ISOLASI</th>	  
									<th class='thead' >LAMA HARI </th>	  
				  		</tr>	 
					</thead>
				</table>
        	</div>
        </div>
 
</div>	
							
 
       
                <!-- #END# Task Info -->
				
 
  <script type="text/javascript">
  	   
      var save_method; //for save method string
    var table;
  var  dataTable = $('#table').DataTable({ 
		"paging": true,
        "processing": false, //Feature control the processing indicator.
		"language": {
					 "sSearch": "Pencarian",
					 "processing": ' <span class="sr-only dataTables_processing">Loading...</span> <br><b style="color:black;background:white">Proses menampilkan data<br> Mohon Menunggu..</b>',
						  "oPaginate": {
							"sFirst": "Hal Pertama",
							"sLast": "Hal Terakhir",
							 "sNext": "Selanjutnya",
							 "sPrevious": "Sebelumnya"
							 },
						"sInfo": "Total :  _TOTAL_ , Halaman (_START_ - _END_)",
						 "sInfoEmpty": "Tidak ada data yang di tampilkan",
						   "sZeroRecords": "Data tidak tersedia",
						  "lengthMenu": "Tampil _MENU_ Baris",  
				    },
					 
					 
        "serverSide": true, //Feature control DataTables' server-side processing mode.
		 "responsive": true,
		 "searching": true,
		 "lengthMenu":
		 [[10 ,20,30,50], 
		 [10 ,20,30,50], ], 
	  dom: 'Blfrtip',
		buttons: [
           // 'copy', 'csv', 'excel', 'pdf', 'print'
		   {
		text: ' Refresh  ',
                action: function ( e, dt, node, config ) {
                   reload_table();
                },className: 'btn  btn-secondary  '
                },
		{
			  text: ' Download Xl ',
                action: function ( e, dt, node, config ) {
                   download();
                },className: 'btn   btn-outline-success  '
                }, 
		{
			  text: 'Input ',
                action: function ( e, dt, node, config ) {
                   download();
                },className: 'btn   btn-outline-success  '
                }, 
		{
			  text: 'Import ',
                action: function ( e, dt, node, config ) {
                   download();
                },className: 'btn   btn-outline-success  '
                }, 
			 
					 
					 
        ],
        
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('pegawai/getData');?>",
            "type": "POST",
			"data": function ( data ) {
			   data.level =12;
		 },
		   beforeSend: function() {
               loading("area_lod");
            },
			complete: function() {
              unblock('area_lod');
            },
			
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
          "targets": [ 0,-1,-2,-3,-4,-5 ], //last column
          "orderable": false, //set not orderable
        },
        ],
	
      });
	function reload_table()
	{
		 dataTable.ajax.reload(null,false);	
	};
	 
	</script>
	
	
	
	
	
<script>
function add()
{
			$.post("<?php echo site_url("vicon/viewAdd_vicon"); ?>",{},function(data){
			 $("#mdl_modal_artikel").modal();
			 $("#viewAdd").html(data);
		      }); 
	 
}
</script>
	 

	
 <div class="modal fade" id="mdl_modal_artikel" tabindex="-1" role="dialog">
                <div class="modal-dialog" id="area_modal_artikel" role="document">
				
	<form  action="javascript:submitFormAkun('modal_artikel')" id="modal_artikel" url="<?php echo base_url()?>vicon/insert_vicon"   method="post" enctype="multipart/form-data">
                    <div class="modal-content">  
                        <div class="modal-header">  <h5 class="modal-titles" id="defaultModalLabel"><b>Tambah</b></h5>
						<button type="button" class="close" aria-label="Close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
						</button>
                          
							 
                        </div>
                        <div class="modal-body">
                       	   <div id="viewAdd"></div>
 
                       <div class="modal-footer">
						<span id="msg" class='pull-left'></span>
                            <div class="btn-group" role="group" aria-label="Default button group">
                                      
                                  <!--      <button  title="tutup"  data-dismiss="modal" class="btn bg-teal  waves-effect"><i class="material-icons">cancel</i> </button>
                                   -->      <button  id="submit" class="btn btn-primary waves-effect" onclick="submitFormAkun('modal_artikel')" ><i class="fa fa-save"></i> SIMPAN</button>
                                    </div>
                             
                        </div>

				</div>
				</div>
					 
       		
				</div>
				</form>
         </div><!-- /.modal-dialog -->
       
   
<script>
 
	 function edit(id)
	 {	 
		 		  
			 $.post("<?php echo site_url("vicon/viewEdit_vicon"); ?>",{id:id},function(data){
		 	   $("#editan").html(data);
			    $("#mdl_modal_edit").modal();
			}); 
	 }

	 function set(id,sts)
	 {	 
		 		  
			 $.post("<?php echo site_url("vicon/set_vicon"); ?>",{id:id,sts:sts},function(data){
		 	   reload_table();
			     
			}); 
	 }
   
</script>




 <div class="modal fade" id="mdl_modal_edit" tabindex="-1" role="dialog">
                <div class="modal-dialog" id="area_modal_edit" role="document">
				
	<form  action="javascript:submitFormAkun('modal_edit')" id="modal_edit" url="<?php echo base_url()?>vicon/update_vicon"  method="post" enctype="multipart/form-data">
                    <div class="modal-content">  
                         <div class="modal-header">  <h5 class="modal-titles" id="defaultModalLabel"><b>Edit </b></h5>
						<button type="button" class="close" aria-label="Close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
						</button>
                          
							 
                        </div>
                        <div class="modal-body">
                       	  
					   	 <div id="editan"></div>
							 
 
                       <div class="modal-footer">
						<span id="msg" class='pull-left'></span>
                            <div class="btn-group" role="group" aria-label="Default button group">
                                      
                               <!--         <button  title="tutup"  data-dismiss="modal" class="btn bg-teal  waves-effect"><i class="material-icons">cancel</i> </button>
                                -->         <button  id="submit" class="btn btn-primary btn-sm waves-effect" onclick="submitFormAkun('modal_edit')" ><i class="fa fa-save"></i> SIMPAN</button>
                                    </div>
                             
                        </div>

				</div>
				</div>
					 
       		
				</div>
				</form>
   </div><!-- /.modal-dialog --> 



    
 <script>
	 
     $( document ).ready(function() {
	window.asd = $('.SlectBox').SumoSelect({ csvDispCount: 3, selectAll:true, captionFormatAllSelected: "Yeah, OK, so everything." });
	window.Search = $('.search-box').SumoSelect({ csvDispCount: 3, search: true, searchText:'Enter here.' });
	window.sb = $('.SlectBox-grp-src').SumoSelect({ csvDispCount: 3, search: true, searchText:'Enter here.', selectAll:true });
	$('.testselect1').SumoSelect();
	$('.testselect2').SumoSelect();
	$('.selectsum1').SumoSelect({ okCancelInMulti: true, selectAll: true });
	$('.selectsum2').SumoSelect({ selectAll: true });
	
});
	  </script>
	
		 



 
	
 
						
						
						
						
						
						
						
 