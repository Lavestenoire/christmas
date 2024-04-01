<?php
$title = "Christmas - Accueil";
/* Le $title est situé au niveau du title de la base */
?>

<?php
if (isset($_SESSION['idAccount'])) {
    var_dump($_SESSION['idAccount']);
    if ($showForm) { ?>
        <!-- Si status_user == admin non présent: -->
        <h2>Bienvenue à la famille <?= $_SESSION['nicknameLogin']; ?></h2>
        <p>Merci de créer le premier profil de ce compte, qui vous permettra de modifier et supprimer votre compte familial, et d'avoir accès aux profils des membres de votre famille.</p>

        <form class="mx-auto w-80" action="#" method="POST">
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

            <button type="submit" name="addAccount" class="btn btn-primary">Valider</button>
        </form>
    <?php } else if ($showProfiles) { ?>
        <h2>Bienvenue à la famille <?= $_SESSION['nicknameLogin']; ?></h2>
        <div class="card" style="width: 18rem;">
            <img src="..." class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
        </div>
    <?php }
} else { ?>
    <h1>Accueil</h1>
<?php } ?>