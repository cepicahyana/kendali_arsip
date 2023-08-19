<?php
require_once('vendor/autoload.php');
class Ldap{
    function login($username,$password){
          $var["sts"] = true;
          return $var;
        $var["response"] = "username";
       
                        $ad = new Adldap\Adldap();
                        // LDAP SETNEG
                        $connectionSetneg  = 'setneg-connection';
                        $connectionSetpres = 'setpres-connection';
                        $configSetneg = [
                            'hosts'            => ['ads-01.setneg.go.id'],
                            'base_dn'          => 'dc=setneg,dc=go,dc=id',
                            'account_suffix'   => '@setneg.go.id',
                            'use_ssl' 		   => true,
                            'port'             => 636,
                            'custom_options'   => [
                                // See: http://php.net/ldap_set_option
                                LDAP_OPT_X_TLS_REQUIRE_CERT => LDAP_OPT_X_TLS_NEVER,
                                // LDAP_OPT_X_TLS_CERTFILE => 'C:/Users/abich/Downloads/ads-01.setneg.go.id.crt'
                            ]
                        ];

                        $configSetpres = [
                            'hosts'            => ['192.168.32.36'],
                            // 'base_dn'          => 'dc=setneg,dc=go,dc=id',
                            'account_suffix'   => '@istanapresiden.go.id',
                            'use_ssl' 		   => false,
                            'port'             => 389,
                            'custom_options'   => [
                                // See: http://php.net/ldap_set_option
                                LDAP_OPT_X_TLS_REQUIRE_CERT => LDAP_OPT_X_TLS_NEVER,
                            ]
                        ];


                        $ad->addProvider($configSetneg, $connectionSetneg);
                        try {
                            // $provider = $ad->connect($connectionSetneg); 
                            $provider = $ad->connect($connectionSetneg);
                            // $username = 'ldap_kendali'; //tambahan
                            // $password = 'K3nd4l1'; //tambahn
                            
                            if($provider->auth()->attempt($username , $password)) 
                            {
                                $var["sts"] = true;
                                return $var;
                            } 
                            else 
                            {
                                $var["sts"] = false;
                                $var["response"] = "Username / Password salah!";
                            }
                        } catch (Adldap\Auth\BindException $e) {
                            $var["sts"] = false;
                            $var["response"] =  $e->getMessage();
                        }
                       
                       
                       
                        $ad->addProvider($configSetpres, $connectionSetpres);
                        try {
                            $provider = $ad->connect($connectionSetpres); 
                            // $provider = $ad->connect($connectionSetpres);
                            // $username = 'ldap_kendali'; //tambahan
                            // $password = 'K3nd4l1'; //tambahn
                            
                            if($provider->auth()->attempt($username , $password)) 
                            {
                                $var["sts"] = true;
                                return $var;
                            } 
                            else 
                            {
                                $var["sts"] = false;
                                $var["response"] = "Username / Password salah!";
                            }
                        } catch (Adldap\Auth\BindException $e) {
                            $var["sts"] = false;
                            $var["response"] =  $e->getMessage();
                        }

                        return $var;
    }
}