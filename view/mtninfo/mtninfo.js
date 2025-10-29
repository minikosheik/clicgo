$(document).ready(function () {
    listarInfoGeneral();

    // Abrir modal para nueva imagen
    $("#btnNuevaImagen").on("click", function() {
        $("#modalInfoLabel").text("Agregar Imagen");
        $("#form_info_general")[0].reset();
        $("#id_info").val("");
        $("#preview").empty();
    });

    // Vista previa de imagen
    $("#imagen").on("change", function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = e => $("#preview").html(`<img src="${e.target.result}" class="img-fluid rounded shadow" style="max-height:200px;">`);
            reader.readAsDataURL(file);
        } else {
            $("#preview").empty();
        }
    });

    // Guardar / Actualizar imagen
    $("#form_info_general").on("submit", function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        $.ajax({
            url: "../../controller/info_general.php?op=guardar",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                const res = JSON.parse(response);
                alert(res.msg);
                if (res.status === "success") {
                    $("#modalInfo").modal("hide");
                    listarInfoGeneral();
                }
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                alert("❌ Error al guardar la imagen.");
            }
        });
    });
});

function listarInfoGeneral() {
    $.ajax({
        url: "../../controller/info_general.php?op=listar",
        type: "GET",
        dataType: "json",
        success: function (data) {
            $("#tabla_info").DataTable({
                destroy: true,
                data: data,
                responsive: true,
                language: { url: "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json" },
                columns: [
                    { data: "id_info" },
                    {
                        data: "imagen",
                        render: function (data) {
                            return `<img src="../../${data}" class="gallery-img" 
                                    onerror="this.src='../../public/assets/images/placeholder.png';">`;
                        }
                    },
                    {
                        data: "fecha_publicacion",
                        render: function (data) {
                            const f = new Date(data);
                            return f.toLocaleDateString("es-MX", {
                                year: "numeric", month: "long", day: "numeric"
                            });
                        }
                    },
                    {
                        data: null,
                        render: function (data) {
                            return `
                                <button class="btn btn-warning btn-sm me-1" onclick="editarImagen(${data.id_info}, '../../${data.imagen}')">
                                    <i class="mdi mdi-pencil"></i> Editar
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="eliminarImagen(${data.id_info})">
                                    <i class="mdi mdi-delete"></i> Eliminar
                                </button>`;
                        }
                    }
                ]
            });
        },
        error: function (xhr) {
            console.error(xhr.responseText);
        }
    });
}

// ✏️ Editar imagen existente
function editarImagen(id_info, imagenRuta) {
    $("#modalInfoLabel").text("Actualizar Imagen");
    $("#id_info").val(id_info);
    $("#preview").html(`<img src="${imagenRuta}" class="img-fluid rounded shadow" style="max-height:200px;">`);
    $("#modalInfo").modal("show");
}

// 🗑 Eliminar imagen
function eliminarImagen(id_info) {
    if (confirm("¿Seguro que deseas eliminar esta imagen?")) {
        $.ajax({
            url: "../../controller/info_general.php?op=eliminar",
            type: "POST",
            data: { id_info },
            success: function (response) {
                const res = JSON.parse(response);
                alert(res.msg);
                listarInfoGeneral();
            },
            error: function (xhr) {
                console.error(xhr.responseText);
            }
        });
    }
}
