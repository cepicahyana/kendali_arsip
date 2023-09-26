<?php
if (empty($refresh)) {
    $this->load->helper('s3_helper');
    $id     = $this->m_reff->san($this->input->post("id"));
    $detail = $this->mdl->getDetail($id);
}
?>
<div class="row row-xs mg-b-20 align-items-center">
    <div class="col-md-4">
        <label class="form-label mg-b-0 text-black">Nomor Pemusnahan</label>
    </div>
    <div class="col-md-8 mg-t-5 mg-md-t-0">
        <label class="form-label mg-b-0 text-black"><?= $detail->nomor ?></label>
    </div>
</div>
<div class="row row-xs mg-b-20 align-items-center">
    <div class="col-md-4">
        <label class="form-label mg-b-0 text-black">Tanggal Register Pemusnahan </label>
    </div>
    <div class="col-md-8 mg-t-5 mg-md-t-0">
        <label class="form-label mg-b-0 text-black"><?= $detail->tanggal_id ?></label>
    </div>
</div>
<div class="row row-xs align-items-center mg-b-20">
    <div class="col-md-4">
        <label class="form-label mg-b-0 text-black">Tujuan Pemusnahan </label>
    </div>
    <div class="col-md-8">
        <label class="form-label mg-b-0 text-black">UK2</label>
    </div>
</div>
<div class="row row-xs align-items-center mg-b-20">
    <div class="col-md-4">
        <label class="form-label mg-b-0 text-black">Inisiator </label>
    </div>
    <div class="col-md-8">
        <label class="form-label mg-b-0 text-black"><?= $detail->inisiator ?></label>
    </div>
</div>
<div class="row row-xs align-items-center mg-b-20">
    <div class="col-md-4">
        <label class="form-label mg-b-0 text-black">Organisasi </label>
    </div>
    <div class="col-md-8">
        <label class="form-label mg-b-0 text-black">Biro Umum</label>
    </div>
</div>
<div class="row row-xs mg-b-20 align-items-center">
    <div class="col-md-4">
        <label class="form-label mg-b-0 text-black">Tim Pemusnahan</label>
    </div>
    <div class="col-md-8 mg-t-5 mg-md-t-0">
        <?= $detail->nama_tim ? "<ul style='padding-left: 12px;'>$detail->nama_tim</ul>" : '' ?>
    </div>
</div>

<?php if ($detail->status > 0 and !empty($detail->attach_sk_tim)) : ?>
    <div class="row row-xs mg-b-20 align-items-center">
        <div class="col-md-4">
            <label class="form-label mg-b-0 text-black">SK Tim Pemusnahan</label>
        </div>
        <div class="col-md-8 mg-t-5 mg-md-t-0">
            <a href="<?= get_s3_object($detail->attach_sk_tim, 10) ?>" class="btn btn-sm btn-info btn-file" target="_blank"><i class="fa fa-print"></i></a>
        </div>
    </div>
<?php endif; ?>

<?php if ($detail->status > 0 and !empty($detail->attach_usulmusnah_awal)) : ?>
    <div class="row row-xs mg-b-20 align-items-center">
        <div class="col-md-4">
            <label class="form-label mg-b-0 text-black">Usul musnah Awal</label>
        </div>
        <div class="col-md-8 mg-t-5 mg-md-t-0">
            <a href="<?= get_s3_object($detail->attach_usulmusnah_awal, 10) ?>" class="btn btn-sm btn-info btn-file" target="_blank"><i class="fa fa-print"></i></a>
        </div>
    </div>
<?php endif; ?>

<?php if ($detail->status > 1 and !empty($detail->attach_sk_penilaian_tim)) : ?>
    <div class="row row-xs mg-b-20 align-items-center">
        <div class="col-md-4">
            <label class="form-label mg-b-0 text-black">SK Penilaian Tim Pemusnahan</label>
        </div>
        <div class="col-md-8 mg-t-5 mg-md-t-0">
            <a href="<?= get_s3_object($detail->attach_sk_penilaian_tim, 10) ?>" class="btn btn-sm btn-info btn-file" target="_blank"><i class="fa fa-print"></i></a>
        </div>
    </div>
<?php endif; ?>

<?php if ($detail->status > 1 and !empty($detail->attach_usulmusnah_tim)) : ?>
    <div class="row row-xs mg-b-20 align-items-center">
        <div class="col-md-4">
            <label class="form-label mg-b-0 text-black">Arsip Usul Musnah Tim Pemusnahan</label>
        </div>
        <div class="col-md-8 mg-t-5 mg-md-t-0">
            <a href="<?= get_s3_object($detail->attach_usulmusnah_tim, 10) ?>" class="btn btn-sm btn-info btn-file" target="_blank"><i class="fa fa-print"></i></a>
        </div>
    </div>
<?php endif; ?>

<?php if ($detail->status > 2 and !empty($detail->attach_sk_penilaian_anri)) : ?>
    <div class="row row-xs mg-b-20 align-items-center">
        <div class="col-md-4">
            <label class="form-label mg-b-0 text-black">SK Penilaian ANRI</label>
        </div>
        <div class="col-md-8 mg-t-5 mg-md-t-0">
            <a href="<?= get_s3_object($detail->attach_sk_penilaian_anri, 10) ?>" class="btn btn-sm btn-info btn-file" target="_blank"><i class="fa fa-print"></i></a>
        </div>
    </div>
<?php endif; ?>

<?php if ($detail->status > 2 and !empty($detail->attach_usulmusnah_final)) : ?>
    <div class="row row-xs mg-b-20 align-items-center">
        <div class="col-md-4">
            <label class="form-label mg-b-0 text-black">Arsip Yang Dimusnahkan</label>
        </div>
        <div class="col-md-8 mg-t-5 mg-md-t-0">
            <a href="<?= get_s3_object($detail->attach_usulmusnah_final, 10) ?>" class="btn btn-sm btn-info btn-file" target="_blank"><i class="fa fa-print"></i></a>
        </div>
    </div>
<?php endif; ?>

<?php if ($detail->status > 3 and !empty($detail->attach_sk_penilaian_kasetpres)) : ?>
    <div class="row row-xs mg-b-20 align-items-center">
        <div class="col-md-4">
            <label class="form-label mg-b-0 text-black">SK Penilaian Kasetpres</label>
        </div>
        <div class="col-md-8 mg-t-5 mg-md-t-0">
            <a href="<?= get_s3_object($detail->attach_sk_penilaian_kasetpres, 10) ?>" class="btn btn-sm btn-info btn-file" target="_blank"><i class="fa fa-print"></i></a>
        </div>
    </div>
<?php endif; ?>

<?php if ($detail->status > 5 and !empty($detail->attach_ba)) : ?>
    <div class="row row-xs mg-b-20 align-items-center">
        <div class="col-md-4">
            <label class="form-label mg-b-0 text-black">BA Pemusnahan</label>
        </div>
        <div class="col-md-8 mg-t-5 mg-md-t-0">
            <a href="<?= get_s3_object($detail->attach_ba, 10) ?>" class="btn btn-sm btn-info btn-file" target="_blank"><i class="fa fa-print"></i></a>
        </div>
    </div>
<?php endif; ?>