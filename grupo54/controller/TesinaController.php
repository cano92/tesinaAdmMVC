<?php


class TesinaController {
    
    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function home(){
        if (isset($_SESSION['user'])) {
            $colTesis=TesisRepository::getInstance()->myTesis( $_SESSION['user']->id );
            //si alguna tesis fue modificada mostrar 
            $_SESSION['user']->contarAlertasTesinas($colTesis);
            $view = new UserView();
            $view->home($_SESSION['user'],'');
        
        }else{  header('Location:?action=stop'); }
    }
    public function homeStop(){
        if (isset($_SESSION['user'])) {
            $colTesis=TesisRepository::getInstance()->myTesis( $_SESSION['user']->id );
            //si alguna tesis fue modificada mostrar 
            $_SESSION['user']->contarAlertasTesinas($colTesis);
            $view = new UserView();
            $view->home($_SESSION['user'],'No tiene Permisos para esa accion');
        
        }else{  header('Location:?action=stop'); }
    }

    public function reportesEstado(){
        if (isset($_SESSION['user'])) {
            if( $_SESSION['user']->findPermiso('tesina_validate') || $_SESSION['user']->findPermiso('all') ){ 
                $result=new TesinasEstadoHC;
                //recuperar las tesinas por estado cantidades
                $propuestaIncial = TesisRepository::getInstance()->getTesisStateSize("propuesta incial");
                $result->__SET('propuestaIncial',$propuestaIncial);
                $tesinaInicial = TesisRepository::getInstance()->getTesisStateSize("tesina inicial");
                $result->__SET('tesinaInicial',$tesinaInicial);
                $infAvanceEntregado = TesisRepository::getInstance()->getTesisStateSize("infAvance entregado");
                $result->__SET('infAvanceEntregado',$infAvanceEntregado);
                $paraExponer = TesisRepository::getInstance()->getTesisStateSize("para exponer");
                $result->__SET('paraExponer',$paraExponer);
                $tesinaFinalizada = TesisRepository::getInstance()->getTesisStateSize("tesina finalizada");
                $result->__SET('tesinaFinalizada',$tesinaFinalizada);
                $tesinaCancelada = TesisRepository::getInstance()->getTesisStateSize("tesina cancelada");
                $result->__SET('tesinaCancelada',$tesinaCancelada);
                
                $view = new TesinatView();
                $view->showResportesEstado($_SESSION['user'],$result);
            }else {  header('Location:?action=homeStop');  }
        }else{  header('Location:?action=stop'); }
        
    }

    public function reportesNotas(){
        if (isset($_SESSION['user'])) {
            if( $_SESSION['user']->findPermiso('tesina_validate') || $_SESSION['user']->findPermiso('all') ){ 
                $result=new TesinasNotasHC;

                $nota1= TesisRepository::getInstance()->getTesisNotaSize(1);
                $result->__SET('nota1',$nota1);
                $nota2= TesisRepository::getInstance()->getTesisNotaSize(2);
                $result->__SET('nota2',$nota2);
                $nota3= TesisRepository::getInstance()->getTesisNotaSize(3);
                $result->__SET('nota3',$nota3);
                $nota4= TesisRepository::getInstance()->getTesisNotaSize(4);
                $result->__SET('nota4',$nota4);
                $nota5= TesisRepository::getInstance()->getTesisNotaSize(5);
                $result->__SET('nota5',$nota5);
                $nota6= TesisRepository::getInstance()->getTesisNotaSize(6);
                $result->__SET('nota6',$nota6);
                $nota7= TesisRepository::getInstance()->getTesisNotaSize(7);
                $result->__SET('nota7',$nota7);
                $nota8= TesisRepository::getInstance()->getTesisNotaSize(8);
                $result->__SET('nota8',$nota8);
                $nota9= TesisRepository::getInstance()->getTesisNotaSize(9);
                $result->__SET('nota9',$nota9);
                $nota10= TesisRepository::getInstance()->getTesisNotaSize(10);
                $result->__SET('nota10',$nota10);

                $view = new TesinatView();
                $view->showResportesNotas($_SESSION['user'],$result);
            }else {  header('Location:?action=homeStop');  }
        }else{  header('Location:?action=stop'); }
    }

    public function reportesDirectores(){
        if (isset($_SESSION['user'])) {
            if( $_SESSION['user']->findPermiso('tesina_validate') || $_SESSION['user']->findPermiso('all') ){ 
                $result="";
                //recuperar todos los directores de los form1 filtrando repetidos

                //cantidad de form1 en los que esta porque cada form1 tiene una tesina asociada

                $view = new TesinatView();
                $view->showResportesDirectores($_SESSION['user'],$result);
            }else {  header('Location:?action=homeStop');  }
        }else{  header('Location:?action=stop'); }
    }

