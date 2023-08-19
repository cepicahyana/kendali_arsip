<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Input extends MY_Controller {

	

	function __construct(){
		parent::__construct();	
		$this->m_konfig->validasi_session(array("pic_covid","admin_covid","super_admin","pimpinan_covid"));
		$this->load->model("model","mdl");
		// $this->load->model("model_ppnpn","ppnpn");
		$this->load->model("model_external","external");
		date_default_timezone_set('Asia/Jakarta');

		

	}
	
	function _template($data){
		$this->load->view('temp_main/main',$data);	
	}

	public function external(){
		$ajax=$this->input->get_post("ajax");
		if($ajax=="yes")
		{
			$var["data"]=$this->load->view("external",null,true);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$data['konten']="external";
			$this->_template($data);
		}
	}   

	public function ppnpn(){
		$ajax=$this->input->get_post("ajax");
		if($ajax=="yes")
		{
			$var["data"]=$this->load->view("ppnpn",null,true);
			$var["token"]=$this->m_reff->getToken();
			echo json_encode($var);
		}else{
			$data['konten']="ppnpn";
			$this->_template($data);
		}
	}   

	public function index(){
		
								
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

	public function family(){
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

	function getData(){
		if(!$this->m_reff->san($this->input->post("draw"))){ echo $this->m_reff->page403(); return false;}
		$list = $this->mdl->get_data();
		$data = array();
		$no = $this->m_reff->san($this->input->post("start"));
		$no =$no+1;
		foreach ($list as $dataDB) {
		////
		$db	=	$this->db->get_where("data_pegawai",array("nik"=>$dataDB->nik))->row();

		if($dataDB->konfirm_rs){
			$thn=substr($dataDB->tgl,0,4);
			$url=$dataDB->file;
			$tombol = "<a class='text-primary' href='".site_url("download")."?f=". $this->m_reff->encrypt($url)."'> <i class='fa fa-download' ></i> Download hasil</a>
			<br> Tgl : ".$this->tanggal->hariLengkap($dataDB->konfirm_rs,"/");
		}else{
		 
	 if($this->session->level=="pic_covid" or $this->session->level=="admin_covid")
	 {
		$tombol='<div aria-label="Basic example" class="btn-groupss" role="group">
		<button onclick="edit(`'.$dataDB->id.'`)" class="btn btn-sm btn-secondary pd-x-25 active" type="button">Edit</button> 
		<button onclick="hapus(`'.$dataDB->id.'`,`'.$dataDB->nip.'`,`'.$dataDB->nama.'`,`'.$dataDB->kode.'`)" class="btn btn-sm btn-danger pd-x-25" type="button">Hapus</button> 
	   </div>';
		}else{
			$tombol = "";
		}
	}
	

			
	 if($dataDB->sts_acc==0){
		 if($this->session->level=="admin_covid" and $dataDB->kode_jenis=="04"){
			 $acc =  '	<button onclick="edit(`'.$dataDB->id.'`,`acc`)" class="btn btn-sm btn-secondary pd-x-25 active" type="button">Belum disetujui</button> ';
		 }elseif($this->session->level=="pic_covid" and $dataDB->kode_jenis=="04"){
			 $acc =  '	<span onclick="alert(`untuk persetujuan TCM harus oleh admin`)" class="" type="button">Belum disetujui</span> ';
		 }else{
			$acc =  '	<button onclick="edit(`'.$dataDB->id.'`,`acc`)" class="btn  btn-secondary pd-x-25 active" type="button">Belum disetujui</button> ';
		 }
	 }else{
		 if($dataDB->hasil){
			$acc = '	<button disabled class="btn btn-sm btn-success pd-x-25 active" type="button">Disetujui</button> ';
		 }else{
			$acc = '	<button onclick="edit(`'.$dataDB->id.'`,`acc`)" class="btn btn-sm btn-secondary text-warning pd-x-25 active" type="button">Disetujui</button> ';
		 }
	 }	


	  if($dataDB->hasil=="+"){
		  $hasil = "<span class='badge badge-danger'>positif +</span>";
	  }elseif($dataDB->hasil=="-"){
		  $hasil = "<span class='badge badge-success'>negatif -</span>";
	  }else{
		$hasil = "<span class='badge badge-info'>".$dataDB->hasil."</span>";
	  }
		 
	  if($dataDB->keperluan){
		  $kep = $dataDB->keperluan;
	  }else{
		  $kep = $this->m_reff->keperluan($dataDB->id_keperluan);
	  }
		    $jenis_pegawai = $this->m_reff->jenis_pegawai($dataDB->jenis_pegawai);
			$row = array();
			// $row[] =  $no++;	
			$row[] = $this->tanggal->hariLengkap3($dataDB->tgl,"/");
			$row[] = $acc;
			$row[] = $dataDB->nama.br()."<i>".$jenis_pegawai."</i>";;
			$row[] = isset($db->jabatan)?($db->jabatan):"";
			$row[] = $this->m_reff->goField("tr_jenis_test","nama","where kode='".$dataDB->kode_jenis."'");
			$row[] =  $kep;
			$row[] = $this->m_reff->goField("tm_rs","nama","where kode='".$dataDB->kode_tempat."'");
			$row[] = $hasil;
			$row[] = $tombol;
			 
		  
			$data[] = $row; 
			
			}
			 
		$output = array(
						"draw" => $this->m_reff->san($this->input->post("draw")),
						"recordsTotal" => $c=$this->mdl->count(),
						"recordsFiltered" =>$c,
						"data" => $data,
						"token"=>$this->m_reff->getToken()
						);
		//output to json format
		echo json_encode($output);

	}
 

	function setStsAcc(){
		$id=$this->m_reff->san($this->input->post("id"));
		if(!$id){ return $this->m_reff->page403();}

		$this->mdl->setStsAcc();
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}

	function setStsAccFam(){
		$id=$this->m_reff->san($this->input->post("id"));
		if(!$id){ return $this->m_reff->page403();}

		$this->mdl->setStsAccFam();
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}

	function viewAddFamily(){
		$f = $this->input->post();
		if(!$f){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("viewAddFamily",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}

	function viewAddExternal(){
		$f = $this->input->post();
		if(!$f){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("viewAddExternal",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}

	function viewAdd(){
		$f = $this->input->post();
		if(!$f){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("viewAdd",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}

	function viewAddppnpn(){
		$f = $this->input->post();
		if(!$f){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("viewAddPpnpn",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
	 
	function viewEditFamily(){
		$id = $this->m_reff->san($this->input->post("id"));
		if(!$id){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("viewEditFamily",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}

	function viewEdit(){
		$id = $this->m_reff->san($this->input->post("id"));
		if(!$id){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("viewEdit",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}

	function viewEditPpnpn(){
		$id = $this->m_reff->san($this->input->post("id"));
		if(!$id){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("viewEditPpnpn",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}

	function viewEditExternal(){
		$id = $this->m_reff->san($this->input->post("id"));
		if(!$id){ return $this->m_reff->page403();}

		$var["data"]=$this->load->view("viewEditExternal",NULL,TRUE);
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
	}
	 
	function insert_family(){
		$f = $this->input->post("f");
		if(!$f){ return $this->m_reff->page403();}

		$dt = $this->mdl->insert_family();
		echo json_encode($dt);
	}

	function insert_ppnpn(){
		$f = $this->input->post("f");
		if(!$f){ return $this->m_reff->page403();}

		$dt = $this->ppnpn->insert();
		echo json_encode($dt);
	}

	function insert_external(){
		$f = $this->input->post("f");
		if(!$f){ return $this->m_reff->page403();}

		$dt = $this->external->insert();
		echo json_encode($dt);
	}


	function insert(){
		$f = $this->input->post("f");
		if(!$f){ return $this->m_reff->page403();}

		$dt = $this->mdl->insert();
		echo json_encode($dt);
	}
	 
	function update(){
		$f = $this->input->post("f");
		if(!$f){ return $this->m_reff->page403();}

		$dt = $this->mdl->update();
		echo json_encode($dt);
	}
	 
	function update_ppnpn(){
		$f = $this->input->post("f");
		if(!$f){ return $this->m_reff->page403();}

		$dt = $this->ppnpn->update();
		echo json_encode($dt);
	}
	 
	function update_external(){
		$f = $this->input->post("f");
		if(!$f){ return $this->m_reff->page403();}

		$dt = $this->external->update();
		echo json_encode($dt);
	}
	 
	function update_family(){
		$f = $this->input->post("f");
		if(!$f){ return $this->m_reff->page403();}

		$dt = $this->mdl->update_family();
		echo json_encode($dt);
	}

	function hapus(){
		$id = $this->m_reff->san($this->input->post("id"));
		if(!$id){ return $this->m_reff->page403();}

		$dt = $this->mdl->hapus();
		echo json_encode($dt);
	}

	function hapus_family(){
		$id = $this->m_reff->san($this->input->post("id"));
		if(!$id){ return $this->m_reff->page403();}

		$dt = $this->mdl->hapus_family();
		echo json_encode($dt);
	}

	function hapus_external(){
		$id = $this->m_reff->san($this->input->post("id"));
		if(!$id){ return $this->m_reff->page403();}

		$dt = $this->external->hapus();
		echo json_encode($dt);
	}

	function hapus_ppnpn(){
		$id = $this->m_reff->san($this->input->post("id"));
		if(!$id){ return $this->m_reff->page403();}

		$dt = $this->ppnpn->hapus();
		echo json_encode($dt);
	}
	function setNIK(){
		$f=$this->input->post('id');
		if(!$f){ return $this->m_reff->page403();}
		$dt = $this->mdl->setNIK();
		echo json_encode($dt);
	 }
	function getDataPegawai(){
		$cek = $this->m_reff->san($this->input->post("val"));
		if(!$cek){ return $this->m_reff->page403();}

        $data = $this->mdl->getDataPegawai();

		

        if(!$data){
            $isi= "<br><div style='width:100%' class='alert alert-danger mg-b-0' role='alert'> <button aria-label='Close' class='close' data-dismiss='alert' type='button'> <span aria-hidden='true'>×</span> </button> 
              Data tidak ditemukan atau sudah diajukan!</div>";
        }else{

			if(!$data->nik){
			 $nik = '
			 <br>
			 Silahkan input Nomor NIK Terlebih dahulu:<br>
			 <input required id="setNIKupdate" onchange="setNIK(`'.$data->id.'`,`this.value`)" type="number" class="form-control" name="f[nik]" value="'.$data->nik.'"> ';
			}else{
				$nik = '<input type="hidden" name="f[nik]" value="'.$data->nik.'"> ';
			}

            $isi ='
			<input type="hidden" name="f[nama]" value="'.$data->nama.'"> 

			<input type="hidden" name="f[nip]" value="'.$data->nip.'"> 
			'.$nik.'
			<input type="hidden" name="hasil_test" value="'.$data->hasil_test.'"> 
			<input type="hidden" name="kode_test" value="'.$data->kode_test.'"> 
			<input type="hidden" name="jenis_pegawai" value="'.$data->jenis_pegawai.'"> 
            ';
            $isi.='<br><table class="entry" width="100%">
            <tr>
            <td>Nama </td> <td>'.$data->nama.'</td>
            </tr>
           
            <tr>
            <td>Biro </td> <td>'.$this->m_reff->biro($data->kode_biro).'</td>
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
			<tr>
            <td>Jenis pegawai </td> <td>'.$this->m_reff->jenis_pegawai($data->jenis_pegawai).'</td>
            </tr>
            </table>';


        }

		$var["data"]=$isi;
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);

    }

	function dataPpnpn(){
		$cek = $this->m_reff->san($this->input->post("val"));
		if(!$cek){ return $this->m_reff->page403();}

        $data = $this->ppnpn->getDataPpnpn();
        if(!$data){
            $isi= "<br><div style='width:100%' class='alert alert-danger mg-b-0' role='alert'> <button aria-label='Close' class='close' data-dismiss='alert' type='button'> <span aria-hidden='true'>×</span> </button> 
              Data tidak ditemukan atau sudah ditambahkan!</div>";
        }else{
            $isi ='
			<input type="hidden" name="f[nama]" value="'.$data->nama.'"> 
			<input type="hidden" name="f[nip]" value="'.$data->nip.'"> 
			<input type="hidden" name="f[nik]" value="'.$data->nik.'"> 
			<input type="hidden" name="hasil_test" value="'.$data->hasil_test.'"> 
			<input type="hidden" name="kode_test" value="'.$data->kode_test.'"> 
            ';
            $isi.='<br><table class="entry" width="100%">
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

		$var["data"]=$isi;
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
    }

	function getDataPegawaiEdit(){
		$cek = $this->m_reff->san($this->input->post("val"));
		if(!$cek){ return $this->m_reff->page403();}

        $data = $this->mdl->getDataPegawaiEdit();
        if(!$data){
            $isi =  "<div style='width:100%' class='alert alert-danger mg-b-0' role='alert'> <button aria-label='Close' class='close' data-dismiss='alert' type='button'> <span aria-hidden='true'>×</span> </button> 
              Data tidak ditemukan!</div>";
        }else{
         
            $isi = '<table class="entry" width="100%">
            <tr>
            <td>Nama </td> <td>'.$data->nama.'</td>
            </tr>
           
            <tr>
            <td>Biro </td> <td>'.$this->m_reff->biro($data->kode_biro).'</td>
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
            <tr>
            <td>Jenis pegawai </td> <td>'.$this->m_reff->jenis_pegawai($data->jenis_pegawai).'</td>
            </tr>
            </table>';


        }
		$var["data"]=$isi;
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
    }


	function getDataPpnpnEdit(){
		$cek = $this->m_reff->san($this->input->post("val"));
		if(!$cek){ return $this->m_reff->page403();}

        $data = $this->ppnpn->getDataPpnpnEdit();
        if(!$data){
            $isi =  "<div style='width:100%' class='alert alert-danger mg-b-0' role='alert'> <button aria-label='Close' class='close' data-dismiss='alert' type='button'> <span aria-hidden='true'>×</span> </button> 
              Data tidak ditemukan!</div>";
        }else{
         
            $isi = '<table class="entry" width="100%">
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
		$var["data"]=$isi;
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);
    }

	function getDataKeluargaEdit(){
		$cek = $this->m_reff->san($this->input->post("val"));
		if(!$cek){ return $this->m_reff->page403();}

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

	function getDataFamily()
	{
		if(!$this->m_reff->san($this->input->post("draw"))){ echo $this->m_reff->page403(); return false;}
		$list = $this->mdl->get_data_family();
		$data = array();
		$no = $this->m_reff->san($this->input->post("start"));
		$no =$no+1;

		foreach ($list as $dataDB) {
		////
		// $db	=	$this->db->get_where("data_pegawai",array("nip"=>$dataDB->nip_pegawai))->row();

		if($dataDB->konfirm_rs){
			$tombol = "<a class='text-primary' href='".site_url("download")."?f=".$this->m_reff->encrypt($dataDB->file)."'> <i class='fa fa-download' ></i> Download hasil</a>
			";
		}else{
			if($this->session->level=="pic_covid")
	 {
		$tombol='<div aria-label="Basic example" class="btn-groupss" role="group">
		<button onclick="edit(`'.$dataDB->id.'`,`'.$dataDB->nama.'`)" class="btn btn-sm btn-secondary pd-x-25 active" type="button">Edit</button> 
		<button onclick="hapus(`'.$dataDB->id.'`,`'.$dataDB->nip_pegawai.'`,`'.$dataDB->nama.'`,`'.$dataDB->kode.'`,)" class="btn btn-sm btn-danger pd-x-25" type="button">Hapus</button> 
	   </div>';
	 }else{
		 $tombol = "";
	 }
		}

			


	  if($dataDB->hasil=="+"){
		  $hasil = "<span class='badge badge-danger'>positif +</span>";
	  }elseif($dataDB->hasil=="-"){
		  $hasil = "<span class='badge badge-success'>negatif -</span>";
	  }else{
		$hasil = "<span class='badge badge-info'>belum keluar</span>";
	  }
		 

	  if($this->session->userdata("level")=="pic_covid"){
		  $btnedit = 'onclick="edit(`'.$dataDB->id.'`,`1`,`'.$dataDB->nama.'`)" ';
	  }else{
		  $btnedit = $this->session->pic;
	  }
	  

 if($dataDB->sts_acc==0){
		$acc =  '	<button '.$btnedit.' class="btn btn-sm btn-secondary pd-x-25 active" type="button">Belum disetujui</button> ';
 }else{
	 if($dataDB->hasil){
		$acc = '	<button disabled class="btn btn-sm btn-success pd-x-25 active" type="button">  Disetujui</button> ';
	 }else{
		$acc = '	<button  '.$btnedit.' class="btn btn-sm btn-success pd-x-25 active" type="button">  Disetujui</button> ';
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
						"draw" => $this->m_reff->san($this->input->post("draw")),
						"recordsTotal" => $c=$this->mdl->count_family(),
						"recordsFiltered" =>$c,
						"data" => $data,
						"token"=>$this->m_reff->getToken()
						);
		//output to json format
		echo json_encode($output);

	}
 
	function getDataExternal()
	{
		if(!$this->m_reff->san($this->input->post("draw"))){ echo $this->m_reff->page403(); return false;}
		$list = $this->external->get_data();
		$data = array();
		$no = $this->m_reff->san($this->input->post("start"));
		$no =$no+1;

		foreach ($list as $dataDB) {
		////
		// $db	=	$this->db->get_where("data_pegawai",array("nip"=>$dataDB->nip_pegawai))->row();

		if($dataDB->konfirm_rs){
			$tombol = "<a class='text-primary' href='".site_url("download")."?f=".$this->m_reff->encrypt($dataDB->file)."'> <i class='fa fa-download' ></i> Download hasil</a>
			";
		}else{
			if($this->session->level=="pic_covid")
	 {
		$tombol='<div aria-label="Basic example" class="btn-groupss" role="group">
		<button onclick="edit(`'.$dataDB->id.'`,`'.$dataDB->nama.'`)" class="btn btn-sm btn-secondary pd-x-25 active" type="button">Edit</button> 
		<button onclick="hapus(`'.$dataDB->id.'`,`'.$dataDB->nik.'`,`'.$dataDB->nama.'`,`'.$dataDB->kode.'`,)" class="btn btn-sm btn-danger pd-x-25" type="button">Hapus</button> 
	   </div>';
	 }else{
		 $tombol = "";
	 }
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
		$acc = '	<button disabled class="btn btn-sm btn-success pd-x-25 active" type="button">Disetujui</button> ';
	 }else{
		$acc = '	<button  '.$btnedit.' class="btn btn-sm btn-success pd-x-25 active" type="button">Disetujui</button> ';
	 }
 }	
		    
			$row = array();
			// $row[] =  $no++;	
			$row[] = $this->tanggal->hariLengkap3($dataDB->tgl,"/");
			// $row[] = $acc;
			$row[] = $dataDB->nama;
			$row[] = $dataDB->nik;
			$row[] = $dataDB->ket;
			$row[] = $this->m_reff->goField("tr_jenis_test","nama","where kode='".$dataDB->kode_jenis."'");
			$row[] = $this->m_reff->goField("tm_rs","nama","where kode='".$dataDB->kode_tempat."'");
			$row[] = $hasil;
			$row[] = $tombol;
			 
		  
			$data[] = $row; 
			
			}
			 
		$output = array(
						"draw" => $this->m_reff->san($this->input->post("draw")),
						"recordsTotal" => $c=$this->external->count(),
						"recordsFiltered" =>$c,
						"data" => $data,
						"token"=>$this->m_reff->getToken()
						);
		//output to json format
		echo json_encode($output);

	}
 
	function getDataKeluarga(){
		$nik = $this->m_reff->san($this->input->post("val"));
		if(!$nik){
			return $this->m_reff->page403();
		}

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
			if($nip_pegawai!=$this->m_reff->san($this->input->post("nik_pegawai"))){
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
	
	function dataExternal(){
		$nik = $this->m_reff->san($this->input->post("val"));
		if(!$nik){
			return $this->m_reff->page403();
		}

		$this->db->where("nik",$nik);
		// $this->db->where("nip_pegawai",$this->m_reff->nip());
		$val = $this->db->get("data_external")->row();
		$nik  = isset($val->nik)?($val->nik):"";

	

		if(!isset($val)){
			$var["token"]=$this->m_reff->getToken();
			$var["status"]=false;
			$var["info"]=false;
			echo json_encode($var);
		}else{
			// if($nik!=$this->m_reff->nip()){
			// 	$var["status"]=false;
			// 	$var["info"]="<b class='text-black'>Salah memasukan NIK</b>";
			// 	$var["token"]=$this->m_reff->getToken();
			// 	echo json_encode($var);
			// 	return false;
			// };
			
			if($val->sts_test==1){ // sedang di test
				$var["status"]=false;
				$var["info"]="<b class='text-black'>Gagal ditambahkan! <br>atas nama ".$val->nama." sudah diajukan untuk tes.</span>";
				$var["token"]=$this->m_reff->getToken();
				echo json_encode($var);
			}else{
				$var["status"]=true;
				//$var["tgl_lahir"]=$this->tanggal->ind($val->tgl_lahir,"/");
				$var["data"]=$val;
				$var["token"]=$this->m_reff->getToken();
				echo json_encode($var);
			}
			
		}
	}

	function getDataPegawaiUntukKeluarga(){
		$val = $this->m_reff->san($this->input->post("val"));
		if(!$val){
			return $this->m_reff->page403();
		}

        $data = $this->mdl->getDataPegawaiUntukKeluarga();
		// $this->session->set_userdata("jk",isset($data->jk)?($data->jk):null);
		
        if(!$data){
            $isi= "<br><div style='width:100%' class='alert alert-danger mg-b-0' role='alert'> <button aria-label='Close' class='close' data-dismiss='alert' type='button'> <span aria-hidden='true'>×</span> </button> 
              Data tidak ditemukan !</div>";
			  $pil = "";
        }else{
			$pil ="";
			$jk_peg   = $data->jk;
		   if($jk_peg=="l"){
			  $this->db->select("id,jk,nama_p as nama");
		  }else{
			  $this->db->select("id,jk,nama_l as nama");
		  }
		  $data_hub = $this->db->get("tr_hubungan")->result();
		  foreach($data_hub as $val){
			if(strtolower($val->nama)=="istri"){
			  $jk="p";
			}elseif(strtolower($val->nama)=="suami"){
			  $jk="l";
			}else{
				$jk=$val->jk;
			}
			

			$pil.= ' <div class="row">
		    <div class="col-lg-3 p-1"> <label class="rdiobox">
		  <input onclick="klikhub(`'.strtolower($val->nama).'`,`'.$jk.'`)"
		   required type="radio" name="id_hubungan" value="'.$val->id.'"><span>'.$val->nama.'</span></label> </div>
		  </div> ';
		}
        
            $isi='<br><div class="alert alert-info">
			<b>Data pegawai:</b><table class="entry" width="100%">
            <tr>
            <td>Nama </td> <td>'.$data->nama.'</td>
            </tr>
           
            <tr>
            <td>Biro </td> <td>'.$this->m_reff->biro($data->kode_biro).'</td>
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
            </table></div><hr>';


        }
		
		$var["pilihan_hubungan"]=$pil;
		$var["data"]=$isi;
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);

    }

	function getDataExternalEdit(){
		$val = $this->m_reff->san($this->input->post("val"));
		if(!$val){
			return $this->m_reff->page403();
		}

        $data = $this->external->getDataexternalEdit();
        if(!$data){
            $isi= "<br><div style='width:100%' class='alert alert-danger mg-b-0' role='alert'> <button aria-label='Close' class='close' data-dismiss='alert' type='button'> <span aria-hidden='true'>×</span> </button> 
              Data tidak ditemukan !</div>";
        }else{
            $isi ='
			
            ';
            $isi.='<br><div class="alert alert-info">
			<b>Data pegawai:</b><table class="entry" width="100%">
            <tr>
            <td>Nama </td> <td>'.$data->nama.'</td>
            </tr>
           
            <tr>
            <td>ket </td> <td>'.$data->ket.'</td>
            </tr>
            
            <tr>
            <td>No Hp </td> <td>'.$data->no_hp.'</td>
            </tr>
            <tr>
            <td>Email </td> <td>'.$data->email.'</td>
            </tr>
            </table></div><hr>';


        }

		$var["data"]=$isi;
		$var["token"]=$this->m_reff->getToken();
		echo json_encode($var);

    }

	function getDataPpnpn()
	{
		if(!$this->m_reff->san($this->input->post("draw"))){ echo $this->m_reff->page403(); return false;}
		$list = $this->ppnpn->get_data();
		$data = array();
		$no = $this->m_reff->san($this->input->post("start"));
		$no =$no+1;
		foreach ($list as $dataDB) {
		////
		$db	=	$this->db->get_where("data_ppnpn",array("nik"=>$dataDB->nik))->row();

		if($dataDB->konfirm_rs){
			$tombol = "<a class='text-primary' href='".site_url("download")."?f=".$this->m_reff->encrypt("hasil/".$dataDB->file)."'> <i class='fa fa-download' ></i> Download hasil</a>
			";
		}else{
		$tombol='<div aria-label="Basic example" class="btn-groupss" role="group">
		<button onclick="edit(`'.$dataDB->id.'`,`'.$dataDB->nama.'`)" class="btn btn-sm btn-secondary pd-x-25 active" type="button">Edit</button> 
		<button onclick="hapus(`'.$dataDB->id.'`,`'.$dataDB->nik.'`,`'.$dataDB->nama.'`,`'.$dataDB->kode.'`)" class="btn btn-sm btn-danger pd-x-25" type="button">Hapus</button> 
	   </div>';
		}

			
	 if($dataDB->sts_acc==0){
			$acc =  '	<button onclick="edit(`'.$dataDB->id.'`,`1`,`'.$dataDB->nama.'`)" class="btn btn-sm btn-secondary pd-x-25 active" type="button">Belum disetujui</button> ';
	 }else{
		 if($dataDB->hasil){
			$acc = '	<button disabled class="btn btn-sm btn-success pd-x-25 active" type="button">Disetujui</button> ';
		 }else{
			$acc = '	<button onclick="edit(`'.$dataDB->id.'`,`0`,`'.$dataDB->nama.'`)" class="btn btn-sm btn-success pd-x-25 active" type="button">Disetujui</button> ';
		 }
	 }	


	  if($dataDB->hasil=="+"){
		  $hasil = "<span class='badge badge-danger'>positif +</span>";
	  }elseif($dataDB->hasil=="-"){
		  $hasil = "<span class='badge badge-success'>negatif -</span>";
	  }else{
		$hasil = "<span class='badge badge-info'>".$dataDB->hasil."</span>";
	  }
		 
		    
			$row = array();
			// $row[] =  $no++;	
			$row[] = $this->tanggal->hariLengkap3($dataDB->tgl,"/");
			// $row[] = $acc;
			$row[] = $dataDB->nama;
			$row[] = $db->jabatan;
			$row[] = $this->m_reff->goField("tr_jenis_test","nama","where kode='".$dataDB->kode_jenis."'");
			$row[] = $this->m_reff->goField("tm_rs","nama","where kode='".$dataDB->kode_tempat."'");
			$row[] = $hasil;
			$row[] = $tombol;
			 
		  
			$data[] = $row; 
			
			}
			 
		$output = array(
						"draw" => $this->m_reff->san($this->input->post("draw")),
						"recordsTotal" => $c=$this->ppnpn->count(),
						"recordsFiltered" =>$c,
						"data" => $data,
						"token"=>$this->m_reff->getToken()
						);
		//output to json format
		echo json_encode($output);

	}
 
}