<section class="container mt-2">
    <h1 class="text-center">Administration des articles</h1>
    <div class="table-responsive rounded">
        <table class="table table-light table-borderless">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Title</th>
                    <th scope="col">Content</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($articles as $article) : ?>
                    <tr>
                        <td scope="row"><?= $article->getId(); ?></td>
                        <td><?= $article->getTitle(); ?></td>
                        <td><?= $article->getContent(); ?></td>
                        <td>
                            <div class="d-flex gap-4 flex-wrap align-items-center justify-content-center">
                                <a href="/admin/articles/<?= $article->getId(); ?>/edit" class="btn btn-warning">Modifier</a>
                                <form action="/admin/articles/delete" method="post" onsubmit="return confirm('Êtes-vous sùr de vouloir supprimer cet utilisateur ?')">
                                    <input type="hidden" name="id" value="<?= $article->getId(); ?>">
                                    <input type="hidden" name="token" value="<?= $_SESSION['token']; ?>">
                                    <button class="btn btn-danger">Supprimer</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>