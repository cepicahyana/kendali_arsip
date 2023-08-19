<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Akun_ppnpn extends CI_Controller {

    var $tbl="admin";
	function __construct()
	{
		parent::__construct();	
		$this->m_konfig->validasi_session(array("super_admin","admin_ppnpn"));
		$this->load->model("model","mdl");
		$this->load->model("model_pimpinan","m_pimpinan");
		$this->load->model("model_pimpinan_pusat","m_pusat");
		$this->load->model("model_pic","m_pic");
		date_default_timezone_set('Asia/Jakarta');
	}

	function _template($data)
	{
		$this->load->view('temp_admin_ppnpn/main',$data);	
	}

    public function index()
	{
		return $this->akun_admin();
		$ajax=$this->input->post("ajax");
		if($ajax=="yes")
		{
			echo	$this->load->view("index");
		}else{
			$data['konten']="index";
			$this->_template($data);
		}
		
	} 


// AKUN ADMIN PPNPN
    public function akun_admin()
	{
		$ajax=$this->input->post("ajax");
		if($ajax=="yes")
		{
			$var["data"]=$this->load->view("view_akun_admin",null,true);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$data['konten']="view_akun_admin";
			$this->_template($data);
		}
	} 

    function get_data_admin(){
		if(!$this->input->post("draw")){ echo $this->m_reff->page403(); return false;}
        $list = $this->mdl->get_data_admin();
		$data = array();
		$no = $this->input->post("start");
		$no =$no+1;
		foreach ($list as $dataDB) {
		$getBiro = $this->db->get_where("tr_biro", ["kode" => $dataDB->kode_biro])->row();

        $nama_biro = isset($getBiro->nama)?($getBiro->nama):null;

		$tombol='<div aria-label="Basic example" class="btn-groupss" role="group">
		<button style="display:none;" onclick="edit(`'.$dataDB->id_admin.'`,`'.$dataDB->owner.'`)" class="font14 btn btn-sm ti-pencil btn-secondary" type="button"> Edit</button> 
		<button style="color:white" onclick="hapus(`'.$dataDB->id_admin.'`,`'.$dataDB->owner.'`)" class="font14 btn btn-sm ti-trash bg-danger" type="button"> Hapus</button> 
		</div>';

		$relasi = $this->db->get_where("data_pegawai",array("nip"=>$dataDB->nip))->row();
		

		$row = array();
		$row[] = $no++;	
		$row[] = isset($relasi->nama)?($relasi->nama):null;
		$row[] = isset($relasi->nip)?($relasi->nip):null;
		$row[] = $this->m_reff->jk(isset($relasi->jk)?($relasi->jk):null);
		// $row[] = $dataDB->alamat;
		$row[] = isset($relasi->no_hp)?($relasi->no_hp):null;
		$row[] = isset($relasi->email)?($relasi->email):null;
		
			$row[] = $tombol;



			$data[] = $row; 
			
		}

		$output = array(
			"draw" => $this->input->post("draw"),
			"recordsTotal" => $c=$this->mdl->count_data_admin(),
			"recordsFiltered" =>$c,
			"data" => $data,
			"token"=>$this->m_reff->getToken()
		);
		//output to json format
		echo json_encode($output);
    }

    function add_akun_admin(){
		$f=$this->input->post();
		if(!$f){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("view_add_akun_admin","",true);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}

    function insert_akun_admin(){
		$f=$this->input->post("f");
		if(!$f){ return $this->m_reff->page403();}

        $data = $this->mdl->insert_akun_admin();
		echo json_encode($data);
    }

    function view_edit_akun_admin(){
		$f=$this->input->post("id");
		if(!$f){ return $this->m_reff->page403();}

        $var["data"]=$this->load->view("view_edit_akun_admin","",true);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
    }

    function update_akun_admin(){
		$f=$this->input->post("f");
		if(!$f){ return $this->m_reff->page403();}

		$data = $this->mdl->update_akun_admin();
		echo json_encode($data);
	}

    function hapus_akun_admin(){
		$f=$this->input->post("id");
		if(!$f){ return $this->m_reff->page403();}

        $data = $this->mdl->hapus_akun_admin();
		echo json_encode($data);
    }


// AKUN PIMPINAN PPNPN
	public function akun_pimpinan()
	{
		$ajax=$this->input->post("ajax");
		if($ajax=="yes")
		{
			$var["data"]=$this->load->view("view_akun_pimpinan",null,true);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$data['konten']="view_akun_pimpinan";
			$this->_template($data);
		}
	} 

	function get_data_pimpinan(){
		if(!$this->input->post("draw")){ echo $this->m_reff->page403(); return false;}
        $list = $this->m_pimpinan->get_data_pimpinan();
		$data = array();
		$no = $this->input->post("start");
		$no =$no+1;
		foreach ($list as $dataDB) {
			$tombol='<div aria-label="Basic example" class="btn-groupss" role="group">
			<button style="display:none;" onclick="edit(`'.$dataDB->id_admin.'`,`'.$dataDB->owner.'`)" class="font14 btn btn-sm ti-pencil btn-secondary" type="button"> Edit</button> 
			<button style="color:white" onclick="hapus(`'.$dataDB->id_admin.'`,`'.$dataDB->owner.'`)" class="font14 btn btn-sm ti-trash bg-danger" type="button"> Hapus</button> 
			</div>';
	
			$relasi = $this->db->get_where("data_pegawai",array("nip"=>$dataDB->nip))->row();
			
	
			$row = array();
			$row[] = $no++;	
			$row[] = isset($relasi->nama)?($relasi->nama):null;
			$row[] = $this->m_reff->jk(isset($relasi->jk)?($relasi->jk):null);
			$row[] = isset($relasi->nip)?($relasi->nip):null;
			$row[] = isset($relasi->no_hp)?($relasi->no_hp):null;
			$row[] = isset($relasi->email)?($relasi->email):null;
			$row[] = $this->m_reff->istana($dataDB->kode_istana);
		   //  $row[] = $this->m_reff->jk(isset($relasi->jk)?($relasi->jk):null);
			$row[] = $this->m_reff->biro($dataDB->kode_biro);
			$row[] = $tombol;


			$data[] = $row; 
			
		}

		$output = array(
			"draw" => $this->input->post("draw"),
			"recordsTotal" => $c=$this->m_pimpinan->count_data_pimpinan(),
			"recordsFiltered" =>$c,
			"data" => $data,
			"token"=>$this->m_reff->getToken()
		);
		//output to json format
		echo json_encode($output);
    }

    function add_akun_pimpinan(){
		$f=$this->input->post();
		if(!$f){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("view_add_akun_pimpinan","",true);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}

    function insert_akun_pimpinan(){
		$f=$this->input->post("f");
		if(!$f){ return $this->m_reff->page403();}

        $data = $this->m_pimpinan->insert_akun_pimpinan();
		echo json_encode($data);
    }

    function view_edit_akun_pimpinan(){
		$f=$this->input->post("id");
		if(!$f){ return $this->m_reff->page403();}

        $var["data"]=$this->load->view("view_edit_akun_pimpinan","",true);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
    }

    function update_akun_pimpinan(){
		$f=$this->input->post("f");
		if(!$f){ return $this->m_reff->page403();}

		$data = $this->m_pimpinan->update_akun_pimpinan();
		echo json_encode($data);
	}

    function hapus_akun_pimpinan(){
		$f=$this->input->post("id");
		if(!$f){ return $this->m_reff->page403();}

        $data = $this->m_pimpinan->hapus_akun_pimpinan();
		echo json_encode($data);
    }


	// AKUN PIMPINAN PUSAT
	public function akun_pimpinan_pusat()
	{
		$ajax=$this->input->post("ajax");
		if($ajax=="yes")
		{
			$var["data"]=$this->load->view("view_akun_pimpinan_pusat",null,true);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$data['konten']="view_akun_pimpinan_pusat";
			$this->_template($data);
		}
	} 

	function get_data_pimpinan_pusat(){
		if(!$this->input->post("draw")){ echo $this->m_reff->page403(); return false;}
        $list = $this->m_pusat->get_data_pimpinan_pusat();
		$data = array();
		$no = $this->input->post("start");
		$no =$no+1;
		foreach ($list as $dataDB) {
		// $getBiro = $this->db->get_where("tr_biro", ["kode" => $dataDB->kode_biro])->row();

        // $nama_biro = isset($getBiro->nama)?($getBiro->nama):null;

		$tombol='<div aria-label="Basic example" class="btn-groupss" role="group">
		<button style="display:none;" onclick="edit(`'.$dataDB->id_admin.'`,`'.$dataDB->owner.'`)" class="font14 btn btn-sm ti-pencil btn-secondary" type="button"> Edit</button> 
		<button style="color:white" onclick="hapus(`'.$dataDB->id_admin.'`,`'.$dataDB->owner.'`)" class="font14 btn btn-sm ti-trash bg-danger" type="button"> Hapus</button> 
		</div>';

		$relasi = $this->db->get_where("data_pegawai",array("nip"=>$dataDB->nip))->row();
		

		$row = array();
		$row[] = $no++;	
		$row[] = isset($relasi->nama)?($relasi->nama):null;
		$row[] = $this->m_reff->jk(isset($relasi->jk)?($relasi->jk):null);
		$row[] = isset($relasi->nip)?($relasi->nip):null;
		$row[] = isset($relasi->no_hp)?($relasi->no_hp):null;
		$row[] = isset($relasi->email)?($relasi->email):null;
		$row[] = $this->m_reff->istana($dataDB->kode_istana);
	   //  $row[] = $this->m_reff->jk(isset($relasi->jk)?($relasi->jk):null);
		// $row[] = $this->m_reff->biro($dataDB->kode_biro);
		$row[] = $tombol;



			$data[] = $row; 
			
		}

		$output = array(
			"draw" => $this->input->post("draw"),
			"recordsTotal" => $c=$this->m_pusat->count_data_pimpinan_pusat(),
			"recordsFiltered" =>$c,
			"data" => $data,
			"token"=>$this->m_reff->getToken()
		);
		//output to json format
		echo json_encode($output);
    }

    function add_akun_pimpinan_pusat(){
		$f=$this->input->post();
		if(!$f){ return $this->m_reff->page403();}
		$var["data"]=$this->load->view("view_add_akun_pimpinan_pusat","",true);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}

    function insert_akun_pimpinan_pusat(){
		$f=$this->input->post("f");
		if(!$f){ return $this->m_reff->page403();}
        $data = $this->m_pusat->insert_akun_pimpinan_pusat();
		echo json_encode($data);
    }

    function view_edit_akun_pimpinan_pusat(){
		$id=$this->input->post("id");
		if(!$id){ return $this->m_reff->page403();}

        $var["data"]=$this->load->view("view_edit_akun_pimpinan_pusat","",true);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
    }

    function update_akun_pimpinan_pusat(){
		$f=$this->input->post("f");
		if(!$f){ return $this->m_reff->page403();}

		$data = $this->m_pusat->update_akun_pimpinan_pusat();
		echo json_encode($data);
	}

    function hapus_akun_pimpinan_pusat(){
		$id=$this->input->post("id");
		if(!$id){ return $this->m_reff->page403();}

        $data = $this->m_pusat->hapus_akun_pimpinan_pusat();
		echo json_encode($data);
    }


	// AKUN PIC
	public function akun_pic()
	{
		$ajax=$this->input->post("ajax");
		if($ajax=="yes")
		{
			$var["data"]=$this->load->view("view_akun_pic",null,true);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$data['konten']="view_akun_pic";
			$this->_template($data);
		}
	} 

	function get_data_pic(){
		if(!$this->input->post("draw")){ echo $this->m_reff->page403(); return false;}
        $list = $this->m_pic->get_data_pic();
		$data = array();
		$no = $this->input->post("start");
		$no =$no+1;
		foreach ($list as $dataDB) {
		// $getBiro = $this->db->get_where("tr_biro", ["kode" => $dataDB->kode_biro])->row();

        
		$tombol='<div aria-label="Basic example" class="btn-groupss" role="group">
		<button style="display:none;" onclick="edit(`'.$dataDB->id_admin.'`,`'.$dataDB->owner.'`)" class="font14 btn btn-sm ti-pencil btn-secondary" type="button"> Edit</button> 
		<button style="color:white" onclick="hapus(`'.$dataDB->id_admin.'`,`'.$dataDB->owner.'`)" class="font14 btn btn-sm ti-trash bg-danger" type="button"> Hapus</button> 
		</div>';

		$relasi = $this->db->get_where("data_pegawai",array("nip"=>$dataDB->nip))->row();
		

		$row = array();
		$row[] = $no++;	
		$row[] = isset($relasi->nama)?($relasi->nama):null;
		$row[] = $this->m_reff->jk(isset($relasi->jk)?($relasi->jk):null);
		$row[] = isset($relasi->nip)?($relasi->nip):null;
		$row[] = isset($relasi->no_hp)?($relasi->no_hp):null;
		$row[] = isset($relasi->email)?($relasi->email):null;
		$row[] = $this->m_reff->istana($dataDB->kode_istana);
	   //  $row[] = $this->m_reff->jk(isset($relasi->jk)?($relasi->jk):null);
		$row[] = $this->m_reff->biro($dataDB->kode_biro);
		$row[] = $tombol;
			
			



			$data[] = $row; 
			
		}

		$output = array(
			"draw" => $this->input->post("draw"),
			"recordsTotal" => $c=$this->m_pic->count_data_pic(),
			"recordsFiltered" =>$c,
			"data" => $data,
			"token"=>$this->m_reff->getToken()
		);
		//output to json format
		echo json_encode($output);
    }

    function add_akun_pic(){
		$f=$this->input->post();
		if(!$f){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("view_add_akun_pic","",true);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}

    function insert_akun_pic(){
		$f=$this->input->post("f");
		if(!$f){ return $this->m_reff->page403();}
        $data = $this->m_pic->insert_akun_pic();
		echo json_encode($data);
    }

    function view_edit_akun_pic(){
		$id=$this->input->post("id");
		if(!$id){ return $this->m_reff->page403();}

        $var["data"]=$this->load->view("view_edit_akun_pic","",true);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
    }

    function update_akun_pic(){
		$f=$this->input->post("f");
		if(!$f){ return $this->m_reff->page403();}
		$data = $this->m_pic->update_akun_pic();
		echo json_encode($data);
	}

    function hapus_akun_pic(){
		$id=$this->input->post("id");
		if(!$id){ return $this->m_reff->page403();}

        $data = $this->m_pic->hapus_akun_pic();
		echo json_encode($data);
    }
}