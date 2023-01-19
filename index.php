<?php
//Start Session
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
require_once './core/Authentification.php';
$auth = new Authentification();
require_once './core/itemNavMenu.php';

?>
<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Cerca libri, appunti e ripetizioni e mettiti in contatto direttamente con i venditori. Cerca ora su BTN!">
    <meta name="keywords" content="BTN, libri, appunti, ripetizioni, università, books, tutoring, notes">
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
    <title>BTN - Cerca libri, appunti, ripetizioni</title>
</head>

<body>
    <header>
        <div>
            <h1><abbr title="Book Tutoring Notes">BTN</abbr></h1>
            <button id="menu-btn" class="button" onclick="menuOnClick()"><span lang="en">MENU</span></button>
        </div>

        <?php printItemNavMenu("cerca",$auth->getIfLogin());?>

    </header>
    <main>
        <section id="search">
            <div>
                <h2>Cerca libri, appunti e ripetizioni</h2>
            </div>
            <div>
                <form action="" id="search-form">
                    <input type="text" placeholder="Titolo, corso..." name="search" id="search-in">
                    <div id="search-buttons">
                        <select name="categoria" id="search-cat-select">
                            <option value="libri">Libri</option>
                            <option value="ripetizioni">Ripetizioni</option>
                            <option value="appunti">Appunti</option>
                        </select>

                        <button type="submit" id="search-btn" class="button">Cerca</button>
                    </div>
                </form>
            </div>
        </section>
    </main>

    <footer>
        <p>© 2023 <abbr lang="en" title="Book Tutoring Notes">BTN</abbr></p>
    </footer>
</body>

</html>