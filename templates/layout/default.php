<!DOCTYPE html>
<html lang="ja">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $this->fetch('title') ?>
    </title>

    <?= $this->Html->css(['normalize.min', 'milligram.min', 'fonts', 'cake', 'style']) ?>
    <?= $this->Html->css('https://use.fontawesome.com/releases/v6.2.0/css/all.css');?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
</head>
<body>
    <main class="main">
        <div class="container">
            <?= $this->fetch('content') ?>
        </div>
        <?= $this->fetch('script') ?>
    </main>
    <footer>
    </footer>
</body>
</html>