    public function inicialTesinas(){
        if (isset($_SESSION['user'])) {
            if( $_SESSION['user']->findPermiso('tesina_validate') || $_SESSION['user']->findPermiso('all') ){ 
                //recuperar las tesinas propuestas incial sin calificar

                $colTesis = TesisRepository::getInstance()->getPropuestasInicialRevision(); 
                $colAuthors=$this->generateListAuthor($colTesis);       
                $view = new TesinatView();
                $view->showPendienTesinas($_SESSION['user'],$colTesis,$colAuthors,'','');
            }else {  header('Location:?action=homeStop');  }
        }else{  header('Location:?action=stop'); }
    }

    public function succesForm1Edit(){
        if (isset($_SESSION['user'])) {
            if( $_SESSION['user']->findPermiso('tesina_update') || $_SESSION['user']->findPermiso('all') ){ 
                //mostrar que el formulario1 se edito correctamente
                $form1=TesisRepository::getInstance()->findForm1($_SESSION['user']->__GET('id'));
                $view = new TesinatView();
                $view->form1Editsucces( $_SESSION['user'],$form1->id,'Formulario 1 editado');
            }else {  header('Location:?action=homeStop');  }
        }else{  header('Location:?action=stop'); }
    }

    public function showTesinasCorregida(){
        if (isset($_SESSION['user'])) {
            if( $_SESSION['user']->findPermiso('tesina_validate') || $_SESSION['user']->findPermiso('all') ){ 
                $colTesis = TesisRepository::getInstance()->getPropuestasInicialRevision(); 
                $colAuthors=$this->generateListAuthor($colTesis);       
                $view = new TesinatView();
                $view->showPendienTesinas($_SESSION['user'],$colTesis,$colAuthors,'','la Tesina fue corregida..');
            }else {  header('Location:?action=homeStop');  }
        }else{  header('Location:?action=stop'); }
    }

    public function allTesinas(){
        if (isset($_SESSION['user'])) {
            if( $_SESSION['user']->findPermiso('tesina_index') || $_SESSION['user']->findPermiso('all') ){
                $allTesis = TesisRepository::getInstance()->getAllTesis();        
                $view = new TesinatView();
                //recuperar los autores de las tesis
                $listauthor=$this->generateListAuthor($allTesis);
                
               // print_r($listauthor);
                $view->allTesinas($_SESSION['user'],$allTesis,$listauthor);
            }else {  header('Location:?action=homeStop');  }
        }else{  header('Location:?action=stop'); }
    }

    public function tesinasFinalizadas(){
        if (isset($_SESSION['user'])) {
            if( $_SESSION['user']->findPermiso('tesina_validate') || $_SESSION['user']->findPermiso('all') ){
                $allTesis = TesisRepository::getInstance()->getTesisState('tesina finalizada');

                $view = new TesinatView();
                //recuperar los autores de las tesis
                $listauthor=$this->generateListAuthor($allTesis);
                
               // print_r($listauthor);
                $view->allTesinas($_SESSION['user'],$allTesis,$listauthor);
            }else {  header('Location:?action=homeStop');  }
        }else{  header('Location:?action=stop'); }
    }
    
 
    /**registrar tesina y mostrar nuevo tesina debe estar aqui */
    public function registerTesina(){
        if ( isset($_SESSION['user']) ) {
            if( $_SESSION['user']->findPermiso('tesina_new') || $_SESSION['user']->findPermiso('all') ){
                //recupera formulario1 activo
                $form1=TesisRepository::getInstance()->findForm1($_SESSION['user']->__GET('id'));
               
                //guarda la nueva tesina
                TesisRepository::getInstance()->registerTesis($_POST['titulo'],date("Y-m-d H:i:s"),$_POST['objetivo'],$_POST['motivacion'],
                $_POST['desarrolloPropuestos'],$_POST['resultadosEsperados'],$form1->id,0,'propuesta incial','en espera',1);
                
                
                //desactiva el formulario1 para que otro formulario1 y otra tesina puedan ser subido
                TesisRepository::getInstance()->desableForm1($form1->id,0);


                header('Location:?action=newTesinaSuccess');
            }else { header('Location:?action=homeStop');  }   
        }else{  header('Location:?action=stop'); }
    }

    public function updateTesina(){
        if ( isset($_SESSION['user']) ) {
            if( $_SESSION['user']->findPermiso('tesina_update') || $_SESSION['user']->findPermiso('all') ){                
                //recupera la tesis actual
                $tesisActual=TesisRepository::getInstance()->findTesisId( $_POST['tesisId'] );
                //guarda la nueva tesis
                TesisRepository::getInstance()->registerTesis($_POST['titulo'],$tesisActual->fecha,$_POST['objetivo'],$_POST['motivacion'],
                $_POST['desarrolloPropuestos'],$_POST['resultadosEsperados'],$tesisActual->formulario1_id,$tesisActual->evaluadores_id,'propuesta incial','en espera',1);

                TesisRepository::getInstance()->disEnableTesis( $_POST['tesisId'], 0 );
                //notificar
                $_SESSION['user']->tesinaAlertMenos();

                header('Location:?action=newTesinaSuccess');
            }else { header('Location:?action=homeStop');  }   
        }else{  header('Location:?action=stop'); }

    }

