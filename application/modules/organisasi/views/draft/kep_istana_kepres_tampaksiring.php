<style type="text/css">
	/*Now the CSS*/
* {margin: 0; padding: 0;}

.tree ul {
	padding-top: 20px; position: relative;
	
	transition: all 0.5s;
	-webkit-transition: all 0.5s;
	-moz-transition: all 0.5s;
}

.tree li {
	float: left; text-align: center;
	list-style-type: none;
	position: relative;
	padding: 20px 5px 0 5px;

	transition: all 0.5s;
	-webkit-transition: all 0.5s;
	-moz-transition: all 0.5s;
}

/*We will use ::before and ::after to draw the connectors*/
.tree li::before, .tree li::after{
	content: '';
	position: absolute; top: 0; right: 50%;
	border-top: 1px solid #ccc;
	width: 50%; height: 20px;
	z-index: 99999;
 
}
.tree li::after{
	right: auto; left: 50%;
	border-left: 1px solid #ccc;
}

/*We need to remove left-right connectors from elements without 
any siblings*/
.tree li:only-child::after, .tree li:only-child::before {
	display: none;
}

/*Remove space from the top of single children*/
.tree li:only-child{ padding-top: 0;}

/*Remove left connector from first child and 
right connector from last child*/
.tree li:first-child::before, .tree li:last-child::after{
	border: 0 none;
}
/*Adding back the vertical connector to the last nodes*/
.tree li:last-child::before{
	border-right: 1px solid #ccc;
	border-radius: 0 5px 0 0;
	-webkit-border-radius: 0 5px 0 0;
	-moz-border-radius: 0 5px 0 0;
}
.tree li:first-child::after{
	border-radius: 5px 0 0 0;
	-webkit-border-radius: 5px 0 0 0;
	-moz-border-radius: 5px 0 0 0;
}

/*Time to add downward connectors from parents*/
.tree ul ul::before{
	content: '';
	position: absolute; top: 0; left: 50%;
	border-left: 1px solid #ccc;
	width: 0; height: 20px;
}

.tree li a{
	border: 1px solid #ccc;
	padding: 5px 10px;
	text-decoration: none;
	color: #666;
	font-family: arial, verdana, tahoma;
	font-size: 11px;
	display: inline-block;
	
	border-radius: 5px;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	
	transition: all 0.5s;
	-webkit-transition: all 0.5s;
	-moz-transition: all 0.5s;
	background-color: white;
}

/*Time for some hover effects*/
/*We will apply the hover effect the the lineage of the element also*/
.tree li a:hover, .tree li a:hover+ul li a {
	background: #c8e4f8; color: #000; border: 1px solid #94a0b4;
}
/*Connector styles on hover*/
.tree li a:hover+ul li::after, 
.tree li a:hover+ul li::before, 
.tree li a:hover+ul::before, 
.tree li a:hover+ul ul::before{
	border-color:  #94a0b4;
}
 
.turun{
	border-left: 1px solid #ccc;
	border-radius: 0 5px 0 0;
	-webkit-border-radius: 0 5px 0 0;
	-moz-border-radius: 0 5px 0 0;
	margin-top:0px;
	margin-left: 5px;
}
.anchor{
	cursor: pointer;
}
.anchor:hover{
	color:blue;
	cursor: pointer;
}
.group1{
	border:#ccc solid 1px;
	border-radius: 5px;
	background-color:#f8f5f5;
	padding: 15px;
}
.padding-group{
 	 padding: 15px;
	 margin-top: 9px;
	 width: 200px;
}
.group2{
	border-top:#ccc solid 1px;
	border-right:#ccc solid 1px;
	border-top-right-radius: 5px;
 
	 width: 130px;
	 margin-left: 99px;
	 margin-top: -24px;
	 position: absolute;
	 height: 335px;
	 z-index: 0;
}
.group2-end{
	border-bottom:#ccc solid 1px;
	border-right:#ccc solid 1px;
	 
	border-top-right-radius: 5px;
 
	 width: 28px;
	 margin-left: 216px;
	 margin-top: -104px;
	 position: absolute;
	 min-height: 55px;
}
.group3{
	/* border-top:#ccc solid 1px;
	border-right:#ccc solid 1px; */
	 
	border-top-right-radius: 5px;
 
	 width: 130px;
	 margin-left: 100px;
	 margin-top: -24px;
	 position: absolute;
	 min-height: 355px;
	 
}

 .group{
		/* border-top:#ccc solid 1px; */
		border-right:#ccc solid 1px;
		/* border-bottom:#ccc solid 1px; */
		margin-left: 20px;
		margin-top: -9px;
		border-top-right-radius: 10px;
 }
 
 

