<div class="col-md-12 alert alert-info"> <center><b>  <?php echo strtoupper($this->m_reff->goField("tr_jenis_kegiatan","nama","where id='".$this->input->post("id_acara")."' "))?></b></center> </div>


<?php $id_acara=$this->input->post("id_acara");	
					$data	=	$this->db->get_where("template_undangan",array("id_acara"=>$id_acara))->result();
					foreach($data as $val)
					{ 
						$poto		=	isset($val->poto)?($val->poto):"xx.jpg"; 
						$path		=	"plug/img/temp/".$poto; 
						if(!file_exists(($path)))
						{
							$poto_template	= base_url()."plug/img/template_undangan.jpg";
						}else{
							$poto_template	= base_url()."plug/img/temp/".$poto;
						} 
					?>
					 
					 
					 <div class="col-md-6 cursor">
					  <center><?php echo $val->nama;?>  <br>
					<a title="klik untuk melihat template" href="<?php echo base_url()?>template/preview_template/<?php echo $val->id;?>" target="_blank">
					<img class="img-fluid img-thumbnail" src="<?php echo $poto_template;?>"    style='height:200px;width:100%'> </a><br> 
					 <div class="btn-group">
					 <button class="btn btn-danger btn-sm feather icon-trash-2" style="min-width:20px" onclick="hapus(`<?php echo $this->m_reff->encrypt($val->id)?>`,`<?php echo $val->nama?>`)"> Hapus </button>
					 <button class="btn btn-info btn-sm feather icon-edit " style="min-width:100px" onclick="edit(`<?php echo $val->id?>`)"> Edit Template </button>
					 <button  class="btn btn-success btn-sm feather icon-check-circle "  style="width:100px" onclick="terapkan(`<?php echo $val->id?>`,`<?php echo $val->nama?>`)"> Terapkan </button>
					 </div>
					 </center><br>
					 </div>
					 
					<?php } ?>
					
					
 