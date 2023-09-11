<div class="general-connexion">
    <h2 class="titre-connexion">Inscription</h2>
    <?php
    // on affiche les erreurs si il y en a 
    if ($form_result && $form_result->hasError()) {
    ?>
        <div>
            <?php echo $form_result->getErrors()[0]->getMessage(); ?>
        </div>
    <?php
    }
    ?>

    <form class="connexion" action="/inscriptionPost" method="post">
        <label for="email">
            <strong>Email:</strong> <input type="email" name="email" id="email">
        </label><br>
        <label for="motdepasse">
            <strong>Mot de passe:</strong> <input type="password" name="motdepasse" id="motdepasse">
        </label><br>
        <label for="isannonceur">
            <strong>Voulez-vous également poster des annonces?</strong>
        </label>
        <div class="d-flex flex-row">
            <label for="oui">Oui
                <input type="radio" name="isannonceur" id="oui" value="1" checked>
            </label> &nbsp;
            <label for="non">Non
                <input type="radio" name="isannonceur" id="non" value="0">
            </label>
        </div><br>
        <label>
            <strong>Votre adresse:</strong>
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
            </label><br>
        </div><br>
        <div class="go">
            <input type="submit" value="S'inscrire">
        </div>
    </form>
</div>