<?php
$title = "Fami'list - Profil Administrateur";
// var_dump($accountInfos);
?>
<?php if (isset($_SESSION['id_account'])) { ?>
    <h1>PAGE ADMIN AVEC TOUS LES PROFILS USERS</h1>
    <div id="adminCards">
        <div id="profileCard">
            <?php foreach ($listUsers as $user) { ?>
                <div id="imgAndUl">
                    <div><img src="<?= $user->getPicture_user() ?>" alt="avatar" width=150></div>
                    <ul>
                        <li><?= $user->getNickname_user() ?></li>
                        <li><?= $user->getEmail_user() ?></li>
                    </ul>
                </div>
            <?php } ?>
        </div>
        <div id="accountCard">
            <ul>
                <li><?= $accountInfos['nickname_account'] ?></li>
                <li><?= $accountInfos['email_account'] ?></li>
                <li><button type="button" name="editAccount" class='button-paper' onclick="editAccountForm()">Modifier le compte</button>
                </li>
            </ul>
            <form class="mx-auto w-80 editAccountForm" action="editAccount" method="POST">
                <div class="mb-3 col-6">
                    <label for="nickname_account" class="form-label">Pseudo familial</label>
                    <input value="<?= $accountInfos['nickname_account'] ?>" type="text" name="nickname_account" class="form-control" aria-describedby="usernameHelp">
                    <?php if (isset($error['nickname_account'])) : ?>
                        <div class="text-danger"><?= ($error['nickname_account']) ?></div>
                    <?php endif; ?>
                </div>
                <div class="mb-3 col-6">
                    <label for="email_account" class="form-label">Email familial</label>
                    <input value="<?= $accountInfos['email_account'] ?>" type="email" name="email_account" class="form-control loginPassword" id="email_account" aria-describedby="usernameHelp">
                    <?php if (isset($error['email_account'])) : ?>
                        <div class="text-danger"><?= ($error['email_account']) ?></div>
                    <?php endif; ?>
                </div>
                <div class="mb-3 col-6 mdp">
                    <div class="eye"><i class="fa-regular fa-eye"></i></div>
                    <label for="oldPassword" class="form-label">Mot de passe actuel</label>
                    <input type="password" name="oldPassword" class="form-control loginPassword" id="oldPassword">
                    <?php if (isset($error['password'])) : ?>
                        <div class="text-danger"><?= ($error['password']) ?></div>
                    <?php endif; ?>
                </div>
                <div class="mb-3 col-6 mdp">
                    <div class="eye"><i class="fa-regular fa-eye"></i></div>
                    <label for="newPassword" class="form-label">Nouveau mot de passe</label>
                    <input type="password" name="newPassword" class="form-control loginPassword" id="newPassword">
                </div>
                <div class="mb-3 col-6 mdp">
                    <div class="eye"><i class="fa-regular fa-eye"></i></div>
                    <label for="confirmNewPassword" class="form-label">Confirmer le nouveau mot de passe</label>
                    <input type="password" name="confirmNewPassword" class="form-control loginPassword" id="confirmNewPassword">
                </div>
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']['editAccount']; ?>">
                <?php
                if (isset($_SESSION['error_messageC'])) : ?>
                    <div class="text-danger"><?= ($_SESSION['error_messageC']) ?></div>
                <?php endif;
                unset($_SESSION['error_messageC']);
                ?>
                <button type="submit" name="editAccount" class="button-paper" role="button">Valider</button>
                <button type="button" class='button-paper' onclick="cancelEditAccount()">Annuler la modification</button>
            </form>
        </div>
    </div>
<?php }
