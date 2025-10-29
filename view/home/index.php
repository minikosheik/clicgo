<?php 
require_once("../../config/seguridad.php");
?>

<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">

<head>

<meta charset="utf-8" />
<title>ClicGo | Home</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
<meta content="Themesbrand" name="author" />

<!-- ========== Head Page ========== -->
    <?php include_once("../mainhead/head.php"); ?>
<!-- end Head Page --> 

</head>

<body>

<!-- Begin page -->
<div id="layout-wrapper">
<!-- ========== Header Menu ========== -->
<?php include_once("../mainheader/header.php"); ?>
<!-- end Header -->

<!-- ========== Nav Menu ========== -->
<?php include_once("../mainnav/nav.php"); ?>
<!-- end Nav -->

<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">

<!-- ========== Page content start ========== -->
            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row align-items-start g-3">
                            <!-- 🖼️ INFORMACIÓN GENERAL -->
                            <div class="col-xl-8 col-lg-8">
                                <div class="card shadow-sm">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h4 class="card-title mb-0">Información General</h4>
                                    </div>
                                    <div class="card-body">
                                        <!-- Swiper dinámico -->
                                        <div class="swiper default-swiper rounded">
                                            <div class="swiper-wrapper" id="infoGeneralContainer">
                                                <!-- Imágenes dinámicas cargadas por JS -->
                                            </div>

                                            <!-- Controles -->
                                            <div class="swiper-pagination"></div>
                                            <div class="swiper-button-next"></div>
                                            <div class="swiper-button-prev"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 📰 COMUNICADOS AL LADO DERECHO -->
                            <div class="col-xl-4 col-lg-4">
                                <div class="card shadow-sm">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h4 class="card-title mb-0">Comunicados</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="swiper marketplace-swiper rounded gallery-light">
                                            <div class="swiper-wrapper" id="contenedor-comunicados">
                                                <!-- Comunicados dinámicos cargados por JS -->
                                            </div>

                                            <!-- Controles -->
                                            <div class="swiper-button-next"></div>
                                            <div class="swiper-button-prev"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                        <div class="col-xxl-5">
                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Aniversarios</h4>
                                </div><!-- end card header -->
                                <div class="card-body pt-0">
                                    <ul class="list-group list-group-flush border-dashed">
                                        <li class="list-group-item ps-0">
                                            <div class="row align-items-center g-3">
                                                
                                            </div>
                                            <!-- end row -->
                                        </li><!-- end -->
                                    </ul><!-- end -->
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div><!-- end col -->

                        <div class="col-xxl-7">
                            <div class="card card-height-100">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Eventos de la semana</h4>
                                </div><!-- end card header -->

                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-nowrap align-middle mb-0" id="tabla-eventos">
                                           <thead>
                                                <th>Nombre</th>
                                                <th>Fechas(s)</th>
                                                <th>Tipo</th>
                                            </thead>
                                            <tbody></tbody>
                                        </table><!-- end table -->
                                    </div><!-- end table responsive -->
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div><!-- end col -->
                    </div><!-- end row -->

                    <!-- 🎂 Cumpleaños -->
                        <div class="col-xxl-5">
                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Cumpleaños del Mes</h4>
                                    <div class="flex-shrink-0">
                                        <i class="bx bx-gift fs-4 text-warning"></i>
                                    </div>
                                </div><!-- end card header -->

                                <div class="card-body pt-0">
                                    <ul class="list-group list-group-flush border-dashed" id="lista-cumpleanios">
                                        <li class="list-group-item text-center text-muted">Cargando...</li>
                                    </ul>
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div><!-- end col -->
                    <!-- end page title -->

                </div>
            </div>
<!-- ============================================================== -->
<!-- End Page-content -->
<!-- ============================================================== -->

<!-- ========== footer ========== -->
<?php include_once("../footer/footer.php"); ?> 
<!-- end footer -->

<!-- ========== JS ========== -->
<?php include_once("../mainjs/js.php"); ?> 

<!-- end JS -->

<!-- Tu JS personalizado -->
<script src="home.js"></script>

