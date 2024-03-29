<?php
require_once "imports.php";
require_once './utils/RichiesteAnnunci.php';
$request = new RichiesteAnnunci();
require_once './utils/Sanitizer.php';
$sanit = new Sanitizer();

//Verifica se loggato
if (!$auth->getIfLogin()) {
    header("location:./area_riservata.php");
    exit();
}

//Script Inserimento Annuncio
if (isset($_POST["new_listing"])) {
    //Verifico Input e sanitize
    $_POST['titolo'] = $sanit->sanitizeString($_POST['titolo']);
    $_POST['descrizione'] = $sanit->sanitizeString($_POST['descrizione']);
    $_POST['prezzo'] = $sanit->sanitizeString($_POST['prezzo']);
    $_POST['materia'] = $sanit->sanitizeString($_POST['materia']);
    if ($_POST['categoria'] == "libri") {
        $_POST['titolo'] = $sanit->sanitizeString($_POST['titolo']);
        $_POST['edizione'] = $sanit->sanitizeString($_POST['edizione']);
        $_POST['isbn'] = $sanit->sanitizeString($_POST['isbn']);
    }
    $error = array();
    if (!$sanit->validateTitle($_POST['titolo'])) {
        array_push($error, "Formato Titolo non corretto");
    }
    if (!$sanit->validateDescription($_POST['descrizione'])) {
        array_push($error, "Formato descrizione non corretto");
    }
    if (!$sanit->validateNumber($_POST['prezzo'])) {
        array_push($error, "Formato prezzo non corretto");
    }
    if (!$sanit->validateNameNumberMaxLength($_POST['materia'])) {
        array_push($error, "Formato materia non corretto");
    }
    if ($_POST['categoria'] == "libri") {
        if (!$sanit->validateNameMaxLength($_POST['autore'])) {
            array_push($error, "Formato autore non corretto");
        }
        if (!$sanit->validateNameNumberMaxLength($_POST['edizione'])) {
            array_push($error, "Formato edizione non corretto");
        }
        if (!$sanit->validateISBN($_POST['isbn'])) {
            array_push($error, "Formato ISBN non corretto");
        }
    }
    $verifica =
        $sanit->validateTitle($_POST['titolo']) &&
        $sanit->validateDescription($_POST['descrizione']) &&
        $sanit->validateNumber($_POST['prezzo']) &&
        $sanit->validateNameNumberMaxLength($_POST['materia']);
    if ($_POST['categoria'] == "libri") {
        $verifica = $verifica &&
            $sanit->validateNameMaxLength($_POST['autore']) &&
            $sanit->validateNameNumberMaxLength($_POST['edizione']) &&
            $sanit->validateISBN($_POST['isbn']);
    }

    //Mando i dati da modificare del annuncio alla funzione new_listing con una struttura dati array
    if ($verifica) {
        $result = $request->new_listing(
            array("tipo" => $_POST['categoria'], "titolo" => $_POST['titolo'], "descrizione" => $_POST['descrizione'], "prezzo" => $_POST['prezzo'], "username" => $_SESSION["loginAccount"], "mediapath" => $_FILES["mediapath"], "materia" => $_POST['materia'], "autore" => $_POST['autore'], "edizione" => $_POST['edizione'], "isbn" => $_POST['isbn'])
        );
    } else {
        header('location:./new_listing.php?categoria=' . $_POST['categoria'] . '&errore=' . implode(" - ", $error));
        exit();
    }
    //Se nei risultati il campo lastid è valorizzato !=0 l'inserimento è avvenuta con successo
    if ($result["lastid"] != 0) {
        header("location:./listing.php?annuncio=$result[lastid]");
        exit();
    } else {
        $error = $result['upload']['errore'];
        header("location:./new_listing.php?categoria=$_POST[categoria]&errore=$error");
        exit();
    }

}
?>