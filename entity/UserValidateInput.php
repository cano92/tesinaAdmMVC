<?php

class UserValidateInput {

    public function validateUser(){ 
        //controla los campos obligatorios 
        if( !$this->validateMail() ){ return false; } 
        if( !$this->validateUsername() ){ return false; }
        if( !$this->validatePass() ){ return false; }
        return true;
    }

    private function validateUsername(){
        if (!isset($_POST['username'])) { $_SESSION['inputError']='ingrese un nombre de usuario porfavor';  return false; }
        if ( $_POST['username'] == '' ){ 
            $_SESSION['inputError']='ingrese un nombre de usuario porfavor'; 
            return false; } 
        return true;
    }

    private function validatePass(){
        if (!isset($_POST['pass'])) { $_SESSION['inputError']='ingrese un mail porfavor';  return false; }
        if ( $_POST['pass'] == '' ){
            $_SESSION['inputError']='ingrese un mail porfavor'; 
            return false; }
        if( strlen($_POST['pass']) <= 3 ){ 
            $_SESSION['inputError']='el password debe tener mas de 3 caracteres';
            return false; }
        return true;
    }

    private function validateMail(){
        if (!isset($_POST['mail'])) { $_SESSION['inputError']='ingrese un mail porfavor'; return false; }
        if ( $_POST['mail'] == '' ){ 
            $_SESSION['inputError']='ingrese un mail porfavor';
            return false; } 
        //valida estructura mail
        if( !filter_var( $_POST['mail'], FILTER_VALIDATE_EMAIL ) ){ 
            $_SESSION['inputError']='la forma del mail es invalida debe ser.. alguien@mail.com'; 
            return false; }
        return true;
    }

}