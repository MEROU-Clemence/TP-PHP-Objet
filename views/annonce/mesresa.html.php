<h1><?= $title_tag ?></h1>

<div class="d-flex flex-row flex-wrap justify-content-center col-12">
    <?php foreach ($reservation as $resa) : ?>
        <div class="card m-2" style="width: 42rem">
            <div class="m-2 card-info">
                <h3 class="card-title m-2"><?= $resa->annonce->titre ?></h3>
                <?php if (!empty($resa->annonce->images)) : ?>
                    <?php foreach ($resa->annonce->images as $image) : ?>
                        <img src="/img/<?= $image->image_path ?>" class="card-img-top img-fluid p-3" alt="<?= $resa->annonce->titre ?>">
                    <?php endforeach; ?>
                <?php endif; ?>
                <p><?= $resa->annonce->description ?></p>
                <p><strong>Date de début:</strong> <?= (new DateTime('@' . $resa->date_debut))->format('d/m/Y') ?></p>
                <p><strong>Date de fin:</strong> <?= (new DateTime('@' . $resa->date_fin))->format('d/m/Y') ?></p>
                    <?php
                    // Calculer la durée en jours de la réservation en excluant le jour de début
                    $dateDebut = new DateTime('@' . $resa->date_debut);
                    $dateFin = new DateTime('@' . $resa->date_fin);
                    $dureeReservation = $dateDebut->diff($dateFin)->days;

                    // Calculer le prix total en fonction du prix par nuit de l'annonce
                    $prixTotal = ($dureeReservation) * $resa->annonce->prix;
                    ?>
                    <p><strong>Prix total:</strong> <?= $prixTotal ?>€ (<?= $dureeReservation ?> nuit(s))</p>
                </div>
            </div>
    <?php endforeach; ?>
</div>

<div class="button-retour btn-manip">
    <a href="/">Retour accueil</a>
</div>