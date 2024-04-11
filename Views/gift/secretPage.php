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
                            <ul class="giftEntry">
                                <li>nom <?= $gift['name_gift'] ?></li>
                                <li>description <?= $gift['description_gift'] ?></li>
                                <li>category <?= $gift['name_category'] ?></li>
                            </ul>
                            <div><input type='checkbox' name='gift[]' value='<?= $gift['id_gift'] ?>'></div>
                        </div>
                <?php }
                } ?>
                <button class="button-paper" role="button">Ajouter</button>
            </div>
        <?php } ?>
    </div>
<?php } else if (!isset($_SESSION['id_user'])) {
    header('Location: home');
} else {
    header('Location: loginAccount');
    exit();
} ?>