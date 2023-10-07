<?php

class Model extends CI_Model  {
    

 
 	function __construct()
    {
        parent::__construct();
    }
	function idu()
	{
		return $this->session->userdata("id");
	}
	 

/*======= DATATABLE TINGKAT PERKEMBANGAN=========*/
	function getData_tingkaPerkembangan()
	{
		 $this->_getData_tingkaPerkembangan();
		if($this->m_reff->san($this->input->post("length")!=-1)) 
		$this->db->limit($this->m_reff->san($this->input->post("length")),$this->m_reff->san($this->input->post("start")));
	 	return $this->db->get()->result();
		 
	}
	function _getData_tingkaPerkembangan()
	{
		  
		    if (strlen(isset($_POST['search']['value'])?($_POST['search']['value']):null)>1) {
                $searchkey = $_POST['search']['value'];
                $searchkey = $this->m_reff->sanitize($searchkey);
				$query=array(
				"nama"=>$searchkey 
				);
				$this->db->group_start()
                        ->or_like($query)
                ->group_end();
				
			}		 
		$query=$this->db->from("ars_tr_tingkat_perkembangan");
		return $query;
	}
	
	public function count_tingkaPerkembangan()
	{				
			$this->_getData_tingkaPerkembangan();
		return $this->db->get()->num_rows();
	}
    function insert_biro(){
        $form   = $this->input->post("f");
        if(!$form){return false;}
        $cek    = $this->cek_biro();
        if($cek){
            $var["gagal"]=true;
            $var["info"]="Kode sudah pernah diinput.";
            $var["token"]=$this->m_reff->getToken();
            return $var;
        }
        $this->db->set($form);
        $this->db->insert("tr_biro");
        $var["token"]=$this->m_reff->getToken();
        return $var;
    }
    /*======= DATATABLE TINGKAT PERKEMBANGAN=========*/
     
    function update_tingkat_perkembangan(){
        $id = $this->input->post("id");
        $form = $this->input->post("f");
        $this->db->set($form);
        if($id){
            $this->db->set("_uid",$this->session->userdata("nip"));
            $this->db->set("_utime",date('Y-m-d H:i:s'));
            $this->db->where("id",$id);
            $this->db->update("ars_tr_tingkat_perkembangan");
            $this->m_reff->log("update data tingkat perkembangan");
        }else{
            $this->db->set("_cid",$this->session->userdata("nip"));
            $this->db->set("_ctime",date('Y-m-d H:i:s'));
            $this->db->insert("ars_tr_tingkat_perkembangan");
            $this->m_reff->log("menambahkan data tingkat perkembangan");
        }
        return true;
    }

    function hapus_tingkat_perkambangan(){
        $id = $this->input->post("id");
        $this->db->where("id",$id);
        return $this->db->delete("ars_tr_tingkat_perkembangan");
    }



    /*======= UNIT KEARSIPAN =========----------------------------------------------------------------------------*/
	function getData_unitKearsipan()
	{
		 $this->_getData_unitKearsipan();
		if($this->m_reff->san($this->input->post("length")!=-1)) 
		$this->db->limit($this->m_reff->san($this->input->post("length")),$this->m_reff->san($this->input->post("start")));
	 	return $this->db->get()->result();
		 
	}
	function _getData_unitKearsipan()
	{
		  
		    if (strlen(isset($_POST['search']['value'])?($_POST['search']['value']):null)>=1) {
                $searchkey = $_POST['search']['value'];
                $searchkey = $this->m_reff->sanitize($searchkey);
				$query=array(

				"description"=>$searchkey,
                 
				);
				$this->db->group_start()
                        ->or_like($query)
                ->group_end();
				
			}		 
		$query=$this->db->from("ars_tr_uk");
		return $query;
	}	
	public function count_unitKearsipan()
	{				
			$this->_getData_unitKearsipan();
		return $this->db->get()->num_rows();
	}

