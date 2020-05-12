<?php

class UserRepository extends PDORepository {

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function findUserLeg($legajo){
        $stmt = $this->query("SELECT * FROM `usuario` WHERE legajo = :legajo" );
        $stmt->bindParam(':legajo',$legajo,PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);  
    }

    public function findUserName($aName){
        $stmt = $this->query("SELECT * FROM `usuario` WHERE username = :aName" );
        $stmt->bindParam(':aName',$aName,PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);       
    }

    private function findUserEmail($aMail){
        $stmt = $this->query("SELECT * FROM `usuario` WHERE email = :mail" );
        $stmt->bindParam(':mail',$aMail,PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);        

    }

    public function findUserId($aId){
        $stmt = $this->query("SELECT * FROM `usuario` WHERE id = :id" );
        $stmt->bindParam(':id',$aId,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);        
    }

    public function allUsers(){
        $answer = $this->queryList("SELECT * FROM `usuario`");
        return $answer;
    }

    public function getUser($username,$pass){
        $stmt = $this->query("SELECT * FROM `usuario` WHERE username = :username AND pass = :pass" );

        $stmt->bindParam(':username',$username,PDO::PARAM_STR);
        $stmt->bindParam(':pass',$pass,PDO::PARAM_STR);
        $stmt->execute();
        //return $stmt->fetch(PDO::FETCH_CLASS,"User");
        return $stmt->fetch(PDO::FETCH_OBJ);
    }


}