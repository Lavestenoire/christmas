<?php
$title = "Christmas - Ma liste";
// echo $_SESSION['id_user'];
// var_dump($list);
?>

<h1>Ma liste de cadeaux</h1>
<?php if (isset($_SESSION['id_account']) && isset($_SESSION['id_user'])) { ?>
    <div id="logoutUserBtn"><button type="submit" name="addAUser" role="button"><a href="logoutUser"></a><img src="pictures/BoutonDecoUser.svg" alt="bouton" width=150></button></div>
    <button name="addGift" class="button-paper" role="button"><a href="pageCreateGift">Ajouter un cadeau à ma liste</a></button>
    <div class="list">
        <?php if (empty($list)) { ?>
            <p>Tu n'as pas encore de cadeau dans ta liste</p>
            <button type="submit" name="addGift" class="button-paper" role="button"><a href="/christmas/public/pageCreateGift">Ajouter un cadeau</a></button>
            <?php } else {
            foreach ($list as $gift) { ?>
                <ul class='giftList'>
                    <ul class='giftList'>
                        <li><span title="<?= $gift['description_gift'] . ' - ' . $gift['name_category']; ?>"><?= $gift['name_gift']; ?></span></li>
                        <li><i class="fa-regular fa-pen-to-square"><a href="#"></a></i></li>
                        <li><i class="fa-regular fa-trash-can"></i><a href="#"></a></i></li>
                    </ul>
                </ul>
                <hr>
        <?php }
        } ?>
    </div>

<?php } else if (!isset($_SESSION['id_user'])) {
    header('Location: home');
} else {
    header('Location: loginAccount');
    exit();
} ?>