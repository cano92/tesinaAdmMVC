<?php

class TesinasEstadoHC {

    public $propuestaIncial;
    public $propuestaIncialSize;
    public $tesinaInicial;
    public $tesinaInicialSize;
    public $infAvanceEntregado;
    public $infAvanceEntregadoSize;
    public $paraExponer;
    public $paraExponerSize;
    public $tesinaFinalizada;
    public $tesinaFinalizadaSize;
    public $tesinaCancelada;
    public $tesinaCanceladaSize;

    public function __GET($k){ return $this->$k; }
	public function __SET($k, $v){ return $this->$k = $v; }
}