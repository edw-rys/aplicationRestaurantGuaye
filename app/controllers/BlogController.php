<?php
require_once MODELS."DTO/User/User.php";
require_once MODELS.'DAO/BlogDAO.php';
require_once MODELS.'DTO/Blog/Blog.php';
require_once MODELS.'DTO/Blog/Recipe.php';
class BlogController {
    private $blogDAO;
    public function __construct() {
        $this->blogDAO = new BlogDAO();
    }

    public function index(){
        $allBlog = $this->blogDAO->query();
        if(!empty($allBlog)){
            $allBlog=array_reverse($allBlog);
        }
        $data=[
            "title"=>"Blog",
            "allBlog"=>$allBlog,
        ];
        View::render("blog", $data);
    }
    // public function queryAllBlog(){
    //     $blog = $this->blogDAO->query();
    // }
    public function viewRecipe($id_blog=0){
        $socialNetworkList= $this->blogDAO->querySocialNetwork();
        $blog = $this->blogDAO->queryById($id_blog);
        if(empty($blog) || is_null($blog))
            echo "null";
        else{
            include_once COMPONENTS."blog/itemAllData.php";
        }
    }
    public function seachRecipe($id_blog=null, $edit=false){
        $id_user=isset($_SESSION['ID_USER'])?$_SESSION['ID_USER']:'';
        $id_blog=is_null($id_blog)?'':$id_blog;
        $blog = $this->blogDAO->queryById($id_blog);

        if($edit){
            if(isset($_SESSION['ID_USER'])){
                $blog_edit= $this->blogDAO->queryByIdCheck($id_blog , $_SESSION['ID_USER']);
                $socialNetworkList= $this->blogDAO->querySocialNetwork();
                if(!empty($blog_edit)){
                    $data=[
                        "title"=>"Blog",
                        "allBlog"=>$blog_edit,
                        "status"=>"success",
                        "code"=>200,
                        "socialNetworkList"=>$socialNetworkList
                    ];
                }else{
                    $data=[
                        "title"=>"Blog",
                        "status"=>"error",
                        "code"=>404,
                        "message"=>"Usted no tiene permisos para editar esta publicación!"
                    ];
                }
            }else{
                $data=[
                    "title"=>"Blog",
                    "status"=>"error",
                    "code"=>400,
                    "message"=>"Necesita estar autenticado para editar."
                ];
            }
        }else{
            $data=[
                "title"=>"Blog",
                "status"=>"new",
                "code"=>200,
                "message"=>"Nuevo."
            ];
        }
        return $data;
    }
    public function queryAllBlogByUser($id=0){
        $blog = $this->blogDAO->queryByUser($id);
        return $blog;
    }

    public function renderPostMin($id=0){
        $dataBlog = $this->queryAllBlogByUser($id);
        require_once COMPONENTS.'blog/renderPostMin.php';
    }

    public function chargeSocialNetwork(){
        $socialNetwork= $this->blogDAO->querySocialNetwork();
        echo json_encode($socialNetwork);
    }
    public function delete($id=0){
        if(isset($_SESSION['ID_USER'])){
            if($_SESSION['rol']==MODERADOR){
                $numfilasAfectadas= $this->blogDAO->deleteByRol($id);
                if($numfilasAfectadas>0){
                    $data=[
                        "title"=>"Blog",
                        "status"=>"success",
                        "code"=>200,
                        "message"=>"Post eliminado por un moderador!"
                    ];
                }
                else{
                    $data=[
                        "title"=>"Blog",
                        "status"=>"error",
                        "code"=>400,
                        "message"=>"Hubo un error al eliminar."
                    ];
                }
            }else{
                $numfilasAfectadas= $this->blogDAO->delete($id,$_SESSION['ID_USER']);
                if($numfilasAfectadas>0){
                    $data=[
                        "title"=>"Blog",
                        "status"=>"success",
                        "code"=>200,
                        "message"=>"Post eliminado!"
                    ];
                }else{
                    $data=[
                        "title"=>"Blog",
                        "status"=>"error",
                        "code"=>400,
                        "message"=>"Error al eliminar, asegurese de estar autenticado con en el usuario correspondiente que hizo la publicación."
                    ];
                }
            }
        }else{
            $data=[
                "title"=>"Blog",
                "status"=>"error",
                "code"=>400,
                "message"=>"Necesita estar autenticado para eliminar."
            ];
        }
        echo json_encode($data);
    }


