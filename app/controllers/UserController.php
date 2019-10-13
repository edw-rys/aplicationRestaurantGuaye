<?php
require_once MODELS.'DAO/TypeUserDAO.php';
require_once MODELS.'DAO/UserDAO.php';
require_once MODELS.'DTO/User/User.php';
require_once MODELS.'DTO/User/TypeUser.php';
class UserController{
    private $userDAO;
    private $typeUserDAO ;
    public function __construct() {
        $this->userDAO=new UserDAO();
        $this->typeUserDAO=new TypeUserDAO();
    }
    public function signup(){
            //en caso de la ausencia de algún campo, retornar =>faltan campos
        if(!(isset($_REQUEST['name']) && isset($_REQUEST['lastname']) && 
            isset($_REQUEST['username']) && isset($_REQUEST['password']) && 
            isset($_REQUEST['numtelf']))){
                $data=[
                    "title"=>"Registro",
                    "message"=>"Compelte todos los campos, por favor!",
                    "code"=>400,
                    "status"=>"error"
                ];
                // View::render("home", $data);  
                die();              
        }
        $verify=$this->userDAO->verifyUserNotRepeat(strtolower($_REQUEST['username']));
        if(!empty( $verify)){
            $data=[
                "title"=>"Registro",
                "message"=>"usuario ya existente",
                "code"=>400,
                "status"=>"error"
            ];
            // View::render("home", $data);
        }else{
            $user=new User();
            $user->setUsername(strtolower($_REQUEST['username']));
            $user->setName_user($_REQUEST['name']);
            $user->setLast_name($_REQUEST['lastname']);
            $user->setPhone_number($_REQUEST['numtelf']);
            $user->setPassword($_REQUEST['password']);
            $num=$this->userDAO->create($user);
            echo $num;
            if($num>0){
                $data=[
                    "title"=>"Login",
                    "message"=>"Usuario Registrado",
                    "code"=>200,
                    "status"=>"success"
                ];
            // View::render("home", $data);
            }else{
                $data=[
                    "title"=>"Registro",
                    "message"=>"Error al guardar",
                    "code"=>400,
                    "status"=>"error"
                ];
               // View::render("signup", $data);
            }
            // View::render("home", $data);
        }
        var_dump($data);
    }
    
    public function login(){
        $user=isset($_POST['user'])?strtolower($_POST['user']):'';
        $password=isset($_POST['password'])?$_POST['password']:'';
        $results = $this->userDAO->checkUser($user,$password);
        $data=[
            "title"=>"Login"
        ];
        // echo $user ." ".$password;
        if(empty($results)){
            $data=[
                "title"=>"Login",
                "message"=>"usuario no encontrado","code"=>404,"status"=>"error"
            ];
        }else{
            $types=$this->typeUserDAO->queryOne($results['id_TypeUser']);
            $user = new User();
            $user->setId_user($results['id_user']);
            $user->setUsername($results['username']);
            $user->setName_user($results['name_user']);
            $user->setLast_name($results['last_name']);
            $user->setPhone_number($results['phone_number']);
            $user->setType_user($types);
            $_SESSION['rol']=$user->getType_user()->getId_TypeUser();
            $_SESSION['USER']=serialize($user);
            $_SESSION['ID_USER']=$user->getId_user();
            $data=[
                "title"=>"Login",
                "user"=>$user,"code"=>200,"status"=>"success"
            ];
            // View::render("home", $data);
        }
        echo json_encode($data);
        // View::render("login", $data);        
    }
    public function logout(){
        if(isset($_SESSION['USER'])){
            unset($_SESSION['USER']);
            if(isset($_SESSION['rol']))
                unset($_SESSION['rol']);
            if(isset($_SESSION['ID_USER']))
                unset($_SESSION['ID_USER']);
        }
        Redirect::to(URL);
    }
    // Views
    public function profile($username = null){
        if(is_null($username)){
            Redirect::to(URL);
        }else{
            $user = $this->userDAO->getUser($username);
            if(empty($user)){
                $data =[
                    "code"=>404,
                    "status"=>"error",
                    "message"=>"Usuario no encontrado"
                ];
            }else{
                $data =[
                    "code"=>200,
                    "status"=>"success",
                    "user"=>$user,
                    "profile"=>"VISIT"
                ];
                if(isset($_SESSION['ID_USER']) && $user->getId_user()){
                    $data["profile"]="MY_PROFILE";
                }
                View::render("profile", $data);
            }
        }
    }
    public function myprofile($username = null){
        if(is_null($username)){
            Redirect::to(URL);
        }else{

        }
    }
}
