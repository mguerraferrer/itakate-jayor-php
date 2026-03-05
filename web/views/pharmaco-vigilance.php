<?php
    require_once __DIR__ . '/../template/quotation-session-init.php';
    require_once __DIR__ . '/../../autoload.php';

    // Load reCAPTCHA configuration
    $recaptchaWebService = new RecaptchaWebService();
    $siteKey = $recaptchaWebService->getSiteKey();

    if (!isset($viewsPath)) {
        $viewsPath = '../views/';
    }

    $title = 'Laboratorio Jayor - Farma y tecno';
    $headlineTitle = 'Farma y tecno';
    $sectionTitle = 'Farmacovigilancia y Tecnovigilancia';
?>
<!doctype html>
<html lang="es-MX">
    <head>
        <?php include '../template/head.php'; ?>
        <!-- Bootstrap Datepicker -->
        <!--<link rel="stylesheet" href="../../assets/vendor/bootstrap-datepicker/bootstrap-datepicker.min.css">-->
        <link rel="stylesheet" href="../../assets/vendor/datepicker/datepicker-bs5.min.css">
        <!-- Pharma CSS -->
        <link rel="stylesheet" href="../../assets/css/pharma.css"/>
    </head>
    <body>
        <?php include '../fragments/mini-cart.php'; ?>
        <div class="wrapper">
            <div class="header-height-bar"></div>
            <!-- Header -->
            <?php include '../template/header.php'; ?>
            <!-- Header End -->
            <!-- Main -->
            <main>
                <?php include '../fragments/page-info.php'; ?>
                <section class="section pb-0">
                    <div class="container">
                        <div class="row align-items-stretch">
                            <div class="col-lg-6 my-3" data-aos="fade-right" data-aos-delay="300" data-aos-duration="1000">
                                <img src="../../assets/src/pharma/item-1.webp" alt="" title="" class="img-fluid">
                            </div>
                            <div class="col-lg-6 ps-lg-8 my-3" data-aos="fade-left" data-aos-delay="300" data-aos-duration="1000">
                                <h4>
                                    En Laboratorios Jayor <br>
                                    cuidamos lo que más importa: <br>
                                    tu salud.
                                </h4>
                                <p class="pt-2 pb-2">
                                    Por eso, estamos súper comprometidos con la Farmacovigilancia y la
                                    Tecnovigilancia. ¿Qué significa eso? Que nos apegamos a la normativa vigente
                                    para detectar, evaluar y prevenir cualquier riesgo asociado con nuestros
                                    medicamentos y dispositivos médicos.
                                </p>
                                <p class="pb-2">
                                    En pocas palabras: los vigilamos de cerca, todo el tiempo, para asegurarnos de
                                    que sean seguros y confiables para ti.
                                </p>
                                <p class="pb-2 fw-bold">
                                    ¡Porque tu salud no se improvisa!
                                </p>
                                <p class="mb-0">
                                    A través de la farmacovigilancia y tecnovigilancia, buscamos brindar
                                    tranquilidad y bienestar a quienes confían en nuestros productos.
                                </p>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="section">
                    <div class="container">
                        <div class="row" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
                            <div class="col-12 text-center pb-5">
                                <p class="fs-80">
                                    Si presentas algún evento/incidente adverso o problema de seguridad o de calidad con el uso de alguno de nuestros productos, lo puedes reportar aquí.
                                </p>
                            </div>
                            <div class="col-12 text-center">
                                <a href="#pharmaco-report" class="btn btn-jy-primary">
                                    CREA TU REPORTE
                                </a>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="section border-top">
                    <div class="container">
                        <div class="col-12 d-none d-md-block">
                            <div class="row">
                                <!-- Columna de imágenes -->
                                <div class="col-md-5 pe-md-8 divider-line col-img"
                                     data-aos="fade-right" data-aos-delay="300" data-aos-duration="1000">
                                    <div class="img-container text-md-end">
                                        <img src="../../assets/src/pharma/item-2.webp" alt="Farmacovigilancia" class="img-fluid">
                                    </div>
                                    <div class="img-container text-md-end">
                                        <img src="../../assets/src/pharma/item-3.webp" alt="Reacción adversa" class="img-fluid">
                                    </div>
                                    <div class="img-container text-md-end">
                                        <img src="../../assets/src/pharma/item-4.webp" alt="Tecnovigilancia" class="img-fluid">
                                    </div>
                                    <div class="img-container text-md-end">
                                        <img src="../../assets/src/pharma/item-5.webp" alt="Incidente Adverso" class="img-fluid">
                                    </div>
                                </div>
                                <!-- Columna de texto -->
                                <div class="col-md-6 ps-md-8" data-aos="fade-left" data-aos-delay="300" data-aos-duration="1000">
                                    <div class="content-block">
                                        <h6 class="pb-2">¿Qué es la Farmacovigilancia?</h6>
                                        <p class="fs-85">
                                            Son actividades relacionadas con la detección, evaluación, comprensión y prevención
                                            de los eventos adversos, las sospechas de reacciones adversas, las reacciones adversas
                                            o cualquier otro problema de seguridad relacionado con el uso de los medicamentos,
                                            para contribuir a su uso seguro.
                                        </p>
                                    </div>
                                    <div class="content-block">
                                        <h6 class="pb-2">¿Qué es una reacción adversa a medicamentos?</h6>
                                        <p class="fs-85">
                                            Es cualquier respuesta no deseada, manifestación clínica o de laboratorio, que ocurre
                                            después de la administración de uno o varios medicamentos.
                                        </p>
                                    </div>
                                    <div class="content-block">
                                        <h6 class="pb-2">¿Qué es la Tecnovigilancia?</h6>
                                        <p class="fs-85">
                                            Son actividades para la identificación y evaluación de incidentes adversos relacionados
                                            con los dispositivos médicos. Permiten identificar factores de riesgo basándose en la
                                            comunicación, registro y evaluación de los reportes de incidentes adversos, con la
                                            finalidad de determinar la frecuencia, gravedad e incidencia, para prevenir su aparición
                                            y minimizar sus riesgos.
                                        </p>
                                    </div>
                                    <div class="content-block">
                                        <h6 class="pb-2">¿Qué es un Incidente Adverso?</h6>
                                        <p class="fs-85">
                                            Acontecimiento comprobado y relacionado con el uso de un dispositivo médico.
                                            Del cual, se cuenta con pruebas contundentes de su relación causal, y que pueda
                                            provocar la muerte o deterioro grave a la salud del usuario.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 d-md-none">
                            <div class="row" data-aos="zoom-in" data-aos-delay="300" data-aos-duration="1000">
                                <div class="col-md-3 text-start mb-3 img-container">
                                    <img src="../../assets/src/pharma/item-2.webp" alt="Farmacovigilancia" class="img-fluid">
                                </div>
                                <div class="col-md-9">
                                    <h6 class="pb-2">¿Qué es la Farmacovigilancia?</h6>
                                    <p class="fs-85">
                                        Son actividades relacionadas con la detección, evaluación, comprensión y prevención
                                        de los eventos adversos, las sospechas de reacciones adversas, las reacciones adversas
                                        o cualquier otro problema de seguridad relacionado con el uso de los medicamentos,
                                        para contribuir a su uso seguro.
                                    </p>
                                </div>
                                <div class="col-md-3 text-start mb-3 mt-5 img-container">
                                    <img src="../../assets/src/pharma/item-3.webp" alt="Reacción adversa" class="img-fluid">
                                </div>
                                <div class="col-md-9">
                                    <h6 class="pb-2">¿Qué es una reacción adversa a medicamentos?</h6>
                                    <p class="fs-85">
                                        Es cualquier respuesta no deseada, manifestación clínica o de laboratorio, que ocurre
                                        después de la administración de uno o varios medicamentos.
                                    </p>
                                </div>
                                <div class="col-md-3 text-start mb-3 mt-5 img-container">
                                    <img src="../../assets/src/pharma/item-4.webp" alt="Tecnovigilancia" class="img-fluid">
                                </div>
                                <div class="col-md-9">
                                    <h6 class="pb-2">¿Qué es la Tecnovigilancia?</h6>
                                    <p class="fs-85">
                                        Son actividades para la identificación y evaluación de incidentes adversos relacionados
                                        con los dispositivos médicos. Permiten identificar factores de riesgo basándose en la
                                        comunicación, registro y evaluación de los reportes de incidentes adversos, con la
                                        finalidad de determinar la frecuencia, gravedad e incidencia, para prevenir su aparición
                                        y minimizar sus riesgos.
                                    </p>
                                </div>
                                <div class="col-md-3 text-start mb-3 mt-5 img-container">
                                    <img src="../../assets/src/pharma/item-5.webp" alt="Incidente Adverso" class="img-fluid">
                                </div>
                                <div class="col-md-9">
                                    <h6 class="pb-2">¿Qué es un Incidente Adverso?</h6>
                                    <p class="fs-85">
                                        Acontecimiento comprobado y relacionado con el uso de un dispositivo médico.
                                        Del cual, se cuenta con pruebas contundentes de su relación causal, y que pueda
                                        provocar la muerte o deterioro grave a la salud del usuario.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section id="pharmaco-report" class="section border-top">
                    <div class="container" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
                        <div class="d-flex justify-content-center align-self-center">
                            <h4 class="mb-0">CREA TU REPORTE</h4>
                        </div>
                    </div>
                    <!-- Table -->
                    <div class="py-6 my-account">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-4 mb-5 mb-lg-0" data-aos="fade-right" data-aos-delay="300" data-aos-duration="1000">
                                    <div class="nav flex-column nav-pills me-3 border" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                        <a href="#" class="nav-link step-tab active" id="v-pills-personal-tab" data-bs-toggle="pill"
                                           data-bs-target="#v-pills-personal" role="tab" aria-controls="v-pills-personal" aria-selected="true" data-step="1">
                                            Datos del notificador
                                        </a>
                                        <a href="#" class="nav-link step-tab disabled" id="v-pills-product-tab" data-bs-toggle="pill"
                                           data-bs-target="#v-pills-product" role="tab" aria-controls="v-pills-product" aria-selected="false" data-step="2"
                                           aria-disabled="true" tabindex="-1">
                                            Datos del producto
                                        </a>
                                        <a href="#" class="nav-link step-tab disabled" id="v-pills-event-tab" data-bs-toggle="pill"
                                           data-bs-target="#v-pills-event" role="tab" aria-controls="v-pills-event" aria-selected="false" data-step="3"
                                           aria-disabled="true" tabindex="-1">
                                            Descripción del evento
                                        </a>
                                        <a href="#" class="nav-link step-tab disabled" id="v-pills-patient-tab" data-bs-toggle="pill"
                                           data-bs-target="#v-pills-patient" role="tab" aria-controls="v-pills-patient" aria-selected="true" data-step="4"
                                           aria-disabled="true" tabindex="-1">
                                            Datos del paciente
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-8" data-aos="fade-left" data-aos-delay="300" data-aos-duration="1000">
                                    <form id="pharmacoVigilanceForm" action="#" method="post" autocomplete="off">
                                        <div class="tab-content" id="v-pills-tabContent">
                                            <div class="tab-pane fade show active" id="v-pills-personal" role="tabpanel" aria-labelledby="v-pills-personal-tab" data-step-content="1">
                                                <h4 class="pb-3">Datos del notificador</h4>
                                                <div class="row g-3">
                                                    <div class="col-12 col-md-4">
                                                        <div id="div-name" class="form-group">
                                                            <label id="label-name" class="form-control-label" for="name">Nombre *</label>
                                                            <input id="name" type="text" name="name" class="form-control" data-required="true">
                                                            <small id="small-name"></small>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div id="div-plName" class="form-group">
                                                            <label id="label-plName" class="form-control-label" for="plName">Apellido Paterno *</label>
                                                            <input id="plName" type="text" name="plName" class="form-control" data-required="true">
                                                            <small id="small-plName"></small>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div id="div-mlName" class="form-group">
                                                            <label id="label-mlName" class="form-control-label" for="mlName">Apellido Materno *</label>
                                                            <input id="mlName" type="text" name="mlName" class="form-control" data-required="true">
                                                            <small id="small-mlName"></small>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div id="div-phone" class="form-group">
                                                            <label id="label-phone" class="form-control-label" for="phone">Teléfono *</label>
                                                            <input id="phone" type="text" name="phone" class="form-control" data-required="true">
                                                            <small id="small-phone"></small>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div id="div-email" class="form-group">
                                                            <label id="label-email" class="form-control-label" for="email">Correo electrónico *</label>
                                                            <input id="email" type="text" name="email" class="form-control" data-required="true">
                                                            <small id="small-email"></small>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div id="div-personType" class="form-group">
                                                            <label id="label-personType" class="form-control-label" for="personType">Tipo de persona *</label>
                                                            <select name="personType" id="personType" class="custom-select form-control" data-required="true">
                                                                <option value="">-- Seleccione --</option>
                                                                <option value="doc">MÉDICO</option>
                                                                <option value="nur">ENFERMERA</option>
                                                                <option value="pha">FARMACÉUTICO</option>
                                                                <option value="pat">PACIENTE</option>
                                                                <option value="fam">FAMILIAR</option>
                                                            </select>
                                                            <small id="small-personType"></small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mt-4 d-flex justify-content-end">
                                                    <button type="button" id="btn-next-1" class="btn btn-jy-primary">Siguiente</button>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-product" role="tabpanel" aria-labelledby="v-pills-product-tab">
                                                <h4 class="pb-0 mb-0">Datos del producto</h4>
                                                <p>
                                                    <small>
                                                        Por favor llena la mayor cantidad posible de datos, si tienes duda de qué elementos colocar de
                                                        <a href="../../assets/src/pharma/pharmaco-vigilance-example.pdf" target="_blank">clic aquí</a>.
                                                    </small>
                                                </p>
                                                <div class="row g-3">
                                                    <div class="col-12 col-md-4">
                                                        <div id="div-product" class="form-group">
                                                            <label id="label-product" class="form-control-label" for="product">Producto *</label>
                                                            <input id="product" type="text" name="product" class="form-control" data-required="true">
                                                            <small id="small-product"></small>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div id="div-lote" class="form-group">
                                                            <label id="label-lote" class="form-control-label" for="lote">Lote No. *</label>
                                                            <input id="lote" type="text" name="lote" class="form-control" data-required="true">
                                                            <small id="small-lote"></small>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div id="div-dueDate" class="form-group">
                                                            <label id="label-dueDate" class="form-control-label" for="dueDate">Caducidad Día/Mes/Año</label>
                                                            <input id="dueDate" type="text" name="dueDate" class="form-control">
                                                            <small id="small-dueDate"></small>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div id="div-genericName" class="form-group">
                                                            <label id="label-genericName" class="form-control-label" for="genericName">Nombre genérico</label>
                                                            <input id="genericName" type="text" name="genericName" class="form-control">
                                                            <small id="small-genericName"></small>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div id="div-dose" class="form-group">
                                                            <label id="label-dose" class="form-control-label" for="dose">Dosis</label>
                                                            <input id="dose" type="text" name="dose" class="form-control">
                                                            <small id="small-dose"></small>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div id="div-admWay" class="form-group">
                                                            <label id="label-admWay" class="form-control-label" for="admWay">Vía de administración</label>
                                                            <input id="admWay" type="text" name="admWay" class="form-control">
                                                            <small id="small-admWay"></small>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div id="div-brand" class="form-group">
                                                            <label id="label-brand" class="form-control-label" for="brand">Marca</label>
                                                            <input id="brand" type="text" name="brand" class="form-control">
                                                            <small id="small-brand"></small>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div id="div-healthRegister" class="form-group">
                                                            <label id="label-healthRegister" class="form-control-label" for="healthRegister">Registro Sanitario</label>
                                                            <input id="healthRegister" type="text" name="healthRegister" class="form-control">
                                                            <small id="small-healthRegister"></small>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <label id="label-prouse" class="form-control-label">Continúa usando el producto</label>
                                                                </div>
                                                                <div class="col-2">
                                                                    <label class="container-checkbox">Si
                                                                        <input type="checkbox" id="productUseYes" name="productUseYes" value="1">
                                                                        <span class="checkmark"></span>
                                                                    </label>
                                                                </div>
                                                                <div class="col-2">
                                                                    <label class="container-checkbox">No
                                                                        <input type="checkbox" id="productUseNo" name="productUseNo" value="1">
                                                                        <span class="checkmark"></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div id="div-startDate" class="form-group">
                                                            <label id="label-startDate" class="form-control-label" for="startDate">Fecha inicio de uso</label>
                                                            <input id="startDate" name="startDate" type="text" class="form-control" placeholder="Día/Mes/Año">
                                                            <small id="small-startDate"></small>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div id="div-endDate" class="form-group">
                                                            <label id="label-endDate" class="form-control-label" for="endDate">Fecha término</label>
                                                            <input id="endDate" name="endDate" type="text" class="form-control" placeholder="Día/Mes/Año">
                                                            <small id="small-endDate"></small>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div id="div-reasonUse" class="form-group">
                                                            <label id="label-reasonUse" class="form-control-label" for="reasonUse">Razones por las que usa este producto</label>
                                                            <textarea class="form-control" id="reasonUse" name="reasonUse" rows="3" style="resize: none;"></textarea>
                                                            <small id="small-reasonUse"></small>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div id="div-otherDrug" class="form-group">
                                                            <label id="label-otherDrug" class="form-control-label" for="otherDrug">
                                                                Menciona si se encuentra utilizando algún otro medicamento y/o dispositivo médico
                                                            </label>
                                                            <textarea class="form-control" id="otherDrug" name="otherDrug" rows="3" style="resize: none;"></textarea>
                                                            <small id="small-otherDrug"></small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mt-4 d-flex justify-content-end">
                                                    <button type="button" id="btn-prev-2" class="btn btn-jy-outline-primary me-2">Anterior</button>
                                                    <button type="button" id="btn-next-2" class="btn btn-jy-primary">Siguiente</button>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-event" role="tabpanel" aria-labelledby="v-pills-event-tab">
                                                <h4 class="pb-3">Descripción del evento</h4>
                                                <div class="row g-3">
                                                    <div class="col-md-12">
                                                        <div id="div-eventHappened" class="form-group">
                                                            <label id="label-eventHappened" class="form-control-label" for="eventHappened">Describa qué le ocurrió cuando usó el producto *</label>
                                                            <textarea class="form-control" id="eventHappened" name="eventHappened" rows="3" style="resize: none;" data-required="true"></textarea>
                                                            <small id="small-eventHappened"></small>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div id="div-eventStartDate" class="form-group">
                                                            <label id="label-eventStartDate" class="form-control-label" for="eventStartDate">Fecha inicio del evento</label>
                                                            <input id="eventStartDate" name="eventStartDate" type="text" class="form-control" placeholder="Día/Mes/Año">
                                                            <small id="small-eventStartDate"></small>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div id="div-eventEndDate" class="form-group">
                                                            <label id="label-eventEndDate" class="form-control-label" for="eventEndDate">Fecha término</label>
                                                            <input id="eventEndDate" name="eventEndDate" type="text" class="form-control" placeholder="Día/Mes/Año">
                                                            <small id="small-eventEndDate"></small>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <label id="label-eveuse" class="form-control-label">Continúa usando el producto</label>
                                                                </div>
                                                                <div class="col-2">
                                                                    <label class="container-checkbox">Si
                                                                        <input type="checkbox" id="eventUseYes" name="eventUseYes" value="1">
                                                                        <span class="checkmark"></span>
                                                                    </label>
                                                                </div>
                                                                <div class="col-2">
                                                                    <label class="container-checkbox">No
                                                                        <input type="checkbox" id="eventUseNo" name="eventUseNo" value="1">
                                                                        <span class="checkmark"></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div id="div-eventType" class="form-group">
                                                            <label id="label-eventType" class="form-control-label" for="eventType">Tipo de evento</label>
                                                            <select name="eventType" id="eventType" class="custom-select form-control">
                                                                <option value="">-- Seleccione --</option>
                                                                <option value="none">NINGUNA</option>
                                                                <option value="death">MUERTE</option>
                                                                <option value="hosp">HOSPITALIZACIÓN O PROLONGA LA HOSPITALIZACIÓN</option>
                                                                <option value="inability">INVALIDEZ O DE INCAPACIDAD</option>
                                                                <option value="alter">ALTERACIONES O MALFORMACIONES EN EL RECIÉN NACIDO</option>
                                                            </select>
                                                            <small id="small-eventType"></small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mt-4 d-flex justify-content-end">
                                                    <button type="button" id="btn-prev-3" class="btn btn-jy-outline-primary me-2">Anterior</button>
                                                    <button type="button" id="btn-next-3" class="btn btn-jy-primary">Siguiente</button>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-patient" role="tabpanel" aria-labelledby="v-pills-patient-tab">
                                                <h4 class="pb-3">Datos del paciente</h4>
                                                <div class="row g-3">
                                                    <div class="col-12 col-md-4">
                                                        <div id="div-patName" class="form-group">
                                                            <label id="label-patName" class="form-control-label" for="patName">Nombre *</label>
                                                            <input id="patName" type="text" name="patName" class="form-control" data-required="true">
                                                            <small id="small-patName"></small>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div id="div-patPlName" class="form-group">
                                                            <label id="label-patPlName" class="form-control-label" for="patPlName">Apellido Paterno *</label>
                                                            <input id="patPlName" type="text" name="patPlName" class="form-control" data-required="true">
                                                            <small id="small-patPlName"></small>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div id="div-patMlName" class="form-group">
                                                            <label id="label-patMlName" class="form-control-label" for="patMlName">Apellido Materno</label>
                                                            <input id="patMlName" type="text" name="patMlName" class="form-control">
                                                            <small id="small-patMlName"></small>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div id="div-gender" class="form-group">
                                                            <label id="label-gender" class="form-control-label" for="gender">Género</label>
                                                            <select name="gender" id="gender" class="custom-select form-control">
                                                                <option value="">-- Seleccione --</option>
                                                                <option value="female">Femenino</option>
                                                                <option value="male">Masculino</option>
                                                            </select>
                                                            <small id="small-gender"></small>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div id="div-birthDate" class="form-group">
                                                            <label id="label-birthDate" class="form-control-label" for="birthDate">Fecha de Nacimiento</label>
                                                            <input id="birthDate" name="birthDate" type="text" class="form-control" placeholder="Día/Mes/Año">
                                                            <small id="small-birthDate"></small>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <label id="label-pregnancy" class="form-control-label">Embarazo</label>
                                                                </div>
                                                                <div class="col-2">
                                                                    <label class="container-checkbox">Si
                                                                        <input type="checkbox" id="pregnancyYes" name="pregnancyYes" value="1" disabled>
                                                                        <span class="checkmark"></span>
                                                                    </label>
                                                                </div>
                                                                <div class="col-2">
                                                                    <label class="container-checkbox">No
                                                                        <input type="checkbox" id="pregnancyNo" name="pregnancyNo" value="1" disabled>
                                                                        <span class="checkmark"></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div id="div-height" class="form-group">
                                                            <label id="label-height" class="form-control-label" for="height">Estatura (metros)</label>
                                                            <input id="height" type="text" name="height" class="form-control">
                                                            <small id="small-height"></small>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div id="div-weight" class="form-group">
                                                            <label id="label-weight" class="form-control-label" for="weight">Peso (kilogramos)</label>
                                                            <input id="weight" type="text" name="weight" class="form-control">
                                                            <small id="small-weight"></small>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <label id="label-doctor-prescribe" class="form-control-label">¿Te lo recetó tu médico?</label>
                                                                </div>
                                                                <div class="col-2">
                                                                    <label class="container-checkbox">Si
                                                                        <input type="checkbox" id="doctorPrescribeYes" name="doctorPrescribeYes" value="1">
                                                                        <span class="checkmark"></span>
                                                                    </label>
                                                                </div>
                                                                <div class="col-2">
                                                                    <label class="container-checkbox">No
                                                                        <input type="checkbox" id="doctorPrescribeNo" name="doctorPrescribeNo" value="1">
                                                                        <span class="checkmark"></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div id="div-patPhone" class="form-group">
                                                            <label id="label-patPhone" class="form-control-label" for="patPhone">Teléfono</label>
                                                            <input id="patPhone" type="text" name="patPhone" class="form-control">
                                                            <small id="small-patPhone"></small>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-4">
                                                        <div id="div-patEmail" class="form-group">
                                                            <label id="label-patEmail" class="form-control-label" for="patEmail">Correo electrónico</label>
                                                            <input id="patEmail" type="text" name="patEmail" class="form-control">
                                                            <small id="small-patEmail"></small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column flex-md-row justify-content-md-between align-items-md-start mt-4">
                                                    <!-- reCAPTCHA v2 -->
                                                    <div id="recaptcha-container" class="mb-2 form-group">
                                                        <div class="g-recaptcha" data-sitekey="<?php echo htmlspecialchars($siteKey); ?>" data-callback="onRecaptchaSuccess"></div>
                                                        <small id="small-recaptcha-container"></small>
                                                    </div>
                                                    <div class="d-flex justify-content-end">
                                                        <button type="button" id="btn-prev-4" class="btn btn-jy-outline-primary me-2">Anterior</button>
                                                        <button type="button" class="btn btn-jy-primary w-100 w-md-auto" id="btn-next-4">
                                                            <span class="btn-text">Enviar reporte</span>
                                                            <span class="spinner-border spinner-border-sm d-none ms-2"></span>
                                                            <span class="processing-text d-none ms-2">Enviando...</span>
                                                        </button>
                                                    </div>
                                                </div>

                                                <div class="snackbars" id="form-output-global"></div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Table -->
                </section>
                <!-- Pharma Modal -->
                <?php include '../modals/pharmaco-vigilance-modal.html'; ?>
            </main>
            <!-- End Main -->
            <!-- Footer-->
            <?php include '../template/footer.php'; ?>
            <!-- End Footer -->
        </div>
        <?php include '../template/script.php'; ?>
        <!-- Bootstrap Datepicker -->
        <script src="../../assets/vendor/datepicker/datepicker-full.min.js" type="text/javascript"></script>
        <script src="../../assets/vendor/datepicker/datepicker-full-es.js" type="text/javascript"></script>
        <!-- Google Captcha -->
        <script src="https://www.google.com/recaptcha/api.js" type="text/javascript"></script>
        <script src="../../assets/js/form.js" type="text/javascript"></script>
        <script src="../../assets/js/pharmaco-vigilance.js" type="text/javascript"></script>
    </body>
</html>