<?php

class RolRepository extends PDORepository {

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**recupera el id del rol enviado */
    public function findRolName($nombre){

        $stmt = $this->query("SELECT * FROM `rol` WHERE nombre = :nombre" );
        $stmt->bindParam(':nombre',$nombre,PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

}