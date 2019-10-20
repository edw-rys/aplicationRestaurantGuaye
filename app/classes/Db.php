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

        // echo json_encode([
        //     "status"=>"error",
        //     "sql"=>json_encode($query)
        // ]);
        // printObj($attributes["params"]);
        // die();
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
                if($attributes["fetch"]=="ALL"){
                    return 
                    $query->fetchAll(PDO::FETCH_CLASS,$attributes["class"]);
                }else{
                    $resulSet = 
                    $query->fetchAll(PDO::FETCH_CLASS,$attributes["class"]);
                    return empty($resulSet)?$resulSet:$resulSet[0];
                }
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
            $id = $link->lastInsertId();
            $link->commit();
            return $id;
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
    public static function cleanData($data=null){
        if(is_null($data)){
            $data =[];
        }
        if(!isset($data["table"]) || is_null($data["table"])){
            throw new Exception("Table not found");
        }
        if(!isset($data["params"])){
            $data["params"] = [];
        }
        if(!isset($data["_sql_params"])){
            $data["_sql_params"] = "*";
        }
        if(!isset($data["condition"])){
            $data["condition"]=null;
        }
        if(!isset($data["inner_join"])){
            $data["inner_join"]=null;
        }
        return $data;
    }
    /**
     * Recibe un array de string, string se separa con espacios, tendrá un tamaño de 3 palabra
     * "TABLE llave_primaria llave_de_referencia identificador(opcional)"
     * genera un array con llaves para hacer un inner join
     * @return $innerJoinArrayData
     */
    public static function generateInnerJoin($params=[]) {
        $innerJoinArrayData=[];
        foreach ($params as $value) {
            $value = explode(' ',$value);
            $inner =[
                "table"=>$value[0],
                "this_col_reference"=>$value[1],
                "colReference"=>$value[2],
            ] ;
            if(isset($value[3]) && !empty($value[3])){
                $inner["identify"] = $value[3];
            }
            array_push($innerJoinArrayData, $inner);
        }
        return $innerJoinArrayData;
    }
    /**
     * $params =[
     *  _sql_params , table, params, inner_join, 
     * ]
     */
    public static function get($params=[]) {
        try {
            $params = self::cleanData($params);
        } catch (Exception $th) {
            die($th);
        }
        // query
        $as = isset($params['as_table'])?' as '. $params['as_table']:'';
        $sql = 'SELECT '.$params['_sql_params'].' from '. $params['table']. $as.' ';
        // Inner
        if(!is_null($params["inner_join"])){
            $as_table =isset($params['as_table'])?$params['as_table']:$params['table'];
            foreach ($params["inner_join"] as $value) {
                if($value['identify']){
                    $sql = $sql .
                    ' inner join '. $value['table'] . ' as '. $value['identify'].
                        ' on '. $value['identify'] .'.'.$value['this_col_reference'].' = '.$as_table.'.'.$value['colReference'] ;
                }else{
                    $sql = $sql .
                    ' inner join '. $value['table'] .
                        ' on '. $value['table'].'.'.$value['this_col_reference'].' = '.$as_table.'.'.$value['colReference'] ;
                }
            }
        }
        if( !is_null($params['condition']) ){
            $sql  = $sql . " where ".$params['condition'];
        }

        $data_sql =[
            "sql"           => $sql,
            "params"        => $params["params"],
            "type"          => "query",
            "fetch"         => isset($params["fetch"])?$params["fetch"]:null,
            "fetch_type"    => isset($params["fetch_type"])?$params["fetch_type"]:null,
            "class"         => (isset($params["class"]) && !empty($params["class"]))?$params["class"]:null,
        ];
        // printObj($data_sql);
        // die();
        try{
            return self::sql($data_sql);
        }catch(Exception $ex){
            die($ex);
        }
    }
}