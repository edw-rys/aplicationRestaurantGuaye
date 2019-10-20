<?php
class EventModel extends Model{
	//Manejo de datos de actividades
    private $id_event;
    private $affair;  //ASUNTO
    private $creation_date;
    private $execution_date;
    private $start_time;
    private $end_time;
    private $comment;
    private $id_user;
    private $status;
    private $is_accepted;


    public function getData($params_get_data){
        $condition = "evt.status=1 ";
        $params=[];
        if(isset($params_get_data["value"]) && !empty($params_get_data["value"]) ){
            $condition =  $condition ." and (evt.affair like CONCAT('%', :value,'%') or evt.execution_date LIKE concat('%',:value,'%'))";
            $params["value"]= $params_get_data["value"];
        }
        if(isset($params_get_data["id_user"]) && $params_get_data["id_user"]){
            $condition  = $condition . ' and evt.id_user=:id_user ';
            $params["id_user"]= $params_get_data["id_user"];
        }
        if(isset($params_get_data["id_event"]) && $params_get_data["id_event"]){
            $condition = $condition ." and evt.id_event=:id_event ";
            $params["id_event"]= $params_get_data["id_event"];
        }
        $data_sql =[
            "_sql_params"   => "evt.id_event, evt.affair,evt.creation_date ,
                                evt.execution_date,evt.start_time, evt.end_time, evt.is_accepted,
                                evt.comment, us.username,us.name_user,us.last_name, us.id_user ",
            "table"         => "event_",
            "as_table"      => "evt",
            "inner_join"    => parent::generateInnerJoin(["user_ id_user id_user us"]),
            "condition"     => $condition,
            "params"        => $params 
        ];
        if(isset($params_get_data["id_event"]) && $params_get_data["id_event"]){
            $data_sql["fetch"]="one";
        }
        if(isset($params_get_data["mode"]) && !empty($params_get_data["mode"])){
            $data_sql["class"]="EventModel";
            $data_sql["fetch_type"]="class";
        }
        return parent::get($data_sql);
    } 

    
    //  verificar Horario no ocupado
    public function checkSchedule($date, $hour_in,$hour_out){
        try {
            $parametros = array($date, $hour_in,$hour_out);
            return Model::sql([
                "sql"   =>"call getEventForDate(?,?,?)",
                "params"=>$parametros,
            ]);
        } catch (Exception $e) {
            die($e->getMessage());
            die($e->getTrace());
        }
    }


    ////////////////


    public function update(){
        $sql = "UPDATE event_
                set  affair=:affair, execution_date=:execution_date, start_time=:start_time , end_time=:end_time, comment=:comment 
                where id_event=:id_event and id_user=:id_user;";
        $params = [
            "affair"         => $this->affair,
            "comment"        => $this->comment,
            "id_user"        => $this->id_user,
            "end_time"       => $this->end_time,
            "id_event"       => $this->id_event,
            "start_time"     => $this->start_time,
            "execution_date" => $this->execution_date,
        ];
        try {
            return Model::sql([
                "sql"   =>$sql,
                "params"=>$params,
                "type"  =>"update"
            ]);
            // retorna el num de filas afectadas
        } catch (Exception $e) {
            die($e->getMessage());
            die($e->getTrace());
        }
    }
    public function delete( $id_event){
        try {
            $parametros = array( $id_event);
            return Model::sql([
                "sql"=>"call deleteStatusEvent(?)",
                "params"=>  $parametros,
                "type"  =>"delete"
            ]);
            // retorna el num de filas afectadas
        } catch (Exception $e) {
            die($e->getMessage());
            die($e->getTrace());
        }
    }
    public function create(){
        $sql = "INSERT INTO 
        event_( affair,execution_date, start_time, end_time, comment, id_user, creation_date) 
        VALUES (:affair, :execution_date, :start_time, :end_time, :comment, :id_user,now())";
        $params = [
            "affair"         => $this->affair,
            "comment"        => $this->comment,
            "id_user"        => $this->id_user,
            "end_time"       => $this->end_time,
            "start_time"     => $this->start_time,
            "execution_date" => $this->execution_date,
        ];
        try {
            return Model::sql([
                "sql"   => $sql,
                "params"=> $params,
                "type"  => "insert"
            ]);
        } catch (Exception $e) {
            die($e->getMessage());
            die($e->getTrace());
        }
    }


    public function accept($id_evt){
        $sql = "UPDATE event_ set  is_accepted=1 where id_event=:id_event;";
        try {
            return Model::sql([
                "sql"    => $sql ,
                "type"   => "update",
                "params" => ["id_event"=>$id_evt],
            ]);
        } catch (Exception $e) {
            die($e->getMessage());
            die($e->getTrace());
        }
    }
    public function getDataCalendarEvent(){
        $sql = "SELECT execution_date, start_time, end_time, affair event_ from event_;";
        try {
            return Model::sql([
                "sql"    => $sql,
                "params" => []
            ]);
        } catch (Exception $e) {
            // die($e->getMessage());
            // die($e->getTrace());
        }
    }





    // Gets and Sets

    public function getIs_accepted() {
        return $this->is_accepted;
    }

    public function setIs_accepted() {
        return $this->is_accepted;
    }
    public function getId_event() {
        return $this->id_event;
    }

    public function getAffair() {
        return $this->affair;
    }

    public function getDate() {
        return $this->creation_date;
    }

    public function getStart_time() {
        return $this->start_time;
    }

    public function getEnd_time() {
        return $this->end_time;
    }

    public function getComments() {
        return $this->comment;
    }

    public function getUser() {
        return $this->id_user;
    }

    public function getExecutionDate() {
        return $this->execution_date;
    }

    
    public function setExecutionDate($execution_date) {
        $this->execution_date = $execution_date;
    }
    public function setId_event($id_event) {
        $this->id_event = $id_event;
    }

    public function setAffair($affair) {
        $this->affair = $affair;
    }

    public function setDate($creation_date) {
        $this->creation_date = $creation_date;
    }

    public function setStart_time($start_time) {
        $this->start_time = $start_time;
    }

    public function setEnd_time($end_time) {
        $this->end_time = $end_time;
    }

    public function setComments($comment) {
        $this->comment = $comment;
    }

    public function setUser($id_user) {
        $this->id_user = $id_user;
    }
}