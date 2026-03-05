<?php
    if (!isset($title)) {
        $title = 'Laboratorios Jayor';
    }

    if (!isset($rootPath)) {
        $rootPath = '../../';
    }

    if (!isset($assetsPath)) {
        $assetsPath = '../../';
    }

    if (!isset($viewsPath)) {
        $viewsPath = '../views/';
    }
?>
<!-- metas -->
<meta charset="utf-8">
<meta name="author" content="lkmsoft">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
<meta name="keywords" content="Laboratorios Jayor">
<meta name="description" content="Laboratorios Jayor">

<title><?php echo htmlspecialchars($title); ?></title>

<!-- Favicon -->
<link rel="icon" href="<?php echo $rootPath; ?>assets/src/favicon/favicon.ico">

<!-- AOS CSS -->
<link rel="stylesheet" type="text/css" href="<?php echo $rootPath; ?>assets/vendor/aos/aos.min.css">
<!-- iziToast CSS -->
<link rel="stylesheet" type="text/css" href="<?php echo $rootPath; ?>assets/vendor/iziToast/iziToast.min.css">
<!-- iziToast Custom CSS -->
<link rel="stylesheet" type="text/css" href="<?php echo $rootPath; ?>assets/css/izitoast.custom.css">
<!-- Theme CSS -->
<link rel="stylesheet" type="text/css" href="<?php echo $rootPath; ?>assets/theme/css/style.css">
<!-- Custom CSS -->
<link rel="stylesheet" type="text/css" href="<?php echo $rootPath; ?>assets/css/custom.css">

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-F26FFGY1DZ"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-F26FFGY1DZ');
</script>