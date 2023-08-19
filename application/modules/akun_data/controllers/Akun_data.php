<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Akun_data extends CI_Controller {


	var $tbl="admin";
	function __construct()
	{
		parent::__construct();	
		$this->m_konfig->validasi_session(array("admin_data","super_admin"));
		$this->load->model("model","mdl");
		$this->load->model("model_pimpinan_pusat","m_pusat");
		date_default_timezone_set('Asia/Jakarta');
	}

	function _template($data)
	{
		$this->load->view('temp_main_data/main',$data);	
	}
	 
// AKUN ADMIN
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
	public function akun_super_admin()
	{
		$ajax=$this->input->post("ajax");
		if($ajax=="yes")
		{
			$var["data"]=$this->load->view("view_akun_super_admin",null,true);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$data['konten']="view_akun_super_admin";
			$this->_template($data);
		}
	} 

	function get_data_admin(){
        $list = $this->mdl->get_data_admin();
		$data = array();
		$no = $this->m_reff->san($this->input->post("start"));
		if(!$this->m_reff->san($this->input->post("draw"))){ echo $this->m_reff->page403(); return false;}
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
			"draw" => $this->m_reff->san($this->input->post("draw")),
			"recordsTotal" => $c=$this->mdl->count_data_admin(),
			"recordsFiltered" =>$c,
			"data" => $data,
			"token"=>$this->m_reff->getToken()
		);
		//output to json format
		echo json_encode($output);
    }
	function get_data_superadmin(){
		if(!$this->m_reff->san($this->input->post("draw"))){ echo $this->m_reff->page403(); return false;}
        $list = $this->mdl->get_data_superadmin();
		$data = array();
		$no = $this->m_reff->san($this->input->post("start"));
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
			$row[] = isset($relasi->nip)?($relasi->nip):null;
			$row[] = $this->m_reff->jk(isset($relasi->jk)?($relasi->jk):null);
			// $row[] = $dataDB->alamat;
			$row[] = isset($relasi->no_hp)?($relasi->no_hp):null;
			$row[] = isset($relasi->email)?($relasi->email):null;
		 
			$row[] = $tombol;



			$data[] = $row; 
			
		}

		$output = array(
			"draw" => $this->m_reff->san($this->input->post("draw")),
			"recordsTotal" => $c=$this->mdl->count_data_superadmin(),
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

    function add_akun_superadmin(){
		$f=$this->input->post();
		if(!$f){ return $this->m_reff->page403();}
		
		$var["data"]=$this->load->view("view_add_akun_superadmin","",true);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}

    function insert_akun_admin(){
		$f=$this->input->post();
		if(!$f){ return $this->m_reff->page403();}

        $data = $this->mdl->insert_akun_admin();
		echo json_encode($data);
    }
    function insert_akun_superadmin(){
		$f=$this->input->post();
		if(!$f){ return $this->m_reff->page403();}

        $data = $this->mdl->insert_akun_superadmin();
		echo json_encode($data);
    }

    function edit_akun_admin(){
		$f=$this->m_reff->san($this->input->post("id"));
		if(!$f){ return $this->m_reff->page403();}

        $var["data"]=$this->load->view("view_edit_akun_admin","",true);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
    }
    function edit_akun_superadmin(){
		$f=$this->m_reff->san($this->input->post("id"));
		if(!$f){ return $this->m_reff->page403();}

        $var["data"]=$this->load->view("view_edit_akun_superadmin","",true);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
    }

    function update_akun_admin(){
		$f=$this->input->post("f");
		if(!$f){ return $this->m_reff->page403();}

		$data = $this->mdl->update_akun_admin();
		echo json_encode($data);
	}

    function update_akun_superadmin(){
		$f=$this->input->post("f");
		if(!$f){ return $this->m_reff->page403();}

		$data = $this->mdl->update_akun_superadmin();
		echo json_encode($data);
	}

    function hapus_akun_admin(){
		$f=$this->input->post("id");
		if(!$f){ return $this->m_reff->page403();}

        $data = $this->mdl->hapus_akun_admin();
		echo json_encode($data);
    }
    function hapus_akun_superadmin(){
		$f=$this->input->post("id");
		if(!$f){ return $this->m_reff->page403();}

        $data = $this->mdl->hapus_akun_superadmin();
		echo json_encode($data);
    }


	// AKUN ADMIN
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
        $list = $this->m_pusat->get_data_pimpinan_pusat();
		$data = array();
		$no = $this->m_reff->san($this->input->post("start"));
		if(!$this->m_reff->san($this->input->post("draw"))){ echo $this->m_reff->page403(); return false;}
		$no =$no+1;
		foreach ($list as $dataDB) {
		$getBiro = $this->db->get_where("tr_biro", ["kode" => $dataDB->kode_biro])->row();

        $nama_biro = isset($getBiro->nama)?($getBiro->nama):null;


			$tombol='<div aria-label="Basic example" class="btn-groupss" role="group">
			<button style="display:none;" onclick="edit(`'.$dataDB->id_admin.'`,`'.$dataDB->owner.'`)" class="font14 btn btn-sm btn-secondary" type="button">Edit</button> 
			<button onclick="hapus(`'.$dataDB->id_admin.'`,`'.$dataDB->owner.'`)" class="text-white font14 btn btn-sm bg-danger" type="button">Hapus</button> 
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
			// $row[] = $dataDB->kode_istana;
			// $row[] = $nama_biro;
			$row[] = $tombol;
			 

			$data[] = $row; 
			
		}

		$output = array(
			"draw" => $this->m_reff->san($this->input->post("draw")),
			"recordsTotal" => $c=$this->m_pusat->count_data_pimpinan_pusat(),
			"recordsFiltered" =>$c,
			"data" => $data,
			"token"=>$this->m_reff->getToken()
		);
		//output to json format
		echo json_encode($output);
    }

    function add_akun_pimpinan_pusat(){
		$form = $this->input->post();
		if(!$form){return $this->m_reff->page403();}

		$var["data"]=$this->load->view("view_add_akun_pimpinan_pusat","",true);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}

    function insert_akun_pimpinan_pusat(){
		$form = $this->input->post();
		if(!$form){return $this->m_reff->page403();}

        $data = $this->m_pusat->insert_akun_pimpinan_pusat();
		echo json_encode($data);
    }

    function edit_akun_pimpinan_pusat(){
		$form = $this->m_reff->san($this->input->post("id"));
		if(!$form){return $this->m_reff->page403();}

        $var["data"]=$this->load->view("view_edit_akun_pimpinan_pusat","",true);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
    }

    function update_akun_pimpinan_pusat(){
		$form = $this->input->post();
		if(!$form){return $this->m_reff->page403();}

		$data = $this->m_pusat->update_akun_pimpinan_pusat();
		echo json_encode($data);
	}

    function hapus_akun_pimpinan_pusat(){
		$form = $this->m_reff->san($this->input->post("id"));
		if(!$form){return $this->m_reff->page403();}
		
        $data = $this->m_pusat->hapus_akun_pimpinan_pusat();
		echo json_encode($data);
    }
}