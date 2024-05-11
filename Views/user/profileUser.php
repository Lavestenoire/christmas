<?php
$title = "Fami'list - Profil";
// var_dump($_SESSION['password_user']);
?>
<h1 id="titreRouge">Tu peux modifier ou supprimer ton profil</h1>

<?php
if (isset($_SESSION['id_user'])) { ?>
    <?php if (isset($_SESSION['role_user']) && $_SESSION['role_user'] === 1) { ?>
        <div>
            <a href="adminPage"><button type="button" name="allProfileAccess" class="button-paper" role="button">Accéder à tous les profils</button></a>
        </div>
    <?php } ?>

    <section id="profilePage">
        <div id="profile">
            <img src="<?= $userProfile['picture_user'] ?>" alt="avatar">
            <div><?= $userProfile['nickname_user'] ?></div>
            <div id="btnProfil">
                <button name='modifyUser' class='button-paper lutinBtn' id="editBtn" role='button' onclick="editProfileUser()">Modifie ton profil</button>
                <button name="deleteUser" class="button-paper lutinBtn" role="button" onclick="deleteConfirmUser()">Supprimer ton profil</button>
                <div id="deleteConfirmUser"></div>
            </div>
        </div>

        <form class="mx-auto w-80 editUser" id="editForm" action="editUser" method="POST" enctype="multipart/form-data">
            <div class="mb-3 col-7">
                <label for="nickname_user" class="form-label">Modifie ton pseudo</label>
                <input type="text" name="nickname_user" value="<?= $userProfile['nickname_user'] ?>" class="form-control" id="nickname_user" aria-describedby="usernameHelp">
            </div>
            <div class="mb-3 col-7">
                <label for="email_user" class="form-label">Modifie ton email.</label>
                <input type="text" name="email_user" value="<?= $userProfile['email_user'] ?>" class="form-control" id="email_user" aria-describedby="usernameHelp" required>
            </div>
            <div class="mb-3 col-7 mdp">
                <div class="eye"><i class="fa-regular fa-eye"></i></div>
                <label for="password_user" class="form-label">Indique ton mot de passe actuel</label>
                <input type="password" name="current_password_user" class="form-control loginPassword" id="current_password_user">
            </div>
            <div class="mb-3 col-7 mdp">
                <div class="eye"><i class="fa-regular fa-eye"></i></div>
                <label for="password_user" class="form-label">Indique ton nouveau mot de passe</label>
                <input type="password" name="new_password_user" class="form-control loginPassword" id="new_password_user">
            </div>
            <div class="mb-3 col-7 mdp">
                <div class="eye"><i class="fa-regular fa-eye"></i></div>
                <label for="password_user" class="form-label">Valide ton nouveau mot de passe</label>
                <input type="password" name="confirm_new_password_user" class="form-control loginPassword" id="confirm_new_password_user">
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

            <button type="submit" name="editUser" class='button-paper lutinBtn' onclick="confirmEditProfileUser()">Modifier le profil</button>
            <button type="button" class='button-paper lutinBtn' onclick="cancelEditProfileUser()">Annuler la modification</button>
        </form>
        <div><img src="pictures/lutin.svg" alt="image lutin"></div>

    </section>

<?php } else if (!isset($_SESSION['id_user'])) {
    header('Location: Home');
} else {
    header('Location: signInUser');
    exit();
} ?>