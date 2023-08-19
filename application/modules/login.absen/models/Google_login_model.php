
<?php
class Google_login_model extends CI_Model
{
 function Is_already_register($id)
 {
  $this->db->where('gid', $id);
  $query = $this->db->get('data_pegawai')->row();
  if(isset($query->id))
  {
   return $query;
  }
  else
  {
   return false;
  }
 }

 function Update_user_data($data, $id)
 {
  $this->db->where('gid', $id);
  $this->db->update('data_pegawai', $data);
 }
 

 function Insert_user_data($data)
 {
  $this->db->insert('data_pegawai', $data);
 }
}
?>
