<section class="container mt-2">
    <h1 class="text-center"><?= $article->getTitle(); ?></h1>
    <div class="card">
        <div class="card-body">
            <p class="card-text"><?= $article->getContent(); ?></p>
        </div>
    </div>
</section>