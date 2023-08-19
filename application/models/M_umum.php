<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_umum extends ci_Model
{
	
	public function __construct() {
        parent::__construct();
	 
     	}

    
         function libur($tgl=null){
            if($tgl==null){ $tgl=date("Y-m-d");   }          
            $this->db->where("start<=",$tgl);
            $this->db->where("end>=",$tgl);
            $db = $this->db->get("tm_jadwal_libur")->row();
            return isset($db->nama)?true:false;
         }
         function hitungTelat($datang,$hari=null){
             $libur = $this->libur();
            if($hari==null){
                $hari = date("N");
            }
            if($hari>5 or $libur){
                return	0;
            }
            $jamSetingMasuk =   $this->jam_masuk();
            return 	$this->selisih($datang,$jamSetingMasuk);
             
        }

        function selisih($akhir,$awal) //menit
        { 
                $hourdiff  = round((strtotime(trim($akhir)) - strtotime(trim($awal)))/60, 2)*60;
            //    $hourdiff  = str_replace("-","",$hourdiff);
         return  $this->tanggal->hitungJamAbsen($hourdiff);
        }

        function hitungLembur($datang,$pulang,$hari=null,$id_format=null){
            if($hari==null){
                $hari = date("N");
            }
            $libur = $this->libur();
            if($hari>5 or $libur){
                return	$this->selisih($pulang,$datang);
            }
            $jamLembur		=	$this->jam_mulai_lembur($id_format); //jam mulai lembur
            $kewajiban		=	$this->lama_kerja(); //kewajiban bekerja 8 jam
    
            $jamPulang		=	$this->jam_pulang($id_format); //jam pulang
            if($pulang>$jamPulang){
                $maxPulang	=	$jamPulang;
            }else{
                $maxPulang = 	$pulang;
            }
         
             $lamaKerja		=	$this->selisih($maxPulang,$datang);//."-".$maxPulang."-".$datang; // lama bekerja tanpa lembur maks. jam pulang
    
            $lembur			=	$this->selisih($pulang,$jamLembur);   //lembur mentahan
    
             $lamaKerja		=	$this->tanggal->tambahJam($lamaKerja,$lembur); //kewajiban+lembur bersih
    
            if($lamaKerja>$kewajiban){
                     return		 $this->selisih($lamaKerja,$kewajiban); //  total bekerja - kewajiban ,ada lebih berapa dr kewajiban!
                 
            }else{
                    return 		$lembur;
            }
         
        }

        function hitungUangMakan($jLembur,$id_format=null){
            $minLembur =   $this->jamin_lembur_uang_makan($id_format);
            if($jLembur>=$minLembur){
                return 1;
            }	return 0;
        }

        function jamin_lembur_uang_makan($id_format=null){
                $db = $this->format_absen($id_format);
                return "0".$db->jamin_umak;
        }
        function nominal_uang_makan($id_format=null){
                $db = $this->format_absen($id_format);
                return $db->uang_makan;
        }
      
        function max_uang_lembur_weekend(){
                $db = $this->format_absen();
                return $db->max_lembur_weekend*$db->nominal_lembur;
        }
        function max_uang_lembur_weekday(){
                $db = $this->format_absen();
                return $db->max_lembur_weekday*$db->nominal_lembur;
        }
        function max_uang_lembur_perminggu(){
            $db = $this->format_absen();
            return (($db->max_lembur_weekend*2)*$db->nominal_lembur)+(($db->max_lembur_weekday*5)*$db->nominal_lembur);
        }
      
      
        function nominal_lembur($id_format=null){
                $db = $this->format_absen($id_format);
                return $db->nominal_lembur;
        }

        function hitungNUangMakan($jml,$id_format=null){
            $minLembur =   $this->nominal_uang_makan($id_format);
            return $minLembur*$jml;
        }
        function hitungNLembur($jml,$hari=null,$id_format=null){
            if($hari==null){
                $hari = date("N");
            }
            $libur = $this->libur();
            if($hari>5 or $libur){
                $max		= (int)$this->max_uang_lembur_weekend($id_format);	
            }else{
                $max		= (int)$this->max_uang_lembur_weekday($id_format);	
            }
              $jml		= (int)substr($jml,0,2);
              $lembur	= (int)$this->nominal_lembur($id_format);	
              
              if($jml<10){
                  $jml	=	(int)str_replace("0","",$jml);
              } 
             
              $nilai = $jml*$lembur;
              if($nilai>=$max){
                  return $max;
              }else{
                  return $nilai;
              }
        }
    
        function hitungLemburTerhitung($jml,$hari=null,$id_format=null){
            $libur = $this->libur();
            if($hari==null){
                $hari = date("N");
            }
            if($hari>5 or $libur){ 
                        $jml=(int)substr($jml,0,2);
                        if($jml<10){
                            $jml = str_replace("0","",$jml);
                        } 
                        $max = $this->max_lembur_weekend($id_format);
                        if($jml>=$max){
                            $jml = $max;
                        }
                        return isset($jml)?($jml):0;
            }
    
                        $jml=(int)substr($jml,0,2);
                        if($jml<10){
                            $jml = str_replace("0","",$jml);
                        } 
                        $max = $this->max_lembur_weekday($id_format);
                        if($jml>=$max){
                            $jml = $max;
                        }
                        return isset($jml)?($jml):0;
        }


     function max_lembur_weekday($id_format=null){
            $db = $this->format_absen($id_format);
            return $db->max_lembur_weekday;
    }
        function max_lembur_weekend($id_format=null){
            $db = $this->format_absen($id_format);
            return $db->max_lembur_weekend;
    }

    
  



        function bidang($id){
            $this->db->where("id",$id);
            $db = $this->db->get("tm_bidang")->row();
            return isset($db->bidang)?($db->bidang):"";
        }

        function istana(){
            $id = $this->m_reff->istana();
            $db=$this->db->where("id",$id);
            $db = $this->db->get("tr_istana")->row();
            return isset($db->istana)?($db->istana):"";
        }

        function dataPPNPNin(){
            $level = $this->session->userdata("level");
            if ($level === 'pic_ppnpn' or $level === 'pimpinan_ppnpn') {//jika pic
                $kodebiro = $this->session->userdata("kode_biro");
                if($kodebiro){
                    $this->db->where("kode_biro",$this->m_reff->sanitize($kodebiro));
                }
                $kode_istana = $this->session->userdata("kode_istana");
                if($kode_istana){
                    $this->db->where("kode_istana",$this->session->userdata("kode_istana"));
                }
            }
            
            $istana = $this->m_reff->sanitize($this->input->post("istana"));
            if ($istana) {
                $this->db->where("kode_istana", $istana);
            }
            $biro = $this->m_reff->sanitize($this->input->post("biro"));
            if ($biro) {
                $this->db->where("kode_biro", $biro);
            }

            $this->db->select("nip");
            $this->db->where("jenis_pegawai",2);
            $in = $this->db->get("data_pegawai")->result();
            $data = array();$i=0;
            foreach($in as $in){
                $i++;
                $data[$in->nip]=$in->nip;
            }
            if($i==0){
                return $data[0]=0;
            }
            return $data;
        }

        function jam_masuk(){
            $db     = $this->format_absen();
            return $db->jam_masuk;
        }
        function jam_pulang($id_format){
            $db     = $this->format_absen($id_format);
            return $db->jam_pulang;
        }
        function jam_mulai_lembur($id_format=null){
            $db     = $this->format_absen($id_format);
            return $db->jam_mulai_lembur;
        }

        function kewajiban_bekerja($id_format=null){
            $db     = $this->format_absen($id_format);
            return $db->jam_mulai_lembur;
        }

        function format_absen($id_format=null){
            if($id_format==null){
                $id_format = $this->id_format();
            } 
                        $this->db->where("id",$id_format);
            return   $this->db->get("tm_format_absen")->row();
        }

        function lama_kerja(){
                   $db = $this->format_absen();
            return $this->selisih($db->jam_pulang,$db->jam_masuk);
        }

        function id_format($param=null){//bln-tgl
            // $istana = $this->session->userdata("kode_istana");
            if($param){
                $param  = explode("-",$param);
                $bln    = $param[0];//date("m");
                $bln    = $this->konverter($bln);
    
                $tgl    = $param[1];//date("d");
                $tgl    = $this->konverter($tgl);
            }else{
                $bln    = date("m");
                $bln    = $this->konverter($bln);
    
                $tgl    = date("d");
                $tgl    = $this->konverter($tgl);
            }
            
            
        
            $bln    = $bln."-".$tgl;
                        // $this->db->where("kode_istana",$istana);
                        $this->db->where("bln_mulai>=",$bln);
                        $this->db->order_by("bln_mulai","DESC");
                        $this->db->limit("1");
            $get    =   $this->db->get("v_pengaturan_absen")->row();
            return isset($get->id_format)?($get->id_format):1;
        }


        function konverter($bln){

            if($bln=="01"){
                $bln = 1;
            }elseif($bln=="02"){
                $bln = 2;
            }elseif($bln=="03"){
                $bln = 3;
            }elseif($bln=="04"){
                $bln = 4;
            }elseif($bln=="05"){
                $bln = 5;
            }elseif($bln=="06"){
                $bln = 6;
            }elseif($bln=="07"){
                $bln = 7;
            }elseif($bln=="08"){
                $bln = 8;
            }elseif($bln=="09"){
                $bln = 9;
            }
            
            return $bln;

        }



        // function numberOfWeek($tgl){
        //     $ddate = $tgl;
        //     $date = new DateTime($ddate);
        //   return  $week = $date->format("W");
        // }
        // function week($tgl,$tglmax){
            		 
        //            $week = $this->numberOfWeek($tgl);
                    
        //                 $dto = new DateTime();
        //                 $dto->setISODate(date("Y"), $week);
        //                 $ret['tgl1'] = $dto->format('Y-m-d');
        //                 $dto->modify('+6 days');
        //                 $ret['tgl2'] = $dto->format('Y-m-d');
        //                 $tgl2=$ret['tgl2'];

        //                 if($tgl2<=$tglmax){
        //                   return  $this->week($tgl2,$tglmax);
        //                 }else{
        //                     return $ret;
        //                 }
                  
        // }


       
}


?>