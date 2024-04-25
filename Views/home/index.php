<?php
$title = "Christmas - Accueil";
// var_dump($_SESSION['csrf_token']);
?>

<?php
if (isset($_SESSION['id_account'])) { ?>
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
                <label for="email_user" class="form-label">Merci d'indiquer une question personnelle.</label>
                <input type="text" name="email_user" class="form-control" id="email_user" aria-describedby="usernameHelp" required>
            </div>
            <div class="mb-3 col-4 mdp">
                <div class="eye"><i class="fa-regular fa-eye"></i></div>
                <label for="password_user" class="form-label">Merci d'indiquer la réponse à ta question</label>
                <input type="password" name="password_user" class="form-control loginPassword" id="password_user" required>
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
            <div id="logoutUserBtn"><button type="submit" name="logOutAUser" role="button"><a href="logoutUser"><img src="pictures/BoutonDecoUser.svg" alt="bouton" width=150></a></button></div>
            <h1>Bienvenue à toi, petit lutin <?= $_SESSION['nickname_user'] ?></h1>
            <p>Bienvenue dans le quartier général du Père Noël pour les listes et les cadeaux parfaits ! 🎅🎁

                Êtes-vous prêt à transformer le pôle Nord en une zone de planification festive ? 🎄 Imaginez un endroit où les lutins développeurs se joignent à nous pour créer la magie de Noël en ligne !

                Que vous soyez un parent en quête de l'ultime cadeau-surprise ou un enfant déterminé à garantir que votre lettre au Père Noël ne se perde pas dans la neige, vous êtes au bon endroit.

                Ici, vous pouvez créer, partager et collaborer sur vos listes de souhaits les plus extravagantes. Pensez-y comme un tableau de bord de rêve pour Noël, où chaque clic rapproche votre moment de joie sous l'arbre.

                Préparez-vous à être plus efficace que jamais dans votre quête du cadeau parfait. Avec notre aide, vous aurez les cadeaux les plus épiques depuis les rennes volants du Père Noël.

                Alors, qu'attendez-vous ? Plongez dans le joyeux chaos de la saison des fêtes avec nous ! 🎉</p>
        <?php }
        //sinon affichage des profils existant 
        else { ?>
            <h3>Connecte toi afin de gérer tes listes</h3>
            <div id="profileCards">
                <?php foreach ($users as $user) { ?>
                    <div class="profile">
                        <a href="/christmas/public/pageLoginUser?id_user=<?= $user->getId_user() ?>">
                            <div class="profile-image"><img src="<?= $user->getPicture_user() ?>" alt="avatar"></div>
                            <div class="profile-name"><?= $user->getNickname_user() ?></div>
                        </a>
                    </div>
                <?php } ?>
            </div>
            <a href="pageCreateUser"><button class="button-paper" role="button">Ajouter un profil</button>
            </a>
    <?php }
    }
} else { ?>
    <h1>Bienvenue sur ce site de partages de listes en famille</h1>

    <button type="button" name="addGift" class="button-paper" role="button"><a href="/christmas/public/signInAccount">Identifiez-vous</a></button>
    <p>Si vous n'avez pas encore de compte, <a href="signUp">cliquez ici</a></p>

<?php } ?>