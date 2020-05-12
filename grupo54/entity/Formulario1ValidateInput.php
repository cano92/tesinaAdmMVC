<?php

class Formulario1ValidateInput {

    
    public function validateFormulario1(){ 
        //controla los campos obligatorios 
        if( !$this->director() ){ return false; } 
        if( !$this->codirector() ){ return false; }
        if( !$this->asesorProfesional() ){ return false; }
        if( !$this->alumno2() ){ return false; }
        if( !$this->clasificacion() ){ return false; }
        if( !$this->plazo_de_ejecucion() ){ return false; }
        
        return true;
    }

    private function director(){
        if (!isset($_POST['director'])) { $_SESSION['inputError']='ingrese un director'; return false; }
        if ( $_POST['director'] == '' ){ 
            $_SESSION['inputError']='ingrese un nombre de director porfavor'; 
            return false; } 
        if($_POST['director']==$_POST['codirector']){
            $_SESSION['inputError']='el director y codirector deben ser distintos'; 
            return false; }
            //el id debe ser un nro
            if( !filter_var( $_POST['director'], FILTER_VALIDATE_INT) ){
                $_SESSION['inputError']='el plazo de ejecucion debe ser un nro..';
                return false; 
            } 
            //el id debe ser un nro valido mayor a cero
            if ( $_POST['director'] <= 0 ){ 
                $_SESSION['inputError']='el plazo de ejecucion debe ser mayor a cero';
                return false; }
        return true;
    }

    private function codirector(){
        if (!isset($_POST['codirector'])) { $_SESSION['inputError']='ingrese un codirector';return false; }
        if ( $_POST['codirector'] == '' ){
            $_SESSION['inputError']='ingrese un codirector porfavor'; 
            return false; }
        if($_POST['director']==$_POST['codirector']){
            $_SESSION['inputError']='el director y codirector deben ser distintos'; 
            return false; }
            //el id debe ser un nro 
            if( !filter_var( $_POST['codirector'], FILTER_VALIDATE_INT) ){
                $_SESSION['inputError']='el plazo de ejecucion debe ser un nro..';
                return false; 
            } 
            //el id debe ser un nro valido mayor a cero
            if ( $_POST['codirector'] <= 0 ){ 
                $_SESSION['inputError']='el plazo de ejecucion debe ser mayor a cero';
                return false; }
        return true;
    }

    private function asesorProfesional(){
        if (!isset($_POST['asesor_profesional'])) {$_SESSION['inputError']='ingrese un asesorProfesional'; return false; }
        if ( $_POST['asesor_profesional'] == '' ){ 
            $_SESSION['inputError']='ingrese un asesorProfesional porfavor';
            return false; } 
        return true;
    }

    
    private function alumno2(){
        //si la variable alumno2 existe revisa que sea valido
        if ( isset($_POST['id_alumno2']) && $_POST['id_alumno2'] != '' ) {
        
            //revisar que se cumpla el rol de alumno
            //revisa que user este registrado y exista
            $userBD = UserRepository::getInstance()->findUserName( $_POST['id_alumno2'] );
            if( !$userBD ){
                $_SESSION['inputError']='alumno2 no existe';
                return false; }

            //generar el usuario y roles
            $userRolesBD = UserRepository::getInstance()->getRols( $userBD->id);
            $user=new User;
            $user->generateUserBD($userBD,$userRolesBD);
            
            //revisar que este activo
            if( !$user->isActivo() ){
                $_SESSION['inputError']='alumno2 no esta registrado';
                return false; }
            //revisar que este habilitado tenga el permiso de tesina new
            if( !( $user->findPermiso('tesina_new') ) ){
                $_SESSION['inputError']='alumno2 aun no esta habilitado';
                return false; }
            return true;
        }
        return true;
    }

    private function clasificacion(){
        if (!isset($_POST['clasificacion'])) {$_SESSION['inputError']='ingrese una clasificacion'; return false; }
        if ( $_POST['clasificacion'] == '' ){ 
            $_SESSION['inputError']='ingrese un clasificacion porfavor';
            return false; } 
        return true;
    }
    private function plazo_de_ejecucion(){
        if (!isset($_POST['plazo_de_ejecucion'])) { $_SESSION['inputError']='ingrese un plazo_de_ejecucion';return false; }
        if ( $_POST['plazo_de_ejecucion'] == '' ){ 
            $_SESSION['inputError']='ingrese un plazo de ejecucion porfavor';
            return false; } 
        if( !filter_var( $_POST['plazo_de_ejecucion'], FILTER_VALIDATE_INT) ){
            $_SESSION['inputError']='el plazo de ejecucion debe ser un nro..';
            return false; 
        } 
        if ( $_POST['plazo_de_ejecucion'] <= 0 ){ 
            $_SESSION['inputError']='el plazo de ejecucion debe ser mayor a cero';
            return false; } 
        return true;
    }
    
}