    function update_unit_kearsipan(){
        $uuid = $this->input->post("uuid");
        $form = $this->input->post("f");
        $type=$this->input->post("f[type]");
        $nip_pegawai = $this->input->post("nip_pegawai[]");
        $posisi = $this->input->post("posisi[]");
        
        $form = $this->input->post("f");
        $this->db->set($form);
        if($uuid){
            $get=$this->db->get_where("ars_tr_uk",array("uuid"=>$uuid))->row();
            $type_b=$get->type??'';
            $cek=$this->db->get_where("ars_tr_uk",array("type!="=>$type_b,"type"=>$type))->num_rows();
            if($cek){
                $var["gagal"]=true;
                $var["info"]="Unit Kearsipan I sudah ada";
                $var["token"]=$this->m_reff->getToken();
                return $var;
            }
            $this->db->set("_uid",$this->session->userdata("nip"));
            $this->db->set("_utime",date('Y-m-d H:i:s'));
            $this->db->where("uuid",$uuid);
            $this->db->update("ars_tr_uk");

            $arr1_data=array();
            $arr2_data=array();
            foreach($nip_pegawai as $key=>$value) {
                if($value){
                    foreach($posisi as $k=>$v) {
                        if($key==$k){
                            $ceks=$this->db->get_where("ars_tr_uk_employee",array("employee_nip="=>$value,"uk_uuid"=>$uuid))->num_rows();
                            if($ceks){
                                $arr1_data[]  = array(
                                    'employee_nip' => $value,
                                    'posisi_type' => $v,
                                    'status' => 1,
                                    'uk_uuid' => $uuid
                                );
                            }
                            if($ceks==0){
                                $arr2_data[]  = array(
                                    'employee_nip' => $value,
                                    'posisi_type' => $v,
                                    'status' => 1,
                                    'uk_uuid' => $uuid
                                );
                            }
                        }
                    }
                }
            }
            if(count($arr1_data)!=0){
                $this->db->update_batch("ars_tr_uk_employee",$arr1_data,'employee_nip');
            }
            if(count($arr2_data)!=0){
                $this->db->insert_batch("ars_tr_uk_employee",$arr2_data);
            }
            $this->m_reff->log("update data unit kearsipan");
        }else{
            if($type==1){
                $cek=$this->db->get_where("ars_tr_uk",array("type"=>1))->num_rows();
                if($type){
                    $var["gagal"]=true;
                    $var["info"]="Unit Kearsipan I sudah ada";
                    $var["token"]=$this->m_reff->getToken();
                    return $var;
                }
            }
            $this->db->set('status',1);
            $this->db->set("_cid",$this->session->userdata("nip"));
            $this->db->set("_ctime",date('Y-m-d H:i:s'));
            $this->db->insert("ars_tr_uk");

            $guk=$this->db->order_by('id','DESC');
            $guk=$this->db->get("ars_tr_uk")->row();
            $uk_uuid=$guk->uuid??null;
            $arr1_data=array();
            foreach($nip_pegawai as $key=>$value) {
                if($value){
                    foreach($posisi as $k=>$v) {
                        if($key==$k){
                            $arr1_data[]  = array(
                                'employee_nip' => $value,
                                'posisi_type' => $v,
                                'status' => 1,
                                'uk_uuid' => $uk_uuid
                            );
                        }
                    }
                }
            }
            if(count($arr1_data)!=0){
                $this->db->insert_batch("ars_tr_uk_employee",$arr1_data);
            }
            $this->m_reff->log("menambahkan data unit kearsipan");
        }
        return true;
    }

    function hapus_unit_kearsipan(){
        $id = $this->input->post("id");
        $this->db->where("uuid",$id);
        $hapus=$this->db->delete("ars_tr_uk");
        if($hapus){
            $this->db->where("uk_uuid",$id);
            return $this->db->delete("ars_tr_uk_employee");
        }
    }