    public function registerForm1(){
        if ( isset($_SESSION['user']) ) {
            if( $_SESSION['user']->findPermiso('tesina_new') || $_SESSION['user']->findPermiso('all') ){
                $validator = new Formulario1ValidateInput();
                if( $validator->validateFormulario1() ){ //validando campos
                    //revisar si alumno 2 esta vacio
                    $idAlumno2=0;
                    $alumno2 = UserRepository::getInstance()->findUserName( $_POST['id_alumno2'] );
                    if($alumno2){
                        $idAlumno2=$alumno2->id;
                    }
                    TesisRepository::getInstance()->registerForm1($_POST['director'],$_POST['codirector'],$_POST['asesor_profesional'],
                    $_SESSION['user']->__GET('id'),$idAlumno2,$_POST['clasificacion'],$_POST['plazo_de_ejecucion'],1 );
                    
                    header('Location:?action=newTesina');
                }else{//el fomulario tiene campos invalidos, recargar el formulario
                    $form1= new Formulario1();
                    $form1->generateForm1Basic($_POST['director'],$_POST['codirector'],$_POST['asesor_profesional'],$_SESSION['user']->__GET('id'),$_POST['id_alumno2'],$_POST['clasificacion'],$_POST['plazo_de_ejecucion'] );
                    $_SESSION['form1']=$form1;
                
                    header('Location:?action=form1InputError');
                }
            }else { header('Location:?action=homeStop');  }   
        }else{  header('Location:?action=stop'); }
    }

    public function form1InputError(){
        //recargar el form1 y borrarlo de session
        if (isset($_SESSION['user'])) {
            if( $_SESSION['user']->findPermiso('tesina_new') || $_SESSION['user']->findPermiso('all') ){       
                $view = new TesinatView();
                $curl=new CurlRequest();
                $view->showForm1InputError($_SESSION['user'],$_SESSION['form1'],$curl->docentes(),$_SESSION['inputError'] );
                // unset( $_SESSION['form1'] );
                // unset( $_SESSION['inputError'] );
            }else {  header('Location:?action=homeStop');  }
        }else{  header('Location:?action=stop'); }

    }
    
    public function regsiterEditForm1(){
        if ( isset($_SESSION['user']) ) {
            if( $_SESSION['user']->findPermiso('tesina_new') || $_SESSION['user']->findPermiso('all') ){
                $validator = new Formulario1ValidateInput();
                if( $validator->validateFormulario1() ){ //validando campos
                    $idAlumno2=0;
                    $alumno2 = UserRepository::getInstance()->findUserName( $_POST['id_alumno2'] );
                    if($alumno2){
                        $idAlumno2=$alumno2->id;
                    }
                    TesisRepository::getInstance()->updateForm1($_POST['id'],$_POST['director'],$_POST['codirector'],$_POST['asesor_profesional'],
                    $_SESSION['user']->__GET('id'),$idAlumno2,$_POST['clasificacion'],$_POST['plazo_de_ejecucion'],1 );
                
                    header('Location:?action=succesForm1Edit');
                }else{//el fomulario tiene campos invalidos, recargar el formulario
                    $form1= new Formulario1();
                    $form1->generateForm1Basic($_POST['director'],$_POST['codirector'],$_POST['asesor_profesional'],$_SESSION['user']->__GET('id'),$_POST['id_alumno2'],$_POST['clasificacion'],$_POST['plazo_de_ejecucion'] );
                    $_SESSION['form1']=$form1;
                   
                    header('Location:?action=form1EditInputError');
                }       
            }else { header('Location:?action=homeStop');  }   
        }else{  header('Location:?action=stop'); }
    }

    public function form1EditInputError(){
        //recargar el form1
        if (isset($_SESSION['user'])) {
            if( $_SESSION['user']->findPermiso('tesina_new') || $_SESSION['user']->findPermiso('all') ){  
                //tambien recargar el director y codirector que son de api externa
                $curl=new CurlRequest();
                $view = new TesinatView();
                $view->showForm1EditInputError($_SESSION['user'],$_SESSION['form1'],$curl->docentes(),$_SESSION['form1']->__GET('id_alumno2'),$_SESSION['inputError'] );
            }else {  header('Location:?action=homeStop');  }
        }else{  header('Location:?action=stop'); }
    }

    public function editForm1(){
        if ( isset($_SESSION['user']) ) {
            if( $_SESSION['user']->findPermiso('tesina_new') || $_SESSION['user']->findPermiso('all') ){
               //recuperar formulario para editar y lo guarda en session
               $formbd=TesisRepository::getInstance()->getFormulario1Id( $_POST['idForm1'] );
               $form1= new Formulario1();
               $form1->generateForm1Complete($formbd->id,$formbd->director,$formbd->codirector,$formbd->asesor_profesional,
               $formbd->id_alumno1,$formbd->id_alumno2,$formbd->clasificacion,$formbd->plazo_de_ejecucion,$formbd->activo );
        
               $_SESSION['form1'] = $form1;
               header('Location:?action=showForm1Edit');
            }else { header('Location:?action=homeStop');  }   
        }else{  header('Location:?action=stop'); }
    }

