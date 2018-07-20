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

    public function genreportenovedades() {
        $data = $this->loadModel('reportes');
        $this->_view->usuarios = $data->usuariosreportenovedades();
        $this->_view->renderizar('detallenovedades', 'blank');
    }

    public function novedades() {
        Session::accesoEstricto(array('Administrador', 'Instructor','Coordinador Academico'), true);
        $data = $this->loadModel('reportes');
        @$layout = $this->layout($_POST['val']);
        $dataparametros = $this->loadModel('parametros');
        $this->_view->instituciones = $dataparametros->instituciones();
        $this->_view->titulo = 'Reporte Novedades';
        $this->_view->metodo = "Reportes";
        $this->_view->metodoaccion = 'Novedades';
        $this->_view->renderizar('novedades', 'vidar', $layout);
    }

    public function detallecomite() {
        $data = $this->loadModel('reportes');
        $this->_view->datos = $data->onecomite();
        $this->_view->usuarios = $data->listaaprendices();
        $this->_view->renderizar('detallecomite', 'blank');
    }

    public function guardardatosplan() {
        $data = $this->loadModel('reportes');
        $sql = $data->setplanmejoramiento();
        if ($sql) {
            Session::set('mensaje', 'Operacion exitosa');
            Session::set('tipomensaje', 'alert-success');
        } else {
            Session::set('mensaje', 'Error en el proceso');
            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('reportes/comitedeevaluacion');
        exit();
    }

    public function comitedeevaluacion() {
        Session::accesoEstricto(array('Administrador', 'Instructor','Coordinador Academico'), true);
        $data = $this->loadModel('reportes');
        $dataparametros = $this->loadModel('parametros');
        $this->_view->instituciones = $dataparametros->instituciones();
        @$layout = $this->layout($_POST['val']);
        $this->_view->titulo = 'Comites de evaluacion';
        $this->_view->metodo = "Reportes";
        $this->_view->comites = $data->listacomites();
        $this->_view->metodoaccion = 'Comites de evaluacion';
        $this->_view->renderizar('comitesdeevaluacion', 'vidar', $layout);
    }

    public function carganovedadesaprendices() {
        $data = $this->loadModel('reportes');
        $this->_view->novedades = $data->novedadesaprendiz();
        $this->_view->renderizar('carganovedades', 'blank');
    }

    public function filtrocomites() {
        $data = $this->loadModel('reportes');
        $this->_view->comites = $data->filtracomites();
        $this->_view->renderizar('filtrocomites', 'blank');
    }

    public function asignarplanmejoramiento() {
        $data = $this->loadModel('reportes');
        $this->_view->usuarios = $data->usuarioscomite();
        $ficha = $data->fichacomite();
        $this->_view->ficha = $ficha[0]['fchaId'];
        $this->_view->renderizar('formularioplanmejoramiento', 'blank');
    }

    public function genasistencia() {
        $data = $this->loadModel('reportes');
        $this->_view->usuarios = $data->reporteasistencia();
        $this->_view->renderizar('reporteasistencia', 'blank');
    }

    public function cargaraprendices() {
        $data = $this->loadModel('reportes');
        $this->_view->aprendices = $data->usuariosasistencia();
        $this->_view->renderizar('cargaaprendices', 'blank');
    }

    public function asistencia() {
        Session::accesoEstricto(array('Administrador', 'Instructor','Coordinador Academico'), true);
        $data = $this->loadModel('parametros');
        $this->_view->instituciones = $data->instituciones();
        @$layout = $this->layout($_POST['val']);
        $this->_view->titulo = 'Reporte Asistencias';
        $this->_view->metodo = "Reportes";
        $this->_view->metodoaccion = 'Asistencia';
        $this->_view->renderizar('asistencia', 'vidar', $layout);
    }

}
