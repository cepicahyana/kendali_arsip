<?php
$id_msg = $this->input->post("id");
$this->db->where("id",$id_msg);
$db = $this->db->get("data_tanya_dokter")->row();
$id_peg = isset($db->id_sender)?($db->id_sender):"";
$id_dokter = isset($db->id_dokter)?($db->id_dokter):$this->mdl->idu();

if($id_dokter!=$this->mdl->idu()){
echo "<div class='card card-body'><h4>Pertanyaan ini baru saja telah ditanggapi oleh dokter lain.</h4></div>

<center>
<a href='' class='btn btn-secondary'>close</a><br>
</center>
<br>
";
return false;
}else{
	$this->db->where("id",$id_msg);
	$this->db->set("id_dokter",$this->mdl->idu());
	$this->db->update("data_tanya_dokter");
}

$peg    = $this->m_reff->getDataPegawai($id_peg);
$jk_peg = isset($peg->jk)?($peg->jk):"l";
$nama_peg = isset($peg->nama)?($peg->nama):"";
?>

<!-- main-content-body -->
<div class="main-content-body">
	<div class="row row-sm">
		<div class="col-xl-12 col-lg-12">

			<style>
				.ex1 {
					height: 500px;
					overflow: scroll;
				}
			</style>


			<div class="card">
				<div class="main-content-body ">
					<div class="main-chat-header">
						<div class="main-img-user"><img alt="" src="assets/<?php echo $jk_peg;?>.png"></div>
						<div class="main-chat-msg-name">
							<h6><?php echo $nama_peg;?></h6><small><?php echo $this->tanggal->hariLengkapJam($db->tgl, "/");?></small>
                         
						</div>

					</div><!-- main-chat-header -->
                    <a href="" class='btn btn-secondary' style="float:right;margin-top:-50px;margin-right:20px">close</a>
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
				 
                var url = "<?php echo site_url("dokter/chat_list"); ?>";
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
					url: '<?php echo site_url("dokter/saveChat"); ?>',
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

				var id_msg = "<?php echo $this->input->post('id'); ?>";
				posisi = "chat";
				open = true;
				$.ajax({
					url: '<?php echo site_url("dokter/saveChat"); ?>',
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
					url: '<?php echo site_url("dokter/chat_replay"); ?>',
					data: param,
					method: "POST",
					dataType: "JSON",
					beforeSend: function() {

					},
					success: function(data) {
                        token = data["token"];
						$("#isiChat").append(data["isi"]);
						if (data["isi"]) {
							scroll();
						}
					}
				});
			}


			setInterval(function() {
				replays();
			}, 5000);




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
							 
							
							var url = "<?php echo site_url("dokter/hapus_com"); ?>";
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
	  
			
		</script>





	</div>
</div>