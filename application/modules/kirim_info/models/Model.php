<?php
class Model extends CI_Model
{


	public function __construct() {
        parent::__construct();
    }



	function idu(){
		return $this->session->userdata("id");
	}
	/*===================================*/
	public function getData()
	{
		$this->_getData();
		if($this->input->post("length") != -1)
		$this->db->limit($this->input->post("length"),$this->input->post("start"));
	 	return $this->db->get()->result();
	}
	private function _getData()
	{

		if (strlen(isset($_POST['search']['value'])?($_POST['search']['value']):null)>1) {
				$searchkey = $_POST['search']['value'];
				$searchkey = $this->m_reff->sanitize($searchkey);

				$query=array(
				"judul"=>$searchkey,
				"tgl"=>$searchkey,
				"isi"=>$searchkey,
				"sts"=>$searchkey,

				);
				$this->db->group_start()
                        ->or_like($query)
                ->group_end();

			}
			$this->db->where("kode_biro",$this->session->userdata("kode_biro"));
			$this->db->where("kode_istana",$this->session->userdata("kode_istana"));
		$this->db->order_by("id","desc");
		$query=$this->db->from("data_informasi");
		return $query;

	}
	public function count()
	{
		$this->_getData();
		return $this->db->get()->num_rows();
	}

	function insert(){
		$form	=	$this->input->post("f");
		$this->db->set($form);
		
		 if(isset($_FILES["gambar"]['tmp_name']))
			{  
    			$dok = "plug/img/info";
    			$file = $this->m_reff->upload_file("gambar",$dok,"gambar".date('His'),"mp4,MP4,mpeg,pdf,docs,docx,xlxs,JPG,JPEG,PNG,jpg,jpeg,png",250000000);
    			if($file["validasi"]!=false){
    				$this->db->set("file_name",$file["name"]);
    			}else{
					$var["gagal"]=true;
					$var["info"]=$file["info"];
					$var["token"]=$this->m_reff->getToken();
					return $var;
				}
			}
 
		$this->db->set("kode_biro",$this->session->userdata("kode_biro"));
		$this->db->set("kode_istana",$this->session->userdata("kode_istana"));
		$this->db->insert("data_informasi");
		$var["token"]=$this->m_reff->getToken();
		return $var;
	}
	function update(){
		$id		=	$this->input->post("id");
		$form	=	$this->input->post("f");
		$gambar_b=$this->input->post("gambar_b");
		
		if(isset($_FILES["gambar"]['tmp_name']))
		{  
			$dok = "plug/img/info";
			$file = $this->m_reff->upload_file("gambar",$dok,"gambar".date('His'),"mp4,MP4,mpeg,pdf,docs,docx,xlxs,JPG,JPEG,PNG,jpg,jpeg,png",250000000,$gambar_b);
			if($file["validasi"]!=false){
				$this->db->set("file_name",$file["name"]);
			}else{
				$var["gagal"]=true;
				$var["info"]=$file["info"];
				$var["token"]=$this->m_reff->getToken();
				return $var;
			}
		}
			
			
		$this->db->set($form);
		$this->db->where("id",$id);
		$this->db->update("data_informasi");
		$var["token"]=$this->m_reff->getToken();
		return $var;
	}

	function hapus(){
		$id	=	$this->input->post("id");
		$this->db->where("id",$id);
		$this->db->delete("data_informasi");
		$var["token"]=$this->m_reff->getToken();
		return $var;
	}

}
