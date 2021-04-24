<?php

namespace OpenClassrooms\Snake\Controleur; // La classe sera dans ce namespace

require_once 'Controleur/controleur.php';
require_once 'Config/Vue.php';

class Routeur
{

    private $ctrl;

    public function __construct()
    {
        $this->ctrl = new \OpenClassrooms\Snake\Controleur\Controleur();
    }

    // Traite une requête entrante
    public function routerRequete()
    {

        try {
            if (isset($_GET['action'])) {

                if ($_GET['action'] == 'login') {
                    $vue = new \OpenClassrooms\Snake\Vue\Vue("Connexion");
                    $vue->generer(array());
                }

                // ACTION POUR SE CONNECTER
                else if ($_GET['action'] == 'connexion') {
                    $pseudo = $this->getParametre($_POST, 'pseudo');
                    $resultat = $this->getParametre($_POST, 'password');
                    $this->ctrl->authentification($pseudo, $resultat);

                }

                // ACTION POUR S'INSCRIRE'
                else if ($_GET['action'] == 'sinscrire') {
                    $pseudo = $this->getParametre($_POST, 'pseudo');
                    $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
                    $this->ctrl->utilisateur($pseudo, $pass);

                }

                // ACTION POUR SE RENDRE SUR LA PAGE JEU'
                else if ($_GET['action'] == 'jeu') {
                    $vue = new \OpenClassrooms\Snake\Vue\Vue("Jeu");
                    $vue->generer(array());
                }

                // ACTION POUR SE RENDRE SUR LA PAGE REGLES'
                else if ($_GET['action'] == 'regles') {
                    $vue = new \OpenClassrooms\Snake\Vue\Vue("Regles");
                    $vue->generer(array());
                }

                // ACTION POUR SE RENDRE SUR LA PAGE SCORE'
                else if ($_GET['action'] == 'scores') {
                    $modeleUtilistateur = new \OpenClassrooms\Snake\Modele\UtilisateurManager();
                    $users = $modeleUtilistateur->usersList();
                    $vue = new \OpenClassrooms\Snake\Vue\Vue("Scores");
                    $vue->generer(array('users' => $users));
                }

                // ACTION POUR SE RENDRE SUR LA PAGE S'INSCRIRE'
                else if ($_GET['action'] == 'inscription') {
                    $vue = new \OpenClassrooms\Snake\Vue\Vue("Inscription");
                    $vue->generer(array());
                }

                // ACTION POUR RÉCUPÉRER LE SCORE DANS LA BDD
                else if ($_GET['action'] == 'scoreBdd') {
                    session_start();
                    $pseudoUser = $_SESSION['pseudo'];
                    $this->ctrl->scoreSnakeVerify($pseudoUser);
                }

                // ACTION POUR MODIFIER LE SCORE DANS LA BDD
                else if ($_GET['action'] == 'score') {
                    session_start();
                    $snakeScore = $this->getParametre($_POST, 'score');
                    $pseudoUser = $_SESSION['pseudo'];

                    $this->ctrl->scoreSnake($snakeScore, $pseudoUser);
                }

                // ACTION POUR SE DÉCONNECTER
                else if ($_GET['action'] == 'logout') {

                    $this->ctrl->logout();

                } else {
                    throw new \Exception("Action non valide");
                }

            }

            // DÉFINITION DE L'ACTION PAR DÉFAULT
            else {
                $this->ctrl->accueil();
            }
        } catch (\Exception $e) {
            $this->erreur($e->getMessage());
        }

    }

    // Affiche une erreur
    private function erreur($msgErreur)
    {
        $vue = new \OpenClassrooms\Snake\Vue\Vue("Erreur");
        $vue->generer(array('msgErreur' => $msgErreur));
    }

    // Recherche un paramètre dans un tableau
    private function getParametre($tableau, $nom)
    {
        if (isset($tableau[$nom])) {
            return $tableau[$nom];
        } else {
            throw new \Exception("Paramètre '$nom' absent");
        }

    }
}