    public function showForm1Edit(){
        if ( isset($_SESSION['user']) ) {
            if( $_SESSION['user']->findPermiso('tesina_update') || $_SESSION['user']->findPermiso('all') ){
               //recupera el  formulario de session y lo muestra para editar
                if( isset($_SESSION['form1']) ){
                    //mostrar mje de formulario1 editado
                    $view = new TesinatView();
                    $curl=new CurlRequest();
                    $alumno2BD=UserRepository::getInstance()->findUserId( $_SESSION['form1']->__GET('id_alumno2') );
                    $alumno2=null;
                    if($alumno2BD){
                        $alumno2=$alumno2BD->username;
                    }

                    $view->showForm1Edit($_SESSION['user'],$_SESSION['form1'],$curl->docentes(),$alumno2,'' );
                }else{ header('Location:?action=homeStop');   }
            }else { header('Location:?action=homeStop');  }   
        }else{  header('Location:?action=stop'); }
    }

        /** vista de planilla de tesina */
    public function newTesina(){
            if (isset($_SESSION['user']) ) {
                if( $_SESSION['user']->findPermiso('tesina_new') || $_SESSION['user']->findPermiso('all') ){
                    $colTesis=TesisRepository::getInstance()->myTesis( $_SESSION['user']->id );
                    //si alguna tesis fue modificada mostrar 
                    $_SESSION['user']->contarAlertasTesinas($colTesis);
                    //busca si tiene formulario1
                    $form1=TesisRepository::getInstance()->findForm1($_SESSION['user']->__GET('id'));
                    if( $form1 ){ //muestra el formulario de tesina
                            $view = new TesinatView();
                            $view->showTesinaForm($_SESSION['user'],$form1->id );
                    }else{ //no tiene agregado formulario1.. muestra form1
                        $curl=new CurlRequest();
                        //enviar lista de docentes para elegir director y co director
                        $view = new TesinatView();
                        $view->showForm1($_SESSION['user'],$curl->docentes(),'','');
                    }
                }else { header('Location:?action=homeStop');  }   
            }else{  header('Location:?action=stop'); }
        }

    public function newTesinaSuccess(){
        if (isset($_SESSION['user']) ) {
            if( $_SESSION['user']->findPermiso('tesina_new') || $_SESSION['user']->findPermiso('all') ){
                //si llega aqui el formulario1 ya fue bloqueado porque ya se subio la tesis
                $curl=new CurlRequest();
                //enviar lista de docentes para elegir director y co director
                
                $view = new TesinatView();
                $view->showForm1( $_SESSION['user'],$curl->docentes(),'la tesina se subio correctamente','' );
            }else { header('Location:?action=homeStop');  }   
        }else{  header('Location:?action=stop'); }

    }

     public function verTesina(){
        if ( isset($_SESSION['user']) ) {
            if( $_SESSION['user']->findPermiso('tesina_show') || $_SESSION['user']->findPermiso('all') ){
               //bajar la alerta del user session y actualizar DB la tesina acctual
               //$_SESSION['user']->tesinaAlertMenos();
               TesisRepository::getInstance()->updateTesisLeido( $_POST['idTesis'],false );
               $colTesis=TesisRepository::getInstance()->myTesis( $_SESSION['user']->id );
                //si alguna tesis fue modificada mostrar 
                $_SESSION['user']->contarAlertasTesinas($colTesis);

                //ver la tesina
               $tesis=TesisRepository::getInstance()->findTesisId( $_POST['idTesis'] );
               $formulario1=TesisRepository::getInstance()->getFormulario1Id( $tesis->formulario1_id);
               $curl=new CurlRequest();

               $alumno1=UserRepository::getInstance()->findUserId( $formulario1->id_alumno1 );
               $alumno2=UserRepository::getInstance()->findUserId( $formulario1->id_alumno2 );

               $view = new TesinatView();
               $view->showTesina($_SESSION['user'],$tesis,$formulario1,$curl->docenteId($formulario1->director),$curl->docenteId($formulario1->codirector),$alumno1,$alumno2 );
            
            
            }else { header('Location:?action=homeStop');  }   
        }else{  header('Location:?action=stop'); }
     }

     public function showTesinaRevision(){
        if ( isset($_SESSION['user']) ) {
            if( $_SESSION['user']->findPermiso('tesina_show') || $_SESSION['user']->findPermiso('all') ){
               //ver la tesina
               $tesis=TesisRepository::getInstance()->findTesisId( $_POST['idTesis'] );
               //recuperar director y codirector
               $formulario1=TesisRepository::getInstance()->getFormulario1Id( $tesis->formulario1_id);
               $curl=new CurlRequest();
               $alumno1=UserRepository::getInstance()->findUserId( $formulario1->id_alumno1 );
               $alumno2=UserRepository::getInstance()->findUserId( $formulario1->id_alumno2 );

               $view = new TesinatView();
               $view->showTesinaRevision($_SESSION['user'],$tesis,$formulario1,$curl->docenteId($formulario1->director),$curl->docenteId($formulario1->codirector),$alumno1,$alumno2 );
            
            }else { header('Location:?action=homeStop');  }   
        }else{  header('Location:?action=stop'); }
     }

