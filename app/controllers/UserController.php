<?php
require_once MODELS.'DAO/TypeUserDAO.php';
require_once MODELS.'DAO/UserDAO.php';
require_once MODELS.'DTO/User/User.php';
require_once MODELS.'DTO/User/TypeUser.php';
require_once CONTROLLERS. 'BlogController.php';
class UserController{
    private $userDAO;
    private $typeUserDAO ;
    private $jwt;
    private $blog;
    public function __construct() {
        $this->userDAO=new UserDAO();
        $this->typeUserDAO=new TypeUserDAO();
        $this->jwt = new JwtAuth();
        $this->blog = new BlogController();
    }
    public function signup(){
            //en caso de la ausencia de algún campo, retornar =>faltan campos
        if(!(isset($_REQUEST['name']) && isset($_REQUEST['lastname']) && 
            isset($_REQUEST['username']) && isset($_REQUEST['password']) && 
            isset($_REQUEST['gender']))){
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
            $user->setPhone_number( isset($_REQUEST['numtelf']) ?$_REQUEST['numtelf']:'');
            $passwordEncrypt = password_hash($_REQUEST['password'], PASSWORD_BCRYPT , ['cost'=>10]);
            $user->setPassword($passwordEncrypt );
            $user->setid_gender($_REQUEST['gender']);
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
    
    public function login($getToken=null){
        $user=isset($_POST['username'])?strtolower($_POST['username']):'';
        $password=isset($_POST['password'])?$_POST['password']:'';

        $results = $this->jwt->signup($user,$password,$this->userDAO,$getToken);

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
            $_SESSION['ID_USER']=$user->getId_user();
            $_SESSION['USER']=serialize($user);
            // token
            $this->csrf = new Csrf();
            $data=[
                "title"=>"Login",
                "user"=>$user,
                "code"=>200,
                "status"=>"success",
            ];
            if(is_null($getToken)){
                $data["token"] = $results["token"];
            }else{
                $data["identity"] = $results["identity"];
            }
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
                    "profile"=>"VISIT",
                    "title"=>$user->getUsername()." - Inicio"
                ];
                if(isset($_SESSION['ID_USER']) && $user->getId_user() == $_SESSION['ID_USER'] ){
                    $data["profile"]="MY_PROFILE";
                }
                View::render("profile", $data);
            }
        }
        Redirect::to("error");
    }

    public function myprofile(){
        if(!isset($_SESSION["USER"])){
            Redirect::to(URL);
        }else{
            $user = $this->userDAO->getUserById($_SESSION["ID_USER"]);
            if(empty($user)){
                Redirect::to(URL);
            }else{
                // printObj($user);
                View::render("profile",["title"=>$user->getUsername(),"user"=>$user]);
            }
        }
    }
    public function renderPost($idUser=null) {
        if(is_null($idUser)){
            if(isset($_SESSION["ID_USER"])){
                $this->blog->renderPostMin($_SESSION["ID_USER"]);
            }
        }else{
            $this->blog->renderPostMin($idUser);
        }
    }
    public function config($param=null){
        if(is_null($param)){
            $data =[
                "title" => "Configuración",
                "user"  => $this->userDAO->getUserById($_SESSION["ID_USER"])
            ];
            include_once COMPONENTS."user/config.php";
        }elseif ($param="checkusername") {
            $username = isset($_REQUEST["username"])?$_REQUEST["username"]:null;
            if(!is_null($username)){
                $verify=$this->userDAO->verifyUserNotRepeat(strtolower($username),isset($_SESSION['ID_USER'])?$_SESSION['ID_USER']:null);
                if(empty($verify)){
                    $data = [
                        "status" => "success",
                        "code"   => 200,
                        "message"=> ""
                    ];
                }else{
                    $data = [
                        "status" => "error",
                        "code"   => 400,
                        "message"=> "Nombre de usuario existente"
                    ]; 
                }
            }else{
                $data = [
                    "status" => "error",
                    "code"   => 400,
                    "message"=> "Error"
                ];
            }
            echo json_encode($data);
        }
    }

    public function signin($value="login"){
        if(!isset($_SESSION["USER"])){
            if($value=="login")
                require_once COMPONENTS."user/loginComponent.php";
            elseif ($value=="signup") {
                require_once COMPONENTS."user/signupComponent.php";                
            }
        }
    }

    public function update(){
        $status = ValidateField::validateUser($_POST,$_SESSION['ID_USER']);
        if($status["status"]=="success"){
            unset($_POST['password_confirm']);
            unset($_POST['password_current']);
            // actualizar nombre de usuario
            $username = isset($_REQUEST["username"])?$_REQUEST["username"]:null;
            if(isset($_POST["password"])){
                $_POST["password"] = password_hash($_POST["password"], PASSWORD_BCRYPT , ['cost'=>10]);
            }
            if(!is_null($username)){
                $verify=$this->userDAO->verifyUserNotRepeat(strtolower($username),$_SESSION['ID_USER']);
                if(empty($verify)){
                    $res = $this->userDAO->update($_POST,$_SESSION['ID_USER']);
                    if($res){
                        $data=[
                            "status"=>"success",
                            "code"  =>200,
                            "message"=>"datos actualizados"
                        ];
                        $user = $this->userDAO->getUserById($_SESSION["ID_USER"]);
                        if(!is_null($user) && !empty($user) ){
                            $_SESSION["USER"] = serialize($user);
                        }
                    }else{
                        $data=[
                            "status"=>"error",
                            "code"  =>400,
                            "message"=>"error al actualizar"
                        ];
                    }
                }else{
                    $data = [
                        "status" => "error",
                        "code"   => 400,
                        "message"=> "Nombre de usuario existente"
                    ]; 
                }
            }else{
                if(!empty($_FILES)){
                    $data = saveImage('image',ROUTEPHOTO);
                    if($data["status"]=="success"){
                        $_POST["url_photo"] = $data["url"];
                        $res = $this->userDAO->update($_POST,$_SESSION['ID_USER']);
                        if($res){
                            $data=[
                                "status"=>"success",
                                "code"  =>200,
                                "message"=>"datos actualizados"
                            ];
                            $user = $this->userDAO->getUserById($_SESSION["ID_USER"]);
                            if(!is_null($user) && !empty($user) ){
                                $_SESSION["USER"] = serialize($user);
                            }
                        }else{
                            $data=[
                                "status"=>"error",
                                "code"  =>400,
                                "message"=>"error al actualizar"
                            ];
                        }
                    }
                }else{
                    $res = $this->userDAO->update($_POST,$_SESSION['ID_USER']);
                    if($res){
                        $data=[
                            "status"=>"success",
                            "code"  =>200,
                            "message"=>"datos actualizados"
                        ];
                        $user = $this->userDAO->getUserById($_SESSION["ID_USER"]);
                        if(!is_null($user) && !empty($user) ){
                            $_SESSION["USER"] = serialize($user);
                        }
                    }else{
                        $data=[
                            "status"=>"error",
                            "code"  =>400,
                            "message"=>"error al actualizar"
                        ];
                    }
                }

            }
        }else{
            $data=[
                "status"=>"error",
                "code"  =>400,
                "errors"=>$status["errors"]
            ];
        }
        echo json_encode($data);
    }
    public function delete(){
        die("No disponible");
        $deleteUser = $this->userDAO->delete($_SESSION["ID_USER"]);
        if($deleteUser){
            echo json_encode([
                "status" => "success",
                "code"   => 200,
                "message"=> "Usuario eliminado"
            ]);
        }else{
            echo json_encode([
                "status" => "error",
                "code"   => 400,
                "message"=> "Error al eliminar"
            ]);
        }
    }    
    public function disable(){
        $password = isset($_POST["password"])?$_POST["password"]:'';
        $check = $this->userDAO->checkPassword($_SESSION["ID_USER"] , $_POST['password']);
        if($check){
            $disableUser = $this->userDAO->disable($_SESSION["ID_USER"]);
            if($disableUser){
                $data=[
                    "status"=>"success",
                    "code"  =>200,
                    "message"=>"Usuario deshabilitado."
                ];
            }else{
                $data=[
                    "status"=>"error",
                    "code"  =>400,
                    "message"=>"Error al deshabilitar cuenta."
                ];
            }
        }else{
            $data=[
                "status"=>"error",
                "code"  =>400,
                "message"=>"Contraseña incorrecta!"
            ];
        }
        echo json_encode($data);
    }

    public function getMyData(){
        $user = $this->userDAO->getUserById($_SESSION["ID_USER"]);
        // Profile photo
        if(!is_null($user)){
            if(empty($user->geturl_photo())){
                if($user->getid_gender()==1){
                    $user->seturl_photo(IMAGES.'pictures/upload/default/male.png');
                }else{
                    $user->seturl_photo(IMAGES.'pictures/upload/default/female.png');
                }
            }else{
                $user->seturl_photo(URL.$user->geturl_photo() );
            }
            $user = dismount($user);
            if($user["id_gender"]==1){
                $user["url_image_gender"]= IMAGES.'icons/male.svg';
            }else{
                $user["url_image_gender"]= IMAGES.'icons/female.svg';
            }
            echo json_encode($user);
        }else{
            echo json_encode(["status"=>"error","code"=>"404"]);
        }
    }
    public function search($value="",$window=null) {
        $users = $this->userDAO->search($value);
        $data =[
            "title"=>"Buscar usuario",
            "users"=>$users
        ];
        if(!is_null($window)){
            View::render("search",$data);
        }else{
            include_once COMPONENTS."user/panelSearch.php";
        }
    }
}
