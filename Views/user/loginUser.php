<?php
$title = "Christmas - Se connecter";
// var_dump($_SESSION);
// die;
// echo '<pre>';
// echo '</pre>';
?>
<?php if (isset($user)) { ?>

    <h1>Bonjour <?= $user['nickname_user']; ?></h1>
    <form class="mx-auto w-80 loginUser" action="loginUser" method="POST">
        <img src="<?= $user['picture_user']; ?>" alt="avatar">
        <div class="mb-3 col-lg-4 col-6">
            <label for="email_user" class="form-label">Question</label>
            <select name="email_user" id="email_user" class="form-select" aria-label="Default select example">
                <option value="">Choisi ta question:</option>
                <?php foreach ($questions as $question) { ?>
                    <option value="<?= $question['email_user'] ?>"><?= $question['email_user'] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3 col-lg-4 col-6 mdp">
            <div class="eye"><i class="fa-regular fa-eye"></i></div>
            <label for="password_user" class="form-label">Réponse</label>
            <input type="password" name="password_user" class="form-control loginPassword" id="password_user" required>
        </div>
        <!-- champs caché pour insérer le role admin par défaut/ici non admnin puisqu'il en existe déjà un via l'ajout profil de home/index-->
        <input type="hidden" name="id_user" value="<?= $user['id_user']; ?>">
        <input type="hidden" name="role_user" value="<?= $user['role_user']; ?>">
        <input type="hidden" name="status_user" value="<?= $user['status_user']; ?>">
        <input type="hidden" name="nickname_user" value="<?= $user['nickname_user']; ?>">

        <?php if (isset($_SESSION['error_message'])) : ?>
            <span class="text-danger"><?= ($_SESSION['error_message']) ?></span>
        <?php endif;
        unset($_SESSION['error_message']);
        ?>
        <button type="submit" name="connexion" class="button-paper" role="button">Me connecter</button>
    </form>
<?php } else {
    // echo '<pre>';
    // var_dump($user);
    // echo '</pre>';
    // die;
    header("Location: pageCreateUser");
}
