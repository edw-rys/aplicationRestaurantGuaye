<?php
require_once MODELS.'DTO/User/User.php';
class UserDAO {
	//Manejo de datos de actiidades
	public function __construct(){
	}
	public function getUser($username){
		try{
			$resultSet = Model::sql([
				"sql"=>"select id_user, username,name_user, last_name, phone_number,date_create,t.id_TypeUser, t.name_TypeUser, g.name_gender, g.id_gender".
						"from user_ as u ".
						"inner join typeuser as t on u.id_TypeUser= t.id_TypeUser ".
						"inner join gender as g on u.gender = g.id_gender ".
						"where username=:username",
				"params"=>["username"=>$username],
				"class"=>"User"
				// "fetch_type"=>"FETCH_CLASS",
			]);
			return (empty($resultSet))?$resultSet:$resultSet[0];
		} catch (Exception $e) {
			die($e->getMessage());
			die($e->trace());
		}
	}
    public function checkUser($username, $password){
		try{
			$user = Model::sql([
				"sql"=>"select id_user, username,name_user, last_name, phone_number,date_create,t.id_TypeUser, t.name_TypeUser, g.name_gender, g.id_gender, u.password ".
						"from user_ as u ".
						"inner join typeuser as t on u.id_TypeUser= t.id_TypeUser ".
						"inner join gender as g on u.gender = g.id_gender ".
						"where username=:username",
				"params"=>["username"=>$username],
				"class"=>"User",
				"fetch"=>"one"
			]);
			if(empty($user)){
				return null;
			}else{				
				if(password_verify($password,$user->getPassword())){
					return $user;
				}
				return null;
			}
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
								$user->getPassword(), $user->getPhone_number(), $user->getid_gender(),102);
			return Model::sql([
				"sql"=>"INSERT INTO 
						user_(username, name_user, last_name, password, phone_number,gender, id_TypeUser , date_create) 
						values
						(?,?,?,?,?,?,?,now());",
				"params"=>$parametros,
				"type"=>"insert"
			]);
		} catch (Exception $e) {
			die($e->getMessage());
			die($e->trace());
		}
    }

}