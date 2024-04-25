<?php
$title = "Christmas - Ma liste";
// var_dump($_SESSION['role_user']);
?>


<h1>Ma liste de cadeaux</h1>
<?php if (isset($_SESSION['id_account']) && isset($_SESSION['id_user'])) { ?>
    <div id="logoutUserBtn"><button type="submit" name="logOutUser" role="button"><a href="logoutUser"><img src="pictures/BoutonDecoUser.svg" alt="bouton" width=150></a></button></div>
    <section id="listSection">
        <button id="addGift" name="addGift" class="button-paper" role="button"><a href="pageCreateGift">Ajouter un cadeau à ma liste</a></button>
        <table class="list listFromListPage">
            <tr>
                <th>Nom</th>
                <th>Description</th>
                <th>Catégorie</th>
                <th>Modifier</th>
                <th>Supprimer</th>
            </tr>
            <?php if (empty($list)) { ?>
                <tr>
                    <td colspan="5">Tu n'as pas encore de cadeau dans ta liste</td>
                </tr>
                <tr>
                    <td colspan="5"><button type="submit" name="addGift" class="button-paper" role="button"><a href="/christmas/public/pageCreateGift">Ajouter un cadeau</a></button></td>
                </tr>
                <?php } else {
                foreach ($list as $gift) { ?>
                    <tr class="idGift" data-id="<?= $gift['id_gift'] ?>">
                        <td>
                            <div class="gift-name"><?= $gift['name_gift']; ?></div>
                            <input type="text" class="edit-input" name="name_gift" value="<?= $gift['name_gift']; ?>">
                        </td>
                        <td>
                            <div class="gift-description"><?= $gift['description_gift']; ?></div>
                            <input type="text" class="edit-input" name="description_gift" value="<?= $gift['description_gift']; ?>">
                        </td>
                        <td>
                            <div class="gift-category"><?= $gift['name_category']; ?></div>
                            <input type="text" class="edit-input" name="name_category" value="<?= $gift['name_category']; ?>">
                        </td>
                        <td>
                            <i class="fa-regular fa-pen-to-square edit-button"></i>
                        </td>
                        <td><i class="fa-regular fa-trash-can deleteGiftBtn"><a href="deleteGift"></a></i></td>
                    </tr>
                    <input type="hidden" class="edit-input" name="id_category" value="<?= $gift['id_category']; ?>">


            <?php }
            } ?>
        </table>
    </section>
<?php } else if (!isset($_SESSION['id_user'])) {
    header('Location: home');
} else {
    header('Location: signInAccount');
    exit();
} ?>