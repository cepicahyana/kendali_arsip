<?php
$kodeE	=	$kode;
$kode	=	$this->m_reff->decrypt($kode);
$this->db->where("kode",$kode);
$cek=$this->db->get("data_acara");
if(!$cek->num_rows() or $kode==false){
	echo $this->m_reff->page403(); return false;
}
?>










<?php 
  $data		=	$cek->row();
  $kode		=	isset($data->kode)?($data->kode):"";
  
  $agenda	=	isset($data->agenda)?($data->agenda):"";
  $tgl		=	isset($data->tgl)?($data->tgl):"";
  $jam		=	isset($data->jam)?($data->jam):"";
  $vicon	=	isset($data->sts_vicon)?($data->sts_vicon):0;
  if($vicon==0){
	  	echo  "<h1>Halaman belum dapat diakses! </h1>"; return false;
  }
  $date		=	$tgl." ".$jam;
  $id_acara	=	isset($data->id_acara)?($data->id_acara):"";
				
					$this->db->where("hapus",0); 
 $datapeserta	=	$this->db->get("data_peserta");
 $v				=	$datapeserta->result();
?>
<!DOCTYPE html>
<html lang="en">
 <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<!-- Mirrored from ableproadmin.com/bootstrap/default/layout-horizontal-2.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 03 Mar 2020 17:14:21 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
    <title>PANDU</title>
    
     
    <link rel="icon" href="<?php echo base_url();?>plug/img/logom.png" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>plug/css/add.css"/>
 
    <!-- vendor css -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css">
    <script src="<?php echo base_url();?>assets/js/vendor-all.min.js"></script>
     <script src="<?php echo base_url();?>plug/jquery/jquery.min.js"></script>
 
 
	 <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>plug/datatables/css.css"/>
	<script type="text/javascript" src="<?php echo base_url();?>plug/datatables/font.js"></script> 
	<script type="text/javascript" src="<?php echo base_url();?>plug/datatables/datatable.js"></script>
<style>
 #body{
margin-top:-50px;
background-image:url('../../plug/img/ground.jpg');
background-size:cover;
background-repeat: no-repeat;
background-position: top; 
background-attachment: fixed;
}
</style>
</head>

