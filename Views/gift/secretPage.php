<?php
$title = "Christmas - Page secrète";
?>

<h1>Ma page secrète</h1>

<?php if (isset($_SESSION['id_account']) && isset($_SESSION['id_user'])) { ?>
    <p>affichage des listes</p>
    <p>récup des listes de chaque utilisateur WHERE status_user == 0</p>
<?php } else {
    header('Location: loginAccount');
    exit();
} ?>