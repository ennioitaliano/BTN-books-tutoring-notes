<?php
require_once './core/area_riservata_control.php';

// HTML di pagina, header e footer
$area_riservata = file_get_contents("./contents/area_riservata_content.html");
$header = file_get_contents("./contents/header.html");
$footer = file_get_contents("./contents/footer.html");

// Contenuto corretto di navbar e breadcrumb
$navbar = printNavbar("areariservata", $auth->getIfLogin());
$breadcrumb = printBreadcrumb("areariservata");

// Tasto nuovo annuncio
$new_listing = '<a href="new_listing.php">Nuovo annuncio</a>';

// Controllo il login
if ($auth->getIfLogin()) {
    // Messaggio di benvenuto e informazioni utente
    $welcome_message_login = '<h1>Benvenuto, ' . $_SESSION["loginAccount"] . '</h1>';
    $welcome_message_login .= '<img src="./assets/imgs/icona.png"alt="" width="150" height="150" style="margin-top: 10px;">';
    
    $user_info = '<dl>';
    
    $user_info .= '</dl>';
    $user_info .= '<a href="">Modifica dati</a>';

    // Elenco degli annunci
    $listings_list = '<h3>Annunci pubblicati</h3>';

    $listings = $request->getAnnunciOfUser($_SESSION["loginAccount"]);

    foreach ($listings as $listing) {
        $listings_list .= '<tr>';
        $listings_list .= '<td>' . $listing['titolo'] . '</td>';
        $listings_list .= '<td>' . $listing['materia'] . '</td>';
        $listings_list .= '<td>' . $listing['prezzo'] . '€</td>';
        $listings_list .= '<td><a href="listing.php?annuncio=' . $listing['id'] . '">Visualizza</a></td>';
        $listings_list .= '<td><a href="edit_listing.php?modifica=' . $listing['id'] . '">Modifica</a></td>';
        $listings_list .= '<td><a href="edit_listing.php?elimina=' . $listing['id'] . '">Elimina</a></td>';
        $listings_list .= '</tr>';
    }

    $listings_list .= '</table>';

    // Sostituisco i segnaposti
    $area_riservata = str_replace('<php-welcome-message />', $welcome_message_login, $area_riservata);
    $area_riservata = str_replace('<php-user-info />', $user_info, $area_riservata);
    $area_riservata = str_replace('<php-listings-list />', $listings_list, $area_riservata);
    $area_riservata = str_replace('<php-new-listing />', $new_listing, $area_riservata);
} else {
    // Se non loggato non dovrei mai finire su questa pagina, ma in caso mi rimanda al login
    header("Location: login.php");
    exit();
}

// Sostituisco i segnaposti
$header = str_replace('<navbar/>', $navbar, $header);
$header = str_replace('<breadcrumb/>', $breadcrumb, $header);
$area_riservata = str_replace('<php-header />', $header, $area_riservata);
$area_riservata = str_replace('<php-footer />', $footer, $area_riservata);

// Mostro la pagina
echo $area_riservata;
?>