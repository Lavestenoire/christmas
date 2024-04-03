<?php
$title = "Christmas - Créer un profil";
?>

<h1>Créer un profil pour la famille <?= $_SESSION['nickname_account']; ?></h1>
<form class="mx-auto w-80" action="addUser" method="POST">
    <img src="pictures/avatar.png" alt=" avatar">
    <div class="mb-3 col-4">
        <label for="nickname_user" class="form-label">Choisi un pseudo</label>
        <input type="text" name="nickname_user" class="form-control" id="nickname_user" aria-describedby="usernameHelp" required>
    </div>
    <div class="mb-3 col-4">
        <label for="question" class="form-label">Merci d'indiquer une question personnelle.</label>
        <input type="text" name="question" class="form-control" id="question" aria-describedby="usernameHelp" required>
    </div>
    <div class="mb-3 col-4">
        <label for="response" class="form-label">Merci d'indiquer la réponse à ta question</label>
        <input type="password" name="response" class="form-control" id="response" required>
    </div>
    <!-- champs caché pour insérer le role admin par défaut/ici non admnin puisqu'il en existe déjà un via l'ajout profil de home/index-->
    <input type="hidden" name="role_user" value="0">
    <input type="hidden" name="status_user" value="0">

    <?php if (isset($_SESSION['error_message'])) : ?>
        <span class="text-danger"><?= ($_SESSION['error_message']) ?></span>
    <?php endif;
    unset($_SESSION['error_message']);
    ?>
    <button type="submit" name="addAUser" class="btn btn-primary">Ajouter ce profil</button>
</form>