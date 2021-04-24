<?php

namespace OpenClassrooms\Snake\Modele; // La classe sera dans ce namespace

require_once "Config/modele.php";
class UtilisateurManager extends Modele
{

    // Renvoie la liste de tous les scores, triés par ordre décroissant
    public function usersList()
    {
        $sql = 'SELECT pseudo, snakeScore FROM users'
            . ' order by snakeScore desc'
            . ' LIMIT 0, 3;';
        $users = $this->executerRequete($sql);
        return $users;

    }

    public function getUser($pseudo)
    {
        //  Récupération de l'utilisateur et de son pass hashé
        $sql = 'SELECT id, pass FROM users WHERE pseudo = ?';
        $connexion = $this->executerRequete($sql, array($pseudo));
        $resultat = $connexion->fetch();
        return $resultat;

    }

    public function ajouterUtilisateur($pseudo, $pass)
    {
        $sql = 'INSERT INTO users(pseudo, pass) VALUES (?, ?)';
        $ajout = $this->executerRequete($sql, array($pseudo, $pass));
        return $ajout;
    }

    public function updateSnakeScore($snakeScore, $pseudoUser)
    {
        $sql = 'UPDATE users SET snakeScore=? WHERE pseudo=?';
        $userUpdate = $this->executerRequete($sql, array($snakeScore, $pseudoUser));
        return $userUpdate;
    }

    // Renvoie la liste de tous les scores, triés par ordre décroissant
    public function selectSnakeScore($pseudoUser)
    {
        $sql = 'SELECT snakeScore FROM users WHERE pseudo = ?';
        $selectSnake = $this->executerRequete($sql, array($pseudoUser));
        $resultat = $selectSnake->fetch();
        return $resultat;

    }

}
