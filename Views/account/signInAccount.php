<?php
$title = "Christmas - LogIn";
?>

<section id="connexionInscription">
    <div id="signInAccount">
        <h2>Connexion</h2>
        <form class="mx-auto w-80" action="signInAccount" method="POST">
            <div class="mb-3 col-5">
                <label for="nickname_account" class="form-label">Pseudo familial</label>
                <input type="text" name="nickname_account" class="form-control" aria-describedby="usernameHelp" required>
            </div>
            <div class="mb-3 col-5 mdp">
                <div class="eye"><i class="fa-regular fa-eye"></i></div>
                <label for="loginPassword" class="form-label">Mot de passe</label>
                <input type="password" name="loginPassword" class="form-control loginPassword" required>
            </div>
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']['login_account']; ?>">

            <?php

            var_dump($_SESSION['csrf_token']['create_account']);

            if (isset($_SESSION['error_message'])) : ?>
                <span class="text-danger"><?= ($_SESSION['error_message']) ?></span>
            <?php endif;
            unset($_SESSION['error_message']);
            ?>
            <button type="submit" name="connectionAccount" class="button-paper" role="button">Connexion</button>
        </form>
    </div>


    <div id="createAccount">
        <h2>Inscription</h2>
        <form class="mx-auto w-80" action="createAccount" method="POST">
            <div class="mb-3 col-5">
                <label for="nickname_account" class="form-label">Pseudo familial</label>
                <input type="text" name="nickname_account" class="form-control" aria-describedby="usernameHelp" required>
                <?php if (isset($error['nickname_account'])) : ?>
                    <div class="text-danger"><?= ($error['nickname_account']) ?></div>
                <?php endif; ?>
            </div>
            <div class="mb-3 col-5">
                <label for="email_account" class="form-label">Email familial</label>
                <input type="email" name="email_account" class="form-control" id="email_account" aria-describedby="usernameHelp" required>
                <?php if (isset($error['email_account'])) : ?>
                    <div class="text-danger"><?= ($error['email_account']) ?></div>
                <?php endif; ?>
            </div>
            <div class="mb-3 col-5 mdp">
                <div class="eye"><i class="fa-regular fa-eye"></i></div>
                <label for="password_account" class="form-label">Mot de passe</label>
                <input type="password" name="password" class="form-control loginPassword" id="password" required>
                <?php if (isset($error['password'])) : ?>
                    <div class="text-danger"><?= ($error['password']) ?></div>
                <?php endif; ?>
            </div>
            <div class="mb-3 col-5 mdp">
                <div class="eye"><i class="fa-regular fa-eye"></i></div>
                <label for="password_account" class="form-label">Vérifier le mot de passe</label>
                <input type="password" name="confirmPassword" class="form-control loginPassword" id="confirmPassword" required>
            </div>
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']['create_account']; ?>">
            <?php
            if (isset($_SESSION['error_messageC'])) : ?>
                <div class="text-danger"><?= ($_SESSION['error_messageC']) ?></div>
            <?php endif;
            unset($_SESSION['error_messageC']);
            var_dump($_SESSION['csrf_token']['login_account']);
            ?>
            <button type="submit" name="createAccount" class="button-paper" role="button">Valider</button>

        </form>
    </div>
</section>