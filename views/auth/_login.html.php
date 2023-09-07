<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Airbnb connect</title>
    <!-- importer bootstrap icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- importer cdn bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- on link notre CSS -->
    <link rel="stylesheet" href="/style.css">
</head>

<body>
    <div class="general-connexion">
        <h1 class="titre-connexion">Connexion</h1>
        <?php if ($auth::isAuth()) $auth::redirect('/'); ?>
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

        <form class="connexion" action="/login" method="post">
            <label for="email">
                Email: <input type="email" name="email" id="email">
            </label><br>
            <label for="password">
                Mot de passe: <input type="password" name="password" id="password">
            </label><br>
            <div class="go">
                <input type="submit" value="GO!">
            </div>
        </form>
    </div>
</body>

</html>