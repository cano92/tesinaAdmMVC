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
        $answer = $this->queryList("SELECT * FROM `tesina` WHERE estado='tesina inicial' OR estado='infAvance entregado' OR estado='para exponer' ");
        return $answer;
    }

    public function registerTesis($titulo,$fecha,$objetivo,$motivacion,$desarrollos_propuestos,$resultados_esperados,$formulario1_id,$evaluadores_id,$estado,$revision,$activo){
        $stmt = $this->query("INSERT INTO tesina(titulo,fecha,objetivo,motivacion,desarrollos_propuestos,resultados_esperados,formulario1_id,evaluadores_id,estado,revision,activo)
        VALUES(:titulo,:fecha,:objetivo,:motivacion,:desarrollos_propuestos,:resultados_esperados,:formulario1_id,:evaluadores_id,:estado,:revision,:activo)");

        $stmt->bindParam(':titulo',$titulo,PDO::PARAM_STR);
        $stmt->bindParam(':fecha',$fecha,PDO::PARAM_STR);
        $stmt->bindParam(':objetivo',$objetivo,PDO::PARAM_STR);
        $stmt->bindParam(':motivacion',$motivacion,PDO::PARAM_STR);
        $stmt->bindParam(':desarrollos_propuestos',$desarrollos_propuestos,PDO::PARAM_STR);
        $stmt->bindParam(':resultados_esperados',$resultados_esperados,PDO::PARAM_STR);
        $stmt->bindParam(':formulario1_id',$formulario1_id,PDO::PARAM_INT);
        $stmt->bindParam(':evaluadores_id',$evaluadores_id,PDO::PARAM_INT);
        $stmt->bindParam(':estado',$estado,PDO::PARAM_STR);
        $stmt->bindParam(':revision',$revision,PDO::PARAM_STR);
        $stmt->bindParam(':activo',$activo,PDO::PARAM_INT);

        $stmt->execute();
    }

    public function registerForm1( $director,$codirector,$asesor_profesional,$id_alumno1,$id_alumno2,$clasificacion,$plazo_de_ejecucion,$activo ){
        $stmt = $this->query("INSERT INTO formulario1(director,codirector,asesor_profesional,id_alumno1,id_alumno2,clasificacion,plazo_de_ejecucion,activo)
        VALUES(:director,:codirector,:asesor_profesional,:id_alumno1,:id_alumno2,:clasificacion,:plazo_de_ejecucion,:activo)");

        $stmt->bindParam(':director',$director,PDO::PARAM_STR);
        $stmt->bindParam(':codirector',$codirector,PDO::PARAM_STR);
        $stmt->bindParam(':asesor_profesional',$asesor_profesional,PDO::PARAM_STR);
        $stmt->bindParam(':id_alumno1',$id_alumno1,PDO::PARAM_INT);
        $stmt->bindParam(':id_alumno2',$id_alumno2,PDO::PARAM_INT);
        $stmt->bindParam(':clasificacion',$clasificacion,PDO::PARAM_STR);
        $stmt->bindParam(':plazo_de_ejecucion',$plazo_de_ejecucion,PDO::PARAM_STR);
        $stmt->bindParam(':activo',$activo,PDO::PARAM_INT);

        $stmt->execute();
    }
    
    public function updateForm1($id,$director,$codirector,$asesor_profesional,$id_alumno1,$id_alumno2,$clasificacion,$plazo_de_ejecucion,$activo){
        $stmt = $this->query(" UPDATE `formulario1` SET  `director`=:director,`codirector`=:codirector,`asesor_profesional`=:asesor_profesional,
        `id_alumno1`=:id_alumno1,`id_alumno2`=:id_alumno2,`clasificacion`=:clasificacion,`plazo_de_ejecucion`=:plazo_de_ejecucion,`activo`=:activo
         WHERE id = :id ");

        $stmt->bindParam(':id',$id,PDO::PARAM_INT);
        $stmt->bindParam(':director',$director,PDO::PARAM_STR);
        $stmt->bindParam(':codirector',$codirector,PDO::PARAM_STR);
        $stmt->bindParam(':asesor_profesional',$asesor_profesional,PDO::PARAM_STR);
        $stmt->bindParam(':id_alumno1',$id_alumno1,PDO::PARAM_INT);
        $stmt->bindParam(':id_alumno2',$id_alumno2,PDO::PARAM_INT);
        $stmt->bindParam(':clasificacion',$clasificacion,PDO::PARAM_STR);
        $stmt->bindParam(':plazo_de_ejecucion',$plazo_de_ejecucion,PDO::PARAM_STR);
        $stmt->bindParam(':activo',$activo,PDO::PARAM_INT);

        $stmt->execute();
    }

    public function getTesisState($estado){
        $stmt = $this->query("SELECT * FROM `tesina` WHERE estado = :estado" );
        $stmt->bindParam(':estado',$estado,PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getTesisStateSize($estado){
        $stmt = $this->query("SELECT COUNT(id) FROM `tesina` WHERE estado = :estado" );
        $stmt->bindParam(':estado',$estado,PDO::PARAM_STR);
        $stmt->execute();
         
        return $stmt->fetchColumn();
    }
    
    public function getTesisNotaSize($nota){
        $stmt = $this->query("SELECT COUNT(*) FROM `tesina` WHERE nota = :nota" );
        $stmt->bindParam(':nota',$nota,PDO::PARAM_INT);
        $stmt->execute();
         
        return $stmt->fetchColumn();
    }

    public function getPropuestasInicialRevision(){
        $stmt = $this->query("SELECT * FROM `tesina` WHERE estado = 'propuesta incial' AND revision = 'en espera' " );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function findForm1($idUser){
        $stmt = $this->query("SELECT * FROM `formulario1` WHERE ( id_alumno1 = :id OR  id_alumno2 = :id ) AND activo=1" );
        $stmt->bindParam(':id',$idUser,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function desableForm1($idForm1,$activo){
        $stmt = $this->query(" UPDATE `formulario1` SET `activo`=:activo  WHERE id = :id");
        $stmt->bindParam(':activo',$activo,PDO::PARAM_INT);
        $stmt->bindParam(':id',$idForm1,PDO::PARAM_INT);

        $stmt->execute();
    }

    //formularios activos
    public function getForm1IdActivos($idForm1){
        $stmt = $this->query("SELECT * FROM `formulario1` WHERE id = :id AND activo=1 " );
        $stmt->bindParam(':id',$idForm1,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function getFormulario1Id($idForm1){
        $stmt = $this->query("SELECT * FROM `formulario1` WHERE id = :id " );
        $stmt->bindParam(':id',$idForm1,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function findTesis($idForm1){
        $stmt = $this->query("SELECT * FROM `tesina` WHERE formulario1_id = :id AND activo=1" );
        $stmt->bindParam(':id',$idForm1,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
   
    public function  findTesisId($idTesis){
        $stmt = $this->query("SELECT * FROM `tesina` WHERE id = :id  " );
        $stmt->bindParam(':id',$idTesis,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
    public function updateTesisLeido($idTesis,$leido){
        $stmt = $this->query(" UPDATE `tesina` SET `leido`=:leido  WHERE id = :id");
        $stmt->bindParam(':leido',$leido,PDO::PARAM_INT);
        $stmt->bindParam(':id',$idTesis,PDO::PARAM_INT);

        $stmt->execute();
    }

    public function disEnableTesis($id,$activo){
        $stmt = $this->query(" UPDATE `tesina` SET `activo`=:activo  WHERE id = :id");
        $stmt->bindParam(':activo',$activo,PDO::PARAM_INT);
        $stmt->bindParam(':id',$id,PDO::PARAM_INT);

        $stmt->execute();
    }

    public function updateTesisRevisionComentDenny($id,$revision,$comentario){
        $stmt = $this->query(" UPDATE `tesina` SET `revision`=:revision,`comentario`=:comentario  WHERE id = :id");
        $stmt->bindParam(':revision',$revision,PDO::PARAM_STR);
        $stmt->bindParam(':comentario',$comentario,PDO::PARAM_STR);
        $stmt->bindParam(':id',$id,PDO::PARAM_INT);

        $stmt->execute();
    }

    public function updateTesisRevisionComentAccept($id,$revision,$comentario,$estado){
        $stmt = $this->query(" UPDATE `tesina` SET `estado`=:estado,`revision`=:revision,`comentario`=:comentario  WHERE id = :id");
        $stmt->bindParam(':revision',$revision,PDO::PARAM_STR);
        $stmt->bindParam(':comentario',$comentario,PDO::PARAM_STR);
        $stmt->bindParam(':estado',$estado,PDO::PARAM_STR);
        $stmt->bindParam(':id',$id,PDO::PARAM_INT);

        $stmt->execute();
    }

    public function myTesis($id){
        $stmt = $this->query("SELECT tesina.* FROM `tesina` INNER JOIN 
        (SELECT id FROM `formulario1` WHERE id_alumno1 = :id OR id_alumno2 = :id ) 
        AS formularios ON tesina.formulario1_id = formularios.id WHERE activo = 1 ");

        $stmt->bindParam(':id',$id,PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function updateEvaluathors($idTesis,$idEvaluathors){
        $stmt = $this->query(" UPDATE `tesina` SET `evaluadores_id`=:evaluadores_id  WHERE id = :id");
        $stmt->bindParam(':evaluadores_id',$idEvaluathors,PDO::PARAM_INT);
        $stmt->bindParam(':id',$idTesis,PDO::PARAM_INT);

        $stmt->execute();

    }//insertReturnID

    public function registerEvaluathors($idEvaluathor1,$idEvaluathor2,$idEvaluathor3,$idEvaluathor4){
        
        $sql = "INSERT INTO evaluadores(id_evaluador1,id_evaluador2,id_evaluador3,id_evaluador4)
        VALUES(:id_evaluador1,:id_evaluador2,:id_evaluador3,:id_evaluador4) ";

        $connection = $this->con();
        $stmt = $connection->prepare($sql);

        $stmt->bindParam(':id_evaluador1',$idEvaluathor1,PDO::PARAM_INT);
        $stmt->bindParam(':id_evaluador2',$idEvaluathor2,PDO::PARAM_INT);
        $stmt->bindParam(':id_evaluador3',$idEvaluathor3,PDO::PARAM_INT);
        $stmt->bindParam(':id_evaluador4',$idEvaluathor4,PDO::PARAM_INT);

        $stmt->execute();
        //retorna el id de la row insertada
        return $connection->lastInsertId() ;
    }

    public function registerInfAvance($idTesis,$infAvance){
        $stmt = $this->query(" UPDATE `tesina` SET `informe_avance`=:informe_avance  WHERE id = :id");
        $stmt->bindParam(':informe_avance',$infAvance);
        $stmt->bindParam(':id',$idTesis,PDO::PARAM_INT);

        $stmt->execute();
    }
    
    public function updateTesisFechExp( $idTesis,$fechaExp,$estado ){
        $stmt = $this->query(" UPDATE `tesina` SET `fecha_exposicion`=:fecha_exposicion,`estado`=:estado  WHERE id = :id");
        $stmt->bindParam(':fecha_exposicion',$fechaExp,PDO::PARAM_STR);
        $stmt->bindParam(':estado',$estado,PDO::PARAM_STR);
        $stmt->bindParam(':id',$idTesis,PDO::PARAM_INT);

        $stmt->execute();
    }

    public function updateTesisNote( $idTesis,$note,$estado,$revision ){
        $stmt = $this->query(" UPDATE `tesina` SET `nota`=:nota,`estado`=:estado,`revision`=:revision  WHERE id = :id");
        $stmt->bindParam(':nota',$note,PDO::PARAM_INT);
        $stmt->bindParam(':estado',$estado,PDO::PARAM_STR);
        $stmt->bindParam(':revision',$revision,PDO::PARAM_STR);
        $stmt->bindParam(':id',$idTesis,PDO::PARAM_INT);

        $stmt->execute();
    }

    public function updateTesisState( $idTesis,$estado,$comentario ){
        $stmt = $this->query(" UPDATE `tesina` SET `estado`=:estado,`descripcion_cancelacion`=:comentario  WHERE id = :id");
        $stmt->bindParam(':estado',$estado,PDO::PARAM_STR);
        $stmt->bindParam(':comentario',$comentario,PDO::PARAM_STR);
        $stmt->bindParam(':id',$idTesis,PDO::PARAM_INT);

        $stmt->execute();
    }

}
