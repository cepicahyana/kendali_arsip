<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div>
        <h4 class="content-title mb-2" id="bread_title"><?=isset($title)?($title):"";?></h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"  id="bread_subtitle"><?=isset($subtitle)?($subtitle):"";?></a></li>
                <!-- <li class="breadcrumb-item active" aria-current="page">Project</li> -->
            </ol>
        </nav>
    </div>
</div>
<!-- /breadcrumb -->
<div class="content">
<?php 
if(isset($konten)){ 
    echo $this->load->view($konten);
}else{	
    echo "File Konten Tidak Tersedia";
}; ?>
</div>