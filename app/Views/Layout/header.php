<header class="sticky-top  bg-primary">
    <div class="container-fluid">
        <nav class="navbar navbar-expand-sm navbar-dark">
            <a class="navbar-brand" href="/">My MVC App</a>
            <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation"></button>
            <div class="collapse navbar-collapse" id="collapsibleNavId">
                <ul class="navbar-nav me-auto mt-2 mt-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Articles</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <?php if (!empty($_SESSION['user'])) : ?>
                        <li class="nav-item">
                            <a href="/logout" class="btn btn-danger">Déconnexion</a>
                        </li>
                    <?php else : ?>
                        <li class="nav-item">
                            <a href="/login" class="btn btn-outline-light">Connexion</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </div>

</header>