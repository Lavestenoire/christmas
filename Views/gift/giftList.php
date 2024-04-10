<?php
$title = "Christmas - Ma liste";
// echo $_SESSION['id_user'];
// var_dump($list);
?>

<h1>Ma liste de cadeaux</h1>
<?php if (isset($_SESSION['id_account']) && isset($_SESSION['id_user'])) { ?>
    <div class="list">
        <?php foreach ($list as $gift) { ?>
            <ul id='giftList'>
                <li><?= $gift['name_gift']; ?></li>
                <li><?= $gift['description_gift']; ?></li>
                <li><?= $gift['name_category']; ?></li>
            </ul>
            <div class="candy"><i class="fa-solid fa-candy-cane"></i></div>
        <?php } ?>
    </div>
<?php } else {
    header('Location: loginAccount');
    exit();
} ?>