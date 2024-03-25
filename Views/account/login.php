<?php
$title = "Christmas - LogIn";
?>

<h1>Connexion/Inscription</h1>

<form class="mx-auto w-50" action="createAccount" method="POST">
    <div class="mb-3 col-4">
        <label for="nickname_account" class="form-label">Pseudo familial</label>
        <input type="text" name="nickname_account" class="form-control" id="nickname_account" aria-describedby="usernameHelp" required>
    </div>
    <div class="mb-3 col-4">
        <label for="email_account" class="form-label">Email familial</label>
        <input type="email" name="email_account" class="form-control" id="email_account" aria-describedby="usernameHelp" required>
    </div>
    <div class="mb-3 col-4">
        <label for="password_account" class="form-label">Mot de passe</label>
        <input type="password" name="password" class="form-control" id="password" required>
    </div>
    <div class="mb-3 col-4">
        <label for="password_account" class="form-label">Vérifier le mot de passe</label>
        <input type="password" name="confirmPassword" class="form-control" id="confirmPassword" required>
    </div>
    <button type="submit" name="addAccount" class="btn btn-primary">Valider</button>
</form>