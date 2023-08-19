<html>
<head>
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
	background-color:white;
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

</head>
<body>
	<div class="tree">
	<ul>
		<li><a class="link" id="kepala" href="#"><b>Kepala Bagian Acara</b>
			<br><?php echo $this->mdl->pejabat("KEPALA BAGIAN ACARA"); ?>
			<br> 
			</a>
			 <ul> 

				 <li>
					<div class="group1">	
					<a class="link" id="kepala" href="#">		
					<b>Kelompok</b><br>
					<b>Jabatan</b><br>
					<b>Fungsional</b><br>
				</a>
				 </li>

					<li>				
						<a class="link pb5" href="#" id="kepala">
							<b>Kepala Subbagian Acara I<br></b> 
							<?php echo $this->mdl->pejabat("Subbagian Acara I"); ?>
						</a>
						<ul>
							<li style="margin-top:-20px">
								<div class="group" style="margin-top:20px">
									<div class="padding-group">
										<div class="garis"></div>
						 
								<a class="link block9" href="#">
								<b><?php echo $this->mdl->jabatan("kabag_acara","Subbagian Acara I","analis protokol");?></b><br>
								<?php echo $this->mdl->loop_jabatan("Subbagian Acara I","analis protokol");?>
								</a><br><br><br>

								<a class="link block9" href="#">
								<b><?php echo $this->mdl->jabatan("kabag_acara","Subbagian Acara I","petugas protokol kepresidenan");?></b><br>
								<?php echo $this->mdl->loop_jabatan("Subbagian Acara I","petugas protokol kepresidenan");?>
								</a><br><br><br>
								<div class="garis-end"></div>
							</div>
						</div>
						 	</li>
							 
						</ul>
					</li>

					<li>				
						<a class="link pb5" href="#" id="kepala">
							<b>Kepala Subbagian Acara II<br></b>
							<?php echo $this->mdl->pejabat("Subbagian Acara II"); ?>

						</a>
						<ul>
							<li style="margin-top:-20px">
								<div class="group" style="margin-top:20px">
									<div class="padding-group">
										<div class="garis"></div>
								<a class="link block9" href="#">
								<b><?php echo $this->mdl->jabatan("kabag_acara","Subbagian Acara II","analis protokol");?></b><br>
								<?php echo $this->mdl->loop_jabatan("Subbagian Acara II","analis protokol");?>
								</a><br><br><br>

								<a class="link block9" href="#">
								<b><?php echo $this->mdl->jabatan("kabag_acara","Subbagian Acara II","petugas protokol kepresidenan");?></b><br>
								<?php echo $this->mdl->loop_jabatan("Subbagian Acara II","petugas protokol kepresidenan");?>
								</a><br><br><br>
								<div class="garis-end"></div>
							</div>
						</div>
						 	</li>
							 
						</ul>
					</li>

					<li>				
						<a class="link pb5" href="#" id="kepala">
							<b>Kepala Subbagian Acara III<br></b>
							<?php echo $this->mdl->pejabat("Subbagian Acara III"); ?>

						</a>
						<ul>
							<li style="margin-top:-20px">
								<div class="group" style="margin-top:20px">
									<div class="padding-group">
										<div class="garis"></div>
								<a class="link block9" href="#">
								<b><?php echo $this->mdl->jabatan("kabag_acara","Subbagian Acara III","analis protokol");?></b><br>
								<?php echo $this->mdl->loop_jabatan("Subbagian Acara III","analis protokol");?>
								</a><br><br><br>

								<a class="link block9" href="#">
								<b><?php echo $this->mdl->jabatan("kabag_acara","Subbagian Acara III","petugas protokol kepresidenan");?></b><br>
								<?php echo $this->mdl->loop_jabatan("Subbagian Acara III","petugas protokol kepresidenan");?>
								</a><br><br><br>
								<div class="garis-end"></div>
							</div>
						</div>
						 	</li>
							 
						</ul>
					</li>
				</div>


</body>
</html>