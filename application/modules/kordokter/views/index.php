<script>
	$("a").removeClass("menuclick");
</script>
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
	<div>
		<h4 class="content-title mb-2">Konsultasi </h4>
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">
						Data yang muncul dibawah merupakan percakapan seluruh dokter dengan pasien</a></li>
				<!-- <li class="breadcrumb-item active" aria-current="page">Project</li> -->
			</ol>
		</nav>
	</div>

</div>

<div class="cards">
	<div class="row">
		<div class="col-md-12">
			<div id="shareInfo"></div>
		</div>
	</div>



	<!-- <div class="card card-style">
<div class="content mb-0">
<h3 class="bolder"> Bagikan informasi</h3>
<p>
Pesan yang anda bagikan   akan terlihat diberanda orang lain
</p>
 
 
<div class="input-style input-style-1 input-required">
<span class="input-style-1-inactive">Mak.250 karakter</span>
<em>(required)</em>
<textarea  style="max-height:80px;border:#DCDCDC solid 1px;padding:15px" 
maxlength="250" name="update_status" class="font-22" placeholder="ketik disini..."></textarea>
</div>
 <a href="javascript:kirim_status()" class="btn btn-m btn-full mb-3 rounded-xl text-uppercase font-900 shadow-s bg-highlight">Kirim</a>
