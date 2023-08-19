<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penilaian extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->m_konfig->validasi_session(array("admin_ppnpn", "pic_ppnpn","pimpinan_ppnpn","super_admin"));
		$this->load->model("model", "mdl");
		date_default_timezone_set('Asia/Jakarta');
	}

	function _template($data)
	{
		$this->load->view('temp_admin_ppnpn/main', $data);
	}


	function update_periode(){
			$var["data"]=$this->mdl->update_periode();
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
	}
	public function ttd()
	{
		$ajax = $this->input->get_post("ajax");
		if ($ajax == "yes") {
	  
			$data['header'] = "Upload tanda tangan";

			$var["data"]=$this->load->view("ttd",$data,TRUE);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		} else {
		  
			$data['header'] = "Upload tanda tangan";
			$data['konten'] = "ttd";
			$this->_template($data);
		}
	}
	public function index()
	{
		$ajax = $this->input->get_post("ajax");
		if ($ajax == "yes") {
	 
			 
			$data['header'] = "Data Penilaian Kinerja PPNPN";

			$var["data"]=$this->load->view("index",$data,TRUE);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		} else {
		 
			  
			$data['header'] = "Data Penilaian Kinerja PPNPN";
			$data['konten'] = "index";
			$this->_template($data);
		}
	}
	public function periode()
	{
		$ajax = $this->input->get_post("ajax");
		if ($ajax == "yes") {
			$data['periode'] = $this->mdl->getPeriodeNilai(); 
	  		$data['header'] = "Periode penilaian";

			$var["data"]=$this->load->view("periode",$data,TRUE);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		} else {
		 
			$data['periode'] = $this->mdl->getPeriodeNilai(); 
			$data['header'] = "Periode penilaian";
			$data['konten'] = "periode";
			$this->_template($data);
		}
	}
	function getData()
	{	
		if(!$this->input->post("draw")){ echo $this->m_reff->page403(); return false;}
		$tahun	=	$this->m_reff->san($this->input->post("tahun"));
		$sms	=	$this->m_reff->san($this->input->post("sms"));
		$list = $this->mdl->getData(); 
		$data = array();
		$no = $this->input->post('start');
		$no = $no + 1;
		foreach ($list as $dataDB) {
			$db = $this->mdl->getEvaluasi($dataDB->nip,$tahun,$sms);
			$id	= $db->id ?? '';

			$btn_hapus = '';
			if ($db) {
				$btn_hapus = '<button onclick="hapus(`' . $id . '`, `' . $dataDB->nama . '`)" type="button" class="btn bg-danger  btn-sm waves-effect waves-light ti-trash">Hapus Nilai</button>';
			}
			$level = $this->session->userdata("level");
			if ($level === 'admin_ppnpn') {
				$action		=	'<div class="btn-group" role="group"  >
								<button onclick="detail(`'.$dataDB->nip.'`,`'.$tahun.'`,`'.$sms.'`,`'.$id.'`)" type="button" class="btn bg-grey btn-sm waves-effect waves-light"><i class="fa fa-search"></i> Lihat Hasil Penilaian  </button>
							</div>';
			} else {
				$action		=	'<div class="btn-group" role="group"  >
								<button onclick="edit(`'.$dataDB->nip.'`,`'.$tahun.'`,`'.$sms.'`,`'.$id.'`)" type="button" class="btn bg-teal  btn-sm waves-effect waves-light ti-pencil-alt"> <i class="ri-edit-2-fill"></i></button>
								'.$btn_hapus.'
							</div>';
			}
			$row = array();
			$row[] = $no++;
			$row[] = $this->m_reff->istana($dataDB->kode_istana,"true").br().str_replace("Biro","",$this->m_reff->biro($dataDB->kode_biro));
			$row[] = $dataDB->bagian;
			   $row[] = $tahun .' - Sms '.$sms;
			   $row[] = $dataDB->nama;
			  
		
			   $row[] = isset($db->hasil_evaluasi)?($db->hasil_evaluasi):"<i class='text-danger'>Belum dinilai</i>";
			   $row[] = isset($db->predikat)?($this->m_reff->predikat($db->predikat)):"<i class='text-danger'>Belum dinilai</i>";
			   $row[] = isset($db->catatan)?($db->catatan):null;
			$row[] = $action;

			//add html for action
			$data[] = $row;
		}

		//$csrf_name = $this->security->get_csrf_token_name();
		//$csrf_hash = $this->security->get_csrf_hash(); 
		$output = array(
			"draw" => $this->input->post('draw'),
			"recordsTotal" => $c = $this->mdl->count(),
			"recordsFiltered" => $c,
			"data" => $data,
			"token"=>$this->m_reff->getToken()
		);
		//output to json format
		//$output[$csrf_name] = $csrf_hash;
		echo json_encode($output);
	}

	// function get_indikator_edit()
	// {
	// 	$tahun = $this->input->post('tahun');
	// 	$semester = $this->input->post('semester');

	// 	$id = $this->input->post('id');
	// 	$this->db->where("id",$id);
	// 	$db	=	$this->db->get("penilaian_kinerja_ppnpn")->row();

	// 	$tampilData = '';
	// 	$no = 0;
	// 	$data_penilaian = json_decode($db->data_penilaian);
	// 	/*echo "<pre><span>";
	// 	print_r($data_penilaian);
	// 	echo "</span></pre>";*/
	// 	foreach ($data_penilaian as $r) {
	// 		$fi_indikator = array(
	// 		        'type'  => 'hidden',
	// 		        'name'  => 'i['.$no.'][indikator]',
	// 		        'value' => $r->indikator,
	// 		        'class' => 'findikator'
	// 		);
	// 		$fi_id = array(
	// 		        'type'  => 'hidden',
	// 		        'name'  => 'i['.$no.'][id_indikator]',
	// 		        'value' => $r->id_indikator,
	// 		        'class' => 'fid'
	// 		);
	// 		$fi_bobot = array(
	// 		        'type'  => 'hidden',
	// 		        'name'  => 'i['.$no.'][bobot]',
	// 		        'value' =>  $r->bobot,
	// 		        'class' => 'fbobot'
	// 		);
	// 		$tampilData 	.= '<tr><td>'.$r->indikator.
	// 		form_input($fi_id).
	// 		form_input($fi_indikator).'</td>
	// 		<td class="text-center">
	// 			'.$r->bobot.' %'.
	// 			form_input($fi_bobot).'
	// 		</td>
	// 		<td>
	// 			<input type="number" name="i['.$no.'][skor]" value="'.set_value('i['.$no.'][skor]', $r->skor).'" min="0" max="100" class="form-controls fskor">
	// 		</td>
	// 		<td>
	// 			<input type="text" name="i['.$no.'][nilai]" value="'.set_value('i['.$no.'][nilai]', $r->nilai).'" min="0" max="100" class="form-controls fnilai" readonly>
	// 		</td>
	// 	</tr>';
	// 	$no++;
	// 	}
	// 	echo $tampilData;
	// }

	function get_indikator_edit()
	{
		$id = $this->input->post('id');
		if(!$id){ return $this->m_reff->page403();}

		// $tahun 	  = $this->input->post('tahun');
		// $semester = $this->input->post('semester');

		$id = $this->input->post('id');
		$this->db->where("id",$id);
		$db	=	$this->db->get("penilaian_kinerja_ppnpn")->row();

		$tampilData = '';
		$no = 0;
		$data_penilaian = json_decode($db->data_penilaian);
		/*echo "<pre><span>";
		print_r($data_penilaian);
		echo "</span></pre>";*/
		foreach ($data_penilaian as $r) {
			$fi_indikator = array(
			        'type'  => 'hidden',
			        'name'  => 'i['.$no.'][indikator]',
			        'value' => $r->indikator,
			        'class' => 'findikator'
			);
			$fi_id = array(
			        'type'  => 'hidden',
			        'name'  => 'i['.$no.'][id_indikator]',
			        'value' => $r->id_indikator,
			        'class' => 'fid'
			);
			$fi_bobot = array(
			        'type'  => 'hidden',
			        'name'  => 'i['.$no.'][bobot]',
			        'value' =>  $r->bobot,
			        'class' => 'fbobot'
			);
			$tampilData 	.= '<tr><td>'.$r->indikator.
			form_input($fi_id).
			form_input($fi_indikator).'</td>
			<td class="text-center">
				'.$r->bobot.' %'.
				form_input($fi_bobot).'
			</td>
			<td>
				<input type="number" name="i['.$no.'][skor]" value="'.set_value('i['.$no.'][skor]', $r->skor).'" min="0" max="100" class="form-controls fskor">
			</td>
			<td>
				<input type="text" name="i['.$no.'][nilai]" value="'.set_value('i['.$no.'][nilai]', $r->nilai).'" min="0" max="100" class="form-controls fnilai" readonly>
			</td>
		</tr>';
		$no++;
		}
		$var["indikator"]=$tampilData;
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}

	function get_indikator()
	{
		// $id = $this->input->post('id');
		// if(!$id){ return $this->m_reff->page403();}

		$id 		= $this->m_reff->san($this->input->post('id'));
		$tahun 		= $this->m_reff->san($this->input->post('tahun'));
		$semester 	= $this->m_reff->san($this->input->post('semester'));
		if ('' !== $id || $id > 0) {
			$wa = ["id"=>$id, "tahun"=>$tahun, "semester"=>$semester];
			$this->db->where($wa);
			$db	= $this->db->get("penilaian_kinerja_ppnpn");
			if ($db->num_rows() > 0) {
				$dbx = $db->row();
				$getDataIndikator = json_decode($dbx->data_penilaian);
			} else {
				$getDataIndikator = $this->db->get_where('tm_indikator_penilaian', ['tahun'=>$tahun, 'semester'=>$semester])->result();
			}
			
		} else {
			$getDataIndikator = $this->db->get_where('tm_indikator_penilaian', ['tahun'=>$tahun, 'semester'=>$semester])->result();
		}

		$tampilData = '';
		
		if (count($getDataIndikator) < 1) {
			if(strtolower($this->session->userdata("level"))!="pic_ppnpn")
			{
			$tampilData = '<td colspan="4" class="text-center">
				<p>Indikator Penilaian untuk <span class="text-primary">Tahun '.$tahun.' - Semester '.$semester.'</span> belum ditambahkan!</p>
				<button onclick="importIndikator(`'.$tahun.'`,`'.$semester.'`)" class="btn btn-primary">Copy Data Indikator Sebelumnya</button>&nbsp;
				<a href="'.site_url('mipenilaian').'" class="btn btn-success">Buat Indikator Baru</a>
			</td>';
			}else{
				$tampilData = '<td colspan="4" class="text-center">
				<p>Indikator Penilaian untuk <span class="text-primary">Tahun '.$tahun.' - Semester '.$semester.'</span> belum ditambahkan!</p>
				</td>';
			}
		} else {
			$no = 0;
			$level = $this->session->userdata("level");
			$skor_nilai = '';
			foreach ($getDataIndikator as $r) {
					$fi_indikator = array(
					        'type'  => 'hidden',
					        'name'  => 'i['.$no.'][indikator]',
					        'value' => $r->indikator,
					        'class' => 'findikator'
					);
					$fi_id = array(
					        'type'  => 'hidden',
					        'name'  => 'i['.$no.'][id_indikator]',
					        'value' => $r->id ?? $r->id_indikator,
					        'class' => 'fid'
					);
					$fi_bobot = array(
					        'type'  => 'hidden',
					        'name'  => 'i['.$no.'][bobot]',
					        'value' =>  $r->bobot,
					        'class' => 'fbobot'
					);
					// status admin
	 				if ($level === 'admin_ppnpn') {
	 					$skor_nilai = '<td>'.($r->skor??'0').'</td><td>'.($r->nilai??'0').'</td>';
	 				} else {
	 					$skor_nilai = '<td>
										<input type="number" name="i['.$no.'][skor]" value="'.set_value('i['.$no.'][skor]', ($r->skor??'')).'" min="0" max="100" class="form-controls fskor">
									</td>
									<td>
										<input type="text" name="i['.$no.'][nilai]" value="'.set_value('i['.$no.'][nilai]', ($r->nilai??'')).'" min="0" max="100" class="form-controls fnilai" readonly>
									</td>';
	 				}
					
					$tampilData .= '<tr><td>'.$r->indikator.
					form_input($fi_id).
					form_input($fi_indikator).'</td>
					<td class="text-center">
						'.$r->bobot.' %'.
						form_input($fi_bobot).'
					</td>'.$skor_nilai.'
				</tr>';
				$no++;
			}
		}
		$var["indikator"]=$tampilData;
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
	
	function detail(){		
		// $id = $this->input->post('id');
		// if(!$id){ return $this->m_reff->page403();}

	echo	$this->load->view("detail");
		// $var["token"]=$this->m_reff->getToken();
		// echo json_encode($var);

		//$this->load->view("detail");
	}
 
	function form_tambah(){
		$id = $this->input->post();
		if(!$id){ return $this->m_reff->page403();}

		$this->load->view("form_tambah");
	}

	function update_ttd()
	{
		$var["data"]=$this->mdl->update_ttd();
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
	function form_edit()
	{
		// $id = $this->input->post('id');
		// if(!$id){ return $this->m_reff->page403();}
		
		$var["data"]=$this->load->view("form_edit",null,true);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}

	function insert()
	{
		$f = $this->input->post('f');
		if(!$f){ return $this->m_reff->page403();}

		$x = $this->mdl->insert();
		echo json_encode($x);
	}

	function hapus()
	{
		$id = $this->input->post('id');
		if(!$id){ return $this->m_reff->page403();}

		echo $this->mdl->hapus();
	}

	function update()
	{
		$f = $this->input->post('f');
		if(!$f){ return $this->m_reff->page403();}

		$x = $this->mdl->update();
		echo json_encode($x);
	}
}
