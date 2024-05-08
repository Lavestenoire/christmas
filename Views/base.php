<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/68ae4d1766.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="pictures/faviconFamilistTransparent.png" />
    <meta name="description" content="<?php echo $description; ?>">

    <title><?= $title ?></title>
</head>

<body>
    <header>
        <nav class="navbar sticky-top navbar-expand-lg bg-body-tertiary container-fluid">
            <div class="container-fluid">
                <a class="navbar-brand" href="home"> <!-- le lien href de home: home = réecriture d'URL = controller et action donc render -->
                    <img src="pictures/logo.svg" alt="Logo">
                </a>
                <?php if (isset($_SESSION['tag_account'])) { ?>
                    <span class="navbar-brand mb-0 h1 familyName">Lutin administateur</span>
                <?php } else if (isset($_SESSION['nickname_user'])) { ?>
                    <span class="navbar-brand mb-0 h1 familyName">Lutin <?= $_SESSION['nickname_user'] ?></span>

                <?php } ?>
                <button class="navbar-toggler justify-content-end" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse w-100" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <?php if (isset($_SESSION['id_user'])) { ?>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="home">
                                    <img src="pictures/icones/home.svg" alt="icone home" width=50>
                                    <span class="menuText">Home</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="pageCreateGift">
                                    <img src="pictures/icones/cadeau.svg" alt="icone cadeau" width=50>
                                    <span class="menuText">Ajouter un cadeau</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="giftList">
                                    <img src="pictures/icones/liste.svg" alt="icone liste" width=50>
                                    <span class="menuText">Ma liste</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="secretPage">
                                    <img src="pictures/icones/pageSecrete.svg" alt="icone page secrète" width=50>
                                    <span class="menuText">Page Secrète</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="profileUser">
                                    <img src="pictures/icones/profil.svg" alt="icone profil" width=50>
                                    <span class="menuText">Profil</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/christmas/public/logOutUser">
                                    <img src="pictures/icones/deconnexion.svg" alt="icone deconnexion" width=50>
                                    <span class="menuText">Déconnexion</span>
                                </a>
                            </li>
                        <?php } else if (isset($_SESSION['id_account'])) { ?>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="home">
                                    <img src="pictures/icones/home.svg" alt="icone home" width=50>
                                    <span class="menuText">Home</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="profileAccount">
                                    <img src="pictures/icones/profil.svg" alt="icone profil" width=50>
                                    <span class="menuText">Profil</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/christmas/public/logOutAccount">
                                    <img src="pictures/icones/deconnexion.svg" alt="icone deconnexion" width=50>
                                    <span class="menuText">Déconnexion</span>
                                </a>
                            </li>
                        <?php } else { ?>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="home">
                                    <img src="pictures/icones/home.svg" alt="icone home" width=50>
                                    <span class="menuText">Home</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#connexionAnchor">
                                    <img src="pictures/icones/cadeau.svg" alt="icone cadeau" width=50>
                                    <span class="menuText">Ajouter un cadeau</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#connexionAnchor">
                                    <img src="pictures/icones/liste.svg" alt="icone liste" width=50>
                                    <span class="menuText">Ma liste</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#connexionAnchor">
                                    <img src="pictures/icones/pageSecrete.svg" alt="icone page secrète" width=50>
                                    <span class="menuText">Page Secrète</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#connexionAnchor">
                                    <img src="pictures/icones/profil.svg" alt="icone profil" width=50>
                                    <span class="menuText">Profil</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <img src="pictures/icones/contact.svg" alt="icone contact" width=50>
                                    <span class="menuText">Contact</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#connexionAnchor">
                                    <img src="pictures/icones/connexion.svg" alt="icone connexion" width=50>
                                    <span class="menuText">Connexion</span>
                                </a>
                            </li>
                        <?php } ?>

                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="container">
        <main><?= $content ?></main>
        <img src="pictures/imgFooter.svg" alt="" id="footerImage">
    </div>


    <footer>
        <div class="footerItem copyright">Fami'list © 2024 | Tous droits réservés</div>
        <div id="mentionsLegales">
            <div><a href="cgu">Conditions générales d'utilisation</a></div>
            <div><a href="pdc">Politique de confidentialité</a></div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="/christmas/public/script.js"></script>
</body>

</html>