    /*======= UNIT PENGELOLA =========----------------------------------------------------------------------------*/
	function getData_unitPengelola()
	{
		 $this->_getData_unitPengelola();
		if($this->m_reff->san($this->input->post("length")!=-1)) 
		$this->db->limit($this->m_reff->san($this->input->post("length")),$this->m_reff->san($this->input->post("start")));
	 	return $this->db->get()->result();
		 
	}
	function _getData_unitPengelola()
	{
		  
		    if (strlen(isset($_POST['search']['value'])?($_POST['search']['value']):null)>=1) {
                $searchkey = $_POST['search']['value'];
                $searchkey = $this->m_reff->sanitize($searchkey);
				$query=array(

				"description"=>$searchkey,
                 
				);
				$this->db->group_start()
                        ->or_like($query)
                ->group_end();
				
			}		 
		$query=$this->db->from("ars_tr_up");
		return $query;
	}
	
	public function count_unitPengelola()
	{				
			$this->_getData_unitPengelola();
		return $this->db->get()->num_rows();
	}

    function update_unit_pengelola(){
        $uuid = $this->input->post("uuid");
        $form = $this->input->post("f");
        $type=$this->input->post("f[type]");
        $nip_pegawai = $this->input->post("nip_pegawai[]");
        $posisi = $this->input->post("posisi[]");
        
        $form = $this->input->post("f");
        $this->db->set($form);
        if($uuid){
            // $get=$this->db->get_where("ars_tr_up",array("uuid"=>$uuid))->row();
            // $type_b=$get->type??'';
            // $cek=$this->db->get_where("ars_tr_up",array("type!="=>$type_b,"type"=>$type))->num_rows();
            // if($cek){
            //     $var["gagal"]=true;
            //     $var["info"]="Unit Kearsipan I sudah ada";
            //     $var["token"]=$this->m_reff->getToken();
            //     return $var;
            // }
            $this->db->set("_uid",$this->session->userdata("nip"));
            $this->db->set("_utime",date('Y-m-d H:i:s'));
            $this->db->where("uuid",$uuid);
            $this->db->update("ars_tr_up");

            $arr1_data=array();
            $arr2_data=array();
            foreach($nip_pegawai as $key=>$value) {
                if($value){
                    foreach($posisi as $k=>$v) {
                        if($key==$k){
                            $ceks=$this->db->get_where("ars_tr_up_employee",array("employee_nip="=>$value,"up_uuid"=>$uuid))->num_rows();
                            if($ceks){
                                $arr1_data[]  = array(
                                    'employee_nip' => $value,
                                    'posisi_type' => $v,
                                    'status' => 1,
                                    'up_uuid' => $uuid
                                );
                            }else{
                                $arr2_data[]  = array(
                                    'employee_nip' => $value,
                                    'posisi_type' => $v,
                                    'status' => 1,
                                    'up_uuid' => $uuid
                                );
                            }
                        }
                    }
                }
            }
            if(count($arr1_data)!=0){
                $this->db->update_batch("ars_tr_up_employee",$arr1_data,'employee_nip');
            }
            if(count($arr2_data)!=0){
                $this->db->insert_batch("ars_tr_up_employee",$arr2_data);
            }
            $this->m_reff->log("update data unit pengelola");
        }else{
            // if($type==1){
            //     $cek=$this->db->get_where("ars_tr_up",array("type"=>1))->num_rows();
            //     if($type){
            //         $var["gagal"]=true;
            //         $var["info"]="Unit Kearsipan I sudah ada";
            //         $var["token"]=$this->m_reff->getToken();
            //         return $var;
            //     }
            // }
            $this->db->set('status',1);
            $this->db->set("_cid",$this->session->userdata("nip"));
            $this->db->set("_ctime",date('Y-m-d H:i:s'));
            $this->db->insert("ars_tr_up");

            $guk=$this->db->order_by('id','DESC');
            $guk=$this->db->get("ars_tr_up")->row();
            $up_uuid=$guk->uuid??null;
            $arr1_data=array();
            foreach($nip_pegawai as $key=>$value) {
                if($value){
                    foreach($posisi as $k=>$v) {
                        if($key==$k){
                            $arr1_data[]  = array(
                                'employee_nip' => $value,
                                'posisi_type' => $v,
                                'status' => 1,
                                'up_uuid' => $up_uuid
                            );
                        }
                    }
                }
            }
            if(count($arr1_data)!=0){
                $this->db->insert_batch("ars_tr_up_employee",$arr1_data);
            }
            $this->m_reff->log("menambahkan data unit pengelola");
        }
        return true;
    }

