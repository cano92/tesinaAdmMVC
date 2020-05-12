<?php

class UserRepository extends PDORepository {

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
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
    /**retorna los Roles  de un user*/
    public function getRols($idUser){
        //recupera los roles de un usuario por id
        $stmt = $this->query("SELECT rol.nombre,rol.id FROM rol INNER JOIN 
        (SELECT usuario_tiene_rol.rol_id FROM `usuario_tiene_rol` WHERE usuario_id =:id) 
        AS roles ON rol.id = roles.rol_id");
        $stmt->bindParam(':id',$idUser,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
        //return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    /**retorna los permisos de un rol */
    public function getPermits($idRol){
        //SELECT permiso.nombre FROM permiso INNER JOIN (SELECT rol_tiene_permiso.permiso_id FROM rol_tiene_permiso WHERE rol_tiene_permiso.rol_id =1 ) AS permisos ON permisos.permiso_id = permiso.id
        $stmt = $this->query("SELECT permiso.nombre FROM permiso INNER JOIN 
        (SELECT rol_tiene_permiso.permiso_id FROM rol_tiene_permiso WHERE rol_tiene_permiso.rol_id =:id)
        AS permisos ON permisos.permiso_id = permiso.id");
        $stmt->bindParam(':id',$idRol,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /** getAllPermits  */
    //retornar la lista de todos los permisos para una lista de roles

    public function registerUser($email,$username,$pass,$firstname,$lastname,$legajo,$direction,$phone,$activo){
        $stmt = $this->query("INSERT INTO usuario(email,username,pass,firstname,lastname,legajo,direction,phone,activo)
        VALUES(:email,:username,:pass,:firstname,:lastname,:legajo,:direction,:phone,:activo)");
        
        $stmt->bindParam(':email',$email,PDO::PARAM_STR);
        $stmt->bindParam(':username',$username,PDO::PARAM_STR);
        $stmt->bindParam(':pass',$pass,PDO::PARAM_STR);
        $stmt->bindParam(':firstname',$firstname,PDO::PARAM_STR);
        $stmt->bindParam(':lastname',$lastname,PDO::PARAM_STR);
        $stmt->bindParam(':legajo',$legajo,PDO::PARAM_STR);
        $stmt->bindParam(':direction',$direction,PDO::PARAM_STR);
        $stmt->bindParam(':phone',$phone,PDO::PARAM_INT);
        $stmt->bindParam(':activo',$activo,PDO::PARAM_INT);

        $stmt->execute();
    }

    public function update($email,$username,$pass,$firstname,$lastname,$legajo,$direction,$phone,$id){
        $stmt = $this->query(" UPDATE `usuario` SET `email`=:email,`username`=:username,`pass`=:pass,`firstname`=:firstname,
        `lastname`=:lastname,`legajo`=:legajo,`direction`=:direction,`phone`=:phone  WHERE id = :id");
        
        $stmt->bindParam(':email',$email,PDO::PARAM_STR);
        $stmt->bindParam(':username',$username,PDO::PARAM_STR);
        $stmt->bindParam(':pass',$pass,PDO::PARAM_STR);
        $stmt->bindParam(':firstname',$firstname,PDO::PARAM_STR);
        $stmt->bindParam(':lastname',$lastname,PDO::PARAM_STR);
        $stmt->bindParam(':legajo',$legajo,PDO::PARAM_STR);
        $stmt->bindParam(':direction',$direction,PDO::PARAM_STR);
        $stmt->bindParam(':phone',$phone,PDO::PARAM_INT);

        $stmt->bindParam(':id',$id,PDO::PARAM_INT);
        $stmt->execute();
    }

    public function disEnableUser($id,$activo){
        $stmt = $this->query(" UPDATE `usuario` SET `activo`=:activo  WHERE id = :id");
        $stmt->bindParam(':activo',$activo,PDO::PARAM_INT);
        $stmt->bindParam(':id',$id,PDO::PARAM_INT);

        $stmt->execute();
    }

 
    

}