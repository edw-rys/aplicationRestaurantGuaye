<?php

use Firebase\JWT\JWT;
class JwtAuth{
    public $key;
    public function __construct(){
        $this->key = 'KAYBNFGA_TOKEN_TNX_GENERATE_RANDOM';
    }
    public function signup($username, $password,$DAO,$getToken=null) {
        // Buscar si existe el usuario con sus credenciales
        $user = $DAO->checkUser($username,$password);
        // Comprobar si son correctas
        $signup = is_object($user) ?true :false;

        // Generar el token con los datos del usuario
        if($signup){
            $token = array(
                'sub' => $user->getId_user(),
                'user'=> $user,
                'iat'=> time(),
                'exp'=>time()+(7*24*60*60)
            );
            $jwt = JWT::encode($token, $this->key, 'HS256');
            $decode = JWT::decode($jwt,$this->key, ['HS256']);
            if(is_null($getToken))
                $data= [
                    "status"=>"success",
                    "code"=>200,
                    "token"=>$jwt,
                    'user'=> $user,
                ];
            else
                $data= [
                    "status"=>"success",
                    "code"=>200,
                    "identity"=>$decode,
                    'user'=> $user,
                ];
        }else{
            $data = array(
                'code'=>400,
                'status'=>'error',
                'message'=>'Login incorrecto.'
            );
        }
        // Devolver los datos decodificados o el token, en función de un parámetro
        return $data;
    }
    public function checkToken($jwt , $getIdentity = false){
        $auth = false;
        try{
            $jwt = str_replace('"','',$jwt);
            $decoded = JWT::decode($jwt, $this->key, ['HS256']);
            // die();
        }catch(UnexpectedValueException $e){
            $auth= false;
        }catch(DomainException $ex){
            $auth= false;
        }
        if(!empty($decoded) && is_object($decoded) && isset($decoded->sub)){
            $auth = true;
        }else{
            $auth = false;
        }
        if($getIdentity)
            return $decoded;
        return $auth;
    }
}
