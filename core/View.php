<?php

class View {

    private $_cont;

    public function __construct($c) {
        $this->_cont = $c;
    }

    public function renderizar($vista, $layout, $NoLayout = false) {
        $nombrelayoyt = $layout . "Layout";
        $men1 = $this->menu();
        $_layoutParams = array(
            'ruta_img' => RUTA_URL . 'public/' . $nombrelayoyt . '/img/',
            'ruta_js' => RUTA_URL . 'public/' . $nombrelayoyt . '/js/',
            'ruta_css' => RUTA_URL . 'public/' . $nombrelayoyt . '/css/',
            'menu' => $men1
        );
        $rutaview = ROOT . $this->_cont . DS . 'views' . DS . $vista . '.phtml';
        if (is_readable($rutaview)) {
            if ($NoLayout) {
                include_once $rutaview;
                exit();
            }
            include_once ROOT . 'public' . DS . $nombrelayoyt . DS . 'header.phtml';
            include_once $rutaview;
            include_once ROOT . 'public' . DS . $nombrelayoyt . DS . 'footer.phtml';
        } else {
            throw new Exception("error en la vista");
        }
    }

    public function menu() {
        if (Session::get('autenticado') && Session::get('perfil') == 'Administrador') {
            $subreportes = array(
                array(
                    'id' => 'rep1',
                    'titulo' => 'Asistencia',
                    'title' => 'Asistencia',
                    'icono' => 'fa fa-calendar',
                    'enlace' => RUTA_URL . 'reportes/asistenciamyt'
                ),
                array(
                    'id' => 'rep2',
                    'titulo' => 'Novedades',
                    'title' => 'Novedades',
                    'icono' => 'fa fa-calendar',
                    'enlace' => RUTA_URL . 'reportes/novedades'
                ),
                array(
                    'id' => 'rep3',
                    'titulo' => 'Comite de evaluacion',
                    'title' => 'Comite de evaluacion',
                    'icono' => 'fa fa-calendar',
                    'enlace' => RUTA_URL . 'reportes/comitedeevaluacion'
                ),
            );
            $subprocesos = array(
                array(
                    'id' => 'proc1',
                    'titulo' => 'Autorizar Usuario',
                    'title' => 'Autorizar Usuarios',
                    'icono' => 'fa fa-check-circle',
                    'enlace' => RUTA_URL . 'procesos/autorizarusuario'
                ),
                array(
                    'id' => 'proc2',
                    'titulo' => 'Solicitar comite de evaluacion',
                    'title' => 'Solicitar comite de evaluacion',
                    'icono' => 'fa fa-check-circle',
                    'enlace' => RUTA_URL . 'procesos/solicitarcomite'
                ),
                array(
                    'id' => 'proc5',
                    'titulo' => 'Programar comite evaluacion',
                    'title' => 'Programar comite de evaluacion',
                    'icono' => 'fa fa-check-circle',
                    'enlace' => RUTA_URL . 'procesos/programarcomite'
                ),
                array(
                    'id' => 'proc3',
                    'titulo' => 'Asignar Aprendices',
                    'title' => 'Asignar aprendices ficha',
                    'icono' => 'fa fa-check-circle',
                    'enlace' => RUTA_URL . 'procesos/asignaraprendices'
                ),
                array(
                    'id' => 'proc4',
                    'titulo' => 'Registrar Inasistencia',
                    'title' => 'Registrar Inasistencia',
                    'icono' => 'fa fa-check-circle',
                    'enlace' => RUTA_URL . 'procesos/inasistencia'
                ),
                array(
                    'id' => 'proc6',
                    'titulo' => 'Novedad Academica',
                    'title' => 'Novedad Academica',
                    'icono' => 'fa fa-check-circle',
                    'enlace' => RUTA_URL . 'procesos/novedadacademica'
                ),
                array(
                    'id' => 'proc7',
                    'titulo' => 'Novedad Disciplinaria',
                    'title' => 'Novedad Disciplinaria',
                    'icono' => 'fa fa-check-circle',
                    'enlace' => RUTA_URL . 'procesos/novedaddisciplinaria'
                ),
            );
            $subparametros = array(
                array(
                    'id' => 'pro',
                    'titulo' => 'Aprendices',
                    'title' => 'Aprendices',
                    'icono' => 'fa fa-newspaper-o',
                    'enlace' => RUTA_URL . 'parametros/aprendices'
                ),
                array(
                    'id' => 'pro2',
                    'titulo' => 'Fichas',
                    'title' => 'Fichas',
                    'icono' => 'fa fa-newspaper-o',
                    'enlace' => RUTA_URL . 'parametros/fichas'
                ),
                array(
                    'id' => 'pro6',
                    'titulo' => 'Programas',
                    'title' => 'Programas',
                    'icono' => 'fa fa-newspaper-o',
                    'enlace' => RUTA_URL . 'parametros/programas'
                ),
                array(
                    'id' => 'pro3',
                    'titulo' => 'Faltas y aspectos positivos',
                    'title' => 'Faltas y aspectos positivos',
                    'icono' => 'fa fa-newspaper-o',
                    'enlace' => RUTA_URL . 'parametros/faltasyaspectos'
                ),
                array(
                    'id' => 'pro4',
                    'titulo' => 'Institucion',
                    'title' => 'Institucion',
                    'icono' => 'fa fa-newspaper-o',
                    'enlace' => RUTA_URL . 'parametros/institucion'
                ),
                array(
                    'id' => 'pro5',
                    'titulo' => 'Actas de equipo ejecutor',
                    'title' => 'Actas de equipo ejecutor',
                    'icono' => 'fa fa-newspaper-o',
                    'enlace' => RUTA_URL . 'parametros/actasequipo'
                )
            );
            $menu = array(
                array(
                    'id' => 'inicio',
                    'titulo' => 'Inicio',
                    'title' => 'Inicio',
                    'icono' => 'fa fa-home',
                    'enlace' => RUTA_URL . 'inicio/portal',
                    'sub' => '',
                ),
                array(
                    'id' => 'parametros',
                    'titulo' => 'Parametros',
                    'icono' => 'fa fa-book',
                    'enlace' => '',
                    'sub' => $subparametros
                ),
                array(
                    'id' => 'procesos',
                    'titulo' => 'Procesos',
                    'icono' => 'fa fa-cog',
                    'enlace' => '',
                    'sub' => $subprocesos
                ),
                array(
                    'id' => 'reportes',
                    'titulo' => 'Reportes',
                    'icono' => 'fa fa-server',
                    'enlace' => '',
                    'sub' => $subreportes
                )
            );
        } else if (Session::get('autenticado') && Session::get('level') == 'Usuario') {
            $subreportes = array(
                array(
                    'id' => 'rep1',
                    'titulo' => 'Asistencia',
                    'title' => 'Asistencia',
                    'icono' => 'fa fa-calendar',
                    'enlace' => RUTA_URL . 'reportes/asistencia'
                ),
                array(
                    'id' => 'rep2',
                    'titulo' => 'Horas Trabajadas',
                    'title' => 'Horas Trabajadas',
                    'icono' => 'fa fa-hourglass',
                    'enlace' => RUTA_URL . 'reportes/asistenciahorasvoluntarios'
                ),
            );
            $subsesion = array(
                array(
                    'id' => 'cerrar',
                    'titulo' => 'Editar Informacion',
                    'title' => 'Editar Informacion',
                    'icono' => 'fa fa-edit',
                    'enlace' => RUTA_URL . 'sesion/editarinformacion',
                ),
                array(
                    'id' => 'cerrar',
                    'titulo' => 'Configurar Cuenta',
                    'title' => 'Configurar Cuenta',
                    'icono' => 'fa fa-address-book-o',
                    'enlace' => RUTA_URL . 'sesion/cambiarpassword',
                )
            );
            $menu = array(
                array(
                    'id' => 'inicio',
                    'titulo' => 'Inicio',
                    'title' => 'Inicio',
                    'icono' => 'fa fa-home',
                    'enlace' => RUTA_URL . 'inicio/portal',
                    'sub' => '',
                ),
                array(
                    'id' => 'parametros',
                    'titulo' => 'Formulario',
                    'title' => 'Formulario',
                    'icono' => 'fa fa-book',
                    'enlace' => RUTA_URL . 'parametros/formularioconvocatoria',
                    'sub' => '',
                ),
                array(
                    'id' => 'reportes',
                    'titulo' => 'Reportes',
                    'icono' => 'fa fa-server',
                    'enlace' => '',
                    'sub' => $subreportes
                ),
                array(
                    'id' => 'excusas',
                    'titulo' => 'Subir excusa inasistencia',
                    'title' => 'Subir excusa inasistencia',
                    'icono' => 'fa fa-user-plus',
                    'enlace' => RUTA_URL . 'inicio/excusas',
                    'sub' => ''
                ),
                array(
                    'id' => 'mensajes',
                    'titulo' => 'Mensajes recibidos <span class="pull-right-container">
                    <span class="label label-primary pull-right" id="cantmensajes">4</span>
                    </span>',
                    'title' => 'Mensajes recibidos',
                    'icono' => 'fa fa-comments',
                    'enlace' => RUTA_URL . 'inicio/mensajeusuarios',
                    'sub' => '',
                ),
                array(
                    'id' => 'sesion',
                    'titulo' => 'Cuenta',
                    'icono' => 'fa fa-address-card',
                    'enlace' => '',
                    'sub' => $subsesion,
                ),
            );
        } else {
            $menu = array(
                array(
                    'id' => 'inicio',
                    'titulo' => 'Inicio',
                    'title' => 'Inicio',
                    'icono' => 'fa fa-home',
                    'enlace' => RUTA_URL . 'inicio/portal',
                    'sub' => '',
                ),
                array(
                    'id' => 'parametros',
                    'titulo' => 'Formulario Convocatoria',
                    'title' => 'Formulario Convocatoria',
                    'icono' => 'fa fa-newspaper-o',
                    'enlace' => RUTA_URL . 'parametros/formularioconvocatoria',
                    'sub' => '',
                ),
                array(
                    'id' => 'reportes',
                    'titulo' => 'Consultar Estado Convocatoria',
                    'title' => 'Consultar Estado Convocatoria',
                    'icono' => 'fa fa-search',
                    'enlace' => RUTA_URL . 'reportes/consultaestadoconvo',
                    'sub' => '',
                ),
                array(
                    'id' => 'sesion',
                    'titulo' => 'Iniciar Sesion',
                    'title' => 'Iniciar Sesion',
                    'icono' => 'fa fa-user',
                    'enlace' => RUTA_URL . 'inicio/index',
                    'sub' => '',
                ),
            );
        }
        return $menu;
    }

}
