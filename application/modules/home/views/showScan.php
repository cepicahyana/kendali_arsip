 
  <style>
 
    #githubLink {
      position: absolute;
      right: 0;
      top: 12px;
      color: #2D99FF;
    }

    h1 {
      margin: 10px 0;
      font-size: 40px;
    }

    #loadingMessage {
      text-align: center;
      padding: 40px;
      background-color: #eee;
    }

    #canvas {
      width: 100%;
    }

    #output {
      margin-top: 20px;
      background: #eee;
      padding: 10px;
      padding-bottom: 0;
    }

    #output div {
      padding-bottom: 10px;
      word-wrap: break-word;
    }

    #noQRFound {
      text-align: center;
    }
  </style>
</head>
<body cz-shortcut-listen="true">
  <center><h3>scan qrcode</h3></center>
  <div id="loadingMessage" hidden="">⌛ Loading video...</div>
  <canvas id="canvas" height="480" width="640"></canvas>
  <div id="output">
    <div id="outputMessage">No QR code detected.</div>
    <div hidden=""><b>Data:</b> <span id="outputData">(90)MD805010031209(91)240103</span></div>
  </div>
  <script>
    var video = document.createElement("video");
    var canvasElement = document.getElementById("canvas");
    var canvas = canvasElement.getContext("2d");
    var loadingMessage = document.getElementById("loadingMessage");
    var outputContainer = document.getElementById("output");
    var outputMessage = document.getElementById("outputMessage");
    var outputData = document.getElementById("outputData");

    function drawLine(begin, end, color) {
      canvas.beginPath();
      canvas.moveTo(begin.x, begin.y);
      canvas.lineTo(end.x, end.y);
      canvas.lineWidth = 4;
      canvas.strokeStyle = color;
      canvas.stroke();
    }

    // Use facingMode: environment to attemt to get the front camera on phones
    navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } }).then(function(stream) {
      video.srcObject = stream;
      video.setAttribute("playsinline", true); // required to tell iOS safari we don't want fullscreen
      video.play();
      requestAnimationFrame(tick);
    });

    function tick() {
      loadingMessage.innerText = "⌛ Loading video..."
      if (video.readyState === video.HAVE_ENOUGH_DATA) {
        loadingMessage.hidden = true;
        canvasElement.hidden = false;
        outputContainer.hidden = false;

        canvasElement.height = video.videoHeight;
        canvasElement.width = video.videoWidth;
        canvas.drawImage(video, 0, 0, canvasElement.width, canvasElement.height);
        var imageData = canvas.getImageData(0, 0, canvasElement.width, canvasElement.height);
        var code = jsQR(imageData.data, imageData.width, imageData.height, {
          inversionAttempts: "dontInvert",
        });
        if (code) {
          drawLine(code.location.topLeftCorner, code.location.topRightCorner, "#FF3B58");
          drawLine(code.location.topRightCorner, code.location.bottomRightCorner, "#FF3B58");
          drawLine(code.location.bottomRightCorner, code.location.bottomLeftCorner, "#FF3B58");
          drawLine(code.location.bottomLeftCorner, code.location.topLeftCorner, "#FF3B58");
          outputMessage.hidden = true;
          outputData.parentElement.hidden = false;
          outputData.innerText = code.data;
          if(code.data){
              var hasil = code.data;
              responseQr(hasil);
          }
        } else {
          outputMessage.hidden = false;
          outputData.parentElement.hidden = true;
        }
      }
      requestAnimationFrame(tick);
    }

    function responseQr(hasil){
        // $("#isi-scan").html(loading());
        
        var url = "<?php echo base_url()?>home/setAbsenScan";
			var param = {
				<?php echo $this->m_reff->tokenName()?>: token,
				code:hasil,
                id:1
			};
			$.ajax({
				type: "POST",
				dataType: "json",
				data: param,
				url: url,
				beforeSend: function() {
					// loading_block("menu-welcome-modal-scan");
                    $("#outputMessage").html("mohon tunggu...");
				},
				success: function(val) {
                    token = val["token"];
                    if(val["data"].gagal==true){
                        $("#outputMessage").html(val["data"].info);
                    }else{
                        $("#menu-welcome-modal-scan").hideMenu();
				    	unblock("menu-welcome-modal-scan");
                        // notif_absen();
                        // reloadAbsen();
                        // infoact();
                        setTimeout(() => {
                            window.location.href="";
                        }, 300);
                    }
                  
                    
				}
			});


    }
  </script>


</body></html>