    public function showTesinaInfAvance(){
        if ( isset($_SESSION['user']) ) {
            if( $_SESSION['user']->findPermiso('tesina_show') || $_SESSION['user']->findPermiso('all') ){
               //ver la tesina
               $tesis=TesisRepository::getInstance()->findTesisId( $_POST['idTesis'] );
               //recuperar director y codirector
               $formulario1=TesisRepository::getInstance()->getFormulario1Id( $tesis->formulario1_id);
               $curl=new CurlRequest();
               $alumno1=UserRepository::getInstance()->findUserId( $formulario1->id_alumno1 );
               $alumno2=UserRepository::getInstance()->findUserId( $formulario1->id_alumno2 );

               $view = new TesinatView();
               $view->showTesinaInfAvance($_SESSION['user'],$tesis,$formulario1,$curl->docenteId($formulario1->director),$curl->docenteId($formulario1->codirector),$alumno1,$alumno2 );
            
            }else { header('Location:?action=homeStop');  }   
        }else{  header('Location:?action=stop'); }
     }

     public function showTesinaFechExp(){
        if ( isset($_SESSION['user']) ) {
            if( $_SESSION['user']->findPermiso('tesina_show') || $_SESSION['user']->findPermiso('all') ){
               //ver la tesina
               $tesis=TesisRepository::getInstance()->findTesisId( $_POST['idTesis'] );
               //recuperar director y codirector
               $formulario1=TesisRepository::getInstance()->getFormulario1Id( $tesis->formulario1_id);
               $curl=new CurlRequest();
               $alumno1=UserRepository::getInstance()->findUserId( $formulario1->id_alumno1 );
               $alumno2=UserRepository::getInstance()->findUserId( $formulario1->id_alumno2 );

               $view = new TesinatView();
               $view->showTesinaFechExp($_SESSION['user'],$tesis,$formulario1,$curl->docenteId($formulario1->director),$curl->docenteId($formulario1->codirector),$alumno1,$alumno2 );
            
            }else { header('Location:?action=homeStop');  }   
        }else{  header('Location:?action=stop'); }
     }

     public function showTesinaUpdateNote(){
        if ( isset($_SESSION['user']) ) {
            if( $_SESSION['user']->findPermiso('tesina_show') || $_SESSION['user']->findPermiso('all') ){
               //ver la tesina
               $tesis=TesisRepository::getInstance()->findTesisId( $_POST['idTesis'] );
               //recuperar director y codirector
               $formulario1=TesisRepository::getInstance()->getFormulario1Id( $tesis->formulario1_id);
               $curl=new CurlRequest();
               $alumno1=UserRepository::getInstance()->findUserId( $formulario1->id_alumno1 );
               $alumno2=UserRepository::getInstance()->findUserId( $formulario1->id_alumno2 );

               $view = new TesinatView();
               $view->showTesinaUpdateNote($_SESSION['user'],$tesis,$formulario1,$curl->docenteId($formulario1->director),$curl->docenteId($formulario1->codirector),$alumno1,$alumno2 );
            
            }else { header('Location:?action=homeStop');  }   
        }else{  header('Location:?action=stop'); }

     }

     public function registerFechExp(){
        if ( isset($_SESSION['user']) ) {
            if( $_SESSION['user']->findPermiso('tesina_validate') || $_SESSION['user']->findPermiso('all') ){
                //revisar que sea una fecha valida.. y cambiar estado
                $validator= new FormValidateGeneral();
                if( $validator->validateFechExp() ){
                    TesisRepository::getInstance()->updateTesisFechExp( $_POST['idTesis'],$_POST['fechExp'],'para exponer' );
                    $_SESSION['info']='se registro la fecha de exposicion..';
                    //notificar cambio
                    TesisRepository::getInstance()->updateTesisLeido( $_POST['idTesis'],true );
                    $this->notifymail( $_POST['idTesis'],'fecha de exposicion',' se agrego fecha de exposicion a su tesina,por favor revise su tesina' );
                }//el validador pone el error porque el sabe que error paso
                header('Location:?action=tesinasEnCurso');
            }else { header('Location:?action=homeStop');  }   
        }else{  header('Location:?action=stop'); }

     }