.group::after{
	content : "";
  position: absolute;
  left    : 0;
  bottom  : 0;
  height  : 121px;
  width   : 50%;  /* or 100px */
  border-bottom:1px solid white;
}
.group a::after{
	content: '';
	position: absolute; top: 20; left: 50%;
	border-top: 1px solid #ccc;
	width: 48%; height: 20px;
	border-top-right-radius: 10px;
}
 
 
.group4{
	border-top:#ccc solid 1px;
	border-right:#ccc solid 1px;
	border-top-right-radius: 5px;
 
	 width: 130px;
	 margin-left: 100px;
	 margin-top: -24px;
	 position: absolute;
	 min-height: 95px;
	 
}
.group4-end{
	border-bottom:#ccc solid 1px;
	border-right:#ccc solid 1px;
	border-top-right-radius: 5px;
	width: 29px;
	 margin-left: 216px;
	 margin-top: -88px;
	 position: absolute;
	 min-height: 55px;
	 
}
.block9{
	width: 90%;
	
}
.garis-end{
	position: absolute;margin-left: 201px;margin-top:-50px;
	border-top: #ccc solid 1px;min-width:14px;
	border-right:white solid 1px;
	height: 100px;
}
.garis{
	position: absolute;margin-left: 201px;margin-top:20px;border-bottom: #ccc solid 1px;min-width:15px;
}
.garis2{
	position: absolute;margin-left: 201px;margin-top:24px;border-bottom: #ccc solid 1px;min-width:29px;
}
#kepala{
	/* background-color: rgb(136, 216, 248); */
}

</style>

