$(document).ready(function () {
    var host = 'http://localhost/vidar/';
    //var host = 'https://ganadinero.000webhostapp.com/vidar/';
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
        var data = {
            'ficha': ficha,
            'fi': fi,
            'ff': ff
        };
        cargadivconsulta('CargaReporte', host + 'reportes/genasistencia/', data);
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
            'ficha': $('#selFicha').val(),
            'programa': $('#selPrograma').val(),
            'institucion': $('#selInstitucion').val()
        };
        cargadivconsulta('cargarTablaAprendices', host + 'parametros/tablaaprendices/', data);
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