<div class="pcoded-main-container">
    <div class="pcoded-content">
	<div class="content" id="content">
	   <?php 
if(isset($konten)){?>	 
             <?php echo $this->load->view($konten);?>
<?php 	}else{	echo "File Konten Tidak Ada";}; ?>
    </div>
    </div>
</div>



