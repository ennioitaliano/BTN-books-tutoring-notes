<?php
require_once './core/areariservataCtrl.php';
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="./scripts/main_script.js"></script>
    <title>BTN - Libri, appunti, ripetizioni</title>
</head>

<body>
    <header>
        <div>
          <div>
            <h1><a href="./index.php" class="logo"><abbr title="Book Tutoring Notes">BTN</abbr></a></h1>
            <button id="menu-btn" class="button" onclick="menuOnClick()"><span lang="en">MENU</span></button>
        </div>

            <button id="menu-btn" class="button" onclick="menuOnClick()">MENU</button>
        </div>

        <?php printItemNavMenu("areariservata",$auth->getIfLogin());?>
    </header>
    <?php printItemBreadcrumb("areariservata"); ?>
    <?php if(!$auth->getIfLogin()) : ?>
      <div class="container">
        <div id="welcome-message">
          <h2>Utente Non Loggato</h2><span>Si prega di effetuare il Login Prima<span>
          <p>Hai già un <span lang ="en">account</span>?<a href="login.php"> Accedi</a></p>
          <p>Prima volta su <abbr title="Book Tutoring Notes">BTN</abbr>? <a href="registrazione.html">Registrati</a></p>
        </div>
      </div>       
    <?php else :?>
      <div class="container">
        <div id="welcome-message">
          <h1>Benvenuto, <?php echo $_SESSION["loginAccount"]?></h1>
          <img src="./assets/imgs/icona.png"alt="" width="150" height="150" style="margin-top: 10px;">
        </div>
        <div id="user-info">
          <p>Nome: <?php echo $_SESSION["nameAccount"]?></p>
          <p>Cognome: <?php echo $_SESSION["surnameAccount"]?></p>
          <p>Email: <?php echo $_SESSION["emailAccount"]?></p>
          <p>Data Di Nascita: <?php echo $_SESSION["birthdateAccount"]?></p>
        </div>
      </div>
      <div id="annunci-container" >
        <div id="annunci-nuovo">
          <p>Aggiungi Un Annuncio<a href="new_listing.php?nuovo">Nuovo</a></p>
        </div>
        <div id="annunci-pubblicati">
          <!-- tabella annunci pubblicati -->
          <h3>Annunci pubblicati</h3>
          <table>
            <tr>
              <th>Titolo</th>
              <th>Materia Scolastica</th>
              <th>Prezzo</th>
              <th></th>
              <th></th>
            </tr>
            <?php
            $annunci = $rich->getAnnunciOfUser($_SESSION["loginAccount"]);
            foreach($annunci as $annuncio): ?>
              <tr>
                <td><?php print($annuncio['titolo'])?></td>
                <td><?php print($annuncio['materia'])?></td>
                <td><?php print($annuncio['prezzo'])?> €</td>
                <td><a href="listing.php?annuncio=<?php print($annuncio['id'])?>">Visualizza</a></td>
                <td><a href="edit_listing.php?modifica=<?php print($annuncio['id'])?>">Modifica</a></td>
                <td><a href="edit_listing.php?elimina=<?php print($annuncio['id'])?>">Elimina</a></td>
              </tr>
            <?php endforeach;
            ?>
          </table>         
        </div>
        <div id="annunci-salvati">
          <!-- tabella annunci salvati -->
          <h3>Annunci salvati</h3>
          <table>
            <tr>
              <th>Titolo</th>
              <th>Materia Scolastica</th>
              <th>Prezzo</th>
            </tr>
            <tr>
              <td>Tutor privato</td>
              <td>Inglese</td>
              <td>€30/ora</td>
            </tr>
          </table>
        </div>
      </div>
    <?php endif; ?>

    
</body>