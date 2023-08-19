<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Konfigurasi extends MY_Controller {

	 
	var $tbl="admin";
	function __construct()
	{
		parent::__construct();	
		$this->m_konfig->validasi_session(array("super_admin"));
		$this->load->model("model","mdl");
		date_default_timezone_set('Asia/Jakarta');
	}
	 
	function _template($data)
	{
	$this->load->view('temp_main_data/main',$data);	
	}
 
	// public function index()
	// {
		 	
	// 	$ajax=$this->input->get_post("ajax");
	// 	if($ajax=="yes")
	// 	{
	// 		echo	$this->load->view("index");
	// 	}else{
	// 		$data['konten']="index";
	// 		$this->_template($data);
	// 	}
		
	// }
	
	public function database()
	{
		 	
		$ajax=$this->input->get_post("ajax");
		if($ajax=="yes")
		{
			echo	$this->load->view("database");
		}else{
			$data['konten']="database";
			$this->_template($data);
		}
		
	}
	public function login()
	{
		 	
		$ajax=$this->input->get_post("ajax");
		if($ajax=="yes")
		{
			echo	$this->load->view("login");
		}else{
			$data['konten']="login";
			$this->_template($data);
		}
		
	}
	 function save_()
	{
	$idp=$this->security->xss_clean($this->input->post("idpengaturan"));
	$val=$this->security->xss_clean($this->input->post("idkonten"));
	$data=$this->mdl->save_($idp,$val);
	echo json_encode($data);
	}
	
	function backupdb()
	{
		
	   $add="";//$this->m_reff->tm_pengaturan(36);
	   $db=$this->m_reff->pengaturan(11);
	   $nama=$db."-"; 
	   $table=array(
		   "admin","data_acara","data_file",
		   "data_group","data_kontak","data_peserta",
		   "data_peserta_scan","file_peserta","main_konfig",
		   "main_level","main_log","main_menu","pengaturan",
		   "tm_persetujuan","tr_jenis_kegiatan","tr_jenis_undangan",
		   "tr_persetujuan","tr_tempat_rakor");
	      
      $this->load->dbutil();
      $prefs = array(     
            //   'tables'      =>$table,
                    'format'      => 'zip',             
                    'filename'    => $nama.date("d-m-Y").'.sql'
                  );
      $backup =& $this->dbutil->backup($prefs,$add); 
      $db_name = $nama .  date("d-m-Y") .'.zip'; //NAMAFILENYA
      $save = 'file_upload/'.$db_name;
      $this->load->helper('file');
      write_file($save, $backup); 
      $this->load->helper('download');
      force_download($db_name, $backup);
	}
	
	  public function restore()    
    {

        $this->load->helper('file');
       // $this->load->model('sismas_m');
        $config['upload_path']="./file_upload/";
        $config['allowed_types']="*";
        $this->load->library('upload',$config);
        $this->upload->initialize($config);

        if(!$this->upload->do_upload("datafile")){
         $error = array('error' => $this->upload->display_errors());
         echo "GAGAL UPLOAD";
         var_dump($error);
         exit();
        }

        $file = $this->upload->data();  //DIUPLOAD DULU KE DIREKTORI assets/database/
        $fotoupload=$file['file_name'];
                    
          $isi_file = file_get_contents('./file_upload/' . $fotoupload); //PANGGIL FILE YANG TERUPLOAD
          $string_query = rtrim( $isi_file, "\n;" );
          $array_query = explode(";", $string_query);   //JALANKAN QUERY MERESTORE KEDATABASE
              foreach($array_query as $query)
              {
                   $this->db->query($query);
              }

          $path_to_file = './file_upload/' . $fotoupload;
            if(unlink($path_to_file)) {   // HAPUS FILE YANG TERUPLOAD
                 redirect('/konfigurasi/database');
            }
            else {
                 echo 'errors occured';
            }
        
    }
	
	function resset()
	{
		echo json_encode($this->mdl->resset());
	}
}