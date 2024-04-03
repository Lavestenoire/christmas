<?php
$title = "Christmas - Accueil";
var_dump($_SESSION['id_Account']);

/* Le $title est situé au niveau du title de la base */
?>

<?php
if (isset($_SESSION['id_Account'])) {
    if ($showForm) {
?>
        <!-- Si role_user == admin non présent: -->
        <h2>Bienvenue à la famille <?= $_SESSION['nickname_account']; ?></h2>
        <?php var_dump($_SESSION['email_account']);
        ?>
        <p>Merci de créer le premier profil de ce compte, qui vous permettra de modifier et supprimer votre compte familial, et d'avoir accès aux profils des membres de votre famille.</p>

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
            <!-- champs caché pour insérer le statut admin (1) par défaut -->
            <input type="hidden" name="role_user" value="1">
            <input type="hidden" name="status_user" value="0">
            <button type="submit" name="addAUser" class="btn btn-primary">Ajouter ce profil</button>
        </form>
    <?php } else if ($showProfiles) { ?>
        <h2>Bienvenue à la famille <?= $_SESSION['nickname_account']; ?></h2>

        <?php foreach ($users as $user) { ?>
            <div class="profile">
                <a href="#">
                    <div class="profile-image"></div>
                    <div class="profile-name"><?= $user->getNickname_user() ?></div>
                </a>
            </div>
        <?php  } ?>
        <button><a href="addUserPage">Ajouter un profil</a></button>
    <?php }
} else { ?>
    <h1>Accueil</h1>
<?php } ?>