<body style="background-color:white" >
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->
    <!-- [ navigation menu ] start -->
    <span class="pcoded-navbar theme-horizontal menu-light brand-blue" style="display:none">
        
    </span>
    <!-- [ navigation menu ] end -->
    <!-- [ Header ] start -->
   
    <!-- [ Header ] end -->
 
    <!-- [ Main Content ] start -->
    <div class="pcoded-main-container" style="margin-top:-20px;" id="body">
        <div class="pcoded-wrapper container">
            <div class="pcoded-content" >
                <div class="pcoded-inner-content">
                    <div class="main-body">
				
                        <div class="page-wrapper" >
                            <div class="page-header"  >
                                <div class="page-block">
                                    <div class="row align-items-center" >
                                         <br> 
                                    </div>
                                </div>
                            </div><br>
                        <!-- <h5 class="text-primary"><i class="fa fa-bookmark"></i> Konfirmasi Kehadiran</h5>--->
                           
						</div>
	 <div class="row">	
		<h4 style="margin-left:20px;color:black" class='  feather icon-home'> <?php echo strip_tags($agenda);?></h4>
		</div>	 
	 <div class="row">			
				 
			 <div class="col-xl-4 col-md-6">
                <div class="card"   >
                    <div class="card-body">
                        <div class="row align-items-center m-l-0">
                            <div class="col-auto">
                                <i class="icon feather icon-users f-30 text-c-purple"></i>
                            </div>
                            <div class="col-auto">
                                <h6 class="text-muted m-b-10">TOTAL UNDANGAN VICON</h6>
                                <h2 class="m-b-0" id="all">....</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div><div class="col-xl-4 col-md-6">
                <div class="card "  >
                    <div class="card-body">
                        <div class="row align-items-center m-l-0">
                            <div class="col-auto">
                                <i class="icon feather icon-user-check f-30 text-c-purple"></i>
                            </div>
                            <div class="col-auto">
                                <h6 class="text-muted m-b-10">TELAH JOIN</h6>
                                <h2 class="m-b-0" id="hadir">....</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div><div class="col-xl-4 col-md-6">
                <div class="card"  >
                    <div class="card-body">
                        <div class="row align-items-center m-l-0">
                            <div class="col-auto">
                                <i class="icon feather icon-pie-chart f-30 text-c-purple"></i>
                            </div>
                            <div class="col-auto">
                                <h6 class="text-muted m-b-10">PERSENTASE KEHADIRAN</h6>
                                <h2 class="m-b-0" id="persen">....</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                  
					<div class="col-sm-12">
                      <div class="card card-body"    >
							<div class="col-md-12 " id="rekapRoom"></div>
						</div> 
					</div> 
				   
                            <div class="col-md-12">
                                 
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input onclick='reload_table()' type="radio" id="customRadioInline1" name="status" value='1' class="custom-control-input">
                                    <label class="custom-control-label" for="customRadioInline1">Telah join</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input onclick='reload_table()' type="radio" id="customRadioInline2" name="status" value='2' class="custom-control-input">
                                    <label class="custom-control-label" for="customRadioInline2">Belum join</label>
                                </div>
								<div class="custom-control custom-radio custom-control-inline">
                                    <input onclick='reload_table()' type="radio" id="customRadioInline3" checked name="status" value='3' class="custom-control-input">
                                    <label class="custom-control-label" for="customRadioInline3">Tampilkan Semua</label>
                                </div>
                            </div>
                                <!--  style="background-image:url(<?php echo base_url()."/plug/img/istana1.png"?>)" -->
                                <div class="col-sm-12">
                                    <div class="card"    >
                                        
                                        <div class="card-body"> 
                                            <div   role="alert" >
                                             
											
                                            </div> 
			 <table id="table" class="table table-bordered table-hover " >
			<thead  >
			<th width="20px">NO</th>
			<th>NAMA</th>
			<th>INSTANSI</th>
			<th>STATUS  </th>
			<th><center>CHECKIN </center> </th>
			</thead>			 
			</table>								 
											
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- [ horizontal-layout ] end -->
                            </div>
                                         
              <?php
			  if($id_acara==1){?>
                                    <div class="card"    >
                                        
                                        <div class="card-body"> 
                                            <div   role="alert" >
                                             
											<h6><button onclick="add()" class='dt-button ui-button ui-state-default ui-button-text-only btn btn-light btn-sm btn-table 
											dt-padding-right has-ripple fa fa-plus'> Hasil rakor</button></h6>
                                            </div> 
			 <table id="table" class="table table-bordered table-hover " >
			<thead  >
			<th width="20px">NO</th>
			<th>Nama file</th>
			<th>Download</th>
			<th>Edit | Hapus  </th> 
			</thead>	
			<?php
			$datafile = $this->mdl->getFileRakor($kode);
			$baseurl = $this->m_reff->pengaturan(1);
			$no		  = 1;
			foreach($datafile as $val){
			   $file	= $val->file;
				echo "<tr>
				<td>".$no."</td>
				<td>".$val->nama."</td>
				<td><a   class='feather icon-link'  
				 target='_blank' href='".$baseurl."/download?f=".$this->m_reff->encrypt($file)."'> Download </a> </td>
				<td>
				<span class='btn-groups'>
				<button class='btn btn-sm btn-secondary' onclick='edit(`".$val->id."`)'>Edit</button>
				<button  class='btn btn-sm  btn-danger' onclick='delete_file(`".$val->id."`)'> Hapus </button>
				</span>
				</td>
				</tr>";
			}
			?>
			</table>								 
											
                                        </div>
                                        </div>
			  <?php } ?>                         
			
			
						   <div class='alert alert-info'> Data otomatis diperbaharui setiap 30 detik.</div>
                                </div>
                            </div>
                            <!-- [ Main Content ] end -->
							 <center>
