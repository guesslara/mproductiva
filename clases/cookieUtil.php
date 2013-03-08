<?php
    class CookieUtils{
        
        const DefaultLife = 3600;// 3600 duracion de 1 hora
        
        public function get($name){
            if(isset($_COOKIE[$name])){
                return $_COOKIE[$name];
            }else{
                return false;
            }
        }
        
        public function set($name,$value,$expiry = self::DefaultLife,$path = '/',$domain = false){
            $val=false;
            if(!headers_sent()){
                if($domain === -1){
                    $domain = $_SERVER["HTTP_HOST"];
                }
                if($expiry === false){
                    $expiry = 1893456000;
                }else if(is_numeric($expiry)){
                    $expiry += time();
                }else{
                    $expiry = strtotime($expiry);
                }
                $val=@setcookie($name,$value,$expiry,$path,$domain);
            }
            return $val;
        }
        
        public function delete($name,$path = '/',$domain = false){
            $val=false;
            if(!headers_sent()){
                if($domain === false){
                    $domain = $_SERVER["HTTP_HOST"];
                }
                $val= setcookie($name,'',time()-3600,$path,$domain);
                unset($_COOKIE[$name]);
            }
        }
    }//fin de la clase
?>