    function hapus_unit_pengelola(){
        $id = $this->input->post("id");
        $this->db->where("uuid",$id);
        $hapus=$this->db->delete("ars_tr_up");
        if($hapus){
            $this->db->where("up_uuid",$id);
            return $this->db->delete("ars_tr_up_employee");
        }
    }


    /*======= KLASIFIKASI ARSIP =========----------------------------------------------------------------------------*/
	function getData_KlasifikasiArsip()
	{
		 $this->_getData_KlasifikasiArsip();
		if($this->m_reff->san($this->input->post("length")!=-1)) 
		$this->db->limit($this->m_reff->san($this->input->post("length")),$this->m_reff->san($this->input->post("start")));
	 	return $this->db->get()->result();
		 
	}
	function _getData_KlasifikasiArsip()
	{
		$f1=$this->input->post('f1');
		$f2=$this->input->post('f2');
		$f3=$this->input->post('f3');
		// $f4=$this->input->post('f4');
        if($f1){
            $this->db->where('peraturan_id',$f1);
        }
        if($f2){
            $this->db->where('level',$f2);
        }
        if($f3){
            $this->db->where('kode',$f3);
        }
        // if($f4){
        //     $this->db->where('kode',$f4);
        // }
		    if (strlen(isset($_POST['search']['value'])?($_POST['search']['value']):null)>=1) {
                $searchkey = $_POST['search']['value'];
                $searchkey = $this->m_reff->sanitize($searchkey);
				$query=array(
                    "kode"=>$searchkey,
                    "nama"=>$searchkey,
				    "deskripsi"=>$searchkey,
				);
				$this->db->group_start()
                        ->or_like($query)
                ->group_end();
				
			}		 
		$query=$this->db->from("ars_tr_kka");
		return $query;
	}
	
	public function count_KlasifikasiArsip()
	{				
			$this->_getData_KlasifikasiArsip();
		return $this->db->get()->num_rows();
	}

    function update_klasifikasi_arsip(){
        $uuid = $this->input->post("uuid");
        $form = $this->input->post("f");
        $level=$this->input->post("f[level]");
        $parent_kode=$this->input->post("parent_kode");
        $peraturan_id=$this->input->post("f[peraturan_id]");
        $kode=$this->input->post("f[kode]");

        if(!$parent_kode){
            $parent_kode=null;
        }

        $this->db->set('parent_kode',$parent_kode);
        $this->db->set($form);
        if($uuid){
            $get=$this->db->get_where("ars_tr_kka",array("uuid"=>$uuid))->row();
            $kode_b=$get->kode??'';
            $cek=$this->db->get_where("ars_tr_kka",array("peraturan_id"=>$peraturan_id,"level"=>$level,"kode!="=>$kode_b,"kode"=>$kode))->num_rows();
            if($cek){
                $var["gagal"]=true;
                $var["info"]="kode klasifikasi arsip sudah ada";
                $var["token"]=$this->m_reff->getToken();
                return $var;
            }
            $this->db->set("_uid",$this->session->userdata("nip"));
            $this->db->set("_utime",date('Y-m-d H:i:s'));
            $this->db->where("uuid",$uuid);
            $this->db->update("ars_tr_kka");
            $this->m_reff->log("update data klasifikasi arsip ");
        }else{
            $cek=$this->db->get_where("ars_tr_kka",array("peraturan_id"=>$peraturan_id,"level"=>$level,"kode"=>$kode))->num_rows();
            if($cek){
                $var["gagal"]=true;
                $var["info"]="kode klasifikasi arsip sudah ada";
                $var["token"]=$this->m_reff->getToken();
                return $var;
            }
            $this->db->set('status',1);
            $this->db->set("_cid",$this->session->userdata("nip"));
            $this->db->set("_ctime",date('Y-m-d H:i:s'));
            $this->db->insert("ars_tr_kka");
            $this->m_reff->log("menambahkan data klasifikasi arsip ");
        }
        return true;
    }