<!-- Cargar Imagenes Comunicados -->
<script src="../../public/assets/libs/jquery/jquery.min.js"></script>
<!-- ================================================== -->
<!-- Inicialización Swipers (velocidad + loop infinito) -->
<!-- ================================================== -->
<script>
$(document).ready(function () {
    cargarInformacionGeneral();
    cargarComunicados();
});

// 🖼️ Información General
function cargarInformacionGeneral() {
    $.ajax({
        url: "../../controller/info_general.php?op=listar",
        type: "GET",
        dataType: "json",
        success: function (data) {
            let contenedor = $("#infoGeneralContainer");

            if (!data || data.length === 0) {
                contenedor.html(`
                    <div class="text-center p-5 w-100">
                        <h5 class="text-muted">No hay información general disponible</h5>
                    </div>
                `);
                return;
            }

            let html = "";
            data.forEach(item => {
                if (item.imagen && item.imagen.trim() !== "") {
                    html += `
                        <div class="swiper-slide">
                            <div class="d-flex justify-content-center align-items-center">
                                <img src="../../${item.imagen}" 
                                     alt="Información general"
                                     class="img-fluid rounded shadow"
                                     style="max-height: 900px; object-fit: cover;"
                                     onerror="this.style.display='none'">
                            </div>
                        </div>`;
                }
            });

            contenedor.html(html);

            new Swiper(".general-swiper", {
                slidesPerView: 1,
                centeredSlides: true,
                spaceBetween: 20,
                loop: true, // 🔁 vuelve a iniciar automáticamente
                speed: 1200, // transición más suave
                autoplay: {
                    delay: 7000, // ⏳ más lento
                    disableOnInteraction: false
                },
                pagination: { el: ".swiper-pagination", clickable: true },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
                breakpoints: {
                    768: { slidesPerView: 1.5 },
                    1200: { slidesPerView: 2 },
                }
            });
        },
        error: function (xhr) {
            console.error("Error al cargar información general:", xhr.responseText);
        }
    });
}

// 📰 Comunicados
function cargarComunicados() {
    $.ajax({
        url: "../../controller/comunicado.php?op=listar_publicos",
        type: "GET",
        dataType: "json",
        success: function (data) {
            if (!data || data.length === 0) {
                $(".marketplace-swiper .swiper-wrapper").html(`
                    <div class="text-center p-5 w-100">
                        <h5 class="text-muted">No hay comunicados disponibles</h5>
                    </div>
                `);
                return;
            }

            let html = "";
            data.forEach(c => {
                const tieneImagen = c.imagen && c.imagen.trim() !== "";
                html += `
                    <div class="swiper-slide">
                        <div class="card explore-box card-animate rounded shadow-sm h-100">
                            ${tieneImagen ? `
                                <div class="position-relative">
                                    <img src="../../${c.imagen}" class="img-fluid rounded-top" alt="${c.titulo}" 
                                        onerror="this.style.display='none'; this.nextElementSibling.style.borderTopLeftRadius='0'; this.nextElementSibling.style.borderTopRightRadius='0';">
                                </div>` 
                            : ''}
                            <div class="card-body">
                                <h5 class="fw-bold text-primary mb-1">${c.titulo}</h5>
                                <p class="text-muted small mb-2"><i class="mdi mdi-calendar"></i> ${formatearFecha(c.fecha_publicacion)}</p>
                                <p class="text-secondary">${c.descripcion}</p>
                            </div>
                        </div>
                    </div>`;
            });

            $(".marketplace-swiper .swiper-wrapper").html(html);

            new Swiper(".marketplace-swiper", {
                slidesPerView: 3,
                spaceBetween: 15,
                loop: true, // 🔁 reinicio automático
                speed: 1100, // transición suave
                autoplay: {
                    delay: 100000, // ⏳ más lento
                    disableOnInteraction: false
                },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev"
                },
                breakpoints: {
                    320: { slidesPerView: 1 },
                    768: { slidesPerView: 2 },
                    1200: { slidesPerView: 3 }
                }
            });
        },
        error: function (xhr, status, error) {
            console.error("Error al cargar comunicados:", error);
        }
    });
}

function formatearFecha(fecha) {
    const d = new Date(fecha);
    return d.toLocaleDateString("es-MX", {
        year: "numeric",
        month: "long",
        day: "numeric"
    });
}
</script>

</body>

</html>