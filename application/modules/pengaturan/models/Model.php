<?php
class Model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	function idu()
	{
		return $this->session->userdata("id");
	}
	
	function getVal($val)
	{
		return $this->db->get_where('pengaturan', ['id' => $val])->row()->val;
	}

	function updateVal()
	{
		$f4 = $this->input->post('f4');
		$f4u = ['val'=>$f4];
		$this->db->update("pengaturan", $f4u, ['id'=>4]);

		$f5 = $this->input->post('f5');
		$f5u = ['val'=>$f5];
		$this->db->update("pengaturan", $f5u, ['id'=>5]);

		$f6 = $this->input->post('f6');
		$f6u = ['val'=>$f6];
		$this->db->update("pengaturan", $f6u, ['id'=>6]);

		$f7 = $this->input->post('f7');
		$f7u = ['val'=>$f7];
		$this->db->update("pengaturan", $f7u, ['id'=>7]);

		$f7 = $this->input->post('f7');
		$f7u = ['val'=>$f7];
		$this->db->update("pengaturan", $f7u, ['id'=>7]);

		$f8 = $this->input->post('f8');
		$f8u = ['val'=>$f8];
		$this->db->update("pengaturan", $f8u, ['id'=>8]);

		$f9 = $this->input->post('f9');
		$f9u = ['val'=>$f9];
		$this->db->update("pengaturan", $f9u, ['id'=>9]);

		$f10 = $this->input->post('f10');
		$f10u = ['val'=>$f10];
		$this->db->update("pengaturan", $f10u, ['id'=>10]);

		$f11 = $this->input->post('f11');
		$f11u = ['val'=>$f11];
		$this->db->update("pengaturan", $f11u, ['id'=>11]);

		$f12 = $this->input->post('f12');
		$f12u = ['val'=>$f12];
		$this->db->update("pengaturan", $f12u, ['id'=>12]);

		$f13 = $this->input->post('f13');
		$f13u = ['val'=>$f13];
		$this->db->update("pengaturan", $f13u, ['id'=>13]);

		$f14 = $this->input->post('f14');
		$f14u = ['val'=>$f14];
		$this->db->update("pengaturan", $f14u, ['id'=>14]);

		$f15 = $this->input->post('f15');
		$f15u = ['val'=>$f15];
		$this->db->update("pengaturan", $f15u, ['id'=>15]);

		$f16 = $this->input->post('f16');
		$f16u = ['val'=>$f16];
		$this->db->update("pengaturan", $f16u, ['id'=>16]);

	}

	function insert()
	{
		$form	=	$this->input->post("f");
		if(!$form){	return false;	}
		$this->db->set($form);
		return $this->db->insert("pengaturan");
	}
	function update()
	{
		$id		=	$this->input->post("id");
		$form	=	$this->input->post("f");
		if(!$form){	return false;	}
		$this->db->set($form);
		$this->db->where("id", $id);
		return $this->db->update("pengaturan");
	}

	function hapus()
	{
		$id	=	$this->input->post("id");
		$this->db->where("id", $id);
		return $this->db->delete("pengaturan");
	}
	 
}