     public function registerNote(){
        if ( isset($_SESSION['user']) ) {
            if( $_SESSION['user']->findPermiso('tesina_validate') || $_SESSION['user']->findPermiso('all') ){
                //validar que sea una Nota valida.. y cambiar estado
                $validator= new FormValidateGeneral();
                if( $validator->validateNote() ){
                    TesisRepository::getInstance()->updateTesisNote( $_POST['idTesis'],$_POST['tNote'],'tesina finalizada','aceptada' );
                    $_SESSION['info']='se registro la Nota de la tesina..';
                    //notificar cambio
                    TesisRepository::getInstance()->updateTesisLeido( $_POST['idTesis'],true );
                    $this->notifymail($_POST['idTesis'],'Nota de Tesina','se agrego nota a su tesina,por favor revise su tesina');
                }//el validador pone el error porque el sabe que error paso

                header('Location:?action=tesinasEnCurso');
            }else { header('Location:?action=homeStop');  }   
        }else{  header('Location:?action=stop'); }

     }

     public function confirmTesinaCancel(){
        if ( isset($_SESSION['user']) ) {
            if( $_SESSION['user']->findPermiso('tesina_validate') || $_SESSION['user']->findPermiso('all') ){
                //cancela una tesina updateTesisState
                TesisRepository::getInstance()->updateTesisState($_POST['idTesis'],'tesina cancelada',$_POST['comentario']);
                $_SESSION['info']='tesina cancelada..';
                //notificar cambio
                TesisRepository::getInstance()->updateTesisLeido( $_POST['idTesis'],true );
                $this->notifymail($_POST['idTesis'],'Tesina Cancelada','su tesina fue cancelada, por favor revise su tesina');
               header('Location:?action=tesinasEnCurso');
            }else { header('Location:?action=homeStop');  }   
        }else{  header('Location:?action=stop'); }

     }
     
     public function cancelTesina(){
        if ( isset($_SESSION['user']) ) {
            if( $_SESSION['user']->findPermiso('tesina_validate') || $_SESSION['user']->findPermiso('all') ){
                //ver la tesina
               $tesis=TesisRepository::getInstance()->findTesisId( $_POST['idTesis'] );
               //recuperar director y codirector
               $formulario1=TesisRepository::getInstance()->getFormulario1Id( $tesis->formulario1_id);
               $curl=new CurlRequest();
               $alumno1=UserRepository::getInstance()->findUserId( $formulario1->id_alumno1 );
               $alumno2=UserRepository::getInstance()->findUserId( $formulario1->id_alumno2 );

               $view = new TesinatView();
               $view->showTesinaCancel($_SESSION['user'],$tesis,$formulario1,$curl->docenteId($formulario1->director),$curl->docenteId($formulario1->codirector),$alumno1,$alumno2 );
            }else { header('Location:?action=homeStop');  }   
        }else{  header('Location:?action=stop'); }
     }

     public function aceptTesis(){
        if ( isset($_SESSION['user']) ) {
            if( $_SESSION['user']->findPermiso('tesina_validate') || $_SESSION['user']->findPermiso('all') ){
                //revisar que tenga evaluadores
                $tesis=TesisRepository::getInstance()->findTesisId($_POST['idTesis']);
                if($tesis->evaluadores_id > 0){
                    TesisRepository::getInstance()->updateTesisRevisionComentAccept($_POST['idTesis'],'aceptada',$_POST['comentario'],'tesina inicial' );
                    //notificar cambio
                    TesisRepository::getInstance()->updateTesisLeido( $_POST['idTesis'],true );
                    $this->notifymail($_POST['idTesis'],'Propuesta de Tesina aceptada','su propuesta de tesina fue aceptada, debe presentar informe de avance ');
                    header('Location:?action=showTesinasCorregida');
                }else{ header('Location:?action=homeStop'); }   
            }else { header('Location:?action=homeStop');  }   
        }else{  header('Location:?action=stop'); }
     }

     public function denyTesis(){
        if ( isset($_SESSION['user']) ) {
            if( $_SESSION['user']->findPermiso('tesina_validate') || $_SESSION['user']->findPermiso('all') ){
                //revisar que tenga evaluadores
                $tesis=TesisRepository::getInstance()->findTesisId($_POST['idTesis']);
                if($tesis->evaluadores_id > 0){
                    TesisRepository::getInstance()->updateTesisRevisionComentDenny($_POST['idTesis'],'rechazada',$_POST['comentario']);
                    //notificar cambio
                    TesisRepository::getInstance()->updateTesisLeido( $_POST['idTesis'],true );
                    $this->notifymail($_POST['idTesis'],'Propuesta de Tesina Rechazada','su propuesta de tesina fue rechazada, por favor revisela');
                  
                    header('Location:?action=showTesinasCorregida');
                }else{ header('Location:?action=homeStop'); }
            }else { header('Location:?action=homeStop');  }   
        }else{  header('Location:?action=stop'); }
     }

     /** funciones vue JS */
     public function tesinaEnCursoVue(){
        if ( isset($_SESSION['user']) ) {
            if( $_SESSION['user']->findPermiso('tesina_show') || $_SESSION['user']->findPermiso('all') ){
              
                $view = new TesinatView();
                $view->tesinaEnCurso($_SESSION['user'] );    

            }else { header('Location:?action=homeStop');  }   
        }else{  header('Location:?action=stop'); }

     }