    function hapus_klasifikasi_arsip(){
        $id = $this->input->post("id");
        $this->db->where("uuid",$id);
        return $this->db->delete("ars_tr_kka");
        
    }

    /*======= JRA =========----------------------------------------------------------------------------*/
	function getData_jra()
	{
		 $this->_getData_jra();
		if($this->m_reff->san($this->input->post("length")!=-1)) 
		$this->db->limit($this->m_reff->san($this->input->post("length")),$this->m_reff->san($this->input->post("start")));
	 	return $this->db->get()->result();
		 
	}
	function _getData_jra()
	{
        $f1=$this->input->post('f1');
        if($f1){
            $this->db->where('level',$f1);
        }
        if (strlen(isset($_POST['search']['value'])?($_POST['search']['value']):null)>=1) {
            $searchkey = $_POST['search']['value'];
            $searchkey = $this->m_reff->sanitize($searchkey);
            $query=array(
            "kode"=>$searchkey,
            "nama"=>$searchkey,
            "deskripsi"=>$searchkey
            );
            $this->db->group_start()
                    ->or_like($query)
            ->group_end();
            
        }		 
		$query=$this->db->from("ars_tr_jra");
		return $query;
	}
	
	public function count_jra()
	{				
			$this->_getData_jra();
		return $this->db->get()->num_rows();
	}

    function update_jra(){
        $uuid = $this->input->post("uuid");
        $form = $this->input->post("f");
        $type=$this->input->post("f[type]");
        $level=$this->input->post("f[level]");
        $parent_kode=$this->input->post("parent_kode");
        $kode=$this->input->post("f[kode]");

        if(!$parent_kode){
            $parent_kode=null;
        }

        $this->db->set('parent_kode',$parent_kode);
        $this->db->set($form);
        if($uuid){
            $get=$this->db->get_where("ars_tr_jra",array("uuid"=>$uuid))->row();
            $kode_b=$get->kode??'';
            $cek=$this->db->get_where("ars_tr_jra",array("level"=>$level,"kode!="=>$kode_b,"kode"=>$kode))->num_rows();
            if($cek){
                $var["gagal"]=true;
                $var["info"]="kode jarak retensi arsip sudah ada";
                $var["token"]=$this->m_reff->getToken();
                return $var;
            }

            $this->db->set("_uid",$this->session->userdata("nip"));
            $this->db->set("_utime",date('Y-m-d H:i:s'));
            $this->db->where("uuid",$uuid);
            $this->db->update("ars_tr_jra");
            $this->m_reff->log("update data jarak retensi arsip");
        }else{
            $cek=$this->db->get_where("ars_tr_jra",array("level"=>$level,"kode"=>$kode))->num_rows();
            if($cek){
                $var["gagal"]=true;
                $var["info"]="kode jarak retensi arsip sudah ada";
                $var["token"]=$this->m_reff->getToken();
                return $var;
            }
            $this->db->set('status',1);
            $this->db->set("_cid",$this->session->userdata("nip"));
            $this->db->set("_ctime",date('Y-m-d H:i:s'));
            $this->db->insert("ars_tr_jra");
            $this->m_reff->log("menambahkan data jarak retensi arsip");
        }
        return true;
    }

