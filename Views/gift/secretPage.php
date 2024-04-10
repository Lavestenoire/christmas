<?php
$title = "Christmas - Page secrète";
// echo '<pre>';
// var_dump($giftLists);
// echo '</pre>';
?>

<h1>Ma page secrète</h1>
<?php if (isset($_SESSION['id_account']) && isset($_SESSION['id_user'])) { ?>
    <!-- listes des users avec un status == 0 (non connecté) -->
    <div id="containerList">
        <?php foreach ($giftLists as $nickname => $giftList) { ?>
            <div class="list">
                <h3 class="listTitle">Liste de <?= $nickname ?></h3>
                <?php foreach ($giftList as $gift) { ?>
                    <div class="liAndInputList">
                        <ul class="giftEntry">
                            <li>nom <?= $gift['name_gift'] ?></li>
                            <li>description <?= $gift['description_gift'] ?></li>
                            <li>category <?= $gift['name_category'] ?></li>

                        </ul>
                        <div><input type='checkbox' name='gift[]' value='<?php $gift['id_gift'] ?>'></div>
                    </div>
                <?php } ?>
                <button class="button-paper" role="button">Ajouter</button>
            </div>
        <?php } ?>
    </div>

<?php } else {
    header('Location: loginAccount');
    exit();
} ?>