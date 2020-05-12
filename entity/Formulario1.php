<?php

class Formulario1 {
    
    private $id;
    private $director;
    private $codirector;
    private $asesor_profesional;
    private $id_alumno1;
    private $id_alumno2;
    private $clasificacion;
    private $plazo_de_ejecucion;
    private $activo;

    public function __GET($k){ return $this->$k; }
    public function __SET($k, $v){ return $this->$k = $v; }

    public function generateForm1Complete($id,$director,$codirector,$asesor_profesional,$id_alumno1,$id_alumno2,$clasificacion,$plazo_de_ejecucion,$activo){
        $this->__SET('id', $id);
        $this->__SET('director', $director);
        $this->__SET('codirector', $codirector);
        $this->__SET('asesor_profesional', $asesor_profesional);
        $this->__SET('id_alumno1', $id_alumno1);
        $this->__SET('id_alumno2', $id_alumno2);
        $this->__SET('clasificacion', $clasificacion);
        $this->__SET('plazo_de_ejecucion', $plazo_de_ejecucion);
        $this->__SET('activo', $activo);
    }
  
    public function generateForm1Basic($director,$codirector,$asesor_profesional,$id_alumno1,$id_alumno2,$clasificacion,$plazo_de_ejecucion){
        $this->__SET('director', $director);
        $this->__SET('codirector', $codirector);
        $this->__SET('asesor_profesional', $asesor_profesional);
        $this->__SET('id_alumno1', $id_alumno1);
        $this->__SET('id_alumno2', $id_alumno2);
        $this->__SET('clasificacion', $clasificacion);
        $this->__SET('plazo_de_ejecucion', $plazo_de_ejecucion);
    }


}