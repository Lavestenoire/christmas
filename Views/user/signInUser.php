<?php
$title = "Fami'list - SignIn";
?>

<section id="connexionInscription">
    <div id="signInUser">
        <h1 id="titreRouge">Lutin, connecte toi</h1>
        <h2 class="sousTitreVert">En tant que lutin, tu pourras créer ta liste de cadeaux et choisir dans les autres listes les cadeaux à offrir.</h2>
        <div class="accountForm">
            <form class="mx-auto w-80" action="signInUser" method="POST">
                <?php
                if (isset($_SESSION['error_message'])) : ?>
                    <span class="text-danger"><?= ($_SESSION['error_message']) ?></span>
                <?php endif;
                unset($_SESSION['error_message']); ?>
                <div class="mb-3 col-lg-10 col-10">
                    <label for="nickname_user" class="form-label">Pseudo</label>
                    <input type="text" name="nickname_user" class="form-control" aria-describedby="usernameHelp" required>
                </div>
                <div class="mb-3 col-lg-10 col-10 mdp">
                    <div class="eye"><i class="fa-regular fa-eye"></i></div>
                    <label for="loginPasswordUser" class="form-label">Mot de passe</label>
                    <input type="password" name="loginPasswordUser" class="form-control loginPassword" required>
                </div>
                <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">

                <button type="submit" name="connectionUser" class="button-paper lutinBtn" role="button">Connexion</button>
            </form>
            <div><img src="pictures/lutin.svg" alt="dessinLutin"></div>
        </div>
    </div>
</section>