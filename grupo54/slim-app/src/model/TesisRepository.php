<?php

class TesisRepository extends PDORepository {

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getAllTesis(){
        $answer = $this->queryList("SELECT * FROM `tesina`");
        return $answer;
    }

    public function tesinasEnCurso(){
       
        $answer = $this->queryList("SELECT * FROM `tesina` WHERE estado='tesina inicial' OR estado='infAvance entregado' OR estado='para exponer' OR estado='tesina finalizada' ");
        return $answer;
    }


    public function getTesisState($estado){
        $stmt = $this->query("SELECT * FROM `tesina` WHERE estado = :estado" );
        $stmt->bindParam(':estado',$estado,PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getEstadoId($id){
        $stmt = $this->query("SELECT * FROM `estado` WHERE id = :id" );
        $stmt->bindParam(':id',$id,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ); 
    }

    public function getFormulario1Id($idForm1){
        $stmt = $this->query("SELECT * FROM `formulario1` WHERE id = :id " );
        $stmt->bindParam(':id',$idForm1,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function getTesinaFormularioId($formulario1_id){
        $stmt = $this->query("SELECT * FROM `tesina` WHERE formulario1_id = :formulario1_id " );
        $stmt->bindParam(':formulario1_id',$formulario1_id,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function getFormulario1UserId($id_alumno){
        $stmt = $this->query("SELECT * FROM `formulario1` WHERE id_alumno1 = :id_alumno OR id_alumno2 = :id_alumno " );
        $stmt->bindParam(':id_alumno',$id_alumno,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

}
