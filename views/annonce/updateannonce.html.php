<h1><?= $title_tag ?></h1>
<div>
    <?php
    if ($form_result && $form_result->hasError()) {
    ?>
        <div>
            <?php echo $form_result->getErrors()[0]->getMessage(); ?>
        </div>
    <?php
    }
    ?>

    <form class="form-annonce" action="/updateAnnonce" method="post" enctype="multipart/form-data">
        <!-- input hidden pour l'id du jouet -->
        <input type="hidden" name="id" value="<?= $annonce->id ?>">
        <input type="hidden" name="adresse_id" value="<?= $annonce->adresse_id ?>">
        <input type="hidden" name="utilisateur_id" value="<?= $annonce->utilisateur_id ?>">
        <input type="hidden" name="type_logement_id" value="<?= $annonce->type_logement_id ?>">

        <div class="first-div">
            <label for="titre">
                <strong>Titre:</strong>
                <input type="text" name="titre" id="titre" value="<?= $annonce->titre ?>">
            </label>
        </div>

        <div>
            <label for="images">
                <strong>Télécharger mes images:</strong>
                <input type="file" name="images" id="images" accept="image/*" multiple>
            </label>
            <?php foreach ($annonce->images as $image) : ?>
                <div>
                    <img src="/img/<?= $image->image_path ?>" alt="<?= $image->image_path ?>">
                </div>
            <?php endforeach; ?>
        </div>

        <div>
            <label for="description">
                <strong>Description:</strong><br>
                <textarea name="description" id="description" value="<?= $annonce->description ?>" rows="4" cols="50"><?= $annonce->description ?></textarea>
            </label>
        </div>

        <div>
            <label>
                <strong>Adresse:</strong>
            </label>
            <div>
                <label for="rue">Numéro et nom de rue:
                    <input type="text" name="rue" id="rue" value="<?= $annonce->adresse->rue ?>">
                </label><br>
                <label for="codepostal">Code postal:
                    <input type="text" name="codepostal" id="codepostal" value="<?= $annonce->adresse->code_postal ?>">
                </label><br>
                <label for="ville">Ville:
                    <input type="text" name="ville" id="ville" value="<?= $annonce->adresse->ville ?>">
                </label><br>
                <label for="pays">Pays:
                    <input type="text" name="pays" id="pays" value="<?= $annonce->adresse->pays ?>">
                </label>
            </div>
        </div>

        <div>
            <label for="prix">
                <strong>Prix:</strong> <input type="text" name="prix" id="prix" value="<?= $annonce->prix ?>"> € /nuit
            </label>
        </div>

        <div>
            <label for="taille">
                <strong>Taille de mon bien:</strong> <input type="text" name="taille" id="taille" value="<?= $annonce->taille ?>"> /m2
            </label>
        </div>

        <div>
            <label for="typeslogement">
                <strong>Type de logement:</strong>
            </label>
            <ul>
                <?php foreach ($typeslogement as $type) : ?>
                    <li>
                        <input type="radio" name="type_logement" id="<?= $type->label ?>" value="<?= $type->id ?>" <?= ($annonce->type_logement_id == $type->id) ? 'checked' : '' ?>>
                        <label for="<?= $type->label ?>"><?= $type->label ?></label>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div>
            <label for="pieces">
                <strong>Nombre de pièces:</strong>
            </label>
            <select name="pieces" id="pieces">
                <?php for ($i = 1; $i <= 20; $i++) : ?>
                    <option value="<?= $i ?>" <?= ($annonce->nb_pieces == $i) ? 'selected' : '' ?>><?= $i ?></option>
                <?php endfor; ?>
            </select>
        </div>

        <div>
            <label for="couchages">
                <strong>Nombre de couchages:</strong>
            </label>
            <select name="couchages" id="couchages">
                <?php for ($i = 1; $i <= 20; $i++) : ?>
                    <option value="<?= $i ?>" <?= ($annonce->nb_couchages == $i) ? 'selected' : '' ?>><?= $i ?></option>
                <?php endfor; ?>
            </select>
        </div>

        <div>
            <label for="email">
                <strong>Confirmation email:</strong> <input type="email" name="email" value="<?= $annonce->utilisateur->email ?>" id="email">
            </label><br>
        </div>

        <div>
            <label for="equipement">
                <strong>Equipement(s):</strong>
            </label>
            <ul>
                <?php foreach ($equipements as $equipement) : ?>
                    <li>
                        <input type="checkbox" name="equipement[]" id="<?= $equipement->id ?>" value="<?= $equipement->id ?>" <?php if (in_array($equipement->id, array_column($annonce->equipements, 'id'))) echo 'checked'; ?>>
                        <label for="<?= $equipement->id ?>"><?= $equipement->label ?></label>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="go">
            <input type="submit" value="Mettre à jour">
        </div>
    </form>




    <div class="button-retour btn-manip">
        <a href="/">Retour accueil</a>
    </div>