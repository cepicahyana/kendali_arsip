
    <script src="<?php echo base_url()?>assets/js/plugins/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/ripple.js"></script>
    <script src="<?php echo base_url()?>assets/js/pcoded.min.js"></script>
 
	    
		<!-- Full calendar js -->
	<script src="<?php echo base_url()?>assets/js/plugins/moment.js"></script>
	<script src="<?php echo base_url()?>assets/js/plugins/jquery-ui.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/plugins/fullcalendar.min.js"></script>
	<script src='<?php echo base_url()?>plug/fullcalendar/locale-all.js'></script> 
	 
<script src="<?php echo base_url()?>assets/js/plugins/jquery.bootstrap.wizard.min.js"></script>
<!-- select2 Js -->
<script src="<?php echo base_url()?>assets/js/plugins/select2.full.min.js"></script>
<script src="<?php echo base_url()?>assets/js/plugins/lightbox.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/plugins/bootstrap-notify.min.js"></script>
<script src="<?php echo base_url()?>assets/js/pages/ac-notification.js"></script>
 <script src="<?php echo base_url()?>assets/js/plugins/sweetalert.min.js"></script>
<script src="<?php echo base_url()?>assets/js/pages/ac-alert.js"></script>
<script src="<?php echo base_url()?>plug/js/bootstrap-select.js"></script>
  <script type="text/javascript" src="<?php echo base_url()?>plug/dist/bootstrap-clockpicker.min.js"></script>
  <script src="<?php echo base_url()?>plug/js/nestable.js"></script>
 
  <script type="text/javascript"> 
		  $(document).off("click",".menuclick").on("click",".menuclick",function (event, messages) {
			   event.preventDefault()
			   var url = $(this).attr("href");
			   var title = $(this).attr("title");
			   var session = "1";
			 
			     if(url=="<?php echo base_url()?>login/logout")
				 {
					 window.location.href="<?php echo base_url()?>login/logout";
				 } 
				   
			    $(this).parent().addClass('active').siblings().removeClass('active');
				$(".content").html('<center><div class="card-body" id="loadingKontak"> Loading....<br><div class="spinner-grow text-primary" role="status"><span class="sr-only">Loading...</span></div><div class="spinner-grow text-secondary" role="status"><span class="sr-only">Loading...</span></div><div class="spinner-grow text-success" role="status"><span class="sr-only">Loading...</span></div><div class="spinner-grow text-danger" role="status"><span class="sr-only">Loading...</span></div><div class="spinner-grow text-warning" role="status"><span class="sr-only">Loading...</span></div><div class="spinner-grow text-info" role="status"><span class="sr-only">Loading...</span></div><div class="spinner-grow text-light" role="status"><span class="sr-only">Loading...</span></div><div class="spinner-grow text-dark" role="status"><span class="sr-only">Loading...</span></div></div></center>')
				$.post(url,{ajax:"yes"},function(data){
				
				$('.modal.aside').remove();
				  history.replaceState(title, title, url);
				  $('title').html(title);
				  $(".content").html(data);
			  })
		  })
	 </script> 
<script type="text/javascript">
$('.clockpicker').clockpicker();
</script>
<script type="text/javascript">
$('.clockpicker').clockpicker()
	.find('input').change(function(){
		console.log(this.value);
	}); 
 
 
</script>

<script>
    $(document).ready(function() {
        $('#besicwizard').bootstrapWizard({
            withVisible: false,
            'nextSelector': '.button-next',
            'previousSelector': '.button-previous',
            'firstSelector': '.button-first',
            'lastSelector': '.button-last'
        });
        $('#btnwizard').bootstrapWizard({
            withVisible: false,
            'nextSelector': '.button-next',
            'previousSelector': '.button-previous',
            'firstSelector': '.button-first',
            'lastSelector': '.button-last'
        });
        $('#progresswizard').bootstrapWizard({
            withVisible: false,
            'nextSelector': '.button-next',
            'previousSelector': '.button-previous',
            'firstSelector': '.button-first',
            'lastSelector': '.button-last',
            onTabShow: function(tab, navigation, index) {
                var $total = navigation.find('li').length;
                var $current = index + 1;
                var $percent = ($current / $total) * 100;
                $('#progresswizard .progress-bar').css({
                    width: $percent + '%'
                });
            }
        });
        $('#validationwizard').bootstrapWizard({
            withVisible: false,
            'nextSelector': '.button-next',
            'previousSelector': '.button-previous',
            'firstSelector': '.button-first',
            'lastSelector': '.button-last',
            onNext: function(tab, navigation, index) {
                if (index == 1) {
                    if (!$('#validation-t-name').val()) {
                        $('#validation-t-name').focus();
                        $('.form-1').addClass('was-validated');
                        return false;
                    }
                    if (!$('#validation-t-email').val()) {
                        $('#validation-t-email').focus();
                        $('.form-1').addClass('was-validated');
                        return false;
                    }
                    if (!$('#validation-t-pwd').val()) {
                        $('#validation-t-pwd').focus();
                        $('.form-1').addClass('was-validated');
                        return false;
                    }
                }
                if (index == 2) {
                    if (!$('#validation-t-address').val()) {
                        $('#validation-t-address').focus();
                        $('.form-2').addClass('was-validated');
                        return false;
                    }
                }
            }
        });
        $('#tabswizard').bootstrapWizard({
            'nextSelector': '.button-next',
            'previousSelector': '.button-previous',
        });
        $('#verticalwizard').bootstrapWizard({
            'nextSelector': '.button-next',
            'previousSelector': '.button-previous',
        });
    });
</script>

	
</body>
</html>
	
		
	