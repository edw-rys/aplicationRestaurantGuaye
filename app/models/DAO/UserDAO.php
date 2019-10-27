<?php
require_once MODELS.'DTO/User/User.php';
class UserDAO {
	//Manejo de datos de actiidades
	public function __construct(){
	}
	public function search($value=""){
		if(empty($value)){
			return [];
		}
		try{
			return Model::sql([
				"sql"=>"select id_user, username, name_user, last_name, url_photo,gender ".
						"from user_ ".
						"where ( username like concat('%',:value,'%')  or name_user like concat('%',:value,'%') or last_name like concat('%',:value,'%')) and status=1",
				"params"=>["value"=>$value],
			]);
		} catch (Exception $e) {
			die($e->getMessage());
			die($e->trace());
		}
	}
	public function getUser($username){
		try{
			return Model::sql([
				"sql"=>"select id_user, username,name_user, last_name, phone_number, url_photo ,date_create,t.id_TypeUser, t.name_TypeUser, g.name_gender, g.id_gender ".
						"from user_ as u ".
						"inner join typeuser as t on u.id_TypeUser= t.id_TypeUser ".
						"inner join gender as g on u.gender = g.id_gender ".
						"where username=:username and u.status=1",
				"params"=>["username"=>$username],
				"class"=>"User",
				"fetch"=>"one"
			]);
		} catch (Exception $e) {
			die($e->getMessage());
			die($e->trace());
		}
	}
	public function getUserById($id){
		try{
			return Model::sql([
				"sql"=>"select id_user, username,name_user, last_name, phone_number, url_photo, date_create,t.id_TypeUser, t.name_TypeUser, g.name_gender, g.id_gender ".
						"from user_ as u ".
						"inner join typeuser as t on u.id_TypeUser= t.id_TypeUser ".
						"inner join gender as g on u.gender = g.id_gender ".
						"where id_user=:id_user and u.status=1",
				"params"=>["id_user"=>$id],
				"class"=>"User",
				"fetch"=>"one"
			]);
		} catch (Exception $e) {
			die($e->getMessage());
			die($e->trace());
		}
	}
    public function checkUser($username, $password){
		try{
			$user = Model::sql([
				"sql"=>"select id_user, username,name_user, last_name, phone_number, url_photo, date_create,t.id_TypeUser, t.name_TypeUser, g.name_gender, g.id_gender, u.password ".
						"from user_ as u ".
						"inner join typeuser as t on u.id_TypeUser= t.id_TypeUser ".
						"inner join gender as g on u.gender = g.id_gender ".
						"where username=:username and u.status=1;",
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
	public function checkPassword($id_user, $password){
		try{
			$user = Model::sql([
				"sql"=>"select password ".
						"from user_ ".
						"where id_user=:id_user and status=1;",
				"params"=>["id_user"=>$id_user],
				"class"=>"User",
				"fetch"=>"one"
			]);
			if(empty($user)){
				return false;
			}else{				
				if(password_verify($password,$user->getPassword())){
					return true;
				}
				return false;
			}
		} catch (Exception $e) {
			die($e->getMessage());
			die($e->trace());
		}
    }
    public function update($params=[], $id){
		try{
			return Model::set([
				"table"    	=>	"user_",
				"params"   	=>	$params,
				"condition"	=>	"where id_user=:id_user",
				"id_table"	=>	["id_user"=> $id]
			]);
		} catch (Exception $e) {
			die($e->getMessage());
			die($e->trace());
		}
    }
    public function disable($id){
		try{
			return Model::set([
				"table" 	=> 	"user_",
				"params"	=> 	["status"=>0],
				"condition"	=>	"where id_user=:id_user",
				"id_table"	=>	["id_user"=> $id]
			]);
		} catch (Exception $e) {
			die($e->getMessage());
			die($e->trace());
		}
	}
	public function verifyUserNotRepeat($username,$id=null){
        try{
			$parametros = array("username"=>$username);
			$sql = "SELECT * from user_ where username=:username ";
			if(!is_null($id)){
				$sql = $sql. " and id_user!=:id_user;";
				$parametros["id_user"]=$id;
			}
			return Model::sql([
				"sql"=>$sql,
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