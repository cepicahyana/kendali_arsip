<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
	<div>
		<h4 class="content-title mb-2">Tanya dokter</h4>
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">
						Konsultasikan masalah kesehatan anda dan keluarga anda</a></li>
				<!-- <li class="breadcrumb-item active" aria-current="page">Project</li> -->
			</ol>
		</nav>
	</div>

</div>


<!-- main-content-body -->
<div class="main-content-body">
	<div class="row row-sm">
		<div class="col-xl-8 col-lg-7">

			<style>
				.ex1 {
					height: 400px;
					overflow: scroll;
				}
			</style>


			<div class="card">
				<div class="main-content-body ">
					<div class="main-chat-header">
						<div class="main-img-user"><img alt="" src="assets/img/faces/9.jpg"></div>
						<div class="main-chat-msg-name">
							<h6>Dokter</h6><small>Last seen: 2 minutes ago</small>
						</div>

					</div><!-- main-chat-header -->
					<div class="main-chat-body" id="ChatBody">
						<div class="content-inner">
							<div class="content ex1" id="chatlist"></div>
						</div>
					</div>
				</div>


				<div class="main-chat-footer">
					<input autocomplete="off" onkeyup="type_teks()" id="type_teks" class="form-control" placeholder="Type your message here..." type="text">
					<a class="main-msg-send" href="javascript:sendChatManual()"><i class="far fa-paper-plane"></i></a>
				</div>

			</div>
		</div>













		<script>
			var posisi;
			reload_chat();
			setTimeout(function() {
				scroll();
			}, 1000);

			function reload_chat() {
				var id = "<?php echo $this->input->post('id'); ?>";
				$("#chatlist").html("mohon tunggu...");
				$.post("<?php echo base_url() ?>dokter/chat_list", {
					id: id
				}, function(data, status) {
					$("#chatlist").html(data);
				});
			}

			function sent_chat() {
				var inField = $("#type_teks").val();
				sendChat(inField);
			}

			function type_teks(e) {

				var inField = $("#type_teks").val();
				var charCode;
				if (e && e.which) {
					charCode = e.which;
				} else if (window.event) {
					e = window.event;
					charCode = e.keyCode;
				}


				if (charCode == 13 && inField) {

					sendChat(inField);
				}

			}

			function sendChatManual() {
				var text = $("#type_teks").val();
				var receiver = "<?php echo $this->input->post('id'); ?>";
				posisi = "chat";
				open = true;
				$.ajax({
					url: '<?php echo site_url("dokter/saveChat"); ?>',
					data: {
						receiver: receiver,
						msg: text
					},
					method: "POST",
					dataType: "JSON",
					beforeSend: function() {

					},
					success: function(data) {
						$("#isiChat").append(data.isi);
						$("#type_teks").val("");
						scroll();

					}
				});
			}

			function sendChat(text) {
				var receiver = "<?php echo $this->input->post('id'); ?>";
				posisi = "chat";
				open = true;
				$.ajax({
					url: '<?php echo site_url("dokter/saveChat"); ?>',
					data: {
						receiver: receiver,
						msg: text
					},
					method: "POST",
					dataType: "JSON",
					beforeSend: function() {

					},
					success: function(data) {
						$("#isiChat").append(data.isi);
						$("#type_teks").val("");
						scroll();

					}
				});
			}

			function scroll() {
				var element = document.getElementById("chatlist");
				element.scrollTop = element.scrollHeight;

			}


			function replays() {
				var sender = "<?php echo $this->input->post('id'); ?>";
				$.ajax({
					url: '<?php echo site_url("dokter/chat_replay"); ?>',
					data: {
						sender: sender
					},
					method: "POST",
					dataType: "JSON",
					beforeSend: function() {

					},
					success: function(data) {
						$("#isiChat").append(data.isi);
						if (data.isi) {
							scroll();
						}
					}
				});
			}


			setInterval(function() {
				replays();
			}, 5000);
		</script>





	</div>
</div>