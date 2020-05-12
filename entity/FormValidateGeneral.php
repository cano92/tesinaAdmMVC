<?php

class FormValidateGeneral {

    public function validateFechExp(){ 
        
        if( !$this->fechExp() ){ return false; } 

        return true;
    }

    public function validateNote(){

        if( !$this->Note() ){ return false; } 

        return true;
    }




    private function Note(){
        if (!isset($_POST['tNote'])) {$_SESSION['error']='la Nota ingresada no es valida1'; return false; }
        
        if ( $_POST['tNote'] == '' ){ 
            $_SESSION['error']='la Nota ingresada no es valida2';
            return false; } 
        
        if( !filter_var( $_POST['tNote'], FILTER_VALIDATE_INT) ){
            $_SESSION['error']='la Nota debe ser un nro..';
            return false; 
        } 
        
        if ( $_POST['tNote'] <= 0 ){ 
            $_SESSION['error']='la Nota debe ser mayor a cero';
            return false; }

        if ( $_POST['tNote'] >= 10 ){ 
            $_SESSION['error']='la Nota debe ser menor a 10';
            return false; }
        
        return true;
    }

    private function fechExp(){
        if (!isset($_POST['fechExp'])) {$_SESSION['error']='la fecha ingresada no es valida1'; return false; }
        
        if ( $_POST['fechExp'] == '' ){ 
            $_SESSION['error']='la fecha ingresada no es valida2';
            return false; } 
        
        if ( !$this->isRealDate( $_POST['fechExp'] ) ){ 
            $_SESSION['error']='la fecha ingresada no es valida3';
            return false; } 
        
        if ( $_POST['fechExp'] <= date("Y-m-d H:i:s") ){ 
            $_SESSION['error']='la fecha ingresada debe ser mayor a la actual';
            return false; } 

        return true;
    }

    //revisa que sea una cadena date valida
    private function isRealDate($date) { 
        if (false === strtotime($date)) { 
            return false;
        } 
        list($year, $month, $day) = explode('-', $date); 
        return checkdate($month, $day, $year);
    }


}