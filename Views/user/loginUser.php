<?php
$title = "Christmas - Se connecter";
// echo '<pre>';
// var_dump($user);
// var_dump($_GET['id_user']);
// var_dump($_SESSION['user']);
// var_dump($_SESSION['id_account']);
// var_dump($_SESSION['id_user']);
// echo '</pre>';
?>

<h1>Bonjour <?= $user['nickname_user']; ?></h1>
<form class="mx-auto w-80" action="loginUser" method="POST">
    <img src="pictures/avatar.png" alt=" avatar">
    <div class="mb-3 col-4">
        <label for="question_user" class="form-label">Merci d'indiquer une question personnelle.</label>
        <input type="text" name="question_user" value="<?= $user['question_user']; ?>" class="form-control" id="question_user" aria-describedby="usernameHelp" required>
    </div>
    <div class="mb-3 col-4">
        <label for="response_user" class="form-label">Merci d'indiquer la réponse à ta question</label>
        <input type="password" name="response_user" class="form-control" id="response_user" required>
    </div>
    <!-- champs caché pour insérer le role admin par défaut/ici non admnin puisqu'il en existe déjà un via l'ajout profil de home/index-->
    <input type="hidden" name="role_user" value="<?= $user['role_user']; ?>">
    <input type="hidden" name="status_user" value="<?= $user['status_user']; ?>">
    <input type="hidden" name="nickname_user" value="<?= $user['nickname_user']; ?>">

    <?php if (isset($_SESSION['error_message'])) : ?>
        <span class="text-danger"><?= ($_SESSION['error_message']) ?></span>
    <?php endif;
    unset($_SESSION['error_message']);
    ?>
    <button type="submit" name="connexion" class="btn btn-primary">Ajouter ce profil</button>
</form>