    function hapus_jra(){
        $id = $this->input->post("id");
        $this->db->where("uuid",$id);
        return $this->db->delete("ars_tr_jra");
    }


    /*======= FOLDER =========----------------------------------------------------------------------------*/
	function getData_folder()
	{
		 $this->_getData_folder();
		if($this->m_reff->san($this->input->post("length")!=-1)) 
		$this->db->limit($this->m_reff->san($this->input->post("length")),$this->m_reff->san($this->input->post("start")));
	 	return $this->db->get()->result();
		 
	}
	function _getData_folder()
	{
		  
		    if (strlen(isset($_POST['search']['value'])?($_POST['search']['value']):null)>=1) {
                $searchkey = $_POST['search']['value'];
                $searchkey = $this->m_reff->sanitize($searchkey);
				$query=array(

				"code"=>$searchkey,
				"number"=>$searchkey,
				"deskripsi"=>$searchkey
                 
				);
				$this->db->group_start()
                        ->or_like($query)
                ->group_end();
				
			}		 
		$query=$this->db->from("ars_trx_folder");
		return $query;
	}
	
	public function count_folder()
	{				
			$this->_getData_folder();
		return $this->db->get()->num_rows();
	}

    function update_folder(){
        $uuid = $this->input->post("uuid");
        $form = $this->input->post("f");
        $code=$this->input->post("f[code]");
        $number=$this->input->post("f[number]");
        $tahun=$this->input->post("tahun");
        $jumlah=$this->input->post("jumlah");
        
        if($uuid){
            $this->db->set($form);
            $get=$this->db->get_where("ars_trx_folder",array("uuid"=>$uuid))->row();
            $code_b=$get->code??'';
            $number_b=$get->number??'';
            $cek=$this->db->get_where("ars_trx_folder",array("code!="=>$code_b,"code"=>$code,"number!="=>$number_b,"number"=>$number,"substr(code,2,4)"=>$tahun))->num_rows();
            if($cek){
                $var["gagal"]=true;
                $var["info"]="Kode sudah ada";
                $var["token"]=$this->m_reff->getToken();
                return $var;
            }
            $this->db->set("_uid",$this->session->userdata("nip"));
            $this->db->set("_utime",date('Y-m-d H:i:s'));
            $this->db->where("uuid",$uuid);
            $this->db->update("ars_trx_folder");
            $this->m_reff->log("update data folder");
        }else{
           
            for($i=0;$i<$jumlah;$i++){
                $genereate=$this->generate_kode_folder($tahun);
                $kodefolder='F'.$tahun.$genereate.'';
                //cek dulu
                $this->db->where("code",$kodefolder);
                $this->db->where("number",$genereate);
                $this->db->where("substr(code,2,4)",''.$tahun.'');
                $cek=$this->db->get("ars_trx_folder")->num_rows();
                if($cek)
                {
                    $var["gagal"]=true;
                    $var["info"]="Kode sudah ada";
                    $var["token"]=$this->m_reff->getToken();
                    return $var;
                }
                $this->db->set("code",$kodefolder);
                $this->db->set("number",$genereate);
                $this->db->set("status",1);
                $this->db->set("_uid",$this->session->userdata("nip"));
                $this->db->set("_utime",date('Y-m-d H:i:s'));
                $this->db->insert("ars_trx_folder");
                $this->m_reff->log("menambahkan data folder");

            }
        }
        return true;
    }

    function hapus_folder(){
        $id = $this->input->post("id");
        $this->db->where("uuid",$id);
        return $this->db->delete("ars_trx_folder");
    }

    function generate_kode_folder($tahun){
        $this->db->select("(MAX(SUBSTR(code,6,5))+1) as kodefolder");
        $this->db->where("substr(code,2,4)",''.$tahun.'');
        $t = $this->db->get("ars_trx_folder")->row();
        $idv=isset($t->kodefolder)?($t->kodefolder):''; 
        if(!$idv){  return "00001"; }
        $gen=sprintf("%05s", $idv);
        return  $gen;
    }