    public function save(){
        if(!isset($_SESSION['ID_USER'])){
            $data=[
                "title"=>"Blog",
                "status"=>"error",
                "code"=>400,
                "message"=>"Necesita estar autenticado para publicar en el blog."
            ];
        }else{
            if(!(isset($_REQUEST['nombre']) && 
                isset($_REQUEST['ingrediente']) && isset($_REQUEST['preparacion']))){
                $data=[
                    "title"=>"Blog",
                    "status"=>"error",
                    "code"=>400,
                    "message"=>"Faltan datos!"
                ];
            }else{
                
                
                $recipe =new Recipe();
                $recipe->setPreparation($_REQUEST['preparacion']);        
                
                $recipe->setName_recipe($_REQUEST['nombre']);
                for($i=0; $i<count($_REQUEST['ingrediente']) ;$i++){
                    $ingredient_=array(
                        "value"=>$_REQUEST['ingrediente'][$i]
                    );
                    $recipe->addIngredients($ingredient_);
                }
                $blog=new Blog();
                $blog->setRecipe($recipe);
                if(isset($_REQUEST['input-social']) && isset($_REQUEST['social-op'])){
                    if(count($_REQUEST['input-social'])==count($_REQUEST['social-op'])){
                        for($i=0;$i<count($_REQUEST['input-social']);$i++){
                            $link=array(
                                        "link"=>$_REQUEST['input-social'][$i],
                                        "id_type"=>$_REQUEST['social-op'][$i]
                                    );
                            $blog->addLink($link);
                        }
                    }
                }
                $numfilasAfectadas =0;
                if (isset($_REQUEST['id']) && !empty($_REQUEST['id']) &&  isset($_REQUEST['id_recipe']) && !empty($_REQUEST['id_recipe']) ) {
                    // editar
                    if(isset($_REQUEST['imagen-edit']) && !is_null($_REQUEST['imagen-edit'])){
                        $blog->getRecipe()->setUrl_image($_REQUEST['imagen-edit']);
                        if(isset($_FILES['imagen'])){
                            if($_FILES['imagen']['name']){
                                $data = saveImage('imagen');
                                if($data["status"]=="success"){
                                    $url = $data["url"];
                                    $blog->getRecipe()->setUrl_image($url);
                                }
                            }
                        }
                    }else{
                        $data = saveImage('imagen');
                        if($data["status"]=="success"){
                            $url = $data["url"];
                            $blog->getRecipe()->setUrl_image($url);
                        }
                    }

                    $blog->setId_blog($_REQUEST['id']);
                    $blog->getRecipe()->setId_recipe($_REQUEST['id_recipe']);
                    $verify=$this->blogDAO->queryByIdCheck($blog->getId_blog(),$_SESSION['ID_USER']);
                    if(empty($verify)){
                        $data=[
                            "title"=>"Blog",
                            "status"=>"error",
                            "code"=>400,
                            "message"=>"Usted no tiene permisos para editar esta publicación."
                        ];
                    }else{
                        $data=[
                            "title"=>"Blog",
                            "status"=>"success",
                            "code"=>200,
                            "message"=>"Editado exitosamente.",
                            "idRecipe"=> $blog->getId_blog(),
                        ];
                        $numfilasAfectadas = $this->blogDAO->update($blog);
                        if ($numfilasAfectadas > 0) {
                            $data=[
                                "title"=>"Blog",
                                "status"=>"success",
                                "code"=>200,
                                "message"=>"Editado exitosamente",
                                "idRecipe"=> $blog->getId_blog(),
                                "img"=>$_FILES['imagen']['name']?"true":"false"
                            ];
                        } else {
                            $data=[
                                "title"=>"Blog",
                                "status"=>"error",
                                "code"=>400,
                                "message"=>"No se pudo guardar los datos"
                            ];
                        }
                    }
                    
                }else{
                    $data = saveImage('imagen');
                    if($data["status"]=="success"){
                        $url = $data["url"];
                        $blog->getRecipe()->setUrl_image($url);
                        $numfilasAfectadas = $this->blogDAO->create($blog, $_SESSION['ID_USER']);
                        
                        $blog->setId_blog($numfilasAfectadas);

                        if ($numfilasAfectadas > 0) {
                            $data=[
                                "title"=>"Blog",
                                "status"=>"success",
                                "code"=>200,
                                "message"=>"Receta guardada.",
                                "idRecipe"=> $blog->getId_blog(),
                            ];
                        } else {
                            $data=[
                                "title"=>"Blog",
                                "status"=>"error",
                                "code"=>400,
                                "message"=>"No se pudo guardar los datos"
                            ];
                        }
                    }
                }
            }
            echo json_encode($data);
        }
    }

    public function getItemView($id=null, $version="big"){
        if(!is_null($id)){
            $blog = $this->blogDAO->queryById($id);
            if($version=="big"){
                require_once COMPONENTS."blog/blogItem.php";
            }elseif ( $version=="small") {
                $blogMin = $blog ;
                require_once COMPONENTS."blog/post_min.php";                
            }
        }
    }
    
    public function destacado($id=0){
        if($id!=0 && $_SESSION['rol']==MODERADOR){
            $res = $this->blogDAO->updateDestacado($id);
            echo json_encode(
                [
                    "status"=>$res?"success":"error",
                    "code"=>$res?200:400,
                    "message"=>$res?"":"Ocurrió un error!"
                ]
            );
        }else{
            echo json_encode(
                [
                    "status"=>"error",
                    "code"=>400,
                    "message"=>"Acción no disponible!"
                ]
            );
        }
    }

    // Views
    public function new($id=0){
        if(isset($_SESSION["USER"])){
            if($id!=0){
                $data = $this->seachRecipe($id,true);
                // var_dump($data);
                if($data["status"]=='success'){
                    $blog_edit=$data["allBlog"];
                }
            }
            include_once COMPONENTS."blog/formRecipe.php";
        }else{
            echo "error";
        }
    }
}
