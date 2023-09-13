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
                <strong>Prix:</strong>
            </label>
            <select name="prix" id="prix">
                <option value="50">10 € /nuit</option>
                <option value="50">20 € /nuit</option>
                <option value="50">30 € /nuit</option>
                <option value="50">40 € /nuit</option>
                <option value="50">50 € /nuit</option>
                <option value="50">60 € /nuit</option>
                <option value="50">70 € /nuit</option>
                <option value="50">80 € /nuit</option>
                <option value="50">90 € /nuit</option>
                <option value="50">100 € /nuit</option>
                <option value="100">125 € /nuit</option>
                <option value="150">150 € /nuit</option>
                <option value="150">175 € /nuit</option>
                <option value="150">200 € /nuit</option>
                <option value="150">250 € /nuit</option>
                <option value="150">250 € /nuit</option>
                <option value="150">275 € /nuit</option>
                <option value="150">300 € /nuit</option>
                <option value="150">350 € /nuit</option>
                <option value="150">400 € /nuit</option>
                <option value="150">450 € /nuit</option>
                <option value="150">500 € /nuit</option>
                <option value="150">600 € /nuit</option>
                <option value="150">700 € /nuit</option>
                <option value="150">800 € /nuit</option>
                <option value="150">900 € /nuit</option>
                <option value="150">1000 € /nuit</option>
            </select>
        </div>

        <div>
            <label for="taille">
                <strong>Taille de mon bien:</strong> <input type="text" name="taille" id="taille"> /m2
            </label>
        </div>

        <!-- TODO: ici ajouter le type de logement dans un menu select. 1 seule option possible -->

        <div>
            <label for="pieces">
                <strong>Nombre de pièces:</strong>
            </label>
            <select name="pieces" id="pieces">
                <option value="50">1</option>
                <option value="50">2</option>
                <option value="50">3</option>
                <option value="50">4</option>
                <option value="50">5</option>
                <option value="50">6</option>
                <option value="50">7</option>
                <option value="50">8</option>
                <option value="50">9</option>
                <option value="50">10</option>
                <option value="50">11</option>
                <option value="50">12</option>
                <option value="50">13</option>
                <option value="50">14</option>
                <option value="50">15</option>
                <option value="50">16</option>
                <option value="50">17</option>
                <option value="50">18</option>
                <option value="50">19</option>
                <option value="50">20 et +</option>
            </select>
        </div>

        <div>
            <label for="email">
                <strong>Confirmation email:</strong> <input type="email" name="email" id="email">
            </label><br>
        </div>

        <!-- TODO: faire mon menu déroulant avec les options possibles dans mon logement. On peut en sélectionner plusieurs -->

        <div class="go">
            <input type="submit" value="Envoyer">
        </div>
    </form>




    <div class="button-retour btn-manip">
        <a href="/">Retour accueil</a>
    </div>