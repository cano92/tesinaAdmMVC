<?php


class UserView extends TwigView {
    
    /**el usuario logueado */
    public function home($user,$error) {
        
        echo self::getTwig()->render('home.html.twig',array('user' => $user,'error' => $error));
    }

    public function info($user) {
        echo self::getTwig()->render('info.html.twig',array('user' => $user ) );
    }

    public function allUsers($user,$colUsers,$info) {
        echo self::getTwig()->render('listUser.html.twig',array('user' => $user,'colUsers' => $colUsers,'info' => $info));
    }

    public function allAlumnos($user,$colUsers,$info){
        echo self::getTwig()->render('listAlumnos.html.twig',array('user' => $user,'colUsers' => $colUsers,'info' => $info));      
    }
    
    public function showUserFormEdit($error,$id,$mail,$username,$pass,$firstname,$lastname,$leg,$dir,$tel,$user) {
        echo self::getTwig()->render('userForm.html.twig',array('errorUserName'=>$error,'id'=>$id,'mail'=>$mail,'username'=>$username,
        'pass'=>$pass,'firstname'=>$firstname,'lastname'=>$lastname,'leg'=>$leg,'dir'=>$dir,'tel'=>$tel,'user' => $user ) );
    }

    public function showUserFormEditInputError($error,$id,$mail,$username,$pass,$firstname,$lastname,$leg,$dir,$tel,$user) {
        echo self::getTwig()->render('userForm.html.twig',array('error'=>$error,'id'=>$id,'mail'=>$mail,'username'=>$username,
        'pass'=>$pass,'firstname'=>$firstname,'lastname'=>$lastname,'leg'=>$leg,'dir'=>$dir,'tel'=>$tel,'user' => $user ) );
    }

    public function showBuscador($user){
        echo self::getTwig()->render('buscador.html.twig',array('user' => $user ) );
    }

}