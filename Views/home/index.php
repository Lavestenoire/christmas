<?php
$title = "Fami'list - Accueil";
// var_dump($_SESSION);
?>

<?php
if (isset($_SESSION['id_user'])) { ?>
    <!-- // s'il n'y a pas de profil créé -->

    <h1 id="titreAccueilConnexion">Bienvenue à toi, petit lutin <?= isset($_SESSION['nickname_account']) ? $_SESSION['nickname_account'] : (isset($_SESSION['nickname_user']) ? $_SESSION['nickname_user'] : '') ?></h1>
    <h2 class="sousTitreAccueilConnexion">Crée et partage ta liste, puis choisis dans les listes de ta famille les cadeaux que tu veux offrir, via la page secrète.</h2>
    <div id="btnAccueil">
        <button type="button" name="connectionAccount" class="button-paper lutinBtn" role="button"><a href="pageCreateGift">Ajoute un cadeau à ta liste</a></button>
        <button type="button" name="connectionAccount" class="button-paper lutinBtn" role="button"><a href="secretPage">Page secrète</a></button>
    </div>
<?php }
//sinon affichage des profils existant 
else if (isset($_SESSION['id_account'])) { ?>
    <h1 id="titreAccueilConnexion">Accède à ta page profil pour supprimer des utilisateurs</h1>
    <button type="submit" name="addGift" class="button-paper lutinBtn" role="button"><a href="profileUser">Profil</a></button>
<?php } else { ?>
    <h1 id="titreAccueilConnexion">Bienvenue dans le quartier général du Père Noël pour créer une liste de cadeaux unique et personnalisée ! </h1>
    <h2 class="sousTitreAccueilConnexion">Que vous soyez un parent en quête de l'ultime cadeau surprise ou un enfant déterminé à garantir que votre liste au père Noël ne se perde pas dans la neige, vous êtes au bon endroit.</h2>
    <div id="explanations">
        <div class="imgExplanation"><img src="pictures/9.svg" alt="logo explication" width=200></div>
        <div class="imgExplanation"><img src="pictures/10.svg" alt="logo explication" width=200></div>
        <div class="imgExplanation"><img src="pictures/11.svg" alt="logo explication" width=200></div>
        <div class="imgExplanation"><img src="pictures/12.svg" alt="logo explication" width=200></div>
    </div>
    <div id="connexionAnchor"></div>
    <p id="linkCreerCompte">Si vous n'avez pas encore de compte, <a href="signUpPage">cliquez ici</a></p>
    <div id="btnAccueil">
        <button type="button" name="" class="button-paper lutinBtn" role="button"><a href="/christmas/public/signInAccount">Lutin administrateur, identifiez-vous</a></button>
        <button type="button" name="" class="button-paper lutinBtn" role="button"><a href="/christmas/public/signInUser">Lutin, identifiez-vous</a></button>
    </div>
    <h2 class="sousTitreAccueilConnexion">Ce site vous permet de créer, partager et collaborer sur vos listes de souhaits. Pensez-y comme un tableau de bord de rêves pour Noël. Allez hop, plongez avec nous dans le joyeux chaos de la saison des fêtes!</h2>


<?php } ?>