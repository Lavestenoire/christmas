<?php
$title = "Fami'list - SignUpAccount";
?>
<div id="signUpForms">
    <section>
        <h1 id="titreAccueilConnexion">Pour créer un compte et inviter des membres, passez par là</h1>
        <form class=" mx-auto w-80" action=" " method="POST">
            <div class="mb-3 col-5">
                <label for="nickname_account" class="form-label">Pseudo</label>
                <input type="text" name="nickname_account" class="form-control" aria-describedby="usernameHelp" required>
                <?php if (isset($error['nickname_account'])) : ?>
                    <div class="text-danger"><?= ($error['nickname_account']) ?></div>
                <?php endif; ?>
            </div>
            <div class="mb-3 col-5">
                <label for="email_account" class="form-label">Email</label>
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
            <div class="mb-3 col-5">
                <label for="tag_account" class="form-label">Créer un code famille</label>
                <input type="text" name="tag_account" class="form-control" aria-describedby="usernameHelp" required>
                <?php if (isset($error['tag_account'])) : ?>
                    <div class="text-danger"><?= ($error['tag_account']) ?></div>
                <?php endif; ?>
            </div>
            <?php
            if (isset($_SESSION['error_message'])) : ?>
                <div class="text-danger"><?= ($_SESSION['error_message']) ?></div>
            <?php endif;
            unset($_SESSION['error_message']);
            // var_dump($_SESSION['csrf_token']['loginNoTags_account']);
            ?>
            <button type="submit" name="signUpAccountAndTag" class="button-paper lutinBtn" role="button">Créer le compte</button>

        </form>
    </section>
</div>