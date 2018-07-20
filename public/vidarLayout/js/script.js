$(document).ready(function () {
    var host = 'http://localhost/vidar/';
    //var host = 'https://ganadinero.000webhostapp.com/vidar/';
    $(document).on('click', '#btnEnviarPasswordCuenta', function () {
        var data = {
            'password': $('#txtPasswordDatos').val()
        };
        cargadivconsulta('MostrarResultadoCuenta', host + 'inicio/validateaccountuser/', data);
    });
    $(document).on('click', '#btnEnviarPassword', function () {
        var data = {
            'password': $('#txtPasswordDatos').val()
        };
        cargadivconsulta('MostrarResultado', host + 'inicio/validateuserdatos/', data);
    });
    $(document).on('click', '#btnVerNovedades', function () {
        var data = {
            'id': $(this).val()
        };
        $('#modalNovedades').modal('show');
        cargadivconsulta('contenidoModal', host + 'reportes/carganovedadesaprendices/', data);
    });
    $(document).on('click', '#btnGenerarReporteNovedades', function () {
        var ficha = $('#selFicha').val();
        var aprendiz = $('#selAprendiz').val();
        var data = {
            'ficha': ficha,
            'aprendiz': aprendiz
        };
        cargadivconsulta('CargaReporteNovedades', host + 'reportes/genreportenovedades/', data);
    });
    $(document).on('change', '#selInstitucion', function () {
        var data = {
            'id': $(this).val()
        };
        cargadivconsulta('cargarProgramas', host + 'parametros/cargaprogramas/', data);
    });
    $(document).on('change', '#selInstitucion2', function () {
        var data = {
            'id': $(this).val()
        };
        cargadivconsulta('cargarProgramas2', host + 'procesos/cargaprogramas2/', data);
    });
    $(document).on('click', '#btnbuscarUsuariosNovedades', function () {
        var data = {
            'id': $('#selFicha').val()
        };
        cargadivconsulta('cargarTablaUsuariosNovedades', host + 'procesos/usuariosnovedades/', data);
    });
    $(document).on('change', '#cargarNovedades', function () {
        var data = {
            'tipo': $(this).val()
        };
        cargadivconsulta('mostrarNovedades', host + 'procesos/cargarnovedadespredefinidas/', data);
    });
    $(document).on('click', '#btnAgregarAspecto', function () {
        var data = {
            'id': ''
        };
        cargadivconsulta('vista', host + 'parametros/formularioaspectos/', data);
    });
    $(document).on('click', '#btnEditarAspectos', function () {
        var data = {
            'id': $(this).val()
        };
        cargadivconsulta('vista', host + 'parametros/formularioaspectos/', data);
    });
    $(document).on('click', '#btnAgregarReglamento', function () {
        var data = {
            'id': ''
        };
        cargadivconsulta('vista', host + 'parametros/formularioreglamento/', data);
    });
    $(document).on('click', '#btnEditarReglamento', function () {
        var data = {
            'id': $(this).val()
        };
        cargadivconsulta('vista', host + 'parametros/formularioreglamento/', data);
    });
    $(document).on('click', '#btnbuscarComiteFiltro', function () {
        var data = {
            'id': $('#selFicha').val()
        };
        cargadivconsulta('cargarTablaFiltroComite', host + 'reportes/filtrocomites/', data);
    });
    $(document).on('click', '#btnbuscarPlanesMejoramiento', function () {
        var data = {
            'id': $('#selFicha').val()
        };
        cargadivconsulta('cargarTablaPlanesMejoramiento', host + 'procesos/filtraplanesmejoramiento/', data);
    });
    $(document).on('click', '#btnVerDatosPlan', function () {
        var data = {
            'id': $(this).val()
        };
        $('#modalplanesMejoramiento').modal('show');
        cargadivconsulta('contenidoModal', host + 'procesos/verdatosplanmejoramiento/', data);
    });
    $(document).on('click', '#btnCalificarPlan', function () {
        var data = {
            'id': $(this).val()
        };
        $('#modalplanesMejoramiento').modal('show');
        cargadivconsulta('contenidoModal', host + 'procesos/calificarplanmejoramiento/', data);
    });
    $(document).on('click', '#btnEliminarPlanMejoramiento', function () {
        var data = {
            'planid': $(this).val(),
            'id': $('#txtCodigo').val()
        };
        cargadivconsulta('tablaAprendicesplan', host + 'procesos/deletedetalleplan/', data);
    });
    $(document).on('change', '#selFicha', function () {
        var data = {
            'id': $(this).val()
        };
        cargadivconsulta('tablaAprendicesplan', host + 'procesos/cargatablaaprendices/', data);
        cargadivconsulta('cargaAprendicesInasistencia', host + 'reportes/cargaraprendices/', data);
    });
    $(document).on('click', '#btnAgregarPlan', function () {
        var data = {
            'id': ''
        };
        $('#modalplanesMejoramiento').modal('show');
        cargadivconsulta('contenidoModal', host + 'procesos/formularioplanmejoramiento/', data);
    });
    $(document).on('click', '#btnEditarPlan', function () {
        var data = {
            'id': $(this).val()
        };
        $('#modalplanesMejoramiento').modal('show');
        cargadivconsulta('contenidoModal', host + 'procesos/formularioplanmejoramiento/', data);
    });
    $(document).on('click', '#btnInformacionComite', function () {
        var data = {
            'id': $(this).val()
        };
        $('#modalComites').modal('show');
        cargadivconsulta('contenidoModal', host + 'reportes/detallecomite/', data);
    });
    $(document).on('click', '#btnPlanMejoramiento', function () {
        var data = {
            'id': $(this).val()
        };
        $('#modalComites').modal('show');
        cargadivconsulta('contenidoModal', host + 'reportes/asignarplanmejoramiento/', data);
    });
    $(document).on('click', '#btnEliminarInstructor', function () {
        var id = $(this).val();
        var ficha = $(this).attr('data-ficha');
        var data = {
            'id': id,
            'ficha': ficha
        };
        cargadivconsulta('cargaFichaInstructores', host + 'parametros/setusuariosinstructores/', data);
    });
    $(document).on('click', '#btnEliminarAprendiz', function () {
        var id = $(this).val();
        var ficha = $(this).attr('data-ficha');
        var data = {
            'id': id,
            'ficha': ficha
        };
        cargadivconsulta('cargaFichaAprendices', host + 'parametros/setusuariosaprendiz/', data);
    });
    $(document).on('click', '#btnAsignarUsers', function () {
        var data = {
            'ficha': $(this).val()
        };
        cargadivconsulta('vista', host + 'parametros/usuariosasignadosfichas/', data);
    });
    $(document).on('click', '#btnQuitar', function () {
        var comite = $(this).attr('data-comite');
        var data = {
            'id': comite,
            'iddetalle': $(this).val()
        };
        cargadivconsulta('tablaInstructores', host + 'procesos/cargatablasinstructores/', data);
    });
    $(document).on('change', '#selActa', function () {
        var data = {
            'acta': $(this).val()
        };
        cargadivconsulta('cargarDocumento', host + 'procesos/mostrardocumento/', data);
    });
    $(document).on('click', '#btnbuscaraprendicesComite', function () {
        var ficha = $('#selFicha').val();
        var data = {
            'ficha': ficha
        };
        if (ficha != '') {
            cargadivconsulta('cargarTablaAprendicesComite', host + 'procesos/aprendicescomite/', data);
        } else {
            console.log('Seleccione una ficha');
            return;
        }
    });
    $(document).on('click', '#btnAgregarActas', function () {
        var data = {
            'id': ''
        };
        cargadivconsulta('vista', host + 'parametros/formularioactas/', data);
    });
    $(document).on('click', '#btnEditarActas', function () {
        var data = {
            'id': $(this).val()
        };
        cargadivconsulta('vista', host + 'parametros/formularioactas/', data);
    });
    $(document).on('click', '#btnGenerarReporte', function () {
        var ficha = $('#selFicha').val();
        var fi = $('#fi').val();
        var ff = $('#ff').val();
        var aprendiz = $('#selAprendiz').val();
        var data = {
            'ficha': ficha,
            'fi': fi,
            'ff': ff,
            'aprendiz': aprendiz
        };
        cargadivconsulta('CargaReporte', host + 'reportes/genasistencia/', data);
    });
    $(document).on('change', '#checkaprendices', function () {
        var id = $(this).attr('data-id');
        $('.seleccione' + id).prop('checked', false);
        $(this).prop('checked', true);
    });
    $(document).on('change', '#chek2', function () {
        var id = $(this).attr('data-id');
        $('.seleccion' + id).prop('checked', false);
        $(this).prop('checked', true);
    });
    $(document).on('click', '#btnbuscaraprendicesInsasistencia', function () {
        var ficha = $('#selFicha').val();
        var data = {
            'ficha': ficha
        };
        if (ficha != '') {
            cargadivconsulta('cargarTablaAprendicesInsasistencia', host + 'procesos/listadoaprendicesinasistencia/', data);
        } else {
            alert('Por favor seleccione una ficha');
            return;
        }
    });
    $(document).on('click', '#btnArchivoPlano', function () {
        $('#modalAsignar').modal('show');
        var data = {
            'ficha': $('#numFicha').val()
        };
        cargadivconsulta('contenidoModal', host + 'procesos/modalarchivos/', data);
    });
    $(document).on('click', '#btnGuardarUsuariosAsignar', function () {
        var ficha = $('#selFicha').val();
        if (ficha != '') {
            $('#formAsignar').submit();
        } else {
            alert('Seleccione una ficha');
            return;
        }
    });
    $(document).on('click', '#btnbuscaraprendicesAsignar', function () {
        var data = {
            'ficha': $('#selFicha').val()
        };
        cargadivconsulta('cargarTablaAprendicesAsignar', host + 'procesos/tablaaprendicesasignar/', data);
    });
    $(document).on('click', '#btnbuscaraprendices', function () {
        var data = {
            'ficha': $('#selFicha').val()
        };
        cargadivconsulta('cargarTablaAprendices', host + 'parametros/tablaaprendices/', data);
    });
    $(document).on('change', '#selPrograma2', function () {
        var data = {
            'institucion': $('#selInstitucion').val(),
            'programa': $(this).val()

        };
        cargadivconsulta('cargafichas2', host + 'parametros/cargarfichas/', data);
    });
    $(document).on('change', '#selPrograma', function () {
        var data = {
            'institucion': $('#selInstitucion').val(),
            'programa': $(this).val()

        };
        cargadivconsulta('cargafichas', host + 'parametros/cargarfichas/', data);
    });
    $(document).on('change', '#selPrograma', function () {
        var data = {
            'institucion': $('#selInstitucion').val(),
            'programa': $(this).val()

        };
        cargadivconsulta('cargafichas', host + 'parametros/cargarfichas/', data);
    });
    $(document).on('click', '#btnAgregarAprendices', function () {
        var data = {
            'id': ''
        };
        cargadivconsulta('vista', host + 'parametros/formularioaprendices/', data);
    });
    $(document).on('click', '#btnEditarAprendices', function () {
        var data = {
            'id': $(this).val()
        };
        cargadivconsulta('vista', host + 'parametros/formularioaprendices/', data);
    });
    $(document).on('click', '#btnAgregarFichas', function () {
        var data = {
            'id': ''
        };
        cargadivconsulta('vista', host + 'parametros/formulariofichas/', data);
    });
    $(document).on('click', '#btnEditarFichas', function () {
        var data = {
            'id': $(this).val()
        };
        cargadivconsulta('vista', host + 'parametros/formulariofichas/', data);
    });
    $(document).on('click', '#btnAgregarProgramas', function () {
        var data = {
            'id': ''
        };
        cargadivconsulta('vista', host + 'parametros/formularioprogramas/', data);
    });
    $(document).on('click', '#btnEditarProgramas', function () {
        var data = {
            'id': $(this).val()
        };
        cargadivconsulta('vista', host + 'parametros/formularioprogramas/', data);
    });
    $(document).on('change', '#selPais', function () {
        var data = {
            'id': $(this).val()
        };
        cargadivconsulta('divestado', host + 'parametros/estados/', data);
    });
    $(document).on('change', '#selEstado', function () {
        var data = {
            'id': $(this).val()
        };
        cargadivconsulta('divciudad', host + 'parametros/ciudades/', data);
    });
    $(document).on('click', '#btnAgregarInstituciones', function () {
        var data = {
            'id': ''
        };
        cargadivconsulta('vista', host + 'parametros/formularioinstitucion/', data);
    });
    $(document).on('click', '#btnEditarinst', function () {
        var data = {
            'id': $(this).val()
        };
        cargadivconsulta('vista', host + 'parametros/formularioinstitucion/', data);
    });
    $(document).on('click', '#btnAutorizar', function () {
        $('#modalAutorizar').modal('show');
        var data = {
            'id': $(this).val()
        };
        cargadivconsulta('contenidoModal', host + 'procesos/modalroles/', data);
    });
    $(document).on('click', 'a[class="metodoEnlace"]', function (e) {
        e.preventDefault();
        var enlace = $(this).attr('href');
        var item = $(this).attr('data-i');
        var title = $(this).attr('data-title');
        $('.items').each(function () {
            $(this).removeAttr('class');
        });
        $('#item' + item).attr('class', 'items active');
        $('title').text(title);
        renderizarAjax('cargarPagina', enlace, '');
    });
    window.onload = cerrar;
    function cerrar() {
        $("#carga").animate({"opacity": "0"}, 1000, function () {
            $("#carga").css("display", "none");
        });
    }
    $("#carga").click(function () {
        cerrar();
    });
    //**************************************** ANIMACION OCULTA MENSAJE**********************************************************
    setTimeout(function () {
        $("#mensaje").fadeOut(1500);
    }, 3000);
});
function renderizarAjax(div, ruta, data) {
    $('#' + div).show();
    var layout = {
        'val': 'A'
    };
    $.ajax({
        type: 'POST',
        url: ruta,
        data: layout,
        async: false,
        success: function (html) {
            $('#' + div).html(html);
        }, beforeSend: function () {
            $('#cargando').attr('class', 'loader');
            $(".loader-img").attr('style', '');
            $(".loader").attr('style', '');
        }, complete: function () {
            $(".loader-img").fadeOut();
            $(".loader").fadeOut("slow");
        }
    });
}