    /*======= BOX =========----------------------------------------------------------------------------*/
	function getData_box()
	{
		 $this->_getData_box();
		if($this->m_reff->san($this->input->post("length")!=-1)) 
		$this->db->limit($this->m_reff->san($this->input->post("length")),$this->m_reff->san($this->input->post("start")));
	 	return $this->db->get()->result();
		 
	}
	function _getData_box()
	{
		  
		    if (strlen(isset($_POST['search']['value'])?($_POST['search']['value']):null)>=1) {
                $searchkey = $_POST['search']['value'];
                $searchkey = $this->m_reff->sanitize($searchkey);
				$query=array(

				"code"=>$searchkey,
				"nomor"=>$searchkey,
				"deskripsi"=>$searchkey
                 
				);
				$this->db->group_start()
                        ->or_like($query)
                ->group_end();
				
			}		 
		$query=$this->db->from("ars_trx_box");
		return $query;
	}
	
	public function count_box()
	{				
			$this->_getData_box();
		return $this->db->get()->num_rows();
	}

    function update_box(){
        $uuid = $this->input->post("uuid");
        $form = $this->input->post("f");
        $code=$this->input->post("f[code]");
        $nomor=$this->input->post("f[nomor]");
        $tahun=$this->input->post("tahun");
        $jumlah=$this->input->post("jumlah");
        
        if($uuid){
            $this->db->set($form);
            $get=$this->db->get_where("ars_trx_box",array("uuid"=>$uuid))->row();
            $code_b=$get->code??'';
            $nomor_b=$get->nomor??'';
            $cek=$this->db->get_where("ars_trx_box",array("code!="=>$code_b,"code"=>$code,"nomor!="=>$nomor_b,"nomor"=>$nomor,"substr(code,2,4)"=>$tahun))->num_rows();
            if($cek){
                $var["gagal"]=true;
                $var["info"]="Kode sudah ada";
                $var["token"]=$this->m_reff->getToken();
                return $var;
            }
            $this->db->set("_uid",$this->session->userdata("nip"));
            $this->db->set("_utime",date('Y-m-d H:i:s'));
            $this->db->where("uuid",$uuid);
            $this->db->update("ars_trx_box");
            $this->m_reff->log("update data box");
        }else{
           
            for($i=0;$i<$jumlah;$i++){
                $genereate=$this->generate_kode_box($tahun);
                $kodebox='B'.$tahun.$genereate.'';
                //cek dulu
                $this->db->where("code",$kodebox);
                $this->db->where("nomor",$genereate);
                $this->db->where("substr(code,2,4)",''.$tahun.'');
                $cek=$this->db->get("ars_trx_box")->num_rows();
                if($cek)
                {
                    $var["gagal"]=true;
                    $var["info"]="Kode sudah ada";
                    $var["token"]=$this->m_reff->getToken();
                    return $var;
                }
                $this->db->set("code",$kodebox);
                $this->db->set("nomor",$genereate);
                $this->db->set("status",1);
                $this->db->set("_uid",$this->session->userdata("nip"));
                $this->db->set("_utime",date('Y-m-d H:i:s'));
                $this->db->insert("ars_trx_box");
                $this->m_reff->log("menambahkan data box");

            }
        }
        return true;
    }

    function hapus_box(){
        $id = $this->input->post("id");
        $this->db->where("uuid",$id);
        return $this->db->delete("ars_trx_box");
    }

    function generate_kode_box($tahun){
        $this->db->select("(MAX(SUBSTR(code,6,5))+1) as kodebox");
        $this->db->where("substr(code,2,4)",''.$tahun.'');
        $t = $this->db->get("ars_trx_box")->row();
        $idv=isset($t->kodebox)?($t->kodebox):''; 
        if(!$idv){  return "00001"; }
        $gen=sprintf("%05s", $idv);
        return  $gen;
    }



    



}