<?php


class UserController {
    
    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function info(){
        if (isset($_SESSION['user'])) {
            $colTesis=TesisRepository::getInstance()->myTesis( $_SESSION['user']->id );
            //si alguna tesis fue modificada mostrar 
            $_SESSION['user']->contarAlertasTesinas($colTesis);
            $view = new UserView();
            $view->info($_SESSION['user'] );
        }else{  header('Location:?action=stop'); }
    }

    public function successEnableUser(){
        if (isset($_SESSION['user'])) {
            if( $_SESSION['user']->findPermiso('usuario_index') || $_SESSION['user']->findPermiso('all') ){
                $allUser = UserRepository::getInstance()->allUsers();        
                $userList=$this->setUsersRoles($allUser);
                $view = new UserView();
                $view->allUsers($_SESSION['user'],$userList,'El usuario se Habilito correctamente');
            }else {  header('Location:?action=homeStop');  }
        }else{  header('Location:?action=stop'); }
    }

    public function successDisableUser(){
        if (isset($_SESSION['user'])) {
            if( $_SESSION['user']->findPermiso('usuario_index') || $_SESSION['user']->findPermiso('all') ){
                /**debe direccionar a lista de usuarios */
                $allUser = UserRepository::getInstance()->allUsers();        
                $userList=$this->setUsersRoles($allUser);
                $view = new UserView();
                $view->allUsers($_SESSION['user'],$userList,'El usuario se Elimino correctamente');
            }else {  header('Location:?action=homeStop');  }
        }else{  header('Location:?action=stop'); }
    }

    public function successDisableAlumno(){
        if (isset($_SESSION['user'])) {
            if( $_SESSION['user']->findPermiso('usuario_accept') || $_SESSION['user']->findPermiso('all') ){
                $allUser = UserRepository::getInstance()->allUsers(); 
                $userList=$this->setUsersRoles($allUser);
                $view = new UserView();
                $view->allAlumnos($_SESSION['user'],$userList,'El alumno fue Des-habilitado');
            }else {  header('Location:?action=homeStop');  }
        }else{  header('Location:?action=stop'); }
    } 
    public function successEnableAlumno(){
        if (isset($_SESSION['user'])) {
            if( $_SESSION['user']->findPermiso('usuario_accept') || $_SESSION['user']->findPermiso('all') ){
                $allUser = UserRepository::getInstance()->allUsers();        
                $userList=$this->setUsersRoles($allUser);
                $view = new UserView();
                $view->allAlumnos($_SESSION['user'],$userList,'El alumno fue habilitado');
            }else {  header('Location:?action=homeStop');  }
        }else{  header('Location:?action=stop'); }
    }

    public function successEdit(){
        if (isset($_SESSION['user'])) {
            if( $_SESSION['user']->findPermiso('usuario_update') || $_SESSION['user']->findPermiso('all') ){
                $allUser = UserRepository::getInstance()->allUsers();        
                $userList=$this->setUsersRoles($allUser);
                $view = new UserView();

                $view->allUsers($_SESSION['user'],$userList,'Se Modifico el usuario correctamente');
            }else {  header('Location:?action=homeStop');  }
        }else{  header('Location:?action=stop'); }
    }


    /**>>>>>>>>>>>>>>>>>>>>>  funciones   <<<<<<<<<<<<<<<<<<<<<< */
    public function allUsers(){
        if (isset($_SESSION['user'])) {
            if( $_SESSION['user']->findPermiso('usuario_index') || $_SESSION['user']->findPermiso('all') ){
                $allUser = UserRepository::getInstance()->allUsers();        
                $userList=$this->setUsersRoles($allUser);
                $view = new UserView();
                
                $view->allUsers($_SESSION['user'],$userList,'');   
            }else {  header('Location:?action=homeStop');  }
        }else{   header('Location:?action=stop'); }
    }
    public function allAlumnos(){
        if (isset($_SESSION['user'])) {
            if( $_SESSION['user']->findPermiso('usuario_accept') || $_SESSION['user']->findPermiso('all') ){
                $allUser = UserRepository::getInstance()->allUsers();        
                $userList=$this->setUsersRoles($allUser);
                $view = new UserView();
                
                $view->allAlumnos($_SESSION['user'],$userList,''); 
            }else { header('Location:?action=homeStop');  }   
        }else{  header('Location:?action=stop'); }
    }
    
