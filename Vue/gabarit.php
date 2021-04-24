<?php session_start();?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title><?=$titre?></title>   <!-- Élément spécifique -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Londrina+Solid&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bangers&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="public/css/style.css" />
    <script src="https://kit.fontawesome.com/22878924ef.js" crossorigin="anonymous"></script>



</head>

<body class="fondSnake">


    <div class="nav-toggle">
	    <div class="nav-toggle-bar"></div>
    </div>

    <nav id="nav" class="nav">
	    <ul>
            <li class="liAccueilSmall"><a href="index.php?action=jeu">JOUER</a></li>
            <li class="liAccueilSmall"><a href="index.php?action=regles">RÈGLES</a></li>
            <li class="liAccueilSmall"><a href="index.php?action=scores">SCORES</a></li>
    <?php
if (isset($_SESSION['pseudo'])) {
    echo '  <li class="liAccueilSmall"><a href="index.php?action=logout">DECONNEXION</a></li>';

} else {
    echo '  <li class="liAccueilSmall"><a href="index.php?action=login">CONNEXION</a></li>';
}?>	    </ul>
    </nav>

    <?=$contenu?>   <!-- Élément spécifique -->

    <!-- SCRIPTS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="public/js/canvas.js"></script>
    <script src="public/js/ajax.js"></script>
    <script src="public/js/menu.js"></script>
    <script src="public/js/diaporama.js"></script>


</body>
</html>
