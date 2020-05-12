<?php

 class CurlRequest{

    private function connect($url){
        //$ur="https://api-referencias.proyecto2018.linti.unlp.edu.ar/docente";
        //inicia la peticion curl con la url indicada
        $ch = curl_init($url);
        //revisa que este en funcion
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //marca el protocolo a usar
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
       //ejecuta la la llamada a la api 
        $response = curl_exec($ch);
        curl_close($ch);
        if(!$response) {
            return false;
        }else{
            //return json_decode( $response, true );
            return $response;
        }
    }

    private function connect2($url){
        return json_decode( file_get_contents($url), true );
    }


    public function docentes(){
        
        return $this->connect2("https://api-referencias.proyecto2018.linti.unlp.edu.ar/docente");
       
    //    $str='[{"id":"1","lastname":"Diaz J.","firstname":"Javier","position":"PTDE","works_at":"LINTI","phone":"42738","direction":"50 y 115","email":"jdiaz@info.unlp.edu.ar"},
    //    {"id":"2","lastname":"Rossi","firstname":"Gustavo","position":"PTDE","works_at":"LIFIA","phone":"","direction":"50 Y 115","email":"gustavo@sol.info.unlp.edu.ar <gustavo@sol.info.unl"},
    //    {"id":"3","lastname":"De Giusti","firstname":"Armando","position":"PTDE","works_at":"LIDI","phone":"","direction":"","email":"degiusti@lidi.info.unlp.edu.ar <degiusti@lidi.info"},
    //    {"id":"4","lastname":"Gordillo","firstname":"Silvia","position":"PTDS","works_at":"LIFIA","phone":"","direction":"","email":"gordillo@sol.info.unlp.edu.ar"},
    //    {"id":"5","lastname":"Baum","firstname":"Gabriel","position":"PTDE","works_at":"LIFIA","phone":"","direction":"","email":"gbaum@info.unlp.edu.ar"}]';
    //    return json_decode( $str, true );
    }
    
    public function evaluadores(){
        
         return $this->connect2("https://api-referencias.proyecto2018.linti.unlp.edu.ar/evaluador");
        
        // $str= '[{"id":"1","lastname":"Diaz J.","firstname":"Javier ","position":"PTDE","works_at":"LINTI ","phone":"42738 ","direction":"50 y 115","email":"jdiaz@info.unlp.edu.ar "},
        // {"id":"2","lastname":"Rossi ","firstname":"Gustavo","position":"PTDE","works_at":"LIFIA ","phone":"42738 ","direction":"50 Y 115","email":"gustavo@sol.info.unlp.edu.ar"},
        // {"id":"3","lastname":"De Giusti A","firstname":"Armando","position":"PTDE","works_at":"LIDI","phone":"42738 ","direction":"50 Y 115","email":"degiusti@lidi.info.unlp.edu.ar "},
        // {"id":"4","lastname":"Gordillo  ","firstname":"Silvia ","position":"PTDS","works_at":"LIFIA ","phone":"42738 ","direction":"50 Y 115","email":"gordillo@sol.info.unlp.edu.ar  "}]';
        // return json_decode( $str, true );
    }

    public function docenteId($idDocecnte){

         return $this->connect2("https://api-referencias.proyecto2018.linti.unlp.edu.ar/docente/$idDocecnte");
    
    //    $str='{"id":"1","lastname":"Diaz J.","firstname":"Javier","position":"PTDE","works_at":"LINTI","phone":"42738","direction":"50 y 115","email":"jdiaz@info.unlp.edu.ar"}';
    //    return json_decode( $str, true );
    }

    public function evaluadorId($idEvaluador){

        return $this->connect2("https://api-referencias.proyecto2018.linti.unlp.edu.ar/evaluador/$idEvaluador");
    
        // $str='{"id":"3","lastname":"De Giusti A","firstname":"Armando","position":"PTDE","works_at":"LIDI","phone":"42738 ","direction":"50 Y 115","email":"degiusti@lidi.info.unlp.edu.ar "}';
        // return json_decode( $str, true );
    }

 }