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
        <nav class="navbar sticky-top navbar-expand-lg bg-body-tertiary">
            <a class="navbar-brand" href="/christmas/public/home"> <!-- le lien href de home: home = réecriture d'URL = controller et action donc render -->
                <img src="pictures/logoChristmas1.png" alt="Logo" width="100"> <!-- Remplacez "logo.png" par le chemin de votre logo -->
            </a>
            <div class="container-fluid justify-content-end">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/christmas/public/home">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Créer un cadeau</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Ma liste</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Page Secrète</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contact</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/christmas/public/viewLogin">
                                <img src="pictures/gnome1.jpg" alt="icone gnome" width="100">
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/christmas/public/logoutAccount">
                                <i class="fa-solid fa-right-from-bracket"></i> </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="container">
        <main><?= $content ?></main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="/christmas/public/script.js"></script>
</body>

</html>