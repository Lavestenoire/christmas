<?php
$title = "Christmas - Ma liste";
// echo $_SESSION['id_user'];
// var_dump($list);
?>

<h1>Ma liste de cadeaux</h1>
<?php if (isset($_SESSION['id_account']) && isset($_SESSION['id_user'])) { ?>
    <div class="list">
        <?php if (empty($list)) { ?>
            <p>Tu n'as pas encore de cadeau dans ta liste</p>
            <button type="submit" name="addGift" class="button-paper" role="button"><a href="/christmas/public/pageCreateGift">Ajouter un cadeau</a></button>
            <?php } else {
            foreach ($list as $gift) { ?>
                <ul id='giftList'>
                    <li><?= $gift['name_gift']; ?></li>
                    <li><?= $gift['description_gift']; ?></li>
                    <li><?= $gift['name_category']; ?></li>
                    <li><i class="fa-regular fa-pen-to-square"><a href="#"></a></i></li>
                    <li><i class="fa-regular fa-trash-can"></i><a href="#"></a></i></li>
                </ul>
                <div class="candy"><i class="fa-solid fa-candy-cane"></i></div>
        <?php }
        } ?>
    </div>
    <button name="addGift" class="button-paper" role="button"><a href="pageCreateGift">Ajouter un cadeau à ma liste</a></button>

<?php } else if (!isset($_SESSION['id_user'])) {
    header('Location: home');
} else {
    header('Location: loginAccount');
    exit();
} ?>