     public function tesinaRechazadaEdit(){
        if ( isset($_SESSION['user']) ) {
            if( $_SESSION['user']->findPermiso('tesina_new') || $_SESSION['user']->findPermiso('all') ){
                
                //recupera lq tesis
                $tesis=TesisRepository::getInstance()->findTesisId( $_POST['idTesis'] );
                $form1=TesisRepository::getInstance()->getFormulario1Id( $tesis->formulario1_id );
                $curl=new CurlRequest();
                $alumno1=UserRepository::getInstance()->findUserId( $form1->id_alumno1 );
                $alumno2=UserRepository::getInstance()->findUserId( $form1->id_alumno2 );
                $view = new TesinatView();

                $view->showTesinaRechazada($_SESSION['user'],$tesis,$form1,$curl->docenteId($form1->director),$curl->docenteId($form1->codirector),$alumno1,$alumno2);
            }else { header('Location:?action=homeStop');  }   
        }else{  header('Location:?action=stop'); }

     }

     public function myTesinas(){
        if ( isset($_SESSION['user']) ) {
            if( $_SESSION['user']->findPermiso('tesina_show') || $_SESSION['user']->findPermiso('all') ){
                $colTesis=TesisRepository::getInstance()->myTesis( $_SESSION['user']->id );
                //si alguna tesis fue modificada mostrar 
                $_SESSION['user']->contarAlertasTesinas($colTesis);
                $tesis=TesisRepository::getInstance()->myTesis( $_SESSION['user']->__GET('id') );
                $view = new TesinatView();
                $view->myTesinas($_SESSION['user'],$tesis );    

            }else { header('Location:?action=homeStop');  }   
        }else{  header('Location:?action=stop'); }

     }



     public function showFormEvaluathors(){
        if ( isset($_SESSION['user']) ) {
            if( $_SESSION['user']->findPermiso('tesina_validate') || $_SESSION['user']->findPermiso('all') ){
                //guarda el id de la tesis para usarlo despues
                $_SESSION['idTesisEvaluathor']=$_POST['idTesis'];
                
                $view = new TesinatView();
                $curl=new CurlRequest();
                
                $view->showFormEvaluathors( $_SESSION['user'],$curl->evaluadores(),'' );  
            }else { header('Location:?action=homeStop');  }   
        }else{  header('Location:?action=stop'); }

     }

     public function showFormEvaluathorsError(){
        if ( isset($_SESSION['user']) ) {
            if( $_SESSION['user']->findPermiso('tesina_validate') || $_SESSION['user']->findPermiso('all') ){
                
                $view = new TesinatView();
                $curl=new CurlRequest();

                $view->showFormEvaluathorsError( $_SESSION['user'],$curl->evaluadores(),$_SESSION['evaluador1'],$_SESSION['evaluador2'],$_SESSION['evaluador3'],$_SESSION['evaluador4'],$_SESSION['error'] );  
            }else { header('Location:?action=homeStop');  }   
        }else{  header('Location:?action=stop'); }

     }

     public function registerEvaluathors(){
        if ( isset($_SESSION['user']) ) {
            if( $_SESSION['user']->findPermiso('tesina_validate') || $_SESSION['user']->findPermiso('all') ){
                
                $validator = new FormEvaluathorsValidateInput();
                if( $validator->validateFormulario() ){ //validando campos
                    //agregar a tabla de evaluadores los 4 evaladores elegidos
                    $idEvaluadores=TesisRepository::getInstance()->registerEvaluathors( $_POST['evaluador1'],$_POST['evaluador2'],$_POST['evaluador3'],$_POST['evaluador4'] );
                    //actualizar tesina con los evaluadores.. la idTesisEvaluathor es guardada en la session
                    TesisRepository::getInstance()->updateEvaluathors( $_SESSION['idTesisEvaluathor'],$idEvaluadores  );
                
                    header('Location:?action=successRegisterEvaluathors');
                }else{ //no pasa la validacion se debe recargar formulario evaluadores
                    $_SESSION['evaluador1']=$_POST['evaluador1'];
                    $_SESSION['evaluador2']=$_POST['evaluador2'];
                    $_SESSION['evaluador3']=$_POST['evaluador3'];
                    $_SESSION['evaluador4']=$_POST['evaluador4'];
                    header('Location:?action=showFormEvaluathorsError');
                }
            }else { header('Location:?action=homeStop');  }   
        }else{  header('Location:?action=stop'); }

     }

     public function successRegisterEvaluathors(){
        if ( isset($_SESSION['user']) ) {
            if( $_SESSION['user']->findPermiso('tesina_validate') || $_SESSION['user']->findPermiso('all') ){ 
                //recuperar las tesinas propuestas incial sin calificar
                $colTesis = TesisRepository::getInstance()->getPropuestasInicialRevision();        
                $view = new TesinatView();
                $colAuthors=$this->generateListAuthor($colTesis);

                $view->showPendienTesinas($_SESSION['user'],$colTesis,$colAuthors,'','se agregaron los evaluadores correctamente'); 
            }else { header('Location:?action=homeStop');  }   
        }else{  header('Location:?action=stop'); }

     }

