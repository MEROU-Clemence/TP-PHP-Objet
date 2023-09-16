<?php

use Core\Session\Session;

?>

<h1><?= $title_tag ?></h1>

<?php
// on affiche les erreurs si il y en a 
if (isset($form_result) && $form_result->hasError()) : ?>
    <div>
        <?php foreach ($form_result->getErrors() as $error) : ?>
            <p><?= $error->getMessage() ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>


<div class="d-flex">
    <div class="d-flex flex-row flex-wrap justify-content-center col-6">
        <div class="card m-2" style="width: 42rem">
            <h3 class="card-title m-2"><?= $annonce->titre ?></h3>
            <?php if (!empty($annonce->images)) : ?>
                <?php foreach ($annonce->images as $image) : ?>
                    <img src="/img/<?= $image->image_path ?>" class="card-img-top img-fluid p-3" alt="<?= $annonce->titre ?>">
                <?php endforeach; ?>
            <?php endif; ?>
            <div class="m-2 card-info">
                <p><?= $annonce->description ?></p>
                <p><strong>Localisation:</strong> <?= $annonce->adresse->rue ?>, <?= $annonce->adresse->code_postal ?>, <?= $annonce->adresse->ville ?>, <?= $annonce->adresse->pays ?></p>
                <p><strong>Prix:</strong> <?= $annonce->prix ?>€ /nuit</p>
                <h5 class="card-typelogmt"><?= $annonce->typelogement->label ?></h5>
                <p><strong>Taille:</strong> <?= $annonce->taille ?> m2</p>
                <p><strong>Nombre de pièces:</strong> <?= $annonce->nb_pieces ?> pièces</p>
                <h5 class="card-contact">Contact:</h5>
                <p><strong>Email:</strong> <?= $annonce->utilisateur->email ?></p>
                <h5 class="card-contact">Equipements:</h5>
                <?php if (!empty($annonce->equipements)) : ?>
                    <?php foreach ($annonce->equipements as $equipement) : ?>
                        <p><?= $equipement->label ?></p>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="d-flex flex-row flex-wrap justify-content-center col-6">
        <div class="card m-2" style="width: 42rem">

            <h3 class="card-title m-2">Réserver ce logement</h3>

            <form action="/reserverPost" method="post" enctype="multipart/form-data">
                <input type="hidden" name="annonce_id" value="<?= $annonce->id ?>">
                <input type="hidden" name="utilisateur_id" value="<?= Session::get(Session::USER)->id ?>">

                <div class="dates-resa m-2">
                    <p><strong>Date début: &nbsp;</strong> </p>
                    <input type="date" id="date_debut" name="date_debut" value="2023-15-09" min="2023-15-09" max="2033-15-09" />
                </div>
                <div class="dates-resa m-2">
                    <p><strong>Date fin: &nbsp;</strong> </p>
                    <input type="date" id="date_fin" name="date_fin" value="2023-15-09" min="2023-15-09" max="2033-15-09" />
                </div>


                <div class="go m-2">
                    <input type="submit" value="Confirmer réservation">
                </div>

            </form>
        </div>
    </div>
</div>


<div class="button-retour btn-manip">
    <a href="/">Retour accueil</a>
</div>