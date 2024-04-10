<?php
$title = "Christmas - Créer un cadeau";
// echo '<pre>';
// var_dump($_SESSION);
// echo '</pre>';
?>
<?php
if (isset($_GET['message']) && $_GET['message'] == 'gift_added') {
    echo '<p>Le cadeau a été ajouté avec succès !</p>';
}
?>
<?php if (isset($_SESSION['id_account']) && isset($_SESSION['id_user'])) { ?>
    <h1>Page de <?= $_SESSION['nickname_user']; ?></h1>
    <div id="giftPage">
        <section class="sectionGift">
            <h2>Créer un cadeau</h2>
            <form class="mx-auto w-80" action="createGift" method="POST">
                <div class="mb-3 col-4">
                    <label for="name_gift" class="form-label">Nom</label>
                    <input type="text" name="name_gift" class="form-control" id="name_gift" aria-describedby="usernameHelp" required>
                </div>
                <div class="mb-3 col-4">
                    <label for="description_gift" class="form-label">Description</label>
                    <input type="text" name="description_gift" class="form-control" id="description_gift" aria-describedby="usernameHelp" required>
                </div>
                <div class="mb-3 col-4">
                    <label for="category_gift" class="form-label">Catégorie</label>
                    <input type="text" name="category_gift" class="form-control" id="category_gift" aria-describedby="usernameHelp" required>
                </div>
                <!-- champs caché à 0 pour non réservé-->
                <input type="hidden" name="reserved_gift" value="0">

                <button type="submit" name="addGift" class="button-paper" role="button">Ajouter ce cadeau à ma liste</button>

            </form>
        </section>
        <section class="sectionGift">
            <h2>Afficher la liste</h2>
        </section>
    </div>
<?php } else if (!isset($_SESSION['id_user'])) {
    header('Location: pageLoginUser');
} else {
    header('Location: loginAccount');
    exit();
} ?>