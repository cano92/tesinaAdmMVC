<?php

class FormEvaluathorsValidateInput {

    public function validateFormulario(){ 
        if( !$this->evaluador1() ){ return false; }
        if( !$this->evaluador2() ){ return false; }
        if( !$this->evaluador3() ){ return false; }
        if( !$this->evaluador4() ){ return false; }
        
        return true;
    }

    private function evaluador1(){
        if (!isset($_POST['evaluador1'])) { $_SESSION['error']='ingrese evaluador1'; return false; }
        
        if ( $_POST['evaluador1'] == '' ){ 
            $_SESSION['error']='evaluador1 no es valido'; 
            return false; }
        
        if ( $_POST['evaluador1'] == $_POST['evaluador2'] ){ 
            $_SESSION['error']='evaluador2 esta repetido'; 
            return false; }

        if ( $_POST['evaluador1'] == $_POST['evaluador3'] ){ 
            $_SESSION['error']='evaluador3 esta repetido'; 
            return false; }

        if ( $_POST['evaluador1'] == $_POST['evaluador4'] ){ 
            $_SESSION['error']='evaluador4 esta repetido'; 
            return false; }

        return true;
    }
    
    private function evaluador2(){
        if (!isset($_POST['evaluador2'])) { $_SESSION['error']='ingrese evaluador2'; return false; }
        
        if ( $_POST['evaluador2'] == '' ){ 
            $_SESSION['error']='evaluador2 no es valido'; 
            return false; }
        
        if ( $_POST['evaluador2'] == $_POST['evaluador1'] ){ 
            $_SESSION['error']='evaluador1 esta repetido'; 
            return false; }

        if ( $_POST['evaluador2'] == $_POST['evaluador3'] ){ 
            $_SESSION['error']='evaluador3 esta repetido'; 
            return false; }

        if ( $_POST['evaluador2'] == $_POST['evaluador4'] ){ 
            $_SESSION['error']='evaluador4 esta repetido'; 
            return false; }

        return true;
    }

    private function evaluador3(){
        if (!isset($_POST['evaluador3'])) { $_SESSION['error']='ingrese evaluador3'; return false; }
        
        if ( $_POST['evaluador3'] == '' ){ 
            $_SESSION['error']='evaluador3 no es valido'; 
            return false; }
        
        if ( $_POST['evaluador3'] == $_POST['evaluador1'] ){ 
            $_SESSION['error']='evaluador1 esta repetido'; 
            return false; }

        if ( $_POST['evaluador3'] == $_POST['evaluador2'] ){ 
            $_SESSION['error']='evaluador2 esta repetido'; 
            return false; }

        if ( $_POST['evaluador3'] == $_POST['evaluador4'] ){ 
            $_SESSION['error']='evaluador4 esta repetido'; 
            return false; }

        return true;
    }

    private function evaluador4(){
        if (!isset($_POST['evaluador4'])) { $_SESSION['error']='ingrese evaluador4'; return false; }
        
        if ( $_POST['evaluador4'] == '' ){ 
            $_SESSION['error']='evaluador4 no es valido'; 
            return false; }
        
        if ( $_POST['evaluador4'] == $_POST['evaluador1'] ){ 
            $_SESSION['error']='evaluador1 esta repetido'; 
            return false; }

        if ( $_POST['evaluador4'] == $_POST['evaluador2'] ){ 
            $_SESSION['error']='evaluador2 esta repetido'; 
            return false; }

        if ( $_POST['evaluador4'] == $_POST['evaluador3'] ){ 
            $_SESSION['error']='evaluador3 esta repetido'; 
            return false; }

        return true;
    }
    

}