     public function tesinasEnCurso(){
        if ( isset($_SESSION['user']) ) {
            if( $_SESSION['user']->findPermiso('tesina_validate') || $_SESSION['user']->findPermiso('all') ){ 
                //recuperar las tesinas propuestas incial sin calificar
                $colTesis = TesisRepository::getInstance()->tesinasEnCurso();        
                $view = new TesinatView();
                $colAuthors=$this->generateListAuthor($colTesis);
                $info='';$error='';
                //pregunto si en la session existe algun error o info alert
                if ( isset($_SESSION['info']) ){ $info=$_SESSION['info'];  unset( $_SESSION['info'] ); }
                if ( isset($_SESSION['error']) ){ $error=$_SESSION['error']; unset( $_SESSION['error'] ); }

                $view->showTesinasEnCurso($_SESSION['user'],$colTesis,$colAuthors,$info,$error); 
            }else { header('Location:?action=homeStop');  }   
        }else{  header('Location:?action=stop'); }

     }


     public function registerInfAvance(){
        if ( isset($_SESSION['user']) ) {
            if( $_SESSION['user']->findPermiso('tesina_validate') || $_SESSION['user']->findPermiso('all') ){ 
               //verifica la llegada del archivo
                if(is_array($_FILES)) {
                    if(is_uploaded_file( $_FILES['infAvance']['tmp_name']  ) ) {
                        
                        //recupera el contenido binario para guardarlo en la BD
                        $fp = fopen( $_FILES["infAvance"]["tmp_name"], "rb" );
                        $contenido = fread( $fp, $_FILES["infAvance"]["size"] );
                        $contenido = addslashes($contenido);
                        fclose($fp);

                        //registrar el infAvance >>> revisar extension
                        TesisRepository::getInstance()->registerInfAvance( $_POST['idTesis'],$contenido  );
                        //cambiar estado de la tesis
                        TesisRepository::getInstance()->updateTesisRevisionComentAccept($_POST['idTesis'],'aceptada','','infAvance entregado');
                        $_SESSION['info']="el archivo fue subido correctamente";

                        //notificar cambio
                        TesisRepository::getInstance()->updateTesisLeido( $_POST['idTesis'],true );
                        $this->notifymail($_POST['idTesis'],'Informe de Avance aceptada','se registro su informe de avance, debe cordinar una fecha de exposicion porfavor ');

                    }else{ $_SESSION['error']='el archivo No se envio'; }
                }else{ $_SESSION['error']='el archivo No se envio'; }
                
                header('Location:?action=tesinasEnCurso');
            }else { header('Location:?action=homeStop');  }   
        }else{  header('Location:?action=stop'); }

     }

 

     /**>>>>>>>>>>>>>>   funciones ayudantes privadas   <<<<<<<<<<<<<<*/

    private function generateListAuthor($colTesis){
        $resul=array();  $i=0;
        foreach( $colTesis as $tesis){
            //se recuperan los autores de las tesis
            $form1=TesisRepository::getInstance()->getFormulario1Id($tesis->formulario1_id);
            $alumno1=UserRepository::getInstance()->findUserId($form1->id_alumno1);
            $authors=$alumno1->username;
            if($form1->id_alumno2){
                //si existe autor2 se concatena los autores
                $alumno2=UserRepository::getInstance()->findUserId($form1->id_alumno2);
                $authors=$authors.' y '.$alumno2->username;
            }
            $resul[$i]=$authors;
            $i++;
        }
        return $resul;
    }

    private function verTesinasEstado($tesis,$form1){
        if($tesis->estado == 'entregada' ){
            $view = new TesinatView();
            $view->showTesinaInfo($_SESSION['user'],'su tesina se encuentra en espera de calificacion..',$tesis->id );
        }
        if($tesis->estado == 'aceptada' ){
            $view = new TesinatView();
            $view->showTesinaInfo($_SESSION['user'],'su tesina fue aprobada..',$tesis->id );
        }
        if($tesis->estado == 'rechazada' ){
            $view = new TesinatView();

            $view->showTesinaRechazada($_SESSION['user'],$tesis,$form1 );
        }

    }

    private function notifymail($idTesis, $subject, $message){
        //recuperar usuarios de la tesis y mandar el mail 
        $urlApp='https://grupo54.proyecto2018.linti.unlp.edu.ar/';

        $tesis=TesisRepository::getInstance()->findTesisId($idTesis);
        $form1=TesisRepository::getInstance()->getFormulario1Id( $tesis->formulario1_id );

        $alumno1=UserRepository::getInstance()->findUserId($form1->id_alumno1);
        $to=$alumno1->email;
        //envio de mail
        $mess=$message.'\n\t    '.$urlApp;
        
        mail($to, $subject, $mess);
     
        $alumno2=UserRepository::getInstance()->findUserId($form1->id_alumno2);
        if($alumno2){
            $to2=$alumno2->email;
            mail($to2, $subject, $mess);
        }
    }

}