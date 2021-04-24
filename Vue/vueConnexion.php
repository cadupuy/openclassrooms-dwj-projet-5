<?php $this->titre = "Connexion";?>

<section class="fondco">

<div class="formulaireConnexion">
    <form class="formConnexion" method="post" action="index.php?action=connexion">
        <h2 class="titleConnexion">Connexion</h2>
        <input class="inputCo" type="text" id="pseudo" placeholder="Pseudo" name="pseudo" required><br>
        <input class="inputCo" type="password" id="password" name="password" placeholder="Mot de passe" required><br>
        <input class="bouton2" type="submit" value="Connexion" id="submit" name="Connexion">
        <p class="retour">Vous n'avez pas encore de compte ? <a class="pasDeCompte" href="index.php?action=inscription">S'inscrire</a></p>
    </form>
</div>

</section>
