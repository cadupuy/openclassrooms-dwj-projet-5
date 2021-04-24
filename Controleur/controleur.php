<?php

namespace OpenClassrooms\Snake\Controleur; // La classe sera dans ce namespace

require_once 'Modele/modeleUtilisateur.php';
require_once 'Config/Vue.php';

class Controleur
{

    public function __construct()
    {
        $this->modeleUtilisateur = new \OpenClassrooms\Snake\Modele\UtilisateurManager();
    }

    // Ajoute un utilisateur à la base de données
    public function utilisateur($pseudo, $pass)
    {
        $utilisateur = $this->modeleUtilisateur->ajouterUtilisateur($pseudo, $pass);

        if ($utilisateur) {
            session_start();
            $_SESSION['pseudo'] = $pseudo;
            header('Location: index.php');
        }
        // Actualisation de l'affichage
        throw new \Exception('Impossible d\'ajouter l\'utilisateur');
    }

// Modifie le score d'un utilisateur sur le jeu snake
    public function scoreSnake($snakeScore, $pseudoUser)
    {
        $score = $this->modeleUtilisateur->updateSnakeScore($snakeScore, $pseudoUser);

    }

// Vérifie le score d'un joueur Snake
    public function scoreSnakeVerify($pseudoUser)
    {
        $scoreVerify = $this->modeleUtilisateur->selectSnakeScore($pseudoUser);
        echo $scoreVerify["snakeScore"];
    }

    public function accueil()
    {
        require 'Vue/vueAccueil.php';
    }

    public function authentification($pseudo, $resultat)
    {

        $user = $this->modeleUtilisateur->getUser($pseudo);
        $isPasswordCorrect = password_verify($resultat, $user['pass']);

        if ($isPasswordCorrect) {
            session_start();
            $_SESSION['pseudo'] = $pseudo;
            header('Location: index.php');
        } else {
            throw new \Exception("Mauvais identifiant ou mot de passe !");

        }
    }

    // Clotûre la session
    public function logout()
    {
        session_start();
        // Suppression des variables de session et de la session
        $_SESSION = array();
        session_destroy();

        header('Location: index.php');
    }

}
