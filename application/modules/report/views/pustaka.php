 


<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
	<div>
		<h4 class="content-title mb-2">Daftar pustaka</h4>
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">File pustaka</a></li>
				<!-- <li class="breadcrumb-item active" aria-current="page"></li> -->
			</ol>
		</nav>
	</div>
</div>

<div class="card">
	
	<div class="row card-body" style='padding-top:10px;padding-bottom:20px'>

		<div class="col-md-12" id="area_lod">
			
        <table id="tablez" class="table table-bordered table-striped">
				<thead>
					<tr>
					 
						<th class='thead' width="20px">No </th> 
						<th class='thead' >Nama file</th>   
						<th class='thead' >Keterangan</th>   
						<th class='thead' >File</th>   
						<th class='thead' >Edit | Hapus </th>	  
					</tr>	 
				</thead>
			</table>
		</div>
	</div>
	
</div>	



<!-- #END# Task Info -->


<script type="text/javascript">
	function hapus(id,akun){
		
		swal({
			title: 'Hapus ?',
			text: akun,
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
				swal("data "+akun+" telah dihapus", {
					icon: "success",
					buttons : {
						confirm : {
							className: 'btn btn-success'
						}
					}
				});
				
				var url   = "<?php echo site_url("report/hapus_pustaka");?>";
				 
				var param = {<?php echo $this->m_reff->tokenName()?>:token,id:id};
				$.ajax({
					type: "POST",dataType: "json",data: param, url: url,
					success: function(val){
						token=val['token'];
						reload_table();
					}
				});	
				
			}  
		});
		
		
		
		
	};
	
	</script>

	<script>
      
	  
    var save_method; //for save method string
    var table;
    var  dataTable = $('#tablez').DataTable({
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
		"searching": true,
		"ordering": false,
		"lengthMenu":
		[
			[10, 20, 30,40, 50,100,99999999],
	 		[10, 20, 30,40, 50,100,"All"],
	 	],
        dom: 'Blfrtip',
		// Buttons with Dropdown
		 
		buttons: [
		
				    //   'copy', 'csv', 'excel', 'pdf', 'print',
			 
			{
 				text: '',
 				action: function(e, dt, node, config) {
 					reload_table();
 				},
 				className: 'btn btn-light ti-reload '
 			},
			 
 			{
 				text: ' Tambah Data ',
 				action: function(e, dt, node, config) {
 					add();
 				},
 				className: 'btn btn-success '
 			},

		],
        
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo base_url()?>report/getDataPustaka",
            "type": "POST",
            "data": function ( data ) {
            	// data.istana = $('[name="istana"]').val();
            	// data.instansi = $('[name="instansi"]').val();
            	// data.biro = $('[name="biro"]').val();
            	// data.jenis_pegawai = 1;
				// data.filter = true;
                data.ci_csrf_token=token;
            },
            beforeSend: function() {
                loading("area_lod");
            },
            complete: function(data) {
                token=data.responseJSON.token;
                unblock('area_lod');
            },
        },

        //Set column definition initialisation properties.
        /*"columnDefs": [
            {
                "targets": [ 0,-1], //last column
                "orderable": false, //set not orderable
            },
        ],*/
        
    });


      function reload_table()
      {
      	dataTable.ajax.reload(null,false);	
      };
      
    </script>
    
    
    
    
    
    <script>
     function add()
     {
	 
      var url   = "<?php echo site_url("report/viewAdd_pustaka");?>";
      var param = {<?php echo $this->m_reff->tokenName()?>:token};
      $.ajax({
       type: "POST",dataType: "json",data: param, url: url,
       success: function(val){
        $("#mdl_modal").modal();
        $("#editan").html(val['data']);
        token=val['token'];
      }
    });		
    }

    function edit(id)
    {	 
	 
      var url   = "<?php echo site_url("report/viewEdit_pustaka");?>";
      var param = {<?php echo $this->m_reff->tokenName()?>:token,id:id};
      $.ajax({
       type: "POST",dataType: "json",data: param, url: url,
       success: function(val){
        $("#mdl_modal").modal();
        $("#editan").html(val['data']);
        token=val['token'];
      }
    });	
    }
    
  </script>




  <div class="modal effect-super-scaled" id="mdl_modal" tabindex="-1" role="dialog">
  	<div class="modal-dialog" id="area_modal_edit" role="document">
  		<div id="editan"></div>
  	</div>
  </form>
</div><!-- /.modal-dialog --> 














