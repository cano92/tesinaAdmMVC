<?php

class User {
    
    private $id;
    private $email;
    private $username;
    private $password;
    private $firstname;
    private $lastname;
    private $legajo;
    private $direction;
    private $phone;
    private $activo;
    private $tesinaAlerts;

    private $roles=array();
    private $permisos=array();

    public function __construct(){
    }

    public function __GET($k){ return $this->$k; }
	public function __SET($k, $v){ return $this->$k = $v; }

    
    private function find($collection,$find){
        $resul=false;
        foreach($collection as $actual){
            if($actual == $find ){ return true; };
        }
        return $resul;        
    }

    /**busca un rol en sus roles */    
    public function findRol($rol){
        return $this->find($this->__GET('roles'),$rol);
    }
    
    /**busca un permiso en sus permisos falta hacer */
    public function findPermiso($perm){
        return $this->find($this->__GET('permisos'),$perm);
    }

    public function isActivo(){
        if($this->__GET('activo')== 1 ){
            return true;
        }
        return false;
    }

    public function contarAlertasTesinas($colTesis){
        //suma la cantidad de alertas
        $this->__SET('tesinaAlerts',0);
        foreach( $colTesis as $tesis){
            if($tesis->leido){
                $this->tesinaAlertMas();
            }
        }
     }

     public function tesinaAlertMas(){
        $this->tesinaAlerts++;
     }

     public function tesinaAlertMenos(){
        $this->tesinaAlerts--;
    } 

    public function generateUserEdit($id,$email,$username,$pass,$firstname,$lastname,$legajo,$direction,$phone){
        
        $this->__SET('id', $id);
        $this->__SET('email', $email);
        $this->__SET('username', $username);
        $this->__SET('password', $pass);
        $this->__SET('firstname', $firstname);
        $this->__SET('lastname', $lastname);
        $this->__SET('legajo', $legajo);
        $this->__SET('direction', $direction);
        $this->__SET('phone', $phone);
       
    }

    public function generateUserBD($aUser,$roles){

        $this->__SET('id', $aUser->id);
        $this->__SET('email', $aUser->email);
        $this->__SET('username', $aUser->username);
        $this->__SET('password', $aUser->pass);
        $this->__SET('firstname', $aUser->firstname);
        $this->__SET('lastname', $aUser->lastname);
        $this->__SET('legajo', $aUser->legajo);
        $this->__SET('direction', $aUser->direction);
        $this->__SET('phone', $aUser->phone);
        $this->__SET('activo', $aUser->activo);
       
        $this->__SET('roles', $this->generateRoles($roles) );
        $this->__SET('permisos', $this->generatePermisos($roles) );

    }

    private function generatePermisos($colRoles ){
        $resul=array();  $i=0;
        foreach( $colRoles as $rol){
            $permisos = UserRepository::getInstance()->getPermits( $rol->id );
            foreach($permisos as $perm){
                $resul[$i]=$perm->nombre;
                $i++;
            }
        }
        return $resul;
    }
    private function generateRoles($colRoles ){
        $resul=array();  $i=0;
        foreach( $colRoles as $rol){
            $resul[$i]=$rol->nombre;
            $i++;
        }
        return $resul;
    }
    
}