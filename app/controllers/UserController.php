<?php
require_once MODELS.'DAO/TypeUserDAO.php';
require_once MODELS.'DAO/UserDAO.php';
require_once MODELS.'DTO/User/User.php';
require_once MODELS.'DTO/User/TypeUser.php';
class UserController{
    private $userDAO;
    private $typeUserDAO ;
    private $jwt;
    public function __construct() {
        $this->userDAO=new UserDAO();
        $this->typeUserDAO=new TypeUserDAO();
        $this->jwt = new JwtAuth();
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
        echo json_encode($data);      
    }
    
    public function login(){
        $user=isset($_POST['username'])?strtolower($_POST['username']):'';
        $password=isset($_POST['password'])?$_POST['password']:'';

        $results = $this->jwt->signup($user,$password,$this->userDAO);

        // $results = $this->userDAO->checkUser($user,$password);        
        $data=[
            "title"=>"Login"
        ];
        // echo $user ." ".$password;
        if($results["code"]==400){
            $data=[
                "title"=>"Login",
                "message"=>"usuario no encontrado",
                "code"=>404,"status"=>"error"
            ];
        }else{
            $user =  $results["user"];
            $_SESSION['rol']=$user->getId_TypeUser();
            // printObj($user);
            // echo($user->getId_TypeUser());
            // echo($_SESSION['rol']);

            // die();
            $_SESSION['ID_USER']=$user->getId_user();
            $_SESSION['USER']=serialize($user);
            // token
            $this->csrf = new Csrf();
            $data=[
                "title"=>"Login",
                "user"=>$user,
                "code"=>200,
                "status"=>"success",
                "token"=>$results["token"]
            ];
            // View::render("home", $data);
        }
        echo json_encode($data);
        // View::render("login", $data);        
    }
    public function logout(){
        session_destroy();
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
                // printObj($data);
                // View::render("profile", $data);
            }
        }
        var_dump($data);
        echo "En proceso";
    }
    public function myprofile(){
        if(!isset($_SESSION["USER"])){
            Redirect::to(URL);
        }else{
            echo "En proceso";
        }
    }
    public function settings(){
        echo "En proceso";
    }
}
