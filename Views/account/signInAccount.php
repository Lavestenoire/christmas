<?php
$title = "Christmas - SignIn";
?>

<section id="connexionInscription">
    <div id="signInAccount">
        <h2>Connexion</h2>
        <form class="mx-auto w-80" action="signInAccount" method="POST">
            <div class="mb-3 col-lg-10 col-10">
                <label for="nickname_account" class="form-label">Pseudo</label>
                <input type="text" name="nickname_account" class="form-control" aria-describedby="usernameHelp" required>
            </div>
            <div class="mb-3 col-lg-10 col-10 mdp">
                <div class="eye"><i class="fa-regular fa-eye"></i></div>
                <label for="loginPassword" class="form-label">Mot de passe</label>
                <input type="password" name="loginPassword" class="form-control loginPassword" required>
            </div>

            <?php
            if (isset($_SESSION['error_message'])) : ?>
                <span class="text-danger"><?= ($_SESSION['error_message']) ?></span>
            <?php endif;
            unset($_SESSION['error_message']);
            ?>
            <button type="submit" name="connectionAccount" class="button-paper" role="button">Connexion</button>
        </form>
    </div>
</section>