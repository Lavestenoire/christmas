<?php
$title = "Fami'list - Profil";
// var_dump($userInfos);
?>
<div id="userprofileAccount">
    <?php
    foreach ($userInfos as $info) { ?>
        <div>
            <div><img src="<?= $info['picture_user'] ?>" alt="avatar" width=150></div>
            <div><?= $info['nickname_user'] ?></div>
        </div>
    <?php } ?>
</div>
<?php


if (isset($_SESSION['id_account'])) { ?>

    <section id="profilePage">
        <div id="profile">
            <div><?= $accountInfos['nickname_account'] ?></div>
            <div id="btnProfil">
                <button name='modifyAccount' class='button-paper lutinBtn' id="editBtn" role='button' onclick="editProfileAccount()">Modifie ton profil</button>
                <button name="deleteAccount" class="button-paper lutinBtn" role="button" onclick="deleteConfirmAccount()">Supprimer ton profil</button>
                <div id="deleteConfirmAccount"></div>
            </div>
        </div>

        <form class="mx-auto w-80 editAccount" id="editForm" action="editAccount" method="POST" enctype="multipart/form-data">
            <div class="mb-3 col-7">
                <label for="nickname_account" class="form-label">Modifie ton pseudo</label>
                <input type="text" name="nickname_account" value="<?= $accountInfos['nickname_account'] ?>" class="form-control" id="nickname_account" aria-describedby="usernameHelp" required>
            </div>
            <div class="mb-3 col-7">
                <label for="email_account" class="form-label">Modifie ton email.</label>
                <input type="text" name="email_account" value="<?= $accountInfos['email_account'] ?>" class="form-control" id="email_account" aria-describedby="usernameHelp" required>
            </div>
            <div class="mb-3 col-7 mdp">
                <div class="eye"><i class="fa-regular fa-eye"></i></div>
                <label for="current_password_account" class="form-label">Indique ton mot de passe actuel</label>
                <input type="password" name="current_password_account" class="form-control loginPassword" id="current_password_account">
            </div>
            <div class="mb-3 col-7 mdp">
                <div class="eye"><i class="fa-regular fa-eye"></i></div>
                <label for="new_password_account" class="form-label">Indique ton nouveau mot de passe</label>
                <input type="password" name="new_password_account" class="form-control loginPassword" id="new_password_account">
            </div>
            <div class="mb-3 col-7 mdp">
                <div class="eye"><i class="fa-regular fa-eye"></i></div>
                <label for="confirm_new_password_account" class="form-label">Valide ton nouveau mot de passe</label>
                <input type="password" name="confirm_new_password_account" class="form-control loginPassword" id="confirm_new_password_account">
            </div>
            <?php if (isset($_SESSION['error_message'])) : ?>
                <div class="alert alert-danger">
                    <?= $_SESSION['error_message'] ?>
                </div>
                <?php unset($_SESSION['error_message']); ?>
            <?php endif; ?>

            <button type="submit" name="editAccount" class='button-paper lutinBtn' onclick="confirmEditProfileAccount()">Modifier le profil</button>
            <button type="button" class='button-paper lutinBtn' onclick="cancelEditProfileAccount()">Annuler la modification</button>
        </form>
        <div><img src="pictures/lutinAdmin.svg" alt="image lutin admin"></div>

    </section>

<?php } else if (!isset($_SESSION['id_account'])) {
    header('Location: home');
} else {
    header('Location: signInAccount');
    exit();
} ?>