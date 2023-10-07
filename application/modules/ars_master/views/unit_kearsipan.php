<div class="card">         
	<div class="row card-body" style='padding-top:10px;padding-bottom:20px'>
		<div class="col-md-12" id="area_lod">

			<table id='table' width="100%" class="tabel black table-striped table-bordered table-hover dataTable">
				<thead>
					<tr>
						<th class='thead'  width='15px'>NO</th>
						<th class='thead' width='100px'>UNIT KEARSIPAN </th> 
						<th class='thead' width='100px'>PARENT UK </th>   
						<th class='thead' >DESKRIPSI </th>  
						<th class='thead' >ORGANISASI </th>  
						<th class='thead' width='110px' >JUMLAH PEGAWAI </th>  
						<th class='thead' >STATUS </th>  
						<th class='thead' width='170px' ># </th>	  
					</tr>	 
				</thead>
			</table>
			
		</div>
	</div>
</div>	
						

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

				var url   = "<?php echo site_url("ars_master/hapus_unit_kearsipan");?>";
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

	

      var save_method; //for save method string
      var table;
      var  dataTable = $('#table').DataTable({ 
      	"paging": true,
        "processing": false, 
        "ordering":false,
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
        	"lengthMenu": "&nbsp;&nbsp;Tampil _MENU_ Baris",  
        },
        "serverSide": true, 
        "responsive": true,
        "searching": true,
        "lengthMenu":
        [[10 ,20,30,50], 
        [10 ,20,30,50], ], 
        dom: 'Blfrtip',
        buttons: [
			{
				text: '<i class="fe fe-refresh-cw"></i>',
				action: function ( e, dt, node, config ) {
					reload_table();
				},className: 'btn  btn-secondary-light'
			},
			{
				text: '<i class="fe fe-download"></i>',
				action: function ( e, dt, node, config ) {
					downloadXL();
				},className: 'btn  btn-secondary-light'
			},
			{
				text: '<i class="fe fe-plus"></i> Tambah ',
				action: function ( e, dt, node, config ) {
					action_form();
				},className: 'btn  btn-secondary-light'
			}, 
        ],
        
        "ajax": {
        	"url": "<?php echo site_url('ars_master/getData_unitKearsipan');?>",
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
        "columnDefs": [
        { 
          "targets": [  ], //last column
          "orderable": false, //set not orderable
        },
        ],
      });
      function reload_table()
      {
      	dataTable.ajax.reload(null,false);	
      };

    

       

      function action_form(id=null)
      {	 
			var url = "<?= site_url('ars_master/form_unit_kearsipan')?>";
			var title = $(this).attr("title");
			var session = "1";
			$("a").removeClass('active');
			$(this).addClass('active').siblings().removeClass('active');
			$(".content").html('<center><div style="height:100%"> <button class="btn btn-dark" type="button" disabled=""> <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading... </button></div></center>');
            $.ajax({
            type: "POST",
            dataType: "json",
            data: {ajax:"yes",<?php echo $this->m_reff->tokenName()?>:token,id:id},
            url: url,
            success: function(data){
                token=data["token"];
                $('.modal.aside').remove();
                history.replaceState(title, title, url);
                $('#bread_title').html(data["title"]);
                $('#bread_subtitle').html(data["subtitle"]);
                $(".content").html(data["data"]);
                }
            });
      }

	  function downloadXL()
	{	
		// var f1 = $('#f1').val();
		var s = $('.whatever').val();		
		window.open(
		  "<?php echo base_url()?>ars_master/downloadXL_unit_kearsipan/?s="+s,
		  '_blank' // <- This is what makes it open in a new window.
		);
	}
    </script>



 

  <!-- <div class="modal effect-scale" id="mdl_modal" >
			<div class="modal-dialog modal-xl modal-dialog-centered" role="document">
				<div class="modal-content modal-content-demo" id="area_modal">
					<div class="modal-header">
						<h6 class="modal-title"> </h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
					</div>
					
				<div id="response"></div>
				</div>
			</div>
		</div> -->