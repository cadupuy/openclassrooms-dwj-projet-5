<?php session_start();?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Londrina+Solid&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bangers&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="public/css/style.css" />
    <title>Snake Game</title>
</head>

<body class="fondSnake">

    <div class="title-page">
        <h1 class="titre-jeu">SNAKE GAME</h1>
    </div>
    <nav class="navAccueil">
        <ul class="ulAccueil">
            <li class="liAccueil"><a href="index.php?action=jeu">JOUER</a></li>
            <li class="liAccueil"><a href="index.php?action=regles">RÈGLES</a></li>
            <li class="liAccueil"><a href="index.php?action=scores">SCORES</a></li>
            <?php
if (isset($_SESSION['pseudo'])) {
    echo '<li class="liAccueil"><a href="index.php?action=logout">DECONNEXION</a></li>';

} else {
    echo '<li class="liAccueil"><a href="index.php?action=login">CONNEXION</a></li>';
}?>
        </ul>
    </nav>


    <section class="piedDePage">
        <div class="footer">
            <p>© Charles-Antoine Dupuy - 2020</p>
        </div>
    </section>

</body>

</html>
