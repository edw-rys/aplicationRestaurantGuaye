<?php
include_once 'config/config.php';
require_once 'model/DAO/TypeUserDAO.php';
require_once 'model/DAO/UserDAO.php';
require_once 'model/DTO/User/User.php';
require_once 'model/DTO/User/TypeUser.php';
class UserController{
    private $userDAO;
    private $typeUserDAO ;
    public function __construct() {
        $this->userDAO=new UserDAO();
        $this->typeUserDAO=new TypeUserDAO();
    }
    public function sessionStart(){
        if (!isset($_SESSION)) {
            session_start();
        }
    }
    public function query(){}
    public function signup(){
        $this->sessionStart();
            //en caso de la ausencia de algún campo, retornar =>faltan campos
        if(!(isset($_REQUEST['name']) && isset($_REQUEST['lastname']) && 
            isset($_REQUEST['username']) && isset($_REQUEST['password']) && 
            isset($_REQUEST['numtelf']))){
                $_SESSION['messageError']="Compelte todos los campos, por favor!";
                header("Location:index.php?c=index&a=static&p=signup");
        }
        $verify=$this->userDAO->verifyUserNotRepeat(strtolower($_REQUEST['username']));
        if(!empty( $verify)){
            $_SESSION['messageError']="usuario ya existente";
            header("Location:index.php?c=index&a=static&p=signup");
        }else{
            $user=new User();
            $user->setUsername(strtolower($_REQUEST['username']));
            $user->setName_user($_REQUEST['name']);
            $user->setLast_name($_REQUEST['lastname']);
            $user->setPhone_number($_REQUEST['numtelf']);
            $user->setPassword($_REQUEST['password']);
            $num=$this->userDAO->create($user);
            if($num>0){
                $_SESSION['message']="usuario regstado";
            }else{
                $_SESSION['messageError']="Error al guardar";
            }
            $this->viewWindow();
        }
    }
    
    public function login(){
        $user=isset($_REQUEST['user'])?strtolower($_REQUEST['user']):'';
        $password=isset($_REQUEST['password'])?$_REQUEST['password']:'';
        $results = $this->userDAO->checkUser($user,$password);
        if(!isset($_SESSION)){
            session_start();
        }
        if(empty($results)){
            $_SESSION['messageError']="usuario no encontrado";
        }else{
            // var_dump($results);

            $types=$this->typeUserDAO->queryOne($results['id_TypeUser']);
            // var_dump($types);

            $user = new User();
            $user->setId_user($results['id_user']);
            $user->setUsername($results['username']);
            $user->setName_user($results['name_user']);
            $user->setLast_name($results['last_name']);
            $user->setPhone_number($results['phone_number']);
            $user->setType_user($types);
            $_SESSION['rol']=$user->getType_user()->getId_TypeUser();
            $_SESSION['USER']=$user;
        }
        $this->viewWindow();
        //var_dump($results);
    }
    public function logout(){
        if(!isset($_SESSION)){
            session_start();
        }
        if(isset($_SESSION['USER'])){
            unset($_SESSION['USER']);
            if(isset($_SESSION['rol']))
                unset($_SESSION['rol']);
            if(isset($_SESSION['ID_USER']))
                unset($_SESSION['ID_USER']);
        }
        $this->viewWindow();
    }
    public function viewWindow(){
        require_once HEADER;
        require_once 'view/static/login.php';
        require_once PANELS;
        require_once FOOTER;
    }
}
