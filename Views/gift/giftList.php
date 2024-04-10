<?php
$title = "Christmas - Ma liste";
// echo $_SESSION['id_user'];
// var_dump($list);
?>

<h1>Ma liste de cadeaux</h1>
<?php if (isset($_SESSION['id_account']) && isset($_SESSION['id_user'])) {
    foreach ($list as $gift) { ?>
        <div id='giftList'>
            <p><?= $gift['name_gift']; ?></p>
            <p><?= $gift['description_gift']; ?></p>
            <p><?= $gift['name_category']; ?></p>
        </div>
<?php }
} else {
    header('Location: loginAccount');
    exit();
} ?>