<div class="tree">
	<ul>
		<li><a class='link'  id="kepala" href='#'><b>KEPALA ISTANA KEPRESIDENAN<br>TAMPAKSIRING</b><br>
			<br><?php echo $this->mdl->pejabat("KEPALA ISTANA KEPRESIDENAN TAMPAKSIRING"); ?></a>
			 <ul> 
				 <li>
					 <div class="group1">
			
						<a class='link pb5' href='#'>
							<b>Analisis Kepegawaian <br/>
								<?php echo $this->mdl->jenjang_jabatan("kep_istana_kepres_tampaksiring","Analisis Kepegawaian","Ahli Muda")?><br>
								<?php echo $this->mdl->loop_jenjang_jabatan("Analisis Kepegawaian","Ahli Muda")?></b>	
						</a>
						<br><br>
						<a class='link pb5' href='#'>
							<b>Analisis Pengelola Keuangan APBN <br/>
							<?php echo $this->mdl->jenjang_jabatan("kep_istana_kepres_tampaksiring","Analisis Pengelola Keuangan APBN","Ahli Muda")?><br>
							<?php echo $this->mdl->loop_jenjang_jabatan("Analisis Pengelola Keuangan APBN","Ahli Muda")?></b></b>
						</a>
						<br><br>
						<a class='link pb5' href='#'>
							<b>Pranata Komputer <br/>
						<?php echo $this->mdl->jenjang_jabatan("kep_istana_kepres_tampaksiring","Pranata Komputer","Ahli Muda")?><br>
							<?php echo $this->mdl->loop_jenjang_jabatan("Pranata Komputer","Ahli Muda")?></b></b></b>
						</a>
						<br><br>
						<a class='link pb5' href='#'>
							<b>Arsiparis<br/>
						<?php echo $this->mdl->jenjang_jabatan("kep_istana_kepres_tampaksiring","Arsiparis","Ahli Muda")?><br>
							<?php echo $this->mdl->loop_jenjang_jabatan("Arsiparis","Ahli Muda")?></b></b></b>
						</a>
						<br><br>
						<a class='link pb5' href='#'>
							<b>Pengelola Pengadaan Barang/Jasa <br/>
							<?php echo $this->mdl->jenjang_jabatan("kep_istana_kepres_tampaksiring","Pengelola Pengadaan Barang/Jasa","Muda")?><br>
							<?php echo $this->mdl->loop_jenjang_jabatan("Pengelola Pengadaan Barang/Jasa","Muda")?></b></b>
						</a>
						</b><br>
					</div>
                  
				 </li>
                  <li>
					<a class='link' id="kepala" href='#'>
						<b>Kepala Subbagian<br/>
							Tata Usaha</b>
					<br><?php echo $this->mdl->pejabat("Subbagian Tata Usaha"); ?></a>					
				</a>

				<ul>
                    <li>
                        <div class="group1">
                            <a class='link pb5' href='#'>
                                <b>Analisis Anggaran</b>
                                <br><br>
                                <b>
									<?php echo $this->mdl->jenjang_jabatan("kep_istana_kepres_tampaksiring","Analisis Anggaran","Ahli Pertama")?><br>
									<?php echo $this->mdl->loop_jenjang_jabatan("Analisis Anggaran","Ahli Pertama")?></b></b>
								</b><br>
                            </a>
							<br>
							<br>
							<a class='link pb5' href='#'>
                                <b>Analisis Kepegawaian</b>
                                <br><br>
                                <b><?php echo $this->mdl->jenjang_jabatan("kep_istana_kepres_tampaksiring","Analisis Kepegawaian","Ahli Pertama")?><br>
									<?php echo $this->mdl->loop_jenjang_jabatan("Analisis Kepegawaian","Ahli Pertama")?>
									<br>
									<?php echo $this->mdl->jenjang_jabatan("kep_istana_kepres_tampaksiring","Analisis Kepegawaian","Penyelia")?><br>
									<?php echo $this->mdl->loop_jenjang_jabatan("Analisis Kepegawaian","Penyelia")?>
									<br>
									<?php echo $this->mdl->jenjang_jabatan("kep_istana_kepres_tampaksiring","Analisis Kepegawaian","Mahir")?><br>
									<?php echo $this->mdl->loop_jenjang_jabatan("Analisis Kepegawaian","Mahir")?>
									<br>
									<?php echo $this->mdl->jenjang_jabatan("kep_istana_kepres_tampaksiring","Analisis Kepegawaian","Terampil")?><br>
									<?php echo $this->mdl->loop_jenjang_jabatan("Analisis Kepegawaian","Terampil")?>
								</b>
                            </a>
							<br>
							<br>
							<a class='link pb5' href='#'>
                                <b>Analis Pengelola Keuangan APBN</b>
                                <br><br>
                                <b><?php echo $this->mdl->jenjang_jabatan("kep_istana_kepres_tampaksiring","Analis Pengelola Keuangan APBN","Ahli Pertama")?><br>
									<?php echo $this->mdl->loop_jenjang_jabatan("Analis Pengelola Keuangan APBN","Ahli Pertama")?></b>
                            </a>
							<br>
							<br>
							<a class='link pb5' href='#'>
                                <b>Pranata Keuangan APBN</b>
                                <br><br>
                                <b><?php echo $this->mdl->jenjang_jabatan("kep_istana_kepres_tampaksiring","Pranata Keuangan APBN","Penyelia")?><br>
									<?php echo $this->mdl->loop_jenjang_jabatan("Pranata Keuangan APBN","Penyelia")?>
									<br>
									<?php echo $this->mdl->jenjang_jabatan("kep_istana_kepres_tampaksiring","Pranata Keuangan APBN","Mahir")?><br>
									<?php echo $this->mdl->loop_jenjang_jabatan("Pranata Keuangan APBN","Mahir")?>
									<br>
									<?php echo $this->mdl->jenjang_jabatan("kep_istana_kepres_tampaksiring","Pranata Keuangan APBN","Terampil")?><br>
									<?php echo $this->mdl->loop_jenjang_jabatan("Pranata Keuangan APBN","Terampil")?></b>
                            </a>
							<br>
							<br>
							<a class='link pb5' href='#'>
                                <b>Pranata Komputer</b>
                                <br><br>
                                <b><?php echo $this->mdl->jenjang_jabatan("kep_istana_kepres_tampaksiring","Pranata Komputer","Ahli Pertama")?><br>
									<?php echo $this->mdl->loop_jenjang_jabatan("Pranata Komputer","Ahli Pertama")?>
									<br>
									<?php echo $this->mdl->jenjang_jabatan("kep_istana_kepres_tampaksiring","Pranata Komputer","Penyelia")?><br>
									<?php echo $this->mdl->loop_jenjang_jabatan("Pranata Komputer","Penyelia")?>
									<br>
									<?php echo $this->mdl->jenjang_jabatan("kep_istana_kepres_tampaksiring","Pranata Komputer","Mahir")?><br>
									<?php echo $this->mdl->loop_jenjang_jabatan("Pranata Komputer","Mahir")?>
									<br>
									<?php echo $this->mdl->jenjang_jabatan("kep_istana_kepres_tampaksiring","Pranata Komputer","Terampil")?><br>
									<?php echo $this->mdl->loop_jenjang_jabatan("Pranata Komputer","Terampil")?></b>
                            </a>
							<br>
							<br>
							<a class='link pb5' href='#'>
                                <b>Arsiparis</b>
                                <br><br>
                                <b><?php echo $this->mdl->jenjang_jabatan("kep_istana_kepres_tampaksiring","Arsiparis","Ahli Pertama")?><br>
									<?php echo $this->mdl->loop_jenjang_jabatan("Arsiparis","Ahli Pertama")?>
									<br>
									<?php echo $this->mdl->jenjang_jabatan("kep_istana_kepres_tampaksiring","Arsiparis","Penyelia")?><br>
									<?php echo $this->mdl->loop_jenjang_jabatan("Arsiparis","Penyelia")?>
									<br>
									<?php echo $this->mdl->jenjang_jabatan("kep_istana_kepres_tampaksiring","Arsiparis","Mahir")?><br>
									<?php echo $this->mdl->loop_jenjang_jabatan("Arsiparis","Mahir")?>
									<br>
									<?php echo $this->mdl->jenjang_jabatan("kep_istana_kepres_tampaksiring","Arsiparis","Terampil")?><br>
									<?php echo $this->mdl->loop_jenjang_jabatan("Arsiparis","Terampil")?></b>
                            </a>
							<br>
							<br>
                        </div>
                    </li>
                    <li>
                        
						<ul>
							<li style="margin-top:-20px">
								<div class="group" style="margin-top:20px">
									<div class="padding-group">
										<div class="garis"></div>
								<a class='link block9' href='#'>
									<b>
									<?php echo $this->mdl->jabatan("kep_istana_kepres_tampaksiring","Subbagian Tata Usaha","Analis Tata Usaha");?><br>
									<?php echo $this->mdl->loop_jabatan("Subbagian Tata Usaha","Analis Tata Usaha");?></b>
								</a><br><br>
                                <div class="garis"></div>
                                <a class='link block9' href='#'>
									<b>
									<?php echo $this->mdl->jabatan("kep_istana_kepres_tampaksiring","Subbagian Tata Usaha","Analis Keuangan");?><br>
									<?php echo $this->mdl->loop_jabatan("Subbagian Tata Usaha","Analis Keuangan");?></b>
								</a><br><br>
                                <div class="garis"></div>
                                <a class='link block9' href='#'>
									<b>
									<?php echo $this->mdl->jabatan("kep_istana_kepres_tampaksiring","Subbagian Tata Usaha","Analis Perencanaan Anggaran");?><br>
									<?php echo $this->mdl->loop_jabatan("Subbagian Tata Usaha","Analis Perencanaan Anggaran");?></b>
								</a><br><br>
                                <div class="garis"></div>
                                <a class='link block9' href='#'>
									<b>
									<?php echo $this->mdl->jabatan("kep_istana_kepres_tampaksiring","Subbagian Tata Usaha","Analis SDM Aparatur");?><br>
									<?php echo $this->mdl->loop_jabatan("Subbagian Tata Usaha","Analis SDM Aparatur");?></b>
								</a><br><br>
                                <div class="garis"></div>
                                <a class='link block9' href='#'>
									<b>
									<?php echo $this->mdl->jabatan("kep_istana_kepres_tampaksiring","Subbagian Tata Usaha","Pengolah Data");?><br>
									<?php echo $this->mdl->loop_jabatan("Subbagian Tata Usaha","Pengolah Data");?></b>
								</a><br><br>
                                <a class='link block9' href='#'>
									<b>
									<?php echo $this->mdl->jabatan("kep_istana_kepres_tampaksiring","Subbagian Tata Usaha","Pengadministrasi Umum");?><br>
									<?php echo $this->mdl->loop_jabatan("Subbagian Tata Usaha","Pengadministrasi Umum");?></b>
								</a><br><br>
								<div class="garis-end"></div>
							</div>
						</div>
						 	</li>
							 
						</ul>
					</li>
				</ul>

				 </li>
                 <li>
					<a class='link' id="kepala" href='#'>
						<b>Kepala Subbagian<br/>
						Rumah Tangga dan Protokol</b>
					<br>
					<?php echo $this->mdl->pejabat("Subbagian Rumah Tangga dan Protokol"); ?>					
				</a>

				<ul>
                    <li>
			
						<ul>
							<li style="margin-top:-20px">
								<div class="group" style="margin-top:20px">
									<div class="padding-group">
										<div class="garis"></div>
								<a class='link block9' href='#'>
									<b>
									<?php echo $this->mdl->jabatan("kep_istana_kepres_tampaksiring","Subbagian Rumah Tangga dan Protokol","Analis Protokol");?><br>
									<?php echo $this->mdl->loop_jabatan("Subbagian Rumah Tangga dan Protokol","Analis Protokol");?></b>
								</a><br><br>
                                <div class="garis"></div>
                                <a class='link block9' href='#'>
								<b>
									<?php echo $this->mdl->jabatan("kep_istana_kepres_tampaksiring","Subbagian Rumah Tangga dan Protokol","Analis Tata Usaha");?><br>
									<?php echo $this->mdl->loop_jabatan("Subbagian Rumah Tangga dan Protokol","Analis Tata Usaha");?></b>
								</a><br><br>
                                <div class="garis"></div>
                                <a class='link block9' href='#'>
								<b>
									<?php echo $this->mdl->jabatan("kep_istana_kepres_tampaksiring","Subbagian Rumah Tangga dan Protokol","Pengolah Data");?><br>
									<?php echo $this->mdl->loop_jabatan("Subbagian Rumah Tangga dan Protokol","Pengolah Data");?></b>
								</a><br><br>
                                <div class="garis"></div>
                                <a class='link block9' href='#'>
								<b>
									<?php echo $this->mdl->jabatan("kep_istana_kepres_tampaksiring","Subbagian Rumah Tangga dan Protokol","Pranata Jamuan");?><br>
									<?php echo $this->mdl->loop_jabatan("Subbagian Rumah Tangga dan Protokol","Pranata Jamuan");?></b>
								</a><br><br>
                                <div class="garis"></div>
                                <a class='link block9' href='#'>
								<b>
									<?php echo $this->mdl->jabatan("kep_istana_kepres_tampaksiring","Subbagian Rumah Tangga dan Protokol","Pengadministrasi Umum");?><br>
									<?php echo $this->mdl->loop_jabatan("Subbagian Rumah Tangga dan Protokol","Pengadministrasi Umum");?></b>
								</a><br><br>
                                <div class="garis"></div>
                                <a class='link block9' href='#'>
								<b>
									<?php echo $this->mdl->jabatan("kep_istana_kepres_tampaksiring","Subbagian Rumah Tangga dan Protokol","Petugas Protokol");?><br>
									<?php echo $this->mdl->loop_jabatan("Subbagian Rumah Tangga dan Protokol","Petugas Protokol");?></b>
								</a><br><br>
								<a class='link block9' href='#'>
								<b>
									<?php echo $this->mdl->jabatan("kep_istana_kepres_tampaksiring","Subbagian Rumah Tangga dan Protokol","Pramusaji Kepresidenan");?><br>
									<?php echo $this->mdl->loop_jabatan("Subbagian Rumah Tangga dan Protokol","Pramusaji Kepresidenan");?></b>
								</a><br><br><br>
								<div class="garis-end"></div>
							</div>
						</div>
						 	</li>
							 
						</ul>
					</li>
				</ul>

				 </li>
				 <li>
					<a class='link' id="kepala" href='#'>
						<b>Kepala Subbagian <br/>
							Bangunan</b>
					<br>
					<?php echo $this->mdl->pejabat("Subbagian Bangunan"); ?>
				<ul>
                    <li>
			
						<ul>
							<li style="margin-top:-20px">
								<div class="group" style="margin-top:20px">
									<div class="padding-group">
										<div class="garis"></div>
								<a class='link block9' href='#'>
									<b>
										<?php echo $this->mdl->jabatan("kep_istana_kepres_tampaksiring","Subbagian Bangunan","Analis Bangunan Gedung dan Permukiman");?><br>
										<?php echo $this->mdl->loop_jabatan("Subbagian Bangunan","Analis Bangunan Gedung dan Permukiman");?></b>
								</a><br><br>
                                <div class="garis"></div>
                                <a class='link block9' href='#'>
									<b>
										<?php echo $this->mdl->jabatan("kep_istana_kepres_tampaksiring","Subbagian Bangunan","Analis Tata Usaha");?><br>
										<?php echo $this->mdl->loop_jabatan("Subbagian Bangunan","Analis Tata Usaha");?></b>
								</a><br><br>
                                <div class="garis"></div>
                                <a class='link block9' href='#'>
								<b>
										<?php echo $this->mdl->jabatan("kep_istana_kepres_tampaksiring","Subbagian Bangunan","Pengelola Sarana dan Prasarana Kantor");?><br>
										<?php echo $this->mdl->loop_jabatan("Subbagian Bangunan","Pengelola Sarana dan Prasarana Kantor");?></b>
								</a><br><br>
                                <div class="garis"></div>
                                <a class='link block9' href='#'>
								<b>
										<?php echo $this->mdl->jabatan("kep_istana_kepres_tampaksiring","Subbagian Bangunan","Pengolah Data");?><br>
										<?php echo $this->mdl->loop_jabatan("Subbagian Bangunan","Pengolah Data");?></b>
								</a><br><br>
                                <div class="garis"></div>
                                <a class='link block9' href='#'>
									<b>
										<?php echo $this->mdl->jabatan("kep_istana_kepres_tampaksiring","Subbagian Bangunan","Teknisi Rancang Bangun");?><br>
										<?php echo $this->mdl->loop_jabatan("Subbagian Bangunan","Teknisi Rancang Bangun");?></b>
								</a><br><br>
                                <div class="garis"></div>
                                <a class='link block9' href='#'>
								<b>
										<?php echo $this->mdl->jabatan("kep_istana_kepres_tampaksiring","Subbagian Bangunan","Teknisi Peralatan, Listrik dan Elektronika");?><br>
										<?php echo $this->mdl->loop_jabatan("Subbagian Bangunan","Analis Bangunan Gedung dan Permukiman");?></b>
								</a><br><br>
								<a class='link block9' href='#'>
								<b>
										<?php echo $this->mdl->jabatan("kep_istana_kepres_tampaksiring","Subbagian Bangunan","Pengadministrasi Umum");?><br>
										<?php echo $this->mdl->loop_jabatan("Subbagian Bangunan","Analis Bangunan Gedung dan Permukiman");?></b>
								</a><br><br><br>
								<div class="garis-end"></div>
							</div>
						</div>
						 	</li>
							 
						</ul>
					</li>
				</ul>

				 </li>


				 <li>
					<div class="group">
						<div class="padding-group">
						<div class="garis"></div>
						<a class='link block9' href='#'>
							<b><?php echo $this->mdl->jabatan("kep_istana_kepres_tampaksiring","KEPALA ISTANA KEPRESIDENAN TAMPAKSIRING","Analis Tata Usaha");?><br>
							<?php echo $this->mdl->loop_jabatan("KEPALA ISTANA KEPRESIDENAN TAMPAKSIRING","Analis Tata Usaha");?></b>
						</a><br><br>
						<div class="garis"></div>
						<a class='link block9' href='#'>
						<b><?php echo $this->mdl->jabatan("kep_istana_kepres_tampaksiring","KEPALA ISTANA KEPRESIDENAN TAMPAKSIRING","Analis Aset Negara");?><br>
							<?php echo $this->mdl->loop_jabatan("KEPALA ISTANA KEPRESIDENAN TAMPAKSIRING","Analis Aset Negara");?></b>
						</a><br><br>
						</a><br/><br/>
						<div class="garis"></div>
						<a class='link block9' href='#'>
						<b><?php echo $this->mdl->jabatan("kep_istana_kepres_tampaksiring","KEPALA ISTANA KEPRESIDENAN TAMPAKSIRING","Penyusun Rencana Kebutuhan Rumah Tangga dan Perlengkapan");?><br>
							<?php echo $this->mdl->loop_jabatan("KEPALA ISTANA KEPRESIDENAN TAMPAKSIRING","Penyusun Rencana Kebutuhan Rumah Tangga dan Perlengkapan");?></b>
						</a><br><br>
						</a><br><br>
						<div class="garis"></div>
						<a class='link block9' href='#'>
						<b><?php echo $this->mdl->jabatan("kep_istana_kepres_tampaksiring","KEPALA ISTANA KEPRESIDENAN TAMPAKSIRING","Pengolah Data");?><br>
							<?php echo $this->mdl->loop_jabatan("KEPALA ISTANA KEPRESIDENAN TAMPAKSIRING","Pengolah Data");?></b>
						</a><br><br>
                        <b><?php echo $this->mdl->jabatan("kep_istana_kepres_tampaksiring","KEPALA ISTANA KEPRESIDENAN TAMPAKSIRING","Pengadministrasi Umum");?><br>
							<?php echo $this->mdl->loop_jabatan("KEPALA ISTANA KEPRESIDENAN TAMPAKSIRING","Pengadministrasi Umum");?></b>
						</a><br><br>
						<div class="garis-end">&nbsp;</div>
					 </div>
					</div>
				 </li>
			 </ul>
		</li>
	</ul>
</div>

