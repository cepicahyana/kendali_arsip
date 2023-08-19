<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('vendor/autoload.php');

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class M_reff extends ci_Model
{
	
	public function __construct() {
		parent::__construct();
		$this->load->library('email');
	}
	function fotoProfile($id=null){
		if($id==null){
			$id = $this->idu();
		}
		$this->db->where("id",$id);

		$dp = $this->db->get("data_pegawai")->row();
		if(!isset($dp->id)){ return false;}

		if($dp->jenis_pegawai==1){ //jika pegawai ASN foto dr link
			$img = $dp->foto;
			if($img){
			  $img = $img;
			}else{
			  $img =   base_url().'assets/'.$dp->jk.'.png';
			}
		
		  }else{
				$img = $dp->foto; //foto dr upload path
			  if($img){
				   $img = $this->m_reff->pengaturan(1).$img;
				   $img =   $this->konversi->img($img);
			  }else{
				  $img =  base_url().'assets/'.$dp->jk.'.png';
			  }
		  }
		  return $img;
	}



	function dp_ppnpn($id=null){
		 return $this->fotoProfile($id);
		// if($id==null){
		// 	$id = $this->idu();
		// }
		// $this->db->where("id",$id);
		// $data	=	$this->db->get("data_pegawai")->row();
		// $f = isset($data->foto)?($data->foto):"";
		// if($f){  
			
		// 	$path=realpath($data->foto);
			
		// 	if(!file_exists($path)){
		// 		if(strtolower($data->jk)=="l"){
		// 			return base_url()."assets/l.png";
		// 		}else{
		// 			return base_url()."assets/p.png";
		// 		}
				
		// 	}
		
		// return $this->konversi->img($path);
		// } 
		
		// if(strtolower($data->jk)=="l"){
		// 	return base_url()."assets/l.png";
		// }else{
		// 	return base_url()."assets/p.png";
		// }
	}


	function counterNotif($kode_istana,$kode_biro,$notif_field="notif_hasil"){
		if($kode_istana){
			$this->db->where("kode_istana",$kode_istana);
		}
		if($kode_biro){
			$this->db->where("kode_biro",$kode_biro);
		}
							   $this->db->order_by("notif_pengajuan","DESC");
							   $this->db->order_by("notif_hasil","DESC");
							   $this->db->where("level",6);
		$notif				 = $this->db->get("admin")->row();
		// $notif_pengajuan	 = isset($notif->notif_pengajuan)?($notif->notif_pengajuan):0;
		$notif_hasil		 = isset($notif->$notif_field)?($notif->$notif_field):0;


		if($kode_istana){
			$this->db->where("kode_istana",$kode_istana);
		}
		if($kode_biro){
			$this->db->where("kode_biro",$kode_biro);
		}
		// $this->db->set("notif_pengajuan",($notif_pengajuan+1));
		$this->db->set($notif_field,($notif_hasil+1));
		$this->db->where("level",6);
		return $this->db->update("admin");

	}
	function hubungan($id,$jk){
		$nama="nama_".$jk;
		$this->db->where("id",$id);
		$db=$this->db->get("tr_hubungan")->row();
		return isset($db->$nama)?($db->$nama):"";
	}
	function generateKodeFamily(){
		$kode = $this->m_reff->acak(11);
		$cek = $this->db->get_where("data_test_keluarga",array("kode"=>$kode))->num_rows();
		if($cek){
			return $this->generateKodeFamily();
		}else{
			return $kode;
		}
	}
	function generateKode(){
		$kode = $this->m_reff->acak(10);
		$cek = $this->db->get_where("data_test",array("kode"=>$kode))->num_rows();
		if($cek){
			return $this->generateKode();
		}else{
			return $kode;
		}
	}
	function pic_jk(){
		$cek = $this->db->get_where("admin",array("id_admin"=>$this->session->userdata("id")))->row();
		return isset($cek->jk)?($cek->jk):"l";
	}
	function dokter_jk(){
		$cek = $this->db->get_where("data_dokter",array("id"=>$this->session->userdata("id")))->row();
		return isset($cek->jk)?($cek->jk):"l";
	}
	function sanitize($string){
		// $a = is_array($string);
		// if($a){
		// 	return $string;
		// }
		$string = strip_tags($string);
		return $this->security->xss_clean($string);
	}
	function san($string){
		return $this->sanitize($string);
	}
	function sanex($string){
		$string=str_replace("'","",$string);
		$string=str_replace("`","",$string);
		return $this->sanitize($string);
	}
	function getToken(){
		return $this->security->get_csrf_hash();
	}
	function jenis_pegawai($i){
		if($i==1){
			return "ASN";
		}elseif($i==2){
			return "PPNPN";
		
		}elseif($i==3){
			return "Petugas taman";
		
		}elseif($i==4){
			return "Cleaning service";
		}else{
			return "-";
		}
	}
	function domisili(){
		$this->db->distinct("id_prov");
		// $this->db->group_by("id_prov");
		$this->db->where("id_prov IS NOT NULL");
		$this->db->where("id_prov!=''");
		return $this->db->get("data_pegawai")->result();
	}
	function list_golongan(){
		return $this->db->get("tr_golongan")->result();
	}
	function pangkat($golongan){
		$db = $this->db->get_where("tr_golongan",array("golongan"=>$golongan))->row();
		return isset($db->pangkat)?($db->pangkat):null;
	}
	function panggol($id){
		$db = $this->db->get_where("tr_golongan",array("golongan"=>$id))->row();
		$png =  isset($db->pangkat)?($db->pangkat):null;
		$gol =  isset($db->golongan)?($db->golongan):null;
		return $gol."-".$png;
	}
	function area(){
		if($this->session->kode_biro){
			echo $this->m_reff->goField("tr_biro","biro","where kode='".$this->session->kode_biro."' ");
		}
	}
	function notifikasi($id,$field){
		$this->db->where("id",$id);
		$db = $this->db->get("notifikasi")->row();
		return isset($db->$field)?($db->$field):"";

	}
	function jpegawai(){
		$id = $this->session->userdata("id");
		$this->db->where("id",$id);
		$db = $this->db->get("data_pegawai")->row();
		return $db->jenis_pegawai;
	}
	function peg_id_istana(){
		$id = $this->session->userdata("id");
		$db=$this->db->where("id",$id);
		$db = $this->db->get("data_pegawai")->row();
		return $db->kode_istana;
	}
	function peg_kode_biro(){
		$id = $this->session->userdata("id");
		$this->db->where("id",$id);
		$db = $this->db->get("data_pegawai")->row();
		return $db->kode_biro;
	}
	function input($field){
		$string = $this->input->post($field);
		return $this->sanitize($string);
	}
	function tokenName(){
		return $this->security->get_csrf_token_name();
	}
	function getDataBiroPositif(){ // nama biro, jml positif
		$q='SELECT biro,count(*) as jml from data_pegawai where hasil_test="+" group by biro order by jml desc';
		return $this->db->query($q)->result();
	}
	function data_pegawai($input){
		$this->db->where("nip",$input);
		$this->db->or_where("nik",$input);
		return $this->db->get("data_pegawai")->row();
	}
	function deputi($kode){
		$this->db->where("kode",$kode);
		$kode = $this->db->get("tr_biro")->row();
		$kode = isset($kode->kode_deputi)?($kode->kode_deputi):"";

		$this->db->where("kode",$kode);
		$kode = $this->db->get("data_deputi")->row();
		return isset($kode->deputi)?($kode->deputi):"";
	}
	function getDataPegawai($id){
		$this->db->where("id",$id);
		return $this->db->get("data_pegawai")->row();
	}
 
	function nip(){
		$id = $this->session->userdata("id");
		$this->db->where("id",$id);
		$d=$this->db->get("data_pegawai")->row();
		return isset($d->nip)?($d->nip):"";
	}
	function nik(){
		$id = $this->session->userdata("id");
		$this->db->where("id",$id);
		$d=$this->db->get("data_pegawai")->row();
		return isset($d->nik)?($d->nik):"";
	}
	function ai($table){
	    $db=$this->db->query("SHOW TABLE STATUS LIKE '".$table."'")->row();
	    return isset($db->Auto_increment)?($db->Auto_increment):0;
	}
	function peg_jk($id=null){
		if(!$id){
			$id = $this->session->userdata("id");
		}
		
		$this->db->where("id",$id);
		$d=$this->db->get("data_pegawai")->row();
		return isset($d->jk)?($d->jk):"l";
	}
	function akun_opr(){ // kode biro pic
		$id = $this->session->userdata("id");
		$this->db->where("id",$id);
		$d=$this->db->get("data_pegawai")->row();
		return isset($d->akun_opr)?($d->akun_opr):"";
	}
	function mobile()
	{
		$useragent=$_SERVER['HTTP_USER_AGENT'];
		if(preg_match('/(android|bb\d+|meego).+mobile|Android|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
			{ return true;}else{ return false; }

	}
	function provinsi($id){
		$this->db->where("id_prov",$id);
		$this->db->select("nama");
		$data = $this->db->get("provinsi")->row();
		return isset($data->nama)?($data->nama):null;
	}
	function kabupaten($id){
		$this->db->where("id_kab",$id);
		$this->db->select("nama");
		$data = $this->db->get("kabupaten")->row();
		return isset($data->nama)?($data->nama):null;
	}
	function kecamatan($id){
		$this->db->where("id_kec",$id);
		$this->db->select("nama");
		$data = $this->db->get("kecamatan")->row();
		return isset($data->nama)?($data->nama):null;
	}
	function kelurahan($id){
		$this->db->where("id_kel",$id);
		$this->db->select("nama");
		$data = $this->db->get("kelurahan")->row();
		return isset($data->nama)?($data->nama):null;
	}
	function dbPegawai()
	{
		$nip	=	$this->session->userdata("nip");
		$this->db->where("niplama",$nip);
		return 		$this->db->get("pegawai")->row();
	}
	function totalMateri($kode)
	{
		$this->db->where("kode_acara",$kode);
		return $this->db->get("data_file")->num_rows();
	}
	function totalTamuBefore($kode,$hadir=null)
	{
		if($hadir){
			$this->db->where("sts_ikutserta",$hadir);
		}
		$this->db->where("hapus",0);
		$this->db->where("kode_acara",$kode);
		return $this->db->get("data_peserta")->num_rows();
	}
	function totalTamuBeforeRakor($kode,$hadir=null)
	{
		if($hadir){
	   //      $this->db->where("sts_ikutserta",$hadir);
		}else{
		// $this->db->where_in("sts_ikutserta",array(2));
		}
	    //  $this->db->where("hapus",0);
		$this->db->where("qr=qr_utama");
		$this->db->where("kode_acara",$kode);
		$this->db->select("SUM(jml_und) as jml");
		return $this->db->get("data_peserta")->row()->jml;
	}
	function totalTamu($kode,$hadir=null)
	{
		if($hadir){
			$this->db->where("sts_kehadiran",$hadir);
		}
		$this->db->where_in("sts_ikutserta",array(2));
		$this->db->where("kode_acara",$kode);
		$this->db->where("hapus",0);
		$this->db->where("j_kehadiran",1);
		return $this->db->get("data_peserta")->num_rows();
	}function totalTamuVicon($kode,$hadir=null)
	{
		if($hadir){
			$this->db->where("sts_kehadiran",$hadir);
		}
		$this->db->where_in("sts_ikutserta",array(2));
		$this->db->where("kode_acara",$kode);
		$this->db->where("hapus",0);
		$this->db->where("nama is not null");
		$this->db->where("j_kehadiran",2);
		return $this->db->get("data_peserta")->num_rows();
	}
	function totalTamuAkanHadir($kode,$hadir=null)
	{
		if($hadir){
			$this->db->where("sts_kehadiran",$hadir);
		}
		$this->db->where_in("sts_ikutserta",array(2));
		$this->db->where("kode_acara",$kode);
		$this->db->where("j_kehadiran",1);
		$this->db->where("hapus",0);
		$this->db->where("nama is not null");
		return $this->db->get("data_peserta")->num_rows();
	}
	function totalTamuAkanHadirVicon($kode,$hadir=null)
	{
		if($hadir){
			$this->db->where("sts_kehadiran",$hadir);
		}
		$this->db->where("nama is not null");
	  // $this->db->where_in("sts_ikutserta",array(2));
		$this->db->where("j_kehadiran",2);
		$this->db->where("kode_acara",$kode);
		$this->db->where("hapus",0);
		return $this->db->get("data_peserta")->num_rows();
	}
	
	function idu()
	{
		return $this->session->userdata("id");
	}
	
	function poto_akun()
	{
		$jk=$this->goField("data_pegawai","jk","where id='".$this->idu()."'");
		if($jk=="l")
		{
			return base_url()."plug/img/l.png";
		}else{
			return base_url()."plug/img/p.png";
		}
	}

	function dataProfilePegawai()
	{
		return $this->db->get_where("data_pegawai",array("id"=>$this->idu()))->row();
	}

	function dataProfileAdmin()
	{
		return $this->db->get_where("admin",array("id_admin"=>$this->idu()))->row();
	}
	function keperluan($id=null){
		$this->db->where("kode",$id);
		$dt = $this->db->get("tr_keperluan_tes")->row();
		return isset($dt->nama)?($dt->nama):null;
	}
	function dataRs($id){
		$this->db->where("kode",$id);
		return $this->db->get("tm_rs")->row();
	}
	function goField3($tbl,$select,$where=null){
		$tbl 	= $this->sanitize($tbl);
		$select = $this->sanitize($select);
		$select=$this->sanitize($select);
		 
		$data=$this->db->query("select $select as field from $tbl $where")->row(); 
		$return=isset($data->field)?($data->field):"";
		return $this->sanitize($return);
	}
	function goField($tbl,$select,$where=null)
	{
		$tbl 	= $this->sanitize($tbl);
		$select = $this->sanitize($select);
		$select=$this->sanitize($select);
		if($where)
		{	
			//$where = addslashes($where);
			$where=$this->sanitize($where);
			$where=str_replace("where","",$where);
			$where=str_replace("'''","'\''",$where);  
			$this->db->where($where);
		}
		$this->db->select($select); 
		$data=$this->db->get($tbl)->row(); 
		$return=isset($data->$select)?($data->$select):"";
		return $this->sanitize($return);
	}
	function goField2($tbl,$select,$where=null)
	{
		$data=$this->db->query("SELECT $select from $tbl $where ")->row();
		return isset($data->val)?($data->val):"";
	}
	function db_predikat(){
		$var["A"]="Baik";
		$var["B"]="Cukup";
		$var["C"]="Kurang";
		// $var["D"]="Kurang";
		// $var["E"]="Buruk";
		return $var;
	}
	function predikat($p){
		$p=strtoupper($p);
		if($p=="A"){
			return "Baik";
		}elseif($p=="B"){
			return "Cukup";
		}elseif($p=="C"){
			return "Kurang";
		}else{
			return "-";
		}

	}
	function goResult($tbl,$select,$where=null)
	{
		return $data=$this->db->query("SELECT $select from $tbl $where ");  
	}
	function jk($id)
	{
		if($id=="l")
		{
			return "Laki-laki";
		}elseif($id=="p")
		{
			return "Perempuan";
		}
	}

	function tgl_pergantian()
	{
		$data=$this->db->query("select * from tr_tahun_ajaran where sts=1")->row();
		return isset($data->tgl_pindah)?($data->tgl_pindah):"";
	}	

	function zipz($nama_file,$dir,$file)
	{
		$error=true;
		/* nama zipfile yang akan dibuat */
		$zipname = $nama_file.".zip";
		/* proses membuat zip file */
		$zip = new ZipArchive;
		$zip->open($zipname, ZipArchive::CREATE);

          //  foreach ($file as $value) {
		$zip->addFile($dir.$file,$file);
        //    }
		$zip->close();
		/* preses pembuatan zip file selesai disini */

		/* download file jika eksis*/
		if(file_exists($zipname)){
			header('Content-Type: application/zip');
			header('Content-disposition: attachment; 
				filename="'.$zipname.'"');
			header('Content-Length: ' . filesize($zipname));
			readfile($zipname);
			unlink($zipname);

		} else{
			$error = "Proses mengkompresi file gagal  ";
            } //end of if file_exist
            
            return $error;
            
        }

        function zip($zip_file,$dir,$data)
        {


            // Get real path for our folder
        	$rootPath = realpath($dir);

            // Initialize archive object
        	$zip = new ZipArchive();
        	$zip->open($zip_file, ZipArchive::CREATE | ZipArchive::OVERWRITE);

            // Create recursive directory iterator
        	/** @var SplFileInfo[] $files */
        	$files = new RecursiveIteratorIterator(
        		new RecursiveDirectoryIterator($rootPath),
        		RecursiveIteratorIterator::LEAVES_ONLY
        	);

        	foreach ($files as $name => $file)
        	{
                // Skip directories (they would be added automatically)
        		if (!$file->isDir())
        		{
                    // Get real and relative path for current file
        			$filePath = $file->getRealPath();
        			$relativePath = substr($filePath, strlen($rootPath) + 1);

                    // Add current file to archive
        			$polder=substr($relativePath,0,6);
        			if (in_array($polder, $data)) {
        				$zip->addFile($filePath, $relativePath);
        			}  



        		}
        	}

            // Zip archive will be created only after closing object
        	$zip->close();


        	header('Content-Description: File Transfer');
        	header('Content-Type: application/octet-stream');
        	header('Content-Disposition: attachment; filename='.basename($zip_file));
        	header('Content-Transfer-Encoding: binary');
        	header('Expires: 0');
        	header('Cache-Control: must-revalidate');
        	header('Pragma: public');
        	header('Content-Length: ' . filesize($zip_file));
        	readfile($zip_file);


        }

        function setToken()
        {
        	$code=substr(str_shuffle("123aYbCdEfGhIj0K0opqrStUvwXyZ4567809"),0,25); $this->session->set_userdata("token",$code); 
        	echo '<input type="hidden" name="token" value="'.$this->session->userdata("token").'">';
        }
        function cekToken()
        {
        	$token_post=$this->input->post("token");
        	$token_server=$this->session->userdata("token");

        	if($token_post==$token_server)
        	{
        		return true;
        	}else{
        		return false;
        	}

        }
	function hapussemua($src){ //nama folder
		if(file_exists($src)){
			$dir = opendir($src);
			while(false !== ( $file = readdir($dir)) ) {
				if (( $file != '.' ) && ( $file != '..' )) {
					$full = $src . '/' . $file;
					if ( is_dir($full) ) {
						hapussemua($full);
					}
					else {
						unlink($full);
					}
				}
			}
			closedir($dir);
			rmdir($src);
		}
	}
	function hapus_file($nama_file) //full path
	{
		$filename = $nama_file;

		if (file_exists($filename)) {
			unlink($nama_file);
		}  
		return true;
	}
	function hapus_materi($ray)
	{
		foreach($ray as $val)
		{
			$qr=$this->m_reff->goField("data_peserta","qr","where id='".$val."' ");
			$this->db->where("kode_qr",$qr);
			$this->db->delete("data_file"); 
		}
		return true;
		
	}
	







	function allowedfile($tempfile, $destpath) {
		$ALLOWED_FILEEXT = array('pdf', 'doc', 'docx' ,'jpeg', 'jpg','png','xls','xlsx','zip','rar' );
		$ALLOWED_MIME = array(
			'image/jpeg',
			'image/png',
			'application/xlsx', 
			'application/zip', 
			'application/rar', 
			'application/pdf', 
			'application/msword', 
			'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
			'application/vnd.openxmlformats-officedocument.presentationml.presentation', 
			'application/vnd.openxmlformats-officedocument.wordprocessingml.document');

		$file_ext = pathinfo($destpath, PATHINFO_EXTENSION);
		$file_mime = mime_content_type($tempfile);
		$valid_extn = in_array($file_ext, $ALLOWED_FILEEXT);
		$valid_mime = in_array($file_mime, $ALLOWED_MIME);
		$allowed_file = $valid_extn && $valid_mime;
		return $allowed_file;
	}	
	
	
	function upload_file($form,$dok,$nama_file_awal, $type_file_yg_diizinkan,$sizeFile="3000000",$before_file=null)
	{		
		if(!isset($_FILES[$form]['name'])){
			$var["validasi"]=false; 
			return $var;
		}
		if($nip=$this->input->post("f[nip_pegawai]")){
			$filename=$this->m_reff->pengaturan(1)."/dok/".$nip;
			if (!file_exists($filename)) {
				mkdir($this->m_reff->pengaturan(1)."dok/".$nip, 0777); 
			} 
		}

		$var=array();
		$var["size"]=true; 
		$var["file"]=true;
		$var["validasi"]=false; 
		$nama_file_awal=preg_replace('/[^A-Za-z0-9\ ]/', "",$nama_file_awal);
		$nama_file_awal=str_replace(' ', "-",$nama_file_awal);
		$nama=$nama_file_awal."___".date("dmYHis");
		$lokasi_file = $_FILES[$form]['tmp_name'];
		$tipe_file   = $_FILES[$form]['type'];
		$nama_file   = $_FILES[$form]['name'];
		$size  	   = $_FILES[$form]['size'];

		$type_file_yg_diupload = substr(strrchr($nama_file, '.'), 1);
		$nama=$nama.".".$type_file_yg_diupload;
		$target_path = $dok."/".$nama;

		$extention=$type_file_yg_diupload;
		$var["maxsize"]=substr($sizeFile,0,-6); 

		$mime_content_type	= $this->allowedfile($lokasi_file, $nama_file);
		$pos = strpos(strtoupper($type_file_yg_diizinkan), strtoupper($extention));
		if (!$mime_content_type or $pos===false) {
			$var["validasi"]=false;
			$var["info"]="Type file tidak diizinkan.";
			return $var;
		}


		$maxsize =$sizeFile;
		if($size>=$maxsize)
		{
			$var["size"]=false; 
			$var["validasi"]=false;
			$var["info"]="Kapasitas file terlalu besar untuk diupload";
			return $var;
		}else{
			if($before_file!=null)
			{
				$filename=$dok."/".$before_file;
				if (file_exists($filename)) {
					unlink($filename);
				} 
			}				



			$var["validasi"]=true;
			if (!empty($lokasi_file)) {
				move_uploaded_file($lokasi_file,$target_path);
			}
			$var["name"]=$nama;
		}
		return $var;
	}
	
	
	function upload_file_ttd($form,$dok,$nama_file_awal, $type_file_yg_diizinkan,$sizeFile="3000000",$before_file=null)
	{		
		if(!isset($_FILES[$form]['name'])){
			$var["validasi"]=false; 
			return $var;
		}
		if($nip=$this->session->userdata("nip")){
			$filename=$this->m_reff->pengaturan(1)."/dok/".$nip;
			if (!file_exists($filename)) {
				mkdir($this->m_reff->pengaturan(1)."dok/".$nip, 0777); 
			} 
		}

		$var=array();
		$var["size"]=true; 
		$var["file"]=true;
		$var["validasi"]=false; 
	
		$nama=$nama_file_awal;
		$lokasi_file = $_FILES[$form]['tmp_name'];
		$tipe_file   = $_FILES[$form]['type'];
		$nama_file   = $_FILES[$form]['name'];
		$size  	   = $_FILES[$form]['size'];

		$type_file_yg_diupload = substr(strrchr($nama_file, '.'), 1);
		$nama=$nama.".jpg";
		$target_path = $dok."/".$nama;

		$extention=$type_file_yg_diupload;
		$var["maxsize"]=substr($sizeFile,0,-6); 

		$mime_content_type	= $this->allowedfile($lokasi_file, $nama_file);
		$pos = strpos(strtoupper($type_file_yg_diizinkan), strtoupper($extention));
		if (!$mime_content_type or $pos===false) {
			$var["validasi"]=false;
			$var["info"]="Type file tidak diizinkan.";
			return $var;
		}


		$maxsize =$sizeFile;
		if($size>=$maxsize)
		{
			$var["size"]=false; 
			$var["validasi"]=false;
			$var["info"]="Kapasitas file terlalu besar untuk diupload";
			return $var;
		}else{
			if($before_file!=null)
			{
				$filename=$dok."/".$before_file;
				if (file_exists($filename)) {
					unlink($filename);
				} 
			}				



			$var["validasi"]=true;
			if (!empty($lokasi_file)) {
				move_uploaded_file($lokasi_file,$target_path);
			}
			$var["name"]=$nama;
		}
		return $var;
	}




	function pengaturan($id)
	{
		$return=$this->db->get_where("pengaturan",array("id"=>$id))->row();
		return $return->val;
	}
	
	function deleteElement($element,  &$array){
		$index = array_search($element, $array);
		if($index !== false){
			unset($array[$index]);
		}
	}
	
	function  getCode()
	{
		$kode=substr(str_shuffle("123456789ABCDEFGHIJKLMNPQRSTUVWXYZ"),0,5);
		$cek=$this->db->get_where("data_acara",array("kode"=>$kode))->num_rows();
		if($cek)
		{
			return $this->getCode();
		}else{
			return $kode;
		}
	}

	function  getCodeTamu($kode)
	{
		$c=$this->m_reff->goField("data_acara","count_peserta","where kode='".$kode."' ");
		if(!$c){ $c=1;}else{ $c=$c+1;}
		$c=sprintf("%03s",$c);

		$this->db->where("kode",$kode);
		$this->db->set("count_peserta",$c);
		$this->db->update("data_acara");		
		$acak=substr(str_shuffle("ABCDEFGHIJKLMNPQRSTUVWXYZ"),0,2);
		return $kode."-".$acak.$c;
		

	}
	function hapus_qr($qr)
	{
		$pecah=explode("-",$qr);
		$kode_acara=isset($pecah[0])?($pecah[0]):"";
		//$kode_acara=isset($pecah[1])?($pecah[1]):"";
		if(!$kode_acara)
		{
			return false;
		}
		
		echo $filename="files/".$kode_acara."/qr/".$qr.".png";
		if (file_exists($filename)) {
			unlink($filename);  
		}  
	}
	
	function targetPath($kode,$polder)
	{
		$this->db->select("YEAR(tgl) as tahun");	
		$db=$this->db->get_where("data_acara",array("kode"=>$kode))->row();
		$thn=isset($db->tahun)?($db->tahun):"";
		return $this->m_reff->pengaturan(25)."/files/".$thn."/".$kode."/".$polder;
	}
	
	function direktori($tahun=null)
	{	 
		 if(!$tahun){ $tahun = date("Y");}
		$filename=$this->m_reff->pengaturan(1)."/".$tahun;
		if (!file_exists($filename)) {
			mkdir($this->m_reff->pengaturan(1).
 			$tahun, 0777); 
		}  

		$filename=$this->m_reff->pengaturan(1)."/dok";
		if (!file_exists($filename)) {
			mkdir($this->m_reff->pengaturan(1).
 			"dok", 0777); 
		}  
		
		
		$filename=$this->m_reff->pengaturan(1)."/".$tahun."/qr";
		if (!file_exists($filename)) {
			mkdir($this->m_reff->pengaturan(1)."/".$tahun."/info", 0777); 
			mkdir($this->m_reff->pengaturan(1)."/".$tahun."/qr", 0777); 
			mkdir($this->m_reff->pengaturan(1)."/".$tahun."/surat_rekomendasi", 0777); 
			mkdir($this->m_reff->pengaturan(1)."/".$tahun."/hasil", 0777); 
		}  
	}

	function direktori_nip($nip){
		$filename=$this->m_reff->pengaturan(1)."/dok";
		if (!file_exists($filename)) {
			mkdir($this->m_reff->pengaturan(1).
 			"dok", 0777); 
		}  
		
		$filename=$this->m_reff->pengaturan(1)."/dok/".$nip;
		if (!file_exists($filename)) {
			mkdir($this->m_reff->pengaturan(1)."/dok/".$nip, 0777); 
		}  
	}

	function direktori_pustaka(){
		$filename=$this->m_reff->pengaturan(1)."/dok";
		if (!file_exists($filename)) {
			mkdir($this->m_reff->pengaturan(1).
 			"dok", 0777); 
		}  
		
		$filename=$this->m_reff->pengaturan(1)."/dok/pustaka";
		if (!file_exists($filename)) {
			mkdir($this->m_reff->pengaturan(1)."/dok/pustaka", 0777); 
		}  
	}


	function qr($id,$tahun=null)
	{	
		if(!$tahun){ $tahun=date("Y");}
		$this->direktori($tahun);  
		if($id){
			$this->load->library('ciqrcode');
			$params['data']  = $id;
			$params['level'] = 'H';
			$params['size']  = 10;
			$params['savename'] = $this->m_reff->pengaturan(1).$tahun."/qr/".$id.".png";
			return	$this->ciqrcode->generate($params);
		}
	}
	function amankan2($car)
	{	  
		$car	= 	trim($car);
		$car	=	str_replace("<p>","<br>- ",$car);
		$car	=	str_replace("</p>","",$car);
		$br	=	substr($car,0,4);

		if($br=="<br>"){
			$car=trim(substr($car,4));
		}

		$car	= 	trim($car);


		$end4	=	trim(substr(trim($car),-4)); 
		$end5	=	trim(substr(trim($car),-5)); 
		$end6	=	trim(substr(trim($car),-6)); 

		if(strpos($end4,"<br>")!==false){
			$j=strlen($car);
			$car=substr($car,0,($j-4));
		}elseif(strpos($end5,"<br>")!==false){
			$j=strlen($car);
			$car=substr($car,0,($j-5));
		}elseif(strpos($end6,"<br>")!==false){
			$j=strlen($car);
			$car=substr($car,0,($j-6));
		}


		return trim($car);
	} function amankan($car)
	{	  
		$car	= 	trim($car);
		$car	=	str_replace("<p>","<br>",$car);
		$car	=	str_replace("</p>","",$car);
		$br	=	substr($car,0,4);

		if($br=="<br>"){
			$car=trim(substr($car,4));
		}

		$car	= 	trim($car);


		$end4	=	trim(substr(trim($car),-4)); 
		$end5	=	trim(substr(trim($car),-5)); 
		$end6	=	trim(substr(trim($car),-6)); 

		if(strpos($end4,"<br>")!==false){
			$j=strlen($car);
			$car=substr($car,0,($j-4));
		}elseif(strpos($end5,"<br>")!==false){
			$j=strlen($car);
			$car=substr($car,0,($j-5));
		}elseif(strpos($end6,"<br>")!==false){
			$j=strlen($car);
			$car=substr($car,0,($j-6));
		}


		return trim($car);
	}
	function gocara($id, $field)
	{
		$this->db->select($field);
		$this->db->where("id",$id);
		$db=$this->db->get("tr_jenis_undangan")->row();
		return isset($db->$field)?($db->$field):"";
	}
	function clearkoma($data)
	{
		if(substr($data,0,1)==",")
		{
			$data=substr($data,1);
		}
		
		if(substr($data,-1)==",")
		{
			$data=substr($data,0,-1);
		}
		
		
		
		return $data;
	}
	
	
	function clearkomaray($data)
	{
		$data=$this->clearkoma($data);
		return explode(",",$data);
	}
	function configEmail()
	{	 
		$user=$this->pengaturan(20);
		$pass=$this->pengaturan(21);
		$config = Array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_port' => 465,
			'smtp_user' => $user,
			'smtp_pass' => $pass,
			'mailtype'  => 'html',
			'charset'   => 'iso-8859-1',
			'wordwrap'  => TRUE,
		);

		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");
		$this->email->set_header('MIME-Version', '1.0; charset=utf-8');
		$this->email->set_header('Content-type', 'text/html');

	}
	function kirimEmail(){
		return true;
	}
	public function _kirimEmail($data)
	// public function kirimEmail($femail,$fsubject,$fmessage,$path=null,$namaFile=null,$delfile=null)
	{  	
		//$var["sts"]="ok";
		//	return $var;

	$femail		=	isset($data["email"])?($data["email"]):null;
	$fsubject	=	isset($data["subject"])?($data["subject"]):null;
	$fmessage	=	isset($data["msg"])?($data["msg"]):null;
	$path		=	isset($data["path"])?($data["path"]):null;
	$namaFile	=	isset($data["namaFile"])?($data["namaFile"]):null;

	$fsubject	=	str_replace("<br>"," ",$fsubject);
	$fsubject	=	str_replace("<br/>"," ",$fsubject);
	$fsubject	=	strip_tags($fsubject); 
	$fsubject	=	str_replace("&nbsp;"," ",$fsubject);
	$fsubject	=	strtolower($fsubject);
	$jml		=	strlen($fsubject);
	if($jml>34)
	{
		$fsubject=substr($fsubject,0,34)."...";
	} 

	try {
		$connection = new AMQPStreamConnection(AMQP_HOST, AMQP_PORT, AMQP_USER, AMQP_PASSWORD);
		$channel = $connection->channel();

		$channel->queue_declare(AMQP_QUEUE_NAME, false, true, false, false);

		if($path){
			$path=DOWNLOAD_URL . $this->m_reff->encrypt($path);
		}

		$dataArray = array(
			'from' => $this->pengaturan(28),
			'to' => $femail,
			'subject' => $fsubject,
			'file_url' => $path,
			'file_name' => $namaFile,
			'body' => $fmessage,
			'username' => $this->m_reff->pengaturan(26),	        
			'password' => $this->m_reff->pengaturan(27)	        
		);

		$data = json_encode($dataArray, JSON_UNESCAPED_SLASHES);

		$msg = new AMQPMessage(
			$data,
			array('delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT)
		);

		$channel->basic_publish($msg, '', AMQP_QUEUE_NAME);

		$channel->close();
		$connection->close();
	} catch (Exception $e) {
		$var["sts"]="Fail: " . $e->getMessage();
		return $var;		
	}

	$var["sts"]="ok";
	return $var;
}



/*	public function kirimEmail($femail,$fsubject,$fmessage,$path=null,$namaFile=null,$delfile=null)
	{   
	    return $this->sendEmail($femail,$fsubject,$fmessage,$path,$namaFile,$delfile);
	    
	}
		
	function sendEmail($femail,$fsubject,$fmessage,$path,$namaFile,$delfile){
	    $user=$this->pengaturan(20);
		$pass=$this->pengaturan(21);
		$from=$this->pengaturan(19);
		$host=$this->pengaturan(5);
		$port=$this->pengaturan(8);
		$smptScure=$this->pengaturan(9);
        $this->load->library('PHPMailer_load'); //Load Library PHPMailer
        $mail = $this->phpmailer_load->load(); // Mendefinisikan Variabel Mail
       
       
        $mail->setFrom($from, $fsubject); // Sumber email
        $mail->addAddress($femail,$fsubject); // Masukkan alamat email dari variabel $email
        $mail->Subject = $fsubject; // Subjek Email
        $mail->msgHtml($fmessage); // Isi email dengan format HTML
        $mail->isHTML(true);
     	if(file_exists($path)){
          $mail->addAttachment($path,$namaFile);
     	}  
       
       
       
        $mail->CharSet  = "UTF-8";
        $mail->Host = $host; // Host dari server SMTP
       // $mail->isSMTP();  // Mengirim menggunakan protokol SMTP
        $mail->Port = $port;
        $mail->SMTPAuth = true; // Autentikasi SMTP
        $mail->Username = $user;
        $mail->Password = $pass;
        $mail->SMTPSecure = $smptScure;
         $mail->SMTPOptions      = array(
                                        ''.$smptScure.'' => array(
                                            'verify_peer' => false,
                                            'verify_peer_name' => false,
                                            'allow_self_signed' => true
                                        )
                                    );
       
        
        if (!$mail->send()) {
                    $var["sts"]="Mailer Error: " . $mail->ErrorInfo;
                  
                } else {
                   $var["sts"]="ok";
                    if($path && file_exists($path) && $delfile){
                        unlink($path);
                    }
                } // Kirim email dengan cek kondisi
                
       
       
       
                  return $var;
              }*/
			  function kirimWaPpnpn($phone,$msg,$dok=null)
			  {
				
				$curl = curl_init();
				$token = $this->pengaturan(19);
				$linkapi = $this->pengaturan(17);
				$type  = "";
				$file  = strtolower($url);

				if($file)
				{  
					$file = substr($file,-3);
					if ($file=="jpg" or $file=="png" or $file=="peg" or $file=="gif") {
						$type="img";
					}else{
						$type="file";
					}
				} 
		

				if($type=="img"){ //image
					$data = [
						'phone' => $phone,
						'caption' => $msg, // can be null
						'image' => $url,
						'secret' => false, // or true
						'priority' => false, // or true
					];
				
				curl_setopt($curl, CURLOPT_URL, $linkapi."/api/send-image");
				curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
				curl_setopt($curl, CURLOPT_HTTPHEADER,
				array(
					"Authorization: ".$token,
				   //  "Content-Type: application/json"
				)
			);
				}elseif($type=="file"){//file
					$data = [
						'phone' => $phone,
						'document' => $url,
						'secret' => false, // or true
						'priority' => false, // or true
					];
					curl_setopt($curl, CURLOPT_URL, $linkapi."/api/send-document");
					curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
					if($msg){
						$this->kirimWaPpnpn($phone,$msg);
					}
					curl_setopt($curl, CURLOPT_HTTPHEADER,
					array(
						"Authorization: ".$token,
					   //  "Content-Type: application/json"
					)
				);
				}else{
					$payload = [
						"data" => [
							[
								'phone' => $phone,
								'message' => $msg,
								'secret' => false, // or true
								'priority' => false, // or true
							]
						
						]
					];
					curl_setopt($curl, CURLOPT_URL, $linkapi."/api/v2/send-bulk/text");
					curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload) );
					curl_setopt($curl, CURLOPT_HTTPHEADER,
					array(
						"Authorization: ".$token,
						"Content-Type: application/json"
					)
				);
				}

			
				
	
	 curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
	 curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	 
	
	 curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
	 curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	 $result = curl_exec($curl);
	 curl_close($curl);
		return $result;
		 
			 
			  }

			  function kirimWa($phone,$msg,$url=null)
			  {
				
				$curl = curl_init();
				$token = $this->pengaturan(25);
				$linkapi = $this->pengaturan(24);
				$type  = "";
				$file  = strtolower($url);

				if($file)
				{  
					$file = substr($file,-3);
					if ($file=="jpg" or $file=="png" or $file=="peg" or $file=="gif") {
						$type="img";
					}else{
						$type="file";
					}
				} 
		

				if($type=="img"){ //image
					$data = [
						'phone' => $phone,
						'caption' => $msg, // can be null
						'image' => $url,
						'secret' => false, // or true
						'priority' => false, // or true
					];
				
				curl_setopt($curl, CURLOPT_URL, $linkapi."/api/send-image");
				curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
				curl_setopt($curl, CURLOPT_HTTPHEADER,
				array(
					"Authorization: ".$token,
				   //  "Content-Type: application/json"
				)
			);
				}elseif($type=="file"){//file
					$data = [
						'phone' => $phone,
						'document' => $url,
						'secret' => false, // or true
						'priority' => false, // or true
					];
					curl_setopt($curl, CURLOPT_URL, $linkapi."/api/send-document");
					curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
					if($msg){
						$this->kirimWa($phone,$msg);
					}
					curl_setopt($curl, CURLOPT_HTTPHEADER,
					array(
						"Authorization: ".$token,
					   //  "Content-Type: application/json"
					)
				);
				}else{
					$payload = [
						"data" => [
							[
								'phone' => $phone,
								'message' => $msg,
								'secret' => false, // or true
								'priority' => false, // or true
							]
						
						]
					];
					curl_setopt($curl, CURLOPT_URL, $linkapi."/api/v2/send-bulk/text");
					curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload) );
					curl_setopt($curl, CURLOPT_HTTPHEADER,
					array(
						"Authorization: ".$token,
						"Content-Type: application/json"
					)
				);
				}

			
				
	
	 curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
	 curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	 
	
	 curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
	 curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	 $result = curl_exec($curl);
	 curl_close($curl);
		return $result;
		 
			 
			  }
			  
					   function kirimWakonek($phone,$msg,$dok=null) //covid
					   {
						   $key = $this->pengaturan(25); //key
				   
							  if($dok){
								  $link  =  $this->pengaturan(24); //api send text
								  $data =array(
								  'phone' => $phone,
								  'msg' => $msg,
								  'key' =>$key,
								  'url' =>base_url().$dok,
								  );
							  }else{
								  $link  =  $this->pengaturan(23); // api send image
								  $data =array(
								  'phone' => $phone,
								  'msg' => $msg,
								  'key' =>$key,
								  );
							  }
							  $curl = curl_init();
						   
							  // curl_setopt($curl, CURLOPT_HTTPHEADER,
							  //     array(
							  //         "Authorization:".$token,
							  //     )
							  // );
							  curl_setopt($curl, CURLOPT_URL, $link);
							  curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
							  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
							  curl_setopt($curl, CURLOPT_POSTFIELDS, ($data)); 
							  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
							  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
							  $result = curl_exec($curl);
							  curl_close($curl); 
							  return $result;
					  
					   }
		 
		 
		 
		 
			function kirimWaData($phone,$msg,$url=null) //local
			  {
				    $curl = curl_init();
					$token = $this->pengaturan(31);
					$linkapi = $this->pengaturan(29);
					$type  = "";
					$file  = strtolower($url);

					if($file)
					{  
						$file = substr($file,-3);
						if ($file=="jpg" or $file=="png" or $file=="peg" or $file=="gif") {
							$type="img";
						}else{
							$type="file";
						}
					} 
			

					if($type=="img"){ //image
						$data = [
							'phone' => $phone,
							'caption' => $msg, // can be null
							'image' => $url,
							'secret' => false, // or true
							'priority' => false, // or true
						];
					
					curl_setopt($curl, CURLOPT_URL, $linkapi."/api/send-image");
					curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
					curl_setopt($curl, CURLOPT_HTTPHEADER,
					array(
						"Authorization: ".$token,
					   //  "Content-Type: application/json"
					)
				);
					}elseif($type=="file"){//file
						$data = [
							'phone' => $phone,
							'document' => $url,
							'secret' => false, // or true
							'priority' => false, // or true
						];
						curl_setopt($curl, CURLOPT_URL, $linkapi."/api/send-document");
						curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
						if($msg){
							$this->kirimWaData($phone,$msg);
						}
						curl_setopt($curl, CURLOPT_HTTPHEADER,
						array(
							"Authorization: ".$token,
						   //  "Content-Type: application/json"
						)
					);
					}else{
						$payload = [
							"data" => [
								[
									'phone' => $phone,
									'message' => $msg,
									'secret' => false, // or true
									'priority' => false, // or true
								]
							
							]
						];
						curl_setopt($curl, CURLOPT_URL, $linkapi."/api/v2/send-bulk/text");
						curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload) );
						curl_setopt($curl, CURLOPT_HTTPHEADER,
						array(
							"Authorization: ".$token,
						    "Content-Type: application/json"
						)
					);
					}

				
					
		
		 curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
		 curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		 
		
		 curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
		 curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		 $result = curl_exec($curl);
		 curl_close($curl);
			return $result;
			 
			  }
					   
		 
					   function kirimWaData__($phone,$msg,$dok=null) //covid
					   {
						   $key = $this->pengaturan(31); //key
				   
							  if($dok){
								  $link  =  $this->pengaturan(30); //api send text
								  $data =array(
								  'phone' => $phone,
								  'msg' => $msg,
								  'key' =>$key,
								  'url' =>base_url().$dok,
								  );
							  }else{
								  $link  =  $this->pengaturan(29); // api send image
								  $data =array(
								  'phone' => $phone,
								  'msg' => $msg,
								  'key' =>$key,
								  );
							  }
							  $curl = curl_init();
						   
							  // curl_setopt($curl, CURLOPT_HTTPHEADER,
							  //     array(
							  //         "Authorization:".$token,
							  //     )
							  // );
							  curl_setopt($curl, CURLOPT_URL, $link);
							  curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
							  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
							  curl_setopt($curl, CURLOPT_POSTFIELDS, ($data)); 
							  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
							  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
							  $result = curl_exec($curl);
							  curl_close($curl); 
							  return $result;
					  
					   }
		 
              function kirimSms($phone,$msg)
              {
              	return false;  
              	$curl = curl_init();
              	$token =  $this->tm_pengaturan(12);
              	$link  =  $this->tm_pengaturan(11);
              	$data = [
              		'phone' => $phone,
              		'message' => $msg,
              	];

              	curl_setopt($curl, CURLOPT_HTTPHEADER,
              		array(
              			"Authorization: $token",
              		)
              	);
              	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
              	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
              	curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
              	curl_setopt($curl, CURLOPT_URL, $link);
              	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
              	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
              	$result = curl_exec($curl);
              	curl_close($curl); 
              	return $result;

              }
              function convert_wa($isi)
              {
              	$rep=str_replace("<strong>","_*",$isi);
              	$rep=str_replace("</strong>","*_",$rep);
              	$rep=str_replace("<br />","&#92;",$rep);
              	$rep=str_replace("<br/>","&#92;",$rep);
              	$rep=strip_tags($rep);
              	return $rep;
              }

              function isiWAPolos($data,$data_acara,$isi=null)
              {
              	$base_url		=	$this->m_reff->pengaturan(1); 	

              	$nama			=	isset($data->nama)?($data->nama):"";
              	$jabatan		=	isset($data->jabatan)?($data->jabatan):"";
              	$instansi		=	isset($data->instansi)?($data->instansi):"";
              	$hp				=	isset($data->hp)?($data->hp):"";
              	$email			=	isset($data->email)?($data->email):"";
              	$qr_utama		=	isset($data->qr_utama)?($data->qr_utama):"";
              	$link_join		=	isset($data->link_join)?($data->link_join):"Belum tersedia.";


              	$agenda				=	isset($data_acara->agenda)?($data_acara->agenda):"";
              	$tempat				=	isset($data_acara->tempat)?($data_acara->tempat):"";
              	$tgl_pelaksanaan	=	isset($data_acara->tgl)?($data_acara->tgl):"";
              	$tgl_pelaksanaan	=	$this->tanggal->hariLengkap3($tgl_pelaksanaan);
              	$jam_pelaksanaan	=	isset($data_acara->jam)?($data_acara->jam):"";
              	$jam_pelaksanaan	=	isset($data_acara->jam)?($data_acara->jam):"";

              	$isi				=	$this->m_reff->convert_wa($isi); 
              	$isi				=	str_replace("{nama}",$nama,$isi);
              	$isi				=	str_replace("{jabatan}",$jabatan,$isi);
              	$isi				=	str_replace("{agenda}",$agenda,$isi);
              	$isi				=	str_replace("{instansi}",$instansi,$isi);
              	$isi				=	str_replace("{hp}",$hp,$isi);
              	$isi				=	str_replace("{email}",$email,$isi);
              	$isi				=	str_replace("{tempat}",$tempat,$isi);
              	$isi				=	str_replace("{tgl}",$tgl_pelaksanaan,$isi);
              	$isi				=	str_replace("{jam}",$jam_pelaksanaan,$isi);
              	$link 				=   $base_url."/confirm?id=".$qr_utama;
              	$isi				=	str_replace("{link}",$link,$isi); 
              	$isi				=	str_replace("{link_join}",$link_join,$isi); 

              	return $isi;
              }
              function isiWA($data,$kode,$type=null)
              {
              	$base_url		=	$this->m_reff->pengaturan(1); 	
              	$type			=	str_replace("email","wa",$type);
              	$nama			=	isset($data->nama)?($data->nama):"";
              	$jabatan		=	isset($data->jabatan)?($data->jabatan):"";
              	$instansi		=	isset($data->instansi)?($data->instansi):"";
              	$hp				=	isset($data->hp)?($data->hp):"";
              	$email			=	isset($data->email)?($data->email):"";
              	$qr_utama		=	isset($data->qr_utama)?($data->qr_utama):"";
              	$link_join		=	isset($data->link_join)?($data->link_join):"Belum tersedia.";
              	$data_acara			=	$this->db->get_where("data_acara",array("kode"=>$kode))->row();
              	$agenda				=	isset($data_acara->agenda)?($data_acara->agenda):"";
              	$tempat				=	isset($data_acara->tempat)?($data_acara->tempat):"";
              	$tgl_pelaksanaan	=	isset($data_acara->tgl)?($data_acara->tgl):"";
              	$tgl_pelaksanaan	=	$this->tanggal->hariLengkap3($tgl_pelaksanaan);
              	$jam_pelaksanaan	=	isset($data_acara->jam)?($data_acara->jam):"";
              	$jam_pelaksanaan	=	isset($data_acara->jam)?($data_acara->jam):"";

              	$isi				=	$this->m_reff->convert_wa(isset($data_acara->$type)?($data_acara->$type):""); 
              	$isi				=	str_replace("{nama}",$nama,$isi);
              	$isi				=	str_replace("{jabatan}",$jabatan,$isi);
              	$isi				=	str_replace("{agenda}",$agenda,$isi);
              	$isi				=	str_replace("{instansi}",$instansi,$isi);
              	$isi				=	str_replace("{hp}",$hp,$isi);
              	$isi				=	str_replace("{email}",$email,$isi);
              	$isi				=	str_replace("{tempat}",$tempat,$isi);
              	$isi				=	str_replace("{tgl}",$tgl_pelaksanaan,$isi);
              	$isi				=	str_replace("{jam}",$jam_pelaksanaan,$isi);
              	$link 				=   $base_url."/confirm?id=".$qr_utama;
              	$isi				=	str_replace("{link}",$link,$isi); 
              	$isi				=	str_replace("{link_join}",$link_join,$isi); 

              	return $isi;
              }

              function isiEmail($data,$kode,$type=null)
              {
              	$base_url		=	$this->m_reff->pengaturan(1); 
              	$nama			=	isset($data->nama)?($data->nama):"";
              	$jabatan		=	isset($data->jabatan)?($data->jabatan):"";
              	$instansi		=	isset($data->instansi)?($data->instansi):"";
              	$hp				=	isset($data->hp)?($data->hp):"";
              	$email			=	isset($data->email)?($data->email):"";
              	$qr_utama		=	isset($data->qr_utama)?($data->qr_utama):"";
              	$link_join		=	isset($data->link_join)?($data->link_join):"#tidak_tersedia!";

              	$data_acara			=	$this->db->get_where("data_acara",array("kode"=>$kode))->row();
              	$agenda				=	isset($data_acara->agenda)?($data_acara->agenda):"";
              	$tempat				=	isset($data_acara->tempat)?($data_acara->tempat):"";
              	$tgl_pelaksanaan	=	isset($data_acara->tgl)?($data_acara->tgl):"";
              	$tgl_pelaksanaan	=	$this->tanggal->hariLengkap3($tgl_pelaksanaan);
              	$jam_pelaksanaan	=	isset($data_acara->jam)?($data_acara->jam):"";
              	$isi				=	isset($data_acara->$type)?($data_acara->$type):"";
              	$isi				=	str_replace("&nbsp;"," ",$isi);

              	$isi	=	str_replace("(link)","<a href='".$link_join."'>",$isi);
              	$isi	=	str_replace("(unlink)","</a>",$isi);
              	$isi=str_replace("{link_join}","<a href='".$link_join."'>".$link_join."</a>",$isi);
              	$isi=str_replace("{nama}",$nama,$isi);
              	$isi=str_replace("{jabatan}",$jabatan,$isi);
              	$isi=str_replace("{agenda}",$agenda,$isi);
              	$isi=str_replace("{instansi}",$instansi,$isi);
              	$isi=str_replace("{hp}",$hp,$isi);
              	$isi=str_replace("{email}",$email,$isi);
              	$isi=str_replace("{tempat}",$tempat,$isi);
              	$isi=str_replace("{tgl}",$tgl_pelaksanaan,$isi);
              	$isi=str_replace("{jam}",$jam_pelaksanaan,$isi);
              	$link =  "<a href='".$base_url."/confirm?id=".$qr_utama."'>Klik disini</a>";
              	$isi=str_replace("{link}",$link,$isi); 
              	$namatombol="KONFIRMASI KEHADIRAN";
              	$isi=$this->m_konfig->templateEmailConfirm($isi,$qr_utama,$namatombol);
              	return $isi;
              }

              function isiEmailBanner($data,$kode,$isi,$data_acara)
              {



              	$base_url		=	$this->m_reff->pengaturan(1); 
              	$nama			=	isset($data->nama)?($data->nama):"";
              	$jabatan		=	isset($data->jabatan)?($data->jabatan):"";
              	$instansi		=	isset($data->instansi)?($data->instansi):"";
              	$hp				=	isset($data->hp)?($data->hp):"";
              	$email			=	isset($data->email)?($data->email):"";
              	$qr_utama		=	isset($data->qr_utama)?($data->qr_utama):"";
              	$link_join		=	isset($data->link_join)?($data->link_join):"#tidak_tersedia!";

	//$data_acara			=	$this->db->get_where("data_acara",array("kode"=>$kode))->row();
              	$agenda				=	isset($data_acara->agenda)?($data_acara->agenda):"";
              	$tempat				=	isset($data_acara->tempat)?($data_acara->tempat):"";
              	$tgl_pelaksanaan	=	isset($data_acara->tgl)?($data_acara->tgl):"";
              	$tgl_pelaksanaan	=	$this->tanggal->hariLengkap3($tgl_pelaksanaan);
              	$jam_pelaksanaan	=	isset($data_acara->jam)?($data_acara->jam):"";
              	$banner				=	isset($data_acara->banner_email)?($data_acara->banner_email):"";

              	if($banner){
              		$dok 	=	$this->m_reff->targetPath($kode,"file");
              		$src	=	$this->konversi->img(realpath($dok."/".$banner));
              		$banner	=	' <img src="'.$src.'"/> <br> ';
              	}


	 // $isi				=	isset($data_acara->$type)?($data_acara->$type):"";


              	$isi	=	str_replace("(link)","<a href='".$link_join."'>",$isi);
              	$isi	=	str_replace("(unlink)","</a>",$isi);
              	$isi=str_replace("{link_join}","<a href='".$link_join."'>".$link_join."</a>",$isi);
              	$isi=str_replace("{nama}",$nama,$isi);
              	$isi=str_replace("{jabatan}",$jabatan,$isi);
              	$isi=str_replace("{agenda}",$agenda,$isi);
              	$isi=str_replace("{instansi}",$instansi,$isi);
              	$isi=str_replace("{hp}",$hp,$isi);
              	$isi=str_replace("{email}",$email,$isi);
              	$isi=str_replace("{tempat}",$tempat,$isi);
              	$isi=str_replace("{tgl}",$tgl_pelaksanaan,$isi);
              	$isi=str_replace("{jam}",$jam_pelaksanaan,$isi);
              	$link =  "<a href='".$base_url."/confirm?id=".$qr_utama."'>Klik disini</a>";
              	$isi=str_replace("{link}",$link,$isi); 
	  // $namatombol="KONFIRMASI KEHADIRAN";
	  // $isi=$this->m_konfig->templateEmailConfirm($isi,$qr_utama,$namatombol);
              	return $banner.$isi;
              }

              function isiEmailPolos($data,$kode,$isi,$data_acara)
              {

              	$base_url		=	$this->m_reff->pengaturan(1); 
              	$nama			=	isset($data->nama)?($data->nama):"";
              	$jabatan		=	isset($data->jabatan)?($data->jabatan):"";
              	$instansi		=	isset($data->instansi)?($data->instansi):"";
              	$hp				=	isset($data->hp)?($data->hp):"";
              	$email			=	isset($data->email)?($data->email):"";
              	$qr_utama		=	isset($data->qr_utama)?($data->qr_utama):"";
              	$link_join		=	isset($data->link_join)?($data->link_join):"#tidak_tersedia!";


              	$agenda				=	isset($data_acara->agenda)?($data_acara->agenda):"";
              	$tempat				=	isset($data_acara->tempat)?($data_acara->tempat):"";
              	$tgl_pelaksanaan	=	isset($data_acara->tgl)?($data_acara->tgl):"";
              	$tgl_pelaksanaan	=	$this->tanggal->hariLengkap3($tgl_pelaksanaan);
              	$jam_pelaksanaan	=	isset($data_acara->jam)?($data_acara->jam):"";


              	$isi	=	str_replace("(link)","<a href='".$link_join."'>",$isi);
              	$isi	=	str_replace("(unlink)","</a>",$isi);
              	$isi=str_replace("{link_join}","<a href='".$link_join."'>".$link_join."</a>",$isi);
              	$isi=str_replace("{nama}",$nama,$isi);
              	$isi=str_replace("{jabatan}",$jabatan,$isi);
              	$isi=str_replace("{agenda}",$agenda,$isi);
              	$isi=str_replace("{instansi}",$instansi,$isi);
              	$isi=str_replace("{hp}",$hp,$isi);
              	$isi=str_replace("{email}",$email,$isi);
              	$isi=str_replace("{tempat}",$tempat,$isi);
              	$isi=str_replace("{tgl}",$tgl_pelaksanaan,$isi);
              	$isi=str_replace("{jam}",$jam_pelaksanaan,$isi);
              	$link =  "<a href='".$base_url."/confirm?id=".$qr_utama."'>Klik disini</a>";
              	$isi=str_replace("{link}",$link,$isi); 

              	return $isi;
              }

              function isiEmailGlobal($data,$kode,$isi)
              {
              	$base_url		=	$this->m_reff->pengaturan(1); 
              	$nama			=	isset($data->nama)?($data->nama):"";
              	$jabatan		=	isset($data->jabatan)?($data->jabatan):"";
              	$instansi		=	isset($data->instansi)?($data->instansi):"";
              	$hp				=	isset($data->hp)?($data->hp):"";
              	$email			=	isset($data->email)?($data->email):"";
              	$qr_utama		=	isset($data->qr_utama)?($data->qr_utama):"";
              	$link_join		=	isset($data->link_join)?($data->link_join):"javascript:alert('terjadi kesalahan mohon hubungi panitia penyelenggara')";

              	$data_acara			=	$this->db->get_where("data_acara",array("kode"=>$kode))->row();
              	$agenda				=	isset($data_acara->agenda)?($data_acara->agenda):"";
              	$tempat				=	isset($data_acara->tempat)?($data_acara->tempat):"";
              	$tgl_pelaksanaan	=	isset($data_acara->tgl)?($data_acara->tgl):"";
              	$tgl_pelaksanaan	=	$this->tanggal->hariLengkap3($tgl_pelaksanaan);
              	$jam_pelaksanaan	=	isset($data_acara->jam)?($data_acara->jam):"";
	//$isi				=	isset($data_acara->$type)?($data_acara->$type):"";

              	$isi	=	str_replace("(link)","<a href='".$link_join."'>",$isi);
              	$isi	=	str_replace("(unlink)","</a>",$isi);
              	$isi=str_replace("{nama}",$nama,$isi);
              	$isi=str_replace("{jabatan}",$jabatan,$isi);
              	$isi=str_replace("{agenda}",$agenda,$isi);
              	$isi=str_replace("{instansi}",$instansi,$isi);
              	$isi=str_replace("{hp}",$hp,$isi);
              	$isi=str_replace("{email}",$email,$isi);
              	$isi=str_replace("{tempat}",$tempat,$isi);
              	$isi=str_replace("{tgl}",$tgl_pelaksanaan,$isi);
              	$isi=str_replace("{jam}",$jam_pelaksanaan,$isi);
              	$link =  "<a href='".$base_url."/confirm?id=".$qr_utama."'>Klik disini</a>";
              	$isi=str_replace("{link}",$link,$isi);
              	$namatombol="KONFIRMASI KEHADIRAN";
              	$isi=$this->m_konfig->templateEmailConfirm($isi,$qr_utama,$namatombol);
              	return $isi;
              }


              function encrypt($string)
              { 

              	$string = $this->encryption->encrypt($string); 
              	$string=str_replace("+",".",$string);
              	$string=str_replace("=","-",$string);
              	$string=str_replace("/","~",$string); 
              	return $string;
              }


              function decrypt($string)
              {
              	$string=str_replace(".","+",$string);
              	$string=str_replace("-","=",$string);
              	$string=str_replace("~","/",$string); 
              	$ret = $this->encryption->decrypt($string); 
              	return $ret;
              }
              function page403()
              {
              	$this->load->view("403.html");
              }function page404()
              {
              	$this->load->view("404.html");
              }function page405()
              {
              	$this->load->view("405.html");
              }

              function insertKontak($form=null,$poto=null)
              {
              	$id_group	=	$this->m_reff->goField("data_group","id","where LOWER(nama)='lainnya'");
              	if(isset($id_group))
              	{
              		$nama		=	isset($form['nama'])?($form['nama']):"";
              		$jabatan	=	isset($form['jabatan'])?($form['jabatan']):"";
              		$instansi	=	isset($form['instansi'])?($form['instansi']):"";
              		$hp			=	isset($form['hp'])?($form['hp']):"";
              		$email		=	isset($form['email'])?($form['email']):"";


					//	$this->db->where("id_group",$id_group);
              		$query=array( 
              			"hp"=>$hp, 
              			"email"=>$email
              		);
              		$this->db->group_start()
              		->or_like($query)
              		->group_end();
              		$cek		=	$this->db->get("data_kontak")->row();

              		if($poto){
              			$this->db->set("poto",$poto);
              		}

              		$this->db->set("nama",$nama);
              		$this->db->set("jabatan",$jabatan);
              		$this->db->set("instansi",$instansi);
              		$this->db->set("hp",$hp);
              		$this->db->set("email",$email);


              		if($cek)
              		{							
				 //  $this->db->where("id",$cek->id);
              			$this->db->where("hp",$hp);
              			$this->db->where("email",$email);
              			return $this->db->update("data_kontak");
              		}else{
              			$this->db->set("id_group",$id_group);
              			return $this->db->insert("data_kontak");
              		}


              	}	return true;

              }


              function get_id_zoom_akun($meetingId)
              {
              	$this->db->where("kode",$meetingId);
              	$return	 =	$this->db->get("zoom_room")->row();
              	return isset($return->id_akun)?($return->id_akun):"";
              }
              function zoom_event($meetingId)
              {
              	$this->db->where("kode",$meetingId);
              	return	 $this->db->get("zoom_room")->row();
              }
              function zoom_akun($id_akun)
              {
              	$this->db->where("id",$id_akun);
              	return	 $this->db->get("zoom_akun")->row();
              }
              function clearhasray($data)
              {

              	$data=$this->clearhas($data);
              	return explode("|",$data);
              }
              function clearhas($data)
              {
              	if(substr($data,0,1)=="|")
              	{
              		$data=substr($data,1);
              	}

              	if(substr($data,-1)=="|")
              	{
              		$data=substr($data,0,-1);
              	}


              	$data=str_replace("||","|",$data);
              	return $data;
              }

              function acak($jml=2)
              {
              	$karakter = '123456789123456789123456789123456789123456789123456789123456789123456789123456789123456789123456789123456789';
              	$shuffle  = substr(str_shuffle($karakter),0,$jml);
              	return $shuffle;
              }

             
              function download($path)
              {
              	$path=$this->encrypt($path);
              	redirect("welcome/getAttachment/".$path);
              }


             

		function log($aksi,$modul=null){
			if(!$modul){
				$modul = $this->session->userdata("module");
			}
			$this->db->set("level",$this->session->userdata("level"));
			$this->db->set("id_user",$this->idu());
			$this->db->set("tgl",date("Y-m-d H:i:s"));
			$this->db->set("aksi",$aksi);
			$this->db->set("username",$this->session->userdata("username"));
			$this->db->set("module",$modul);
			return $this->db->insert("main_log");
		}


		function nama(){
	 
			$this->db->where("id",$this->idu());
			$data = $this->db->get("data_pegawai")->row();
			return isset($data->nama)?($data->nama):"";
			
		}function nama_depan(){
		 
			$this->db->where("id",$this->idu());
			$data = $this->db->get("data_pegawai")->row();
			$depan = isset($data->nama_depan)?($data->nama_depan):"";
		 
			return $depan;
		}
		function dp($id=null){
		 
			if($id==null){
				$id = $this->idu();
			}
			$data	=	$this->goField("data_pegawai","foto","where id='".$id."'");
			if(isset($data)){  
				
				$path="upload/dp/".$data;
				if(!file_exists($path)){
					return base_url()."plug/img/logo.png";
				}
			
			return base_url().$path;
			} return false;
		}
		
		function keperluan_tes($id=null){
			if(!$id){ return false;}
			$this->db->where("id",$id);
			$db = $this->db->get("tr_keperluan_tes")->row();
			return isset($db->nama)?($db->nama):null;
		}

		function istana($kode,$singkat=false){
			// $id = $this->session->userdata("id");
			// $db=$this->db->where("id",$id);
			// $db = $this->db->get("data_pegawai")->row();
			// return isset($db->kode_istana)?($db->kode_istana):"";
			$this->db->where("kode",$kode);
			$db = $this->db->get("tr_istana")->row();
			$hasil =  isset($db->istana)?($db->istana):"";
			if($singkat){
				$hasil =  str_replace("Istana Kepresidenan","",$hasil);
			}
			return $hasil;
		}
		function tempat_tes($kode){
			$this->db->where("kode",$kode);
			$db = $this->db->get("tm_rs")->row();
			return isset($db->nama)?($db->nama):"";
		}
		function jenis_tes($kode){
			$this->db->where("kode",$kode);
			$db = $this->db->get("tr_jenis_test")->row();
			return isset($db->nama)?($db->nama):"";
		}
	 
		function semester(){
			$this->db->where("tahun",date('Y'));
			$this->db->order_by("semester","desc");
			$this->db->limit(1);
			$db = $this->db->get("penilaian_kinerja_ppnpn")->row();
			return isset($db->semester)?($db->semester):1;

		}
		function m_konfig($id){
			$return=$this->db->get_where("main_konfig",array("id_konfig"=>$id))->row();
			return isset($return->value)?($return->value):"";
		}
	 
		function jenis_absen($id){
			$this->db->where("id",$id);
			$dt = $this->db->get("tr_jenis_absen")->row();
			return isset($dt->nama)?($dt->nama):null;
		}
		function levelName(){
			$this->db->where("nama",$this->session->level);
			$db = $this->db->get("main_level")->row();
			return isset($db->ket)?($db->ket):"";
		}

		function kode_istana_jakarta(){
			$this->db->like("istana","jakarta");
			return $this->db->get("tr_istana")->row()->kode;

		}
		/* tyo */
		function biro($kode = '')
		{
			if ('' !== $kode) {
				$this->db->where('kode', $kode);
			}else{
				return "-";
			}
			$dt =  $this->db->get('tr_biro')->row();
			return isset($dt->biro)?($dt->biro):"";
		}
	 
		function getDataBCGroup($id){
			$this->db->where("id_group",$id);
			return $this->db->get("broadcast_kontak")->result();
		}
		function getDataBCGroupKontak($id){
			$this->db->where("id",$id);
			return $this->db->get("broadcast_kontak")->row();
		}

		function list_pegawai($jenis = '', $istana = '', $biro = '') {
			if ('' !== $jenis) {
				$this->db->where('jenis_pegawai', $jenis); }
			
			if ('' !== $istana) {
				$this->db->where('kode_istana', $istana); }
			
			if ('' !== $biro) {
				$this->db->where('kode_biro', $biro); }
					$this->db->where("sts_keaktifan","aktif");
			return $this->db->get('data_pegawai');
		}
		function list_istana() {
			//$this->db->distinct('istana');
			// $this->db->where('kode_istana IS NOT NULL');
			// $this->db->where('kode_istana!=','');
			// $this->db->group_by('kode_istana');
			return $this->db->get('tr_istana');
		}
		function list_instansi() {
			// $this->db->distinct('instansi');
			$this->db->where('instansi IS NOT NULL');
			$this->db->where('instansi!=',"");
			$this->db->group_by('instansi');
			return $this->db->get('data_pegawai');
		}
		function list_biro() {
			return $this->db->get('tr_biro');
			// //$this->db->distinct('biro');
			// $this->db->where('biro IS NOT NULL');
			// $this->db->where('biro!=',"");
			// $this->db->group_by('biro');
			// return $this->db->get('data_pegawai');
		}
		function list_bagian($jenis_pegawai=1) {
			$this->db->distinct('bagian');
			if($jenis_pegawai){
				$this->db->where("jenis_pegawai",$jenis_pegawai);
			}
			$biro = $this->session->userdata("kode_biro");
			if($biro){
				$this->db->where('kode_biro',$biro);
			}
			$this->db->select("bagian");
			$this->db->where('bagian IS NOT NULL');
			$this->db->where('bagian!=','');
			// $this->db->group_by('bagian');
			return $this->db->get('data_pegawai');
		}
		function list_jabatan($jenis_pegawai=1) {
			$this->db->distinct('bagian');
			if($jenis_pegawai){
				$this->db->where("jenis_pegawai",$jenis_pegawai);
			}
			$biro = $this->session->userdata("kode_biro");
			if($biro){
				$this->db->where('kode_biro',$biro);
			}
			$this->db->select("jabatan");
			$this->db->where('jabatan IS NOT NULL');
			$this->db->where('jabatan!=','');
			// $this->db->group_by('jabatan');
			$this->db->order_by('jabatan','asc');
			return $this->db->get('data_pegawai')->result();
		}
		function list_subbagian($jenis_pegawai=1) {
			$this->db->distinct('bagian');
			if($jenis_pegawai){
				$this->db->where("jenis_pegawai",$jenis_pegawai);
			}
			$biro = $this->session->userdata("kode_biro");
			if($biro){
				$this->db->where('kode_biro',$biro);
			}
			$this->db->select("subbagian");
			$this->db->where('subbagian IS NOT NULL');
			$this->db->where('subbagian!=','');
			// $this->db->group_by('bagian');
			return $this->db->get('data_pegawai');
		}
		function list_bidang($jenis_pegawai=1) {
			$this->db->distinct('bagian');
			if($jenis_pegawai){
				$this->db->where("jenis_pegawai",$jenis_pegawai);
			}
			$biro = $this->session->userdata("kode_biro");
			if($biro){
				$this->db->where('kode_biro',$biro);
			}
			$this->db->where('bidang IS NOT NULL');
			$this->db->where('bidang!=','');
			// $this->db->group_by('bidang');
			return $this->db->get('data_pegawai');
		}
		function list_jp($jenis_pegawai=null) {
			$this->db->distinct('id_jp');
			if($jenis_pegawai){
				$this->db->where("jenis_pegawai",$jenis_pegawai);
			}
			 
			$this->db->where('id_jp IS NOT NULL');
			$this->db->where('id_jp!=','');
			$this->db->where('id_jp!=','0');
			$this->db->select("id_jp");
			// $this->db->group_by('id_jp');
			$this->db->order_by('id_jp',"ASC");
			return $this->db->get('data_pegawai')->result();
		}
		function list_jenjangPendidikan()
		{
			$jp = [
				'Tanpa Jenjang'=>'Tanpa Jenjang',
				'SD' => 'SD',
				'SMP' => 'SMP',
				'SMA' => 'SMA',
				'D1' => 'D1',
				'D2' => 'D2',
				'D3' => 'D3',
				'D4' => 'D4',
				'S1' => 'S1',
				'Profesi' => 'Profesi',
				'S2' => 'S2',
				'S2 Terapan' => 'S2 Terapan',
				'Sp-1' => 'Sp-1',
				'S3' => 'S3',
				'S3 Terapan' => 'S3 Terapan',
				'Sp-2' => 'Sp-2',
				'Informal' => 'Informal',
				'Non formal' => 'Non formal',
				'Lainnya' => 'Lainnya'
			];
			return $jp;
		}
		/* tyo */
	
	}

	?>
