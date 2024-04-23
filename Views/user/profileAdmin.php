<?php
$title = "Christmas - Profil Administrateur";
// var_dump($accountInfos);
?>

<h1>PAGE ADMIN AVEC TOUS LES PROFILS USERS</h1>
<div id="adminCards">
    <?php foreach ($listUsers as $user) { ?>
        <div id="profileCard">
            <div><img src="<?= $user->getPicture_user() ?>" alt="avatar" width=150></div>
            <ul>
                <li><?= $user->getNickname_user() ?></li>
                <li><?= $user->getQuestion_user() ?></li>
            </ul>
        </div>
    <?php } ?>
    <div id="accountCard">
        <ul>
            <li><?= $accountInfos['nickname_account'] ?></li>
            <li><?= $accountInfos['email_account'] ?></li>
        </ul>
    </div>
</div>