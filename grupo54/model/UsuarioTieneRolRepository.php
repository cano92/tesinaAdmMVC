<?php

class UsuarioTieneRolRepository extends PDORepository {

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function darRol($idUser,$idRol){
        $stmt = $this->query("INSERT INTO usuario_tiene_rol(usuario_id,rol_id)
        VALUES(:usuario_id,:rol_id)");
        $stmt->bindParam(':usuario_id',$idUser,PDO::PARAM_INT);
        $stmt->bindParam(':rol_id',$idRol,PDO::PARAM_INT);
   
        $stmt->execute();
    }
    public function QuitarRol($idUser,$idRol){
        $stmt = $this->query(" DELETE FROM usuario_tiene_rol WHERE usuario_id = :usuario_id
        AND rol_id = :rol_id");
        $stmt->bindParam(':usuario_id',$idUser,PDO::PARAM_INT);
        $stmt->bindParam(':rol_id',$idRol,PDO::PARAM_INT);
          
        $stmt->execute();
    }


}