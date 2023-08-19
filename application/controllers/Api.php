<?php
header('Access-Control-Allow-Origin: *');

//if($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
//	header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET,POST,OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
 //   exit;
//}
use Firebase\JWT\JWT;


use Restserver\Libraries\REST_Controller;
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Api extends REST_Controller {
    var $key = "@Indonesia45";
    function __construct()
    {
        // Construct the parent class
        //error_reporting(0);
        parent::__construct();
        $this->load->model("Model", "mdl"); 
    }
    public function hasil_post(){

        $kode_tes   = $this->post("kode");
        $hasil      = $this->post("hasil");
        $cek        = $this->mdl->cek_kode($kode_tes);

        
        if(!$kode_tes or !$hasil){
            return     $this->response( [
                'status'    => false,
                'msg'       => "params not complete!"
            ], 201 );
        }elseif(isset($cek["kode"])){
                                $sts        = isset($cek["sts_acc"])?($cek["sts_acc"]):0;
                               if($sts==0){
                                    return    $this->response( [
                                        'status'    => false,
                                        'msg'       => "not approved!"
                                    ], 201 );
                                }else{
                                    $data   = $this->mdl->update_hasil($cek);
                                    if($data["gagal"]==true){

                                                        if($sts==0){
                                                                return    $this->response( [
                                                                    'status'    => false,
                                                                    'msg'       => "not approved!"
                                                                ], 201 );
                                                        }else{
                                                            return    $this->response( [
                                                                'status'    => false,
                                                                'msg'       => $data["info"]
                                                            ], 201 );
                                                        }
                                                        
                                         }else{
                                                            return    $this->response( [
                                                                'status'    => true,
                                                                'msg'       => 'success'
                                                            ], 200 );
                                             }
                                      }
                                    
        }else{
                    return     $this->response( [
                            'status'    => false,
                            'msg'       => "invalid code!"
                        ], 201 );
        }
                            
    }
    // public function hasil_post(){
    //             $key = $this->key;
    //             $headers = apache_request_headers();
    //             $token = isset($headers['Authorization'])?($headers['Authorization']):"";
       
    //             try{
    //                     $decoded = JWT::decode($token, $key, array('HS256'));

                        
    //                         return $this->response( [
    //                                 'status'    => true,
    //                                 'data'   => $decoded
    //                             ], 201 );
                
                       

    //             }catch(Exception $e){
    //                 $this->response( [
    //                     'status'    => false,
    //                     'message'   => " Invalid Credentials."
    //                 ], 401 );
    //             } 
    // }
  
    
    
     
    }