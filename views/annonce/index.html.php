<?php

use App\Controller\AuthController;
use App\Controller\InscriptionController;
use Core\Session\Session;

?>


<div class="profil-manip">
    <?php if (AuthController::isAuth() || InscriptionController::isAuth()) : ?>
        <p class="profil-utilisateur">Profil utilisateur
            <?= $email = Session::get(Session::USER)->email;
            // TODO: faire apparaitre de mail lors de l'inscription également var_dump($email); 
            ?>

        </p>
        <div class="btn-manip">
            <a href="/logout">Déconnexion</a>
        </div>
    <?php else : ?>
        <p class="profil-utilisateur">Mon profil :</p>
        <div class="buttons btn-manip">
            <a href="/connexion">Connexion</a>
            <a href="/inscription">Inscription</a>
        </div>
    <?php endif; ?>
</div>


<div class="button-add-annonce">
    <a href="/addannonce">Ajouter une annonce</a>
</div>
<!-- TODO: appel pour le rendu de mon annonce -->
<h1><?= $title_tag ?></h1>
<?php
// si on a pas d'annonces
if (empty($annonces)) : ?>
    <p>Aucunes annonces en ce moment</p>
<?php else : ?>
    <div class="d-flex flex-row flex-wrap justify-content-center col-6">
        <?php
        foreach ($annonces as $annonce) : ?>
            <div class="card m-2" style="width: 18rem">
                <h3 class="m-2"><?= $annonce->titre ?></h3>
                <?php if (!empty($annonce->images)) : ?>
                    <?php foreach ($annonce->images as $image) : ?>
                        <img src="/img/<?= $image->image_path ?>" class="card-img-top img-fluid p-3" alt="<?= $annonce->titre ?>">
                    <?php endforeach; ?>
                <?php endif; ?>
                <p class="m-2"><?= $annonce->adresse->ville ?>, <?= $annonce->adresse->pays ?></p>
                <p class="m-2"><?= $annonce->prix ?>€ /nuit</p>
                <h5 class="m-2"><?= $annonce->typelogement->label ?></h5>
                <a href="/annonce/<?= $annonce->id ?>" class="btn btn-primary"> Voir détail</a>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>