<span style='color:white'><i class='feather icon-bookmark'></i><?php echo $data->kode;?></span>
							 <div style='color:white;font-size:12px;line-height:15px; '><?php echo $this->m_reff->pengaturan(7);?></div></center>
							  <br>
			<br>
			<br>
			<br>
			<br>
                        </div>
                    </div>
                </div>
            </div>
			
     
	
<script type="text/javascript"> 

setInterval(function(){ reload_table(); }, 30000);

var status;
function getStatus()
{
	 var radios = document.getElementsByName('status');
	for (var i = 0, length = radios.length; i < length; i++) {
	  if (radios[i].checked) { 
		return (radios[i].value); 
		 
	  }
	}
}


      var save_method; //for save method string
    var table;
  var  dataTable = $('#table').DataTable({ 
		///scrollX: 103,
        "fixedHeader": true,
		"paging": true,
        "processing": false, //Feature control the processing indicator.
		"language": {
					 "sSearch": "search",
					 "processing": ' <span class="sr-only dataTables_processing">Loading...</span> <br><b style="color:black;background:white">Proses menampilkan data<br> Mohon Menunggu..</b>',
						  "oPaginate": {
							"sFirst": "Hal Pertama",
							"sLast": "Hal Terakhir",
							 "sNext": ">>",
							 "sPrevious": "<<"
							 },
						"sInfo": "Total :  _TOTAL_ , Page (_PAGE_)",
						 "sInfoEmpty": " ",
						   "sZeroRecords": "Data tidak tersedia",
						  "lengthMenu": "  _MENU_ Baris",  
				    },
					 
					 
        "serverSide": true, //Feature control DataTables' server-side processing mode.
		 "responsive": false,
		 "searching": true,
		 "lengthMenu":
		 [[ 10 ,20,30,40,50,100,200,100000], 
		 [ 10 ,20,30,40,50,100,200,"All"], ], 
	  dom: 'Blfrtip',
		buttons: [
           // 'copy', 'csv', 'excel', 'pdf', 'print'
			 
			  {
			  text: '<span class="feather icon-refresh-cw"></span> Perbaharui   ',
                action: function ( e, dt, node, config ) {
                   reload_table();
                },className: 'btn btn-light btn-sm  btn-table dt-padding-right'
                }, 
  ],
        
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo base_url()?>welcome/getDataAcara",
            "type": "POST",
			"data": function ( data ) {
			 data.status= getStatus();
			 data.kode= "<?php echo $kodeE?>";
			 data.j_kehadiran= "2";
			 data.sts_vicon= "<?php echo $vicon;?>";
		 },
		   beforeSend: function() {
             //  loading("area_lod");
            },
			complete: function() {
            //  unblock('area_lod');
            },
			
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
          "targets": [ 0 ], //last column
          "orderable": false, //set not orderable
        },
			<?php	if($id_acara!=1){?>	  { 'visible': false, 'targets': [2] } <?php } ?>
        ],
	
      });
	  
	function reload_table()
	{
		 dataTable.ajax.reload(null,false);	
		 updateRekap();
		 updateRekapRoom();
	};
 
	</script>
	
	
	
	<script>
	function updateRekap()
	 {	   
	 var kode="<?php echo $kodeE;?>";
	 $.ajax({
		 url:"<?php echo base_url()?>welcome/updateViconRekap",
		 data: {kode:kode},
		 method:"POST",
		 dataType:"JSON",
		 beforeSend: function() {
             //  loading("area_"+id);
            },
		 success: function(data)
			{ 	
				$("#hadir").html(data.hadir);
				$("#all").html(data.all);
				$("#persen").html(data.persen);
			}})
	 } 
	</script>
	
	<script>
	function updateRekapRoom()
	 {	   
	 var kode="<?php echo $kodeE;?>";
	 var vicon="<?php echo $vicon;?>";
	 $.ajax ({
		 url:"<?php echo base_url()?>welcome/updateRekapRoom",
		 data: {kode:kode,vicon:vicon},
		 method:"POST", 
		 beforeSend: function() {
             //  loading("area_"+id);
            },
		 success: function(data)
			{ 	
				$("#rekapRoom").html(data);
				 
			}})
	 } 
	</script>
	
	
	
	
	<script>
	 function add()
	 {	   $("#mdl_formSubmit").modal();
		 		     $("#peserta").html(cantik());
			 var kode = "<?php echo $kode;?>";
			 $.post("<?php echo site_url("welcome/add_bahan_rakor"); ?>",{kode:kode},function(data){
		 	   $("#editan").html(data);
		 	  
			}); 
	 }  
	</script>
	
	<script>
	 function edit(id)
	 {	   			$("#mdl_formSubmit").modal();
		 		     $("#peserta").html(cantik());
			 var kode = "<?php echo $kode;?>";
			 $.post("<?php echo site_url("welcome/edit_bahan_rakor"); ?>",{id:id,kode:kode},function(data){
		 	   $("#editan").html(data);
		 	  
			}); 
	 }  
	</script>
	
						
