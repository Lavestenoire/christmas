<?php
$title = "Fami'list - Ma liste";
// var_dump($_SESSION['role_user']);
?>


<h1 id="titreRouge">Ma liste de cadeaux</h1>
<?php if (isset($_SESSION['id_account']) || isset($_SESSION['id_user'])) { ?>
    <section id="listSection">
        <div class="divBtn">
            <a href="pageCreateGift"><button id="addGift" name="addGift" class="button-paper lutinBtn" role="button">Ajouter un cadeau à ma liste</button></a>
        </div>
        <table class="list listFromListPage">
            <tr id="trTitle">
                <th>Nom</th>
                <th>Description</th>
                <th>Catégorie</th>
                <th id="iconeEditGift">Modifier</th>
                <th id="iconeDeleteGift">Supprimer</th>
            </tr>
            <?php if (empty($list)) { ?>
                <tr>
                    <td colspan="5">Tu n'as pas encore de cadeau dans ta liste</td>
                </tr>
                <?php } else {
                foreach ($list as $gift) { ?>
                    <tr class="idGift" data-id_gift="<?= $gift['id_gift'] ?>" data-id_category="<?= $gift['id_category']; ?>">
                        <td class="name_giftDataTable">
                            <div class="gift-name"><?= $gift['name_gift']; ?></div>
                            <input type="text" class="edit-input" name="name_gift" value="<?= $gift['name_gift']; ?>">
                        </td>
                        <td class="descriptionDataTable">
                            <div class="gift-description"><?= $gift['description_gift']; ?></div>
                            <input type="text" class="edit-input" name="description_gift" value="<?= $gift['description_gift']; ?>">
                        </td>
                        <td class="name_categoryDataTable">
                            <div class="gift-category"><?= $gift['name_category']; ?></div>
                            <input type="text" class="edit-input" name="name_category" value="<?= $gift['name_category']; ?>">
                        </td>

                        <td>
                            <i class="fa-regular fa-pen-to-square edit-button"></i>
                        </td>
                        <td>
                            <i class="fa-regular fa-trash-can deleteGiftBtn"></i>
                        </td>
                    </tr>
            <?php }
            } ?>
        </table>
    </section>
<?php } else if (!isset($_SESSION['id_user'])) {
    header('Location: Home');
} else {
    header('Location: signInAccount');
    exit();
} ?>