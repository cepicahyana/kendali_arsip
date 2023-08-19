<?php
 $nama_lengkap = isset($data->nama_lengkap)?($data->nama_lengkap):"";
 $jenis_pegawai = isset($data->jenis_pegawai)?($data->jenis_pegawai):"";

 if($jenis_pegawai==2){
     echo "<style>.hide{ display:none;visibility:hidden}</style>";
 }
 ?>

<div class="row row-sm">
   <div class="col-lg-4">
      <div class="cards mg-b-20">
         <div class="card-body">
            <div class="pl-0">
               <div class="main-profile-overview">
               <div class="float-right btn-group">
                <a target="_blank" href="<?php echo base_url()?>cek_data/cetak_pdf?nip=<?= isset($data->nip)?($data->nip):"";?>" class="btn btn-sm btn-icon btn-outline-success float-right" title="download pdf"> <i class="fa fa-file-pdf"></i>  </a>
                <div class="input-group-prepend">
                                 <button style="width:50px" class="btn btn-sm btn-icon btn-outline-success float-right dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="edit">&nbsp;<i class="fa fa-user-edit"></i>&nbsp;</button>
                                 <div class="dropdown-menu">
                                     <a class="dropdown-item" href="#" onclick="formEdit('a')"><i class="fa fa-user"></i> Data Personal</a>
                                     <a class="dropdown-item" href="#" onclick="formEdit('b')"><i class="fa fa-user-tie"></i> Data Kepegawaian</a>
                                     <a class="dropdown-item" href="#" onclick="formEdit('c')"><i class="fa fa-fa fa-users"></i> Keluarga</a>
                                     <a class="dropdown-item" href="#" onclick="formEdit('d')"><i class="fa fa-home"></i>  Domisili</a>
                                  
                                     <a class="hide dropdown-item" href="#" onclick="formEdit('e')"><i class="fab fa-black-tie"></i> Golongan</a>
                                     <a class="hide dropdown-item" href="#" onclick="formEdit('f')"><i class="fa fa-crown"></i> Jabatan</a>
                                     <a class="hide dropdown-item" href="#" onclick="formEdit('g')"><i class="fa fa-chess-bishop"></i> Penugasan</a>
                                     <a class="dropdown-item" href="#" onclick="formEdit('h')"><i class="fa fa-user-graduate"></i> Pendidikan</a>
                                     <a class="dropdown-item" href="#" onclick="formEdit('o')"><i class="fa fa-user-graduate"></i> Keminatan</a>
                                     <a class="dropdown-item" href="#" onclick="formEdit('p')"><i class="fa fa-user-graduate"></i> Pelatihan</a>
                                     <a class="dropdown-item" href="#" onclick="formEdit('i')"><i class="fa fa-award"></i> Penghargaan</a>
                                     <a class="dropdown-item" href="#" onclick="formEdit('j')"><i class="fa fa-chart-bar"></i> Kinerja</a>
                                     <a class="hide dropdown-item" href="#" onclick="formEdit('m')"> <i class="fa fa-balance-scale"></i> Hukuman</a>
                                     <a class="dropdown-item" href="#" onclick="formEdit('k')"> <i class="fa fa-diagnoses"></i> Riwayat Medis</a>
                                     <a class="dropdown-item" href="#" onclick="formEdit('n')"><i class="fa fa-syringe"></i> Riwayat Vaksinasi</a>
                                     <a class="hide dropdown-item" href="#" onclick="formEdit('l')"><i class="fa fa-donate"></i> Gaji</a>
                                    
                                 </div>
                             </div> <button class="btn btn-sm btn-icon btn-outline-success float-right" title="sinkron" onclick="syncron(`<?=$data->nip;?>`,`<?=$data->nama_lengkap;?>`)"> <i class="fa fa-sync-alt"></i> </button>
                            </div>
                  <div class="main-img-user profile-user">
                      <?php
                
                      if($data->jenis_pegawai==1){ //jika pegawai ASN foto dr link
                        $img = $data->foto;
                        if($img){
                          echo '<img alt="'.$img.'"  src="'.$img.'"> ';
                        }else{
                          echo '<img alt="foto profile" src="'.base_url().'assets/'.$data->jk.'.png"> ';
                        }

                      }else{
                            $img = $data->foto; //foto dr upload path
                          if($img){
                               $img = $this->m_reff->pengaturan(1).$img;
                            echo '<img alt="'.$img.'" src="'.$this->konversi->img($img).'"> ';
                          }else{
                            echo '<img alt="foto profile" src="'.base_url().'assets/'.$data->jk.'.png"> ';
                          }
                        
                      }?>
                  

                </div>
                <br>   <b class='badge sadow badge-info float-right'> <?php echo $this->m_reff->jenis_pegawai($data->jenis_pegawai)?></b>
                 
                  <div class="d-flex justify-content-between mg-b-20">
                     <div>
                        <h5 class="  main-profile-name"><?= $nama_lengkap; ?></h5>
                        <p class="main-profile-name-text"><?= $data->jabatan;?></p>
                     </div>
                  </div>
               
                   <!-- main-profile-bio --> 
                   <table width="100%" class="tabel entry2">
                          <tr>
                              <td width="150px">Nama </td>
                              <td><?=$data->nama;?></td>
                          </tr>
                          <tr>
                              <td>Jenis kelamin</td>
                              <td><?=$this->m_reff->jk($data->jk);?></td>
                          </tr>
                          <tr>
                              <td>Tempat,Tgl Lahir</td>
                              <td><?=UCWORDS($data->tempat_lahir);?>, <?php echo $this->tanggal->ind($data->tgl_lahir,"/");?></td>
                          </tr>
                          <tr>
                              <td>NIK</td>
                              <td><?=$data->nik;?></td>
                          </tr>
                          <tr>
                              <td>Gol. Darah</td>
                              <td><?=$data->id_goldar;?></td>
                          </tr>
                          <tr>
                              <td>Nomor BPJS</td>
                              <td><?=$data->bpjs;?></td>
                          </tr>
                          <tr>
                              <td>Alamat sesuai KTP</td>
                              <td><?php
                                 if($data->ktp_prov){
                                    echo "Provinsi ".$this->m_reff->provinsi($data->ktp_prov);
                                }
                                if($data->ktp_kab){
                                    echo "<br>".ucwords(strtolower($this->m_reff->kabupaten($data->ktp_kab)));
                                }
                                if($data->ktp_kec){
                                    echo "<br>Kecamatan ".$this->m_reff->kecamatan($data->ktp_kec);
                                }
                                if($data->ktp_kel){
                                    echo "<br>Kelurahan ".$this->m_reff->kelurahan($data->ktp_kel);
                                }
                                if($data->ktp_alamat){
                                    echo "<br>".$data->ktp_alamat;
                                } 
                              ?></td>
                          </tr>
                          <tr>
                              <td>Alamat Domisili</td>
                              <td><?php
                                if($data->id_prov){
                                    echo "Provinsi ".$this->m_reff->provinsi($data->id_prov);
                                }
                                if($data->id_kab){
                                    echo "<br>".ucwords(strtolower($this->m_reff->kabupaten($data->id_kab)));
                                }
                                if($data->id_kec){
                                    echo "<br>Kecamatan ".$this->m_reff->kecamatan($data->id_kec);
                                }
                                if($data->id_kel){
                                    echo "<br>Kelurahan ".$this->m_reff->kelurahan($data->id_kel);
                                }
                                if($data->alamat){
                                    echo "<br>".$data->alamat;
                                } 
                              ?></td>
                          </tr>
                          
                           
                         
                        </table>
