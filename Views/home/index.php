<?php
$description = "Accédez à vos listes de cadeaux et sélectionnez des cadeaux à offrir";
$title = "Fami'list - Accueil";
// var_dump($_SESSION);
?>

<?php
if (isset($_SESSION['id_user'])) { ?>
    <!-- // s'il n'y a pas de profil créé -->

    <h1 id="titreRouge">Bienvenue à toi, petit lutin <?= isset($_SESSION['nickname_account']) ? $_SESSION['nickname_account'] : (isset($_SESSION['nickname_user']) ? $_SESSION['nickname_user'] : '') ?></h1>
    <h2 class="sousTitreVert">Créé et partage ta liste, puis choisis dans les listes de ta famille les cadeaux que tu veux offrir, via la page secrète.</h2>
    <div id="btnAccueil">
        <a href="pageCreateGift"><button type="button" name="connectionAccount" class="button-paper lutinBtn" role="button">Ajoute un cadeau à ta liste</button></a>
        <a href="secretPage"><button type="button" name="connectionAccount" class="button-paper lutinBtn" role="button">Page secrète</button></a>
    </div>
<?php }
//sinon affichage des profils existant 
else if (isset($_SESSION['id_account'])) { ?>
    <h1 id="titreRouge">Accède à ta page profil pour supprimer des utilisateurs</h1>
    <h2 class="sousTitreVert">Tu peux aussi modifier ou supprimer ce compte.<br> Pour créer ta liste de cadeaux, inscrit toi en tant que lutin.</h2>

    <div class="profilBtn">
        <a href="profileAccount"><button type="button" name="addGift" class="button-paper lutinBtn" role="button">Profil</button></a>
    </div>
<?php } else { ?>
    <h1 id="titreRouge">Bienvenue dans le quartier général du Père Noël pour créer une liste de cadeaux unique et personnalisée ! </h1>
    <h2 class="sousTitreVert">Que vous soyez un parent en quête de l'ultime cadeau surprise ou un enfant déterminé à garantir que votre liste au père Noël ne se perde pas dans la neige, vous êtes au bon endroit.</h2>
    <div id="explanations">
        <div class="imgExplanation"><img src="pictures/9.svg" alt="logo explication" width=200></div>
        <div class="imgExplanation"><img src="pictures/10.svg" alt="logo explication" width=200></div>
        <div class="imgExplanation"><img src="pictures/11.svg" alt="logo explication" width=200></div>
        <div class="imgExplanation"><img src="pictures/12.svg" alt="logo explication" width=200></div>
    </div>
    <div id="connexionAnchor"></div>
    <p id="linkCreerCompte">Si vous n'avez pas encore de compte, <a href="signUpPage">cliquez ici</a></p>
    <div id="btnAccueil">
        <a href="/christmas/public/signInAccount"><button type="button" name="" class="button-paper lutinBtn" role="button">Lutin administrateur, identifiez-vous</button></a>
        <a href="/christmas/public/signInUser"><button type="button" name="" class="button-paper lutinBtn" role="button">Lutin, identifiez-vous</button></a>
    </div>
    <h2 class="sousTitreVert">Ce site vous permet de créer, partager et collaborer sur vos listes de souhaits. Pensez-y comme un tableau de bord de rêves pour Noël. Allez hop, plongez avec nous dans le joyeux chaos de la saison des fêtes!</h2>


<?php } ?>