</div>
</div> -->







	<script>
		var replayID;

		setInterval(function() {
			reload_status();
		}, 20000);

		setTimeout(function() {
			reload_status();
		}, 100);

		var load = loading("shareInfo");
		$("#shareInfo").html(load);


		// function getNewReplay() {
		// 	var url = "<?php echo site_url("kordokter/getNewReplay"); ?>";
		// 	var param = {
		// 		<?php echo $this->m_reff->tokenName() ?>: token
		// 	};
		// 	$.ajax({
		// 		type: "POST",
		// 		dataType: "json",
		// 		data: param,
		// 		url: url,
		// 		success: function(val) {
		// 			// token   =  val['token'];
		// 			$("#msgReplay").append($(val['data']).fadeIn('slow'));

		// 			//$("#msg"+idm).html(data);
		// 			// $("#status_mdl").hideMenu();
		// 			// $("#msg"+idm).hide().show(1000);


		// 		}
		// 	});
		// }



		function reload_status() {

			var load = loading("shareInfo");
			$("#shareInfo").html(load);
			var url = "<?php echo site_url("kordokter/reload_status"); ?>";
			var param = {
				<?php echo $this->m_reff->tokenName() ?>: token
			};
			$.ajax({
				type: "POST",
				dataType: "json",
				data: param,
				url: url,
				success: function(val) {
					token = val['token'];
					$("#shareInfo").html(val['data']);
				}
			});

		}

		function kirim_status() {
			var msg = $("[name='update_status']").val();
			if (!msg) {
				notif("<span class='text-black'>mohon tulis pesan yang akan dikirim</span>");
				return false;
			}
			var url = "<?php echo site_url("kordokter/kirim_status"); ?>";
			var param = {
				msg: msg,
				<?php echo $this->m_reff->tokenName() ?>: token
			};
			$.ajax({
				type: "POST",
				dataType: "json",
				data: param,
				url: url,
				success: function(val) {
					token = val['token'];
					if (val["data"].error == true) {
						var msg = val["data"].info;
						swal(msg, {
							icon: "warning",
							buttons: {
								confirm: {
									className: 'btn btn-success'
								}
							}
						});

						return false;
					}
					reload_status();
					// $("#newStatus").append(val["data"]);

					// $("#newStatus").prepend($(val["data"]).fadeIn('slow'));     
					$("[name='update_status']").val("");
					// $("#newStatus").hide().show(1000);


					swal("Terkirim", {
						icon: "success",
						buttons: {
							confirm: {
								className: 'btn btn-success'
							}
						}
					});

				}
			});

		}

		function kirim_balasan() {
			var idm = replayID;
			var msg = $("[name='msg_balasan']").val();


			var url = "<?php echo site_url("kordokter/kirim_balasan"); ?>";
			var param = {
				msg: msg,
				idm: idm,
				<?php echo $this->m_reff->tokenName() ?>: token
			};
			$.ajax({
				type: "POST",
				dataType: "json",
				data: param,
				url: url,
				success: function(val) {
					token = val['token'];
					$("#msgReplay").append($(val['data']).fadeIn('slow'));
					$("[name='msg_balasan']").val("");
					//$("#msg"+idm).html(data);
					// $("#status_mdl").hideMenu();
					// $("#msg"+idm).hide().show(1000);
					$("#mdl_modal").modal("hide");

				}
			});
		}


		function lihat_obrolan(id) {
			var url = "<?php echo site_url("kordokter/lihat_obrolan"); ?>";
			var param = {
				id: id,
				<?php echo $this->m_reff->tokenName() ?>: token
			};
			// $("#isi").html(cantik());
			$("#mdl_utama").modal();
			$.ajax({
				type: "POST",
				dataType: "json",
				data: param,
				url: url,
				success: function(val) {
					token = val['token'];
					$("#isi_modal").html(val["data"]);
				}
			});
		}
	</script>

	<script>
		function replay(id, msg) {
			// $('#status_mdl').showMenu();
			// $('#statusReplayContent').html(msg);
			// $('#replayID').val(id);
			//$('#chatlist').html(msg);
			//$('#idTanyakorDokter').html(id);
			$('#mdl_modal').modal();
			// $('#replayID').val(id);
			//replayID = id;
			var url = "<?php echo site_url("kordokter/tanggapi"); ?>";
					var param = {
						id: id,
						msg:msg,
						<?php echo $this->m_reff->tokenName() ?>: token
					};
					loading("shareInfo");
					$.ajax({
						type: "POST",
						dataType: "json",
						data: param,
						url: url,
						success: function(val) {
							$('#isi_modal').html(val["data"]);
							token = val['token'];
							reload_status();
							unblock("shareInfo");

						}
					});

		}
	</script>






	<script>
		var compus;
		var ucapan;

		var idhapus;
		//  function hapus_sts(id){
		// 	 idhapus=id;
		// 	 setTimeout(function(){ $('#status_mdl').hideMenu(); }, 200);

		// 	$('#menu-hapus').showMenu();
		//  }


		function hapus_sts(id) {

			swal({
				title: 'Obrolan akan dihapus !',
				text: 'Anda tidak dapat melihat riwayat obrolan ini setelah dihapus',
				type: 'warning',
				buttons: {
					cancel: {
						visible: true,
						text: 'batal',
						className: 'btn btn-danger'
					},
					confirm: {
						text: 'Ya',
						className: 'btn btn-success'
					}
				}
			}).then((willDelete) => {
				if (willDelete) {


					var url = "<?php echo site_url("kordokter/hapus_status"); ?>";
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
							token = val['token'];
							$("#card" + id).fadeOut(1000);
							setTimeout(function() {
								$("#card" + id).html("");
							}, 1000);
						}
					});


				}
			});




		};

		function akhiri(id) {

			swal({
				title: 'Akhiri obrolan ?',
				text: 'Percakapan akan diakhiri namun anda masih dapat melihat percakapan ini pada arsip.',
				type: 'warning',
				buttons: {
					cancel: {
						visible: true,
						text: 'batal',
						className: 'btn btn-danger'
					},
					confirm: {
						text: 'Ya',
						className: 'btn btn-success'
					}
				}
			}).then((willDelete) => {
				if (willDelete) {
					var url = "<?php echo site_url("kordokter/akhiri_obrolan"); ?>";
					var param = {
						id: id,
						<?php echo $this->m_reff->tokenName() ?>: token
					};
					loading("shareInfo");
					$.ajax({
						type: "POST",
						dataType: "json",
						data: param,
						url: url,
						success: function(val) {
							token = val['token'];
							reload_status();
							unblock("shareInfo");

						}
					});


				}
			});




		};

		function hapus_com(id) {
			compus = id;

			swal({
				title: 'Hapus ?',
				text: '',
				type: 'warning',
				buttons: {
					cancel: {
						visible: true,
						text: 'batal',
						className: 'btn btn-danger'
					},
					confirm: {
						text: 'Ya',
						className: 'btn btn-success'
					}
				}
			}).then((willDelete) => {
				if (willDelete) {


					var url = "<?php echo site_url("kordokter/hapus_com"); ?>";
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
							token = val['token'];
							$("#com" + id).fadeOut(600);
							setTimeout(function() {
								$("#com" + id).html("");
							}, 600);
						}
					});


				}
			});
		}
	</script>





	<div class="modal effect-flip-vertical" id="mdl_modal" style="z-index:1500" role="dialog">
		<div class="modal-dialog modal-md" id="area_modal" role="document">

			<div class="modal-content">
			 
			<div id="isi_modal"></div>
			</div>
		</div>
	</div><!-- /.modal-dialog -->

	 

	<script>
		var posisi;
		reload_chat();
		setTimeout(function() {
			scroll();
		}, 1000);

		function reload_chat() {
			var id = "<?php echo $this->input->post('id'); ?>";
			$("#chatlist").html("mohon tunggu...");
			$.post("<?php echo base_url() ?>kordokter/chat_list", {
				id: id
			}, function(data, status) {
				$("#chatlist").html(data);
			});
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

		// function sendChatManual() {
		// 	var text = $("#type_teks").val();
		// 	var receiver = "<?php echo $this->input->post('id'); ?>";
		// 	posisi = "chat";
		// 	open = true;
		// 	$.ajax({
		// 		url: '<?php echo site_url("kordokter/saveChat"); ?>',
		// 		data: {
		// 			receiver: receiver,
		// 			msg: text
		// 		},
		// 		method: "POST",
		// 		dataType: "JSON",
		// 		beforeSend: function() {

		// 		},
		// 		success: function(data) {
		// 			$("#isiChat").append(data.isi);
		// 			$("#type_teks").val("");
		// 			scroll();

		// 		}
		// 	});
		// }

		// function sendChat(text) {
		// 	var receiver = "<?php echo $this->input->post('id'); ?>";
		// 	posisi = "chat";
		// 	open = true;
		// 	$.ajax({
		// 		url: '<?php echo site_url("kordokter/saveChat"); ?>',
		// 		data: {
		// 			receiver: receiver,
		// 			msg: text
		// 		},
		// 		method: "POST",
		// 		dataType: "JSON",
		// 		beforeSend: function() {

		// 		},
		// 		success: function(data) {
		// 			$("#isiChat").append(data.isi);
		// 			$("#type_teks").val("");
		// 			scroll();

		// 		}
		// 	});
		// }

		function scroll() {
			var element = document.getElementById("chatlist");
			element.scrollTop = element.scrollHeight;
		}

		// function replays() {
		// 	var sender = "<?php echo $this->input->post('id'); ?>";
		// 	$.ajax({
		// 		url: '<?php echo site_url("kordokter/chat_replay"); ?>',
		// 		data: {
		// 			sender: sender
		// 		},
		// 		method: "POST",
		// 		dataType: "JSON",
		// 		beforeSend: function() {

		// 		},
		// 		success: function(data) {
		// 			$("#isiChat").append(data.isi);
		// 			if (data.isi) {
		// 				scroll();
		// 			}
		// 		}
		// 	});
		// }


		// setInterval(function() {
		// 	replays();
		// }, 5000);
	</script>