<hr>
<table class="entry2" width="100%">
    <tr>
        <td> Usia </td> <td> <?=$this->tanggal->hitungUsia($data->tgl_lahir)?></td>
    </tr>
    <tr>
        <td> Status perkawinan </td> <td> <?=$data->sts_menikah?></td>
    </tr>
    <tr>
        <td> Usia pensiun </td> <td> <?=$data->bup;//+$data->bup_tambahan?></td>
    </tr>
    <tr>
        <td> Usia pensiun tambahan</td> <td> <?=$data->bup_tambahan?></td>
    </tr>
    
    <tr>
        <td> <span style="font-size:13px">Jml anggota keluarga </span><br>(istri & anak)</td> <td> <?=$this->mdl->jmlKeluarga($data->nip,[3,4])?> Orang</td>
    </tr>
    <tr>
        <td width="150px"> Jml Penghargaan </td> <td> <?=$this->mdl->jmlPenghargaan($data->nip)?> </td>
    </tr>
</table>

<hr>
<table class="entry2" width="100%">
    <tr>
        <td width="150px"> Nomor Rekening </td> <td> <?=$data->norek?></td>
    </tr>
    <tr>
        <td> Nama Bank </td> <td> <?=$data->bank?></td>
    </tr>
    <tr>
        <td> Atas nama </td> <td> <?=$data->an_rek?></td>
    </tr>
     
