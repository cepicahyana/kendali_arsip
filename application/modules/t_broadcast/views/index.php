 <div class="page-header">  </div>
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

    <div class="card">
        <div class="card-header">
            <div class="card-title"><h5>Data konten broadcast</h5>
			 <div class="float-right">
        			<button class="btn btn-success btn-sm " onclick="email()">
					<i class="fas fa-plus"></i>    konten email</button>
					
					<button class="btn btn-primary btn-sm  " onclick="wa()">
					<i class="fas fa-plus"></i>    konten whatsapp</button>
				</div>
				
        		</div> 
        </div>

        <div class="row card-body" style='padding-top:10px;padding-bottom:20px'>

        	<div class="col-md-12" id="area_lod">
        		
        		<table id='table' width="100%" class="tabel black table-striped table-bordered table-hover dataTable">
				  	<thead>
				  		<tr>
				  				<th class='thead'  width='15px'>&nbsp;NO</th>
									<th class='thead' width="100px" >Jenis pesan</th> 
									<th class='thead' >Subject</th> 
									<th class='thead' >Konten  </th> 
						 
									<th class='thead' width="150px">Edit | Hapus</th>
				  		</tr>	 
					</thead>
				</table>
        	</div>
        </div>

    </div>
</div>	
							
 
       
                <!-- #END# Task Info -->
				
 
  <script type="text/javascript">
  	  function hapus(id){
		  
swal({
						title: 'Hapus ?',
						text: "",
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
							swal("Berhasil dihapus", {
								icon: "success",
								buttons : {
									confirm : {
										className: 'btn btn-success'
									}
								}
							});
							
							   $.post("<?php echo site_url("t_broadcast/hapus"); ?>",{id:id},function(){
							   reload_table();
							  });
							
						}  
					});
					
	 
		 
		    
	  };
	  
	
	  
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
		 "responsive": false,
		 "searching": false,
		 "lengthMenu":
		 [[10 ,20,30,50], 
		 [10 ,20,30,50], ], 
	  dom: 'Blfrtip',
		buttons: [
           // 'copy', 'csv', 'excel', 'pdf', 'print'
			 
			 
					 
					 
        ],
        
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('t_broadcast/getData');?>",
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
function email()
{
			$.post("<?php echo site_url("t_broadcast/viewAddEmail"); ?>",{},function(data){
			 $("#mdl_modal_artikel").modal();
			 $("#viewAdd").html(data);
		      }); 
	 
}
</script>	
	
<script>
function wa()
{
			$.post("<?php echo site_url("t_broadcast/viewAddWa"); ?>",{},function(data){
			 $("#mdl_modal_artikel").modal();
			 $("#viewAdd").html(data);
		      }); 
	 
}
</script>

<script>
function edit(id,type)
{
			$.post("<?php echo site_url("t_broadcast/viewEdit"); ?>",{id:id,type:type},function(data){
			 $("#mdl_modal_artikel").modal();
			 $("#viewAdd").html(data);
		      }); 
	 
}
</script>
	 

	
 <div class="modal fade" id="mdl_modal_artikel" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" id="area_modal_artikel" role="document">
				
	<form  action="javascript:submitFormAkun('modal_artikel')" id="modal_artikel" url="<?php echo base_url()?>t_broadcast/insert_t_broadcast"   method="post" enctype="multipart/form-data">
                    <div class="modal-content">  
                        
                        <div class="modal-body">
                       	   <div id="viewAdd"></div>
 
                      

				</div>
				</div>
					 
       		
				</div>
				</form>
         </div><!-- /.modal-dialog -->
       
    
 