    public function editFormUser(){
        /**revisa que el usuario a editar exista y los permisos de session sino redirecciona */
        if (isset($_SESSION['user'])) {
            if( $_SESSION['user']->findPermiso('usuario_update') || $_SESSION['user']->findPermiso('all') ){
                if ( !isset($_SESSION['userEdit']) ) {
                    /** no hay ningun usuario guardado para editar error redirigir */
                    header('Location:?action=homeStop');
                }else{
                    //si alguna tesis fue modificada mostrar 
                    $_SESSION['user']->contarAlertasTesinas(TesisRepository::getInstance()->myTesis( $_SESSION['user']->id ));
                    $us=$_SESSION['userEdit'];
                    $view = new UserView();
                    $view->showUserFormEdit('',$us->__GET('id'),$us->__GET('email'),$us->__GET('username'),
                    $us->__GET('password'),$us->__GET('firstname'),$us->__GET('lastname'),$us->__GET('legajo'),$us->__GET('direction'),$us->__GET('phone'),$_SESSION['user']);   
                }
            }else { header('Location:?action=homeStop');  }   
        }else{  header('Location:?action=stop'); } 
    }

    public function editFormUserError(){
        if (isset($_SESSION['user'])) {
            if( $_SESSION['user']->findPermiso('usuario_update') || $_SESSION['user']->findPermiso('all') ){
                /**revisa que el usuario a editar exista y los permisos de session sino redirecciona */
                if ( !isset($_SESSION['userEdit']) ) {
                    header('Location:?action=homeStop');
                }else{
                    $us=$_SESSION['userEdit'];
                    $view = new UserView();
                    $error="el nuevo nombre de usuario NO es Valido, ya esta en uso";
                    $view->showUserFormEdit($error,$us->__GET('id'),$us->__GET('email'),$us->__GET('username'),
                    $us->__GET('password'),$us->__GET('firstname'),$us->__GET('lastname'),$us->__GET('legajo'),$us->__GET('direction'),$us->__GET('phone'),$_SESSION['user']);   
                } 
            }else { header('Location:?action=homeStop');  }   
        }else{  header('Location:?action=stop'); }         
    }

    public function editFormUserErrorInput(){
        if (isset($_SESSION['user'])) {
            if( $_SESSION['user']->findPermiso('usuario_update') || $_SESSION['user']->findPermiso('all') ){
                /**revisa que el usuario a editar exista y los permisos de session sino redirecciona */
                if ( !isset($_SESSION['userEdit']) ) { 
                    header('Location:?action=homeStop');
                }else{
                    $us=$_SESSION['userEdit'];
                    $view = new UserView();
                    
                    $view->showUserFormEditInputError($_SESSION['inputError'],$us->__GET('id'),$us->__GET('email'),$us->__GET('username'),
                    $us->__GET('password'),$us->__GET('firstname'),$us->__GET('lastname'),$us->__GET('legajo'),$us->__GET('direction'),$us->__GET('phone'),$_SESSION['user']);   
                } 
            }else { header('Location:?action=homeStop');  }   
        }else{  header('Location:?action=stop'); }         
    }

    public function editUserId(){
        if ( isset($_SESSION['user']) ) {
            if( $_SESSION['user']->findPermiso('usuario_update') || $_SESSION['user']->findPermiso('all') ){
                $user = UserRepository::getInstance()->findUserId($_POST['id'] );
                $userEdit=$this->generateUserEdit($user->id,$user->email,$user->username,$user->pass,
                $user->firstname,$user->lastname,$user->legajo,$user->direction,$user->phone);
                $_SESSION['userEdit'] = $userEdit;
                header('Location:?action=editFormUser');
            }else { header('Location:?action=homeStop');  } 
        }else{  header('Location:?action=stop'); }
    }