</table>

<hr>
<b>Kontak</b>
<table class="entry2" width="100%">
    <tr>
        <td width="150px"> Email </td> <td> <?=$data->email?></td>
    </tr>
    <tr>
        <td> Hp </td> <td> <?=$data->no_hp?></td>
    </tr>
</table>
                
                  <!-- main-profile-work-list --> 
            
                  
                  <!-- main-profile-social-list --> 
               </div>
               <!-- main-profile-overview --> 
            </div>
         </div>
      </div>
      <hr/>
   
<div class="card-body">
<b>Kelengkapan File</b><br><br>
<?php
 
 if($data->file_akta){
    $file  =  $this->m_reff->encrypt($data->file_akta);
echo ' <a  href="'.base_url().'download?f='.$file.'" class="text-info btn-block"><i class="fa fa-file"></i> File Akta Lahir</a>';
 }else{
  echo ' <a  href="javascript:alert(`file belum tersedia`)" class="text-secondary btn-block"><i class="fa fa-file"></i> File Akta Lahir</a>';

 }?>
 <?php
 if($data->file_npwp){
    $file  =  $this->m_reff->encrypt($data->file_npwp);
echo ' <a  href="'.base_url().'download?f='.$file.'" class="text-info btn-block"><i class="fa fa-file"></i> File NPWP</a>';
 }else{
  echo ' <a  href="javascript:alert(`file belum tersedia`)" class="text-secondary btn-block"><i class="fa fa-file"></i> File NPWP</a>';

 }?>
      <?php
 if($data->file_buku_rek){
    $file  =  $this->m_reff->encrypt($data->file_buku_rek);
echo ' <a  href="'.base_url().'download?f='.$file.'" class="text-info btn-block"><i class="fa fa-file"></i> File Buku Rekening</a>';
 }else{
  echo ' <a  href="javascript:alert(`file belum tersedia`)" class="text-secondary btn-block"><i class="fa fa-file"></i> File Buku Rekening</a>';

 }?>
 <?php
 if($data->file_kk){
    $file  =  $this->m_reff->encrypt($data->file_kk);
echo ' <a  href="'.base_url().'download?f='.$file.'" class="text-info btn-block"><i class="fa fa-file"></i> File KK</a>';
 }else{
  echo ' <a  href="javascript:alert(`file belum tersedia`)" class="text-secondary btn-block"><i class="fa fa-file"></i> File KK</a>';

 }?>

 <?php
 if($data->file_ktp){
    $file  =  $this->m_reff->encrypt($data->file_ktp);
echo ' <a  href="'.base_url().'download?f='.$file.'" class="text-info btn-block"><i class="fa fa-file"></i> File KTP</a>';
 }else{
  echo ' <a  href="javascript:alert(`file belum tersedia`)" class="text-secondary btn-block"><i class="fa fa-file"></i> File KTP</a>';

 }?>
 
 <?php
 if($data->file_bpjs){
    $file  =  $this->m_reff->encrypt($data->file_bpjs);
echo ' <a  href="'.base_url().'download?f='.$file.'" class="text-info btn-block"><i class="fa fa-file"></i> File BPJS</a>';
 }else{
  echo ' <a  href="javascript:alert(`file belum tersedia`)" class="text-secondary btn-block"><i class="fa fa-file"></i> File BPJS</a>';

 }?>

 
  
 <?php
 if($data->file_goldar){
    $file  =  $this->m_reff->encrypt($data->file_goldar);
echo ' <a  href="'.base_url().'download?f='.$file.'" class="text-info btn-block"><i class="fa fa-file"></i> File ket dokter golongan darah</a>';
 }else{
  echo ' <a  href="javascript:alert(`file belum tersedia`)" class="text-secondary btn-block"><i class="fa fa-file"></i> File ket dokter golongan darah</a>';

 }?>

 <?php
 if($data->file_surat_nikah){
    $file  =  $this->m_reff->encrypt($data->file_surat_nikah);
echo ' <a  href="'.base_url().'download?f='.$file.'" class="text-info btn-block"><i class="fa fa-file"></i> File Surat Nikah</a>';
 }else{
  echo ' <a  href="javascript:alert(`file belum tersedia`)" class="text-secondary btn-block"><i class="fa fa-file"></i> File Surat Nikah</a>';

 }?>
