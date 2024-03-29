<?php
require_once "utils/search_results_control.php";

// Prendo l'HTML della pagina, dell'header e del footer
$search_results_content = file_get_contents("./contents/search_results_content.html");
$search_results = boilerplate($search_results_content);

$footer = file_get_contents("./contents/footer.html");
// Prendo il contenuto corretto della navbar
$header = printHeader("risultati", $auth->getIfLogin());
$breadcrumb = printBreadcrumb("risultati", $_GET['search']);

// Rimpiazzo i segnaposti coi contenuti HTML
$header = str_replace('<breadcrumb />', $breadcrumb, $header);
$search_results = str_replace('<php-header />', $header, $search_results);

$search = new Search_Results_Control();
$risultati = $search->getResults($_GET['search'], $_GET['categoria'], isset($_GET['ordine']) ? $_GET['ordine'] : "standard");
$listings = '<h2> Ricerca ' . $_GET['categoria'] . ' "' . $_GET['search'] . '"</h2>';
$listings .= listingsList($risultati, $_GET['categoria']);

$search_results = str_replace('<php-listings />', $listings, $search_results);

$search_results = str_replace('<php-footer />', $footer, $search_results);
$search_results = str_replace('php-search-value', $_GET['search'], $search_results);

$search_results = str_replace('php-catlibri', $_GET['categoria'] == "libri" ? "selected" : "", $search_results);
$search_results = str_replace('php-catappunti', $_GET['categoria'] == "appunti" ? "selected" : "", $search_results);
$search_results = str_replace('php-catripetizioni', $_GET['categoria'] == "ripetizioni" ? "selected" : "", $search_results);

$search_results = str_replace('php-title-search', $_GET['search'], $search_results);
$search_results = str_replace('php-type-search', $_GET['categoria'], $search_results);

if (!isset($_GET['ordine'])) {
    $search_results = str_replace('<option value="standard">', '<option value="standard" selected>', $search_results);
} else {
    $search_results = str_replace('<option value="standard">', $_GET['ordine'] == "standard" ? '<option value="standard selected">' : '<option value="standard">', $search_results);
    $search_results = str_replace('<option value="prezzoasc">', $_GET['ordine'] == "prezzoasc" ? '<option value="prezzoasc" selected>' : '<option value="prezzoasc">', $search_results);
    $search_results = str_replace('<option value="prezzodisc">', $_GET['ordine'] == "prezzodisc" ? '<option value="prezzodisc" selected>' : '<option value="prezzodisc">', $search_results);
}
// Mostro la pagina
echo $search_results;
?>