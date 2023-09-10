<?php

namespace App\Model\Repository;

use App\Model\Utilisateur;
use Core\Repository\Repository;
use Core\Repository\AppRepoManager;


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



    public function checkAuthInscription(string $email, string $motdepasse, bool $isannonceur, string $rue, string $codepostal, string $ville, string $pays): ?Utilisateur
    {

        // on crée la requête
        /*$query = sprintf(
            'SELECT `%1$s`.*,  `%2$s`.rue AS rue, `%2$s`.code_postal AS codepostal, `%2$s`.ville AS ville, `%2$s`.pays AS pays
            FROM `%1$s`
            INNER JOIN `%2$s`
            ON `%1$s`.adresse_id = `%2$s`.id
            WHERE `%1$s`.email = :email
                AND `%1$s`.mot_de_passe = :motdepasse
                AND `%1$s`.is_annonceur = :isannonceur
                AND `%2$s`.rue = :rue
                AND `%2$s`.code_postal = :codepostal
                AND `%2$s`.ville = :ville
                AND `%2$s`.pays = :pays',
            // Je donne la valeur a  `%1$s` qui correspond a la table utilisateur
            $this->getTableName(),
            // donner la valeur de %2$s qui correspond à la table adresse
            // on le récupère à travers notre AppRepoManager
            AppRepoManager::getRm()->getAdresseRepo()->getTableName()
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
            'rue' => $rue,
            'codepostal' => $codepostal,
            'ville' => $ville,
            'pays' => $pays
        ]);
        // on récupère les données
        $user_data = $stmt->fetch();
        // on instancie un objet Users
        return empty($user_data) ? null : new Utilisateur($user_data);
        
        
        */

        // on créer la requête d'insertion
        $q_insert = sprintf(
            'INSERT INTO `%1$s` (`email`, `mot_de_passe`, `is_annonceur`), `%2$s` (`rue`, `code_postal`, `ville`, `pays`)
            VALUES (:email, :motdepasse, :isannonceur, :rue, :codepostal, :ville, :pays)',
            $this->getTableName(),
            AppRepoManager::getRm()->getAdresseRepo()->getTableName()
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
            'motdepasse' => $motdepasse,
            'isannonceur' => $isannonceur,
            'rue' => $rue,
            'codepostal' => $codepostal,
            'ville' => $ville,
            'pays' => $pays
        ]);

        // on retourne true
        return true;
    }
}
