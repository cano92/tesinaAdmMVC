<?php

/**
 * Description of SimpleResourceList
 *
 * @author fede
 */


class InitView extends TwigView {
    
    /** */
    public function show() {
        echo self::getTwig()->render('login.html.twig');
    }

    public function showError($error) {
        echo self::getTwig()->render('login.html.twig',array('error'=>$error) );
    }

    public function showInfo($info) {
        echo self::getTwig()->render('login.html.twig',array('info'=>$info) );
    }

    public function showRegisterForm() {
        echo self::getTwig()->render('registerForm.html.twig');
    }

    public function showRegisterFormEdit($error,$mail,$username,$pass,$firstname,$lastname,$leg,$dir,$tel) {
        echo self::getTwig()->render('registerForm.html.twig',array('errorUserName'=>$error,'mail'=>$mail,'username'=>$username,
        'pass'=>$pass,'firstname'=>$firstname,'lastname'=>$lastname,'leg'=>$leg,'dir'=>$dir,'tel'=>$tel ) );
    }

    public function inputInvalidForm($error,$mail,$username,$pass,$firstname,$lastname,$leg,$dir,$tel) {
        echo self::getTwig()->render('registerForm.html.twig',array('error'=>$error,'mail'=>$mail,'username'=>$username,
        'pass'=>$pass,'firstname'=>$firstname,'lastname'=>$lastname,'leg'=>$leg,'dir'=>$dir,'tel'=>$tel ) );
    }

    public function showBuscador(){
        echo self::getTwig()->render('buscador.html.twig');
    }

}
