<?php

namespace App\Model\Repository;

use App\Model\Utilisateur;
use Core\Repository\Repository;
use App\Model\Repository\UtilisateurRepository;

class UtilisateurRepository extends Repository
{
    public function getTableName(): string
    {
        return 'utilisateur';
    }

    public function checkAuth(string $email, string $password): ?Utilisateur
    {
        // on crée la requête
        $query = sprintf(
            'SELECT * FROM %s WHERE email = :email AND password = :password',
            $this->getTableName()
        );

        // on prépare la requête
        $stmt = $this->pdo->prepare($query);
        // on vérifie que la requête est bien préparée
        if (!$stmt) return null;
        // on exécute la requête
        $stmt->execute([
            'email' => $email,
            'password' => $password
        ]);
        // on récupère les données
        $user_data = $stmt->fetch();
        // on instancie un objet Users
        return empty($user_data) ? null : new Utilisateur($user_data);
    }

    // créer une méthode qui récupère la liste des utilisateurs
    public function findAll(): array
    {
        return $this->readAll(Utilisateur::class);
    }

    // méthode qui récupère un utilisateur par son id
    public function findById(int $id): ?Utilisateur
    {
        return $this->readById(Utilisateur::class, $id);
    }

    // méthode qui update l'utilisateur
    public function updateUserById(string $email, int $role, int $id): ?Utilisateur
    {
        // on crée la requête
        $q = sprintf(
            'UPDATE `%s` SET `email` = :email, `role` = :role WHERE `id` = :id',
            $this->getTableName()
        );

        // on prépare la requête
        $stmt = $this->pdo->prepare($q);
        // on vérifie que la requête est bien préparée
        if (!$stmt) return null;
        // on exécute la requête
        $stmt->execute([
            'email' => $email,
            'role' => $role,
            'id' => $id
        ]);
        // on récupère les données
        $user_data = $stmt->fetch();

        // on instancie un objet User
        return empty($user_data) ? null : new Utilisateur($user_data);
    }

    // méthode pour supprimer un utilisateur
    public function deleteUser(int $id): bool
    {
        return $this->delete($id);
    }

    // méthode pour créer un nouvel utilisateur
    public function createUtilisateur(string $email, string $password, int $role)
    {
        // on créer la requête d'insertion
        $q_insert = sprintf(
            'INSERT INTO `%s` (`email`, `password`, `role`)
            VALUES (:email, :password, :role)',
            $this->getTableName()
        );

        // on crée une requête pour savoir si un utilisateur existe déjà
        $q_select = sprintf(
            'SELECT * FROM `%s` WHERE `email` = :email',
            $this->getTableName()
        );

        // on prépare la requête select
        $stmt_select = $this->pdo->prepare($q_select);

        // on vérifie que la requête est bien préparée
        if (!$stmt_select) return null;

        // on exécute la requête select
        $stmt_select->execute([
            'email' => $email
        ]);

        // on récupère les données
        $user_data = $stmt_select->fetch();

        // si j'ai un résultat, je retourne false
        if (!empty($user_data)) return false;

        // sinon on prépare la requête d'insertion
        $stmt_insert = $this->pdo->prepare($q_insert);

        // on vérifie que la requête est bien préparée
        if (!$stmt_insert) return false;

        // on exécute la requête d'insertion
        $stmt_insert->execute([
            'email' => $email,
            'password' => $password,
            'role' => $role
        ]);

        // on retourne true
        return true;
    }
}
