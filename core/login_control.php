<?php
//Start Session
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

require_once 'Authentication.php';
$auth = new Authentication();
require_once 'header.php';
require_once "imports.php";
require_once 'Sanitizer.php';
$san = new Sanitizer();

if (isset($_POST['utente']) && !empty($_POST['utente'])) {
    //Verifico Input
    $username = $san->sanitizeString($_POST["utente"]);
    $password = $san->sanitizeString($_POST["password"]);
    $verifica = $san->validatePassword($password);
    if($verifica)
    $retResponse = $auth->login($username,$password);
    if ($verifica && $retResponse === TRUE) {
        print("
        <script>
        alert('Login Avvenuta con successo');
        window.location = '../area_riservata.php';
        </script>
        ");
    } else {
        print("
        <script>
        alert('Errore nel Login');
        window.location = '../login.php';
        </script>
        ");
    }
}
?>
