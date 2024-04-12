<?php
$title = "Christmas - Profil";
?>


<?php
if (isset($_SESSION['id_account']) && isset($_SESSION['id_user'])) { ?>
    <h1>page profil de <?= $_SESSION['nickname_user'] ?></h1>
    <img src="<?= $userProfile['picture_user'] ?>" alt="avatar">
    <div><?= $userProfile['nickname_user'] ?></div>
    <form action="deleteUser">
        <button type="submit" name="deleteUser" class="button-paper" role="button">Clique ici pour supprimer ton profil</button>
    </form>
<?php } else if (!isset($_SESSION['id_user'])) {
    header('Location: loginUser');
} else {
    header('Location: loginAccount');
    exit();
} ?>