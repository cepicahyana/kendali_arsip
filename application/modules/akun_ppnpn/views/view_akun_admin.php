<div class="card" id="area_lod">
    <div class="card-body">
        <div class="col-md-12 table-responsive">
            <table id="table" class="tablecool   table-sm" style="width:100%">
                <thead>
                    <th width="30px">NO</th>
                    <th>Nama </th>
                    <th>NIP </th>
                    <th>Jenis Kelamin</th>
                    <!-- <th>Istana</th> -->
                    <!-- <th>Biro</th> -->
                    <!-- <th>Alamat</th> -->
                    <th>No.Telp</th>
                    <th>Email</th>
                   
                    <th>#</th>
                </thead>
            </table>
        </div>
        </div>
</div>

<script>
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
            {
 				text: ' Refresh ',
 				action: function(e, dt, node, config) {
 					reload_table();
 				},
 				className: '  font14 btn btn-sm btn-light ti-reload  '
 			},
			{
 				text: ' Tambah ',
 				action: function(e, dt, node, config) {
 					add();
 				},
 				className: '  font14 btn btn-sm ti-plus bg-teal  '
 			},
        ],
        
        // Load data for the table's content from an Ajax source
        "ajax": {
        	"url": "<?php echo site_url('akun_ppnpn/get_data_admin');?>",
        	"type": "POST",
        	"data": function ( data ) {
        		data.<?php echo $this->m_reff->tokenName()?>=token;
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
        "columnDefs": [
        { 
          "targets": [ 0,-1,-2,-3, -4, -5], //last column
          "orderable": false, //set not orderable
        },
        ],
        
      });
      function reload_table()
      {
      	dataTable.ajax.reload(null,false);	
      };


    function add()
    {
        var url   = "<?php echo site_url("akun_ppnpn/add_akun_admin");?>";
        var param = {<?php echo $this->m_reff->tokenName()?>:token};
        $.ajax({
            type: "POST",dataType: "json",data: param, url: url,
            success: function(val){
                $("#mdl_formSubmit").modal();
                $("#mdlValue").html(val['data']);
                token=val['token'];
            }
        });   
    }

    function edit(id)
    {	 
        var url   = "<?php echo site_url("akun_ppnpn/view_edit_akun_admin");?>";
        var param = {<?php echo $this->m_reff->tokenName()?>:token,id:id};
        $.ajax({
            type: "POST",dataType: "json",data: param, url: url,
            success: function(val){
                $("#mdl_formSubmit").modal();
                $("#mdlValue").html(val['data']);
                token=val['token'];
            }
        }); 
    }

    function hapus(id, nama) {
 		alertify.confirm("<center> Hapus  <br>" + nama + " ?</center>", function() {
            var url   = "<?php echo site_url("akun_ppnpn/hapus_akun_admin");?>";
            var param = {<?php echo $this->m_reff->tokenName()?>:token,id:id};
            $.ajax({
                type: "POST",dataType: "json",data: param, url: url,
                success: function(val){
                    token=val['token'];
                    notif("Berhasil dihapus!", "Info", "success");
                    reload_table();
                }
            });
 		});
 	}
</script>

<div class="modal  fade" id="mdl_formSubmit" tabindex="-9991" style="z-index:1199" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
 	<div id="mdl_size" class="modal-dialog modal-md" role="document">
 		<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
 			<div class="modal-content">
 				<div class="modal-body">
 					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
 						<span aria-hidden="true">&times;</span>
 					</button>
 					<div id="mdlValue">
					 </div>
 				</div>
 			</div>
 		</div>
 	</div>
 </div>