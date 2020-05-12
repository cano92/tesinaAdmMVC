<?php

class Tesina {

    public $titulo;
    public $directores;
    public $alumnos;
    public $estado;

    public function __GET($k){ return $this->$k; }
	public function __SET($k, $v){ return $this->$k = $v; }

}
    