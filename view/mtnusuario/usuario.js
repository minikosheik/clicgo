$(document).ready(function () {

    // ===================== 1️⃣ Inicializa la tabla =====================
    var tabla = $("#tabla_usuarios").DataTable({
        ajax: {
            url: "../../controller/usuario.php?op=listar",
            type: "POST",
            dataType: "json",
            dataSrc: "data"
        },
        columns: [
            { data: "id_empleado" },
            { data: "numero_nomina" }, // 🔹 nueva columna
            { data: "nombre_completo" },
            { 
                data: "fecha_nacimiento",
                render: d => d ? d : '<span class="text-muted">—</span>'
            },
            { data: "puesto" },
            { data: "area" },
            { data: "correo" },
            { data: "rol" },
            { data: "fecha_ingreso" },
            { data: "estatus" },
            { data: "acciones" }
        ],
        responsive: true,
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
        }
    });


    // ===================== 2️⃣ Funciones para cargar selects =====================
    function cargarJefes() {
        $.ajax({
            url: "../../controller/usuario.php?op=listar_jefes",
            type: "POST",
            dataType: "json",
            success: function (data) {
                var select = $("#id_jefe");
                select.empty();
                select.append('<option value="">Seleccione jefe...</option>');
                $.each(data, function (i, item) {
                    select.append('<option value="' + item.id_empleado + '">' + item.nombre_completo + '</option>');
                });
            },
            error: function (xhr, status, error) {
                console.error("Error al cargar jefes:", error);
            }
        });
    }

    function cargarAreas() {
        $.ajax({
            url: "../../controller/usuario.php?op=listar_areas",
            type: "POST",
            dataType: "json",
            success: function (data) {
                var select = $("#id_area");
                select.empty();
                select.append('<option value="">Seleccione área...</option>');
                $.each(data, function (i, item) {
                    select.append('<option value="' + item.id_area + '">' + item.nombre + '</option>');
                });
            },
            error: function (xhr, status, error) {
                console.error("Error al cargar áreas:", error);
            }
        });
    }


    // ===================== 3️⃣ Nuevo usuario =====================
    $("#btnNuevoUsuario").on("click", function () {
        $("#form_usuario")[0].reset();
        $("#id_empleado").val("");
        $("#modalUsuarioLabel").text("Nuevo Usuario");
        $("#estadoUsuario").hide();
        cargarJefes();
        cargarAreas();
        $("#modalUsuario").modal("show");
    });


    // ===================== 4️⃣ Guardar usuario =====================
    $("#form_usuario").on("submit", function (e) {
        e.preventDefault();
        var id = $("#id_empleado").val();
        var operacion = id ? "actualizar" : "insertar";

        $.ajax({
            url: "../../controller/usuario.php?op=" + operacion,
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function (data) {
                Swal.fire({
                    icon: "success",
                    title: "Éxito",
                    text: data.message,
                    timer: 1800,
                    showConfirmButton: false
                });
                $("#modalUsuario").modal("hide");
                tabla.ajax.reload();
            },
            error: function (xhr) {
                Swal.fire("Error", "No se pudo guardar el usuario", "error");
                console.error(xhr.responseText);
            }
        });
    });


    // ===================== 5️⃣ Editar usuario =====================
    $(document).on("click", ".btn-warning", function () {
        var id_empleado = $(this).attr("onClick").match(/\d+/)[0];

        $.ajax({
            url: "../../controller/usuario.php?op=obtener",
            type: "POST",
            data: { id_empleado: id_empleado },
            dataType: "json",
            success: function (data) {
                $("#id_empleado").val(data.id_empleado);
                $("#numero_nomina").val(data.numero_nomina);
                $("#nombre").val(data.nombre);
                $("#apellido").val(data.apellido);
                $("#puesto").val(data.puesto);
                $("#correo").val(data.correo);
                $("#id_rol").val(data.id_rol);
                $("#fecha_ingreso").val(data.fecha_ingreso);
                $("#id_jefe").val(data.id_jefe);
                $("#id_area").val(data.id_area);
                $("#activo").val(data.activo);
                $("#estadoUsuario").show();
                $("#modalUsuarioLabel").text("Editar Usuario");
                cargarJefes();
                cargarAreas();
                $("#modalUsuario").modal("show");
            },
            error: function (xhr) {
                Swal.fire("Error", "No se pudieron cargar los datos", "error");
                console.error(xhr.responseText);
            }
        });
    });


    // ===================== 6️⃣ Eliminar usuario =====================
    $(document).on("click", ".btn-danger", function () {
        var id_empleado = $(this).attr("onClick").match(/\d+/)[0];

        Swal.fire({
            title: "¿Estás seguro?",
            text: "El usuario será dado de baja.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "../../controller/usuario.php?op=eliminar",
                    type: "POST",
                    data: { id_empleado: id_empleado },
                    dataType: "json",
                    success: function (data) {
                        Swal.fire("Eliminado", data.message, "success");
                        tabla.ajax.reload();
                    },
                    error: function (xhr) {
                        Swal.fire("Error", "No se pudo eliminar el usuario", "error");
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    });

    // ===================== FUNCIÓN GLOBAL EDITAR =====================
        window.editar = function (id_empleado) {
            $.ajax({
                url: "../../controller/usuario.php?op=obtener",
                type: "POST",
                data: { id_empleado: id_empleado },
                dataType: "json",
                success: function (data) {
                    $("#id_empleado").val(data.id_empleado);
                    $("#numero_nomina").val(data.numero_nomina);
                    $("#nombre").val(data.nombre);
                    $("#apellido").val(data.apellido);
                    $("#puesto").val(data.puesto);
                    $("#correo").val(data.correo);
                    $("#id_rol").val(data.id_rol);
                    $("#fecha_ingreso").val(data.fecha_ingreso);
                    $("#id_jefe").val(data.id_jefe);
                    $("#id_area").val(data.id_area);
                    $("#activo").val(data.activo);
                    $("#estadoUsuario").show();
                    $("#modalUsuarioLabel").text("Editar Usuario");

                    cargarJefes();
                    cargarAreas();

                    $("#modalUsuario").modal("show");
                },
                error: function (xhr) {
                    Swal.fire("Error", "No se pudieron cargar los datos del usuario", "error");
                    console.error(xhr.responseText);
                }
            });
        };

});
