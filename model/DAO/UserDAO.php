<?php
require_once 'model/Connection.php';
require_once 'model/DTO/User/User.php';
class UserDAO {
	//Manejo de datos de actiidades
	private $connection;

	public function __construct(){
		$this->connection = Connection :: getConnection();
	}
	
    public function checkUser($user, $password){
        if(!$this->connection) return null;
        try{
			$sentencia = $this->connection->prepare("call getUserCheck(?,?)");
			$parametros = array($user, $password);
			$sentencia->execute($parametros);
			$resultSet = $sentencia->fetch(PDO::FETCH_ASSOC);
			return $resultSet;
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
		if(!$this->connection) return null;
        try{
			$sentencia = $this->connection->prepare("select * from user_ where username=?;");
			$parametros = array($username);
			$sentencia->execute($parametros);
			$resultSet = $sentencia->fetch(PDO::FETCH_ASSOC);
			return $resultSet;
		} catch (Exception $e) {
			die($e->getMessage());
			die($e->trace());
		}
	}
    public function create(User $user){
		if(!$this->connection) return null;
        try{
			$sentencia = $this->connection->prepare("call insertUser(?,?,?,?,?,?)");
			$parametros = array($user->getUsername(), $user->getName_user(),
								$user->getLast_name(),$user->getPassword(),$user->getPhone_number(),102);
			$sentencia->execute($parametros);
			return $sentencia->rowCount();
		} catch (Exception $e) {
			die($e->getMessage());
			die($e->trace());
		}
    }

}