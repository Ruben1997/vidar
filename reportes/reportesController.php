<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of reportesController
 *
 * @author Ruben1997
 */
class reportesController extends Controller {

    //put your code here
    public function __construct() {
        parent::__construct("reportes");
    }

    public function genasistencia() {
        $data = $this->loadModel('reportes');
        $this->_view->usuarios = $data->reporteasistencia();
        $this->_view->renderizar('reporteasistencia', 'blank');
    }

    public function asistencia() {
        $data = $this->loadModel('parametros');
        $this->_view->instituciones = $data->instituciones();
        $this->_view->programas = $data->programas();
        $layout = $this->layout($_POST['val']);
        $this->_view->titulo = 'Reporte Asistencias';
        $this->_view->metodo = "Reportes";
        $this->_view->metodoaccion = 'Asistencia';
        $this->_view->renderizar('asistencia', 'vidar', $layout);
    }

}
