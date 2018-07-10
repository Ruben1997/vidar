var RUTA_URL = 'http://localhost/vidar/';
$(document).ready(function () {
    $(document).on('click', '#btnArchivoPlano', function () {
        $('#modalAsignar').modal('show');
        var data = {
            'ficha': $('#numFicha').val()
        };
        cargadivconsulta('contenidoModal', RUTA_URL + 'procesos/modalarchivos/', data);
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
        cargadivconsulta('cargarTablaAprendicesAsignar', RUTA_URL + 'procesos/tablaaprendicesasignar/', data);
    });
    $(document).on('click', '#btnbuscaraprendices', function () {
        var data = {
            'ficha': $('#selFicha').val(),
            'programa': $('#selPrograma').val(),
            'institucion': $('#selInstitucion').val()
        };
        cargadivconsulta('cargarTablaAprendices', RUTA_URL + 'parametros/tablaaprendices/', data);
    });
    $(document).on('change', '#selPrograma', function () {
        var data = {
            'institucion': $('#selInstitucion').val(),
            'programa': $(this).val()

        };
        cargadivconsulta('cargafichas', RUTA_URL + 'parametros/cargarfichas/', data);
    });
    $(document).on('click', '#btnAgregarAprendices', function () {
        var data = {
            'id': ''
        };
        cargadivconsulta('vista', RUTA_URL + 'parametros/formularioaprendices/', data);
    });
    $(document).on('click', '#btnEditarAprendices', function () {
        var data = {
            'id': $(this).val()
        };
        cargadivconsulta('vista', RUTA_URL + 'parametros/formularioaprendices/', data);
    });
    $(document).on('click', '#btnAgregarFichas', function () {
        var data = {
            'id': ''
        };
        cargadivconsulta('vista', RUTA_URL + 'parametros/formulariofichas/', data);
    });
    $(document).on('click', '#btnEditarFichas', function () {
        var data = {
            'id': $(this).val()
        };
        cargadivconsulta('vista', RUTA_URL + 'parametros/formulariofichas/', data);
    });
    $(document).on('click', '#btnAgregarProgramas', function () {
        var data = {
            'id': ''
        };
        cargadivconsulta('vista', RUTA_URL + 'parametros/formularioprogramas/', data);
    });
    $(document).on('click', '#btnEditarProgramas', function () {
        var data = {
            'id': $(this).val()
        };
        cargadivconsulta('vista', RUTA_URL + 'parametros/formularioprogramas/', data);
    });
    $(document).on('change', '#selPais', function () {
        var data = {
            'id': $(this).val()
        };
        cargadivconsulta('divestado', RUTA_URL + 'parametros/estados/', data);
    });
    $(document).on('change', '#selEstado', function () {
        var data = {
            'id': $(this).val()
        };
        cargadivconsulta('divciudad', RUTA_URL + 'parametros/ciudades/', data);
    });
    $(document).on('click', '#btnAgregarInstituciones', function () {
        var data = {
            'id': ''
        };
        cargadivconsulta('vista', RUTA_URL + 'parametros/formularioinstitucion/', data);
    });
    $(document).on('click', '#btnEditarinst', function () {
        var data = {
            'id': $(this).val()
        };
        cargadivconsulta('vista', RUTA_URL + 'parametros/formularioinstitucion/', data);
    });
    $(document).on('click', '#btnAutorizar', function () {
        $('#modalAutorizar').modal('show');
        var data = {
            'id': $(this).val()
        };
        cargadivconsulta('contenidoModal', RUTA_URL + 'procesos/modalroles/', data);
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