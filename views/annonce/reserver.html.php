<h1><?= $title_tag ?></h1>

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
            <div class="dates-resa">
                <p>Date début:</p>
                <div class="dates-select m-2">
                    <select name="day">
                        <?php
                        for ($day = 1; $day <= 31; $day++) {
                            echo "<option value=\"$day\">$day</option>";
                        }
                        ?>
                    </select>
                    <select name="month">
                        <?php
                        $months = [
                            '01' => 'Janvier', '02' => 'Février', '03' => 'Mars',
                            '04' => 'Avril', '05' => 'Mai', '06' => 'Juin',
                            '07' => 'Juillet', '08' => 'Août', '09' => 'Septembre',
                            '10' => 'Octobre', '11' => 'Novembre', '12' => 'Décembre',
                        ];

                        foreach ($months as $monthNumber => $monthName) {
                            echo "<option value=\"$monthNumber\">$monthName</option>";
                        }
                        ?>
                    </select>

                    <select name="year">
                        <?php
                        $currentYear = date("Y");
                        $endYear = $currentYear + 10;

                        for ($year = $currentYear; $year <= $endYear; $year++) {
                            echo "<option value=\"$year\">$year</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="dates-resa">
                <p>Date fin:</p>
                <div class="dates-select m-2">
                    <select name="day">
                        <?php
                        for ($day = 1; $day <= 31; $day++) {
                            echo "<option value=\"$day\">$day</option>";
                        }
                        ?>
                    </select>
                    <select name="month">
                        <?php
                        $months = [
                            '01' => 'Janvier', '02' => 'Février', '03' => 'Mars',
                            '04' => 'Avril', '05' => 'Mai', '06' => 'Juin',
                            '07' => 'Juillet', '08' => 'Août', '09' => 'Septembre',
                            '10' => 'Octobre', '11' => 'Novembre', '12' => 'Décembre',
                        ];

                        foreach ($months as $monthNumber => $monthName) {
                            echo "<option value=\"$monthNumber\">$monthName</option>";
                        }
                        ?>
                    </select>

                    <select name="year">
                        <?php
                        $currentYear = date("Y");
                        $endYear = $currentYear + 10;

                        for ($year = $currentYear; $year <= $endYear; $year++) {
                            echo "<option value=\"$year\">$year</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>


            <div class="go m-2">
                <input type="submit" value="Confirmer réservation">
            </div>
        </div>
    </div>
</div>

<div class="button-retour btn-manip">
    <a href="/">Retour accueil</a>
</div>