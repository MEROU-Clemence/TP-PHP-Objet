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

    <form class="form-annonce" action="/annoncePost" method="post" enctype="multipart/form-data">
        <div class="first-div">
            <label for="titre">
                <strong>Titre:</strong> <input type="text" name="titre" id="titre">
            </label>
        </div>

        <div>
            <label for="images">
                <strong>Télécharger mes images:</strong> <input type="file" name="images" id="images" accept="image/*" multiple>
            </label>
        </div>

        <div>
            <label for="description">
                <strong>Description:</strong><br>
                <textarea name="description" id="description" rows="4" cols="50"></textarea>
            </label>
        </div>

        <div>
            <label>
                <strong>Adresse:</strong>
            </label>
            <div>
                <label for="rue">Numéro et nom de rue:
                    <input type="text" name="rue" id="rue">
                </label><br>
                <label for="codepostal">Code postal:
                    <input type="text" name="codepostal" id="codepostal">
                </label><br>
                <label for="ville">Ville:
                    <input type="text" name="ville" id="ville">
                </label><br>
                <label for="pays">Pays:
                    <input type="text" name="pays" id="pays">
                </label>
            </div>
        </div>

        <div>
            <label for="prix">
                <strong>Prix:</strong> <input type="text" name="prix" id="prix"> € /nuit
            </label>
        </div>

        <div>
            <label for="taille">
                <strong>Taille de mon bien:</strong> <input type="text" name="taille" id="taille"> /m2
            </label>
        </div>

        <div>
            <label for="typeslogement">
                <strong>Type de logement:</strong>
            </label>
            <ul>
                <?php foreach ($typeslogement as $type) : ?>
                    <li>
                        <input type="radio" name="type_logement" id="<?= $type->label ?>" value="<?= $type->id ?>">
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
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
                <option value="16">16</option>
                <option value="17">17</option>
                <option value="18">18</option>
                <option value="19">19</option>
                <option value="20">20 et +</option>
            </select>
        </div>

        <div>
            <label for="couchages">
                <strong>Nombre de couchages:</strong>
            </label>
            <select name="couchages" id="couchages">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
                <option value="16">16</option>
                <option value="17">17</option>
                <option value="18">18</option>
                <option value="19">19</option>
                <option value="20">20 et +</option>
            </select>
        </div>

        <div>
            <label for="email">
                <strong>Confirmation email:</strong> <input type="email" name="email" id="email">
            </label><br>
        </div>

        <div>
            <label for="equipement">
                <strong>Equipement(s):</strong>
            </label>
            <ul>
                <?php foreach ($equipements as $equipement) : ?>
                    <li>
                        <input type="checkbox" name="equipement[]" id="<?= $equipement->id ?>" value="<?= $equipement->id ?>">
                        <label for="<?= $equipement->id ?>"><?= $equipement->label ?></label>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="go">
            <input type="submit" value="Envoyer">
        </div>
    </form>




    <div class="button-retour btn-manip">
        <a href="/">Retour accueil</a>
    </div>