<!-- Modal -->
<div class="modal fade " id="mdl_formSubmit" tabindex="-9991" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
 
   <div class="modal-dialog   modal-lg" role="document" >
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
					<div id="editan"></div> 
                </div>
                
            </div>
        </div>
    </div>
</div>

	
	
	
	
	 
	
        <!-- Required Js -->
        
        <script src="<?php echo base_url();?>assets/js/plugins/bootstrap.min.js"></script>
        <script src="<?php echo base_url();?>assets/js/ripple.js"></script>
        <script src="<?php echo base_url();?>assets/js/pcoded.min.js"></script>
    	 <script src="<?php echo base_url();?>assets/js/plugins/sweetalert.min.js"></script>
 


    <script src="<?php echo base_url();?>assets/js/horizontal-menu.js"></script>
    <script>
        setTimeout(function(){ updateRekapRoom() }, 1000);
		
        $(document).ready(function() {
			updateRekap();
            $("#pcoded").pcodedmenu({
                themelayout: 'horizontal',
                MenuTrigger: 'hover',
                SubMenuTrigger: 'hover',
            });
        });
    </script>

   <script>
        function cantik()
  {
    return '<center><div class="card-body" id="loadingKontak"> Loading....<br><div class="spinner-grow text-primary" role="status"><span class="sr-only">Loading...</span></div><div class="spinner-grow text-secondary" role="status"><span class="sr-only">Loading...</span></div><div class="spinner-grow text-success" role="status"><span class="sr-only">Loading...</span></div><div class="spinner-grow text-danger" role="status"><span class="sr-only">Loading...</span></div><div class="spinner-grow text-warning" role="status"><span class="sr-only">Loading...</span></div><div class="spinner-grow text-info" role="status"><span class="sr-only">Loading...</span></div><div class="spinner-grow text-light" role="status"><span class="sr-only">Loading...</span></div><div class="spinner-grow text-dark" role="status"><span class="sr-only">Loading...</span></div></div></center>';
  }






	  function delete_file(id)
	 {	
	 var kode	=	"<?php echo $kode;?>";
	 
		   swal({
                title: "Hapus ?",
				text:"",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
				  
			    $.post("<?php echo site_url("welcome/hapus_file"); ?>",{id:id,kode:kode},function(data){
		  
				window.location.href="";
			});  
			
			
                    swal("Terimakasih!", {
						title:"Mohon tunggu....",
						text:"sistem sedang memproses...",
                        icon: "success",
                    });
				  
                } else {
                    return false;
                }
            });
	 }
	 











 </script>



</body>


 </html>
