<?php
$title = "Christmas - Profil";
?>


<?php
if (isset($_SESSION['id_account']) && isset($_SESSION['id_user'])) { ?>
    <h1>page profil de <?= $_SESSION['nickname_user'] ?></h1>
    <section id="profilePage">
        <div id="profile">
            <img src="<?= $userProfile['picture_user'] ?>" alt="avatar" width="100">
            <div><?= $userProfile['nickname_user'] ?></div>
            <button name='modifyUser' class='button-paper' id="editBtn" role='button' onclick="editProfileUser()">Modifie ton profil</button>
            <button name="deleteUser" class="button-paper" role="button" onclick="deleteConfirm()">Clique ici pour supprimer ton profil</button>
            <div id="deleteConfirm"></div>
        </div>

        <form class="mx-auto w-80 editUser" id="editForm" action="editUser" method="POST" enctype="multipart/form-data">
            <div class="mb-3 col-6">
                <label for="nickname_user" class="form-label">Modifie ton pseudo</label>
                <input type="text" name="nickname_user" value="<?= $userProfile['nickname_user'] ?>" class="form-control" id="nickname_user" aria-describedby="usernameHelp" required>
            </div>
            <div class="mb-3 col-6">
                <label for="question_user" class="form-label">Modifie ta question personnelle.</label>
                <input type="text" name="question_user" value="<?= $userProfile['question_user'] ?>" class="form-control" id="question_user" aria-describedby="usernameHelp" required>
            </div>
            <div class="mb-3 col-6">
                <label for="response_user" class="form-label">Modifie la réponse à ta question</label>
                <input type="password" name="response_user" value="<?= $userProfile['response_user'] ?>" class="form-control" id="response_user" required>
            </div>
            <div class="mb-3 col-12">
                <label for="formFile" class="form-label">Modifie l'image de profil</label>
                <input name="avatar" class="form-control" type="file" id="formFile">
            </div>
            <?php if (isset($_SESSION['error_message'])) : ?>
                <div class="alert alert-danger">
                    <?= $_SESSION['error_message'] ?>
                </div>
                <?php unset($_SESSION['error_message']); ?>
            <?php endif; ?>

            <button type="submit" name="editUser" class='button-paper' onclick="ConfirmEditProfileUser()">Modifier le profil</button>
        </form>
    </section>

<?php } else if (!isset($_SESSION['id_user'])) {
    header('Location: home');
} else {
    header('Location: loginAccount');
    exit();
} ?>