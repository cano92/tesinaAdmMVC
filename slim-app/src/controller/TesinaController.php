<?php


class TesinaController {
    
    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function tesinasEstado($idEstado){
        $colTesis=array();
        if( $this->intValidate($idEstado) ){
            //se debe recuperar el nombre de estado de la tabla lo que llega es un id
            $estado= TesisRepository::getInstance()->getEstadoId($idEstado);
            if($estado){
                $colTesis = TesisRepository::getInstance()->getTesisState($estado->nombre);
            }
        }        
        return $this->generateListTesinas($colTesis);
    }

    public function tesinasEnCurso(){
        $colTesis = TesisRepository::getInstance()->tesinasEnCurso();
        return $this->generateListTesinas($colTesis);
    }

    public function tesinasLegAlumno($legajo){
       $colTesis=array();$i=0;

        if( $this->intValidate($legajo) ){
            //no esta controlado si el alumno existe o no
            $alumno=UserRepository::getInstance()->findUserLeg($legajo);
            if($alumno){
                $colFormulario1=TesisRepository::getInstance()->getFormulario1UserId( $alumno->id );
                //recorrer la lista de formularios 1 y traer las tesis
                foreach( $colFormulario1 as $form1){
                    //recuperar tesis del formulario 1 y agregarlo a la col
                    $tesina=TesisRepository::getInstance()->getTesinaFormularioId($form1->id);
                    //generar una lista de tesinas y llamar a generateListTesinas
                    $colTesis[$i]=$tesina;
                    $i++;
                }
            }
        }
        return $this->generateListTesinas($colTesis);
    }

    /** funciones ayudantes privadas */

    private function generateListTesinas($colTesis){
        $result = array(); $i=0;
        foreach( $colTesis as $tesis){
            $directores=$this->generateDirectores($tesis->formulario1_id);
            $estado=$this->generateEstado($tesis);
            $alumnos=$this->generateAlumnos($tesis->formulario1_id);
            //genera la tesina para ser agregada
            $tesina=$this->generateTesina($tesis->titulo,$directores,$alumnos,$estado);
            //agrega la tesina a la coleccion resultado
            $result[$i]=$tesina;
            $i++;
        }

        return $result;
    }

    private function generateDirectores($idFormulario1){
        $directores="";

         //se debe recuperar los nombres de los directores del formulario1
        $form1=TesisRepository::getInstance()->getFormulario1Id($idFormulario1);
        $curl = new CurlRequest;
        $director=$curl->docenteId($form1->director);
        $codirector=$curl->docenteId($form1->codirector);

        //print_r($director);
        $directores=$director['lastname'].' '.$director['firstname'].' y '.$codirector['lastname'].' '.$codirector['firstname'];

        return $directores;
    }

    private function generateEstado($tesis){
        $estado=$tesis->estado;

        if($tesis->estado == 'tesina finalizada'){
            $estado=$estado.', Nota '.$tesis->nota;
        }

        return $estado;
    }

    private function generateAlumnos($idFormulario1){
        $alumnos="";
        //recupero formulario1
        $form1=TesisRepository::getInstance()->getFormulario1Id($idFormulario1);
        $alumno1=UserRepository::getInstance()->findUserId($form1->id_alumno1);
        $alumnos=$alumno1->username;
        if($form1->id_alumno2){
            //si existe autor2 se concatena los autores
            $alumno2=UserRepository::getInstance()->findUserId($form1->id_alumno2);
            $alumnos=$alumnos.' y '.$alumno2->username;
        }
        return $alumnos;
    }

    private function generateTesina($titulo,$directores,$alumnos,$estado){
        $tesina = new Tesina;

        $tesina->__SET('titulo',$titulo);
        $tesina->__SET('directores',$directores);
        $tesina->__SET('alumnos',$alumnos);
        $tesina->__SET('estado',$estado);

        return $tesina;
    }

    private function intValidate($nro){
        if( !filter_var( $nro, FILTER_VALIDATE_INT) ){
            return false; 
        } 
        if ( $nro <= 0 ){ 
            return false; 
        } 
        return true;
    }

}