    /**hablita un usuario como alumno, un alumno puede subir tesinas */
    public function enableUserAlumno(){
        if ( isset($_SESSION['user']) ) {
            if( $_SESSION['user']->findPermiso('usuario_accept') || $_SESSION['user']->findPermiso('all') ){
                /**asumo que el rol alumno existe y que tiene el permismo tesina_new */
                $rolAlumno=RolRepository::getInstance()->findRolName('alumno');
                UsuarioTieneRolRepository::getInstance()->darRol($_POST['id'],$rolAlumno->id); 
                
                header('Location:?action=successEnableAlumno');
            }else { header('Location:?action=homeStop');  }  
        }else{  header('Location:?action=stop'); }
    }
    public function desableUserAlumno(){
        if ( isset($_SESSION['user']) ) {
            if( $_SESSION['user']->findPermiso('usuario_accept') || $_SESSION['user']->findPermiso('all') ){
                UsuarioTieneRolRepository::getInstance()->QuitarRol($_POST['id'],3);
                header('Location:?action=successDisableAlumno'); 
                /**debe redireccionar a lista alumnos */
            }else { header('Location:?action=homeStop');  }  
        }else{  header('Location:?action=stop'); }
    }

    /**habilita un usuario */
    public function enableUser(){
        if ( isset($_SESSION['user']) ) {
            if( $_SESSION['user']->findPermiso('usuario_new') || $_SESSION['user']->findPermiso('all') ){
                UserRepository::getInstance()->disEnableUser($_POST['id'],1);
                header('Location:?action=successEnableUser');
            }else { header('Location:?action=homeStop');  }  
        }else{  header('Location:?action=stop'); }
    }
    /**desabilita un usuario */
    public function disableUser(){
        if ( isset($_SESSION['user']) ) {
            if( $_SESSION['user']->findPermiso('usuario_destroy') || $_SESSION['user']->findPermiso('all') ){
                UserRepository::getInstance()->disEnableUser($_POST['id'],0);
                header('Location:?action=successDisableUser');
            }else { header('Location:?action=homeStop');  }  
        }else{  header('Location:?action=stop'); }
    }
    public function logout() {
        //elimina la variable usuario de la session
        if(isset($_SESSION)) {  
            //preguntar si hay un session user 
            unset( $_SESSION['user'] );
            session_destroy();
            header('Location:?');
        }
    }

    public function login(){
        /**busca al usurio en model */
        $user = UserRepository::getInstance()->getUser($_POST['name'],$_POST['password']);
        if($user){ /** recuperar las lista de roles y permisos  */
            $userRoles = UserRepository::getInstance()->getRols( $user->id);
            $userFinal = $this->generateUser($user,$userRoles);
            if($userFinal->isActivo()){ 
                $this->registerSessionUser($userFinal);
                header('Location:?action=home');
            }else{header('Location:?action=showError');  }
        }else{  header('Location:?action=showError'); } 
    }   
    
    public function updateUser(){
        if ( isset($_SESSION['user']) ) {
            if( $_SESSION['user']->findPermiso('usuario_update') || $_SESSION['user']->findPermiso('all') ){
            
            $validator = new UserValidateInput();
            if( $validator->validateUser() ){ //valida los datos ingresados
                if( ($_POST['username'] == $_SESSION['user']->__GET('username') && $_POST['id'] == $_SESSION['user']->__GET('id') ) || $_SESSION['user']->findPermiso('all') ){
                    $this->saveUserEdit();
                }else{ //pregunto si el nuevo nombre de usuario no esta usado
                    $user = UserRepository::getInstance()->findUserName($_POST['username']);
                    if( $user ){//el nuevo nombre de usuario NO ES VALIDO volver a editar 
                        $userEdit=$this->generateUserEdit($_POST['id'],$_POST['mail'],$_POST['username'],$_POST['pass'],$_POST['firstname'],$_POST['lastname'],$_POST['leg'],$_POST['dir'],$_POST['tel']);
                        $_SESSION['userEdit'] = $userEdit;
                        header('Location:?action=editFormUserError');
                    }else{ /**el nuevo de usuario es valido actualiza BD */
                        $this->saveUserEdit();
                    }
                }
            }else{//fallo la validacion
                $userEdit=$this->generateUserEdit($_POST['id'],$_POST['mail'],$_POST['username'],$_POST['pass'],$_POST['firstname'],$_POST['lastname'],$_POST['leg'],$_POST['dir'],$_POST['tel']);
                $_SESSION['userEdit'] = $userEdit;
                header('Location:?action=editFormUserErrorInput');
            }
            }else { header('Location:?action=homeStop');  }  
        }else{  header('Location:?action=stop'); }

    }

