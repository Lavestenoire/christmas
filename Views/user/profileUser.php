<?php
$title = "Christmas - Profil";
?>


<?php
if (isset($_SESSION['id_account']) && isset($_SESSION['id_user'])) { ?>
    <h1>page profil de <?= $_SESSION['nickname_user'] ?></h1>
    <img src="<?= $userProfile['picture_user'] ?>" alt="avatar">
    <div><?= $userProfile['nickname_user'] ?></div>
    <button name='modifyUser' class='button-paper' role='button'>Modifie ton profil</button>
    <button name="deleteUser" class="button-paper" role="button" onclick="deleteConfirm()">Clique ici pour supprimer ton profil</button>

    <div id="deleteConfirm"></div>

    <form class="mx-auto w-80" action="#" method="POST" enctype="multipart/form-data">
        <div class="mb-3 col-4">
            <label for="nickname_user" class="form-label">Choisi un pseudo</label>
            <input type="text" name="nickname_user" class="form-control" id="nickname_user" aria-describedby="usernameHelp" required>
        </div>
        <div class="mb-3 col-4">
            <label for="question_user" class="form-label">Merci d'indiquer une question personnelle.</label>
            <input type="text" name="question_user" class="form-control" id="question_user" aria-describedby="usernameHelp" required>
        </div>
        <div class="mb-3 col-4">
            <label for="response_user" class="form-label">Merci d'indiquer la réponse à ta question</label>
            <input type="password" name="response_user" class="form-control" id="response_user" required>
        </div>
        <div class="mb-3 col-4">
            <label for="formFile" class="form-label">Changer l'image de profil</label>
            <input name="avatar" class="form-control" type="file" id="formFile">
        </div>

        <button type="submit" name="editUser" class='button-paper'>Modifier le profil</button>
    </form>

<?php } else if (!isset($_SESSION['id_user'])) {
    header('Location: home');
} else {
    header('Location: loginAccount');
    exit();
} ?>