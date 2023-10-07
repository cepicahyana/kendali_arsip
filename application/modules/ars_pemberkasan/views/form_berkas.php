<?php
$id = $this->m_reff->san($this->input->post("id"));
$data = $this->db->get_where("ars_trx_arsip",array("id"=>$id))->row();
$nama = isset($data->nama)?($data->nama):null;
$id = isset($data->id)?($data->id):null;
 
?>



<div id="area_submitForm">
    <div class="card custom-card" id="tab">
        <div class="card-body">
            <div class="mg-b-20">
                <h6 class="card-title mb-1">Buat Berkas</h6>
            </div>
            <div class="text-wrap">
                <div class="border">
                    <div class="card-body tab-content">
                        <form action="javascript:submit('submitForm')" id="submitForm" url="<?php echo base_url()?>ars_pemberkasan/update_berkas"
                            method="post" enctype="multipart/form-data">
                            <input type="hidden" value="<?php echo $id?>" name="id">
                            <input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName()?>"
                                value="<?php echo $this->m_reff->getToken()?>">
                            <!-- <div class="col-md-6">
                                <div class="row row-xs align-items-center mg-b-20">
                                    <div class="col-md-4">
                                        <label class="form-label mg-b-0 text-black">Jenis Arsip </label>
                                    </div>
                                    <div class="col-md-8 mg-t-5 mg-md-t-0">
                                        <?php 
                                            $dataray=array();
                                            $dataray[""]="=== Pilih ===";
                                            $dataray["1"]="Konvensional";
                                            $dataray["2"]="Elektronik";
                                            echo form_dropdown("f[type]",$dataray,"",'class="select2 form-control text-black " style="width:100%" onchange="change_form_by_type(this.value)"');
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <hr> -->
                            <div class="col-md-12" id="submit_form">
                                <div class="row row-xs align-items-center mg-b-20">
                                    <div class="col-md-2">
                                        <label class="form-label mg-b-0 text-black">Klasifikasi Arsip </label>
                                    </div>
                                    <div class="col-md-10 mg-t-5 mg-md-t-0">
                                        <?php 
                                            $dataray=array();
                                            $dataray[""]="=== Pilih ===";
                                            $data = $this->db->get("ars_tr_kka")->result();
                                            foreach($data as $db){
                                                $dataray[$db->kode] = "{$db->kode} - {$db->nama}";
                                            }
                                            echo form_dropdown("f[kka_kode]",$dataray,"",'id="klasifikasi_arsip" class="form-control select2 text-black"  style="width:100%"');
                                        ?>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-20">
                                    <div class="col-md-2">
                                        <label class="form-label mg-b-0 text-black">Uraian Informasi Arsip </label>
                                    </div>
                                    <div class="col-md-10 mg-t-5 mg-md-t-0">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <textarea class=" form-control" name="f[uraian_informasi]"  type="text"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-20">
                                    <div class="col-md-2">
                                        <label class="form-label mg-b-0 text-black">Kurun Waktu </label>
                                    </div>
                                    <div class="col-md-10 mg-t-5 mg-md-t-0">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input required style='color:black;' type="text" id="periode" name="f[kurun_waktu]" class="cursor form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-20">
                                    <div class="col-md-2">
                                        <label class="form-label mg-b-0 text-black">Tingkat Perkembangan </label>
                                    </div>
                                    <div class="col-md-10 mg-t-5 mg-md-t-0">
                                        <?php 
                                            $dataray=array();
                                            $dataray[""]="=== Pilih ===";
                                            $data = $this->db->get("ars_tr_tingkat_perkembangan")->result();
                                            foreach($data as $db){
                                                $dataray[$db->id] = $db->nama;
                                            }
                                            echo form_dropdown("f[tingkat_perkembangan_id]",$dataray,"",'id="tingkat_perkembangan" class="form-control select2 text-black" style="width:100%"');
                                        ?>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-20"><!-- Belum Memiliki Kolom pada Table -->
                                    <div class="col-md-2">
                                        <label class="form-label mg-b-0 text-black">Jumlah </label>
                                    </div>
                                    <div class="col-md-10 mg-t-5 mg-md-t-0">
                                        <input type="number" class="form-control" name="nf[jumlah]" value="" placeholder="Jumlah">
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-20"><!-- Belum Memiliki Kolom pada Table -->
                                    <div class="col-md-2">
                                        <label class="form-label mg-b-0 text-black">Keterangan </label>
                                    </div>
                                    <div class="col-md-10 mg-t-5 mg-md-t-0">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <textarea class=" form-control" name="nf[keterangan]" type="text"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-20"><!-- Belum Memiliki Kolom pada Table -->
                                    <div class="col-md-2">
                                        <label class="form-label mg-b-0 text-black">Lokasi Ruang Simpan </label>
                                    </div>
                                    <div class="col-md-10 mg-t-5 mg-md-t-0">
                                        <?php 
                                            $dataray=array();
                                            $dataray[""]="=== Pilih ===";
                                            $data = $this->db->get("ars_trx_lokasi")->result();
                                            foreach($data as $db){
                                                $dataray[$db->kode] = $db->nama;
                                            }
                                            echo form_dropdown("nf[location_kode]",$dataray,"",'id="lokasi" class="form-control select2 text-black" style="width:100%"');
                                        ?>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-20"><!-- Belum Memiliki Kolom pada Table -->
                                    <div class="col-md-2">
                                        <label class="form-label mg-b-0 text-black">Nomor Folder </label>
                                    </div>
                                    <div class="col-md-10 mg-t-5 mg-md-t-0">
                                        <?php 
                                            $dataray=array();
                                            $dataray[""]="=== Pilih ===";
                                            $data = $this->db->get("ars_trx_folder")->result();
                                            foreach($data as $db){
                                                $dataray[$db->uuid] = "{$db->code} - {$db->number} - {$db->deskripsi}";
                                            }
                                            echo form_dropdown("nf[folder_uuid]",$dataray,"",'id="folder" class="form-control select2 text-black" style="width:100%"');
                                        ?>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-20"><!-- Belum Memiliki Kolom pada Table -->
                                    <div class="col-md-2">
                                        <label class="form-label mg-b-0 text-black">Nomor Boks Arsip </label>
                                    </div>
                                    <div class="col-md-10 mg-t-5 mg-md-t-0">
                                        <?php 
                                            $dataray=array();
                                            $dataray[""]="=== Pilih ===";
                                            $data = $this->db->get("ars_trx_box")->result();
                                            foreach($data as $db){
                                                $dataray[$db->uuid] = "{$db->code} - {$db->nomor} - {$db->deskripsi}";
                                            }
                                            echo form_dropdown("nf[box_uuid]",$dataray,"",'id="box" class="form-control select2 text-black" style="width:100%"');
                                        ?>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-20">
                                    <div class="col-md-2">
                                        <label class="form-label mg-b-0 text-black">Jadwal Retensi Arsip </label>
                                    </div>
                                    <div class="col-md-10 mg-t-5 mg-md-t-0">
                                        <?php 
                                        $dataray=array();
                                        $dataray[""]="=== Pilih ===";
                                        $data = $this->db->get("ars_tr_jra")->result();
                                        foreach($data as $db){
                                            $dataray[$db->id] = $db->nama;
                                        }
                                        echo form_dropdown("f[jra_kode]",$dataray,"",'id="jadwal_retensi_arsip" class="form-control select2 text-black" style="width:100%"');
                                        ?>
                                    </div>
                                    <div class="card custom-card mg-t-20" id="detail_jra" style="display: none;">
                                        <div class="card-body">
                                            <div class="row row-xs align-items-center mg-b-20">
                                                <div class="col-md-3">
                                                    <label class="form-label mg-b-0 text-black">Retensi Aktif </label>
                                                </div>
                                                <div class="col-md-9 mg-t-5 mg-md-t-0">
                                                    <input type="text" class="form-control" id="retensi_aktif" disabled>
                                                </div>
                                            </div>
                                            <div class="row row-xs align-items-center mg-b-20">
                                                <div class="col-md-3">
                                                    <label class="form-label mg-b-0 text-black">Deskripsi Retensi Aktif </label>
                                                </div>
                                                <div class="col-md-9 mg-t-5 mg-md-t-0">
                                                    <input type="text" class="form-control" id="deks_retensi_aktif" disabled>
                                                </div>
                                            </div>
                                            <div class="row row-xs align-items-center mg-b-20">
                                                <div class="col-md-3">
                                                    <label class="form-label mg-b-0 text-black">Retensi InAktif </label>
                                                </div>
                                                <div class="col-md-9 mg-t-5 mg-md-t-0">
                                                    <input type="text" class="form-control" id="retensi_inaktif" disabled>
                                                </div>
                                            </div>
                                            <div class="row row-xs align-items-center mg-b-20">
                                                <div class="col-md-3">
                                                    <label class="form-label mg-b-0 text-black">Deskripsi Retensi InAktif </label>
                                                </div>
                                                <div class="col-md-9 mg-t-5 mg-md-t-0">
                                                    <input type="text" class="form-control" id="deks_retensi_inaktif" disabled>
                                                </div>
                                            </div>
                                            <div class="row row-xs align-items-center mg-b-20">
                                                <div class="col-md-3">
                                                    <label class="form-label mg-b-0 text-black">Tindak Lanjut </label>
                                                </div>
                                                <div class="col-md-9 mg-t-5 mg-md-t-0">
                                                    <input type="text" class="form-control" id="tindak_lanjut" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row row-xs align-items-center mg-b-20">
                                    <div class="col-md-2">
                                        <label class="form-label mg-b-0 text-black">List Arsip </label>
                                    </div>
                                    <div class="col-md-10 mg-t-5 mg-md-t-0">
                                        <table class="table table-striped table-hover" id="tableArsip">
                                            <thead>
                                                <tr>
                                                    <th width="50px">No</th>
                                                    <th>Nomor Arsip</th>
                                                    <th width="102px">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody id="ListItem">
                                                <tr class="zero">
                                                    <td class="text-center" colspan="3">Data Tidak Tersedia</td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr class="text-right">
                                                    <input type="hidden" name="JmlUpload" id="JmlUpload" value="0">
                                                    <td colspan="4"><a href="javascript:void(0)" onclick="listArsip()" class="btn btn-xs btn-info">Pilih Arsip</a></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div align="right">
                                <hr>
                                <button onclick="submit('submitForm')" class="btn btn-primary pd-x-30 mg-r-5 mg-t-5"><i
                                        class='fa fa-save'></i> Simpan</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
	    $('.select2').select2();
    })

    function submit()
    {
        $("#submitForm").ajaxForm({
            url: "<?php echo base_url()?>ars_pemberkasan/update_berkas",
            data: $("#submitForm").serialize(),
            method:"POST",
            dataType:"JSON",
            beforeSend: function() {
                loading("area_submitForm");
            },
            success: function(data)
                { 	  
                    token = data["token"];
                    $("#formToken").val(data["token"]);
                    unblock("area_submitForm");

                    if(data["data"].gagal==true)
                    {	  
                        swal(data["data"].info, {
                            icon: "warning",
                            buttons : {
                                confirm : {
                                    className: 'btn btn-primary'
                                }
                            }
                        });
                    }else{
                            
                        swal({
                            title: 'Success!',
                            text: ' ',
                            icon: 'success',
                            timer: 1000,
                            buttons: false,
                        })
                        window.location = "<?php echo site_url('ars_pemberkasan');?>";
                        
                    }
                                
                }
        });     
    }
    
    $('#periode').datepicker({
        format: 'yyyy-mm-dd'
    });

    $("#jadwal_retensi_arsip").on('change', function(){
        var id = $(this).val()
        var url   = "<?php echo site_url("ars_pemberkasan/get_jra");?>";
        var param = {<?php echo $this->m_reff->tokenName()?>:token,id:id};
        $.ajax({
            type: "POST",dataType: "json",data: param, url: url,
            success: function(val){
                console.log(val)
                $("#retensi_aktif").val(val['data']['retensi_aktif']);
                $("#deks_retensi_aktif").val(val['data']['retensi_aktif_deskripsi']);
                $("#retensi_inaktif").val(val['data']['retensi_inaktif']);
                $("#deks_retensi_inaktif").val(val['data']['retensi_inaktif_deskripsi']);
                $("#tindak_lanjut").val(val['data']['nama_tindak_lanjut']);
                $("#detail_jra").css('display','')
            }
        })
    })

    function listArsip(id=null)
    {	 
        $("#mdl_modal").modal("show");
        $("#response").html(cantik());
        $(".modal-title").html("List Arsip");
        var dataTable = $('#table1').DataTable({
            "paging": true,
            "processing": false,
            "ordering": false,
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
            "lengthMenu": [
                [10, 20, 30, 50],
                [10, 20, 30, 50],
            ],
            destroy: true, 
            dom: 'Blfrtip',
            buttons: [],
            "ajax": {
                "url": "<?php echo site_url('ars_pemberkasan/getData_arsiplist');?>",
                "type": "POST",
                "data": function(data) {
                    data.<?php echo $this->m_reff->tokenName()?> = token;
                    data.kka = $("#klasifikasi_arsip").val();
                },
                beforeSend: function() {
                    loading("area_lod");
                },
                complete: function(data) {
                    token = data.responseJSON.token;
                    unblock('area_lod');
                },

            },
            "columnDefs": [{
                "targets": [], //last column
                "orderable": false, //set not orderable
            }, ],
        });
    }

    function addArsip(){
        var tableModal = $('#table1').DataTable();
        $('.zero').attr("hidden", true);
        html = ``;
        no = i = $('#tableArsip tr.data').length;
        tableModal.rows().nodes().each(function(item){
            if ($(item).find('.checkItem').prop('checked') == true) {
                html += 
                    `<tr id="${$(item).find('.checkItem').attr('data-id')}" class="data">
                        <td class="text-center iteration">${(no+=1)}</td>
                        <td>
                            <input type="hidden" class="itemFile" name="file_${i}" id="file_${i}" value="${$(item).find('.checkItem').attr('data-id')}">
                            ${$(item).find('.checkItem').attr('data-nomor') == "" ? "-" : $(item).find('.checkItem').attr('data-nomor')}
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-xs btn-danger btn-icon" style="padding: 3px 4px" onclick="removelist(this)"><i class="side-menu__icon fe fe-trash" style="color: #FFF"></i></button>
                        </td>
                    </tr>`
            }
            i++
        })
        $("#ListItem").append(html)
        $("#JmlUpload").val($('#tableArsip tr.data').length)
        $('.modal').modal('hide')
    }

    function removelist(data){
        let tr = $(data).closest('tr');
        $(tr).remove();

        total = $('#tableArsip tr.data').length
        no = 0

        if (total > 0 ) {
            $('#tableArsip tr.data').each(function(index, tr){
                $(tr).find('.iteration').html(index +1)
                $(tr).find('.itemFile').attr("name", "file_" + no).attr("id", "file_" + no)
                no++
            })
        } else {
            $('.zero').attr("hidden", false);
        }

        $("#JmlUpload").val($('#tableArsip tr.data').length)
    }
</script>

<div class="modal effect-scale" id="mdl_modal"   role="dialog" style="z-index:5000">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content modal-content-demo" id="area_modal">
            <div class="modal-header">
                <h6 class="modal-title"> </h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <table id='table1' width="100%" class="tabel black table-striped table-bordered table-hover dataTable">
                    <thead>
                        <tr>
                            <th class='thead' width='15px'>No</th>
                            <th class='thead'>Nomor Arsip </th>
                            <th class='thead'>Klasifikasi Arsip </th>
                            <th class='thead'>Jenis / series Arsip</th>
                            <th class='thead'>Kurun Waktu</th>
                            <th class='thead'>Tingkat Perkembangan</th>
                            <th class='thead'>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-xs btn-primary" onclick="addArsip()">Tambahkan Arsip</button>
                <button class="btn btn-xs btn-danger" onclick="$('.modal').modal('hide')">Batal</button>
            </div>
        </div>
    </div>
</div>