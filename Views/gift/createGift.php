<?php
$title = "Fami'list - Créer un cadeau";
// echo '<pre>';
// var_dump($_SESSION);
// echo '</pre>';
?>
<?php
if (isset($_GET['message']) && $_GET['message'] == 'gift_added') {
    echo '<p>Le cadeau a été ajouté avec succès !</p>';
}
?>
<?php if (isset($_SESSION['id_account']) || isset($_SESSION['id_user'])) { ?>
    <div id="giftPage">
        <section class="sectionGift">
            <h1 id="titreAccueilConnexion">Ajouter un cadeau</h1>
            <div class="accountForm">
                <form class="mx-auto w-80" action="createGift" method="POST">
                    <div class="mb-3 col-lg-12 col-12">
                        <label for="name_gift" class="form-label">Nom du cadeau</label>
                        <input type="text" name="name_gift" class="form-control" id="name_gift" aria-describedby="usernameHelp" required>
                    </div>
                    <div class="mb-3 col-lg-12 col-12">
                        <label for="description_gift" class="form-label">Description</label>
                        <input type="text" name="description_gift" class="form-control" id="description_gift" aria-describedby="usernameHelp">
                    </div>
                    <div class="mb-3 col-lg-12 col-12">
                        <label for="category_gift" class="form-label">Lien</label>
                        <input type="url" name="category_gift" class="form-control" id="category_gift" aria-describedby="usernameHelp" onkeyup="showHint(this.value)">
                    </div>
                    <div id="suggestions"></div>
                    <!-- champs caché à 0 pour non réservé -->
                    <input type="hidden" name="reserved_gift" value="0">

                    <button type="submit" name="addGift" class="button-paper lutinBtn" role="button">Ajouter ce cadeau à ma liste</button>
                    <p>Accéder à <a href="giftList">ma liste</a></p>
                </form>
                <div><img src="pictures/cadeauListe.svg" alt="dessinLutin"></div>
            </div>

        </section>
    </div>
<?php } else if (!isset($_SESSION['id_user'])) {
    header('Location: home');
} else {
    header('Location: signInAccount');
    exit();
} ?>