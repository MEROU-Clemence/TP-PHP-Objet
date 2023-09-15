<h1><?= $title_tag ?></h1>

<?php var_dump($reservation); ?>

<!-- TODO: faire le rendu de ce que je veux afficher comme card dans mes réservations -->
<div class="d-flex flex-row flex-wrap justify-content-center col-6">
    <div class="card m-2" style="width: 42rem">
        <!-- TODO: faire une boucle pour afficher mon tableau de réservations -->
        <h3 class="card-title m-2"><?= $reservation[0]->annonce->titre ?></h3>
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


<div class="button-retour btn-manip">
    <a href="/">Retour accueil</a>
</div>