</div>
 




   </div>
   <div class="col-lg-8 alert alert-primary">
      <div class="main-content-body main-content-body-profile ">
         <nav class="nav main-nav-line card"> 

             <a class="nav-link active" data-toggle="tab" href="#" onclick="tab(`<?php echo base_url()?>cek_data/tab_kepegawaian`)"><i class="fa fa-user-tie"></i> Data kepegawaian</a> 
             <a class="nav-link" data-toggle="tab" href="#" onclick="tab(`<?php echo base_url()?>cek_data/tab_keluarga`)"><i class="fa fa-users"></i> Keluarga</a> 
             <a class="nav-link" data-toggle="tab" href="#" onclick="tab(`<?php echo base_url()?>cek_data/tab_domisili`)"><i class="fa fa-home"></i> Domisili</a> 
             <a class="hide nav-link" data-toggle="tab" href="#" onclick="tab(`<?php echo base_url()?>cek_data/tab_golongan`)"><i class="fab fa-black-tie"></i> Golongan</a> 
             <a class="hide nav-link" data-toggle="tab" href="#" onclick="tab(`<?php echo base_url()?>cek_data/tab_jabatan`)"><i class="fa fa-crown"></i> Jabatan</a> 
             <a class="nav-link" data-toggle="tab" href="#" onclick="tab(`<?php echo base_url()?>cek_data/tab_penugasan`)"><i class="fa fa-chess-bishop"></i> Penugasan</a> 
             <a class="nav-link" data-toggle="tab" href="#" onclick="tab(`<?php echo base_url()?>cek_data/tab_pendidikan`)"><i class="fa fa-user-graduate"></i> Pendidikan & Minat</a> 
             <a class="nav-link" data-toggle="tab" href="#" onclick="tab(`<?php echo base_url()?>cek_data/tab_penghargaan`)"><i class="fa fa-award"></i> Penghargaan</a> 
             <a class="nav-link" data-toggle="tab" href="#" onclick="tab(`<?php echo base_url()?>cek_data/tab_penilaian`)"><i class="fa fa-chart-bar"></i> Penilaian kinerja</a> 
             <a class="hide nav-link" data-toggle="tab" href="#" onclick="tab(`<?php echo base_url()?>cek_data/tab_hukuman`)"><i class="fa fa-balance-scale"></i> Hukuman</a> 
             <a class="nav-link" data-toggle="tab" href="#" onclick="tab(`<?php echo base_url()?>cek_data/tab_medis`)"><i class="fa fa-diagnoses"></i> R. Medis</a> 
             <a class="hide nav-link" data-toggle="tab" href="#" onclick="tab(`<?php echo base_url()?>cek_data/tab_gaji`)"><i class="fa fa-donate"></i> Gaji</a> 

        </nav>
         <!-- main-profile-body --> 
         <div class="main-profile-body p-0">
            <div class="row row-sm">
               <div class="col-12">
                  <div class="card mg-b-20">
                     <div class="card-body">
                        
                        <p class="mg-t-10" id="data_tab">
                      
                        
                        </p>
                         
                     </div>
                  </div>
                 
                
                  
               </div>
            </div>
         </div>
         <!-- main-profile-body --> 
      </div>
   </div>
</div>


<script>
tab(`<?php echo base_url()?>cek_data/tab_kepegawaian`);
function tab(url){
	loading("data_tab");
	  var nip		=	"<?php echo $data->nip;?>";
      var param = {<?php echo $this->m_reff->tokenName()?>:token,nip:nip};
      $.ajax({
       type: "POST",dataType: "json",data: param, url: url,
       success: function(val){
        $("#data_tab").html(val['data']);
        token=val['token'];
		unblock("data_tab");
      }
    });	
}




