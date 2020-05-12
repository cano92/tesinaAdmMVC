<?php

class TesinasNotasHC {

    public $nota1;
    public $nota2;
    public $nota3;
    public $nota4;
    public $nota5;
    public $nota6;
    public $nota7;
    public $nota8;
    public $nota0;
    public $nota10;
    
    public function __GET($k){ return $this->$k; }
	public function __SET($k, $v){ return $this->$k = $v; }
}