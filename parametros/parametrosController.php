<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of parametrosController
 *
 * @author Ruben1997
 */
class parametrosController extends Controller {

    //put your code here
    public function __construct() {
        parent::__construct("parametros");
    }

    public function cargaprogramas() {
        $data = $this->loadModel('parametros');
        $this->_view->programas = $data->cargaprogramas();
        $this->_view->renderizar('cargaprogramas', 'blank');
    }

    public function bajaaspectos($argum = false) {
        $data = $this->loadModel('parametros');
        $sql = $data->bajaaspectos($argum);
        if ($sql) {
            Session::set('mensaje', 'Operacion exitosa');
            Session::set('tipomensaje', 'alert-success');
        } else {
            Session::set('mensaje', 'Error en el proceso');
            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('parametros/faltasyaspectos');
        exit();
    }

    public function setaspecto() {
        $data = $this->loadModel('parametros');
        $sql = $data->setapecto();
        if ($sql) {
            Session::set('mensaje', 'Operacion exitosa');
            Session::set('tipomensaje', 'alert-success');
        } else {
            Session::set('mensaje', 'Error en el proceso');
            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('parametros/faltasyaspectos');
        exit();
    }

    public function formularioaspectos() {
        $data = $this->loadModel('parametros');
        $this->_view->reglamento = $data->listareglamento();
        if (!empty($_POST['id'])) {
            $this->_view->datos = $data->oneaspecto();
            $this->_view->accion = 'Editar faltas y aspectos positivos';
        } else {
            $this->_view->datos = array(3);
            $this->_view->accion = 'Agregar faltas y aspectos positivos';
        }
        $this->_view->renderizar('formularioaspectos', 'blank');
    }

    public function faltasyaspectos() {
        Session::accesoEstricto(array('Administrador', 'Instructor'), true);
        $data = $this->loadModel('parametros');
        @$layout = $this->layout($_POST['val']);
        $this->_view->titulo = 'Faltas y aspectos positivos';
        $this->_view->metodo = "Parametros";
        $this->_view->metodoaccion = 'Faltas y aspectos positivos';
        $this->_view->aspectos = $data->aspectospositivos();
        $this->_view->renderizar('aspectos', 'vidar', $layout);
    }

    public function bajareglamento($argum = false) {
        $data = $this->loadModel('parametros');
        $sql = $data->bajareglamentos($argum);
        if ($sql) {
            Session::set('mensaje', 'Operacion exitosa');
            Session::set('tipomensaje', 'alert-success');
        } else {
            Session::set('mensaje', 'Error en el proceso');
            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('parametros/reglamentoaprendiz');
        exit();
    }

    public function setreglamento() {
        $data = $this->loadModel('parametros');
        $sql = $data->setreglamento();
        if ($sql) {
            Session::set('mensaje', 'Operacion exitosa');
            Session::set('tipomensaje', 'alert-success');
        } else {
            Session::set('mensaje', 'Error en el proceso');
            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('parametros/reglamentoaprendiz');
        exit();
    }

    public function formularioreglamento() {
        $data = $this->loadModel('parametros');
        if (!empty($_POST['id'])) {
            $this->_view->datos = $data->onereglamento();
            $this->_view->accion = 'Editar Deber';
        } else {
            $this->_view->datos = array(3);
            $this->_view->accion = 'Agregar Deber';
        }
        $this->_view->renderizar('formularioreglamento', 'blank');
    }

    public function reglamentoaprendiz() {
        Session::acceso('Administrador');
        $data = $this->loadModel('parametros');
        @$layout = $this->layout($_POST['val']);
        $this->_view->titulo = 'Reglamento Aprendiz';
        $this->_view->metodo = "Parametros";
        $this->_view->metodoaccion = 'Reglamento Aprendiz';
        $this->_view->reglamento = $data->listareglamento();
        $this->_view->renderizar('reglamento', 'vidar', $layout);
    }

    public function setusuariosfichas() {
        $data = $this->loadModel('parametros');
        $sql = $data->setusuariosfichas();
        if ($sql) {
            Session::set('mensaje', 'Operacion exitosa');
            Session::set('tipomensaje', 'alert-success');
        } else {
            Session::set('mensaje', 'Error en el proceso');
            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('parametros/fichas');
        exit();
    }

    public function setusuariosinstructores() {
        $data = $this->loadModel('parametros');
        $sql = $data->bajadetalleusuario();
        if ($sql) {
            $this->_view->instructores = $data->instructoresfichas();
            $this->_view->renderizar('tablainstructores', 'blank');
        }
    }

    public function setusuariosaprendiz() {
        $data = $this->loadModel('parametros');
        $sql = $data->bajadetalleusuario();
        if ($sql) {
            $this->_view->aprendices = $data->aprendicesfichas();
            $this->_view->renderizar('tablaaprendices', 'blank');
        }
    }

    public function usuariosasignadosfichas() {
        $data = $this->loadModel('parametros');
        $this->_view->instructores = $data->instructoresfichas();
        $this->_view->aprendices = $data->aprendicesfichas();
        $this->_view->ficha = $_POST['ficha'];
        $this->_view->renderizar('usuariosfichas', 'blank');
    }

    public function bajactas($argum = false) {
        $data = $this->loadModel('parametros');
        $sql = $data->bajaactas($argum);
        if ($sql) {
            Session::set('mensaje', 'Operacion exitosa');
            Session::set('tipomensaje', 'alert-success');
        } else {
            Session::set('mensaje', 'Error en el proceso');
            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('parametros/actasequipo');
        exit();
    }

    public function formularioactas() {
        $data = $this->loadModel('parametros');
        $this->_view->instituciones = $data->instituciones();
        if (!empty($_POST['id'])) {
            $this->_view->datos = $data->oneacta();
            $datos = $data->oneacta();
            $this->_view->programas = $data->programasinstitucion($datos[0]['instId']);
            $this->_view->fichas = $data->fichasactas($datos[0]['proId'], $datos[0]['instId']);
            $this->_view->accion = 'Editar Actas';
        } else {
            $this->_view->programas = array();
            $this->_view->fichas = array();
            $this->_view->datos = array(7);
            $this->_view->accion = 'Agregar Actas';
        }
        $this->_view->renderizar('formularioactas', 'blank');
    }

    public function setactas() {
        $data = $this->loadModel('parametros');
        if ($_FILES['txtArchivoActa']['error'] != 4) {
            $nombrearchivo = htmlentities($_FILES['txtArchivoActa']['name']);
            $destino = ROOT . 'public' . DS . 'vidarLayout' . DS . 'files' . DS . html_entity_decode($nombrearchivo);
            move_uploaded_file($_FILES['txtArchivoActa']['tmp_name'], $destino);
        }
        $sql = $data->setacta();
        if ($sql) {
            Session::set('mensaje', 'Operacion exitosa');
            Session::set('tipomensaje', 'alert-success');
        } else {
            Session::set('mensaje', 'Error en el proceso');
            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('parametros/actasequipo');
        exit();
    }

    public function actasequipo() {
        Session::accesoEstricto(array('Administrador', 'Instructor', 'Coordinador Academico'), true);
        $data = $this->loadModel('parametros');
        @$layout = $this->layout($_POST['val']);
        $this->_view->titulo = 'Actas';
        $this->_view->metodo = "Parametros";
        $this->_view->metodoaccion = 'Actas';
        $this->_view->actas = $data->actas();
        $this->_view->renderizar('actas', 'vidar', $layout);
    }

    public function tablaaprendices() {
        $data = $this->loadModel('parametros');
        $this->_view->usuarios = $data->tablaaprendices();
        $this->_view->renderizar('filtraaprendices', 'blank');
    }

    public function cargarfichas() {
        $data = $this->loadModel('parametros');
        $this->_view->fichas = $data->cargaficha();
        $this->_view->renderizar('cargafichas', 'blank');
    }

    public function setaprendices() {
        $data = $this->loadModel('parametros');
        $sql = $data->setaprendiz();
        if ($sql) {
            Session::set('mensaje', 'Operacion exitosa');
            Session::set('tipomensaje', 'alert-success');
        } else {
            Session::set('mensaje', 'Error en el proceso');
            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('parametros/aprendices');
        exit();
    }

    public function bajaaprendices($argum = false) {
        $data = $this->loadModel('parametros');
        $sql = $data->bajaaprendices($argum);
        if ($sql) {
            Session::set('mensaje', 'Operacion exitosa');
            Session::set('tipomensaje', 'alert-success');
        } else {
            Session::set('mensaje', 'Error en el proceso');
            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('parametros/aprendices');
        exit();
    }

    public function formularioaprendices() {
        $data = $this->loadModel('parametros');
        if (!empty($_POST['id'])) {
            $this->_view->datos = $data->oneusuario();
            $this->_view->accion = 'Editar Aprendices';
        } else {
            $this->_view->datos = array(7);
            $this->_view->accion = 'Agregar Aprendices';
        }
        $this->_view->renderizar('formularioaprendices', 'blank');
    }

    public function aprendices() {
        Session::accesoEstricto(array('Administrador', 'Instructor'), true);
        $data = $this->loadModel('parametros');
        @$layout = $this->layout($_POST['val']);
        $this->_view->titulo = 'Aprendices';
        $this->_view->metodo = "Parametros";
        $this->_view->metodoaccion = 'Aprendices';
        $this->_view->usuarios = $data->aprendices();
        $this->_view->instituciones = $data->instituciones();
        $this->_view->renderizar('aprendices', 'vidar', $layout);
    }

    public function bajafichas($argum = false) {
        $data = $this->loadModel('parametros');
        $sql = $data->bajafichas($argum);
        if ($sql) {
            Session::set('mensaje', 'Operacion exitosa');
            Session::set('tipomensaje', 'alert-success');
        } else {
            Session::set('mensaje', 'Error en el proceso');
            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('parametros/fichas');
        exit();
    }

    public function setfichas() {
        $data = $this->loadModel('parametros');
        $sql = $data->setficha();
        if ($sql) {
            Session::set('mensaje', 'Operacion exitosa');
            Session::set('tipomensaje', 'alert-success');
        } else {
            Session::set('mensaje', 'Error en el proceso');
            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('parametros/fichas');
        exit();
    }

    public function formulariofichas() {
        $data = $this->loadModel('parametros');
        $this->_view->instituciones = $data->instituciones();
        if (!empty($_POST['id'])) {
            $sql = $data->oneficha();
            $this->_view->programas = $data->programasinstitucion($sql[0]['fchaIdInstitucion']);
            $this->_view->datos = $data->oneficha();
            $this->_view->accion = 'Editar Fichas';
        } else {
            $this->_view->programas = array();
            $this->_view->datos = array(4);
            $this->_view->accion = 'Agregar Fichas';
        }
        $this->_view->renderizar('formulariofichas', 'blank');
    }

    public function fichas() {
        Session::accesoEstricto(array('Administrador', 'Instructor'), true);
        $data = $this->loadModel('parametros');
        @$layout = $this->layout($_POST['val']);
        $this->_view->titulo = 'Fichas';
        $this->_view->metodo = "Parametros";
        $this->_view->metodoaccion = 'Fichas';
        $this->_view->fichas = $data->fichas();
        $this->_view->renderizar('fichas', 'vidar', $layout);
    }

    public function bajaprogramas($argum = false) {
        $data = $this->loadModel('parametros');
        $sql = $data->bajaprogramas($argum);
        if ($sql) {
            Session::set('mensaje', 'Operacion exitosa');
            Session::set('tipomensaje', 'alert-success');
        } else {
            Session::set('mensaje', 'Error en el proceso');
            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('parametros/programas');
        exit();
    }

    public function setprogramas() {
        $data = $this->loadModel('parametros');
        $sql = $data->setprograma();
        if ($sql) {
            Session::set('mensaje', 'Operacion exitosa');
            Session::set('tipomensaje', 'alert-success');
        } else {
            Session::set('mensaje', 'Error en el proceso');
            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('parametros/programas');
        exit();
    }

    public function formularioprogramas() {
        $data = $this->loadModel('parametros');
        $this->_view->instituciones = $data->instituciones();
        if (!empty($_POST['id'])) {
            $this->_view->accion = 'Editar Programas';
            $this->_view->datos = $data->oneprograma();
        } else {
            $this->_view->datos = array(2);
            $this->_view->accion = 'Agregar Programas';
        }
        $this->_view->renderizar('formularioprogramas', 'blank');
    }

    public function programas() {
        Session::acceso('Administrador');
        $data = $this->loadModel('parametros');
        @$layout = $this->layout($_POST['val']);
        $this->_view->titulo = 'Programas';
        $this->_view->metodo = "Parametros";
        $this->_view->metodoaccion = 'Programas';
        $this->_view->programas = $data->programas();
        $this->_view->renderizar('programas', 'vidar', $layout);
    }

    public function bajainstituciones($arg = false) {
        $data = $this->loadModel('parametros');
        $sql = $data->bajainstituciones($arg);
        if ($sql) {
            Session::set('mensaje', 'Operacion exitosa');
            Session::set('tipomensaje', 'alert-success');
        } else {
            Session::set('mensaje', 'Error en el proceso');
            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('parametros/institucion');
        exit();
    }

    public function setinstitucion() {
        $data = $this->loadModel('parametros');
        $sql = $data->setinstitucion();
        if ($sql) {
            Session::set('mensaje', 'Operacion exitosa');
            Session::set('tipomensaje', 'alert-success');
        } else {
            Session::set('mensaje', 'Error en el proceso');
            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('parametros/institucion');
        exit();
    }

    public function ciudades() {
        $data = $this->loadModel('parametros');
        $this->_view->ciudades = $data->oneciudad($_POST['id']);
        $this->_view->renderizar('ciudades', 'blank');
    }

    public function estados() {
        $data = $this->loadModel('parametros');
        $this->_view->estados = $data->oneestado($_POST['id']);
        $this->_view->renderizar('estados', 'blank');
    }

    public function formularioinstitucion() {
        $data = $this->loadModel('parametros');
        $this->_view->paises = $data->paises();
        if (!empty($_POST['id'])) {
            $this->_view->accion = 'Editar Institucion';
            $this->_view->datos = $data->oneinstitucion();
            $datos = $data->oneinstitucion();
            $this->_view->estados = $data->oneestado($datos[0]['pa']);
            $this->_view->ciudades = $data->oneciudad($datos[0]['est']);
        } else {
            $this->_view->estados = array(0);
            $this->_view->ciudades = array(0);
            $this->_view->accion = 'Agregar Institucion';
            $this->_view->datos = array(7);
        }
        $this->_view->renderizar('formularioInstitucion', 'blank');
    }

    public function institucion() {
        Session::acceso('Administrador');
        $data = $this->loadModel('parametros');
        @$layout = $this->layout($_POST['val']);
        $this->_view->instituciones = $data->instituciones();
        $this->_view->titulo = 'Instituciones';
        $this->_view->metodo = "Parametros";
        $this->_view->metodoaccion = 'Instituciones';
        $this->_view->renderizar('instituciones', 'vidar', $layout);
    }

}