function formEdit(id) {
         var url = "<?php echo site_url('cek_data_edit/modal_form_edit'); ?>";
         var val = $("[name='val']").val();
         var param = {
             val:val,
             id: id,
             <?php echo $this->m_reff->tokenName() ?>: token
         }
         $.ajax({
             type: "POST",
             dataType: "json",
             data: param,
             url: url,
             success: function(val) {
                 token = val['token'];
                 $("#mdl_modal").modal(
                    //  {
                    //     backdrop: 'static',
                    //     keyboard: false
                    // }
                    );
                 $("#isi").html(val['data']);
             }
         });
     }
     function formTableEdit(id) {
         var url = "<?php echo site_url('cek_data_edit/modal_form_edit'); ?>";
         var fr  = $("[name='fr']").val();
         var val = $("[name='val']").val();
         var param = {
             val:val,
             id: fr,
             id_a: id,
             <?php echo $this->m_reff->tokenName() ?>: token
         }
         $.ajax({
             type: "POST",
             dataType: "json",
             data: param,
             url: url,
             success: function(val) {
                 token = val['token'];
                 $("#isi").html(val['data']);
             }
         });
     }
     function syncron(nip,nama) {

		 swal({
			title: 'Perbaharui data pegawai ?',
			text: nama,
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
                  
                loading();
		var url   = "<?php echo base_url()?>cek_data/syncron";
        var param = {ci_csrf_token:token,nip:nip};
        $.ajax({
          type: "POST",dataType: "json",data: param, url: url,
          success: function(val){
            token=val['token'];
            
            swal("data "+nama+" telah diperbaharui", {
					icon: "success",
					buttons : {
						confirm : {
							className: 'btn btn-success'
						}
					}
          });
          search();
          unblock();
        }
        
        });
            }
    });

        
     }
 </script>

<div class="modal fade" id="mdl_modal" style="z-index:1800" role="dialog">
    <div class="modal-dialog modal-lg" id="area_modal" role="document">
		<div id="isi"></div>
	</div>
</div><!-- /.modal-dialog --> 

<script>
    
    function resetFormN(){
		formTableEdit("");
	}
    function reload_table_inmodal(id){
        var url = "<?php echo site_url('cek_data_edit/modal_table'); ?>";
         var val		=	$("[name='val']").val();
         var param = {
             val:val,
             id: id,
             <?php echo $this->m_reff->tokenName() ?>: token
         };
         loading("area_table");
         $.ajax({
             type: "POST",
             dataType: "json",
             data: param,
             url: url,
             success: function(val) {
                 $("#area_table").html(val['data']);
                 token = val['token'];
                 unblock("area_table");
             }
         });
    }

 



	function submitFormN(id)
	{	
		var form = $("#"+id);
		var link = $(form).attr("url");
        var fr = $('[name="fr"]').val();
        var id_a = $('[name="id_a"]').val();
        $(form).ajaxForm({
             type: "POST",
             dataType: "json",
             data: $(form).serialize(),
             url: link,
             beforeSend: function() {
			    loading("area_"+id);
		    },
             success: function(data) {
                token = data["token"];
                $("#formToken").val(data["token"]);
                unblock("area_"+id); 	
                setTimeout(() => {
                    // search();
                }, 500);
               
                if(data["gagal"]==true)
                {	  
                    notif("<font color='black'>"+data["info"]+"</font>");
                } else{
                   
                    swal("success", {
                        icon: "success",
                        buttons : {
                            confirm : {
                                className: 'btn btn-success'
                            }
                        }
                    });
                    if(id_a==""){
                        resetFormN()
                    }
                    reload_table_inmodal(fr);
                   
                }
             }
         });
	}
    function hapusTable(id,akun){
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
                var fr = $('[name="fr"]').val();
				var url   = "<?php echo site_url('cek_data_edit/destroy');?>";
				var param = {fr:fr,id_a:id,<?php echo $this->m_reff->tokenName()?>:token};
				$.ajax({
					type: "POST",
                    dataType: "json",
                    data: param, 
                    url: url,
					success: function(val){
						token=val['token'];
						reload_table_inmodal(fr);
					}
				});
			}
		});
    }
    function setDomisili(id,akun){
		swal({
			title: 'Default ?',
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
				swal(""+akun+" default", {
					icon: "success",
					buttons : {
						confirm : {
							className: 'btn btn-success'
						}
					}
				});
                var fr = $('[name="fr"]').val();
				var url   = "<?php echo site_url('cek_data_edit/defaultdomisili');?>";
				var param = {fr:fr,id_a:id,<?php echo $this->m_reff->tokenName()?>:token};
				$.ajax({
					type: "POST",
                    dataType: "json",
                    data: param, 
                    url: url,
					success: function(val){
						token=val['token'];
						reload_table_inmodal(fr);
					}
				});
			}
		});
	}
</script>