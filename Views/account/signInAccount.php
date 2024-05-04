<?php
$title = "Fami'list - SignIn";
?>

<section id="connexionInscription">
    <div id="signInAccount">
        <h1 id="titreRouge">Lutin administrateur, connecte toi</h1>
        <h2 class="sousTitreVert">En tant qu'administrateur, tu pourras gérer les profils des lutins de ta famille. <br> Pour créer ta liste de cadeaux, inscrit toi en tant que lutin.</h2>
        <div class="accountForm">
            <form class="mx-auto w-80 adminForm" action="signInAccount" method="POST">
                <div class="mb-3 col-lg-4 col-10">
                    <label for="nickname_account" class="form-label">Pseudo</label>
                    <input type="text" name="nickname_account" class="form-control" aria-describedby="usernameHelp" required>
                </div>
                <div class="mb-3 col-lg-4 col-10 mdp">
                    <div class="eye"><i class="fa-regular fa-eye"></i></div>
                    <label for="loginPassword" class="form-label">Mot de passe</label>
                    <input type="password" name="loginPassword" class="form-control loginPassword" required>
                </div>
                <button type="submit" name="connectionAccount" class="button-paper lutinBtn" role="button">Connexion</button>

                <?php
                if (isset($_SESSION['error_message'])) : ?>
                    <span class="text-danger"><?= ($_SESSION['error_message']) ?></span>
                <?php endif;
                unset($_SESSION['error_message']);
                ?>
            </form>
            <div><img src="pictures/lutinAdmin.svg" alt="dessinLutin"></div>
        </div>
    </div>
</section>