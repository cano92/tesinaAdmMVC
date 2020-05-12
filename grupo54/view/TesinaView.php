<?php


class TesinatView extends TwigView {


    public function allTesinas($user,$colTesis,$colAthors) { 
        echo self::getTwig()->render('listTesinas.html.twig',array('user' => $user,'colTesis' => $colTesis,'colAthors' => $colAthors ));
    }

    public function showTesinasEnCurso($user,$colTesis,$colAuthors,$info,$error) {
        echo self::getTwig()->render('listTesinasEnCurso.html.twig',array('user' => $user,'colTesis' => $colTesis,'colAuthors' =>$colAuthors,'error' => $error,'info' => $info));
    }

    public function showPendienTesinas($user,$colTesis,$colAuthors,$error,$info) {
        echo self::getTwig()->render('listTesinasPendientes.html.twig',array('user' => $user,'colTesis' => $colTesis,'colAuthors' =>$colAuthors,'error' => $error,'info' => $info));
    }

    public function showTesinaForm($user,$idForm1){
        echo self::getTwig()->render('tesinaForm.html.twig',array('user' => $user,'idForm1' => $idForm1 ));
    }

    public function form1Editsucces($user,$idForm1,$info){
        echo self::getTwig()->render('tesinaForm.html.twig',array('user' => $user,'idForm1' => $idForm1,'info' => $info ));
    }

    public function showForm1($user,$docentes,$info,$error){
        echo self::getTwig()->render('formulario1.html.twig',array('user' => $user,'docentes'=> $docentes,'info' => $info,'error'=>$error ));
    }

    public function showForm1InputError($user,$form1,$docentes,$error){
        echo self::getTwig()->render('formulario1.html.twig',array('user'=>$user,'form1'=>$form1,'docentes'=> $docentes,'error'=>$error  ));
    }

    public function showForm1EditInputError($user,$form1,$docentes,$alumno2,$error){
        echo self::getTwig()->render('formulario1Edit.html.twig',array('user'=>$user,'form1'=>$form1,'docentes'=> $docentes,'alumno2'=>$alumno2,'error'=>$error  ));
    }

    public function showForm1Edit($user,$form1,$docentes,$alumno2,$error){
        echo self::getTwig()->render('formulario1Edit.html.twig',array('user' => $user,'form1' => $form1,'docentes'=> $docentes,'alumno2'=>$alumno2,'error'=>$error ));
    }

    public function showTesinaInfo($user,$mensajeEstado,$idTesis){
        echo self::getTwig()->render('tesinaInfo.html.twig',array('user' => $user,'mensajeEstado' => $mensajeEstado,'idTesis'=>$idTesis ));
    }

    public function showTesina($user,$tesis,$form1,$director,$codirector,$alumno1,$alumno2){
        echo self::getTwig()->render('tesinaShow.html.twig',array('user' => $user,'tesis'=>$tesis,'form1'=>$form1,'director'=>$director,'codirector'=>$codirector,'alumno1'=>$alumno1,'alumno2'=>$alumno2 ));
    }

    public function showTesinaRechazada($user,$tesis,$form1,$director,$codirector,$alumno1,$alumno2){
        echo self::getTwig()->render('tesinaShowRechazada.html.twig',array( 'user' => $user,'tesis'=>$tesis,'form1'=>$form1,'director'=>$director,'codirector'=>$codirector,'alumno1'=>$alumno1,'alumno2'=>$alumno2 ));
    }
    
    public function showTesinaRevision($user,$tesis,$form1,$director,$codirector,$alumno1,$alumno2){
        echo self::getTwig()->render('tesinaRevisionShow.html.twig',array('user' => $user,'tesis'=>$tesis,'form1'=>$form1,'director'=>$director,'codirector'=>$codirector,'alumno1'=>$alumno1,'alumno2'=>$alumno2 ));
    }

    public function showTesinaCancel($user,$tesis,$form1,$director,$codirector,$alumno1,$alumno2){
        echo self::getTwig()->render('tesinaCancelShow.html.twig',array('user' => $user,'tesis'=>$tesis,'form1'=>$form1,'director'=>$director,'codirector'=>$codirector,'alumno1'=>$alumno1,'alumno2'=>$alumno2 ));
    }

    public function showTesinaInfAvance($user,$tesis,$form1,$director,$codirector,$alumno1,$alumno2){
        echo self::getTwig()->render('tesinaInfoAvanceShow.html.twig',array('user' => $user,'tesis'=>$tesis,'form1'=>$form1,'director'=>$director,'codirector'=>$codirector,'alumno1'=>$alumno1,'alumno2'=>$alumno2 ));
    }

    public function showTesinaFechExp($user,$tesis,$form1,$director,$codirector,$alumno1,$alumno2){
        echo self::getTwig()->render('tesinafechExpShow.html.twig',array('user' => $user,'tesis'=>$tesis,'form1'=>$form1,'director'=>$director,'codirector'=>$codirector,'alumno1'=>$alumno1,'alumno2'=>$alumno2 ));
    }

    public function showTesinaUpdateNote($user,$tesis,$form1,$director,$codirector,$alumno1,$alumno2){
        echo self::getTwig()->render('tesinaUpdateNoteShow.html.twig',array('user' => $user,'tesis'=>$tesis,'form1'=>$form1,'director'=>$director,'codirector'=>$codirector,'alumno1'=>$alumno1,'alumno2'=>$alumno2 ));
    }

    public function myTesinas($user,$colTesis){
        echo self::getTwig()->render('myTesinasList.html.twig',array('user' => $user,'colTesis'=>$colTesis ));
    } 

    public function showFormEvaluathors($user,$colEvaluadores,$error){
        echo self::getTwig()->render('formEvaluathors.html.twig',array('user' => $user,'colEvaluadores'=>$colEvaluadores,'error'=>$error ));
    }

    public function showFormEvaluathorsError($user,$colEvaluadores,$idEv1,$idEv2,$idEv3,$idEv4,$error){
        echo self::getTwig()->render('formEvaluathors.html.twig',array('user' => $user,'colEvaluadores'=>$colEvaluadores,'idEv1'=>$idEv1,'idEv2'=>$idEv2,'idEv3'=>$idEv3,'idEv4'=>$idEv4,'error'=>$error ));
    }

    /** vista con client vue JS */

    public function tesinaEnCurso($user){
        echo self::getTwig()->render('tesinaEnCursoVue.html.twig',array('user' => $user ));
    } 
    
    /**reportes highchatrs */
    public function showResportesEstado($user,$result){
        echo self::getTwig()->render('reportesEstado.html.twig',array('user' => $user,'result' => $result ));
    }

    public function showResportesNotas($user,$result){
        echo self::getTwig()->render('reportesNotas.html.twig',array('user' => $user,'result' => $result ));
    }

    public function showResportesDirectores($user,$result){
        echo self::getTwig()->render('reportesDirectores.html.twig',array('user' => $user,'result' => $result ));
    }

}