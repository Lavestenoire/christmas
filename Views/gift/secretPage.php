<?php
$title = "Christmas - Page secrète";
// echo '<pre>';
// var_dump($giftLists);
// echo '</pre>';
?>

<?php if (isset($_SESSION['id_account']) && isset($_SESSION['id_user'])) { ?>
    <h1>
        <?= $_SESSION['nickname_user'] ?>, bienvenue sur ta page secrète
    </h1>
    <p>Tu peux ici sélectionner des cadeaux dans les listes des membres de ta famille et les ajouter dans ta liste de cadeaux à offrir.</p>
    <!-- listes des users avec un status == 0 (non connecté) -->
    <div id="containerList">
        <?php foreach ($giftLists as $nickname => $giftList) { ?>
            <div class="list">
                <div class="boxName"><?= $nickname ?></div>
                <?php if (empty($giftList)) { ?>
                    <p><?= $nickname ?> n'a pas encore ajouté de cadeau à sa liste</p>
                    <?php } else {
                    foreach ($giftList as $gift) { ?>
                        <div class="liAndInputList">
                            <ul class="giftList">
                                <li><?= $gift['name_gift'] ?></li>
                                <li><?= $gift['description_gift'] ?></li>
                                <li><?= $gift['name_category'] ?></li>
                            </ul>
                            <div><input type='checkbox' name='gift[]' value='<?= $gift['id_gift'] ?>'></div>
                        </div>
                        <hr>
                <?php }
                } ?>
                <button class="button-paper" role="button">Ajouter</button>
            </div>
        <?php } ?>
    </div>
    <!-- liste des cadeaux réservés à 1 par id_user -->
    <div id="containerList">
        <div class="list">
            <div class="boxName">Pour offrir</div>
            <p>Pas de cadeau ajouté à la liste</p>
            <div class="liAndInputList">
                <ul class="giftList">
                    <li>nom</li>
                    <li>description</li>
                    <li>category</li>
                </ul>
                <div><i class="fa-solid fa-minus"></i></div>
            </div>
        </div>
    </div>
<?php } else if (!isset($_SESSION['id_user'])) {
    header('Location: home');
} else {
    header('Location: loginAccount');
    exit();
} ?>