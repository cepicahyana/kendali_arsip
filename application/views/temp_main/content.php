<div class="main-content horizontal-content">
 <div class="container content">

<?php 
if(isset($konten)){?>	 
             <?php echo $this->load->view($konten);?>
<?php 	}else{	echo "File Konten Tidak Ada";}; ?>

</div>
</div>