<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Input_permohonan extends MY_Controller {

	

	function __construct()
	{
		parent::__construct();	
		$this->m_konfig->validasi_session(array("pegawai","pic"));
		$this->load->model("model","mdl");
		date_default_timezone_set('Asia/Jakarta');
	 
	}
	
	function _template($data)
	{
	$this->load->view('temp_main/main',$data);	
	}
	 
	  public function keluarga()
	{
		$ajax=$this->input->get_post("ajax");
		if($ajax=="yes")
		{
			$var["data"]=$this->load->view("family",NULL,TRUE);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$data['konten']="family";
			$this->_template($data);
		}
		
	}  
	function setHp(){
		$f=$this->input->post('id');
		if(!$f){ return $this->m_reff->page403();}
		$dt = $this->mdl->setHp();
		echo json_encode($dt);
	 }
	  public function index()
	{
		$ajax=$this->input->get_post("ajax");
		if($ajax=="yes")
		{
			$var["data"]=$this->load->view("index",NULL,TRUE);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$data['konten']="index";
			$this->_template($data);
		}
		
	}  
	function getData()
	{
		if(!$this->input->post("draw")){ echo $this->m_reff->page403(); return false;}
		$list = $this->mdl->get_data();
		$data = array();
		$no = $this->input->post("start");
		$no =$no+1;
		foreach ($list as $dataDB) {
		////
		$db	=	$this->db->get_where("data_pegawai",array("nik"=>$dataDB->nik))->row();

		if($dataDB->sts_acc!=0){
			$tombol = "<a class='text-primary' href='".site_url("download")."?f=".$this->m_reff->encrypt($dataDB->file)."'> <i class='fa fa-download' ></i> Download hasil</a>
			";
		}else{
		$tombol='<div aria-label="Basic example" class="btn-groupss" role="group">
		<button onclick="edit(`'.$dataDB->id.'`,`'.$dataDB->nama.'`)" class="btn btn-sm btn-secondary pd-x-25 active" type="button">Edit</button> 
		<button onclick="hapus(`'.$dataDB->id.'`,`'.$dataDB->nip.'`,`'.$dataDB->nama.'`)" class="btn btn-sm btn-danger pd-x-25" type="button">Hapus</button> 
	   </div>';
		}

			


	  if($dataDB->hasil=="+"){
		  $hasil = "<span class='badge badge-danger'>positif +</span>";
	  }elseif($dataDB->hasil=="-"){
		  $hasil = "<span class='badge badge-success'>negatif -</span>";
	  }else{
		$hasil = "<span class='badge badge-info'>".$dataDB->hasil."</span>";
	  }
		 
	  		
	 if($dataDB->sts_acc==0){
		$acc =  '	<span  class="badge  badge-secondary pd-x-25 active" type="button">Belum disetujui</span> ';
 }else{
	 if($dataDB->hasil){
		$acc = '	<span  class="badge btn-success pd-x-25 active" type="button">Telah disetujui</span> ';
	 }else{
		$acc = '	<span  class="badge   badge-success pd-x-25 active" type="button">Telah disetujui</span> ';
	 }
 }	
		    
			$row = array();
			// $row[] =  $no++;	
			$row[] = $this->tanggal->hariLengkap3($dataDB->tgl,"/");
			$row[] = $acc;
			$row[] = $dataDB->nama;
			$row[] = $db->jabatan;
			$row[] = $this->m_reff->goField("tr_jenis_test","nama","where kode='".$dataDB->kode_jenis."'");
			$row[] = $this->m_reff->goField("tm_rs","nama","where kode='".$dataDB->kode_tempat."'");
			$row[] = $hasil;
			$row[] = $tombol;
			 
		  
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
 

	 function viewAddPribadi(){
		$f=$this->input->post();
		// if(!$f){ return $this->m_reff->page403();}
		$var["data"]=$this->load->view("viewAddPribadi",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	 }
	 

	 function viewEditPribadi(){
		$id=$this->input->post('id');
		if(!$id){ return $this->m_reff->page403();}
		$var["data"]=$this->load->view("viewEditPribadi",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	 }
	 
	 function viewEdit(){
		$id=$this->input->post('id');
		if(!$id){ return $this->m_reff->page403();}
		$this->load->view("viewEdit");
	 }
	 
	 
	 function insert(){
		$f=$this->input->post('f');
		if(!$f){ return $this->m_reff->page403();}
		$dt = $this->mdl->insert();
		echo json_encode($dt);
	 }
	 function setNIK(){
		$f=$this->input->post('id');
		if(!$f){ return $this->m_reff->page403();}
		$dt = $this->mdl->setNIK();
		echo json_encode($dt);
	 }
	 function setTglLahir(){
		$f=$this->input->post('id');
		if(!$f){ return $this->m_reff->page403();}
		$dt = $this->mdl->setTglLahir();
		echo json_encode($dt);
	 }
	 function setTempatLahir(){
		$f=$this->input->post('id');
		if(!$f){ return $this->m_reff->page403();}
		$dt = $this->mdl->setTempatLahir();
		echo json_encode($dt);
	 }
	 
	 function update(){
		$f=$this->input->post('f');
		if(!$f){ return $this->m_reff->page403();}
		$dt = $this->mdl->update();
		echo json_encode($dt);
	 }
	 function hapus(){
		$id=$this->input->post('id');
		if(!$id){ return $this->m_reff->page403();}
		$dt = $this->mdl->hapus();
		echo json_encode($dt);
	 }


	 function getDataPegawai(){
        $data = $this->mdl->getDataPegawai();
        if(!$data){
            echo "<br><div style='width:100%' class='alert alert-danger mg-b-0' role='alert'> <button aria-label='Close' class='close' data-dismiss='alert' type='button'> <span aria-hidden='true'>×</span> </button> 
              Data tidak ditemukan!</div>";
        }else{
            echo '
			<input type="hidden" name="f[nama]" value="'.$data->nama.'"> 
			<input type="hidden" name="f[nip]" value="'.$data->nip.'"> 
			<input type="hidden" name="f[nik]" value="'.$data->nik.'"> 
            ';
            echo '<br><table class="entry" width="100%">
            <tr>
            <td>Nama </td> <td>'.$data->nama.'</td>
            </tr>
           
            <tr>
            <td>Biro </td> <td>'.$data->biro.'</td>
            </tr>
            <tr>
            <td>Bagian </td> <td>'.$data->bagian.'</td>
            </tr>
            <tr>
            <td>Jabatan </td> <td>'.$data->jabatan.'</td>
            </tr>
            <tr>
            <td>No Hp </td> <td>'.$data->no_hp.'</td>
            </tr>
            <tr>
            <td>Email </td> <td>'.$data->email.'</td>
            </tr>
            </table>';


        }
    }
	 function getDataPegawaiEdit(){
        $data = $this->mdl->getDataPegawaiEdit();
        if(!$data){
            echo "<br><div style='width:100%' class='alert alert-danger mg-b-0' role='alert'> <button aria-label='Close' class='close' data-dismiss='alert' type='button'> <span aria-hidden='true'>×</span> </button> 
              Data tidak ditemukan!</div>";
        }else{
            echo '
           
            ';
            echo '<br><table class="entry" width="100%">
            <tr>
            <td>Nama </td> <td>'.$data->nama.'</td>
            </tr>
           
            <tr>
            <td>Biro </td> <td>'.$data->biro.'</td>
            </tr>
            <tr>
            <td>Bagian </td> <td>'.$data->bagian.'</td>
            </tr>
            <tr>
            <td>Jabatan </td> <td>'.$data->jabatan.'</td>
            </tr>
            <tr>
            <td>No Hp </td> <td>'.$data->no_hp.'</td>
            </tr>
            <tr>
            <td>Email </td> <td>'.$data->email.'</td>
            </tr>
            </table>';


        }
    }

	function getDataFamily()
	{
		if(!$this->input->post("draw")){ echo $this->m_reff->page403(); return false;}
		$list = $this->mdl->get_data_family();
		$data = array();
		$no = $this->input->post("start");
		$no =$no+1;

		foreach ($list as $dataDB) {
		////
		// $db	=	$this->db->get_where("data_pegawai",array("nip"=>$dataDB->nip_pegawai))->row();

		if($dataDB->sts_acc!=0){
			$tombol = "<a class='text-primary' href='".site_url("download")."?f=".$this->m_reff->encrypt($dataDB->file)."'> <i class='fa fa-download' ></i> Download hasil</a>
			";
		}else{
		$tombol='<div aria-label="Basic example" class="btn-groupss" role="group">
		<button onclick="edit(`'.$dataDB->id.'`,`'.$dataDB->nama.'`)" class="btn btn-sm btn-secondary pd-x-25 active" type="button">Edit</button> 
		<button onclick="hapus(`'.$dataDB->id.'`,`'.$dataDB->nip_pegawai.'`,`'.$dataDB->nama.'`,`'.$dataDB->kode.'`,)" class="btn btn-sm btn-danger pd-x-25" type="button">Hapus</button> 
	   </div>';
		}

			


	  if($dataDB->hasil=="+"){
		  $hasil = "<span class='badge badge-danger'>positif +</span>";
	  }elseif($dataDB->hasil=="-"){
		  $hasil = "<span class='badge badge-success'>negatif -</span>";
	  }else{
		$hasil = "<span class='badge badge-info'>belum keluar</span>";
	  }
		 

	  if($this->session->userdata("level")=="pic"){
		  $btnedit = 'onclick="edit(`'.$dataDB->id.'`,`1`,`'.$dataDB->nama.'`)" ';
	  }else{
		  $btnedit = $this->session->pic;
	  }
	  

 if($dataDB->sts_acc==0){
		$acc =  '	<button '.$btnedit.' class="btn btn-sm btn-secondary pd-x-25 active" type="button">Belum disetujui</button> ';
 }else{
	 if($dataDB->hasil){
		$acc = '	<button disabled class="btn btn-sm btn-success pd-x-25 active" type="button">Telah disetujui</button> ';
	 }else{
		$acc = '	<button  '.$btnedit.' class="btn btn-sm btn-success pd-x-25 active" type="button">Telah disetujui</button> ';
	 }
 }	
		    
			$row = array();
			// $row[] =  $no++;	
			$row[] = $this->tanggal->hariLengkap3($dataDB->tgl,"/");
			$row[] = $acc;
			$row[] = $dataDB->nama;
			$row[] = $this->m_reff->goField("data_pegawai","nama","where nip='".$dataDB->nip_pegawai."'").br().
			$this->m_reff->goField("data_pegawai","jabatan","where nip='".$dataDB->nip_pegawai."'");
			$row[] = $this->m_reff->goField("tr_hubungan","nama_".$dataDB->jk,"where id='".$dataDB->id_hubungan."'");
			$row[] = $this->m_reff->goField("tr_jenis_test","nama","where kode='".$dataDB->kode_jenis."'");
			$row[] = $this->m_reff->goField("tm_rs","nama","where kode='".$dataDB->kode_tempat."'");
			$row[] = $hasil;
			$row[] = $tombol;
			 
		  
			$data[] = $row; 
			
			}
			 
		$output = array(
						"draw" => $this->input->post("draw"),
						"recordsTotal" => $c=$this->mdl->countFamily(),
						"recordsFiltered" =>$c,
						"data" => $data,
						"token"=>$this->m_reff->getToken()
						);
		//output to json format
		echo json_encode($output);

	}
	function viewAddFamily(){
		$f=$this->input->post();
		if(!$f){ return $this->m_reff->page403();}
		$var["data"]=$this->load->view("viewAddFamily",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
 }



 function getDataKeluargaEdit(){
	$data = $this->mdl->getDataKeluargaEdit();
	$nip = $this->input->post("nip");
	$peg = $this->db->get_where("data_pegawai",array("nip"=>$nip))->row();
	$nama_peg = isset($peg->nama)?($peg->nama):"";
	$nama_peg = isset($peg->nama)?($peg->nama):"";
	$id_hub   = isset($data->id_hubungan)?($data->id_hubungan):"";
	$jk		  = isset($data->jk)?($data->jk):"";

	$hub = $this->m_reff->goField("tr_hubungan","nama_".$jk,"where id='".$id_hub."'");
	if(!$data){
		$isi =  "<div style='width:100%' class='alert alert-danger mg-b-0' role='alert'> <button aria-label='Close' class='close' data-dismiss='alert' type='button'> <span aria-hidden='true'>×</span> </button> 
		  Data tidak ditemukan!</div>";
	}else{
	 
		$isi = '<table class="entry" width="100%">
		<tr>
		<td>Nama </td> <td>'.$data->nama.'</td>
		</tr>
	   
		<tr>
		<td>Keluarga dari </td> <td>'.$nama_peg.'</td>
		</tr>
		<tr>
		<td>Hubungan keluarga </td> <td>'.$hub.'</td>
		</tr>
		 
		</table>';


	}
	$var["data"]=$isi;
	$var["token"]=$this->m_reff->getToken();
	echo json_encode($var);
}


function getDataKeluarga(){
	$nik = $this->input->post("val");
	$this->db->where("nik",$nik);
	// $this->db->where("nip_pegawai",$this->m_reff->nip());
	$val = $this->db->get("data_keluarga")->row();
	$nip_pegawai  = isset($val->nip_pegawai)?($val->nip_pegawai):"";



	if(!isset($val)){
		$var["token"]=$this->m_reff->getToken();
		$var["status"]=false;
		$var["info"]=false;
		echo json_encode($var);
	}else{
		if($nip_pegawai!=$this->m_reff->nip()){
			$var["status"]=false;
			$var["info"]="<b class='text-black'>Salah memasukan NIK</b>";
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
			return false;
		};
		
		if($val->sts_test==1){ // sedang di test
			$var["status"]=false;
			$var["info"]="<b class='text-black'>Gagal ditambahkan! <br>atas nama ".$val->nama." sudah diajukan untuk tes.</span>";
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$var["status"]=true;
			$var["tgl_lahir"]=$this->tanggal->ind($val->tgl_lahir,"/");
			$var["data"]=$val;
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}
		
	}
}
function insert_family(){
	$f=$this->input->post('f');
	if(!$f){ return $this->m_reff->page403();}
	$dt = $this->mdl->insert_family();
	echo json_encode($dt);
 }
 function viewEditFamily(){
	$id=$this->input->post('id');
	if(!$id){ return $this->m_reff->page403();}
	$var["data"]=$this->load->view("viewEditFamily",NULL,TRUE);
	$var["token"]=$this->m_reff->getToken();
	echo json_encode($var);
}
function update_family(){
	$f=$this->input->post('f');
	if(!$f){ return $this->m_reff->page403();}
	$dt = $this->mdl->update_family();
	echo json_encode($dt);
 }
}