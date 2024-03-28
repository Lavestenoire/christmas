<?php
$title = "Christmas - LogIn";
?>

<section id="connexionInscription">
    <div id="loginAccount">
        <h2>Connexion</h2>
        <form class="mx-auto w-80" action="loginAccount" method="POST">
            <div class="mb-3 col-4">
                <label for="nicknameLogin" class="form-label">Pseudo familial</label>
                <input type="text" name="nicknameLogin" class="form-control" id="nicknameLogin" aria-describedby="usernameHelp" required>
            </div>
            <div class="mb-3 col-4">
                <label for="loginPassword" class="form-label">Mot de passe</label>
                <input type="password" name="loginPassword" class="form-control" id="loginPassword" required>
            </div>
            <input type="hidden" name="token" value='<?= isset($_SESSION['token']) ? $_SESSION['token'] : ''; ?>'>
            <?php
            if (isset($_SESSION['error_message'])) : ?>
                <div class="text-danger"><?= htmlspecialchars($_SESSION['error_message']) ?></div>
            <?php endif;
            unset($_SESSION['error_message']);
            ?>

            <button type="submit" name="connectionAccount" class="btn btn-primary">Connexion</button>
        </form>
    </div>


    <div id="createAccount">
        <h2>Inscription</h2>
        <form class="mx-auto w-80" action="createAccount" method="POST">
            <div class="mb-3 col-4">
                <label for="nickname_account" class="form-label">Pseudo familial</label>
                <input type="text" name="nickname_account" class="form-control" id="nickname_account" aria-describedby="usernameHelp" required>
                <?php if (isset($error['nickname_account'])) : ?>
                    <div class="text-danger"><?= htmlspecialchars($error['nickname_account']) ?></div>
                <?php endif; ?>
            </div>
            <div class="mb-3 col-4">
                <label for="email_account" class="form-label">Email familial</label>
                <input type="email" name="email_account" class="form-control" id="email_account" aria-describedby="usernameHelp" required>
                <?php if (isset($error['email_account'])) : ?>
                    <div class="text-danger"><?= htmlspecialchars($error['email_account']) ?></div>
                <?php endif; ?>
            </div>
            <div class="mb-3 col-4">
                <label for="password_account" class="form-label">Mot de passe</label>
                <input type="password" name="password" class="form-control" id="password" required>
                <?php if (isset($error['password'])) : ?>
                    <div class="text-danger"><?= htmlspecialchars($error['password']) ?></div>
                <?php endif; ?>
            </div>
            <div class="mb-3 col-4">
                <label for="password_account" class="form-label">Vérifier le mot de passe</label>
                <input type="password" name="confirmPassword" class="form-control" id="confirmPassword" required>
                <?php if (isset($error['confirm_password'])) : ?>
                    <div class="text-danger"><?= htmlspecialchars($error['confirm_password']) ?></div>
                <?php endif; ?>
            </div>
            <input type="hidden" name="token" value='<?= isset($_SESSION['token']) ? $_SESSION['token'] : ''; ?>'>
            <button type="submit" name="addAccount" class="btn btn-primary">Valider</button>
        </form>
    </div>
</section>