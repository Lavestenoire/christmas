<?php
$title = "Fami'list - Page secrète";
?>

<?php if (isset($_SESSION['id_account']) || isset($_SESSION['id_user'])) { ?>


    <h1 id="titreRouge">
        <?= $_SESSION['nickname_user'] ?>, bienvenue sur ta page secrète
    </h1>
    <div id="iconeSecrete">
        <img src="pictures/icones/pageSecrete.svg" alt="icone page secrète" width=100>
    </div>

    <h2 class="sousTitreVert">Choisis les cadeaux dans les listes des lutins de ta famille. Tu les retrouveras en bas de page dans ta liste de cadeaux à offrir.</h2>
    <?php
    $signedInUsersString = implode(' et ', $signedInUserNames);
    if (count($signedInUserNames) === 1) {
        echo "<p class='signedInUserNames'>{$signedInUsersString} est aussi entrain de remplir sa liste !</p>";
    } elseif (count($signedInUserNames) > 1) {
        echo "<p class='signedInUserNames'>{$signedInUsersString} sont aussi entrain de remplir leurs listes !</p>";
    } ?>


    <div id="containerList">
        <?php
        // Initialisation du total de cadeau non réservés toutes listes confondues
        $totalUnreservedCount = 0;
        foreach ($giftList as $nickname => $list) {
            // compte du nombre de cadeaux non réservés dans chaque liste
            $unreservedCount = count($list);
            // initialiser le nombre de cadeaux à 0
            $unreservedCount = 0; ?>
            <form action="reservedGift" method="POST">
                <input type="hidden" name="id_user" value="<?= $_SESSION['id_user'] ?>">
                <div class="listSecretPage">
                    <div class="boxName">La liste de <?= $nickname ?>&nbsp&nbsp&nbsp<img src="pictures/cadeau.svg" alt="icone page secrète" width=50>
                    </div>
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
                                        <li class="reservedGift">Reservé</li>
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
                <!-- afficher le nombre de cadeaux non réservés, avec une opération ternaire pour le pluriel -->
                <p id="giftCount">Il y a <span class="countColor"><?= $unreservedCount ?></span> cadeau<?= $unreservedCount > 1 ? 'x' : '' ?> non réservé<?= $unreservedCount > 1 ? 's' : '' ?> dans la liste</p>
                <button type="submit" class="button-paper lutinBtn secretBtn" role="button">Réserve le cadeau coché</button>
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
                <?php } else {

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
        <p>Toutes listes confondues, il reste <span class="countColor"><?= $totalUnreservedCount ?></span> cadeau<?= $totalUnreservedCount > 1 ? 'x' : '' ?> non réservé<?= $totalUnreservedCount > 1 ? 's' : '' ?></p>
    </div>
<?php } else if (!isset($_SESSION['id_user'])) {
    header('Location: Home');
} else {
    header('Location: signInAccount');
    exit();
} ?>