<?php
$title = "Christmas - Profil";
// var_dump($_SESSION['role_user']);
?>

<?php
if (isset($_SESSION['id_account']) && isset($_SESSION['id_user'])) { ?>
    <div id="logoutUserBtn"><button type="button" name="logOutUser" role="button"><a href="logoutUser"><img src="pictures/BoutonDecoUser.svg" alt="bouton" width=150></a></button></div>
    <?php if (isset($_SESSION['role_user']) && $_SESSION['role_user'] === 1) { ?>
        <div>
            <button type="button" name="allProfileAccess" class="button-paper" role="button"><a href="adminPage">Accéder à tous les profils</a></button>
        </div>
    <?php } ?>

    <section id="profilePage">
        <div id="profile">
            <img src="<?= $userProfile['picture_user'] ?>" alt="avatar">
            <div><?= $userProfile['nickname_user'] ?></div>
            <div id="btnProfil">
                <button name='modifyUser' class='button-paper' id="editBtn" role='button' onclick="editProfileUser()">Modifie ton profil</button>
                <button name="deleteUser" class="button-paper" role="button" onclick="deleteConfirm()">Supprimer ton profil</button>
                <div id="deleteConfirm"></div>
            </div>
        </div>

        <form class="mx-auto w-80 editUser" id="editForm" action="editUser" method="POST" enctype="multipart/form-data">
            <div class="mb-3 col-7">
                <label for="nickname_user" class="form-label">Modifie ton pseudo</label>
                <input type="text" name="nickname_user" value="<?= $userProfile['nickname_user'] ?>" class="form-control" id="nickname_user" aria-describedby="usernameHelp" required>
            </div>
            <div class="mb-3 col-7">
                <label for="question_user" class="form-label">Modifie ta question personnelle.</label>
                <input type="text" name="question_user" value="<?= $userProfile['question_user'] ?>" class="form-control" id="question_user" aria-describedby="usernameHelp" required>
            </div>
            <div class="mb-3 col-7 mdp">
                <div class="eye"><i class="fa-regular fa-eye"></i></div>
                <label for="response_user" class="form-label">Modifie la réponse à ta question</label>
                <input type="password" name="response_user" value="<?= $userProfile['response_user'] ?>" class="form-control loginPassword" id="response_user" required>
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

            <button type="submit" name="editUser" class='button-paper' onclick="confirmEditProfileUser()">Modifier le profil</button>
            <button type="button" class='button-paper' onclick="cancelEditProfile()">Annuler la modification</button>
        </form>
    </section>

<?php } else if (!isset($_SESSION['id_user'])) {
    header('Location: home');
} else {
    header('Location: loginAccount');
    exit();
} ?>