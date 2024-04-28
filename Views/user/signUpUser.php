<?php
$title = "Fami'list - SignUpUser";
// var_dump($_SESSION);
?>
<div id="signUpForms">
    <section>
        <h1>Si vous avez un code famille mais pas de compte, passez par ici</h1>
        <form class="mx-auto w-80" action="signUpUser" method="POST">
            <div class="mb-3 col-5">
                <label for="nickname_user" class="form-label">Pseudo</label>
                <input type="text" name="nickname_user" class="form-control" aria-describedby="usernameHelp" required>
                <?php if (isset($_SESSION['error-message']['nickname_user'])) : ?>
                    <div class="text-danger"><?= ($_SESSION['error-message']['nickname_user']) ?></div>
                <?php endif; ?>
            </div>
            <div class="mb-3 col-5">
                <label for="email_user" class="form-label">Email</label>
                <input type="email" name="email_user" class="form-control" id="email_user" aria-describedby="usernameHelp" required>
                <?php if (isset($_SESSION['error-message']['email_user'])) : ?>
                    <div class="text-danger"><?= ($_SESSION['error-message']['email_user']) ?></div>
                <?php endif; ?>
            </div>
            <div class="mb-3 col-5 mdp">
                <div class="eye"><i class="fa-regular fa-eye"></i></div>
                <label for="password_user" class="form-label">Mot de passe</label>
                <input type="password" name="password_user" class="form-control loginPassword" id="password_user" required>
                <?php if (isset($_SESSION['error-message']['password_user'])) : ?>
                    <div class="text-danger"><?= ($_SESSION['error-message']['password_user']) ?></div>
                <?php endif; ?>
            </div>
            <div class="mb-3 col-5 mdp">
                <div class="eye"><i class="fa-regular fa-eye"></i></div>
                <label for="confirmPassword_user" class="form-label">Vérifier le mot de passe</label>
                <input type="password" name="confirmPassword_user" class="form-control loginPassword" id="confirmPassword_user" required>
                <?php if (isset($_SESSION['error-message']['samePassword_user'])) : ?>
                    <div class="text-danger"><?= ($_SESSION['error-message']['samePassword_user']) ?></div>
                <?php endif; ?>
            </div>
            <div class="mb-3 col-5">
                <label for="tag_user" class="form-label">Indiquez votre code famille</label>
                <input type="text" name="tag_user" class="form-control" aria-describedby="usernameHelp" required>
                <?php if (isset($_SESSION['error-message']['tag_user'])) : ?>
                    <div class="text-danger"><?= ($_SESSION['error-message']['tag_user']) ?></div>
                <?php endif; ?>
            </div>
            <?php
            if (isset($_SESSION['error_message'])) : ?>
                <div class="text-danger"><?= ($_SESSION['error_message']) ?></div>
            <?php endif;
            unset($_SESSION['error_message']);
            ?>
            <button type="submit" name="signUpAccountWithTag" class="button-paper lutinBtn" role="button">Créer le compte</button>
        </form>

    </section>
</div>