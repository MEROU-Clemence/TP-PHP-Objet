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

    <form class="connexion" action="/connexion" method="post">
        <label for="email">
            Email: <input type="email" name="email" id="email">
        </label><br>
        <label for="motdepasse">
            Mot de passe: <input type="password" name="motdepasse" id="motdepasse">
        </label><br>
        <label for="isannonceur">
            Poster également des annonces: <input type="checkbox" name="isannonceur" id="isannonceur">
        </label><br>
        <label for="adresse">
            Adresse: <input type="adresse" name="adresse" id="adresse">
        </label><br>
        <div class="go">
            <input type="submit" value="GO!">
        </div>
    </form>
</div>