<?php

namespace App\Model\Repository;

use App\Model\Utilisateur;
use Core\Repository\Repository;


class UtilisateurRepository extends Repository
{
    public function getTableName(): string
    {
        return 'utilisateur';
    }

    public function checkAuth(string $email, string $motdepasse): ?Utilisateur
    {
        // on crée la requête
        $query = sprintf(
            'SELECT * FROM %s WHERE email = :email AND mot_de_passe = :motdepasse',
            $this->getTableName()
        );

        // on prépare la requête
        $stmt = $this->pdo->prepare($query);
        // on vérifie que la requête est bien préparée
        if (!$stmt) return null;
        // on exécute la requête
        $stmt->execute([
            'email' => $email,
            'motdepasse' => $motdepasse
        ]);
        // on récupère les données
        $user_data = $stmt->fetch();
        // on instancie un objet Users
        return empty($user_data) ? null : new Utilisateur($user_data);
    }



    public function checkAuthInscription(array $data): bool
    {
        // on crée une requête pour savoir si un utilisateur existe déjà
        $q_select = sprintf(
            'SELECT * FROM `%s` WHERE `email` = :email',
            $this->getTableName()
        );

        // on prépare la requête select
        $stmt_select = $this->pdo->prepare($q_select);

        // on vérifie que la requête est bien préparée
        if (!$stmt_select) return false;

        // on exécute la requête select
        $stmt_select->execute([
            'email' => $data['email']
        ]);

        // on récupère les données
        $user_data = $stmt_select->fetch();

        // si j'ai un résultat, je retourne false
        if (!empty($user_data)) {
            return false;
        } else {

            // on créer la requête d'insertion
            $q = sprintf(
                'INSERT INTO `%s` (`email`, `mot_de_passe`, `is_annonceur`, `adresse_id`) 
                VALUES (:email, :mot_de_passe, :is_annonceur, :adresse_id)',
                $this->getTableName()

            );

            // on prépare la requête
            $stmt = $this->pdo->prepare($q);
            // on vérifie que la requête est bien préparée
            if (!$stmt) return false;
            // on exécute la requête
            $stmt->execute($data);
            // on récupère les données
            $user_data = $stmt->fetch();
            // on instancie un objet Users
            return true;
        }
    }
}
