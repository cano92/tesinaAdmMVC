<?php


class InitController {
    
    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**muestra la page de inicio */
    public function home(){
        $this->cleanSession();
        $view = new InitView();
        $view->show();
    }
    
    public function registerForm(){
        $this->cleanSession();
        $view = new InitView();
        $view->showRegisterForm();
    }

    public function showError(){
        $this->cleanSession();
        $view = new InitView();
        $error="los datos ingresados no son correctos";
        $view->showError($error);
    }

    public function stop(){
        $this->cleanSession();
        $view = new InitView();
        $error="Error.. No puede ver esto";
        $view->showError($error);
    }
    public function showInfo(){
        $view = new InitView();
        $view->showInfo('El Usuario se Registro Correctamente');  
    }

    public function inputUserRegisterInvalid(){
               /**recupera datos de la session guardados */
            if ( !isset($_SESSION['userEdit']) ) {
                /** no hay ningun usuario guardado para editar error redirigir */
            }else{
                $us=$_SESSION['userEdit'];
                $view = new InitView();
                $view->inputInvalidForm($_SESSION['inputError'],$us->__GET('email'),$us->__GET('username'),
                $us->__GET('password'),$us->__GET('firstname'),$us->__GET('lastname'),$us->__GET('legajo'),$us->__GET('direction'),$us->__GET('phone'));   
            } 
    }

    public function FormEditUser(){
        /**recupera datos de la session guardados */
        if ( !isset($_SESSION['userEdit']) ) {
            /** no hay ningun usuario guardado para editar error redirigir */
        }else{
            $us=$_SESSION['userEdit'];
            $view = new InitView();
            $view->showRegisterFormEdit('el usuario ya existe',$us->__GET('email'),$us->__GET('username'),
            $us->__GET('password'),$us->__GET('firstname'),$us->__GET('lastname'),$us->__GET('legajo'),$us->__GET('direction'),$us->__GET('phone'));   
        }    
    }

    public function registerUser(){
        //valida datos caso contrario vuelve al formulario..
        $validator = new UserValidateInput();
        if( $validator->validateUser() ){ 
            $user = UserRepository::getInstance()->findUserName($_POST['username']);
            if($user){ //el usuario ya existe, se guarda los datos para mostrar el form
                $this->saveInfoUser( $this->generateUser($_POST['mail'],$_POST['username'],$_POST['pass'],$_POST['firstname'],$_POST['lastname'],$_POST['leg'],$_POST['dir'],$_POST['tel']) );
                header('Location:?action=FormEditUser'); 
            }else{//el nombre de usuario esta disponible, se registra al usuario
                UserRepository::getInstance()->registerUser($_POST['mail'],$_POST['username'],$_POST['pass'],
                $_POST['firstname'],$_POST['lastname'],$_POST['leg'],$_POST['dir'],$_POST['tel'],true);
                header('Location:?action=success');   
            }
        }else{//fallo la validacion
            $this->saveInfoUser( $this->generateUser($_POST['mail'],$_POST['username'],$_POST['pass'],$_POST['firstname'],$_POST['lastname'],$_POST['leg'],$_POST['dir'],$_POST['tel']) );
            header('Location:?action=inputUserRegisterInvalid'); 
        }
    }

    public function buscador(){
        $view = new InitView();
        $view->showBuscador();
    }

    private function cleanSession(){
        if (isset($_SESSION['user'])) {
            unset( $_SESSION['user'] );
        }
        session_destroy();
    }

    private function saveInfoUser($userEdit){
        if(!isset($_SESSION)) { 
            session_start(); 
        }
        $_SESSION['userEdit'] = $userEdit;
    }

    private function generateUser($email,$username,$pass,$firstname,$lastname,$leg,$dir,$tel){
        $user = new User();
        $user->__SET('email', $email);
        $user->__SET('username', $username);
        $user->__SET('password', $pass);
        $user->__SET('firstname', $firstname);
        $user->__SET('lastname', $lastname);
        $user->__SET('legajo', $leg);
        $user->__SET('direction', $dir);
        $user->__SET('phone', $tel);
        return $user;
    }



}
