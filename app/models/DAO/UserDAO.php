<?php
require_once MODELS.'DTO/User/User.php';
class UserDAO {
	//Manejo de datos de actiidades
	public function __construct(){
	}
	public function getUser($username){
		try{
			$resultSet = Model::sql([
				"sql"=>"select id_user, username,name_user, last_name, phone_number,date_create,t.id_TypeUser, t.name_TypeUser ".
						"from user_ as u ".
						"inner join typeuser as t on u.id_TypeUser= t.id_TypeUser ".
						"where username=?",
				"params"=>[$username],
				"class"=>"User"
				// "fetch_type"=>"FETCH_CLASS",
			]);
			return (empty($resultSet))?$resultSet:$resultSet[0];
		} catch (Exception $e) {
			die($e->getMessage());
			die($e->trace());
		}
	}
    public function checkUser($user, $password){
        try{
			$parametros = array($user, $password);
			$resultSet = Model::sql([
				"sql"=>"call getUserCheck(?,?);",
				"params"=>$parametros,
				"class"=>"User"
				// "fetch_type"=>"ASSOC"
			]);
			return empty($resultSet)?null: $resultSet[0];
		} catch (Exception $e) {
			die($e->getMessage());
			die($e->trace());
		}
    }
    public function update(){

    }
    public function delete(){

	}
	public function verifyUserNotRepeat($username){
        try{
			$parametros = array($username);
			return Model::sql([
				"sql"=>"SELECT * from user_ where username=?;",
				"params"=>$parametros,
			]);
		} catch (Exception $e) {
			die($e->getMessage());
			die($e->trace());
		}
	}
    public function create(User $user){
        try{
			$parametros = array($user->getUsername(), $user->getName_user(), $user->getLast_name(),
								$user->getPassword(), $user->getPhone_number(), 102);
			return Model::sql([
				"sql"=>"INSERT INTO 
						user_(username, name_user, last_name, password, phone_number, id_TypeUser,date_create) 
						values
						(?,?,?,?,?,?,now());",
				"params"=>$parametros,
				"type"=>"insert"
			]);
		} catch (Exception $e) {
			die($e->getMessage());
			die($e->trace());
		}
    }

}