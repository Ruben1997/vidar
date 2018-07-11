<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of procesosController
 *
 * @author Ruben1997
 */
class procesosController extends Controller {

//put your code here
    public function __construct() {
        parent::__construct("procesos");
    }

    public function aprendicescomite() {
        $data = $this->loadModel('procesos');
        $this->_view->usuarios = $data->aprendicescomite();
        $this->_view->actas = $data->actascomite();
        $this->_view->renderizar('aprendicescomite', 'blank');
    }

    public function mostrardocumento() {
        $data = $this->loadModel('procesos');
        $this->_view->acta = $data->actadocumento();
        $this->_view->renderizar('documento', 'blank');
    }

    public function solicitarcomite() {
        $data = $this->loadModel('parametros');
        $this->_view->instituciones = $data->instituciones();
        $this->_view->programas = $data->programas();
        @$layout = $this->layout($_POST['val']);
        $this->_view->titulo = 'Comite de evaluacion';
        $this->_view->metodo = "Procesos";
        $this->_view->metodoaccion = 'Comite de evaluacion';
        $this->_view->renderizar('comite', 'vidar', $layout);
    }

    public function setinasistencia() {
        $data = $this->loadModel('procesos');
        $sql = $data->setasistencia();
        if ($sql) {
            Session::set('mensaje', 'Operacion exitosa');
            Session::set('tipomensaje', 'alert-success');
        } else {
            Session::set('mensaje', 'Error en el proceso');
            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('procesos/inasistencia');
        exit();
    }

    public function listadoaprendicesinasistencia() {
        $data = $this->loadModel('procesos');
        $this->_view->ficha = $_POST['ficha'];
        $this->_view->usuarios = $data->listaaprendicesinasistencia();
        $this->_view->renderizar('usuariosinasistencia', 'blank');
    }

    public function inasistencia() {
        $data = $this->loadModel('parametros');
        $this->_view->instituciones = $data->instituciones();
        $this->_view->programas = $data->programas();
        @$layout = $this->layout($_POST['val']);
        $this->_view->titulo = 'Inasistencia';
        $this->_view->metodo = "Procesos";
        $this->_view->metodoaccion = 'Inasistencia';
        $this->_view->renderizar('inasistencia', 'vidar', $layout);
    }

    public function modalarchivos() {
        $this->_view->ficha = $_POST['ficha'];
        $this->_view->renderizar('archivos', 'blank');
    }

    public function setarchivoplano() {
        $model = $this->loadModel('procesos');
        $data = $this->getLibrary('classes' . DS . 'PHPExcel');
        $data = $this->getLibrary('classes' . DS . 'PHPExcel' . DS . 'Reader' . DS . 'Excel2007');
        $archivo = $_FILES['excel']['name'];
        $tipo = $_FILES['excel']['type'];
        $destino = ROOT . 'public' . DS . 'vidarLayout' . DS . 'files' . DS . 'cop_' . $archivo;
        if (copy($_FILES['excel']['tmp_name'], $destino)) {
            
        } else {
            
        }
        if (file_exists($destino)) {
            $objReader = new PHPExcel_Reader_Excel2007();
            $objPHPExcel = $objReader->load($destino);
            $objFecha = new PHPExcel_Shared_Date();
            $objPHPExcel->setActiveSheetIndex(0);
            $columnas = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
            $filas = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
            $array = array();
            for ($i = 2; $i <= $filas; $i++) {
                $e = array();
                $e['tipo'] = $objPHPExcel->getActiveSheet()->getCell('A' . $i)->getCalculatedValue();
                $e['documento'] = $objPHPExcel->getActiveSheet()->getCell('B' . $i)->getCalculatedValue();
                $e['nombre'] = $objPHPExcel->getActiveSheet()->getCell('C' . $i)->getCalculatedValue();
                $e['apellido'] = $objPHPExcel->getActiveSheet()->getCell('D' . $i)->getCalculatedValue();
                $e['correo'] = $objPHPExcel->getActiveSheet()->getCell('E' . $i)->getCalculatedValue();
                $e['telefono'] = $objPHPExcel->getActiveSheet()->getCell('F' . $i)->getCalculatedValue();
                array_push($array, $e);
            }
            $sql = $model->insertaraprendices($array);
            if ($sql) {
                Session::set('mensaje', 'Operacion exitosa');
                Session::set('tipomensaje', 'alert-success');
            } else {
                Session::set('mensaje', 'Error en el proceso');
                Session::set('tipomensaje', 'alert-danger');
            }
            $this->redireccionar('procesos/asignaraprendices');
            exit();
        } else {
            Session::set('mensaje', 'Error en la ruta del archivo');
            Session::set('tipomensaje', 'alert-danger');
            $this->redireccionar('procesos/asignaraprendices');
            exit();
        }
    }

    public function setasignar() {
        $data = $this->loadModel('procesos');
        $sql = $data->setficha();
        if ($sql) {
            Session::set('mensaje', 'Operacion exitosa');
            Session::set('tipomensaje', 'alert-success');
        } else {
            Session::set('mensaje', 'Error en el proceso');
            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('procesos/asignaraprendices');
        exit();
    }

    public function tablaaprendicesasignar() {
        $data = $this->loadModel('procesos');
        $this->_view->usuarios = $data->listaaprendicesasignar();
        $this->_view->ficha = $_POST['ficha'];
        $this->_view->renderizar('cargaaprendicesasignar', 'blank');
    }

    public function asignaraprendices() {
        $data = $this->loadModel('parametros');
        $this->_view->instituciones = $data->instituciones();
        $this->_view->programas = $data->programas();
        $layout = $this->layout($_POST['val']);
        $this->_view->titulo = 'Asignar Aprendices';
        $this->_view->metodo = "Procesos";
        $this->_view->metodoaccion = 'Asignar Aprendices';
        $this->_view->renderizar('asignaraprendices', 'vidar', $layout);
    }

    public function setrol() {
        $data = $this->loadModel('procesos');
        $sql = $data->updaterol();
        if ($sql) {
            Session::set('mensaje', 'Usuario autorizado correctamente');
            Session::set('tipomensaje', 'alert-success');
        } else {
            Session::set('mensaje', 'Error en el proceso');
            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('procesos/autorizarusuario');
        exit();
    }

    public function modalroles() {
        $data = $this->loadModel('procesos');
        $this->_view->roles = $data->listarroles();
        $this->_view->id = $_POST['id'];
        $this->_view->renderizar('asignarRoles', 'blank');
    }

    public function autorizarusuario() {
        $data = $this->loadModel('procesos');
        $this->_view->usuarios = $data->autorizausuarios();
        $layout = $this->layout($_POST['val']);
        $this->_view->titulo = 'Autorizar Usuarios';
        $this->_view->metodo = "Procesos";
        $this->_view->metodoaccion = 'Autorizar Usuarios';
        $this->_view->renderizar('autorizarUsuarios', 'vidar', $layout);
    }

}
