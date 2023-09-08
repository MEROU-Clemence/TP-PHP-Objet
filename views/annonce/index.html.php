<?php

use Core\Session\Session;

?>

<div class="deconnexion">
    <?php if ($auth::isAuth()) : ?>
        <p class="profil-utilisateur">Profil utilisateur de
            <?= $email = Session::get(Session::USER)->email; ?>
        </p>
        <div class="deconnect">
            <a class="deconnexion" href="/logout">Déconnexion</a>
        </div>
    <?php else : ?>
        <p class="profil-utilisateur">Mon profil :</p>
        <div class="buttons deconnect">
            <a class="deconnexion" href="/connexion">Connexion</a>
            <a class="deconnexion" href="/inscription">Inscription</a>
        </div>
    <?php endif; ?>
</div>

<h1>Index je suis</h1>

<p>Je suis la suite du header</p>