<?php
$title = "Christmas - Accueil";
/* Le $title est situé au niveau du title de la base */
?>

<?php if (isset($error_message)) : ?>
    <div class="error"><?= htmlspecialchars($error_message) ?></div>
<?php elseif (isset($_SESSION['nicknameLogin'])) : ?>
    <h2>Bienvenue à la famille <?= $_SESSION['nicknameLogin']; ?></h2>
<?php else : ?>
    <h1>Accueil</h1>
<?php endif; ?>