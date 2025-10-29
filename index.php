<?php
session_start();
require_once("models/Usuario.php");

$error = "";

if (isset($_POST["enviar"]) && $_POST["enviar"] == "si") {
    $usuario = new Usuario();
    $correo = trim($_POST["correo"]);
    $contrasena = trim($_POST["contrasena"]);

    if ($usuario->login($correo, $contrasena)) {
        // Redirección según rol
        if ($_SESSION["rol"] == "administrador") {
            header("Location: view/home/index.php");
        } elseif ($_SESSION["rol"] == "jefe") {
            header("Location: view/home/index.php");
        } else {
            header("Location: view/home/index.php");
        }
        exit();
    } else {
        $error = "Correo o contraseña incorrectos";
    }
}
?>

<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">

<head>

    <meta charset="utf-8" />
    <title>ClicGo | Acceso</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- Layout config Js -->
    <script src="assets/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="public/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="public/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="public/assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="public/assets/css/custom.min.css" rel="stylesheet" type="text/css" />

</head>

<body background="public/assets/images/bg.JPG">

    <!-- auth-page wrapper -->
    <div class="auth-page-wrapper py-5 d-flex justify-content-center align-items-center min-vh-100">
        <div class="bg-overlay"></div>
        <!-- auth-page content -->
        <div class="auth-page-content overflow-hidden pt-lg-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card overflow-hidden">
                            <div class="row g-0">
                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-4 auth-one-bg h-100">
                                        <div class="bg-overlay"></div>
                                        <div class="position-relative h-100 d-flex flex-column">
                                            <div class="mb-4">
                                            </div>
                                            <div class="mt-auto">
                                                <div class="mb-3">
                                                    <i class="ri-double-quotes-l display-4 text-success"></i>
                                                </div>

                                                <div id="qoutescarouselIndicators" class="carousel slide" data-bs-ride="carousel">
                                                    <div class="carousel-indicators">
                                                        <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                                        <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                                        <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                                    </div>
                                                    <div class="carousel-inner text-center text-white-50 pb-5">
                                                        <div class="carousel-item active">
                                                            <p class="fs-15 fst-italic">" No se trata de ser el mejor, se trata de ser mejor de lo que eras ayer. "</p>
                                                        </div>
                                                        <div class="carousel-item">
                                                            <p class="fs-15 fst-italic">" El éxito es la suma de pequeños esfuerzos repetidos día tras día. "</p>
                                                        </div>
                                                        <div class="carousel-item">
                                                            <p class="fs-15 fst-italic">" Si todos avanzan juntos, el éxito se cuida solo. "</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end carousel -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end col -->

                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-4">
                                        <div>
                                            <img src="public/assets/images/logo-light.png" alt="" height="60">
                                            <p class="text-muted">Aislantes Minerales, S.A. de C.V.</p>
                                        </div>

                                        <div class="mt-4">
                                            <!-- Mostrar error -->
                                            <?php if(!empty($error)) { ?>
                                                <div class="alert alert-danger"><?php echo $error; ?></div>
                                            <?php } ?>

                                            <form method="POST" action="" class="needs-validation" novalidate>
                                                <div class="mb-3">
                                                    <label for="correo" class="form-label">Correo</label>
                                                    <input type="email" class="form-control" id="correo" name="correo" required>
                                                    <div class="invalid-feedback">Por favor ingrese su correo</div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="contrasena" class="form-label">Contraseña</label>
                                                    <input type="password" class="form-control" id="contrasena" name="contrasena" required>
                                                    <div class="invalid-feedback">Por favor ingrese su contraseña</div>
                                                </div>

                                                <input type="hidden" name="enviar" value="si">
                                                <button type="submit" class="btn btn-success w-100">Acceder</button>
                                            </form>                                        
                                        </div>

                                        <div class="mt-3 text-center">
                                            <p class="mb-0">¿No tienes cuenta? <a href="mailto:clicgo@rolan.com">Contacta al área de RRHH</a></p>
                                        </div>

                                    </div>
                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end row -->
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->

                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->

        <!-- footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0">&copy;
                                <script>document.write(new Date().getFullYear())</script> ClicGo - Aislantes Minerales by Dpto. de Sistemas
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->
    </div>
    <!-- end auth-page-wrapper -->

    <!-- JAVASCRIPT -->
    <script src="public/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="public/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="public/assets/libs/node-waves/waves.min.js"></script>
    <script src="public/assets/libs/feather-icons/feather.min.js"></script>
    <script src="public/assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="public/assets/js/plugins.js"></script>

    <!-- password-addon init -->
    <script src="public/assets/js/pages/password-addon.init.js"></script>
</body>

</html>