<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menpro_pdf extends CI_Controller
{
	public function index()
	{
		echo 'test';
	}

	function cetak_raport()
	{
		//$this->load->view('menpro_pdf/raport');

		require_once('libraries/html2pdf/html2pdf.class.php');
		ob_start();
		//include('file.html');
		//$isi =  $this->load->view('menpro_pdf/raport');
		$isi = "
	<html> 
	<body>
		<h1>MPDF WORK !</h1> 
		Selamat datang di rachmat.ID
	</body>
	</html>
	";
		//return false;
		$isi = ob_get_clean();

		try {
			$html2pdf = new HTML2PDF('L', array("210", "310"), 'en', true, '', array(8, 10, 10, 5));
			$html2pdf->writeHTML($isi, isset($_GET['vuehtml']));
			//ob_end_clean();
			//$html2pdf->Output('Raport.pdf');
		} catch (HTML2PDF_exception $e) {
			echo $e;
			exit;
		}
	}
}
