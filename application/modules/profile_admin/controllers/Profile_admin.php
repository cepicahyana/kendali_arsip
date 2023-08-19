<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile_admin extends CI_Controller {



	function __construct()
	{
		parent::__construct();
		$this->load->model("Model","mdl");
		$this->load->library('form_validation');
		date_default_timezone_set('Asia/Jakarta');
	}

	function _template($data)
  	{
		$this->load->view('temp_admin_ppnpn/main',$data);
	}

	public function index()
	{

		$level=strtoupper($this->session->userdata("level"));
		if($level=="ADMIN_PPNPN"){
			$index = "admin_ppnpn";
			$data['data']=$this->mdl->dataProfileAdminPpnpn();
		}elseif($level == "PIC_PPNPN"){
			$index = "pic_ppnpn";
			$data['data']=$this->mdl->dataProfilePicPpnpn();
		}else{
			$index = "pic_ppnpn";
			$data['data']=$this->mdl->dataProfilePimpinanPpnpn();
		}

		$ajax=$this->input->get_post("ajax");
		if($ajax=="yes")
		{
			$var["data"]=$this->load->view($index,$data,TRUE);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$data['konten']=$index;
			$this->_template($data);
		}

	}
		public function editProfile()
		{
			$f=$this->input->post('f');
			if(!$f){ return $this->m_reff->page403();}
			echo $this->mdl->update();
			redirect('profile_admin');
		}

	    // public function updatePassword()
	    // {
	    //     $this->form_validation->set_rules('passLama', 'Password Lama', 'trim|required|min_length[5]|max_length[25]');
	    //     $this->form_validation->set_rules('passBaru', 'Password Baru', 'trim|required|min_length[5]|max_length[25]');
	    //     $this->form_validation->set_rules('passKonf', 'Password Konfirmasi', 'trim|required|min_length[5]|max_length[25]');

	    //     $id = $this->session->userdata('id');
	    //     if ($this->form_validation->run() == true) {
	    //         if (password_verify($this->input->post('passLama'), $this->session->userdata('password'))) {
	    //             if ($this->input->post('passBaru') != $this->input->post('passKonf')) {
	    //                 $this->session->set_flashdata('msg', show_err_msg('Password Baru dan Konfirmasi Password harus sama'));
	    //                 redirect('profile_admin/index');
	    //             } else {
	    //                 $data = ['password' => get_hash($this->input->post('passBaru'))];
	    //                 $result = $this->mdl->update($data, $id);
	    //                 if ($result > 0) {
	    //                     $this->updateProfil();
	    //                     $this->session->set_flashdata('msg', show_succ_msg('Password Berhasil diubah'));
	    //                     redirect('profile_admin/index');
	    //                 } else {
	    //                     $this->session->set_flashdata('msg', show_err_msg('Password Gagal diubah'));
	    //                     redirect('profile_admin/index');
	    //                 }
	    //             }
	    //         } else {
	    //             $this->session->set_flashdata('msg', show_err_msg('Password Salah'));
	    //             redirect('profile_admin/index');
	    //         }
	    //     } else {
	    //         $this->session->set_flashdata('msg', show_err_msg(validation_errors()));
	    //         redirect('profile_admin/index');
	    //     }
	    // }

	    // private function _do_upload()
	    // {
	    //     $config['upload_path']          = 'assets/uploads/images/foto_profil/';
	    //     $config['allowed_types']        = 'gif|jpg|png';
	    //     $config['max_size']             = 100; //set max size allowed in Kilobyte
	    //     $config['max_width']            = 1000; // set max width image allowed
	    //     $config['max_height']           = 1000; // set max height allowed
	    //     $config['file_name']            = round(microtime(true) * 1000);
	    //     $this->load->library('upload', $config);

	    //     if (!$this->upload->do_upload('photo')) {
	    //         $this->session->set_flashdata('msg', $this->upload->display_errors('', ''));
	    //         redirect('profile_admin/index');
	    //     }
	    //     return $this->upload->data('file_name');
	    // }
	}
	?>
