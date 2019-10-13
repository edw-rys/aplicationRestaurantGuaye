<?php 

class Db{
    private $link;
    private $engine;
    private $host;
    private $name;
    private $user;
    private $pass;
    private $charset;
    /**
    * Constructor para nuestra clase
    */
    public function __construct(){
        $this->engine  = IS_LOCAL ? LDB_ENGINE : DB_ENGINE;
        $this->name    = IS_LOCAL ? LDB_NAME : DB_NAME;
        $this->user    = IS_LOCAL ? LDB_USER : DB_USER;
        $this->pass    = IS_LOCAL ? LDB_PASS : DB_PASS;
        $this->charset = IS_LOCAL ? LDB_CHARSET : DB_CHARSET;
        return $this;    
    }
    /**
    * Método para abrir una conexión a la base de datos
    *
    * @return void
    */
    private function connect() {
        try {
        $this->link = new PDO($this->engine.':host='.$this->host.';dbname='.$this->name.';charset='.$this->charset, $this->user, $this->pass);
        return $this->link;
        } catch (PDOException $e) {
        die(sprintf('No  hay conexión a la base de datos, hubo un error: %s', $e->getMessage()));
        }
    }
    /**
    * Método para hacer un query a la base de datos
    *
    * @param string $sql
    * @param array $params
    * @return void
    */


    public static function sql($attributes){
        $db = new self();
        $link = $db->connect(); // nuestra conexión a la db
        $link->beginTransaction(); // por cualquier error, checkpoint
        $query = $link->prepare($attributes["sql"]);
        if(!$query->execute($attributes["params"])) {
            $link->rollBack();
            $error = $query->errorInfo();
            // index 0 es el tipo de error
            // index 1 es el código de error
            // index 2 es el mensaje de error al usuario
            throw new Exception($error[2]);
        }
        // add type
        if(!isset($attributes["type"])){
            $attributes["type"]="query";
        }
        $attributes["type"]= strtolower($attributes["type"]);

        if(!isset($attributes["fetch_type"])){
            $attributes["fetch_type"]="OBJ";
        }

        if(!isset($attributes["fetch"])){
            $attributes["fetch"]="ALL";
        }
        // CHECK TYPE SENTENCE SQL
        if($attributes["type"] =="query"){
            if(isset($attributes["class"])){
                return 
                $attributes["fetch"]=="ALL"?
                    $query->fetchAll(PDO::FETCH_CLASS,$attributes["class"]):
                    $query->fetch(PDO::FETCH_CLASS,$attributes["class"]);
            }else{
                return
                    $attributes["fetch"]=="ALL"?
                        $query->fetchAll(
                            $attributes["fetch_type"] == "OBJ" ?PDO::FETCH_OBJ:
                            PDO::FETCH_ASSOC
                        )
                        :
                        $query->fetch(
                            $attributes["fetch_type"] == "OBJ" ?PDO::FETCH_OBJ:
                            PDO::FETCH_ASSOC
                        )
                        ;
            }
        }elseif ($attributes["type"]=="insert") {
            $link->commit();
            return $query->rowCount();
        }elseif ($attributes["type"]=="delete") {
            if($query->rowCount() > 0) {
                $link->commit();
                return true;
            }
            $link->rollBack();
            return false; // Nada ha sido borrado
        }elseif ($attributes["type"]=="update") {
            $link->commit();
            return true;
        }
    }
    public static function queryProcedureAssoc($sql, $params = []){
        $db = new self();
        $link = $db->connect(); // nuestra conexión a la db
        $link->beginTransaction(); // por cualquier error, checkpoint
        $query = $link->prepare($sql);
        if(!$query->execute($params)) {
            $link->rollBack();
            $error = $query->errorInfo();
            // index 0 es el tipo de error
            // index 1 es el código de error
            // index 2 es el mensaje de error al usuario
            throw new Exception($error[2]);
        }
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function excecuteProcedure($sql, $params = [], $type="query",$class=null){
        $type = strtolower($type);
        $db = new self();
        $link = $db->connect(); // nuestra conexión a la db
        $link->beginTransaction(); // por cualquier error, checkpoint
        $query = $link->prepare($sql);
        if(!$query->execute($params)) {
            $link->rollBack();
            $error = $query->errorInfo();   
            // index 0 es el tipo de error
            // index 1 es el código de error
            // index 2 es el mensaje de error al usuario
            throw new Exception($error[2]);
        }
        if($type =="query"){
            if($class!=null){
                return $query->fetchAll(PDO::FETCH_CLASS,$class) ;
            }else{
                return $query->fetchAll(PDO::FETCH_OBJ);
            }
        }elseif ($type =="insert") {
            $link->commit();
            return $query->rowCount();
        }elseif ($type =="delete") {
            if($query->rowCount() > 0) {
                $link->commit();
                return true;
            }
            $link->rollBack();
            return false; // Nada ha sido borrado
        }elseif ($type =="update") {
            $link->commit();
            return true;
        }
    }
    public static function queryByClass($sql, $params = [], $class){
        $db = new self();
        $link = $db->connect(); // nuestra conexión a la db
        $link->beginTransaction(); // por cualquier error, checkpoint
        $query = $link->prepare($sql);
        // Manejando errores en el query o la petición
        // SELECT * FROM usuarios WHERE id=:cualquier AND name = :name;
        if(!$query->execute($params)) {
            $link->rollBack();
            $error = $query->errorInfo();
            // index 0 es el tipo de error
            // index 1 es el código de error
            // index 2 es el mensaje de error al usuario
            throw new Exception($error[2]);
        }
        return $query->rowCount() > 0 ? $query->fetchAll(PDO::FETCH_CLASS,$class) : false; // no hay resultados
    }
    public static function query($sql, $params = []){
        $db = new self();
        $link = $db->connect(); // nuestra conexión a la db
        $link->beginTransaction(); // por cualquier error, checkpoint
        $query = $link->prepare($sql);

        // Manejando errores en el query o la petición
        // SELECT * FROM usuarios WHERE id=:cualquier AND name = :name;
        if(!$query->execute($params)) {
            $link->rollBack();
            $error = $query->errorInfo();
            // index 0 es el tipo de error
            // index 1 es el código de error
            // index 2 es el mensaje de error al usuario
            throw new Exception($error[2]);
        }

        // SELECT | INSERT | UPDATE | DELETE | ALTER TABLE
        // Manejando el tipo de query
        // SELECT * FROM usuarios;
        if(strpos($sql, 'SELECT') !== false) {
            
            return $query->rowCount() > 0 ? $query->fetchAll(PDO::FETCH_OBJ) : false; // no hay resultados

        } elseif(strpos($sql, 'INSERT') !== false) {

            $id = $link->lastInsertId();
            $link->commit();
            return $id;

        } elseif(strpos($sql, 'UPDATE') !== false) {

            $link->commit();
            return true;

        } elseif(strpos($sql, 'DELETE') !== false) {

            if($query->rowCount() > 0) {
                $link->commit();
                return true;
            }
        
            $link->rollBack();
            return false; // Nada ha sido borrado

        } else {

        // ALTER TABLE | DROP TABLE 
            $link->commit();
            return true;
        
        }
    }
}