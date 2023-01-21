<?php
require_once "./core/registration_control.php";

// Prendo l'HTML della pagina, dell'header e del footer
$registration = file_get_contents("./contents/registration_content.html");
$header = file_get_contents("./contents/header.html");
$footer = file_get_contents("./contents/footer.html");
// Prendo il contenuto corretto della navbar
$navbar = printNavbar("registrazione", $auth->getIfLogin());
$breadcrumb = printBreadcrumb("registrati");

// Rimpiazzo i segnaposti coi contenuti HTML
$header = str_replace('<navbar/>', $navbar, $header);
$header = str_replace('<breadcrumb/>', $breadcrumb, $header);
$registration = str_replace('<php-header />', $header, $registration);
$registration = str_replace('php-action', $_SERVER['PHP_SELF'], $registration);
$registration = str_replace('<php-footer />', $footer, $registration);

// Mostro la pagina
echo $registration;
?>