<?php
$id_msg = $this->input->post("id");
$this->db->where("id",$id_msg);
$db = $this->db->get("data_tanya_dokter")->row();
$id_peg = isset($db->id_sender)?($db->id_sender):"";
$id_dokter = isset($db->id_dokter)?($db->id_dokter):$this->mdl->idu();
$sts 	   = isset($db->sts)?($db->sts):"";

 

$peg    = $this->m_reff->getDataPegawai($id_peg);
$jk_peg = isset($peg->jk)?($peg->jk):"l";
$nama_peg = isset($peg->nama)?($peg->nama):"";
?>

<!-- main-content-body -->
<div class="main-content-body">
	<div class="row row-sm">
		<div class="col-xl-12 col-lg-12">
		<!-- <?php
			if($sts==0){?>
			<br>
			<center><button class="btn btn-sm bg-info text-white" onclick="akhiri(`<?php echo $id_msg;?>`)"> akhiri obrolan </button></button></center>
			
			<?php } ?> -->
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
                    <a href="" class='' style="float:right;margin-top:-50px;margin-right:20px">&times; close</a>
					<div class="main-chat-body" id="ChatBody">
						<div class="content-inner">


							<div class="content ex1" id="chatlist"></div>
						</div>
					</div>
				</div>

				<!-- <?php
			if($sts==0){?>
				<div class="main-chat-footer">
					<input autocomplete="off" onkeyup="type_teks()" id="type_teks" class="form-control" placeholder="Type your message here..." type="text">
					<a class="main-msg-send" href="javascript:sent_chat()"><i class="far fa-paper-plane"></i></a>
				</div>
			<?php } ?> -->
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
				 
                var url = "<?php echo site_url("riwayat_obrolan/chat_list"); ?>";
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


		
		</script>





	</div>
</div>