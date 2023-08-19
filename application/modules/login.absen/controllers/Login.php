<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	

	function __construct()
	{
		parent::__construct();	
			$this->load->model('google_login_model');
			$this->load->model('M_login','mdl');
			$this->load->library('Ldap','ldap');
		date_default_timezone_set('Asia/Jakarta');
	}
	function sescaptcha($captcha)
	{
	$this->session->set_userdata(array("captcha"=>$captcha));
	}
	 function captcha()
	{
	$captcha=substr(str_shuffle("123456789"),0,5); // string yg akan diacak membentuk captcha 0-z dan sebanyak 6 karakter
	$this->sescaptcha($captcha);
	$gambar=ImageCreate(50,25); // ukuran kotak width=60 dan height=20
	$wk=ImageColorAllocate($gambar, 255, 255, 255); // membuat warna kotak -> Navajo White
	$wt=ImageColorAllocate($gambar, 71, 153, 153); // membuat warna tulisan -> Putih
	ImageFilledRectangle($gambar, 190, 776, 50, 120, $wk);
	ImageString($gambar, 10, 1, 3, $captcha, $wt);
	return ImageJPEG($gambar);
	}
	function _template($data)
	{
		//	$this->load->view('temp_login/main',$data);
	}
	function cek()
	{
	   echo sprintf("%05s", 4341);
	}
	public function logout()
	{
		 $this->session->sess_destroy();
		$this->load->view("logout");
		 redirect("login");
		
	}

	function index(){



		$google_client = new Google_Client();

		$google_client->setClientId($this->m_reff->pengaturan(39)); //Define your ClientID
	  
		$google_client->setClientSecret($this->m_reff->pengaturan(40)); //Define your Client Secret Key
	  
		$google_client->setRedirectUri(base_url().'login'); //Define your Redirect Uri
	  
		$google_client->addScope('email');
	  
		$google_client->addScope('profile');
	  
		if(isset($_GET["code"]))
		{
		 $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);
	  
		 if(!isset($token["error"]))
		 {
		  $google_client->setAccessToken($token['access_token']);
	  
		  $this->session->set_userdata('access_token', $token['access_token']);
	  
		  $google_service = new Google_Service_Oauth2($google_client);
	  
		  $data = $google_service->userinfo->get();
	  
		  $current_datetime = date('Y-m-d H:i:s');
	  
		  if($res = $this->google_login_model->Is_already_register($data['id']))
		  {
		   //update data
		   $user_data = array(
			// 'first_name' => $data['given_name'],
			// 'last_name'  => $data['family_name'],
			// 'email_address' => $data['email'],
			'gpic'=> $data['picture'],
			'last_login' => date('Y-m-d H:i:s')
		   );
		   $this->google_login_model->Update_user_data($user_data, $data['id']);

		   $data = $this->mdl->cek_loggin_google($res);
		   if($data["sts"]){
			   redirect($data['direct']);
		   }else{
				$this->session->set_flashdata("err",true);
				redirect("login");
		   }

		  }
		  else
		  {
		   //insert data
		//    $user_data = array(
		// 	'gid' => $data['id'],
		// 	'gpic'=> $data['picture'],
		//    );
		//    $this->google_login_model->Insert_user_data($user_data);

				// $var["gagal"] = true;
				// $var["info"] = "Akun google anda belum didaftarkan";
				// return $var;
				$this->session->set_flashdata("err",true);
				redirect("login");

		  }
		  $this->session->set_userdata('user_data', $user_data);
		 }
		}

		if($this->m_reff->mobile()){
			$view="mobile";
		}else{
			$view="login";
		}

 
		$login_button = $google_client->createAuthUrl();
		if(!$this->session->userdata('access_token'))
		{
		 $data['login_button'] = $login_button;
		 $this->load->view($view, $data);
		}
		else
		{
			$data['login_button'] = $login_button;
		 $this->load->view($view,$data);
		}


		
		
	}

 
	 
	function cekLogin()
	{
		$cek = $this->input->post('username');
		if(!$cek){ return $this->m_reff->page403();}
		$hasil=$this->mdl->cekLogin();
		echo json_encode($hasil);
	}
	 
	  
  
}

