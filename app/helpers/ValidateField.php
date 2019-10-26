<?php
require_once MODELS.'DAO/UserDAO.php';
class ValidateField{
    /**
     * Validar campos de usuario pasados por parámetro
     * @return boolean 
     */
    private static  $letrasNumEspacio ="/^[\w\-\s]+$/";
    private static $soloNum         = "/^[0-9]+$/";
    private static $regexobj        = "/^[a-zA-Z0-9üáéíóú][a-zA-Z0-9ü+ _áéíóú-]{3,30}$/";
    private static $alphareg        = "/^[A-Za-z]*\s()[A-Za-z]*$/g";
    private static $emailreg        = "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/";
    private static $validaUrl       = "/ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/";
    private static $imgFormat       = "/\.(jpg|png|gif)$/i";
    private static $sololetras      = "/^[\u00F1A-Za-z _]*[\u00F1A-Za-z][\u00F1A-Za-z _]*$/";
    private static $numDecimal      = "/^(0|[1-9]\d*)(\.\d+)?$/";
    private static $expUsername     = "/^[a-z0-9ü][a-z0-9ü_]{3,15}$/";
    private static $regexobjPrepare = "/^[a-zA-Z0-9üáéíóú][a-zA-Z0-9ü+ _.,:;áéíóú-]{3,900}$/";
    private static $regexp_password = "/^(?=.*\d)(?=.*[\u0021-\u002b\u003c-\u0040])(?=.*[A-Z])(?=.*[a-z])\S{6,16}$/";
    public static function validateUser($params=[], $id_user=0){
        $data =[
            "status"=>"success",
            "errors"=>[],
            "params"=>[]
        ];
        if(isset($params['username'])){
            if(!preg_match(self::$expUsername,$params['username'])){
                array_push($data["errors"],"Nombre de usuario no es válido!");
                $data["status"] = "error";
            }
        }
        if(isset($params['name_user'])){
            if(!preg_match(self::$letrasNumEspacio,$params['name_user'])){
                array_push($data["errors"],"Nombre no es válido!");
                $data["status"] = "error";
            }
        }
        if(isset($params['last_name'])){
            if(!preg_match(self::$letrasNumEspacio,$params['last_name'])){
                array_push($data["errors"],"Apellido no es válido!");
                $data["status"] = "error";
            }
        }
        if(isset($params['phone_number'])){
            if(!preg_match(self::$soloNum,$params['phone_number'])){
                array_push($data["errors"],"Número de teléfono no es válido!");
                $data["status"] = "error";
            }else{
                if(strlen($params['phone_number'])!=10 && strlen($params['phone_number'])!=7){
                    array_push($data["errors"],"Número de teléfono no es válido!");
                    $data["status"] = "error";
                }
            }
        }
        if($id_user!=0){
            // edit
            if(isset($params['password'])){
                $userDAO=new UserDAO();
                $check = $userDAO->checkPassword($id_user , $params['password_current']);
                if(!$check){
                    array_push($data["errors"],"Contraseña actual no es válida!");
                    $data["status"] = "error";
                }
                if($params['password'] != $params['password_confirm']){
                    array_push($data["errors"],"Contraseñas no son iguales!");
                    $data["status"] = "error";
                }
                if(!preg_match(self::$regexp_password,$params['password'])){
                    array_push($data["errors"],"La contraseña debe tener al entre 6 y 16 caracteres, al menos un dígito, al menos una minúscula, al menos una mayúscula y al menos un caracter no alfanumérico.");
                    $data["status"] = "error";
                }
            }
        }else{
            if(isset($params['password'])){
                if(!preg_match(self::$letrasNumEspacio,$params['last_name'])){
                    array_push($data["errors"],"Apellido no es válido!");
                    $data["status"] = "error";
                }
            }
        }
        return $data;
    }
}
