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
                    <div class="row">
                        <div class="col-12">
                            
                            <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Comunicados</h4>
                                </div><!-- end card header -->
                                <div class="card-body">

                                    <!-- Swiper -->
                                    <div class="swiper effect-coverflow-swiper rounded pb-5">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide">
                                                <img src="../../public/assets/images/small/img-4.jpg" alt="" class="img-fluid" />
                                            </div>
                                            <div class="swiper-slide">
                                                <img src="../../public/assets/images/small/img-5.jpg" alt="" class="img-fluid" />
                                            </div>
                                            <div class="swiper-slide">
                                                <img src="../../public/assets/images/small/img-6.jpg" alt="" class="img-fluid" />
                                            </div>
                                            <div class="swiper-slide">
                                                <img src="../../public/assets/images/small/img-7.jpg" alt="" class="img-fluid" />
                                            </div>
                                            <div class="swiper-slide">
                                                <img src="../../public/assets/images/small/img-8.jpg" alt="" class="img-fluid" />
                                            </div>
                                            <div class="swiper-slide">
                                                <img src="../../public/assets/images/small/img-9.jpg" alt="" class="img-fluid" />
                                            </div>
                                            <div class="swiper-slide">
                                                <img src="../../public/assets/images/small/img-9.jpg" alt="" class="img-fluid" />
                                            </div>
                                            <div class="swiper-slide">
                                                <img src="../../public/assets/images/small/img-9.jpg" alt="" class="img-fluid" />
                                            </div>
                                            <div class="swiper-slide">
                                                <img src="../../public/assets/images/small/img-9.jpg" alt="" class="img-fluid" />
                                            </div>
                                            <div class="swiper-slide">
                                                <img src="../../public/assets/images/small/img-9.jpg" alt="" class="img-fluid" />
                                            </div>
                                        </div>
                                        <div class="swiper-pagination swiper-pagination-dark"></div>
                                    </div>
                                </div><!-- end card-body -->
                            </div><!-- end card -->
                        </div>
                        <!--end col-->

                        <div class="row">
                            <div class="col-xl-7">
                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Eventos de la semana</h4>
                                    <div class="flex-shrink-0">
                                        <div class="dropdown card-header-dropdown">
                                            <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="text-muted">02 Nov 2021 to 31 Dec 2021<i class="mdi mdi-chevron-down ms-1"></i></span>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="#">Today</a>
                                                <a class="dropdown-item" href="#">Last Week</a>
                                                <a class="dropdown-item" href="#">Last Month</a>
                                                <a class="dropdown-item" href="#">Current Year</a>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- end card header -->

                                <div class="card-body">
                                    <div class="table-responsive table-card">
                                        <table class="table table-borderless table-hover table-nowrap align-middle mb-0">
                                            <thead class="table-light">
                                                <tr class="text-muted">
                                                    <th scope="col">Name</th>
                                                    <th scope="col" style="width: 20%;">Last Contacted</th>
                                                    <th scope="col">Sales Representative</th>
                                                    <th scope="col" style="width: 16%;">Status</th>
                                                    <th scope="col" style="width: 12%;">Deal Value</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr>
                                                    <td>Absternet LLC</td>
                                                    <td>Sep 20, 2021</td>
                                                    <td>
                                                        <a href="#javascript: void(0);" class="text-body fw-medium">Donald Risher</a>
                                                    </td>
                                                    <td><span class="badge badge-soft-success p-2">Deal Won</span></td>
                                                    <td>
                                                        <div class="text-nowrap">$100.1K</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Raitech Soft</td>
                                                    <td>Sep 23, 2021</td>
                                                    <td>
                                                        <a href="#javascript: void(0);" class="text-body fw-medium">Sofia Cunha</a>
                                                    </td>
                                                    <td><span class="badge badge-soft-warning p-2">Intro Call</span></td>
                                                    <td>
                                                        <div class="text-nowrap">$150K</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>William PVT</td>
                                                    <td>Sep 27, 2021</td>
                                                    <td>
                                                        <a href="#javascript: void(0);" class="text-body fw-medium">Luis Rocha</a>
                                                    </td>
                                                    <td><span class="badge badge-soft-danger p-2">Stuck</span></td>
                                                    <td>
                                                        <div class="text-nowrap">$78.18K</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Loiusee LLP</td>
                                                    <td>Sep 30, 2021</td>
                                                    <td>
                                                        <a href="#javascript: void(0);" class="text-body fw-medium">Vitoria Rodrigues</a>
                                                    </td>
                                                    <td><span class="badge badge-soft-success p-2">Deal Won</span></td>
                                                    <td>
                                                        <div class="text-nowrap">$180K</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Apple Inc.</td>
                                                    <td>Sep 30, 2021</td>
                                                    <td>
                                                        <a href="#javascript: void(0);" class="text-body fw-medium">Vitoria Rodrigues</a>
                                                    </td>
                                                    <td><span class="badge badge-soft-info p-2">New Lead</span></td>
                                                    <td>
                                                        <div class="text-nowrap">$78.9K</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Apple Inc.</td>
                                                    <td>Sep 30, 2021</td>
                                                    <td>
                                                        <a href="#javascript: void(0);" class="text-body fw-medium">Vitoria Rodrigues</a>
                                                    </td>
                                                    <td><span class="badge badge-soft-info p-2">New Lead</span></td>
                                                    <td>
                                                        <div class="text-nowrap">$78.9K</div>
                                                    </td>
                                                </tr>
                                            </tbody><!-- end tbody -->
                                        </table><!-- end table -->
                                    </div><!-- end table responsive -->
                                </div><!-- end card body -->
                            </div><!-- end card -->
                            </div><!-- end col -->

                            <div class="col-xxl-5">
                                <div class="card">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">Aniversarios/Cumpleaños del mes</h4>
                                        <div class="flex-shrink-0">
                                            <div class="dropdown card-header-dropdown">
                                                <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="text-muted fs-18"><i class="mdi mdi-dots-vertical"></i></span>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="#">Edit</a>
                                                    <a class="dropdown-item" href="#">Remove</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- end card header -->
                                    <div class="card-body pt-0">
                                        <ul class="list-group list-group-flush border-dashed">
                                            <li class="list-group-item ps-0">
                                                <div class="row align-items-center g-3">
                                                    <div class="col-auto">
                                                        <div class="avatar-sm p-1 py-2 h-auto bg-light rounded-3">
                                                            <div class="text-center">
                                                                <h5 class="mb-0">25</h5>
                                                                <div class="text-muted">Tue</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <h5 class="text-muted mt-0 mb-1 fs-13">12:00am - 03:30pm</h5>
                                                        <a href="#" class="text-reset fs-14 mb-0">Meeting for campaign with sales team</a>
                                                    </div>
                                                </div>
                                                <!-- end row -->
                                            </li><!-- end -->
                                            <li class="list-group-item ps-0">
                                                <div class="row align-items-center g-3">
                                                    <div class="col-auto">
                                                        <div class="avatar-sm p-1 py-2 h-auto bg-light rounded-3">
                                                            <div class="text-center">
                                                                <h5 class="mb-0">20</h5>
                                                                <div class="text-muted">Wed</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <h5 class="text-muted mt-0 mb-1 fs-13">02:00pm - 03:45pm</h5>
                                                        <a href="#" class="text-reset fs-14 mb-0">Adding a new event with attachments</a>
                                                    </div>
                                                </div>
                                                <!-- end row -->
                                            </li><!-- end -->
                                            <li class="list-group-item ps-0">
                                                <div class="row align-items-center g-3">
                                                    <div class="col-auto">
                                                        <div class="avatar-sm p-1 py-2 h-auto bg-light rounded-3">
                                                            <div class="text-center">
                                                                <h5 class="mb-0">17</h5>
                                                                <div class="text-muted">Wed</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <h5 class="text-muted mt-0 mb-1 fs-13">04:30pm - 07:15pm</h5>
                                                        <a href="#" class="text-reset fs-14 mb-0">Create new project Bundling Product</a>
                                                    </div>
                                                </div>
                                                <!-- end row -->
                                            </li><!-- end -->
                                            <li class="list-group-item ps-0">
                                                <div class="row align-items-center g-3">
                                                    <div class="col-auto">
                                                        <div class="avatar-sm p-1 py-2 h-auto bg-light rounded-3">
                                                            <div class="text-center">
                                                                <h5 class="mb-0">12</h5>
                                                                <div class="text-muted">Tue</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <h5 class="text-muted mt-0 mb-1 fs-13">10:30am - 01:15pm</h5>
                                                        <a href="#" class="text-reset fs-14 mb-0">Weekly closed sales won checking with sales team</a>
                                                    </div>
                                                </div>
                                                <!-- end row -->
                                            </li><!-- end -->
                                        </ul><!-- end -->
                                        <div class="align-items-center mt-2 row g-3 text-center text-sm-start">
                                            <div class="col-sm">
                                                <div class="text-muted">Showing<span class="fw-semibold">4</span> of <span class="fw-semibold">125</span> Results
                                                </div>
                                            </div>
                                            <div class="col-sm-auto">
                                                <ul class="pagination pagination-separated pagination-sm justify-content-center justify-content-sm-start mb-0">
                                                    <li class="page-item disabled">
                                                        <a href="#" class="page-link">←</a>
                                                    </li>
                                                    <li class="page-item">
                                                        <a href="#" class="page-link">1</a>
                                                    </li>
                                                    <li class="page-item active">
                                                        <a href="#" class="page-link">2</a>
                                                    </li>
                                                    <li class="page-item">
                                                        <a href="#" class="page-link">3</a>
                                                    </li>
                                                    <li class="page-item">
                                                        <a href="#" class="page-link">→</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->

                        </div><!-- end row -->


                        </div>
                    </div>
                    <!-- end page title -->
                </div>
                <!-- container-fluid -->
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
    
</body>

</html>