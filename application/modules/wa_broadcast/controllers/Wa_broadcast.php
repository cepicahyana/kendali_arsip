<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wa_broadcast extends MY_Controller {

	function __construct()
	{
		parent::__construct();	
		$this->m_konfig->validasi_session(array("admin_data","super_admin"));
		$this->load->model("model","mdl");
		$this->load->model("Model_kontak_group","mdl_kg");
		$this->load->model("Model_list_kontak","mdl_lk");
		date_default_timezone_set('Asia/Jakarta');
	}
	
	function _template($data)
	{
		$this->load->view('temp_main_data/main',$data);	
	}
	 
	public function index()
	{
		$ajax=$this->input->get_post("ajax");
		if($ajax=="yes")
		{
			$var["data"]=$this->load->view("broadcast_group",NULL,TRUE);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$data['konten']="broadcast_group";
			$this->_template($data);
		}
		
	}

	function getData()
	{
		if(!$this->input->post("draw")){echo $this->m_reff->page403(); return false;}
		$get_controller = $this->router->fetch_class();
		$list = $this->mdl->get_data();
		$data = array();
		$no = $this->input->post("start");
		$no =$no+1;

		foreach ($list as $dataDB) {
			$total_kontak = $this->mdl_kg->countKontakInGroup($dataDB->id);
			$kontak_badge = ($total_kontak < 1) ? ' title="Tambah Kontak"><i class="fe fe-user-plus menu-icon"></i>' : ' title="'.$total_kontak.' Data Kontak"><span class="badge badge-pill badge-primary">'.$total_kontak.'</span>&nbsp;&nbsp;&nbsp;<i class="fe fe-users menu-icon"></i>';
			$tombol = '<div class="text-right"><a class="btn btn-light" href="'.site_url($get_controller.'/group_kontak/'.$dataDB->id).'" '.$kontak_badge.' </a>
						<button class="btn btn-light" onclick="edit(`'.$dataDB->id.'`,`'.$dataDB->nama.'`)" title="Edit Group"><i class="fe fe-edit menu-icon"></i></button>
						<button class="btn btn-danger" onclick="hapus(`'.$dataDB->id.'`,`'.$dataDB->nama.'`)" title="Hapus Group"><i class="fe fe-trash-2 menu-icon"></i></button></div>';
			$row = array();
			$row[] = '<input type="checkbox" class="selectedId" name="pilih[]" value="'.$dataDB->id.'" />';

			$row[] = $dataDB->nama;
			$row[] = $tombol;

			//add html for action
			$data[] = $row;
		}
			 
		$output = array(
						"draw" => $this->input->post("draw"),
						"recordsTotal" => $c=$this->mdl->count(),
						"recordsFiltered" =>$c,
						"data" => $data,
						"token"=>$this->m_reff->getToken()
						);
		//output to json format
		echo json_encode($output);

	}
	function viewAdd(){
		$f=$this->input->post();
		if(!$f){ return $this->m_reff->page403();}
		
		$var["data"]=$this->load->view("viewAdd",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}

	function insert_data(){
		$f=$this->input->post('f');
		if(!$f){ return $this->m_reff->page403();}

		$dt = $this->mdl->insert();
		echo json_encode($dt);
	}

	function viewEdit(){
		$id = $this->input->post('id');
		if(!$id){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("viewEdit",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
	function update_data(){
		$f=$this->input->post('f');
		if(!$f){ return $this->m_reff->page403();}

		$dt = $this->mdl->update();
		echo json_encode($dt);
	}

	function hapus(){
		$id = $this->input->post('id');
		if(!$id){ return $this->m_reff->page403();}

		$dt = $this->mdl->hapus();
		echo json_encode($dt);
	}

	/*-------
	broadcast
	-------*/
	function form_broadcast(){
		$f = $this->input->post();
		if(!$f){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("form_broadcast",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
	function sendBroadcast(){
		$f = $this->input->post('f');
		if(!$f){ return $this->m_reff->page403();}

		$this->mdl->sendBroadcast();
		$data["token"] = $this->m_reff->getToken();
		echo json_encode($data);
	}

	
	function form_broadcast_group(){
		$f = $this->input->post();
		if(!$f){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("form_broadcast_group",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
	function sendBroadcast_group(){
		$f = $this->input->post('f');
		if(!$f){ return $this->m_reff->page403();}

		$this->mdl->sendBroadcast_group();
		$data["token"] = $this->m_reff->getToken();
		echo json_encode($data);
	}


	function form_broadcast_group_kontak(){
		$f = $this->input->post();
		if(!$f){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("form_broadcast_group_kontak",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
	function sendBroadcast_group_kontak(){
		$f = $this->input->post('f');
		if(!$f){ return $this->m_reff->page403();}

		$this->mdl->sendBroadcast_group_kontak();
		$data["token"] = $this->m_reff->getToken();
		echo json_encode($data);
	}


	/*-------
	LIST KONTAK
	-------*/
	function list_kontak()
	{
		$ajax=$this->input->get_post("ajax");
		if($ajax=="yes")
		{
			$var["data"]=$this->load->view("list_kontak",NULL,TRUE);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$data['konten']="list_kontak";
			$this->_template($data);
		}
	}
	function getData_list_kontak()
	{
		if(!$this->input->post("draw")){ echo $this->m_reff->page403(); return false;}
		$list = $this->mdl_lk->get_data();
		$data = array();
		$no = $this->input->post("start");
		$no =$no+1;

		foreach ($list as $dataDB) {

			$tombol='<div aria-label="Basic example" class="btn-groupss" role="group">
				<button onclick="edit(`'.$dataDB->id.'`,`'.$dataDB->nama.'`)" class="btn btn-sm btn-secondary pd-x-25 active" type="button">Edit</button> 
				<button onclick="hapus(`'.$dataDB->id.'`,`'.$dataDB->nama.'`)" class="btn btn-sm btn-danger pd-x-25" type="button">Hapus</button> 
			</div>';

			$jns	=	$this->m_reff->jenis_pegawai($dataDB->jenis_pegawai);

			$row = array();
			$row[] = '<input type="checkbox" class="selectedId" name="pilih[]" value="'.$dataDB->id.'" />';

			$row[] = $dataDB->nama;
			$row[] = $jns;
			$row[] = $dataDB->bagian;
			$row[] = $dataDB->jabatan;
			$row[] = $this->m_reff->biro($dataDB->kode_biro);
			// $row[] = $dataDB->instansi;
			$row[] = $this->m_reff->biro($dataDB->kode_istana);
			$row[] = $dataDB->no_hp;
			$row[] = $dataDB->email;
			

			//add html for action
			$data[] = $row;
		}
			 
		$output = array(
						"draw" => $this->input->post("draw"),
						"recordsTotal" => $c=$this->mdl_lk->count(),
						"recordsFiltered" =>$c,
						"data" => $data,
						"token"=>$this->m_reff->getToken()
						);
		//output to json format
		echo json_encode($output);

	}



	/*-------
	GROUP KONTAK
	-------*/
	function group_kontak()
	{
		$ajax=$this->input->get_post("ajax");
		if($ajax=="yes")
		{
			$var["data"]=$this->load->view("gkontak",NULL,TRUE);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$data['konten']="gkontak";
			$this->_template($data);
		}
		
	}
	function getData_kontak()
	{
		if(!$this->input->post("draw")){echo $this->m_reff->page403(); return false;}
		$list = $this->mdl_kg->get_data();
		$data = array();
		$no = $this->input->post("start");
		$no =$no+1;

		foreach ($list as $dataDB) {
			$row = array();
			$row[] = '<input type="checkbox" class="selectedId" name="pilih[]" value="'.$dataDB->id.'" />';
			$row[] = $dataDB->nama;
			$row[] = $dataDB->jabatan;
			$row[] = $dataDB->instansi;
			$row[] = $dataDB->email;
			$row[] = $dataDB->no_hp;
			$row[] = '<button class="btn btn-light" onclick="editGroupKontak(`'.$dataDB->id_group.'`,`'.$dataDB->id.'`)" title="Edit"><i class="fe fe-edit menu-icon"></i></button>&nbsp;&nbsp;<button class="btn btn-danger" onclick="hapus(`'.$dataDB->id.'`,`'.$dataDB->nama.'`)" title="Hapus"><i class="fe fe-trash-2 menu-icon"></i></button>';

			//add html for action
			$data[] = $row;
		}
			 
		$output = array(
						"draw" => $this->input->post("draw"),
						"recordsTotal" => $c=$this->mdl_kg->count(),
						"recordsFiltered" =>$c,
						"data" => $data,
						"token"=>$this->m_reff->getToken()
					);
		//output to json format
		echo json_encode($output);
	}

	function form_group_kontak(){
		$f=$this->input->post();
		if(!$f){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("gkontak_form",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
	function insert_group_kontak(){
		$f=$this->input->post('f');
		if(!$f){ return $this->m_reff->page403();}

		$dt = $this->mdl_kg->insert();
		echo json_encode($dt);
	}

	function update_group_kontak(){
		$f=$this->input->post('f');
		if(!$f){ return $this->m_reff->page403();}

		$dt = $this->mdl_kg->update();
		echo json_encode($dt);
	}

	function hapus_group_kontak(){
		$id = $this->input->post('id');
		if(!$id){ return $this->m_reff->page403();}

		$dt = $this->mdl_kg->hapus();
		echo json_encode($dt);
	}



	/* import file*/
	function form_gkontak_import(){
		$f = $this->input->post();
		if(!$f){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("gkontak_form_import",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
	function import_file()
	{
		$cekGroup = $this->input->post('group');
		if(!$cekGroup){ return $this->m_reff->page403();}

		$dt		=	$this->mdl->import_file();
		
		/*$insert =	$dt["data_insert"];
		$gagal =	$dt["data_gagal"];
		$dgagal =	$dt["dgagal"];
		$g="";
		if($gagal)
		{
			$g="<br> ".$gagal." Data gagal ditambahkan dikarenakan sudah ada";
			
		}
		
		$i="";
		if($insert)
		{
			$i=$insert." Data berhasil ditambahkan";
		}
		
		
		
		if(!$i and !$g)
		{
			$i="Tidak ada data didalam file! silahkan cek kembali file yang anda upload....";
		}
		echo ' <i class="feather icon-check-circle display-3 text-success"></i><br>
				<span class="mt-3"> '.$i.'  '.$g.'</span>';
		if($dgagal)
		{
			echo "<br>data gagal:<br>".$dgagal;
		}*/

		echo json_encode($dt);
	}



	function option_biro()
	{
		$biro = $this->input->post('biro');
		if(!$biro){ return $this->m_reff->page403();}

		$this->db->where('biro', $biro);
		$pegawai = $this->mdl->getAllData();

		$options = [];
		foreach ($pegawai->result() as $p) {
			$options[$p->id] = $p->nama;
		}
		//$options["token"]=$this->m_reff->getToken();
		echo json_encode($options);
	}

}