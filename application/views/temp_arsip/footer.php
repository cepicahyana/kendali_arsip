 
		<!-- Footer closed -->
	</div>
		<!-- page closed -->

		<!--- Back-to-top --->
		<a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>

		<!--- JQuery min js --->
		<script src="<?=base_url();?>assets_arsip/plugins/jquery/jquery.min.js"></script>

		<!--- Bootstrap Bundle js --->
		<script src="<?=base_url();?>assets_arsip/plugins/bootstrap/popper.min.js"></script>
		<script src="<?=base_url();?>assets_arsip/plugins/bootstrap/js/bootstrap.min.js"></script>

		<!--- Ionicons js --->
		<script src="<?=base_url();?>assets_arsip/plugins/ionicons/ionicons.js"></script>

		<!--- Moment js --->
		<script src="<?=base_url();?>assets_arsip/plugins/moment/moment.js"></script>

		<!--- JQuery sparkline js --->
		<script src="<?=base_url();?>assets_arsip/plugins/jquery-sparkline/jquery.sparkline.min.js"></script>

		<!--- P-scroll js --->
		<script src="<?=base_url();?>assets_arsip/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
		<script src="<?=base_url();?>assets_arsip/plugins/perfect-scrollbar/p-scroll.js"></script>

		<!--- Switcher js --->
		<script src="<?=base_url();?>assets_arsip/switcher/js/switcher.js"></script>

		<!--- Eva-icons js --->
		<script src="<?=base_url();?>assets_arsip/js/eva-icons.min.js"></script>



		<!--- Sidebar js --->
		<script src="<?=base_url();?>assets_arsip/plugins/side-menu/sidemenu.js"></script>

		<!--- sticky js --->
		<script src="<?=base_url();?>assets_arsip/js/sticky.js"></script>

		<!--- Right-sidebar js --->
		<script src="<?=base_url();?>assets_arsip/plugins/sidebar/sidebar.js"></script>
		<script src="<?=base_url();?>assets_arsip/plugins/sidebar/sidebar-custom.js"></script>

		<!--- Index js --->
		<script src="<?=base_url();?>assets_arsip/js/script.js"></script>

		<!--themecolor js-->
		<script src="<?=base_url();?>assets_arsip/js/themecolor.js"></script>
        <script src="<?php echo base_url()?>assets_arsip/plugins/select2/js/select2.min.js"></script>
        <script src="<?php echo base_url()?>assets_arsip/plugins/sumoselect/jquery.sumoselect.js"></script>
		<!--swither-styles js-->
		<script src="<?=base_url();?>assets_arsip/js/swither-styles.js"></script>
        <script src="<?php echo base_url()?>assets/js/plugins/sweetalert.min.js"></script>
		<!--- Custom js --->
		<script src="<?=base_url();?>assets_arsip/js/custom.js"></script>
        <script type="text/javascript"> 
   var token = $("#token_footer").val();
		  $(document).off("click",".menuclick").on("click",".menuclick",function (event, messages) {
			   event.preventDefault()
			   var url = $(this).attr("href");
			   var title = $(this).attr("title");
			   var session = "1";
			 
			     if(url=="<?php echo base_url()?>login/logout")
				 {
					 window.location.href="<?php echo base_url()?>login/logout";
				 } 
				   
			    // $(this).parent().addClass('active').siblings().removeClass('active');
                $("a").removeClass('active');
			    $(this).addClass('active').siblings().removeClass('active');
				$(".content").html('<center><div style="height:100%"> <button class="btn btn-dark" type="button" disabled=""> <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading... </button></div></center>')
                
               

            $.ajax({
            type: "POST",
            dataType: "json",
            data: {ajax:"yes",<?php echo $this->m_reff->tokenName()?>:token},
            url: url,
            success: function(data){
                // $("#token_footer").val(data["token"]);
                token=data["token"];
                $('.modal.aside').remove();
                history.replaceState(title, title, url);
                $('title').html(title);
                $(".content").html(data["data"]);
                }
            });

		  })
	 </script> 
	</body>
</html>