    public function buscadorLog(){
        if ( isset($_SESSION['user']) ) { 
            $colTesis=TesisRepository::getInstance()->myTesis( $_SESSION['user']->id );
            //si alguna tesis fue modificada mostrar 
            $_SESSION['user']->contarAlertasTesinas($colTesis);           
            $view = new UserView();
            $view->showBuscador($_SESSION['user']);
        }else{  header('Location:?action=stop'); }
    }

/**>>>>>>>>>>>>>>   funciones ayudantes privadas   <<<<<<<<<<<<<<*/

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
        /**genera el usuario para guardar en la session */
        private function generateUserEdit($id,$email,$username,$pass,$firstname,$lastname,$legajo,$direction,$phone){
            $user = new User();
            $user->__SET('id', $id);
            $user->__SET('email', $email);
            $user->__SET('username', $username);
            $user->__SET('password', $pass);
            $user->__SET('firstname', $firstname);
            $user->__SET('lastname', $lastname);
            $user->__SET('legajo', $legajo);
            $user->__SET('direction', $direction);
            $user->__SET('phone', $phone);
            return $user;
        }

        private function generateUser($aUser,$roles){
            $user = new User();
            $user->__SET('id', $aUser->id);
            $user->__SET('email', $aUser->email);
            $user->__SET('username', $aUser->username);
            $user->__SET('password', $aUser->pass);
            $user->__SET('firstname', $aUser->firstname);
            $user->__SET('lastname', $aUser->lastname);
            $user->__SET('legajo', $aUser->legajo);
            $user->__SET('direction', $aUser->direction);
            $user->__SET('phone', $aUser->phone);
            $user->__SET('activo', $aUser->activo);
           
            $user->__SET('roles', $this->generateRoles($roles) );
            $user->__SET('permisos', $this->generatePermisos($roles) );
    
            return $user;
        }
        private function registerSessionUser($user){
            if (!isset($_SESSION['user'])) {
                $_SESSION['user'] = $user;
              }
        }
        private function setUsersRoles($allUser){
            $resul=array();  $i=0;   
            foreach($allUser as $user){
                $userRoles = UserRepository::getInstance()->getRols( $user->id);
                $userFinal = $this->generateUser($user,$userRoles);
    
                $resul[$i]=$userFinal;
                $i++;
            }
            return $resul;
        }

        //busca si el nombre de usuario esta disponible
        private function validateUserNameEdit(){
            $user = UserRepository::getInstance()->findUserName($_POST['username']);
            if( $user ){//el nuevo nombre de usuario NO ES VALIDO volver a editar 
                $userEdit=$this->generateUserEdit($_POST['id'],$_POST['mail'],$_POST['username'],$_POST['pass'],
                $_POST['firstname'],$_POST['lastname'],$_POST['leg'],$_POST['dir'],$_POST['tel']);
                
                $_SESSION['userEdit'] = $userEdit;
                header('Location:?action=editFormUserError');
            }else{ /**el nuevo de usuario es valido actualiza BD */
                $this->saveUserEdit();
            }
        }

        private function saveUserEdit(){

            UserRepository::getInstance()->update($_POST['mail'],$_POST['username'],
            $_POST['pass'],$_POST['firstname'],$_POST['lastname'],$_POST['leg'],$_POST['dir'],$_POST['tel'],$_POST['id'] );
            /**una vez editados los datos elimina los temporales de la session*/
            unset( $_SESSION['userEdit'] );
            header('Location:?action=successEdit');
        }

  


}

