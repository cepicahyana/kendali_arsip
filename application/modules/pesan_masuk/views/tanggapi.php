<?php
$id_msg = $this->input->post("id");
$this->db->where("id",$id_msg);
$db = $this->db->get("data_tanya_admin")->row();

$id_peg = isset($db->id_sender)?($db->id_sender):"";
$id_pesan_masuk = isset($db->id_pesan_masuk)?($db->id_pesan_masuk):$this->mdl->idu();
$sts 	   = isset($db->sts)?($db->sts):"";

 

$peg    = $this->m_reff->getDataPegawai($id_peg);
$jk_peg = isset($peg->jk)?($peg->jk):"l";
$nama_peg = isset($peg->nama)?($peg->nama):"";
?>

<!-- main-content-body -->
<div class="main-content-body">

	<div class="row row-sm">
		<div class="col-xl-12 col-lg-12">
		<?php
			if($sts==0 and $this->session->level=="pic_covid"){?>
			<br>

			<center><button class="btn btn-sm bg-danger text-white" onclick="akhiri(`<?php echo $id_msg;?>`)"> akhiri obrolan </button></center>
			
			<?php } else{ 
				echo "<br><br>";
			}?>
			<style>
				.ex1 {
					height: 500px;
					overflow: scroll;
				}
			</style>

<a href="" class='' style="float:right;margin-top:-25px;margin-right:20px"> &times; close</a>
			<div class="card">
				<div class="main-content-body ">
					<div class="main-chat-header">
						
						<div class="main-img-user"><img alt="" src="assets/<?php echo $jk_peg;?>.png"></div>
						<div class="main-chat-msg-name">
							<h6><?php echo $nama_peg;?></h6><small><?php echo $this->tanggal->hariLengkapJam($db->tgl, "/");?></small>
						 </div>
						
					</div><!-- main-chat-header -->
                   
					<div class="main-chat-body" id="ChatBody">
						<div class="content-inner">


							<div class="content ex1" id="chatlist"></div>
						</div>
					</div>
				</div>

				<?php
			if($sts==0 and $this->session->level=="pic_covid"){?>
				<div class="main-chat-footer">
					<input autocomplete="off" onkeyup="type_teks()" id="type_teks" class="form-control" placeholder="Type your message here..." type="text">
					<a class="main-msg-send" href="javascript:sent_chat()"><i class="far fa-paper-plane"></i></a>
				</div>
			<?php } ?>
			</div>
		
		</div>













		<script>
			var posisi;
			reload_chat();
			setTimeout(function() {
				scroll();
			}, 1000);

			function hapus_chat(id) {
				swal({
						title: 'Hapus ?',
						text: "",
						type: 'warning',
						buttons:{
							cancel: {
								visible: true,
								text : 'batal',
								className: 'btn btn-danger'
							},        			
							confirm: {
								text : 'Ya',
								className : 'btn btn-success'
							}
						}
					}).then((willDelete) => {
						if (willDelete) {
							 
							
							var url = "<?php echo site_url("pesan_masuk/hapus_chat_list"); ?>";
										var param = {
											id: id,
											<?php echo $this->m_reff->tokenName() ?>: token
										};
										$.ajax({
											type: "POST",
											dataType: "json",
											data: param,
											url: url,
											success: function(val) {
												$('#msg'+id).fadeOut(600);
												token = val['token'];
											}
										});
									
							
						}  
					});
		    
	  };
	  
			
			function reload_chat() {
				var id = "<?php echo $this->input->post('id'); ?>";
				 
                var url = "<?php echo site_url("pesan_masuk/chat_list"); ?>";
					var param = {
						id: id,
						<?php echo $this->m_reff->tokenName() ?>: token
					};
					$.ajax({
						type: "POST",
						dataType: "json",
						data: param,
						url: url,
						success: function(val) {
							$('#chatlist').html(val["data"]);
							token = val['token'];
						}
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
				var id_msg = "<?php echo $this->input->post('id'); ?>";
				posisi = "chat";
				open = true;
				$.ajax({
					url: '<?php echo site_url("pesan_masuk/saveChat"); ?>',
					data: {
						id_msg: id_msg,
						msg: text,
                        <?php echo $this->m_reff->tokenName() ?>: token
					},
					method: "POST",
					dataType: "JSON",
					beforeSend: function() {

					},
					success: function(data) {
						token=data["token"];
						$("#isiChat").append(data["data"]);
						$("#type_teks").val("");
						scroll();

					}
				});
			}

			function sendChat(text) {
loading("ChatBody");
				var id_msg = "<?php echo $this->input->post('id'); ?>";
				posisi = "chat";
				open = true;
				$.ajax({
					url: '<?php echo site_url("pesan_masuk/saveChat"); ?>',
					data: {
						id_msg: id_msg,
						msg: text,
                        <?php echo $this->m_reff->tokenName() ?>: token
					},
					method: "POST",
					dataType: "JSON",
					beforeSend: function() {

					},
					success: function(data) {
						token=data["token"];
						$("#isiChat").append(data["data"]);
						$("#type_teks").val("");
						scroll();
						unblock("ChatBody");
					}
				});
			}

			function scroll() {
				var element = document.getElementById("chatlist");
				element.scrollTop = element.scrollHeight;

			}


			function replays() {
				var id_msg = "<?php echo $this->input->post('id'); ?>";
                var param = {
                    id_msg: id_msg,
				    <?php echo $this->m_reff->tokenName() ?>: token
			        };

				$.ajax({
					url: '<?php echo site_url("pesan_masuk/getNewReplay"); ?>',
					data: param,
					method: "POST",
					dataType: "JSON",
					beforeSend: function() {

					},
					success: function(data) {
                      //  token = data["token"];
						$("#isiChat").append(data["data"]);
						if (data["data"]) {
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