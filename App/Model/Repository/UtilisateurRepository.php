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



    public function checkAuthInscription(string $email, string $motdepasse, bool $isannonceur, int $adresse): ?Utilisateur
    {
        // on crée la requête
        $query = sprintf(
            'SELECT * FROM %s WHERE email = :email AND mot_de_passe = :motdepasse AND is_annonceur = :isannonceur AND adresse_id =: adresse',
            $this->getTableName()
        );

        // on prépare la requête
        $stmt = $this->pdo->prepare($query);
        // on vérifie que la requête est bien préparée
        if (!$stmt) return null;
        // on exécute la requête
        $stmt->execute([
            'email' => $email,
            'motdepasse' => $motdepasse,
            'isannonceur' => $isannonceur,
            'adresse' => $adresse
        ]);
        // on récupère les données
        $user_data = $stmt->fetch();
        // on instancie un objet Users
        return empty($user_data) ? null : new Utilisateur($user_data);
    }
}
