<?php
$title = "Christmas - Page secrète";
// var_dump($giftList);
?>

<?php if (isset($_SESSION['id_account']) && isset($_SESSION['id_user'])) { ?>
    <div id="logoutUserBtn"><button type="submit" name="logOutAUser" role="button"><a href="logoutUser"><img src="pictures/BoutonDecoUser.svg" alt="bouton" width=150></a></button></div>

    <h1>
        <?= $_SESSION['nickname_user'] ?>, bienvenue sur ta page secrète
    </h1>
    <p>Tu peux ici sélectionner des cadeaux dans les listes des membres de ta famille et les ajouter dans ta liste de cadeaux à offrir.</p>
    <!-- listes des users avec un status == 0 (non connecté) -->
    <div id="containerList">
        <?php
        // Initialisation du total
        $totalUnreservedCount = 0;

        foreach ($giftList as $nickname => $list) {
            // compte le nombre de cadeaux
            $unreservedCount = count($list);
            // initialiser le nombre de cadeaux à 0
            $unreservedCount = 0; ?>
            <form action="reservedGift" method="POST">
                <input type="hidden" name="id_user" value="<?= $_SESSION['id_user'] ?>">
                <div class="listSecretPage">
                    <div class="boxName"><?= $nickname ?></div>
                    <?php if (empty($list)) { ?>
                        <p><?= $nickname ?> n'a pas encore ajouté de cadeau à sa liste</p>
                        <?php } else {
                        foreach ($list as $gift) {
                        ?>
                            <div class="liAndInputList">
                                <ul class="giftList">
                                    <li><?= $gift['name_gift'] ?></li>
                                    <li><?= $gift['description_gift'] ?></li>
                                    <li><?= $gift['name_category'] ?></li>
                                    <?php if ($gift['reserved_gift'] == 1) { ?>
                                        <li>Reservé</li>
                                    <?php } else if ($gift['reserved_gift'] == 0) {
                                        // pour tous les cadeaux non réservés, incrémenter le nombre initialisé plus haut à 0
                                        $unreservedCount++;
                                    ?>
                                        <li><input type='checkbox' name='gift[]' value='<?= $gift['id_gift'] ?>'></li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <hr>
                    <?php }
                        $totalUnreservedCount += $unreservedCount;
                    }

                    ?>
                </div>
                <!-- afficher le nombre de cadeaux non réservés, avec une opération ternaire por le pluriel -->
                <p><?= $unreservedCount ?> cadeau<?= $unreservedCount > 1 ? 'x' : '' ?> non réservé<?= $unreservedCount > 1 ? 's' : '' ?> dans la liste</p>
                <button type="submit" class="button-paper" role="button">Ajouter</button>
            </form>
        <?php
        } ?>
    </div>


    <!-- liste des cadeaux réservés à 1 par id_user -->
    <div id="containerListToOffer">
        <div class="list">
            <div class="boxName">Pour offrir</div>
            <?php if (empty($listToOffer)) { ?>
                <p>Tu n'as pas encore ajouté de cadeaux à offrir</p>
                <?php } else if (!empty($listToOffer)) {

                foreach ($listToOffer as $giftToOffer) { ?>
                    <div class="liAndInputList">
                        <ul class="giftList">
                            <li><?= $giftToOffer['name_gift'] ?></li>
                            <li><?= $giftToOffer['description_gift'] ?></li>
                            <li><?= $giftToOffer['name_category'] ?></li>
                            <li><?= $giftToOffer['nickname_user'] ?></li>
                            <li>
                                <form action="deleteGiftToOffer" method="POST">
                                    <input type="hidden" name="id_gift" value="<?= $giftToOffer['id_gift'] ?>">
                                    <button type="submit" class="update-button"><i class="fa-solid fa-minus"></i></button>
                                </form>
                            </li>
                        </ul>
                    </div>
            <?php }
            } ?>
        </div>
        <p>Total de <?= $totalUnreservedCount ?> cadeau<?= $totalUnreservedCount > 1 ? 'x' : '' ?> non réservé<?= $totalUnreservedCount > 1 ? 's' : '' ?></p>
    </div>
<?php } else if (!isset($_SESSION['id_user'])) {
    header('Location: home');
} else {
    header('Location: loginAccount');
    exit();
} ?>