<?php
$title = "Christmas - Accueil";
// var_dump($_SESSION['id_account']);
// var_dump($_SESSION['id_user']);
// var_dump($_SESSION['nickname_account']);
// var_dump($_SESSION['nickname_user']);
// var_dump($_SESSION['role_user']);
// var_dump($_SESSION['status_user']);
/* Le $title est situé au niveau du title de la base */
?>

<?php
if (isset($_SESSION['id_account'])) { ?>
    <div>
        <p id="countDown"></p>
    </div>
    <!-- // s'il n'y a pas de profil créé -->
    <?php if (isset($showForm) && $showForm) {
    ?>
        <!-- ##########################################################################
        Si 0 users existent pour cet id_account > affichage formulaire pour en créer un
        ############################################################################### -->
        <p>Merci de créer le premier profil de ce compte, qui vous permettra de modifier et supprimer votre compte familial, et d'avoir accès aux profils des membres de votre famille.</p>

        <form class="mx-auto w-80" action="createUser" method="POST">
            <img src="pictures/avatar.png" alt=" avatar">
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
            <!-- champs caché pour insérer le rôle admin (1) par défaut -->
            <input type="hidden" name="role_user" value="1">
            <input type="hidden" name="status_user" value="0">
            <button type="submit" name="addAUser" class="button-paper" role="button">Ajouter ce profil</button>

        </form>
        <?php }
    // si au moins un profil créé
    else if (isset($showProfiles) && $showProfiles) {
        // si un profil est connecté
        if (isset($_SESSION['id_user'])) { ?>
            <h1>Bienvenue à toi, petit lutin <?= $_SESSION['nickname_user'] ?></h1>
            <div id="logoutUserBtn"><a href="logoutUser"><button type="submit" name="addAUser" class="button-paper" role="button">Déco User</button></a></div>
        <?php }
        //sinon affichage des profils existant 
        else { ?>
            <h3>Connecte toi afin de gérer tes listes</h3>
            <?php foreach ($users as $user) { ?>
                <div class="profile">
                    <a href="/christmas/public/pageLoginUser?id_user=<?= $user->getId_user() ?>">
                        <div class="profile-image"></div>
                        <div class="profile-name"><?= $user->getNickname_user() ?></div>
                    </a>
                </div>
            <?php } ?>
            <a href="pageCreateUser"><button class="button-paper" role="button">Ajouter un profil</button>
            </a>
    <?php }
    }
} else { ?>
    <h1>Accueil - Il fait la connexion d'un parent pour accéder ou créer ton profil</h1>
    <button type="button" name="addGift" class="button-paper" role="button"><a href="/christmas/public/loginAccount">Connexion</a></button>

<?php } ?>