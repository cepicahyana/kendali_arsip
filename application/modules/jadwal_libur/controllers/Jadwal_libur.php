<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jadwal_libur extends MY_Controller {

	function __construct(){
		parent::__construct();	
		$this->m_konfig->validasi_session(array("pic_ppnpn", "pimpinan_ppnpn","admin_ppnpn","super_admin"));
		$this->load->model("model","mdl");
		date_default_timezone_set('Asia/Jakarta');
	}

    function _template($data){
		$this->load->view('temp_admin_ppnpn/main', $data);
	}

    public function index(){
		$ajax = $this->input->get_post("ajax");
		if ($ajax == "yes") {
	 
			$data['jp'] = $this->mdl->getJp();
		 
			$data['header'] = "Jadwal Libur";
			$data['token'] = $this->m_reff->getToken();
			$data['data'] = $this->load->view("index", null,true);
			echo json_encode($data);
		} else {
		 
			$data['jp'] = $this->mdl->getJp();
			 
			$data['header'] = "Jadwal Libur";
			$data['konten'] = "index";
			$this->_template($data);
		}
	}

    function process() {
	// $tahun=$this->m_reff->tahun();
	// $sms=$this->m_reff->semester();
        $type = isset($_POST['type'])?($_POST['type']):"";
        if ($type == 'fetch') {
            // $status = " AND last_cekout IS NULL ";

            $events = array();

            $fetch = $this->db->query("SELECT * FROM tm_jadwal_libur")->result();

          //  $fetch = $this->db->query("SELECT * FROM tm_tamu where id_user='" . $this->session->userdata('idu') . "' $status ")->result();

            foreach ($fetch as $fetch) {
                $e = array();
                $e['id'] = $fetch->id; 
                $e['title'] = $fetch->nama; 
                $e['start'] = $fetch->start;
                $e['end'] =  $this->tanggal->tambah_tgl($fetch->end,1);
                $e['backgroundColor'] =  "red";

              //  $allday = ($fetch->allDay == "true") ? true : false;
                $e['allDay'] = "true";
                array_push($events, $e);
            }
            echo json_encode($events);
        }
    }

    public function add(){
        $cek=$this->input->post("ket");
		if(!$cek){ return $this->m_reff->page403();}

        echo $this->mdl->add();
	}

    public function update(){
        $cek=$this->input->post("id");
		if(!$cek){ return $this->m_reff->page403();}

        echo $this->mdl->update();
	}
    
    public function moveEvent(){
        $cek=$this->input->post("id");
		if(!$cek){ return $this->m_reff->page403();}

        echo $this->mdl->moveEvent();
	}

    function info(){
        $id=$this->input->post("id");
        if(!$id){ return $this->m_reff->page403();}

        $title=$this->input->post("title");
        echo "<textarea class='form-control' id='title'>".$title."</textarea>";
        echo "<br>";
        echo "<button class='btn bg-pink' onclick='hapus(`".$id."`)'>Hapus</button>";
        echo "<button class='btn bg-teal pull-right' onclick='save(`".$id."`)'>Simpan</button>";
    }

	function hapus(){
        $id=$this->input->post("id");
        if(!$id){ return $this->m_reff->page403();}
        
        echo $this->mdl->hapus();
    }


}