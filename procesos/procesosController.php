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

    public function cargaprogramas2() {
        $data = $this->loadModel('parametros');
        $this->_view->programas = $data->cargaprogramas();
        $this->_view->renderizar('cargaprograma', 'blank');
    }

    public function setnovedad() {
        $data = $this->loadModel('procesos');
        $sql = $data->setnovedad();
        if ($sql) {
            Session::set('mensaje', 'Operacion exitosa');
            Session::set('tipomensaje', 'alert-success');
        } else {
            Session::set('mensaje', 'Error en el proceso');
            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('procesos/novedades');
        exit();
    }

    public function cargarnovedadespredefinidas() {
        $data = $this->loadModel('procesos');
        $this->_view->novedades = $data->onenovedades();
        $this->_view->renderizar('formularionovedades', 'blank');
    }

    public function usuariosnovedades() {
        $data = $this->loadModel('procesos');
        $this->_view->ficha = $_POST['id'];
        $this->_view->usuarios = $data->usuariosnovedades();
        $this->_view->renderizar('usuariosnovedades', 'blank');
    }

    public function novedades() {
        Session::accesoEstricto(array('Administrador', 'Instructor', 'Coordinador Academico'), true);
        $data = $this->loadModel('procesos');
        $dataparametros = $this->loadModel('parametros');
        $this->_view->instituciones = $dataparametros->instituciones();
        @$layout = $this->layout($_POST['val']);
        $this->_view->titulo = 'Novedades';
        $this->_view->metodo = "Procesos";
        $this->_view->metodoaccion = 'Novedades';
        $this->_view->renderizar('novedades', 'vidar', $layout);
    }

    public function verdatosplanmejoramiento() {
        $data = $this->loadModel('procesos');
        $this->_view->datos = $data->detalleplan();
        $this->_view->renderizar('detalleplan', 'blank');
    }

    public function setcalificacionplanmejoramiento() {
        $data = $this->loadModel('procesos');
        $sql = $data->setcalificacion();
        if ($sql) {
            Session::set('mensaje', 'Operacion exitosa');
            Session::set('tipomensaje', 'alert-success');
        } else {
            Session::set('mensaje', 'Error en el proceso');
            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('procesos/planesdemejoramiento');
        exit();
    }

    public function calificarplanmejoramiento() {
        $data = $this->loadModel('procesos');
        $this->_view->datos = $data->datoscalificarplan();
        $this->_view->renderizar('calificarplan', 'blank');
    }

    public function bajaplanesmejoramiento($argum = false) {
        $data = $this->loadModel('procesos');
        $sql = $data->bajaplanesmejoramiento($argum);
        if ($sql) {
            Session::set('mensaje', 'Operacion exitosa');
            Session::set('tipomensaje', 'alert-success');
        } else {
            Session::set('mensaje', 'Error en el proceso');
            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('procesos/planesdemejoramiento');
        exit();
    }

    public function setplanmejoramiento() {
        $data = $this->loadModel('procesos');
        $sql = $data->setplanmejoramiento();
        if ($sql) {
            Session::set('mensaje', 'Operacion exitosa');
            Session::set('tipomensaje', 'alert-success');
        } else {
            Session::set('mensaje', 'Error en el proceso');
            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('procesos/planesdemejoramiento');
        exit();
    }

    public function deletedetalleplan() {
        $data = $this->loadModel('procesos');
        $sql = $data->bajadetalleplan();
        if ($sql) {
            $this->_view->datos = $data->oneusuariosplanmejoramiento();
            $this->_view->renderizar('tablausuarioseditar', 'blank');
        }
    }

    public function cargatablaaprendices() {
        $data = $this->loadModel('procesos');
        $this->_view->usuarios = $data->seleccionaprendices();
        $this->_view->renderizar('tablaaprendices', 'blank');
    }

    public function formularioplanmejoramiento() {
        $data = $this->loadModel('procesos');
        $dataparametros = $this->loadModel('parametros');
        $this->_view->instituciones = $dataparametros->instituciones();
        $this->_view->programas = $dataparametros->programas();
        if (!empty($_POST['id'])) {
            $this->_view->datos = $data->oneplanmejoramiento();
            $datos = $data->oneplanmejoramiento();
            $this->_view->fichas = $data->oneficha($datos[0]['proId'], $datos[0]['instId']);
            $this->_view->accion = 'Agregar plan de mejoramiento';
        } else {
            $this->_view->fichas = array();
            $this->_view->datos = array(6);
            $this->_view->accion = 'Editar plan de mejoramiento';
        }
        $this->_view->renderizar('formularioplanes', 'blank');
    }

    public function filtraplanesmejoramiento() {
        $data = $this->loadModel('procesos');
        $this->_view->planes = $data->filtraplanesmejoramiento();
        $this->_view->renderizar('filtraplanes', 'blank');
    }

    public function planesdemejoramiento() {
        Session::accesoEstricto(array('Administrador', 'Instructor'), true);
        $data = $this->loadModel('procesos');
        $dataparametros = $this->loadModel('parametros');
        $this->_view->instituciones = $dataparametros->instituciones();
        $this->_view->planes = $data->listarplanesdemejoramiento();
        @$layout = $this->layout($_POST['val']);
        $this->_view->titulo = 'Planes de mejoramiento';
        $this->_view->metodo = "Procesos";
        $this->_view->metodoaccion = 'Planes de mejoramiento';
        $this->_view->renderizar('planmejoramiento', 'vidar', $layout);
    }

    public function cargatablasinstructores() {
        $data = $this->loadModel('procesos');
        $sql = $data->bajadetallecomite();
        if ($sql) {
            $this->_view->usuarios = $data->listainstructores();
            $this->_view->renderizar('tablainstructores', 'blank');
        }
    }

    public function guardardatoscomite() {
        $data = $this->loadModel('procesos');
        $sql = $data->setagendacomite();
        if ($sql) {
            $datos = $data->usuarioscorreo();
            for ($i = 0; $i < count($datos); $i++) {
                $mensaje = 'Usted ha sido citado al comite de evaluacion y seguimiento que se realizara el dia ' . $datos[$i]['comFechaComite'] . ' a las ' . $datos[$i]['comHoraComite'] . ' en ' . $datos[$i]['comLugar'];
                $correo = $datos[$i]['usuCorreo'];
                $this->sendcorreo($mensaje, $correo);
            }
            Session::set('mensaje', 'Operacion exitosa');
            Session::set('tipomensaje', 'alert-success');
        } else {
            Session::set('mensaje', 'Error en el proceso');
            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('procesos/agendarcomite');
        exit();
    }

    public function sendcorreo($mensaje, $correo) {
        $this->getLibrary('phpmailer' . DS . 'PHPMailerAutoload');
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'rubendariorochalizcano@gmail.com';
        $mail->Password = '1079185602';
        $mail->SMTPSecure = "ssl";
        $mail->Port = 465;
        $mail->From = 'rubendariorochalizcano@gmail.com';
        $mail->FromName = 'COMITE DE EVALUACION'; //titulo del correo
        $email = $correo; //usuarios al que va destinado el correo
        $nombre = "SENA"; //Nombre de usuarios
        $apellidos = ""; //Apellidos si los quieres
        $message = $mensaje;
        $mail->addAddress($email, $nombre . $apellidos);
        $mail->WordWrap = 50;
        $mail->isHTML(true);
        $mail->Subject = 'Invitacion comite de evaluacion'; //encabezado
        $mail->Body = $message;
        $mail->CharSet = 'UTF-8';
        if (!$mail->send()) {
            
        } else {
            
        }
    }

    public function setagendarcomite() {
        $data = $this->loadModel('procesos');
        $this->_view->id = $_POST['id'];
        $this->_view->datos = $data->onecomite();
        $this->_view->usuarios = $data->listainstructores();
        $this->_view->renderizar('formularioagendar', 'blank');
    }

    public function agendarcomite() {
        Session::accesoEstricto(array('Administrador', 'Coordinador Academico'), true);
        $data = $this->loadModel('procesos');
        @$layout = $this->layout($_POST['val']);
        $this->_view->titulo = 'Agendar Comite';
        $this->_view->metodo = "Procesos";
        $this->_view->metodoaccion = 'Agendar Comite';
        $this->_view->comites = $data->listacomites();
        $this->_view->renderizar('agendarcomite', 'vidar', $layout);
    }

    public function setcomite() {
        $data = $this->loadModel('procesos');
        $sql = $data->setcomite();
        if ($sql) {
            Session::set('mensaje', 'Operacion exitosa');
            Session::set('tipomensaje', 'alert-success');
        } else {
            Session::set('mensaje', 'Error en el proceso');
            Session::set('tipomensaje', 'alert-danger');
        }
        $this->redireccionar('procesos/solicitarcomite');
        exit();
    }

    public function aprendicescomite() {
        $data = $this->loadModel('procesos');
        $this->_view->usuarios = $data->aprendicescomite();
        $this->_view->actas = $data->actascomite();
        $this->_view->ficha = $_POST['ficha'];
        $this->_view->renderizar('aprendicescomite', 'blank');
    }

    public function mostrardocumento() {
        $data = $this->loadModel('procesos');
        $this->_view->acta = $data->actadocumento();
        $this->_view->renderizar('documento', 'blank');
    }

    public function solicitarcomite() {
        Session::accesoEstricto(array('Administrador', 'Instructor'), true);
        $data = $this->loadModel('parametros');
        $this->_view->instituciones = $data->instituciones();
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
        $this->_view->horas = $data->listahoras();
        $this->_view->usuarios = $data->listaaprendicesinasistencia();
        $this->_view->renderizar('usuariosinasistencia', 'blank');
    }

    public function inasistencia() {
        Session::accesoEstricto(array('Administrador', 'Instructor'), true);
        $data = $this->loadModel('parametros');
        $this->_view->instituciones = $data->instituciones();
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
        Session::accesoEstricto(array('Administrador', 'Instructor'), true);
        $data = $this->loadModel('parametros');
        $this->_view->instituciones = $data->instituciones();
        @$layout = $this->layout($_POST['val']);
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
        Session::acceso('Administrador');
        $data = $this->loadModel('procesos');
        $this->_view->usuarios = $data->autorizausuarios();
        @$layout = $this->layout($_POST['val']);
        $this->_view->titulo = 'Autorizar Usuarios';
        $this->_view->metodo = "Procesos";
        $this->_view->metodoaccion = 'Autorizar Usuarios';
        $this->_view->renderizar('autorizarUsuarios', 'vidar', $layout);
    }

}
