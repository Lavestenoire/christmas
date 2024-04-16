<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/68ae4d1766.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">

    <title><?= $title ?></title>
</head>

<body>
    <header>
        <nav class="navbar sticky-top navbar-expand-lg bg-body-tertiary container-fluid">

            <a class="navbar-brand" href="/christmas/public/home"> <!-- le lien href de home: home = réecriture d'URL = controller et action donc render -->
                <img src="pictures/logoCalisto.png" alt="Logo" width="100">
            </a>
            <?php if (isset($_SESSION['nickname_account'])) { ?>
                <h3>Famille <?= $_SESSION['nickname_account']; ?></h3>
            <?php } ?>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="container-fluid justify-content-end">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/christmas/public/home">
                                <i class="menuIcon fa-solid fa-house-chimney-window"></i>
                                <span class="menuText">Home</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="pageCreateGift">
                                <i class="menuIcon fa-solid fa-gift menuEntry"></i>
                                <span class="menuText">Ajouter un cadeau</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="giftList">
                                <i class="menuIcon fa-solid fa-list-ul"></i>
                                <span class="menuText">Ma liste</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="secretPage">
                                <i class="menuIcon fa-solid fa-user-secret"></i>
                                <span class="menuText">Page Secrète</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="profileUser">
                                <i class="menuIcon fa-solid fa-user"></i>
                                <span class="menuText">Profil</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="menuIcon fa-solid fa-address-card"></i>
                                <span class="menuText">Contact</span>
                            </a>
                        </li>
                        <?php if (!isset($_SESSION['id_account'])) { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/christmas/public/viewLogin">
                                    <i class="menuIcon fa-solid fa-right-to-bracket"></i>
                                    <span class="menuText">Connexion/inscription</span>
                                </a>
                            </li>
                        <?php } else { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/christmas/public/logoutAccount">
                                    <i class="menuIcon fa-solid fa-right-from-bracket"></i>
                                    <span class="menuText">Se déconnecter</span>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="container">
        <?php if (isset($_SESSION['id_user'])) { ?>
            <div id="helloFamilyContainer">
                <div id="helloFamily">Famille <?= $_SESSION['nickname_account'] ?></div>
            </div>
        <?php } ?>
        <main><?= $content ?></main>
    </div>
    <footer>
        <nav class="footerItem">
            <ul>
                <li><a href="home">Accueil</a></li>
                <li><a href="pageCreateGift">Ajouter un cadeau</a></li>
                <li><a href="giftList">Ma liste</a></li>
                <li><a href="secretPage">Page Secrète</a></li>
                <li><a href="profileUser">Profil</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </nav>
        <div class="footerItem copyright">Calisto © 2024 | Tous droits réservés</div>
        <div class="footerItem"><img src="pictures/titreCalisto.png" alt="Logo" width="150"></div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="/christmas/public/script.js"></script>
</body>

</html>