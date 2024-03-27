<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($meta['title']) ? $meta['title'] : null ?> | My MVC App</title>
    <?php foreach (isset($meta['css']) ? $meta['css'] : [] as $src) : ?>
        <link rel="stylesheet" href="<?= $src; ?>">
    <?php endforeach; ?>
    <?php foreach (isset($meta['js']) ? $meta['js'] : [] as $src) : ?>
        <script src="<?= $src; ?>" defer></script>
    <?php endforeach; ?>
</head>

<body>

    <main>
        <?= $content; ?>
    </main>

</body>

</html>