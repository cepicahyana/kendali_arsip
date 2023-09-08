<?php
$id = $this->m_reff->san($this->input->post("id"));
// $data = $this->db->get_where("ars_trx_pemindahan",array("id"=>$id))->row();
$id = ""; //isset($data->id)?($data->id):null;
$nomor = ""; //isset($data->nama)?($data->nama):null;
$asal = "";
$tujuan = array("Organisasi 1", "Organisasi 2", "Organisasi 3", "Organisasi 4");
$ListKlasifikasi = ["KK.00.00", "KK.00.01", "KK.00.02", "KK.01.00", "KK.01.01", "KK.01.02", "PI.00.00", "PI.00.01", "PI.00.02", "PI.01.00", "PI.01.01", "PI.01.02"];
$ListPerkembangan = ["Asli", "Pertinggal", "Tembusan", "Salinan", "Fotokopi"];
?>

<div class="card">
    <div class="row card-body" style='padding-top:10px;padding-bottom:20px'>
        <form action="javascript:submitForm('modal')" id="modal" url="<?php echo base_url() ?>ars_master/update_pemindahan" method="post" enctype="multipart/form-data">
            <input type="hidden" value="<?php echo $id ?>" name="id">
            <input type="hidden" id="formToken" name="<?php echo $this->m_reff->tokenName() ?>" value="<?php echo $this->m_reff->getToken() ?>">
            <div class="row">
                <div class="col-xl-8 col-lg-12" id="area_lod">
                    <h5>List Pemindahan Arsip</h5>
                    <hr class="mt-1">
                    <div class="border">
                        <div class="bg-gray-200 nav-bg">
                            <nav class="nav nav-tabs">
                                <a class="nav-link active" data-bs-toggle="tab" href="#tabCont1">Arsip Usul Pindah</a>
                                <a class="nav-link" data-bs-toggle="tab" href="#tabCont2">Arsip yang akan Dipindahkan</a>
                            </nav>
                        </div>
                        <div class="card-body tab-content">
                            <div class="tab-pane active" id="tabCont1">
                                <table id='tableSelectItemArsip' width="100%" class="tabel black table-striped table-bordered table-hover dataTable">
                                    <thead>
                                        <tr>
                                            <th class='thead text-center' width='15px'><input type='checkbox' id='checkAll'></th>
                                            <th class='thead' width='15px'>No</th>
                                            <th class='thread'>Klasifikasi Arsip</th>
                                            <th class='thread'>Jenis/Series Arsip</th>
                                            <th class='thread text-center'>Kurun Waktu</th>
                                            <th class='thread text-center'>Tingkat Perkembangan</th>
                                            <th class='thread text-center'>Jumlah</th>
                                            <th class='thread'>Ket</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        for ($i = 0; $i < 23; $i++) {
                                            $thn = rand(2, 5);
                                            $no = $i + 1;
                                            echo "<tr>";
                                            echo "<td class='text-center'><input type='checkbox' class='checkItem'></td>";
                                            echo "<td>$no</td>";
                                            echo "<td>" . $ListKlasifikasi[rand(0, 11)] . "</td>";
                                            echo "<td>Jenis Arsip $no</td>";
                                            echo "<td class='text-center'>" . sprintf("%02d", rand(1, 29)) . '-' . sprintf("%02d", rand(1, 12)) . '-' . sprintf("%04d", rand(1990, 2022)) . "</td>";
                                            echo "<td class='text-center'>" . $ListPerkembangan[rand(0, 4)] . "</td>";
                                            echo "<td class='text-center'>" . rand(50, 300) . "</td>";
                                            echo "<td>Ket. $no</td>";
                                            echo "</tr>";
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot style="display: none;" id="btnHProses">
                                        <tr>
                                            <th colspan="8" class="pt-0">
                                                <button class="btn btn-success pd-x-30 mg-r-5 mg-t-5" data-toggle="tooltip" data-placement="top" title="Approve" type="button"><i class="fa fa-arrow-right text-white"></i> Proses</button>
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="tab-pane" id="tabCont2">
                                <table id='tableItemArsip' width="100%" class="tabel black table-striped table-bordered table-hover dataTable">
                                    <thead>
                                        <tr>
                                        <th class='thead text-center' width='15px'><input type='checkbox' id='checkAll2'></th>
                                            <th class='thead' width='15px'>No</th>
                                            <th class='thread'>Klasifikasi Arsip</th>
                                            <th class='thread'>Jenis/Series Arsip</th>
                                            <th class='thread text-center'>Kurun Waktu</th>
                                            <th class='thread text-center'>Tingkat Perkembangan</th>
                                            <th class='thread text-center'>Jumlah</th>
                                            <th class='thread'>Ket</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        for ($i = 0; $i < 9; $i++) {
                                            $thn = rand(2, 5);
                                            $no = $i + 1;
                                            echo "<tr>";
                                            echo "<td class='text-center'><input type='checkbox' class='checkItem2'></td>";
                                            // echo "<td class='text-center'><a href='javascript:void(0);' class='font14' data-toggle='tooltip' data-placement='top' title='Approve' role='button'><i class='fas fa-times text-danger'></i></a></td>";
                                            echo "<td>$no</td>";
                                            echo "<td>" . $ListKlasifikasi[rand(0, 11)] . "</td>";
                                            echo "<td>Jenis Arsip $no</td>";
                                            echo "<td class='text-center'>" . sprintf("%02d", rand(1, 29)) . '-' . sprintf("%02d", rand(1, 12)) . '-' . sprintf("%04d", rand(1990, 2022)) . "</td>";
                                            echo "<td class='text-center'>" . $ListPerkembangan[rand(0, 4)] . "</td>";
                                            echo "<td class='text-center'>" . rand(50, 300) . "</td>";
                                            echo "<td>Ket. $no</td>";
                                            echo "</tr>";
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot style="display: none;" id="btnHBatal">
                                        <tr>
                                            <th colspan="8" class="pt-0">
                                                <button class="btn btn-danger pd-x-30 mg-r-5 mg-t-5" data-toggle="tooltip" data-placement="top" title="Approve" type="button"><i class="fas fa-times text-white"></i> Batal</button>
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-12">
                    <h5>Informasi Pemindahan</h5>
                    <hr class="mt-1">
                    <div class="row row-xs mg-b-20 align-items-center">
                        <div class="col-md-5">
                            <label class="form-label mg-b-0 text-black">Tanggal Pemindahan </label>
                        </div>
                        <div class="col-md-7 mg-t-5 mg-md-t-0">
                            <input class="form-control text-black" name="f[tanggal]" placeholder="Tanggal Pemindahan..." type="date" value="">
                        </div>
                    </div>
                    <div class="row row-xs align-items-center mg-b-20">
                        <div class="col-md-5">
                            <label class="form-label mg-b-0 text-black">Tujuan Pemindahan </label>
                        </div>
                        <div class="col-md-7">
                            <label class="form-label mg-b-0 text-black">UK2</label>
                        </div>
                    </div>
                    <div class="row row-xs align-items-center mg-b-20">
                        <div class="col-md-5">
                            <label class="form-label mg-b-0 text-black">Penandatangan Sumber </label>
                        </div>
                        <div class="col-md-7">
                            <label class="form-label mg-b-0 text-black">Hery Hermansyah, S.T., M.Tr.AP.</label>
                        </div>
                    </div>
                    <div class="row row-xs align-items-center mg-b-20">
                        <div class="col-md-5">
                            <label class="form-label mg-b-0 text-black">Penandatangan Penerima </label>
                        </div>
                        <div class="col-md-7">
                            <label class="form-label mg-b-0 text-black">Wahyudi, S.H., M.M.</label>
                        </div>
                    </div>
                </div>
            </div>
            <div align="right">
                <hr>
                <a href="<?= base_url(); ?>ars_penyusutan/pemindahan" role="button" class="btn btn-default menuclick pd-x-30 mg-r-5 mg-t-5"><i class='fa fa-arrow-left'></i> Kembali</a>
                <a href="<?= base_url(); ?>ars_penyusutan/pemindahan" role="button" style="display:none;" id="btnSave" class="btn btn-primary menuclick pd-x-30 mg-r-5 mg-t-5"><i class='fa fa-save'></i> Simpan</a>
                <a href="<?= base_url(); ?>ars_penyusutan/pemindahan" role="button" style="display:none;" id="btnReqApprove" class="btn btn-success menuclick pd-x-30 mg-r-5 mg-t-5"><i class='fa fa-arrow-right'></i> Request Approval Pengiriman</a>
                <a href="<?= base_url(); ?>ars_penyusutan/pemindahan" role="button" style="display:none;" id="btnApprove" class="btn btn-success menuclick pd-x-30 mg-r-5 mg-t-5"><i class='fa fa-check'></i> Approve Pengiriman</a>
                <a href="<?= base_url(); ?>ars_penyusutan/pemindahan" role="button" style="display:none;" id="btnBatal" class="btn btn-danger menuclick pd-x-30 mg-r-5 mg-t-5"><i class='far fa-trash-alt'></i> Batalkan Pemindahan</a>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    var dataTable = $('#tableSelectItemArsip').DataTable({
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
        "responsive": true,
        "searching": true,
        // "lengthMenu": [
        //     [10, 20, 30, 50],
        //     [10, 20, 30, 50],
        // ],
        dom: 'Blfrtip',
        buttons: [{
            text: '<i class="fe fe-refresh-cw"></i>    ',
            action: function(e, dt, node, config) {
                reload_table();
            },
            className: 'btn  btn-secondary-light'
        }, ],
    });

    var dataTable2 = $('#tableItemArsip').DataTable({
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
        "responsive": true,
        "searching": true,
        "lengthMenu": [
            [10, 20, 30, 50],
            [10, 20, 30, 50],
        ],

        dom: 'Blfrtip',
        buttons: [{
            text: '<i class="fe fe-refresh-cw"></i>    ',
            action: function(e, dt, node, config) {
                reload_table();
            },
            className: 'btn btn-secondary-light'
        }, ],
    });
    $('#checkAll').click(function() {
        if ($(this).is(':checked')) {
            $('.checkItem').each(function() {
                if (!$(this).is(':checked')) {
                    $(this).click();
                }
            });
        } else {
            $('.checkItem').each(function() {
                if ($(this).is(':checked')) {
                    $(this).click();
                }
            });
        }
    });
    $('#checkAll2').click(function() {
        if ($(this).is(':checked')) {
            $('.checkItem2').each(function() {
                if (!$(this).is(':checked')) {
                    $(this).click();
                }
            });
        } else {
            $('.checkItem2').each(function() {
                if ($(this).is(':checked')) {
                    $(this).click();
                }
            });
        }
    });
    $(function(){
        var status = parseInt('<?php echo isset($status) ? $status : 0; ?>');
        if(status == 1){
            $('#btnHProses').show();
            $('#btnHBatal').show();          
            $('#btnSave').show();
            $('#btnReqApprove').show();
        } else if(status == 2){
            $('#btnHProses').show();
            $('#btnHBatal').show();
            $('#btnSave').show();
            $('#btnApprove').show();
        } else if(status == 99){
            $('#btnBatal').show();
        }
    });
</script>
<div class="modal effect-scale" id="mdl_modal" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content" id="area_modal">
            <div class="modal-header">
                <h6 class="modal-title"> </h6><button type="button" role="button" aria-label="Close" class="btn-close" data-bs-dismiss="modal"><span aria-hidden="true">×</span></button>
            </div>
            <div id="response"></div>
        </div>
    </div>
</div>